<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
							<h1><b> Update User</b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('SystemAdministration/User');?>">
									<i class="icon-wrench icon-2x"></i>
									<span ><br /></span>
								</a>
								

							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
						<div class="box-header with-border">
						Header
						</div>
						<div class="box-body">
							<?php 
						foreach ($UserData as $UserData_item): 
						?>
							<form method="post" id="form-buying-type" action="<?php echo site_url('SystemAdministration/User/UpdateUser/'.$id)?>" class="form-horizontal">
							<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
							
							<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" id="hdnDate" />
							<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" id="hdnUser" />
							<div class="panel-heading text-left">
							</div>
							
							<div class="panel-body">
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">NIK</label>
											<div class="col-lg-4">
												<input type="text" placeholder="Username" name="txtUsername" value="<?php echo $UserData_item['user_name'] ?>" class="form-control toupper" readonly/>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">New Password</label>
											<div class="col-lg-4">
												<input type="password" placeholder="Password" name="txtPassword" value="" id="txtPassword" class="form-control" />
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Re-Enter Password</label>
											<div id="divPassCheck" class="col-lg-4">
												<input type="password" onkeyup="checkPass();" placeholder="Password" name="txtPasswordCheck" value="" id="txtPasswordCheck" class="form-control" />
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Employee</label>
											<div class="col-lg-4">
												<select class="form-control employee-data" name="slcEmployee" data-placeholder="All Employee" style="width:100%;">
													<option value="<?php echo $UserData_item['employee_id'] ?>"><?php echo $UserData_item['employee_name'] ?></option>
												</select>
											</div>
									</div>
							</div>
							<div class="panel-footer">
								<div class="row text-right">
									<a href="<?php echo site_url('SystemAdministration/User/');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
									&nbsp;&nbsp;
									<button type="submit" id="btnUser" class="btn btn-primary btn-lg btn-rect">Save Changes</button>
								</div>
							</div>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
		<?php endforeach ?>
	</div>
</section>