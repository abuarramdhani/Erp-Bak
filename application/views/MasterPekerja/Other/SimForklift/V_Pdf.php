<!DOCTYPE html>
<html>
<head>
</head>
<body style="font-family: monospace;">
	<?php 
	$bulan = array(
		1 => 'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	if (isset($pekerja) && !empty($pekerja)) {
		$jumlah = count($pekerja);
		for ($i=0; $i < ceil($jumlah/5); $i++) { 
			echo "<div>";
			for ($j=(5 * $i); $j < (5 * $i) + 5; $j++) { 
				if (isset($pekerja[$j]) && !empty(isset($pekerja[$i]))) {
					$value = $pekerja[$j];
					if ($value->jenis == "Utama") {
						?>
							<div style="height: 85.60mm;width: 53.98mm;border: 1px solid black;color: black;float: left;background-image: url(<?php echo base_url('assets/img/SimForklift/front_utama.png') ?>);background-repeat: no-repeat;background-attachment: fixed;background-size: 100% 100%;margin-right: 2mm;margin-bottom: 5mm;margin-left: 2mm;">
								<div style="width: 100%;text-align: center;margin-top: 8mm;">
									<img src="<?php echo $value->photo ?>" style="height: 47mm;width-left: 35mm;border: 2px solid white;">
								</div>
								<div style="width: 100%;text-align: center;font-weight: bold;"><?php echo substr($value->nama,0,20) ?></div>
								<div style="width: 100%;text-align: center;font-weight: bold;"><?php echo substr($value->noind,0,20) ?></div>
								<div style="width: 100%;text-align: center;font-weight: bold;"><?php echo substr($value->seksi,0,20) ?></div>
							</div>
						<?php
					}elseif ($value->jenis == "Cadangan") {
						?>
							<div style="height: 85.60mm;width: 53.98mm;border: 1px solid black;color: yellow;float: left;background-image: url(<?php echo base_url('assets/img/SimForklift/front_cadangan.png') ?>);background-repeat: no-repeat;background-attachment: fixed;background-size: 100% 100%;margin-right: 2mm;margin-bottom: 5mm;margin-left: 2mm;">
								<div style="width: 100%;text-align: center;margin-top: 8mm;">
									<img src="<?php echo $value->photo ?>" style="height: 47mm;width: 35mm;border: 2px solid white;">
								</div>
								<div style="width: 100%;text-align: center;font-weight: bold;"><?php echo substr($value->nama,0,20) ?></div>
								<div style="width: 100%;text-align: center;font-weight: bold;"><?php echo substr($value->noind,0,20) ?></div>
								<div style="width: 100%;text-align: center;font-weight: bold;"><?php echo substr($value->seksi,0,20) ?></div>
							</div>
						<?php
					}
				}
			}
			echo "</div><div>";
			for ($j=(5 * $i); $j < (5 * $i) + 5; $j++) { 
				if (isset($pekerja[$j]) && !empty(isset($pekerja[$i]))) {
					$value = $pekerja[$j];
					?>
						<div style="height: 85.60mm;width: 53.98mm;border: 1px solid black;color: black;float: left;background-image: url(<?php echo base_url('assets/img/SimForklift/back.png') ?>);background-repeat: no-repeat;background-attachment: fixed;background-size: 100% 100%;margin-right: 2mm;margin-bottom: 5mm;margin-left: 2mm;font-family: calibri;">
							<div style="width: 100%;font-size: 9pt;color: white;font-weight: bold;margin-top: 16mm;text-align: center;">SIM FORKLIFT</div>
							<div style="width: 100%;font-size: 8pt;color: white;font-weight: bold;text-align: center;">SURAT IJIN MENGEMUDI FORKLIFT</div>
							<div style="width: 100%;font-size: 9pt;padding-left: 5mm;font-weight: bold;margin-top: 3mm;">KETENTUAN:</div>
							<div style="width: 100%;font-size: 9pt;">
								<ol style="margin-top: 0;margin-bottom: 0;">
									<li>SIM harus dibawa dan dikenakan di depan saku pada saat mengemudikan forklift.</li>
									<li>SIM tidak boleh dipinjamkan / digunakan orang lain.</li>
								</ol>
							</div>
							<div style="width: 100%;font-size: 9pt;text-align: right;padding-right: 5mm;">Yogyakarta, <?php echo $bulan[intval(date('m',strtotime($value->mulai_berlaku)))].' '.date('Y',strtotime($value->mulai_berlaku)) ?></div>
							<div style="width: 100%;font-size: 9pt;text-align: right;padding-right: 5mm;">TIM UP2L</div>
							<div style="width: 100%;font-size: 8pt;padding-left: 5mm;">Berlaku: s/d <?php echo $bulan[intval(date('m',strtotime($value->selesai_berlaku)))].' '.date('Y',strtotime($value->selesai_berlaku)) ?></div>
							<div style="width: 100%;text-align: center;">
								<img src="<?php echo base_url('assets/plugins/barcode.php?size=60&text='.$value->noind);?>" width="180px" height="34px">
							</div>
							<div style="width: 100%;text-align: center;letter-spacing: 15px;"><?php echo $value->noind ?></div>
						</div>
					<?php
				}
			}
			echo "</div>";
			?>
				<div style="page-break-after: always;"></div>
			<?php 
		}
	}
	?>
</body>
</html>