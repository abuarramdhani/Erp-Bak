<section class="content">
	<div class="inner" >
		<div class="row">
			<form method="post" action="<?php echo site_url('SystemAdministration/Module/CreateModule')?>" class="form-horizontal">
					<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
					<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
					<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
			<div class="col-lg-12">
				<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-11">
								<div class="text-right">
								<h1><b> New Module</b></h1>

								</div>
							</div>
							<div class="col-lg-1 ">
								<div class="text-right hidden-md hidden-sm hidden-xs">
									<a class="btn btn-default btn-lg" href="<?php echo site_url('SystemAdministration/Module/');?>">
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
							<div class="panel-body">
								<div class="row">
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Module Name</label>
											<div class="col-lg-4">
												<input type="text" placeholder="Module Name" name="txtModuleName" class="form-control toupper" required/>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Module ShortName</label>
											<div class="col-lg-4">
												<input type="text" maxlength="3" placeholder="Module ShortName" name="txtShortName" id="txtShortName" class="form-control" />
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Module Link </label>
											<div id="divPassCheck" class="col-lg-4">
												<input type="text" placeholder="Module Link" name="txtModuleLink" id="txtModuleLink" class="form-control" />
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Menu Icon</label>
											<div class="col-lg-4">
												<input type="text" placeholder="Icon" name="txtMenuIcon" id="txtMenuIcon" class="form-control" />
											</div>
									</div>
								</div>
							</div>
							<div class="panel-footer">
								<div class="row text-right">
									<a href="<?php echo site_url('SystemAdministration/Module/');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
									&nbsp;&nbsp;
									<button id="btnUser" class="btn btn-primary btn-lg btn-rect">Save Data</button>
								</div>
							</div>
						</div>
						</div>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</section>