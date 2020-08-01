<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<b><h1><?=$Title ?></h1></b>
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
												<label class="control-label col-lg-4">Seksi</label>
												<div class="col-lg-4">
													<select class="select2" id="txt-SI-SubmitIde-Seksi" style="width: 100%" data-placeholder="Pilih Seksi...">
														<option></option>
														<option>Keuangan</option>
														<option>AP</option>
														<option>AR Pusat dan Cabang</option>
														<option>Pajak dan Asset</option>
														<option>Costing</option>
														<option>GL dan Sistem</option>
														<option>Penggajian</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">judul</label>
												<div class="col-lg-4">
													<input type="text" id="txt-SI-SubmitIde-Judul" class="form-control" placeholder="Tuliskan Judul...">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Due Date F4</label>
												<div class="col-lg-4">
													<input type="text" id="txt-SI-SubmitIde-DueDate" class="form-control" placeholder="Pilih Tanggal Due Date...">
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-12 text-center">
													<button type="button" class="btn btn-primary"  id="btn-SI-SubmitIde-Submit">Submit</button>
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
<div class="loading" id="ldg-SI-SubmitIde" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>