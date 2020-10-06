<html lang="en">

<head>
  <!-- <meta charset="UTF-8"> -->
  <style>
    @page {
      margin-top: 1cm;
      margin-bottom: 1cm;
      margin-left: 2cm;
      margin-right: 2cm;
    }

    @media print {
      @page {
        size: auto;
      }
    }

    body {
      font-family: arial;
      font-size: 15px;
    }

    section {
      display: block;
    }

    .pl-1 {
      padding-left: 1rem;
    }

    .mb-1 {
      margin-bottom: 1rem;
    }

    .mb-2 {
      margin-bottom: 2rem;
    }

    .p-0-25 {
      padding: 0.25rem;
    }

    .p-0-5 {
      padding: 0.5rem;
    }

    table {
      border-collapse: collapse;
    }

    td {
      vertical-align: top;
      text-align: left;
    }

    .table-border thead th,
    .table-border tbody td,
    .table-border tfoot th {
      border: 0.1px solid;
      border-color: #000;
    }


    .table-border {
      border-collapse: collapse;
    }

    .border {
      border: 1px solid;
      border-color: #000 !important;
    }

    .border-next-line {
      border-bottom: 1px solid;
      border-left: 1px solid;
      border-right: 1px solid;
      border-color: #000 !important;
    }

    .border-bottom {
      border-bottom: 1px solid;
      border-color: #000 !important;
    }

    .border-top {
      border-top: 1px solid;
      border-color: #000 !important;
    }

    .border-left {
      border-left: 1px solid;
      border-color: #000 !important;
    }

    .border-right {
      border-right: 1px solid;
      border-color: #000 !important;
    }

    .border-none {
      border-style: none !important;
    }

    .bold {
      font-weight: bold;
    }

    .italic {
      font-style: italic;
    }

    .text-left {
      text-align: left;
    }

    .text-center {
      text-align: center;
    }

    .text-right {
      text-align: right;
    }

    .dot {
      font-size: 8pt;
    }

    .row {
      width: 100%
    }

    .col-1 {
      width: 8%;
      float: left;
    }

    .col-2 {
      width: 16%;
      float: left;
    }

    .col-3 {
      width: 24%;
      float: left;
    }

    .col-4 {
      width: 32%;
      float: left;
    }

    .col-5 {
      width: 40%;
      float: left;
    }

    .col-6 {
      width: 50%;
      float: left;
    }

    .col-7 {
      width: 58%;
      float: left;
    }

    .col-8 {
      width: 66%;
      float: left;
    }

    .col-9 {
      width: 74%;
      float: left;
    }

    .col-10 {
      width: 82%;
      float: left;
    }

    .col-11 {
      width: 90%;
      float: left;
    }

    .col-12 {
      width: 100%;
      float: left;
    }
  </style>
</head>

