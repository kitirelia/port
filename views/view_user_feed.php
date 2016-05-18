<script type="text/javascript">
	//document.title = "New Feed";
	$(document).ready(function(){
		$('img').on('load', function() {
	    	if(($(this).attr('id').indexOf('hash_img'))>=0){
		    	if($(this).width()>$(this).height()){
		    		$(this).addClass( "crop_for_h  " );
		    	}else{
		    		$(this).addClass( "crop_for_v " );
		    	}
		    	//console.log('resize it');
		    	if($(this).attr('id')==='hash_img_profile'){
		    	//	alert('round it');
		    	//$(this).addClass('img-responsive');
		    	}
	    	}
		});//end load
		
	});//end $(document).ready
	
	
</script>
<style type="text/css">
		.jonat-thumbnail {
			float: left;
		 	position: relative;
		 	width: 152px;
			height: 152px;
			background-color: white;
			overflow: hidden;
		  /*margin:10px;*/
		}
		.img_size_preview{
			width: 305px;
			height:	305px;
		    margin:10px;
		}

		.force_square_image{
			 border-radius: 50%;
			 /*padding: 15px;*/
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
		.debug_nav{
			width:100%;
			height:75px;
			background-color: white;
			border-bottom: 1px solid #dbdbdb;
		}
		.strech_allpage{
			width:100%;
			background-color: #fafafa;
			height: 300px;
		}
		#follow_data ul{
		    list-style:none;
		    position:relative;
		     margin: 0 auto;
		     display: inline-block;
		     text-align: center;
		}
		#follow_data li{
		    float: left;
		    margin:10px;
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

<div id='allpage' class='strech_allpage'>
		<div class='container'>
		<div id ='block_for_content' class='row ' style='margin-top:50px;'>
			<div id='left_edge' class="col-md-1">
				<!-- left edge -->
			</div> <!-- end id='left_edge' -->
			<div id='page_content' class="col-md-10">
				<!-- 		content start here -->
				<div id='user_profile_data' class='row'>
					<div id='block_pro' class='col-md-3'>
						<div id='user_image_profile' class='  jonat-thumbnail force_square_image'> //..'/a
							<!-- <img id='hash_img_profile'  src="<?php echo "" ?>"> -->
							<?php
								echo "<img id = 'hash_img_profile' src='".base_url()."/uploads/fullsize/".$result['content_data'][0] ['profile_picture']. "'>";
							?>
						</div>
					</div> <!-- end id='block_pro -->
					<div id ='user_about_profile' class='col-md-9'>
						<div id='view_user_name'>
							<h1>
								<?php echo $result['content_data'][0] ['user_name'] ?>
							</h1>
						</div> <!-- end view_user_name -->
						<div id='view_user_detail'>
							Satsuki(さっぴょん) 1993.09.24【Japanese,Chinese,English】 Please check Our new instagram @xoxo__ms__ お仕事の依頼はこちら☞sapyon924@gmail.com sapyon924.wix.com/satsuki0924
						</div> <!-- end view_user_detail -->
						<div id='follow_data'>
							<ul>
								<li>
									<span>825</span><span>posts</span>
								</li>
								<li>
									<span>3.7m followers</span>
								</li>
								<li>
									<span>114 following</span>
								</li>
							</ul>
						</div> <!-- end id='follow_data' -->
					</div>
				</div> <!-- end 'profile_data' -->

				<!-- separate here -->

				<div id='image_data' class = ''>
					<div id='parent_each'>
					<div id='image_each' class='row' style='margin-top:40px;'>
						<?php
								$count = 0;
								$user_id =$result['content_data'][0] ['user_id'];
								// /////////// decare javascript variable
								echo '<script>var current_user_id = "'.$user_id . '";</script>';//decare variable
								echo '<script>var current_user_name = "'.$result['content_data'][0] ['user_name'] . '";</script>';//decare variable
								echo '<script>var feed_debug = "'.$count . '";</script>';//decare variable
								$max_image=40;
								$current_image=10;
								//$count=0;
								foreach ($result['content_data'] as $data) {
									//echo "<div  >";
									echo "<div  class = 'jonat-thumbnail img_size_preview'>";
									echo $data['file_name'];
									//echo "<img  id='hash_img".$count."' src='images/".($i%$current_image).".jpg'  >";
									echo '	<img id="hash_img'.$count.'" src="'.base_url().'/uploads/fullsize/'.$data['file_name'].'">';
									echo "</div>";
									$count++;
									//echo $count;
								}
								
								
							?>
					</div> <!-- end id='image_each' -->
					</div>
				</div> <!-- end id='image_content' -->
			</div> <!-- end page_content -->
			<div id='right_edge' class="col-md-1">
				<!-- right edge -->
			</div> <!-- end id='right_edge' -->
		</div> <!-- end row -->
	</div> <!-- end container -->

	</div> <!-- end id='allpage' -->



<div class="container">
	<div id='astupid'>
				<?php
					// $count = 0;
					// $user_id =$result['content_data'][0] ['user_id'];
					// // /////////// decare javascript variable
					// echo '<script>var current_user_id = "'.$user_id . '";</script>';//decare variable
					// echo '<script>var current_user_name = "'.$result['content_data'][0] ['user_name'] . '";</script>';//decare variable
					// echo '<script>var feed_debug = "'.$count . '";</script>';//decare variable
					// // ///////////////////////////////
					// echo '<ul id="start_ul" class="row first">';
					// foreach ($result['content_data'] as $data) {
					// 	echo '<li>';
					// 	echo '	<img src="'.base_url().'/auploads/fullsize/'.$data['file_name'].'">';
					// 	echo '	<div class="text" hidden>';
					// 		$data['caption'] = _add_link_hashtag($data['caption']);
					// 	echo $data['caption'];
					// 	echo '	</div>';
					// 	echo '</li>';
					// }
					// echo '</ul>';
				?>
	</div>
</div>
