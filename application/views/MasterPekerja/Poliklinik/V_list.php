<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><?=$Title ?></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<div class="row">
									<div class="col-lg-12 text-right">
										<a href="<?php echo base_url('MasterPekerja/Poliklinik/InputData') ?>" class="btn btn-primary"><span class="fa fa-plus"></span>&nbsp;Tambah Data</a>
									</div>
								</div>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-striped table-hover table-bordered">
											<thead class="bg-success">
												<tr>
													<th style="text-align: center; vertical-align: middle;">No.</th>
													<th style="text-align: center; vertical-align: middle;">Action</th>
													<th style="text-align: center; vertical-align: middle;">Waktu Kunjungan</th>
													<th style="text-align: center; vertical-align: middle;">Pekerja</th>
													<th style="text-align: center; vertical-align: middle;">Seksi</th>
													<th style="text-align: center; vertical-align: middle;">Unit</th>
													<th style="text-align: center; vertical-align: middle;">Bidang</th>
													<th style="text-align: center; vertical-align: middle;">Departemen</th>
													<th style="text-align: center; vertical-align: middle;">Keterangan</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($data) && !empty($data)) {
													$nomor = 1;
													foreach ($data as $dt) {
														?>
														<tr>
															<td style="text-align: center; vertical-align: middle;"><?php echo $nomor ?></td>
															<td style="text-align: center; vertical-align: middle;">
																<?php 
																	$encrypted_string = $this->encrypt->encode($dt['id_kunjungan']);
																	$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
																?>
																<a href="<?php echo base_url('MasterPekerja/Poliklinik/EditData/'.$encrypted_string) ?>" class="btn btn-primary"><span class="fa fa-wrench"></span>&nbsp; Edit</a>	
																<a onclick="return confirm('Apakah Anda yakin ingin MENGHAPUS data ini ?')" href="<?php echo base_url('MasterPekerja/Poliklinik/HapusData/'.$encrypted_string) ?>" class="btn btn-danger"><span class="fa fa-trash"></span>&nbsp; Hapus</a>	
															</td>
															<td><?php echo strtoupper(date('d M Y H:i:s',strtotime($dt['waktu_kunjungan']))) ?></td>
															<td><?php echo $dt['noind'].' - '.$dt['employee_name'] ?></td>
															<td><?php echo $dt['section_name'] ?></td>
															<td><?php echo $dt['unit_name'] ?></td>
															<td><?php echo $dt['field_name'] ?></td>
															<td><?php echo $dt['department_name'] ?></td>
															<td><?php echo $dt['keterangan'] ?></td>
														</tr>
														<?php
														$nomor++;
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
</section>