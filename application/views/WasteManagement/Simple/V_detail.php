<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h1><b><?=$Title ?></b></h1>
						</div>
						<div class="col-lg-1">
							<a href="<?php echo site_url('WasteManagement/Simple'); ?>" class="btn btn-default btn-lg text-right">
								<span class="fa fa-wrench fa-2x"></span>
							</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
							</div>
							<div class="box-body">
								<ul class="nav nav-pills nav-justified">
									<li class="active"><a data-toggle="pill" href="#awal">Belum Proses</a></li>
									<li><a data-toggle="pill" href="#akhir">Sudah Proses</a></li>
								</ul>

								<div class="tab-content">
									<div id="awal" class="tab-pane fade in active">
										<div class="row">
											<div class="col-lg-12">
												<form class="form-horizontal" id="ProsesSimpleExport" target="_blank" method="POST" action="<?php echo site_url('WasteManagement/Simple/Proses/'); ?>">
													<div class="form-group">
														<div class="col-lg-12">
															<div class="table-responsive">
																<table class="datatable table table-bordered table-striped table-hover text-left">
																	<thead class="bg-primary">
																		<tr>
																			<th>Action</th>
																			<th>Tanggal Kirim</th>
																			<th>Jenis Limbah</th>
																			<th>Seksi</th>
																			<th>Berat (Kg)</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php foreach ($DetailBelum as $key) { ?>
																			<tr>
																				<td class="text-center status-simple">
																					<input type="checkbox" class="simpleDetailCheck" name="txtInsert[]" value="<?php echo $key['id_kirim'] ?>">
																				</td>
																				<td><?php echo $key['tanggal'] ?></td>
																				<td><?php echo $key['jenis'] ?></td>
																				<td><?php echo $key['seksi'] ?></td>
																				<td><?php echo $key['berat'] ?></td>
																			</tr>
																		<?php } ?>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
													<div class="form-group">
														<div class="col-lg-2 text-right">
															<input type="checkbox" name="selectAll" id="simpleSelectAll" class="simpleSelectAll"> Select All
														</div>
														<div class="col-lg-9 text-right">
															<input class="btn btn-danger" type="submit" name="statusButton" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini ?')" value="Delete">
															<input class="btn btn-info" type="submit" name="statusButton" value="Proses">
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
									<div id="akhir" class="tab-pane fade ">
										<div class="row">
											<div class="col-lg-12">
												<br>
												<div class="table-responsive">
													<table class="datatable table table-bordered table-striped table-hover text-left simple-sudahproses-serverside">
														<thead class="bg-primary">
															<tr>
																<th style="width: 5%">No.</th>
																<th style="width: 20%">Tanggal Kirim</th>
																<th style="width: 20%">Jenis Limbah</th>
																<th style="width: 40%">Seksi</th>
																<th style="width: 10%">Berat (Kg)</th>
															</tr>
														</thead>
														<tbody>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var idJenisLimbahSimpleDetail = '<?php echo $idSimple; ?>';
	</script>
</section>