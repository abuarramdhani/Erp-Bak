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
							<div class="text-right hidden-xs hidden-sm hidden-md">
								<a href="" class="btn btn-default btn-lg">
									<i class="icon-wrench icon-2x"></i>
								</a>
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
											<table class="datatable-ma table table-bordered table-striped table-hover text-left">
												<thead class="bg-primary">
													<tr>
														<th>No</th>
														<th>Serial Number</th>
														<th>Lokasi</th>
														<th>Lokasi Kerja</th>
														<th>Jumlah Total</th>
														<th>Jumlah Hapus</th>
														<th>Status</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php $no =1;foreach ($table as $key) { 
															$encrypted_string 	=	$this->general->enkripsi($key['id_lokasi']);
														?>
														<tr>
															<td><?php echo $no ?></td>
															<td><?php echo $key['device_sn'] ?></td>
															<td><?php echo $key['device_name'] ?></td>
															<td><?php echo $key['lokasi_kerja'] ?></td>
															<td><?php echo $key['scan_total'] ?></td>
															<td><?php echo $key['scan_delete'] ?></td>
															<?php if ($key['status_warning'] == '1') { ?>
																<td class="bg-danger">Segera hapus</td>
															<?php }elseif ($key['status_warning'] == '2') { ?>
																<td class="bg-warning">Siap-Siap</td>
															<?php }else{ ?>
																<td class="bg-success">Normal</td>
															<?php } ?>
															<td>
																<a type="button" href="<?php echo site_url('PresenceManagement/MonitoringPresensi/delete_device_scanlog'.'/'.$encrypted_string) ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" alt="Delete Scanlog" title="Delete Scanlog" onclick="return confirm('Apakah anda yakin ingin menghapus data scanlog di device ini ?')">
								                                    <i class="fa fa-trash"></i> <i class="fa fa-database"></i>
								                                </a>
															</td>
														</tr>
													<?php $no++;} ?>
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