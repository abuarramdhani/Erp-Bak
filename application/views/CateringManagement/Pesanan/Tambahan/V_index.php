<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><b><?= $Title ?></b></h1>
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
										<form class="form-horizontal" id="frm-CM-Tambahan-Form">
											<div class="col-lg-6">
												<div class="form-group">
													<label class="control-label col-lg-4">Tanggal</label>
													<div class="col-lg-8">
														<input type="text" name="txt-CM-Tambahan-Tanggal" id="txt-CM-Tambahan-Tanggal" class="form-control" placeholder="Tanggal" autocomplete="off" required value="<?php echo date('Y-m-d') ?>">
														<input type="hidden" name="txt-CM-Tambahan-Tanggal-Baru" id="txt-CM-Tambahan-Tanggal-Baru">
														<input type="hidden" name="txt-CM-Tambahan-IdTambahan" id="txt-CM-Tambahan-IdTambahan">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-4">Tempat makan</label>
													<div class="col-lg-8">
														<select class="select2" style="width: 100%" data-placeholder="Tempat Makan" name="slc-CM-Tambahan-TempatMakan" id="slc-CM-Tambahan-TempatMakan" autocomplete="off" disabled required>
															<option></option>
															<?php 
															if (isset($katering) && !empty($katering)) {
																foreach ($katering as $kt) {
																	?>
																	<option value="<?php echo $kt['fs_tempat_makan'] ?>"><?php echo $kt['fs_tempat_makan'].' - '.$kt['lokasi'] ?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-4">Shift</label>
													<div class="col-lg-8">
														<select class="select2" style="width: 100%" data-placeholder="Shift" name="slc-CM-Tambahan-Shift" id="slc-CM-Tambahan-Shift" autocomplete="off" disabled required>
															<option></option>
															<option value="1">Shift 1 & Umum</option>
															<option value="2">Shift 2</option>
															<option value="3">Shift 3</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-4">Kategori</label>
													<div class="col-lg-8">
														<select class="select2" style="width: 100%" data-placeholder="Kategori" name="slc-CM-Tambahan-Kategori" id="slc-CM-Tambahan-Kategori" disabled required>
															<option></option autocomplete="off">
															<option value="1">Lembur</option>
															<option value="2">Shift Tanggung</option>
															<option value="3">Tugas Ke Pusat</option>
															<option value="4">Tugas Ke Tuksono</option>
															<option value="5">Tugas Ke Mlati</option>
															<option value="6">Tamu</option>
															<option value="7">Cadangan</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-4">urutan</label>
													<div class="col-lg-8">
														<select class="select2" style="width: 100%" data-placeholder="Urutan" name="slc-CM-Tambahan-Urutan" id="slc-CM-Tambahan-Urutan" autocomplete="off" disabled required></select>
													</div>
												</div>
												<div class="form-group">
													<div class="col-lg-4 text-center">
														<button type="button" class="btn btn-primary" id="btn-CM-Tambahan-Tambah">Tambah</button>
													</div>
													<div class="col-lg-4 text-center">
														<button type="button" class="btn btn-warning" id="btn-CM-Tambahan-Edit" disabled>Edit</button>
													</div>
													<div class="col-lg-4 text-center">
														<button type="button" class="btn btn-danger" id="btn-CM-Tambahan-Hapus" disabled>Hapus</button>
													</div>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group" id="opt-CM-Tambahan-JumlahPesan" style="display: none;">
													<label class="control-label col-lg-4">Jumlah Pesan</label>
													<div class="col-lg-8">
														<input type="text" name="txt-CM-Tambahan-JumlahPesan" id="txt-CM-Tambahan-JumlahPesan" class="form-control" placeholder="Jumlah Pesan" autocomplete="off" disabled required>
													</div>
												</div>
												<div class="form-group" id="opt-CM-Tambahan-Pemohon" style="display: none;">
													<label class="control-label col-lg-4">Pemohon</label>
													<div class="col-lg-8">
														<select class="slc-CM-Tambahan-Pekerja" name="slc-CM-Tambahan-Pemohon" id="slc-CM-Tambahan-Pemohon" data-placeholder="Pemohon" autocomplete="off" style="width: 100%" disabled required></select>
													</div>
												</div>
												<div class="form-group" id="opt-CM-Tambahan-Keterangan" style="display: none;">
													<label class="control-label col-lg-4">Keterangan</label>
													<div class="col-lg-8">
														<textarea name="txt-CM-Tambahan-Keterangan" id="txt-CM-Tambahan-Keterangan" class="form-control" placeholder="Keterangan" autocomplete="off" disabled required></textarea>
													</div>
												</div>
												<div class="form-group" id="opt-CM-Tambahan-Penerima" style="display: none;">
													<label class="control-label col-lg-4">Penerima</label>
													<div class="col-lg-8">
														<select class="slc-CM-Tambahan-Penerima" name="slc-CM-Tambahan-Penerima" id="slc-CM-Tambahan-Penerima" autocomplete="off" data-placeholder="Penerima" style="width: 100%" disabled></select>
													</div>
												</div>
												<div class="form-group" id="opt-CM-Tambahan-Penerima-Table" style="display: none;">
													<div class="col-lg-12">
														<style type="text/css">
															#tbl-CM-Tambahan-Penerima-Table {
																width: 100% !important;
															}
															
															#tbl-CM-Tambahan-Penerima-Table td:nth-child(odd) {
																text-align: center;
																vertical-align: middle;
															}

															#opt-CM-Tambahan-Penerima-Table .dataTables_scrollHeadInner {
																width: 100% !important;
															}
															
															#opt-CM-Tambahan-Penerima-Table .dataTables_scrollHeadInner table {
																width: 100% !important;
															}

															#opt-CM-Tambahan-Penerima-Table .dataTables_scrollHead th:nth-child(1),
															#opt-CM-Tambahan-Penerima-Table .dataTables_scrollBody td:nth-child(1) {
																width: 92px !important;
																box-sizing: border-box !important;
															}

															#opt-CM-Tambahan-Penerima-Table .dataTables_scrollHead th:nth-child(2),
															#opt-CM-Tambahan-Penerima-Table .dataTables_scrollBody td:nth-child(2) {
																width: 325px !important;
																box-sizing: border-box !important;
															}

															#opt-CM-Tambahan-Penerima-Table .dataTables_scrollHead th:nth-child(3),
															#opt-CM-Tambahan-Penerima-Table .dataTables_scrollBody td:nth-child(3) {
																width: 70px !important;
																box-sizing: border-box !important;
															}

															#tbl-CM-Tambahan-Penerima-Table > thead > tr > th,
															#tbl-CM-Tambahan-Penerima-Table > tbody > tr > th,
															#tbl-CM-Tambahan-Penerima-Table > tfoot > tr > th, 
															#tbl-CM-Tambahan-Penerima-Table > thead > tr > td, 
															#tbl-CM-Tambahan-Penerima-Table > tbody > tr > td, 
															#tbl-CM-Tambahan-Penerima-Table > tfoot > tr > td {
																padding: 1px !important;
															}
														</style>
														<table class="table table-hover table-bordered table-striped" id="tbl-CM-Tambahan-Penerima-Table">
															<thead class="bg-info">
																<th style="text-align: center;vertical-align: middle;">No. Induk</th>
																<th style="text-align: center;vertical-align: middle;">Nama</th>
																<th style="text-align: center;vertical-align: middle;">Action</th>
															</thead>
															<tbody>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</form>
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
										<table class="table table-striped table-bordered table-hover" id="tbl-CM-Tambahan-Table" style="width: 100%">
											<thead>
												<tr>
													<th style="text-align: center;vertical-align: middle;">No.</th>
													<th style="text-align: center;vertical-align: middle;">Tempat Makan</th>
													<th style="text-align: center;vertical-align: middle;">Shift</th>
													<th style="text-align: center;vertical-align: middle;">Status</th>
													<th style="text-align: center;vertical-align: middle;">Jumlah</th>
													<th style="text-align: center;vertical-align: middle;">Pemohon</th>
													<th style="text-align: center;vertical-align: middle;">Keterangan</th>
													<th style="text-align: center;vertical-align: middle;">List Pekerja</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($tambahan) && !empty($tambahan)) {
													$nomor = 1;
													foreach ($tambahan as $dt) {
														?>
														<tr>
															<td style="text-align: center;"><?php echo $nomor ?></td>
															<td><?php echo $dt['fs_tempat_makan']."<input type='hidden' value='".$dt['id_tambahan']."'>" ?></td>
															<td><?php echo $dt['shift'] ?></td>
															<td><?php echo $dt['fb_kategori'] ?></td>
															<td style="text-align: center;"><?php echo $dt['fn_jumlah_pesanan'] ?></td>
															<td><?php echo $dt['fs_pemohon'] ?></td>
															<td><?php echo $dt['fs_keterangan'] ?></td>
															<td><?php echo $dt['list_pekerja'] ?></td>
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
<style type="text/css">
	.loading {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(0,0,0,.5);
    z-index: 9999;
}
.loading-wheel {
    width: 40px;
    height: 40px;
    margin-top: -80px;
    margin-left: -40px;
    
    position: absolute;
    top: 50%;
    left: 50%;
}
.loading-wheel-2 {
    width: 100%;
    height: 20px;
    margin-top: -50px;
    
    position: absolute;
    top: 70%;
    font-weight: bold;
    font-size: 30pt;
    color: white;
    text-align: center;
}

</style>
<div class="loading" id="CateringTambahanLoading" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>