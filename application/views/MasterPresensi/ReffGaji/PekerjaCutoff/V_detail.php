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
							<div class="box-header with-border text-right">
								<input type="button" value="Back" onclick="window.history.back()" class="btn btn-warning" /> 
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12 text-center">
										<?php 
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
										$tgl= explode("-", $periode);
										echo "<h2>".$bulan[intval($tgl['1'])].' '.$tgl['0']."</h2>";
										?>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<table class="dataTable-pekerjaCutoff table table-bordered table-striped table-hover table-hovered">
											<thead class="bg-primary">
												<tr>
													<th class="text-center">No</th>
													<th class="text-center">No. Induk</th>
													<th class="text-center">Nama</th>
													<th class="text-center">Seksi/Unit</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													if(isset($data) and !empty($data)){
														$nomor = 1;
														foreach ($data as $key) { 
															
												?>
															<tr>
																<td class="text-center"><?=$nomor ?></td>
																<td class="text-center">
																	<a href="<?php echo base_url('MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/pekerja/'.$key['noind']) ?>">
																		<?php echo $key['noind'] ?>
																	</a>
																</td>
																<td class="text-left"><?php echo $key['nama'] ?></td>
																<td class="text-left"><?php echo $key['seksi'] ?></td>
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