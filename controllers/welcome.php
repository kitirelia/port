<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('html','file','form','url'));
		//$this->load->model("Insta_model","hey");
	}

	public function index()
	{
		//$this->load->view('welcome_message');
		if(!$this->session->userdata('logged')){
			//echo "revision 32";
			//echo "Git3 revision two Not login";
			//$this->show_login();
			$this->go_loginpage();
		}else{
			echo "have sessioni redirect";
			$this->load->view('view_gen_head');
			$this->load->view('view_form_upload');
			$this->load->view('view_new_feed');
			$this->load->view("view_logout");
			$this->load->view('view_gen_footer');
		}
	}
	public function go_loginpage(){
		$this->load->view("view_gen_head");
		$this->load->view("view_login_form");
		$this->load->view("view_gen_footer");
	}
}

