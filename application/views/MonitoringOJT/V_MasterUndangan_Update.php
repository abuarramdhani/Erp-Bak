<section class="content">
	<div class="inner">
		<div class="row">
			<form class="form-horizontal" method="post" action="<?php echo base_url('OnJobTraining/MasterUndangan/update'.'/'.$id);?>" enctype="multipart/form-data">
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
									<a class="btn btn-default btn-lg" href="<?php echo site_url('OnJobTraining/MasterUndangan');?>">
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
									<h3 class="box-title">Edit Format Undangan</h3>
								</div>
								<div class="box-body">
									<?php
										foreach ($dataFormatUndangan as $formatUndangan) 
										{
									?>
									<div class="panel-body">
										<div class="form-group">
											<label for="txtJenisUndangan" class="control-label col-lg-2">Jenis Undangan</label>
											<div class="col-lg-4">
												<input type="text" class="form-control" style="text-transform: uppercase; width: 100%" name="txtJenisUndangan" value="<?php echo $formatUndangan['judul'];?>">
											</div>
										</div>
										<div class="form-group">
											<label for="txaFormatUndangan" class="control-label col-lg-2">Format Undangan</label>
											<div class="col-lg-8">
												<textarea name="txaFormatUndangan" style="width: 100%" id="MonitoringOJT-Undangan-txaFormatUndangan" class="form-control"><?php echo $formatUndangan['memo'];?></textarea>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<div class="row text-right">
                                            <a href="<?php echo base_url('OnJobTraining/MasterUndangan');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
                                        </div>
									</div>
									<?php
										}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>