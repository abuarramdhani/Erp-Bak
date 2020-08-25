<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
							<h1><b> <?= $Title ?></b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('SystemAdministration/Responsibility');?>">
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
						foreach ($Responsibility as $Responsibility_item): 
						?>
							<form method="post" id="form-buying-type" action="<?php echo site_url('SystemAdministration/Responsibility/UpdateResponsibility/'.$id)?>" class="form-horizontal">
							<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
							
							<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" id="hdnDate" />
							<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" id="hdnUser" />
							<div class="panel-heading text-left">
							</div>
							
							<div class="panel-body">
								<div class="row">
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Responsibility Name</label>
											<div class="col-lg-4">
												<input type="text" placeholder="Username" name="txtResponsibilityName" value="<?=$Responsibility_item['user_group_menu_name'] ?>" id="txtResponsibilityName" class="form-control" required />
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Module</label>
											<div class="col-lg-4">
												<select class="form-control select4" name="slcModule" id="slcModule" required>
													<option value=""></option>
													<?php foreach($Module as $Module_item){
													?>
													<option value="<?=$Module_item['module_id']?>" <?php if($Responsibility_item['module_id']==$Module_item['module_id']){echo "selected";} ?>><?=$Module_item['module_name']?></option>
													<?php } ?>
												</select>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Menu Group</label>
											<div class="col-lg-4">
												<select class="form-control select4" name="slcMenuGroup" id="slcMenuGroup" required>
													<option value=""></option>
													<?php foreach($MenuGroup as $MenuGroup_item){
													?>
													<option value="<?=$MenuGroup_item['group_menu_id']?>" <?php if($Responsibility_item['group_menu_id']==$MenuGroup_item['group_menu_id']){echo "selected";} ?>><?=$MenuGroup_item['group_menu_name']?></option>
													<?php } ?>
												</select>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Report Group</label>
											<div class="col-lg-4">
												<select class="form-control select4" name="slcRepotGroup" id="slcRepotGroup" >
													<option value=""></option>
													<?php foreach($ReportGroup as $ReportGroup_item){
													?>
													<option value="<?=$ReportGroup_item['report_group_id']?>" <?php if($Responsibility_item['report_group_id']==$ReportGroup_item['report_group_id']){echo "selected";} ?>><?=$ReportGroup_item['report_group_name']?></option>
													<?php } ?>
												</select>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Organization</label>
											<div class="col-lg-4">
												<select class="form-control select4" name="slcOrganization" id="slcOrganization" required>
													<option value=""></option>
													<?php foreach($Organization as $Organization_item){
													?>
													<option value="<?=$Organization_item['org_id']?>" <?php if($Responsibility_item['org_id']==$Organization_item['org_id']){echo "selected";} ?>><?=$Organization_item['org_name']?></option>
													<?php } ?>
												</select>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Javascript yang dibutuhkan<span style="color: red">*</span></label>
											<div class="col-lg-4">
												<input type="text" class="form-control" name="txtJavascript" placeholder="Input Javascript" value="<?php echo $Responsibility_item['required_javascript'] ?>">
											</div>
									</div>
									<div class="form-group" style="color: red">
										<div class="col-lg-12">
											<i>*) khusus untuk file custom js yang ada di folder assets/js, jika lebih dari satu maka gunakan semicolon (;) sebagai pemisah. Contoh : customAA.js;customBB.js</i>
										</div>
									</div>
								</div>
								
							</div>
							<div class="panel-footer">
								<div class="row text-right">
									<a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
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