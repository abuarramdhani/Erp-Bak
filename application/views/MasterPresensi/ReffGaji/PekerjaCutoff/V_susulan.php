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
															$tgl1 = substr($key['periode'],0,4);
															$tgl2 = substr($key['periode'],4,6);
												?>
															<tr>
																<td class="text-center"><?=$nomor ?></td>
																<td class="text-center"><?php echo $bulan[intval($tgl2)].' '.$tgl1 ?></td>
																<td class="text-center"><?php echo $key['jumlah'] ?></td>
																<td class="text-center" style="font-size: 10pt">
																	<a 
																		href="<?php echo base_url('MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/detail_susulan/'.$key['periode']) ?>" 
																		title="Lihat Detail" class="btn btn-primary">
																		<span class="glyphicon glyphicon-search"></span>&nbsp;Detail
																	</a>
																	<a 
																		href="<?php echo base_url('MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/cetak_susulan/pdf/'.$key['periode']) ?>"
																		title="cetak PDF" 
																		target="_blank" 
																		class="btn btn-danger">
																		<span class="fa fa-file-pdf-o"></span>&nbsp;PDF
																	</a>
																	<a 
																		href="<?php echo base_url('MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/cetak_susulan/xls/'.$key['periode']) ?>"
																		title="cetak excel" 
																		target="_blank" 
																		class="btn btn-success">
																		<span class="fa fa-file-excel-o"></span>&nbsp;Excel
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