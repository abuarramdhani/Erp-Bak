<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
</head>

<body>
  <h1 style="font-family: times; font-size: 14pt;">Rencana Lembur</h1>
  <table><?php echo ("<tr><td>Tanggal</td><td>:</td><td>" . $Filter['tgllembur'] . "</td><td style = \"width: 90px;\"></td><td>Lokasi</td><td>:</td><td>" . $Filter['tmpmakan'] . "</td></tr>
  <tr><td>Status Makan</td><td>:</td><td>" . $Filter['statmakan'] . "</td><td style = \"width: 90px;\"></td><td>Status Approve</td><td>:</td><td>" . $Filter['statapprov'] . "</td></tr>") ?></table>



  <div style="margin-bottom : 200 px;">
    <table style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">

      <thead>
        <tr>
          <th style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">No</th>
          <th style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Pekerja</th>
          <th style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Mulai Lembur</th>
          <th style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Selesai Lembur</th>

          <th style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Nama Lembur</th>
          <th style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Pekerjaan</th>
          <th style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Makan</th>
          <th style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Tempat Makan</th>

          <th style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Shift</th>
          <th style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Atasan</th>
          <th style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Status</th>


        </tr>
      </thead>

      <tbody>
        <?php foreach ($PekerjaLembur as $key => $val) :
          ?>
          <tr>
            <td style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;text-align : center;"><?= $key + 1 ?></td>
            <td style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['pekerja_noind'], " - ", $val['pekerja_nama']; ?></td>
            <td style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['mulai']; ?></td>
            <td style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['selesai']; ?></td>

            <td style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['nama_lembur']; ?></td>
            <td style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['pekerjaan']; ?></td>
            <td style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['makan']; ?></td>
            <td style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['tempat_makan']; ?></td>

            <td style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['shift']; ?></td>
            <td style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['atasan_noind'], " - ", $val['atasan_nama']; ?></td>
            <td style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['status']; ?></td>

          </tr>
        <?php endforeach; ?>
      </tbody>

    </table>
  </div>

</body>

</html>