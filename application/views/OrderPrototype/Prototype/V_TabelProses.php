<table class="table table-bordered" id="master_proses_display" style="float: none;margin: 0 auto;width: 70%">
		<thead class="bg-yellow">
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">Nama Proses</th>
				<th class="text-center">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $n=1; foreach ($proses as $pros) {?>
				<tr>
					<td class="text-center"><?=$n?></td>
					<td class="text-center"><input type="hidden" id="namapros<?=$n?>" value="<?=$pros['nama_proses']?>"><?=$pros['nama_proses']?></td>
					<td class="text-center"><button onclick="deleteproses(<?=$n?>)" class="btn btn-danger btn-xs">Delete</button></td>
				</tr>
			<?php $n++; } ?>
	</tbody>
</table>