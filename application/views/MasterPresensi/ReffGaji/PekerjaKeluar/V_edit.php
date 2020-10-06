<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><?php echo $Title ?></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="POST" action="<?php echo base_url('MasterPresensi/ReffGaji/PekerjaKeluar/updateGaji/'.$noind_encrypted) ?>">
											<div class="col-lg-12">
												<div class="form-group">
													<label class="control-label col-lg-1">Noind :</label>
													<div class="col-lg-4">
														<input type="text" class="form-control" value="<?php echo $data->noind ?>" disabled>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-1">Nama :</label>
													<div class="col-lg-4">
														<input type="text" class="form-control" value="<?php echo $data->nama ?>" disabled>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label col-sm-4">I. PRES.</label>
													<div class="col-sm-8">
														<input type="text" class="form-control" name="txtKomIP" placeholder="....." value="<?php echo $data->ipe ?>" required>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4">I. PRES. TKS.</label>
													<div class="col-sm-8">
														<input type="text" class="form-control" name="txtKomIPT" placeholder="....." value="<?php echo $data->ipet ?>" required>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4">I. KOND.</label>
													<div class="col-sm-8">
														<input type="text" class="form-control" name="txtKomIK" placeholder="....." value="<?php echo $data->ika ?>" required>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4">I. FUNG.</label>
													<div class="col-sm-8">
														<input type="text" class="form-control" name="txtKomIF" placeholder="....." value="<?php echo $data->ief ?>" required>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4">UBT</label>
													<div class="col-sm-8">
														<input type="text" class="form-control" name="txtKomUBT" placeholder="....." value="<?php echo $data->ubt ?>" required>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4">UPAMK</label>
													<div class="col-sm-8">
														<input type="text" class="form-control" name="txtKomUPAMK" placeholder="....." value="<?php echo $data->upamk ?>" required>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4">JAM LEMBUR</label>
													<div class="col-sm-8">
														<input type="text" class="form-control" name="txtKomLEMBUR" placeholder="....." value="<?php echo $data->jam_lembur ?>" required>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label col-sm-4">IMS</label>
													<div class="col-sm-8">
														<input type="text" class="form-control" name="txtKomIMS" placeholder="....." value="<?php echo $data->ims ?>" required>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4">IMM</label>
													<div class="col-sm-8">
														<input type="text" class="form-control" name="txtKomIMM" placeholder="....." value="<?php echo $data->imm ?>" required>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4">U. M. PUASA</label>
													<div class="col-sm-8">
														<input type="text" class="form-control" name="txtKomUMP" placeholder="....." value="<?php echo $data->um_puasa ?>" required>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4">U. M. CABANG</label>
													<div class="col-sm-8">
														<input type="text" class="form-control" name="txtKomUMC" placeholder="....." value="<?php echo $data->um_cabang ?>" required>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4">CUTI</label>
													<div class="col-sm-8">
														<input type="text" class="form-control" name="txtKomCT" placeholder="....." value="<?php echo $data->ct ?>" required>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4">HTM</label>
													<div class="col-sm-8">
														<input type="text" class="form-control" name="txtKomHTM" placeholder="....." value="<?php echo $data->htm ?>" required>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4">IJIN</label>
													<div class="col-sm-8">
														<input type="text" class="form-control" name="txtKomIJIN" placeholder="....." value="<?php echo $data->ijin ?>" required>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label col-sm-4">TAMBAHAN</label>
													<div class="col-sm-8">
														<input type="text" class="form-control" name="txtKomTAMB" placeholder="....." value="<?php echo $data->tambahan_str ?>">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4">UANG DL</label>
													<div class="col-sm-8">
														<input type="text" class="form-control" name="txtKomDL" placeholder="....." value="<?php echo $data->dldobat ?>">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4">POTONGAN</label>
													<div class="col-sm-8">
														<input type="text" class="form-control" name="txtKomPOT" placeholder="....." value="<?php echo $data->potongan_str ?>">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4">DUKA</label>
													<div class="col-sm-8">
														<input type="text" class="form-control" name="txtKomDUKA" placeholder="....." value="<?php echo $data->pduka ?>">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4">UTANG KOP.</label>
													<div class="col-sm-8">
														<input type="text" class="form-control" name="txtKomKOP" placeholder="....." value="<?php echo $data->putang ?>">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4">POT. LAIN</label>
													<div class="col-sm-8">
														<input type="text" class="form-control" name="txtKomPLAIN" placeholder="....." value="<?php echo $data->plain ?>">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4">KETERANGAN</label>
													<div class="col-sm-8">
														<input type="text" class="form-control" name="txtKomKET" placeholder="....." value="<?php echo $data->ket ?>">
													</div>
												</div>
											</div>
											<div class="col-lg-12">
												<div class="form-group">
													<div class="col-lg-12 text-center">
														<a href="javascript:history.back()" class="btn btn-warning"><span class="fa fa-arrow-left"></span> Kembali</a>
														<button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Simpan</button>
													</div>
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