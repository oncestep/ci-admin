<?php

/**
 * Created by PhpStorm.
 * Admin: 15185
 * Date: 2017/8/7
 * Time: 13:58
 */
class Passage extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();

    }

    public function index()
    {
        //Check login

        $this->load->view('pages/advertising_list');
    }

    public function create()
    {
        $this->load->view('pages/advertising_create');
    }

    public function create_on()
    {
        //Check login
        if (!$_SESSION['logged_in']) {
            redirect('admin/login');
        }

        $this->form_validation->set_rules('title', 'Title', 'required|is_unique[passage.passage_title]');
        $this->form_validation->set_rules('content', 'Content', 'required');

        if ($this->form_validation->run() === FALSE) {
            redirect('passage/create');
        } else {
            if ($this->passage_model->create_passage()) {
                $this->admin_model->add_passage();
                $this->load->view('pages/advertising_create');
                echo "<script>alert('Create Success');</script>";
            } else {
                echo 'FAIL TO UPLOAD PASSAGE';
            }
        }
    }

    public function manage($offset = 0)
    {
        //Pagination Config
        $config['base_url'] = site_url('passage/manage');
        $config['total_rows'] = $this->passage_model->get_each();
        $config['per_page'] = 5;
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

        //Show all passages
        $form = $this->passage_model->get_passages(FALSE, $config['per_page'], $offset);

        $data['passages'] = $form;

        $this->load->view('pages/advertising_list', $data);
    }

    public function delete($passage_id,$author_id)
    {
        //Check login
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/login');
        }

        $signal = $this->passage_model->delete_passage($passage_id);
        $this->admin_model->sub_passage($author_id);

        if ($signal) {
            $this->session->set_flashdata('passage_deleted', 'The passage was deleted.');
            redirect('passage/manage');
        } else {
            $this->session->set_flashdata('passage_failed', 'Delete fail.');
            redirect('passage/manage');
        }
    }

    public function delete_batch()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/login');
        }

        $data = $this->input->post('item');

        $this->admin_model->sub_batch($data);
        $signal = $this->passage_model->delete_batch($data);

        if ($signal) {
            $this->session->set_flashdata('batch_deleted', 'The batch was deleted');
            redirect('passage/manage');
        } else {
            $this->session->set_flashdata('batch_failed', 'Delete fail.');
            redirect('passage/manage');
        }
    }

    public function alter($id)
    {
        $this->session->set_userdata(array('passage_id'=>$id));
        $data = $this->passage_model->get_passages($id);
        $this->load->view('pages/advertising_alter',$data);
    }

    public function save($id){
        if(!$this->session->userdata('logged_in')){
            redirect('admin/login');
        }

        $this->form_validation->set_rules('title','Title','required|callback_check_title_exists');
        $this->form_validation->set_rules('content','Content','required');

        if($this->form_validation->run() === FALSE){
            redirect('passage/alter/'.$id);
        } else {
            $signal = $this->passage_model->alter_passage($id);
            if($signal === TRUE){
                    $this->session->set_flashdata('passage_altered', 'the change of passage was saved.');
                    redirect('passage/manage');
                } else {
                    $this->session->set_flashdata('alter_failed', 'the change of passage was not saved');
                    redirect('passage/alter/'.$id);
                }
        }
    }

    public function search(){
        $passage_id = $this->passage_model->search_passage();
        if($passage_id){
            $this->alter($passage_id);
        } else {
            echo "<script>alert('所搜索文章不存在');window.location.href='".site_url('passage/manage')."';</script>";
        }
    }







    public function check_title_exists($title_input){
        if($this->passage_model->check_title_exists($title_input)){
            return true;
        } else {
            $this->form_validation->set_message('check_title_exists','That title of passage was taken.Please choose a different one.');
            return false;
        }
    }

}