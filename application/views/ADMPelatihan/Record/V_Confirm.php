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
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/MasterTraining');?>">
                                <i class="icon-wrench icon-2x"></i>
                                <span><br/></span>	
                            </a>
						</div>
					</div>
				</div>
			</div>
			<br/>
			
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<b>Form Konfirmasi Pelaksanaan Pelatihan</b>
					</div>
					<div class="box-body">
					<?php foreach($record as $rc){?>
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
										<input class="form-control" value="<?php echo $rc['scheduling_name']?>" readonly>
									</div>
								</div>
							</div>

							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Tanggal</label>
									<div class="col-lg-9">
										<input class="form-control" value="<?php echo $rc['date_format']?>" readonly >
									</div>	
								</div>
							</div>

							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Waktu</label>
									<div class="col-lg-4 ">
										<input class="form-control" value="<?php echo $rc['start_time']?>" readonly>
									</div>
									<label class="col-lg-1 control-label" align="center">-</label>
									<div class="col-lg-4">
										<input class="form-control" value="<?php echo $rc['end_time']?>" readonly>
									</div>
								</div>
							</div>

							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Ruang</label>
									<div class="col-lg-9">
										<input class="form-control" value="<?php echo $rc['room']?>" readonly >
									</div>
								</div>
							</div>
							<hr>

							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
								<label class="col-lg-3 control-label">Evaluasi</label>
									<div class="col-lg-9">
										<?php
											$eval='';$ev1='';$ev2='';$ev3='';
											if($rc['evaluation']==1){$eval='Wawasan';$ev1='Y';}
											if($rc['evaluation']==2){$eval='Pengetahuan';$ev2='Y';}
											if($rc['evaluation']==3){$eval='Perilaku';$ev3='Y';}
											if($rc['evaluation']==12){$eval='Wawasan, Pengetahuan';$ev1='Y';$ev2='Y';}
											if($rc['evaluation']==13){$eval='Wawasan, Perilaku';$ev1='Y';$ev3='Y';}
											if($rc['evaluation']==23){$eval='Pengetahuan, Perilaku';$ev2='Y';$ev3='Y';}
											if($rc['evaluation']==123){$eval='Wawasan, Pengetahuan, Perilaku';$ev1='Y';$ev2='Y';$ev3='Y';}
										?>
										<input class="form-control" value="<?php echo $eval ?>" readonly >
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Peserta</label>
									<div class="col-lg-3">
										<input class="form-control" value="<?php echo $rc['participant_type_description'] ?>" readonly >
									</div>
									<label class="col-lg-3 control-label" align="right">Jumlah Peserta</label>
									<div class="col-lg-3">
										<input class="form-control" value="<?php echo $rc['participant_number']?>" readonly >
									</div>
								</div>
							</div>
							<hr>
						</div>
						<div class="col-lg-12">
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
									<table class="table table-sm table-bordered table-hover" style="table-layout: fixed;">
										<thead class="bg-primary">
											<tr>
												<th width="5%">No</th>
												<th width="15%">No Induk</th>
												<th width="60%">Nama Trainer</th>
												<th width="20%">Status</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$no=0;
												$strainer = explode(',', $rc['trainer']);
												foreach ($strainer as $st){ $no++;
													foreach ($trainer as $tr){
														if($st == $tr['trainer_id']){
															$status='Internal';
															if($tr['trainer_status']==0){
																$status='Eksternal';
															}
											?>
											<tr>
												<td><?php echo $no ?></td>
												<td><?php echo $tr['noind'] ?></td>
												<td><?php echo $tr['trainer_name'] ?></td>
												<td><?php echo $status ?></td>
											</tr>
											<?php }}} ?>
										</tbody>
									</table>
								</div>
							</div>
							<hr>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-12 control-label">Peserta : </label>
								</div>
							</div>
							<form method="post" action="<?php echo base_url('ADMPelatihan/Record/DoConfirm')?>">
							<div class="row" style="margin: 10px 10px">
								<div class="col-md-12">
									<input type="text" name="txtSchnum" value="<?php echo $rc['scheduling_id']?>" hidden></input>
									<table class="table table-sm table-bordered table-hover" style="table-layout: fixed;">
										<thead class="bg-primary">
											<tr>
												<th width="5%">No</th>
												<th width="8%">No Induk</th>
												<th width="20%">Nama Peserta</th>
												<th width="12%">Status</th>
													<?php if($ev2=='Y'){ ?>
												<th>Pengetahuan (Pre)</th>
													<?php } if($ev3=='Y'){ ?>
												<th>Perilaku (Pre)</th>
												<th>Perilaku (Post)</th>
												<th width="7%">R1</th>
												<th width="7%">R2</th>
												<th width="7%">R3</th>
													<?php } ?>
											</tr>
										</thead>
										<tbody>
											<?php $no=0;foreach ($participant as $pt){ $no++; 

												if('2'==$pt['status'])
												{
													$hadir='';
													$tidakhadir='selected';
												}
												else
												{
													$hadir='selected';
													$tidakhadir='';
												}

												?>
											<tr>
												<td><?php echo $no ?></td>
												<td><?php echo $pt['noind'] ?></td>
												<td><?php echo $pt['participant_name'] ?></td>
												<td>
													<input type="text" name="txtId[]" value="<?php echo $pt['participant_id']?>" hidden>
													<select class="form-control select4" name="slcStatus[]">
														<option value="1" <?php echo $hadir;?> >Hadir</option>
														<option value="2" <?php echo $tidakhadir;?> >Tidak Hadir</option>
													</select>
												</td>
													<?php if($ev2=='Y'){ ?>
												<td>
													<input type="text" class="form-control" name="txtPengetahuanPre[]" Placeholder="Pengetahuan (pre)" onkeypress="return isNumberKey(event)" value="<?php echo $pt['score_eval2_pre'];?>">
												</td>
													<?php } if($ev3=='Y'){ ?>
												<td>
													<input type="text" class="form-control" name="txtPerilakuPre[]" Placeholder="Perilaku (pre)" onkeypress="return isNumberKey(event)" value="<?php echo $pt['score_eval3_pre'];?>">
												</td>
												<td>
													<input type="text" class="form-control" name="txtPerilakuPost[]" Placeholder="Perilaku (Post)" onkeypress="return isNumberKey(event)" value="<?php echo $pt['score_eval3_post1'];?>">
												</td>
												<td>
													<input type="text" class="form-control" name="txtPerilakuPostRem1[]" Placeholder="R1" onkeypress="return isNumberKey(event)" value="<?php echo $pt['score_eval3_post2'];?>">
												</td>
												<td>
													<input type="text" class="form-control" name="txtPerilakuPostRem2[]" Placeholder="R2" onkeypress="return isNumberKey(event)" value="<?php echo $pt['score_eval3_post3'];?>">
												</td>
												<td>
													<input type="text" class="form-control" name="txtPerilakuPostRem3[]" Placeholder="R3" onkeypress="return isNumberKey(event)" value="<?php echo $pt['score_eval3_post4'];?>">
												</td>
													<?php } ?>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-12 control-label">*) Standar kelulsan : <?php echo $rc['limit']?></label>
								</div>
							</div>
							<hr>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<div class="col-lg-12 text-right">
										<a href="javascript:window.history.go(-1);" class="btn btn-primary btn btn-flat">Back</a>
									&nbsp;&nbsp;
										<button type="submit" class="btn btn-success btn btn-flat">Confirm</button>
									</div>
								</div>
							</div>
							</form>
						</div>
					<?php } ?>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				