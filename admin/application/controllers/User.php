<?php

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library(array('form_validation','session'));
    }

    public function index()
    {
        $this->view();
    }

    public function login()
    {
        //validate user input from the login form
        $this->form_validation->set_rules('id', 'ID', 'required|trim|htmlspecialchars|regex_match[/admin/]', array(
            'required' => '%s is not provided'
        ));
        $this->form_validation->set_rules('password', 'Password', 'required|trim|htmlspecialchars|regex_match[/root/]', array(
            'required' => '%s is not provided'
        ));
        $this->form_validation->set_rules('redirect', 'Redirect', 'trim|htmlspecialchars');

        //if form validation error or input error, redisplay the login page with errors
        if($this->form_validation->run() == FALSE)
        {
            if(isset($_POST['submit'])){
                $data['error'] = 'Wrong ID or Password';
            }
            $data['title'] = 'Admin Login';
            $data['page'] = 'admin_login';
            $this->load->view('template/header', $data);
            $this->load->view('user/login');
        }

        //if there is no error from form validation, send user input(provided login credential)  to user model class for validation or verification
        else
        {
            
            $user_data = array(
                'loggedIn' => true,
                'role' => 'admin'
            );

            $this->session->set_userdata($user_data);

            //redirect user to page that required the user must be logged in
            //redirect only if the redirect field was set
            //or redirect to dashboard after login
            if(!empty($this->input->post('redirect')))
            {
                $url = $this->input->post('redirect');
            }
            else
            {
                    $url = base_url.'/index.php/dashboard';
            }
            header('location:'.$url);
        }
    }

    public function view()
    {
        $data['title'] = 'Users';
        $data['page'] = 'users';
        $this->load->view('template/header', $data);
        $this->load->view('navbar');
        $this->load->view('user/view');
        $this->load->view('template/footer');
    }

    public function logout()
    {
        //verify user is currently logged in before attempting to logout
        if($this->session->logged_in != true)
        {
            //if not logged in redirect to login page
            header('location:'.base_url.'/index.php/user/login');
        }

        //set session data logged_in to false
        $this->session->set_userdata(array(
            'loggedIn' => false,
            'role' => null
            )
        );

        //redirect to login page after logout
        header('location:'.base_url.'/index.php/user/login');
    }


}