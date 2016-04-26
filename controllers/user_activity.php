<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

class User_activity extends CI_Controller{
		
	public function __construct(){
		parent::__construct();
		$this->load->model("Port_model","db_model");
		$this->load->helper(array('html','file','form','url'));
		$this->load->library('form_validation',NULL,'F');

	}

	public function user_login(){
		
		 $this->F->set_rules('email', 'HeyEmail', 'trim|valid_email|required');
		 $this->F->set_rules('password', 'Hey debug', 'trim|required');
		if($this->F->run()==TRUE){
			//echo "checking..";
			$data=array(
				'email'=>$this->input->post('email'),
				'password'=>$this->input->post('password')
				);
			$data=$this->db_model->check_account_exist($data);
			//print_r($data['res']);
			if($data['stat']>0){
				$data['logged']=TRUE;
				$this->session->set_userdata($data);
				$this->load->view('view_gen_head');
				$this->load->view('view_form_upload');
				$this->load->view('view_new_feed',$data);
				$this->load->view("view_logout");
				$this->load->view('view_gen_footer');
			}else{
				echo "not found";
				$data['logged']=FALSE;
				$this->load->view('view_gen_head');
				$this->load->view('view_login_form',$data);
				$this->load->view('view_gen_footer');
				//echo "Some thing went wrong";
			}
		}else{
			echo "Wrong rulese";
		}
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
	public function logout(){
		$this->session->sess_destroy();
		redirect('/welcome'.'/?logout=aenxwe');
	}
	
	public function go_page_regis_member(){
		$this->load->view('view_user_register');
	}

	public function do_upload(){
		$config['upload_path'] = './uploads/origin/';
		$config['allowed_types'] = 'jpg|png';
		$config['max_size']	= '1024000';
		$config['file_name'] = time()."_".$this->_random_string(10);
		$this->load->library('upload', $config);
		
	}// end do_upload()
	function _random_string($length) {
	    $key = '';
	    $keys = array_merge(range(0, 9), range('a', 'z'));
	    for ($i = 0; $i < $length; $i++) {
	        $key .= $keys[array_rand($keys)];
	    }
	    return $key;
	}//end _random_string()
}