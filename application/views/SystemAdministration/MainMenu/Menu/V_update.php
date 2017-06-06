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
								<a class="btn btn-default btn-lg" href="<?php echo site_url('SystemAdministration/Menu');?>">
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
						foreach ($Menu as $Menu_item): 
						?>
							<form method="post" id="form-buying-type" action="<?php echo site_url('SystemAdministration/Menu/UpdateMenu/'.$id)?>" class="form-horizontal">
							<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
							
							<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" id="hdnDate" />
							<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" id="hdnUser" />
							<div class="panel-heading text-left">
							</div>
							
							<div class="panel-body">
								<div class="row">
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Menu Name</label>
											<div class="col-lg-4">
												<input type="text" placeholder="Repot Name" name="txtMenuName" id="txtMenuName" value="<?= $Menu_item['menu_name'] ?>" class="form-control" required/>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Menu Link</label>
											<div class="col-lg-4">
												<input type="text" placeholder="Menu Link" name="txtMenuLink" id="txtMenuLink" value="<?= $Menu_item['menu_link'] ?>" class="form-control" required/>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Menu Icon</label>
											<div class="col-lg-4">
												<input type="text" placeholder="Icon" name="txtMenuIcon" id="txtMenuIcon" value="<?= $Menu_item['menu_fa'] ?>" class="form-control" />
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Menu Title</label>
											<div class="col-lg-4">
												<input type="text" placeholder="Title" name="txtMenuTitle" id="txtMenuTitle" value="<?= $Menu_item['menu_title'] ?>" class="form-control" />
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