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
											<div class="col-md-4 col-sm-6 col-md-offset-2">
												<div class="form-group">
													<label class="col-sm-4">Tanggal</label>
													<div class="col-sm-8">
														<input type="text" class="form-control" placeholder="Pilih Tanggal..." id="txt-CM-PekerjaTerhitungCatering-Tanggal">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-4">Shift</label>
													<div class="col-sm-8">
														<select class="select2" style="width: 100%" data-placeholder="Pilih Shift..." id="slc-CM-PekerjaTerhitungCatering-Shift">
															<option></option>
															<option value="1">Shift 1 & Umum</option>
															<option value="2">Shift 2</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-4">Lokasi Kerja</label>
													<div class="col-sm-8">
														<select class="select2" style="width: 100%" data-placeholder="Pilih Lokasi Kerja..." id="slc-CM-PekerjaTerhitungCatering-Lokasi">
															<option></option>
															<option value="1">Yogyakarta & Mlati</option>
															<option value="2">Tuksono</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-4 col-sm-6">
												<div class="form-group">
													<label class="col-sm-4">Tempat Makan</label>
													<div class="col-sm-8">
														<select class="select2" style="width: 100%" data-placeholder="Pilih Tempat Makan..." id="slc-CM-PekerjaTerhitungCatering-TempatMakan">
															<option></option>
															<?php if (isset($tempat_makan) && !empty($tempat_makan)) {
																foreach ($tempat_makan as $tm) {
																	?>
																	<option value="<?php echo $tm['fs_tempat_makan'] ?>"><?php echo $tm['fs_tempat_makan'] ?></option>
																	<?php
																}
															} ?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-12 text-center">
														<button type="button" class="btn btn-primary" id="btn-CM-PekerjaTerhitungCatering-Lihat">Lihat</button>
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
										<table class="table table-striped table-hover table-bordered" id="tbl-CM-PekerjaTerhitungKatering-Table">
											<thead>
												<tr>
													<th class="bg-primary">No.</th>
													<th class="bg-primary">No. Induk</th>
													<th class="bg-primary">Nama</th>
													<th class="bg-primary">Masuk</th>
													<th class="bg-primary">Tempat Makan</th>
													<th class="bg-primary">Titik Absen</th>
													<th class="bg-primary">Seksi</th>
													<th class="bg-primary">Shift</th>
													<th class="bg-primary">Status</th>
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
<div class="loading" id="ldg-CM-PekerjaTerhitungKatering-Loading" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>