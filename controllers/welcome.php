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
			echo "Not login";
			//$this->show_login();
		}else{
			echo "Redirect to feed";
			//$this->new_feed();
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */