<div class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><?=$Title ?></h1>
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
										<form id="CateringHitungPesananForm" class="form-horizontal" method="POST" action="<?php echo site_url('CateringManagement/HitungPesanan/prosesLihat') ?>">
											<div class="form-group">
												<label class="control-label col-md-4">Tanggal</label>
												<div class="col-md-4">
													<input type="text"class="form-control" placeholder="Pilih Tanggal..." id="CateringHitungPesananTanggal" name="CateringHitungPesananTanggal" autocomplete="off" value="<?php echo date('Y-m-d') ?>">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-4">Shift</label>
												<div class="col-md-4">
													<select class="select2" style="width: 100%" data-placeholder="Pilih Shift..." id="CateringHitungPesananShift" name="CateringHitungPesananShift">
														<option></option>
														<option value="1" <?php echo (strtotime(date("Y-m-d H:i:s")) < strtotime(date('Y-m-d 12:30:00'))) ? "selected" : ""  ?>>Shift 1 & Umum</option>
														<option value="2" <?php echo (strtotime(date("Y-m-d H:i:s")) >= strtotime(date('Y-m-d 12:30:00')) && strtotime(date("Y-m-d H:i:s")) <= strtotime(date('Y-m-d 16:30:00'))) ? "selected" : ""  ?>>Shift 2</option>
														<option value="3" <?php echo (strtotime(date("Y-m-d H:i:s")) > strtotime(date('Y-m-d 16:30:00'))) ? "selected" : ""  ?>>Shift 3</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-4">Lokasi Kerja</label>
												<div class="col-md-4">
													<select class="select2" style="width: 100%" data-placeholder="Pilih Lokasi Kerja..." id="CateringHitungPesananLokasi" name="CateringHitungPesananLokasi">
														<option></option>
														<option value="1" <?php echo (isset($lokasi_kerja) && $lokasi_kerja == 1) ? "selected" : "" ?>>Pusat</option>
														<option value="2" <?php echo (isset($lokasi_kerja) && $lokasi_kerja == 2) ? "selected" : "" ?>>Tuksono</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-2 col-sm-offset-4 text-center">
													<button type="submit" class="btn btn-primary" id="CateringHitungLihat">Lihat</button>
												</div>
												<div class="col-sm-2 text-center">
													<button type="button" class="btn btn-success" id="CateringHitungRefresh">Refresh</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="CateringHitungModal">
	<div class="modal-dialog modal-sm" role="document">
    	<div class="modal-content">
    		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Pilih Jari</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<p>Pilih Jari Yang Akan Digunakan Untuk Verifikasi</p>
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
<div class="loading" id="CateringHitungLoading" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>