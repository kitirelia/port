<div class='row' id="nav_content">
		<div id="display_view">
			<div id="content" class = "col-md-6 col-md-offset-3">
				<a href=<?php echo base_url(); ?> >HOME</a>
				<p>Hello Nav bar <?php 
					echo $this->session->userdata('user_name') ; 
				?><p>
			</div>
		</div>
</div>