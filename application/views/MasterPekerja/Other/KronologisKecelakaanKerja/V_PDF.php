<table style="width: 100%; font-weight: bold">
	<tr>
		<td style="text-align: center;">
			<h4>KRONOLOGIS KECELAKAAN KERJA</h4>
		</td>
	</tr>
</table>
<table style="width: 100%; margin-top: 10px; font-weight: bold">
	<tr>
		<td style="width: 27%;">1)&nbsp;&nbsp; Nama</td>
		<td style="width: 2%;">:</td>
		<td><?= $kr['nama'] ?></td>
		<td>No. Induk</td>
		<td style="width: 5%;">:</td>
		<td><?= $kr['pekerja'] ?></td>
	</tr>
	<tr>
		<td style="width: 27%;">2)&nbsp;&nbsp; No. KPJ</td>
		<td style="width: 2%;">:</td>
		<td><?= $kr['no_kpj'] ?></td>
		<td></td>
		<td style="width: 5%;"></td>
		<td></td>
	</tr>
	<tr>
		<td style="width: 27%;">3)&nbsp;&nbsp; Tanggal</td>
		<td style="width: 2%;">:</td>
		<td><?= date('d M Y', strtotime($kr['tanggal'])) ?></td>
		<td>Jam</td>
		<td style="width: 5%;">:</td>
		<td><?= $kr['jam'] ?> WIB</td>
	</tr>
	<tr>
		<td valign="top" style="width: 27%;">4)&nbsp;&nbsp; Tempat Kecelakaan</td>
		<td valign="top" style="width: 2%;">:</td>
		<td valign="top"><?= $kr['tempat'] ?></td>
		<td></td>
		<td style="width: 5%;"></td>
		<td></td>
	</tr>
	<tr>
		<td colspan="6">
			<br>
		</td>
	</tr>
	<tr>
		<td style="width: 27%;">5)&nbsp;&nbsp; Uraian Kejadian</td>
		<td style="width: 2%;">:</td>
		<td colspan="4"><?= $kr['uraian_kejadian'] ?></td>
	</tr>
</table>

<div style="width: 90%; height: 45s%; margin-left: 5%; margin-top: 20px; font-weight: bold; border: 1px solid black">
	<div style="width: 100%; text-align: center; border-bottom: 1px solid black;">
		Uraian
	</div>
	<div style="width: 100%; font-size: 12px; padding: 5px; text-align: justify;">
		<?= $kr['uraian'] ?>
	</div>
</div>
<div style="width: 100%; height: 20px;">
	
</div>
<div style="float: left; width: 50%;">
	<table style="width: 100%; font-weight: bold;">
		<tr>
			<td style="text-align: center;">
				Perusahaan
			</td>
		</tr>
		<tr>
			<td>
				<br><br>
				<br><br>
				<br>
			</td>
		</tr>
		<tr>
			<td style="text-align: center;">
				( <?= $kr['wakil_perusahaan'] ?> )
			</td>
		</tr>
	</table>
</div>
<div style="float: left; width: 50%;">
	<table style="width: 100%; font-weight: bold;">
		<tr>
			<td style="text-align: center;">
				Saksi
			</td>
		</tr>
		<tr>
			<td>
				<br><br>
				<br><br>
				<br>
			</td>
		</tr>
		<tr>
			<td style="text-align: center;">
				( <?= $kr['saksi_1'] ?> )
			</td>
		</tr>
	</table>
</div>
<br><br><br>
<div style="float: left; width: 50%;">
	
</div>
<div style="float: right; width: 50%;">
	<table style="width: 100%; font-weight: bold;">
		<tr>
			<td style="text-align: center;">
				Saksi
			</td>
		</tr>
		<tr>
			<td>
				<br><br>
				<br><br>
				<br>
			</td>
		</tr>
		<tr>
			<td style="text-align: center;">
				( <?= $kr['saksi_2'] ?> )
			</td>
		</tr>
	</table>
</div>