<?php

class Store extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation','session'));
        $this->load->model(array('categories_model', 'product_model', 'users_model'));
        $this->load->helper(array('form','url','check'));
        
    }

    public function index()
    {
        $this->view();
    }

    public function view($category = 'all')
    {
        if(isset($_POST['price']))
        {
            $price_order = $_POST['price'];
        }
        else
        {
            $price_order = null;
        }


        if($category != 'all')
        {
            $data['bannerHead'] = "Showing products under ".$category;
        }
        else
        {
            $data['bannerHead'] = "Our Products";
        }

        if(isset($_POST['search']))
        {
            $search = $_POST['search'];
            $data['bannerHead'] = "Showing search result for: ".$search;
        }
        else
        {
            $search = null;
        }
        $search = isset($_POST['search'])? $_POST['search'] : null;

        $data['page'] =  'store';
        $data['title'] = 'Store';
        $data['products'] = $this->product_model->get_all_client($price_order, $search, $category);
        $data['categories'] = $this->categories_model->get_all();
        $this->load->view('client/header', $data);
        $this->load->view('client/navbar');
        $this->load->view('store');
        $this->load->view('client/footer');
    }
    public function cart()
    {
        $id = $this->input->post('id'); //get the id of the posted product
        $status = $this->input->post('status'); //get the status of the posted product
        $qty = $this->input->post('quantity'); //get the status of the posted product
        //check if session exist, or create one
        if(!isset($_SESSION['cart']))
		{
            $_SESSION['cart'] = [];
        }

        //add or remove products in cart based on the status 0-remove 1-add
        if($status == '1')
        {
            $_SESSION['cart'][$id] = $qty;
            
        }
        elseif($status == '0')
        {
            unset($_SESSION['cart'][$id]);
        }

        if(isset($_POST['from_detail']))
        {
            $this->view_cart();
        }
    }

    public function wish()
    {
        $id = $this->input->post('id'); //get the id of the posted product
        $status = $this->input->post('status'); //get the status of the posted product
        $qty = $this->input->post('quantity'); //get the status of the posted product
        //check if session exist, or create one
        if(!isset($_SESSION['wish']))
		{
            $_SESSION['wish'] = [];
        }

        //add or remove products in cart based on the status 0-remove 1-add
        if($status == '1')
        {
            $_SESSION['wish'][$id] = $qty;
            
        }
        elseif($status == '0')
        {
            unset($_SESSION['wish'][$id]);
        }
    }

    public function detail($id = 0)
    {
        $data['page'] =  'detail';
        $data['product'] = $this->product_model->get_product($id);
        $data['title'] = 'Product: '.$data['product']['name'];
        $data['bannerHead'] = "Showing product: ".$data['product']['name'];
        $data['categories'] = $this->categories_model->get_all();
        $data['comments'] = $this->product_model->get_comments($id);
        $this->load->view('client/header', $data);
        $this->load->view('client/navbar');
        $this->load->view('detail');
        $this->load->view('client/footer');
    }

    public function add_comment()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim|htmlspecialchars', array(
            'required' => '%s is not provided!',
        ));
        $this->form_validation->set_rules('email', 'Email', 'required|trim|htmlspecialchars', array(
            'required' => '%s is not provided!',
        ));
        $this->form_validation->set_rules('comment', 'Comment', 'required|trim|htmlspecialchars', array(
            'required' => 'Please give a feedback',
        ));

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
            $db = $this->product_model->add_comment($_POST);
            if($db)
            {
                echo "<p class='text-success'>success</p>";
            }
            else
            {
                echo "a problem occured! try again later";
            }
        }

    }

    public function view_cart()
    {
        if(count($_SESSION['cart']) > 0)
        { 
            $cart_product = array_keys($_SESSION['cart']);
            $data['cart_items'] = $this->product_model->get_product_list($cart_product);
            $data['bannerHead'] = "Your cart: <span class='cart-banner-count'>".count($cart_product).'</span> item(s)';
        }
        else
        {
            $data['cart_items'] = false;
            $data['bannerHead'] = "Your cart: <span class='cart-banner-count'>0</span> item(s)";
        }
        $data['page'] =  'cart';
        $data['title'] = 'My cart';
        $data['categories'] = $this->categories_model->get_all();
        $this->load->view('client/header', $data);
        $this->load->view('client/navbar');
        $this->load->view('cart');
        $this->load->view('client/footer');
    }

    public function view_wish()
    {
        if(count($_SESSION['wish']) > 0)
        { 
            $wish_list = array_keys($_SESSION['wish']);
            $data['wish_items'] = $this->product_model->get_product_list($wish_list);
            $data['bannerHead'] = "Your wish: <span class='wish-banner-count'>".count($wish_list).'</span> item(s)';
        }
        else
        {
            $data['wish_items'] = false;
            $data['bannerHead'] = "Your wish: <span class='wish-banner-count'>0</span> item(s)";
        }
        $data['page'] =  'wish';
        $data['title'] = 'My wish list';
        $data['categories'] = $this->categories_model->get_all();
        $this->load->view('client/header', $data);
        $this->load->view('client/navbar');
        $this->load->view('wish');
        $this->load->view('client/footer');
    }

    public function checkout()
    {
        $this->form_validation->set_rules('state', 'State', 'required|trim|htmlspecialchars', array(
            'required' => '%s is not provided!',
        ));
        $this->form_validation->set_rules('city', 'City', 'required|trim|htmlspecialchars', array(
            'required' => '%s is not provided!',
        ));
        $this->form_validation->set_rules('address', 'Address', 'required|trim|htmlspecialchars', array(
            'required' => 'Please give a feedback',
        ));
        $this->form_validation->set_rules('phone', 'Phone number', 'required|trim|htmlspecialchars|numeric', array(
            'required' => 'Please give a feedback',
        ));

        if($this->form_validation->run() == FALSE)
        {
            if(isset($_POST['state']))
            {
                $_SESSION['flashMsg'] = "<div class='bg-danger flash-msg'>An error occured!</div>";
            }
            if(!$this->session->logged_in || $this->session->logged_in == false){
                header('location:'.base_url.'/index.php/users/view?redirect='.current_url());
            }
            if(count($_SESSION['cart']) > 0)
            { 
                $cart_product = array_keys($_SESSION['cart']);
                $data['cart_items'] = $this->product_model->get_product_list($cart_product);
                $data['bannerHead'] = "Checkout";
            }
            else
            {
                $data['cart_items'] = false;
                $data['bannerHead'] = "Checkout";
            }
            $data['d_details'] = $this->users_model->get_user_details($this->session->id);
            $data['user'] = $this->users_model->get_user_data($this->session->id);
            $data['page'] =  'checkout';
            $data['title'] = 'Checkout';
            $data['categories'] = $this->categories_model->get_all();
            $this->load->view('client/header', $data);
            $this->load->view('client/navbar');
            $this->load->view('checkout');
            $this->load->view('client/footer');
        }
        else
        {
            $place_order = $this->product_model->place_order($_POST);
            if($place_order)
            {
                unset($_SESSION['cart']);
                $this->orders();

            }
        }
    }

    public function orders()
    {
        if(!$this->session->logged_in || $this->session->logged_in == false){
            header('location:'.base_url.'/index.php/users/view?redirect='.current_url());
        }
        $data['bannerHead'] = "Your orders";
        //$data['d_details'] = $this->users_model->get_user_details($this->session->id);
        $data['orders'] = $this->product_model->get_user_orders($this->session->id);
        $data['user'] = $this->users_model->get_user_data($this->session->id);
        $data['page'] =  'orders';
        $data['title'] = 'Orders';
        $data['categories'] = $this->categories_model->get_all();
        $this->load->view('client/header', $data);
        $this->load->view('client/navbar');
        $this->load->view('orders');
        $this->load->view('client/footer');
    }
}