<script type="text/javascript">
	document.title = "New Feed";
	// $(window).scroll(function() {
	//    if($(window).scrollTop() + $(window).height() == $(document).height()) {
	//        alert("bottom!");
	//    }
	// });
	//window.scrollTo(0, 0);
	$(document).ready(function(){
		console.log('ready');
		//alert('ready');
	    $(this).scrollTop(0);

	    window.onscroll = function(ev) {
		    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
		        alert("you're at the bottom of the page");
		    }
		};
	});
	
	
</script>
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
		<div id="display_view">
			<div id="content" class = "col-md-6 col-md-offset-3">
				<?php
				echo json_decode('"\uD83D\uDE00"');
				echo "------------------------";
					foreach ($result['content_data'] as $data) {

						echo '<div class="panel panel-default">';
						echo '	<div class="panel-body">';
						//echo '	<div> <img src=../../uploads/thumb/'.$data['file_name'].' class="img-circle" height="42" width="42"> </div>';
						echo ' 		<a href="'.base_url()."index.php/user_activity/show_content_user/".$data['user_id'].'"><p class="lead">'.$data['user_name'].'</p></a>';
						echo '		<div class="thumbnail">';
						//echo image_asset('logo.png');
						echo '			<img src="'.base_url().'/uploads/thumb/'.$data['file_name'].'" class="img-responsive">';
						echo '		</div>';
						echo '<p>';
						$data['caption'] = _add_link_hashtag($data['caption']);
							echo $data['caption'];
						//$emo = "\uD83D\uDE00";
						//echo json_decode($emo);
						echo '</p>';
						echo '	</div>';
						echo "</div>";
					}

				?>
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