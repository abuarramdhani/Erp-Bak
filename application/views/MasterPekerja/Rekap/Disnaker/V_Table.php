<div class="col-md-12" style="margin-bottom: 10px;" >
	<?php if ($type == 'aktif'): ?>
		<a class="btn btn-success" id="mpk_btndisnAK" href="<?= base_url('MasterPekerja/disnaker/export_pkjaktif?tanggal='.$date.'&lokasi='.$lokasi) ?>">
			<i class="fa fa-file-excel-o"></i> Cetak Pekerja Aktif
		</a>
	<?php endif ?>
	<?php if ($type == 'resign'): ?>
		<a class="btn btn-success" id="mpk_btndisnRE" href="<?= base_url('MasterPekerja/disnaker/export_pkjresign?tanggal='.$date.'&lokasi='.$lokasi)?>">
			<i class="fa fa-file-excel-o"></i> Cetak Pekerja Resign
		</a>
	<?php endif ?>
</div>
<div class="col-md-12">
	<table class="table table-bordered table-hover" id="mpk_tbldisnker">
		<thead class="bg-primary">
			<th class="bg-primary">No</th>
			<th class="bg-primary">Nama Lengkap<br>Tenaga Kerja</th>
			<th>NIK</th>
			<th>Alamat Sesuai KTP</th>
			<th>Alamat Tempat<br>Tinggal Sekarang</th>
			<th style="min-width: 100px;">No HP</th>
			<th>No Kartu BPJS Kesehatan</th>
			<th>No KPJ BPJS Ketenagakerjaan</th>
			<th>Tingkat Pendidikan</th>
			<th>Status Profesi/<br>Job Desk</th>
			<th>Upah</th>
			<th>Upah yang diberlakukan</th>
			<th>Status Pegawai</th>
			<th>Warga Negara</th>
			<th>Alamat Email</th>
			<th>Keterangan</th>
		</thead>
		<tbody>
			<?php $x=1; foreach ($list as $k):
			if (isset($k['sebabklr'])) {
				$keterangan = trim($k['sebabklr']).' ('.date('d-m-Y', strtotime($k['tglkeluar'])).')';
			}else{
				$keterangan = '';
			}

			?>
			<tr>
				<td style="text-align: center;"><?=$x++?></td>	
				<td><?= $k['nama'] ?></td>
				<td><?= $k['nik'] ?></td>
				<td><?= $k['alamat'] ?></td>
				<td><?= $k['almt_kost'] ?></td>
				<td><?= $k['nohp'] ?></td>
				<td><?= $k['bpjs_kesehatan'] ?></td>
				<td><?= $k['bpjs_ketenagakerjaan'] ?></td>
				<td><?= $k['pendidikan'] ?></td>
				<td><?= $k['jabatan'] ?></td>
				<td><?= $k['upah'] ?></td>
				<td><?= $k['upah_berlaku'] ?></td>
				<td><?= $k['status_pegawai'] ?></td>
				<td><?= $k['kewarganegaraan'] ?></td>
				<td><?= $k['email'] ?></td>
				<td><?= $keterangan ?></td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>