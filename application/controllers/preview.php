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
                $this->load->model('preview_model');

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
        /*19*/  $this->form_validation->set_rules('user_location', 'Location', 'required');
        /*20*/  $this->form_validation->set_rules('user_industry', 'Industry', 'required');

 
        if ($this->form_validation->run() == FALSE){
            //print_r( $this->form_validation->error_array() );
            //Log this error
            $this->load->library('user_agent');
            $user_agent = $this->agent->agent_string();
            $error_array = json_encode($this->form_validation->error_array());
            $all_post = json_encode($this->input->post());
            log_message('error', 'START ERROR');
            log_message('error', 'User Agent: '.$user_agent);
            log_message('error', 'Form Validation FAILED on preview controller: '.$error_array);
            log_message('error', 'Submitted data: '.$all_post);
            log_message('error', 'END ERROR');
            
            //reload the form
            $this->load->library('ion_auth');
            $data['message']="There was an unexpected error with your submission.  Please try again.  We apologize for any inconvenience.";
            $data['title']="Work-Life-Play";
            $data['content']="pages/_criteria";
            $this->load->view('canvas', $data);
        }
        else {//data is good...process it.
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
            
            //DETERMINE IF USER EDUCATION AND WORK ARE POPULATED OR EMPTY...
            $education_exists = $this->preview_model->validate_education_array($user_education);
            $work_exists = $this->preview_model->validate_work_array($user_work);
            
            if (!$education_exists)
            {
                $user_education = NULL;
            } 
            
            if (!$work_exists) 
            {
                $user_work = NULL;
            }

                                  
            /*19*/$user_location = $this->input->post('user_location');
            /*20*/$user_industry = $this->input->post('user_industry');
            //$categories = $this->input->post('category');//NOT SURE OF THIS NAME!!!                
            //$history = $this->input->post('history'); //NOT SURE OF THIS NAME!!!  

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
            $data = $this->run_matching_algorithm2($user_type,$user_pace,$user_lifecycle,$user_benefits,$user_citizenship,$user_industry,$user_work);
            //$data VAR IS AN ARRAY THAT CONTAINS LIST OF COMPANIES WITH ALL REQUIRED INFO TO DISPLAY

            //Ideally, we should always have something to display.  Need to figure out what to show
            //in the event the match count is very low, or the scores are not 
            //that great. Maybe tell them that there were not any good matches,
            //but ...

            if ($data['company_count']>0)
            {
                //WE FOUND MATCHES! DISPLAY THE VIEW
                $data['title']="Preview Results";
                $data['content']="pages/_preview";
                $this->load->view('canvas', $data);
            }
            else
            {
                //THERE WERE NO MATCHES...DISPLAY THE VIEW, and pass company_count data
                //$data['company_count'] = 0;
                $data['title']="Preview Results";
                $data['content']="pages/_preview";
                $this->load->view('canvas', $data);
            }
        }
    } //end of index()

    public function run_matching_algorithm($user_type,$user_pace,$user_lifecycle,$user_benefits,$user_citizenship,$user_industry,$user_work){
        
        $this->load->model('preview_model');
        $image_path = './'.COMPANY_LOGO_PATH;

        //FIND COMPANIES THAT MATCH THE USER'S INDUSTRY CHOICE
        //BLC 06-25-13: We should use scoring instead of filtering.  Perhaps do a scoring
        //system for industry similar to what we're currently doing for history_scoring
        $comps_by_industry = $this->preview_model->industry_filter($user_industry);
        //print_r($comps_by_industry);
        if (!empty($comps_by_industry))
        {
            //FIND COMPANIES THAT MATCH THE USER'S BASIC CRITERIA
            //$basic_criteria_list = $this->preview_model->toggle_filters($comps_by_industry,$user_type,$user_pace,$user_lifecycle);
            
            //6-30-13 created dummy filter to eliminate filtering temporarily.  Remove this later to save on db trips.
            $basic_criteria_list = $this->preview_model->toggle_filters_dummy($comps_by_industry,$user_type,$user_pace,$user_lifecycle);

            if (!empty($basic_criteria_list))
            {
                //RANK THE COMPANIES BY THEIR BENEFITS
                $benefit_scoring = $this->preview_model->benefits_scoring($basic_criteria_list,$user_benefits);

                //GET USER'S PREVIOUS JOB TYPE IDs
                $prev_job_ids = $this->preview_model->prev_job_ids($user_work);
                if (!empty($prev_job_ids)){
                    //SCORE THE COMPANIES BASED ON WHETHER THEY HAVE A JOB TYPE THAT MATCHES THE USER'S HISTORY
                    $history_scoring = $this->preview_model->history_scoring($basic_criteria_list,$prev_job_ids);
                    //echo "<br>history scoring elements: ".count($history_scoring);
                    //echo '<br><pre>history scoring:<br>',print_r($history_scoring,1),'</pre>';                    
                    $type_scoring = $this->preview_model->type_scoring($basic_criteria_list,$user_type);
                    //echo "<br>type scoring elements: ".count($type_scoring);     
                    //echo '<br><pre>type scoring:<br>',print_r($type_scoring,1),'</pre>';                            
                }
                //SCORE THE COMPANIES USING KNN METHOD
                $ranked_results = $this->preview_model->get_distance_matrix3($benefit_scoring,$history_scoring,$user_citizenship,$user_pace,$user_lifecycle,$prev_job_ids);

                //TRANSLATE THE RESULTS INTO 'FIT SCORES', WITH 100% OR 1.0 BEING PERFECT
                $company_fit = $this->preview_model->fit_score($ranked_results);
                $company_fit = $company_fit;

                //COUNT THE NUMBER OF COMPANIES IN THE LIST
                $company_count = count($ranked_results);
                

                //WRITE THE FIT DATA TO THE SESSION FOR USE IF THE USER SIGNS UP
                $this->session->set_userdata('company_fit',$company_fit);

                //SET A FLAG SO WE KNOW TO SAVE THE USER'S DATA IF THEY SIGN UP
                $this->session->set_userdata('save_data',TRUE);       

                //RETURN THE FIRST 5 COMPANIES FOR THE PREVIEW.  get_company2 returns the full list...
                //should make the limit value a variable and pass it from here (right now 5 is hardcoded in the model)
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
 
    public function run_matching_algorithm2($user_type,$user_pace,$user_lifecycle,$user_benefits,$user_citizenship,$user_industry,$user_work){
        
        $this->load->model('preview_model');
        $image_path = './'.COMPANY_LOGO_PATH;

        //6-30-13 created dummy filter to eliminate filtering temporarily.  Remove this later to save on db trips.
        $comps_by_industry = $this->preview_model->industry_filter_dummy($user_industry);
        $basic_criteria_list = $this->preview_model->toggle_filters_dummy($comps_by_industry,$user_type,$user_pace,$user_lifecycle);
        
        //SCORE THE COMPANIES BY THEIR BENEFITS, TYPE, and INDUSTRY
        $benefit_scoring = $this->preview_model->benefits_scoring($basic_criteria_list,$user_benefits);            
        $type_scoring = $this->preview_model->type_scoring($basic_criteria_list,$user_type);
        $industry_scoring = $this->preview_model->industry_scoring($basic_criteria_list,$user_industry);

        $ranked_results = $this->preview_model->get_distance_matrix4($benefit_scoring,$user_citizenship,$user_pace,$user_lifecycle,$user_industry,$user_type,$type_scoring,$industry_scoring);

        //TRANSLATE THE RESULTS INTO 'FIT SCORES', WITH 100% OR 1.0 BEING PERFECT
        $company_fit = $this->preview_model->fit_score($ranked_results);
        $company_fit = $company_fit;

        //COUNT THE NUMBER OF COMPANIES IN THE LIST
        $company_count = count($ranked_results);


        //WRITE THE FIT DATA TO THE SESSION FOR USE IF THE USER SIGNS UP
        $this->session->set_userdata('company_fit',$company_fit);

        //SET A FLAG SO WE KNOW TO SAVE THE USER'S DATA IF THEY SIGN UP
        $this->session->set_userdata('save_data',TRUE);       

        //RETURN THE FIRST 5 COMPANIES FOR THE PREVIEW.  get_company2 returns the full list...
        $company_info = $this->preview_model->get_company3($ranked_results,12);
        $full_company_info = $this->preview_model->merge_company_info($company_info,$company_fit); 

        $match_data = array();
        $match_data['company_count']   = $company_count;
        $match_data['full_company_info']   = $full_company_info;
        $match_data['image_path']   = $image_path;

        return $match_data;                           
        
    }//end of run_matching_algorithm    
    
    
    public function user_tester(){
        //get list of categories from database
        $this->load->model('survey_model');
        $data['categories'] = $this->survey_model->get_categories();
        $data['message'] = '';
        $this->load->view("survey/user_tester",$data);
        //$this->load->view("survey/newload",$data);
    }     
    
    
        
}
