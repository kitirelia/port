<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

class User_activity extends CI_Controller{
		
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('html','file','form','url'));
	}

	public function regis_member(){
		$this->load->view('view_user_register');
	}
}