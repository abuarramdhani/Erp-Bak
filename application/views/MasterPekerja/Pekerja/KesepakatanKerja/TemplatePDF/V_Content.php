<html lang="en">

<head>
  <!-- <meta charset="UTF-8"> -->
  <style>
    * {
      box-sizing: inherit;
    }

    body {
      font-family: arial;
      /* font-size: 14px; */
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

    /* td {
      vertical-align: top;
      text-align: left;
    } */

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

    .text-bottom {
      vertical-align: bottom;
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

    .bordered {
      border: 1px solid black;
    }

    .justify {
      text-align: justify;
    }

    ol {
      list-style-position: outside;
      margin-top: 0;
      padding-left: 2em;
    }

    ol.number {
      list-style: number;
    }

    ol.abjad {
      list-style: lower-alpha;
    }

    ol.roman {
      list-style: lower-roman;
    }

    .block {
      display: block;
    }
  </style>
</head>

<body>
  <main>
    <div class="col-12 text-center">
      <h2><u>PERJANJIAN KERJA WAKTU TERTENTU</u></h2>
    </div>
    <!-- pihak  -->
    <div class="col-12">
      <span>Yang bertanda tangan dibawah ini:</span>
      <table style="width: 92%; margin: 0 auto;">
        <tr>
          <td class="text-bottom" width="3%">1. </td>
          <td class="text-bottom" style="padding-top: 0.5em;" width="27%">Nama</td>
          <td class="text-bottom" width="2%">:</td>
          <td width="" class="text-bottom">
            <dottab />
          </td>
        </tr>
        <tr>
          <td> </td>
          <td style="padding-top: 0.5em;" class="text-bottom">Jenis Kelamin</td>
          <td class="text-bottom">:</td>
          <td class="text-bottom">
            <dottab />
          </td>
        </tr>
        <tr>
          <td class="text-bottom"> </td>
          <td style="padding-top: 0.5em;" class="text-bottom">Tempat/Tanggal lahir</td>
          <td class="text-bottom">:</td>
          <td class="text-bottom">
            <dottab />
          </td>
        </tr>
        <tr>
          <td> </td>
          <td style="padding-top: 0.5em;" class="text-bottom">Alamat</td>
          <td class="text-bottom">:</td>
          <td class="text-bottom">
            <dottab />
          </td>
        </tr>
        <tr>
          <td> </td>
          <td class="text-bottom"></td>
          <td style="padding-top: 0.5em;" class="text-bottom">:</td>
          <td style="padding-top: 0.5em;" class="text-bottom">
            <dottab />
          </td>
        </tr>
      </table>
      <p class="justify">
        bertindak untuk dan atas nama diri sendiri, yang selanjutnya dalam Kesepakatan ini disebut sebagai <b>Pihak 1</b>;
      </p>
      <table style="width: 92%; margin: 0 auto;">
        <tr>
          <td class="text-bottom" width="3%">2. </td>
          <td class="text-bottom" width="20%">Nama</td>
          <td class="text-bottom" width="2%">:</td>
          <td style="padding-top: 0.5em;" width="" class="text-bottom">
            <b><?= @ucwords(strtolower($signer->nama)) ?></b>
          </td>
        </tr>
        <tr>
          <td> </td>
          <td class="text-bottom" class="text-bottom">Jabatan</td>
          <td class="text-bottom" class="text-bottom">:</td>
          <td style="padding-top: 0.5em;" class="text-bottom">
            <b><?= @ucwords(strtolower($signer->jabatan)) ?>, CV. Karya Hidup Sentosa</b>
          </td>
        </tr>
        <tr>
          <td> </td>
          <td class="text-bottom" class="text-bottom" class="text-bottom">Jenis Usaha</td>
          <td class="text-bottom" class="text-bottom" class="text-bottom">:</td>
          <td style="padding-top: 0.5em;" class="text-bottom">
            <b>Pabrik Mesin dan Alat Pertanian</b>
          </td>
        </tr>
        <tr>
          <td> </td>
          <td class="text-bottom">Alamat</td>
          <td class="text-bottom">:</td>
          <td style="padding-top: 0.5em;" class="text-bottom">
            <b>Jl. Magelang 144 Yogyakarta</b>
          </td>
        </tr>
      </table>
      <p class="justify">
        bertindak untuk dan atas nama CV. Karya Hidup Sentosa, yang selanjutnya dalam kesepakatan ini disebut sebagai <b>Pihak 2;</b>
      </p>
      <p class="justify">
        menyatakan bahwa, pada hari ................... , tanggal ......................................... bertempat di Jalan
        Magelang No. 144, Yogyakarta, kedua belah pihak telah sepakat untuk mengadakan Kesepakatan Kontrak Kerja,
        yang diatur dengan ketentuan sebagai berikut:
      </p>
    </div>
    <!-- end pihak -->
    <!-- pasal-pasal -->
    <!-- NEW LOGIC -->
    <div class="col-12">
      <!-- item  -->
      <!-- hapus nya disini  -->
      <?php foreach ($data as $i => $item) : ?>
        <div class="col-12 text-center">
          <p><b>Pasal <?= @$item['pasal'] ?: $i ?></b></p>
          <p><b><?= $item['title']['isi'] ?></b></p>
        </div>
        <?php
        if ($item['count_sub'] == 1) {
          if (count($item['item']) == 1) {
            echo "<p class='justify block'>{$item['item'][0]['isi']}</p>";
          } else {
            foreach ($item['item'] as $j => $sub_item) {
              $prevSub = @$item['item'][$j - 1]['sub'];
              $currSub = @$item['item'][$j]['sub'];
              $nextSub = @$item['item'][$j + 1]['sub'];
              $isi = $sub_item['isi'];

              if ($currSub > 0) {
                echo "
                <span class='justify'>$isi</span>
                  <ol class='number'>
                ";
              } else {
                echo "
                  <li class='justify block'>$isi</li>
                ";

                if (is_null($nextSub)) {
                  echo "</ol>";
                }
              }
            }
          }
        }

        if ($item['count_sub'] > 1) {
          foreach ($item['item'] as $j => $sub_item) {
            $prevSub = @$item['item'][$j - 1]['sub'];
            $currSub = @$item['item'][$j]['sub'];
            $nextSub = @$item['item'][$j + 1]['sub'];
            $isi = str_replace(PHP_EOL, '<br>', $sub_item['isi']);

            if ($currSub == 1) {
              echo "
                <ol class='number'>
                  <li class='justify block z'>$isi</li>
              ";
            }

            // TODO, PROBLEM
            // if ($prevSub == 0 && $currSub > 1 && $nextSub == 0) {
            //   echo "</ol>";
            // }

            if ($currSub > 1) {
              echo "
                <li class='justify block x'>$isi</li>
              ";
            }

            // sub item
            if ($currSub == 0 && $prevSub > 0) {
              echo "
                <ol class='abjad'>
                  <li class='justify block a'>$isi</li>
              ";
            }

            if ($currSub == 0 && $prevSub == 0 && $nextSub == 0 && !is_null($nextSub)) {
              echo "
                <li class='justify block b'>$isi</li>
              ";
            } elseif ($currSub == 0 && $prevSub > 1 && ($nextSub > 0 || is_null($nextSub))) {
              echo "
                </ol>
              ";
            } elseif ($currSub == 0 /*&& $prevSub == 0*/ && ($nextSub > 0 || is_null($nextSub))) {
              echo "
                <li class='justify block c'>$isi</li>
                </ol>
              ";
            }

            //

            if (is_null($nextSub)) {
              echo "</ol>";
            }
          }
        }

        ?>
      <?php endforeach ?>
    </div>
    <!-- The champion  -->
    <div class="col-12 text-center">
      <p>Para Pihak,</p>
      <div class="col-12">
        <div class="col-6 text-center" style="padding-top: 80px;">
          <p>(_______________________________)</p>
          <p>Pihak 1</p>
        </div>
        <div class="col-6 text-center" style="padding-top: 80px;">
          <p>(<b><u><?= @ucwords(strtolower($signer->nama)) ?></u></b>)</p>
          <p>Pihak 2</p>
        </div>
      </div>
    </div>
  </main>
  <?php //die;
  ?>

</html>