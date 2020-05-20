<html>

<head>
	<style media="screen">
		td {
			padding: 5px;
		}
	</style>
</head>
<body>
<div style="border-top: 1.5px solid black;border-left: 1.5px solid black;border-right: 1.5px solid black;border-bottom: 1.5px solid black;">
	<table style="width:100%; border-collapse: collapse !important;page-break-inside:avoid;">
		<tr>
			<td style="width:15%;padding:5px">
				<center><img style="height: auto;padding:5px; width: 110px;" src="<?php echo base_url('assets/img/logo.png'); ?>" /></center>
			</td>
			<td style="width:65%;padding:5px;font-size:18px">
				<center>
					<h2>FORM PENGIRIMAN BARANG</h2><br>
					<h5>KIRIM KE :</h5>
					<h1 style="color:red;padding-top:20px!important"><?php echo $get[0]['TUJUAN'] ?></h1>
				</center>
			</td>
			<td style="width:20%; height: 25px;">
				<center>
					<img style="width: 30mm; height: auto;" src="<?php echo base_url('assets/img/PBIQRCode/'.$get[0]['DOC_NUMBER'].'.png') ?>">
				</center>
				<div style="font-size:13px;text-align:left !important">
					<b><?php echo $get[0]['DOC_NUMBER'] ?> <br>
					Tgl. <?php echo $get[0]['CREATION_DATE'] ?></b>
				</div>
			</td>
		</tr>
	</table>
	<div style="padding:18px;">
		<table style="font-size:16.3px !important;width:100%;border-collapse: collapse !important;page-break-inside:avoid;">
			<tr>
				<td style="width:42%;padding:5px;border-left: 1px solid black;border-bottom: 1px solid black;border-top: 1px solid black;">
					<b style="font-size:14px;">DARI :</b> <br><br>
					<?php echo $get[0]['CREATED_BY'] ?><br>
					<?php echo $nama_pengirim[0]['employee_name'] ?>
				</td>
				<td style="width:58%;padding:5px;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;">
					<b style="font-size:14px;position:absolute;">SEKSI :</b> <br><br>
					<?php echo $get[0]['SEKSI_KIRIM'] ?>
				</td>
			</tr>
			<tr>
				<td style="width:42%;padding:5px;border-bottom: 1px solid black;border-left: 1px solid black;">
					<b style="font-size:14px;">UNTUK :</b><br><br>
					<span>
						<b><?php echo $get[0]['USER_TUJUAN'] ?><br>
						<?php echo $user_tujuan[0]['employee_name'] ?></b>
					</span>
				</td>
				<td style="width:58%;padding:5px;border-top: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;">
					<b style="font-size:14px;position:absolute;">SEKSI :</b> <br><br>
					<?php echo $seksi_tujuan->seksi ?>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding: 5px;border-bottom: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;">
					<b style="font-size:14px">JENIS BARANG :</b> <br> <br>
					<b><?php echo $jenisbarang ?></b>
				</tr>
				</td>
			</tr>
		</table>
		<br>
		<i style="font-size:12px;">*) Untuk melihat detail barang, cek web Monitoring Pengiriman Barang Internal KHS.
<span style="color:blue;">http://produksi.quick.com/PengirimanBarangInternal</span></i style="font-size:10px;">
	</div>
</div>
<span style="font-size:13px;font-weight:bold">FRM-PPB-02-05</span>
<!-- <pagebreak> -->
</body>
</html>
