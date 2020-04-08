<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right"><h1><b><?=$Title ?></b></h1></div>
						</div>
						<div class="col-lg-1">
							<a href="<?php echo site_url('CateringManagement/TmpMakan') ?>" class="btn btn-default btn-lg">
								<span class="icon-wrench icon-2x"></span>
							</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border text-right">
								<a href="<?php echo site_url('CateringManagement/TmpMakan/Create') ?>" class="btn btn-default icon-plus icon-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Add Data'></a>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="table-responsive">
											<table class="datatable table table-bordered table-striped table-hover text-left dataTable-TmpMakan">
												<thead class="bg-primary">
													<tr>
														<th>No</th>
														<th>Tempat Makan</th>
														<th>Letak Tempat makan</th>
														<th>Lokasi Tempat makan</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php $a=1;foreach ($TmpMakan as $key) { 
														$encrypted_1 = $this->encrypt->encode($key['fs_tempat_makan']);
                                                		$encrypted_1 = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_1);
                                                		$encrypted_2 = $this->encrypt->encode($key['fs_tempat']);
                                                		$encrypted_2 = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_2);
                                                		$encrypted_3 = $this->encrypt->encode($key['fs_letak']);
                                                		$encrypted_3 = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_3);
                                                		$encrypted_4 = $this->encrypt->encode($key['fs_lokasi']);
                                                		$encrypted_4 = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_4);
                                                	?>
														<tr>
															<td><?php echo $a; ?></td>
															<td><?php echo $key['fs_tempat_makan'] ?></td>
															<td><?php echo $key['fs_letak'] ?></td>
															<td><?php echo $key['fs_lokasi'] == '1' ? 'Pusat & Mlati' : ($key['fs_lokasi'] == '2' ? 'Tuksono' : 'Tidak Diketahui'); ?></td>
															<td>
																<a href="<?php echo base_url('CateringManagement/TmpMakan/Edit/'.$encrypted_1.'/'.$encrypted_2.'/'.$encrypted_3.'/'.$encrypted_4) ?>" class="fa fa-edit fa-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Edit Data'></a>
															<a href="<?php echo base_url('CateringManagement/TmpMakan/Delete/'.$encrypted_1.'/'.$encrypted_2) ?>" class="fa fa-trash fa-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Data' onclick='return confirm("Apakah Anda Yakin Ingin Menghapus Data Ini ?")'></a>
															</td>
														</tr>
													<?php $a++;} ?>
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