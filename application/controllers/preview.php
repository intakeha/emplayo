<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Preview extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->helper('url');

		// Load MongoDB library instead of native db driver if required
		$this->config->item('use_mongodb', 'ion_auth') ?
		$this->load->library('mongo_db') :
		$this->load->database();
                $this->load->model('survey_model');                

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
	}
	/*
	public function index(){
		$data['title']="Preview Results";
		$data['content']="pages/_preview";
		$this->load->view('canvas', $data);
	}*/

    public function index(){
        
        $this->load->library("form_validation");
        
        //Form Validation...need to flesh this out. http://stackoverflow.com/a/5843435/1011500

/*01*/  $this->form_validation->set_rules('user_type[]', 'Company Type', 'required|greater_than[0]|less_than[5]');
/*02*/  $this->form_validation->set_rules('user_pace[]', 'Company Pace', 'required|greater_than[0]|less_than[4]');
/*03*/  $this->form_validation->set_rules('user_lifecycle[]', 'Company Lifecycle', 'required|greater_than[0]|less_than[6]');
/*04*/  $this->form_validation->set_rules('user_benefits[]', 'Benefits', 'required|greater_than[0]|less_than[17]');
/*05*/  $this->form_validation->set_rules('user_citizenship', 'Corporate Citizenship', 'required|greater_than[0]|less_than[6]');
/*06*/  $this->form_validation->set_rules('user_travel', 'Travel', 'required|greater_than[0]|less_than[6]');
/*07*/  $this->form_validation->set_rules('user_responsibilities', 'Responsibilities', 'required|greater_than[0]|less_than[5]');
/*08*/  $this->form_validation->set_rules('user_promotion', 'Promotion', 'required|greater_than[0]|less_than[7]');
/*09*/  $this->form_validation->set_rules('user_environment', 'Environment', 'required|greater_than[0]|less_than[3]');
/*10*/  $this->form_validation->set_rules('user_recognition', 'Recognition', 'required|greater_than[0]|less_than[7]');
/*11*/  $this->form_validation->set_rules('user_tasks', 'Tasks', 'required|greater_than[0]|less_than[7]');
/*12*/  $this->form_validation->set_rules('user_communication', 'Communication', 'required|greater_than[0]|less_than[5]');
/*13*/  $this->form_validation->set_rules('user_resource', 'Resource', 'required|greater_than[0]|less_than[6]');
/*14*/  $this->form_validation->set_rules('user_supervisor', 'Supervisor', 'required|greater_than[0]|less_than[7]');
/*15*/  $this->form_validation->set_rules('user_leadership', 'Leadership', 'required|greater_than[0]|less_than[4]');
/*16*/  $this->form_validation->set_rules('user_traits[]', 'Traits', 'required|greater_than[0]|less_than[21]');
/*17*/  $this->form_validation->set_rules('user_motivation', 'Motivation', 'required|greater_than[0]|less_than[6]');
//etc...
        
        if ($this->form_validation->run() == FALSE){
            //reload the form
            $this->load->library('ion_auth');
            $data['title']="Work-Life-Play";
            $data['content']="pages/_criteria";
            $this->load->view('canvas', $data);
            
        } else {//data is good...process it.
            
            if($this->input->post('mysubmit')){
                
                /*01*/$user_type = $this->input->post('user_type');
                /*02*/$user_pace = $this->input->post('user_pace');
                /*03*/$user_lifecycle = $this->input->post('user_lifecycle');
                /*04*/$user_benefits = $this->input->post('user_benefits');
                /*05*/$user_citizenship = $this->input->post('user_citizenship');
                /*06*/$user_travel = $this->input->post('user_travel');
                /*07*/$user_responsibilities = $this->input->post('user_responsibilities');
                /*08*/$user_promotion = $this->input->post('user_promotion');
                /*09*/$user_environment = $this->input->post('user_environment');
                /*10*/$user_recognition = $this->input->post('user_recognition');
                /*11*/$user_tasks = $this->input->post('user_tasks');
                /*12*/$user_communication = $this->input->post('user_communication');
                /*13*/$user_resource = $this->input->post('user_resource');
                /*14*/$user_supervisor = $this->input->post('user_supervisor');
                /*15*/$user_leadership = $this->input->post('user_leadership');
                /*16*/$user_traits = $this->input->post('user_traits');
                /*17*/$user_motivation = $this->input->post('user_motivation');
                $categories = $this->input->post('user_next');//NOT SURE OF THIS NAME!!!                
                $history = $this->input->post('user_history'); //NOT SURE OF THIS NAME!!!                
                
                //TODO: MAKE SURE WE MAKE WORK AND EDUCATION HISTORY OPTIONAL!
                //TODO: FIX THESE NAMES ASSIGNED TO THE SESSION AND EVERYWHERE ELSE THEY MAY BE USED:
                //
                //let's save all the submitted data to the session so we can get it later if the user decides to sign up
                
                /*01*/$this->session->set_userdata('user_type',$user_type);
                /*02*/$this->session->set_userdata('user_pace',$user_pace);
                /*03*/$this->session->set_userdata('user_lifecycle',$user_lifecycle);
                /*04*/$this->session->set_userdata('user_benefits',$user_benefits);
                /*05*/$this->session->set_userdata('user_citizenship',$user_citizenship);
                /*06*/$this->session->set_userdata('user_travel',$user_travel);
                /*07*/$this->session->set_userdata('user_responsibilities',$user_responsibilities);
                /*08*/$this->session->set_userdata('user_promotion',$user_promotion);
                /*09*/$this->session->set_userdata('user_environment',$user_environment);
                /*10*/$this->session->set_userdata('user_recognition',$user_recognition);
                /*11*/$this->session->set_userdata('user_tasks',$user_tasks);
                /*12*/$this->session->set_userdata('user_communication',$user_communication);
                /*13*/$this->session->set_userdata('user_resource',$user_resource);
                /*14*/$this->session->set_userdata('user_supervisor',$user_supervisor);
                /*15*/$this->session->set_userdata('user_leadership',$user_leadership);
                /*16*/$this->session->set_userdata('user_traits',$user_traits);
                /*17*/$this->session->set_userdata('user_motivation',$user_motivation);
                $this->session->set_userdata('category',$categories); //NEED TO REVIEW THIS!!
                $this->session->set_userdata('history',$history); //NEED TO REVIEW THIS!!                
                
                //$this->session->set_userdata('company_pace',$user_pace);
                //$this->session->set_userdata('corp_citizenship',$user_citizenship);               
                //$this->session->set_userdata('lifecycle',$user_lifecycle);

                $this->load->model('preview_model');

                //get initial list of companies that match basic criteria
                $data['company_list'] = $this->preview_model->survey_filter2($categories);
                if (!empty($data['company_list']))
                {
                    //send this list of companies to the next filter to reduce based on type
                    $data['company_list'] = $this->preview_model->toggle_filters($data['company_list']);
                    
                    //TODO: Need to put a conditional statement on each of these steps....
                    
                    //using initial list of companies, rank them based on their benefits
                    $benefit_scoring = $this->preview_model->benefits_scoring($data['company_list']);
                    $history_scoring = $this->preview_model->history_scoring($data['company_list']);
                    
                    //based on these benefits scores, go grab the citizenship scores, and find
                    //nearest neighbor, in ranked order

                    //$data['ranked_results'] = $this->preview_model->get_distance_matrix3($benefit_scoring,$history_scoring);
                    $data = $this->preview_model->get_distance_matrix3($benefit_scoring,$history_scoring);

                    //translate the distance info into 'fit' scores, based on 100% being perfect
                    $data['company_fit'] = $this->preview_model->fit_score($data['ranked_results']);
                    $company_fit = $data['company_fit'];
                    $data['company_count'] = count($data['ranked_results']);
                    $data['image_path'] = "assets/images/company_logos/";
                    
                    //write the fit data to the session in case the user decides to sign up, so we can save it
                    $this->session->set_userdata('company_fit',$company_fit);
                    
                    //set a flag so we know to save this user's data if they sign up
                    $this->session->set_userdata('save_data',TRUE);       
                    
                    //now that we have the ranked companies, let's go get their info, so we can display it 
                    //to the user
                    //$data['company_info'] = $this->preview_model->get_company2($data['ranked_results']);
                    
                    //using get_company3 to only return 5 compamies.  get_company2 returns the full list...
                    $data['company_info'] = $this->preview_model->get_company3($data['ranked_results']);
                    $data['full_company_info'] = $this->preview_model->merge_company_info($data['company_info'],$data['company_fit']);
                    
                    //$data['result_msg'] = 'Success!';
                    //$this->load->view("survey/results",$data); 
                    
                    //just a quick test to make sure we can save the data correctly.  
                    //Remove this:
                    //$this->load->model('home_model');
                    //$result2 = $this->home_model->save_user_inquiry();
                    
                    $data['title']="Preview Results";
                    $data['content']="pages/_preview";
                    $this->load->view('canvas', $data);                    
                    
                } 
                 else {
                    //result set is empty
                    //$data['result_msg'] = 'there were no results!';
                    //$this->load->view("survey/results",$data);
                     echo "there were no results!";
                 }
                
            }
        }
    } //end of submit()
    
    public function insert_matches(){
        //echo "i'm saving you data!";
        //$result = $this->preview_model->save_user_inquiry();
        
        $company_fit = $this->session->userdata('company_fit');

        if (!empty($company_fit)){
            $result = $this->preview_model->insert_matches($company_fit);
            if ($result){
                echo "success!";
            }
            else {
                echo "failure :-(";
            }
        }
        else {
            //return error
       
        }
        
    }        
    
        
}
