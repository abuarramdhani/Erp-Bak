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
								<h1><b> Aktivitas Monitoring Hardware</b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('MonitoringICT/MonitoringAll');?>">
									<i class="icon-desktop icon-2x"></i>
									<span ><br /></span>
								</a>
							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<?php foreach ($DataMonitoring as $DM) { ?>
					<div class="col-lg-12">
						<div class="box <?= $DM['cls_tbl'] ?> box-solid">
							<div class="box-header <?= $DM['cls_tbl2']=='bg-purple' ? 'bg-purple' :'' ?> with-border">
								<b> <?= strtoupper($DM['periode_monitoring']); ?></b>
							</div>
							<div class="box-body">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover text-left tblMonitoring " id="tbl<?= $DM['periode_monitoring']; ?>" style="font-size:12px;">
										<thead>
											<tr class="<?= $DM['cls_tbl2'] ?>">
												<th width="5%"><center>No</center></th>
												<th width="12%"><center>Jenis Perangkat</center></th>
												<th width="20%"><center>Server</center></th>
												<th width="25%"><center>Aspek</center></th>
												<th width="10%"><center>Last Action</center></th>
												<th width="20%"><center>PIC</center></th>
												<th width="8%"></th>
											</tr>
										</thead>
										<tbody>
											<?php $no=1; foreach ($DM['detail_period'] as $DP) { ?>
												<tr class="style1" <?= $DP['nomor_order'] != null ? 'style="background-color:#ffcece"' :'' ?>>
													<td><?= $no++; ?></td>
													<td><?= $DP['jenis_perangkat'] ?></td>
													<td><?= $DP['host'] ?></td>
													<td>
														<?php 
														if (isset($DP['aspek_hasil'])) foreach ($DP['aspek_hasil'] as $asp) {
															if ($asp['jenis_standar'] =='nn') {
																$hasil = $asp['hasil_pengecekan'] == '1' ? 'Y' : 'T';
															}else{
																$hasil = $asp['hasil_pengecekan'].' %';
															}

															echo ' - '.$asp['aspek']. '<b>['.$hasil.']</b><br>';
														}
													?>
													</td>
													<td>
														<center>
														<?php 
														if ($DP['tgl_monitoring'] != null) {
															$tanggal = new DateTime($DP['tgl_monitoring']);
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
															if ($DP['periode_monitoring_id']) {
																switch ($DP['periode_monitoring_id']) {
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
														</center>
													</td>
													<td>
														<?php foreach ($DP['pic'] as $pic) { 
																	echo ' - '.$pic['employee_name'].'<br>';
														}
														 ?>
													</td>
													<td>
														<center>
														<a href="<?php echo base_url("MonitoringICT/JobListMonitoring/Detail/$DP[perangkat_id]/$DP[periode_monitoring_id]") ?>">
														<button class="btn btn-info btn-xs">Detail</button>
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
					<?php } ?>

				</div>
			</div>
	</div>
	</div>
</section>