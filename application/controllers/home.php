<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->helper('url');
		$this->load->helper('text');
                $this->load->helper('date');

		// Load MongoDB library instead of native db driver if required
		$this->config->item('use_mongodb', 'ion_auth') ?
		$this->load->library('mongo_db') :
		$this->load->database();
                $this->load->model('home_model');

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
	}

	public function index(){
		
		if ($this->ion_auth->logged_in()){
                    $user_id = $this->session->userdata('user_id');
                    
                    //the login was successful, now check to see if there is 
                    //preference/survey data to save
                    if ($this->session->userdata('save_data') == TRUE)
                    {
                        if ($this->session->userdata('new_user') == TRUE)
                        {
                            //do an INSERT
                            //TODO: Consolidate these two functions into one transaction.
                            //$result = $this->home_model->insert_matches();
                            $result = $this->home_model->save_user_inquiry();

                            if ($result){                     
                                //if the db write is successful, redirect user to the user home page
                                $this->session->set_flashdata('update_message', 'Your preferences have been saved.');
                                $this->session->unset_userdata('save_data');
                                $this->session->unset_userdata('new_user');
                                redirect('/','refresh');
                                /*
                                $data['title']="Home";
                                $data['content']="pages/_home";
                                $this->load->view('canvas', $data); 
                                */
                            } else {
                                $this->session->set_flashdata('update_message', 'There was an error inserting your data. Please try again.');
                                
                                //TODO: we should send them to a page that gives them the option to try again...
                                redirect('inquire','refresh');
                            }
                        }
                        else
                        {
                            //user exists already.  do an UPDATE!
                            //
                            //Check to see if they have already filled out the survey at least once
                            //in order to give them the proper messaging.
                            //user_survey_taken($user_id)
                            $last_survey_date = $this->home_model->user_survey_taken($user_id);
                            if ($last_survey_date){
                                //user has taken the survey before
                                $data['last_survey_date'] = $last_survey_date;
                                $data['title']="Overwrite Confirmation";
                                $data['content']="pages/_overwrite_confirm";
                                $this->load->view('canvas', $data);                                
                                
                            }
                            else {
                                //user has NOT taken the survey before
                                $data['last_survey_date'] = FALSE;
                                $data['title']="Overwrite Confirmation";
                                $data['content']="pages/_overwrite_confirm";
                                $this->load->view('canvas', $data);                                  
                            }

                        }
                    }
                    else
                    {//save_data is FALSE.  load the normal user home view
                        
                        //get the user's match data
                        //$user_id = $this->session->userdata('user_id');
                        $data['matches'] = $this->home_model->get_matches($user_id);
                        $data['image_path'] = './'.COMPANY_LOGO_PATH;

                        $data['title']="Home";
                        $data['content']="pages/_user_home";
                        $this->load->view('canvas', $data);
                        $this->session->unset_userdata('message');//what is this for?          
                    }
			
		}//end of if user is logged in
                else {
			$data['title']="Home";
			$data['content']="pages/_home";
			$this->load->view('canvas', $data);
		}

	}
        
	public function manage_prefs(){
		
            $prefs_action = $this->input->post('prefs_action');

            if ($prefs_action == 1)
            {
                //OVERWRITE THE DATA!
                $result = $this->home_model->update_user_inquiry();
                if ($result)
                {
                    $this->session->set_userdata('save_data',FALSE);
                    $this->home_model->discard_session_prefs();                    
                    $this->session->set_flashdata('update_message', 'Successfully updated preferences.');
                    redirect('/','refresh');
                }
                else 
                {
                    $this->session->set_flashdata('update_message', 'There was an error updating your data. Please try again.');
                    redirect('/','refresh');
                }
            }
            elseif ($prefs_action == 0)
            {
                //DON'T OVERWRITE THE DATA! DISCARD ANY NEW PREFS FROM THE SESSION
                //echo "prefs action is 0";discard_session_prefs
                $this->session->set_userdata('save_data',FALSE);
                $this->home_model->discard_session_prefs();
                $this->session->set_flashdata('update_message', 'No updates were made.');
                redirect('/','refresh');                
            }
            elseif ($prefs_action == 2)
            {
                //FIRST TIME USER ->INSERT!
                //TODO - consolidate these two into one total transaction
                //$result = $this->home_model->insert_matches();
                $result2 = $this->home_model->save_user_inquiry();

                if ($result2)    
                {
                    $this->session->set_userdata('save_data',FALSE);
                    $this->home_model->discard_session_prefs();                    
                    $this->session->set_flashdata('update_message', 'Successfully updated preferences.');
                    redirect('/','refresh');
                }
                else 
                {
                    $this->session->set_flashdata('update_message', 'There was an error updating your data. Please try again.');
                    redirect('/','refresh');
                }           
            }            
            else 
            {
                //all other cases, discard the prefs data in the session
                $this->session->set_userdata('save_data',FALSE);
                $this->home_model->discard_session_prefs();
                $this->session->set_flashdata('update_message', 'No updates were made.');
                redirect('/','refresh');   
            }
            

	}
	        
	
}
