<?php
/**
 * Created by PhpStorm.
 * Admin: 15185
 * Date: 2017/8/7
 * Time: 16:31
 */
class Section extends CI_Controller{

    public function add_category(){
        $this->load->view('pages/add_category');
    }

    public function admin_list(){
        $this->load->view('pages/admin_list');
    }

    public function adminLogin(){
        $this->load->view('pages/adminLogin');
    }

    public function advertising(){
        $this->load->view('pages/advertising');
    }

    public function advertising_list(){
        $this->load->view('pages/advertising_list');
    }

    public function bar(){
        $this->load->view('pages/bar');
    }

    public function edit_product(){
        $this->load->view('pages/edit_product');
    }

    public function home(){
        $this->load->view('pages/home');
    }

    public function login(){
        $this->load->view('pages/login');
    }

    public function admin_info(){
        $this->load->view('pages/admin_info');
    }

    public function admin_alter(){
        $this->load->view('pages/admin_alter');
    }

    public function menu(){
        $this->load->view('pages/menu');
    }

    public function product_category(){
        $this->load->view('pages/product_category');
    }

    public function product_list(){
        $this->load->view('pages/product_list');
    }

    public function revise_password(){
        $this->load->view('pages/revise_password');
    }

    public function top(){
        $this->load->view('pages/top');
    }

}