<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('html','file','form','url'));
		$this->load->model("Port_model","db_model");
		//$this->load->model("Insta_model","hey");
	}

	public function index()
	{
		//$this->load->view('welcome_message');
		if(!$this->session->userdata('logged')){

			$this->go_loginpage();
		}else{
			echo "have sessioni redirect<br>";
			$data = $this->session->userdata;
			
			echo "<br>from index <br>";
			$feed_data = $this->db_model->fetch_new_feed($data['uid']);
				echo "is admin ".$data['user_stat']."<br>";
				$data_pack['result']= array(
					'user_data'=>$data,
					'content_data'=>$feed_data
					);
				if($data['user_stat']!='admin'){
					$this->load->view('view_gen_head');
					$this->load->view('view_form_upload');
					$this->load->view('view_new_feed',$data_pack);
					$this->load->view("view_logout");
					$this->load->view('view_gen_footer');
				}else if($data['user_stat']==='admin'){
					$this->load->view('view_gen_head');
					$this->load->view('view_admin_feed',$data_pack);
					$this->load->view("view_logout");
					$this->load->view('view_gen_footer');
				}
			
		}
	}
	public function go_loginpage(){
		$this->load->view("view_gen_head");
		$this->load->view("view_login_form");
		$this->load->view("view_gen_footer");
	}
}

