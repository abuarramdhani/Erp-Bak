<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Export PDF</title>
  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
    }

    .width-10 {
      display: block;
      width: 9.8%;
      border: 1px;
      float: left;
    }

    .width-80 {
      display: block;
      width: 79.8%;
      float: left;
    }

    .width-50 {
      width: 49.5%;
      float: left;
    }

    .width-25 {
      width: 24.5%;
      float: left;
    }

    .width-90 {
      float: left;
      width: 90%;
    }

    .width-100 {
      float: left;
      width: 100%;
    }

    .bordered {
      border: 1px solid black;
    }

    .text-center {
      text-align: center;
    }

    .m-0 {
      margin: 0;
    }

    .border-bottom {
      border-bottom: 1px solid gray;
    }

    table.table {
      width: 100%;
      border-collapse: collapse;
    }

    table.vtop th,
    table.vtop td {
      vertical-align: top;
    }

    table.table-bordered td,
    table.table-bordered th {
      border: 1px solid black;
      padding: 5px 5px;
    }

    .m-0 {
      margin: 0;
    }

    .ml-4 {
      margin-left: 1.5em;
    }

    .ml-2 {
      margin-left: 0.75em;
    }

    .pl-2 {
      padding-left: 0.5em;
    }

    .pl-4 {
      padding-left: 1em;
    }

    .pl-5 {
      padding-left: 1.5em;
    }

    .px-2 {
      padding-left: 0.5em;
      padding-right: 0.5em;
    }

    .py-2 {
      padding-top: 0.5em;
      padding-bottom: 0.5em;
    }

    .vertical-top {
      vertical-align: top;
    }

    .my-auto {
      margin-top: auto;
      margin-bottom: auto;
    }

    .italic {
      font-style: italic;
    }

    .bold {
      font-weight: bold;
    }

    .block {
      display: block;
    }

    .inline-block {
      display: inline-block;
    }

    .px-5px {
      padding-left: 5px;
      padding-right: 5px;
    }

    .v-top {
      vertical-align: top;
    }

    .v-bot {
      vertical-align: bottom;
    }

    .checkbox {
      width: 5px;
      font-style: italic;
      text-align: center;
      transform: rotate(90deg);
    }

    .strike {
      text-decoration: line-through;
    }
  </style>
</head>

