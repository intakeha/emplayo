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
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin())
        {
                redirect('/login', 'refresh');
        }   
    }
    
    //Listing - displays a list of the companies in the database
    public function index()
    {
        $this->load->view("admin/home/index");         
    }
}