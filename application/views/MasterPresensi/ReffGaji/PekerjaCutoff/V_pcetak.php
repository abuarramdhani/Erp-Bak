<div style="width: 100%;padding: 10px">
	<div style="text-align: center;">
		<h2>Pekerja Dibayar Cutoff</h2>
		<?php 
			$bulan = array (
				1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
		$tgl= explode("-", $periode);
		echo "<h2>".$bulan[intval($tgl['1'])].' '.$tgl['0']."</h2>";
		?>
	</div>
	<div>
		<table style="border-collapse: collapse;width: 100%">
			<thead>
				<tr>
					<th style="text-align: center;border: 1px solid black">No</th>
					<th style="text-align: center;border: 1px solid black">No. Induk</th>
					<th style="text-align: center;border: 1px solid black">Nama</th>
					<th style="text-align: center;border: 1px solid black">Seksi/Unit</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					if(isset($data) and !empty($data)){
						$nomor = 1;
						foreach ($data as $key) { 
							
				?>
							<tr>
								<td style="text-align: center;border: 1px solid black"><?=$nomor ?></td>
								<td style="text-align: center;border: 1px solid black"><?php echo $key['noind'] ?></td>
								<td style="text-align: left;border: 1px solid black;padding-left: 5px"><?php echo $key['nama'] ?></td>
								<td style="text-align: left;border: 1px solid black;padding-left: 5px"><?php echo $key['seksi'] ?></td>
							</tr>
				<?php 
							$nomor++;
						}
					}else{ ?>
						<tr>
							<td colspan="4" style="text-align: center;border: 1px solid black">Tidak Ditemukan Data untuk Periode <?php echo $bulan[intval($tgl['1'])].' '.$tgl['0']; ?> di Data Pekerja Cut Off</td>
						</tr>
				<?php }
				?>
			</tbody>
		</table>
	</div>
</div>