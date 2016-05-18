<!doctype html>
<html>
<head>
	<title>Register</title>
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
		.vcenter {
		    display: inline-block;
		    vertical-align: middle;
		    float: none;
		}
		.vertical-align {
		    display: flex;
		    align-items: center;
		}
		.form_deco{
			background-color: white;
		}
		.icon {
			display: inline-block;
			width: 1em;
			height: 1em;
			fill: currentColor;
		}
		.debug_bg{
			background-color: red;
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function(){

			$("#register_view").hide();
  			$("#login_view").show();
		});//end $(document).ready
		function toggle_view(){
			//alert('toggle');
			$('#register_view').toggle();
			$('#login_view').toggle();
		}
	</script>

</head>
<body style="background-color: #fafafa;">
	<div class='container' id='register_view' hidden>
		<div class='row'>
			<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3 form_deco" style='margin-top:40px;'>
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
			<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3 form_deco">
				<div class="panel-body form_deco" style='margin-top:30px;'>
					<div>
						<a href="#" class="rig" onclick='toggle_view()'>Login</a>
					</div>
				</div>
			</div> <!-- end svg -->
			<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3 form_deco">
				<div class="panel-body form_deco" style='margin-top:30px;'>
					<div>
						<a href="<?php echo site_url() ?>" class="rig">Home</a>
					</div>
				</div>
			</div> <!-- end home -->
		</div> <!-- end row -->
	</div> <!-- end container -->
	
	<div class='container ' id='login_view' hidden>
		<div class='row'>
			<div class='col-md-6 col-md-offset-3 '>
				<div class="panel-body form_deco" style='margin-top:40px;'>
					<h3 class='h3text'>Login</h3>
					<div class='force_center'>
					<form name='form1' method="post" action="<?php echo site_url() ?>/user_activity/user_login" >
						<div class="form-group">
							<input type ="text" name='email' placeholder='email' size=30 name='user_name'>
						</div>
						<div class="form-group">
							<input type = "password" name='password' placeholder="Password" size=30 margin="auto" name='pwd'>
						</div>
						<div class="form-group" >
							<button type="submit" class="btn btn-primary btn-block" style="margin:auto; width:244px;">Login</button>
							<!-- <input type="submit" value="login" class="btn btn-default" /> -->
						</div>
					</form>
					</div>
					
				</div> <!-- //end deco -->
			</div> <!-- end div from -->
			<div class='col-md-6 col-md-offset-3' >
				<div class="panel-body form_deco" style='margin-top:30px;'>
					<div>
						<a href="#" class="rig" onclick='toggle_view()'>Register</a>
					</div>
				</div>
			</div>
			<div class='col-md-6 col-md-offset-3' >
				<div class="panel-body form_deco" style='margin-top:30px;'>
					<div>
						<a href="<?php echo site_url() ?>" class="rig" >Home</a>
					</div>
				</div>
			</div>
		</div> <!-- end div class='row' -->
	</div><!--  end class='container ' id='login_view' -->

<!-- <div class="row">
    <div class="col-xs-5 col-md-3 col-lg-1 vcenter">
        <div style="height:10em;border:1px solid #000">Big</div>
    </div><div class="col-xs-5 col-md-7 col-lg-9 vcenter">
        <div style="height:3em;border:1px solid #F00">Small</div>
    </div>
</div> -->

</body>
</html>