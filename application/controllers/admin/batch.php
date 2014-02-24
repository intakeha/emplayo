<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//Main controller for all company CRUD functions

class Batch extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
	$this->load->helper('url');
	$this->load->helper('text');	
        $this->load->database();
        $this->load->helper('image_functions_helper');
        
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin())
        {
                redirect('/login', 'refresh');
        }        
    }
    
    //Create slugs for each the companies in the database
    function slugs()
    {
	
	if ($this->ion_auth->is_admin()){
		$data['title']="Update Company Slugs";
		$data['content']="admin/company/_slugs";
		$this->load->view('canvas', $data);
		$this->session->unset_userdata('message');
		
	}   else {
		$data['title']="Home";
		$data['content']="pages/_home";
		$this->load->view('canvas', $data);
	}
	
    }
    
    function create_slugs()
    {
	if ($this->ion_auth->is_admin()){
		$this->load->model('admin/batch_model');
		$this->batch_model->update_slugs();
		redirect('/admin/batch/slugs', 'refresh');
	}   else {
		$data['title']="Home";
		$data['content']="pages/_home";
		$this->load->view('canvas', $data);
	}
    }
        

}//end of class
