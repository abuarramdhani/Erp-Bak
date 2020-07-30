<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<b><h1><?=$Title ?></h1></b>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<ul class="nav nav-pills nav-justified" role="tablist">
											<li role="presentation" class="active">
												<a href="#all" aria-controls="all" role="tab" data-toggle="tab">All</a>
											</li>
											<li role="presentation">
												<a href="#createide" aria-controls="createide" role="tab" data-toggle="tab">Create Ide</a>
											</li>
											<li role="presentation">
												<a href="#pengajuanhapuside" aria-controls="pengajuanhapuside" role="tab" data-toggle="tab">Pengajuan Hapus Ide</a>
											</li>
											<li role="presentation">
												<a href="#f4sudahsubmit" aria-controls="f4sudahsubmit" role="tab" data-toggle="tab">F4 Sudah di Submit</a>
											</li>
											<li role="presentation">
												<a href="#f4belumupload" aria-controls="f4belumupload" role="tab" data-toggle="tab">F4 Belum di Upload</a>
											</li>
											<li role="presentation">
												<a href="#f4sudahupload" aria-controls="f4sudahupload" role="tab" data-toggle="tab">F4 Sudah di Upload</a>
											</li>
										</ul>
										<hr>
										<div class="tab-content">
											<style type="text/css">
												.dt-buttons, .dataTables_info {
													float: left;
												}
												.dataTables_filter, .dataTables_paginate {
													float: right;
												}
											</style>
											<div role="tabpanel" class="tab-pane fade in active" id="all">
												<div class="row">
													<div class="col-lg-12"> 
														<table class="table table-striped table-hover table-bordered tbl-SI-KaizenAkt-MyKaizen">
															<thead class="bg-primary">
																<tr>
																	<th style="text-align: center;">No.</th>
																	<th style="text-align: center;">Judul</th>
																	<th style="text-align: center;">Create Ide</th>
																	<th style="text-align: center;">Due Date F4</th>
																	<th style="text-align: center;">Status</th>
																	<th style="text-align: center;">Action</th>
																</tr>
															</thead>
															<tbody>
																<?php 
																if (isset($kaizen) && !empty($kaizen)) {
																	$nomor = 1;
																	foreach ($kaizen as $key => $value) {
																		$encrypted_string = $this->encrypt->encode($value['kaizen_id']);
																		$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
																		?>
																		<tr>
																			<td class="text-center"><?php echo $nomor ?></td>
																			<td><?php echo empty($value['judul']) ? $value['ide'] : $value['judul'] ?></td>
																			<td><?php echo date('Y-m-d H:i:s',strtotime($value['created_timestamp'])) ?></td>
																			<td><?php echo $value['due_date_f4'] ?></td>
																			<td class="text-center"><?php echo $value['status'] ?></td>
																			<td class="text-center">
																				<?php if (in_array($value['status'], array('F4 Sudah di Submit','F4 Belum di Upload','F4 Sudah di Upload'))) {
																					?>
																				<a href="<?php echo base_url('SystemIntegration/KaizenAkt/LihatF4/'.$encrypted_string) ?>" title="Lihat F4" class="btn btn-success btn-sm"><span class="fa fa-eye"></span></a>
																					<?php
																				}

																				if ($value['status'] == 'F4 Belum di Upload') {
																				 	?>
																				<a href="<?php echo base_url('SystemIntegration/KaizenAkt/CetakF4/'.$encrypted_string) ?>" target="_blank" title="Cetak F4" class="btn btn-danger btn-sm"><span class="fa fa-file-pdf-o"></span></a>
																				<a href="<?php echo base_url('SystemIntegration/KaizenAkt/UploadF4/'.$encrypted_string) ?>" title="Upload F4" class="btn btn-info btn-sm"><span class="fa fa-upload"></span></a>
																				<a href="<?php echo base_url('SystemIntegration/KaizenAkt/EditF4/'.$encrypted_string) ?>" title="Edit F4" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span></a>
																				<a href="<?php echo base_url('SystemIntegration/KaizenAkt/HapusF4/'.$encrypted_string) ?>" title="Hapus F4" class="btn btn-danger btn-sm" onclick="return confirm('apakah anda yakin ingin menghapus F4 pada ide kaizen ini ?')"><span class="fa fa-trash-o"></span></a>
																				 	<?php
																				} 

																				if ($value['status'] == 'F4 Sudah di Submit') {
																					?>
																				<a href="<?php echo base_url('SystemIntegration/KaizenAkt/CetakF4/'.$encrypted_string) ?>" target="_blank" title="Cetak F4" class="btn btn-danger btn-sm"><span class="fa fa-file-pdf-o"></span></a>
																					<?php
																				}

																				if($value['status'] == 'Create Ide'){
																				?>
																				<a href="<?php echo base_url('SystemIntegration/KaizenAkt/PengajuanHapusIde/'.$encrypted_string) ?>" title="Pengajuan Hapus Ide" class="btn btn-danger btn-sm" onclick="return confirm('apakah anda yakin ingin mengajukan penghapusan ide untuk kaizen ini ?')"><span class="fa fa-trash"></span></a>
																				<?php
																				}

																				if($value['status'] == 'Pengajuan Hapus Ide'){ 
																				?>
																				<a href="<?php echo base_url('SystemIntegration/KaizenAkt/BatalPengajuanHapusIde/'.$encrypted_string) ?>" title="Batal Ajukan Hapus Ide" class="btn btn-danger btn-sm" onclick="return confirm('apakah anda yakin ingin membatalkan pengajuan hapus ide untuk kaizen ini ?')"><span class="fa fa-undo"></span></a>
																				<?php 
																				}
																				?>
																			</td>
																		</tr>
																		<?php
																		$nomor++;
																	}
																}
																?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
											<div role="tabpanel" class="tab-pane fade " id="createide">
												<div class="row">
													<div class="col-lg-12">
														<table class="table table-striped table-hover table-bordered tbl-SI-KaizenAkt-MyKaizen">
															<thead class="bg-primary">
																<tr>
																	<th style="text-align: center;">No.</th>
																	<th style="text-align: center;">Ide</th>
																	<th style="text-align: center;">Create Ide</th>
																	<th style="text-align: center;">Due Date F4</th>
																	<th style="text-align: center;">Action</th>
																</tr>
															</thead>
															<tbody>
																<?php 
																if (isset($kaizen) && !empty($kaizen)) {
																	$nomor = 1;
																	foreach ($kaizen as $key => $value) {
																		$encrypted_string = $this->encrypt->encode($value['kaizen_id']);
																		$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
																		if($value['status'] == 'Create Ide'){
																		?>
																		<tr>
																			<td class="text-center"><?php echo $nomor ?></td>
																			<td><?php echo $value['ide'] ?></td>
																			<td><?php echo date('Y-m-d H:i:s',strtotime($value['created_timestamp'])) ?></td>
																			<td><?php echo $value['due_date_f4'] ?></td>
																			<td class="text-center">
																				<a href="<?php echo base_url('SystemIntegration/KaizenAkt/PengajuanHapusIde/'.$encrypted_string) ?>" title="Ajukan Hapus Ide" class="btn btn-danger btn-sm" onclick="return confirm('apakah anda yakin ingin mengajukan penghapusan ide untuk kaizen ini ?')"><span class="fa fa-trash"></span></a>
																			</td>
																		</tr>
																		<?php
																		$nomor++;
																		}
																	}
																}
																?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
											<div role="tabpanel" class="tab-pane fade " id="pengajuanhapuside">
												<div class="row">
													<div class="col-lg-12">
														<table class="table table-striped table-hover table-bordered tbl-SI-KaizenAkt-MyKaizen">
															<thead class="bg-primary">
																<tr>
																	<th style="text-align: center;">No.</th>
																	<th style="text-align: center;">Ide</th>
																	<th style="text-align: center;">Create Ide</th>
																	<th style="text-align: center;">Due Date F4</th>
																	<th style="text-align: center;">Action</th>
																</tr>
															</thead>
															<tbody>
																<?php 
																if (isset($kaizen) && !empty($kaizen)) {
																	$nomor = 1;
																	foreach ($kaizen as $key => $value) {
																		$encrypted_string = $this->encrypt->encode($value['kaizen_id']);
																		$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
																		if($value['status'] == 'Pengajuan Hapus Ide'){
																		?>
																		<tr>
																			<td class="text-center"><?php echo $nomor ?></td>
																			<td><?php echo $value['ide'] ?></td>
																			<td><?php echo date('Y-m-d H:i:s',strtotime($value['created_timestamp'])) ?></td>
																			<td><?php echo $value['due_date_f4'] ?></td>
																			<td class="text-center">
																				<a href="<?php echo base_url('SystemIntegration/KaizenAkt/BatalPengajuanHapusIde/'.$encrypted_string) ?>" title="Batal Ajukan Hapus Ide" class="btn btn-danger btn-sm" onclick="return confirm('apakah anda yakin ingin membatalkan pengajuan hapus ide untuk kaizen ini ?')"><span class="fa fa-undo"></span></a>
																			</td>
																		</tr>
																		<?php
																		$nomor++;
																		}
																	}
																}
																?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
											<div role="tabpanel" class="tab-pane fade " id="f4sudahsubmit">
												<div class="row">
													<div class="col-lg-12">
														<table class="table table-striped table-hover table-bordered tbl-SI-KaizenAkt-MyKaizen">
															<thead class="bg-primary">
																<tr>
																	<th style="text-align: center;">No.</th>
																	<th style="text-align: center;">Judul</th>
																	<th style="text-align: center;">Create Ide</th>
																	<th style="text-align: center;">Due Date F4</th>
																	<th style="text-align: center;">Action</th>
																</tr>
															</thead>
															<tbody>
																<?php 
																if (isset($kaizen) && !empty($kaizen)) {
																	$nomor = 1;
																	foreach ($kaizen as $key => $value) {
																		$encrypted_string = $this->encrypt->encode($value['kaizen_id']);
																		$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
																		if($value['status'] == 'F4 Sudah di Submit'){
																		?>
																		<tr>
																			<td class="text-center"><?php echo $nomor ?></td>
																			<td><?php echo $value['judul'] ?></td>
																			<td><?php echo date('Y-m-d H:i:s',strtotime($value['created_timestamp'])) ?></td>
																			<td><?php echo $value['due_date_f4'] ?></td>
																			<td class="text-center">
																				<a href="<?php echo base_url('SystemIntegration/KaizenAkt/LihatF4/'.$encrypted_string) ?>" title="Lihat F4" class="btn btn-success btn-sm"><span class="fa fa-eye"></span></a>
																				<a href="<?php echo base_url('SystemIntegration/KaizenAkt/CetakF4/'.$encrypted_string) ?>" target="_blank" title="Cetak F4" class="btn btn-danger btn-sm"><span class="fa fa-file-pdf-o"></span></a>
																			</td>
																		</tr>
																		<?php
																		$nomor++;
																		}
																	}
																}
																?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
											<div role="tabpanel" class="tab-pane fade " id="f4belumupload">
												<div class="row">
													<div class="col-lg-12">
														<table class="table table-striped table-hover table-bordered tbl-SI-KaizenAkt-MyKaizen">
															<thead class="bg-primary">
																<tr>
																	<th style="text-align: center;">No.</th>
																	<th style="text-align: center;">Judul</th>
																	<th style="text-align: center;">Create Ide</th>
																	<th style="text-align: center;">Due Date F4</th>
																	<th style="text-align: center;">Action</th>
																</tr>
															</thead>
															<tbody>
																<?php 
																if (isset($kaizen) && !empty($kaizen)) {
																	$nomor = 1;
																	foreach ($kaizen as $key => $value) {
																		$encrypted_string = $this->encrypt->encode($value['kaizen_id']);
																		$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
																		if($value['status'] == 'F4 Belum di Upload'){
																		?>
																		<tr>
																			<td class="text-center"><?php echo $nomor ?></td>
																			<td><?php echo $value['judul'] ?></td>
																			<td><?php echo date('Y-m-d H:i:s',strtotime($value['created_timestamp'])) ?></td>
																			<td><?php echo $value['due_date_f4'] ?></td>
																			<td class="text-center">
																				<a href="<?php echo base_url('SystemIntegration/KaizenAkt/LihatF4/'.$encrypted_string) ?>" title="Lihat F4" class="btn btn-success btn-sm"><span class="fa fa-eye"></span></a>
																				<a href="<?php echo base_url('SystemIntegration/KaizenAkt/CetakF4/'.$encrypted_string) ?>" target="_blank" title="Cetak F4" class="btn btn-danger btn-sm"><span class="fa fa-file-pdf-o"></span></a>
																				<a href="<?php echo base_url('SystemIntegration/KaizenAkt/UploadF4/'.$encrypted_string) ?>" title="Upload F4" class="btn btn-info btn-sm"><span class="fa fa-upload"></span></a>
																				<a href="<?php echo base_url('SystemIntegration/KaizenAkt/EditF4/'.$encrypted_string) ?>" title="Edit F4" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span></a>
																				<a href="<?php echo base_url('SystemIntegration/KaizenAkt/HapusF4/'.$encrypted_string) ?>" title="Hapus F4" class="btn btn-danger btn-sm" onclick="return confirm('apakah anda yakin ingin menghapus F4 pada ide kaizen ini ?')"><span class="fa fa-trash-o"></span></a>
																			</td>
																		</tr>
																		<?php
																		$nomor++;
																		}
																	}
																}
																?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
											<div role="tabpanel" class="tab-pane fade " id="f4sudahupload">
												<div class="row">
													<div class="col-lg-12">
														<table class="table table-striped table-hover table-bordered tbl-SI-KaizenAkt-MyKaizen">
															<thead class="bg-primary">
																<tr>
																	<th style="text-align: center;">No.</th>
																	<th style="text-align: center;">Judul</th>
																	<th style="text-align: center;">Create Ide</th>
																	<th style="text-align: center;">Due Date F4</th>
																	<th style="text-align: center;">Action</th>
																</tr>
															</thead>
															<tbody>
																<?php 
																if (isset($kaizen) && !empty($kaizen)) {
																	$nomor = 1;
																	foreach ($kaizen as $key => $value) {
																		$encrypted_string = $this->encrypt->encode($value['kaizen_id']);
																		$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
																		if($value['status'] == 'F4 Sudah di Upload'){
																		?>
																		<tr>
																			<td class="text-center"><?php echo $nomor ?></td>
																			<td><?php echo $value['judul'] ?></td>
																			<td><?php echo date('Y-m-d H:i:s',strtotime($value['created_timestamp'])) ?></td>
																			<td><?php echo $value['due_date_f4'] ?></td>
																			<td class="text-center">
																				<a href="<?php echo base_url('SystemIntegration/KaizenAkt/LihatF4/'.$encrypted_string) ?>" title="Lihat F4" class="btn btn-success btn-sm"><span class="fa fa-eye"></span></a>
																			</td>
																		</tr>
																		<?php
																		$nomor++;
																		}
																	}
																}
																?>
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
	</div>
</section>