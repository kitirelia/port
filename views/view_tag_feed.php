<script type="text/javascript">
	//document.title = "New Feed";
	$(document).ready(function(){
		//var user_name
		document.title = "#"+set_tile;
		var current_page = 1;
	    var loading_new_feed =false;
	    var is_going_down =false;
		var lastScrollTop = $(this).scrollTop();

		$(window).scroll(function(event){
			var st = $(this).scrollTop();
			//$( "#debug_scroll" ).html(st+"|"+lastScrollTop);
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
			//alert('user page');
			
			//var current_user_id declare in php fetching
			var getUrl = "http://"+window.location.host+'/port/index.php'+'/user_activity/load_hashtag_more/'+current_hashtag+"/"+current_page;
			var base_url = "http://"+window.location.host+'/port/index.php'+"/user_activity/";
			var base_img = "http://"+window.location.host+'/port/index.php'+"/port/../";
			//console.log('req '+getUrl)
				  $.getJSON( getUrl)
				    .done(function( data ) {
				    	
				    	if(data.length>0){
				    		current_page++;
				    	}
				    	//console.log('get data length '+data.length);
				    	var str ='';
						for (item of data) {
							str+= "<div id='"+item.post_id+"' class = 'jonat-thumbnail'>";
							str+= "<img  id='hash_img"+item.post_id+"' src='"+base_img+"../uploads/thumb/"+item.file_name+"'   />";
							str+= "<div id='d_user_name"+item.post_id+"' hidden>";
							str+= ' 		<a href="'+base_url+"show_content_user/"+item.user_id+'"><p >'+item.user_name+'</p></a>';
							str+= "</div>";
							str+= "<div id='d_user_profile"+item.post_id+"' hidden>";
							str+= "	<img id='profile_img"+item.post_id+"' src='"+base_img+"../uploads/thumb/"+item.profile_picture+"'>";// " $data['profile_picture'];
							str+= "</div>";
							//str+= '<div id=caption'+feed_debug+'>'+search_hashtag(item.caption)+'</div>'
							str+= "<div id='capdata"+item.post_id+"' hidden>"+search_hashtag(item.caption)+"</div>";
							str+= "</div>";
							feed_debug++;
						}//end for
						$( "#preloading" ).remove();
						$( "#stupid" ).append(str);
						
						loading_new_feed =false;
						
				    }).fail(function() {
				    	
					    console.log( "error" );
					});
		}//end load_json_feed
		
		function search_hashtag(str){
			//console.log("welcome ------------------");
			var clean ="";
			var white_arr=[];
			//console.log("before "+str);
			if(typeof str !== "undefined"){
				//console.log("ok "+str);
				white_arr = str.split(" ");
			}else{
				//console.log('what the ... '+str);
			}
			
			var base_url = "http://"+window.location.host+'/port/index.php'+"/user_activity/show_content_by_hashtag/";
			for (item of white_arr) {
				if(item.indexOf('#')>=0){
					item = clean_each_hash(item);
					//item='<a href="'+base_url+(item.replace("#", ""))+'">'+item+'</a>';
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
			var cache_str="";
			var arr = str.split('#');
			var clean_str="";
			var count_check=0;
			var base_url = "http://"+window.location.host+'/port/index.php'+"/user_activity/show_content_by_hashtag/";
			if(str.indexOf('#')>0){
				cache_str = arr[0];
			}
			for(each_tag of arr){
				if(each_tag !=cache_str && each_tag.length){
					//console.log("each tag "+each_tag);
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
		
		$('img').on('load', function() {

	    	var this_id = $(this).attr('id');
	    	if(typeof this_id !== typeof undefined && this_id !== false) {
	    	if((this_id).indexOf('hash_img')>=0 ){
		    	if($(this).width()>$(this).height()){
		    		$(this).addClass( "crop_for_h  " );
		    	}else{
		    		$(this).addClass( "crop_for_v " );
		    	}
		    }//end if((this_id).indexOf('hash_img')>=0 ){
		    }//end if has attr
		});//end $('img').on('load', function() {
		

		$('body').on('click','img',
			function(){
				var this_id = $(this).attr('id');
				var parent_id = $(this).parent().attr('id');
				//console.log('parent_id is  '+parent_id);
				if(typeof this_id !== typeof undefined && this_id !== false) {
			    	if((this_id).indexOf('hash_img')>=0 ){
			    		//
				   		var lcaption = $('#capdata'+parent_id).html();
				   		//var thumb_path = $(this).attr('src'); d_user_profile
				   		var thumb_path =  $('#hash_img'+parent_id).attr('src');
				   		var content_image = $('#hash_img'+parent_id).attr('src');
				   		//console.log("content_image "+parent_id,"content_image "+content_image);
				   		var user_name_tag=$('#d_user_name'+parent_id).html();
				   		var user_profile_image = $('#d_user_profile'+parent_id+' img').attr('src');
				   		console.log(user_profile_image);
				   		var real_path = thumb_path.replace("thumb", "fullsize");
					  	$('#imagepreview').attr('src',real_path); 
					  	$('#modal_user_profile').attr('src',user_profile_image);
					  	$('#modal_user_name').html(user_name_tag);
					  	$('#caption_me').html(lcaption);
					 	$('#myModal').modal('show'); // imagemoda
					}
				}
			}
		);//end $('body').on('click','img',
		
		$('#myModal').on('show.bs.modal', function () {
		     
		});//end show modal
	});//end $(document).ready
	
	
</script>
<style type="text/css">
	.force_back{
		background-color: black;
	}
	.ball-pulse > div {
	  background: orange;
	}
	.show_tag_head{
		font-size: 46px;
		color: #868686;
		margin:auto;
	}
	.easy_frame{
		margin-bottom: 20px;
		margin-top: 20px;
	}
	.no_hashtag{
		margin-bottom: 20px;
		margin-top: 20px;
		text-align: center;
		font-size: 40px;
		color: #286090;
		border-style: solid;
    	border-color: #CCC;
	}


	/*crop engine*/
	.jonat-thumbnail {
			float: left;
		  position: relative;
		  width: 275px;
		  height: 275px;
		 /* background-color: black;*/
		  overflow: hidden;
		  margin:10px;
		}
	.crop_for_h {
		  position: absolute;
		  left: 50%;
		  top: 50%;
		  height: 100%;
		  width: auto;
		  -webkit-transform: translate(-50%,-50%);
		      -ms-transform: translate(-50%,-50%);
		          transform: translate(-50%,-50%);
	}
	.crop_for_v {
		  position: absolute;
		  left: 50%;
		  top: 50%;
		  height: auto;
		  width: 100%;
		  -webkit-transform: translate(-50%,-50%);
		      -ms-transform: translate(-50%,-50%);
		          transform: translate(-50%,-50%);
	}
	.vertical-align {
		    display: flex;
		    align-items: center;
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
				$_eash_tag .= "<a href='".base_url()."index.php/user_activity/show_content_by_hashtag/".$_subword."' target='_self'>#".$_subword."</a>";
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

<div  id="allcontent"  class='row' style=" background-color: #fafafa";>
		
			<div id='hashtag_head' class = "col-md-6 col-md-offset-3 easy_frame" style="text-align: center;">
				<span class='show_tag_head'>#<?php echo $result['search_tag']; ?></span>
				<?php 
				echo '<script>var set_tile = "'.$result['search_tag'] . '";</script>';
				//decare variable
				?> 

			</div>

			<div id="content" class = "col-md-8 col-md-offset-2">
				
				<?php
					$count = 0;
					if(count($result['content_data'])>0){
						$user_id =$result['content_data'][0] ['user_id'];
						/////////// decare javascript variable
						echo '<script>var current_hashtag = "'.$result['search_tag'] . '";</script>';//decare variable
						echo '<script>var current_user_name = "'.$result['content_data'][0] ['user_name'] . '";</script>';//decare variable
						echo '<script>var feed_debug = "'.$count . '";</script>';//decare variable
						///////////////////////////////
						//echo "user id is".$user_id."<br>"."data length ".(count($result['content_data']));
						echo "<div id ='stupid' class ='container'>";
						//echo "<ul>";
						foreach ($result['content_data'] as $data) {
							echo "<div id='".$data['post_id']."' class = 'jonat-thumbnail'>";
							$cap =_add_link_hashtag($data['caption']);
							echo "<img id='hash_img".$data['post_id']."' src='".base_url()."/uploads/thumb/".$data['file_name']."'   >";
							echo "<div id='d_user_name".$data['post_id']."' hidden>";
							echo ' 		<a href="'.base_url()."index.php/user_activity/show_content_user/".$data['user_id'].'"><p >'.$data['user_name'].'</p></a>';
							echo "</div>";
							echo "<div id='capdata".$data['post_id']."' hidden>".$cap."</div>";
							echo "<div id='d_user_profile".$data['post_id']."' hidden>";
							echo "	<img id='profile_img".$data['post_id']."' src='".base_url()."/uploads/thumb/".$data['profile_picture']."'>";// " $data['profile_picture'];
							echo "</div>";
							echo "</div>";
							$count++;
						}//end foreach
						//echo "</ul>";
						echo "</div>";
					}//end if
					else{
						echo "<div class='no_hashtag'>No data</div>";
					}
				?>
				
			</div>

		
	</div>


<!-- Modal -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
    	<div class="modal-content">
    		<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal">&times;</button>
	     	</div><!-- end <div class="modal-header"> -->
      		<div id='modal_body_here' class="modal-body ">
      			<div class='row'>
      				<div class="col-md-8 modal_clean_border" >
      					<img  id="imagepreview" src='http://www.mx7.com/i/ad0/MjAbok.png' class='img-responsive'>
      				</div>
  					<div class="col-md-4 modal_clean_border">
  						<div class='row vertical-align' style=" border-bottom: 1px solid #efefef; padding: 15px;">
  							<div  class="col-md-4">
  								<img  id='modal_user_profile'
  										class='img-responsive img-circle'
  										src="https://instagram.fbkk9-1.fna.fbcdn.net/t51.2885-19/s150x150/11378177_1602477123409848_72885111_a.jpg">
  							</div>
  							<div class="col-md-8" id='modal_user_name' class='modal_text_too_long'></div>
  						</div>
  						<div id='caption_me'>

  						</div>
  					</div>
      			</div> <!-- end row -->
      		</div> <!-- end div class="modal-body -->
      		<div class="modal-footer" hidden>
		        
		     </div> <!-- end <div class="modal-footer"> -->
    </div> <!-- end <div class="modal-content -->

	</div> <!-- end <div class="modal-dialog -->
</div><!-- end <div id="myModal"  -->

<div class='container'>
		<div class='row'>
			<?php
				// if($this->session->userdata('stat')>=1){//Success
				// 	echo "<p>Success</p>";
				// 	echo "<p>Hello ".$this->session->userdata('user_name')."</p>";
				// 	echo "<p>email ".$this->session->userdata('email')."</p>";
				// 	echo "<p>image ".$this->session->userdata('profile_picture')."</p>";
				// }else{
				// 	echo "<p>fail</p>";
				// }
			?>
		<div> <!-- end class row -->
</div>