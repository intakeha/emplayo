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
        /*04*/  $this->form_validation->set_rules('user_benefits[]', 'Benefits', 'required');
        /*05*/  $this->form_validation->set_rules('user_citizenship', 'Corporate Citizenship', 'required|greater_than[0]|less_than[6]');
        /*06*/  $this->form_validation->set_rules('user_travel', 'Travel', 'required|greater_than[0]|less_than[6]');
        /*07*/  $this->form_validation->set_rules('user_responsibilities', 'Responsibilities', 'required|greater_than[0]|less_than[5]');
        /*08*/  $this->form_validation->set_rules('user_promotion', 'Promotion', 'required');
        /*09*/  $this->form_validation->set_rules('user_environment[]', 'Environment', 'required|greater_than[0]|less_than[21]');
        /*10*/  $this->form_validation->set_rules('user_recognition[]', 'Recognition', 'required');
        /*11*/  $this->form_validation->set_rules('user_tasks[]', 'Tasks', 'required');
        /*12*/  $this->form_validation->set_rules('user_communication', 'Communication', 'required|greater_than[0]|less_than[5]');
        /*13*/  $this->form_validation->set_rules('user_resource[]', 'Resource', 'required');
        /*14*/  $this->form_validation->set_rules('user_supervisor', 'Supervisor', 'required|greater_than[0]|less_than[7]');
        /*15*/  $this->form_validation->set_rules('user_leadership', 'Leadership', 'required|greater_than[0]|less_than[4]');
        /*16*/  $this->form_validation->set_rules('user_traits[]', 'Traits', 'required|greater_than[0]|less_than[21]');
        /*17*/  $this->form_validation->set_rules('user_motivation', 'Motivation', 'required|greater_than[0]|less_than[6]');
        /*18a*/  //$this->form_validation->set_rules('user_education', 'Education', 'required');
        /*18b*/  //$this->form_validation->set_rules('user_work', 'Work', 'required');
        /*19*/  //$this->form_validation->set_rules('user_location', 'Location', 'required');
        /*20*/  $this->form_validation->set_rules('user_industry', 'Industry', 'required');

 
        if ($this->form_validation->run() == FALSE){
            //reload the form
            //$this->load->library('ion_auth');
            //$data['title']="Work-Life-Play";
            //$data['content']="pages/_criteria";
            //$this->load->view('canvas', $data);
            $this->load->view("survey/user_tester");
        }
        else {//data is good...process it.
            
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
                /*18a*/$user_education = $this->input->post('user_education');
                /*18b*/$user_work = $this->input->post('user_work');
                /*19*/$user_location = $this->input->post('user_location');
                /*20*/$user_industry = $this->input->post('user_industry');
                //$categories = $this->input->post('category');//NOT SURE OF THIS NAME!!!                
                //$history = $this->input->post('history'); //NOT SURE OF THIS NAME!!!  
 
                
                //print_r($user_work);
                
                
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
                /*18a*/$this->session->set_userdata('user_education',$user_education);
                /*18b*/$this->session->set_userdata('user_work',$user_work);
                /*19*/$this->session->set_userdata('user_location',$user_location);    
                /*20*/$this->session->set_userdata('user_industry',$user_industry); 
                //$this->session->set_userdata('category',$categories); //NEED TO REVIEW THIS!!
                //$this->session->set_userdata('history',$history); //NEED TO REVIEW THIS!!                
                
                //SEND THE USER ENTERED DATA OFF TO THE MATCHING ALGORITHM
                $data = $this->run_matching_algorithm($user_type,$user_pace,$user_lifecycle,$user_benefits,$user_citizenship,$user_industry,$user_work);
                //$data VAR IS AN ARRAY THAT CONTAINS LIST OF COMPANIES WITH ALL REQUIRED INFO TO DISPLAY
                
                if ($data['company_count']>0)
                {
                    //WE FOUND MATCHES! DISPLAY THE VIEW
                    $data['title']="Preview Results";
                    $data['content']="pages/_preview";
                    $this->load->view('canvas', $data);
                }
                else
                {
                    //THERE WERE NO MATCHES...DISPLAY THE VIEW
                    //$data['company_count'] = 0;
                    $data['title']="Preview Results";
                    $data['content']="pages/_preview";
                    $this->load->view('canvas', $data);
                }
            }
        }
    } //end of index()

    public function run_matching_algorithm($user_type,$user_pace,$user_lifecycle,$user_benefits,$user_citizenship,$user_industry,$user_work){
        
        $this->load->model('preview_model');

        //FIND COMPANIES THAT MATCH THE USER'S INDUSTRY CHOICE
        $comps_by_industry = $this->preview_model->industry_filter($user_industry);
        //print_r($comps_by_industry);
        if (!empty($comps_by_industry))
        {
            //FIND COMPANIES THAT MATCH THE USER'S BASIC CRITERIA
            $basic_criteria_list = $this->preview_model->toggle_filters($comps_by_industry,$user_type,$user_pace,$user_lifecycle);

            if (!empty($basic_criteria_list))
            {
                //RANK THE COMPANIES BY THEIR BENEFITS
                $benefit_scoring = $this->preview_model->benefits_scoring($basic_criteria_list,$user_benefits);

                //GET USER'S PREVIOUS JOB TYPE IDs
                $prev_job_types = $this->preview_model->prev_job_types($user_work);
                if (!empty($prev_job_types)){
                    //SCORE THE COMPANIES BASED ON WHETHER THEY HAVE A JOB TYPE THAT MATCHES THE USER'S HISTORY
                    $history_scoring = $this->preview_model->history_scoring($basic_criteria_list,$prev_job_types);
                }
                //SCORE THE COMPANIES USING KNN METHOD
                $ranked_results = $this->preview_model->get_distance_matrix3($benefit_scoring,$history_scoring,$user_citizenship,$user_pace,$user_lifecycle,$prev_job_types);

                //TRANSLATE THE RESULTS INTO 'FIT SCORES', WITH 100% OR 1.0 BEING PERFECT
                $company_fit = $this->preview_model->fit_score($ranked_results);
                $company_fit = $company_fit;

                //COUNT THE NUMBER OF COMPANIES IN THE LIST
                $company_count = count($ranked_results);
                $image_path = "assets/images/company_logos/";

                //WRITE THE FIT DATA TO THE SESSION FOR USE IF THE USER SIGNS UP
                $this->session->set_userdata('company_fit',$company_fit);

                //SET A FLAG SO WE KNOW TO SAVE THE USER'S DATA IF THEY SIGN UP
                $this->session->set_userdata('save_data',TRUE);       

                //RETURN THE FIRST 5 COMPANIES FOR THE PREVIEW.  get_company2 returns the full list...
                $company_info = $this->preview_model->get_company3($ranked_results);
                $full_company_info = $this->preview_model->merge_company_info($company_info,$company_fit); 
                
                $match_data = array();
                $match_data['company_count']   = $company_count;
                $match_data['full_company_info']   = $full_company_info;
                $match_data['image_path']   = $image_path;
                
                return $match_data;                    
            }
            else 
            {
                $match_data = array();
                $match_data['company_count']   = 0;
                $match_data['full_company_info']   = NULL;
                $match_data['image_path']   = $image_path;
                
                return $match_data;                     
            }
        }
        else 
        {
            $match_data = array();
            $match_data['company_count']   = 0;
            $match_data['full_company_info']   = NULL;
            $match_data['image_path']   = $image_path;

            return $match_data;                     
        }        
        
    }//end of run_matching_algorithm
    
    
    public function user_tester(){
        //get list of categories from database
        $this->load->model('survey_model');
        $data['categories'] = $this->survey_model->get_categories();
        $data['message'] = '';
        $this->load->view("survey/user_tester",$data);
        //$this->load->view("survey/newload",$data);
    }     
    
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
