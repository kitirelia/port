<?php
	class Port_model extends CI_Model{
		function _construct(){
			parent::_construct();
			//$this->load->database("test_db",TRUE);
			$this->load->database("port_db",TRUE);
		}

		function fetch_new_feed($req_id){
			echo "request new feed from ".$req_id."<br>";
			$table_list = array(
				'content_data.user_id','content_data.caption','content_data.file_name','content_data.create_date'
				,'user_data.id','user_data.user_name','user_data.profile_picture','user_data.user_stat'
				);
			$query = $this->db->select($table_list)
			->join('user_data','content_data.user_id=user_data.id','LEFT')
			->order_by('content_data.create_date','ASC')
			->limit(10)
			->get('content_data');
			$result=$query->result_array();
			return $result;
			
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
				'uid'=>$callback[0]['id'],
				'user_stat'=>$callback[0]['user_stat']
				);
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

		function addSingle_content($data){
			$query=$this->db->insert('content_data',$data);
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
		}// end addSingle_content

		function check_hashtag_id($income_hashtag){
			echo "<br>income #".$income_hashtag."<br/>";
			$query=$this->db->get_where('hashtag_stat',array('hashtag_name'=>$income_hashtag));
			$req = $query->result_array();
			if ( $query->num_rows() > 0 ){
				$hash_tag_id=$req[0]['id'];
			}else{
				$raw= array(
					'hashtag_name'=>$income_hashtag,
					'create_date'=>time()
					);
				$query=$this->db->insert('hashtag_stat',$raw);
				$hash_tag_id = $this->db->insert_id();
			}
			return $hash_tag_id; 
		}//end check_hashtag_id
		function pair_content_and_hashtag($pair_data){
			$query=$this->db->insert('hashtag_content',$pair_data);	
			$hash_tag_id = $this->db->insert_id();
			echo "<br>pair id ".$hash_tag_id." <br>";
		}
	}

?>