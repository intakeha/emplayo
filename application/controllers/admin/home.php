<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//Main controller for all company CRUD functions

class Home extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));        
        $this->load->database();
	
	// Load MongoDB library instead of native db driver if required
	$this->config->item('use_mongodb', 'ion_auth') ?
	$this->load->library('mongo_db') :
	$this->load->database();
		
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin())
        {
                redirect('/login', 'refresh');
        }   
    }
    
    //Listing - displays a list of the companies in the database
    public function index()
    {

	if ($this->ion_auth->logged_in()){
	
		$data['title']="Admin";
		$data['content']="admin/home/_index";
		$this->load->view('canvas', $data);
		$this->session->unset_userdata('message');
		
	}   else {
		$data['title']="Home";
		$data['content']="pages/_home";
		$this->load->view('canvas', $data);
	}




    }
}