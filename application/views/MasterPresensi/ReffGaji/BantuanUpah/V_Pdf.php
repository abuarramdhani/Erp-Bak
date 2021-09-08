<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<?php ?>
		<table>
			<tr>
				<td>Periode</td>
				<td>:</td>
				<td><?php echo isset($data) ? strftime("%d %B %Y",strtotime($data->periode_awal))." s/d ".strftime("%d %B %Y",strtotime($data->periode_akhir)) : '' ?></td>
			</tr>
			<tr>
				<td>Status Hubungan Kerja</td>
				<td>:</td>
				<td><?php echo isset($data) ? $data->status_hubungan_kerja : '' ?></td>
			</tr>
		</table>
		<table border="1" style="border: 1px solid black;border-collapse: collapse;">
			<thead>
				<tr>
					<th rowspan="2" style="background-color: #3498db;font-size: 8pt;">No</th>
					<th rowspan="2" style="background-color: #3498db;font-size: 8pt;">No. Induk</th>
					<th rowspan="2" style="background-color: #3498db;font-size: 8pt;">Nama</th>
					<th rowspan="2" style="background-color: #3498db;font-size: 8pt;">Tanggal Perhitungan</th>
					<th rowspan="2" style="background-color: #3498db;font-size: 8pt;">Lokasi Kerja</th>
					<th colspan="2" style="background-color: #3498db;font-size: 8pt;">GP</th>
					<th colspan="2" style="background-color: #3498db;font-size: 8pt;">IF</th>
					<th colspan="2" style="background-color: #3498db;font-size: 8pt;">IP</th>
					<th colspan="2" style="background-color: #3498db;font-size: 8pt;">IPT</th>
					<th colspan="2" style="background-color: #3498db;font-size: 8pt;">IK</th>
					<th colspan="2" style="background-color: #3498db;font-size: 8pt;">IKR</th>
					<th colspan="2" style="background-color: #3498db;font-size: 8pt;">Ins. Kepatuhan</th>
					<th colspan="2" style="background-color: #3498db;font-size: 8pt;">Ins. Kemahalan</th>
					<th colspan="2" style="background-color: #3498db;font-size: 8pt;">Ins. Penempatan</th>
					<th rowspan="2" style="background-color: #3498db;font-size: 8pt;">Kategori</th>
					<th rowspan="2" style="background-color: #3498db;font-size: 8pt;">Keterangan</th>
				</tr>
				<tr>
					<th style="background-color: #3498db;font-size: 8pt;">Kom</th>
					<th style="background-color: #3498db;font-size: 8pt;">(%)</th>
					<th style="background-color: #3498db;font-size: 8pt;">Kom</th>
					<th style="background-color: #3498db;font-size: 8pt;">(%)</th>
					<th style="background-color: #3498db;font-size: 8pt;">Kom</th>
					<th style="background-color: #3498db;font-size: 8pt;">(%)</th>
					<th style="background-color: #3498db;font-size: 8pt;">Kom</th>
					<th style="background-color: #3498db;font-size: 8pt;">(%)</th>
					<th style="background-color: #3498db;font-size: 8pt;">Kom</th>
					<th style="background-color: #3498db;font-size: 8pt;">(%)</th>
					<th style="background-color: #3498db;font-size: 8pt;">Kom</th>
					<th style="background-color: #3498db;font-size: 8pt;">(%)</th>
					<th style="background-color: #3498db;font-size: 8pt;">Kom</th>
					<th style="background-color: #3498db;font-size: 8pt;">(%)</th>
					<th style="background-color: #3498db;font-size: 8pt;">Kom</th>
					<th style="background-color: #3498db;font-size: 8pt;">(%)</th>
					<th style="background-color: #3498db;font-size: 8pt;">Kom</th>
					<th style="background-color: #3498db;font-size: 8pt;">(%)</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				if (isset($detail) && !empty($detail)) {
					$nomor = 1;
					foreach ($detail as $dt) {
						?>
						<tr>
							<td style="font-size: 8pt;padding: 2px;"><?php echo $nomor ?></td>
							<td style="font-size: 8pt;padding: 2px;"><?php echo $dt['noind'] ?></td>
							<td style="font-size: 8pt;padding: 2px;"><?php echo $dt['nama'] ?></td>
	                        <td style="font-size: 8pt;padding: 2px;"><?php echo $dt['tanggal_perhitungan_awal']." s/d ".$dt['tanggal_perhitungan_akhir'] ?></td>
	                        <td style="font-size: 8pt;padding: 2px;"><?php echo $dt['lokasi_kerja'] ?></td>
	                        <td style="font-size: 8pt;padding: 2px;"><?php echo $dt['kom_gp'] ?></td>
	                        <td style="font-size: 8pt;padding: 2px;"><?php echo $dt['persen_gp'] ?></td>
	                        <td style="font-size: 8pt;padding: 2px;"><?php echo $dt['kom_if'] ?></td>
	                        <td style="font-size: 8pt;padding: 2px;"><?php echo $dt['persen_if'] ?></td>
	                        <td style="font-size: 8pt;padding: 2px;"><?php echo $dt['kom_ip'] ?></td>
	                        <td style="font-size: 8pt;padding: 2px;"><?php echo $dt['persen_ip'] ?></td>
	                        <td style="font-size: 8pt;padding: 2px;"><?php echo $dt['kom_ipt'] ?></td>
	                        <td style="font-size: 8pt;padding: 2px;"><?php echo $dt['persen_ipt'] ?></td>
	                        <td style="font-size: 8pt;padding: 2px;"><?php echo $dt['kom_ik'] ?></td>
	                        <td style="font-size: 8pt;padding: 2px;"><?php echo $dt['persen_ik'] ?></td>
	                        <td style="font-size: 8pt;padding: 2px;"><?php echo $dt['kom_ikr'] ?></td>
	                        <td style="font-size: 8pt;padding: 2px;"><?php echo $dt['persen_ikr'] ?></td>
	                        <td style="font-size: 8pt;padding: 2px;"><?php echo $dt['kom_ins_kepatuhan'] ?></td>
	                        <td style="font-size: 8pt;padding: 2px;"><?php echo $dt['persen_ins_kepatuhan'] ?></td>
	                        <td style="font-size: 8pt;padding: 2px;"><?php echo $dt['kom_ins_kemahalan'] ?></td>
	                        <td style="font-size: 8pt;padding: 2px;"><?php echo $dt['persen_ins_kemahalan'] ?></td>
	                        <td style="font-size: 8pt;padding: 2px;"><?php echo $dt['kom_ins_penempatan'] ?></td>
	                        <td style="font-size: 8pt;padding: 2px;"><?php echo $dt['persen_ins_penempatan'] ?></td>
	                        <td style="font-size: 8pt;padding: 2px;"><?php echo $dt['kategori'] ?></td>
	                        <td style="font-size: 8pt;padding: 2px;"><?php echo $dt['keterangan'] ?></td>
						</tr>
						<?php 
						$nomor++;
					}
				}
				?>
			</tbody>
		</table>
		<br>
		<table style="width: 100%">
			<tr>
				<td></td>
				<td style="text-align: center;width: 30%">Yogyakarta, <?php echo strftime('%d %B %Y') ?></td>
			</tr>
			<tr>
				<td></td>
				<td style="height: 50px;"></td>
			</tr>
			<tr>
				<td></td>
				<td style="text-align: center;"><?php echo ucwords(strtolower($this->session->employee)) ?></td>
			</tr>
		</table>
	</body>
</html>