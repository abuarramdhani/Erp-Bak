<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h1><b><?php echo $Title; ?></b></h1>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-xs hidden-sm hidden-md">
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
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form enctype="multipart/form-data" class="form-horizontal" method="POST" action="<?php echo site_url('PenilaianKinerja/ImportData/GetData') ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">GP Tahun</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" name="txtTahunGP" maxlength="4" required placeholder="Contoh : <?php echo Date('Y'); ?>">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">File</label>
												<div class="col-lg-4">
													<input type="file" class="form-control" name="txtFileGP" required placeholder="File Upload">
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
								<div class="row">
									<div class="col-lg-12">
										<?php if (isset($table) and !empty($table)) { ?>
											<div class="table-responsive">
												<table class="table table-striped table-bordered table-hover">
													<thead class="bg-primary">
														<tr>
															<td class="text-center">No</td>
															<td class="text-center">Noind</td>
															<td class="text-center">Nama</td>
															<td class="text-center">Tahun</td>
															<td class="text-center">GP</td>
														</tr>
													</thead>
													<tbody>
														<?php $angka = 1;
															foreach ($table as $key) { ?>
																<tr>
																	<td class="text-center"><?php echo $angka ?></td>
																	<td class="text-center"><?php echo $key['noind'] ?></td>
																	<td><?php echo $key['nama'] ?></td>
																	<td class="text-center"><?php echo $key['tahun'] ?></td>
																	<td class="text-center"><?php echo number_format($key['gp'],'0',',','.') ?></td>
																</tr>
														<?php $angka++;	}
														?>
													</tbody>
												</table>
											</div>
										<?php } ?>
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