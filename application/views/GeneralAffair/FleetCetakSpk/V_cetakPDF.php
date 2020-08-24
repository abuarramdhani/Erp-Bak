<!DOCTYPE html>
<html>
<body>
	<table style="width:100%;margin-bottom: 5px;border-bottom: 2px solid black;">
		<tr>
			<td style="width: 80px;height: 100px;"><img src="<?php echo base_url('/assets/img/logo.png'); ?>" width="80" heigth="60"></td>
			<td style="width: 520px;height: 100px">
				<h3 style="margin-bottom: 0; padding-bottom: 0;font-size: 24px">CV. KARYA HIDUP SENTOSA</h3>
				<p style="font-size: 16px">Jl. Magelang 144, Yogyakarta (55241) Indonesia</p>
				<p style="font-size: 16px">Phone : (0274) 563217, 556923, 513025, 584874, 512095 (hunting)</p>
				<p style="font-size: 16px">Fax : (0274) 563523 E-mail : operator1@quick.co.id</p>
			</td>
		</tr>
	</table>
	<h4 style="text-align: center;font-size: 18px;margin-bottom: 0px; padding-bottom: 0px;margin-top: 5px"><b>SURAT PERINTAH KERJA SERVICE KENDARAAN</b></h4>
	<br></br>
	<table style="margin-bottom: 0px;padding-bottom: 0px;margin-top: 5px">
		<tr>
			<td> 
				<p style="font-size: 14px">No</p>
				<p style="font-size: 14px">Hal</p>
				<p style="font-size: 14px">Lampiran</p>
			</td>
			<td>
				<p style="font-size: 14px">: <?php echo $FleetHeaderCetakSpk['no_surat']." / GA / KE-A / ".$tanggal[1]." / ".$tanggal[0];?></p>
				<p style="font-size: 14px">: <b>Permintaan Service Kendaraan CV Karya Hidup Sentosa</b></p>
				<p style="font-size: 14px">: -</p>
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<br></br>
				<p style="font-size: 14px">Kepada Yth.</p>
				<p style="font-size: 14px"><b>Bagian Service Kendaraan</b></p>
				<p style="font-size: 14px"><b><?php echo $FleetHeaderCetakSpk['nama_bengkel'];?></b></p>
				<p style="font-size: 14px"><b><?php echo $FleetHeaderCetakSpk['alamat_bengkel'];?></b></p>
			</td>
			
		</tr>
	</table>
	<br></br>
	<p style="font-size: 14px">Dengan hormat,<br></br>
		Sesuai dengan Perjanjian Kerjasama Service Kendaraan antara CV Karya Hidup Sentosa dengan <?php echo $FleetHeaderCetakSpk['nama_bengkel']; ?> di Yogyakarta, maka mohon dilakukan service kendaraan sbb:
	</p>
	<table style="border:1px solid black;width: 100%;">
		<thead>
			<tr>
				<th style="font-size: 14px;border: 1px solid black;padding: 4px">No</th>
				<th style="font-size: 14px;border: 1px solid black;padding: 4px">Jenis Kendaraan</th>
				<th style="font-size: 14px;border: 1px solid black;padding: 4px">Keterangan Service</th>
			</tr>
		</thead>
		<tbody>
			<?php $no=1; foreach ($FleetLineSpkDetail as $key):?>
			<tr>
				<td style="font-size: 14px;border: 1px solid black;padding: 4px"> <?php echo $no++; ?></td>
				<td style="font-size: 14px;border: 1px solid black;padding: 4px"> <?php echo $key['jenis_kendaraan'] ?></td>
				<td style="font-size: 14px;border: 1px solid black;padding: 4px"> <?php echo $key['jenis_maintenance'] ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<br></br>
	<p style="font-size: 14px;">Estimasi biaya service mohon dapat dikirimkan ke email purchasing.sec11@gmail.com dan WhatsApp ke 0811 2575 216 up/ Pak Fikri dengan <b>Subject : Estimasi Biaya Service Mobil <?php echo $FleetHeaderCetakSpk['merk_kendaraan']." Plat No ".$FleetHeaderCetakSpk['no_pol'];?></b>. Estimasi terhadap biaya service tersebut akan kami berikan persetujuan terlebih dahulu, sebelum service dikerjakan.<br></br>
		Demikian surat ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.
	</p>
	<div style="position: absolute;bottom: 100px;left: 100px">
		<table>
			<tr>
				<td> </td>
			</tr>
			<tr>
				<td style="padding: 7px;text-align: center;">Mengetahui,</td>
			</tr>
			<tr>
				<td style="padding: 30px 7px"> </td>
			</tr>
			<tr>
				<td style="padding: 7px;text-align: center;">Rajiwan</td>
			</tr>
			<tr>
				<td style="padding: 7px;text-align: center;">(Kepala Seksi Utama GA & Hubungan Kerja)</td>
			</tr>
		</table>
	</div>
	<div style="position: absolute;bottom: 100px;right: 100px">
		<table>
			<tr>
				<td style="text-align: center;">Yogyakarta, <?php echo date('d F Y'); ?></td>
			</tr>
			<tr>
				<td style="padding: 7px;text-align: center;">Hormat Kami,</td>
			</tr>
			<tr>
				<td style="padding: 30px 7px"> </td>
			</tr>
			<tr>
				<td style="padding: 7px;text-align: center;">Yosua Andi Erlangga</td>
			</tr>
			<tr>
				<td style="padding: 7px;text-align: center;">(Kasi Madya GA)</td>
			</tr>
		</table>
	</div>
</body>
</html>