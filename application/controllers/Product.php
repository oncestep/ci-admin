<?php

/**
 * Created by PhpStorm.
 * Admin: 15185
 * Date: 2017/8/7
 * Time: 13:59
 */
class Product extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        if (!$_SESSION['logged_in']) {
            redirect('admin/login');
        }
    }

    public function create($up_id = 0)
    {
        $result_fir = $this->product_model->get_children(0);
        if($result_fir){
            $row_fir = $result_fir[0];
            $result_sec = $this->product_model->get_children($row_fir['category_id']);
            $row_sec = $result_sec[0];
            $result_thi = $this->product_model->get_children($row_sec['category_id']);
            $row_thi = $result_thi[0];
            $default = array('default_fir' => $row_fir['category_id'], 'default_sec' => $row_sec['category_id'], 'default_thi' => $row_thi['category_id']);
        } else {
            $default = NULL;
        }

        $data['default'] = $default;

        $result = $this->product_model->get_children($up_id);
        $data['rows'] = $result;
        $this->load->view('pages/product_create', $data);
    }

    public function manage($offset = 0)
    {
        //Pagination Config
        $config['base_url'] = site_url('product/manage');
        $config['total_rows'] = $this->product_model->get_each();
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;

        $config['first_link'] = '首页';
        $config['last_link'] = '尾页';
        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';
        $config['full_tag_open'] = '<div class="turnPage center fr page_converse">';
        $config['full_tag_close'] = '</div>';
        $config['cur_tag_open'] = ' <a class="limit_tag">';
        $config['cur_tag_close'] = '</a>';
//        $config['prev_tag_open'] = '<a class="limit_tag">';
//        $config['prev_tag_close'] = '</a>';
//        $config['next_tag_open'] = '<a class="limit_tag">';
//        $config['next_tag_close'] = '</a>';
        $config['first_tag_open'] = '<a class="limit_tag">';
        $config['first_tag_close'] = '</a>';
        $config['last_tag_open'] = '<a class="limit_tag">';
        $config['last_tag_close'] = '</a>';

        $this->pagination->initialize($config);

        $list_first = $this->category_model->get_category(1);
        $data['lists'] = $list_first;

        $id_list = $this->list_inorder();
        $result = $this->product_model->get_product_inorder($id_list);

        $data['rows'] = array_slice($result,$offset,10);
        $this->load->view('pages/product_list',$data);
    }

    public function create_on()
    {
        //Check login
        if (!$_SESSION['logged_in']) {
            redirect('admin/login');
        }
        $this->form_validation->set_rules('product_name', 'Product_name', 'required|is_unique[product.product_name]');
        $this->form_validation->set_rules('product_price', 'Product_price', 'required|greater_than_equal_to[0]');
        $this->form_validation->set_rules('product_num', 'Product_num', 'required|greater_than_equal_to[0]|is_natural');
        $this->form_validation->set_rules('container', 'Container', 'required');
        if ($this->form_validation->run() === FALSE) {
            redirect('product/create');
        } else {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '2048';
            $this->upload->initialize($config);

            $step_one = $this->product_model->create_product();
            if (!empty($_FILES['product_img'])) {
                if ($this->upload->do_upload('product_img')) {
                    $path = $this->upload->data('full_path');
                    $new_id = $this->product_model->find_id($this->input->post('product_name'));
                    $this->product_model->create_detail($path,$new_id);
                } else {
//                    echo $this->upload->display_errors();
                }
            }

            if($step_one){
                $this->admin_model->add_product();
                echo '<script>alert("产品上传成功");window.location.href="'.site_url('product/manage').'";</script>';
            } else {
                echo '<script>alert("产品上传失败");window.location.href="'.site_url('product/create').'";</script>';
            }
        }
    }

    public function delete($id)
    {
        //Check login
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/login');
        }

        $sub_id = $this->product_model->get_admin_id($id);
        $this->product_model->delete_product($id);
        $this->product_model->delete_detail($id);
        $this->admin_model->sub_product($sub_id);
        redirect('product/manage');
    }

    public function alter($id)
    {
        //Check login
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/login');
        }
        $this->session->set_userdata(array('product_id' => $id));

        $info = $this->product_model->get_data($id);
        $pre_id = $this->product_model->get_parent($info['category_id']);
        $ppre_id = $this->product_model->get_parent($pre_id);
        $default = array('default_fir' => $ppre_id,'default_sec' =>$pre_id,'default_thi' =>$info['category_id']);
        $data['default'] = $default;

        $result = $this->product_model->get_children(0);
        $data['rows'] = $result;

        $data['info'] = $info;
        $this->load->view('pages/product_alter', $data);
    }

    public function save($id)
    {
        //Check login
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/login');
        }
        $this->form_validation->set_rules('product_name', 'Product_name', 'required|callback_check_name_exists');
        $this->form_validation->set_rules('product_price', 'Product_price', 'required|greater_than_equal_to[0]');
        $this->form_validation->set_rules('product_num', 'Product_num', 'required|greater_than_equal_to[0]|is_natural');
        $this->form_validation->set_rules('container', 'Container', 'required');

        if($this->form_validation->run() === FALSE){
//            redirect('product/alter/'.$id);
        } else {

            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '2048';
            $this->upload->initialize($config);

            if (!empty($_FILES['product_img'])) {
                if ($this->upload->do_upload('product_img')) {
//                    echo '<script>alert("error");</script>';
                    $path = $this->upload->data('full_path');
                    $this->product_model->create_detail($path,$id);
                } else {
//                    echo $this->upload->display_errors();
                }
            }
            echo '<script>alert("22222");</script>';

            $signal = $this->product_model->alter_product($id);

            if($signal === true){
                $this->session->set_flashdata('product_altered', 'the change of product was saved.');
                redirect('product/manage');
            } else {
                $this->session->set_flashdata('passage_alter_failed', 'the change of passage was not saved.');
                redirect('product/alter/'.$id);
            }
        }
    }

    public function search()
    {
        $product_id = $this->product_model->search_product();
        if($product_id){
            $this->alter($product_id);
        } else {
            echo '<script>alert("所搜索产品不存在");window.location.href="'.site_url('product/manage').'";</script>';
        }
    }

    public function get_children($up_id)
    {
        $data = $this->product_model->get_children($up_id);
        return $data;
    }

    public function get_second()
    {
        $id_fir = trim($this->input->post('id_fir'));
        $result_sec = $this->product_model->get_children($id_fir);
        $info_sec = "";
        foreach ($result_sec as $row) {
            $info_sec .= '<option value="' . $row['category_id'] . '">' . $row['category_name'] . '</option>';
        }
        echo $info_sec;
        exit;
    }

    public function get_third()
    {
        $id_sec = trim($this->input->post('id_sec'));
        $result_thi = $this->product_model->get_children($id_sec);
        $info_thi = "";

        foreach ($result_thi as $row) {
            $info_thi .= '<option value="' . $row['category_id'] . '">' . $row['category_name'] . '</option>';
        }
        echo $info_thi;
    }

