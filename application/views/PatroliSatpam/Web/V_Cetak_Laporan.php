<style type="text/css">
	.kolom_kecil td{
		width: 35px;
	}
	.padingg td{
		padding-left: 10px;
		padding-right: 10px;
	}
</style>
<?php if (1==1): ?>
<!-- Lembar 1 -->
<div style="width: 100%; height: 100%; border: 1px solid black; padding: 10px;" >
	<table width="100%" border="0" style="border-collapse: collapse;">
		<tr>
			<td style="width: 20%"></td>
			<td style="width: 20%; text-align: right;">
				<img width="40" src="<?=base_url('assets/img/logo.png')?>">
			</td>
			<td style="width: 20%; text-align: center; font-weight: bold; width: 300px;">
				<h2>
					Laporan Patroli Dengan Amano<br>Satuan Pengamanan Pusat
				</h2>
			</td>
			<td style="width: 20%; text-align: left;">
				<img width="40" src="<?=base_url('assets/img/HSE_LOGO.png')?>">
			</td>
			<td style="width: 20%; text-align: right;" colspan="0">
				<table border="1" style="border-collapse: collapse;">
					<tr>
						<td style="text-align: left; padding-left: 2px;">No Doc</td>
						<td style="text-align: left; padding-left: 2px;">FRM-HRM-00-SHE-02 &nbsp;&nbsp;&nbsp;</td>
					</tr>
					<tr>
						<td style="text-align: left; padding-left: 2px;">Rev No</td>
						<td style="text-align: left; padding-left: 2px;">00</td>
					</tr>
					<tr>
						<td style="text-align: left; padding-left: 2px;">Rev Date &nbsp;&nbsp;&nbsp;</td>
						<td style="text-align: left; padding-left: 2px;">27 September 2016</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="5"><b>Bulan <?=$bulan?> <?=$fullyear?></b></td>
		</tr>
	</table>
	<table width="100%" border="0" style="border-collapse: collapse;">
			<tr>
				<td>
					<table style="border-collapse: collapse; text-align: center;" border="1">
						<tr>
							<td rowspan="2" style="font-weight: bold;">No<br>Pos</td>
							<?php for ($i=1; $i <= 8; $i++) { 
								$x = (strlen($i) == 1) ? '0'.$i:$i; ?>
								<td colspan="4"><?= $month.'/'.$x.'/'.$year ?></td>
								<?php } ?>
							</tr>
							<tr>
								<?php for ($i=1; $i <= 8; $i++) { 
									if (!empty($satpam[$i-1])) {
										$arr = array_column($satpam[$i-1], 'nama');
										for ($z=0; $z < count($arr); $z++) { 
											$arr[$z] = explode(' ', $arr[$z])[0];
										}
										echo '<td colspan="4">'.implode($arr, ',').'</td>';
									}else{
										echo '<td colspan="4">-</td>';
									}
								} ?>
							</tr>
							<?php for($a=1; $a <= $max; $a++){ //row ?>
							<tr class="kolom_kecil">
								<td style="font-weight: bold;"><?= $a ?></td>
								<?php
						for ($h=0; $h < 8; $h++) { //kolom kecil
							if (empty($list[$h])) {
								echo "<td>-</td>";
								echo "<td>-</td>";
								echo "<td>-</td>";
								echo "<td>-</td>";
							}else{
								$key = array_search($a, array_column($list[$h], 'pos'));
								if ($key === false) {
									echo "<td>-</td>";
									echo "<td>-</td>";
									echo "<td>-</td>";
									echo "<td>-</td>";
								}else{
									$r1 = empty($list[$h][$key]['r1']) ? '-':$list[$h][$key]['r1'];
									$r2 = empty($list[$h][$key]['r2']) ? '-':$list[$h][$key]['r2'];
									$r3 = empty($list[$h][$key]['r3']) ? '-':$list[$h][$key]['r3'];
									$r4 = empty($list[$h][$key]['r4']) ? '-':$list[$h][$key]['r4'];
									$color = strpos($r1, 'N') ? 'style="color:red"': '';
									echo "<td ".$color.">".substr($r1, 0,5)."</td>";

									$color = strpos($r2, 'N') ? 'style="color:red"': '';
									echo "<td ".$color.">".substr($r2, 0,5)."</td>";

									$color = strpos($r3, 'N') ? 'style="color:red"': '';
									echo "<td ".$color.">".substr($r3, 0,5)."</td>";

									$color = strpos($r4, 'N') ? 'style="color:red"': '';
									echo "<td ".$color.">".substr($r4, 0,5)."</td>";
								}
							}
						}
						?>
					</tr>
					<?php } ?>
				</table>
			</td>
		</tr>
		<tr>
			<td style="height: 20px;"></td>
		</tr>
		<tr>
			<td>
				<table style="border-collapse: collapse; text-align: center;" border="1">
					<tr>
						<td rowspan="2"><b>No<br>Pos</b></td>
						<?php for ($i=9; $i <= 16; $i++) { 
							$x = (strlen($i) == 1) ? '0'.$i:$i; ?>
							<td colspan="4"><?= $month.'/'.$x.'/'.$year ?></td>
							<?php } ?>
						</tr>
						<tr>
							<?php for ($i=9; $i <= 16; $i++) { 
								if (!empty($satpam[$i-1])) {
									$arr = array_column($satpam[$i-1], 'nama');
									for ($z=0; $z < count($arr); $z++) { 
										$arr[$z] = explode(' ', $arr[$z])[0];
									}
									echo '<td colspan="4">'.implode($arr, ',').'</td>';
								}else{
									echo '<td colspan="4">-</td>';
								}
							} ?>
						</tr>
						<?php for($a=1; $a <= $max; $a++){ //row ?>
						<tr class="kolom_kecil">
							<td style="font-weight: bold;"><?= $a ?></td>
							<?php
						for ($h=8; $h < 16; $h++) { //kolom kecil
							if (empty($list[$h])) {
								echo "<td>-</td>";
								echo "<td>-</td>";
								echo "<td>-</td>";
								echo "<td>-</td>";
							}else{
								$key = array_search($a, array_column($list[$h], 'pos'));
								if ($key === false) {
									echo "<td>-</td>";
									echo "<td>-</td>";
									echo "<td>-</td>";
									echo "<td>-</td>";
								}else{
									$r1 = empty($list[$h][$key]['r1']) ? '-':$list[$h][$key]['r1'];
									$r2 = empty($list[$h][$key]['r2']) ? '-':$list[$h][$key]['r2'];
									$r3 = empty($list[$h][$key]['r3']) ? '-':$list[$h][$key]['r3'];
									$r4 = empty($list[$h][$key]['r4']) ? '-':$list[$h][$key]['r4'];
									$color = strpos($r1, 'N') ? 'style="color:red"': '';
									echo "<td ".$color.">".substr($r1, 0,5)."</td>";

									$color = strpos($r2, 'N') ? 'style="color:red"': '';
									echo "<td ".$color.">".substr($r2, 0,5)."</td>";

									$color = strpos($r3, 'N') ? 'style="color:red"': '';
									echo "<td ".$color.">".substr($r3, 0,5)."</td>";

									$color = strpos($r4, 'N') ? 'style="color:red"': '';
									echo "<td ".$color.">".substr($r4, 0,5)."</td>";
								}
							}
						}
						?>
					</tr>
					<?php } ?>
				</table>
			</td>
		</tr>
	</table>
