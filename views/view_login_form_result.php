<div class='container'>
		<div class='row'>
			<?php
				if($stat>=1){//Success
					echo "<p>Success</p>";
					echo "<p>usename ".$user_name."</p>";
					echo "<p>email ".$email."</p>";
					echo "<p>image ".$profile_picture."</p>";
				}else{
					echo "<p>fail</p>";
				}
			?>
		<div> <!-- end class row -->
	</div>