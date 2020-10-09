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
        <span style="text-align: center;font-size: 15pt;margin-bottom: 1px; font-family: Verdana;">
          <strong><u>SURAT KETERANGAN</u></strong>
        </span>
        <br>
        <span style="text-align: center;font-size: 9pt;margin-top: 1px; font-family: Verdana;">
          <strong>No. : <?php echo $dt['nomor'] ?>/PS/KE-A/<?php echo $dt['bulan'] ?>/<?php echo $dt['tahun'] ?></strong>
        </span>
      </p>
      <br>
      <p style="text-align: justify;font-size: 9pt; font-family: Verdana;">
        Dengan ini Departemen Personalia CV.Karya Hidup Sentosa, Jln Magelang 144 Yogyakarta menerangkan dengan sesungguhnya bahwa
      </p>

      <table border="0" style="width: 100%;margin-left: 5%;border: 1px solid white">
        <tbody>
          <tr>
            <td style="width: 25%;font-size: 9pt; font-family: Verdana;"><b> Nama <strong></td>
            <td style="width: 5%"> <strong>:<strong></td>
            <td style="width: 70%;font-size: 9pt; font-family: Verdana;"><strong><?php echo $dt['nama'] ?><strong></td>
          </tr>
          <tr>
            <td style="font-size: 9pt; font-family: Verdana;"><strong>Tempat/Tgl Lahir <strong></td>
            <td><strong>:<strong></td>
            <td style="font-size: 9pt; font-family: Verdana;"><strong><?php echo $dt['templahir'] . ', ' . $dt['lahir'] ?> <strong></td>
          </tr>
          <tr>
            <td style="font-size: 9pt; font-family: Verdana;"><strong>No.Induk Pekerja <strong></td>
            <td><strong>:<strong></td>
            <td style="font-size: 9pt; font-family: Verdana;"><strong><?php echo $dt['noind'] ?><strong></td>
          </tr>
          <tr>
            <td valign="top" style="font-size: 9pt; font-family: Verdana;"> <strong>Alamat <strong></td>
            <td valign="top"><strong>:<strong></td>
            <!--<td><strong><?php echo $dt['alamat'] . ',' . $dt['kec'] . ',' . $dt['kab'] . ',' . $dt['prop'] . ',' . $dt['kodepos'] ?><strong></td> -->
            <td style="font-size: 9pt; font-family: Verdana;">
              <strong><?= trim($dt['alamat']) . ', ' . trim($dt['kec']) . ', ' . trim($dt['kab']) . ', ' . trim($dt['prop']) . ', ' . trim($dt['kodepos']) ?>
                <strong>
            </td>
          </tr>
          <?php if (!empty($nik)) : ?>
            <tr>
              <td style="font-size: 9pt; font-family: Verdana;"> <strong> NIK <strong></td>
              <td> <strong>: <strong></td>
              <td style="font-size: 9pt; font-family: Verdana;"> <strong><?php echo $nik_pengalaman ?> <strong></td>
            </tr>
          <?php endif ?>

        </tbody>
      </table>
      <p style="text-align: justify;font-size: 9pt; font-family: Verdana;">
        Adalah benar-benar pekerja dengan status <?php echo $stat ?> di Perusahaan kami, pada :
      </p>

      <table border="0" style="width: 100%;margin-left: 5%;border: 1px solid white">
        <tbody>
          <tr>
            <td style="width: 25%;font-size: 9pt; font-family: Verdana;"> Mulai bekerja </td>
            <td style="width: 5%"> :</td>
            <td style="width: 70%;font-size: 9pt; font-family: Verdana;"><?php echo $dt['masuk'] ?></td>
          </tr>
          <tr>
            <td style="font-size: 9pt; font-family: Verdana;">Sampai </td>
            <td>:</td>
            <td style="font-size: 9pt; font-family: Verdana;"><?php echo $sampai ?> </td>
          </tr>
          <tr>
            <td valign="top" style="font-size: 9pt; font-family: Verdana;">Seksi</td>
            <td valign="top">:</td>
            <td style="font-size: 9pt; font-family: Verdana;"> Seksi <?php echo $dt['seksi'] . ', Unit ' . $dt['unit'] . ', Departemen ' . $dt['dept'] ?></td>
          </tr>
          <tr>
            <td valign="top" style="font-size: 9pt; font-family: Verdana;"> Jabatan </td>
            <td valign="top" style="font-size: 9pt; font-family: Verdana;">:</td>
            <td style="font-size: 9pt; font-family: Verdana;"><?php echo $jabatan_pengalaman ?></td>
          </tr>
        </tbody>
      </table>

      <p style="text-align: justify;font-size: 9pt; font-family: Verdana;">
        <?php echo $dt['isi_surat'] ?>
      </p>
      <p style="text-align: justify;font-size: 9pt; font-family: Verdana;">
        Demikian surat keterangan ini dibuat untuk dapat digunakan sebagaimana mestinya.
      </p>
      <p style="font-size: 9pt; font-family: Verdana;">
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
        <u style="font-size: 9pt; font-family: Verdana;"><strong>Rajiwan</strong></u><br>
        Kepala Seksi Utama
      </p>
      <p>
        <u style="font-size: 9pt; font-family: Verdana;"><strong>Tembusan :</strong></u><br>
        -Arsip <br>
        <i style="font-size: 9pt; font-family: Verdana;">rs / af</i>
      </p>
    </div>
</body>

</html>
<?php } ?>