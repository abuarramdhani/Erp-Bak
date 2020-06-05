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
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal">
											<div class="col-lg-6">
												<div class="form-group">
													<label class="control-label col-lg-4">Tanggal</label>
													<div class="col-lg-4">
														<input type="text" class="form-control" placeholder="Pilih Tanggal..." id="txt-CM-AbsenPerLokasiAbsen-Tanggal">
													</div>
													<div class="col-lg-2">
														<button type="button" class="btn btn-primary" id="btn-CM-AbsenPerLokasiAbsen-cari">Cari</button>
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
										<table class="table table-striped table-bordered table-hover" id="tbl-CM-AbsenPerLokasiAbsen-table">
											<thead>
												<tr>
													<th class="bg-primary text-center">Titik Absen</th>
													<th class="bg-primary text-center">Inisial</th>
													<th class="bg-primary text-center">Lokasi</th>
													<th class="bg-primary text-center">Absen</th>
													<th class="bg-primary text-center">Katering</th>
													<th class="bg-primary text-center">Last Update</th>
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

<div class="modal" tabindex="-1" role="dialog" area-hidden="true" id="mdl-CM-AbsenPerLokasiAbsen">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-lg-12">
						<button class="btn btn-danger" id="mdl-CM-AbsenPerLokasiAbsen-close" style="float: right;border-radius: 0px">
							<span class="glyphicon glyphicon-off"></span>
						</button>
						<span style="font-size: 15pt;">Detail Absen Per Lokasi Absen : </span> <span id="mdl-CM-AbsenPerLokasiAbsen-judul" style="font-size: 20pt;font-weight: bold;"></span>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">Detail Absen</div>
							<div class="box-body">
								<table  class="table table-striped table-hover table-bordered" id="tbl-CM-AbsenPerLokasiAbsen-Absen">
									<thead>
										<tr>
											<th>No. Induk</th>
											<th>Nama</th>
											<th>Shift</th>
											<th>Waktu</th>
											<th>Tempat Makan</th>
										</tr>
									</thead>
									<tbody>
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">Detail Katering</div>
							<div class="box-body">
								<table  class="table table-striped table-hover table-bordered" id="tbl-CM-AbsenPerLokasiAbsen-Katering">
									<thead>
										<tr>
											<th>No. Induk</th>
											<th>Nama</th>
											<th>Shift</th>
											<th>Waktu</th>
											<th>Tempat Makan</th>
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
			<div class="modal-footer">

			</div>
		</div>
	</div>
</div>

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
<div class="loading" id="ldg-CM-AbsenPerLokasiAbsen-Loading" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>