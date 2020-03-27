<?php 

	if (isset($table) and !empty($table)) {
		$seksi = '';
		$pekerjaan = '';
		$no = 1;
		foreach ($table as$value) {
?>			
<div>
	<div>
		Lampiran Surat Keputusan Direktur Utama No. <?php echo $nomor;  ?>
		<br>
		BESAR KENAIKAN UPAH (GAJI POKOK) PEKERJA NON STAF TAHUN <?php echo $tahun['0']['tahun']; ?>
		<br>
		Per 1 Januari <?php echo $tahun['0']['tahun']; ?>
	</div>
	<div>
		<table style="width: 100%;border-collapse: collapse;font-size: 9pt;">
			<thead>
				<tr>
					<th style="border-top: 1px solid black;border-bottom: 1px solid black;width: 5%">No</th>
					<th style="border-top: 1px solid black;border-bottom: 1px solid black;width: 10%">Noind</th>
					<th style="border-top: 1px solid black;border-bottom: 1px solid black;width: 25%">Nama Operator</th>
					<th style="border-top: 1px solid black;border-bottom: 1px solid black;width: 10%">Skor</th>
					<th style="border-top: 1px solid black;border-bottom: 1px solid black;width: 12%">Gol Nilai</th>
					<th style="border-top: 1px solid black;border-bottom: 1px solid black;width: 12%">Naik/Bln</th>
					<th style="border-top: 1px solid black;border-bottom: 1px solid black;width: 13%">Gp Lama</th>
					<th style="border-top: 1px solid black;border-bottom: 1px solid black;width: 13%">Gp Baru</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					if (isset($value) and !empty($value)) {
						$unit = '';
						$seksi = '';
						$pekerjaan = '';
						foreach ($value as $key) {
							if ($seksi !== $key['seksi'] or $pekerjaan !== $key['pekerjaan']) { ?>
							<?php if ($unit !== '' and $unit !== $key['unit'])
							{
								// echo '<pagebreak/>';
								$no = 1;
							} ?>
								<?php if ($unit !== $key['unit']): ?>
									<tr>
										<td colspan="8">
											*> &nbsp; Unit : <?php echo $key['unit'] ?>
										</td>
									</tr>
								<?php endif ?>

								<?php if ($seksi !== $key['seksi']): ?>
									<tr>
										<td colspan="8">
											**>	&nbsp; Seksi : <?php echo $key['seksi'] ?>
										</td>
									</tr>
								<?php endif ?>

								<tr>
									<td colspan="4">
										<b>Nama Pekerjaan: <?php echo $key['pekerjaan'] ?></b>
									</td>
									<td colspan="4">
										<b>Gol Pekerjaan: <?php echo $key['gol_kerja'] ?></b>
									</td>
								</tr>
								<tr>
									<td style="text-align: center;">
										<?php echo $key['number']; ?>
									</td>
									<td style="text-align: center;">
										<?php echo $key['noind'] ?>
									</td>
									<td>
										<?php echo $key['nama'] ?>
									</td>
									<td style="text-align: center;">
										<?php echo $key['skor'] ?>
									</td>
									<td style="text-align: center;">
										<?php echo $key['gol_nilai'] ?>
									</td>
									<td style="text-align: center;">
										<?php echo $key['nominal_kenaikan'] ?>
									</td>
									<td style="text-align: center;">
										<?php echo number_format($key['gp_lama'])  ?>
									</td>
									<td style="text-align: center;">
										<?php echo number_format($key['gp_baru']) ?>
									</td>
								</tr>
							<?php }else{ ?>
								<tr>
									<td style="text-align: center;">
										<?php echo $key['number']; ?>
									</td>
									<td style="text-align: center;">
										<?php echo $key['noind'] ?>
									</td>
									<td>
										<?php echo $key['nama'] ?>
									</td>
									<td style="text-align: center;">
										<?php echo $key['skor'] ?>
									</td>
									<td style="text-align: center;">
										<?php echo $key['gol_nilai'] ?>
									</td>
									<td style="text-align: center;">
										<?php echo $key['nominal_kenaikan'] ?>
									</td>
									<td style="text-align: center;">
										<?php echo number_format($key['gp_lama'])  ?>
									</td>
									<td style="text-align: center;">
										<?php echo number_format($key['gp_baru']) ?>
									</td>
								</tr>
							<?php }

							$unit = $key['unit'];
							$seksi = $key['seksi'];
							$pekerjaan = $key['pekerjaan'];
						}
					}
				?>
			</tbody>
		</table>
	</div>
</div>
<div style="page-break-before: always"></div>
<?php }
	}
?>