<html>

<head>
  <style>
    body {
      text-align: justify !important;
      font-size: 9.5pt !important;
      font-family: Verdana !important;
      line-height: 1.21 !important;
      word-spacing: 0 !important;
      /* word-spacing: -0.2 !important; */
    }

    pre {
      margin-top: 1em !important;
      margin-bottom: 1em !important;
      margin-left: 0 !important;
      margin-right: 0 !important;
      text-align: justify !important;
      font-size: 9.5pt !important;
      font-family: Verdana !important;
      line-height: 1.21 !important;
      /* word-spacing: -0.2 !important; */
    }

    pre .class_1 {
      margin-top: 0 !important;
      margin-bottom: 1em !important;
      margin-left: 0 !important;
      margin-right: 0 !important;
      text-align: justify !important;
      font-size: 9.5pt !important;
      font-family: Verdana !important;
      line-height: 1.21 !important;
    }

    pre p {
      margin-top: 0 !important;
      margin-bottom: 0 !important;
      margin-left: 0 !important;
      margin-right: 0;
      text-align: justify !important;
      font-size: 9.5pt !important;
      font-family: Verdana !important;
      line-height: 1.21 !important;
    }

    table {
      border: 0;
      width: 100%;
      margin-left: 7.5%;
      margin-top: 0;
      margin-bottom: 0;
      margin-right: 0;
      padding: 0;
      border-spacing: 0;
      line-height: 1.01 !important;
    }
  </style>
</head>

<body>
  <?php
  set_time_limit(0);
  ini_set("memory_limit", "2048M");

  ?>
  <?php foreach ($data as $dt) { ?>
    <div style="width: 100%;padding-right: 20px;padding-left: 20px; ">
      <p style="text-align: center; line-height: 1.14;">
        <span style="text-align: center;font-size: 16pt;margin-bottom: 1px; font-family: verdana-bold;">
          <u style="text-decoration: underline;text-decoration-color: black;"><strong>SURAT KETERANGAN</strong></u>
        </span>
        <br>
        <span style="text-align: center; margin-top: 1px; ">
          <strong>No. : <?php echo $dt['nomor'] ?>/PS/KE-A/<?php echo $dt['bulan'] ?>/<?php echo $dt['tahun'] ?></strong>
        </span>
      </p>
      <p style="text-align: justify; margin-top: 36px;">
        Dengan ini Departemen Personalia CV. Karya Hidup Sentosa, Jln. Magelang 144, Yogyakarta, menerangkan dengan sesungguhnya bahwa :
      </p>
      <table>
        <tbody>
          <tr>
            <td style="width: 25%;"><strong>Nama</strong></td>
            <td style="width: 1.5%;"> <strong>:<strong></td>
            <td style="width: 70%;"><strong><?php echo $dt['nama'] ?><strong></td>
          </tr>
          <tr>
            <td><strong>Tempat/Tgl Lahir <strong></td>
            <td><strong>:<strong></td>
            <td><strong><?php echo $dt['templahir'] . ', ' . $dt['lahir'] ?> <strong></td>
          </tr>
          <tr>
            <td><strong>No.Induk Pekerja <strong></td>
            <td><strong>:<strong></td>
            <td><strong><?php echo $dt['noind'] ?><strong></td>
          </tr>
          <tr>
            <td valign="top"> <strong>Alamat <strong></td>
            <td valign="top"><strong>:<strong></td>
            <td style="line-height: 1.17;">
              <strong><?= trim($dt['alamat']) . ', ' . trim($dt['kec']) . ', ' . trim($dt['kab']) . ', ' . trim($dt['prop']) . ', ' . trim($dt['kodepos']) ?><strong>
            </td>
          </tr>
          <?php if (!empty($nik)) : ?>
            <tr>
              <td> <strong> NIK <strong></td>
              <td> <strong>: <strong></td>
              <td> <strong><?php echo $nik_pengalaman ?> <strong></td>
            </tr>
          <?php endif ?>
        </tbody>
      </table>
      <p>
        Adalah benar-benar pekerja dengan status <?php echo $stat ?> di Perusahaan kami, pada :
      </p>
      <table>
        <tbody>
          <tr>
            <td style="width: 25%;"> Mulai bekerja </td>
            <td style="width: 1.5%"> :</td>
            <td style="width: 70%;"><?php echo $dt['masuk'] ?></td>
          </tr>
          <tr>
            <td>Sampai </td>
            <td>:</td>
            <td><?php echo $sampai ?> </td>
          </tr>
          <tr>
            <td valign="top">Seksi</td>
            <td valign="top">:</td>
            <td style=" line-height: 1.17;">Seksi <?php echo $dt['seksi'] . ', Unit ' . $dt['unit'] . ', Departemen ' . $dt['dept'] ?></td>
          </tr>
          <tr>
            <td valign="top"> Jabatan </td>
            <td valign="top">:</td>
            <td><?php echo trim($jabatan_pengalaman) ?></td>
          </tr>
        </tbody>
      </table>
      <?php $str = trim($dt['isi_surat']);
      $a = 1;
      $splited = explode('><', $str);
      $firstParagraph = $splited[0];
      $splited[0] =  str_ireplace('<p>', "<p class='class_$a'>", $firstParagraph);

      $joined = implode('><', $splited);

      // var_dump($joined);
      // $str = str_ireplace('<p>', "<p class='class_$a'>", $str);
      // $str = str_ireplace('</p>', '</p>', $str);
      echo "<pre>$joined</pre>";
      ?>
      <p>
        Demikian surat keterangan ini dibuat untuk dapat digunakan sebagaimana mestinya.
      </p>
      <p> </p>
      <p>
        <strong> Yogyakarta, <?php echo $pengalaman_tglCetak ?> </strong>
        <br>
        CV. Karya Hidup Sentosa
        <br>
        Departemen Personalia
      </p>
      <p>
        &nbsp;
      </p>
      <p></p>
      <p>
        <u><strong>Rajiwan</strong></u><br>
        Kepala Seksi Utama
      </p>
      <p><strong>Tembusan :</strong><br>
        -Arsip <br>
        <i>rs / af</i>
      </p>
    </div>
</body>

</html>
<?php } ?>