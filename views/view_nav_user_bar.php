<style type="text/css">
	.text_sizing{ 
	  width: 200px; 
	  min-width:170px; 
	  max-width:250px; 

	  height:28px; 
	  min-height:20px;  
	  max-height:40px;
	}

	.nav_link_menu a{
		cursor: pointer; cursor: hand;
		color: #2D2D2D;
		font-size: 18px;
	}
	div.nav_link_menu a:hover{
	    text-decoration: none;
	}
	#nav_content{
		margin:20px;
		border-bottom: 1px solid #dbdbdb;
		/*border-bottom: 1px solid #dbdbdb;*/
	}
	

</style>
<script type="text/javascript">
	$(function() {
	    $("#usr_search").keypress(function (e) {
	        if(e.which == 13) {
	            var serch_msg = check_search($(this).val());
	            //console.log('serch_msg-> '+serch_msg);
	            e.preventDefault();
	            if(serch_msg.length>0){
	            	//serch_msg = check_search(serch_msg);
	            	//console.log('tosend -> '+serch_msg)
	            	$('input[name="search_word"]').val(serch_msg);
					$('#search_form').submit();
					$('input[name="search_word"]').val('');
	            }else{
	            	//console.log('blank');
	            }
	        }
	    });
	});// end $(function() {

	function check_search(str){
		var clean_str='';
		str = $.trim(str);
		
		str = str.replace(/ /g,'');
		console.log('step1 '+str);
		//str = str.replace(/([~!@$%^&*()-_+=`{}\[\]\|\\:;'<>,.\/? ])+/g, '');
		str =str.replace(/\b[-.,()&$#!\[\]{}"']+\B|\B[-.,()&$!\[\]{}"']+\b/g, "");
		//str = str.replace(/([~!@$%^&*()-_+=`{}\[\]\|\\:;'<>,.\/? ])+/g, '');//.replace(/^(-)+|(-)+$/g,'');
		console.log('step2 '+str);
		if(str.indexOf('#')>=0){
			str = str.split('#');
			var found=false;
			for (var xx of str) {
			  xx = $.trim(xx);
			  if(xx.length>0){
			  	clean_str= xx;
			  	clean_str = 'h*'+clean_str;
			  	//return clean_str;
			  	break;
			  }
			}
		}
		else{
			clean_str=str;
			clean_str='u*'+clean_str;
			//return clean_str;
			//console.log('search user');
		}
		//clean_str='u_'+clean_str;
		return clean_str;
	}
</script>

<div class='container' id="nav_content" >
	<div class='row' >
		<div class="col-md-10 col-md-offset-1 vcenter" style="  padding-top: 10px; " >
			<div class="col-md-4">
				<div align="center" class='nav_link_menu'>
					<a href='<?php	echo base_url();?>'>Home</a>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group has-feedback ">
					<form role="form" id='search_form' method="post" action="<?php echo site_url() ?>/user_activity/nav_show_content_by_hashta">
					<span class='pull-left'>
					<i class="glyphicon glyphicon-search text_sizing form-control-feedback" style="color:#2D2D2D"></i>
					</span>
					<input type="text" name="search_word"  class="form-control  text_sizing " id="usr_search" style=" margin: auto;" placeholder='search'>
					</form>
				</div> <!-- end <div class="form-gro -->
			</div> <!-- end search -->
			<div class="col-md-4">
				<div align="center" class='nav_link_menu'>
					<?php
						//echo 'here'.$this->session->userdata('logged');
						if($this->session->userdata('logged')){
							//echo "|".$this->session->userdata('uid').'|';
							echo "	<a href='".base_url()."index.php/user_activity/show_content_user/".$this->session->userdata('uid')."'>".$this->session->userdata('user_name')."</a>";
						}
						else{
							echo "	<a href='".base_url()."index.php/user_activity/go_page_regis_member'>Login</a>";
						}
					?>
					
				</div>
			</div> <!-- end login -->
		</div>
	</div> <!-- end <div class='row -->
</div> <!-- end  id="nav_content" -->

<!-- <div id="display_view">
			<div id="content" class = "col-md-6 col-md-offset-3">
				<a href=<?php echo base_url(); ?> >HOME</a>
				<p>Hello Nav bar <?php 
					echo $this->session->userdata('user_name') ; 
				?><p>
			</div>
		</div> -->