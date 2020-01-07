<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div>
	<div style="width: 100%;height: 100%;">
		<div style="border: 1px solid black;margin-bottom: 10px;">
			<h3 style="text-align: center;font-size: 20px;font-weight: bold;">
				Detail Approval Absen
			</h3>
		</div>
		<div style="width: 100%;height: 100%">
			<div style="margin: 10px;">
				<div align="center">
					<img src="<?= $dataEmployee[0]['gambar'] ?>" style="width: 200px;height: 200px;display: block;margin: 0 auto;">
				</div>
				<div style="width: 100%;height: 100%;margin-top: 10px;">
					<h3 style="font-weight: bold;font-size: 18px;">Detail Pekerja</h3>
					<table class="table table-bordered" style="width: 100%;">
						<tr>
							<td style="width: 33%;padding: 5px;">No. Induk</td>
							<td style="width: 3%;text-align: center;">:</td>
							<td style="width: 64%;padding-left: 5px;"><?= $dataEmployee[0]['noind'] ?></td>
						</tr>
						<tr>
							<td style="width: 33%;padding: 5px;">Nama</td>
							<td style="width: 3%;text-align: center;">:</td>
							<td style="width: 64%;padding-left: 5px;"><?= $dataEmployee[0]['nama'] ?></td>
						</tr>
						<tr>
							<td style="width: 33%;padding: 5px;">Seksi</td>
							<td style="width: 3%;text-align: center;">:</td>
							<td style="width: 64%;padding-left: 5px;"><?= $employeeInfo[0]['section_name'] ?></td>
						</tr>
						<tr>
							<td style="width: 33%;padding: 5px;">Unit</td>
							<td style="width: 3%;text-align: center;">:</td>
							<td style="width: 64%;padding-left: 5px;"><?= $employeeInfo[0]['unit_name'] ?></td>
						</tr>
						<tr>
							<td style="width: 33%;padding: 5px;">Bidang</td>
							<td style="width: 3%;text-align: center;">:</td>
							<td style="width: 64%;padding-left: 5px;"><?= $employeeInfo[0]['field_name'] ?></td>
						</tr>
						<tr>
							<td style="width: 33%;padding: 5px;">Departemen</td>
							<td style="width: 3%;text-align: center;">:</td>
							<td style="width: 64%;padding-left: 5px;"><?= $employeeInfo[0]['department_name'] ?></td>
						</tr>						
					</table>
					<h3 style="font-weight: bold;font-size: 18px;">Detail Absen</h3>
					<table class="table table-bordered">
							<tr>
							<td style="width: 33%;padding: 5px;">Waktu</td>
							<td style="width: 3%;text-align: center;">:</td>
							<td style="width: 64%;padding: 5px;"><?= $dataEmployee[0]['waktu'] ?></td>
						</tr>
						<tr>
							<td style="width: 33%;padding: 5px;">Lokasi</td>
							<td style="width: 3%;text-align: center;">:</td>
							<td style="width: 64%;padding: 5px;"><?= $dataEmployee[0]['lokasi'] ?></td>
						</tr>
						<tr>
							<td style="width: 33%;padding: 5px;">Jenis Absen</td>
							<td style="width: 3%;text-align: center;">:</td>
							<td style="width: 64%;padding: 5px;"><?= $dataEmployee[0]['jenis_absen'] ?></td>
						</tr>
						</table>
				</div>

			</div>
			
		</div>
		
	</div>
</div>

</body>
</html>