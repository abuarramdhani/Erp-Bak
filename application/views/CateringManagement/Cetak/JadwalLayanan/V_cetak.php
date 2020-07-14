<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="row">
		<div class="col-lg-12">
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
							<th width="14%" style="text-align: center;">Tanggal</th>
							<th width="17%" style="text-align: center;">Shift 1 & Shift Umum</th>
							<th width="17%" style="text-align: center;">Shift 2</th>
							<th width="17%" style="text-align: center;">Shift 3</th>
							<th width="17%" style="text-align: center;">Catering Libur</th>
							<th width="18%" style="text-align: center;">Keterangan</th>
						</tr>
					</thead>
					<tbody style="font-size: 8pt;">
						<?php 
						foreach ($table as $key) { ?>
							<tr>
								<td><?php echo $key['tanggal'] ?></td>
								<td <?php echo $key['shift1'] == "-" ? 'style="text-align: center"' : ""; ?>><?php echo $key['shift1'] ?></td>
								<td <?php echo $key['shift2'] == "-" ? 'style="text-align: center"' : ""; ?>><?php echo $key['shift2'] ?></td>
								<td <?php echo $key['shift3'] == "-" ? 'style="text-align: center"' : ""; ?>><?php echo $key['shift3'] ?></td>
								<td <?php echo $key['libur'] == "-" ? 'style="text-align: center"' : ""; ?>><?php echo $key['libur'] ?></td>
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
		<div class="col-lg-12">
			<table style="width: 100%">
				<tr>
					<td style="width: 60%">&nbsp;</td>
					<td style="text-align: center;width: 40%">Yogyakarta, <?php echo $data['cetak'] ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td style="text-align: center;"><?php echo ucwords(strtolower($this->session->employee)) ?></td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>
	