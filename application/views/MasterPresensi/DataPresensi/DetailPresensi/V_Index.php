<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="box box-solid box-primary">
					<div class="box-header with-border">
						INFO PEGAWAI
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="row">
									<div class="col-lg-4">
										<form class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-lg-4">Jenis Presensi</label>
												<div class="col-lg-8">
													<select id="slcMPRDetailPresensiJenisPresensi" style="width: 100%">
														<option>Presensi</option>
														<option>Lembur</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Jenis Tampilan</label>
												<div class="col-lg-8">
													<select id="slcMPRDetailPresensiJenisTampilan" style="width: 100%">
														<option value="1">/</option>
														<option value="2">S</option>
													</select>
												</div>
											</div>
										</form>
									</div>
									<div class="col-lg-4">
										<form class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-lg-4">
													Kode Induk
													<span style="color: red;">*</span>
												</label>
												<div class="col-lg-8">
													<select class="select2" id="slcMPRDetailPresensiKodeInduk" data-placeholder="Kode Induk" style="width: 100%">
														<option></option>
														<?php
														if (isset($kode_induk) && !empty($kode_induk)) {
															foreach ($kode_induk as $ki) {
																?>
																<option value="<?php echo $ki['noind'] ?>"><?php echo $ki['noind']." - ".$ki['ket'] ?></option>
																<?php
															}
														}
														 ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">
													Lokasi Kerja
													<span style="color: red;">*</span>
												</label>
												<div class="col-lg-8">
													<select class="select2" id="slcMPRDetailPresensiLokasiKerja" data-placeholder="Lokasi Kerja" style="width: 100%">
														<option></option>
														<?php
														if (isset($lokasi_kerja) && !empty($lokasi_kerja)) {
															foreach ($lokasi_kerja as $lk) {
																?>
																<option value="<?php echo $lk['kode_lokasi'] ?>"><?php echo $lk['kode_lokasi']." - ".$lk['nama_lokasi'] ?></option>
																<?php
															}
														}
														 ?>
													</select>
												</div>
											</div>
										</form>
									</div>
									<div class="col-lg-4">
										<form class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-lg-4">Periode Absen</label>
												<div class="col-lg-8">
													<input type="text" id="slcMPRDetailPresensiPeriodeAbsen" class="form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">
													Pekerja Keluar &nbsp;
												</label>
												<div class="col-lg-1">
													<input type="checkbox" id="chkMPRDetailPresensiPekerjaKeluar">
												</div>
												<div class="col-lg-7">
													<input type="text" id="txtMPRDetailPresensiPekerjaKeluar" class="form-control" disabled>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<span style="color: red">* : Kosongi untuk memilih semua.</span>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 text-center">
										<button class="btn btn-primary" id="btnMPRDetailPresensiLihat">
											<span class="fa fa-search"></span>
											Lihat
										</button>
										<button class="btn btn-danger" id="btnMPRDetailPresensiPdf" disabled>
											<span class="fa fa-file-pdf-o"></span>
											Pdf
										</button>
										<button class="btn btn-success" id="btnMPRDetailPresensiExcel" disabled>
											<span class="fa fa-file-excel-o"></span>
											Excel
										</button>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-lg-8">
										<table id="tblMPRDetailPresensiPresensiHarian" class="table table-hover table-striped table-hover table-bordered">
											<thead>
												<tr>
													<th class="bg-primary" rowspan="2" style='text-align: center;vertical-align: middle;'>No. Induk</th>
													<th class="bg-primary" rowspan="2" style='text-align: center;vertical-align: middle;'>Nama</th>
													<?php  
														$simpan_bulan_tahun = "";
														$simpan_bulan = "";
														$simpan_tahun = "";
														$hitung_colspan = 1;
														$tanggal_pertama = "";
														$tanggal_terakhir = "";
														$bulan = array (
																		1 =>   'Januari',
																			'Februari',
																			'Maret',
																			'April',
																			'Mei',
																			'Juni',
																			'Juli',
																			'Agustus',
																			'September',
																			'Oktober',
																			'November',
																			'Desember'
																		);
														foreach ($tanggal as $dt_bulan) {
															if($dt_bulan['bulan'].$dt_bulan['tahun'] == $simpan_bulan_tahun){
																$hitung_colspan++;
															}else{
																if ($simpan_bulan !== "") {
																	echo "<th class='bg-primary' colspan='".$hitung_colspan."'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
																	$hitung_colspan = 1;
																}else{
																	$tanggal_pertama = $dt_bulan['tanggal'];
																}
															}
															$simpan_bulan_tahun = $dt_bulan['bulan'].$dt_bulan['tahun'];
															$simpan_bulan = $dt_bulan['bulan'];
															$simpan_tahun = $dt_bulan['tahun'];
														}
														echo "<th class='bg-primary' colspan='".$hitung_colspan."' style='text-align: center'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
														$tanggal_terakhir = $dt_bulan['tanggal'];
													?>
												</tr>
												<tr>
													<?php  
														foreach ($tanggal as $dt_tanggal) {
															echo "<th class='bg-primary' style='text-align: center'>".$dt_tanggal['hari']."</th>";
														}
													?>
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
									<div class="col-lg-4">
										<table id="tblMPRDetailPresensiJamAbsen" class="table table-hover table-striped table-hover table-bordered">
											<thead>
												<tr>
													<th class="bg-primary">Tanggal</th>
													<th class="bg-primary">Nama</th>
													<th class="bg-primary">Waktu</th>
												</tr>
											</thead>
											<tbody>
												
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
<div class="loading" id="ldgMPRDetailPresensi" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>