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
								<a href="javascript:history.back()" class="btn btn-info">Kembali</a>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table>
											<tr>
												<td>Tanggal</td>
												<td>:</td>
												<td><?php echo date('d M Y',strtotime($tanggal)) ?></td>
											</tr>
											<tr>
												<td>Shift</td>
												<td>:</td>
												<td><?php echo $shift == '1' ? 'Shift 1 & Umum' : ''  ?></td>
											</tr>
											<tr>
												<td>Lokasi</td>
												<td>:</td>
												<td><?php echo $lokasi == '1' ? 'Yogyakarta & Mlati' : 'Tuksono' ?></td>
											</tr>
										</table>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<style type="text/css">
											.dataTables_filter {
												float: right;
											}
											.dataTables_paginate {
												float: right;
											}
											.dt-buttons {
												float: left;
											}
											.dataTables_info {
												float: left;
											}
										</style>
										<table class="table table-bordered table-hover table-striped" id="tbl-CM-PrediksiSnack-Table">
											<thead class="bg-primary">
												<tr>
													<th>No.</th>
													<th>Tempat Makan</th>
													<th>Jumlah Shift</th>
													<th>Dirumahkan</th>
													<th>Cuti</th>
													<th>Sakit</th>
													<th>Dinas Luar</th>
													<th>Total</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												$total_jumlah_shift = 0;
												$total_dirumahkan = 0;
												$total_cuti = 0;
												$total_sakit = 0;
												$total_dinas_luar = 0;
												$total_total = 0;
												if (isset($prediksi) && !empty($prediksi)) {
													$nomor = 1;
													foreach ($prediksi as $key => $value) {
														?>
														<tr>
															<td><?php echo $nomor; ?></td>
															<td><?php echo $value['tempat_makan'] ?></td>
															<td><?php echo $value['jumlah_shift'] ?></td>
															<td style="<?php echo $value['dirumahkan'] != "0" ? "background-color: #ff4d4d" : ""; ?>" ><?php echo $value['dirumahkan'] ?></td>
															<td style="<?php echo $value['cuti'] != "0" ? "background-color: #ff4d4d" : ""; ?>" ><?php echo $value['cuti'] ?></td>
															<td style="<?php echo $value['sakit'] != "0" ? "background-color: #ff4d4d" : ""; ?>" ><?php echo $value['sakit'] ?></td>
															<td style="<?php echo $value['dinas_luar'] != "0" ? "background-color: #ff4d4d" : ""; ?>" ><?php echo $value['dinas_luar'] ?></td>
															<td><?php echo $value['total'] ?></td>
														</tr>
														<?php
														$total_jumlah_shift += $value['jumlah_shift'];
														$total_dirumahkan += $value['dirumahkan'];
														$total_cuti += $value['cuti'];
														$total_sakit += $value['sakit'];
														$total_dinas_luar += $value['dinas_luar'];
														$total_total += $value['total'];
														$nomor++;
													}
												}
												?>
											</tbody>
											<tfoot class="bg-primary">
												<tr>
													<th></th>
													<th></th>
													<th><?php echo $total_jumlah_shift; ?></th>
													<th><?php echo $total_dirumahkan; ?></th>
													<th><?php echo $total_cuti; ?></th>
													<th><?php echo $total_sakit; ?></th>
													<th><?php echo $total_dinas_luar; ?></th>
													<th><?php echo $total_total; ?></th>
												</tr>
											</tfoot>
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