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
									<div class="col-lg-5">
										<form class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-lg-4">Jenis Presensi</label>
												<div class="col-lg-6">
													<select class="select2" id="hlcm-detailpresensi-jenpres" style="width: 100%">
														<option>Presensi</option>
														<option>Lembur</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Jenis Tampilan</label>
												<div class="col-lg-6">
													<select class="select2" id="hlcm-detailpresensi-jentam" style="width: 100%">
														<option value="1">/</option>
														<option value="2">S</option>
													</select>
												</div>
											</div>
										</form>
									</div>
									<div class="col-lg-7">
										<form class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-lg-5">Cut Off</label>
												<div class="col-lg-3">
													<input type="text" id="hlcm-detailpresensi-cutoff-awal" class="hlcm-presensipekerja-daterangepickersingledate form-control">
												</div>
												<label class="control-label col-lg-1 text-center">-</label>
												<div class="col-lg-3">
													<input type="text" id="hlcm-detailpresensi-cutoff-akhir" class="hlcm-presensipekerja-daterangepickersingledate form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-5">
													Pekerja Keluar &nbsp;
													<input type="button" id="hlcm-detailpresensi-pkjoff" class="btn btn-danger" value="Off">
												</label>
												<div class="col-lg-3">
													<input type="text" id="hlcm-detailpresensi-cutoff-awal-pkjoff" class="hlcm-presensipekerja-daterangepickersingledate form-control">
												</div>
												<label class="control-label col-lg-1 text-center">-</label>
												<div class="col-lg-3">
													<input type="text" id="hlcm-detailpresensi-cutoff-akhir-pkjoff" class="hlcm-presensipekerja-daterangepickersingledate form-control">
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 text-right">
										<button class="btn btn-primary" onclick="hlcmPresensiPekerjaLihat()">Lihat</button>
									</div>
									<div class="col-lg-4 text-center">
										<button class="btn btn-danger" id="hlcm-detailpresensi-cetak" onclick="hlcmPresensiPekerjaCetak()" style="display: none;">Cetak</button>
									</div>
									<div class="col-lg-4 text-left">
										<button class="btn btn-success" id="hlcm-detailpresensi-simpan" onclick="hlcmPresensiPekerjaSimpan()" style="display: none;">Simpan</button>
										<div class="collapse" id="hlcm-detailpresensi-collapse">
											<div class="col-lg-12 text-center">
												<span style="color: red" id="hlcm-detailpresensi-collapse-ket"><i>Mohon untuk mengisi Keterangan</i></span>
											</div>
											<div class="col-lg-12">
												<textarea class="form-control" id="hlcm-detailpresensi-keterangan"></textarea>
											</div>
										</div>
										
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 text-center">
										<hr>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-8">
										<table id="hlcm-tbl-detailpresensi" class="table table-hover table-striped table-hover table-bordered">
											<thead>
												<tr>
													<th rowspan="2" style='text-align: center;vertical-align: middle;'>No. Induk</th>
													<th rowspan="2" style='text-align: center;vertical-align: middle;'>Nama</th>
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
																	echo "<th colspan='".$hitung_colspan."'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
																	$hitung_colspan = 1;
																}else{
																	$tanggal_pertama = $dt_bulan['tanggal'];
																}
															}
															$simpan_bulan_tahun = $dt_bulan['bulan'].$dt_bulan['tahun'];
															$simpan_bulan = $dt_bulan['bulan'];
															$simpan_tahun = $dt_bulan['tahun'];
														}
														echo "<th colspan='".$hitung_colspan."' style='text-align: center'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
														$tanggal_terakhir = $dt_bulan['tanggal'];
													?>
												</tr>
												<tr>
													<?php  
														foreach ($tanggal as $dt_tanggal) {
															echo "<th style='text-align: center'>".$dt_tanggal['hari']."</th>";
														}
													?>
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
									<div class="col-lg-4">
										<table id="hlcm-tbl-detailpresensi-waktu" class="table table-hover table-striped table-hover table-bordered">
											<thead class="bg-primary">
												<tr>
													<th>Tanggal</th>
													<th>Nama</th>
													<th>Waktu</th>
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
<div class="loading" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>