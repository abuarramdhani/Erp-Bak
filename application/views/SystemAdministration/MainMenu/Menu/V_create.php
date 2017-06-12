<section class="content">
	<div class="inner" >
		<div class="row">
			<form method="post" action="<?php echo site_url('SystemAdministration/Menu/CreateMenu')?>" class="form-horizontal">
					<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
					<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
					<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
			<div class="col-lg-12">
				<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-11">
								<div class="text-right">
								<h1><b><?= $Title?></b></h1>

								</div>
							</div>
							<div class="col-lg-1 ">
								<div class="text-right hidden-md hidden-sm hidden-xs">
									<a class="btn btn-default btn-lg" href="<?php echo site_url('SystemAdministration/User/');?>">
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
											<label for="norm" class="control-label col-lg-4">Menu Name</label>
											<div class="col-lg-4">
												<input type="text" placeholder="Username" name="txtMenuName" id="txtMenuName" class="form-control" required/>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Menu Link</label>
											<div class="col-lg-4">
												<input type="text" placeholder="Menu Link" name="txtMenuLink" id="txtMenuLink" class="form-control" required/>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Menu Icon</label>
											<div class="col-lg-4">
												<input type="text" placeholder="Icon" name="txtMenuIcon" id="txtMenuIcon" class="form-control" />
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Menu Title</label>
											<div class="col-lg-4">
												<input type="text" placeholder="Title" name="txtMenuTitle" id="txtMenuTitle" class="form-control" />
											</div>
									</div>
								</div>
								
							</div>
							<div class="panel-footer">
								<div class="row text-right">
									<a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
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