<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Survey extends CI_Controller {
    public function load(){
        //get list of categories from database
        $this->load->model('survey_model');
        $data['categories'] = $this->survey_model->get_categories();
        $data['message'] = '';
        $this->load->view("survey/load",$data);
        //$this->load->view("survey/newload",$data);
    }

        public function submit2(){
            //validation required?
            //find all the companies that match the submitted 'tags'
            $categories = $this->input->post('category');
            $history = $this->input->post('history');
            /*
            echo '<pre>';
            print_r($categories);
            echo '</pre>';
            */
            
            $this->load->model('survey_model');
            $data['category_tags'] = $this->survey_model->match_tags($categories);
            
            $this->load->view("survey/newresults",$data);
        }
    
    public function submit(){
        $this->load->library("form_validation");
        $this->form_validation->set_rules('company_type[]', 'Company Type', 'required');
        $this->form_validation->set_rules('users_benefits[][]', 'Benefits', 'required');
        
        if ($this->form_validation->run() == FALSE){
            //reload the form
            $data['message'] = '';
            $this->load->view("survey/load",$data);
            
        } else {//data is good...process it.
            //$data['message'] = 'The information has been submitted!';
            //$data['message'] = $this->input->post('company_type');

            //print_r($this->input->post());
            
            //$user_benefits_array = $this->input->post('users_benefits');
            
            if($this->input->post('mysubmit')){
                
                $this->load->model('survey_model');
                //$this->survey_model->insert_survey();
                
                //$this->load->view("survey/results",$data);
                
               // $data['matches'] = $this->survey_model->match_survey();
                
                //get initial list of companies that match basic criteria
                //$data['company_list'] = $this->survey_model->survey_filter();
                $categories = $this->input->post('category');
                $data['company_list'] = $this->survey_model->survey_filter2($categories);
                if (!empty($data['company_list']))
                {
                    //send this list of companies to the next filter to reduce based on type
                    $data['company_list'] = $this->survey_model->toggle_filters($data['company_list']);
                    
                    
                    //using initial list of companies, rank them based on their benefits
                    $benefit_scoring = $this->survey_model->benefits_scoring($data['company_list']);
                    $history_scoring = $this->survey_model->history_scoring($data['company_list']);
                    
                    //based on these benefits scores, go grab the citizenship scores, and find
                    //nearest neighbor, in ranked order
                    //$data['ranked_results'] = $this->survey_model->get_distance_matrix($benefit_scoring);
                    $data['ranked_results'] = $this->survey_model->get_distance_matrix3($benefit_scoring,$history_scoring);

                    //translate the distance info into 'fit' scores, based on 100% being perfect
                    $company_fit = $this->survey_model->fit_score($data['ranked_results']);
                    
                    //now that we have the ranked companies, let's go get their info, so we can display it 
                    //to the user
                    $data['company_info'] = $this->survey_model->get_company2($data['ranked_results']);
                    $data['full_company_info'] = $this->survey_model->merge_company_info($data['company_info'],$company_fit);
                    
                    $data['result_msg'] = 'Success!';
                    $this->load->view("survey/results",$data);    
                } 
                 else {
                    //result set is empty
                    $data['result_msg'] = 'there were no results!';
                    $this->load->view("survey/results",$data);
                 }
                
                /*
                //get company details and load them into the view
                if (!empty($data['matches']))
                {
                    $data['company_info'] = $this->survey_model->get_company($data['matches']);
                    $this->load->view("survey/results",$data);
                } else {
                    //result set is empty
                    $data['result_msg'] = 'there were no results!';
                    $this->load->view("survey/results",$data);
                }
                */
                
                //$data['company_info'] = $this->survey_model->get_company($data['matches']);
                //$this->survey_model->get_distance_matrix($data['company_info']);
                /*
                if (!empty($data['matches']))
                {
                    $data['ranked_results'] = $this->survey_model->get_distance_matrix($data['matches']);
                    $data['company_info'] = $this->survey_model->get_company2($data['ranked_results']);
                    $this->load->view("survey/results",$data);                    
                    
                                        
                } else {
                    //result set is empty
                    $data['result_msg'] = 'there were no results!';
                    $this->load->view("survey/results",$data);
                }                
                */
                
            }
        }
    } 
}
