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
										<table class="table table-bordered table-hover table-striped" id="tbl-CM-PrediksiSnack-List">
											<thead class="bg-primary">
												<tr>
													<th>No.</th>
													<th>Tanggal</th>
													<th>Shift</th>
													<th>Lokasi</th>
													<th>Jumlah Prediksi</th>
													<th>Prediksi Pertama</th>
													<th>Prediksi Terakhir</th>
													<th>User</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($prediksi) && !empty($prediksi)) {
													$nomor = 1;
													foreach ($prediksi as $key => $value) {
														?>
														<tr>
															<td><?php echo $nomor; ?></td>
															<td><?php echo date('d M Y',strtotime($value['tanggal'])) ?></td>
															<td><?php echo $value['shift'] == '1' ? 'Shift 1 & Umum' : '' ?></td>
															<td><?php echo $value['lokasi'] ? 'Yogyakarta & Mlati' : 'Tuksono' ?></td>
															<td><?php echo $value['jumlah'] ?></td>
															<td><?php echo date("Y-m-d H:i:s",strtotime($value['pertama'])) ?></td>
															<td><?php echo date("Y-m-d H:i:s",strtotime($value['terakhir'])) ?></td>
															<td><?php echo $value['pekerja'] ?></td>
															<td><a href="<?php echo base_url('CateringManagement/Pesanan/PrediksiSnack/daftar/'.$value['tanggal'].'_'.$value['shift'].'_'.$value['lokasi']) ?>" class="btn btn-info"><span class="fa fa-file-o"></span>&nbsp;Lihat</a></td>
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