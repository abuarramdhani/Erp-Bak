<div class="col-md-12">
	<h3 style="font-weight: bold">Dos</h3>
</div>
<div class="col-md-12">
	<table class="table table-bordered">
		<thead class="bg-primary">
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">Kode Komponen</th>
				<th class="text-center">Nama Komponen</th>
				<th class="text-center">Bulan</th>
				<th class="text-center">Versi</th>

			</tr>
		</thead>
		<tbody>
			<?php $bo=1; foreach ($arrayplandos as $dos) { ?>
			<tr>
				<td class="text-center"><?=$bo?></td>
				<td class="text-center"><?=$dos['kode_komponen']?></td>
				<td class="text-center"><?=$dos['nama_komponen']?></td>
				<td class="text-center"><?=$dos['bulan']?></td>
				<td class="text-center"><?=$dos['versi_baru']?></td>

			</tr>
			<?php $bo++; } ?>
		</tbody>
	</table>
</div>