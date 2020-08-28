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
										<form class="form-horizontal" id="frm-CVD-MonitoringCovid-Tambah">
											<div class="form-group">
												<label class="control-label col-lg-4">Pekerja</label>
												<div class="col-lg-4">
													<select id="slc-CVD-MonitoringCovid-Tambah-Pekerja" style="width: 100%" data-placeholder="Pilih Pekerja">
														<?php 
														if (isset($data) && !empty($data)) {
															?>
															<option value="<?php echo $data->noind ?>"><?php echo $data->noind." - ".$data->nama ?></option>
															<?php
														}
														?>
													</select>
													<input type="hidden" id="txt-CVD-MonitoringCovid-Tambah-PekerjaId" name="pekerja_id" value="<?php echo (isset($data) && !empty($data)) ? $data->cvd_pekerja_id : ''; ?>">
															
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Seksi</label>
												<div class="col-lg-4">
													<input type="text" value="<?php echo (isset($data) && !empty($data)) ? $data->seksi : ''; ?>" class="form-control" id="txt-CVD-MonitoringCovid-Tambah-Seksi" readonly placeholder="Seksi Pekerja">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Departemen</label>
												<div class="col-lg-4">
													<input type="text" value="<?php echo (isset($data) && !empty($data)) ? $data->dept : ''; ?>" class="form-control" id="txt-CVD-MonitoringCovid-Tambah-Departemen" readonly placeholder="Departemen Pekerja">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Kasus</label>
												<div class="col-lg-4">
													<input type="text" value="<?php echo (isset($data) && !empty($data)) ? $data->kasus : ''; ?>" class="form-control" id="txt-CVD-MonitoringCovid-Tambah-Kasus" placeholder="Kasus">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Tanggal Interaksi</label>
												<div class="col-lg-2">
													<input type="text" value="<?php echo (isset($data) && !empty($data)) ? $data->tgl_interaksi : ''; ?>" class="form-control" id="txt-CVD-MonitoringCovid-Tambah-TanggalInteraksi" placeholder="Tanggal Interaksi">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Periode Isolasi</label>
												<div class="col-lg-2">
													<input type="text" value="<?php echo (isset($data) && !empty($data)) ? $data->mulai_isolasi : ''; ?>" class="form-control" id="txt-CVD-MonitoringCovid-Tambah-PeriodeAwal" placeholder="Mulai Isolasi">
												</div>
												<div class="col-lg-2">
													<input type="text" value="<?php echo (isset($data) && !empty($data)) ? $data->selesai_isolasi : ''; ?>" class="form-control" id="txt-CVD-MonitoringCovid-Tambah-PeriodeAkhir" placeholder="Selesai Isolasi">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Keterangan</label>
												<div class="col-lg-4">
													<textarea class="form-control" id="txt-CVD-MonitoringCovid-Tambah-Keterangan" placeholder="Keterangan"><?php 
														echo (isset($data) && !empty($data)) ? $data->keterangan : ''; 
													?></textarea>
												</div>
											</div>
											<div class="form-group text-center">
												<button type="button" class="btn btn-primary" id="btn-CVD-MonitoringCovid-Tambah-Simpan"><span class="fa fa-save"></span> Simpan</button>
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
<div class="loading" id="ldg-CVD-MonitoringCovid-Tambah-Loading" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>