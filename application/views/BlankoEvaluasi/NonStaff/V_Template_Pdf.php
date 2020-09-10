<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Evaluasi Kontrak Outsourching dan Non-staff</title>
  <style media="print">
    .m-0 {
      margin: 0;
    }

    table {
      width: 100%;
      margin: 0;
      table-layout: fixed;
      page-break-inside: avoid;
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

    .text-top-left {
      text-align: left;
      vertical-align: top;
    }

    .bold {
      font-weight: bold;
    }
  </style>
</head>
<?php
function repeat($string, $x)
{
  $val = '';
  for ($i = 0; $i < $x; $i++) {
    $val .= $string;
  }

  return $val;
}
?>

<body>
  <!-- --------------------- PAGE 1 -------------------- -->
  <!-- header -->
  <table cellspacing="0" cellpadding="0" style="border: none;">
    <tr>
      <td style="width: 6%;"><img class="logo" src="<?= base_url('assets/img/logo.png') ?>" alt="quick logo"></td>
      <td class="center" style="position: relative;">
        <p class="bold" style="font-size: 12px;">BLANKO EVALUASI PENILAIAN</p>
        <p class="bold" style="font-size: 16px;">PERPANJANGAN STATUS HUBUNGAN KERJA OUTSOURCING/ KONTRAK NON-STAF</p>
        <p class="bold" style="font-size: 12px;">CV. KARYA HIDUP SENTOSA</p>
        <p>JL. Magelang No. 144 Yogyakarta</p>
      </td>
      <td>
        <table>
          <tr>
            <td class="center bold" style="width: 30px; height: 20px; padding: 0; border: 1px solid black;">
              <?= (trim($worker['jabatan']) == 'os') ? '<h2>✓</h2>' : '' ?>
            </td>
            <td><b>Outsourcing</b></td>
          </tr>
          <tr>
            <td class="center bold" style="width: 30px; height: 20px; border: 1px solid black;">
              <?= (trim($worker['jabatan']) == 'nonstaff') ? '<h2>✓</h2>' : '' ?>
            </td>
            <td><b>Kontrak Non Staf</b></td>
          </tr>
        </table>
      </td>
      <td class="center" style="border: 2px solid black;">
        <p class="bold" style="font-size: 50px;">B</p>
      </td>
    </tr>
  </table>
  <!-- data pekerja -->
  <div class="title">
    <span>I. DATA PEKERJA</span>
  </div>
  <table cellspacing="0" style="border: none; margin-bottom: 10px; margin-top: 5px;">
    <tr>
      <td style="width: 35%;"></td>
      <td>
        <p class="bold">DATA PRESENSI PEKERJA TIGA BULAN TERAKHIR (OS) / DUA TAHUN TERAKHIR (KONTRAK) DAN SURAT PERINGATAN</p>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top; padding-top: 1em;">
        <table>
          <tr>
            <td>
              <p class="bold">1. NAMA</p>
            </td>
            <td>:</td>
            <td style="width: 55%; height: 25px; border: 1px solid grey; padding: 3;"><?= $worker['nama'] ?></td>
          </tr>
          <tr>
            <td>
              <p class="bold">2. NO INDUK</p>
            </td>
            <td>:</td>
            <td style="width: 55%; height: 25px; border: 1px solid grey; padding: 3;"><?= $worker['noind'] ?></td>
          </tr>
          <tr>
            <td style="text-align: left; vertical-align: top;">
              <p class="bold">3. SEKSI/UNIT/DEPARTEMEN</p>
            </td>
            <td style="text-align: left; vertical-align: top;">:</td>
            <td style="width: 55%; height: 25px; border: 1px solid grey; padding: 3;"><?= $worker['seksi'] ?></td>
          </tr>
          <tr>
            <td>
              <p class="bold">4. NAMA/JENIS PEKERJAAN</p>
            </td>
            <td>:</td>
            <td style="width: 55%; height: 25px; border: 1px solid grey; padding: 3;"><?= $worker['pekerjaan'] ?></td>
          </tr>
          <tr>
            <td>
              <p class="bold">5. MASA KERJA</p>
            </td>
            <td>:</td>
            <td style="width: 55%; height: 25px; border: 1px solid grey; padding: 3;"><?= $worker['masa_kerja'] ?></td>
          </tr>
          <tr>
            <td>
              <p class="bold">6. PERIODE AKHIR KONTRAK</p>
            </td>
            <td>:</td>
            <td style="width: 55%; height: 25px; border: 1px solid grey; padding: 3;"><?= date('d-m-Y', strtotime($worker['akhir_kontrak'])) ?></td>
          </tr>
        </table>
      </td>
      <td style="padding-right: 0;">
        <p>PERIODE PENARIKAN DATA : <b><?= date('d-m-Y', strtotime($worker['periode_awal'])) ?></b> s.d <b><?= date('d-m-Y', strtotime($worker['periode_akhir'])) ?></b></p>
        <table cellspacing="0" cellpadding="0" style="border: none;">
          <tr>
            <td width="50%">
              <table class="bordered centered">
                <thead>
                  <tr>
                    <td width="200px" rowspan="3">PARAMETER</td>
                    <td colspan="3">REKAP PRESENSI</td>
                    <td width="15%" rowspan="3">JUMLAH</td>
                  </tr>
                  <tr>
                    <td>OS</td>
                    <td colspan="2">KONTRAK</td>
                  </tr>
                  <tr>
                    <td>3 BULAN</td>
                    <td>TAHUN 1</td>
                    <td>TAHUN 2</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Terlambat (T)</td>
                    <td><?= $worker['jabatan'] == 'os' ? $tims['data']['T']['bulan3'] : '-' ?></td>
                    <td><?= $worker['jabatan'] == 'nonstaff' ? $tims['data']['T']['tahun1'] : '-' ?></td>
                    <td><?= $worker['jabatan'] == 'nonstaff' ? $tims['data']['T']['tahun2'] : '-' ?></td>
                    <td><?= $tims['data']['T']['jumlah'] ?></td>
                  </tr>
                  <tr>
                    <td>Izin Pribadi (I)</td>
                    <td><?= $worker['jabatan'] == 'os' ? $tims['data']['I']['bulan3'] : '-' ?></td>
                    <td><?= $worker['jabatan'] == 'nonstaff' ? $tims['data']['I']['tahun1'] : '-' ?></td>
                    <td><?= $worker['jabatan'] == 'nonstaff' ? $tims['data']['I']['tahun2'] : '-' ?></td>
                    <td><?= $tims['data']['I']['jumlah'] ?></td>
                  </tr>
                  <tr>
                    <td>Mangkir (M)</td>
                    <td><?= $worker['jabatan'] == 'os' ? $tims['data']['M']['bulan3'] : '-' ?></td>
                    <td><?= $worker['jabatan'] == 'nonstaff' ? $tims['data']['M']['tahun1'] : '-' ?></td>
                    <td><?= $worker['jabatan'] == 'nonstaff' ? $tims['data']['M']['tahun2'] : '-' ?></td>
                    <td><?= $tims['data']['M']['jumlah'] ?></td>
                  </tr>
                  <tr>
                    <td>Sakit (S + PSP)</td>
                    <td><?= $worker['jabatan'] == 'os' ? $tims['data']['S']['bulan3'] : '-' ?></td>
                    <td><?= $worker['jabatan'] == 'nonstaff' ? $tims['data']['S']['tahun1'] : '-' ?></td>
                    <td><?= $worker['jabatan'] == 'nonstaff' ? $tims['data']['S']['tahun2'] : '-' ?></td>
                    <td><?= $tims['data']['S']['jumlah'] ?></td>
                  </tr>
                  <tr>
                    <td>Izin Pamit (IP) <b>(hanya OS)</b></td>
                    <td><?= $worker['jabatan'] == 'os' ? $tims['data']['P']['bulan3'] : '-' ?></td>
                    <td><?= $worker['jabatan'] == 'nonstaff' ? $tims['data']['P']['tahun1'] : '-' ?></td>
                    <td><?= $worker['jabatan'] == 'nonstaff' ? $tims['data']['P']['tahun2'] : '-' ?></td>
                    <td><?= $tims['data']['S']['jumlah'] ?></td>
                  </tr>
                  <tr>
                    <td colspan="4"><b>TOTAL FREKUENSI (∑)</b> <i>(OS)</i></td>
                    <td><?= $worker['jabatan'] == 'os' ? $tims['total'] : '-' ?></td>
                  </tr>
                  <tr>
                    <td colspan="4"><b>TOTAL FREKUENSI TIM (∑)</b> <i>(pekerja kontrak)</i></td>
                    <td><?= $worker['jabatan'] == 'nonstaff' ? $tims['total_tim'] : '-' ?></td>
                  </tr>
                  <tr>
                    <td colspan="4"><b>TOTAL FREKUENSI TIMS (∑)</b> <i>(pekerja kontrak)</i></td>
                    <td><?= $worker['jabatan'] == 'nonstaff' ? $tims['total_tims'] : '-' ?></td>
                  </tr>
                </tbody>
              </table>
            </td>
            <td style="padding-left: 20px;" width="50%;">
              <div style="float: right;">
                <table class="bordered centered">
                  <thead>
                    <tr>
                      <td colspan="2">SURAT PERINGATAN</td>
                    </tr>
                    <tr>
                      <td width="30%">BULAN</td>
                      <td>PERIHAL</td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td style="vertical-align: top;" height="140">
                        <?php foreach ($sp as $item) : ?>
                          <?= $item['bulan'] . "<br>"; ?>
                        <?php endforeach; ?>
                      </td>
                      <td style="vertical-align: top;">
                        <?php foreach ($sp as $item) : ?>
                          <?= "SP {$item['ke']} {$item['jenis']} {$item['ket']} <br>"; ?>
                        <?php endforeach; ?>
                      </td>
                    </tr>
                  </tbody>
                  <footer>
                    <tr>
                      <td colspan="2"><i>(Syarat perpanjangan: tidak pernah mendapat SP)</i></td>
                    </tr>
                  </footer>
                </table>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

  <!-- evaluasi pekerja -->
  <div class="title">
    <span>II. EVALUASI PEKERJA</span>
  </div>
  <table class="bordered">
    <tbody>
      <tr class="centered">
        <th rowspan="2">No</th>
        <th rowspan="2" width="13%">ASPEK PENILAIAN</th>
        <th rowspan="2" width="15%">DASAR NILAI</th>
        <th rowspan="2" width="15%">URAIAN</th>
        <th rowspan="2" width="20%">BUKTI PERILAKU</th>
        <th width="60px;" rowspan="2">NILAI</th>
        <th colspan="5">SKALA PENILAIAN</th>
      </tr>
      <tr class="centered">
        <td class="bold">NILAI PRESENSI</td>
        <td class="bold" width="5px" rowspan="2">∑ Tot. Frek.</td>
        <td class="bold">Nilai Presensi</td>
        <td class="bold" width="140px;" colspan="2">∑ Total Frekuensi</td>
      </tr>
      <tr>
        <td rowspan="4" style="padding: 40px 0;"></td>
        <td rowspan="4">KEHADIRAN / PRESENSI</td>
        <td rowspan="4">Integritas</td>
        <td rowspan="4">Total kehadiran pekerja berdasarkan data evaluasi administrasi (presensi)</td>
        <td rowspan="4" class="center">(Data Presensi Pekerja)</td>
        <td rowspan="4" class="center">
          <div style="width: 15px;">
            <table class="centerd">
              <tr>
                <td style="width: 20px; height: 15px; border: 1px solid white"></td>
                <td style="width: 20px; height: 20px; border: 1px solid black; padding: 0;"><?= $tims['presensi_ok'] ? '<h2>✓</h2>' : '' ?></td>
                <td style="width: 20px; height: 15px; border: 1px solid white"></td>
              </tr>
            </table>
            <span>OK</span>
            <table class="centerd">
              <tr>
                <td style="width: 20px; height: 15px; border: 1px solid white"></td>
                <td style="width: 20px; height: 20px; border: 1px solid black; padding: 0;"><?= !$tims['presensi_ok'] ? '<h2>✓</h2>' : '' ?></td>
                <td style="width: 20px; height: 15px; border: 1px solid white"></td>
              </tr>
            </table>
            <span>NOT OK</span>
          </div>
        </td>
        <td class="center bold">OS</td>
        <td class="center bold">Kontrak</td>
        <td class="center bold">TIM</td>
        <td class="center bold">TIMS</td>
      </tr>
      <tr class="centered">
        <td>OK</td>
        <td>≤5</td>
        <td>OK</td>
        <td>≤15</td>
        <td>≤20</td>
      </tr>
      <tr class="centered">
        <td>NOT OK</td>
        <td>>5</td>
        <td>NOT OK</td>
        <td>>15</td>
        <td>>20</td>
      </tr>
      <tr class="centered">
        <td colspan="5"><i>Syarat perpanjangan status : Aspek Kehadiran "OK"</i></td>
      </tr>
      <tr>
        <!-- space kosong  -->
        <td style="border: none; color: white" colspan="12">i am spacing</td>
      </tr>
      <tr>
        <td rowspan="2" class="center">1</td>
        <td rowspan="2">HARD SKILL / KEMAMPUAN TEKNIS</td>
        <td rowspan="2">Unggul, Selalu Belajar dan Berubah</td>
        <td rowspan="2">Pengetahuan, keahlian, dan kebiasaan tertentu yang diterapkan dalam menyelesaikan sebuah tugas</td>
        <td class="text-top-left" rowspan="2"><?= $two['nilai']['0']['bukti'] ?></td>
        <td class="center" rowspan="2"><?= $two['nilai']['0']['skor'] ?></td>
        <td colspan="2" rowspan="6">
          <div style="text-align: center;">
            <b>NILAI ASPEK 1-5</b><br>
          </div>
          5 = Sangat Baik <br>
          4 = Baik <br>
          3 = Cukup <br>
          2 = Kurang <br>
          1 = Kurang Sekali
        </td>
        <td style="padding: 0; height: 5px;" class="center bold" colspan="3">CATATAN KHUSUS</td>
      </tr>
      <tr>
        <td class="text-top-left" style="padding: 0;" colspan="3" rowspan="5">
          <?= $two['pertimbangan'] ?>
        </td>
      </tr>
      <tr>
        <td class="center">2</td>
        <td>PERILAKU</td>
        <td>Integritas, Hidup Sederhana, Orientasi pada Pelanggan</td>
        <td>Penilaian terhadap perilaku kerja yang sesuai dengan work habit dan nilai perusahaan</td>
        <td class="text-top-left"><?= $two['nilai']['1']['bukti'] ?></td>
        <td class="center"><?= $two['nilai']['1']['skor'] ?></td>
      </tr>
      <tr>
        <td class="center">3</td>
        <td>KAIZEN</td>
        <td>Unggul, Selalu Belajar dan Berubah, Fanatik terhadap Detail</td>
        <td>Menunjukkan ide perbaharuan melalui ide Kaizen sertakan bukti SS (Suggestion System)</td>
        <td class="text-top-left"><?= $two['nilai']['2']['bukti'] ?></td>
        <td class="center"><?= $two['nilai']['2']['skor'] ?></td>
      </tr>
      <tr>
        <td class="center">4</td>
        <td>PRESTASI KERJA</td>
        <td>Unggul, Selalu Belajar dan Berubah, Fanatik terhadap Detail</td>
        <td>Kemampuan dalam menyelesaikan tugas-tugas yang diberikan atasan secara tepat waktu dengan kualitas yang baik</td>
        <td class="text-top-left"><?= $two['nilai']['3']['bukti'] ?></td>
        <td class="center"><?= $two['nilai']['3']['skor'] ?></td>
      </tr>
      <tr>
        <td class="center">5</td>
        <td>KERJASAMA</td>
        <td>Kerja Tim</td>
        <td>Kemampuan bekerjasama dan penyesuaian diri dengan pekerja lain dan atasan dalam satu unit yang sama</td>
        <td class="text-top-left"><?= $two['nilai']['4']['bukti'] ?></td>
        <td class="center"><?= $two['nilai']['4']['skor'] ?></td>
      </tr>
      <tr class="centered">
        <td class="bold" style="border-top: 2px solid black;" colspan="5"><b>TOTAL ASPEK 1-5</b></td>
        <td><?= $two['total'] ?></td>
        <td class="bold" colspan="5">Penilai adalah Atasan Langsung</td>
      </tr>
      <tr class="centered">
        <td class="bold" colspan="5"><b>RATA-RATA ASPEK 1-5</b></td>
        <td><?= $two['avg'] ?></td>
        <td class="bold" colspan="5">Standar Lulus = Rata-rata Nilai Minimal 3.00 (Aspek 1-5)</td>
      </tr>
    </tbody>
  </table>
  <!-- mastercopy watermark -->
  <div style="position: absolute; bottom: 90px; right: 160px;">
    <img style="height: 40px; width: auto;" src="<?= base_url('assets/img/mastercopy.png') ?>" alt="">
  </div>

  <!-- ---------------- PAGE 2 --------------- -->
  <pagebreak />
  <div class="title">
    <span>III. PROGRAM PENGEMBANGAN DAN PERNYATAAN PEKERJA</span>
  </div>
  <table>
    <tr>
      <td style="width: 80%;">
        <span style="color: white;">whitespace</span>
      </td>
      <td class="center">
        <span class="bold center">Pekerja</span>
      </td>
    </tr>
    <tr>
      <td style="padding: 5px 60px;">
        <!-- <span>1. <?= repeat('.', 232); ?></span> -->
        <span>1. <?= ($three[0]['text']) ? $three[0]['text'] : repeat('.', 232); ?></span>
      </td>
      <td rowspan="2">

      </td>
    </tr>
    <tr>
      <td style="padding: 5px 60px;">
        <!-- <span>2. <?= repeat('.', 232); ?></span> -->
        <span>2. <?= ($three[1]['text']) ? $three[1]['text'] : repeat('.', 232); ?></span>
      </td>
    </tr>
    <tr>
      <td style="padding: 5px 60px;">
        <!-- <span>3. <?= repeat('.', 232); ?></span> -->
        <span>3. <?= ($three[2]['text']) ? $three[2]['text'] : repeat('.', 232); ?></span>
      </td>
      <td class="center" style="font-size: 10px;">
        <span><b>(<span style="color: white;"><?= str_pad('<span style="color: black">' . $worker['nama'] . '</span>', 60, '-', STR_PAD_BOTH)  ?></span>)</b></span><br>
        <span>Tgl. <i style="color: white;">----------------</i></span>
      </td>
    </tr>
  </table>
  <table style="margin-bottom: 5px;">
    <tr>
      <td class="center bold" style="width: 40px; height: 30px; border: 3px solid black;"> </td>
      <td>Saya bersedia diperpanjang sebagai pekerja <b><u><i>outsourcing / kontrak non-staf</i></u></b> di CV. KHS (<i>coret salah satu</i>)</td>
    </tr>
  </table>

  <!-- -------------------------------- -->
  <div class="title">
    <span>IV. USULAN ATASAN</span>
  </div>
  <table cellspacing="5">
    <tr>
      <td class="center bold" style="width: 40px; height: 30px; border: 3px solid black;"> </td>
      <td><b>Diperpanjang: <?= $four['usulan'] ?> bulan</b></td>
    </tr>
    <tr>
      <td class="center bold" style="width: 40px; height: 30px; border: 3px solid black;"> </td>
      <td><b>Tidak Diperpanjang</b></td>
    </tr>
  </table>
  <div style="padding: 10px;">
    <span>Yogyakarta, <?= repeat('.', 30) ?></span>
  </div>
  <div style="width: 400px; margin-bottom: 5px;">
    <table class="centered">
      <tr>
        <td></td>
        <td><b>Penilai,</b></td>
        <td></td>
      </tr>
      <tr>
        <td>Supervisor</td>
        <td></td>
        <td>Kasi Madya</td>
      </tr>
      <tr>
        <td style="padding: 25px;"></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <!-- <td>( <i style="color: white">-------------------------------------------</i> )</td> -->
        <td class="center"><span>(<?= $four['supervisor'] ? $four['supervisor'] : '<i style="color: white">-----------------------------------------</i>' ?>)</span></td>
        <td></td>
        <!-- <td>( <i style="color: white">-------------------------------------------</i> )</td> -->
        <td class="center"><span>(<span style="color: white;"><?= str_pad('<span style="color: black">' . $four['kasie'] . '</span>', 60, '-', STR_PAD_BOTH)  ?></span>)</span></td>
      </tr>
    </table>
  </div>

  <!-- --------------------------------------- -->
  <div class="title">
    <span>V. KEPUTUSAN</span>
  </div>
  <table cellspacing="5">
    <tr>
      <td class="center bold" style="width: 40px; height: 30px; border: 3px solid black;"> </td>
      <td><b>Diperpanjang: ...... bulan</b></td>
    </tr>
    <tr>
      <td class="center bold" style="width: 40px; height: 30px; border: 3px solid black;"> </td>
      <td><b>Tidak Diperpanjang</b></td>
    </tr>
  </table>
  <div style="width: 60%; margin-bottom: 5px;">
    <table class="centered">
      <tr>
        <td width="100px">
          <b>Menyetujui,</b><br>
          Ka. Unit/Asisten Ka.Unit
        </td>
        <td width="210px">
          <b>Menyetujui,</b><br>
          Ka./Wa/Ka/Asisten Ka. Departemen
        </td>
        <td width="100px">
          <b>Memeriksa,</b><br>
          Kasi Madya Hub. Kerja
        </td>
      </tr>
      <tr>
        <td style="padding: 20px;"></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <!-- <td class="center">( <i style="color: white">-------------------------------------------</i> )</td>
                <td class="center">( <i style="color: white">-------------------------------------------</i> )</td>
                <td class="center">( <i style="color: white">-------------------------------------------</i> )</td> -->
        <td class="center">( <span style="color: white;"><?= str_pad('<span style="color: black">' . $four['unit'] . '</span>', 60, '-', STR_PAD_BOTH)  ?></span>)</td>
        <td class="center">( <span style="color: white;"><?= $four['dept'] ? str_pad('<span style="color: black">' . $four['dept'] . '</span>', 60, '-', STR_PAD_BOTH) : '<i style="color: white">-------------------------------------------</i>' ?></span> )</td>
        <td class="center">( <i style="color: white">-------------------------------------------</i> )</td>
      </tr>
    </table>
  </div>
  <hr style="color: black; height: 3px;">
  <div style="width: 20%; margin-bottom: 5px;">
    <table class="centered">
      <tr>
        <td>
          <b>Menerima,</b><br>
          Asisten Ka. Departemen/ Ka. Unit Personalia
        </td>
      </tr>
      <tr>
        <td style="padding: 25px;"></td>
      </tr>
      <tr>
        <td>( <i style="color: white">-----------------------------------------</i> )</td>
      </tr>
    </table>
  </div>
  <div>
    <span>> otorisasi 1 oleh Atasan Langsung (Supervisor dan Kasi Madya)</span><br>
    <span>> otorisasi 2 minimal oleh Asisten Kepala Unit <u><i>(untuk perpanjangan OS)</i></u>. Perpanjangan <i><u>pekerja</u></i> kontrak minimal sampai Asisten Kepala Departemen</span><br>
    <span>* Atasan langsung sebelum memanggil pekerja, terlebih dahulu konsultasi tentang status pekerja ke Tingkat Unit (Perpanjangan OS)/ Tingkat Departemen (Perpanjangan kontrak)</span><br>
    <span>No. : FRM-HRM-04-19</span>
    <span>Rev. No : 01</span>
  </div>
  <div style="position: absolute; bottom: 130px; left: 400px;">
    <img style="height: 40px; width: auto;" src="<?= base_url('assets/img/mastercopy.png') ?>" alt="">
  </div>
</body>

</html>