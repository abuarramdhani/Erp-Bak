<?php
	$no = 1;
	foreach ($hasilHitungGaji as $dataHasil) {
?>
		<tr role="row">
			<td><?php echo $no++; ?></td>
			<td>
				<form target="_blank" method="post" action="<?php echo base_url('PayrollManagementNonStaff/ProsesGaji/HitungGaji/cetakStruk'); ?>">
					<input type="hidden" name="noind" value="<?php echo $dataHasil['noind']; ?>">
					<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-print"></i> Struk</button>
				</form>
			</td>
			<td><?php echo $dataHasil['noind']; ?></td>
			<td><?php echo $dataHasil['nama']; ?></td>
			<td><?php echo $dataHasil['gajiPokok']; ?></td>
			<td><?php echo $dataHasil['IPTotal']; ?></td>
			<td><?php echo $dataHasil['IKTotal']; ?></td>
			<td><?php echo $dataHasil['KonditeTotal']; ?></td>
			<td><?php echo $dataHasil['IMSTotal']; ?></td>
			<td><?php echo $dataHasil['IMMTotal']; ?></td>
			<td><?php echo $dataHasil['UBTTotal']; ?></td>
			<td><?php echo $dataHasil['UPAMKTotal']; ?></td>
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