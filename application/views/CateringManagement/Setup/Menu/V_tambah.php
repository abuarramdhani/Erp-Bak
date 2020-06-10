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
											<div class="col-lg-6">
												<div class="form-group">
													<label class="control-label col-lg-4">Shift</label>
													<div class="col-lg-8">
														<select class="select2" data-placeholder="Pilih Shift..." style="width: 100%" autocomplete="off" id="slc-CM-Menu-Shift">
															<option></option>
															<option value="1">Shift 1 & Umum</option>
															<option value="2">Shift 2</option>
															<option value="3">Shift 3</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-4">Bulan Tahun</label>
													<div class="col-lg-8">
														<input type="text" class="form-control" placeholder="Pilih Bulan Tahun..." autocomplete="off" id="txt-CM-Menu-BulanTahun">
													</div>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<label class="control-label col-lg-4">Lokasi</label>
													<div class="col-lg-8">
														<select class="select2" data-placeholder="Pilih Lokasi..." style="width: 100%" autocomplete="off" id="slc-CM-Menu-Lokasi">
															<option></option>
															<option value="1">Yogyakarta & Mlati</option>
															<option value="2">Tuksono</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-4">Copy Menu</label>
													<div class="col-lg-6">
														<input type="text" class="form-control" placeholder="Pilih Bulan Tahun yang di Copy..." autocomplete="off" id="txt-CM-Menu-CopyMenu">
													</div>
													<div class="col-lg-2">
														<button type="button" class="btn btn-primary">Copy</button>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-striped table-hover table-bordered" id="tbl-CM-Menu-Create">
											<thead>
												<tr>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">Tanggal</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">Sayur</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">Lauk Utama</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">Lauk Pendamping</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">Buah</th>
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 text-right">
										<a href="javascript:history.back()" class="btn btn-danger">Kembali</a>
										<button type="text" class="btn btn-primary" id="btn-CM-Menu-Simpan">Simpan</button>
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
<div class="loading" id="ldg-CM-Menu-Loading" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>