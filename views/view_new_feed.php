<script type="text/javascript">
	document.title = "New Feed";
</script>
<?php
	function _add_link_hashtag($raw_str){
		$raw_arr = explode(' ', $raw_str);
		$clean_data ="";
		foreach ($raw_arr as $data) {
			$pos = strpos( $data, '#');
			if($pos !== false){
			//	echo $pos." ->".$data."<br>";
				$data='<a href ="http://www.google.com/'.$data.'">'.$data.'</a>';
			}
			$clean_data.=" ".$data;
		}
		 return $clean_data;
		//return 'hello';
	}//end _add_link_hashtag
?>
<div class='row' id="allcontent">
		<div id="display_view">
			<div id="content" class = "col-md-6 col-md-offset-3">
				<?php
					foreach ($result['content_data'] as $data) {

						echo '<div class="panel panel-default">';
						echo '	<div class="panel-body">';
						//echo '	<div> <img src=../../uploads/thumb/'.$data['file_name'].' class="img-circle" height="42" width="42"> </div>';
						echo ' 		<a href="'.base_url()."index.php/user_search/serch_username/".$data['user_id'].'"><p class="lead">'.$data['user_name'].'</p></a>';
						echo '		<div class="thumbnail">';
						//echo image_asset('logo.png');
						echo '			<img src="'.base_url().'/uploads/thumb/'.$data['file_name'].'" class="img-responsive">';
						echo '		</div>';
						echo '<p>';
						// $raw = explode(',', $data['caption']);
						// foreach ($raw as $data2) {
						// 	if(trim($data2)!=""){
						// 		echo " <a href='
						// 		".base_url()."index.php/user_search/search_hashtag/".$data2."
						// 		'>#".$data2."</a>";
						// 	}
						// }
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