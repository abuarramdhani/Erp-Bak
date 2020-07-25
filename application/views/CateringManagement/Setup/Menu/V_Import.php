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
					<div class="col-md-6">
						<div class="box box-solid">
							<div class="box-header with-border text-right" style="padding-top: 0px;padding-bottom: 0px;background-color: #55efc4;color: #00b894">
								<label style="font-size: 30pt;margin: 0;">IMPORT</label>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" action="<?php echo base_url('CateringManagement/Setup/Menu/ImportData') ?>" method="POST" enctype="multipart/form-data">
											<div class="form-group">
												<label class="control-label col-lg-4">File Upload</label>
												<div class="col-lg-6">
													<input type="file" class="form-control" name="file">
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-12 text-center">
													<button type="submit" class="btn btn-primary">Upload</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="box box-solid">
							<div class="box-header with-border text-left" style="padding-top: 0px;padding-bottom: 0px;background-color: #00b894;color: #55efc4">
								<label style="font-size: 30pt;margin: 0;">EXPORT</label>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" action="<?php echo base_url('CateringManagement/Setup/Menu/ExportData') ?>" method="POST">
											<div class="form-group">
												<label class="control-label col-lg-4">Isi File</label>
												<div class="col-lg-3">
													<input type="radio" class="form-control" value="Kosong" name="txt-CM-Menu-Export-Isi" checked>&nbsp;File Kosong
												</div>
												<div class="col-lg-3">
													<input type="radio" class="form-control" value="Isi" name="txt-CM-Menu-Export-Isi">&nbsp;File Isi
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Periode</label>
												<div class="col-lg-6">
													<input type="text" name="txt-CM-Menu-Export-Tanggal" class="form-control" id="txt-CM-Menu-Export-BulanTahun" value="<?php echo date('F Y') ?>">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Shift</label>
												<div class="col-lg-6">
													<select class="select2" style="width: 100%"  name="slc-CM-Menu-Export-Shift">
														<option>Shift 1 & Umum</option>
														<option>Shift 2</option>
														<option>Shift 3</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Lokasi Kerja</label>
												<div class="col-lg-6">
													<select class="select2" style="width: 100%"  name="slc-CM-Menu-Export-Lokasi">
														<option>Yogyakarta & Mlati</option>
														<option>Tuksono</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-12 text-center">
													<button type="submit" class="btn btn-primary">Download</button>
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