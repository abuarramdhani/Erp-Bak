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
	.bg-sukses{
		background-color: #28a745;
	}
</style>
<section class="content" style="display: none">
<div class="col-md-12 text-center">
	<h1 style="font-weight: bold;">Monitoring Pekerja Isolasi KHS</h1>
</div>
<div class="col-md-12">
	<div class="col-md-1"></div>
	<div class="col-lg-2">
		<div class="box box-solid box-danger text-center" data-toggle="modal" data-target="#cvd_wfhpst">
			<div class="box-header with-border">
				Isolasi di Rumah (Pusat) Hari Ini
			</div>
			<div class="box-body" style="font-size: 30pt;">
				<?= count($wfhPst) ?>
			</div>
		</div>
	</div>
	<div class="col-lg-2">
		<div class="box box-solid box-danger text-center" data-toggle="modal" data-target="#cvd_wfhtks">
			<div class="box-header with-border">
				Isolasi di Rumah (Tuksono) Hari Ini
			</div>
			<div class="box-body" style="font-size: 30pt;">
				<?= count($wfhTks) ?>
			</div>
		</div>
	</div>
	<div class="col-lg-2">
		<div class="box box-solid box-danger text-center" data-toggle="modal" data-target="#cvd_wfopst">
			<div class="box-header with-border">
				Isolasi di Perusahaan (Pusat) Hari Ini
			</div>
			<div class="box-body" style="font-size: 30pt;">
				<?= count($wfoPst) ?>
			</div>
		</div>
	</div>
	<div class="col-lg-2">
		<div class="box box-solid box-danger text-center" data-toggle="modal" data-target="#cvd_wfotks">
			<div class="box-header with-border">
				Isolasi di Perusahaan (Tuksono) Hari Ini
			</div>
			<div class="box-body" style="font-size: 30pt;">
				<?= count($wfoTks) ?>
			</div>
		</div>
	</div>
	<div class="col-lg-2">
		<div class="box box-solid box-danger text-center" data-toggle="modal" data-target="#cvd_aknselesai">
			<div class="box-header with-border">
				Isolasi Hampir Selesai<br>
				<span style="color: #dd4b39">-</span>
			</div>
			<div class="box-body" style="font-size: 30pt;">
				<?= count($akanSelesai) ?>
			</div>
		</div>
	</div>
