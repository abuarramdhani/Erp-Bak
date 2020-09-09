<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Evaluasi Staff</title>
  <style media="print">
    .m-0 {
      margin: 0;
    }

    table {
      width: 100%;
      margin: 0;
      table-layout: fixed;
    }

    table.bordered {
      padding: 0;
      border-collapse: collapse;
    }

    table.bordered td {
      border: 1px solid black;
    }

    .centered td,
    .centered th {
      text-align: center;
    }

    table.bordered thead td,
    table.bordered thead th {
      font-weight: bold;
    }

    table.bordered th,
    table.bordered td {
      border: 1px solid black;
    }

    table.header>tr {
      height: 100px;
    }

    td {
      word-wrap: break-word;
    }

    .logo {
      width: 60px;
      height: auto;
    }

    /* ------------------------------------------------ */
    .title {
      background-color: #C0C0C0;
      width: 100%;
      font-weight: bold;
    }

    .center {
      text-align: center;
    }

    .text-left {
      text-align: left;
    }

    .text-right {
      text-align: right;
    }

    .text-top-left {
      text-align: left;
      vertical-align: top;
    }

    .bold {
      font-weight: bold;
    }
  </style>
</head>

<body>
  <div style="border: 3px solid black; padding: 1em;">
    <div style="margin-bottom: 1em;">
      <table border="0">
        <tr>
          <td style="width: 10%;"><img class="logo" src="<?= base_url('assets/img/logo.png') ?>" alt="quick logo"></td>
          <td class="text-top-left">
            <h1>CV. KARYA HIDUP SENTOSA</h1>
            <p>JL. MAGELANG NO 144 YOGYAKARTA</p>
          </td>
        </tr>
      </table>
    </div>
    <div class="center" style="line-height: 2px;">
      <h3 class="bold">Blanko Evaluasi Penilaian</h3>
      <h3 class="bold">Untuk Perpanjangan Pekerja Kontrak</h3>
    </div>
    <table border="0">
      <tr>
        <td style="width: 20%;">Nama</td>
        <td>: <?= $worker['nama'] ?></td>
      </tr>
      <tr>
        <td>No. Induk</td>
        <td>: <?= $worker['noind'] ?></td>
      </tr>
      <tr>
        <td>Seksi/Unit</td>
        <td>: <?= $worker['seksi'] ?></td>
      </tr>
      <tr>
        <td>Status</td>
        <td>: <?= $worker['status_jabatan'] ?></td>
      </tr>
      <tr>
        <td>Jabatan</td>
        <td>: <?= $worker['jabatan'] ?></td>
      </tr>
      <tr>
        <td>Akhir Kontrak</td>
        <td>: <?= $worker['akhir_kontrak'] ?></td>
      </tr>
    </table>
    <div style="height: 160px; margin-top: 2em; padding: 0 1em; word-wrap: break-word; white-space:pre-wrap;">
      <span>Penilaian Atasan :</span>
      <?php if (!$atasan) : ?>
        <p>.......................................................................................................................................................</p>
        <p>.......................................................................................................................................................</p>
        <p>.......................................................................................................................................................</p>
        <p>.......................................................................................................................................................</p>
      <?php else : ?>
        <p><?= $atasan ?></p>
      <?php endif ?>
    </div>
    <div style="padding: 0 1em;">
      <span>Pernyataan Pekerja :</span>
      <p>.......................................................................................................................................................</p>
      <p>.......................................................................................................................................................</p>
      <p>.......................................................................................................................................................</p>
      <p>.......................................................................................................................................................</p>
    </div>
    <div>
      <table border="0">
        <tr>
          <td colspan="2"><u>Usulan Atasan</u></td>
          <td colspan="2"><u>Keputusan</u></td>
        </tr>
        <tr>
          <td>
            <?php if (!$usulan) echo "<s>"  ?>
            ➢ Diperpanjang
            <?php if (!$usulan) echo "</s>"  ?>
          </td>
          <td>: <?= ($usulan) ? $usulan : '....' ?> Bulan</td>
          <td>➢ Diperpanjang</td>
          <td>: .... Bulan</td>
        </tr>
        <tr>
          <td>
            <?php if ($usulan) echo "<s>"  ?>
            ➢ Tidak Diperpanjang
            <?php if ($usulan) echo "<s>"  ?>
          </td>
          <td></td>
          <td>➢ Tidak Diperpanjang</td>
          <td></td>
        </tr>
      </table>
    </div>
    <div>
      <p>KHS, ....................</p>
    </div>
    <div>
      <div style="padding: 0 2em;" class="text-right">
        Menyetujui, _____________________
      </div>
      <table border="0">
        <tr>
          <td class="center" style="width: 25%;">Pekerja</td>
          <td class="center" style="width: 25%;">Kepala Seksi*</td>
          <td class="center" style="width: 25%;">Ass./Kepala Unit/Bid</td>
          <td class="center" style="width: 25%;">Ass./Wa./Ka.Dept</td>
        </tr>
        <tr>
          <td style="height: 50px;"></td>
          <td style="height: 50px;"></td>
          <td style="height: 50px;"></td>
          <td style="height: 50px;"></td>
        </tr>
        <tr>
          <td class="center">(<?= $worker['nama'] ?>)</td>
          <td class="center">(<?= $approval0 ?>)</td>
          <td class="center">(<?= $approval1 ?>)</td>
          <td class="center">( <?= $approval2 ?> )</td>
        </tr>
      </table>
    </div>
    <div style="margin-top: .5em;">
      <small>* Kepala Seksi sebelum memanggil pekerja, harus konsultasi terlebih dahulu tentang status pekerja ke Tingkat Unit</small>
    </div>
    <div style="margin-top: 3em;">
      <table style="width: 200px; font-size: 10px;">
        <tr>
          <td>No</td>
          <td>: FRM-HRM-00-04</td>
        </tr>
        <tr>
          <td>Rev. No</td>
          <td>: -</td>
        </tr>
      </table>
    </div>
  </div>
</body>

</html>