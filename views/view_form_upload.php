	<div id="upload_form">
			<div class="row debug-bg">
				<div class="col-md-6 col-md-offset-3 ">
					<div class="panel-body form_deco">
						<form action="<?php echo site_url() ?>index.php/welcome/do_upload" method="post" enctype="multipart/form-data">
							<?php echo $this->session->userdata('user_name'); ?>
							<div class="form-group">
								<label >Select Image</label>
								<input type="file" name="userfile" size="20" />
	   							
	   						</div>
	   						<div class="form-group">
	   							<input type="hidden" name="user_name" value="<?php echo $this->session->userdata('user_name'); ?>">
							    <!-- <input type="text"  class="form-control" name="user_name2" id="exampleInputEmail1" placeholder="Username"><br/> -->
								<textarea   placeholder="Say something. #hashtag" name="hashtag" id="taid" cols="35" wrap="soft" class="form-control custom-control" style="resize:none"></textarea>
							</div>

	   						<!-- <button type="submit" value="upload"  name='submit'class="btn btn-default">Upload</button> -->
	   						<input type="submit" value="upload" class="btn btn-default" />
						</form>
					</div>
				</div>
			</div>
	</div>