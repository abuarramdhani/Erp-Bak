<html>

<head>
	<style media="screen">
		td {
			padding: 5px;
		}
	</style>
</head>

<body>
<div style="position:absolute;">
	<br>
</div>

	<!-- HEADER -->
	<table style="width:100%; border-collapse: collapse !important; page-break-inside: avoid">
		<tr>			
			<td style="vertical-align: middle;">
				<center>
					<b>KARTU IDENTITAS SUBKON</b>
				</center><br>
			</td>			
			<td style="font-size: 16px; padding: 5px; text-align: center" rowspan="5">
				<center>
					<img style="width: 20mm; height: auto;" src="<?php echo base_url('assets/img/kisQRCODE/'.$kis.'.png') ?>">
				</center>
		  		<b><span style="font-size: 12px"><?php echo $subkon[0]['SEGMENT1'] ?></span><b>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">
				<center>
					<span style="font-size: 18px; font-weight: bold;">
						<?php echo $subkon[0]['DESCRIPTION'] ?>
					</span>
				</center>
			</td>
		</tr>
	</table>

	<!-- ISI BODY -->

	<!-- BODY KERANGKA TABEL -->
	<table style="width: 100%; border-collapse: collapse !important; font-weight: bold;">
		<thead>
			<tr>
				<td style="width: 15%; border-left: 1px solid black; border-bottom: 1px solid black; border-top: 1px solid black; font-size: 10px;" rowspan="2">
					<center>Tanggal</center>
				</td>
				<td style="width: 40%; border-left: 1px solid black; border-bottom: 1px solid black; border-top: 1px solid black; font-size: 10px;" rowspan="2">
					<center>Tipe Handling</center>
				</td>
				<td style="width: 20%; border-left: 1px solid black; border-bottom: 1px solid black; border-top: 1px solid black; font-size: 10px;" colspan="2">
					<center>Jumlah</center>
				</td>
				<td style="width: 10%; border-left: 1px solid black; border-bottom: 1px solid black; border-top: 1px solid black; font-size: 10px;" rowspan="2">
					<center>TTD Subkon</center>
				</td>
				<td style="width: 10%; border: 1px solid black; font-size: 10px;" rowspan="2">
					<center>TTD KHS</center>
				</td>
			</tr>
			<tr>
				<td style="width: 10%; border-left: 1px solid black; border-bottom: 1px solid black; font-size: 10px;">
					<center>Out<br>KHS</center>
				</td>
				<td style="width: 10%; border-left: 1px solid black; border-bottom: 1px solid black; font-size: 10px;">
					<center>In<br>KHS</center>
				</td>
			</tr>
		</thead>
		<tbody style="vertical-align: top!important;">
			<?php 
				for ($i=0; $i < 19; $i++) {
			?>
					<tr style="border-bottom: 1px solid black;">
						<td style="border-left: 1px solid black; border-bottom: 1px solid black; height: 19.5px;">

						</td>
						<td style="border-left: 1px solid black; border-bottom: 1px solid black;">

						</td>
						<td style="border-left: 1px solid black; border-bottom: 1px solid black;">

						</td>
						<td style="border-left: 1px solid black; border-bottom: 1px solid black;">
							
						</td>
						<td style="border-left: 1px solid black; border-bottom: 1px solid black;">
							
						</td>
						<td style="border-left: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black;">
							
						</td>
					</tr>
			<?php
				}
			?>
		</tbody>
	</table>

	<!-- FOOTER -->
	<table style="width: 100%;">
		<thead>
			<tr>
				<td style="font-size: 10px; text-align: left;">
					CV. KARYA HIDUP SENTOSA
				</td>
				<td style="font-size: 10px; text-align: right;">
					<?php echo $kis; ?>
				</td>
			</tr>
		</thead>
	</table>
	<!-- <div style="position: absolute; width: 500px; border: 1px solid black;">
		<p style="font-size: 10px; float: left;">CV. KARYA HIDUP SENTOSA</p>
		<p style="font-size: 10px; float: right;">FORM</p>		
	</div> -->
</body>
</html>