<body>
  <header>
    <div class="col-12 mb-1">
      <div class="col-2">
        <img width="70px" src="<?= base_url('assets/img/logo.png') ?>">
      </div>
      <div class="col-10 text-center">
        <span style="font-size: 23px;"><u><b>SEKSI HUBUNGAN KERJA</b></u></span><br>
        <span style="font-size: 20px;"><b>C V . K A R Y A &nbsp; H I D U P &nbsp; S E N T O S A</b></span><br>
        <span style="font-size: 16px;"><b>Jl. Magelang No. 144 Yogyakarta</b></span><br>
      </div>
    </div>
    <div class="col-12 text-center">
      <span style="font-size: 23px;"><b>MEMO</b></span>
    </div>
    <div class="col-12 mb-1">
      <div>
        <!-- <span>No &nbsp;: 0001/PS/KI-L/08/20</span> -->
        <span>No &nbsp;: <?= $no_surat ?></span>
      </div>
      <div>
        <span>Hal : Perpanjangan Orientasi Pekerja</span>
      </div>
    </div>
    <div class="col-12 mb-1">
      <div>Kepada Yth :</div>
      <div><?= $atasan['nama'] ?></div>
      <div><?= $atasan['jabatan'] ?></div>
      <div>Di Tempat</div>
    </div>
  </header>
  <main>
    <p>Dengan Hormat,</p>
    <div>Berkaitan dengan diperpanjangnya masa orientasi pekerja :</div>
    <table style="border: 1px;">
      <tbody>
        <tr>
          <td style="width: 200px;">Nama</td>
          <td>: </td>
          <td><?= $nama ?></td>
        </tr>
        <tr>
          <td>No. Induk</td>
          <td>: </td>
          <td><?= $noind ?></td>
        </tr>
        <tr>
          <td>Seksi / Unit</td>
          <td>: </td>
          <td><?= $seksi ?> / <?= $unit ?></td>
        </tr>
        <tr>
          <td>Tanggal Masuk</td>
          <td>: </td>
          <td><?= strftime('%d %B %Y', strtotime($masukkerja)); ?></td>
        </tr>
        <tr>
          <td>Masa Orientasi</td>
          <td>: </td>
          <td><?= strftime('%d %B %Y', strtotime($masukkerja)); ?> - <?= strftime('%d %B %Y', strtotime($mulai . " -1 day")); ?></td>
        </tr>
        <tr>
          <td>Perpanjangan Orientasi</td>
          <td>: </td>
          <td><?= $lama_perpanjangan ?> Bulan (<?= strftime('%d %B %Y', strtotime($mulai)); ?> - <?= strftime('%d %B %Y', strtotime($akhir)); ?>)</td>
        </tr>
        <tr>
          <td>Kontrak Kerja</td>
          <td>: </td>
          <td><?= $lama_kontrak ?> Bulan (<?= strftime('%d %B %Y', strtotime($diangkat)); ?> - <?= strftime('%d %B %Y', strtotime($akhkontrak)); ?>)</td>
        </tr>
      </tbody>
    </table>
    <p>Maka kami beritahukan bahwa pekerja tersebut akan mendapatkan Insentif Kerajinan setelah 3 (tiga) bulan masa kontrak yaitu mulai tanggal <?= strftime('%d %B %Y', strtotime($diangkat . "+3 month")); ?></p>
    <p>Demikian memo ini kami buat, atas bantuan dan kerjasamanya kami ucapkan terima kasih.</p>
    <div class="approval">
      <p>Yogyakarta, <?= strftime('%d %B %Y', time()) ?></p>
      <div class="col-12">
        <div class="col-4">&nbsp;</div>
        <div class="col-3">&nbsp;</div>
        <div class="col-5">Mengetahui,</div>
      </div>
      <div class="col-12">
        <div class="col-5">Seksi Hubungan Kerja</div>
        <div class="col-2">&nbsp;</div>
        <div class="col-5">Unit General Affair & Hubungan Kerja</div>
      </div>
      <div class="col-12 padding-big" style="padding: 3em;">
        <!-- whitespace for sign -->
      </div>
      <div class="col-12 mb-2">
        <div class="col-5">
          <b><u><?= $hubker['nama'] ?></u></b><br>
          KEPALA SEKSI MADYA
        </div>
        <div class="col-2">&nbsp;</div>
        <div class="col-5">
          <b><u><?= @$atasan3->nama ?: 'RAJIWAN' ?></u></b><br>
          <?= @strtoupper($atasan3->jabatan) ?: 'KEPALA SEKSI MADYA' ?>
        </div>
      </div>
      <div class="col-12">
        <span>TEMBUSAN :</span>
        <ul style="list-style-type: none; padding-left: 1em; margin-top: 5px;">
          <li>> Administrator Penggajian</li>
          <!-- <li>> Arsip ted/</li> -->
          <li>> Arsip <?= $kode_arsip ?></li>
        </ul>
      </div>
    </div>
  </main>
</body>

</html>