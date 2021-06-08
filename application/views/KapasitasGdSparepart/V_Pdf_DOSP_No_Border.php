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
		<?php if ($key_master > 0): ?>
			<br>
		<?php endif; ?>
		<table style="width:100%; border-collapse: collapse !important; page-break-inside: avoid;">
			<tr>
				<td style="border-bottom: 1px solid white; border-right: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; width:10%; padding: 5px" rowspan="2">

				</td>
				<td style="border-bottom: 1px solid white; border-right: 1px solid white; border-top: 1px solid white; width: 60%; padding: 5px" rowspan="2">

				</td>
				<td colspan="2" style="text-align: center; border-bottom: 1px solid white; border-right: 1px solid white; border-top: 1px solid white;  height: 25px;">

				</td>
			</tr>
			<tr>
				<td style="border-bottom: 1px solid white; border-right: 1px solid white; width: 15%; font-size: 10px; padding: 5px; text-align: center">

				</td>
				<td style="border-bottom: 1px solid white; border-right: 1px solid white; width: 15%; font-size: 11px; padding: 5px; text-align: center;padding-left:5mm">
						<br><br>
			  		<span style="font-size: 11.5px"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <?php echo $get_header[0]['REQUEST_NUMBER'] ?></span>
				</td>
			</tr>
		</table>

		<table style="width: 100%; border-collapse: collapse !important; margin-top: -1px; page-break-inside: avoid">
			<tr>
				<td style="vertical-align: top; height: 95px; width: 55%; border-bottom: 1px solid white; border-top: 1px solid white; border-left: 1px solid white; font-size: 10px; padding: 5px 5px 5px 15px;" colspan="4">
					<?php
						echo ''.$get_header[0]['NAMA_ASAL'].'<br>';
					?>
					<?php echo $get_header[0]['ALAMAT_ASAL'] ?>, <?php echo $get_header[0]['KOTA_ASAL'] ?><br><br>
					<span style="color:white">NPWP :</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $get_header[0]['NPWP'] ?><br>
				</td>
				<td colspan="2" style="vertical-align: top; border-bottom: 1px solid white; border-right: 1px solid white; border-top: 1px solid white; border-left: 1px solid white; font-size: 10px; padding: 5px;">
					<?php echo $get_header[0]['NAMA_KIRIM'] ?> <br>
					<?php
						$arr = explode("#", $get_header[0]['ALAMAT_KIRIM']); //jika mau ganti baris gunakan tanda # (pagar)
						foreach($arr as $i) {
							echo $i.'<br>';
						}
					?>
				</td>
			</tr>
			<tr style="text-align: center;">
				<td style="vertical-align: top; border-bottom: 1px solid white; border-left: 1px solid white; font-size: 10px; width: 10px;padding-top:-0.5mm">
				 <!-- <br> -->
					<?php echo $get_header[0]['NO_SO'] ?>
				</td>
				<td style="vertical-align: top; border-bottom: 1px solid white; border-left: 1px solid white; font-size: 10px;padding-top:-1mm;">
					 <!-- <br> -->
					<?php echo $get_header[0]['SO_DATE'] ?>
				</td>
				<td style="vertical-align: top; border-bottom: 1px solid white; border-left: 1px solid white; font-size: 10px; width: 7%;padding-left:-2mm;padding-top:-0.5mm">
				<!-- <br> -->
					<?php echo number_format($get_berat[0]['TTL_BERAT'],3).' KG' ?>
				</td>
				<td style="vertical-align: top; border-bottom: 1px solid white; border-left: 1px solid white; font-size: 10px;padding-left:5mm;padding-top:-0.5mm">
				<!-- <br> -->
					<?php echo $get_header[0]['BSATERM_NOMORIO'] ?>
				</td>
				<td style="vertical-align: top; border-bottom: 1px solid white; border-left: 1px solid white; font-size: 10px;padding-left:10mm; width: 28%;padding-top:-0.5mm">
				 <!-- <br> -->
					<?php echo $get_header[0]['EKSPEDISI'] ?>
				</td>
				<td style="vertical-align: top; border-bottom: 1px solid white; border-left: 1px solid white; font-size: 10px; padding: 5px; width: 17%; height: 35px; border-right: 1px solid white;">
				 <br>
					<br>
				</td>
			</tr>
		</table>

		<!-- coba  coba  -->
		<div style="position: absolute;">
			<table style="width: 635px; margin-top: 20px;">
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
						<td style="font-size: 9.7px; padding: 3.5px;padding-left: 3.2mm;width: 120px;">
							<?php echo $gb['SEGMENT1'] ?>
						</td>
						<td style="white-space:pre-line; font-size: 9.7px; padding: 3.5px;padding-left: -5mm; width: 175px;">
							<?php echo $gb['DESCRIPTION'] ?>
						</td>
						<td style="white-space:pre-line; font-size: 9.7px; padding: 3.5px; width: 130px;">
							<!-- TIPE? -->
						</td>
					</tr>
				<?php $no++; } ?>
			</table>
		</div>

		<div style="position: absolute;">
			<table style="width: 96%;margin-top: 20px; margin-left: 607px; border-collapse: collapse; border-spacing: 0;">
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

		<div style="position: absolute;">
			<table style="width: 95%; margin-top: 391px; margin-left: 625px;">
				<tr>
					<td style="white-space: pre-line; font-size: 13px; padding: 3.5px; width: 60%; font-weight: bold;">
						<center>
							<img style="width: 20mm; height: auto;" src="<?php echo base_url('assets/img/monitoringDOSPQRCODE/'.$get_header[0]['REQUEST_NUMBER'].'.png') ?>">
						</center>
						<div style="color:white">
							Total Berat :<br>
							<?php echo number_format($get_berat[0]['TTL_BERAT'],3).' KG' ?>
						</div>
					</td>
				</tr>
			</table>
		</div>


		<table style="width: 100%; border-collapse: collapse !important; margin-top: -1px; page-break-inside: avoid;color:white">
			<thead>
				<tr>
					<td rowspan="2" style="width: 5%; border-left: 1px solid white; border-bottom: 1px solid white; border-top: 1px solid white; font-size: 10px; padding: 5px">
						<center>No</center>
					</td>
					<td colspan="2" style="border-left: 1px solid white; border-bottom: 1px solid white; font-size: 10px; padding: 5px; border-top: 1px solid white;">
						<center>Qty</center>
					</td>
					<td rowspan="2" style="width: 5%; border-left: 1px solid white; border-bottom: 1px solid white; font-size: 10px; padding: 5px; border-top: 1px solid white;">
						<center>Satuan</center>
					</td>
					<td rowspan="2" style="width: 16%; border-left: 1px solid white; border-bottom: 1px solid white; font-size: 10px; padding: 5px; border-top: 1px solid white;">
						<center>Kode Barang</center>
					</td>
					<td rowspan="2" style="width: 30.5%; border-left: 1px solid white; border-bottom: 1px solid white; font-size: 10px; padding: 5px; border-top: 1px solid white;">
						<center>Nama Barang</center>
					</td>
					<td rowspan="2" style="width: 29.5%; border-right: 1px solid white; border-left: 1px solid white; border-bottom: 1px solid white; font-size: 10px; padding: 5px; border-top: 1px solid white;">
						<center>Catatan</center>
					</td>
				</tr>
				<tr>
					<td style="width: 7.5%; border-left: 1px solid white; border-bottom: 1px solid white; font-size: 10px; padding: 5px">
						<center>Diminta</center>
					</td>
					<td style="width: 6%; border-left: 1px solid white; border-bottom: 1px solid white; font-size: 10px; padding: 5px">
						<center>Dikirim</center>
					</td>
				</tr>
			</thead>
			<tbody style="vertical-align: top!important;">
				<tr style="border-bottom: 1px solid white;">
					<td style="vertical-align: top; border-right: 1px solid white; border-left: 1px solid white; height: <?php echo $key_master > 0 ? '521px' : '512px'?>; font-size: 10px; padding: 5px;">

					</td>
					<td style="vertical-align: top; border-right: 1px solid white; font-size: 10px; padding: 5px">

					</td>
					<td style="vertical-align: top; border-right: 1px solid white; font-size: 10px; padding: 5px">

					</td>
					<td style="vertical-align: top; border-right: 1px solid white; font-size: 10px; padding: 5px">

					</td>
					<td style="vertical-align: top; border-right: 1px solid white; font-size: 10px; padding: 5px">

					</td>
					<td style="vertical-align: top; border-right: 1px solid white; font-size: 10px; padding: 5px">

					</td>
					<td style="vertical-align: top; border-right: 1px solid white; font-size: 11.5px; padding: 5px;">

					</td>
				</tr>
			</tbody>
		</table>
		<br>
	<?php endforeach; ?>

</body>
</html>
