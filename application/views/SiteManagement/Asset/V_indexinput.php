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
								<a href="<?php echo site_url('SiteManagement/InputAsset/InputNew') ?>"  class="btn btn-info icon-plus"></a>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="table-responsive">
											<table class="datatable table table-striped table-bordered table-hover text-left table-asset">
												<thead class="bg-primary">
													<tr>
														<th>No</th>
														<th>No PPA</th>
														<th>No PP</th>
														<th>Tanggal PP</th>
														<th>Kategori</th>
														<th>Jenis</th>
														<th>perolehan</th>
														<th>Seksi Pemakai</th>
														<th>Requester</th>
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
																	<td><?php echo $key['no_ppa'] ?></td>
																	<td><?php echo $key['no_pp'] ?></td>
																	<td><?php echo $key['tgl_pp'] ?></td>
																	<td><?php echo $key['kategori'] ?></td>
																	<td><?php echo $key['jenis_asset'] ?></td>
																	<td><?php echo $key['perolehan'] ?></td>
																	<td><?php echo $key['seksi'] ?></td>
																	<td><?php echo $key['requester'] ?></td>
																	<td>
																		<?php 
																			$key['id_input_asset'] = $this->encrypt->encode($key['id_input_asset']);
        																	$key['id_input_asset'] = str_replace(array('+', '/', '='), array('-', '_', '~'), $key['id_input_asset']); 
        																?>
																		<a href="<?php echo site_url('SiteManagement/InputAsset/EditAsset/'.$key['id_input_asset']) ?>" class="fa fa-pencil-square-o fa-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Edit Data'></a>
																		<a href="<?php echo site_url('SiteManagement/InputAsset/RemoveAsset/'.$key['id_input_asset']) ?>" class="fa fa-trash fa-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Data' onclick="return confirm('Apakah Anda yakin ingin menghapus data ini ?')"></a>
																	</td>
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