<style type="text/css">
	.btn-cm {
		background-color: #4bcffa;
		color: white;
	}
	.btn-cm:hover {
		color: #4bcffa !important;
		background-color: white !important;
	}
</style>
<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid" style="margin-bottom: 0px">
							<div class="box-header with-header">
								<div class="row">
									<div class="col-lg-5">
									<?php echo "Pesanan Katering <br>Tanggal : ".date("Y-m-d",strtotime($tanggal))." Shift : ".($shift == '1' ? 'Shift Satu dan Umum' : ($shift == '2' ? 'Shift Dua' : ($shift == '3' ? 'Shift Tiga' : 'Tidak Diketahui')))." Lokasi : ".($lokasi == '1' ? 'Yogyakarta' :($lokasi == '2' ? 'Tuksono' : 'Tidak Diketahui')) ?>
									</div>
									<div class="col-lg-7 text-right">
										<button class="btn btn-cm" id="btn-CM-HitungPesanan-CopyPembagian">Copy Pembagian</button>	
										<button class="btn btn-cm" id="btn-CM-HitungPesanan-SimpanMakan">Simpan Makan</button>	
										<button class="btn btn-cm" id="btn-CM-HitungPesanan-SimpanSnack">Simpan Snack</button>	
										<button class="btn btn-cm" id="btn-CM-HitungPesanan-CetakMakan">Cetak Makan</button>	
										<button class="btn btn-cm" id="btn-CM-HitungPesanan-CetakSnack">Cetak Snack</button>	
									</div>
								</div>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-sm-9" style="height: 450px;overflow-x: scroll;">
										<?php if (isset($pembagian) and !empty($pembagian)) { 
											?>
											<table border="1" style="width: 100%;border-collapse: collapse;" id="CateringHitungPesananLihatTabel">
											<?php 
											foreach ($pembagian as $bagi) {
												?>
												<tr>
													<td colspan="7"><?php echo "Nama Katering : ".$bagi['fs_nama_katering'] ?></td>
												</tr>
												<tr>
													<td style="text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black">No.</td>
													<td style="text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black">Tempat Makan</td>
													<td style="text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black">Staff</td>
													<td style="text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black">Non Staff</td>
													<td style="text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black">Tambah</td>
													<td style="text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black">Kurang</td>
													<td style="text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black">Jumlah</td>
												</tr>
												<?php 
												$nomor = 1;
												foreach ($bagi['data'] as $data) {
													if ($data['pengurangan'] !== "0" && $data['tambahan'] !== "0") {
														$warna = "green";
													}elseif ($data['pengurangan'] !== "0") {
														$warna = "red";
													}elseif ($data['tambahan'] !== "0") {
														$warna = "blue";
													}else{
														$warna = "black";
													}
													?>
													<tr data-urutan="<?php echo $bagi['urutan'] ?>" data-katering="<?php echo $data['tempat_makan'] ?>">
														<td style="text-align: center;color: <?php echo $warna ?>"><?php echo $nomor ?></td>
														<td style="text-align: left;padding-left: 20px;color: <?php echo $warna ?>"><?php echo $data['tempat_makan'] ?></td>
														<td style="text-align: right;padding-right: 20px;color: <?php echo $warna ?>"><?php echo $data['staff'] ?></td>
														<td style="text-align: right;padding-right: 20px;color: <?php echo $warna ?>"><?php echo $data['nonstaff'] ?></td>
														<td style="text-align: right;padding-right: 20px;color: <?php echo $warna ?>"><?php echo $data['tambahan'] ?></td>
														<td style="text-align: right;padding-right: 20px;color: <?php echo $warna ?>"><?php echo $data['pengurangan'] ?></td>
														<td style="text-align: right;padding-right: 20px;color: <?php echo $warna ?>"><?php echo $data['jumlah_pesan'] ?></td>
													</tr>
													<?php 
													$nomor++;
												}
												?>
												<tr>
													<td colspan="6" style="text-align: right;padding-right: 20px;">Total : </td>
													<td style="text-align: right;padding-right: 20px;"><?php echo $bagi['jumlah_total'] ?></td>
												</tr>
												<tr>
													<td colspan="7">&nbsp;</td>
												</tr>
												<?php 
											}
											?>
											</table>
											<?php 
										}else{
											echo "<h1>Tidak Ditemukan Data</h1>";
										} ?>
									</div>
									<div class="col-sm-3" style="height: 450px;overflow-x: scroll;">
										<div class="box box-solid box-info">
											<div class="box-body" id="CateringHitungPesananLihatJumlah">
												<?php 
												for ($i=1; $i <= 10; $i++) { 
													?>
													<div class="row">
														<div class="col-lg-12">
															<label class="control-label">Katering <?php echo $i ?></label>
															<div class="col-lg-9" style="padding: 0%">
																<input type="text" class="form-control input-sm" name="txtKateringTampilNama<?php echo $i ?>" value="<?php echo isset($pembagian[$i-1]['fs_nama_katering']) ? $pembagian[$i-1]['fs_nama_katering'] : '' ?>" <?php echo isset($pembagian[$i-1]['fs_nama_katering']) ? '' : 'disabled' ?> >
															</div>
															<div class="col-lg-3" style="padding: 0%">
																<input type="text" class="form-control input-sm" name="txtKateringTampilJumlah<?php echo $i ?>" value="<?php echo isset($pembagian[$i-1]['fs_nama_katering']) ? $pembagian[$i-1]['jumlah_total'] : '' ?>" <?php echo isset($pembagian[$i-1]['fs_nama_katering']) ? '' : 'disabled' ?> >
															</div>
														</div>
													</div>
													<?php 
												}
												?>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-4" style="color: blue"> 
										<span class="fa fa-square"></span> Ada Penambahan
									</div>
									<div class="col-sm-4" style="color: red">
										<span class="fa fa-square"></span> Ada Pengurangan
									</div>
									<div class="col-sm-4" style="color: green">
										<span class="fa fa-square"></span> Ada Penambahan dan Pengurangan
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