</div>

<pagebreak>
	<!-- Lembar 2 -->
	<div style="width: 100%; height: 100%; border: 1px solid black; padding: 10px;" >
		<table width="100%" border="0" style="border-collapse: collapse;">
			<tr>
				<td>
					<table style="border-collapse: collapse; text-align: center;" border="1">
						<tr>
							<td rowspan="2" style="font-weight: bold;">No<br>Pos</td>
							<?php for ($i=17; $i <= 24; $i++) { 
								$x = (strlen($i) == 1) ? '0'.$i:$i; ?>
								<td colspan="4"><?= $month.'/'.$x.'/'.$year ?></td>
								<?php } ?>
							</tr>
							<tr>
								<?php for ($i=17; $i <= 24; $i++) { 
									if (!empty($satpam[$i-1])) {
										$arr = array_column($satpam[$i-1], 'nama');
										for ($z=0; $z < count($arr); $z++) { 
											$arr[$z] = explode(' ', $arr[$z])[0];
										}
										echo '<td colspan="4">'.implode($arr, ',').'</td>';
									}else{
										echo '<td colspan="4">-</td>';
									}
								} ?>
							</tr>
							<?php for($a=1; $a <= $max; $a++){ //row ?>
							<tr class="kolom_kecil">
								<td style="font-weight: bold;"><?= $a ?></td>
								<?php
						for ($h=16; $h < 24; $h++) { //kolom kecil
							if (empty($list[$h])) {
								echo "<td>-</td>";
								echo "<td>-</td>";
								echo "<td>-</td>";
								echo "<td>-</td>";
							}else{
								$key = array_search($a, array_column($list[$h], 'pos'));
								if ($key === false) {
									echo "<td>-</td>";
									echo "<td>-</td>";
									echo "<td>-</td>";
									echo "<td>-</td>";
								}else{
									$r1 = empty($list[$h][$key]['r1']) ? '-':$list[$h][$key]['r1'];
									$r2 = empty($list[$h][$key]['r2']) ? '-':$list[$h][$key]['r2'];
									$r3 = empty($list[$h][$key]['r3']) ? '-':$list[$h][$key]['r3'];
									$r4 = empty($list[$h][$key]['r4']) ? '-':$list[$h][$key]['r4'];
									$color = strpos($r1, 'N') ? 'style="color:red"': '';
									echo "<td ".$color.">".substr($r1, 0,5)."</td>";

									$color = strpos($r2, 'N') ? 'style="color:red"': '';
									echo "<td ".$color.">".substr($r2, 0,5)."</td>";

									$color = strpos($r3, 'N') ? 'style="color:red"': '';
									echo "<td ".$color.">".substr($r3, 0,5)."</td>";

									$color = strpos($r4, 'N') ? 'style="color:red"': '';
									echo "<td ".$color.">".substr($r4, 0,5)."</td>";
								}
							}
						}
						?>
					</tr>
					<?php } ?>
				</table>
			</td>
		</tr>
		<tr>
			<td style="height: 20px;"></td>
		</tr>
		<tr>
			<td>
				<table style="border-collapse: collapse; text-align: center;" border="1">
					<tr>
						<td rowspan="2"><b>No<br>Pos</b></td>
						<?php for ($i=25; $i <= $last; $i++) { 
							$x = (strlen($i) == 1) ? '0'.$i:$i; ?>
							<td colspan="4"><?= $month.'/'.$x.'/'.$year ?></td>
							<?php } ?>
						</tr>
						<tr>
							<?php for ($i=25; $i <= $last; $i++) { 
								if (!empty($satpam[$i-1])) {
									$arr = array_column($satpam[$i-1], 'nama');
									for ($z=0; $z < count($arr); $z++) { 
										$arr[$z] = explode(' ', $arr[$z])[0];
									}
									echo '<td colspan="4">'.implode($arr, ',').'</td>';
								}else{
									echo '<td colspan="4">-</td>';
								}
							} ?>
						</tr>
						<?php for($a=1; $a <= $max; $a++){ //row ?>
						<tr class="kolom_kecil">
							<td style="font-weight: bold;"><?= $a ?></td>
							<?php
						for ($h=24; $h < $last; $h++) { //kolom kecil
							if (empty($list[$h])) {
								echo "<td>-</td>";
								echo "<td>-</td>";
								echo "<td>-</td>";
								echo "<td>-</td>";
							}else{
								$key = array_search($a, array_column($list[$h], 'pos'));
								if ($key === false) {
									echo "<td>-</td>";
									echo "<td>-</td>";
									echo "<td>-</td>";
									echo "<td>-</td>";
								}else{
									$r1 = empty($list[$h][$key]['r1']) ? '-':$list[$h][$key]['r1'];
									$r2 = empty($list[$h][$key]['r2']) ? '-':$list[$h][$key]['r2'];
									$r3 = empty($list[$h][$key]['r3']) ? '-':$list[$h][$key]['r3'];
									$r4 = empty($list[$h][$key]['r4']) ? '-':$list[$h][$key]['r4'];
									$color = strpos($r1, 'N') ? 'style="color:red"': '';
									echo "<td ".$color.">".substr($r1, 0,5)."</td>";

									$color = strpos($r2, 'N') ? 'style="color:red"': '';
									echo "<td ".$color.">".substr($r2, 0,5)."</td>";

									$color = strpos($r3, 'N') ? 'style="color:red"': '';
									echo "<td ".$color.">".substr($r3, 0,5)."</td>";

									$color = strpos($r4, 'N') ? 'style="color:red"': '';
									echo "<td ".$color.">".substr($r4, 0,5)."</td>";
								}
							}
						}
						?>
					</tr>
					<?php } ?>
				</table>
			</td>
		</tr>
	</table>
