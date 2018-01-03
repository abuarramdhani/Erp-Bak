<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b>Job List</b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('MonitoringICT/JobListMonitoring');?>">
									<i class="icon-desktop icon-2x"></i>
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
								<!-- <a href="<?php echo site_url('MonitoringFileServer/InputMonitoring') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
									<button type="button" class="btn btn-default btn-sm">
									  <i class="icon-plus icon-2x"></i>
									</button>
								</a> -->
								Daftar Monitoring
							</div>
							<div class="box-body">
								<div class="table-responsive">
									
									<table class="table table-striped table-bordered table-hover text-left" id="tblUser" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="5%"><center>No</center></th>
												<th width="20%"><center>Jenis Perangkat</center></th>
												<th width="25%"><center>Perangkat</center></th>
												<th width="20%"><center>Periode Monitoring</center></th>
												<th width="20%"><center>Last Action</center></th>
												<th width="10%"><center>Action</center></th>
											</tr>
										</thead>
										<tbody>
											<?php $no = 1; foreach ($DataMonitoring as $DM) { ?>
											<tr>
												<td><?= $no++; ?></td>
												<td><?= $DM['jenis_perangkat'] ?></td>
												<td><?= $DM['host'] ?></td>
												<td><?= $DM['periode_monitoring'] ?></td>
												<td>												
												<?php 
														if ($DM['tgl_monitoring'] != null) {
															$tanggal = new DateTime($DM['tgl_monitoring']);
															$tanggal2 = new DateTime();
															$scp =  $tanggal->diff($tanggal2)->format("%a");
															if ($scp >= 30) {
																$a = floor($scp/30) ;
																$b = $scp % 30;
																$month = $a > 1 ? $a.' Months' : $a.'Month';
																if ($b > 0) {
																	$day = $b > 1 ? $b.' Days' : $b.'Day';
																}else{ $day ='';}
																   $last_act = $month.' '.$day.' Ago';
																
															}elseif($scp > 0) {
																$last_act = $scp > 1 ? $scp.' Days Ago' : $scp.' Day Ago';
															}elseif($scp == 0) {
																$last_act = 'Today';
															}
															if ($DM['periode_monitoring_id']) {
																switch ($DM['periode_monitoring_id']) {
																	case '1':
																		echo $scp > 0 ? '<span class="badge bg-red faa-flash faa-slow animated">'.$last_act.'</span>' : '<span class="badge bg-green ">'.$last_act.'</span>'; 
																		break;
																		break;
																	case '2':
																		echo $scp > 7 ? '<span class="badge bg-red faa-flash faa-slow animated">'.$last_act.'</span>' : '<span class="badge bg-green ">'.$last_act.'</span>'; 
																		break;
																	case '3':
																		echo $scp > 30 ? '<span class="badge bg-red faa-flash faa-slow animated">'.$last_act.'</span>' : '<span class="badge bg-green ">'.$last_act.'</span>'; 
																		break;
																	
																} 
																
															}else{
																echo '<span class="badge bg-green ">'.$last_act.'</span>';
															}
														}else{
															echo '';
														}
													?>
												</td>
												<td>
													<center>
														<a href="<?php echo base_url("MonitoringICT/JobListMonitoring/Detail/$DM[perangkat_id]/$DM[periode_monitoring_id]") ?>">
														<button class="btn btn-primary btn-xs">Detail</button>
														</a>
													</center>
												</td>
											</tr>
											<?php } ?>
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