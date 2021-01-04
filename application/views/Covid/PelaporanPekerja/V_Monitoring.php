<style>
	.table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
    border: 1px solid black;
}
	.table-bordered{
		border:  1px solid black;
	}
	.bg-dangerr{
		background-color: red;
	}
</style>
<section class="content" style="display: none">
<div class="col-md-12 text-center">
	<h1 style="font-weight: bold;">Monitoring Pekerja Isolasi KHS</h1>
</div>
<form method="get" action="">
	<div class="col-md-1">
		<label style="margin-top: 5px;">Periode</label>
	</div>
	<div class="col-md-2">	
		<input class="form-control cvd_drangem" name="periode" value="<?=$periode?>">
	</div>
	<div class="col-md-1">
		<button class="btn btn-primary">Lihat</button>
	</div>
</form>
<div class="col-md-12" style="font-size: 12px; margin-top: 10px;">
	<table class="table table-bordered table-hover table-striped" id="cvd_tblmntrpel">
		<thead class="bg-primary">
			<tr>
				<th class="bg-primary" rowspan="2" style="text-align: center;">No</th>
				<th class="bg-primary" rowspan="2" style="text-align: center;">Noind</th>
				<th class="bg-primary" rowspan="2" style="text-align: center;">Nama</th>
				<th class="bg-primary" rowspan="2" style="text-align: center;">Tgl Laporan</th>
				<th class="bg-primary" rowspan="2" style="text-align: center; min-width: 200px;">Keterangan</th>
				<?php foreach ($bulan as $b):  $widt = $b['jumlah']*50; ?>
					<th style="text-align: center;" colspan="<?= $b['jumlah'] ?>"><?= date('M Y', strtotime($b['bulan'])) ?></th>	
				<?php endforeach ?>
			</tr>
			<tr>
				<?php foreach ($bulan as $b):
					$m = date('m', strtotime($b['bulan']));
				?>
					<?php 
					for ($i=1; $i <= $b['jumlah']; $i++) { 
						if ($m == date('m') && $i/10 == date('d')/10) {
							$bg = 'bg-dangerr';
						}else{
							$bg = 'bg-primary';
						}
						echo '<th class="'.$bg.'" style="min-width:15px;">'.$i.'</th>';
					}
					?>	
				<?php endforeach ?>
			</tr>
		</thead>
		<tbody>
			<?php $x=1; foreach ($list as $k): ?>
				<tr style="height: 80px;">
					<td class="cvd_pekerjaid" data-id="<?= $k['cvd_pekerja_id'] ?>" ><?= $x++; ?></td>
					<td><?= $k['noind']; ?></td>
					<td><?= $k['nama']; ?></td>
					<td><?= $k['created_date']; ?></td>
					<td><?= $k['keterangan']; ?></td>
					<?php foreach ($bulan as $b):
						$m = date('m', strtotime($b['bulan']));
					?>
						<?php 
							for ($i=1; $i <= $b['jumlah']; $i++) { 
								if ($i < 10) {
									$nu = '0'.$i;
								}else{
									$nu = $i;
								}

								if ($m == date('m') && $i/10 == date('d')/10) {
									$bi = 'background-image: linear-gradient(to right, red , yellow);';
								}else{
									$bi = '';
								}
								echo '<td style="padding: 0px; '.$bi.'" class="r'.date('Y-m', strtotime($b['bulan'])).'-'.$nu.'"></td>';
							}
						?>	
					<?php endforeach ?>
				</tr>	
			<?php endforeach ?>
		</tbody>
	</table>