</div>

<pagebreak>
<?php endif ?>
	<!-- Lembar 3 -->
	<div style="width: 100%; height: 100%; border: 1px solid black; padding: 10px;" >
		<table width="100%" border="0" style="border-collapse: collapse;">
			<tr>
				<td width="33%" style="border: 0px solid black">
					<img style="height: 600px;" src="<?=base_url('assets/img/map/Denah_Amano.jpg')?>">
				</td>
				<td width="38%" valign="top" style="border: 0px solid black; padding-left: 10px;">
					<table width="100%" border="1" style="border-collapse: collapse; font-size: 14px;">
						<tr>
							<td colspan="2"><b>Kesimpulan :</b></td>
						</tr>
						<?php $x=1; foreach ($kesimpulan as $key): ?>
							<tr>
								<td style="width: 30px; text-align: center;"><?=$x?></td>
								<td style="text-align: justify;"><?= $key['kesimpulan'] ?></td>
							</tr>
						<?php $x++; endforeach ?>
					</table>
				</td>
				<td style="text-align: center; " valign="top" width="28%">
					<table border="1" style="border-collapse: collapse; text-align: center; font-size: 14px;">
						<tr class="padingg">
							<td style="font-weight: bold;">No Pos</td>
							<td style="font-weight: bold;">Patroli /<br>Pos</td>
							<td style="font-weight: bold;">Total</td>
							<td style="font-weight: bold;">% Jumlah<br>Patroli</td>
						</tr>
						<?php $i=0; foreach ($putaran as $p): ?>
						<tr>
							<td style="font-weight: bold;"><?=$p['id']?></td>
							<td><?=$p['putaran'] ?></td>
							<?php if ($i == 0): ?>
								<td rowspan="<?=$max?>"><?= $last*4 ?></td>
							<?php endif ?>
							<td style="font-weight: bold;">
							<?=round($p['putaran']/($last*4)*100, 1)?>
							</td>
						</tr>
						<?php $i++; endforeach ?>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<br>
					<br>
					<br>
					<br>
				</td>
			</tr>
			<tr>
				<td width="33%" style="text-align: center;">
					<table style="border-collapse: collapse; font-size: 14px; text-align: left;" border="1">
						<tr>
							<td colspan="5" style="font-weight: bold;">Keterangan :</td>
						</tr>
						<tr>
							<td style="padding-right: 20px;" colspan="5">Total Patroli Bulan <?=$bulan?> = <?=$last*4?> Kali Patroli</td>
						</tr>
						<tr>
							<td colspan="5">Standar Patroli Bulan <?=$bulan?></td>
						</tr>
						<tr>
							<td colspan="5"><?=$last?> hr x 4 putaran = <?=$last*4?></td>
						</tr>
						<tr>
							<td colspan="5" style="font-weight: bold;">Prosentase :</td>
						</tr>
						<tr>
							<td style="border-right: 0px;text-align: center;">A</td>
							<td rowspan="2" style="border-left: 0px; border-right: 0px;"> X 100%</td>
							<td rowspan="2" style="border-left: 0px; border-right: 0px;">,</td>
							<td style="border-left: 0px; border-right: 0px; text-align: center;"><?=$last*4?></td>
							<td style="border-left: 0px;" rowspan="2"> X 100% = 100%</td>
						</tr>
						<tr>
							<td style="border-right: 0px;text-align: center;">B</td>
							<td style="border-left: 0px; border-right: 0px; text-align: center;"><?=$last*4?></td>
						</tr>
					</table>
				</td>
				<td colspan="2" width="33%" valign="top" style="text-align: center;">
					<table border="1" style="border-collapse: collapse; font-size: 14px; width: 300px;">
						<tr>
							<td style="text-align: left; width: 50%;">Tgl.</td>
							<td style="text-align: left; width: 50%;">Tgl.</td>
						</tr>
						<tr>
							<td style="height: 100px; border-bottom: 0px;" valign="bottom">
								
							</td>
							<td style="height: 100px; border-bottom: 0px;" valign="bottom">
								
							</td>
						</tr>
						<tr>
							<td style="border-top: 0px;">
								<?= trim($ttd2[0]['nama']) ?>
							</td>
							<td style="border-top: 0px;">
								<?= trim($ttd1[0]['nama']) ?>
							</td>
						</tr>
						<tr>
							<td><?= trim(ucwords(strtolower($ttd2[0]['jabatan']))) ?></td>
							<td><?= trim(ucwords(strtolower($ttd1[0]['jabatan']))) ?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>

