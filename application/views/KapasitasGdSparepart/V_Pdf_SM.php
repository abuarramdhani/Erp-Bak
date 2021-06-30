<html>

<head>
	<style media="screen">
		td {
			padding: 5px;
		}
	</style>
</head>

<body>
	<?php foreach ($get_colly as $key => $gc): ?>
	<div>
		<table style="page-break-inside:avoid;margin-bottom:10px;border: 2px solid black;height: 71mm; width: 101mm;">
			<tr>
				<td style="text-align: center;">
					<!-- 45 max font size -->
					<div style="font-weight: bold; position: absolute;font-size: 45px;">
						<?php if ($get_header[0]['TIPE'] == 'SPB'){ ?>
							<!-- Kepada Yth : <br> -->
							<!-- <?php //echo $get_header[0]['NAMA_KIRIM'].' ['.$get_header[0]['ORGANIZATION_CODE'].']' ?> <br>
							<?php //echo $get_header[0]['ALAMAT_KIRIM'] ?>, <?php // echo $get_header[0]['KOTA_KIRIM'] ?><br><br> -->
							<span style="font-size: 45px;">Dikirim Kepada :</span>  <br>
								<?php
								$arr = explode("#", $get_header[0]['LAIN']); //jika mau ganti baris gunakan tanda # (pagar)
								foreach($arr as $key => $i) {
										echo $i."<br>";
								}
								?>
								<!-- <span style="color:white;"><?php echo $key ?></span> -->
						<?php } else { ?>
							<!-- Dikirim Kepada : <br> -->
							<?php echo $get_header[0]['NAMA_KIRIM'] ?> <br>
							<?php echo $get_header[0]['ALAMAT_KIRIM'] ?>, <?php echo $get_header[0]['KOTA_KIRIM'] ?><br><br>
							<?php
								$arr = explode("#", $get_header[0]['LAIN']); //jika mau ganti baris gunakan tanda # (pagar)
								foreach($arr as $i) {
									echo $i.'<br>';
								}
							?>
						<?php } ?>
					</div>
				</td>
			</tr>
		</table>

		<br>
		<br>
		<div style="height: 71mm; width: 107mm; padding: 3px;">
			<table style="border: 2px solid black; width: 107mm; height: 71mm; border-collapse: collapse !important;page-break-inside:avoid">
				<tr>
					<td colspan="3" style="border: 2px solid black; font-size: 48px; font-weight: bold;">
						<center>
							<?php echo $get_header[0]['REQUEST_NUMBER']; ?>
						</center>
						<p style="font-size: 10px; float: right;">
							<?php echo $gc['COLLY_NUMBER']; ?>
						</p>
					</td>
					<td style="border: 2px solid black; font-size: 24px; font-weight: bold;">
						<center>
							<?php echo $gc['ROWNUM'].' / '.$total_colly; ?>
						</center>
					</td>
				</tr>
				<tr style="height: 100mm;">
					<td style="border: 2px solid black; font-size: 18px; font-weight: bold; padding: 10px;">
						<center>
							<span style="font-size: 12px;">
								CV. KARYA HIDUP SENTOSA<br>
								<?php if ($get_header[0]['TIPE'] == 'SPB') {
									echo $get_header[0]['ALAMAT_KIRIM'].', '.$get_header[0]['KOTA_KIRIM'];
								}
								else { ?>
									Jl. Magelang no 144, Yogyakarta, D.I.Y<br>
									Telp (0274) 512095, 563217<br>
									Email : operator1@quick.co.id<br>
								<?php } ?>
							</span>
						</center>
					</td>
					<td colspan="2" style="border: 2px solid black; font-size: 20px; font-weight: bold; width: 20mm;">
						<center>
							<!-- <?php echo $gc['BERAT'].'<br>KG'; ?> -->
							<?php echo '______<br>KG'; ?>
						</center>
					</td>
					<td style="border: 2px solid black;">
						<center>
							<img style="width: 20mm; height: auto;" src="<?php echo base_url('assets/img/monitoringDOSPQRCODE/'.$get_header[0]['REQUEST_NUMBER'].'.png') ?>">
						</center>
					</td>
				</tr>
				<tr>
					<td colspan="4" style="border: 2px solid black; font-size: 20px; font-weight: bold; padding: 10px;">
						<span style="font-size: 12px;">
							Ekspedisi : <?= $get_header[0]['EKSPEDISI']; ?>
						</span>
						<br>
						<span style="font-size: 12px;">
							Catatan :
							<?php
								if (ceil(strlen($get_header[0]['CATATAN'])/40) == 1) {
					              $a = '<br>'.$get_header[0]['CATATAN'].'<br><br><br><br><br>';
					            } elseif (ceil(strlen($get_header[0]['CATATAN'])/40) == 2) {
					              $a = '<br>'.$get_header[0]['CATATAN'].'<br><br><br><br>';
					            } elseif (ceil(strlen($get_header[0]['CATATAN'])/40) == 3) {
					              $a = '<br>'.$get_header[0]['CATATAN'].'<br><br><br>';
					            } elseif (ceil(strlen($get_header[0]['CATATAN'])/40) == 4) {
					              $a = '<br>'.$get_header[0]['CATATAN'].'<br><br>';
					            } elseif (ceil(strlen($get_header[0]['CATATAN'])/40) == 5) {
					              $a = $get_header[0]['CATATAN'];
					            } elseif (ceil(strlen($get_header[0]['CATATAN'])/40) == 0) {
					              $a = '<br><br><br><br><br><br>';
					            }

								echo $a;
							?>
						</span>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<?php endforeach; ?>
</body>
</html>
