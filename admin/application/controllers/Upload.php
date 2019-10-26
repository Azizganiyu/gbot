<?php

class Upload extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    public function do_upload()
    {
        //Upload configuration and setting
        $config['upload_path']          = '../uploads/';
        $config['allowed_types']        = '*';
        $config['max_size']             = 131072;
        $config['max_width']            = 0;
        $config['max_height']           = 0;
        $config['max_filename']         = 0;

        //load the upload library with the configuration passes
        $this->load->library('upload', $config);

            //try uploading file, if error display error msg to user
            if ( ! $this->upload->do_upload('userfile'))
            {
                $data['title'] = 'Upload error!';
                $data['error'] = array('error' => $this->upload->display_errors());
                $this->load->view('upload_info', $data);
            }

            //if upload success, process the file and store data in database
            else
            {
                $data = array('upload_data' => $this->upload->data()); //array of uploaded file data

                foreach($data as $details)
                {

                    //define upload path for files
                    $path = site_url.'/uploads/'.$details['file_name'];
                    
                }

    

                $data['error'] = "";
                $data['title'] = $path;
                $this->load->view('upload_info', $data);
            }
    }

}