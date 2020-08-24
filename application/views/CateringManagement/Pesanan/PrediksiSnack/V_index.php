<section class="content">
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
						<div class="box box-solid box-primary">
							<div class="box-header with-border text-right">
								<a href="<?php echo base_url('CateringManagement/Pesanan/PrediksiSnack/history') ?>" class="btn btn-success">Data History Prediksi Snack</a>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-lg-4">Tanggal</label>
												<div class="col-lg-4">
													<input type="text" name="txt-CM-PrediksiSnack-Tanggal" id="txt-CM-PrediksiSnack-Tanggal" class="form-control" placeholder="Tanggal" autocomplete="off" value="<?php echo date("Y-m-d") ?>">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Shift</label>
												<div class="col-lg-4">
													<select class="select2" name="slc-CM-PrediksiSnack-Shift" id="slc-CM-PrediksiSnack-Shift" style="width: 100%" disabled>
														<option value="1">Shift 1 & Umum</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Lokasi</label>
												<div class="col-lg-4">
													<select class="select2" name="slc-CM-PrediksiSnack-Lokasi" id="slc-CM-PrediksiSnack-Lokasi" style="width: 100%">
														<option></option>
														<option value="1" <?php echo (isset($lokasi) && $lokasi == '1') ? 'selected' : '' ?> >Yogyakarta & Mlati</option>
														<option value="2" <?php echo (isset($lokasi) && $lokasi == '2') ? 'selected' : '' ?> >Tuksono</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-12 text-center">
													<button type="button" id="btn-CM-PrediksiSnack-List" class="btn btn-info">List</button>
													<button type="button" id="btn-CM-PrediksiSnack-Prediksi" class="btn btn-primary">Prediksi</button>
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
<div class="loading" id="ldg-CM-PrediksiSnack-Loading">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>