<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Survey extends CI_Controller {
    public function load(){
        //echo "hello internets!";
        $data['message'] = '';
        $this->load->view("survey/load",$data);
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
            
            $user_benefits_array = $this->input->post('users_benefits');
            
            if($this->input->post('mysubmit')){
                
                $this->load->model('survey_model');
                //$this->survey_model->insert_survey();
                $data['result_msg'] = 'Success!';
                //$this->load->view("survey/results",$data);
                
                $data['matches'] = $this->survey_model->match_survey();
                
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
                $this->survey_model->get_distance_matrix($data['matches']);
                
            }
        }
    } 
}
