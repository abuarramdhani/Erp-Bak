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
								
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-striped table-bordered table-hover" id="tblHLCMBulanTHR">
											<thead class="bg-primary">
												<tr>
													<th>No.</th>
													<th>Action</th>
													<th>No. Induk</th>
													<th>Nama</th>
													<th>Lokasi Kerja</th>
													<th>Masuk Kerja</th>
													<th>Masa Kerja</th>
													<th>Nominal THR</th>
												</tr>
											</thead>
											<tbody id="tbodyBulanTHR">
												<?php 
												if (isset($data) && !empty($data)) {
													$nomor = 1;
													foreach ($data as $dt) {
														?>
														<tr>
															<td style="text-align: center;vertical-align: middle;"><?php echo $nomor ?></td>
															<td style="text-align: center;vertical-align: middle;">
																<a href="<?php echo base_url('HitungHlcm/THR/Perhitungan/delete?tanggal='.$tanggal.'&noind='.$dt['noind']) ?>" class="btn btn-danger"><span class="fa fa-trash"></span></a>
															</td>
															<td style="text-align: center;vertical-align: middle;"><?php echo $dt['noind'] ?></td>
															<td style="text-align: left;vertical-align: middle;padding-left: 5px;padding-right: 5px;"><?php echo $dt['employee_name'] ?></td>
															<td style="text-align: left;vertical-align: middle;padding-left: 5px;padding-right: 5px;"><?php echo $dt['location_name'] ?></td>
															<td style="text-align: left;vertical-align: middle;padding-left: 5px;padding-right: 5px;"><?php echo date('d M Y',strtotime($dt['tgl_masuk'])) ?></td>
															<td style="text-align: left;vertical-align: middle;padding-left: 5px;padding-right: 5px;"><?php echo $dt['masa_kerja'] ?></td>
															<td style="text-align: right;vertical-align: middle;"><?php echo number_format($dt['nominal_thr'],2,',','.') ?></td>
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