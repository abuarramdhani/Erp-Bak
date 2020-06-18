<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right"><h1><b><?=$Title; ?></b></h1></div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a href="<?php echo site_url('CateringManagement'); ?>" class="btn btn-default btn-lg">
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
								<a href="<?php echo site_url('CateringManagement/catering/Create') ?>" class="btn btn-default icon-plus icon-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Add Data' style="float: right;"></a>
							</div>
							<div class="box-body">
								<div class="table-responsive">
									<table class="datatable table table-bordered table-hover table-striped text-left">
										<thead class="bg-primary">
											<tr>
												<th>No</th>
												<th>Kode Katering</th>
												<th>Nama Katering</th>
												<th>Alamat</th>
												<th>Telepon</th>
												<th>Lokasi</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php $a = 1; 
												foreach ($Catering as $value) { 
													$encrypted_string = $this->encrypt->encode($value['fs_kd_katering']);
                                                	$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

													?>
													<tr>
														<td><?php echo $a; ?></td>
														<td><?php echo $value['fs_kd_katering']; ?></td>
														<td><?php echo $value['fs_nama_katering']; ?></td>
														<td><?php echo $value['fs_alamat']; ?></td>
														<td><?php echo $value['fs_telepon']; ?></td>
														<td><?php echo $value['lokasi_kerja'] == '01' ? 'Pusat & Mlati' : ($value['lokasi_kerja'] == '02' ? 'Tuksono' : 'Tidak Diketahui'); ?></td>
														<td><?php if($value['fb_status'] == 't'){ echo "<span class='label label-success'>Aktif</span>"; }else{ echo "<span class='label label-danger'>Tidak Aktif</span>";} ?></td>
														<td>
															<a href="<?php echo base_url('CateringManagement/catering/Edit/'.$encrypted_string) ?>" class="fa fa-edit fa-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Edit Data'></a>
															<a href="<?php echo base_url('CateringManagement/catering/Delete/'.$encrypted_string) ?>" class="fa fa-trash fa-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Data' onclick='return confirm("Apakah Anda Yakin Ingin Menghapus Data Ini ?")'></a>

														</td>
													</tr>
											<?php $a++;	} ?>
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