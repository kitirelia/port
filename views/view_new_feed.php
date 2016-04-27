<script type="text/javascript">
	document.title = "New Feed";
</script>
<div class='row' id="allcontent">
		<div id="display_view">
			<div id="content" class = "col-md-6 col-md-offset-3">
				<?php
					foreach ($result['content_data'] as $data) {

						echo '<div class="panel panel-default">';
						echo '	<div class="panel-body">';
						//echo '	<div> <img src=../../uploads/thumb/'.$data['file_name'].' class="img-circle" height="42" width="42"> </div>';
						echo ' 		<a href="'.base_url()."index.php/user_search/serch_username/".$data['user_id'].'"><p class="lead">'.$data['user_name'].'</p><a>';
						echo '		<div class="thumbnail">';
						//echo image_asset('logo.png');
						echo '			<img src="'.base_url().'/uploads/thumb/'.$data['file_name'].'" class="img-responsive">';
						echo '		</div>';
						echo '<p>';
						// $raw = explode(',', $user['hashtag']);
						// foreach ($raw as $data) {
						// 	if(trim($data)!=""){
						// 		echo " <a href='
						// 		".base_url()."index.php/user_search/search_hashtag/".$data."
						// 		'>#".$data."</a>";
						// 	}
						// }
							echo $data['caption'];
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