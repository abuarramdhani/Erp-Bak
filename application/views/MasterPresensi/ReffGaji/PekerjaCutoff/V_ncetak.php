<div style="width: 100%;padding: 10px">
	<div style="text-align: center;">
		<h2>Pekerja Dibayar Cutoff</h2>
	</div>
	<div>
		<table>
			<tr>
				<td style="padding-left: 20px;padding-right: 20px">No. Induk</td>
				<td>:</td>
				<td style="padding-left: 20px"><?php echo (isset($pekerja) and !empty($pekerja)) ? $pekerja['0']['noind'] : "-"; ?></td>
			</tr>
			<tr>
				<td style="padding-left: 20px;padding-right: 20px">Nama</td>
				<td>:</td>
				<td style="padding-left: 20px"><?php echo (isset($pekerja) and !empty($pekerja)) ? $pekerja['0']['nama'] : "-"; ?></td>
			</tr>
			<tr>
				<td style="padding-left: 20px;padding-right: 20px">Seksi / Unit</td>
				<td>:</td>
				<td style="padding-left: 20px"><?php echo (isset($pekerja) and !empty($pekerja)) ? $pekerja['0']['seksi'] : "-"; ?></td>
			</tr>
		</table>
	</div>
	<div>
		<table style="border-collapse: collapse;width: 100%">
			<thead>
				<tr>
					<th style="width: 10%;border: 1px solid black">No</th>
					<th  style="border: 1px solid black">Periode</th>
				</tr>
			</thead>
			<tbody >
				<?php 
				if(isset($data) and !empty($data)){ 
					$nomor = 1;
					foreach ($data as $key) {?>
						<tr>
							<td style="text-align: center;border: 1px solid black"><?=$nomor ?></td>
							<td style="text-align: center;border: 1px solid black"><?php echo $key['periode'] ?></td>
						</tr>
				<?php 
						$nomor++;
					}
				}else{ ?>
					<tr>
						<td colspan="2" style="text-align: center;border: 1px solid black">
							<i>Tidak Ditemukan Data <?php echo (isset($pekerja) and !empty($pekerja)) ? $pekerja['0']['noind'] : "-"; ?> di Data Pekerja Cut Off</i>
						</td>
					</tr>
				<?php 
				} ?>
			</tbody>
		</table>
	</div>
</div>