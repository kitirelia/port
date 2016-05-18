<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->output->set_header('Access-Control-Allow-Origin: *');
		$this->load->helper(array('html','file','form','url'));
		$this->load->model("Port_model","db_model");
		//$this->load->model("Insta_model","hey");
	}

	public function index()
	{
		if(!$this->session->userdata('logged')){
			echo "GUEST VIEW";
			$feed_data = $this->db_model->fetch_new_feed('-1');
			$data_pack['result']= array(
					'user_data'=>array(),
					'content_data'=>$feed_data
					);
			$this->load->view('view_gen_head');
			//$this->load->view("view_login_form");
			$this->load->view('view_nav_user_bar');
			$this->load->view('view_new_feed',$data_pack);
			//$this->load->view("view_logout");
			$this->load->view('view_gen_footer');
			//$this->go_loginpage();
		}else{
			if(!$this->session->userdata('logged')){

			}else{
				//echo "ELSE CASE";
			$data = $this->session->userdata;
			//print_r($data);
			if(isset($data['res']['uid'])){
				$data['uid'] =$data['res']['uid'];
			}else if(!isset($data['res']['uid'])){
				$data['uid'] =$data['uid'];
			}
			
			//echo "uid is ";
			$feed_data = $this->db_model->fetch_new_feed($data['uid']);
				//echo "is admin ".$data['user_stat']."<br>";
				$data_pack['result']= array(
					'user_data'=>$data,
					'content_data'=>$feed_data
					);
				if($data['user_stat']!='admin'){
					$this->load->view("view_logout");
					$this->load->view('view_gen_head');
					$this->load->view('view_nav_user_bar');
					$this->load->view('view_form_upload');
					$this->load->view('view_new_feed',$data_pack);
					$this->load->view("view_logout");
					$this->load->view('view_gen_footer');
				}else if($data['user_stat']==='admin'){
					$this->load->view("view_logout");
					$this->load->view('view_gen_head');
					$this->load->view('view_admin_feed',$data_pack);
					
					$this->load->view('view_gen_footer');
				}
			}
		}
	}
	public function go_loginpage(){
		$this->load->view("view_gen_head");
		$this->load->view("view_login_form");
		$this->load->view("view_gen_footer");
	}
}

