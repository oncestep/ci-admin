<?php

/**
 * Created by PhpStorm.
 * Admin: 15185
 * Date: 2017/8/7
 * Time: 15:09
 */
class Product_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }


    public function create_product()
    {
        date_default_timezone_set('PRC');
        $time = date('Y-m-d H:i:s');

        $data = array(
            'category_id' => $this->input->post('level_thi'),
            'product_name' => $this->input->post('product_name'),
            'product_price' => $this->input->post('product_price'),
            'product_content' => $this->input->post('container'),
            'product_quantity' => $this->input->post('product_num'),
            'admin_id' => $_SESSION['admin_id'],
            'update_time' => $time
        );

        return $this->db->insert('product', $data);
    }

    public function create_detail($path,$id)
    {
        $data = array(
            'img_path' => $path,
            'product_id' => $id
        );
        return $this->db->insert('detail',$data);
    }

    public function get_product($limit ,$offset)
    {
        $this->db->join('category','category.category_id = product.category_id');
        $this->db->join('administrator','administrator.admin_id = product.admin_id');
        $query = $this->db->get('product',$limit,$offset);
        return $query->result_array();
    }

    public function get_product_inorder($id_list)
    {
        $rows = array();
        foreach($id_list as $k => $v){
            $this->db->join('category','category.category_id = product.category_id');
            $this->db->join('administrator','administrator.admin_id = product.admin_id');
            $this->db->where('product.category_id',$v);
            $query = $this->db->get('product');
            $result = $query->result_array();
            foreach($result as $key => $value){
                array_push($rows,$value);
            }

        }
        return $rows;
    }

    public function get_product_group($category_id)
    {
        $this->db->join('category','category.category_id = product.category_id');
        $this->db->join('administrator','administrator.admin_id = product.admin_id');
        $this->db->where('product.category_id',$category_id);
        $query = $this->db->get('product');
        $result = $query->result_array();
        return $result;
    }

    public function delete_product($id)
    {
        return $this->db->delete('product',array('product_id'=>$id));
    }

    public function delete_detail($id)
    {
        return $this->db->delete('detail',array('product_id'=>$id));
    }

    public function alter_product($id)
    {
        date_default_timezone_set('PRC');

        $data = array(
            'category_id' => $this->input->post('level_thi'),
            'product_name' => $this->input->post('product_name'),
            'product_price' => $this->input->post('product_price'),
            'product_content' => $this->input->post('container'),
            'product_quantity' => $this->input->post('product_num'),
            'admin_id' => $_SESSION['admin_id'],
            'update_time' => date('Y-m-d H:i:s')
        );

        $this->db->where('product_id',$id);
        return $this->db->update('product',$data);
    }

    public function search_product()
    {
        $search_name = $this->input->post('search_box');
        $query = $this->db->get_where('product',array('product_name'=>$search_name));
        $row = $query->row_array();
        return $row['product_id'];
    }





    public function get_children($up_id)
    {
        $query = $this->db->get_where('category', array('up_category_id' => $up_id));
        $result = $query->result_array();
        return $result;
    }

    public function get_parent($child_id)
    {
        $query = $this->db->get_where('category',array('category_id'=>$child_id));
        $row = $query->row_array();
        return $row['up_category_id'];
    }

    public function find_id($product_name)
    {
        $query = $this->db->get_where('product',array('product_name'=>$product_name));
        $row = $query->row_array();
        return $row['product_id'];
    }

    public function get_each()
    {
        $this->db->from('product');
        return $num = $this->db->count_all_results();
    }

    public function get_admin_id($product_id)
    {
        $query = $this->db->get_where('product',array('product_id'=>$product_id));
        $row = $query->row_array();
        return $row['admin_id'];
    }

    public function get_data($product_id)
    {
        $query = $this->db->get_where('product',array('product_id'=>$product_id));
        $row = $query->row_array();
        return $row;
    }

    public function check_name_exists($name_input)
    {
        $data = $this->get_data($_SESSION['product_id']);
        $query = $this->db->get_where('product',array('product_name'=>$name_input));
        $row = $query->row_array();
        if((empty($row))||($data['product_name']===$name_input)){
            return true;
        } else {
            return false;
        }
    }

}