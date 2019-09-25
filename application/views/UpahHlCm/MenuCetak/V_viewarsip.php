<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h1><b><?=$Title; ?></b></h1>
						</div>
						<div class="col-lg-1"></div>
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
										<table id="table_prosesgaji" class="table table-hover table-bordered table-striped">
											<thead>
												<tr style="background-color: #00ccff;">
													<th style="text-align: center; vertical-align: middle;" rowspan="3">No</th>
													<th style="text-align: center; vertical-align: middle;" rowspan="3">No. Induk</th>
													<th style="text-align: center; vertical-align: middle;" rowspan="3">Nama</th>
													<th style="text-align: center; vertical-align: middle;" rowspan="3">Status</th>
													<th style="text-align: center; vertical-align: middle;" rowspan="3">Lokasi Kerja</th>
													<th style="text-align: center;" colspan="8">Proses Gaji</th>
													<th style="text-align: center;" colspan="6">Tambahan</th>
													<th style="text-align: center;" colspan="6">Potongan</th>
													<th style="text-align: center; vertical-align: middle;" rowspan="3">Total Gaji</th>
												</tr>
												<tr style="background-color: #00ccff;">
													<th style="text-align: center;" colspan="4">Komponen</th>
													<th style="text-align: center;" colspan="4">Nominal</th>
													<th style="text-align: center;" colspan="3">Komponen</th>
													<th style="text-align: center;" colspan="3">Nominal</th>
													<th style="text-align: center;" colspan="3">Komponen</th>
													<th style="text-align: center;" colspan="3">Nominal</th>
												</tr>
												<tr style="background-color: #00ccff;">
													<!-- Proses Gaji -->
													<th style="text-align: center;">Gaji Pokok</th>
													<th style="text-align: center;">Uang Makan</th>
													<th style="text-align: center;">Uang Makan Puasa</th>
													<th style="text-align: center;">Lembur</th>
													<th style="text-align: center;">Gaji Pokok</th>
													<th style="text-align: center;">Uang Makan</th>
													<th style="text-align: center;">Uang Makan Puasa</th>
													<th style="text-align: center;">Lembur</th>
													<!-- Tambahan -->
													<th style="text-align: center;">Gaji Pokok</th>
													<th style="text-align: center;">Uang Makan</th>
													<th style="text-align: center;">Lembur</th>
													<th style="text-align: center;">Gaji Pokok</th>
													<th style="text-align: center;">Uang Makan</th>
													<th style="text-align: center;">Lembur</th>
													<!-- Potongan -->
													<th style="text-align: center;">Gaji Pokok</th>
													<th style="text-align: center;">Uang Makan</th>
													<th style="text-align: center;">Lembur</th>
													<th style="text-align: center;">Gaji Pokok</th>
													<th style="text-align: center;">Uang Makan</th>
													<th style="text-align: center;">Lembur</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no=1;
												foreach ($data as $key) { ?>
													<tr>
														<td style="text-align: center;"><?php echo $no;?></td>
														<td style="text-align: center;"><?php echo $key['noind'];?></td>
														<td><?php echo $key['nama'];?></td>
														<td style="text-align: center;"><?php echo $key['pekerjaan'];?></td>
														<td style="text-align: center;"><?php echo $key['lokasi'];?></td>
														<td style="text-align: center;"><?php echo $key['jml_gp'];?></td>
														<td style="text-align: center;"><?php echo $key['jml_um'];?></td>
														<td style="text-align: center;"><?php echo $key['jml_ump'];?></td>
														<td style="text-align: center;"><?php echo $key['jml_lbr'];?></td>
														<td style="text-align: center;"><?php echo $key['gp'];?></td>
														<td style="text-align: center;"><?php echo $key['um'];?></td>
														<td style="text-align: center;"><?php echo $key['ump'];?></td>
														<td style="text-align: center;"><?php echo $key['lmbr'];?></td>
														<?php 
														if (!empty($key['tambahan'])) {
															?>
															<td style="text-align: center;"><?php echo $key['tambahan']->gp ?></td>
															<td style="text-align: center;"><?php echo $key['tambahan']->um ?></td>
															<td style="text-align: center;"><?php echo $key['tambahan']->lembur ?></td>
															<td style="text-align: center;"><?php echo $key['tambahan']->nominal_gp ?></td>
															<td style="text-align: center;"><?php echo $key['tambahan']->nominal_um ?></td>
															<td style="text-align: center;"><?php echo $key['tambahan']->nominal_lembur ?></td>
															<?php
															$key['total_bayar'] += ($key['tambahan']->nominal_gp + $key['tambahan']->nominal_um + $key['tambahan']->nominal_lembur);
														}else{
															?>
															<td style="text-align: center;">0</td>
															<td style="text-align: center;">0</td>
															<td style="text-align: center;">0</td>
															<td style="text-align: center;">0</td>
															<td style="text-align: center;">0</td>
															<td style="text-align: center;">0</td>
															<?php
														} ?>
														<?php 
														if (!empty($key['potongan'])) {
															?>
															<td style="text-align: center;"><?php echo $key['potongan']->gp ?></td>
															<td style="text-align: center;"><?php echo $key['potongan']->um ?></td>
															<td style="text-align: center;"><?php echo $key['potongan']->lembur ?></td>
															<td style="text-align: center;"><?php echo $key['potongan']->nominal_gp ?></td>
															<td style="text-align: center;"><?php echo $key['potongan']->nominal_um ?></td>
															<td style="text-align: center;"><?php echo $key['potongan']->nominal_lembur ?></td>
															<?php
															$key['total_bayar'] -= ($key['potongan']->nominal_gp + $key['potongan']->nominal_um + $key['potongan']->nominal_lembur);
														}else{
															?>
															<td style="text-align: center;">0</td>
															<td style="text-align: center;">0</td>
															<td style="text-align: center;">0</td>
															<td style="text-align: center;">0</td>
															<td style="text-align: center;">0</td>
															<td style="text-align: center;">0</td>
															<?php
														} ?>
														<td style="text-align: center;"><?php echo $key['total_bayar'];?></td>
													</tr>
													<?php
													$no++;
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