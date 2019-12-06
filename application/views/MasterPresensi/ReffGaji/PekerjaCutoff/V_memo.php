<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h3><?=$Title ?></h3>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<h2 style="text-align: center">Pekerja Cutoff bulan <?php echo date('F Y',strtotime($periode)) ?></h2>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 ">
										<form class="form-horizontal" method="POST" action="<?php echo base_url("MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/hitung/".$periode) ?>">
											<div class="form-group">
												<label class="col-lg-4 control-label">No. Surat</label>
												<div class="col-lg-4">
													<input type="text" placeholder="Nomor Surat" class="form-control" name="cutoff_nomor_surat">
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-4 control-label">Mengetahui</label>
												<div class="col-lg-4">
													<select class="slc-pekerjaCutoff" style="width: 100%" name="cutoff_mengetahui"></select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-4 control-label">Kepada : </label>
											</div>
											<div class="form-group">
												<label class="col-lg-4 control-label">Staff </label>
												<div class="col-lg-4">
													<input type="text" placeholder="kepada" class="form-control" name="cutoff_kepada_staff">
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-4 control-label">Non-Staff </label>
												<div class="col-lg-4">
													<input type="text" placeholder="kepada" class="form-control" name="cutoff_kepada_nonstaff">
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-right">
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