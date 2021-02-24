<html>
<head>
</head>
<body>
<?php
		set_time_limit(0);
		ini_set("memory_limit", "2048M");

	?>
  <?php foreach ($pekerjaPHK as $key) { ?>
<div style="width: 100%;padding-right: 20px;padding-left: 20px">
	<table style="width:100%;font-size: 18px; text-align: center;padding: 20px; border: 1px solid black;">
		<tr>
			<td style="width: 1%;" rowspan="4">
				<img style="height: 80px; width: 70px;margin-left: 100px;" src="<?php echo base_url('/assets/img/logo.png') ?>" />
			</td>
		</tr>
		<tr>
			<td style="font-family: times; margin-bottom: 0.5em;"><b><u>SEKSI HUBUNGAN KERJA</u></b></td>
		</tr>
		<tr>
			<td style="font-family: times; margin-bottom: 0.5em;"><b>CV. KARYA HIDUP SENTOSA</b></td>
		</tr>
		<tr>
			<td style="font-family: times; margin-bottom: 0.5em;"><b>JL. MAGELANG NO. 144 YOGYAKARTA</b></td>
		</tr>
	</table>
  <br>
  <p style="text-align: center; font-size: 15px; font-family: times;"><b>PERJANJIAN BERSAMA PEMUTUSAN HUBUNGAN KERJA</b></p>
  <p style="text-align: center; font-size: 15px; font-family: times; line-height:1px;"><b>KARENA USIA LANJUT</b></p>
	<br>
  <p style="font-size: 14px; font-family: times;">Pada hari <b><?php echo $hari; ?></b> tanggal <b><?php echo date('d') ?></b> bulan <b><?php echo $month ?></b> tahun <b><?php echo date('Y') ?></b>, kami yang bertandatangan dibawah ini:</p>
  <table style="border: 1px solid black; width: 100%">
    <tr>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:20px; font-size: 14px; font-family: times; text-align: center;">1.</td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width: 200px; font-size: 14px; font-family: times;">&nbsp;Nama Pekerja</td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:10px; text-align: center font-size: 14px; font-family: times; text-align: center;">:</td>
			<td style="width:5px; border-bottom: 1px solid black;"></td>
			<td style="border-bottom: 1px solid black; font-size: 14px; font-family: times;"><b><?php echo ucwords(strtolower($key['nama'])) ?></b></td>
    </tr>
    <tr>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:20px; font-size: 14px; font-family: times;"></td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width: 200px; font-size: 14px; font-family: times;">&nbsp;No Induk</td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:10px; text-align: center font-size: 14px; font-family: times; text-align: center;">:</td>
			<td style="width:5px; border-bottom: 1px solid black;"></td>
			<td style="border-bottom: 1px solid black; font-size: 14px; font-family: times;"><b><?php echo $key['noind'] ?></b></td>
    </tr>
    <tr>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:20px; font-size: 14px; font-family: times;"></td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width: 200px; font-size: 14px; font-family: times;">&nbsp;Seksi / Unit / Departement</td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:10px; text-align: center font-size: 14px; font-family: times; text-align: center;">:</td>
			<td style="width:5px; border-bottom: 1px solid black;"></td>
			<td style="border-bottom: 1px solid black; font-size: 14px; font-family: times; text-align: justify;"><?php echo ucwords(strtolower($key['seksi'])).' / '.ucwords(strtolower($key['unit'])).' / '.ucwords(strtolower($key['dept'])) ?></td>
    </tr>
    <tr>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:20px; font-size: 14px; font-family: times;"></td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width: 200px; font-size: 14px; font-family: times;" valign="top">&nbsp;Alamat</td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:10px; text-align: center font-size: 14px; font-family: times; text-align: center;" valign="top">:</td>
			<td style="width:5px; border-bottom: 1px solid black;"></td>
			<td style="border-bottom: 1px solid black; font-size: 14px; font-family: times; text-align: justify;"><?php echo ucwords(strtolower($key['alamat'])).', '.ucwords(strtolower($key['desa'])).', '.ucwords(strtolower($key['kec'])).', '.ucwords(strtolower($key['kab'])).', '.$provinsi ?></td>
    </tr>
    <tr>
      <td style="height: 15px; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
      <td style="height: 15px; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
      <td style="height: 15px; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
			<td style="width:5px; border-bottom: 1px solid black;"></td>
			<td style="height: 15px; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
    </tr>
    <tr>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:20px; font-size: 14px; font-family: times; text-align: center;">2.</td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width: 200px; font-size: 14px; font-family: times;">&nbsp;Nama Perusahaan</td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:10px; text-align: center font-size: 14px; font-family: times; text-align: center;">:</td>
			<td style="width:5px; border-bottom: 1px solid black;"></td>
			<td style="border-bottom: 1px solid black; font-size: 14px; font-family: times;"><b>CV. Karya Hidup Sentosa</b></td>
    </tr>
    <tr>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:20px; font-size: 14px; font-family: times;"></td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width: 200px; font-size: 14px; font-family: times;">&nbsp;Alamat Perusahaan</td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:10px; text-align: center font-size: 14px; font-family: times; text-align: center;">:</td>
			<td style="width:5px; border-bottom: 1px solid black;"></td>
			<td style="border-bottom: 1px solid black; font-size: 14px; font-family: times;">Jl. Magelang No. 144 Yogyakarta</td>
    </tr>
    <tr>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:20px; font-size: 14px; font-family: times;"></td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width: 200px; font-size: 14px; font-family: times;">&nbsp;Nama Wakil Perusahaan</td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:10px; text-align: center font-size: 14px; font-family: times; text-align: center;">:</td>
			<td style="width:5px; border-bottom: 1px solid black;"></td>
			<td style="border-bottom: 1px solid black; font-size: 14px; font-family: times;"><b><?php echo ucwords(strtolower($personalia)) ?></b></td>
    </tr>
    <tr>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:20px; font-size: 14px; font-family: times;"></td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width: 200px; font-size: 14px; font-family: times;">&nbsp;Tempat Perundingan</td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:10px; text-align: center font-size: 14px; font-family: times; text-align: center;">:</td>
			<td style="width:5px; border-bottom: 1px solid black;"></td>
			<td style="border-bottom: 1px solid black; font-size: 14px; font-family: times;">Ruang Personalia</td>
    </tr>
    <tr>
      <td style="height: 15px; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
      <td style="height: 15px; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
      <td style="height: 15px; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
			<td style="width:5px; border-bottom: 1px solid black;"></td>
			<td style="height: 15px; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
    </tr>
    <tr>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:20px; font-size: 14px; font-family: times; text-align: center;">3.</td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width: 200px; font-size: 14px; font-family: times;">&nbsp;Nama Serikat Pekerja</td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:10px; text-align: center font-size: 14px; font-family: times; text-align: center;">:</td>
			<td style="width:5px; border-bottom: 1px solid black;"></td>
			<td style="border-bottom: 1px solid black; font-size: 14px; font-family: times;"><b>PUK-SPSI CV. Karya Hidup Sentosa</b></td>
    </tr>
    <tr>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:20px; font-size: 14px; font-family: times;"></td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width: 200px; font-size: 14px; font-family: times;">&nbsp;Alamat Serikat Pekerja</td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:10px; text-align: center font-size: 14px; font-family: times; text-align: center;">:</td>
			<td style="width:5px; border-bottom: 1px solid black;"></td>
			<td style="border-bottom: 1px solid black; font-size: 14px; font-family: times;">Jl. Magelang No. 144 Yogyakarta</td>
    </tr>
    <tr>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:20px; font-size: 14px; font-family: times;"></td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width: 200px; font-size: 14px; font-family: times;">&nbsp;Nama Wakil Serikat Pekerja</td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:10px; text-align: center font-size: 14px; font-family: times; text-align: center;">:</td>
			<td style="width:5px; border-bottom: 1px solid black;"></td>
			<td style="border-bottom: 1px solid black; font-size: 14px; font-family: times;"><b><?php echo ucwords(strtolower($spsi)) ?></b></td>
    </tr>
    <tr>
      <td style="height: 15px; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
      <td style="height: 15px; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
      <td style="height: 15px; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
			<td style="width:5px; border-bottom: 1px solid black;"></td>
			<td style="height: 15px; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
    </tr>
    <tr>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:20px; font-size: 14px; font-family: times; text-align: center;" valign="top">4.</td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width: 200px; font-size: 14px; font-family: times;" valign="top">&nbsp;Pokok Perundingan</td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:10px; text-align: center font-size: 14px; font-family: times; text-align: center;" valign="top">:</td>
			<td style="width:5px; border-bottom: 1px solid black;"></td>
			<td style="border-bottom: 1px solid black; font-size: 14px; font-family: times; text-align: justify;"><b><?php echo $jenis ?> <?php echo ucwords(strtolower($key['nama'])).'('.$key['noind'].')' ?></b> akan diputus Hubungan Kerja (PHK) karena Usia Lanjut oleh Perusahaan, dan sesuai dengan pasal 14 ayat (1) Perjanjian Kerja Bersama CV. Karya Hidup Sentosa, sehingga hubungan kerja dengan Perusahaan berakhir pada tanggal <b><?php echo $tgl_keluar.' '.$bln_keluar.' '.$thn_keluar ?></b></td>
    </tr>
    <tr>
      <td style="height: 15px; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
      <td style="height: 15px; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
      <td style="height: 15px; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
			<td style="width:5px; border-bottom: 1px solid black;"></td>
			<td style="height: 15px; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
    </tr>
    <tr>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:20px; font-size: 14px; font-family: times; text-align: center;">5.</td>
			<td style="border-right:1px solid black; border-bottom: 1px solid black; width: 200px; font-size: 14px; font-family: times;" valign="top">&nbsp;Pendirian Para Pihak</td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:10px; text-align: center font-size: 14px; font-family: times; text-align: center;" valign="top">:</td>
			<td style="width:5px; border-bottom: 1px solid black;"></td>
			<td style="border-bottom: 1px solid black; font-size: 14px; font-family: times;">&nbsp;</td>
    </tr>
    <tr>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:20px; font-size: 14px; font-family: times; text-align: center;"></td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width: 200px; font-size: 14px; font-family: times;" valign="top">&nbsp;a. Pekerja</td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:10px; text-align: center font-size: 14px; font-family: times; text-align: center;" valign="top">:</td>
			<td style="width:5px; border-bottom: 1px solid black;"></td>
			<td style="border-bottom: 1px solid black; font-size: 14px; font-family: times; text-align: justify;">Menyadari sepenuhnya rencana Perusahaan dan bersedia di-putus Hubungan Kerja (PHK) karena Usia lanjut secara Bipartit<hr width="40%" style="margin-bottom: 0.5em; margin-right: auto;"></td>
    </tr>
    <tr>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:20px; font-size: 14px; font-family: times; text-align: center;"></td>
			<td style="border-right:1px solid black; border-bottom: 1px solid black; width: 200px; font-size: 14px; font-family: times;" valign="top">&nbsp;b. Perusahaan</td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:10px; text-align: center font-size: 14px; font-family: times; text-align: center;" valign="top">:</td>
			<td style="width:5px; border-bottom: 1px solid black;"></td>
			<td style="border-bottom: 1px solid black; font-size: 14px; font-family: times; text-align: justify;">Melaksanakan proses PHK Usia Lanjut secara Bipartit<hr width="40%" style="margin-right: auto; margin-bottom: 0.5em;"></td>
    </tr>
    <tr>
      <td style="height: 15px; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
      <td style="height: 15px; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
      <td style="height: 15px; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
			<td style="width:5px; border-bottom: 1px solid black;"></td>
			<td style="height: 15px; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
    </tr>
    <tr>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:20px; font-size: 14px; font-family: times; text-align: center;" valign="top">6.</td>
			<td style="border-right:1px solid black; border-bottom: 1px solid black; width: 200px; font-size: 14px; font-family: times;" valign="top">&nbsp;Kesimpulan</td>
      <td style="border-right:1px solid black; border-bottom: 1px solid black; width:10px; text-align: center font-size: 14px; font-family: times; text-align: center;" valign="top">:</td>
			<td style="width:5px; border-bottom: 1px solid black;"></td>
			<td style="border-bottom: 1px solid black; font-size: 14px; font-family: times; text-align: justify;">Kedua belah pihak sepakat untuk mengakhiri hubungan kerjanya secara Bipartit pertanggal <b><?php echo $tgl_keluar.' '.$bln_keluar.' '.$thn_keluar ?></b> dan Perusahaan memberikan kompensasi sesuai PP No. 35 tahun 2021<hr width="40%" style="margin-bottom: 0.5em; margin-right: auto;"></td>
    </tr>
  </table>
	<br>
	<p style="font-size: 14px; font-family: times;"><b>Daftar Hadir</b></p>
	<table  style="border: 1px solid black; width: 100%;">
		<tr>
			<td style="border-right:1px solid black; border-bottom: 1px solid black; width: 200px; font-size: 14px; font-family: times;">&nbsp;a. <?php echo ucwords(strtolower($key['nama'])) ?></td>
			<td style="border-right: 1px solid black; border-bottom: 1px solid black; valign: center;">&nbsp;a.<hr width="40%" style="margin-bottom: 0.5em; margin-top: 0.5em;"></td>
			<td style="border-bottom: 1px solid black;"></td>
		</tr>
		<tr>
			<td style="border-right:1px solid black; border-bottom: 1px solid black; width: 200px; font-size: 14px; font-family: times;">&nbsp;b. <?php echo ucwords(strtolower($personalia)) ?></td>
			<td style="border-right: 1px solid black; border-bottom: 1px solid black;"></td>
			<td style="border-bottom: 1px solid black; valign: center;">&nbsp;b.<hr width="40%" style="margin-bottom: 0.5em; margin-top: 0.5em;"></td>
		</tr>
		<tr>
			<td style="border-right:1px solid black; border-bottom: 1px solid black; width: 200px; font-size: 14px; font-family: times;">&nbsp;c. <?php echo ucwords(strtolower($spsi)) ?></td>
			<td style="border-right: 1px solid black; border-bottom: 1px solid black; valign: center;">&nbsp;c.<hr width="40%" style="margin-bottom: 0.5em; margin-top: 0.5em;"></td>
			<td style="border-bottom: 1px solid black;"></td>
		</tr>
		<tr>
			<td style="border-right:1px solid black; border-bottom: 1px solid black; width: 200px; font-size: 14px; font-family: times;">&nbsp;d. <?php echo ucwords(strtolower($saksi1)) ?></td>
			<td style="border-right: 1px solid black; border-bottom: 1px solid black;"></td>
			<td style="border-bottom: 1px solid black; valign: center;">&nbsp;d.<hr width="40%" style="margin-bottom: 0.5em; margin-top: 0.5em;"></td>
		</tr>
		<tr>
			<td style="border-right:1px solid black; border-bottom: 1px solid black; width: 200px; font-size: 14px; font-family: times;">&nbsp;e. <?php echo ucwords(strtolower($saksi2)) ?></td>
			<td style="border-right: 1px solid black; border-bottom: 1px solid black; valign: center;">&nbsp;e.<hr width="40%" style="margin-bottom: 0.5em; margin-top: 0.5em;"></td>
			<td style="border-bottom: 1px solid black;"></td>
		</tr>
	</table>
</div>
</body>
</html>
<?php } ?>
