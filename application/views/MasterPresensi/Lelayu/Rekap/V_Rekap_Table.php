<div class="col-md-12 text-center">
	<h3>Rekap Data</h3>
	<h4 id="duka_pr_rekap"><?= $awal.' sd '.$akhir; ?></h4>
</div>
<table class="table table-bordered table-striped duka_tbl_rekap">
	<thead>
		<tr>
			<th>No</th>
			<th>Noind</th>
			<th>Nama</th>
			<th>Jabatan</th>
			<th>Jumlah Potongan</th>
		</tr>
	</thead>
	<tbody>
		<?php $x=1; foreach ($list as $key): ?>
		<?php if(empty($key['noind'])) continue; ?>
		<tr>
			<td><?= $x ?></td>
			<td><?= $key['noind'] ?></td>
			<td><?= $key['nama'] ?></td>
			<td><?= $key['jabatan'] ?></td>
			<!--<td><?= $key['sum'] ?></td>-->
			<td><?= strval(number_format($key['sum'],0,',',',')) ?></td> 
			
		</tr>
		<?php $x++; endforeach ?>
	</tbody>
</table>