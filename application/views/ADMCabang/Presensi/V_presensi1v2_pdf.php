<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div style="width: 100%">
		<div style="width: 100%">
			
		</div>
		<table width="100%" border="1" style="border: 1px solid black;border-collapse: collapse;">
			<tr>
				<td>No</td>
				<td>No Induk</td>
				<td style="text-align: center;">Nama</td>
				<td width="11%" style="text-align: center;">Tanggal</td>
				<td width="10%">Shift</td>
				<td width="6%">Point</td>
				<td style="text-align: center;" colspan="<?php echo $max ?>">Waktu</td>
				<td >Keterangan</td>
			</tr>
		<?php 
				$no=1;
				foreach ($pekerja as $key) {
					?>
					
						<?php
					foreach ($key['data'] as $shi) {
						
							?>
							<tr>
								<td style="text-align: center;"><?php echo $no; ?></td>
								<td style="text-align: center;"><?php echo $key['noind']; ?></td>
								<td style=""><?php echo $key['nama']; ?></td>
								<td style="text-align: center;"><?php echo $shi['tgl']; ?></td>
								<td><?php echo $shi['shift']; ?></td>
								<td><?php 
									if (isset($shi['tim']) and !empty($shi['tim'])) {
										foreach ($shi['tim'] as $tims) {
											echo $tims;
										}
									}
								 ?></td>
								<?php 
									$angka = 0;
									if (isset($shi['wkt']) and !empty($shi['wkt'])) {
										foreach ($shi['wkt'] as $wkt) { ?>
										<td><?php echo $wkt; ?></td>
									<?php $angka++;
										}
									}

									if ($angka < $max) {
										for ($i=0; $i < $max - $angka; $i++) { 
											echo "<td></td>";
										}
									}
								?>
								<?php if (isset($shi['ket']) and !empty($shi['ket'])) {
									foreach ($shi['ket'] as $ket) { ?>
										<td><?php echo $ket; ?></td>
									<?php }
									}else{
										echo "<td></td>";
									}
								?>
							</tr>
							<?php
							$no++;
						
					}
					?>
					
					<?php
				}
		?>
		</table>
	</div>
</body>
</html>