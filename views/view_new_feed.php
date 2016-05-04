<script type="text/javascript">
	document.title = "New Feed";
	$(document).ready(function(){
		var current_page = 1;
	    var loading_new_feed =false;
	    var is_going_down =false;
	    var load_success =false;
		var lastScrollTop = $(this).scrollTop();
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
		        }else if(! is_going_down && load_success){
		        	//$( "#preloading" ).remove();
		        	//loading_new_feed =false;
		        	//load_success =false;
		        	//console.log('remove done');
		        }
		    }
		};//end window.onscroll

		function show_preload(){
		   	var data ="<div id='preloading'>";
		   	data+="<p> Preload HERE<p>";
		   	data +=" </div> ";
		   	//console.log(data);
			$( "#stupid" ).append(data);
			//load_success =true;
			load_json_feed();
		}
		function load_json_feed(){
			current_page++;
			
			var getUrl = "http://"+window.location.host+window.location.pathname+'/user_activity/load_feed_more/'+current_page;
			//console.log('req page '+current_page,getUrl);
			var base_url = "http://"+window.location.host+window.location.pathname+"/user_activity/";
			var base_img = "http://"+window.location.host+window.location.pathname+"/port/../";
			//console.log("base url "+base_url);
			var flickerAPI = "http://api.flickr.com/services/feeds/photos_public.gne?jsoncallback=?";
				  $.getJSON( getUrl, {
				    tags: "mount rainier",
				    tagmode: "any",
				    format: "json"
				  })
				    .done(function( data ) {
				    	var str ='';

						for (item of data) {
							//console.log(item);
							str+='	<div class = "panel panel-default">';
							str+='		<div class="panel-body">';
							//console.log(base_url+'show_content_user/'+item.user_id);
							str+='			<a href="'+base_url+'show_content_user/'+item.user_id+'"><p class="lead">'+item.user_name+'</p></a>';
							//console.log('			<a href="'+base_url+'show_content_user/'+item.user_id+'><p class="lead">'+item.user_name+'</p></a>');
							str+=' 			<div class="thumbnail">';
							str+='			<img src="'+base_img +'../uploads/thumb/'+item.file_name+'" class="img-responsive">';
							str+='			</div>';
							str+='		</div>';
							str+='	</div>';
						    //console.log(item.caption);
						}//end for
						$( "#preloading" ).remove();
						$( "#stupid" ).append(str);
						loading_new_feed =false;
						load_success =false;
				    }).fail(function() {
					    console.log( "error" );
					});
		}//end load_json_feed
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
		$raw_arr = explode(' ', $raw_str);
		$clean_data ="";
		foreach ($raw_arr as $data) {
			$pos = strpos( $data, '#');
			if($pos !== false){
				$string=$data;
				$string = str_replace('#', '', $string);
				$data='<a href ="'.base_url()."index.php/user_activity/show_content_by_hashtag/".$string.'">'.$data.'</a>';
			}
			$clean_data.=" ".$data;
		}
		 return $clean_data;
	}//end _add_link_hashtag
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
					foreach ($result['content_data'] as $data) {
						//echo base_url()."index.php/user_activity/show_content_user/";
						echo '<div class="panel panel-default">';
						echo '	<div class="panel-body">';
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