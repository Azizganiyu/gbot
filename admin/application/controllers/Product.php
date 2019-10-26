<?php

class Product extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library(array('form_validation', 'session'));
        $this->load->model(array('categories_model','product_model'));
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
        if(isset($_POST['name']))
        {
            $order = $_POST['name'];
        }
        elseif(isset($_POST['date']))
        {
            $order = $_POST['date'];
        }
        else
        {
            $order = null;
        }

        $search = isset($_POST['search'])? $_POST['search'] : null;

        $data['categories'] = $this->categories_model->get_all();
        $data['products'] = $this->product_model->get_all($order, $search);
        $data['title'] = 'Products';
        $data['page'] = 'products';
        $this->load->view('template/header', $data);
        $this->load->view('navbar');
        $this->load->view('product/view');
        $this->load->view('template/footer');
    }

    public function create()
    {
        $this->form_validation->set_rules('name', 'Product Name', 'required|trim|htmlspecialchars|is_unique[products.name]', array(
            'required' => '%s is not provided!',
            'is_unique' => '%s Already Exist!'
        ));
        $this->form_validation->set_rules('description', 'Product Description', 'trim|htmlspecialchars');
        $this->form_validation->set_rules('price', 'Product Price', 'trim|htmlspecialchars|numeric');
        $this->form_validation->set_rules('weight', 'Product Weight', 'trim|htmlspecialchars|numeric');
        $this->form_validation->set_rules('dimention', 'Product Dimention', 'trim|htmlspecialchars|numeric');

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
            $db = $this->product_model->store($_POST);
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
        $this->form_validation->set_rules('name', 'Product Name', 'required|trim|htmlspecialchars|callback_validate_change_product_name['.$id.']', array(
            'required' => '%s is not provided!'
        ));
        $this->form_validation->set_rules('description', 'Product Description', 'trim|htmlspecialchars');
        $this->form_validation->set_rules('price', 'Product Price', 'trim|htmlspecialchars|numeric');
        $this->form_validation->set_rules('weight', 'Product Weight', 'trim|htmlspecialchars|numeric');
        $this->form_validation->set_rules('dimention', 'Product Dimention', 'trim|htmlspecialchars|numeric');

        if($this->form_validation->run() == FALSE)
        {
            if(isset($_POST['submit']))
            {
                $data['updateInfo'] = "<p class='text-danger'>A problem occured check form for errors!</p>";
            }

            $data['categories'] = $this->categories_model->get_all();
            $data['product'] = $this->product_model->get_product($id);
            $data['title'] = 'Edit Product: '. $data['product']['name'];
            $data['page'] = 'edit_products';
            $this->load->view('template/header', $data);
            $this->load->view('navbar');
            $this->load->view('product/edit');
            $this->load->view('template/footer');

        }
        else
        {
            $db = $this->product_model->update($id, $_POST);
            if($db)
            {
                $data['updateInfo'] = "<p class='text-success'>Successfully Updated!</p>";
            }
            else
            {
                $data['updateInfo'] =  "<p class='text-success'>You have made no change!</p>";
            }
            $data['categories'] = $this->categories_model->get_all();
            $data['product'] = $this->product_model->get_product($id);
            $data['title'] = 'Edit Product: '. $data['product']['name'];
            $data['page'] = 'edit_products';
            $this->load->view('template/header', $data);
            $this->load->view('navbar');
            $this->load->view('product/edit');
            $this->load->view('template/footer');
        }

    }

    public function validate_change_product_name($product_name, $id)
    {
        //verify no other product is using the name
        $verify_product_name_change = $this->product_model->validate_change_product_name($product_name, $id);

        //if the name exist somewhere else, set error message for form_validation and return false
        if($verify_product_name_change == false)
        {
            $this->form_validation->set_message('validate_change_product_name', 'Product name already exists');
            return false;
        }
        else
        {
            return true;
        }
    }

    public function destroy()
    {
        $this->product_model->destroy($this->input->post('id'));
    }

    public function get_product($id)
    {

    }
}