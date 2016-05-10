<script type="text/javascript">
	document.title = "New Feed";
	$(document).ready(function(){
		var current_page = 0;
	    var loading_new_feed =false;
	    var is_going_down =false;
		var lastScrollTop = $(this).scrollTop();
		//var color_arr =['#6E6E6E','#9FF781','#F5A9A9','#F2F5A9'];
		$(window).scroll(function(event){
			var st = $(this).scrollTop();
			$( "#debug_scroll" ).html(st+"|"+lastScrollTop);
			    if (st > lastScrollTop){
			    	
			    	is_going_down=true;
			   } else {
			   		
			   		is_going_down=false;
			   }
			   lastScrollTop = st;
			});
	    window.onscroll = function(ev) {
		    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
		        if(is_going_down && !loading_new_feed){
		        	console.log("start load");
		        	loading_new_feed =true;
		        	show_preload();
		        }
		    }
		};//end window.onscroll

		function show_preload(){
		   	var data ="<div id='preloading'>";
		   	data+="<p> Preload HERE<p>";
		   	data +=" </div> ";
			$( "#stupid" ).append(data);
			load_json_feed();
		}
		function load_json_feed(){
			current_page++;
			var getUrl = "http://"+window.location.host+'/port/index.php'+'/user_activity/load_feed_more/'+current_page;
			var base_url = "http://"+window.location.host+'/port/index.php'+"/user_activity/";
			var base_img = "http://"+window.location.host+'/port/index.php'+"/port/../";
			//console.log('req '+getUrl)
				  $.getJSON( getUrl)
				    .done(function( data ) {
				    	console.log('get data length '+data.length);

				    	var str ='';
						for (item of data) {
							//var timeString = moment(1439198499).format("HH:mm:ss");
							str+='		<p>debug '+feed_debug+' post id '+item.post_id+'</p>';
							str+='	<div class = "panel panel-default">';
							//str+='	<p>'+new Date(item.create_date * 1000).format('h:i:s');+'</p>';
							str+='		<div class="panel-body" >';
							str+='		<a href="'+base_url+'/delete_post/'+item.post_id+'" class="btn btn-danger btn-xs" role="button">DELETE</a>';
							//console.log('index is '+(current_page%color_arr.length));
							//console.log(base_url+'show_content_user/'+item.user_id);
							str+='			<a href="'+base_url+'show_content_user/'+item.user_id+'"><p class="lead">'+item.user_name+'</p></a>';
							//console.log('			<a href="'+base_url+'show_content_user/'+item.user_id+'><p class="lead">'+item.user_name+'</p></a>');
							str+=' 			<div class="thumbnail">';
							str+='			<img src="'+base_img +'../uploads/thumb/'+item.file_name+'" class="img-responsive">';
							str+='			</div>';
							str+='			<p>'+search_hashtag(item.caption)+'</p>';
							str+='		</div>';
							str+='	</div>';
						    //console.log(item.caption);
						}//end for
						$( "#preloading" ).remove();
						$( "#stupid" ).append(str);
						loading_new_feed =false;
						
				    }).fail(function() {
				    	
					    console.log( "error" );
					});
		}//end load_json_feed
		function translate_time(UNIX_timestamp) {
			var a = new Date(UNIX_timestamp * 1000);
			  var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
			  var year = a.getFullYear();
			  var month = months[a.getMonth()];
			  var date = a.getDate();
			  var hour = a.getHours();
			  var min = a.getMinutes();
			  var sec = a.getSeconds();
			  var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec ;
			  return time;
		}//end translate_time
		function search_hashtag(str){
			var clean ="";
			var white_arr = str.split(" ");
			var base_url = "http://"+window.location.host+'/port/index.php'+"/user_activity/show_content_by_hashtag/";
			for (item of white_arr) {
				if(item.indexOf('#')>=0){
					//item='<a href="'+base_url+(item.replace("#", ""))+'">'+item+'</a>';
					item = clean_each_hash(item);
				}else if(item.indexOf('@')>=0){{
					item=search_tag_user(item);
				}}
				clean+=(item+" ");
			}
			return clean;
		}//end search_hashtag
		function search_tag_user(str){
			var kept_str = str.split('@');
			var not_use=kept_str[0];
			var res = str.slice(str.indexOf('@'),str.length);
			res = res.split('@');
			res=res.slice(1,res.length);
			var u_str="";
			for (node of res) {
				node = '<a href="https://www.instagram.com/'+node+'" target="_blank" >@'+node+'</a>';
				u_str+=node;
			}
			return not_use+u_str;
		}//end search_tag_user
		function clean_each_hash(str){
			var base_url = "http://"+window.location.host+'/port/index.php'+"/user_activity/show_content_by_hashtag/";
			var cache_str="";
			var arr = str.split('#');
			var clean_str="";
			var count_check=0;
			if(str.indexOf('#')>0){
				cache_str = arr[0];
			}
			for(each_tag of arr){
				if(each_tag !=cache_str && each_tag.length){
					console.log("each tag "+each_tag);
					each_tag = '<a href="'+base_url+each_tag+'">#'+each_tag+'</a>';
					clean_str+=each_tag;
				}else if(!each_tag.length && count_check>0){
					clean_str+="#";
					//console.log('black here '+each_tag);
				}
				count_check++;
			}
			return cache_str+clean_str;
		}//end clean each hash
	});//end $(document).ready
	
	
