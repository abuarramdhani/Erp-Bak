<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
</head>

<body>
  <h1 style="font-family: times; font-size: 14pt;">Tukar Shift dan Absen Manual</h1>
  <p>Tanggal : <?php echo (date("d-m-Y")); ?></p>


  <div style="margin-bottom : 200 px;">
    <table width="100%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">

      <thead>
        <tr>
          <th width="5%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">No</th>
          <th width="10%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">No. Induk</th>
          <th width="15%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Nama</th>
          <th width="15%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Seksi</th>
          <th width="10%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Tempat Makan</th>
          <th width="10%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Jenis</th>
          <th width="20%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Alasan</th>
          <th width="10%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Approver</th>
          <th width="10%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Waktu Approve</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($data as $key => $val) :
          ?>
          <tr>
            <td align="center" width="5%" style=" font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $key + 1 ?></td>
            <td align="center" width="10%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['noind'] ?></td>
            <td width="15%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['nama']; ?></td>
            <td width="15%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['seksi']; ?></td>
            <td width="10%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['tempat_makan']; ?></td>
            <td width="10%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['jenis']; ?></td>
            <td width="20%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['alasan']; ?></td>
            <td align="center" width="10%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['appr_']; ?></td>
            <td align="center" width="10%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['approve_timestamp']; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>

    </table>
  </div>

</body>

</html>