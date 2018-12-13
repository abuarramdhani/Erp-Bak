<section class="content">
	<div class="inner" >
		<div class="row">
			<form method="post" action="<?php echo site_url('Warehouse/MasterItem/importCreateUsableItem')?>" enctype="multipart/form-data" class="form-horizontal">
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
									<a class="btn btn-default btn-lg" href="<?php echo site_url('Warehouse');?>">
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
								<a href="<?php echo site_url('Warehouse/MasterItem/CreateUsableItem') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="View Example Document" >
									<button type="button" class="btn btn-default btn-sm">
									  <i class="icon-search icon-2x"></i>
									</button>
								</a>
							</div>
						<div class="box-body">
							<div class="panel-body">
								<div class="row col-lg-12">
									<div class="form-group">
											<label for="norm" class="control-label col-md-4 text-center">Import Excel</label>
											<div class="col-md-4">
												<input type="file" placeholder="Barcode" name="fileScan" id="fileScan" class="form-control" required/>
											</div>
									</div>
								</div>
							</div>
							<div class="panel-footer">
								<div class="row text-right">
									<a href="<?php echo site_url('Warehouse/MasterItem/Usable') ?>" class="btn btn-primary btn-lg btn-rect">Close</a>
									&nbsp;&nbsp;
									<button id="btnUser" class="btn btn-primary btn-lg btn-rect">Import</button>
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