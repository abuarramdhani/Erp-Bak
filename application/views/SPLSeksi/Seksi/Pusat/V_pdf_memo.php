<div style="padding: 5mm">
	<div style="border: 3px solid black;padding: 1%;height: 190mm">
		<table style="width: 100%;text-align: center;border-bottom: 5px solid black">
			<tr>
				<td rowspan="2"><img src="<?php  echo base_url('/assets/img/logo.png'); ?>" width="40" height="50"></td>
				<td>
					<h1 style="font-size: 16pt"><u><b>MEMO PRESENSI</b></u></h1>
				</td>
			</tr>
			<tr>
				<td>
					<h2 style="font-size: 13pt">CV. KARYA HIDUP SENTOSA</h2>
				</td>
			</tr>
		</table>
		<br>
		<div style="font-size: 9pt">
			Kepada Yth. :<br>
			<b>Seksi Hubungan Kerja</b><br>
			Departemen Personalia<br>
			<br>
			Dengan Hormat,<br>
			Dengan ini disampaikan bahwa saya :
			<table style="width: 90%;padding-left: 5%;font-size: 9pt">
				<tr>
					<td>Nama</td>
					<td> : </td>
					<td><?php echo ucwords(strtolower($tpribadi->nama)) ?></td>
				</tr>
				<tr>
					<td>No. Induk</td>
					<td> : </td>
					<td><?php echo $memo->noind ?></td>
				</tr>
				<tr>
					<td>Seksi / Unit</td>
					<td> : </td>
					<td><?php echo ucwords(strtolower($tpribadi->seksi)) ?> / <?php echo ucwords(strtolower($tpribadi->unit)) ?></td>
				</tr>
			</table>
			<p style="font-size: 9pt">
				Benar-benar masuk dan pulang kerja sesuai jam kerja yang berlaku di<br> CV. Karya Hidup sentosa, pada :
			</p>
			<table style="width: 100%;padding-left: 5%;font-size: 9pt">
			<tr>
				<td>Hari / Tgl.</td>
				<td>:</td>
				<td colspan="2"><?php echo $memo->tgl ?></td>
				<td>Shift</td>
				<td>:</td>
				<td colspan="2"><?php echo $shift->kd_shift ?> <?php echo $shift->shift ?></td>
			</tr>
			<tr>
				<td style="width: 17%">Jam Masuk</td>
				<td style="width: 3%">:</td>
				<td style="width: 20%"><?php echo $memo->masuk ?></td>
				<td style="width: 10%">WIB</td>
				<td style="width: 17%">Jam Pulang</td>
				<td style="width: 3%">:</td>
				<td style="width: 20%"><?php echo $memo->pulang ?></td>
				<td style="width: 10%">WIB</td>
			</tr>
		</table>
		<p style="font-size: 9pt">
			Dengan Alasan :
		</p>
		<table style="width: 100%;font-size: 9pt">
			<?php  
				$b = count($alasan_master);
				for($i = 0;$i < ceil($b/2);$i++) { ?>
					<tr>
						<td style="text-align: center;vertical-align: center;width: 5%;">
							<?php if (isset($alasan_master[$i])) { 
								$ada = "0";
								foreach ($alasan_memo as $als) {
									if ($als['alasan_id'] == $alasan_master[$i]['alasan_id']) {
										echo "<table><tr><td style='width: 5mm;height: auto;aspect-ratio: 1/1;border: 1px solid black;font-weight: 900'><b>√</b></td></tr></table>";
										$ada = "1";
									}
								}
								if ($ada == "0") {
									echo "<table><tr><td style='width: 5mm;height: auto;aspect-ratio: 1/1;border: 1px solid black'>&nbsp;</td></tr></table>";
								}
							} ?>
						</td>
						<td style="width: 45%">
							<?php if (isset($alasan_master[$i])) { ?>
								<?php echo $alasan_master[$i]['alasan'] ?>
								<?php 
									if ($alasan_master[$i]['perlu_info'] == '1') { 
										foreach ($alasan_memo as $als) {
											if ($als['alasan_id'] == $alasan_master[$i]['alasan_id']) {
												echo "\"<i>".$als['info']."</i>\"";
											}
										}
									} ?>
							<?php } ?>
								
						</td>
						<td style="text-align: center;vertical-align: center;width: 5%">
							<?php 
							if (isset($alasan_master[$i+ceil($b/2)])) { 
								$ada = "0";
								foreach ($alasan_memo as $als) {
									if ($als['alasan_id'] == $alasan_master[$i+ceil($b/2)]['alasan_id']) {
										echo "<table><tr><td style='width: 5mm;height: auto;aspect-ratio: 1/1;border: 1px solid black;font-weight: 900'><b>√</b></td></tr></table>";
										$ada = "1";
									}
								}
								if ($ada == "0") {
									echo "<table><tr><td style='width: 5mm;height: auto;aspect-ratio: 1/1;border: 1px solid black'>&nbsp;</td></tr></table>";
								}
							} ?>
						</td>
						<td style="width: 45%">
							<?php if (isset($alasan_master[$i+ceil($b/2)])) { ?>
								<?php echo $alasan_master[$i+ceil($b/2)]['alasan'] ?>
								<?php 
									if ($alasan_master[$i+ceil($b/2)]['perlu_info'] == '1') {
										foreach ($alasan_memo as $als) {
											if ($als['alasan_id'] == $alasan_master[$i+ceil($b/2)]['alasan_id']) {
												echo "\"<i>".$als['info']."</i>\"";
											}
										}
									} ?>
							<?php } ?>
						</td>
					</tr>
				<?php
				} ?>
		</table>
		<p style="font-size: 9pt">
			Demikian pemberitahuan ini saya sampaikan, terima kasih.
		</p>
		<table style="width: 100%;text-align: center;font-size: 9pt">
			<tr>
				<td style="width: 33%"></td>
				<td style="width: 33%"></td>
				<td style="width: 33%" style="text-align: left">Yogyakarta,</td>
			</tr><tr>
				<td></td>
				<td>Menyetujui</td>
				<td>Mengetahui</td>
			</tr><tr>
				<td>pekerja*</td>
				<td>Atasan Langsung**</td>
				<td>Atasan dari Atasan Langsung***</td>
			</tr>
			<tr>
				<td>
					<br>
					<br>
					<br>
					<br>
					( <?php 
						foreach ($atasan as $ats) {
							if ($ats['noind'] == $memo->noind) { 
								echo ucwords(strtolower($ats['nama']));
							}
						} 
					?> )
				</td>
				<td>
					<br>
					<br>
					<br>
					<br>
					( <?php 
						foreach ($atasan as $ats) {
							if ($ats['noind'] == $memo->atasan) { 
								echo ucwords(strtolower($ats['nama']));
							}
						} 
					?> )
				</td>
				<td>
					<br>
					<br>
					<br>
					<br>
					( <?php 
						foreach ($atasan as $ats) {
							if ($ats['noind'] == $memo->atasan_dua) { 
								echo ucwords(strtolower($ats['nama']));
							}
						} 
					?> )
				</td>
			</tr>
			<tr>
				<td>Saksi</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>
					<br>
					<br>
					<br>
					<br>
					(<?php echo $memo->saksi ?>)
				</td>
				<td></td>
				<td></td>
			</tr>
		</table>
		<table style="width: 100%;font-size: 7pt">
			<tr>
				<td style="width: 3%">1.</td>
				<td style="width: 47%">Beri tanda contreng (√) pada kolom yang sesuai</td>
				<td style="width: 50%"></td>
			</tr>
			<tr>
				<td>2.</td>
				<td>*) Pekerja bersangkutan<br>**) Minimal Kepala Seksi</td>
				<td>***) Minimal Ass/Ka. Unit, jika lebih dari 3 hari,<br>masuk Seksi Hubungan Kerja.</td>
			</tr>
		</table>
		</div>
	</div>
	<div>
		<table style="font-size: 8pt;width: 100%">
			<tr>
				<td style="width: 75%">
					<?php echo "dicetak dari ERP responsibility SPL Operator oleh ".($this->session->user) ?>
				</td>
				<td>Nomor</td>
				<td> : </td>
				<td>FRM-HRM-00-36</td>
			</tr>
			<tr>
				<td></td>
				<td>Revisi</td>
				<td> : </td>
				<td>03</td>
			</tr>
		</table>
	</div>
</div>
