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
										<h2 style="text-align: center">Memo Pekerja Cutoff</h2>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 ">
										<form class="form-horizontal" method="POST" action="<?php echo base_url("MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/hitung") ?>">
											<div class="form-group">
												<label class="col-lg-1 control-label">No. Surat</label>
												<div class="col-lg-4">
													<input type="text" placeholder="Nomor Surat" class="form-control" name="cutoff_nomor_surat" autocomplete="off">
												</div>
												<label class="col-lg-2 control-label">Non-Staff </label>
												<div class="col-lg-4">
													<input type="text" placeholder="kepada" class="form-control" name="cutoff_kepada_nonstaff">
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-1 control-label">Mengetahui</label>
												<div class="col-lg-4">
													<select class="slc-pekerjaCutoff-aktif" style="width: 100%" name="cutoff_mengetahui"></select>
												</div>
												<label class="col-lg-2 control-label">Staff </label>
												<div class="col-lg-4">
													<input type="text" placeholder="kepada" class="form-control" name="cutoff_kepada_staff">
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-1 control-label">Periode</label>
												<div class="col-lg-4">
													<input type="text" name="cutoff_periode_susulan" class="form-control" id="txtPeriodeCutoff" placeholder="periode Pekerja Cutoff" autocomplete="off">
												</div>
												<label class="col-lg-2 control-label">Pilih Pekerja</label>
												<div class="col-lg-2">
													<input type="radio" name="txtPilihPekerjaCutoff" id="txtPilihPekerjaCutoffManual" value="Manual">&nbsp;&nbsp;Pilih Manual
												</div>
												<div class="col-lg-2">
													<input type="radio" name="txtPilihPekerjaCutoff" id="txtPilihPekerjaCutoffSemua" value="Semua">&nbsp;&nbsp;Pilih Semua													
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-12" id="boxCutoff">
													
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-right">
													<button type="submit" class="btn btn-primary" id="btnPekerjaCutoffMemoSubmit">Proses</button>
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