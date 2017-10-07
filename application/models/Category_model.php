<?php

/**
 * Created by PhpStorm.
 * Admin: 15185
 * Date: 2017/8/7
 * Time: 14:58
 */
class Category_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function create_category($level = 3, $up_fir = FALSE, $up_sec = FALSE)
    {
        date_default_timezone_set('PRC');
        $time = date('Y-m-d H:i:s');

        if ($level === 1) {
            $data = array(
                'category_name' => $this->input->post('level_fir'),
                'up_category_id' => 0,
                'admin_id' => $_SESSION['admin_id'],
                'create_time' => $time
            );
        } else if ($level === 2) {
            $data = array(
                'category_name' => $this->input->post('level_sec'),
                'up_category_id' => $up_fir,
                'admin_id' => $_SESSION['admin_id'],
                'create_time' => $time
            );
        } else {
            $data = array(
                'category_name' => $this->input->post('level_thi'),
                'up_category_id' => $up_sec,
                'admin_id' => $_SESSION['admin_id'],
                'create_time' => $time
            );
        }


        return $this->db->insert('category', $data);
    }

    public function find_up($level)
    {
        if ($level === 1) {
            $query = $this->db->get_where('category', array('category_name' => $this->input->post('level_fir')));
        } else if ($level === 2) {
            $query = $this->db->get_where('category', array('category_name' => $this->input->post('level_sec')));
        } else {
            $query = $this->db->get_where('category', array('category_name' => $this->input->post('level_thi')));
        }
        $row = $query->row_array();
        return $row['category_id'];
    }

    public function find_byid($category_id)
    {
        $query = $this->db->get_where('category', array('category_id' => $category_id));
        $row = $query->row_array();
        return $row['up_category_id'];
    }

    public function find_byname($category_name)
    {
        $query = $this->db->get_where('category', array('category_name' => $category_name));
        return $query->row_array();
    }

    public function find_name($category_id)
    {
        $query = $this->db->get_where('category', array('category_id' => $category_id));
        $row = $query->row_array();
        return $row['category_name'];
    }

    public function find_result($category_id)
    {
        $this->db->join('administrator', 'administrator.admin_id = category.admin_id');
        $query = $this->db->get_where('category', array('category_id' => $category_id));
        $result = $query->result_array();
        return $result;
    }

    public function get_each()
    {
        $this->db->from('category');
        return $num = $this->db->count_all_results();
    }

    public function get_category($level = 0, $up_id = FALSE)
    {
        $this->db->join('administrator', 'administrator.admin_id = category.admin_id');
        if ($level === 1) {
            $query = $this->db->get_where('category', array('up_category_id' => 0));
        } else {
            $query = $this->db->get_where('category', array('up_category_id' => $up_id));
        }

        $result = $query->result_array();
        return $result;
    }

    public function delete_category($id)
    {
        if ($id) {
            $query = $this->db->get_where('category', array('up_category_id' => $id));
            $result = $query->result_array();
            foreach ($result as $key => $value) {
                $this->delete_category($value['category_id']);
            }

            $this->db->delete('category', array('category_id' => $id));
            $obj = $this->db->get_where('product', array('category_id' => $id));
            $rows = $obj->result_array();
            foreach ($rows as $val) {
                $this->db->delete('detail', array('product_id' => $val['product_id']));
            }

            $this->db->delete('product', array('category_id' => $id));
        }
    }


}