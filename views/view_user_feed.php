<script type="text/javascript">
	//document.title = "New Feed";
	$(document).ready(function(){
		//document.title = "Wait name";
		document.title = current_user_name;
		var current_page = 0;
	    var loading_new_feed =false;
	    var is_going_down =false;
		var lastScrollTop = $(this).scrollTop();
		var tab_length=9;

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
			current_page++;
			//var current_user_id declare in php fetching
			var getUrl = "http://"+window.location.host+'/port/index.php'+'/user_activity/load_user_feed_more/'+current_user_id+"/"+current_page;
			var base_url = "http://"+window.location.host+'/port/index.php'+"/user_activity/";
			var base_img = "http://"+window.location.host+'/port/index.php'+"/port/../";
			console.log('req '+getUrl)
				  $.getJSON( getUrl)
				    .done(function( data ) {
				    	var str ='<ul class ="'+current_page+'">';//<ul class="row first">

						for (item of data) {
							//tab_length++;
							str+='<li class="start" ">';
							str+='<img src="'+base_img +'../uploads/fullsize/'+item.file_name+'" class="img-responsive">';
							str+='<div class="text" hidden>';
							str+=search_hashtag(item.caption);
							str+='</div>';
							str+='</li>';
							// str+='<li class="col-lg-2 col-md-4 col-sm-3 col-xs-4 col-xxs-12 bspHasModal" data-bsp-li-index="'+tab_length+'">';
							// str+='<img src="'+base_img +'../uploads/fullsize/'+item.file_name+'" class="img-responsive">';
							// str+='<div class="text">';
							// str+=search_hashtag(item.caption);
							// str+='</div>';
							// str+='</li>';
							feed_debug++;
						    //console.log(item.caption);
						}//end for
						//console.log("---");
						str+='<ul>';
						$( "#preloading" ).remove();
						//$( "#stupid" ).append(str);
						$('#stupid').append(str);
						$('ul.'+current_page+'').bsPhotoGallery({
				          "classes" : "col-lg-2 col-md-4 col-sm-3 col-xs-4 col-xxs-12",
				          "hasModal" : true
				        });
						loading_new_feed =false;
						
				    }).fail(function() {
				    	
					    console.log( "error" );
					});
		}//end load_json_feed


		function load_json_feed2(){
			//alert('user page');
			current_page++;
			//var current_user_id declare in php fetching
			var getUrl = "http://"+window.location.host+'/port/index.php'+'/user_activity/load_user_feed_more/'+current_user_id+"/"+current_page;
			var base_url = "http://"+window.location.host+'/port/index.php'+"/user_activity/";
			var base_img = "http://"+window.location.host+'/port/index.php'+"/port/../";
			//console.log('req '+getUrl)
				  $.getJSON( getUrl)
				    .done(function( data ) {
				    	console.log('get data length '+data.length);

				    	var str ='';
						for (item of data) {
							//console.log(item);
							str+='	<div class = "panel panel-default">';
							str+='		<div class="panel-body">';
							//console.log(base_url+'show_content_user/'+item.user_id);
							str+='		<p>debug '+feed_debug+' post id '+item.post_id+'</p>';
							str+='			<a href="'+base_url+'show_content_user/'+item.user_id+'"><p class="lead">'+item.user_name+'</p></a>';
							//console.log('			<a href="'+base_url+'show_content_user/'+item.user_id+'><p class="lead">'+item.user_name+'</p></a>');
							str+=' 			<div class="thumbnail">';
							str+='			<img src="'+base_img +'../uploads/thumb/'+item.file_name+'" class="img-responsive">';
							str+='			</div>';
							str+='			<p>'+search_hashtag(item.caption)+'</p>';
							str+='		</div>';
							str+='	</div>';
							feed_debug++;
						    //console.log(item.caption);
						}//end for
						$( "#preloading" ).remove();
						$( "#stupid" ).append(str);
						//add_class_it();
						loading_new_feed =false;
						
				    }).fail(function() {
				    	
					    console.log( "error" );
					});
		}//end load_json_feed2
		function search_hashtag(str){
			var clean ="";
			var white_arr = str.split(" ");
			var base_url = "http://"+window.location.host+'/port/index.php'+"/user_activity/show_content_by_hashtag/";
			for (item of white_arr) {
				if(item.indexOf('#')>=0){
					item='<a href="'+base_url+(item.replace("#", ""))+'">'+item+'</a>';
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

		
		$('ul.first').bsPhotoGallery({//properly
          "classes" : "col-lg-2 col-md-4 col-sm-3 col-xs-4 col-xxs-12",
          "hasModal" : true
        });//end bsPhotoGallery
		
	});//end $(document).ready
	
	
</script>
<style type="text/css">
	@import url(https://fonts.googleapis.com/css?family=Bree+Serif);
	.force_back{
		background-color: black;
	}
	.ball-pulse > div {
	  background: orange;
	}
	ul {
          padding:0 0 0 0;
          margin:0 0 40px 0;
      }
      ul li {
          list-style:none;
          margin-bottom:10px;
      }
      ul li.bspHasModal {
          cursor: pointer;
      }
      .modal-body {
          padding:5px !important;
      }
      .modal-content {
          border-radius:0;
      }
      .modal-dialog img {
          text-align:center;
          margin:0 auto;
      }
    .controls{
        width:50px;
        display:block;
        font-size:11px;
        padding-top:8px;
        font-weight:bold;
    }
    .next {
        float:right;
        text-align:right;
    }
    .text {
      font-family: 'Bree Serif';
      color:#666;
      font-size:11px;
      margin-bottom:10px;
      padding:12px;
      background:#fff;
    }
    .glyphicon-remove-circle:hover {
      cursor: pointer;
    }
    .start{

    }
    @media screen and (max-width: 380px){
       .col-xxs-12 {
         width:100%;
       }
       .col-xxs-12 img {
         width:100%;
       }
    }
</style>
<?php
	// function _add_link_hashtag($raw_str){
	// 	$raw_arr = explode(' ', $raw_str);
	// 	$clean_data ="";
	// 	foreach ($raw_arr as $data) {
	// 		$pos = strpos( $data, '#');
	// 		if($pos !== false){
	// 			$string=$data;
	// 			$string = str_replace('#', '', $string);
	// 			$data='<a href ="'.base_url()."index.php/user_activity/show_content_by_hashtag/".$string.'">'.$data.'</a>';
	// 		}
	// 		$clean_data.=" ".$data;
	// 	}
	// 	 return $clean_data;
	// }//end _add_link_hashtag
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
<div class="container">
	<div id='stupid'>
				<?php
					$count = 0;
					$user_id =$result['content_data'][0] ['user_id'];
					// /////////// decare javascript variable
					echo '<script>var current_user_id = "'.$user_id . '";</script>';//decare variable
					echo '<script>var current_user_name = "'.$result['content_data'][0] ['user_name'] . '";</script>';//decare variable
					echo '<script>var feed_debug = "'.$count . '";</script>';//decare variable
					// ///////////////////////////////
					echo '<ul class="row first">';
					foreach ($result['content_data'] as $data) {
						echo '<li>';
						echo '	<img src="'.base_url().'/uploads/fullsize/'.$data['file_name'].'">';
						echo '	<div class="text" hidden>';
							$data['caption'] = _add_link_hashtag($data['caption']);
						echo $data['caption'];
						echo '	</div>';
						echo '</li>';
					}
					echo '</ul>';
				?>
	</div>
</div>
<div class='row' id="allcontent">
		<!-- <div id="display_view">
			<div id="content" class = "col-md-6 col-md-offset-3">
	
				<div id='stupid'> -->
				 <?php
				// 	echo '<ul class="row first">';
				// 	foreach ($result['content_data'] as $data) {
				// 		echo '<li>';
				// 		echo '	<img src="'.base_url().'/uploads/thumb/'.$data['file_name'].'">';
				// 		echo '	<div class="text">';
				// 			$data['caption'] = _add_link_hashtag($data['caption']);
				// 		echo $data['caption'];
				// 		echo '	</div>';
				// 		echo '</li>';
				// 	}
				// 	echo '</ul>';
					//////////////////////////////////////////////////////
					/////////////////////////////////////////////////////
					/////////////////////////////////////////////////////
					// $count = 0;
					// $user_id =$result['content_data'][0] ['user_id'];

					// /////////// decare javascript variable
					// echo '<script>var current_user_id = "'.$user_id . '";</script>';//decare variable
					// echo '<script>var current_user_name = "'.$result['content_data'][0] ['user_name'] . '";</script>';//decare variable
					// echo '<script>var feed_debug = "'.$count . '";</script>';//decare variable
					// ///////////////////////////////
					// //echo "user id is".$user_id."<br>"."data length ".(count($result['content_data']));
					// foreach ($result['content_data'] as $data) {
					// 	//echo base_url()."index.php/user_activity/show_content_user/";
					// 	//echo "<br>".$count." post_id ".$data['post_id'];
					// 	$count++;
					// 	echo '<script> feed_debug = "'.$count . '";</script>';//decare variable
					// 	echo '<div class="panel panel-default">';
					// 	echo '	<div class="panel-body" style="background-color: #AD9999;">';
					// 	echo ' 		<a href="'.base_url()."index.php/user_activity/show_content_user/".$data['user_id'].'"><p class="lead">'.$data['user_name'].'</p></a>';
					// 	echo '		<div class="thumbnail">';
					// 	echo '			<img src="'.base_url().'/uploads/thumb/'.$data['file_name'].'" class="img-responsive">';
					// 	echo '		</div>';
					// 	echo '<p>';
					// 	$data['caption'] = _add_link_hashtag($data['caption']);
					// 		echo $data['caption'];
					// 	echo '</p>';
					// 	echo '	</div>';
					// 	echo "</div>";
					// }

				?>
				</div>
			</div>

		</div>
		
	</div>

<!-- <div class='container'>
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
		<div> //end row

</div> -->