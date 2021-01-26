<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title></title>
	</head>
	<body>
	<div style="width:100%">

		<?php foreach ($get as $key => $var):?>

		<div style="width:49.5%;float:left;<?php echo ($key+1)%2 == 0 ? 'margin-left:10px' : '' ?>">
		 <!-- <span style="font-size:12px;">STANDAR KERTAS WARNA HIJAU</span> -->
			<table style="width:100%; border-collapse: collapse !important;page-break-inside:avoid;">
				<thead>
					<tr>
						<td style="width:22%;padding:5px;border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;" rowspan="2">
							<center><img style="height: auto;padding:5px; width: 50px;" src="<?php echo base_url('assets/img/logo.png'); ?>" /></center>
						</td>
						<td style="width:57%;padding:5px;font-size:13px;border-right: 1px solid black;border-top: 1px solid black;">
							<center>
								<h4 style="text-a">Gudang Produksi & Ekspedisi <br> CV. Karya Hidup Sentosa</h4>
							</center>
						</td>
						<td style="width:21%;border-right: 1px solid black;border-top: 1px solid black;padding:5px">
							<div style="font-size:13px;">
								Tgl. LPPB :</br>
							</div>
						</td>
					</tr>
					<tr>
						<td style="padding:5px;font-size:12px;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;">
							<center>
								<h3>KIB MOTOR BENSIN</h3>
							</center>
						</td>
						<td style="border-bottom: 1px solid black;border-right: 1px solid black;padding:5px">
							<div style="font-size:13px;">
								<center><?php echo $var['RECEIPT_DATE'] ?></center>
							</div>
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="padding:5px;border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;">
							Kode Brg
						</td>
						<td colspan="2" style="padding:5px;font-size:12px;border-right: 1px solid black;">
							<?php echo $var['KODE_SETELAH'] ?>
						</td>
						<!-- <td rowspan="3" style="border-right: 1px solid black;padding:5px;font-size:9px;">
							Lengkap dengan...
						</td> -->
					</tr>
					<tr>
						<td style="padding:5px;border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;">
							Nama Brg
						</td>
						<td colspan="2" style="padding:5px;font-size:12px;border-right: 1px solid black;border-top: 1px solid black;">
							<?php echo $var['TYPE_SETELAH'] ?>
						</td>
					</tr>
					<tr>
						<td style="padding:5px;border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;">
							Tipe
						</td>
						<?php
							switch ($var['WARNA_KIB']) {
								case 'KUNING':
									$warna = '#edd537';
									break;
								case 'PUTIH':
									$warna = '#ffffff';
									break;
								case 'BIRU':
									$warna = '#46acff';
									break;
								default:
									$warna = '#47ffa1';
									break;
							}
						 ?>
						<td colspan="2" style="padding:5px;font-size:12px;border-right: 1px solid black;border-top: 1px solid black;background:<?php echo $warna ?>">
							<center><h3 style="text-transform:uppercase"><?php echo $var['TYPE'] ?><h3></center>
						</td>
					</tr>
					<tr>
						<td colspan="3" style="padding:5px;border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;">
							<center> Untuk Produk<strong> <?php echo $var['PRODUK'] ?></strong> </center>
						</td>
						<!-- <td style="padding:5px;font-size:12px;border-right: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;">
							Opr. bla bla
						</td> -->
					</tr>
					<tr>
						<td colspan="2" style="padding:5px;border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;">
							<center> CV. KHS melengkapi </center>
						</td>
						<td rowspan="2" style="padding:5px;border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;">
							 <center>
								<img style="width: 17mm; height: auto;" src="<?php echo base_url('assets/img/PBIQRCode/'.$var['SERIAL_NUMBER'].'.png') ?>">
							</center>
						</td>
					</tr>
					<tr>
						<td style="padding:5px;border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;">
							No. Seri :
						</td>
						<td style="padding:5px;border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;">
							<center> <h3><?php echo $var['SERIAL_NUMBER'] ?></h3> </center>
						</td>
					</tr>
				</tbody>
			</table>

			<table style="width:100%">
				<tr>
					<td><center><span style="color:red;">-----------------POTONG DISINI-----------------<span></center></td>
				</tr>
			</table>

			<table style="width:100%; border-collapse: collapse !important;page-break-inside:avoid;">
				<tr>
					<td style="padding:5px;border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;" colspan="3">
						<center><h3>UNTUK WOLC</h3></center>
					</td>
				</tr>
				<tr>
					<td style="width:22%;padding:5px;border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;">
						Kode Brg
					</td>
					<td colspan="2" style="width:57%;padding:5px;font-size:12px;border-right: 1px solid black;">
						<?php echo $var['KODE_SEBELUM'] ?>
					</td>
				</tr>
				<tr>
					<td style="padding:5px;border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;">
						Nama Brg
					</td>
					<td colspan="2" style="padding:5px;font-size:12px;border-right: 1px solid black;border-top: 1px solid black;">
						<?php echo $var['TYPE_SEBELUM'] ?>
					</td>
				</tr>
				<tr>
					<td style="padding:5px;border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;">
						Tipe
					</td>
					<td style="padding:5px;font-size:12px;border-right: 1px solid black;border-top: 1px solid black;background:<?php echo $warna ?>">
						<center><h3 style="text-transform:uppercase"><?php echo $var['TYPE'] ?><h3></center>
					</td>
					<td rowspan="2" style="width: 21%;padding:5px;border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;">
						 <center>
							<img style="width: 17mm; height: auto;" src="<?php echo base_url('assets/img/PBIQRCode/'.$var['SERIAL_NUMBER'].'.png') ?>">
						</center>
					</td>
				</tr>
				<tr>
					<td style="padding:5px;border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;">
						No. Seri :
					</td>
					<td style="padding:5px;border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;">
						<center> <h3><?php echo $var['SERIAL_NUMBER'] ?></h3> </center>
					</td>
				</tr>
			</table>
		</div>
		<?php

		if (($key+1)%2 == 0) {
			echo "<div style='width=100%;'><hr style='color:red;padding:0;margin:10px 0 10px 0'></div>";
		}

	 ?>
		<?php endforeach; ?>


	</div>

	<!-- <span style="font-size:13px;font-weight:bold">FRM-PPB-02-05</span> -->
	<!--  -->

	</body>
</html>
