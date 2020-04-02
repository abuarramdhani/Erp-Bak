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
							<div class="box-header">
								
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table id="tblPendataanBelumInput" class="table table-hover table-striped table-bordered">
											<thead class="bg-primary">
												<tr>
													<th>No.</th>
													<th>Action</th>
													<th>No. Induk</th>
													<th>Nama</th>
													<th>Seksi</th>
													<th>Unit</th>
													<th>Lokasi Kerja</th>
													<th>No. HP</th>
													<th>Shift</th>
													<th>Jam Masuk</th>
													<th>Batas Toleransi Terlambat</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($data) && !empty($data)) {
													$nomor = 1;
													foreach ($data as $dt) {
														?>
														<tr>
															<td><?php echo $nomor ?></td>
															<td>
																<?php 
$text = 'Halo '.$dt['panggil'].' '.$dt['nama'].' 

'.$dt['panggil'].' tercatat tidak masuk (tidak ada absen finger/barcode) pada '.$dt['tanggal'].' - '.$dt['shift'].'. 
Mohon bantuan untuk utk mengisi form pendataan berikut:
Note : password menggunakan tanggal lahir dengan format : ddmmyyyy

Bisa diakses melalui komputer internet di kantor maupun rumah,HP Pribadi, HP Mygroup :
https://quick.co.id/pendataan/

Dengan terkumpulnya informasi ini, diharapkan kita dapat melihat sebaran kondisi kesehatan karyawan di KHS utk secepatnya menentukan kebijakan-kebijakan dan keputusan-keputusan seperlunya.

Terima kasih.
Hubungan Kerja
';
																if ($dt['nomor'] !== 'kosong') {
																?>
																<a href="<?php echo 'https://web.whatsapp.com/send?phone=62'.substr(str_replace(' ', '', $dt['nomor']), 1).'&text='.urlencode($text) ?>"
																	target="_blank"
																	class="btn btn-info">WhatsApp Web</a>
																	<a href="<?php echo 'https://api.whatsapp.com/send?phone=62'.substr(str_replace(' ', '', $dt['nomor']), 1).'&text='.urlencode($text) ?>"
																	target="_blank"
																	class="btn btn-success">WhatsApp Apps</a>
																<?php } ?>
															</td>
															<td><?php echo $dt['noind'] ?></td>
															<td><?php echo $dt['nama'] ?></td>
															<td><?php echo $dt['seksi'] ?></td>
															<td><?php echo $dt['unit'] ?></td>
															<td><?php echo $dt['lokasi_kerja'] ?></td>
															<td><?php echo $dt['nomor'] !== 'kosong' ? str_replace(' ', '', $dt['nomor']) : 'kosong' ?></td>
															<td><?php echo $dt['shift'] ?></td>
															<td><?php echo $dt['jam_msk'] ?></td>
															<td><?php echo $dt['jam_akhmsk'] ?></td>
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
