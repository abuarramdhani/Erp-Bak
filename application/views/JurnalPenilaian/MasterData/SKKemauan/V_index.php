<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h1><b><?php echo $Title ?></b></h1>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-xs hidden-sm hidden-md">
								<a href="" class="btn btn-default btn-lg"><i class="icon-wrench icon-2x"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border text-right">
								<a href="<?php echo site_url('PenilaianKinerja/Masterskkemauan/Create') ?>" class="btn btn-primary"><i class="fa fa-plus fa-2x"></i></a>
							</div>
							<div class="box-body">
								<div class="table-responsive">
									<table class="table table-striped table-hover table-bordered text-left">
										<thead class="bg-primary">
											<tr>
												<th>No</th>
												<th>Bulan Batas Bawah</th>
												<th>Bulan Batas Atas</th>
												<th>Pengurang</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php 	
												if (isset($skkemauan) and !empty($skkemauan)) {
													$no = 1;
													foreach ($skkemauan as $key) { ?>
														<tr>
															<td><?php echo $no; ?></td>
															<td><?php echo $key['bulan_batas_bawah'] ?></td>
															<td><?php echo $key['bulan_batas_atas'] ?></td>
															<td><?php echo $key['pengurang'] ?></td>
															<td class="text-center">
																<a href="<?php echo site_url('PenilaianKinerja/Masterskkemauan/Edit/'.$key['sk_kemauan_id']) ?>" class="fa fa-pencil-square-o fa-2x"></a>
																<a href="<?php echo site_url('PenilaianKinerja/Masterskkemauan/Delete/'.$key['sk_kemauan_id']) ?>" class="fa fa-trash fa-2x" style="color: red" onclick="return confirm('Apakah Anda Yakin ingin menghapus data ini ?')"></a>
															</td>
														</tr>
													<?php $no++; }
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
</section>