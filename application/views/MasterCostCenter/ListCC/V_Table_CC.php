<!-- <button class="btn btn-sm btn-primary mccCeksk" style="margin-bottom: 30px;">Cek Seksi</button> -->
<style>
	#mcconhover:hover{
		text-decoration: underline;
	}
</style>
<label><?= $sudah ?> Seksi Tersetting COA /</label>
<label id="mcconhover" style="color: red; cursor: pointer;"><?= $belum ?> Seksi Belum Tersetting</label>
<table class="table table-bordered table-striped" id="mcc_tbl_list">
	<thead class="bg-primary">
		<th width="5%">No</th>
		<th width="10%">Dept</th>
		<th width="10%">Bidang</th>
		<th width="15%">Unit</th>
		<th width="15%">Seksi</th>
		<th width="15%">Cost Center</th>
		<th width="10%">Branch</th>
		<th width="10%">jenis Akun</th>
		<th width="5%">Status</th>
		<th width="5%">Action</th>
	</thead>
	<tbody>
		<?php $akun = array('Non Produksi', 'Produksi');
		$x=1; foreach ($list as $key): ?>
		<tr>
			<td><?= $x ?></td>
			<td class="dept"><?= $key['dept'] ?></td>
			<td class="bidang"><?= $key['bidang'] ?></td>
			<td class="unit"><?= $key['unit'] ?></td>
			<td class="seksi"><?= $key['seksi'] ?></td>
			<td class="cost"><?= $key['cost_center'].' - '.$key['nama_cost_center'] ?></td>
			<td class="branch"><?= $key['branch'].' - '.$key['nama_branch'] ?></td>
			<td class="akun">
				<?= ($key['jenis_akun'] == '') ? '-':$akun[$key['jenis_akun']] ?>
				<input hidden="" value="<?= $key['jenis_akun']?>">
			</td>
			<td class="text-center">
				<?php if ($key['flag'] == 1): ?>
					<span class="label label-success label-md">Aktif</span>
				<?php else: ?>
					<span class="label label-danger label-md">Tidak Aktif</span>
				<?php endif ?>
			</td>
			<td class="text-center">
				<button value="<?= $key['kodesie']?>" class="btn btn-primary mccuprow"><i class="fa fa-edit"></i></button>
			</td>
		</tr>
		<?php $x++; endforeach ?>
	</tbody>
</table>

<div class="modal fade" id="mcc_modal_cekseksi" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<label style="font-size: 24px;" class="modal-title" id="exampleModalLabel">Seksi yang Belum di Inputkan</label>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>