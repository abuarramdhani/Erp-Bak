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
										<table class="table table-bordered table-striped table-hover" id="tblHLCMMOnitoringPengembalian">
											<thead class="bg-primary">
												<tr>
													<th style="text-align: center;vertical-align: middle;">NO.</th>
													<th style="text-align: center;vertical-align: middle;">IDUL FITRI</th>
													<th style="text-align: center;vertical-align: middle;">NO. INDUK</th>
													<th style="text-align: center;vertical-align: middle;">NAMA</th>
													<th style="text-align: center;vertical-align: middle;">MASA KERJA</th>
													<th style="text-align: center;vertical-align: middle;">TANGGAL KELUAR</th>
													<th style="text-align: center;vertical-align: middle;">NOMINAL THR</th>
													<th style="text-align: center;vertical-align: middle;">CATATAN</th>
													<th style="text-align: center;vertical-align: middle;">TANGGAL KEMBALI</th>
													<th style="text-align: center;vertical-align: middle;">ACTION</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													if (isset($data) && !empty($data)) {
														$nomor = 1;
														foreach ($data as $dt) {
															?>
															<tr>
																<td style="text-align: center;vertical-align: middle;"><?php echo $nomor ?></td>
																<td style="text-align: center;vertical-align: middle;">
																	<?php echo date('d M Y',strtotime($dt['tgl_idul_fitri'])) ?>
																</td>
																<td style="text-align: center;vertical-align: middle;">
																	<?php echo $dt['noind'] ?>
																</td>
																<td style="text-align: left;vertical-align: middle;">
																	<?php echo $dt['employee_name'] ?>
																</td>
																<td style="text-align: left;vertical-align: middle;">
																	<?php echo $dt['masa_kerja'] ?>
																</td>
																<td style="text-align: center;vertical-align: middle;">
																	<?php echo date('d M Y',strtotime($dt['resign_date'])) ?>
																</td>
																<td style="text-align: right;vertical-align: middle;">
																	<?php echo number_format($dt['nominal_thr'],2,',','.') ?>
																</td>
																<td style="text-align: left;vertical-align: middle;">
																	<?php echo $dt['note'] ?>
																</td>
																<td style="text-align: center;vertical-align: middle;">
																	<?php echo $dt['tgl_kembali'] ? date('d M Y',strtotime($dt['tgl_kembali'])) : 'Belum Kembali' ?>
																</td>
																<td style="text-align: center;vertical-align: middle;">
																	<a href="<?php echo base_url('HitungHlcm/THR/MonitoringPengembalian/pengembalian?id='.$dt['id_thr']) ?>" class="btn btn-primary" <?php echo $dt['tgl_kembali'] ? 'disabled' : '' ?>>pengembalian</a>
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