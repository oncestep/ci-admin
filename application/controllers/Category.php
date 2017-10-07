<?php

/**
 * Created by PhpStorm.
 * Admin: 15185
 * Date: 2017/8/7
 * Time: 13:58
 */
class Category extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();

        //Check login
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/login');
        }
    }

    public function create()
    {
        $select_fir = $this->category_model->get_category(1);
        $select_sec = $this->category_model->get_category(2,$select_fir[0]['category_id']);
        $select_thi = $this->category_model->get_category(3,$select_sec[0]['category_id']);

        $data["select_fir"] = $select_fir;
        $data["select_sec"] = $select_sec;
        $data["select_thi"] = $select_thi;
        $this->load->view('pages/category_add',$data);
    }

    public function delete($id)
    {
        $this->category_model->delete_category($id);
        redirect('category/manage');
    }

    public function create_on_one()
    {
        $this->form_validation->set_rules('level_fir', 'Level_Fir', 'required|is_unique[category.category_name]');

        if ($this->form_validation->run()) {
            $this->category_model->create_category(1);
            echo "<script>self.location.href='" . site_url('category/manage') . "';alert('一级分类创建成功！');</script>";
        } else {
            if($this->input->post('level_fir' == "")){
                echo "<script>self.location.href='" . site_url('category/create') . "';alert('非法输入！');</script>";
            } else {
                echo "<script>self.location.href='" . site_url('category/create') . "';alert('一级分类已存在！');</script>";
            }
        }
    }

    public function create_on_two()
    {
        $this->form_validation->set_rules('level_fir', 'Level_Fir', 'required');
        $this->form_validation->set_rules('level_sec', 'Level_Sec', 'required|is_unique[category.category_name]');
        if ($this->form_validation->run()) {
            $id_fir = $this->category_model->find_up(1);
            if ($id_fir) {
                $this->category_model->create_category(2, $id_fir);
                echo "<script>self.location.href='" . site_url('category/manage') . "';alert('二级分类创建成功！');</script>";
            } else {
                echo "<script>self.location.href='" . site_url('category/create') . "';alert('一级分类不存在！');</script>";
            }
        } else {
            if($this->input->post('level_sec' == "")){
                echo "<script>self.location.href='" . site_url('category/create') . "';alert('非法输入！');</script>";
            } else {
                echo "<script>self.location.href='" . site_url('category/create') . "';alert('二级分类已存在！');</script>";
            }
        }
    }

    public function create_on_three()
    {
        if ($this->input->post('level_thi')) {
            $this->form_validation->set_rules('level_fir', 'Level_Fir', 'required');
            $this->form_validation->set_rules('level_sec', 'Level_Sec', 'required');
            $this->form_validation->set_rules('level_thi', 'Level_Thi', 'is_unique[category.category_name]');
        } else {
            if ($this->input->post('level_sec')) {
                $this->form_validation->set_rules('level_fir', 'Level_fir', 'required');
                $this->form_validation->set_rules('level_sec', 'Level_Sec', 'is_unique[category.category_name]');
            } else {
                $this->form_validation->set_rules('level_fir', 'Level_fir', 'required|is_unique[category.category_name]');
            }
        }

        if ($this->form_validation->run()) {
            if ($this->input->post('level_thi')) {
                $id_first = $this->category_model->find_up(1);
                $id_second = $this->category_model->find_up(2);
                if ($id_first) {
                    if ($id_second) {
                        $id_up = $this->category_model->find_byid($id_second);
                        if ($id_up === $id_first) {
                            $this->category_model->create_category(3, $id_first, $id_second);
                            echo "<script>self.location.href='" . site_url('category/manage') . "';alert('三级分类创建成功！');</script>";
                        } else {
                            echo "<script>self.location.href='" . site_url('category/create') . "';alert('一二级分类不匹配！');</script>";
                        }
                    } else {
                        echo "<script>self.location.href='" . site_url('category/create') . "';alert('二级分类不存在！');</script>";
                    }
                } else {
                    echo "<script>self.location.href='" . site_url('category/create') . "';alert('一级分类不存在！');</script>";
                }

            } else {
                if ($this->input->post('level_sec')) {

                    $id_fir = $this->category_model->find_up(1);
                    if ($id_fir) {
                        $this->category_model->create_category(2, $id_fir);
                        echo "<script>self.location.href='" . site_url('category/manage') . "';alert('二级分类创建成功！');</script>";
                    } else {
                        echo "<script>self.location.href='" . site_url('category/create') . "';alert('一级分类不存在！');</script>";
                    }

                } else {
                    $this->category_model->create_category(1);
                    echo "<script>self.location.href='" . site_url('category/manage') . "';alert('一级分类创建成功！');</script>";
                }
            }

        } else {
            if($this->input->post('level_thi' == "")){
                echo "<script>self.location.href='" . site_url('category/create') . "';alert('非法输入！');</script>";
            } else {
                echo "<script>self.location.href='" . site_url('category/create') . "';alert('三级分类已存在！');</script>";
            }
        }
    }

    public function manage($offset = 0)
    {
        //Pagination Config
        $config['base_url'] = site_url('category/manage');
        $config['total_rows'] = $this->category_model->get_each();
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
        $data_output = $this->table_output(10, $offset);
        $data['list'] = $list_first;
        $data['rows'] = $data_output;

        $this->load->view('pages/category_list', $data);
    }

    public function table_output($limit = 10, $offset = 0)
    {
        $data = array(array());
        $data_out = array();
        $data_fir = $this->category_model->get_category(1);
        $col_fir = $this->get_column($data_fir);
        if ($col_fir) {
            foreach ($col_fir as $key => $value) {
                $data[] = $data_fir[$key];
                $data_out[] = $this->draw_column(1, $data_fir[$key]);
                $data_sec = $this->category_model->get_category(2, $value);
                $col_sec = $this->get_column($data_sec);
                if ($col_sec) {
                    foreach ($col_sec as $k => $val) {
                        $data[] = $data_sec[$k];
                        $data_out[] = $this->draw_column(2, $data_sec[$k]);
                        $data_thi = $this->category_model->get_category(3, $val);
                        if ($data_thi) {
                            array_push($data, $data_thi);
                            foreach ($data_thi as $ks => $vals) {
                                $data_out[] = $this->draw_column(3, $data_thi[$ks]);
                            }
                        }
                    }
                }
            }
        }
//        return $data_out;
        $data_pag = array_slice($data_out, $offset, $limit);
        return $data_pag;
    }

    public function get_column($data)
    {
        $column = array();
        foreach ($data as $value) {
            $column[] = $value['category_id'];
        }
        return $column;
    }

    public function draw_column($level = 0, $row)
    {
        if ($level === 1) {
            $rows = '
        <tr>
            <td class="center">
                <span>
                    <span>' . $row["category_name"] . '</span>
                </span>
            </td>
            <td class="center">
                <span>
                    <span></span>
                </span>
            </td>
            <td class="center">
                <span>
                    <span></span>
                </span>
            </td>
            <td class="center">
                <span>
                    <em>' . $row["create_time"] . '</em>
                </span>
            </td>
            <td class="center">
                <span>
                    <i>' . $row["username"] . '</i>
                </span>
            </td>
            <td class="center">
                <a title="删除" href="' . site_url('category/delete/' . $row['category_id']) . '" onclick="return confirm(\'确认删除?\');"><img src="' . base_url('resource/img/base/icon_drop.gif') . '"/></a>
            </td>
        </tr>';
            $this->session->set_userdata(array('level_fir' => $row['category_name']));
        } else if ($level === 2) {
            $rows = '
        <tr>
            <td class="center">
                <span>
                    <span>' . $_SESSION['level_fir'] . '</span>
                </span>
            </td>
            <td class="center">
                <span>
                    <span>' . $row["category_name"] . '</span>
                </span>
            </td>
            <td class="center">
                <span>
                    <span></span>
                </span>
            </td>
            <td class="center">
                <span>
                    <em>' . $row["create_time"] . '</em>
                </span>
            </td>
            <td class="center">
                <span>
                    <i>' . $row["username"] . '</i>
                </span>
            </td>
            <td class="center">
                <a title="删除" href="' . site_url('category/delete/' . $row['category_id']) . '" onclick="return confirm(\'确认删除?\');"><img src="' . base_url('resource/img/base/icon_drop.gif') . '"/></a>
            </td>
        </tr>';
            $this->session->set_userdata(array('level_sec' => $row['category_name']));
        } else {
            $rows = '
        <tr>
            <td class="center">
                <span>
                    <span>' . $_SESSION['level_fir'] . '</span>
                </span>
            </td>
            <td class="center">
                <span>
                    <span>' . $_SESSION['level_sec'] . '</span>
                </span>
            </td>
            <td class="center">
                <span>
                    <span>' . $row["category_name"] . '</span>
                </span>
            </td>
            <td class="center">
                <span>
                    <em>' . $row["create_time"] . '</em>
                </span>
            </td>
            <td class="center">
                <span>
                    <i>' . $row["username"] . '</i>
                </span>
            </td>
            <td class="center">
                <a title="删除" href="' . site_url('category/delete/' . $row['category_id']) . '" onclick="return confirm(\'确认删除?\');"><img src="' . base_url('resource/img/base/icon_drop.gif') . '"/></a>
            </td>
        </tr>';
        }
        return $rows;
    }

    public function change_fir()
    {
        $id_fir = $this->input->post('id_fir');
        $name_fir = $this->category_model->find_name($id_fir);
        $this->session->set_userdata(array('name_fir' => $name_fir));
        $result_sec = $this->category_model->get_category(2, $id_fir);
        $second_list = "";
        $first_part = "";
        $second_list .= '<option value="-1" selected>二级分类</option>';
        foreach ($result_sec as $row) {
            $second_list .= "<option value='" . $row['category_id'] . "'>" . $row['category_name'] . "</option>";
            $first_part .= '<tr><td class="center"><span><span>' . $_SESSION["name_fir"] . '</span></span></td>
                <td class="center"><span><span>' . $row["category_name"] . '</span></span></td><td class="center"><span><span></span></span></td>
                <td class="center"><span><em>' . $row["create_time"] . '</em></span></td><td class="center"><span><i>' . $row["username"] . '</i></span></td>
                <td class="center"><a title="删除" href="' . site_url('category/delete/' . $row['category_id']) . '" onclick="return confirm(\'确认删除?\');"><img src="' . base_url('resource/img/base/icon_drop.gif') . '"/></a></td>
                </tr>';
        }
        $data = array('first_part' => $first_part, 'second_list' => $second_list);
        echo json_encode($data);
    }

    public function change_fir_byname()
    {
        $name_fir = $this->input->post('name_fir');
        $row = $this->category_model->find_byname($name_fir);
        $id_fir = $row['category_id'];
        $this->session->set_userdata(array('name_fir' => $name_fir));
        $result_sec = $this->category_model->get_category(2, $id_fir);
        $second_list = "";
        $second_list .= '<option value="-1" selected>二级分类</option>';
        foreach ($result_sec as $row) {
            $second_list .= "<option value='" . $row['category_name'] . "'>" . $row['category_name'] . "</option>";
        }
        $data = array('second_list' => $second_list);
        echo json_encode($data);
    }

    public function change_sec()
    {
        $id_sec = $this->input->post('id_sec');
        $name_sec = $this->category_model->find_name($id_sec);
        $this->session->set_userdata(array('name_sec' => $name_sec));
        $result_thi = $this->category_model->get_category(3, $id_sec);
        $third_list = "";
        $second_part = "";
        $third_list .= '<option value="-1" selected>三级分类</option>';
        foreach ($result_thi as $row) {
            $third_list .= "<option value='" . $row['category_id'] . "'>" . $row['category_name'] . "</option>";
            $second_part .= '<tr><td class="center"><span><span>' . $_SESSION["name_fir"] . '</span></span></td>
                <td class="center"><span><span>' . $_SESSION["name_sec"] . '</span></span></td><td class="center"><span><span>' . $row["category_name"] . '</span></span></td>
                <td class="center"><span><em>' . $row["create_time"] . '</em></span></td><td class="center"><span><i>' . $row["username"] . '</i></span></td>
                <td class="center"><a title="删除" href="' . site_url('category/delete/' . $row['category_id']) . '" onclick="return confirm(\'确认删除?\');"><img src="' . base_url('resource/img/base/icon_drop.gif') . '"/></a></td>
                </tr>';
        }
        $data = array('second_part' => $second_part, 'third_list' => $third_list);
        echo json_encode($data);
    }

    public function change_thi()
    {
        $id_thi = $this->input->post('id_thi');
        $result = $this->category_model->find_result($id_thi);
        $third_part = "";
        foreach ($result as $row) {
            $third_part .= '<tr><td class="center"><span><span>' . $_SESSION["name_fir"] . '</span></span></td>
                <td class="center"><span><span>' . $_SESSION["name_sec"] . '</span></span></td><td class="center"><span><span>' . $row["category_name"] . '</span></span></td>
                <td class="center"><span><em>' . $row["create_time"] . '</em></span></td><td class="center"><span><i>' . $row["username"] . '</i></span></td>
                <td class="center"><a title="删除" href="' . site_url('category/delete/' . $row['category_id']) . '" onclick="return confirm(\'确认删除?\');"><img src="' . base_url('resource/img/base/icon_drop.gif') . '"/></a></td>
                </tr>';
        }
        $data = array('third_part' => $third_part);
        echo json_encode($data);
    }
}

