<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b><?=$Title ?></b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a href="<?php echo site_url('SiteManagement') ?>" class="btn btn-default btn-lg">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border text-right">
								<a href="<?php echo site_url('SiteManagement/PembelianAsset/InputNew') ?>"  class="btn btn-info icon-plus"></a>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="table-responsive">
											<table class="datatable table table-striped table-bordered table-hover text-left table-asset">
												<thead class="bg-primary">
													<tr>
														<th>No</th>
														<th>No PP</th>
														<th>No BPPBA</th>
														<th>Tanggal Pembelian</th>
														<th>Seksi Pemakai</th>
														<th>Barang</th>
														<th>Cost Center</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php 
														if (isset($tabel)) {
															 $angka = 1; 
															 foreach ($tabel as $key) { ?>
																<tr>
																	<td><?php echo $angka ?></td>
																	<td><?php echo $key['no_pp'] ?></td>
																	<td><?php echo $key['no_bppba'] ?></td>
																	<td><?php echo $key['tgl_beli'] ?></td>
																	<td><?php echo $key['seksi_pemakai'] ?></td>
																	<td><?php echo $key['item'] ?></td>
																	<td><?php echo $key['cost_center'] ?></td>
																	<td></td>
																</tr>
													<?php 	$angka++;} 
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