<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h3><b><?=$Title ?></b></h3>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-xs hidden-sm hidden-md">
								<a href="<?php echo base_url('PNBP') ?>" class="btn btn-default btn-lg"><i class="icon-wrench icon-2x"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<?php if (isset($question) and !empty($question)) { ?>
							<div class="box box-primary box-solid">
								<div class="box-header with-border">
									<h3><?=$kelompok; ?></h3>
								</div>
								<div class="box-body">
									<?php 	
										$encrypted_string = $this->encrypt->encode($id_kelompok);
	            						$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string); 
	            					?>
									<form method="POST" action="<?php echo site_url('PNBP/Questioner/Quest/'.$encrypted_string) ?>">
										<div class="row">
											<div class="col-lg-12">
												<div class="table-responsive">
													<table class="table table-striped table-bordered table-hover">
														<thead class="bg-primary">
															<tr>
																<th class="text-center">No</th>
																<th class="text-center">Pernyataan</th>
																<th class="text-center">STS</th>
																<th class="text-center">TS</th>
																<th class="text-center">S</th>
																<th class="text-center">SS</th>
															</tr>
														</thead>
														<tbody>
															<?php 
																if (isset($question) and !empty($question)) {
																	$angka = 1;
																	foreach ($question as $key) {
																		?>
																		<tr>
																			<td class="text-center"><?php echo $angka; ?></td>
																			<td class="text-center">
																				<?php echo $key['pernyataan'] ?>
																				<input type="hidden" value="<?php echo $key['id_pernyataan'] ?>" name="question[<?php echo $angka; ?>][id_pernyataan]">
																				<input type="hidden" value="<?php echo $key['id_periode'] ?>" name="question[<?php echo $angka; ?>][id_periode]">
																			</td>
																			<td class="text-center">
																				<input type="radio" value="<?php echo "1"." - ".$key['nilai_pil1'] ?>" name="question[<?php echo $angka; ?>][pilihan]" required>
																			</td>
																			<td class="text-center">
																				<input type="radio" value="<?php echo "2"." - ".$key['nilai_pil2'] ?>" name="question[<?php echo $angka; ?>][pilihan]" required>
																			</td>
																			<td class="text-center">
																				<input type="radio" value="<?php echo "3"." - ".$key['nilai_pil3'] ?>" name="question[<?php echo $angka; ?>][pilihan]" required>
																			</td>
																			<td class="text-center">
																				<input type="radio" value="<?php echo "4"." - ".$key['nilai_pil4'] ?>" name="question[<?php echo $angka; ?>][pilihan]" required>
																			</td>
																		</tr>
																	<?php $angka++;
																	}
																}
															?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-10 text-right">
												<button type="submit" class="btn btn-success">Lanjut</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						<?php 	}else{ 
								if (isset($selesai) and $selesai == "selesai") {	?>
									<div class="box box-solid box-primary">
										<div class="box-header with-border"></div>
										<div class="box-body">
											<div class="row">
												<div class="col-lg-12">
													<form method="POST" action="<?php echo site_url('PNBP/Questioner/Save') ?>">
														<div class="form-group text-center">
															<p>
																Anda Yakin ingin menyimpan jawaban questioner ?
															</p>
														</div>
														<div class="form-group text-center">
															<button type="submit" class="btn btn-success">Ya</button>
															<a href="<?php echo site_url('PNBP/Questioner') ?>" class="btn btn-danger">Tidak</a>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
						<?php 		}else{ ?>
										<div class="box box-solid box-primary">
											<div class="box-header with-border"></div>
											<div class="box-body">
												<div class="row">
													<div class="col-lg-12 text-center">
														<p>Jawaban Questioner Sudah Di Simpan.</p>
													</div>
												</div>
											</div>
										</div>
						<?php		}
								} ?>
							
					</div>
				</div>
			</div>
		</div>
	</div>
</section>