<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

class User_activity extends CI_Controller{
		
	public function __construct(){
		parent::__construct();
		$this->load->model("Port_model","hey");
		$this->load->helper(array('html','file','form','url'));
		$this->load->library('form_validation',NULL,'F');
	}

	public function regis_member(){
       $this->F->set_rules('email', 'HeyEmail', 'trim|valid_email|required');
       $this->F->set_rules('username', 'Hey debug', 'trim|required');
       $this->F->set_rules('password_0', 'Hey debug', 'trim|required');
       $this->F->set_rules('password_1', 'Hey debug', 'trim|required|matches[password_0]');
      

        if($this->F->run()==TRUE){
        	echo "Regis success<br>";
        	$data = array(
				'u_email' => $this->input->post('email'),
				'password0' => $this->input->post('password_0'),
				'u_username' => $this->input->post('username'),
				'user_stat' =>'user'
			);
        	//$this->load->view('view_user_register');
        }else{
        	echo "invalid<br>";
        }
       echo "<br>Last line";
       
	}
	public function oldpassword_check($old_password){
	   $old_password_hash = md5($old_password);
	   $old_password_db_hash = $this->yourmodel->fetchPasswordHashFromDB();

	   if($old_password_hash != $old_password_db_hash)
	   {
	      $this->form_validation->set_message('oldpassword_check', 'Old password not match');
	      return FALSE;
	   } 
	   return TRUE;
	}
	public function go_page_regis_member(){
		$this->load->view('view_user_register');
	}
}