<?php

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation','session'));
        $this->load->model(array('categories_model', 'product_model'));
        $this->load->helper(array('form','url','check'));
    }

    public function index()
    {
        $data['page'] =  'home';
        $data['title'] = 'Home';
        $data['products'] = $this->product_model->get_featured('4');
        $data['categories'] = $this->categories_model->get_all();
        $this->load->view('client/header', $data);
        $this->load->view('client/navbar');
        $this->load->view('home');
        $this->load->view('client/footer');
    }
}