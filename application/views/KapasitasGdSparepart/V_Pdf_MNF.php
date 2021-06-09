<html>

<head>
	<style media="screen">
		td {
			padding: 5px;
		}
	</style>
</head>

<body>
<br>
<div style="position:absolute;">
	<br>
</div>

	<!-- HEADER -->
	<table style="width:100%; border-collapse: collapse !important; page-break-inside: avoid">
		<tr>
			<!-- <td style="border-bottom: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; border-top: 1px solid black; width:10%; padding: 5px" rowspan="2">
				<center>
					<img style="height: auto; padding: 5px; width: 70px;" src="<?php echo base_url('assets/img/logo.png'); ?>" />
				</center>
			</td> -->
			<?php 
				foreach ($get_nama as $eks) {
					if ($eks['EKSPEDISI'] == $get_data[0]['EKSPEDISI']) {
						$eksped = $eks['EKSPEDISI'];
						$name = $eks['VENDOR_NAME'];
					}
				}
			?>
			<td style="border: 1px solid black; width: 60%; padding: 5px; vertical-align: top;" rowspan="4">
				<b style="font-size: 28px;"><?php echo $get_data[0]['EKSPEDISI'] ?></b><br>
				<span style="border-bottom: 1px solid black; font-size: 16px;"><?php echo $name ?></span>
				<br><br>
				<!-- <span style="font-size: 12px;">
					KHS PUSAT<br>
					JL. MAGELANG 144, YOGYAKARTA 55241 - INDONESIA,<br>
					Email : operator1@quick.co.id <br>
					Telp. 08002826357, Fax : (0274)563523
				</span> -->
			</td>
			<td colspan="2" style="text-align: center; border: 1px solid black;  height: 25px;">
				<b style="font-size: 24px; padding: 10px">MANIFEST</b>
			</td>
			<tr>
			<td style="border-bottom: 1px solid black; border-right: 1px solid black; width: 15%; font-size: 12px; padding: 5px; text-align: center">
				Tgl. Cetak : <br>
				<?php echo date('d-M-Y') ?>
			</td>
			<td style="border-bottom: 1px solid black; border-right: 1px solid black; width: 15%; font-size: 16px; padding: 5px; text-align: center">
				<center>
					<img style="width: 20mm; height: auto;" src="<?php echo base_url('assets/img/monitoringDOSPQRCODE/'.$get_data[0]['MANIFEST_NUMBER'].'.png') ?>">
				</center>
		  		<span style="font-size: 12px"><?php echo $get_data[0]['MANIFEST_NUMBER'] ?></span>
			</td>
		</tr>
		</tr>
	</table>
	
	<!-- ISI BODY -->
	<div style="position: absolute;">
		<table style="margin-top: 50px;">
			<?php $no = 1; foreach ($get_data as $man) { ?>
				<tr>
					<td style="font-size: 14px; padding: 3.5px; width: 38px; text-align: center; vertical-align: top;">
						<?php echo $no; ?>
					</td>
					<td style="font-size: 14px; padding: 3.5px; width: 158px; text-align: center; vertical-align: top;">
						<?php echo $man['REQUEST_NUMBER'] ?>
					</td>
					<td style="font-size: 14px; padding: 3.5px; width: 382px; text-align: left; vertical-align: top;">
						<?php echo $man['NAMA_KIRIM'] ?>
					</td>
					<td style="font-size: 14px; padding: 3.5px; width: 113px; text-align: center; vertical-align: top;">
						<?php echo $man['JUMLAH_COLLY'] ?>
					</td>
					<td style="font-size: 14px; padding: 3.5px; width: 75px; text-align: right; vertical-align: top;">
						<?php echo number_format($man['TTL_BERAT'],3) ?>
					</td>
					<td style="font-size: 14px; padding: 3.5px; width: 45px; text-align: left; vertical-align: top;">
						KG
					</td>
				</tr>
			<?php $no++; } ?>
		</table>
	</div>

	<!-- BODY KERANGKA TABEL -->
	<table style="width: 100%; border-collapse: collapse !important; margin-top: -1px; page-break-inside: avoid;">
		<thead>
			<tr>
				<td style="width: 5%; border: 1px solid black; font-size: 16px; font-weight: bold; padding: 5px">
					<center>No.</center>
				</td>
				<td style="width: 20%; border: 1px solid black; font-size: 16px; font-weight: bold; padding: 5px">
					<center>SPB/DOSP</center>
				</td>
				<td style="width: 50%; border: 1px solid black; font-size: 16px; font-weight: bold; padding: 5px;">
					<center>TUJUAN</center>
				</td>
				<td style="width: 15%; border: 1px solid black; font-size: 16px; font-weight: bold; padding: 5px;">
					<center>JUMLAH PACKING</center>
				</td>
				<td style="width: 15%; border: 1px solid black; font-size: 16px; font-weight: bold; padding: 5px;">
					<center>TOTAL BERAT</center>
				</td>
			</tr>
		</thead>
		<tbody style="vertical-align: top!important;">
			<tr style="border-bottom: 1px solid black;">
				<td style="vertical-align: top; border: 1px solid black; font-size: 10px; padding: 5px; height: 700px;">

				</td>
				<td style="vertical-align: top; border: 1px solid black; font-size: 10px; padding: 5px">

				</td>
				<td style="vertical-align: top; border: 1px solid black; font-size: 10px; padding: 5px">

				</td>
				<td style="vertical-align: top; border: 1px solid black; font-size: 10px; padding: 5px">
					
				</td>
				<td style="vertical-align: top; border: 1px solid black; font-size: 10px; padding: 5px">
					
				</td>
			</tr>
		</tbody>
	</table>

	<br>
	<br>

	<!-- FOOTER -->
	<table style="width: 100%; border-collapse: collapse !important; margin-top: -1px; page-break-inside: avoid;">
		<tr style="width: 100%">
			<td rowspan="2" style="white-space: pre-line; vertical-align: top; padding: 5px">
				
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top; width: 250px; font-size: 16px; font-weight: bold; padding: 5px; text-align: center;">
				Menyerahkan : <br>
				CV. KHS <br>
				<br><br><br><br><br>
				(...................................)
			</td>
			<td style="vertical-align: top; width: 250px; font-size: 16px; font-weight: bold; padding: 5px; text-align: center;">
				Menerima : <br>
				<?php echo $get_data[0]['EKSPEDISI'] ?> <br>
				<br><br><br><br><br>
				(...................................)
			</td>
		</tr>		
	</table>

</body>
</html>