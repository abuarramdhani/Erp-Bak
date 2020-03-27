<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h3><b><?php echo $Title; ?></b></h3>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-sm hidden-xs hidden-md">
								<a href="" class="btn btn-default btn-lg">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								Setup Nominal yang Digunakan Sebagai Penyesuaian GP untuk Lokasi Kerja Mlati Dan Tuksono
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="POST" action="<?php echo base_url('PenilaianKinerja/Penyesuaian/Save') ?>">
											<div class="table-responsive">
												<table class="table table-bordered table-striped table-hover text-center">
													<thead class="bg-primary">
														<tr>
															<th>Lokasi Kerja</th>
															<th>Nominal Pengurangan</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
													<?php if (isset($table) and !empty($table)) {
														foreach ($table as $key) { ?>
															<tr>
																<td>Tuksono</td>
																<td>
																	<input type="text" name="txtNominalTuksono" value="<?php echo $key['tuksono'] ?>" class="form-control">
																</td>
																<td>
																	<input type="submit" name="txtSubmit" value="Save Tuksono" class="btn btn-primary" onclick="return confirm('Apakah Anda Yakin Ingin Menyimpan Data Tuksono ?')">
																</td>
															</tr>
															<tr>
																<td>Mlati</td>
																<td>
																	<input type="text" name="txtNominalMlati" value="<?php echo $key['mlati'] ?>" class="form-control">
																</td>
																<td>
																	<input type="submit" name="txtSubmit" value="Save Mlati" class="btn btn-primary" onclick="return confirm('Apakah Anda Yakin Ingin Menyimpan Data Mlati ?')">
																</td>
															</tr>
													<?php	}
													} ?>
													</tbody>
												</table>
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