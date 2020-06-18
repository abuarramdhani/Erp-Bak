<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<label><b style="font-size: 15pt;">Jadwal Pengiriman Catering <?php echo $pengiriman['nama_catering'] ?></b><br><b>Bulan : <?php echo $pengiriman['bulan'] ?></b></label>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover text-left">
					<thead>
						<tr>
							<th style="text-align: center">Tanggal</th>
							<th style="text-align: center">Jadwal Kirim</th>
							<th style="text-align: center">Waktu</th>
							<th style="text-align: center">Keterangan</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							foreach ($table as $key) { ?>
								<tr>
									<td><?php echo $key['tanggal'] ?></td>
									<td><?php echo $key['jadwal'] ?></td>
									<td><?php echo $key['waktu'] ?></td>
									<td><?php echo $key['keterangan'] ?></td>
								</tr>
						<?php	} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<label class="form-label"><b>Catatan<br>Daftar Menu : Paket <?php echo $pengiriman['paket'] ?></b></label>
			<table style="width: 100%">
				<tr>
					<td style="width: 50%;text-align: center;"></td>
					<td style="width: 50%;text-align: center;">Yogyakarya, <?php  echo $pengiriman['tanggalbuat'] ?></td>
				</tr>
				<tr>
					<td style="text-align: center;">Departement Personalia,</td>
					<td style="text-align: center;">Catering <?php echo $pengiriman['nama_catering'] ?>,</td>
				</tr>
				<tr>
					<td></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td style="text-align: center;"><?php echo $pengiriman['ppersonalia'] ?></td>
					<td style="text-align: center;"><?php echo $pengiriman['pcatering'] ?></td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>