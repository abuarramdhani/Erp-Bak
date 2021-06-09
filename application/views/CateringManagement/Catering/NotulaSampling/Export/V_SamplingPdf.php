<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    body {
      font-size: 11px;
    }

    .table {
      border-collapse: collapse;
      width: 100%;
    }

    thead th {
      padding: 0.5em 0;
    }

    .bg-gray th {
      background-color: #d7d7d7;
    }

    table td {
      vertical-align: top;
      padding: 3px;
    }

    table.bordered th,
    table.bordered td {
      border: 1px solid black;
    }

    .text-center {
      text-align: center;
    }

    .text-right {
      text-align: right;
    }

    td.border-bottom-bold {
      border-bottom: 3px solid black;
    }
  </style>
</head>

<body>
  <table class="table bordered">
    <thead class="bg-gray">
      <tr>
        <th width="5%">Tanggal</th>
        <th width="4%">Hari</th>
        <th width="5%">Catering</th>
        <th width="3%">Shift</th>
        <th width="4%">Denda</th>
        <th width="7%">Menu</th>
        <th width="3%">Std</th>
        <th width="4%">Berat</th>
        <th width="20%">Rasa</th>
        <th width="20%">Ket</th>
        <th width="5%">PIC</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
      ?>
      <?php foreach ($groupedNotulaSamplings as $NotulaSamplings) : ?>
        <?php foreach ($NotulaSamplings['data'] as $i => $sampling) : ?>
          <?php
          $rowBold = false;
          $rowCount = count($NotulaSamplings['data']);
          if ($i == ($rowCount - 1)) {
            $rowBold = true;
          }
          ?>

          <?php if ($i == 0) : ?>
            <tr>
              <td style="border-bottom: 3px solid black;" rowspan="<?= count($NotulaSamplings['data']) ?>"><?= $sampling->tanggal ?></td>
              <td style="border-bottom: 3px solid black;" rowspan="<?= count($NotulaSamplings['data']) ?>"><?= $dayNames[strftime('%w', strtotime($sampling->tanggal))] ?></td>
              <td style="border-bottom: 3px solid black;" rowspan="<?= count($NotulaSamplings['data']) ?>"><?= $sampling->fs_nama_katering ?></td>
              <td style="border-bottom: 3px solid black;" class="text-center" rowspan="<?= count($NotulaSamplings['data']) ?>"><?= $sampling->shift_alias ?></td>
              <td style="border-bottom: 3px solid black;" rowspan="<?= count($NotulaSamplings['data']) ?>"><?= $NotulaSamplings['denda'] === true ? '5%' : '' ?></td>
              <td><?= $sampling->menu ?></td>
              <td class="text-right"><?= $sampling->standard ?></td>
              <td class="text-right"><?= $sampling->berat ?></td>
              <td><?= $sampling->rasa ?></td>
              <td><?= $sampling->keterangan ?></td>
              <td><?= $sampling->pic ?></td>
            </tr>
          <?php else : ?>
            <tr>
              <td style="<?= $rowBold ? 'border-bottom: 3px solid black;' : '' ?>"><?= $sampling->menu ?></td>
              <td style="<?= $rowBold ? 'border-bottom: 3px solid black;' : '' ?> " class="text-right"><?= $sampling->standard ?></td>
              <td style="<?= $rowBold ? 'border-bottom: 3px solid black;' : '' ?> " class="text-right"><?= $sampling->berat ?></td>
              <td style="<?= $rowBold ? 'border-bottom: 3px solid black;' : '' ?>"><?= $sampling->rasa ?></td>
              <td style="<?= $rowBold ? 'border-bottom: 3px solid black;' : '' ?>"><?= $sampling->keterangan ?></td>
              <td style="<?= $rowBold ? 'border-bottom: 3px solid black;' : '' ?>"><?= $sampling->pic ?></td>
            </tr>
          <?php endif ?>
        <?php endforeach ?>
      <?php endforeach ?>
    </tbody>
  </table>
</body>

</html>