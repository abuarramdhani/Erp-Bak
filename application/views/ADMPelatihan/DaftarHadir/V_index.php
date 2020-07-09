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
								
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<ul class="nav nav-pills nav-justified">
											<li class="active"><a data-toggle="pill" href="#pelatihan">Pelatihan</a></li>
                                    		<li><a data-toggle="pill" href="#paket">Paket Pelatihan</a></li>
										</ul>
										<div class="tab-content">
	                                    	<div id="pelatihan" class="tab-pane fade in active">
	                                    		<br>
	                                    		<div class="table-responsive">
													<table class="datatable table table-striped table-bordered table-hover text-left datatable-undangan-adm">
														<thead class="bg-primary">
															<tr>
																<th>No</th>
																<th>Nama Pelatihan</th>
																<th>Ruang Pelatihan</th>
																<th>Trainer Pelatihan</th>
																<th>Jenis Peserta</th>
																<th>Banyak Peserta</th>
																<th>Tanggal Pelatihan</th>
																<th>Action</th>
															</tr>
														</thead>
														<tbody>
															<?php
																$bulan = array(
																			'',
																			'Januari',
																			'Februari',
																			'Maret',
																			'April',
																			'Mei',
																			'Juni',
																			'Juli',
																			'Agustus',
																			'September',
																			'Oktober',
																			'November',
																			'Desember'
																		);
															 if (isset($Pelatihan)) {
																$angka1 = 1;
																foreach ($Pelatihan as $key) { ?>
																	<tr>
																		<td><?php echo $angka1 ?></td>
																		<td><?php echo $key['scheduling_name'] ?></td>
																		<td><?php echo $key['room'] ?></td>
																		<td><?php echo $key['trainer_name'] ?></td>
																		<td><?php echo $key['participant_type_description'] ?></td>
																		<td><?php echo $key['participant_number'] ?></td>
																		<td><?php $a = explode("-", $key['date']); echo $a[2]." ".strtoupper($bulan[intval($a[1])])." ".$a[0]."<br>".$key['start_time']." - ".$key['end_time'] ?></td>
																		<td>
																			<?php
																				$encrypted_string = $this->encrypt->encode($key['scheduling_id']);
                                                								$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string)
																			 ?>
	
																<a href="<?php echo site_url('ADMPelatihan/Cetak/Daftarhadir/Edit/'.$encrypted_string) ?>" data-toggle="tooltip" data-placement='bottom' data-original-title='Edit Data' class="fa fa-pencil-square-o fa-2x"></a>
																<a target="_blank" href="<?php echo site_url('ADMPelatihan/Cetak/Daftarhadir/PrintDaftarPelatihan/'.$encrypted_string) ?>" data-toggle="tooltip" data-placement='bottom' data-original-title='Cetak Data' class="fa fa-print fa-2x"></a>
																<a href="<?php echo site_url('ADMPelatihan/Cetak/Daftarhadir/Delete/'.$encrypted_string) ?>" data-toggle="tooltip" data-placement='bottom' data-original-title='Delete ' onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini ?')" class="fa fa-trash fa-2x"></a>
																		</td>
																	</tr>
															<?php	$angka1++;}
															} ?>
														</tbody>
													</table>
												</div>
	                                    	</div>
	                                    	<div id="paket" class="tab-pane fade">
	                                    		<br>
	                                    		<div class="table-responsive">
													<table class="datatable table table-striped table-bordered table-hover text-left datatable-undangan-adm">
														<thead class="bg-primary">
															<tr>
																<th>No</th>
																<th>Nama Paket Pelatihan</th>
																<th>Tipe Pelatihan</th>
																<th>Jenis Peserta</th>
																<th>Banyak Peserta</th>
																<th>Tanggal Pelatihan</th>
																<th>Action</th>
															</tr>
														</thead>
														<tbody>
															<?php if (isset($Paket)) {
																$angka2 = 1;
																foreach ($Paket as $key) { ?>
																	<tr>
																		<td><?php echo $angka2 ?></td>
																		<td><?php echo $key['package_scheduling_name'] ?></td>
																		<td><?php echo $key['training_type_description'] ?></td>
																		<td><?php echo $key['participant_type_description'] ?></td>
																		<td><?php if (!empty($key['participant_number'])) {
																			echo $key['participant_number'];
																		}else{
																			echo "belum ada peserta terjadwal";
																		}  ?></td>
																		<td>
																			<?php 
																			if (!empty($key['start_date'])) {
																				$b = explode("-", $key['start_date']);
																				$cout1 = $b[2]." "." ".strtoupper($bulan[intval($b[1])])." ".$b[0];
																			}else{
																				$cout1 = "First Day";
																			}

																			if (!empty($key['end_date'])) {
																				$c = explode("-", $key['end_date']);
																				$cout2 = $c[2]." ".strtoupper($bulan[intval($c[1])])." ".$c[0];
																			}else{
																				$cout2 = "Last Day";
																			}
																				
																				
																				 echo $cout1." - ".$cout2; 
																		 	?>
																		 </td>
																		<td>
																			<?php
																				$encrypted_string = $this->encrypt->encode($key['package_scheduling_id']);
                                                								$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
																			 ?>

																<a href="<?php echo site_url('ADMPelatihan/Cetak/Daftarhadir/Editpaket/'.$encrypted_string) ?>" data-toggle="tooltip" data-placement='bottom' data-original-title='Edit Data' class="fa fa-pencil-square-o fa-2x"></a>
																<a target="_blank" href="<?php echo site_url('ADMPelatihan/Cetak/Daftarhadir/PrintDaftarPaket/'.$encrypted_string) ?>" data-toggle="tooltip" data-placement='bottom' data-original-title='Cetak Data' class="fa fa-print fa-2x"></a>
																<a href="<?php echo site_url('ADMPelatihan/Cetak/Daftarhadir/Deletepaket/'.$encrypted_string) ?>" data-toggle="tooltip" data-placement='bottom' data-original-title='Delete ' onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini ?')" class="fa fa-trash fa-2x"></a>
																	
																		</td>
																	</tr>
															<?php	$angka2++;}
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
		</div>
	</div>
</section>