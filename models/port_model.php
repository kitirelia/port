<?php
	class Port_model extends CI_Model{
		function _construct(){
			parent::_construct();
			//$this->load->database("test_db",TRUE);
			$this->load->database("port_db",TRUE);
		}

		function check_account_exist($arr){
			$query = $this->db->where('email',$arr['email'])
			->where('password',$arr['password'])
			->get('user_data');
			$callback= $query->result_array();
			$res=$query->num_rows();
			if($res>0){
				$clean=array(
				'stat'=>'1',
				'user_name'=>$callback[0]['user_name'],
				'profile_picture'=>$callback[0]['profile_picture'],
				'email'=>$callback[0]['email'],
				'user_stat'=>$callback[0]['user_stat']
				);
				//echo "<br>found<br>";
				//print_r($clean);
				//echo "<br>------<br>";
			}else if($res<=0){
				$clean=array(
				'stat'=>'-1',
				'user_name'=>'',
				'profile_picture'=>'',
				'email'=>'',
				'user_stat'=>''
				);
				//echo "email or password wrong";
			}
			return $clean;
		}
		function register_user($data){
			$query=$this->db->insert('user_data',$data);
			if(!$query){
				$errNo   = $this->db->_error_number();
   				$errMess = $this->db->_error_message();
   				$data=array(
   					'stat'=>'0',
   					'error_no'=>$errNo ,
   					'error_msg'=>$errMess,
   					'alldone'=>FALSE,
   					'uid'=>-1
   					);
   				//echo "<br>Error ".$errMess;
   				return $data;
			}else{
				$uid =  $this->db->insert_id();
				//echo "UID is ".$uid;
				$data=array(
   					'stat'=>$this->db->affected_rows(),
   					'error_no'=>'-1',
   					'error_msg'=>'-1',
   					'alldone'=>TRUE,
   					'uid'=>$uid 
   					);
				return $data;
			}
		}//end register_user
	}
?>