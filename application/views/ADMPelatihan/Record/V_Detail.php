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
			
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<b>Record Pelatihan</b>
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
							<?php if ($rc['package_scheduling_id']==0 && $rc['package_training_id']==0) {
								if(!empty($rc['start_time'])) {?>
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
								<?php }
							}?>
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
											$eval='';
											// if($rc['evaluation']=='1'){$eval='Reaksi';}
											if($rc['evaluation']=='2'){$eval='Pembelajaran';}
											if($rc['evaluation']=='3'){$eval='Evaluasi Lapangan';}
											// if($rc['evaluation']=='1,2' || $rc['evaluation']=='2,1'){$eval='Reaksi, Pembelajaran';}
											// if($rc['evaluation']=='1,3' || $rc['evaluation']=='3,1'){$eval='Reaksi, Evaluasi Lapangan';}
											if($rc['evaluation']=='2,3' || $rc['evaluation']=='3,2' ){$eval='Pembelajaran, Evaluasi Lapangan';}
											// if($rc['evaluation']=='1,2,3'|| $rc['evaluation']=='3,1,2' || $rc['evaluation']=='3,2,1' || $rc['evaluation']=='2,1,3' || $rc['evaluation']=='2,3,1')
											// 	{$eval='Reaksi, Pembelajaran, Evaluasi Lapangan';}
										?>
										<input class="form-control" value="<?php echo $eval?>" readonly >
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Sifat</label>
									<div class="col-lg-9">
										<?php if ($rc['sifat']==1) {?>
											<input class="form-control" value="<?php echo "Order"?>" readonly >
										<?php } ?>
										<?php if ($rc['sifat']==2) {?>
											<input class="form-control" value="<?php echo "Tahunan"?>" readonly >
										<?php } ?>
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
								<div class="col-md-12">
									<table class="table table-sm table-bordered table-hover" style="table-layout: fixed;">
										<thead class="bg-primary">
											<tr>
												<th width="5%">No</th>
												<th width="15%">No Induk</th>
												<th width="65%">Nama Peserta</th>
												<th width="20%">Status</th>
											</tr>
										</thead>
										<tbody>
											<?php $no=0;foreach ($participant as $pt){ $no++ ?>
											<tr>
												<td><?php echo $no ?></td>
												<td><?php echo $pt['noind'] ?></td>
												<td><?php echo $pt['participant_name'] ?></td>
												<td>
													<?php
														$participant_status='Unconfirmed';
														if($pt['status']==1){$participant_status='Hadir';}
														if($pt['status']==2){$participant_status='Tidak Hadir';}
														echo $participant_status;
													?>
												</td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
							<hr>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
								<div class="col-lg-12 text-right">
									<a href="<?php echo site_url('ADMPelatihan/Record/Edit/'.$rc['scheduling_id']);?>" class="btn btn-flat btn-warning">Edit</a>	
									<a href="<?php echo site_url('ADMPelatihan/Record/Confirm/'.$rc['scheduling_id']);?>" class="btn btn-flat btn-success">Confirm</a>
									<a data-toggle="modal" data-target="<?php echo '#deletealert'.$rc['scheduling_id'] ?>" class="btn btn-flat btn-danger">Delete</a>
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
					<?php } ?>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
