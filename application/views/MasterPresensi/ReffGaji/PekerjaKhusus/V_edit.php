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
										<?php if(isset($data) && !empty($data)){
											foreach ($data as $dt) {												
											
											?>
											<form class="form-horizontal" method="POST" action="<?php echo site_url('MasterPresensi/ReffGaji/PekerjaKhusus/update/'.$encrypted_string) ?>">
												<div class="row">
													<div class="col-lg-4" style="text-align: center">
														<label>Noind : <?php echo $dt['noind'] ?></label>
													</div>
													<div class="col-lg-4" style="text-align: center">
														<label>Noind Baru : <?php echo $dt['noind_baru'] ?></label>
													</div>
													<div class="col-lg-4" style="text-align: center">
														<label>Nama : <?php echo $dt['nama'] ?></label>
													</div>
												</div>
												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label col-xs-4">Khusus</label>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususKhusus" value="1" required <?php echo $dt['khusus'] == "1" ? "checked" : ""; ?>> Ya
															</div>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususKhusus" value="0" required <?php echo $dt['khusus'] !== "1" ? "checked" : ""; ?>> Tidak
															</div>												
														</div>
														<div class="form-group">
															<label class="control-label col-xs-4">GP</label>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususGP" value="1" required <?php echo $dt['xgp'] == "1" ? "checked" : ""; ?>> Ya
															</div>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususGP" value="0" required <?php echo $dt['xgp'] !== "1" ? "checked" : ""; ?>> Tidak
															</div>												
														</div>
														<div class="form-group">
															<label class="control-label col-xs-4">IP</label>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususIP" value="1" required <?php echo $dt['xip'] == "1" ? "checked" : ""; ?>> Ya
															</div>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususIP" value="0" required <?php echo $dt['xip'] !== "1" ? "checked" : ""; ?>> Tidak
															</div>												
														</div>
														<div class="form-group">
															<label class="control-label col-xs-4">IPT</label>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususIPT" value="1" required <?php echo $dt['ipt'] == "1" ? "checked" : ""; ?>> Ya
															</div>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususIPT" value="0" required <?php echo $dt['ipt'] !== "1" ? "checked" : ""; ?>> Tidak
															</div>												
														</div>
														<div class="form-group">
															<label class="control-label col-xs-4">IK</label>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususIK" value="1" required <?php echo $dt['xik'] == "1" ? "checked" : ""; ?>> Ya
															</div>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususIK" value="0" required <?php echo $dt['xik'] !== "1" ? "checked" : ""; ?>> Tidak
															</div>												
														</div>
														<div class="form-group">
															<label class="control-label col-xs-4">IF</label>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususIF" value="1" required <?php echo $dt['xif'] == "1" ? "checked" : ""; ?>> Ya
															</div>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususIF" value="0" required <?php echo $dt['xif'] !== "1" ? "checked" : ""; ?>> Tidak
															</div>
														</div>
													</div>
													<div class="col-md-4">													
														<div class="form-group">
															<label class="control-label col-xs-4">UBT</label>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususUBT" value="1" required <?php echo $dt['ubt'] == "1" ? "checked" : ""; ?>> Ya
															</div>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususUBT" value="0" required <?php echo $dt['ubt'] !== "1" ? "checked" : ""; ?>> Tidak
															</div>												
														</div>
														<div class="form-group">
															<label class="control-label col-xs-4">UPAMK</label>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususUPAMK" value="1" required <?php echo $dt['upamk'] == "1" ? "checked" : ""; ?>> Ya
															</div>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususUPAMK" value="0" required <?php echo $dt['upamk'] !== "1" ? "checked" : ""; ?>> Tidak
															</div>												
														</div>
														<div class="form-group">
															<label class="control-label col-xs-4">UM</label>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususUM" value="1" required <?php echo $dt['xum'] == "1" ? "checked" : ""; ?>> Ya
															</div>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususUM" value="0" required <?php echo $dt['xum'] !== "1" ? "checked" : ""; ?>> Tidak
															</div>												
														</div>
														<div class="form-group">
															<label class="control-label col-xs-4">UMC</label>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususUMC" value="1" required <?php echo $dt['umc'] == "1" ? "checked" : ""; ?>> Ya
															</div>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususUMC" value="0" required <?php echo $dt['umc'] !== "1" ? "checked" : ""; ?>> Tidak
															</div>
														</div>
														<div class="form-group">
															<label class="control-label col-xs-4">Lembur</label>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususLembur" value="1" required <?php echo $dt['lembur'] == "1" ? "checked" : ""; ?>> Ya
															</div>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususLembur" value="0" required <?php echo $dt['lembur'] !== "1" ? "checked" : ""; ?>> Tidak
															</div>												
														</div>
														<div class="form-group">
															<label class="control-label col-xs-4">CUTI</label>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususCUTI" value="1" required <?php echo $dt['cuti'] == "1" ? "checked" : ""; ?>> Ya
															</div>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususCUTI" value="0" required <?php echo $dt['cuti'] !== "1" ? "checked" : ""; ?>> Tidak
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label col-xs-4">IMM</label>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususIMM" value="1" required <?php echo $dt['imm'] == "1" ? "checked" : ""; ?>> Ya
															</div>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususIMM" value="0" required <?php echo $dt['imm'] !== "1" ? "checked" : ""; ?>> Tidak
															</div>												
														</div>
														<div class="form-group">
															<label class="control-label col-xs-4">IMS</label>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususIMS" value="1" required <?php echo $dt['ims'] == "1" ? "checked" : ""; ?>> Ya
															</div>
															<div class="col-xs-4">
																<input type="radio" name="txtKhususIMS" value="0" required <?php echo $dt['ims'] !== "1" ? "checked" : ""; ?>> Tidak
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
																					<option value="<?php echo $fml['formula_id'] ?>" <?php echo $fml['formula_id'] == $dt['formula_id'] ? "selected" : ""; ?>><?php echo $fml['ketentuan'].' - '.$fml['satuan_akhir'] ?></option>
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
																<textarea class="form-control" name="txtKhususInfo" required><?php echo $dt['info'] ?></textarea>
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
											<?php
											}
										} ?>
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