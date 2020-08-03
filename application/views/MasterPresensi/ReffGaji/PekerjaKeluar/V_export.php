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
							<div class="box-header with-border">
								
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-lg-4">Periode Keluar</label>
												<div class="col-lg-4">
													<input type="text" class="date form-control" id="txt-MPR-PekerjaKeluar-Export-PeriodeKeluar">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Kode Induk</label>
												<div class="col-lg-4">
													<select class="select2" multiple="multiple" style="width: 100%" id="txt-MPR-PekerjaKeluar-Export-KodeInduk">
														<option value="A">A - Pekerja Non Staf / Operator</option>
														<option value="B">B - Pekerja Staf</option>
														<option value="D">D - Trainee Staf</option>
														<option value="E">E - Trainee Non Staf</option>
														<option value="H">H - Kontrak Non Staf</option>
														<option value="J">J - Kontrak Staf</option>
														<option value="T">T - Kontrak Non Staff Khusus</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-12 text-center">
													<button type="button" id="btn-MPR-PekerjaKeluar-Export-Lihat" class="btn btn-primary"><span class="fa fa-eye"></span> Tampil</button>
													<button type="button" id="btn-MPR-PekerjaKeluar-Export-Pdf" class="btn btn-danger"><span class="fa fa-file-pdf-o"></span> PDF</button>
													<button type="button" id="btn-MPR-PekerjaKeluar-Export-Excel" class="btn btn-success"><span class="fa fa-file-excel-o"></span> Excel</button>
													<button type="button" id="btn-MPR-PekerjaKeluar-Export-Dbf" class="btn btn-warning"><span class="fa fa-file-code-o"></span> DBF</button>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<style type="text/css">
											.dt-buttons, .dataTables_info {
												float: left;
											}
											.dataTables_filter, .dataTables_paginate{
												float: right;
											}
										</style>
										<table class="table table-striped table-bordered table-hover" id="tbl-MPR-PekerjaKeluar-Export">
											<thead>
												<tr>
													<th style="text-align: center;width: 30px;">No.</th>
													<th style="text-align: center;">No Induk</th>
													<th style="text-align: center;">Nama</th>
													<th style="text-align: center;">Tanggal Keluar</th>
													<th style="text-align: center;">IP</th>
													<th style="text-align: center;">IK</th>
													<th style="text-align: center;">UBT</th>
													<th style="text-align: center;">UPAMK</th>
													<th style="text-align: center;">IF</th>
													<th style="text-align: center;">LEMBUR</th>
													<th style="text-align: center;">HTM</th>
													<th style="text-align: center;">Ijin</th>
													<th style="text-align: center;">Sisa Cuti</th>
													<th style="text-align: center;">Keterangan</th>
													<th style="text-align: center;">UM Puasa</th>
													<th style="text-align: center;">IMS</th>
													<th style="text-align: center;">IMM</th>
													<th style="text-align: center;">IPT</th>
													<th style="text-align: center;">UM Cabang</th>
													<th style="text-align: center;">Uang DL</th>
													<th style="text-align: center;">Pot. Lain</th>
													<th style="text-align: center;">Tambahan</th>
													<th style="text-align: center;">Potongan</th>
													<th style="text-align: center;">Jumlah JKN</th>
													<th style="text-align: center;">Jumlah JHT</th>
													<th style="text-align: center;">Jumlah JP</th>
													<th style="text-align: center;">Total Duka</th>
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
    z-index: 9999 !important;
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
<div class="loading" id="ldg-MPR-PekerjaKeluar-Export-Loading" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>