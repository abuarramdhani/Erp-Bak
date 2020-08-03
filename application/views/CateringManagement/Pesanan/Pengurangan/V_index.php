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
										<form class="form-horizontal" id="frm-CM-Pengurangan-Form">
											<div class="col-lg-6">
												<div class="form-group">
													<label class="control-label col-lg-4">Tanggal</label>
													<div class="col-lg-8">
														<input type="text" name="txt-CM-Pengurangan-Tanggal" id="txt-CM-Pengurangan-Tanggal" class="form-control" placeholder="Tanggal" autocomplete="off" value="<?php echo date('Y-m-d') ?>">
														<input type="hidden" name="txt-CM-Pengurangan-Tanggal-Baru" id="txt-CM-Pengurangan-Tanggal-Baru" value="<?php echo date('Y-m-d') ?>">
														<input type="hidden" name="txt-CM-Pengurangan-IdPengurangan" id="txt-CM-Pengurangan-IdPengurangan">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-4">Tempat makan</label>
													<div class="col-lg-8">
														<select class="select2" style="width: 100%" data-placeholder="Tempat Makan" name="slc-CM-Pengurangan-TempatMakan" id="slc-CM-Pengurangan-TempatMakan" autocomplete="off" disabled>
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
														<select class="select2" style="width: 100%" data-placeholder="Shift" name="slc-CM-Pengurangan-Shift" id="slc-CM-Pengurangan-Shift" autocomplete="off" disabled>
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
														<select class="select2" style="width: 100%" data-placeholder="Kategori" name="slc-CM-Pengurangan-Kategori" id="slc-CM-Pengurangan-Kategori" disabled>
															<option></option autocomplete="off">
															<option value="1">Tidak Makan ( Ganti Uang ) </option>
															<option value="2">Pindah Makan</option>
															<option value="3">Tugas Ke Pusat</option>
															<option value="4">Tugas Ke Tuksono</option>
															<option value="5">Tugas Ke Mlati</option>
															<option value="6">Tugas Luar</option>
															<option value="7">Dinas Perusahaan ( Kunjungan Kerja / Layat / dll ) </option>
															<option value="8">Tidak Makan ( Tidak diganti Uang ) </option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<div class="col-lg-4 text-center">
														<button type="button" class="btn btn-primary" id="btn-CM-Pengurangan-Tambah">Tambah</button>
													</div>
													<div class="col-lg-4 text-center">
														<button type="button" class="btn btn-warning" id="btn-CM-Pengurangan-Edit" disabled>Edit</button>
													</div>
													<div class="col-lg-4 text-center">
														<button type="button" class="btn btn-danger" id="btn-CM-Pengurangan-Hapus" disabled>Hapus</button>
													</div>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group" id="opt-CM-Pengurangan-TempatMakanBaru" style="display: none;">
													<label class="control-label col-lg-4">Tempat Makan Baru</label>
													<div class="col-lg-8">
														<select class="slc-CM-Pengurangan-TempatMakanBaru" name="slc-CM-Pengurangan-TempatMakanBaru" id="slc-CM-Pengurangan-TempatMakanBaru" data-placeholder="Tempat Makan Baru" autocomplete="off" style="width: 100%" disabled></select>
													</div>
												</div>
												<div class="form-group" id="opt-CM-Pengurangan-Penerima" style="display: none;">
													<label class="control-label col-lg-4">Penerima</label>
													<div class="col-lg-8">
														<select class="slc-CM-Pengurangan-Penerima" name="slc-CM-Pengurangan-Penerima" id="slc-CM-Pengurangan-Penerima" autocomplete="off" data-placeholder="Penerima" style="width: 100%" disabled></select>
													</div>
												</div>
												<div class="form-group" id="opt-CM-Pengurangan-Penerima-Table" style="display: none;">
													<div class="col-lg-12">
														<style type="text/css">
															#tbl-CM-Pengurangan-Penerima-Table td:nth-child(odd) {
																text-align: center;
																vertical-align: middle;
															}

															#tbl-CM-Pengurangan-Penerima-Table {
																width: 100% !important;
															}

															.dataTables_scrollHeadInner {
																width: 100% !important;
															}
															.dataTables_scrollHeadInner table {
																width: 100% !important;
															}

															.dataTables_scrollHead th:nth-child(1),
															.dataTables_scrollBody td:nth-child(1) {
																width: 92px !important;
																box-sizing: border-box !important;
															}

															.dataTables_scrollHead th:nth-child(2),
															.dataTables_scrollBody td:nth-child(2) {
																width: 325px !important;
																box-sizing: border-box !important;
															}

															.dataTables_scrollHead th:nth-child(3),
															.dataTables_scrollBody td:nth-child(3) {
																width: 70px !important;
																box-sizing: border-box !important;
															}

															#tbl-CM-Pengurangan-Penerima-Table > thead > tr > th,
															#tbl-CM-Pengurangan-Penerima-Table > tbody > tr > th,
															#tbl-CM-Pengurangan-Penerima-Table > tfoot > tr > th, 
															#tbl-CM-Pengurangan-Penerima-Table > thead > tr > td, 
															#tbl-CM-Pengurangan-Penerima-Table > tbody > tr > td, 
															#tbl-CM-Pengurangan-Penerima-Table > tfoot > tr > td {
																padding: 1px !important;
															}
														</style>
														<table class="table table-hover table-bordered table-striped" id="tbl-CM-Pengurangan-Penerima-Table" style="width: 100%">
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
										<table class="table table-striped table-bordered table-hover" id="tbl-CM-Pengurangan-Table" style="width: 100%">
											<thead>
												<tr>
													<th style="text-align: center;vertical-align: middle;">No.</th>
													<th style="text-align: center;vertical-align: middle;">Tempat Makan</th>
													<th style="text-align: center;vertical-align: middle;">Shift</th>
													<th style="text-align: center;vertical-align: middle;">Status</th>
													<th style="text-align: center;vertical-align: middle;">Tempat Makan Baru</th>
													<th style="text-align: center;vertical-align: middle;">Jumlah</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($pengurangan) && !empty($pengurangan)) {
													$nomor = 1;
													foreach ($pengurangan as $dt) {
														?>
														<tr>
															<td style="text-align: center;"><?php echo $nomor ?></td>
															<td><?php echo $dt['fs_tempat_makan']."<input type='hidden' value='".$dt['id_pengurangan']."'>" ?></td>
															<td><?php echo $dt['shift'] ?></td>
															<td><?php echo $dt['fb_kategori'] ?></td>
															<td><?php echo $dt['fs_tempat_makanpg'] ?></td>
															<td style="text-align: center;"><?php echo $dt['fn_jml_tdkpesan'] ?></td>
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
<div class="loading" id="CateringPenguranganLoading">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>