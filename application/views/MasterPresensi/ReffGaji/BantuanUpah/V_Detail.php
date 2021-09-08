<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h3><b><?=$Title ?></b></h3>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-6">
										<span style="font-size: 20pt">Data Hasil Proses</span>
									</div>
									<div class="col-lg-6 text-right">
										<a href="" class="btn btn-danger">
											<span class="fa fa-file-pdf-o"></span>
											PDF
										</a>
										<a href="" class="btn btn-success">
											<span class="fa fa-file-excel-o"></span>
											Excel
										</a>
										<a href="" class="btn btn-danger">
											<span class="fa fa-trash"></span>
											Hapus
										</a>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<style type="text/css">
											.dt-buttons {
												float: left;
											}
											.dataTables_filter {
												float: right;
											}
										</style>
										<table class="table table-bordered table-hover table-striped" id="tbl-MPR-BantuanUpah-HasilProses">
											<thead>
												<tr>
													<th rowspan="2" class="bg-primary">No</th>
													<th rowspan="2" class="bg-primary">No. Induk</th>
													<th rowspan="2" class="bg-primary">Nama</th>
													<th rowspan="2" class="bg-primary">Tanggal Perhitungan</th>
													<th rowspan="2" class="bg-primary">Lokasi Kerja</th>
													<th colspan="2" class="bg-primary">GP</th>
													<th colspan="2" class="bg-primary">IF</th>
													<th colspan="2" class="bg-primary">IP</th>
													<th colspan="2" class="bg-primary">IPT</th>
													<th colspan="2" class="bg-primary">IK</th>
													<th colspan="2" class="bg-primary">IKR</th>
													<th colspan="2" class="bg-primary">Ins. Kepatuhan</th>
													<th colspan="2" class="bg-primary">Ins. Kemahalan</th>
													<th colspan="2" class="bg-primary">Ins. Penempatan</th>
													<th rowspan="2" class="bg-primary">Kategori</th>
													<th rowspan="2" class="bg-primary">Keterangan</th>
												</tr>
												<tr>
													<th class="bg-primary text-center">Kom</th>
													<th class="bg-primary text-center">Prs(%)</th>
													<th class="bg-primary text-center">Kom</th>
													<th class="bg-primary text-center">Prs(%)</th>
													<th class="bg-primary text-center">Kom</th>
													<th class="bg-primary text-center">Prs(%)</th>
													<th class="bg-primary text-center">Kom</th>
													<th class="bg-primary text-center">Prs(%)</th>
													<th class="bg-primary text-center">Kom</th>
													<th class="bg-primary text-center">Prs(%)</th>
													<th class="bg-primary text-center">Kom</th>
													<th class="bg-primary text-center">Prs(%)</th>
													<th class="bg-primary text-center">Kom</th>
													<th class="bg-primary text-center">Prs(%)</th>
													<th class="bg-primary text-center">Kom</th>
													<th class="bg-primary text-center">Prs(%)</th>
													<th class="bg-primary text-center">Kom</th>
													<th class="bg-primary text-center">Prs(%)</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($detail) && !empty($detail)) {
													$nomor = 1;
													foreach ($detail as $dt) {
														?>
														<tr>
															<td><?php echo $nomor ?></td>
															<td><?php echo $dt['noind'] ?></td>
															<td><?php echo $dt['nama'] ?></td>
									                        <td><?php echo $dt['tanggal_perhitungan_awal']." s/d ".$dt['tanggal_perhitungan_akhir'] ?></td>
									                        <td><?php echo $dt['lokasi_kerja'] ?></td>
									                        <td><?php echo $dt['kom_gp'] ?></td>
									                        <td><?php echo $dt['persen_gp'] ?></td>
									                        <td><?php echo $dt['kom_if'] ?></td>
									                        <td><?php echo $dt['persen_if'] ?></td>
									                        <td><?php echo $dt['kom_ip'] ?></td>
									                        <td><?php echo $dt['persen_ip'] ?></td>
									                        <td><?php echo $dt['kom_ipt'] ?></td>
									                        <td><?php echo $dt['persen_ipt'] ?></td>
									                        <td><?php echo $dt['kom_ik'] ?></td>
									                        <td><?php echo $dt['persen_ik'] ?></td>
									                        <td><?php echo $dt['kom_ikr'] ?></td>
									                        <td><?php echo $dt['persen_ikr'] ?></td>
									                        <td><?php echo $dt['kom_ins_kepatuhan'] ?></td>
									                        <td><?php echo $dt['persen_ins_kepatuhan'] ?></td>
									                        <td><?php echo $dt['kom_ins_kemahalan'] ?></td>
									                        <td><?php echo $dt['persen_ins_kemahalan'] ?></td>
									                        <td><?php echo $dt['kom_ins_penempatan'] ?></td>
									                        <td><?php echo $dt['persen_ins_penempatan'] ?></td>
									                        <td><?php echo $dt['kategori'] ?></td>
									                        <td><?php echo $dt['keterangan'] ?></td>
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