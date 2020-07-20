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
						<b>Form Penjadwalan Pelatihan</b>
					</div>
					<div class="box-body">
					<?php foreach($details as $dt){?>
						<div class="row" style="margin: 10px 10px">
							<?php echo $alert; ?>
							<label class="col-lg-offset-2 col-lg-8 control-label" align="center">
								<h3><b><?php echo $dt['training_name']?></b></h3>
							</label>
						</div>
					<form method="post" action="<?php echo base_url('ADMPelatihan/Penjadwalan/Add')?>">
						<div class="col-lg-offset-2 col-lg-8">
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Nama Pelatihan</label>
									<div class="col-lg-9">
										<input name="txtNamaPelatihan" id="txtNamaPelatihan" class="form-control toupper" placeholder="Nama Pelatihan" required value="<?php echo $dt['training_name']?>" readonly>
										<input name="txtTrainingId" value="<?php echo $dt['training_id']?>" hidden>
										<!-- isi standar nilai -->
										<input type="hidden" name="txtStandarNilai" value="<?php echo $dt['limit_1'].','.$dt['limit_2']?>"> 
									</div>
								</div>
							</div>

							<div class="row" style="margin: 10px 10px">
								<div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											<b>Tujuan Pelatihan :</b>
										</div>
										<div class="panel-body">
											<?php foreach($purpose as $pr){ ?>
											<i class="fa fa-angle-right"></i><?php echo ' '.$pr['purpose'] ?><br>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<label class="col-lg-12 control-label"><b>Pelaksanaan</b></label>
							</div>
							<!-- INPUT GROUP 1 ROW 2 -->
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Tanggal</label>
									<div class="col-lg-9">
										<input name="txtTanggalPelaksanaan" class="form-control singledateADM checkdateSch" placeholder="Tanggal" id="checkdateSch" required >
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Waktu</label>
									<div class="col-lg-4 ">
										<div class="bootstrap-timepicker timepicker">
											<input name="txtWaktuMulai" class="form-control" placeholder="Waktu" id="TrainingStartTime" onkeypress="return isNumberKey(event)" required >
										</div>
									</div>
									<label class="col-lg-1 control-label" align="center">-</label>
									<div class="col-lg-4">
										<div class="bootstrap-timepicker timepicker">
											<input name="txtWaktuSelesai" class="form-control"  placeholder="Waktu" id="TrainingEndTime" onkeypress="return isNumberKey(event)" required >
										</div>
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Ruang </label>
									<div class="col-lg-9">
										<select class="form-control SlcRuang" name="slcRuang" data-placeholder="Ruang" required>
											<option></option>
											<?php foreach($room as $rm){?>
											<option value="<?php echo $rm['room_name']?>"><?php echo $rm['room_name'] ?></option>
											<?php }?>
										</select>
									</div>
								</div>
							</div>
							<br>
							<div class="row" style="margin: 10px 10px">
								<div class="col-md-3">
									<label class="control-label">Trainer</label>
								</div>
								<div class="col-md-9">
									<div class="form-group">
										<div class="input-group">
											<div class="input-group-addon">
												<i class="glyphicon glyphicon-user"></i>
											</div>
											<select class="form-control select4" name="slcTrainer[]" id="slcTrainer" multiple="multiple" required>
												<option value=""></option>
												<?php foreach($trainer as $tr){ ?>
													<option value="<?php echo $tr['trainer_id']?>"><?php echo $tr['trainer_name']?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Evaluasi</label>
									<div class="col-lg-9">
	  									<select class="form-control select4" name="slcEvaluasi[]" data-placeholder="   Evaluasi" id="slcEvaluasi" multiple="multiple" required>
												<option value=""></option>
												<?php foreach($GetEvaluationType as $et){ ?>
													<option value="<?php echo $et['evaluation_type_id']?>">
														<?php echo $et['evaluation_type_description'];?>
													</option>
												<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Sifat </label>
									<div class="col-lg-9">
										<select class="form-control SlcRuang" name="slcSifat" data-placeholder="Order/Tahunan" required>
											<option></option>
											<option value="1">Order</option>
											<option value="2">Tahunan</option>
										</select>
									</div>
								</div>
							</div>
							<!-- ORIENTASI/NON ORIENTASI -->
							<?php  ?>
							<input name="txtJenis" value="2" hidden></input>	

							<!-- PESERTA -->
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Peserta</label>
									<div class="col-lg-4">
										<select class="form-control select2" name="slcPeserta">
										<?php foreach($ptctype as $py) {?> 
											<option value="<?php echo $py['participant_type_id']?>">
												<?php echo $py['participant_type_description']?>
											</option>
										<?php }?>
										</select>
									</div>
									<label class="col-lg-1 control-label">Jumlah Peserta</label>
									<div class="col-lg-4">
										<input name="txtJumlahPeserta" id="jmlpeserta" class="form-control" placeholder="Jumlah Peserta" onkeypress="return isNumberKey(event)" maxlength=2 required >
									</div>
								</div>
							</div>

							<div class="row" style="margin: 10px 10px">
								<div class="col-md-12">
									<div class="panel panel-default">
										<div class="panel-heading text-right">
											<a href="javascript:void(0);" class="btn btn-sm btn-primary" id="AddParticipant" title="Tambah Baris" onclick="AddParticipant('<?php echo base_url(); ?>')"><i class="fa fa-plus"></i></a>
											<a href="javascript:void(0);" class="btn btn-sm btn-danger" id="DelParticipant" title="Hapus Baris" onclick="deleteRow('tblParticipant')"><i class="fa fa-remove"></i></a>
											<a id="HiddenDelObjective" onclick="deleteRow('tblParticipant')" hidden >Hidden</a>
										</div>
										<div class="panel-body">
											<div class="table-responsive" >
												<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;" name="tblParticipant" id="tblParticipant">
													<thead>
														<tr class="bg-primary">
															<th width="5%" class="sorting_disabled" rowspan="1" colspan="1" style="width: 48.7778px;">NO</th>
															<th width="90%">Daftar Peserta</th>
															<th width="10%"></th>
														</tr>
													</thead>
													<tbody id="tbodyParticipant">
														<tr class="clone">
															<td ><?php echo $number++;?></td>
															<td>
																<div class="input-group">
																	<div class="input-group-addon">
																		<i class="glyphicon glyphicon-user"></i>
																	</div>
																	<select class="form-control js-slcEmployeeTraining" name="slcEmployee[]" id="slcEmployee" required>
																		<option value=""></option>
																	</select>
																</div>
															</td>
															<td>
																<button type="button" class="btn btn-danger list-del"><i class="fa fa-remove"></i></button>
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
									<a href="<?php echo site_url('ADMPelatihan/Penjadwalan');?>"  class="btn btn-primary btn btn-flat">Back</a>
									&nbsp;&nbsp;
									<button type="submit" class="btn btn-success btn btn-flat">Save Data</button>
								</div>
							</div>
						</div>
					</form>
					<?php } ?>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>
