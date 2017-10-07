<?php

/**
 * Created by PhpStorm.
 * Admin: 15185
 * Date: 2017/8/7
 * Time: 15:09
 */
class Admin_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    //Register
    public function register($enc_password)
    {

        //Admin data array
        $data = array(
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'telephone' => $this->input->post('telephone'),
            'department' => $this->input->post('department'),
            'password' => $enc_password
        );

        //Insert data to db
        return $this->db->insert('administrator', $data);
    }

    //Log in
    public function login($username, $password_enc)
    {
        //Validate
        $query = $this->db->get_where('administrator', array('username' => $username));
        $result = $query->row_array();

        if ($result) {
            $password_t = $result['password'];
        } else {
            return FALSE;
        }

        //Match password
        if ($password_t === $password_enc) {
            return $result;
        } else {
            return FALSE;
        }
    }

    //show info of admin
    public function show_info($id)
    {
        $query = $this->db->get_where('administrator', array('admin_id' => $id));
        $row = $query->row_array();
        $this->load->view('pages/admin_info', $row);
    }

    //Update login time
    public function login_update($username)
    {

        date_default_timezone_set('PRC');
        $time = date('Y-m-d H:i:s');

        $this->db->where('username', $username);
        return $this->db->update('administrator', array('login_time' => $time));
    }

    //Alter admin info
    public function alter($enc_password)
    {

        //Admin data
        $data = array(
            'email' => $this->input->post('email'),
            'telephone' => $this->input->post('telephone'),
            'department' => $this->input->post('department'),
            'password' => $enc_password
        );

        //Update data
        $this->db->where('admin_id', $_SESSION['admin_id']);
        return $this->db->update('administrator', $data);
    }

    //Add passage num
    public function add_passage()
    {

        //false : do not transfer meaning
        $this->db->where('admin_id', $_SESSION['admin_id']);
        $this->db->set('passage_num', 'passage_num+1', FALSE);
        $this->db->update('administrator');
    }

    //Add product num
    public function add_product()
    {
        //false : do not transfer meaning
        $this->db->where('admin_id', $_SESSION['admin_id']);
        $this->db->set('product_num', 'product_num+1', FALSE);
        $this->db->update('administrator');
    }

    //Subtract passage num
    public function sub_passage($author_id)
    {
        $this->db->where('admin_id',$author_id);
        $this->db->set('passage_num','passage_num-1',FALSE);
        $this->db->update('administrator');
    }

    //Subtract batch of passages num
    public function sub_batch($data)
    {
        foreach($data as $value){
            $query = $this->db->get_where('passage',array('passage_id'=>$value));
            $row = $query->row_array();
            $this->db->where('admin_id',$row['admin_id']);
            $this->db->set('passage_num','passage_num-1',FALSE);
            $this->db->update('administrator');
        }
    }

    public function sub_product($author_id)
    {
        $this->db->where('admin_id',$author_id);
        $this->db->set('product_num','product_num-1',FALSE);
        $this->db->update('administrator');
    }

































    //Check username exists
    public function check_username_exists($username)
    {
        $query = $this->db->get_where('administrator', array('username' => $username));
        if (empty($query->row_array())) {
            return true;
        } else {
            return false;
        }
    }

    //Check email exists
    public function check_email_exists($email)
    {
        $query = $this->db->get_where('administrator', array('email' => $email));
        $row = $query->row_array();
        if (empty($row) || ($row['email'] === $_SESSION['email'])) {
            return true;
        } else {
            return false;
        }
    }

    //Check telephone exists
    public function check_telephone_exists($telephone)
    {
        $query = $this->db->get_where('administrator', array('telephone' => $telephone));
        $row = $query->row_array();
        if (empty($row) || ($row['email'] === $_SESSION['email'])) {
            return true;
        } else {
            return false;
        }
    }

    //Check password right
    public function check_password_correct($password)
    {
        $enc_password = md5($password);
        $query = $this->db->get_where('administrator', array('admin_id' => $_SESSION['admin_id']));
        $row = $query->row_array();
        if ($row['password'] === $enc_password) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}