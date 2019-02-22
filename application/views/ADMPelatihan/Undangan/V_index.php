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
							<div class="text-right hidden-sm hidden-xs hidden-md">
								<a href="" class="btn btn-default btn-lg"><i class="icon-wrench icon-2x"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border text-right">
								<a href="<?php echo site_url('ADMPelatihan/Cetak/Undangan/Create') ?>" class="btn btn-primary"><span class="icon-plus icon-2x"></span></a>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="table-responsive">
											<table class="datatable table table-striped table-bordered table-hover text-left datatable-undangan-adm">
												<thead class="bg-primary">
													<tr>
														<th style="width: 5%">No</th>
														<th style="width: 15%">Tanggal Pembuatan</th>
														<th style="width: 15%">Acara</th>
														<th style="width: 20%">Tempat</th>
														<th style="width: 25%">Peserta</th>
														<th style="width: 10%">Keterangan</th>
														<th style="width: 10%">Action</th>
													</tr>
												</thead>
												<tbody>
													<?php if (isset($tabel)) {
																foreach ($tabel as $value) { ?>
														<tr class="accordion-toggle">
															<td><?php echo $value['angka'] ?></td>
															<td><?php echo $value['tanggal'] ?></td>
															<td><?php echo $value['acara'] ?></td>
															<td><?php echo $value['tempat'] ?></td>
															<td data-toggle="collapse" data-target="#collapse<?php echo $value['angka'] ?>"><?php echo $value['peserta1'] ?>
																<div id="collapse<?php echo $value['angka'] ?>" class="collapse"><?php echo $value['peserta2'] ?></div>
															</td>
															<td>Cetak <?php echo $value['keterangan'] ?></td>
															<td>
																<?php 
																$encrypted_string = $this->encrypt->encode($value['id']);
                                                				$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string); 
                                                				?>
																<a href="<?php echo site_url('ADMPelatihan/Cetak/Undangan/Edit/'.$encrypted_string) ?>" data-toggle="tooltip" data-placement='bottom' data-original-title='Edit Data' class="fa fa-pencil-square-o fa-2x"></a>
																<a target="_blank" href="<?php echo site_url('ADMPelatihan/Cetak/Undangan/Cetak/'.$encrypted_string) ?>" data-toggle="tooltip" data-placement='bottom' data-original-title='Cetak Data' class="fa fa-print fa-2x"></a>
																<a href="<?php echo site_url('ADMPelatihan/Cetak/Undangan/Delete/'.$encrypted_string) ?>" data-toggle="tooltip" data-placement='bottom' data-original-title='Delete Data' onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini ?')" class="fa fa-trash fa-2x"></a>
															</td>
														</tr>
													<?php }} ?>
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