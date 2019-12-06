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
													<th class="text-center">No. Surat</th>
													<th class="text-center">Pembuat</th>
													<th class="text-center">Waktu Buat</th>
													<th class="text-center">Staff</th>
													<th class="text-center">Non-Staff</th>
													<th class="text-center">OS</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													if (isset($data) and !empty($data)) {
														$nomor = 1;
														foreach ($data as $key) { ?>
															<tr>
																<td style="text-align: center;vertical-align: middle;"><?=$nomor; ?></td>
																<td style="text-align: center;vertical-align: middle;"><?php echo strftime("%B %Y",strtotime($key['periode'])) ?></td>
																<td style="text-align: center;vertical-align: middle;"><?php echo $key['nomor_surat'] ?></td>
																<td style="vertical-align: middle;"><?php echo $key['dibuat'] ?></td>
																<td style="vertical-align: middle;"><?php echo strftime("tanggal : %d %B %Y <br> pukul : %H:%M:%S ",strtotime($key['created_timestamp'])) ?></td>
																<td style="text-align: center;vertical-align: middle;">
																	<?php if ($key['file_staff'] !== "-") { ?>
																		<a href="<?php echo site_url('assets/upload/TransferReffGaji/'.$key['file_staff'].'.dbf') ?>" class="btn btn-info">DBF</a>
																		<a href="<?php echo site_url('assets/upload/TransferReffGaji/'.$key['file_staff'].'.pdf') ?>" class="btn btn-danger">PDF</a>
																	<?php }else{
																		echo " - ";
																	} ?>
																</td>
																<td style="text-align: center;vertical-align: middle;">
																	<?php if ($key['file_nonstaff'] !== "-") { ?>
																		<a href="<?php echo site_url('assets/upload/TransferReffGaji/'.$key['file_nonstaff'].'.dbf') ?>" class="btn btn-info">DBF</a>
																		<a href="<?php echo site_url('assets/upload/TransferReffGaji/'.$key['file_nonstaff'].'.pdf') ?>" class="btn btn-danger">PDF</a>
																	<?php }else{
																		echo " - ";
																	} ?>
																</td>
																<td style="text-align: center;vertical-align: middle;">
																	<?php if ($key['file_os'] !== "-") { ?>
																		<a href="<?php echo site_url('assets/upload/TransferReffGaji/'.$key['file_os'].'.dbf') ?>" class="btn btn-info">DBF</a>
																		<a href="<?php echo site_url('assets/upload/TransferReffGaji/'.$key['file_os'].'.pdf') ?>" class="btn btn-danger">PDF</a>
																	<?php }else{
																		echo " - ";
																	} ?>
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