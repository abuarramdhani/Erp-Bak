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
										<?php 
										if (isset($data) && !empty($data)) {
											foreach ($data as $dt) {
												?>
										<form method="POST" class="form-horizontal" action="<?php echo base_url('HitungHlcm/THR/MonitoringPengembalian/simpan') ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">IDUL FITRI</label>
												<div class="col-lg-4">
													<input type="text" value="<?php echo date('d M Y',strtotime($dt['tgl_idul_fitri'])) ?>" class="form-control" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">NO. INDUK</label>
												<div class="col-lg-4">
													<input type="text" value="<?php echo $dt['noind'] ?>" class="form-control" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">NAMA</label>
												<div class="col-lg-4">
													<input type="text" value="<?php echo $dt['employee_name'] ?>" class="form-control" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">MASA KERJA</label>
												<div class="col-lg-4">
													<input type="text" value="<?php echo $dt['masa_kerja'] ?>" class="form-control" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">TANGGAL KELUAR</label>
												<div class="col-lg-4">
													<input type="text" value="<?php echo date('d M Y',strtotime($dt['resign_date'])) ?>" class="form-control" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">NOMINAL THR</label>
												<div class="col-lg-4">
													<input type="text" value="<?php echo number_format($dt['nominal_thr'],2,',','.') ?>" class="form-control" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">CATATAN</label>
												<div class="col-lg-4">
													<textarea name="txtHLCMPengembalianTHRCatatan" class="form-control" required></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">TANGGAL KEMBALI</label>
												<div class="col-lg-4">
													<input type="text" name="txtHLCMPengembalianTHRTanggal" id="txtHLCMPengembalianTHRTanggal" value="<?php echo date('Y-m-d') ?>" class="form-control" required>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-6 text-right">
													<button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Simpan</button>
													<input type="hidden" name="txtHLCMPengembalianTHRIDTHR" value="<?php echo $dt['id_thr'] ?>">
												</div>
											</div>
										</form>
										<?php 
											}
										}
										?>
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