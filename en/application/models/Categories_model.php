<?php 

class Categories_model extends CI_Model
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
       $save = array(
            'name' => $data['name'],
            'description' => $data['description'],
            'image' => $data['image']
       );

       $store = $this->db->insert('categories', $save);

       if($store)
       {
           return true;
       }
       else
       {
           return false;
       }
    }

    public function get_all()
    {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('categories');
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
        $update = array(
            'name'=>$data['name'],
            'image' => $data['image'],
            'description' => $data['description']
        );
        $this->db->where('id', $id);
        $update = $this->db->update('categories', $update);

        if($this->db->affected_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;   
        }
    }

    public function validate_change_cat_name($cat_name, $id)
    {
        //check if no other category uses the name to avoid duplication
        $sql = "select name from categories WHERE id != ? AND name = ?";
        $query = $this->db->query($sql, array($id, $cat_name));
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


    public function destroy($id, $name)
    {
        $this->db->where('id', $id);
        $this->db->delete('categories');

        $update = array(
            'category' => 'uncategorized'
        );

        $this->db->where('category', $name);
        $this->db->update('products', $update);

    }

    public function count_product($name)
    {
        $this->db->where('category', $name);
        return $this->db->count_all_results('products');
    }
}