
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<p>Lampiran</p>
	<table border="1" style="border-collapse: collapse; text-align: center; font-size: 10px; width: 100%" class="table table-bordered table-hover text-center tb_et_bulanan">
		<caption align="center" style="color: black;font-weight: bold; font-size: 14px; text-align: center;">Data TIMS Pekerja Staf<br><?php echo $nama ?></caption>
			<thead>
				<tr>
					<th>No</th>
					<th width="3%">No Induk</th>
					<th>Nama</th>
					<th>Tgl Masuk</th>
					<th width="14%">Unit</th>
					<th width="14%">Seksi</th>
					<th width="6%">Lama Kerja</th>
					<th width="2%">T</th>
					<th width="2%">I</th>
					<th width="2%">M</th>
					<th width="2%">S</th>
					<th width="2%">PSP</th>
					<th width="2%">IP</th>
					<th width="2%">CT</th>
					<th width="2%">SP</th>
					<th width="2.5%">TIM</th>
					<th>TIMS</th>
					<th>M <br>2 tahun terakhir</th>
					<th>TIM <br>2 tahun terakhir</th>
					<th>TIMS <br>2 tahun terakhir</th>
					<th>Prediksi Lolos</th>
				</tr>
			</thead>
			<tbody>
				<?php $a = 1; foreach ($listLt as $key): ?>
				<tr>
					<td><?php echo $a; ?></td>
					<td><?php echo $key['noind']; ?></td>
					<td><?php echo $key['nama']; ?></td>
					<td><?php echo date('d-M-Y', strtotime($key['tgl_masuk'])); ?></td>
					<td><?php echo $key['unit']; ?></td>
					<td><?php echo $key['seksi']; ?></td>
					<td><?php echo $key['masa_kerja']; ?></td>
					<td><?php echo $key['telat']; ?></td>
					<td><?php echo $key['ijin']; ?></td>
					<td><?php echo $key['mangkir']; ?></td>
					<td><?php echo $key['sk']; ?></td>
					<td><?php echo $key['psp']; ?></td>
					<td><?php echo $key['ip']; ?></td>
					<td><?php echo $key['ct']; ?></td>
					<td><?php echo $key['sp']; ?></td>
					<td><?php echo $key['tim']; ?></td>
					<td><?php echo $key['tims']; ?></td>
					<td><?php echo round($key['pred_m'],2); ?></td>
					<td><?php echo round($key['pred_tim'],2); ?></td>
					<td><?php echo round($key['pred_tims'],2); ?></td>
					<td 
					<?php if ($key['pred_lolos'] == 'TIDAK LOLOS') {
						echo 'style="color:#ff0000;"';
					} ?>
					><?php echo $key['pred_lolos']; ?></td>
				</tr>
				<?php $a++; endforeach ?>
			</tbody>
		</table>
		<?php if ($jenis == 'harian'): ?>
			<p>Data diambil pada tanggal <?php echo $tgl2; ?></p>
		<?php else: ?>
			<p>Data diambil sampai dengan tanggal <?php echo $tgl2; ?></p>
		<?php endif ?>
		<b>Keterangan</b>
		<table border="0">
			<tr>
				<td width="20%" style="padding: 10px;">
					<ul>
						<li>T   = Terlambat</li>
						<li>I   = Ijin</li>
						<li>M   = Mangkir</li>
						<li>TIM = T + I + M</li>
					</ul>
				</td>
				<td colspan="2" style="padding: 10px;">
					<ul>
						<li>S    = Sakit</li>
						<li>PSP  = Pulang Sakit dari Perusahaan</li>
						<li>SP   = Surat Peringatan</li>
						<li>TIMS = T + I + M + S + PSP</li>
					</ul>
				</td>
			</tr>
			<tr>
				<td width="40%" style="padding: 10px;" colspan="2" valign="top">
					<ul>
						<li>Standar kelolosan frekuensi TIMS staf selama 2 Tahun*):</li>
					</ul>
				</td>
				<td style="padding: 10px;">
					<ul>
						<li>M Maksimal <?php echo $tims[0]; ?></li>
						<li>TIM Maksimal <?php echo $tims[1]; ?></li>
						<li>TIMS Maksimal <?php echo $tims[2]; ?></li>
						<li>SP Maksimal 0</li>
					</ul>
				</td>
			</tr>
			<tr>
				<td style="padding-left: 20px;" colspan="3">
					<p>*)Untuk pekerja dengan masa kerja kurang dari 2 tahun, perhitungan frekuensi TIMS 2 tahun menggunakan ekstrapolasi dari data yang ada</p>
				</td>
			</tr>
		</table>
		<div>
			<?php echo $ket; ?>
		</div>
	</body>
	</html>