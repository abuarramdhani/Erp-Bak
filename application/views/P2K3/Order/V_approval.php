<!DOCTYPE html>
<html>
<body>
	<table style="width: 100%;border: 1px solid black;border-collapse: collapse;">
		<tr>
			<td rowspan="2" style="text-align: center;border: 1px solid black;width: 8%">
				<img src="<?php  echo base_url('/assets/img/logo.png'); ?>" width="100" height="120">
				<br>
				<b style="font-size: 15pt">CV. KHS</b>
			</td>
			<td colspan="12" style="text-align: center;vertical-align: middle;border: 1px solid black;font-size: 20pt">
				<b>DATA KEBUTUHAN SARANA ALAT PELINDUNG DIRI</b>
			</td>
		</tr>
		<tr>
			<td style="width: 6%;border-left: 1px solid black;padding-left: 5px;font-size: 10pt;">Tanggal</td>
			<td style="width: 2%">:</td>
			<td style="width: 15%;font-size: 10pt;"><?php setlocale(LC_ALL, 'IND'); echo strftime('%d %B %Y') ?></td>
			<td style="width: 6%;border-left: 1px solid black;padding-left: 5px;font-size: 10pt;">Seksi</td>
			<td style="width: 2%">:</td>
			<td style="width: 15%;font-size: 10pt;"><?php echo $seksi['0']['section'] ?></td>
			<td style="width: 6%;border-left: 1px solid black;padding-left: 5px;font-size: 10pt;">Unit</td>
			<td style="width: 2%">:</td>
			<td style="width: 15%;font-size: 10pt;"><?php echo $seksi['0']['unit'] ?></td>
			<td style="width: 6%;border-left: 1px solid black;padding-left: 5px;font-size: 10pt;">Departemen</td>
			<td style="width: 2%">:</td>
			<td style="width: 15%;font-size: 10pt;"><?php echo $seksi['0']['dept'] ?></td>
		</tr>
	</table>
	<br>
	<table border="1" style="width: 100%;border: 1px solid black;border-collapse: collapse;">
		<thead>
			<tr>
				<th rowspan="3" style="text-align: center;">No</th>
				<th rowspan="3" style="text-align: center;">Kode Item</th>
				<th rowspan="3" style="text-align: center;">Sarana APD</th>
				<th rowspan="3" style="text-align: center;">Total APD</th>
				<th rowspan="3" style="text-align: center;">Kebutuhan Umum</th>
				<th colspan="<?php echo count($pekerjaan)*2; ?>" style="text-align: center;">Seksi</th>
				<th rowspan="3" style="text-align: center;">Keterangan</th>
			</tr>
			<tr>
				<?php 
					$pd1 = 0;
					foreach ($pekerjaan as $pkj) { ?>
						<th <?php if (count($pekerjaan) > 4) {
							echo 'text-rotate="90"';
						} ?>  style="vertical-align: bottom;text-align: center;padding: 5px;<?php if(count($pekerjaan) <= 4){echo 'width: 50px;';} ?>" colspan="2"><?php echo $pkj['pekerjaan'] ?></th>
				<?php 
						$pd1++;
					}
				?>
			</tr>
			<tr>
				<?php 
					foreach ($pekerjaan as $pkj) { ?>
						<th text-rotate="90" style="vertical-align: bottom;text-align: center;padding: 5px;font-size: 7pt">Kebutuhan Per Pekerja</th>
						<th text-rotate="90" style="vertical-align: bottom;text-align: center;padding: 5px;font-size: 7pt">Jumlah Pekerja</th>
				<?php 
					}
				?>
			</tr>
		</thead>
		<tbody>
			<?php 
				$angka = 1;
				foreach ($data as $dt) { ?>
					<tr>
						<td style="text-align: center;"><?php echo $angka; ?></td>
						<td style="padding-left: 5px;"><?php echo $dt['kode_item'] ?></td>
						<td style="padding-left: 5px;"><?php echo $dt['item'] ?></td>
						<td style="text-align: center;"><?php echo $dt['ttl_order'] ?></td>
						<td style="text-align: center;"><?php echo $dt['jml_umum'] ?></td>
						<?php 
							$jumlah = explode(',', $dt['jml']);
							$pekerja = explode(',', $dt['jml_pkj']);
							$pd2 = 0;
							foreach ($jumlah as $jml) { ?>
							 	<td style="text-align: center;"><?php echo intval($jml); ?></td>
							 	<td style="text-align: center;"><?php echo intval($pekerja[$pd2]); ?></td>
						<?php 
								$pd2++;
							} 
							if ($pd2 !== $pd1) {
								for ($i=0; $i <= abs($pd1 - $pd2); $i++) { 
									echo '<td style="text-align: center;">0</td>';
								}
							}
						?>
						<td style="padding: 5px;"><?php echo $dt['desc'] ?></td>
					</tr>
			<?php 
				$angka++;
				}
			?>
		</tbody>
	</table>
	<br>
	<table border="1" style="width: 100%;border: 1px solid black;border-collapse: collapse;">
		<tr>
			<td style="text-align: center;font-size: 8pt;width: 15%;padding-top: 3px;padding-bottom: 3px">Dibuat : <br>Operator Administrasi</td>
			<td style="text-align: center;font-size: 8pt;width: 15%;padding-top: 3px;padding-bottom: 3px">Diperiksa : <br>Kepala Seksi</td>
			<td style="text-align: center;font-size: 8pt;width: 15%;padding-top: 3px;padding-bottom: 3px">Diketahui : <br>Ass. / Ka. Unit*</td>
			<td rowspan="3" style="font-size: 8pt;vertical-align: top;padding-left: 3px;padding-top: 3px">Keterangan : <br>* Jika tidak ada Ass. / Ka. Unit maka otorisasi harus naik ke level jabatan di atasnya.</td>
		</tr>
		<tr>
			<td style="text-align: center;padding-bottom: 3px;font-size: 12pt;"><br><br>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
			<td style="text-align: center;padding-bottom: 3px;font-size: 12pt;"><br><br>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
			<td style="text-align: center;padding-bottom: 3px;font-size: 12pt;"><br><br>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
		</tr>
		<tr>
			<td style="font-size: 8pt;padding-bottom: 3px;padding-top: 3px;padding-left: 3px">Tanggal : </td>
			<td style="font-size: 8pt;padding-bottom: 3px;padding-top: 3px;padding-left: 3px">Tanggal : </td>
			<td style="font-size: 8pt;padding-bottom: 3px;padding-top: 3px;padding-left: 3px">Tanggal : </td>
		</tr>
	</table>
</body>
</html>