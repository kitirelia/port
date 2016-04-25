<!doctype html>
<html>
<head>
	<title>Result</title>
	<?php echo js_asset('jquery-1.12.0.min.js'); ?>
	<?php echo css_asset('bootstrap.min.css'); ?>
	<style type="text/css">
		.h3text{
			text-align: center;
		}
		.form_box{
			background-color: red;
		}
		.force_center{
			text-align: center;
		}

	</style>

</head>
<body>
	<div class='container'>
		<div class='row'>
			<?php
				if($stat>=1){//Success
					echo "<p>Success</p>";
					echo "<p>id is ".$uid."</p>";
				}else{
					echo "<p>fail</p>";
				}
			?>
		<div> <!-- end class row -->
	</div>
	<div class='container'>
		<div class='row'>
		<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<form role="form" method="post" action="<?php echo site_url() ?>/user_activity/regis_member">
				<h2>Register</h2>
				<div class="form-group">
					<input type="text" name="email" id="email_id" class="form-control input-lg" placeholder="email" tabindex="3">
				</div>
				<div class="form-group">
					<input type="text" name="username" id="username_id" class="form-control input-lg" placeholder="username" tabindex="3">
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="form-group">
	                        <input type="password" name="password_0" id="pass_0" class="form-control input-lg" placeholder="password" tabindex="1">
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="password" name="password_1" id="pass_1" class="form-control input-lg" placeholder="re-password" tabindex="2">
						</div>
					</div>
				</div> <!-- end inside row -->
				<div class="col-xs-12 col-md-6">
				<input type="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="7">
				<!-- <input type="submit" value="login" class="btn btn-default" /> -->
			</div>
			</form>
		</div> <!-- end col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3 -->
		</div> <!-- end row -->
	</div> <!-- end container -->
	<!-- <div class="container">



</body>
</html>