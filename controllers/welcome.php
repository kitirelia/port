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
			echo "Git3 revision two Redirect to feed";
			//$this->new_feed();
		}
	}
	public function go_loginpage(){
		$this->load->view("view_user_login");
	}
}

