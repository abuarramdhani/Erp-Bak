<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body class="container-fluid">
	<div class="row">
		<div class="col-lg-12 text-left">
			<label><b style="font-size: 20px;">CV. Karya Hidup Sentosa<br>Yogyakarta</b></label>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 text-center">
			<label><b style="font-size: 20px;">Jadwal Pengiriman Catering <?php echo $pengiriman['nama_catering'] ?><br>Bulan : <?php echo $pengiriman['bulan'] ?></b></label>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover text-left">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>Jadwal Kirim</th>
							<th>Waktu</th>
							<th>Keterangan</th>
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
		<label class="form-label"><b>Catatan<br>Daftar Menu : Paket <?php echo $pengiriman['paket'] ?></b></label>
	</div>
	<div class="row">
		<div style="width: 30%;float: left">
			<div class="col-lg-3 text-center">
				<br><label>Departement Personalia,</label><br><br><br><br>
				<label><?php echo $pengiriman['ppersonalia'] ?></label>
			</div>
		</div>
		<div class="text-right" style="width: 30%;float: right">
			<label class="control-label">Yogyakarya, <?php  echo $pengiriman['tanggalbuat'] ?></label>
			<div class="col-lg-3 text-center">
				<label>Catering <?php echo $pengiriman['nama_catering'] ?>,</label><br><br><br><br>
				<label><?php echo $pengiriman['pcatering'] ?></label>
			</div>
		</div>
	</div>
</body>
</html>