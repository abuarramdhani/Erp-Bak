<html>
<head>
</head>
<body>
<?php
		set_time_limit(0);
		ini_set("memory_limit", "2048M");

	?>
  <?php foreach ($data as $dt) { ?>
<div style="width: 100%;padding-right: 20px;padding-left: 20px">
  <p style="text-align: center;">
  <span style="text-align: center;font-size: 15pt;margin-bottom: 1px">
  <strong><u>SURAT KETERANGAN</u></strong>
  </span>
  <br>
  <span style="text-align: center;font-size: 10pt;margin-top: 1px">
  <strong>No. : <?php echo $dt['nomor'] ?>/PS/KE-A/<?php echo $dt['bulan'] ?>/<?php echo $dt['tahun'] ?></strong>
  </span>
</p>
<br>
<p style="text-align: justify;">
  Dengan ini Departemen Personalia CV.Karya Hidup Sentosa, Jln Magelang 144 Yogyakarta menerangkan dengan sesungguhnya bahwa
</p>

<table border="0" style="width: 100%;margin-left: 5%;border: 1px solid white">
<tbody>
<tr>
  <td style="width: 25%"><b> Nama <strong></td>
  <td style="width: 5%"> <strong>:<strong></td>
  <td style="width: 70%"><strong><?php echo $dt['nama'] ?><strong></td>
</tr>
<tr>
  <td><strong>Tempat/Tgl Lahir <strong></td>
  <td><strong>:<strong></td>
  <td><strong><?php echo $dt['templahir'].','.$dt['lahir'] ?> <strong></td>
</tr>
<tr>
  <td><strong>No.Induk Pekerja <strong></td>
  <td><strong>:<strong></td>
  <td><strong><?php echo $dt['noind']?><strong></td>
</tr>
<tr>
  <td valign="top"> <strong>Alamat <strong></td>
  <td valign="top"><strong>:<strong></td>
  <!--<td><strong><?php echo $dt['alamat'].','.$dt['kec'].','.$dt['kab'].','.$dt['prop'].','.$dt['kodepos'] ?><strong></td> -->
  <td>
  <strong><?= trim($dt['alamat']) . ', ' . trim($dt['kec']) . ', ' . trim($dt['kab']) . ', ' . trim($dt['prop']) . ', ' . trim($dt['kodepos']) ?>
  <strong>
</td>
</tr>
<?php if (!empty($nik)): ?>
<tr>
  <td> <strong> NIK  <strong></td>
  <td> <strong>: <strong></td>
  <td> <strong><?php echo $nik_pengalaman ?> <strong></td>
</tr>
<?php endif ?>

</tbody>
</table>
<p style="text-align: justify;">
  Adalah benar-benar pekerja dengan status <?php echo $stat ?> di Perusahaan kami, pada :
</p>

<table border="0" style="width: 100%;margin-left: 5%;border: 1px solid white">
<tbody>
<tr>
  <td style="width: 25%"> Mulai bekerja </td>
  <td style="width: 5%"> :</td>
  <td style="width: 70%"><?php echo $dt['masuk'] ?></td>
</tr>
<tr>
  <td>Sampai </td>
  <td>:</td>
  <td><?php echo $sampai ?> </td>
</tr>
<tr>
  <td valign="top">Seksi</td>
  <td valign="top">:</td>
  <td> Seksi <?php echo $dt['seksi'].', Unit '.$dt['unit'].', Departemen '.$dt['dept']?></td>
</tr>
<tr>
  <td valign="top"> Jabatan </td>
  <td valign="top">:</td>
  <td><?php echo $jabatan_pengalaman ?></td>
</tr>
</tbody>
</table>

<p style="text-align: justify;">
  <?php echo $dt['isi_surat']?>
</p>
<p style="text-align: justify;">
  Demikian surat keterangan ini dibuat untuk dapat digunakan sebagaimana mestinya.
</p>
<p>
  Yogyakarta, <?php echo $pengalaman_tglCetak ?>
  <br>
  CV Karya Hidup Sentosa
  <br>
  Departemen Personalia
</p>
<p>
  &nbsp;
</p>
<p>
  &nbsp;
</p>
<p>
  <u><strong>Rajiwan</strong></u><br>
  Kepala Seksi Utama
</p>
<p>
  <u><strong>Tembusan :</strong></u><br>
  -Arsip <br>
  <i>rs / af</i>
</p>
</div>
</body>
</html>
<?php } ?>
