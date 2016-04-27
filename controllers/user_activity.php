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
				$feed_data = $this->db_model->fetch_new_feed($data['uid']);
				//echo "control";
				//print_r($feed_data);
				$data_pack['result']= array(
					'user_data'=>$data,
					'content_data'=>$feed_data
					);

				$this->load->view('view_gen_head');
				$this->load->view('view_form_upload');
				$this->load->view('view_new_feed',$data_pack);
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

	public function upload_image(){
		$config['upload_path'] = './uploads/fullsize/';
		$config['allowed_types'] = 'jpg|png';
		$config['max_size']	= '1024*10';
		$config['file_name'] = time()."_".$this->_random_string(10);
		$this->load->library('upload', $config);

		///echo "time debug ".$this->input->post('debug_time');
		$user_timer = $this->input->post('debug_time');
		//echo "incoming time ".strlen($user_timer);
		if(strlen($user_timer)>0){
			echo "FLASH TIME|".$user_timer."|";
		}
		else{
			$user_timer=time();
			echo "server time";
		}
		echo "-------------------";
		if(! $this->upload->do_upload()){
			$error = array('error' => $this->upload->display_errors());
			print_r($error);
		}else{
			echo "allow upload<br/>";
			$data = array(
				'upload_data' => $this->upload->data(),
				'email' => $this->input->post('email'),
				'uid' => $this->input->post('uid'),
				'caption' => $this->input->post('caption')
			);
			$data['image_name']=$data['upload_data']['file_name'];

			//------------- make thumb
			$new_widht=($data['upload_data']['image_width'])*(320/$data['upload_data']['image_height']);
			$config1 = array(
		      'source_image' => $data['upload_data']['full_path'], //get original image
		      'new_image' => './uploads/thumb/', //save as new image //need to create thumbs first
		      'maintain_ratio' => true,
		      'height' => 320,
		      'width' => $new_widht
		    );
		     $this->load->library('image_lib', $config1); //load library
    		 $this->image_lib->resize(); //generating thumb
    		 if (!$this->image_lib->resize()) {
		        echo $this->image_lib->display_errors();
		    }
		    // clear //
		    $this->image_lib->clear();
		    //echo "thumb success";
			//-------- add general conten------
			if($data['upload_data']['is_image']==1){
				$mime_type="image";
			}else{
				$mime_type="video";
			}
			//echo "mime is ".$mime_type;
		    $addData = array(
		    	'user_id'=>$data['uid'],
		    	'caption'=>$data['caption'],
		    	'file_name'=>$data['image_name'],
		    	'mime_type'=>$mime_type,
		    	'create_date'=>$user_timer
		    );
		    //print_r($addData);
			$content_id = $this->db_model->addSingle_content($addData);
			echo "Success content id ".$content_id['uid'].'<br/>';
			//echo "----------- check hashtag ---------------<br/>";
			//echo $data['caption']."<br/>";
			$hash_arr= $this->_clean_for_hashtag($data['caption']);
			
			if(count($hash_arr)>0){
				//echo "req # id";
				$hash_tag_id_arr = array();
				foreach ($hash_arr as $each_hash) {
					//echo "fet id ".$content_id['uid']."  #".$each_hash."<br/>";
					$_raw_hash_id=$this->db_model->check_hashtag_id($each_hash);
					array_push($hash_tag_id_arr,array(
						'hash_id'=>$_raw_hash_id,
						'content_id'=>$content_id['uid']
						)
					);
					$data = array(
						'content_post_id'=>$content_id['uid'],
						'hashtag_id'=>$_raw_hash_id
						);
					$update_content_detail=$this->db_model->pair_content_and_hashtag($data);
				}
			}else{
				echo "pass #check step";
			}
			//print_r($hash_arr);
			echo "<br>-----------ALL DONE-----------------";
		}//end else do_upload
		
	}// end do_upload()



	//------------------------ helper function 
	function _random_string($length) {
	    $key = '';
	    $keys = array_merge(range(0, 9), range('a', 'z'));
	    for ($i = 0; $i < $length; $i++) {
	        $key .= $keys[array_rand($keys)];
	    }
	    return $key;
	}//end _random_string()
	function _clean_for_hashtag($raw){
		$hash_raw = array();
		$arr0=explode(' ', $raw);
		foreach ($arr0 as $data) {
			if($data!== '' && $data[0]=='#'){
				$data = substr($data,1);	
				$pos = strpos($data, '#');
				if($pos>0){
					$inside_clean=explode('#',$data);
					foreach ($inside_clean as $inside_data) {
						if($inside_data!==''){
							$inside_data = clean_spacial_character($inside_data);
							array_push($hash_raw,$inside_data);
						}
					}
				}else{
					//echo "push ".$data.'</br>';
					$data = clean_spacial_character($data);
					array_push($hash_raw,$data);
				}
			}else{
				//echo "wrog data ".$data."|".($data[0])."</br>";
			}
		}
		return $hash_raw;
	}//end _clean_for_hashtag
	function clean_spacial_character($string) {
	   $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
	   $string = preg_replace('~[\r\n]+~', '', $string);
	   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}//end clean_spacial_character
}