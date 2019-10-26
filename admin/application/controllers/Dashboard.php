<?php

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library(array('form_validation','session'));
        if($this->session->loggedIn != true || $this->session->role != 'admin')
        {
            $current_url = current_url();
            header('location:'.base_url.'/index.php/user/login?redirect='.$current_url);
        }
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['page'] = 'dashboard';
        $this->load->view('template/header', $data);
        $this->load->view('navbar');
        $this->load->view('template/footer');
    }
}