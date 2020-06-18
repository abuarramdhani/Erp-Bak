<header>

</header>
<body>
<div>

	<div style="width: 100%;margin-bottom: 10px;">
		<h3 style="text-align: center;font-size: 20px;font-weight: bold;">
			LAPORAN HASIL KUNJUNGAN PEKERJA
		</h3>
	</div>
	<div style="width: 100%;margin-bottom: 10px;">
		<table width="100%;" border="1">
			<tr>
				<td style="width: 33%;font-weight: bold;padding: 5px;">No. Induk / Nama Petugas</td>
				<td style="width: 3%;text-align: center;font-weight: bold;">:</td>
				<td style="width: 64%;padding-left: 5px;"><?= ucwords(strtolower($noind_petugas))." / ".$nama_petugas." / ".ucwords(strtolower($seksi_petugas)) ?></td>
			</tr>
			<tr>
				<td style="width: 33%;font-weight: bold;padding: 5px;">Nama Pekerja yg dikunjungi</td>
				<td style="width: 3%;text-align: center;font-weight: bold;">:</td>
				<td style="width: 64%;padding-left: 5px;"><?= ucwords(strtolower($nama_pekerja)) ?></td>
			</tr>
			<tr>
				<td style="width: 33%;font-weight: bold;padding: 5px;">No. Induk</td>
				<td style="width: 3%;text-align: center;font-weight: bold;">:</td>
				<td style="width: 64%;padding-left: 5px;"><?= $noind_pekerja ?></td>
			</tr>
			<tr>
				<td style="width: 33%;font-weight: bold;padding: 5px;">Seksi</td>
				<td style="width: 3%;text-align: center;font-weight: bold;">:</td>
				<td style="width: 64%;padding-left: 5px;"><?= ucwords(strtolower($seksi_pekerja))?></td>
			</tr>
			<tr>
				<td style="width: 33%;font-weight: bold;padding: 5px;">Alamat</td>
				<td style="width: 3%;text-align: center;font-weight: bold;">:</td>
				<td style="width: 64%;padding-left: 5px;"><?= ucwords(strtolower($alamat_pekerja)) ?></td>
			</tr>
			<tr>
				<td style="width: 33%;font-weight: bold;padding: 5px;">Diagnosa</td>
				<td style="width: 3%;text-align: center;font-weight: bold;">:</td>
				<td style="width: 64%;padding-left: 5px;"><?= ucwords(strtolower($diagnosa)) ?></td>
			</tr>
		</table>
	</div>

	<div style="width: 100%;height: 7%;border: 2px solid black;" >
		<div>
			<table width="100%" style="margin: 5px;">
				<thead><tr><th>Latar Belakang</th></tr></thead>
				<tbody>
				<?php
				$no = 0;
				if(!empty($latar_belakang)):
				foreach ($latar_belakang as $latbel):
					$no++;
				?>
				<tr>
				<td style="width: 100%"><p><?=$no;?> . <span><?=$latbel;?></span></p></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>

	<div style="width: 100%;height: 300px;border-left: 2px solid black;border-right: 2px solid black;border-bottom: 2px solid black">
		<div style="margin: 5px;">
		<p style="font-weight: bold;">Laporan Hasil Kunjungan : </p>
		<p><?= $hasil_laporan;?></p>
		</div>
	</div>

	<div style="margin-top: 40px;">
		<table style="width: 100%">
			<tr><td style="width: 33%"></td><td style="width: 33%;text-align: center;">Mengetahui</td><td style="width: 33%;text-align: center;">Seksi Hubungan Kerja</td></tr>
			<tr><td height="60px"></td></tr>

			<tr><td style="width: 33%"></td><td style="width: 33%;text-align: center;font-weight: bold;text-decoration: underline;"><?=$nama_atasan?></td><td style="width: 33%;text-align: center;font-weight: bold;text-decoration: underline;"><?=$nama_petugas ?></td></tr>

			<tr><td style="width: 33%"></td><td style="width: 33%;text-align: center;"><?= ucwords(strtolower($jabatan_atasan))?></td><td style="width: 33%;text-align: center;">Petugas</td></tr>
		</table>
	</div>

</div>
</body>
