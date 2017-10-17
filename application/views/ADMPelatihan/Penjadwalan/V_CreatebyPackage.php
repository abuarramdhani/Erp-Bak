<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Penjadwalan</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/MasterTraining');?>">
                                <i class="icon-wrench icon-2x"></i>
                                <span><br/></span>	
                            </a>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<b>Form Penjadwalan Paket Pelatihan</b>
					</div>
					<div class="box-body">
					<?php foreach($packscheduling as $packs){ ?>
						<div class="row" style="margin: 10px 10px">
							<label class="col-lg-offset-2 col-lg-8 control-label" align="center">
								<h3><b><?php echo $packs['package_scheduling_name']?></b></h3>
							</label>
						</div>
					<?php } ?>
					<!-- <form method="post" action="<?php echo base_url('ADMPelatihan/Penjadwalan/addbypackage')?>"> -->
					<?php 
    echo form_open(base_url('ADMPelatihan/Penjadwalan/addbypackage'));
   ?>
						<input name="txtPackageSchedulingId" value="<?php echo $pse?>" hidden>
						<?php foreach($daynumber as $day){ ?>
						<input id="dayrange" value="<?php echo $day['day']?>" hidden>
						<?php } ?>
						<div class="col-lg-offset-2 col-lg-8">
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Tanggal Pelaksanaan</label>
									<div class="col-lg-4">
										<input class="form-control startdate" placeholder="Tanggal" required >
									</div>
									<label class="col-lg-1 control-label" align="center">-</label>
									<div class="col-lg-4">
										<input class="form-control enddate" placeholder="Tanggal" required disabled="true">
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="row" style="margin: 10px 10px">
								<div class="col-lg-12">
									<br>
									<div class="panel panel-default">
										<div class="panel-heading text-center">
											<b>Jadwal Pelatihan</b>
										</div>
										<div class="panel-body">
											<table class="table table-sm table-bordered table-hover text-center" style="table-layout:fixed;width:1400px;" name="tblpackagetraining" id="tblpackagetraining">
												<thead>
													<tr class="bg-primary">
														<th width="3%">No</th>
														<th width="5%">Hari Ke</th>
														<th width="27%">Pelatihan</th>
														<th width="15%">Tanggal</th>
														<th width="15%">Ruang</th>
														<th width="20%">Trainer</th>
														<th width="15%">Evaluasi</th>
													</tr>
												</thead>
												<tbody id="tbodyObjective">
													<?php $no=0; foreach($traininglist as $tl){ $no++ ?>
													<tr class="obclone">
														<td><?php echo $no?></td>
														<td>
															<?php echo $tl['day'] ?>
															<input class="dday" value="<?php echo $tl['day']?>" hidden >
														</td>
														<td>
															<input name="txtNamaPelatihan[]" class="form-control" style="width:100%" placeholder="Scheduling Name" value="<?php echo $tl['training_name'] ?>">
															<input name="txtTrainingId[]" value="<?php echo $tl['training_id']?>" hidden>
															<input name="txtPackageTrainingId[]" value="<?php echo $tl['package_training_id']?>" hidden>
														</td>
														<td>
															<input class="dday-tgl form-control" name ="txtTanggalPelaksanaan[]" value="" placeholder="Tanggal" style="width:95%">
														</td>
														<td>
															<select class="form-control SlcRuang" name="slcRuang[]" data-placeholder="Ruang" style="width:95%">
																<option></option>
																<?php foreach($room as $rm){?>
																<option value="<?php echo $rm['room_name']?>" style="width:95%"><?php echo $rm['room_name'] ?></option>
																<?php }?>
															</select>
														</td>
														<td>
															<select class="form-control select4" name="<?php echo 'slcTrainer'.$no.'[]' ?>" id="slcTrainer" multiple="multiple" required style="width:95%">
																<option value=""></option>
																<?php foreach($trainer as $tr){ ?>
																<option value="<?php echo $tr['trainer_id']?>"><?php echo $tr['trainer_name']?></option>
																<?php } ?>
															</select>
														</td>
														<td style="text-align:left;">
															<div class="col-lg-9">
																<input type="checkbox" name="<?php echo 'chk'.$no.'[]' ?>" value="1"> Wawasan<br>
							  									<input type="checkbox" name="<?php echo 'chk'.$no.'[]' ?>" value="2"> Pengetahuan<br>
							  									<input type="checkbox" name="<?php echo 'chk'.$no.'[]' ?>" value="3"> Perilaku
															</div>
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
						<div class="col-lg-offset-2 col-lg-8">
							<?php foreach($packscheduling as $pse){
								$participanttype=$pse['participant_type'];
								$Peserta='';
								if($pse['participant_type']==0){$Peserta='Staff';}
								elseif($pse['participant_type']==1){$Peserta='Non Staff';}
								elseif($pse['participant_type']==2){$Peserta='Staff & Non Staff';}
							?>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Jumlah Peserta</label>
									<div class="col-lg-4">
										<input name="txtJumlahPeserta" id="jmlpeserta" class="form-control" placeholder="Jumlah Peserta" onkeypress="return isNumberKey(event)" maxlength=2 required >
									</div>
									<label class="col-lg-1 control-label">Peserta</label>
									<div class="col-lg-4">
										<input class="form-control" value="<?php echo $Peserta ?>" readonly>
										<input name="txtPeserta" value="<?php echo $pse['participant_type'] ?>" type="hidden">
									</div>
								</div>
							</div>
							<?php } ?>
							<br/>
							<div class="row" style="margin: 10px 10px">
								<div class="col-md-12">
									<div class="panel panel-default">
										<div class="panel-heading text-right">
											<a href="javascript:void(0);" class="btn btn-sm btn-primary" id="AddParticipant" title="Tambah Baris" onclick="AddParticipant('<?php echo base_url(); ?>')"><i class="fa fa-plus"></i></a>
											<a id="HiddenDelObjective" onclick="deleteRow('tblParticipant')" hidden >Hidden</a>
										</div>
										<div class="panel-body">
											<div class="table-responsive" >
												<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;" name="tblParticipant" id="tblParticipant">
													<thead>
														<tr class="bg-primary">
															<th width="10%">No</th>
															<th width="90%">Daftar Peserta</th>
															<th width="10%"></th>
														</tr>
													</thead>
													<tbody id="tbodyParticipant">
														<tr class="clone" row-id="<?php echo $number;?>">
															<td ><?php echo $number;?></td>
															<td>
																<div class="input-group">
																	<div class="input-group-addon">
																		<i class="glyphicon glyphicon-user"></i>
																	</div>
																	<select class="form-control js-slcEmployee" name="slcEmployee[]" id="slcEmployee" required>
																		<option value=""></option>
																	</select>
																</div>
															</td>
															<td>
																<button type="button" class="btn btn-danger" onclick="deleteRowAjax(<?php echo $number++?>)"><i class="fa fa-remove"></i></button>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>

							<hr>
							<div class="form-group">
								<div class="col-lg-12 text-right">
									<a href="javascript:window.history.go(-1);" class="btn btn-primary btn btn-flat">Back</a>
									&nbsp;&nbsp;
									<button type="submit" class="btn btn-success btn btn-flat">Save Data</button>
								</div>
							</div>
						</div>
						<?php
							echo form_close();
						?>
					<!-- <form> -->
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
