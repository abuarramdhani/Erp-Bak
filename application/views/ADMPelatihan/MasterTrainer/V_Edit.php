<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Master Trainer</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/MasterTrainer');?>">
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
							<b>Form Edit Master Trainer</b>
						</div>
						<div class="box-body">
							<div class="col-sm-2">
								<p style="text-align:center;"><strong>FOTO PRIBADI</strong></p>
								<p id="rcorners2" style="text-align:center;">
									 <?php
									 	foreach ($detail as $dt) {
											$path_photo  		=	base_url('assets/img/foto').'/';
											$file 			= 	$path_photo.$dt['noind'].'.'.'JPG';
											$file_headers 	= 	@get_headers($file);
											if(!$file_headers || substr($file_headers[0], strpos($file_headers[0], 'Not Found'), 9) == 'Not Found')
											{
												$file 			= 	$path_photo.$dt['noind'].'.'.'JPG';
												$file_headers 	= 	@get_headers($file);
												if(!$file_headers || substr($file_headers[0], strpos($file_headers[0], 'Not Found'), 9) == 'Not Found')
												{
													$ekstensi 	= 	'Not Found';
												}
												else
												{
													$ekstensi 	= 	'JPG';
												}
											}
											else
											{
												$ekstensi 	= 	"jpg";
											}

											if($ekstensi=='jpg' || $ekstensi=='JPG')
											{
												echo '<img src="'.$path_photo.$dt['noind'].'.'.$ekstensi.'" id="prevPhoto" style="border-radius: 10px;" width="117px" height="148px"/>';
											}
											else
											{
												echo '<img src="'.base_url('assets/theme/img/user.png').'" id="prevPhoto" style="border-radius: 10px;" width="117px" height="148px"/>';
											}
										}
						            ?>
								</p>
							</div>
							<div class="col-sm-10">
								<form method="post" action="<?php echo base_url('ADMPelatihan/MasterTrainer/Update')?>">
								<?php foreach($detail as $dt){
									?>
									<div class="row" style="margin: 30px 10px 10px">
										<div class="form-group">
											<label class="col-lg-2 control-label">Id Trainer</label>
											<div class="col-lg-6">
												<input name="txtIdTrainer" class="form-control" value="<?php echo $dt['trainer_id'] ?>" readonly>
											</div>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<div class="form-group">
											<label class="col-lg-2 control-label">No. Induk</label>
											<div class="col-lg-6">
												<input name="txtNoind" class="form-control toupper" placeholder="Nomor Induk" value="<?php echo $dt['noind'] ?>" maxlength="5" readonly>
											</div>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<div class="form-group">
											<label class="col-lg-2 control-label">Nama Trainer</label>
											<div class="col-lg-6">
												<input name="txtNamaTrainer" class="form-control" placeholder="Nama Trainer" value="<?php echo trim($dt['trainer_name'],"  ")?>">
											</div>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<div class="form-group">
											<label class="col-lg-2 control-label">Status</label>
											<div class="col-lg-3">
												<?php
													if($dt['trainer_status'] == 1){?>
														<input type="text" class="form-control" name="slcStatus" value="Trainer Internal" readonly>
														<input type="text" name="slcStatus" value="<?php echo $dt['trainer_status']?>" hidden="true">
													<?php }
													if($dt['trainer_status'] == 0){?>
														<input type="text" class="form-control" name="slcStatus" value="Trainer Eksternal" readonly>
														<input type="text" name="slcStatus" value="<?php echo $dt['trainer_status']?>" hidden="true">
													<?php }
												?>
											</div>
										</div>
									</div>
									<hr>
									<div class="row" style="margin: 10px 10px">
										<div class="panel-heading text-right">
											<b style="float:left;">Pendidikan</b>
										</div>
										<div class="col-md-12">
											<table class="table table-sm table-bordered table-hover" style="table-layout: fixed;">
												<thead class="bg-primary">
													<tr>
														<th width="5%">No</th>
														<th width="20%">Pendidikan</th>
														<th >Jurusan</th>
														<th >Sekolah</th>
													</tr>
												</thead>
												<tbody>
													<?php $no=1; $checkPendidikan = array();
														foreach ($GetAllInfo as $gi) {
														if (!in_array($gi['pendidikan'], $checkPendidikan)) {
															array_push($checkPendidikan, $gi['pendidikan']);
														?>
														<tr>
															<td><?php echo $no++ ?></td>
															<td><?php
																	echo $gi['pendidikan'];
															?></td>
															<td><?php echo $gi['jurusan']; ?></td>
															<td><?php echo $gi['sekolah']; ?></td>
														</tr>
														<?php }
													}?>
												</tbody>
											</table>
										</div>
									</div>
									<hr>
									<div class="row" style="margin: 10px 10px">
										<div class="panel-heading text-right">
											<b style="float:left;">Riwayat Penempatan Seksi dan Jabatan</b>
										</div>
										<div class="col-md-12">
											<table class="table table-sm table-bordered table-hover" style="table-layout: fixed;">
												<thead class="bg-primary">
													<tr>
														<th width="5%">No</th>
														<th width="10%">No Induk</th>
														<th >Dept</th>
														<th >Bidang</th>
														<th >Unit</th>
														<th >Seksi</th>
														<th >Jabatan</th>
													</tr>
												</thead>
												<tbody>
												<?php $no=0; foreach ($GetAllInfo as $gai) {
													$no++; ?>
													<tr>
														<td><?php echo $no; ?></td>
														<td><?php echo $gai['noind']; ?></td>
														<td><?php echo $gai['dept']; ?></td>
														<td><?php echo $gai['bidang']; ?></td>
														<td><?php echo $gai['unit']; ?></td>
														<td><?php echo $gai['seksi']; ?></td>
														<td><?php echo $gai['jabatan']; ?></td>
													</tr>
												<?php } ?>
												</tbody>
											</table>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<div class="col-md-12">
											<div class="panel panel-default">
												<div class="panel-heading text-right">
													<a href="javascript:void(0);" class="btn btn-sm btn-primary" id="AddPengalaman" title="Tambah Baris" onclick="AddPengalaman('<?php echo base_url(''); ?>')"><i class="fa fa-plus"></i></a>
													<b style="float:left;">Pengalaman Mengajar di KHS</b>
												</div>
												<div class="panel-body">
													<div class="table-responsive" >
													<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;" name="tblPengalaman" id="tblPengalaman">
														 <form method="post" action="<?php echo base_url('ADMPelatihan/MasterTrainer/Update')?>">
															<thead>
																<tr class="bg-primary">
																	<th width="10%">No</th>
																	<th >Nama Training</th>
																	<th width="30%">Tanggal</th>
																	<th width="10%">Action</th>
																</tr>
															</thead>
															<tbody id="tbodyTrainerPengalaman">
																<?php $no=0; foreach ($GetExperience as $ge) {
																	$no++; ?>
																	<tr class="clone" row-id="<?php echo $no; ?>">
																		<td ><?php echo $no; ?></td>
																		<td>
																			<input id="segment" name="txtPengalaman[]" class="form-control segment" value="<?php echo $ge['training_name']; ?>" data-id="" data-placement="top" placeholder="Pengalaman Trainer">
																			<!-- <input type="text" name="idTrainer" value="<?php echo $ge['trainer_id']; ?>" hidden> -->
																			<input type="text" name="idPengalaman[]" value="<?php echo $ge['id_exp']; ?>" hidden>
																		</td>
																		<td>
																		<?php
																			$date=$ge['training_date'];
																			$newDate=date("d/m/Y", strtotime($date));
																		?>
																			<input name="txtTanggalPengalaman[]" class="form-control singledateADM" placeholder="Tanggal" id="txtTanggalPengalaman" value="<?php echo $newDate ?>">
																		</td>
																		<td>
																			<a href="javascript:void(0);" class="btn btn-danger btn-xs" id="DelPengalaman" title="Hapus Baris" onclick="delPengalaman(<?php echo $no.','.$ge['trainer_id'].','.$ge['id_exp']; ?>)"><i class="fa fa-remove"></i>Delete</a>
																		</td>
																	</tr>
																<?php } ?>
															</tbody>
														</form>
													</table>
													</div>
												</div>
												<br>
											</div>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<div class="col-md-12">
											<div class="panel panel-default">
												<div class="panel-heading text-right">
													<a href="javascript:void(0);" class="btn btn-sm btn-primary" id="AddSertifikat" title="Tambah Baris" onclick="AddSertifikat('<?php echo base_url(''); ?>')"><i class="fa fa-plus"></i></a>
													<b style="float:left;">Training Bersertifikat yang Pernah Diikuti</b>
												</div>
												<div class="panel-body">
													<div class="table-responsive" >
													<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;" name="tblSertifikat" id="tblSertifikat">
														<thead>
															<tr class="bg-primary">
																<th width="10%">No</th>
																<th >Nama Training</th>
																<th width="30%">Tanggal</th>
																<th width="10%">Action</th>
															</tr>
														</thead>
														<tbody id="tbodyTrainerSertifikat">
															<?php $no=0; foreach ($GetCertificate as $gs) {
																$no++; ?>
																<tr class="clone" row-id="<?php echo $no; ?>">
																	<td ><?php echo $no; ?></td>
																	<td>
																		<input id="segment" name="txtSertifikat[]" class="form-control segment" value="<?php echo $gs['training_name'] ?>" data-id="" data-placement="top" placeholder="Nama Training">
																		<!-- <input type="text" name="idTrainer" value="<?php echo $gs['trainer_id']; ?>" hidden> -->
																		<input type="text" name="idsertifikat[]" value="<?php echo $gs['id_cert']; ?>" hidden>
																	</td>
																	<td>
																	<?php
																		$date=$gs['training_date'];
																		$newDate=date("d/m/Y", strtotime($date));
																	?>
																		<input name="txtTanggalSertifikat[]" class="form-control singledateADM" placeholder="Tanggal" id="txtTanggalSertifikat" value="<?php echo $newDate ?>">
																	</td>
																	<td>
																		<a href="javascript:void(0);" class="btn btn-danger btn-xs" id="DelSertifikat" title="Hapus Baris" onclick="delSertifikat(<?php echo $no.','.$gs['trainer_id'].','.$gs['id_cert']; ?>)"><i class="fa fa-remove"></i>Delete</a>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
													</div>
												</div>
												<br>
											</div>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<div class="col-md-12">
											<div class="panel panel-default">
												<div class="panel-heading text-right">
													<a href="javascript:void(0);" class="btn btn-sm btn-primary" id="AddTim" title="Tambah Baris" onclick="AddTim('<?php echo base_url(''); ?>')"><i class="fa fa-plus"></i></a>
													<b style="float:left;">Tim yang Pernah Diikuti</b>
												</div>
												<div class="panel-body">
													<div class="table-responsive" >
													<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;" name="tblTim" id="tblTim">
														<thead>
															<tr class="bg-primary">
																<th width="5%">No</th>
																<th >Nama Kegiatan</th>
																<th width="20%"> Tanggal</th>
																<th width="30%">Jabatan</th>
																<th width="10%">Action</th>
															</tr>
														</thead>
														<tbody id="tbodyTrainerTim">
															<?php $no=0; foreach ($GetTeam as $gt) {
																$no++; ?>
																<tr class="clone" row-id="<?php echo $no; ?>">
																	<td ><?php echo $no; ?></td>
																	<td>
																		<input id="segment" name="txtKegiatan[]" class="form-control segment" value="<?php echo $gt['kegiatan'] ?>" data-id="" data-placement="top" placeholder="Nama Kegiatan">
																		<!-- <input type="text" name="idTrainer" value="<?php echo $gt['trainer_id']; ?>" hidden> -->
																		<input type="text" name="idteam[]" value="<?php echo $gt['id_team']; ?>" hidden>
																	</td>
																	<td>
																	<?php
																		$date=$gt['date'];
																		$newDate=date("d/m/Y", strtotime($date));
																	?>
																		<input name="txtTanggalkegiatan[]" class="form-control singledateADM" placeholder="Tanggal" id="txtTanggalkegiatan" value="<?php echo $newDate ?>">
																	</td>
																	<td>
																		<input id="segment" name="txtJabatan[]" class="form-control segment" value="<?php echo $gt['jabatan'] ?>" data-id="" data-placement="top" placeholder="Jabatan">
																	</td>
																	<td>
																		<a href="javascript:void(0);" class="btn btn-danger btn-xs" id="DelTrainerTim" title="Hapus Baris" onclick="DelTrainerTim(<?php echo $no.','.$gt['trainer_id'].','.$gt['id_team']; ?>)"><i class="fa fa-remove"></i>Delete</a>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
													</div>
												</div>
												<br>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-12 text-right">
											<a href="<?php echo site_url('ADMPelatihan/MasterTrainer');?>"  class="btn btn-primary btn btn-flat">Back</a>
											<button type="submit" class="btn btn-success btn btn-flat">Save Change</button>
										</div>
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
