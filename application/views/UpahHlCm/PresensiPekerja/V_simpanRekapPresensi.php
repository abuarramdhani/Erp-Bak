<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="box box-solid box-primary">
					<div class="box-header with-border text-center">
						<h1>Data Rekap Berhasil Disimpan Di Arsip</h1>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-lg-12">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th rowspan="2" style="text-align: center;vertical-align: middle;">No</th>
											<th rowspan="2" style="text-align: center;vertical-align: middle;">Nama</th>
											<th rowspan="2" style="text-align: center;vertical-align: middle;">Status</th>
											<th colspan="4" style="text-align: center;vertical-align: middle;">Gaji</th>
											<th colspan="3" style="text-align: center;vertical-align: middle;">Tambahan</th>
											<th colspan="3" style="text-align: center;vertical-align: middle;">Potongan</th>
										</tr>
										<tr>
											<th style="text-align: center;vertical-align: middle;">Gaji Pokok</th>
											<th style="text-align: center;vertical-align: middle;">Lembur</th>
											<th style="text-align: center;vertical-align: middle;">Uang Makan</th>
											<th style="text-align: center;vertical-align: middle;">Uang Makan Puasa</th>
											<th style="text-align: center;vertical-align: middle;">Gaji Pokok</th>
											<th style="text-align: center;vertical-align: middle;">Lembur</th>
											<th style="text-align: center;vertical-align: middle;">Uang Makan</th>
											<th style="text-align: center;vertical-align: middle;">Gaji Pokok</th>
											<th style="text-align: center;vertical-align: middle;">Lembur</th>
											<th style="text-align: center;vertical-align: middle;">Uang Makan</th>
										</tr>
									</thead>
									<tbody>
										<?php if (isset($RekapPresensi) && !empty($RekapPresensi)) {
											$nomor = 1;
											foreach ($RekapPresensi as $key) {
												?>
												<tr>
													<td><?php echo $nomor; ?></td>
													<td><?php echo $key['nama'] ?></td>
													<td><?php echo $key['pekerjaan'] ?></td>
													<td style="text-align: center"><?php echo number_format($key['gp_gaji'],'2','.','') ?></td>
													<td style="text-align: center"><?php echo number_format($key['lembur_gaji'],'2','.','') ?></td>
													<td style="text-align: center"><?php echo number_format($key['um_gaji'],'2','.','') ?></td>
													<td style="text-align: center"><?php echo number_format($key['ump_gaji'],'2','.','') ?></td>
													<td style="text-align: center"><?php echo number_format($key['gp_tambahan'],'2','.','') ?></td>
													<td style="text-align: center"><?php echo number_format($key['lembur_tambahan'],'2','.','') ?></td>
													<td style="text-align: center"><?php echo number_format($key['um_tambahan'],'2','.','') ?></td>
													<td style="text-align: center"><?php echo number_format($key['gp_potongan'],'2','.','') ?></td>
													<td style="text-align: center"><?php echo number_format($key['lembur_potongan'],'2','.','') ?></td>
													<td style="text-align: center"><?php echo number_format($key['um_potongan'],'2','.','') ?></td>
												</tr>
												<?php
												$nomor++;
											}
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
</section>