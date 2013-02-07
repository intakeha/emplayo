<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        session_start();
    }

    public function login()
	{
            //if the user has been authenticated, and has a session, then they should not see the login page again.
            if (isset($_SESSION['username'])){
            redirect('user/home');
        }
            //set up the validation library and rules
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email_address','Email Address','required|valid_email');
            $this->form_validation->set_rules('password','Password','required|min_length[4]');
            //TODO: improve password requirements
            
            if ($this->form_validation->run() !== false){
                //Form validation passed...
                $this->load->model('user_model');
                $res = $this
                        ->user_model
                        ->verify_user($this->input->post('email_address'),  $this->input->post('password'));
                if ($res !== false){
                    //if a row is returned, then it means the validation passed.
                    //Set the session varible.
                    $_SESSION['username']= $this->input->post('email_address');
                    //Redirect them to their user home page.
                    redirect('user/home');
                }
                
            }
            //User has not been authenticated.  Load login view.
            $this->load->view('user/login_view');
	}
        
    public function logout()
    {
        //TODO: improve this.  use unset?
        session_destroy();
        redirect('emplayo');//send them to the main home page of site.
    }
    
    public function home()
    {
        $this->load->view('user/home_view');

    }    
    
    public function signup()
    {
            //if the user has been authenticated, and has a session, then they should not see the signup page again.
            if (isset($_SESSION['username'])){
            redirect('user/home');
        }
            //set up the validation library and rules
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email_address','Email Address','required|valid_email');
            $this->form_validation->set_rules('password','Password','required|min_length[4]');
            //TODO: improve password requirements
            
            if ($this->form_validation->run() !== false){
                //Form validation passed...
                $this->load->model('user_model');
                $res = $this
                        ->user_model
                        ->register_user($this->input->post('email_address'),  $this->input->post('password'));
                if ($res !== false){
                    //if a row is returned, then it means the validation passed.
                    //Set the session varible.
                    $_SESSION['username']= $this->input->post('email_address');
                    //Redirect them to their user home page.
                    redirect('user/home');
                }
                
            }
            //User has not been authenticated.  Load login view.
            $this->load->view('user/login_view');        
        
        $this->load->view('user/signup_view');
    }
    
    public function forgot()
    {
        $this->load->view('user/forgot_view');
    }    
}

