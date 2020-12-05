<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<br>
						<h1><?= $Title ?></h1>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="box box-primary box-solid">
						<div class="box-header with-border">
							<div class="row">
								<div class="col-lg-12 text-right">
									<a href="<?php echo site_url('MasterPekerja/Surat/PengalamanKerja/Tambah') ?>" class="btn btn-primary"><span class="fa fa-plus"></span>&nbsp;Tambah</a>
								</div>
							</div>
						</div>
						<div class="box-body">
							<div class="row">
								<div class="col-lg-12">
									<table class="table table-striped table-hover table-bordered" id="tbl" .$new_table_name. "" style="width: 100%;">
										<thead class="bg-primary">
											<tr>
												<th style="text-align:center" width="5%">No.</th>
												<th style="text-align:center" width="20%">Action</th>
												<th style="text-align:center" width="5%">No. Surat</th>
												<th style="text-align:center" width="10%">Tanggal surat</th>
												<th style="text-align:center" width="10%">Pekerja</th>
												<th style="text-align:center" width="50%">Isi Surat</th>
												<th class="hidden">noind</th>
											</tr>
										</thead>
										<tbody>
											<?php
											if (isset($data) && !empty($data)) {
												$nomor = 1;
												foreach ($data as $dt) {
													// 2020-07_065
													$link = trim($dt['kd_surat']) . "_" . trim($dt['no_surat']);
													$link = str_replace("/", "-", $link);
											?>
													<tr id="<?= $link; ?>" style="color: <?= $dt['warna'] ?>">
														<td><?php echo $nomor ?></td>
														<td style="text-align: center">
															<a href="<?php echo site_url('MasterPekerja/Surat/PengalamanKerja/Ubah/' . $link) ?>" class="btn btn-primary">Edit</a>

															<!--<a href="<?php echo site_url('MasterPekerja/Surat/PengalamanKerja/PDF/' . $link) ?>" class="btn btn-warning">PDF</a> -->
															<a data-value='<?php echo $link ?>' data-noind='<?php echo $dt['noind'] ?>' data-sampai='<?php echo $dt['tgl_kena'] ?>' class="btn btn-warning Modal_pdf_pengalaman">PDF</a>
															<!-- <a data-toggle="modal" data-target="#Modal_pdf_pengalaman" value='$link' class="btn btn-warning" class="Modal_pdf_pengalaman" >PDF</a>  -->
															<a href="<?php echo site_url('MasterPekerja/Surat/PengalamanKerja/Hapus/' . $link) ?>" class="btn btn-danger" onclick="return confirm('apakah anda yakin ingin menghapus data ini ?')">Delete</a>
														</td>
														<td><?php echo $dt['no_surat'] ?></td>
														<td><?php echo $dt['tgl_surat'] ?></td>
														<td><?php echo $dt['pekerja'] ?></td>
														<td><?php echo $dt['isi_surat'] ?></td>
														<td class="hidden" id="noindlog" name="noindlog"><?= $dt['noind'] ?></td>
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

<!--a href="<?php echo site_url('MasterPekerja/Surat/PengalamanKerja/PDF/' . $link) ?>" -->

<div class="modal fade" id="Modal_pdf_pengalaman" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document" style="width: 600px">
		<div class="modal-content">
			<form method="POST" action="<?php echo base_url("MasterPekerja/Surat/PengalamanKerja/PDF"); ?>" target="_blank">
				<div class="modal-header text-center">
					<button type="button" class="close hover" data-dismiss="modal">&times;</button>
					<h3>Input Data</h3>
				</div>
				<div class="modal-body" style="width: 100%; text-align: center;">
					<div class="row">
						<div class="col-lg-12">
							<label class="col-lg-12 text-center">Jabatan</label><br>
							<input class="form-control col-lg-8 text-center" style="margin-left: 23%; width: 55%; text-align: center;" name="jabatan_pengalaman" id="jabatan_pengalaman" autocomplete="off" value="">
							<input type="hidden" name="link_pengalaman" id="link_pengalaman">
							<input type="hidden" name="noind_pengalaman" id="noind_pengalaman">
							<input type="hidden" name="sampai_pengalaman" id="sampai_pengalaman">
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-lg-12">
							<label class="col-lg-12 text-center">NIK</label> <br>
							<input class="form-control col-lg-8 text-center" style="margin-left: 23%; width: 55%; text-align: center;" name="nik_pengalaman" id="nik_pengalaman" autocomplete="off" value="">

							</select>
							<input type="checkbox" id="cekNIK" name="cekNIK" value="nik">
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-lg-12">
							<label class="col-lg-12 text-center">Tanggal Cetak</label><br>
							<input class="form-control col-lg-8 text-center" style="margin-left: 23%; width: 55%; text-align: center;" name="pengalaman_tglCetak" id="pengalaman_tglCetak" autocomplete="off" value="">
						</div>
					</div>
				</div>
				<div class="modal-footer" style="text-align: center;">
					<button type="submit" class="btn btn-success" id="prev_Pengalaman">Cetak</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- required nya tak ilangi dulu bu -->