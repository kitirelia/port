<?php
	class Port_model extends CI_Model{
		function _construct(){
			parent::_construct();
			//$this->load->database("test_db",TRUE);
			$this->load->database("port_db",TRUE);
		}
		function register_user($data){
			echo "<br>in model <br>";
			print_r($data);
			$query=$this->db->insert('user_data',$data);
			echo "query is ".$query;
			if(!$query){
				$errNo   = $this->db->_error_number();
   				$errMess = $this->db->_error_message();
   				$data=array(
   					'stat'=>'0',
   					'error_no'=>$errNo ,
   					'error_msg'=>$errMess
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
   					'alldone'=>TRUE
   					);
				//$this->_insert_user_detail($uid,$arr['user_name']);
				//echo "<br>Success";
				return $data;
			}
		}//end register_user
	}
?>