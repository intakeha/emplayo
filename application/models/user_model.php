<?php
class User_model extends CI_Model {

	public function __construct()
	{
	
	}
	
        public function verify_user($email,$password){
            $q = $this
                    ->db
                    ->where('email_address',$email)
                    ->where('password',sha1($password))
                    ->limit(1)
                    ->get('user');
                    
            if ($q->num_rows>0) {
                return $q->row();

            }
            return false;
        }

}
