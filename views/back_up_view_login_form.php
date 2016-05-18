<div class='container'>
		<div class='row'>
			<div class='col-md-6 col-md-offset-3'>
				<div class="panel-body form_deco">
					<h3 class='h3text'>Login</h3>
					<div class='force_center'>
					<form name='form1' method="post" action="<?php echo site_url() ?>/user_activity/user_login" >
						<div class="form-group">
							<input type ="text" name='email' placeholder='email' size=30 name='user_name'>
						</div>
						<div class="form-group">
							<input type = "password" name='password' placeholder="Password" size=30 margin="auto" name='pwd'>
						</div>
						<div class="form-group">
							<input type="submit" value="login" class="btn btn-default" />
						</div>
					</form>
					</div>
				</div>
			</div>
		</div>
		<div>
			<a href="<?php echo site_url() ?>/user_activity/go_page_regis_member" class="rig">Register</a>
		</div>
	</div>