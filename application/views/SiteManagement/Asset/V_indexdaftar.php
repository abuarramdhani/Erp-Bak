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
														<th class="text-center">Tag Number</th>
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
																	<td>
																		<a href="#" id="modalbtnAssetTagNumber"><?php echo $key['tag_number'] ?></a>
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
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Modal start -->
<div class="modal" tabindex="-1" role="dialog" aria-hidden="true" id="modalAssetTagNumber">
	<div role="document" class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary text-center">
				<label class="modal-title">Informasi Asset</label>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table">
						<tr>
							<td class="text-right" style="width: 40%">Tag Number</td>
							<td style="width: 60%"><b id="modaltdAsset1"></b></td>
						</tr>
						<tr>
							<td class="text-right">No PP</td>
							<td><b id="modaltdAsset2"></b></td>
						</tr>
						<tr>
							<td class="text-right">Seksi PP</td>
							<td><b id="modaltdAsset3"></b></td>
						</tr>
						<tr>
							<td class="text-right">Tanggal PP</td>
							<td><b id="modaltdAsset4"></b></td>
						</tr>
						<tr>
							<td class="text-right">Tanggal Pembelian</td>
							<td><b id="modaltdAsset5"></b></td>
						</tr>
						<tr>
							<td class="text-right">Status Retirement</td>
							<td><b id="modaltdAsset6"></b></td>
						</tr>
						<tr>
							<td class="text-right">Tanggal Retirement</td>
							<td><b id="modaltdAsset7"></b></td>
						</tr>
					</table>
				</div>
				<div class="table-responsive">
					<table  class="table table-striped table-bordered table-hover table-sm">
						<thead class="bg-primary">
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">Dari Seksi</th>
								<th class="text-center">Ke Seksi</th>
								<th class="text-center">Tanggal Transfer</th>
							</tr>
						</thead>
						<tbody id="modalTableBodyAsset">
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal End -->