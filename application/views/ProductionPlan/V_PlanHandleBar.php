<div class="col-md-12">
	<h3 style="font-weight: bold">Handle Bar</h3>
</div>
<div class="col-md-12">
	<table class="table table-bordered">
		<thead class="bg-red">
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">Kode Komponen</th>
				<th class="text-center">Nama Komponen</th>
				<th class="text-center">Bulan</th>
				<th class="text-center">Versi</th>

			</tr>
		</thead>
		<tbody>
			<?php $bo=1; foreach ($arrayplanhandlebar as $hand) { ?>
			<tr>
				<td class="text-center"><?=$bo?></td>
				<td class="text-center"><?=$hand['kode_komponen']?></td>
				<td class="text-center"><?=$hand['nama_komponen']?></td>
				<td class="text-center"><?=$hand['bulan']?></td>
				<td class="text-center"><?=$hand['versi_baru']?></td>

			</tr>
			<?php $bo++; } ?>
		</tbody>
	</table>
</div>