</div>
</section>
<div style="display: none;">
	<div id="cvd_warna1" style="width: 150px; height: 80px;">
		<div style="width: 30px;height: 30px; background-color: #ff0000; float: left; margin-left: 2px; margin-bottom: 10px;"></div>
		<div style="float: right;">	
			<label style="margin-top: 5px; margin-left: 5px;">Kontak dengan Positif</label>
		</div>
	</div>
	<div id="cvd_warna2" style="width: 150px; height: 80px;">
		<div style="width: 30px;height: 30px; background-color: #4b1f6f; float: left; margin-left: 2px; margin-bottom: 10px;"></div>
		<div style="float: right;">	
			<label style="margin-top: 5px; margin-left: 5px;">Kontak dengan Probable Positif</label>
		</div>
	</div>
	<div id="cvd_warna3" style="width: 150px; height: 80px;">
		<div style="width: 30px;height: 30px; background-color: #00ff00; float: left; margin-left: 2px; margin-bottom: 10px;"></div>
		<div style="float: right;">	
			<label style="margin-top: 5px; margin-left: 5px;">Ngantor</label>
		</div>
	</div>
	<div id="cvd_warna4" style="width: 150px; height: 80px;">
		<div style="width: 30px;height: 30px; background-color: #ffff00; float: left; margin-left: 2px; margin-bottom: 10px;"></div>
		<div style="float: right;">	
			<label style="margin-top: 5px; margin-left: 5px;">Isolasi di Rumah</label>
		</div>
	</div>
	<div id="cvd_warna5" style="width: 150px; height: 80px;">
		<div style="width: 30px;height: 30px; background-color: #996633; float: left; margin-left: 2px; margin-bottom: 10px;"></div>
		<div style="float: right;">	
			<label style="margin-top: 5px; margin-left: 5px;">Isolasi di kantor</label>
		</div>
	</div>
	<div id="cvd_warna6" style="width: 150px; height: 80px;">
		<div style="width: 30px;height: 30px; background-color: #0084d1; float: left; margin-left: 2px; margin-bottom: 10px;"></div>
		<div style="float: right;">	
			<label style="margin-top: 5px; margin-left: 5px;">PCR (Negatif)</label>
		</div>
	</div>
	<div id="cvd_warna7" style="width: 150px; height: 80px;">
		<div style="width: 30px;height: 30px; background-color: #000000; float: left; margin-left: 2px; margin-bottom: 10px;"></div>
		<div style="float: right;">	
			<label style="margin-top: 5px; margin-left: 5px;">PCR (Positif)</label>
		</div>
	</div>
	<div id="cvd_warna8" style="width: 150px; height: 80px;">
		<div style="width: 30px;height: 30px; background-color: #cccccc; float: left; margin-left: 2px; margin-bottom: 10px;"></div>
		<div style="float: right;">	
			<label style="margin-top: 5px; margin-left: 5px;">PCR (Belum ada Hasil)</label>
		</div>
	</div>
	<div id="cvd_warna9" style="width: 150px; height: 80px;">
		<div style="width: 30px;height: 30px; background-color: #ff00ff; float: left; margin-left: 2px; margin-bottom: 10px;"></div>
		<div style="float: right;">	
			<label style="margin-top: 5px; margin-left: 5px;">Tes Antibody (Non Reaktif)</label>
		</div>
	</div>
	<div id="cvd_warna10" style="width: 150px; height: 80px;">
		<div style="width: 30px;height: 30px; background-color: #7e0021; float: left; margin-left: 2px; margin-bottom: 10px;"></div>
		<div style="float: right;">	
			<label style="margin-top: 5px; margin-left: 5px;">Tes Antibody (Reaktif)</label>
		</div>
	</div>
	<div id="cvd_warna11" style="width: 150px; height: 80px;">
		<div style="width: 30px;height: 30px; background-color: #aecf00; float: left; margin-left: 2px; margin-bottom: 10px;"></div>
		<div style="float: right;">	
			<label style="margin-top: 5px; margin-left: 5px;">Tes Antibody (Belum ada Hasil)</label>
		</div>
	</div>
	<div id="cvd_warna12" style="width: 150px; height: 80px;">
		<div style="width: 30px;height: 30px; background-color: #ff8080; float: left; margin-left: 2px; margin-bottom: 10px;"></div>
		<div style="float: right;">	
			<label style="margin-top: 5px; margin-left: 5px;">Tes Antigen (Non Reaktif)</label>
		</div>
	</div>
	<div id="cvd_warna13" style="width: 150px; height: 80px;">
		<div style="width: 30px;height: 30px; background-color: #ff950e; float: left; margin-left: 2px; margin-bottom: 10px;"></div>
		<div style="float: right;">	
			<label style="margin-top: 5px; margin-left: 5px;">Tes Antigen (Reaktif)</label>
		</div>
	</div>
	<div id="cvd_warna14" style="width: 150px; height: 80px;">
		<div style="width: 30px;height: 30px; background-color: #83caff; float: left; margin-left: 2px; margin-bottom: 10px;"></div>
		<div style="float: right;">	
			<label style="margin-top: 5px; margin-left: 5px;">Tes Antigen (Belum ada Hasil)</label>
		</div>
	</div>
	<div id="cvd_warna15" style="width: 150px; height: 80px;">
		<div style="width: 30px;height: 30px; background-color: #FBE7C6; float: left; margin-left: 2px; margin-bottom: 10px;"></div>
		<div style="float: right;">	
			<label style="margin-top: 5px; margin-left: 5px;">???</label>
		</div>
	</div>
</div>
<script>
	window.addEventListener('load', function () {
		$('.content').show();
		getDataMonitoringCovid();
	});
</script>