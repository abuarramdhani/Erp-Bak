<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Record Pelatihan</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/Record');?>">
                                <i class="icon-wrench icon-2x"></i>
                                <span><br/></span>	
                            </a>
						</div>
					</div>
				</div>
			</div>
			<br/>
			
		<?php foreach($record as $rc){?>						
			<form method="post" action="<?php $id=$rc['scheduling_id'];echo base_url('ADMPelatihan/Record/EditSave/'.$id);?>">
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<b>Record Pelatihan</b>
					</div>
					<div class="box-body">
						<div class="row" style="margin: 10px 10px">
							<label class="col-lg-offset-2 col-lg-8 control-label" align="center">
								<h3><b><?php echo $rc['training_name']?></b></h3>
							</label>
						</div>
						<div class="col-lg-offset-2 col-lg-8">
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Nama Pelatihan</label>
									<div class="col-lg-9">	
										<input type="text" name="txtNamaPelatihan" class="form-control toupper" placeholder="Nama Pelatihan" value="<?php echo $rc['scheduling_name']?>" required>
									</div>
								</div>
							</div>
							
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Tanggal</label>
									<div class="col-lg-9">
										<input type="text" name="txtTanggalPelaksanaan" value="<?php echo $rc['date_foredit']?>" class="form-control singledateADM" placeholder="Tanggal" required >
										<input type="text" id="scheduledate" value="<?php echo $rc['date_foredit']?>" hidden>
									</div>
								</div>
							</div>
						
							<?php if ($rc['package_scheduling_id']==0 && $rc['package_training_id']==0) {?>
								<div class="row" style="margin: 10px 10px">
									<div class="form-group">
										<label class="col-lg-3 control-label">Waktu</label>
										<div class="col-lg-4 ">
											<div class="bootstrap-timepicker timepicker">
												<input type="text" name="txtWaktuMulai" class="form-control" placeholder="Waktu" id="TrainingStartTime" onkeypress="return isNumberKey(event)" value="<?php echo $rc['start_time']?>" required >
											</div>

										</div>
										<label class="col-lg-1 control-label" align="center">-</label>
										<div class="col-lg-4">
											<div class="bootstrap-timepicker timepicker">
												<input type="text" name="txtWaktuSelesai" class="form-control"  placeholder="Waktu" id="TrainingEndTime" onkeypress="return isNumberKey(event)"  value="<?php echo $rc['end_time']?>" required >
											</div>
										</div>
									</div>
								</div>
							<?php } ?>

							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Ruang</label>
									<div class="col-lg-9">
										<select class="form-control SlcRuang" name="slcRuang" data-placeholder="Ruang" required>
											<option></option>
											<?php
												foreach($room as $rm){
												$selected='';if($rc['room']==$rm['room_name']){$selected='selected';}
											?>
											<option <?php echo $selected ?> value="<?php echo $rm['room_name']?>"><?php echo $rm['room_name'] ?></option>
											<?php }?>
										</select>
									</div>
								</div>
							</div>

							<hr>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
								<label class="col-lg-3 control-label">Evaluasi</label>
									<div class="col-lg-9">
										<?php
											$evalData = explode(',', $rc['evaluation']);
											$eval='';
											// if($rc['evaluation']=='1'){$eval='Reaksi';}
											if($rc['evaluation']=='2'){$eval='Pembelajaran';}
											if($rc['evaluation']=='3'){$eval='Perilaku';}
											// if($rc['evaluation']=='1,2' || $rc['evaluation']=='2,1'){$eval='Reaksi, Pembelajaran';}
											// if($rc['evaluation']=='1,3' || $rc['evaluation']=='3,1'){$eval='Reaksi, Perilaku';}
											if($rc['evaluation']=='2,3' || $rc['evaluation']=='3,2'){$eval='Pembelajaran, Perilaku';}
											// if($rc['evaluation']=='1,2,3' || $rc['evaluation']=='3,1,2' || $rc['evaluation']=='3,2,1' || $rc['evaluation']=='2,1,3' || $rc['evaluation']=='2,3,1')
											// 	{$eval='Reaksi, Pembelajaran, Perilaku';}
										?>
										<select class="form-control select4" name="slcEvaluasi[]" id="slcEvaluasi" multiple="multiple" >
												<?php
													foreach($GetEvaluationType as $et){ ?>
													<option value="<?php echo $et['evaluation_type_id']?>" 
													<?php if (in_array($et['evaluation_type_id'], $evalData)) { echo "selected"; } ?>>
														<?php echo $et['evaluation_type_description'];?>
													</option>
												<?php }?>
										</select>
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Sifat</label>
									<div class="col-lg-9">
										<select class="form-control SlcRuang" name="slcSifat" data-placeholder="Order/Tahunan" required>
											<option value="1" <?php if ($rc['sifat']==1) { echo "selected"; } ?>>Order</option>
											<option value="2" <?php if ($rc['sifat']==2) { echo "selected"; } ?>>Tahunan</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Peserta</label>
									<div class="col-lg-3" >
										<!-- <select class="form-control select2" name="slcPeserta" >
										<?php foreach($ptctype as $py) {?> 
											<option  value="<?php echo $py['participant_type_id']?>"
												<?php if($py['participant_type_id']) { echo "selected"; } ?> >
												<?php echo $py['participant_type_description'] ?>
											</option>
										<?php }?>
										</select> --> 
										<input class="form-control" value="<?php echo $rc['participant_type_description'] ?>" readonly>	</div>
									
									<label class="col-lg-3 control-label" align="right">Jumlah Peserta</label>
										<div class="col-lg-3">
											<input class="form-control" name="txtJumlahPeserta" id="jmlpeserta" placeholder="<?php echo $rc['participant_number']?>" 
											onkeypress="return isNumberKey(event)" maxlength=2 value="<?php echo $rc['participant_number']?>">
										</div>
								</div>
							</div>
							
							<hr>
							<div class="row" style="margin: 10px 10px">
								<div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											<b>Tujuan Pelatihan :</b>
										</div>
										<div class="panel-body">
											<?php foreach($purpose as $pp){ ?>
											<i class="fa fa-angle-right"></i><?php echo ' '.$pp['purpose'] ?><br>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-12 control-label">Trainer : </label>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="col-md-12">
									<div class="form-group">
										<div class="input-group">
											<div class="input-group-addon">
												<i class="glyphicon glyphicon-user"></i>
											</div>
											<select class="form-control select4" name="slcTrainer[]" id="slcTrainer" multiple="multiple" required>
												<option value=""></option>
												<?php
												$strainer = explode(',', $rc['trainer']);
													foreach($trainer as $tr){
														$selected_tr=''; 
														if (in_array($tr['trainer_id'], $strainer)) {
															$selected_tr='selected';
														}
												?>
													<option <?php echo $selected_tr?> value="<?php echo $tr['trainer_id']?>"><?php echo $tr['trainer_name']?></option>
												<?php }
												?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<hr>
							<!-- <div class="row" style="margin: 10px 10px">
								<div class="col-md-12"> -->
									<!-- <table class="table table-sm table-bordered table-hover" style="table-layout: fixed;">
										<thead class="bg-primary">
											<tr>
												<th width="5%">No</th>
												<th width="75%">Nama Peserta</th>
												<th width="20%">Status</th>
											</tr>
										</thead>
										<tbody>
											<?php //$no=0;//foreach ($participant as $pt){ $no++ ?>
											<tr>
												<td><?php //echo $no ?></td>
												<td><?php //echo $pt['participant_name'] ?></td>
												<td>
													<?php
														$participant_//status='Unconfirmed';
														//if($pt['status']==1){$participant_status='Hadir';}
														//if($pt['status']==2){$participant_status='Tidak Hadir';}
														//echo $participant_status;
													?>
												</td>
											</tr> -->
										<div class="row" style="margin: 10px 10px">
											<div class="form-group">
												<label class="col-lg-12 control-label">Peserta : </label>
											</div>
										</div>
										<div class="row" style="margin: 10px 10px">
												<div class="panel panel-default">
													<div class="panel-heading text-right">
														<a href="javascript:void(0);" class="btn btn-sm btn-primary" id="AddParticipantEdit" title="Tambah Baris" onclick="AddParticipantEdit('<?php echo base_url(); ?>')"><i class="fa fa-plus"></i></a>
													</div>
													<div class="panel-body">
														<div class="table-responsive" >
															<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;" name="tblParticipant" id="tblParticipant">
																<thead>
																	<tr class="bg-primary">
																		<th width="5%" class="sorting_disabled" rowspan="1" colspan="1" style="width: 48.7778px;">NO</th>
																		<th width="90%">Daftar Peserta</th>
																		<th width="20%">Status</th>
																		<th width="10%"></th>
																	</tr>
																</thead>
																<tbody id="tbodyParticipant">
																<?php $no=1;foreach ($participant as $pt) {?>
																	<tr class="clone" row-id="<?php echo $no;?>">
																		<td ><?php echo $no;?></td>
																		<td>
																			<div class="input-group">
																				<div class="input-group-addon">
																					<i class="glyphicon glyphicon-user"></i>
																				</div>
																					<?php 
																						if ($pt['participant_id']) { ?>
																							<select class="form-control js-slcEmployee">
																								<option value="<?php echo $pt['participant_id']?>" >
																									<?php echo $pt['noind'].'-'.$pt['participant_name']?>
																								</option>
																									<input type="text" name="txtParticipantID" value="<?php echo $pt['participant_id']?>" hidden>
																							</select>
																					<?php }else { ?>
																							<select class="form-control js-slcEmployee" name="slcEmployee[]" id="slcEmployee" >
																								<option value=""></option>
																							</select>
																					<?php }?>
																			</div>
																		</td>
																		<td>
																			<?php
																				$participant_status='Unconfirmed';
																				if($pt['status']==1){$participant_status='Hadir';}
																				if($pt['status']==2){$participant_status='Tidak Hadir';}
																				echo $participant_status;
																			?>
																		</td>
																		<td>
																			<button type="button" class="btn btn-danger" onclick="deleteRowAjax(<?php echo $no++.','.$pt['participant_id'].','.$rc['scheduling_id']?>)"><i class="fa fa-remove"></i></button>
																		</td>
																	</tr>
															     <?php }?>
																</tbody>
															 </table>
														</div>
													</div>
												</div>
											</div>
											<?php } ?>
										<!-- </tbody>
									</table> -->
								<!-- </div>
							</div> -->
							<hr>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
								<div class="col-lg-12 text-right">
										<button type="submit" class="btn btn-flat btn-warning">Save</button>
<!-- 									<a type="submit" href="<?php $id;echo site_url('ADMPelatihan/Record/EditSave/'.$id);?>" class="btn btn-flat btn-warning">Save</a>
 -->									<a data-toggle="modal" data-target="<?php echo '#deletealert'.$rc['scheduling_id'] ?>" class="btn btn-flat btn-danger">Delete</a>
									<a href="javascript:window.history.go(-1);" class="btn btn-primary btn btn-flat">Back</a>
									&nbsp;&nbsp;
								</div>
							</div>
							<div class="modal fade modal-danger" id="<?php echo 'deletealert'.$rc['scheduling_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<div class="col-sm-2"></div>
											<div class="col-sm-8" align="center"><h5><b>PERHATIAN !</b></h5></div>
											<div class="col-sm-2"><h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h5></div>
											</br>
										</div>
										<div class="modal-body" align="center">
											Apakah anda yakin ingin menghapus <b><?php echo $rc['scheduling_name'] ?></b> dari jadwal pelatihan ? <br>
											<small>*) Data yang sudah dihapus tidak dapat dikembalikan lagi.</small>
											<div class="row">
												<br>
												<a href="<?php echo base_url('ADMPelatihan/Record/Delete/'.$rc['scheduling_id'])?>" class="btn btn-default"><i class="fa fa-remove"></i> DELETE</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				</div>
			</div>
			</form>		
			<?php //} ?>
			</div>
		</div>		
	</div>
	</div>
</section>			
			
				
