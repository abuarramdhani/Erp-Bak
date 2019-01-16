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
								<a href="" class="btn btn-default btn-lg"><i class="icon-wrench icon-2x"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header text-right">
								<a href="<?php echo site_url('SiteManagement/TransferAsset/InputNew') ?>" class="btn btn-info icon-plus"></a>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="table-responsive">
											<table class="datatable table table-bordered table-striped table-hover text-left table-asset">
												<thead class="bg-primary">
													<th>No</th>
													<th>No Blanko Assignment</th>
													<th>Tag Number</th>
													<th>Nama Barang</th>
													<th>Seksi Lama</th>
													<th>Seksi Baru</th>
												</thead>
												<tbody>
													<?php $angka = 1;
													if(isset($tabel)){ foreach($tabel as $key) { ?>
													 	<tr>
													 		<td><?php echo $angka ?></td>
													 		<td><?php echo $key['no_blanko'] ?></td>
													 		<td><?php echo $key['tag_number'] ?></td>
													 		<td><?php echo $key['nama_barang'] ?></td>
													 		<td><?php echo $key['seksi_awal'] ?></td>
													 		<td><?php echo $key['seksi_baru'] ?></td>
													 	</tr>
													<?php $angka++; }} ?>
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