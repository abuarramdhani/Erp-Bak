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
						<div class="box box-primary box-solid">
							<div class="box-header with-border text-right">
							</div>
							<div class="box-body">
								<form method="POST" action="<?php echo site_url('PNBP/SetupQuestioner/Save/'.$encrypt_link) ?>">
									<div class="row">
										<div class="col-lg-12">
											<div class="table-responsive">
												<table class="table table-bordered">
													<thead class="bg-primary">
														<tr>
															<th class="text-center" style="width: 5%">No</th>
															<th class="text-center" style="width: 40%">Kelompok</th>
															<th class="text-center" style="width: 5%">No</th>
															<th class="text-center" style="width: 40%">Pernyataan</th>
															<th class="text-center" style="width: 10%">Urutan</th>
														</tr>
													</thead>
													<tbody>
														<?php 
															if (isset($urutan) and !empty($urutan)) {
																$angka = 1;
																$nomor = 1;
																$nomor2 = 1;
																$simpan = "";
																foreach ($urutan as $key) { 
																	?>
																	<tr>
																		<?php if ($simpan !== $key['kelompok']){ ?>
																			<td rowspan="<?php echo $key['jumlah'] ?>" class="text-center"><?php echo $nomor; ?></td>
																			<td rowspan="<?php echo $key['jumlah'] ?>" class="text-center"><?php echo $key['kelompok'] ?></td>
																		<?php 
																			$nomor++;
																			$nomor2 = 1;
																		} ?>
																			
																		<td class="text-center"><?php echo $nomor2 ?></td>
																		<td class="text-center"><?php echo $key['pernyataan'] ?></td>
																		<td class="text-center">
																			<input type="number" style="width: 80px" name="txtInput[<?php echo $angka ?>][urutan]" class="form-control" value="<?php echo $key['no_urut'] ?>">
																			<input type="hidden" name="txtInput[<?php echo $angka ?>][id_pernyataan]" value="<?php echo $key['id_pernyataan'] ?>">
																			<input type="hidden" name="txtInput[<?php echo $angka ?>][id_periode]" value="<?php echo $key['id_periode'] ?>">
																		</td>
																	</tr>
																<?php 
																	$angka++;
																	$nomor2++;
																	$simpan = $key['kelompok'];
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
											<button style="submit" class="btn btn-primary">Save</button>
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
</section>