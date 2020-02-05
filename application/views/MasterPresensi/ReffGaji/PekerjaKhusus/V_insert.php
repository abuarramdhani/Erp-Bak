<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						<h1><?=$Title ?></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="box box-solid box-primary">
							<div class="box-header with-border">
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-md-12">
										<form class="form-horizontal" method="POST" action="<?php echo site_url('MasterPresensi/ReffGaji/PekerjaKhusus/save') ?>">
											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<label class="control-label col-md-4">Noind</label>
														<div class="col-md-8">
															<select name="slcKhususNoind" class="slcKhususNoind" style="width: 100%" data-placeholder="No. Induk Pekerja" required></select>
														</div>												
													</div>
													<div class="form-group">
														<label class="control-label col-xs-4">Khusus</label>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususKhusus" value="1" required> Ya
														</div>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususKhusus" value="0" required> Tidak
														</div>												
													</div>
													<div class="form-group">
														<label class="control-label col-xs-4">GP</label>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususGP" value="1" required> Ya
														</div>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususGP" value="0" required> Tidak
														</div>												
													</div>
													<div class="form-group">
														<label class="control-label col-xs-4">IP</label>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususIP" value="1" required> Ya
														</div>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususIP" value="0" required> Tidak
														</div>												
													</div>
													<div class="form-group">
														<label class="control-label col-xs-4">IPT</label>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususIPT" value="1" required> Ya
														</div>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususIPT" value="0" required> Tidak
														</div>												
													</div>
													<div class="form-group">
														<label class="control-label col-xs-4">IK</label>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususIK" value="1" required> Ya
														</div>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususIK" value="0" required> Tidak
														</div>												
													</div>
												</div>
												<div class="col-md-4">													
													<div class="form-group">
														<label class="control-label col-xs-4">IF</label>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususIF" value="1" required> Ya
														</div>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususIF" value="0" required> Tidak
														</div>
													</div>
													<div class="form-group">
														<label class="control-label col-xs-4">UBT</label>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususUBT" value="1" required> Ya
														</div>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususUBT" value="0" required> Tidak
														</div>												
													</div>
													<div class="form-group">
														<label class="control-label col-xs-4">UPAMK</label>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususUPAMK" value="1" required> Ya
														</div>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususUPAMK" value="0" required> Tidak
														</div>												
													</div>
													<div class="form-group">
														<label class="control-label col-xs-4">UM</label>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususUM" value="1" required> Ya
														</div>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususUM" value="0" required> Tidak
														</div>												
													</div>
													<div class="form-group">
														<label class="control-label col-xs-4">UMC</label>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususUMC" value="1" required> Ya
														</div>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususUMC" value="0" required> Tidak
														</div>
													</div>
													<div class="form-group">
														<label class="control-label col-xs-4">Lembur</label>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususLembur" value="1" required> Ya
														</div>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususLembur" value="0" required> Tidak
														</div>												
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label class="control-label col-xs-4">IMM</label>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususIMM" value="1" required> Ya
														</div>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususIMM" value="0" required> Tidak
														</div>												
													</div>
													<div class="form-group">
														<label class="control-label col-xs-4">IMS</label>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususIMS" value="1" required> Ya
														</div>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususIMS" value="0" required> Tidak
														</div>												
													</div>
													<div class="form-group">
														<label class="control-label col-xs-4">CUTI</label>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususCUTI" value="1" required> Ya
														</div>
														<div class="col-xs-4">
															<input type="radio" name="txtKhususCUTI" value="0" required> Tidak
														</div>
													</div>
													<div class="form-group">
														<label class="control-label col-md-4">Formula</label>
														<div class="col-md-8">
															<select class="select2" name="slckhususFormula" data-placeholder="Formula" style="width: 100%" required>
																<option></option>
																<?php 
																	if (isset($formula) && !empty($formula)) {
																		foreach ($formula as $fml) {
																			?>
																				<option value="<?php echo $fml['formula_id'] ?>"><?php echo $fml['ketentuan'].' - '.$fml['satuan_akhir'] ?></option>
																			<?php
																		}
																	}
																 ?>
															</select>
														</div>
													</div>
													<div class="form-group">
														<label class="control-label col-md-4">Info</label>
														<div class="col-md-8">
															<textarea class="form-control" name="txtKhususInfo" required></textarea>
														</div>
													</div>
													<div class="form-group">
														<div class="col-md-6 text-right">
															<button type="submit" class="btn btn-primary">Submit</button>
														</div>
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