<body>
  <div id="app">
    <header>
      <div class="bordered">
        <div class="width-10">
          <img class="width-90" src="<?= base_url('/assets/img/logo/logo.png') ?>" alt="" />
        </div>
        <div class="width-80 text-center py-2">
          <h1 class="m-0">ANALISA KECELAKAAN KERJA</h1>
          <h4 style="font-weight:normal;" class="m-0">CV KARYA HIDUP SENTOSA</h4>
        </div>
        <div class="width-10">
          <img class="width-100 my-auto" style="margin-top: 5px;" src="<?= base_url('/assets/img/logo/p2k3-bg-white.png') ?>" alt="" />
        </div>
      </div>
    </header>
    <main>
      <div class="content">
        <div class="bordered px-2 py-2">
          <table class="table v-top">
            <tr>
              <td width="15%">KASUS</td>
              <td colspan="5">: <?= $kecelakaanDetail['kasus']; ?></td>
            </tr>
            <tr>
              <td width="15%">HARI</td>
              <td width="1%">:</td>
              <td width="34%"><?= $kecelakaanDetail['hari'] ?></td>
              <td width="15%">NAMA</td>
              <td width="1%">:</td>
              <td width="34%"><?= $pekerjaDetail['nama'] ?></td>
            </tr>
            <tr>
              <td>TANGGAL</td>
              <td>:</td>
              <td><?= HelperClass::dateMonthToIndoNoTime($kecelakaanDetail['waktu_kecelakaan']) ?></td>
              <td>UMUR</td>
              <td>:</td>
              <td><?= $pekerjaDetail['age'] ?> tahun</td>
            </tr>
            <tr>
              <td>JAM</td>
              <td>:</td>
              <td><?= date('H:i:s', strtotime($kecelakaanDetail['waktu_kecelakaan'])) ?></td>
              <td>LAMA BEKERJA</td>
              <td>:</td>
              <td><?= $kecelakaanDetail['masa_kerja'] ?></td>
            </tr>
            <tr>
              <td>LOKASI</td>
              <td>:</td>
              <td><?= $kecelakaanDetail['tkp'] ?></td>
              <td>SEKSI / UNIT</td>
              <td>:</td>
              <td><?= $pekerjaDetail['seksi'] . " / " . $pekerjaDetail['unit'] ?></td>
            </tr>
          </table>
        </div>
        <div class="bordered px-2">
          <h3>KRONOLOGI:</h3>
          <p>
            <?= $kecelakaanDetail['kronologi'] ?>
          </p>
          <h3>ACTION:</h3>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center" width="5%">No</th>
                <th class="text-center" width="10%">Faktor</th>
                <th class="text-center">Root Cause</th>
                <th class="text-center">Corrective Action</th>
                <th class="text-center" width="12%">PIC</th>
                <th class="text-center" width="12%">Due Date</th>
              </tr>
            </thead>
            <tbody>
              <?php $caIndex = 1 ?>
              <?php foreach ($cars as $i => $car) : ?>
                <tr>
                  <td class="text-center v-top" rowspan="<?= count($car->revisi) + 1 ?>"><?= $i + 1 ?></td>
                  <td><?= $car->factor ?></td>
                  <td><?= $car->root_cause ?></td>
                  <td><?= $caIndex . '.' . $car->corrective_action ?></td>
                  <td><?= $car->created_by . " - " . $car->nama_pic ?></td>
                  <td><?= HelperClass::dateMonthToIndoNoTime($car->due_date) ?></td>
                </tr>
                <?php foreach ($car->revisi as $car_revisi) : ?>
                  <tr>
                    <!-- <td></td> -->
                    <td><?= $car_revisi->factor ?></td>
                    <td><?= $car_revisi->root_cause ?></td>
                    <td><?= $caIndex . '.' . $car_revisi->corrective_action ?></td>
                    <td><?= $car_revisi->created_by . " - " . $car_revisi->nama_pic ?></td>
                    <td><?= HelperClass::dateMonthToIndoNoTime($car_revisi->due_date) ?></td>
                  </tr>
                  <?php $caIndex++; ?>
                <?php endforeach ?>
                <?php $caIndex++; ?>
              <?php endforeach ?>
            </tbody>
          </table>
          <div style="margin-top: 0.5em;"></div>
          <div class="mt-2"></div>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th width="25%">Supervisor / Section Head</th>
                <th width="25%">Assistant / Unit Head</th>
                <th>Verification of Action Effectiveness</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-center" height="70px">
                  <!-- <span style="display: block; color: red;">Approved By Kasie at <?= HelperClass::dateMonthToIndoWTime($kasieApproval->created_at) ?></span><br />
                  <span>(<?= $kasieApproval->approval_by ?>)</span> -->
                </td>
                <td class="text-center">
                  <!-- <span style="display: block; color: red;">Approved By Unit at <?= HelperClass::dateMonthToIndoWTime($unitApproval->created_at) ?></span><br />
                  <span>(<?= $unitApproval->approval_by ?>)</span> -->
                </td>
                <td rowspan="2">
                  <div style="display: block; font-size: 17px;">
                    <input type="checkbox" name="" id="">
                    Effective
                  </div>
                  <div style="display: block; font-size: 17px;">
                    <input type="checkbox" name="" id="">
                    Ineffective
                  </div>
                </td>
              </tr>
              <tr>
                <td>Date: <?= HelperClass::dateMonthToIndoNoTime($kasieApproval->created_at) ?></td>
                <td>Date: <?= HelperClass::dateMonthToIndoNoTime($unitApproval->created_at) ?></td>
              </tr>
            </tbody>
          </table>
          <div style="margin-top: 0.5em;"></div>
          <table class="table table-bordered">
            <tr>
              <td style="border-bottom: none;">Comment:</td>
              <td class="text-center" width="24%">Tim P2K3</td>
            </tr>
            <tr>
              <td rowspan="2"></td>
              <td class="text-center v-bot" height="50px">

              </td>
            </tr>
            <tr>
              <td>Date: <?= HelperClass::dateMonthToIndoNoTime(date('Y-m-d')) ?></td>
            </tr>
          </table>
        </div>
      </div>
    </main>
  </div>
</body>

</html>