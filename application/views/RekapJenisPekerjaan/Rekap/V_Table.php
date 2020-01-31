<h2 style="text-align: center;" id="rjp_sini">Rekap Jenis Pekerja</h2>
<h4 style="text-align: center;">per Tanggal <?= $tgl?></h4>
<input hidden="" value="<?= $tgl?>" id="rjpTglRe" />
<table class="table table-bordered table-hover table-striped rjp_tbl">
	<thead class="bg-primary">
		<tr>
			<th width="5%" class="text-center bg-primary">No</th>
			<th class=" bg-primary">Noind</th>
			<th class=" bg-primary">Nama</th>
			<th>Departemen</th>
			<th>Bidang</th>
			<th style="max-width: 200px;">Unit</th>
			<th style="max-width: 200px;">Seksi</th>
			<th>Lokasi Kerja</th>
			<th>Jabatan</th>
			<th>Tanggal masuk</th>
			<th>Akhir Kontrak</th>
			<th>Status</th>
			<th>Pekerjaan</th>
			<th>Jenis Pekerjaan</th>
		</tr>
	</thead>
	<tbody>
	<?php $no = 1; foreach ($getRjp as $key): ?>
		<tr>
			<td><?= $no; ?></td>
			<td><?= $key['noind']; ?></td>
			<td><?= $key['nama']; ?></td>
			<td><?= $key['dept']; ?></td>
			<td><?= $key['bidang']; ?></td>
			<td><?= $key['unit']; ?></td>
			<td><?= $key['seksi']; ?></td>
			<td><?= $key['lokasi_kerja']; ?></td>
			<td><?= $key['jabatan']; ?></td>
			<td><?= $key['tgl_masuk']; ?></td>
			<td><?= $key['tgl_akhir_kontrak']; ?></td>
			<td><?= $key['status']; ?></td>
			<td><?= $key['pekerjaan']; ?></td>
			<td><?= $key['jenis_pekerjaan']; ?></td>
		</tr>
	<?php $no++; endforeach ?>
	</tbody>
</table>