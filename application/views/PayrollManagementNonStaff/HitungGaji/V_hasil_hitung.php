<?php
	$no = 1;
	foreach ($hasilHitungGaji as $dataHasil) {
?>
		<tr>
			<td><?php echo $no++; ?></td>
			<td><?php echo $dataHasil['noind']; ?></td>
			<td><?php echo $dataHasil['nama']; ?></td>
			<td><?php echo $dataHasil['gajiPokok']; ?></td>
			<td><?php echo $dataHasil['insentifPrestasi']; ?></td>
			<td><?php echo $dataHasil['insentifKelebihan']; ?></td>
			<td><?php echo $dataHasil['insentifMasukSore']; ?></td>
			<td><?php echo $dataHasil['insentifMasukMalam']; ?></td>
			<td><?php echo $dataHasil['UBT']; ?></td>
			<td><?php echo $dataHasil['UPAMK']; ?></td>
			<td><?php echo $dataHasil['uangLembur']; ?></td>
			<td><?php echo $dataHasil['tambahanKurangBayar']; ?></td>
			<td><?php echo $dataHasil['tambahanLain']; ?></td>
			<td><?php echo $dataHasil['DL']; ?></td>
			<td><?php echo $dataHasil['potonganHTM']; ?></td>
			<td><?php echo $dataHasil['potonganLebihBayar']; ?></td>
			<td><?php echo $dataHasil['potonganGP']; ?></td>
			<td><?php echo $dataHasil['potonganDL']; ?></td>
			<td><?php echo $dataHasil['JHT']; ?></td>
			<td><?php echo $dataHasil['JKN']; ?></td>
			<td><?php echo $dataHasil['JP']; ?></td>
			<td><?php echo $dataHasil['potonganKoperasi']; ?></td>
			<td><?php echo $dataHasil['potonganHutangLain']; ?></td>
			<td><?php echo $dataHasil['potonganDPLK']; ?></td>
		</tr>
<?php
	}
?>