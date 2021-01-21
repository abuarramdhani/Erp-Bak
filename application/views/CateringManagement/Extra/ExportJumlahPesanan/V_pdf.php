<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
</head>

<body>
  <h1 style="font-family: times; font-size: 14pt;">Rencana Lembur</h1>
  <table><?php echo ("<tr><td>Periode</td><td>:</td><td>" . $Filter['periode'] . "</td><td style = \"width: 90px;\"></td><td>Lokasi</td><td>:</td><td>" . $Filter['lokasi'] . "</td></tr>
  <tr><td>Shift</td><td>:</td><td>" . $Filter['shift'] . "</td><td style = \"width: 90px;\"></td></tr>") ?></table>
  <br>



  <div style="margin-bottom : 200 px;">
    <table width="100%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">

      <thead>
        <tr>
          <th width="5%" style=" font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">No</th>
          <th width="25%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Lokasi</th>
          <th width="25%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Tanggal</th>
          <th width="15%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Shift 1 Umum Tanggung</th>
          <th width="15%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Shift 2</th>
          <th width="15%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Shift 3</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($JumlahPesanan as $key => $val) :
          ?>
          <tr>
            <td align="center" width="5%" style="width : 25%; font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $key + 1 ?></td>
            <td width="25%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['lokasi'] ?></td>
            <td align="center" width="25%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['fd_tanggal']; ?></td>
            <td align="center" width="15%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['shift_satu_umum']; ?></td>
            <td align="center" width="15%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['shift_dua']; ?></td>
            <td align="center" width="15%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['shift_tiga']; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>

    </table>
  </div>

</body>

</html>