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
			<td>
				<form class="detail-form" target="_blank" method="post" action="<?php echo base_url('PayrollManagementNonStaff/ProsesGaji/HitungGaji/detail_perhitungan'); ?>">
					<input type="hidden" name="txtNoind" value="<?php echo $dataHasil['noind']; ?>">
					<input type="hidden" name="txtBulan" value="<?php echo $dataHasil['bln_gaji']; ?>">
					<input type="hidden" name="txtTahun" value="<?php echo $dataHasil['thn_gaji']; ?>">
				</form>
				<a href="#" onclick="$(this).closest('td').find('.detail-form').submit()"><?php echo $dataHasil['noind']; ?></a>
			</td>
			<td>
				<form class="detail-form" target="_blank" method="post" action="<?php echo base_url('PayrollManagementNonStaff/ProsesGaji/HitungGaji/detail_perhitungan'); ?>">
					<input type="hidden" name="txtNoind" value="<?php echo $dataHasil['noind']; ?>">
					<input type="hidden" name="txtBulan" value="<?php echo $dataHasil['bln_gaji']; ?>">
					<input type="hidden" name="txtTahun" value="<?php echo $dataHasil['thn_gaji']; ?>">
				</form>
				<a href="#" onclick="$(this).closest('td').find('.detail-form').submit()"><?php echo $dataHasil['employee_name']; ?></a>
			</td>
			<td><?php echo $dataHasil['gaji_pokok']; ?></td>
			<td><?php echo $dataHasil['insentif_prestasi']; ?></td>
			<td><?php echo $dataHasil['insentif_kelebihan']; ?></td>
			<td><?php echo $dataHasil['insentif_kondite']; ?></td>
			<td><?php echo $dataHasil['insentif_masuk_sore']; ?></td>
			<td><?php echo $dataHasil['insentif_masuk_malam']; ?></td>
			<td><?php echo $dataHasil['ubt']; ?></td>
			<td><?php echo $dataHasil['upamk']; ?></td>
			<td><?php echo $dataHasil['uang_lembur']; ?></td>
			<td><?php echo $dataHasil['tambah_kurang_bayar']; ?></td>
			<td><?php echo $dataHasil['tambah_lain']; ?></td>
			<td><?php echo $dataHasil['uang_dl']; ?></td>
			<td><?php echo $dataHasil['pot_htm']; ?></td>
			<td><?php echo $dataHasil['pot_lebih_bayar']; ?></td>
			<td><?php echo $dataHasil['pot_gp']; ?></td>
			<td><?php echo $dataHasil['pot_uang_dl']; ?></td>
			<td><?php echo $dataHasil['jht']; ?></td>
			<td><?php echo $dataHasil['jkn']; ?></td>
			<td><?php echo $dataHasil['jp']; ?></td>
			<td><?php echo $dataHasil['pot_koperasi']; ?></td>
			<td><?php echo $dataHasil['pot_hutang_lain']; ?></td>
			<td><?php echo $dataHasil['pot_dplk']; ?></td>
			<td><?php echo $dataHasil['spsi']; ?></td>
			<td><?php echo $dataHasil['duka']; ?></td>
		</tr>
<?php
	}
?>