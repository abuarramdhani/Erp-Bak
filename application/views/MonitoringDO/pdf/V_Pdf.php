<html>

<head>
	<style media="screen">
		/* body{
			border: 1px solid black !important;
		} */
		td {
			padding: 5px;
		}
	</style>
</head>

<body>
	<?php
		if (sizeof($body_shelter) > sizeof($serial_shelter)) {
			$who = $body_shelter;
		}else {
			$who = $serial_shelter;
		}
	?>
	<?php foreach ($who as $key_master_who => $value_master):
		if ($key_master_who > 0) {
			echo "<pagebreak />";
		}
	?>

	<br>
	<div style="position: absolute;">
		<br>
	</div>
	<table style="width: 100%; border-collapse: collapse !important; page-break-inside: avoid;">
		<tr>
			<td style="border-bottom: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; border-top: 1px solid black; width: 10%; padding: 5px;" rowspan="2">
				<center>
					<img style="height: auto; padding: 5px; width: 70px;" src="<?php echo base_url('assets/img/logo.png'); ?>" />
				</center>
			</td>
			<td style="border-bottom: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; width: 60%; padding: 5px;" rowspan="2">
				<b style="font-size: 16px;">CV. KARYA HIDUP SENTOSA YOGYAKARTA</b><br>
				<span style="border-bottom: 1px solid black; font-size: 12px;">PABRIK MESIN ALAT PERTANIAAN-PENGECORAN LOGAM-DEALER KUBOTA</span><br><br>
				<span style="font-size: 12px;">
					KHS PUSAT<br>
					JL. MAGELANG 144, YOGYAKARTA 55241 - INDONESIA,<br> Email : operator1@quick.co.id <br>
					Telp. 08002826357, Fax : (0274)563523
				</span>
			</td>
			<td colspan="2" style="text-align: center; border-bottom: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; height: 25px;">
				<?php if (!empty($cek_spb_do[0]['DELIVERY_TYPE'])){ ?>
				<b style="font-size: 14px; padding: 10px;">SURAT PENGANTAR BARANG </b>
				<?php }else { ?>
				<b style="font-size: 16px;">DELIVERY ORDER</b>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<td style="border-bottom: 1px solid black; border-right: 1px solid black; width: 15%; font-size: 10px; padding: 5px; text-align:center;">
				Tgl. Cetak : <br> <?php echo date('d-M-Y') ?>
			</td>
			<td style="border-bottom: 1px solid black; border-right: 1px solid black; width: 15%; font-size: 11px; padding: 5px; text-align:center;">
				<center>
					<img style="width: 19.5mm; height: auto;" src="<?php echo base_url('assets/img/monitoringDOQRCODE/'.$get_header[0]['REQUEST_NUMBER'].'.png') ?>">
				</center>
				<span style="font-size: 13.5px;"><?php echo $get_header[0]['REQUEST_NUMBER'] ?></span>
			</td>
		</tr>
	</table>
	<table style="width: 100%; border-collapse: collapse !important; margin-top: -1px; page-break-inside: avoid;">
		<tr>
			<td style="vertical-align: top; height: 80px; width: 50%; border-bottom: 1px solid black; border-top: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px;" colspan="4">
				<?php echo !empty($cek_spb_do[0]['DELIVERY_TYPE'])?'<br>':'Kepada Yth : <br>' ?>
				<?php echo $get_header[0]['NAMA_ASAL'] ?> <br>
				<?php echo $get_header[0]['ALAMAT_ASAL'] ?>, <?php echo $get_header[0]['KOTA_ASAL'] ?><br>
				NPWP : <?php echo $get_header[0]['NPWP'] ?><br>

				<?php if (!empty($get_header[0]['ALAMAT_BONGKAR'])){ ?>
				Kepada Yth : <br>
				<?php echo $get_header[0]['NAMA_KIRIM'] ?> <br>
				<?php echo $get_header[0]['ALAMAT_KIRIM'] ?>, <?php echo $get_header[0]['KOTA_KIRIM'] ?><br>
				<?php
						if (strlen($get_header[0]['ALAMAT_KIRIM']) < 60) {
							echo "<br>";
						}
					 ?>
				<?php }else{?>
				<?php echo $get_header[0]['ALAMAT_BONGKAR'] ?> <br>
				<?php } ?>

			</td>
			<td colspan="2" style="height: 116.3px; vertical-align: top; border-bottom: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px;">
				<?php
					if (!empty($cek_spb_do[0]['DELIVERY_TYPE'])) {
						if (empty($get_header[0]['ALAMAT_BONGKAR'])) {
							echo 'Kepada Yth : <br>';
						}
					}else{
						echo 'Dikirim Kepada : <br>';
					}
				?>
				<?php if (!empty($get_header[0]['NOTES'])){ ?>
				<br><br><br>
				<?php
						$arr = explode("#", $get_header[0]['LAIN']); //jika mau ganti baris gunakan tanda # (pagar)
						foreach($arr as $i) {
							echo $i.'<br>';
						}
					?>
				<?php }else {?>

				<?php if (!empty($get_header[0]['ALAMAT_BONGKAR'])){ ?>
				<?php echo $get_header[0]['ALAMAT_BONGKAR'] ?> <br><br>
				<?php }else{?>
				<?php echo $get_header[0]['NAMA_KIRIM'] ?> <br>
				<?php echo $get_header[0]['ALAMAT_KIRIM'] ?>, <?php echo $get_header[0]['KOTA_KIRIM'] ?><br>
				<?php
							if (strlen($get_header[0]['ALAMAT_KIRIM']) < 60) {
								echo "<br>";
							}
						 ?>
				<?php } ?>

				<?php echo !empty($cek_spb_do[0]['DELIVERY_TYPE'])?'Dikirim Kepada :  <br>':'<br> ' ?>
				<?php
						$arr = explode("#", $get_header[0]['LAIN']); //jika mau ganti baris gunakan tanda # (pagar)
						foreach($arr as $i) {
							echo $i.'<br>';
						}
					?>
				<?php } ?>
			</td>
		</tr>
		<tr style="text-align: center">
			<td style="vertical-align: top; border-bottom: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px; width: 10px;">
				No Order : <br> <?php echo $get_header[0]['NO_SO'] ?>
			</td>
			<td style="vertical-align: top; border-bottom: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px;">
				Tgl. Order : <br>
			</td>
			<td style="vertical-align: top; border-bottom: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px;">
				Berat : <br><br>
			</td>
			<td style="vertical-align: top; border-bottom: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px;">
				Syarat Pembayaran : <br><br>
			</td>
			<td style="vertical-align: top; border-bottom: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px; width: 30%;">
				Expedisi : <br><?php echo $get_header[0]['EKSPEDISI'] ?>
			</td>
			<td style="vertical-align: top; border-bottom: 1px solid black; border-left: 1px solid black;border-right: 1px solid black; font-size: 10px; padding: 5px; height: 35px; width: 20%;">
				No Polisi : <br><?php echo $get_header[0]['PLAT_NUMBER'] ?><br>
			</td>
		</tr>
	</table>
	<!-- item -->
	<div style="position: absolute;">
		<table style="width: 81.5%; margin-top: 40px;">
			<?php if ($key_master_who == 0): ?>
				<tr>
					<td style="font-size: 9.7px; padding: 3.5px; width: 7%; text-align: center;"></td>
					<td style="font-size: 9.7px; padding: 3.5px; width: 10%; text-align: center;"></td>
					<td style="font-size: 9.7px; padding: 3.5px; width: 8%; text-align: center;"></td>
					<td style="font-size: 9.7px; padding: 3.5px 3.5px 3.5px 10px; width: 7%; text-align: left;">
						<?php echo $get_header[0]['UOM'] ?>
					</td>
					<td style="font-size: 9.7px; padding: 3.5px 3.5px 3.5px 8px; width: 20.5%;">
						<?php echo $get_header[0]['ITEM'] ?>
					</td>
					<td colspan="2" style="font-size: 9.7px; padding: 3.5px; width: 49.5%; white-space: pre-line;">
						<?php echo $get_header[0]['DESCRIPTION'] ?>
					</td>
				</tr>
			<?php endif; ?>
			<?php $no = 1; foreach ($body_shelter[$key_master_who] as $key => $gb){ ?>
			<tr>
				<td style="font-size: 9.7px; padding: 3.5px; width: 7%; text-align: center;">
					<?php echo $no+($key_master_body*22) ?>
				</td>
				<td style="font-size: 9.7px; padding: 3.5px; width: 10%; text-align: center;">
					<?php echo $gb['REQUIRED_QTY'] ?>
				</td>
				<td style="font-size: 9.7px; padding: 3.5px; width: 8%; text-align: center;">
					<?php echo $gb['TRANSACT_QTY'] ?>
				</td>
				<td style="font-size: 9.7px; padding: 3.5px 3.5px 3.5px 10px; width: 7%; text-align: left;">
					<?php echo $gb['UOM_CODE'] ?>
				</td>
				<td style="font-size: 9.7px; padding: 3.5px 3.5px 3.5px 8px; width: 20.5%;">
					<?php echo $gb['ITEM'] ?>
				</td>
				<td style="font-size: 9.7px; padding: 3.5px; width: 5%; border: 1px solid black;"></td>
				<td style="font-size: 9.7px; padding: 3.5px; width: 49.5%; white-space: pre-line;">
					<?php echo $gb['DESCRIPTION'] ?>
				</td>
			</tr>
			<?php $no++; } ?>
		</table>
	</div>
	<div style="position: absolute;">
		<div style="margin-top: 470px; margin-left: 297px;">
			<!-- <watermarktext content="HIAHIAHIA" alpha="0.4" /> -->
			<h4 style="color: black; alpha: 0.4" alpha="0.4">
				<?php
			$arr = explode("#", $get_header[0]['NOTES']); //jika mau ganti baris gunakan tanda # (pagar)
						foreach($arr as $i) {
							echo $i.'<br>';
						}
		 ?>
			</h4>
		</div>
	</div>
	<table style="border-collapse: collapse !important; margin-top: -1px; page-break-inside: avoid;">
		<thead>
			<tr>
				<td rowspan="2" style="width: 5%; border-left: 1px solid black; border-bottom: 1px solid black; border-top: 1px solid black;font-size: 10px; padding: 5px;">
					<center>No</center>
				</td>
				<td colspan="2" style="border-left: 1px solid black; border-bottom: 1px solid black; border-top: 1px solid black; font-size: 10px; padding: 5px;">
					<center>Qty</center>
				</td>
				<td rowspan="2" style="width: 5%; border-left: 1px solid black; border-bottom: 1px solid black; border-top: 1px solid black;font-size: 10px; padding: 5px;">
					<center>Satuan</center>
				</td>
				<td rowspan="2" style="width: 14%; border-left: 1px solid black; border-bottom: 1px solid black; border-top: 1px solid black;font-size: 10px; padding: 5px;">
					<center>Kode Barang</center>
				</td>
				<td rowspan="2" style="width: 39%; border-left: 1px solid black; border-bottom: 1px solid black; border-top: 1px solid black;font-size: 10px; padding: 5px;">
					<center>Nama Barang</center>
				</td>
				<td rowspan="2" style="width: 23.5%; border: 1px solid black; font-size: 10px; padding: 5px;">
					<center>Nomor Barang</center>
				</td>
			</tr>
			<tr>
				<td style="width: 7.5%; border-left: 1px solid black; border-bottom: 1px solid black; font-size: 10px; padding: 5px;">
					<center>Diminta</center>
				</td>
				<td style="width: 6%; border-left: 1px solid black; border-bottom: 1px solid black; font-size: 10px; padding: 5px;">
					<center>Dikirim</center>
				</td>
			</tr>
		</thead>
		<tbody style="vertical-align:top!important;">
			<tr style="border-bottom:1px solid black;">
				<td style="vertical-align: top; border-right: 1px solid black; border-left: 1px solid black; height: 560px; font-size: 10px; padding: 5px;">
					<center>

					</center>
				</td>
				<td style="vertical-align: top; border-right: 1px solid black; font-size: 10px; padding: 5px;">
					<center>

					</center>
				</td>
				<td style="vertical-align: top; border-right: 1px solid black; font-size: 10px; padding: 5px;">
					<center>

					</center>
				</td>
				<td style="vertical-align: top; border-right: 1px solid black; font-size: 10px; padding: 5px;">
					<center>

					</center>
				</td>
				<td style="vertical-align: top; border-right: 1px solid black; font-size: 10px; padding: 5px;">

				</td>
				<td style="vertical-align: top; border-right: 1px solid black; font-size: 10px; padding: 5px;">

				</td>
				<td style="vertical-align: top; font-size: 11.5px; padding: 5px; border-right: 1px solid black;">
					<center>
						<?php if (!empty($get_serial)){ ?>
						<table style="border-collapse: collapse !important; margin-top: -30px !important;">
							<thead>
								<tr>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td style="padding: 5px; margin-top: 20px; font-size: 11.5px;">
										<br>
										<?php
									 	// $size = sizeof($get_serial) > 87 ? '9.6px' : '11.5px';
									  foreach ($header_sub as $key => $h) {
										foreach ($check_header_sub as $key2 => $h2) {
											$explode = explode(' ', $h2);
											if ($h == $explode[0] && !empty($serial_shelter[$key_master_who])) {
												echo '<div style="width:250px;">';
												$key_ok = 0;
												foreach ($serial_shelter[$key_master_who] as $key3 => $h3) {
													if ($h3['DESCRIPTION'] == $h2) {
														if ($key_ok == 0) {
															echo '<br /><b style="font-size:11.5px;">'."$h".'</b><br>';
														}
														echo '<span style = "font-size:11.5px;">'.$h3['SERIAL_NUMBER'].', </span>';
														$key_ok++;
													}
												}
												echo "</div>";
											}
										}
									}
									?>
									</td>
								</tr>
							</tbody>
						</table>
						<center>
							<?php }else {
					echo "";
				} ?>
							<!-- <?php
				// $gass = 0; foreach ($get_body as $key => $gb){
				// 	$gass += strlen($gb['DESCRIPTION']);
				// }
				// if ($gass > 600) {
				// }
				?> -->
				</td>
			</tr>
		</tbody>
	</table>
	<br>
	<?php endforeach; ?>
</body>
</html>