<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h1><b><?=$Title ?></b></h1>
						</div>
						<div class="col-lg-1 text-right">
							<a href="<?php echo site_url('WasteManagement/Simple/Read/'.$SimpleId) ?>" class="btn btn-default btn-lg">
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
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="POST" action="<?php echo site_url('WasteManagement/Simple/Add_Detail/'.$SimpleId); ?>">
											<div class="form-group">
												<div class="col-lg-12">
													<div class="table-responsive">
														<table class="datatable table table-bordered table-striped table-hover text-left">
															<thead class="bg-primary">
																<tr>
																	<th>Tanggal Kirim</th>
																	<th>Jenis Limbah</th>
																	<th>Seksi</th>
																	<th>Berat (Kg)</th>
																	<th>Action</th>
																</tr>
															</thead>
															<tbody>
																<?php foreach ($limbahMasuk as $key) { ?>
																	<tr>
																		<td><?php echo $key['tanggal'] ?></td>
																		<td><?php echo $key['jenis'] ?></td>
																		<td><?php echo $key['seksi'] ?></td>
																		<td><?php echo $key['berat'] ?></td>
																		<td class="text-center status-simple">
																			<input type="checkbox" name="txtInsert[]" value="<?php echo $key['id_kirim'] ?>">
																		</td>
																	</tr>
																<?php } ?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-11 text-right">
													<a href="javascript:history.back(1);" class="btn btn-warning">Cancel</a>
													<button type="submit" class="btn btn-info">Insert</button>
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