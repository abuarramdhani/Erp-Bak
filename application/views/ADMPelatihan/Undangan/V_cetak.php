<div style="width: 210mm;height: 297mm;">
	<?php for ($i=0; $i <= 3; $i++) { ?>
		<div style="width: 104mm;height: 148.5mm;float: left;border: 0.5mm solid black;">
			<div style="margin: 4mm;border: 1mm solid black;height: 137.5mm;width: 94mm;border-style: double;">
				<!-- header -->
				<div style="margin-left: 2mm;margin-top: 2mm;height: 15mm;width: 90mm;border-bottom: 1mm solid black">
					<div style="float: left;width: 12mm;height: 15mm;">
						<img src="<?php  echo base_url('/assets/img/logo.png'); ?>" width="40" height="50">
					</div>
					<div style="float: left;width: 78mm;height: 15mm;text-align: center;font-size: 25pt">
						<label><b>UNDANGAN</b></label>
					</div>
				</div>
				<!-- content -->
				<div style="margin-left: 2mm;margin-top: 2mm;height: 115mm;width: 90mm;font-family: 'Trebuchet MS'">
					<div style="float: left;width: 90mm;height: 3mm;text-align: right;font-size: 10pt">
						<?php $bln = array(
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
									'Desember'); 
							$hr = array(
								'',
								'Minggu',
								'Senin',
								'Selasa',
								'Rabu',
								'Kamis',
								'Jumat',
								'Sabtu');?>
						<p>Yogyakarta, <?php echo $undangan['0']['tg2']." ".$bln[$undangan['0']['b2']]." ".$undangan['0']['th2'] ?></p>
					</div>
					<!-- <div style="float: left;width: 90mm;height: 10mm;text-align: center;font-size: 20pt;color: red;">
						<p><u>UNDANGAN</u></p>
					</div> -->
					<div style="float: left;width: 90mm;height: 18mm;text-align: left;">
						<div style="float: left;width: 25%;height: 15mm;">
							<p>Kepada Yth.<br>Bapak/Ibu:</p>
						</div>
						<div style="float: left;width: 75%;height: 15mm;">
							<table border="1" style="font-size: 7pt;border-collapse: collapse;text-align: center;<?php if ($undangan['0']['keterangan']== '3') {echo "margin-top:6mm";} ?>">
								<tr>
									<td width="22mm"><?php if (isset($peserta['0'])) {echo ucwords(strtolower($peserta['0']));}  ?></td>
									<td width="22mm"><?php if (isset($peserta['1'])) {echo ucwords(strtolower($peserta['1']));}  ?></td>
									<td width="22mm"><?php if (isset($peserta['2'])) {echo ucwords(strtolower($peserta['2']));}  ?></td>
								</tr>
								<?php if ($undangan['0']['keterangan'] == '15') { ?>
									<tr>
										<td><?php if (isset($peserta['3'])) {echo ucwords(strtolower($peserta['3']));}  ?></td>
										<td><?php if (isset($peserta['4'])) {echo ucwords(strtolower($peserta['4']));}  ?></td>
										<td><?php if (isset($peserta['5'])) {echo ucwords(strtolower($peserta['5']));}  ?></td>
									</tr>
									<tr>
										<td><?php if (isset($peserta['6'])) {echo ucwords(strtolower($peserta['6']));}else{echo "&nbsp;";}  ?></td>
										<td><?php if (isset($peserta['7'])) {echo ucwords(strtolower($peserta['7']));}  ?></td>
										<td><?php if (isset($peserta['8'])) {echo ucwords(strtolower($peserta['8']));}  ?></td>
									</tr>
									<tr>
										<td><?php if (isset($peserta['9'])) {echo ucwords(strtolower($peserta['9']));}else{echo "&nbsp;";}  ?></td>
										<td><?php if (isset($peserta['10'])) {echo ucwords(strtolower($peserta['10']));}  ?></td>
										<td><?php if (isset($peserta['11'])) {echo ucwords(strtolower($peserta['11']));}  ?></td>
									</tr>
									<tr>
										<td><?php if (isset($peserta['12'])) {echo ucwords(strtolower($peserta['12']));}else{echo "&nbsp;";}  ?></td>
										<td><?php if (isset($peserta['13'])) {echo ucwords(strtolower($peserta['13']));}  ?></td>
										<td><?php if (isset($peserta['14'])) {echo ucwords(strtolower($peserta['14']));}  ?></td>
									</tr>
								<?php } ?>
							</table>
						</div>
					</div>
					<div style="height: 60mm;">
						<p>
							Dengan Hormat,<br>Mengharapkan kehadiran Bapak/Ibu pada : 
						</p>
						<table style="margin-left: 5mm;">
							<tr>
								<td style="width: 16mm">Hari</td>
								<td>:</td>
								<td><?php echo $hr[$undangan['0']['hr1']];?></td>
							</tr>
							<tr>
								<td>Tanggal</td>
								<td>:</td>
								<td><?php echo $undangan['0']['tg1']." ".$bln[$undangan['0']['b1']]." ".$undangan['0']['th1'];?></td>
							</tr>
							<tr>
								<td>Waktu</td>
								<td>:</td>
								<td><?php $wkt = explode(":", $undangan['0']['wkt']); echo $wkt['0'].".".$wkt['1']." - selesai";?></td>
							</tr>
							<tr>
								<td>Tempat</td>
								<td>:</td>
								<td><?php echo $undangan['0']['tempat'];?></td>
							</tr>
							<tr>
								<td>Acara</td>
								<td>:</td>
								<td><b><?php echo $undangan['0']['acara'];?></b></td>
							</tr>
						</table>
						<p>
							Mohon hadir tepat waktu. Atas kehadiran dan kerja sama Bapak/Ibu, Kami ucapkan terima kasih.
						</p>
					</div>
						
					<div style="width: 30mm;height: 10mm;float: right;">
						<p style="text-align: center;">
							Hormat kami,<br><br><br>
						</p>
						<p style="text-align: center;"><?php echo ucwords(strtolower($undangan['0']['app_name']))  ?></p>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	
</div>