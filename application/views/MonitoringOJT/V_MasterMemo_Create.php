<section class="content">
	<div class="inner">
		<div class="row">
			<form class="form-horizontal" method="post" action="<?php echo base_url('OnJobTraining/MasterMemo/create');?>" enctype="multipart/form-data">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-11">
								<div class="text-right">
									<h1><b><?php echo $Title;?></b></h1>
								</div>
							</div>
							<div class="col-lg-1">
								<div class="text-right hidden-md hidden-sm hidden-xs">
									<a class="btn btn-default btn-lg" href="<?php echo site_url('OnJobTraining/MasterMemo');?>">
										<i class="icon-wrench icon-2x"></i>
									</a>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary box-solid">
								<div class="box-header with-border">
									<h3 class="box-title">Daftar Format Memo</h3>
								</div>
								<div class="box-body">
									<div class="panel-body">
										<div class="form-group">
											<label for="txtJenisMemo" class="control-label col-lg-2">Jenis Memo</label>
											<div class="col-lg-4">
												<input type="text" class="form-control" style="text-transform: uppercase; width: 100%" name="txtJenisMemo">
											</div>
										</div>
										<div class="form-group">
											<label for="txaFormatMemo" class="control-label col-lg-2">Format Memo</label>
											<div class="col-lg-8">
												<textarea name="txaFormatMemo" style="width: 100%" id="MonitoringOJT-Memo-txaFormatMemo" class="form-control"></textarea>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<div class="row text-right">
                                            <a href="<?php echo base_url('OnJobTraining/MasterMemo');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
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