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
						<div class="box box-solid box-primary">
							<div class="box-header with-border">
								<a class="btn btn-success pull-right" href="<?php echo base_url('MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/pekerja') ?>">Cari Pekerja</a>
								<a class="btn btn-warning pull-left" href="<?php echo base_url('MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/list_memo') ?>">Memo yang pernah di proses</a>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table class="dataTable-pekerjaCutoff table table-bordered table-striped table-hover table-hovered">
											<thead class="bg-primary">
												<tr>
													<th class="text-center">No</th>
													<th class="text-center">Periode</th>
													<th class="text-center">Jumlah</th>
													<th class="text-center">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													if(isset($data) and !empty($data)){
														$nomor = 1;
														foreach ($data as $key) { 
															$bulan = array (
																1 =>   'Januari',
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
															$tgl = explode("-", $key['tanggal_proses']);
												?>
															<tr>
																<td class="text-center"><?=$nomor ?></td>
																<td class="text-center"><?php echo $bulan[intval($tgl['1'])].' '.$tgl['0'] ?></td>
																<td class="text-center"><?php echo $key['jumlah'] ?></td>
																<td class="text-center" style="font-size: 18pt">
																	<a 
																		href="<?php echo base_url('MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/d/'.$key['tanggal_proses']) ?>" 
																		title="Lihat Detail">
																		<span class="glyphicon glyphicon-search"></span>
																	</a>
																	<a 
																		href="<?php echo base_url('MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/pdf/p/'.$key['tanggal_proses']) ?>"
																		title="cetak PDF" 
																		style="color: red"
																		target="_blank" >
																		<span class="fa fa-file-pdf-o"></span>
																	</a>
																	<a 
																		href="<?php echo base_url('MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/xls/p/'.$key['tanggal_proses']) ?>"
																		title="cetak excel" 
																		style="color: green" 
																		target="_blank">
																		<span class="fa fa-file-excel-o"></span>
																	</a>
																	<a 
																		href="<?php echo base_url('MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/memo/'.$key['tanggal_proses']) ?>"
																		title="Cetak Memo" 
																		style="color: grey" 
																		target="_blank">
																		<span class="fa fa-cogs"></span>
																	</a>
																</td>
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