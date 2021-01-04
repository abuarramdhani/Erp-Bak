<style>
	#cvd_tblhsltest tbody td{
		text-align: center;
	}
</style>
<div class="col-md-12" style="padding: 0px;">
	<button class="btn btn-success" style="float: right; margin-bottom: 10px;" data-toggle="modal" data-target="#cvd_mdladdtest">
		<i class="fa fa-plus"></i> Tambah
	</button>
</div>
<table class="table table-bordered table-hover" id="cvd_tblhsltest">
	<thead class="bg-primary">
		<tr>
			<th class="text-center">No</th>
			<th class="text-center">Jenis Test</th>
			<th class="text-center">Tanggal Test</th>
			<th class="text-center">Tanggal Keluar Test</th>
			<th class="text-center">Hasil Test</th>
			<th class="text-center">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php $x = 1; foreach ($test as $key): ?>
		<tr>
			<td><?= $x++; ?></td>
			<td><?= $key['jenis_tes'] ?></td>
			<td data-order="<?= $key['tgl_tes']; ?>" ><?= date('d M Y', strtotime($key['tgl_tes'])) ?></td>
			<?php if ($key['tgl_keluar_tes'] == ''): ?>
				<td>-</td>
			<?php else: ?>
				<td data-order="<?= $key['tgl_keluar_tes'] ?>" ><?= date('d M Y', strtotime($key['tgl_keluar_tes'])) ?></td>
			<?php endif ?>
			<?php $st = ['','Negatif', 'Non Reaktif', 'Reaktif', 'Positif']; ?>
			<td><?= (empty($key['hasil_tes'])) ? '-':$st[$key['hasil_tes']] ?></td>
			<td>
				<button class="btn btn-sm btn-primary cvd_btnedhsltes" title="edit" value="<?= $key['id_hasil_tes'] ?>" jns="<?= $key['jenis_tes'] ?>" tgl="<?= $key['tgl_tes'] ?>" tglkeluar="<?= $key['tgl_keluar_tes'] ?>"  hsl="<?= $key['hasil_tes'] ?>">
					<i class="fa fa-edit"></i>
				</button>
				<button class="btn btn-sm btn-danger cvd_btndelhsltes" title="hapus" value="<?= $key['id_hasil_tes'] ?>">
					<i class="fa fa-trash"></i>
				</button>
			</td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>
