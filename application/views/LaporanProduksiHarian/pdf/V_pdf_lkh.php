<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>RKH Operator <?php echo $date ?></title>
	</head>
	<body>
		<?php $no = 1;foreach ($get as $key => $value): ?>
			<?php foreach ($value as $k1 => $v1): ?>
				<div style="page-break-inside:avoid;border-bottom:1px solid black;height:303px">
					<center style="font-size:10px;text-align:center;font-weight:bold">Rencana Kerja Operator Sheet Metal</center>
					<table style="font-size:10px;width:100%;margin-top:10px;">
						<tr>
							<td style="width:50px">No. <?php echo $no; $no++ ?></td>
							<td style="width:70px">Operator :</td>
							<td style="font-weight:bold;width:200px"><?php echo $v1[0]['nama_operator'] ?></td>
							<td>No Induk :</td>
							<td style="font-weight:bold"><?php echo $v1[0]['no_induk'] ?></td>
							<td>Tanggal :</td>
							<td style="font-weight:bold"><?php echo $v1[0]['tanggal'] ?></td>
							<td>Shift :</td>
							<td style="font-weight:bold"><?php echo $v1[0]['shift'] ?></td>
							<td style="font-weight:bold">
								<?php
								if ($v2['hari'] == 'Jumat' || $v['hari'] == 'Sabtu') {
									echo 'S-K';
								}else {
									echo 'J-S';
								}
								 ?>
							</td>
						</tr>
					</table>
					<table class="tbl_aa" style="width:100%; border-collapse: collapse !important;font-size:10px;margin-top:10px;">
						<thead>
							<tr>
								<td style="text-align:center;padding:2px;border-right: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;width:3.3%">Prio</td>
								<td style="text-align:center;padding:2px;border-right: 1px solid black;border-top: 1px solid black;width:9%">Batch</td>
								<td style="text-align:center;padding:2px;border-right: 1px solid black;border-top: 1px solid black;width:6%">Product</td>
								<td style="text-align:center;padding:2px;border-right: 1px solid black;border-top: 1px solid black;width: 17.7%">Nama Part</td>
								<td style="text-align:center;padding:2px;border-right: 1px solid black;border-top: 1px solid black;width:12%">Kode Part</td>
								<td style="text-align:center;padding:2px;border-right: 1px solid black;border-top: 1px solid black;width:5.5%">Mesin</td>
								<td style="text-align:center;padding:2px;border-right: 1px solid black;border-top: 1px solid black;width:9%">Proses</td>
								<td style="text-align:center;padding:2px;border-right: 1px solid black;border-top: 1px solid black;width:4%">No Dies</td>
								<td style="text-align:center;padding:2px;border-right: 1px solid black;border-top: 1px solid black;width:4%">Plan</td>
								<td style="text-align:center;padding:2px;border-right: 1px solid black;border-top: 1px solid black;width:6%">%Tgt</td>
								<td style="text-align:center;padding:2px;border-right: 1px solid black;border-top: 1px solid black;width:4%">CT/PCS</td>
								<td style="text-align:center;padding:2px;border-right: 1px solid black;border-top: 1px solid black;width:4%">Hasil</td>
								<td style="text-align:center;padding:2px;border-right: 1px solid black;border-top: 1px solid black;width:4.5%">Repair</td>
								<td style="text-align:center;padding:2px;border-right: 1px solid black;border-top: 1px solid black;width:4%">Scrap</td>
								<td style="text-align:center;padding:2px;border-right: 1px solid black;border-top: 1px solid black;width:8%">STD HANDLING</td>
								<td style="text-align:center;padding:2px;border-right: 1px solid black;border-top: 1px solid black;width:7%">SARANA</td>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($v1 as $k2 => $v2): ?>
								<tr>
									<td style="padding:2px;border-right: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;text-align:center"><?php echo $k2+1 ?></td>
									<td style="padding:2px;border-right: 1px solid black;border-top: 1px solid black;"><?php echo $v2['no_batch'] ?></td>
									<td style="padding:2px;border-right: 1px solid black;border-top: 1px solid black;"></td>
									<td style="padding:2px;border-right: 1px solid black;border-top: 1px solid black;"><?php echo $v2['nama_komponen'] ?></td>
									<td style="padding:2px;border-right: 1px solid black;border-top: 1px solid black;"><?php echo $v2['kode_komponen'] ?></td>
									<td style="padding:2px;border-right: 1px solid black;border-top: 1px solid black;"><?php echo $v2['kode_mesin'] ?></td>
									<td style="padding:2px;border-right: 1px solid black;border-top: 1px solid black;"><?php echo $v2['proses'] ?></td>
									<td style="padding:2px;border-right: 1px solid black;border-top: 1px solid black;"></td>
									<td style="padding:2px;border-right: 1px solid black;border-top: 1px solid black;"><?php echo $v2['plan'] ?></td>
									<td style="padding:2px;border-right: 1px solid black;border-top: 1px solid black;">
										<?php
											if ($v2['hari'] == 'Jumat' || $v['hari'] == 'Sabtu') {
												echo $v2['persen_target_js'];
											}else {
												echo $v2['persen_target_sk'];
											}
									  ?>
									</td>
									<td style="padding:2px;border-right: 1px solid black;border-top: 1px solid black;"></td>
									<td style="padding:2px;border-right: 1px solid black;border-top: 1px solid black;"></td>
									<td style="padding:2px;border-right: 1px solid black;border-top: 1px solid black;"></td>
									<td style="padding:2px;border-right: 1px solid black;border-top: 1px solid black;"></td>
									<td style="padding:2px;border-right: 1px solid black;border-top: 1px solid black;"></td>
									<td style="padding:2px;border-right: 1px solid black;border-top: 1px solid black;"></td>
								</tr>
							<?php endforeach; ?>
							<tr>
								<td></td>
							</tr>
						</tbody>
					</table>
					<div style="width:100%;border-top:1px solid black;margin-top:-2px">
						<table style="width:50%;font-size:10px;text-align:center;margin-bottom:10px;margin-top:8px;">
							<tr>
								<td style="width:15%">Kasie Sheet Metal</td>
								<td style="width:15%">Administasi</td>
								<td style="width:15%">Operator</td>
							</tr>
							<tr>
								<td><br><br>(................)</td>
								<td><br><br>(................)</td>
								<td><br><br>(................)</td>
							</tr>
						</table>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endforeach; ?>
	</body>
</html>
