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
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="POST" action="<?php echo base_url('MasterPresensi/ReffGaji/THR/simpan') ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">Idul Fitri</label>
												<div class="col-lg-4">
													<input type="text" name="txtTHRTanggalIdulFitri" id="txtTHRTanggalIdulFitri" class="form-control" placeholder="Tanggal Idul Fitri" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Mengetahui</label>
												<div class="col-lg-4">
													<select style="width: 100%" name="slcTHRMengetahui" id="slcTHRMengetahui" required></select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Tanggal Dibuat</label>
												<div class="col-lg-4">
													<input type="text" name="txtTHRTanggalDibuat" id="txtTHRTanggalDibuat" class="form-control" placeholder="Tanggal Dibuat" required value="<?php echo date('Y-m-d') ?>">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Jenis</label>
												<div class="col-lg-2">
													<input type="radio" name="rdbJenis" value="1"> Reguler
												</div>
												<div class="col-lg-2">
													<input type="radio" name="rdbJenis" value="2"> SP 3
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-6 text-right">
													<button type="submit" class="btn btn-primary">Proses</button>
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