//    public function list_limit($length,$offset)
//    {
//        $id_list = $this->list_inorder();
//        $id_limit = array_slice($id_list,$offset,$length);
//        return $id_limit;
//    }

    public function list_inorder()
    {
        $list = array();

        $data_fir = $this->category_model->get_category(1);
        $id_list_fir = $this->get_column($data_fir);
        if($id_list_fir){
            foreach($id_list_fir as $key => $value){
                $data_sec = $this->category_model->get_category(2,$value);
                $id_list_sec = $this->get_column($data_sec);
                if($id_list_sec){
                    foreach($id_list_sec as $k => $v){
                        $data_thi = $this->category_model->get_category(3,$v);
                        $id_list_thi = $this->get_column($data_thi);
                        $list = array_merge($list,$id_list_thi);
                    }
                }
            }
        }

        return $list;
    }

    public function get_column($data)
    {
        $columns = array();
        foreach($data as $key => $value){
            $columns[] = $value['category_id'];
        }
        return $columns;
    }

    public function list_fir()
    {
        $list = array();

        $id_fir = $this->input->post('id_fir');
        $data_sec = $this->category_model->get_category(2,$id_fir);
        $id_list_sec = $this->get_column($data_sec);
        if($id_list_sec){
            foreach($id_list_sec as $key => $value){
                $data_thi = $this->category_model->get_category(3,$value);
                $id_list_thi = $this->get_column($data_thi);
                if($id_list_thi){
                    $list = array_merge($list,$id_list_thi);
                }
            }
        }

        $data_table = $this->product_model->get_product_inorder($list);
        $data_list = $data_sec;
        $data = array('data_table' => $data_table,'data_list' => $data_list);

//        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    public function list_sec()
    {
        $list = array();

        $id_sec = $this->input->post('id_sec');
        $data_thi = $this->category_model->get_category(3,$id_sec);
        $id_list_thi = $this->get_column($data_thi);
        if($id_list_thi){
            $list = array_merge($list,$id_list_thi);
        }

        $data_table = $this->product_model->get_product_inorder($list);
        $data_list = $data_thi;
        $data = array('data_table' => $data_table,'data_list' => $data_list);

//        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    public function list_thi()
    {
        $id_thi = $this->input->post('id_thi');
        $data_table = $this->product_model->get_product_group($id_thi);
        echo json_encode($data_table);
    }





    public function check_name_exists($name_input)
    {
        if($this->product_model->check_name_exists($name_input)){
            return true;
        } else {
            $this->form_validation->set_message('check_name_exists','That name of product was taken.Please choose a different one.');
            return false;
        }
    }

}