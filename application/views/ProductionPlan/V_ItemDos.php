<div class="col-md-12">
	<h3 style="font-weight: bold">Data Dos</h3>
</div>
<div class="col-md-12">
	<table class="table table-bordered">
		<thead class="bg-primary">
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">Kode Komponen</th>
				<th class="text-center">Nama Komponen</th>
				<th class="text-center"></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no=1;
			 foreach ($arraydos as $array) { ?>
			<tr>
				<td class="text-center"><?=$no?></td>
				<td class="text-center"><input type="hidden" value="<?=$array['kode_item']?>" name="codekomp"><?=$array['kode_item']?></td>
				<td class="text-center"><input type="hidden" value="<?=$array['desc_item']?>" name="namakomp"><?=$array['desc_item']?></td>
				<td class="text-center"><input type="hidden" value="" name=""> </td>
			</tr>
			<?php $no++; } ?>
		</tbody>
	</table>
</div>