<html>

<head>
	<style media="screen">
		td {
			padding: 5px;
		}
	</style>
</head>

<body>
	<?php foreach ($get_body as $key_master => $v1010): ?>
		<br>
		<div style="position:absolute;">
			<br>

		</div>
		<?php if ($key_master > 0): ?>
			<br>
		<?php endif; ?>
		<table style="width:100%; border-collapse: collapse !important; page-break-inside: avoid;">
			<tr>
				<td style="border-bottom: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; border-top: 1px solid black; width:10%; padding: 5px" rowspan="2">
					<center>
						<img style="height: auto; padding: 5px; width: 70px;" src="<?php echo base_url('assets/img/logo.png'); ?>" />
					</center>
				</td>
				<td style="border-bottom: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; width: 60%; padding: 5px" rowspan="2">
					<b style="font-size: 16px;">CV. KARYA HIDUP SENTOSA YOGYAKARTA</b><br>
					<span style="border-bottom: 1px solid black; font-size: 11.5px;">PABRIK MESIN ALAT PERTANIAAN-PENGECORAN LOGAM-DEALER KUBOTA</span>
					<br><br>
					<span style="font-size: 12px;">
						KHS PUSAT<br>
						JL. MAGELANG 144, YOGYAKARTA 55241 - INDONESIA,<br>
						Email : operator1@quick.co.id <br>
						Telp. 08002826357, Fax : (0274)563523
					</span>
				</td>
				<td colspan="2" style="text-align: center; border-bottom: 1px solid black; border-right: 1px solid black; border-top: 1px solid black;  height: 25px;">
					<?php if ($get_header[0]['TIPE'] == 'SPB'){ ?>
						<b style="font-size: 14px; padding: 10px">SURAT PENGANTAR BARANG </b>
					<?php } else { ?>
						<b style="font-size: 16px;">DELIVERY ORDER</b>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td style="border-bottom: 1px solid black; border-right: 1px solid black; width: 15%; font-size: 10px; padding: 5px; text-align: center">
					Tgl. Cetak : <br>
					<?php echo date('d-M-Y') ?>
				</td>
				<td style="border-bottom: 1px solid black; border-right: 1px solid black; width: 15%; font-size: 11px; padding: 5px; text-align: center">
					<center>
						<img style="width: 20mm; height: auto;" src="<?php echo base_url('assets/img/monitoringDOSPQRCODE/'.$get_header[0]['REQUEST_NUMBER'].'.png') ?>">
					</center>
			  		<span style="font-size: 11.5px"><?php echo $get_header[0]['REQUEST_NUMBER'] ?></span>
				</td>
			</tr>
		</table>

		<table style="width: 100%; border-collapse: collapse !important; margin-top: -1px; page-break-inside: avoid">
			<tr>
				<td style="vertical-align: top; height: 80px; width: 50%; border-bottom: 1px solid black; border-top: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px" colspan="4">
					<?php if ($get_header[0]['TIPE'] == 'DOSP') {
						echo 'Kepada Yth : <br>'.$get_header[0]['NAMA_ASAL'].'<br>';
					}
					else {
						echo $get_header[0]['NAMA_ASAL'].' ['.$get_header[0]['ORG_CODE'].']<br>';
					}
					?>
					<?php echo $get_header[0]['ALAMAT_ASAL'] ?>, <?php echo $get_header[0]['KOTA_ASAL'] ?><br><br>
					NPWP : <?php echo $get_header[0]['NPWP'] ?><br>
				</td>
				<td colspan="2" style="height: 116.3px; vertical-align: top; border-bottom: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px">
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
						<!-- <?php echo $get_header[0]['ALAMAT_KIRIM'] ?>, <?php echo $get_header[0]['KOTA_KIRIM'] ?><br><br>
						<?php
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
				<td style="vertical-align: top; border-bottom: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px; width: 10px;">
					No Order : <br>
					<?php echo $get_header[0]['NO_SO'] ?>
				</td>
				<td style="vertical-align: top; border-bottom: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px">
					Tgl. Order : <br>
					<?php echo $get_header[0]['SO_DATE'] ?>
				</td>
				<td style="vertical-align: top; border-bottom: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px; width: 7%;">
					Berat : <br>
					<br><br>
				</td>
				<td style="vertical-align: top; border-bottom: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px;">
					Syarat Pembayaran : <br>
					<?php echo $get_header[0]['BSATERM_NOMORIO'] ?>
				</td>
				<td style="vertical-align: top; border-bottom: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px; width: 30%;">
					Expedisi : <br>
					<?php echo $get_header[0]['EKSPEDISI'] ?>
				</td>
				<td style="vertical-align: top; border-bottom: 1px solid black; border-left: 1px solid black; font-size: 10px; padding: 5px; width: 20%; height: 35px; border-right: 1px solid black;">
					No Polisi : <br>
					<br>
				</td>
			</tr>
		</table>

		<!-- coba  coba  -->
		<div style="position: absolute;">
			<table style="width: 635px; margin-top: 49px;">
				<?php $no = 1; foreach ($get_body[$key_master] as $key => $gb){ ?>
					<tr>
						<td style="font-size: 9.7px; padding: 3.5px; width: 35px; text-align: center;">
							<?php echo $no+($key_master*22) ?>
						</td>
						<td style="font-size: 9.7px; padding: 3.5px; width: 60px; text-align: center;">
							<?php echo $gb['QTY_REQUESTED'] ?>
						</td>
						<td style="font-size: 9.7px; padding: 3.5px; width: 40px; text-align: center;">
							<?php echo $gb['QTY_DELIVERED'] ?>
						</td>
						<td style="font-size: 9.7px; padding: 3.5px; width: 45px; text-align: center;">
							<?php echo $gb['UOM_CODE'] ?>
						</td>
						<td style="font-size: 9.7px; padding: 3.5px; width: 120px;">
							<?php echo $gb['SEGMENT1'] ?>
						</td>
						<td style="white-space:pre-line; font-size: 9.7px; padding: 3.5px; width: 325px;">
							<?php echo $gb['DESCRIPTION'] ?>
						</td>
					</tr>
				<?php $no++; } ?>
			</table>
		</div>

		<div style="position: absolute;">
			<table style="width: 95%; margin-top: 49px; margin-left: 625px;">
				<tr>
					<td style="white-space: pre-line; font-size: 13px; padding: 3.5px; width: 60%; font-weight: bold;">
						Total Berat :<br>
						<?php echo number_format($get_berat[0]['TTL_BERAT'],3).' KG' ?>
						<!-- <?php echo '___________ KG' ?> -->
					</td>
				</tr>
			</table>
			<table style="width: 96%; margin-left: 627px; border-collapse: collapse; border-spacing: 0;">
				<tr>
				<?php $no = 0; foreach ($get_colly as $key => $gc){
					if ($no % 2 === 0) {
						echo '</tr><tr>';
					}
				?>
					<td style="font-size: 8px; padding: 3.5px; text-align: left;">
						<?php echo $gc['CNUM'].' : '.number_format($gc['BERAT'],1).' kg' ?>
					</td>
					<!-- <td style="font-size: 8px; padding: 3.5px; text-align: right; border: 1px solid red;">
						<?php echo number_format($gc['BERAT'],1).' KG' ?>
					</td>				 -->
				<?php $no++; } ?>
				</tr>
			</table>
		</div>


		<table style="width: 100%; border-collapse: collapse !important; margin-top: -1px; page-break-inside: avoid">
			<thead>
				<tr>
					<td rowspan="2" style="width: 5%; border-left: 1px solid black; border-bottom: 1px solid black; border-top: 1px solid black; font-size: 10px; padding: 5px">
						<center>No</center>
					</td>
					<td colspan="2" style="border-left: 1px solid black; border-bottom: 1px solid black; font-size: 10px; padding: 5px; border-top: 1px solid black;">
						<center>Qty</center>
					</td>
					<td rowspan="2" style="width: 5%; border-left: 1px solid black; border-bottom: 1px solid black; font-size: 10px; padding: 5px; border-top: 1px solid black;">
						<center>Satuan</center>
					</td>
					<td rowspan="2" style="width: 16%; border-left: 1px solid black; border-bottom: 1px solid black; font-size: 10px; padding: 5px; border-top: 1px solid black;">
						<center>Kode Barang</center>
					</td>
					<td rowspan="2" style="width: 44%; border-left: 1px solid black; border-bottom: 1px solid black; font-size: 10px; padding: 5px; border-top: 1px solid black;">
						<center>Nama Barang</center>
					</td>
					<td rowspan="2" style="width: 15.5%; border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black; font-size: 10px; padding: 5px; border-top: 1px solid black;">
						<center>Catatan</center>
					</td>
				</tr>
				<tr>
					<td style="width: 7.5%; border-left: 1px solid black; border-bottom: 1px solid black; font-size: 10px; padding: 5px">
						<center>Diminta</center>
					</td>
					<td style="width: 6%; border-left: 1px solid black; border-bottom: 1px solid black; font-size: 10px; padding: 5px">
						<center>Dikirim</center>
					</td>
				</tr>
			</thead>
			<tbody style="vertical-align: top!important;">
				<tr style="border-bottom: 1px solid black;">
					<td style="vertical-align: top; border-right: 1px solid black; border-left: 1px solid black; height: <?php echo $key_master > 0 ? '521px' : '512px'?>; font-size: 10px; padding: 5px;">

					</td>
					<td style="vertical-align: top; border-right: 1px solid black; font-size: 10px; padding: 5px">

					</td>
					<td style="vertical-align: top; border-right: 1px solid black; font-size: 10px; padding: 5px">

					</td>
					<td style="vertical-align: top; border-right: 1px solid black; font-size: 10px; padding: 5px">

					</td>
					<td style="vertical-align: top; border-right: 1px solid black; font-size: 10px; padding: 5px">

					</td>
					<td style="vertical-align: top; border-right: 1px solid black; font-size: 10px; padding: 5px">

					</td>
					<td style="vertical-align: top; border-right: 1px solid black; font-size: 11.5px; padding: 5px;">

					</td>
				</tr>
			</tbody>
		</table>
		<br>
	<?php endforeach; ?>

</body>
</html>
