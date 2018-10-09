<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b><?=$Title; ?></b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a href="<?php echo site_url('CateringManagement/PengajuanLibur'); ?>" class="btn btn-default btn-lg">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
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
										<form class="form-horizontal" method="post" action="<?php echo site_url('CateringManagement/PengajuanLibur') ?>">
											<div class="form-group">
												<div class="control-label col-lg-2">Periode</div>
												<div class="col-lg-4">
													<input type="text" class="date form-control" name="txtperiodePengajuanLibur" id="txtperiodePengajuanLibur" value="<?php if (isset($select)) {echo $select;}?>" placeholder="Periode" data-date-format="yyyy-mm-dd" required>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-6 text-right">
													<button type="submit" class="btn btn-primary">Cari</button>
												</div>
											</div>
										</form>									
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 text-right">
										<?php if (isset($encrypted_link)) { ?>
											<a href="<?php echo site_url('CateringManagement/PengajuanLibur/Create/'.$encrypted_link) ?>" class="btn btn-primary">Tambah</a>
										<?php } ?>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="table-responsive" >
											<table class="datatable table table-striped table-hover table-bordered text-left">
												<thead class="bg-primary">
													<tr>
														<th>No</th>
														<th>Tanggal</th>
														<th>Katering Libur</th>
														<th>Katering Pengganti</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php if (isset($table)) {
														$a=1;
														foreach ($table as $key) { 
															$encrypted = $this->encrypt->encode($key['a']."-".$key['b']."-".$key['c']."-".$key['fs_kd_katering_libur']."-".$key['fs_kd_katering_pengganti']);
	        												$encrypted = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted);
															?>
															<tr>
																<td><?php echo $a ?></td>
																<td><?php echo $key['fd_tanggal'] ?></td>
																<td><?php echo $key['nama_katering_libur'] ?></td>
																<td><?php echo $key['nama_katering_pengganti'] ?></td>
																<td>
																	<a href="<?php echo site_url('CateringManagement/PengajuanLibur/Edit/'.$encrypted_link."/".$encrypted) ?>"  class='fa fa-edit fa-2x' data-toggle='tooltip' data-placement='bottom' data-original-title='Edit Data'></a>
																	<a href="<?php echo site_url('CateringManagement/PengajuanLibur/Delete/'.$encrypted_link."/".$encrypted) ?>" class='fa fa-trash fa-2x' data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Data' onclick='return confirm(\"Apakah Anda Yakin Ingin Menghapus Data Ini ?\")'></a>
																</td>
															</tr>
													<?php	$a++;}
													 } ?>
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