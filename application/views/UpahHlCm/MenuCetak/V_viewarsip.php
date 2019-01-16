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
													<th style="text-align: center; vertical-align: middle;" rowspan="2">No</th>
													<th style="text-align: center; vertical-align: middle;" rowspan="2">Nama</th>
													<th style="text-align: center; vertical-align: middle;" rowspan="2">Status</th>
													<th style="text-align: center;" colspan="3">Komponen</th>
													<th style="text-align: center;" colspan="3">Nominal</th>
													<th style="text-align: center; vertical-align: middle;" rowspan="2">Total Gaji</th>
												</tr>
												<tr style="background-color: #00ccff;">
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
														<td><?php echo $key['nama'];?></td>
														<td style="text-align: center;"><?php echo $key['pekerjaan'];?></td>
														<td style="text-align: center;"><?php echo $key['jml_gp'];?></td>
														<td style="text-align: center;"><?php echo $key['jml_um'];?></td>
														<td style="text-align: center;"><?php echo $key['jml_lbr'];?></td>
														<td style="text-align: center;"><?php echo $key['gp'];?></td>
														<td style="text-align: center;"><?php echo $key['um'];?></td>
														<td style="text-align: center;"><?php echo $key['lmbr'];?></td>
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