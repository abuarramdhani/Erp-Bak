<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
  <h1><b>Export Prediksi Catering</b></h1>
  <table><?php echo ("<tr><td>Tanggal </td><td>:</td><td>" . $Filter['tanggal'] . "</td></tr>") ?>
    <?php echo ("<tr><td>Lokasi </td><td>:</td><td>" . $Filter['lokasi'] . "</td></tr>") ?>
    <?php echo ("<tr><td>Shift </td><td>:</td><td>" . $Filter['shift'] . "</td></tr>") ?></table>
  <br>

  <table width="100%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">
    <thead class="bg-primary">
      <tr>
        <th width="3%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">No</th>
        <th width="17%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Tempat Makan</th>
        <th width="10%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Tanggal</th>
        <th width="10%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Jumlah Shift</th>
        <th width="10%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Dirumahkan (NON WFH)</th>
        <th width="10%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Dirumahkan (WFH)</th>
        <th width="5%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Cuti</th>
        <th width="10%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Sakit</th>
        <th width="10%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Dinas Luar</th>
        <th width="5%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Puasa</th>
        <th width="10%" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;">Total</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($PrediksiCatering as $key => $val) :
        ?>
        <tr>
          <td align="center" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $key + 1 ?></td>
          <td style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['tempat_makan'] ?></td>
          <td align="center" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['tanggal']; ?></td>
          <td align="center" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['jumlah_shift']; ?></td>
          <td align="center" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt; <?php echo $val['dirumahkan_nonwfh'] != "0" ? "background-color: #ff8888" : ""; ?>"><?= $val['dirumahkan_nonwfh']; ?></td>
          <td align="center" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt; <?php echo $val['wfh'] != "0" ? "background-color: #ff8888" : ""; ?>"><?= $val['wfh']; ?></td>
          <td align="center" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt; <?php echo $val['cuti'] != "0" ? "background-color: #ff8888" : ""; ?>"><?= $val['cuti']; ?></td>
          <td align="center" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt; <?php echo $val['sakit'] != "0" ? "background-color: #ff8888" : ""; ?>"><?= $val['sakit']; ?></td>
          <td align="center" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt; <?php echo $val['dinas_luar'] != "0" ? "background-color: #ff8888" : ""; ?>"><?= $val['dinas_luar']; ?></td>
          <td align="center" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt; <?php echo $val['puasa'] != "0" ? "background-color: #ff8888" : ""; ?>"><?= $val['puasa']; ?></td>
          <td align="center" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><?= $val['total']; ?></td>

        </tr>
      <?php endforeach; ?>
    </tbody>

    <tfoot>
      <tr>
        <td></td>
        <td></td>
        <td align="right" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><b>Jumlah :</b></td>
        <td align="center" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><b><?= array_sum(array_column($PrediksiCatering, 'jumlah_shift')); ?></b></td>
        <td align="center" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><b><?= array_sum(array_column($PrediksiCatering, 'dirumahkan_nonwfh')); ?></b></td>
        <td align="center" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><b><?= array_sum(array_column($PrediksiCatering, 'wfh')); ?></b></td>
        <td align="center" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><b><?= array_sum(array_column($PrediksiCatering, 'cuti')); ?></b></td>
        <td align="center" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><b><?= array_sum(array_column($PrediksiCatering, 'sakit')); ?></b></td>
        <td align="center" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><b><?= array_sum(array_column($PrediksiCatering, 'dinas_luar')); ?></b></td>
        <td align="center" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><b><?= array_sum(array_column($PrediksiCatering, 'puasa')); ?></b></td>
        <td align="center" style="font-family: times; border-collapse: collapse; border: 0.5px solid black; font-size: 9pt;"><b><?= array_sum(array_column($PrediksiCatering, 'total')); ?></b></td>
      </tr>
    </tfoot>
  </table>
</body>

</html>