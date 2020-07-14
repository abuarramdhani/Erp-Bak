<!DOCTYPE html>
<html>
	<body>
		<?php 
		$bulan = array(
			1 => 'Januari',
			2 => 'Februari',
			3 => 'Maret',
			4 => 'April',
			5 => 'Mei',
			6 => 'Juni',
			7 => 'Juli',
			8 => 'Agustus',
			9 => 'September',
			10 => 'Oktober',
			11 => 'November',
			12 => 'Desember'
		);
		$shift = array(
			1 => '1 & Umum',
			2 => '2',
			3 => '3'
		);

		if (isset($data) && !empty($data)) {
			foreach ($data as $data_key => $data_value) {
				?>
				<h1 style="text-align: center;">Menu Bulan <?php echo $bulan[$data_value['bulan']].' '.$data_value['tahun']  ?> Shift <?php echo $shift[$data_value['shift']] ?></h1>
				<?php
			}
		}
		?>
		<table style="width: 100%;border: 1px solid black;border-collapse: collapse;" border="1">
			<thead>
				<tr>
					<th class="bg-primary" style="text-align: center;vertical-align: middle;">Tanggal</th>
					<th class="bg-primary" style="text-align: center;vertical-align: middle;">Sayur</th>
					<th class="bg-primary" style="text-align: center;vertical-align: middle;">Lauk Utama</th>
					<th class="bg-primary" style="text-align: center;vertical-align: middle;">Lauk Pendamping</th>
					<th class="bg-primary" style="text-align: center;vertical-align: middle;">Buah</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				if (isset($detail) && !empty($detail)) {
					foreach ($detail as $detail_key => $detail_value) {
						?>
						<tr>
							<td style="text-align: center;"><?php echo $detail_value['tanggal'] ?></td>
							<td><?php echo $detail_value['sayur'] ?></td>
							<td><?php echo $detail_value['lauk_utama'] ?></td>
							<td><?php echo $detail_value['lauk_pendamping'] ?></td>
							<td><?php echo $detail_value['buah'] ?></td>
						</tr>
						<?php 
					}
				}
				?>
			</tbody>
		</table>
	</body>
</html>	