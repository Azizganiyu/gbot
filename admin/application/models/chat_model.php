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
}