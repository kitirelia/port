<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

class User_activity extends CI_Controller{
		
	public function __construct(){
		parent::__construct();
		$this->load->model("Port_model","db_model");
		$this->load->helper(array('html','file','form','url'));
		$this->load->library('form_validation',NULL,'F');
	}

	public function regis_member(){
       $this->F->set_rules('email', 'HeyEmail', 'trim|valid_email|required');
       $this->F->set_rules('username', 'Hey debug', 'trim|required');
       $this->F->set_rules('password_0', 'Hey debug', 'trim|required');
       $this->F->set_rules('password_1', 'Hey debug', 'trim|required|matches[password_0]');
      

        if($this->F->run()==TRUE){
        	//echo "Regis success<br>";
        	$time = time();
        	$data = array(
				'email' => $this->input->post('email'),
				'user_name' => $this->input->post('username'),
				'password' => $this->input->post('password_0'),
				'profile_picture'=>'default.jpg',
				'user_stat' =>'user',
				'register_date' =>$time
			);
        	$data["res"]=$this->db_model->register_user($data);
        	//echo "<br>result: ";
        	//print_r($data["res"]);
        	//echo json_encode( $data["res"] );
        	//print_r($data);
        	$this->load->view('view_user_register_result',$data["res"]);
        }else{
        	//echo "Register fail!";
        	$this->load->view('view_user_register');
        }
	}
	
	public function go_page_regis_member(){
		$this->load->view('view_user_register');
	}
}