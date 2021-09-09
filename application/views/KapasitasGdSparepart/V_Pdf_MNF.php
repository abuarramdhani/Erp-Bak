<?php
$jumlah_colly_peralamat=0;
$jumlah_berat_peralamat=0;
foreach ($get_data as $key => $man) {
	if ($man['TIPE'] == 'SPB'){
			$arr = explode("#", $man['LAIN']);
			foreach($arr as $i) {
				$talt .= $i.' ';
			}
	 } else { // JIKA TIPE DO
		 $talt .= $man['NAMA_KIRIM'];
		 if (!empty($man['LAIN'])) {
				$arr = explode("#", $man['ALAMAT_KIRIM']);
				foreach($arr as $i) {
					$talt .= $i.' ';
				}
			}else {
				$talt = $man['ALAMAT_KIRIM'].', '.$man['KOTA_KIRIM'];
			}
 		}

		$tampung_alamat[] = $talt;

		$jumlah_colly_peralamat += $man['JUMLAH_COLLY'];
		$jumlah_berat_peralamat += $man['TTL_BERAT'];

		if ($key != 0 && $talt != $tampung_alamat[$key-1]) {
			$master_result[] = [
				'REQUEST_NUMBER' => '',
				'ALAMAT_FIX' => 'TOTAL :',
				'JUMLAH_COLLY' => $jumlah_colly_peralamat - $man['JUMLAH_COLLY'],
				'TTL_BERAT' => $jumlah_berat_peralamat - $man['TTL_BERAT']
			];
			$jumlah_colly_peralamat = $man['JUMLAH_COLLY'];
			$jumlah_berat_peralamat = $man['TTL_BERAT'];
		}

		$master_result[] = [
			'REQUEST_NUMBER' => $man['REQUEST_NUMBER'],
			'ALAMAT_FIX' => $talt,
			'JUMLAH_COLLY' => $man['JUMLAH_COLLY'],
			'TTL_BERAT' => $man['TTL_BERAT']
		];

		if ($key == sizeof($get_data) - 1) {
			$master_result[] = [
				'REQUEST_NUMBER' => '',
				'ALAMAT_FIX' => 'TOTAL :',
				'JUMLAH_COLLY' => $jumlah_colly_peralamat,
				'TTL_BERAT' => $jumlah_berat_peralamat
			];
		}
		$talt = '';
}

foreach ($master_result as $key => $value) {
	$tampung[] = $value;
	if (sizeof($tampung) == 12 || $key == sizeof($master_result) - 1 ) {
		$one_page_is[] = $tampung;
		$tampung = [];
	}
}

?>
<html>

<head>
	<style media="screen">
		td {
			padding: 5px;
		}
	</style>
</head>

<body>
<?php	$no = 1;foreach ($one_page_is as $key_page => $value_page): ?>
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
			<?php
			foreach ($value_page as $key => $man) {
			if (empty($man['REQUEST_NUMBER'])) {
				$border = 'border-bottom:1px solid black;';
			}else {
				$border = '';
			}
			?>
				<tr>
					<td style="font-size: 14px; padding: 3.5px; width: 38px; text-align: center; vertical-align: middle;<?php echo $border ?>">
						<?php echo !empty($man['REQUEST_NUMBER']) ? $no++ :"<span style='color:white'>$no</span>";?>
					</td>
					<td style="font-size: 14px; padding: 3.5px; width: 108px; text-align: center; vertical-align: middle;<?php echo $border ?>">
						<?php echo $man['REQUEST_NUMBER'] ?>
					</td>
					<td style="font-size: 14px; padding: 3.5px; width: 337px; text-align: <?php echo empty($man['REQUEST_NUMBER']) ? 'right' : 'left'; ?>; vertical-align: middle;<?php echo $border ?>">
						<?php
						$alamat_fix = $man['ALAMAT_FIX'];
						echo empty($man['REQUEST_NUMBER']) ?"<b>$alamat_fix</b>" : $alamat_fix;
						?>
					</td>
					<!-- <td style="width: 30px;margin-left:10px; border: 1px solid black;"></td> -->
					<td style="font-size: 14px; padding: 3.5px; width: 93px; text-align: center; vertical-align: middle;<?php echo $border ?>">
						<?php
						$jumlah_colly = $man['JUMLAH_COLLY'];
						echo empty($man['REQUEST_NUMBER']) ?"<b>$jumlah_colly</b>" : $jumlah_colly;
						?>
					</td>
					<td style="font-size: 14px; padding: 3.5px; width: 150px; text-align: right; vertical-align: middle;<?php echo $border ?>">
						<?php
						$ttl_berat = number_format($man['TTL_BERAT'],1);
						echo empty($man['REQUEST_NUMBER']) ?"<b>$ttl_berat</b>" : $ttl_berat;
						?>
					</td>
					<td style="font-size: 14px; padding: 3.5px; width: 45px; text-align: left; vertical-align: middle;<?php echo $border ?>">
						KG
					</td>
				</tr>
			<?php } ?>
		</table>
	</div>

	<!-- BODY KERANGKA TABEL -->
	<table style="width: 100%; border-collapse: collapse !important; margin-top: -1px; page-break-inside: avoid;">
		<thead>
			<tr>
				<td style="width: 6%; border: 1px solid black; font-size: 16px; font-weight: bold; padding: 5px">
					<center>No.</center>
				</td>
				<td style="width: 13%; border: 1px solid black; font-size: 16px; font-weight: bold; padding: 5px">
					<center>SPB/DOSP</center>
				</td>
				<td style="width: 45%; border: 1px solid black; font-size: 16px; font-weight: bold; padding: 5px;">
					<center>TUJUAN</center>
				</td>
				<td colspan="2" style="border: 1px solid black; font-size: 16px; font-weight: bold; padding: 5px;">
					<center>JUMLAH PACKING</center>
				</td>
				<td style="width: 14%; border: 1px solid black; font-size: 16px; font-weight: bold; padding: 5px;">
					<center>TOTAL BERAT</center>
				</td>
			</tr>
		</thead>
		<tbody style="vertical-align: top!important;">
			<tr style="border-bottom: 1px solid black;">
				<td style="vertical-align: top; border: 1px solid black; font-size: 10px; padding: 5px; height: 580px;">

				</td>
				<td style="vertical-align: top; border: 1px solid black; font-size: 10px; padding: 5px">

				</td>
				<td style="vertical-align: top; border: 1px solid black; font-size: 10px; padding: 5px">

				</td>
				<td style="vertical-align: top; border: 1px solid black; font-size: 10px; padding: 5px">

				</td>
				<td style="height: 10%;vertical-align: top; border: 1px solid black; font-size: 10px; padding: 5px">

				</td>
				<td style="height: 10%;vertical-align: top; border: 1px solid black; font-size: 10px; padding: 5px">

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
<?php endforeach; ?>
</body>
</html>
