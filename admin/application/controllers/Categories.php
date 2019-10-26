<?php

class Categories extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library(array('form_validation','session'));
        $this->load->model('categories_model');
        if($this->session->loggedIn != true || $this->session->role != 'admin')
        {
            $current_url = current_url();
            header('location:'.base_url.'/index.php/user/login?redirect='.$current_url);
        }
    }

    public function index()
    {
        $this->view();
    }


    public function view()
    {
        $data['title'] = 'Categories';
        $data['page'] = 'categories';
        $data['categories'] = $this->categories_model->get_all();
        $this->load->view('template/header', $data);
        $this->load->view('navbar');
        $this->load->view('categories/view');
        $this->load->view('template/footer');
    }

    public function create()
    {
        $this->form_validation->set_rules('name', 'Category Name', 'required|trim|htmlspecialchars|is_unique[categories.name]', array(
            'required' => '%s is not provided!',
            'is_unique' => '%s Already Exist!'
        ));
        $this->form_validation->set_rules('description', 'Category Description', 'trim|htmlspecialchars');

        if($this->form_validation->run() == FALSE)
        {
            //set form info to display error message only if the submit button was clicked
            echo "<p class='text-danger'>";
            echo "An error occured <br/>";
            echo validation_errors();
            echo "</p>";


        }

        else
        {
            $db = $this->categories_model->store($_POST);
            if($db)
            {
                echo "<p class='text-success'>success</p>";
            }
            else
            {
                echo "a problem occured!";
            }
        }
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('name', 'Category Name', 'required|trim|htmlspecialchars|callback_validate_change_cat_name['.$id.']', array(
            'required' => '%s is not provided!',
            'is_unique' => '%s Already Exist!'
        ));
        $this->form_validation->set_rules('description', 'Category Description', 'trim|htmlspecialchars');

        if($this->form_validation->run() == FALSE)
        {
            //set form info to display error message only if the submit button was clicked
            echo "<p class='text-danger'>";
            echo "An error occured <br/>";
            echo validation_errors();
            echo "</p>";


        }
        else
        {
            $db = $this->categories_model->update($id, $_POST);
            if($db)
            {
                echo "<p class='text-success'>success</p>";
            }
            else
            {
                echo "a problem occured!";
            }
        }

    }

    public function validate_change_cat_name($cat_name, $id)
    {
        //verify no other category is using the name
        $verify_cat_name_change = $this->categories_model->validate_change_cat_name($cat_name, $id);

        //if the name exist somewhere else, set error message for form_validation and return false
        if($verify_cat_name_change == false)
        {
            $this->form_validation->set_message('validate_change_cat_name', 'Category name already exists');
            return false;
        }
        else
        {
            return true;
        }
    }

    public function destroy()
    {
        $this->categories_model->destroy($this->input->post('id'), $this->input->post('name'));
    }

}