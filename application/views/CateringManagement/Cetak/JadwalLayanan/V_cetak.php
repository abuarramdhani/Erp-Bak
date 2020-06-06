<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="row">
		<div class="col-lg-12 text-center">
			<label><b style="font-size: 15pt;">Jadwal Pelayanan Catering<?php echo $data['lokasi'] == '1' ? 'Yogyakarta & Mlati' : 'Tuksono' ?></b><br>Bulan : <?php echo $data['bulan'] ?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 text-right">
			<label>Paket : <?php echo $data['paket'] ?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="table-resposive">
				<table class="table table-striped table-hover table-bordered text-left" style="font-size: 9pt;">
					<thead class="bg-primary">
						<tr>
							<th width="14%">Tanggal</th>
							<th width="17%">Shift 1 & Shift Umum</th>
							<th width="17%">Shift 2</th>
							<th width="17%">Shift 3</th>
							<th width="17%">Catering Libur</th>
							<th width="18%">Keterangan</th>
						</tr>
					</thead>
					<tbody style="font-size: 8pt;">
						<?php 
						foreach ($table as $key) { ?>
							<tr>
								<td><?php echo $key['tanggal'] ?></td>
								<td><?php echo $key['shift1'] ?></td>
								<td><?php echo $key['shift2'] ?></td>
								<td><?php echo $key['shift3'] ?></td>
								<td><?php echo $key['libur'] ?></td>
								<td><?php echo $key['keterangan'] ?></td>
							</tr>
						<?php }
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 text-right">
			<label>Yogyakarta, <?php echo $data['cetak'] ?></label>
		</div>
	</div>
</body>
</html>
	