</div>
<form method="get" action="">
	<div class="col-md-1">
		<label style="margin-top: 5px;">Periode</label>
	</div>
	<div class="col-md-2">
		<input class="form-control cvd_drangem" name="periode" value="<?=$periode?>">
	</div>
	<div class="col-md-1 text-center">
		<label style="margin-top: 5px;">Status</label>
	</div>
	<div class="col-md-3">
		<select class="form-control cvd_select3" name="status[]" style="width: 100%" multiple="multiple">
			<option value="1" <?= (in_array(1, $status)) ? 'selected':'' ?>>Baru</option>
			<option value="2" <?= (in_array(2, $status)) ? 'selected':'' ?>>Isolasi Pemantauan</option>
			<option value="3" <?= (in_array(3, $status)) ? 'selected':'' ?>>Follow Up Pekerja Masuk</option>
			<option value="4" <?= (in_array(4, $status)) ? 'selected':'' ?>>Done</option>
			<option value="5" <?= (in_array(5, $status)) ? 'selected':'' ?>>Tidak Perlu Isolasi</option>
		</select>
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
				<th class="bg-primary" rowspan="2" style="text-align: center;">Status</th>
				<th class="bg-primary" rowspan="2" style="text-align: center;">Noind</th>
				<th class="bg-primary" rowspan="2" style="text-align: center;">Nama</th>
				<th class="bg-primary" rowspan="2" style="text-align: center; width: 100px;">Tgl Laporan</th>
				<th class="bg-primary" rowspan="2" style="text-align: center; min-width: 200px;">Keterangan</th>
				<?php foreach ($bulan as $b):  $widt = $b['jumlah']*50; ?>
					<th style="text-align: center;" colspan="<?= $b['jumlah'] ?>"><?= date('M Y', strtotime($b['bulan'])) ?></th>	
				<?php endforeach ?>
			</tr>
			<tr>
				<?php foreach ($bulan as $b):
					$Ym = date('Y-m', strtotime($b['bulan']));
				?>
					<?php 
					for ($i=1; $i <= $b['jumlah']; $i++) {
						if ($i<10) {
							$n = '0'.$i;
						}else{
							$n = $i;
						}

						if ($Ym == date('Y-m') && $i/10 == date('d')/10) {
							$bg = 'bg-sukses';
						}elseif(date('D', strtotime($Ym.'-'.$n)) == 'Sun' || in_array($Ym.'-'.$n, $libur)){
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
					<td style="text-align: center;">
						<button class="btn" style="color: #fff; background-color: <?= $k['background_color'] ?>">
							<?= $k['status_kondisi'] ?>
						</button>
					</td>
					<td><?= $k['noind']; ?></td>
					<td><?= $k['nama']; ?></td>
					<td><?= date('Y-m-d', strtotime($k['created_date'])); ?></td>
					<td><?= $k['keterangan']; ?></td>
					<?php foreach ($bulan as $b):
						$Ym = date('Y-m', strtotime($b['bulan']));
					?>
						<?php 
							for ($i=1; $i <= $b['jumlah']; $i++) { 
								if ($i < 10) {
									$nu = '0'.$i;
								}else{
									$nu = $i;
								}

								if ($Ym == date('Y-m') && $i/10 == date('d')/10) {
									$bi = 'background-image: linear-gradient(to right, green , yellow);';
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

<div class="modal fade" id="cvd_wfhpst" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<label class="modal-title" id="exampleModalLabel">Isolasi di Rumah (Pusat) Hari Ini</label>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Pekerja</th>
						</tr>
					</thead>
					<tbody>
						<?php $x=1; foreach ($wfhPst as $key): ?>
							<tr>
								<td><?=$x++;?></td>
								<td><?= $key['noind'].' - '.$key['nama'] ?></td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="cvd_wfhtks" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<label class="modal-title" id="exampleModalLabel">Isolasi di Rumah (Tuksono) Hari Ini</label>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Pekerja</th>
						</tr>
					</thead>
					<tbody>
						<?php $x=1; foreach ($wfhTks as $key): ?>
							<tr>
								<td><?=$x++;?></td>
								<td><?= $key['noind'].' - '.$key['nama'] ?></td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="cvd_wfopst" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<label class="modal-title" id="exampleModalLabel">Isolasi di Perusahaan (Pusat) Hari Ini</label>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Pekerja</th>
						</tr>
					</thead>
					<tbody>
						<?php $x=1; foreach ($wfoPst as $key): ?>
							<tr>
								<td><?=$x++;?></td>
								<td><?= $key['noind'].' - '.$key['nama'] ?></td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="cvd_wfotks" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<label class="modal-title" id="exampleModalLabel">Isolasi di Perusahaan (Tuksono) Hari Ini</label>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Pekerja</th>
						</tr>
					</thead>
					<tbody>
						<?php $x=1; foreach ($wfoTks as $key): ?>
							<tr>
								<td><?=$x++;?></td>
								<td><?= $key['noind'].' - '.$key['nama'] ?></td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="cvd_aknselesai" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<label class="modal-title" id="exampleModalLabel">Isolasi Hampir Selesai</label>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Pekerja</th>
						</tr>
					</thead>
					<tbody>
						<?php $x=1; foreach ($akanSelesai as $key): ?>
							<tr>
								<td><?=$x++;?></td>
								<td><?= $key['employee_code'].' - '.$key['employee_name'] ?></td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script>
	window.addEventListener('load', function () {
		$('.content').show();
		getDataMonitoringCovid();
		<?php if (empty($status)): ?>
			$('.cvd_select3').val(null).trigger('change');
		<?php else: ?>
			$('.cvd_select3').trigger('change');
		<?php endif ?>
	});
</script>