<?php
	class Port_model extends CI_Model{
		function _construct(){
			parent::_construct();
			//$this->load->database("test_db",TRUE);
			$this->load->database("port_db",TRUE);
		}

		function fetch_new_feed($req_id){
			//echo "request new feed from ".$req_id."<br>";
			$table_list = array(
				'content_data.user_id','content_data.caption','content_data.file_name','content_data.create_date','content_data.post_id'
				,'user_data.id','user_data.user_name','user_data.profile_picture','user_data.user_stat'
				);
			$query = $this->db->select($table_list)
			->join('user_data','content_data.user_id=user_data.id','LEFT')
			->order_by('content_data.create_date','DESC')
			->limit(10)
			->get('content_data');
			$result=$query->result_array();
			return $result;
			
		}
		////////// req that return for load more..
		function load_feed_more($current_page){
			$max_feed_per_page = 10;
			$table_list = array(
				'content_data.user_id','content_data.caption','content_data.file_name','content_data.create_date','content_data.post_id'
				,'user_data.id','user_data.user_name','user_data.profile_picture','user_data.user_stat'
				);
			$query = $this->db->select($table_list)
			->join('user_data','content_data.user_id=user_data.id','LEFT')
			->order_by('content_data.create_date','DESC')
			->limit($max_feed_per_page,($current_page*$max_feed_per_page))
			->get('content_data');
			$result=$query->result_array();
			return $result;

		}
		function  load_user_feed_more($u_id,$page_res){
			$max_feed_per_page = 10;
			//echo $max_feed_per_page."|".($max_feed_per_page*$page_res);
			$table_list = array(
				'content_data.user_id','content_data.caption','content_data.file_name','content_data.create_date','content_data.post_id'
				,'user_data.id','user_data.user_name','user_data.profile_picture','user_data.user_stat'
			);
			$query = $this->db->select($table_list)
			->join('user_data','content_data.user_id=user_data.id','LEFT')
			->where('content_data.user_id',$u_id)
			->order_by('content_data.create_date','DESC')
			->limit($max_feed_per_page,($max_feed_per_page*$page_res))
			->get('content_data');
			$result=$query->result_array();
			//print_r($result);
			return $result;
		}//end load_user_feed_more
		function load_tag_feed_more($hashtag,$page_res){
			$max_feed_per_page = 12;
			//echo "search of "+$hashtag+"<br>";
			//$hashtag =trim( preg_replace( "/[^0-9a-z]+/i", "", $hashtag) );	
			//echo "but clean "+$hashtag;
			$hash_id_query = $this->db
			->where('hashtag_name',$hashtag)
			->get('hashtag_stat');
			$hash_res=$hash_id_query->result_array();
			//print_r($hash_res);
			//echo "<br>----------------<br>";
			if(count($hash_res)>0){
				$hash_id = $hash_res[0]['id'];
				//echo "# id is ".$hash_id.'<br>';
				$table_list = array(
					'content_data.user_id','content_data.caption','content_data.file_name','content_data.create_date','content_data.post_id'
					,'hashtag_content.content_post_id','hashtag_content.hashtag_id'
					);
				$query= $this->db->select($table_list)
				->join('content_data','hashtag_content.content_post_id = content_data.post_id','INNER')
				->where('hashtag_content.hashtag_id',$hash_id)
				->limit($max_feed_per_page,($max_feed_per_page*$page_res))
				->get('hashtag_content');
				$pair_data=$query->result_array();
				//print_r($pair_data);
				//echo count($pair_data)." users <br>";

				for($i=0;$i<count($pair_data);$i++){
					$sub_table_list = array(
						'content_data.user_id','content_data.caption','content_data.file_name','content_data.create_date','content_data.post_id'
						,'user_data.id','user_data.user_name','user_data.profile_picture','user_data.user_stat'
						);
					// //echo "uid ".$single_data['user_id']; 
					$user_query=$this->db
					->where('user_data.id',$pair_data[$i]['user_id'])
					->get('user_data');
					$user_and_conten_data = $user_query->result_array();
					$pair_data[$i]['user_name']=$user_and_conten_data[0]['user_name'];
					$pair_data[$i]['profile_picture']=$user_and_conten_data[0]['profile_picture'];
					$pair_data[$i]['user_stat']=$user_and_conten_data[0]['user_stat'];
					
					//print_r($pair_data[$i]['caption']);
					//echo "-----------------<br>";
				}
				return $pair_data;
			
			}else{
				return array();
			}
		}
		//--------------- se
		function fetch_personal_content($uid){
			//echo "model see ".$uid;
			$table_list = array(
				'content_data.user_id','content_data.caption','content_data.file_name','content_data.create_date','content_data.post_id'
				,'user_data.id','user_data.user_name','user_data.profile_picture','user_data.user_stat'
				);
			$query = $this->db->select($table_list)
			->join('user_data','content_data.user_id=user_data.id','LEFT')
			->where('content_data.user_id',$uid)
			->order_by('content_data.create_date','DESC')
			->limit(10)
			->get('content_data');
			$result=$query->result_array();

			return $result;

		}
		function fetch_hashtag_content($hashtag){
			//echo "search of "+$hashtag+"<br>";
			//$hashtag =trim( preg_replace( "/[^0-9a-z]+/i", "", $hashtag) );	
			//echo "but clean "+$hashtag;
			$hash_id_query = $this->db
			->where('hashtag_name',$hashtag)
			->get('hashtag_stat');
			$hash_res=$hash_id_query->result_array();
			//print_r($hash_res);
			//echo "<br>----------------<br>";
			if(count($hash_res)>0){
				$hash_id = $hash_res[0]['id'];
				//echo "# id is ".$hash_id.'<br>';
				$table_list = array(
					'content_data.user_id','content_data.caption','content_data.file_name','content_data.create_date','content_data.post_id'
					,'hashtag_content.content_post_id','hashtag_content.hashtag_id'
					);
				$query= $this->db->select($table_list)
				->join('content_data','hashtag_content.content_post_id = content_data.post_id','INNER')
				->where('hashtag_content.hashtag_id',$hash_id)
				->limit(12)
				->get('hashtag_content');
				$pair_data=$query->result_array();
				//print_r($pair_data);
				//echo count($pair_data)." users <br>";

				for($i=0;$i<count($pair_data);$i++){
					$sub_table_list = array(
						'content_data.user_id','content_data.caption','content_data.file_name','content_data.create_date','content_data.post_id'
						,'user_data.id','user_data.user_name','user_data.profile_picture','user_data.user_stat'
						);
					// //echo "uid ".$single_data['user_id']; 
					$user_query=$this->db
					->where('user_data.id',$pair_data[$i]['user_id'])
					->get('user_data');
					$user_and_conten_data = $user_query->result_array();
					$pair_data[$i]['user_name']=$user_and_conten_data[0]['user_name'];
					$pair_data[$i]['profile_picture']=$user_and_conten_data[0]['profile_picture'];
					$pair_data[$i]['user_stat']=$user_and_conten_data[0]['user_stat'];
					
					//print_r($pair_data[$i]['caption']);
					//echo "-----------------<br>";
				}
				return $pair_data;
			
			}else{
				return array();
			}
		}

		//----------------- delete post

		function delete_post_content($to_del_post){
			$del_result;
			//--------- delete JPG file
			$jpg_query = $this->db->where('post_id',$to_del_post)
			->get('content_data');
			$jpeg_res = $jpg_query->result_array();
		    $file_name = $jpeg_res[0]['file_name'];
			$folder_arr = array('fullsize','thumb');
			foreach ($folder_arr as $folder) {
				$path_to_file = './uploads/'.$folder.'/'.$file_name;
				if(unlink($path_to_file)) {
				   //  echo 'deleted '.$folder.'successfully<br>';
				    $del_result['jpg_res']='successfully';
				}
				else {
				     echo 'errors occured<br>';
				    $del_result['jpg_res']='errors occured';
				}
			}
		    //--------- delete # and content
		    $content_hash_query = $this->db->where('content_post_id',$to_del_post)
		    ->get('hashtag_content');
		    $hash_res=$content_hash_query->result_array();
		    foreach ($hash_res as $hast_con) {
		    	$h_con = array('id'=>$hast_con['id']);
		    	$this->db->delete('hashtag_content',$h_con);
		    }
		    //----------- delete contend_data
		    $c_con =array('post_id'=>$to_del_post);
			$this->db->delete('content_data',$c_con);
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
			}
			return $clean;
		}
		function register_user($data){
			//echo "before error";
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
			echo "before insert ".$data['caption'];
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
			//echo "<br>income #".$income_hashtag."<br/>";
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
			//echo "<br>pair id ".$hash_tag_id." <br>";
		}
	///////////////// flash debuging
		function flash_req_id_by_user_name($user_name){
			// $query = $this->db->where('email',$arr['email'])
			// ->where('password',$arr['password'])
			// ->get('user_data');
			$query = $this->db->where('user_name',$user_name)
			->get('user_data');
			$res = $query->result_array();
			//print_r($res);
			if($query->num_rows() > 0){
				echo "<br>user exist ".$res[0]['id'];
				return $res[0]['id'];
			}else{
				echo "<br>auto register start";
				$regis_data = array(
					'email'=>$user_name.'@mail.com',
					'user_name' => $user_name,
					'password' => 'aaa',
					'profile_picture'=>'default.jpg',
					'user_stat' =>'user',
					'register_date' =>time()
				);
				$query=$this->db->insert('user_data',$regis_data);
				$uid =  $this->db->insert_id();
				return $uid;
				//echo "!!register done ".$uid;
			}
		}
		function debug_emoji($data){
			$this->db->insert('emoji', array('emoji' => $data));
		}
	}
?>