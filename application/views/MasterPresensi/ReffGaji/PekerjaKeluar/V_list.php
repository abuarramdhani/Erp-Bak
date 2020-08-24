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
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-hover table-bordered table-striped" id="tbl-MPR-PekerjaKeluar-List">
											<thead>
												<tr>
													<th style="text-align: center;width: 30px;">No.</th>
													<th style="text-align: center;">Action</th>
													<th style="text-align: center;">No Induk</th>
													<th style="text-align: center;">Nama</th>
													<th style="text-align: center;">Tanggal Keluar</th>
													<th style="text-align: center;">IP</th>
													<th style="text-align: center;">IK</th>
													<th style="text-align: center;">UBT</th>
													<th style="text-align: center;">UPAMK</th>
													<th style="text-align: center;">IF</th>
													<th style="text-align: center;">LEMBUR</th>
													<th style="text-align: center;">HTM</th>
													<th style="text-align: center;">Ijin</th>
													<th style="text-align: center;">Sisa Cuti</th>
													<th style="text-align: center;">Keterangan</th>
													<th style="text-align: center;">UM Puasa</th>
													<th style="text-align: center;">IMS</th>
													<th style="text-align: center;">IMM</th>
													<th style="text-align: center;">IPT</th>
													<th style="text-align: center;">UM Cabang</th>
													<th style="text-align: center;">Uang DL</th>
													<th style="text-align: center;">Pot. Lain</th>
													<th style="text-align: center;">Tambahan</th>
													<th style="text-align: center;">Potongan</th>
													<th style="text-align: center;">Jumlah JKN</th>
													<th style="text-align: center;">Jumlah JHT</th>
													<th style="text-align: center;">Jumlah JP</th>
													<th style="text-align: center;">Total Duka</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($data) && !empty($data)) {
													$nomor = 1;
													foreach ($data as $key => $value) {
														$noind_encrypted = $this->encrypt->encode($value['noind']);
	                                                	$noind_encrypted = str_replace(array('+', '/', '='), array('-', '_', '~'), $noind_encrypted);
														?>
														<tr>
															<td style="text-align: center;"><?php echo $nomor ?></td>
															<td style="text-align: center;">
																<a href="<?php echo base_url('MasterPresensi/ReffGaji/PekerjaKeluar/editGaji/'.$noind_encrypted) ?>" class="btn btn-primary"><span class="fa fa-pencil-square-o"></span> Edit</a>
															</td>
															<td style="text-align: center;"><?php echo $value['noind'] ?></td>
															<td><?php echo $value['nama'] ?></td>
															<td style="text-align: center;"><?php echo date('d M Y',strtotime($value['tanggal_keluar'])) ?></td>
															<td style="text-align: right;"><?php echo $value['ipe'] ?></td>
															<td style="text-align: right;"><?php echo $value['ika'] ?></td>
															<td style="text-align: right;"><?php echo $value['ubt'] ?></td>
															<td style="text-align: right;"><?php echo $value['upamk'] ?></td>
															<td style="text-align: right;"><?php echo $value['ief'] ?></td>
															<td style="text-align: right;"><?php echo $value['jam_lembur'] ?></td>
															<td style="text-align: right;"><?php echo $value['htm'] ?></td>
															<td style="text-align: right;"><?php echo $value['ijin'] ?></td>
															<td style="text-align: right;"><?php echo $value['ct'] ?></td>
															<td style="text-align: right;"><?php echo $value['ket'] ?></td>
															<td style="text-align: right;"><?php echo $value['um_puasa'] ?></td>
															<td style="text-align: right;"><?php echo $value['ims'] ?></td>
															<td style="text-align: right;"><?php echo $value['imm'] ?></td>
															<td style="text-align: right;"><?php echo $value['ipet'] ?></td>
															<td style="text-align: right;"><?php echo $value['um_cabang'] ?></td>
															<td style="text-align: right;"><?php echo $value['dldobat'] ?></td>
															<td style="text-align: right;"><?php echo $value['plain'] ?></td>
															<td style="text-align: right;"><?php echo $value['tambahan_str'] ?></td>
															<td style="text-align: right;"><?php echo $value['potongan_str'] ?></td>
															<td style="text-align: right;"><?php echo $value['jml_jkn'] ?></td>
															<td style="text-align: right;"><?php echo $value['jml_jht'] ?></td>
															<td style="text-align: right;"><?php echo $value['jml_jp'] ?></td>
															<td style="text-align: right;"><?php echo $value['pduka'] ?></td>
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