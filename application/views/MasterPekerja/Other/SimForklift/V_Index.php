<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><b><?=$Title ?></b></h1>	
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border text-right">
								<a href="<?php echo base_url('MasterPekerja/SimForklift/tambah') ?>" class="btn btn-primary">Tambah</a>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12 text-right">
										<a href="" target="_blank" id="btnSimForkliftCetakPdf" class="btn btn-danger" disabled><span class="fa fa-file-pdf-o"></span> Cetak SIM PDF</a>
										<a href="" target="_blank" id="btnSimForkliftCetakImg" class="btn btn-warning" disabled><span class="fa fa-file-image-o"></span> Cetak SIM IMG</a>
										<a href="" target="_blank" id="btnSimForkliftCetakCrl" class="btn btn-success" disabled><span class="fa fa-file-image-o"></span> Cetak SIM COREL</a>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<style type="text/css">
											.dt-buttons {
												float: left;
											}
											.dataTables_filter {
												float: right;
											}

											.dataTables_info {
												float: left
											}
										</style>
										<table class="table table-bordered table-hover table-striped" style="width: 100%" id="tblMPKSimForkliftList">
											<thead class="bg-primary">
												<tr>
													<th style="text-align: center;">
														<input type="checkbox" id="chkMPKSimForkliftCheckAll" value="all">
													</th>
													<th style="text-align: center;">No</th>
													<th style="text-align: center;">No. Induk</th>
													<th style="text-align: center;">Nama</th>
													<th style="text-align: center;">Seksi</th>
													<th style="text-align: center;">Jenis</th>
													<th style="text-align: center;">Mulai Berlaku</th>
													<th style="text-align: center;">Selesai Berlaku</th>
													<th style="text-align: center;">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($data) && !empty($data)) {
													$nomor = 1;
													foreach ($data as $dt) {
														$encrypted_string = $this->encrypt->encode($dt['id_sim']);
	                                                	$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

														?>
														<tr>
															<td style="text-align: center;">
																<input type="checkbox" class="chkMPKSimForkliftCheckOne" value="<?php echo $dt['id_sim'] ?>">
															</td>
															<td style="text-align: center;"><?php echo $nomor ?></td>
															<td style="text-align: center;"><?php echo $dt['noind'] ?></td>
															<td><?php echo $dt['nama'] ?></td>
															<td><?php echo $dt['seksi'] ?></td>
															<td><?php echo $dt['jenis'] ?></td>
															<td><?php echo strftime('%B %Y',strtotime($dt['mulai_berlaku'])) ?></td>
															<td><?php echo strftime('%B %Y',strtotime($dt['selesai_berlaku'])) ?></td>
															<td>
																<button type="button" data-id="<?php echo $dt['id_sim'] ?>" class="btn btn-danger btnMPKSimForkliftHapus"><span class="fa fa-trash"></span> Hapus</button>
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
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>