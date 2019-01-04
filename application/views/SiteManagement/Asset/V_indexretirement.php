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
								<a href="<?php echo site_url('SiteManagement/RetirementAsset/InputNew') ?>" class="btn btn-info icon-plus"></a>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="table-responsive">
											<table class="datatable table table-bordered table-striped table-hover text-left table-asset">
												<thead class="bg-primary">
													<th>No</th>
													<th>No Retirement</th>
													<th>Tag Number</th>
													<th>Nama Barang</th>
													<th>Seksi</th>
													<th>Rencana Penghentian</th>
												</thead>
												<tbody>
													<?php $angka = 1;
													foreach ($tabel as $key) { ?>
													 	<tr>
													 		<td><?php echo $angka ?></td>
													 		<td><?php echo $key['no_retirement'] ?></td>
													 		<td><?php echo $key['tag_number'] ?></td>
													 		<td><?php echo $key['nama_barang'] ?></td>
													 		<td><?php echo $key['lokasi'] ?></td>
													 		<td><?php echo $key['rencana_penghentian'] ?>
													 			<?php if ($key['rencana_penghentian'] == 'Sementara') { 
													 				$encrypted_string = $this->encrypt->encode($key['id_retirement']."_-_".$key['tag_number']);
        															$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
													 				?>
													 				<a href="<?php echo site_url('SiteManagement/RetirementAsset/Aktif/'.$encrypted_string) ?>" class="icon-wrench"  data-toggle='tooltip' data-placement='bottom' data-original-title='Aktifkan Kembali' style="color: green" onclick="return confirm('Apakah Anda Yakin Ingin Menggunakan kembali Asset Ini ?')"></a>
													 			<?php } ?>
													 		</td>
													 	</tr>
													<?php $angka++; } ?>
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