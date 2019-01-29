<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<h3><b><?=$Title ?></b></h3>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-xs hidden-sm hidden-md">
								<a href="" class="btn btn-default btn-lg"><i class="icon-wrench iocn-2x"></i></a>
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
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-hover datatable-ma">
												<thead class="bg-primary">
													<tr>
														<th class="text-center">No</th>
														<th class="text-center">No PP</th>
														<th class="text-center">Seksi Pemakai</th>
														<th class="text-center">Requester</th>
														<th class="text-center">barang</th>
														<th class="text-center">Status Retirement</th>
														<th class="text-center">Transfer</th>
													</tr>
												</thead>
												<tbody>
													<?php 
														if (isset($tabel) and !empty($tabel)) {
															$angka = 1;
															foreach ($tabel as $key) { ?>
																<tr>
																	<td><?php echo $angka ?></td>
																	<td><?php echo $key['no_pp'] ?></td>
																	<td><?php echo $key['seksi_pemakai'] ?></td>
																	<td><?php echo $key['requester'] ?></td>
																	<td><?php echo $key['nama_item'] ?></td>
																	<td><?php echo $key['status_aktif'] ?></td>
																	<td><?php echo $key['transfer'] ?></td>
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
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>