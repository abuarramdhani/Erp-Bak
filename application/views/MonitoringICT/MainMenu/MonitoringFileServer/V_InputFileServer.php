<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b>Input Monitoring File Server</b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('MonitoringFileServer/InputMonitoring');?>">
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
								
								Form Input Log Server
							</div>
							<div class="box-body">
								<div class="row">
									<form action="<?php echo base_url('MonitoringFileServer/InputMonitoring/save') ?>" method="post">
										
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-2">Petugas</label>
												<div class="col-lg-4">
													<select data-placeholder="Pilih Petugas" class="form-control select2" name="slcPetugas" style="width: 100%">
														<option></option>
														<?php foreach ($Petugas as $Ptg) { ?>
															<option value="<?= $Ptg['employee_id']; ?>" ><?= $Ptg['employee_code'].' - '.$Ptg['employee_name']; ?></option>
														<?php } ?>
													</select>
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-2">Tanggal Monitoring</label>
												<div class="col-lg-2">
													<input type="text"  class="dateICT form-control" name="txtDate" value="<?php echo date('d/m/Y') ?>">
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-2">Ruang Server</label>
												<div class="col-lg-4">
													<select data-placeholder="Pilih Ruang Server" class="form-control select4" name="slcFileServer" style="width: 100%">
														<option></option>
														<?php foreach ($RuangServer as $RS) { ?>
															<option value="<?= $RS['perangkat_id']; ?>" ><?= $RS['host']; ?></option>
														<?php } ?>
													</select>
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
														<?php foreach ($Aspek as $asp) { ?>
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
																	<input type="radio" name="asp_<?php echo $asp['aspek_id'] ?>" value="1"><b>YA</b> &nbsp;
																	<input type="radio" name="asp_<?php echo $asp['aspek_id'] ?>" value="0"><b>TIDAK</b>
																<?php } elseif ($asp['jenis_standar'] == 'n') { ?>
																	<input style="width: 50%; margin-left: 25%" type="text" onkeypress='return event.charCode <= 66 && event.charCode <=91' class="form-control" name="asp_<?php echo $asp['aspek_id'] ?>">
																<?php } ?>
																<input type="hidden" value="<?= $asp['jenis_standar']; ?>" name="jns_asp_<?php echo $asp['aspek_id'] ?>" >
																<input type="hidden" value="<?= $asp['standar']; ?>" name="std_asp_<?php echo $asp['aspek_id'] ?>" >
																<input type="hidden" value="<?= $asp['aspek_id']; ?>" name="aspID[]" >
																<input type="hidden" value="<?= $asp['aspek']; ?>" name="aspDESC[]" >
															</td>
														</tr>
														<?php } ?>
													</table>
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-2">Info</label>
												<div class="col-lg-4">
													<textarea name="txtInfo" style="width: 100%"></textarea>
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<button type="submit" class="btn btn-primary ">SAVE</button>
										<a href="<?php echo base_url('MonitoringFileServer/Monitoring') ?>">
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
