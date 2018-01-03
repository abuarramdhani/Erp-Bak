<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b>Edit Monitoring</b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url("MonitoringICT/JobListMonitoring/Edit/$id_monitoring");?>">
									<i class="icon-pencil icon-2x"></i>
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
								
								Form Edit Hasil Monitoring
							</div>
							<div class="box-body">
								<div class="row">
									<form action="<?php echo base_url('MonitoringICT/JobListMonitoring/saveEdit') ?>" method="post">
										<input type="hidden" name="idPerangkat" value="<?= $id_perangkat;?>">
										<input type="hidden" name="idPeriod" value="<?= $id_periode;?>">
										<input type="hidden" name="idMonitor" value="<?= $id_monitoring;?>">
										<input type="hidden" name="nmPerangkat" value="<?= $DataHasil != null ? $DataHasil[0]['host']  : ''?>">
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-2">Perangkat</label>
												<div class="col-lg-4">
													<?= $DataHasil != null ? $DataHasil[0]['host']  : ''?>
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-2">Jenis Perangkat</label>
												<div class="col-lg-4">
													<?= $DataHasil != null ? $DataHasil[0]['jenis_perangkat']  : ''?>
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-2">Tanggal Monitoring</label>
												<div class="col-lg-2">
													<?= $DataHasil != null ? date('d M Y', strtotime($DataHasil[0]['tgl_monitoring']) )  : ''?>
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group " >
												<label for="norm" class="control-label col-lg-12">Aspek QC</label>
												<div class="col-lg-1"></div>
												<div class="col-lg-6 panel panel-body" style=" background-color: #f5f5f5">
													<table class="table table-bordered table-hover" >
														<tr style="text-align: center;">
															<th width="60%" style="text-align: center;">Aspek</th>
															<th width="10%" style="text-align: center;">Standar</th>
															<th width="30%" style="text-align: center;">Hasil</th>
														</tr>
														<?php $i = 0; foreach ($Aspek as $asp) { ?>
														<tr>
															<td><?php echo $asp['aspek'] ?></td>
															<td><?php if ($asp['jenis_standar'] == 'nn') { 
																		echo $asp['standar'] == '=1' ? '<b>YA</b>' : '<b>TIDAK</b>';
																		}else{
																			echo '<b>'.$asp['standar'].'</b>';
																		}
																	?>
															</td>
															<td style="text-align: center;">
																<?php if ($asp['jenis_standar'] == 'nn') { ?>
																	<?php foreach ($asp as $key => $value) {
																		# code...
																	} ?>
																	<input type="radio" name="asp_<?php echo $asp['aspek_id'] ?>" value="1" 
																	<?= $DataHasil[$i]['hasil_pengecekan'] == 1 ? 'checked' : '' ?> ><b>YA</b> &nbsp;
																	<input type="radio" name="asp_<?php echo $asp['aspek_id'] ?>" value="0" 
																	<?= $DataHasil[$i]['hasil_pengecekan'] == 0 ? 'checked' : '' ?> ><b>TIDAK</b>
																<?php } 
																elseif ($asp['jenis_standar'] == 'n') { ?>
																	<input style="width: 50%; margin-left: 25%" type="text" onkeypress='return event.charCode <= 66 && event.charCode <=91' class="form-control" name="asp_<?php echo $asp['aspek_id'] ?>" value="<?= $DataHasil[$i]['hasil_pengecekan']?>" >
																<?php } ?>
																<input type="hidden" value="<?= $asp['jenis_standar']; ?>" name="jns_asp_<?php echo $asp['aspek_id'] ?>" >
																<input type="hidden" value="<?= $asp['standar']; ?>" name="std_asp_<?php echo $asp['aspek_id'] ?>" >
																<input type="hidden" value="<?= $asp['aspek_id']; ?>" name="aspID[]" >
																<input type="hidden" value="<?= $asp['aspek']; ?>" name="aspDESC[]" >
																<input type="hidden" value="<?= $DataHasil[$i]['hasil_monitoring_detail_id']; ?>" name="detID[]" >
															</td>
														</tr>
														<?php $i++; } ?>
													</table>
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-2">Info</label>
												<div class="col-lg-4">
													<textarea name="txtInfo" style="width: 100%"><?= $DataHasil[0]['info'] ?></textarea>
															
												</div>
										</div>
									</div>
									<?php
										if ($DataHasil) {
											if ($DataHasil[0]['nomor_order']) {?>
											<div class="col-lg-12" style="margin: 5px">
												<div class="form-group">
														<label for="norm" class="control-label col-lg-2">Nomor Order</label>
														<div class="col-lg-4">
															<?= $DataHasil[0]['nomor_order'] ?>
														</div>
												</div>
											</div>
											<?php }
										}
									?>
									<div class="col-lg-12" style="margin: 5px">
										<button type="submit" class="btn btn-primary ">SAVE</button>
										<a href="<?php echo base_url("MonitoringICT/JobListMonitoring/Detail/$id_perangkat/$id_periode"); ?>">
										<button type="button" class="btn btn-default ">CANCEL</button>
										</a>
									</div>
									</form>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	</div>
</section>
