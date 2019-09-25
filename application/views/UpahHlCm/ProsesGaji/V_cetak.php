<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<table style="width: 100%;border-collapse: collapse;font-size: 9pt" border="1">
		<thead>
			<tr style="background-color: #00ccff;">
				<th style="text-align: center; vertical-align: middle;width: 5%" rowspan="3">No</th>
				<th style="text-align: center; vertical-align: middle;width: 6%" rowspan="3">No. Induk</th>
				<th style="text-align: center; vertical-align: middle;width: 20%" rowspan="3">Nama</th>
				<th style="text-align: center; vertical-align: middle;width: 13%" rowspan="3">Status</th>
				<th style="text-align: center; vertical-align: middle;width: 11%" rowspan="3">Lokasi Kerja</th>
				<th style="text-align: center; vertical-align: middle;" colspan="8">Proses Gaji</th>
				<th style="text-align: center; vertical-align: middle;width: 13%" rowspan="3">Total Gaji <br>(Tanpa Tamb/Pot)</th>
			</tr>
			<tr style="background-color: #00ccff;">
				<th style="text-align: center;" colspan="4">Komponen</th>
				<th style="text-align: center;" colspan="4">Nominal</th>
			</tr>
			<tr style="background-color: #00ccff;">
				<th style="text-align: center;width: 8%">Gaji Pokok</th>
				<th style="text-align: center;width: 8%">Uang Makan</th>
				<th style="text-align: center;width: 8%">Uang Makan Puasa</th>
				<th style="text-align: center;width: 8%">Lembur</th>
				<th style="text-align: center;width: 9%">Gaji Pokok</th>
				<th style="text-align: center;width: 9%">Uang Makan</th>
				<th style="text-align: center;width: 9%">Uang Makan Puasa</th>
				<th style="text-align: center;width: 9%">Lembur</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no=1;
			foreach ($data as $key) {
				?>
				<tr>
					<td style="text-align: center;"><?php echo $no;?></td>
					<td style="text-align: center;"><?php echo $key['noind'];?></td>
					<td style="text-align: left">&nbsp;<?php echo $key['nama'];?></td>
					<td style="text-align: center;"><?php echo $key['pekerjaan'];?></td>
					<td style="text-align: center;"><?php echo $key['lokasi'];?></td>
					<td style="text-align: center;"><?php echo number_format($key['jml_gp'],'2',',','.');?></td>
					<td style="text-align: center;"><?php echo number_format($key['jml_um'],'2',',','.');?></td>
					<td style="text-align: center;"><?php echo number_format($key['jml_ump'],'2',',','.');?></td>
					<td style="text-align: center;"><?php echo number_format($key['jml_lbr'],'2',',','.');?></td>
					<td style="text-align: center;"><?php echo number_format($key['gp'],'0',',','.');?></td>
					<td style="text-align: center;"><?php echo number_format($key['um'],'0',',','.');?></td>
					<td style="text-align: center;"><?php echo number_format($key['ump'],'0',',','.');?></td>
					<td style="text-align: center;"><?php echo number_format($key['lmbr'],'0',',','.');?></td>
					<td style="text-align: center;"><?php echo number_format($key['total_bayar'],'0',',','.');?></td>
				</tr>
				<?php
				$no++;
			}
			?>
		</tbody>
	</table>
	<br>
	<div>
		<label><?php echo "Periode : ".$periode; ?></label>
	</div>
	<pagebreak>
	<table style="width: 100%;border-collapse: collapse;font-size: 9pt" border="1">
		<thead>
			<tr style="background-color: #00ccff;">
				<th style="text-align: center; vertical-align: middle;width: 5%" rowspan="3">No</th>
				<th style="text-align: center; vertical-align: middle;width: 6%" rowspan="3">No. Induk</th>
				<th style="text-align: center; vertical-align: middle;width: 18%" rowspan="3">Nama</th>
				<th style="text-align: center; vertical-align: middle;width: 13%" rowspan="3">Status</th>
				<th style="text-align: center;" colspan="6">Tambahan</th>
				<th style="text-align: center;" colspan="6">Potongan</th>
				<th style="text-align: center; vertical-align: middle;width: 13%" rowspan="3">Total Gaji</th>
			</tr>
			<tr style="background-color: #00ccff;">
				<th style="text-align: center;" colspan="3">Komponen</th>
				<th style="text-align: center;" colspan="3">Nominal</th>
				<th style="text-align: center;" colspan="3">Komponen</th>
				<th style="text-align: center;" colspan="3">Nominal</th>
			</tr>
			<tr style="background-color: #00ccff;">
				<!-- Tambahan -->
				<th style="text-align: center;width: 5%">Gaji Pokok</th>
				<th style="text-align: center;width: 5%">Uang Makan</th>
				<th style="text-align: center;width: 5%">Lembur</th>
				<th style="text-align: center;width: 7%">Gaji Pokok</th>
				<th style="text-align: center;width: 7%">Uang Makan</th>
				<th style="text-align: center;width: 7%">Lembur</th>
				<!-- Potongan -->
				<th style="text-align: center;width: 5%">Gaji Pokok</th>
				<th style="text-align: center;width: 5%">Uang Makan</th>
				<th style="text-align: center;width: 5%">Lembur</th>
				<th style="text-align: center;width: 7%">Gaji Pokok</th>
				<th style="text-align: center;width: 7%">Uang Makan</th>
				<th style="text-align: center;width: 7%">Lembur</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no=1;
			foreach ($data as $key) {
					if(!empty($key['potongan']) or !empty($key['tambahan'])){
				?>
				<tr>
					<td style="text-align: center;"><?php echo $no;?></td>
					<td style="text-align: center;"><?php echo $key['noind'];?></td>
					<td style="text-align: left">&nbsp;<?php echo $key['nama'];?></td>
					<td style="text-align: center;"><?php echo $key['pekerjaan'];?></td>
					<?php 
					if (!empty($key['tambahan'])) {
						?>
						<td style="text-align: center;"><?php echo $key['tambahan']->gp ?></td>
						<td style="text-align: center;"><?php echo $key['tambahan']->um ?></td>
						<td style="text-align: center;"><?php echo $key['tambahan']->lembur ?></td>
						<td style="text-align: center;"><?php echo $key['tambahan']->nominal_gp ?></td>
						<td style="text-align: center;"><?php echo $key['tambahan']->nominal_um ?></td>
						<td style="text-align: center;"><?php echo $key['tambahan']->nominal_lembur ?></td>
						<?php
						$key['total_bayar'] += ($key['tambahan']->nominal_gp + $key['tambahan']->nominal_um + $key['tambahan']->nominal_lembur);
					}else{
						?>
						<td style="text-align: center;">0</td>
						<td style="text-align: center;">0</td>
						<td style="text-align: center;">0</td>
						<td style="text-align: center;">0</td>
						<td style="text-align: center;">0</td>
						<td style="text-align: center;">0</td>
						<?php
					} ?>
					<?php 
					if (!empty($key['potongan'])) {
						?>
						<td style="text-align: center;"><?php echo $key['potongan']->gp ?></td>
						<td style="text-align: center;"><?php echo $key['potongan']->um ?></td>
						<td style="text-align: center;"><?php echo $key['potongan']->lembur ?></td>
						<td style="text-align: center;"><?php echo $key['potongan']->nominal_gp ?></td>
						<td style="text-align: center;"><?php echo $key['potongan']->nominal_um ?></td>
						<td style="text-align: center;"><?php echo $key['potongan']->nominal_lembur ?></td>
						<?php
						$key['total_bayar'] -= ($key['potongan']->nominal_gp + $key['potongan']->nominal_um + $key['potongan']->nominal_lembur);
					}else{
						?>
						<td style="text-align: center;">0</td>
						<td style="text-align: center;">0</td>
						<td style="text-align: center;">0</td>
						<td style="text-align: center;">0</td>
						<td style="text-align: center;">0</td>
						<td style="text-align: center;">0</td>
						<?php
					} ?>
					<td style="text-align: center;"><?php echo number_format($key['total_bayar'],'0',',','.');?></td>
				</tr>
				<?php
					$no++;
				}
			}
			?>
		</tbody>
	</table>
	<br>
	<div>
		<label><?php echo "Periode : ".$periode; ?></label>
	</div>
</body>
</html>