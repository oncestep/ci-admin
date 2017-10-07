<?php

/**
 * Created by PhpStorm.
 * Admin: 15185
 * Date: 2017/8/7
 * Time: 13:59
 */
class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('pages/login');
    }

    public function login()
    {
        $this->load->view('pages/login');
    }

    public function register()
    {
        $this->load->view('pages/register');
    }

    public function home()
    {
        if (!$_SESSION['logged_in']) {
            redirect('admin/login');
        }
        $this->load->view('pages/home');
    }

    public function page_alter()
    {
        $this->load->view('pages/admin_alter');
    }

    public function page_info($id)
    {
        $this->admin_model->show_info($id);
    }


    public function register_on()
    {
        //check input
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[6]|max_length[18]|callback_check_username_exists');
        $this->form_validation->set_rules('email', 'Email', 'required|callback_check_email_exists');
        $this->form_validation->set_rules('telephone', 'Telephone', 'required|exact_length[11]|callback_check_telephone_exists');
        $this->form_validation->set_rules('department', 'Department', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[18]');
        $this->form_validation->set_rules('confirm', 'Confirm_Password', 'matches[password]');

        if ($this->form_validation->run() === FALSE) {
            redirect('admin/register');
        } else {
            $enc_password = md5($this->input->post('password'));
            $signal = $this->admin_model->register($enc_password);

            if ($signal) {
                $this->session->flashdata('register', 'register successfully');
                redirect('admin/login');
            }
        }
    }

    public function login_on()
    {
        //Check input
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            redirect('admin/login');
        } else {
            //Get username
            $username = $this->input->post('username');

            //Get and md5 password
            $password = $this->input->post('password');
            $password_enc = md5($password);

            //User Login
            $admin_info = $this->admin_model->login($username, $password_enc);

            if ($admin_info) {

                $this->admin_model->login_update($username);

                $admin_data = array(
                    'admin_id' => $admin_info['admin_id'],
                    'username' => $admin_info['username'],
                    'email' => $admin_info['email'],
                    'telephone' => $admin_info['telephone'],
                    'department' => $admin_info['department'],
                    'passage_num' => $admin_info['passage_num'],
                    'product_num' => $admin_info['product_num'],
                    'login_time' => $admin_info['login_time'],
                    'logged_in' => TRUE
                );

                $this->session->set_userdata($admin_data);
                $this->session->set_flashdata('login', 'login successfully');

                redirect('admin/home');
            } else {
                $this->session->set_flashdata('login fail', 'login is invalid');

                redirect('admin/login');
            }
        }
    }

    public function alter()
    {
        //check alter info whether suitable or not
        $this->form_validation->set_rules('email', 'Email', 'required|callback_check_email_exists');
        $this->form_validation->set_rules('telephone', 'Telephone', 'required|exact_length[11]|callback_check_telephone_exists');
        $this->form_validation->set_rules('department', 'Department', 'required');
        $this->form_validation->set_rules('password_pre', 'Password_pre', 'required|callback_check_password_correct');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[18]');
        $this->form_validation->set_rules('confirm', 'Confirm', 'required|matches[password]');

        if ($this->form_validation->run() === FALSE) {
            redirect('admin/home');
        } else {
            $enc_password = md5($this->input->post('password'));

            $signal = $this->admin_model->alter($enc_password);

            if ($signal) {
                $this->session->set_flashdata('info_altered', 'The changes of the user was saved');

                //Clear all the session and login again
                $info = array('admin_id', 'username', 'email', 'telephone', 'department', 'passage_num', 'product_num', 'login_time');
                $this->session->unset_userdata($info);
                $this->session->set_userdata(array('logged_in' => FALSE));

                redirect('admin/login');
            }
        }

    }

    //administrator log out
    public function logout()
    {
        $this->session->set_flashdata('admin_logout','The administrator logged out');

        $info = array('admin_id', 'username', 'email', 'telephone', 'department', 'passage_num', 'product_num', 'login_time');
        $this->session->unset_userdata($info);
        $this->session->set_userdata(array('logged_in' => FALSE));

        redirect('admin/login');
    }


















    // Check if username exists
    public function check_username_exists($username)
    {

        if ($this->admin_model->check_username_exists($username)) {
            return true;
        } else {
            $this->form_validation->set_message('check_username_exists', 'That username is taken. Please choose a different one');
            return false;
        }
    }

    // Check if email exists
    public function check_email_exists($email)
    {

        if ($this->admin_model->check_email_exists($email)) {
            return true;
        } else {
            $this->form_validation->set_message('check_email_exists', 'That email is taken. Please choose a different one');
            return false;
        }
    }

    //Check if telephone exists
    public function check_telephone_exists($telephone)
    {

        if ($this->admin_model->check_telephone_exists($telephone)) {
            return true;
        } else {
            $this->form_validation->set_message('check_telephone_exists', 'That telephone number is taken.Please choose a different one');
            return false;
        }
    }

    //Check if password correct
    public function check_password_correct($password_pre)
    {
        if ($this->admin_model->check_password_correct($password_pre)) {
            return true;
        } else {
            $this->form_validation->set_message('check_password_correct', 'The password is correct');
            return false;
        }
    }

}