<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right"><h1><b><?=$Title ?></b></h1></div>
						</div>
						<div class="col-lg-1">
							<a href="<?php echo site_url('CateringManagement/JamDatangShift') ?>" class="btn btn-default btn-lg">
								<span class="icon-wrench icon-2x"></span>
							</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border text-right">
								<a href="<?php echo site_url('CateringManagement/JamDatangShift/Create') ?>" class="btn btn-default icon-plus icon-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Add Data'></a>
							</div>
							<div class="box-body">
								<ul class="nav nav-pills nav-justified">
								<li class="active"><a data-toggle="pill" href="#shift1">Shift 1 dan Shift Umum</a></li>
								<li><a data-toggle="pill" href="#shift2">Shift 2</a></li>
							</ul>
							<div class="tab-content">
								<div id="shift1" class="tab-pane fade in active">
									<div class="row">
										<div class="col-lg-12">
											<br>
											<div class="table-responsive">
												<table class="datatable table table-bordered table-hover table-striped text-left">
													<thead class="bg-success">
														<tr>
															<th>No</th>
															<th>hari</th>
															<th>Jam Awal Datang</th>
															<th>jam Akhir Datang</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
														<?php $a=1;
														foreach ($JamDatangShift1 as $key) { 
															$hari = array('','Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
															$x = $key['fs_hari'];
															$encrypted_string = $this->encrypt->encode($x);
                                                			$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
															?>
														 	<tr>
														 		<td><?php echo $a; ?></td>
														 		<td><?php echo $hari[$x]; ?></td>
														 		<td><?php echo $key['fs_jam_awal'] ?></td>
														 		<td><?php echo $key['fs_jam_akhir'] ?></td>
														 		<td>
														 			<a href="<?php echo base_url('CateringManagement/JamDatangShift/Edit/1/'.$encrypted_string) ?>" class="fa fa-edit fa-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Edit Data'></a>
																	<a href="<?php echo base_url('CateringManagement/JamDatangShift/Delete/1/'.$encrypted_string) ?>" class="fa fa-trash fa-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Data' onclick='return confirm("Apakah Anda Yakin Ingin Menghapus Data Ini ?")'></a>
														 		</td>
														 	</tr>
														<?php $a++; } ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<div id="shift2" class="tab-pane fade">
									<div class="row">
										<div class="col-lg-12">
											<br>
											<div class="table-responsive">
												<table class="datatable table table-bordered table-hover table-striped text-left">
													<thead class="bg-warning">
														<tr>
															<th>No</th>
															<th>hari</th>
															<th>Jam Awal Datang</th>
															<th>jam Akhir Datang</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
														<?php $a=1;
														foreach ($JamDatangShift2 as $key) { 
															$hari = array('','Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
															$x = $key['fs_hari'];
															$encrypted_string = $this->encrypt->encode($x);
                                                			$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
															?>
														 	<tr>
														 		<td><?php echo $a; ?></td>
														 		<td><?php echo $hari[$x]; ?></td>
														 		<td><?php echo $key['fs_jam_awal'] ?></td>
														 		<td><?php echo $key['fs_jam_akhir'] ?></td>
														 		<td>
														 			<a href="<?php echo base_url('CateringManagement/JamDatangShift/Edit/2/'.$encrypted_string) ?>" class="fa fa-edit fa-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Edit Data'></a>
																	<a href="<?php echo base_url('CateringManagement/JamDatangShift/Delete/2/'.$encrypted_string) ?>" class="fa fa-trash fa-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Data' onclick='return confirm("Apakah Anda Yakin Ingin Menghapus Data Ini ?")'></a>
														 		</td>
														 	</tr>
														<?php $a++; } ?>
													</tbody>
												</table>
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
		</div>
	</div>
</section>