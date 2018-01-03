<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b>Edit Ploting Job</b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url("MonitoringICT/PlotingJoblist/Edit/$id_perangkat");?>">
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
								Form Edit Ploting
							</div>
							<div class="box-body">
								<div class="row">
									<form action="<?php echo base_url('MonitoringICT/PlotingJoblist/saveEdit') ?>" method="post">
										<input type="hidden" name="idPerangkat" value="<?= $id_perangkat;?>">
									<?php foreach ($dataJoblist as $DJ) { ?>
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-2">Perangkat</label>
												<div class="col-lg-4">
													<?= $DJ['host'] ?>
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-2">Jenis Perangkat</label>
												<div class="col-lg-4">
													<?= $DJ['jenis_perangkat'] ?>
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-2">Periode Monitoring</label>
												<div class="col-lg-2">
													<select required name="slcPeriod" class="form-control select4">
														<option></option>
														<?php foreach ($period as $Prd) { ?>
															<option <?= $Prd['periode_monitoring_id'] == $DJ['periode_monitoring_id'] ? 'selected' :'' ?> value="<?= $Prd['periode_monitoring_id'] ?>"><?= $Prd['periode_monitoring'] ?> 
															</option>
														<?php } ?>
													</select>
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-2">PIC</label>
												<div class="col-lg-4">
													<select name="slcPic[]" class="form-control select4 " multiple>
														<option></option>
														<?php 
														$PN = array();
														foreach ($DJ['pic'] as $PicNow) {
															$PN[] = $PicNow['employee_id'];
														}

														foreach ($pic as $P) { ?>
															<option 
																<?php if ($PN != null ) echo in_array($P['employee_id'], $PN) ? 'selected' :'' ?> 
																value="<?= $P['employee_id'] ?>"><?= $P['employee_code'].' - '.$P['employee_name'] ?> 
															</option>
														<?php } ?>
													</select>
															
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<button type="submit" class="btn btn-primary ">SAVE</button>
										<a href="<?php echo base_url("MonitoringICT/PlotingJoblist/"); ?>">
										<button type="button" class="btn btn-default ">CANCEL</button>
										</a>
									</div>
									<?php } ?>
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
