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
  <div style="width: 100%;padding-right: 20px;padding-left: 20px; ">
    <p style="text-align: center; line-height: 1.14;">
      <span style="text-align: center;font-size: 16pt;margin-bottom: 1px; font-family: verdana-bold;">
        <u style="text-decoration: underline;text-decoration-color: black;"><strong>SURAT KETERANGAN</strong></u>
      </span>
      <br>
      <span style="text-align: center; margin-top: 1px; ">
        <strong>No. : <?php echo $data['nomor'] ?>/PS/KE-A/<?php echo $data['bulan'] ?>/<?php echo $data['tahun'] ?></strong>
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
          <td style="width: 70%;"><strong><?php echo $data['nama'] ?><strong></td>
        </tr>
        <tr>
          <td><strong>Tempat/Tgl Lahir <strong></td>
          <td><strong>:<strong></td>
          <td><strong><?php echo $data['templahir'] . ', ' . $data['lahir'] ?> <strong></td>
        </tr>
        <tr>
          <td><strong>No.Induk Pekerja <strong></td>
          <td><strong>:<strong></td>
          <td><strong><?php echo $data['noind'] ?><strong></td>
        </tr>
        <tr>
          <td valign="top"> <strong>Alamat <strong></td>
          <td valign="top"><strong>:<strong></td>
          <td style="line-height: 1.17;">
            <strong><?= trim($data['alamat']) . ', ' . trim($data['kec']) . ', ' . trim($data['kab']) . ', ' . trim($data['prop']) . ', ' . trim($data['kodepos']) ?><strong>
          </td>
        </tr>
        <?php if (!empty($checkbox_nik)) : ?>
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
          <td style="width: 70%;"><?= $checkbox_tgl_masuk ? $tgl_masuk : $data['tgl_masuk'] ?></td>
        </tr>
        <tr>
          <td>Sampai </td>
          <td>:</td>
          <td><?php echo $sampai ?> </td>
        </tr>
        <!-- Jika user tidak checklist jabatan -->
        <?php foreach ($history_jabatan as $jabatan) : ?>
          <tr>
            <td valign="top">Seksi</td>
            <td valign="top">:</td>
            <td style=" line-height: 1.17;">Seksi <?= $jabatan['seksi'] . ', Unit ' . $jabatan['unit'] . ', Departemen ' . $jabatan['dept'] ?></td>
          </tr>
          <tr>
            <td valign="top"> Jabatan </td>
            <td valign="top">:</td>
            <!-- // isian manual hanya untuk jabatan C & H -->
            <td><?= $jabatan_pengalaman_check && in_array(substr($jabatan['noind'], 0, 1), ['C', 'H']) ? trim($jabatan_pengalaman) : trim($jabatan['jabatan']) ?></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
    <?php $str = trim($data['isi_surat']);
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
      <u><strong><?= ucwords(strtolower($approver['nama'])) ?></strong></u><br>
      <?= $approver['jabatan_organisasi'] ?>
    </p>
    <p><strong>Tembusan :</strong><br>
      -Arsip <br>
      <i>rs / af</i>
    </p>
  </div>
</body>

</html>