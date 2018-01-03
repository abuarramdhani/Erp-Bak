<style type="text/css">
	.style1{
		font-size: 14px;
	}
</style>
<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b>Ploting Job Monitoring</b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('MonitoringICT/PlotingJoblist');?>">
									<i class="icon-user icon-2x"></i>
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
								<b> Daftar Ploting Job </b>
							</div>
							<div class="box-body">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover text-left tblMonitoring " id="tblUser" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="5%"><center>No</center></th>
												<th width="15%"><center>Jenis Perangkat</center></th>
												<th width="28%"><center>Server</center></th>
												<th width="12%"><center>Periode Monitoring</center></th>
												<th width="30%"><center>PIC</center></th>
												<th width="10%"><center>Action</center></th>
											</tr>
										</thead>
										<tbody>
											<?php $no = 1; foreach ($dataJoblist as $DJ) { ?>
											<tr class="style1">
												<td><?= $no++; ?></td>
												<td><?= $DJ['jenis_perangkat']?></td>
												<td><?= $DJ['host'] ?></td>
												<td><?= $DJ['periode_monitoring']?></td>
												<td>
													<?php 
														if ($DJ['pic']) {
															foreach ($DJ['pic'] as $picjob) {
																echo '- ('.$picjob['employee_code'].') '.$picjob['employee_name'].'<br>';
															}
														}
													?>
												</td>
												<td>
													<center>
														<a href="<?php echo base_url("MonitoringICT/PlotingJoblist/Edit/$DJ[perangkat_id]") ?>">
														<button class="btn btn-xs btn-warning">
															<i class="fa fa-edit"></i> Edit
														</button>
														</a>
													</center>
												</td>
											</tr>
											<?php }?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
	</div>
	</div>
</section>