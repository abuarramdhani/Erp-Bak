<?php if (isset($puas) and !empty($puas)) {
	// print_r($puas);exit();
	foreach($puas as $key){ ?>
	<div class="row" style="margin-bottom: 10px;border-bottom: 1px solid black">
		<div style="width: 10%;float: left;">
			<img src="<?php  echo base_url('/assets/img/logo.png'); ?>" width="100" height="125">
		</div>
		<div style="text-align: center;width: 90%;float: left;height: 80px;padding-top: 10px">
			<h4>
				PENGUKURAN INTERNALISASI BUDAYA PERUSAHAAN
				<br>
				CV. KARYA HIDUP SENTOSA
			</h4>
		</div>
	</div>
	<div class="row">
		<div>
			<?php 
			$periode = "";
			$pilihan = "<tr><td>";
			if (isset($sort) and !empty($sort)) {
				foreach ($sort as $value) { 
					foreach ($value as $val) {
						if ($val['label'] == 'Periode') {
							$bln = array(
									'',
									'Januari',
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
							$awal = explode("-", $val['periode_awal']);
							$akhir = explode("-", $val['periode_akhir']);
							$periode = " ".$awal['2']." ".$bln[intval($awal['1'])]." ".$awal['0']." - ".$akhir['2']." ".$bln[intval($akhir['1'])]." ".$akhir['0'];
						}elseif ($val['label'] == 'Departemen') {
							$pilihan .= " <tr><td class='text-right' style='padding-right: 10px'>".$val['label']."</td><td>:</td><td style='padding-left:10px'> ".$val['department_name']."</td></tr>";
						}elseif ($val['label'] == 'Seksi/Unit') {
							$pilihan .= " <tr><td class='text-right' style='padding-right: 10px'>".$val['label']."</td><td>:</td><td style='padding-left:10px'> ".$val['section_name']." / ".$val['unit_name']."</td></tr>";
						}elseif ($val['label'] == 'Masa Kerja') {
							$pilihan .= " <tr><td class='text-right' style='padding-right: 10px'>".$val['label']."</td><td>:</td><td style='padding-left:10px'> ".$val['masa_kerja']."</td></tr>";
						}elseif ($val['label'] == 'Jenis Kelamin') {
							$pilihan .= " <tr><td class='text-right' style='padding-right: 10px'>".$val['label']."</td><td>:</td><td style='padding-left:10px'> ".$val['jenkel']."</td></tr>";
						}elseif ($val['label'] == 'Usia') {
							$pilihan .= " <tr><td class='text-right' style='padding-right: 10px'>".$val['label']."</td><td>:</td><td style='padding-left:10px'> ".$val['usia']."</td></tr>";
						}elseif ($val['label'] == 'Suku') {
							$pilihan .= " <tr><td class='text-right' style='padding-right: 10px'>".$val['label']."</td><td>:</td><td style='padding-left:10px'> ".$val['nama_suku']." - ".$val['asal']."</td></tr>";
						}elseif ($val['label'] == 'Status Jabatan') {
							$pilihan .= " <tr><td class='text-right' style='padding-right: 10px'>>".$val['label']."</td><td>:</td><td style='padding-left:10px'> ".$val['status_jabatan']."</td></tr>";
						}elseif ($val['label'] == 'Pendidikan') {
							$pilihan .= " <tr><td class='text-right' style='padding-right: 10px'>".$val['label']."</td><td>:</td><td style='padding-left:10px'> ".$val['pendidikan']."</td></tr>";
						}

						
					}	
				}
			} ?>
				<p id="PNBPPeriodePenarikan">Periode Penarikan Data : <?php echo $periode ?></p>
				<p id="PNBPPartisipan">Jumlah Partisipan : <?php echo $key['peserta'] ?></p>
				<p id="PNBPPilih">Sorted By :</p>
				<table style="border-collapse: collapse;width: 100%;">
					<?php echo $pilihan ?>
				</table>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2" id="chartBig">
			<canvas id="canvasReportPNBP"></canvas>
		</div>
	</div>
	<div class="row" style="text-align: center;margin-top: 20px">
		<img style="border:1px solid black;width: 100%" src="<?php echo $img ?>">
	</div>
	<div class="row" style="margin-top: 20px">
		<div style="width: 100%;align:center;">
			<table style="border-collapse: collapse;width: 80%;border: 1px solid rgb(213,0,249)">
				<tr>
					<td rowspan="2" style="vertical-align: middle;text-align: center;border: 1px solid rgb(213,0,249)">Kepuasan Kerja</td>
					<td style="vertical-align: middle;text-align: center;border: 1px solid rgb(213,0,249)">Rata - Rata</td>
					<td style="vertical-align: middle;text-align: center;border: 1px solid rgb(213,0,249)">Presentase</td>
				</tr>
				<tr>
					<td class="text-center" style="vertical-align: middle;text-align: center;border: 1px solid rgb(213,0,249)"><?php echo $key['rata'] ?></td>
					<td class="text-center" style="vertical-align: middle;text-align: center;border: 1px solid rgb(213,0,249)"><?php echo $key['persen'] ?></td>
				</tr>
			</table>
		</div>
	</div>
<?php } 
} ?>
	