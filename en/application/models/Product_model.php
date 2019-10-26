<?php 

class Product_model extends CI_Model
{
    /**
     * Class constructor
     * 
     * on class call, automatically load the database
    */   
    public function __construct()
    {
        $this->load->database();
    }

    public function store ($data)
    {
        if(isset($data['featured']))
        {
            $featured = $data['featured'];
        }
        else
        {
            $featured = 'no';
        }
        $save = array(
            'name' => $data['name'],
            'description' => $data['description'],
            'image' => $data['image'],
            'gallery' => $data['gallery'],
            'price' => $data['price'],
            'weight' => $data['weight'],
            'dimention' => $data['dimention'],
            'featured' => $featured,
            'category' => $data['category'],
        );

       $store = $this->db->insert('products', $save);

       if($store)
       {
           return true;
       }
       else
       {
           return false;
       }
    }

    public function get_all($order, $search)
    {
        if($order != null)
        {
            $this->db->order_by($order, 'asc');
        }
        else
        {
            $this->db->order_by('id', 'DESC');
        }

        if($search != null)
        {
            $this->db->like('name', $search, 'both');
        }

        $query = $this->db->get('products');
        if($query->num_rows() > 0)
        {
            $result = $query->result_array();
            return $result;
        }
        else
        {
            return false;

        }
    }

    public function get_all_client($order, $search, $category)
    {
        if($order != null)
        {
            $this->db->order_by('price', $order);
        }

        if($search != null)
        {
            $this->db->like('name', $search, 'both');
        }

        if($category != 'all')
        {
            $this->db->where('category', $category);
        }
        $query = $this->db->get('products');
        if($query->num_rows() > 0)
        {
            $result = $query->result_array();
            return $result;
        }
        else
        {
            return false;

        }
    }

    public function update($id, $data)
    {
        if(isset($data['featured']))
        {
            $featured = $data['featured'];
        }
        else
        {
            $featured = 'no';
        }
        $save = array(
            'name' => $data['name'],
            'description' => $data['description'],
            'image' => $data['image'],
            'gallery' => $data['gallery'],
            'price' => $data['price'],
            'weight' => $data['weight'],
            'dimention' => $data['dimention'],
            'featured' => $featured,
            'category' => $data['category'],
        );

        $this->db->where('id', $id);
        $update = $this->db->update('products', $save);

        if($this->db->affected_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;   
        }
    }

    public function validate_change_product_name($product_name, $id)
    {
        //check if no other products uses the name to avoid duplication
        $sql = "select name from products WHERE id != ? AND name = ?";
        $query = $this->db->query($sql, array($id, $product_name));
        $result = $query->row_array();  
        if(isset($result))
        {
            return false;
        }
        else
        {
            return true;
        }
    }


    public function get_product($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('products');
        $data = $query->row_array();
        if(isset($data))
        {
            return $data;
        }
        else
        {
            return false;
        }
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('products');
    }

    public function get_featured($limit)
    {
        
        $this->db->limit('4');
        $this->db->where('featured', 'yes');
        $query = $this->db->get('products');
        if($query->num_rows() > 0)
        {
            $result = $query->result_array();
            return $result;
        }
        else
        {
            return false;

        }
    }

    public function add_comment($data)
    {
        
        $save = array(
            'product_id' => $data['id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'comment' => $data['comment'],
            'rating' => $data['rating'],
        );

       $store = $this->db->insert('comments', $save);

       if($store)
       {
           return true;
       }
       else
       {
           return false;
       }
    }

    public function get_comments($id)
    {
        $this->db->where('product_id', $id);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('comments');
        if($query->num_rows() > 0)
        {
            $result = $query->result_array();
            return $result;
        }
        else
        {
            return false;

        }
    }

    public function get_product_list($ids)
    {
        $this->db->where_in('id', $ids);
        $query = $this->db->get('products');
        if($query->num_rows() > 0)
        {
            $result = $query->result_array();
            return $result;
        }
        else
        {
            return false;

        }
    }

    public function place_order($data)
    {

        $order = array(
            'user_id' => $this->session->id,
            'invoice' => strtoupper(substr(uniqid(), 6)).rand(100, 999),
            'products' =>   json_encode($_SESSION['cart']),
            'price' => $data['price'],
            'state' => $data['state'],
            'address' => $data['address'],
            'city' => $data['city'],
            'payment_method' => $data['method'],
            'phone' => $data['phone'],
        );

        $save = array(
            'state' => $data['state'],
            'address' => $data['address'],
            'city' => $data['city'],
            'phone' => $data['phone'],
        );

        $this->db->where('user_id', $this->session->id);
        $update = $this->db->update('delivery_details', $save);

       $store_order = $this->db->insert('orders', $order);

       if($store_order)
       {
           return true;
       }
       else
       {
           return false;
       }
    }

    public function get_user_orders($id)
    {
        $this->db->where('user_id', $id);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('orders');
        if($query->num_rows() > 0)
        {
            $result = $query->result_array();
            return $result;
        }
        else
        {
            return false;

        }
    }
}