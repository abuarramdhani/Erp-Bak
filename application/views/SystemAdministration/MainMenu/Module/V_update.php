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
								<a class="btn btn-default btn-lg" href="<?php echo site_url('SystemAdministration/Module');?>">
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
						foreach ($Module as $Mod): 
						?>
							<form method="post" id="form-buying-type" action="<?php echo site_url('SystemAdministration/Module/UpdateModule/'.$id)?>" class="form-horizontal">
							<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
							
							<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" id="hdnDate" />
							<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" id="hdnUser" />
							<div class="panel-heading text-left">
							</div>
							
							<div class="panel-body">
								<div class="row">
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Module Name</label>
											<div class="col-lg-4">
												<input type="text" placeholder="Repot Name" name="txtModuleName" id="txtModuleName" value="<?= $Mod['module_name'] ?>" class="form-control" required/>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Module ShortName</label>
											<div class="col-lg-4">
												<input type="text" maxlength="3" placeholder="Module ShortName" name="txtShortName" id="txtShortName" class="form-control" value="<?= $Mod['module_shortname'] ?>" />
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Module Link </label>
											<div id="divPassCheck" class="col-lg-4">
												<input type="text" placeholder="Module Link" name="txtModuleLink" id="txtModuleLink" class="form-control" value="<?= $Mod['module_link'] ?>"/>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Menu Icon</label>
											<div class="col-lg-4">
												<input type="text" placeholder="Icon" name="txtMenuIcon" id="txtMenuIcon" class="form-control"  value="<?= $Mod['module_image'] ?>"/>
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