<div class="modal fade" tabindex="-1" role="dialog" id="CateringHitungPesananLihatModal">
	<div class="modal-dialog modal-sm" role="document">
    	<div class="modal-content">
    		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Ganti Katering</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<form class="form-horizontal">
							<div class="form-group">
								<label class="control-label col-lg-4">Tempat Makan</label>
								<div class="col-lg-8">
									<input type="text" id="txtCateringHitungPesananTempatmakan" class="form-control" disabled>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-4">Urutan</label>
								<div class="col-lg-8">
									<select class="select2" id="slcCateringHitungPesananUrutan" style="width: 100%">
										<?php 
											if (isset($pembagian) and !empty($pembagian)) {
												foreach ($pembagian as $bg) {
													?>
													<option value="<?php echo $bg['urutan'] ?>"><?php echo $bg['urutan']." - ".$bg['fs_nama_katering'] ?></option>
													<?php 
												}
											}
										?>
									</select>
								</div>
							</div>
							<input type="hidden" id="txtCateringHitungPesananTanggal" value="<?php echo $tanggal ?>">
							<input type="hidden" id="txtCateringHitungPesananLokasi" value="<?php echo $lokasi ?>">
							<input type="hidden" id="txtCateringHitungPesananShift" value="<?php echo $shift ?>">
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-lg-12">
						<?php 
						if($tanggal == date('Y-m-d')){
							?>
							<button type="button" class="btn btn-primary" id="btnCateringHitungPesananSimpan">Simpan</button>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="mdl-CM-HitungPesanan-CopyPembagian">
	<div class="modal-dialog modal-sm" role="document">
    	<div class="modal-content">
    		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Copy Pembagian</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<form class="form-horizontal">
							<div class="form-group">
								<label class="control-label col-lg-4">Tanggal</label>
								<div class="col-lg-8">
									<input type="text" id="txt-CM-HitungPesanan-CopyPembagian-Tanggal" class="form-control" placeholder="Pilih Tanggal">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-lg-12">
						<?php 
						if($tanggal == date('Y-m-d')){
							?>
							<button type="button" class="btn btn-primary" id="btn-CM-HitungPesanan-CopyPembagian-Proses">Proses</button>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>