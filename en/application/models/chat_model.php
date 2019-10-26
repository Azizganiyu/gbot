<?php 

class chat_model extends CI_Model
{
    /**
     * Class constructor
     * 
     * on class call, automatically load the database
    */   
    public function __construct()
    {
        $this->load->database();
        $this->load->library(array('session',));
    }

    public function findEmail($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        if($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;

        }
    }

    public function login($email, $password)
    {
        $sql = "select * from users WHERE email = ?";
        $query = $this->db->query($sql, array($email));
        $result = $query->row_array();

        //if user exist verify password
        if(isset($result))
        {
            //verify password against user password input
            if(password_verify($password, $result['password']))
            {
                $user_data = array(
                    'id' => $result['id'],
                    'logged_in' => true
                );
                $this->session->set_userdata($user_data);

                setcookie('logged_in', 'true', 0, "/");
                return true;
            }
            else
            {
                return False;
            }

        }
        else
        {
            return False;
        }
    }

    public function register($name, $email, $password)
    {
        $values = array(
            'name' => $name,
            'email' =>  $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        );
        $insert = $this->db->insert('users', $values);
        if($insert)
        {
            $id = $this->db->insert_id();
            $this->db->insert('delivery_details', array('user_id' => $id));

            $this->login($email, $password);
            return true;
        }
        else
        {
            return false;
        }
    }

    public function searchProduct($category, $product)
    {
        if($category != 'undefined')
        {
            if($product != 'undefined')
            {
                $this->db->where('category', $category);
                $this->db->like('name', $product, 'both');
                $query = $this->db->get('products');
                if($query->num_rows() > 0)
                {
                    $result = $query->result_array();
                    return array('type' => 'product', 'result' => $result);
                }
                else
                {
                    $this->db->where('category', $category);
                    $query = $this->db->get('products');
                    if($query->num_rows() > 0)
                    {
                        $result = $query->result_array();
                        return array('type' => 'category', 'result' => $result);
                    }
                    else
                    {
                        return false;
                    }

                }
            }
            else
            {
                $this->db->where('category', $category);
                $query = $this->db->get('products');
                if($query->num_rows() > 0)
                {
                    $result = $query->result_array();
                    return array('type' => 'category', 'result' => $result);;
                }
                else
                {
                    return false;

                }
            }
        }
        else
        {
            if($product != 'undefined')
            {
                $this->db->like('name', $product, 'both');
                $query = $this->db->get('products');
                if($query->num_rows() > 0)
                {
                    $result = $query->result_array();
                    return array('type' => 'product', 'result' => $result);;
                }
                else
                {
                    return false;

                }
            }
            else
            {
                return false;
            }
        }

    }

    public function addCart($id, $status, $qty)
    {
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
}