</script>
<style type="text/css">
	.force_back{
		background-color: black;
	}
	.ball-pulse > div {
	  background: orange;
	}
</style>
<?php
	function _add_link_hashtag($raw_str){
		$clean_string="";
		$remove_white = explode(' ', $raw_str);
		foreach ($remove_white as $eachword ) {
			$pos =strpos($eachword, '#');
			//echo "->".$eachword."<br>";
			if($pos !== false){
				if(!empty($eachword)){
					$eachword = add_a_tag($eachword);
				}
			}if(empty($eachword)){//white space
				$eachword =" ";
			}

			$clean_string.=" ".$eachword;
		}
		return $clean_string;
	}//end _add_link_hashtag
	function add_a_tag($incoming_word){
		$cache_unuse="";
		$found_at  =strpos($incoming_word, '#');
		$_eachword =explode('#',$incoming_word);
		$_eash_tag ='';
		$count=0;
		if($found_at>0){
			$cache_unuse = $_eachword[0];
			//echo "cache ".$cache_unuse;
		}
		foreach ($_eachword as $_subword) {
			if(!empty($_subword) && $_subword!==$cache_unuse){
				$_eash_tag .= "<a href='".base_url()."index.php/user_activity/show_content_by_hashtag/".$_subword."' target='_blank'>#".$_subword."</a>";
			}
			else if(empty($_subword) && $count>0){
			// 	echo "BANG!!!<br>";
			 	$_eash_tag .="#";
			 }
			 $count++;
		}
		return $cache_unuse.$_eash_tag;
	}// end add_a_tag

?>

<div class='row' id="allcontent">
	<div class="loader-inner ball-pulse "></div>
	<div class='loader-inner ball-pulse'></div>
		<div id="display_view">
			<div id="content" class = "col-md-6 col-md-offset-3">
				<div id='debug_scroll'>
					debug here
				</div>
		
				<div id='stupid'>
				<?php
					$count=0;
					echo '<script>var feed_debug = "'.$count . '";</script>';//decare variable
					foreach ($result['content_data'] as $data) {
						//echo "create ".$data['create_date'];
						echo "<br>".$count." post_id ".$data['post_id'].'<br>';
						$count++;
						//echo date('d/m/Y', $data['create_date']);
						//echo base_url()."index.php/user_activity/show_content_user/";
						echo '<script> feed_debug = "'.$count . '";</script>';//decare variable
						echo '<div class="panel panel-default">';
						echo '	<div class="panel-body">';
						echo '<a href="'.base_url().'index.php/user_activity/delete_post/'.$data['post_id'].'" class="btn btn-danger" role="button">DELETE</a>';
						echo ' 		<a href="'.base_url()."index.php/user_activity/show_content_user/".$data['user_id'].'"><p class="lead">'.$data['user_name'].'</p></a>';
						echo '		<div class="thumbnail">';
						echo '			<img src="'.base_url().'/uploads/thumb/'.$data['file_name'].'" class="img-responsive">';
						echo '		</div>';
						echo '<p>';
						$data['caption'] = _add_link_hashtag($data['caption']);
							echo $data['caption'];
						echo '</p>';
						echo '	</div>';
						echo "</div>";
					}

				?>
				</div>
			</div>

		</div>
	</div>

<div class='container'>
		<div class='row'>
			<?php
				if($this->session->userdata('stat')>=1){//Success
					echo "<p>Success</p>";
					echo "<p>Hello ".$this->session->userdata('user_name')."</p>";
					echo "<p>email ".$this->session->userdata('email')."</p>";
					echo "<p>image ".$this->session->userdata('profile_picture')."</p>";
				}else{
					echo "<p>fail</p>";
				}
			?>
		<div> <!-- end class row -->
</div>