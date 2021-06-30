<html>
	<head>
		<style media="screen">
			td {
				padding: 5px;
			}
		</style>
	</head>

	<body>
		<?php //$a=0; while ($a < $total_hal) { ?>
			<?php foreach ($total_hal as $key2 => $body_){ ?>

			<br>
			<div style="position: absolute;">
				<br>

			</div>

			<!-- Header -->
			<table style="width: 100%; border-collapse: collapse !important; page-break-inside: avoid">
				<tr>
					<td style="border-bottom: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; border-top: 1px solid black; width:10%; padding: 5px" rowspan="2">
						<center>
							<img style="height: auto; padding: 5px; width: 70px;" src="<?php echo base_url('assets/img/logo.png'); ?>" />
						</center>
					</td>
					<td style="border-bottom: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; width: 60%; padding: 5px" rowspan="2">
						<b style="font-size: 16px;">CV. KARYA HIDUP SENTOSA YOGYAKARTA</b><br>
						<span style="border-bottom: 1px solid black; font-size: 12px;">PABRIK MESIN ALAT PERTANIAAN-PENGECORAN LOGAM-DEALER KUBOTA</span>
						<br><br>
						<span style="font-size: 12px;">
							KHS PUSAT<br>
							JL. MAGELANG 144, YOGYAKARTA 55241 - INDONESIA,<br>
							Email : operator1@quick.co.id <br>
							Telp. 08002826357, Fax : (0274)563523
						</span>
					</td>
					<td colspan="2" style="text-align: center; border-bottom: 1px solid black; border-right: 1px solid black; border-top: 1px solid black;  height: 25px;">
						<b style="font-size: 24px; padding: 10px">PACKING LIST</b>
					</td>
					<tr>
					<td style="border-bottom: 1px solid black; border-right: 1px solid black; width: 15%; font-size: 10px; padding: 5px; text-align: center">
						Tgl. Cetak : <br>
						<?php echo date('d-M-Y') ?>
					</td>
					<td style="border-bottom: 1px solid black; border-right: 1px solid black; width: 15%; font-size: 11px; padding: 5px; text-align: center">
						<center>
							<img style="width: 20mm; height: auto;" src="<?php echo base_url('assets/img/monitoringDOSPQRCODE/'.$get_header[0]['REQUEST_NUMBER'].'.png') ?>">
						</center>
				  		<span style="font-size: 11.5px"><?php echo $get_header[0]['TIPE'].' '.$get_header[0]['REQUEST_NUMBER'] ?></span>
					</td>
				</tr>
				</tr>
			</table>


			<!-- Alamat -->
			<table style="width: 100%; border-collapse: collapse !important; margin-top: -1px; page-break-inside: avoid;">
				<tr>
					<td colspan="4" style="vertical-align: top; width: 367px; height: 80px; border-bottom: 1px solid black; border-top: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px">
						<?php if ($get_header[0]['TIPE'] == 'DOSP') {
							echo 'Kepada Yth : <br>'.$get_header[0]['NAMA_ASAL'].'<br>';
						}
						else {
							echo $get_header[0]['NAMA_ASAL'].' ['.$get_header[0]['ORG_CODE'].']<br>';
						}
						?>
						<?php echo $get_header[0]['ALAMAT_ASAL'] ?>, <?php echo $get_header[0]['KOTA_ASAL'] ?><br><br>
					</td>
					<td colspan="2" style="height: 96.3px; vertical-align: top; border-bottom: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px">
						<?php if ($get_header[0]['TIPE'] == 'SPB'){ ?>
							Kepada Yth : <br>
							<?php echo $get_header[0]['NAMA_KIRIM'].' ['.$get_header[0]['ORGANIZATION_CODE'].']' ?> <br>
							<?php echo $get_header[0]['ALAMAT_KIRIM'] ?>, <?php echo $get_header[0]['KOTA_KIRIM'] ?><br><br>
							Dikirim Kepada : <br>
							<?php
								$arr = explode("#", $get_header[0]['LAIN']); //jika mau ganti baris gunakan tanda # (pagar)
								foreach($arr as $i) {
									echo $i.'<br>';
								}
							?>
						<?php } else { ?>
							Dikirim Kepada : <br>
							<?php echo $get_header[0]['NAMA_KIRIM'] ?> <br>
							<?php if (!empty($get_header[0]['LAIN'])) {
									$arr = explode("#", $get_header[0]['ALAMAT_KIRIM']); //jika mau ganti baris gunakan tanda # (pagar)
									foreach($arr as $i) {
										echo $i.'<br>';
									}
								}
								else {
									echo $get_header[0]['ALAMAT_KIRIM'].', '.$get_header[0]['KOTA_KIRIM'];

								}
							?>
							<!-- <?php
								$arr = explode("#", $get_header[0]['LAIN']); //jika mau ganti baris gunakan tanda # (pagar)
								foreach($arr as $i) {
									echo $i.'<br>';
								}
							?> -->
							<br><br>
						<?php } ?>
					</td>
				</tr>
				<tr style="text-align: center">
					<td colspan="2" style="vertical-align: middle; height: 35px; border-bottom: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px">
						<!-- Berat Estimasi : <?php echo number_format($total_berat[0]['TTL'],3).' '.$total_berat[0]['WEIGHT_UOM_CODE'] ?> -->
						Berat Estimasi : <?php echo '____________ '.$total_berat[0]['WEIGHT_UOM_CODE'] ?>
					</td>
					<td colspan="2" style="vertical-align: middle; height: 35px; border-bottom: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; font-size: 10px; padding: 5px">
						Total Packing : <?php echo $total_colly ?>
					</td>
					<td colspan="2" style="vertical-align: middle; height: 35px; border-bottom: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; font-size: 10px; padding: 5px">
						Ekspedisi : <?php echo $get_header[0]['EKSPEDISI'] ?>
					</td>
				</tr>
			</table>


			<!-- Isi body -->
			<div style="position: absolute;">
				<table style="margin-top: 25px;">
					<?php $no = 1; foreach ($body_ as $key => $gb){ ?>
						<tr>
							<?php
								if ($gb['COLLY_NUMBER'] != $flag) {
									// echo $gb['COLLY_NUMBER'];
									$flag = $gb['COLLY_NUMBER'];
									foreach ($get_colly as $key => $gc) {
										$total[$gc['COLLY_NUMBER']] = $gc['TTL_ITEM'];
									}
									$rowval = $total[$flag]+1;
							?>
									<td rowspan="<?php echo $rowval ?>" style="font-size: 14px; font-weight: bold; padding: 3.5px; width: 127px; text-align: center; vertical-align: top;">
										<?php echo $gb['COLLY_NUMBER'] ?>
										<!-- QRCODE -->
										<!-- <center>
											<img style="width: 20mm; height: auto;" src="<?php echo base_url('assets/img/monitoringDOSPQRCODE/'.$gb['COLLY_NUMBER'].'.png') ?>">
											<span style="font-size: 11.5px"><?php echo $gb['COLLY_NUMBER'] ?></span>
										</center> -->
									</td>
								<?php	}elseif($jumlah_colly == 1 && $key2 != 0) { ?>
										<td style="font-size: 14px; font-weight: bold; padding: 3.5px; width: 127px; text-align: center; vertical-align: top;">

										</td>
								<?php }?>
							<td style="font-size: 9.7px;  padding: 3.5px; width: 48px; text-align: center; vertical-align: top;">
								<?php echo $gb['QUANTITY'] ?>
							</td>
							<td style="font-size: 9.7px; padding: 3.5px; width: 57px; text-align: center; vertical-align: top;">
								<?php echo $gb['UOM'] ?>
							</td>
							<?php if ($gb['ITEM'] == 'TOTAL') {
									$bold = 'font-weight: bold;';
									$size = 'font-size: 10.5px;';
									$garis = '_________ KG';
								}
								else {
									$bold = '';
									$size = 'font-size: 9.7px;';
									$garis = '';
								}
							?>
							<td style="<?php echo $size.$bold ?> padding: 3.5px; width: 132px; vertical-align: top;">
								<?php echo $gb['ITEM'] ?>
							</td>
							<td style="white-space:pre-line; font-size: 9.7px; margin-left: 2px; margin-right: 2px; padding: 3.5px; width: 293px; vertical-align: top;">
								<?php echo $gb['DESCRIPTION'] ?>
							</td>
							<td style="white-space:pre-line; font-size: 9.7px; <?php echo $size.$bold ?> padding: 3.5px; width: 75px; text-align: right; vertical-align: top;">
								<!-- <?php echo number_format($gb['BERAT'],3) ?> -->
								<?php echo $garis ?>
							</td>
							<td style="white-space:pre-line; font-size: 9.7px; <?php echo $size.$bold ?> padding: 3.5px; width: 60px; text-align: left; vertical-align: top;">

							</td>
						</tr>
					<?php $no++; } ?>
				</table>
			</div>


			<!-- Tabel kerangka body -->
			<table style="width: 100%; border-collapse: collapse !important; margin-top: -1px; page-break-inside: avoid;">
				<thead>
					<tr>
						<td style="width: 15%; border-left: 1px solid black; border-bottom: 1px solid black; border-top: 1px solid black; font-size: 10px; padding: 5px">
							<center>No Packing</center>
						</td>
						<td style="width: 5%; border-left: 1px solid black; border-bottom: 1px solid black; font-size: 10px; padding: 5px; border-top: 1px solid black;">
							<center>Qty</center>
						</td>
						<td style="width: 5%; border-left: 1px solid black; border-bottom: 1px solid black; font-size: 10px; padding: 5px; border-top: 1px solid black;">
							<center>Satuan</center>
						</td>
						<td style="width: 15%; border-left: 1px solid black; border-bottom: 1px solid black; font-size: 10px; padding: 5px; border-top: 1px solid black;">
							<center>Kode Barang</center>
						</td>
						<td style="width: 35%; border-left: 1px solid black; border-bottom: 1px solid black; font-size: 10px; padding: 5px; border-top: 1px solid black;">
							<center>Nama Barang</center>
						</td>
						<td style="width: 15%; border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black; font-size: 10px; padding: 5px; border-top: 1px solid black;">
							<center>Berat Estimasi</center>
						</td>
					</tr>
				</thead>
				<tbody style="vertical-align: top!important;">
					<tr style="border-bottom: 1px solid black;">
						<td style="vertical-align: top; border-right: 1px solid black; border-left: 1px solid black; height: 529px; font-size: 10px; padding:5px">

						</td>
						<td style="vertical-align:top;border-right:1px solid black;font-size:10px;padding:5px">
							<center>

							</center>
						</td>
						<td style="vertical-align:top;border-right:1px solid black;font-size:10px;padding:5px">
							<center>

							</center>
						</td>
						<td style="vertical-align:top;border-right:1px solid black;font-size:10px;padding:5px">
							<center>

							</center>
						</td>
						<td style="vertical-align:top;border-right:1px solid black;font-size:10px;padding:5px">

						</td>
						<td style="vertical-align:top;border-right:1px solid black;font-size:10px;padding:5px">

						</td>
					</tr>
				</tbody>
			</table>

			<!-- Footer -->
			<table style="width: 100%; border-collapse: collapse !important; margin-top: -1px; page-break-inside: avoid;">
				<tr style="width: 100%">
					<td rowspan="2" style="white-space: pre-line; vertical-align: top; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px">
						Catatan : <br>
						<?php echo $get_header[0]['CATATAN'] ?>
					</td>
					<td colspan="2" style="vertical-align: top; border-right: 1px solid black; border-top: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px; height: 20px!important; width: 300px">
						Gudang
					</td>
				</tr>
				<tr>
					<td rowspan="2" style="vertical-align: top; width: 100px; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px;">
						Tgl. <?php echo $get_header[0]['ASSIGN_DATE'] ?><br>
						Pengawas : <br>
						<br><br><br><br><br>
						<!-- <?php echo $get_header[0]['ASSIGNER_NAME'] ?> -->
						<?php echo 'REYNALDI, NELSON'; ?>
					</td>
					<td rowspan="2" style="vertical-align: top; width: 100px; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; font-size: 10px; padding: 5px">
						Tgl. <br>
						Petugas Packing : <br>
						<br><br><br><br><br>
						<!-- <?php echo $get_header[0]['CATATAN'] ?> -->
					</td>
				</tr>
			</table>
		<?php } ?>
	</body>
</html>
