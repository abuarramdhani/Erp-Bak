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

	<table style="width:100%; border-collapse: collapse !important;page-break-inside:avoid">
		<tr>
			<td style="border-bottom: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;width:10%;padding:5px" rowspan="2">
				<center><img style="height: auto;padding:5px; width: 70px;" src="<?php echo base_url('assets/img/logo.png'); ?>" /></center>
			</td>
			<td style="border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;;width:60%;padding:5px" rowspan="2">
				<b style="font-size:16px;">CV. KARYA HIDUP SENTOSA YOGYAKARTA</b><br>
				<span style="border-bottom:1px solid black;font-size:12px;">PABRIK MESIN ALAT PERTANIAAN-PENGECORAN LOGAM-DEALER KUBOTA</span><br><br>
				<span style="font-size: 12px;">
					KHS PUSAT<br>
					JL. MAGELANG 144, YOGYAKARTA 55241 - INDONESIA,<br> Email : operator1@quick.co.id <br>
					Telp. 08002826357, Fax : (0274)563523
				</span>

			</td>
			<td colspan="2" style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;">
				<?php if ($get_header[0]['NO_SO'] == ''){ ?>
					<b style="font-size:14px;padding:8px">SURAT PENGIRIMAN BARANG</b>
				<?php }else { ?>
					<b style="font-size:16px;">DELIVERY ORDER</b>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<td style="border-bottom: 1px solid black;border-right: 1px solid black;width:15%;font-size:10px;padding:5px;text-align:center">Tgl. Barang Dikirim: <br> <?php echo date('d-M-Y') ?> </td>
			<td style="border-bottom: 1px solid black;border-right: 1px solid black;width:15%;font-size:11px;padding:5px;text-align:center">
				<center>
					<img style="width: 20mm; height: auto;" src="<?php echo base_url('assets/img/'.$get_header[0]['NO_DO'].'.png') ?>">
				</center>
				<?php echo $get_header[0]['NO_DO'] ?>
			</td>
		</tr>
	</table>

	<table style="width:100%;border-collapse: collapse !important; margin-top:-1px;page-break-inside:avoid">
		<tr>
			<td style="vertical-align:top;height: 70px;width:50%;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;font-size:10px;padding:5px" colspan="4">
				Kepada Yth : <br>
				<?php echo $get_header[0]['TUJUAN'] ?> <br>
				<?php echo $get_header[0]['KOTA'] ?><br>
				NPWP :
			</td>
			<td colspan="2" style="vertical-align:top;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;font-size:10px;padding:5px">
				Dikirim Kepada : <br>
				<?php echo $get_header[0]['TUJUAN'] ?><br>
				<?php echo $get_header[0]['KOTA'] ?>
			</td>
		</tr>
		<tr style="text-align:center">
			<td style="vertical-align:top;border-bottom: 1px solid black;border-left: 1px solid black;font-size:10px;padding:5px">No Order : <br> <?php echo $get_header[0]['NO_SO'] ?></td>
			<td style="vertical-align:top;border-bottom: 1px solid black;border-left: 1px solid black;font-size:10px;padding:5px">Tgl. Order : <br> <?php echo $get_header[0]['ORDERED_DATE'] ?></td>
			<td style="vertical-align:top;border-bottom: 1px solid black;border-left: 1px solid black;font-size:10px;padding:5px">Berat : <br><br> </td>
			<td style="vertical-align:top;border-bottom: 1px solid black;border-left: 1px solid black;font-size:10px;padding:5px">Syarat Pembayaran : <br><br> </td>
			<td style="vertical-align:top;width:30%;border-bottom: 1px solid black;border-left: 1px solid black;font-size:10px;padding:5px">Expedisi : <br><br> </td>
			<td style="vertical-align:top;width:20%;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;font-size:10px;padding:5px">No Polisi : <br><?php echo $get_header[0]['PLAT_NUMBER'] ?><br> </td>
		</tr>
	</table>

<!-- coba  coba  -->
<div style="position:absolute;">
	<table style="width:78%; margin-top:49px;">
		<?php $no = 1; foreach ($get_body as $key => $gb){ ?>
			<tr>
				<td style="font-size:10px;padding:5px;width:8%;text-align:center"><?php echo $no ?></td>
				<td style="font-size:10px;padding:5px;width:8%;text-align:center"><?php echo $gb['QUANTITY'] ?></td>
				<td style="font-size:10px;padding:5px;width:9%;text-align:center"><?php echo $gb['QTY_TERLAYANI'] ?></td>
				<td style="font-size:10px;padding:5px 5px 5px 10px;width:11%;text-align:left"><?php echo $gb['UOM_CODE'] ?></td>
				<td style="font-size:10px;padding:5px;width:30%;"><?php echo $gb['ITEM'] ?></td>
				<td style="font-size:10px;padding:5px;width:35%;"><?php echo $gb['DESCRIPTION'] ?></td>
			</tr>
		<?php $no++; } ?>
	</table>
</div>

	<table style="width:100%;border-collapse: collapse !important; margin-top:-1px;page-break-inside:avoid">
		<thead>
			<tr>
				<td rowspan="2" style="width:5%;border-left:1px solid black;border-bottom: 1px solid black;border-top:1px solid black;font-size:10px;padding:5px">
					<center>No</center>
				</td>
				<td colspan="2" style="border-left:1px solid black;border-bottom: 1px solid black;font-size:10px;padding:5px;border-top:1px solid black;">
					<center>Qty</center>
				</td>
				<td rowspan="2" style="width:5%;border-left:1px solid black;border-bottom: 1px solid black;font-size:10px;padding:5px;border-top:1px solid black;">
					<center>Satuan</center>
				</td>
				<td rowspan="2" style="width:19%;border-left:1px solid black;border-bottom: 1px solid black;font-size:10px;padding:5px;border-top:1px solid black;">
					<center>Kode Barang</center>
				</td>
				<td rowspan="2" style="width:25%;border-left:1px solid black;border-bottom: 1px solid black;font-size:10px;padding:5px;border-top:1px solid black;">
					<center>Nama Barang</center>
				</td>
				<td rowspan="2" style="width:35%;border-right:1px solid black;border-left:1px solid black;border-bottom: 1px solid black;font-size:10px;padding:5px;border-top:1px solid black;">
					<center>Nomor Barang</center>
				</td>
			</tr>
			<tr>
				<td style="width:5%;border-left:1px solid black;border-bottom: 1px solid black;font-size:10px;padding:5px">
					<center>DO</center>
				</td>
				<td style="width:6%;border-left:1px solid black;border-bottom: 1px solid black;font-size:10px;padding:5px">
					<center>Dikirim</center>
				</td>
			</tr>
		</thead>
		<tbody style="vertical-align:top!important;">
		<tr style="border-bottom:1px solid black;">
			<td style="vertical-align:top;border-right:1px solid black;border-left:1px solid black;height: 588px;font-size:10px;padding:5px">
				<center>
					<!-- <?php $no = 1; foreach ($get_body as $key => $gb){ ?>
						<?php echo $no ?> <br /><br />
					<?php $no++; } ?> -->
				</center>
			</td>
			<td style="vertical-align:top;border-right:1px solid black;font-size:10px;padding:5px">
				<center>
					<!-- <?php $no = 1; foreach ($get_body as $key => $gb){ ?>
						<?php echo $gb['QUANTITY'] ?> <br /><br />
					<?php $no++; } ?> -->
				</center>
			</td>
			<td style="vertical-align:top;border-right:1px solid black;font-size:10px;padding:5px">
				<center>
					<!-- <?php $no = 1; foreach ($get_body as $key => $gb){ ?>
						<?php echo $gb['QTY_TERLAYANI'] ?> <br /><br />
					<?php $no++; } ?> -->
				</center>
			</td>
			<td style="vertical-align:top;border-right:1px solid black;font-size:10px;padding:5px">
				<center>
					<!-- <?php $no = 1; foreach ($get_body as $key => $gb){ ?>
						<?php echo $gb['UOM_CODE'] ?> <br /><br />
					<?php $no++; } ?> -->
				</center>
			</td>
			<td style="vertical-align:top;border-right:1px solid black;font-size:10px;padding:5px">
				<!-- <?php $no = 1; foreach ($get_body as $key => $gb){ ?>
					<?php echo $gb['ITEM'] ?> <br /><br />
				<?php $no++; } ?> -->
			</td>
			<td style="vertical-align:top;border-right:1px solid black;border-left:1px solid black;font-size:10px;padding:5px">
				<!-- <?php $no = 1; foreach ($get_body as $key => $gb){ ?>
					<?php echo $gb['DESCRIPTION'] ?> <br /><br />
				<?php $no++; } ?> -->
				<!-- coba <br>
				coba <br>
				coba <br> -->
			</td>
			<td style="vertical-align:top;font-size:10px;padding:5px;border-right:1px solid black;">
				<center>
					<?php if (!empty($get_serial)){ ?>
					<table style="border-collapse: collapse !important;">
						<thead>
							<tr>
								<?php foreach ($header_sub as $h): ?>
									<th style="padding: 5px;font-size:10.5px;"><?php echo $h ?></th>
								<?php endforeach; ?>
							</tr>
						</thead>
						<tbody>
							<tr>
								<?php foreach ($check_header_sub as $h): ?>
									<td style="padding: 5px;font-size:11.5px;">
										<?php foreach ($get_serial as $gs) { ?>
											<?php if ($gs['DESCRIPTION'] == $h){
												echo $gs['SERIAL_NUMBER'].'<br />';
											}?>
										<?php } ?>
									</td>
								<?php endforeach; ?>
							</tr>
						</tbody>
					</table>
				<center>

				<?php }else {
					echo "";
				} ?>

			</td>
		</tr>
		</tbody>
	</table>
	<br>
</body>
</html>
