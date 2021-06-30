<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Export PDF</title>
  <style>
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
          <h4 class="m-0">PANITIA PEMBINA KESELAMATAN DAN KESEHATAN KERJA</h4>
          <h4 class="m-0">P2K3</h4>
          <h4 class="m-0">CV KARYA HIDUP SENTOSA</h4>
          <small class="m-0 bold">Jl. Magelang No.144 Yogyakarta</small>
        </div>
        <div class="width-10">
          <img class="width-100 my-auto" style="margin-top: 5px;" src="<?= base_url('/assets/img/logo/p2k3-bg-white.png') ?>" alt="" />
        </div>
      </div>
    </header>
    <main>
      <div id="content">
        <h4 class="text-center" style="margin-top: 0.5em; margin-bottom: 0.5em;">LAPORAN KECELAKAAN</h4>
        <table class="table" id="form">
          <tr>
            <td class="italic bold" width="35%">1. Nama / No Induk</td>
            <td width="2%">:</td>
            <td colspan="2" class="border-bottom"><?= $pkj['nama'] . " / " . $pkj['noind'] ?> </td>
          </tr>
          <tr>
            <td class="italic bold">2. Seksi/Unit/Plant *</td>
            <td>:</td>
            <td class="border-bottom">
              <?= $pkj['seksi'] . " / " . $pkj['unit'] ?>
            </td>
            <td width="15%">
              <span class="<?= $pkj['lokasi_kerja'] == '02' ? 'strike' : '' ?>">Pusat</span>/<span class="<?= $pkj['lokasi_kerja'] == '01' ? 'strike' : '' ?>">Tuksono</span>
            </td>
          </tr>
          <tr>
            <td class="italic bold">3. Jenis Pekerjaan *</td>
            <td>:</td>
            <td class="border-bottom">
              <span><?= $kecelakaan['nama_pekerjaan'] ?></span>
            </td>
            <td width="15%">
              <span class="<?= $kecelakaan['jenis_pekerjaan'] == '2' ? 'strike' : '' ?>">Regular</span>/<span class="<?= $kecelakaan['jenis_pekerjaan'] == '1' ? 'strike' : '' ?>">Ireguler</span>
            </td>
          </tr>
          <tr>
            <td class="italic bold">4. Umur</td>
            <td>:</td>
            <td colspan="2" class="border-bottom"><?= $pkj['age'] ?> Tahun</td>
          </tr>
          <tr>
            <td class="italic bold">5. Masa Kerja</td>
            <td>:</td>
            <td colspan="2" class="border-bottom"><?= $kecelakaan['masa_kerja'] ?></td>
          </tr>
          <tr>
            <td class="italic bold">6. Masa Kerja Di Pos Accident</td>
            <td>:</td>
            <td colspan="2" class="border-bottom"><?= $kecelakaan['masa_masuk_pos']; ?></td>
          </tr>
          <tr>
            <td class="italic bold">7. Tanggal Kecelakaan</td>
            <td>:</td>
            <td colspan="2" class="border-bottom"><?= $this->personalia->konversitanggalIndonesia($kecelakaan['waktu_kecelakaan']) ?></td>
          </tr>
          <tr>
            <td class="italic bold">8. Jam terjadi Kecelakaan</td>
            <td>:</td>
            <td colspan="2" class="border-bottom"><?= date('H.i', strtotime($kecelakaan['waktu_kecelakaan'])) ?> WIB</td>
          </tr>
          <tr>
            <td class="italic bold">9. Lokasi Kejadian</td>
            <td>:</td>
            <td colspan="2" class="border-bottom"><?= $kecelakaan['tkp'] ?></td>
          </tr>
          <tr>
            <td class="italic bold">10. Penyebab Kecelakaan</td>
            <td>:</td>
            <td colspan="2" class="border-bottom"><?= $kecelakaan['penyebab'] ?></td>
          </tr>
          <!-- ALASAN COMMENT: 
          - User minta agar tidak ditampilkan
          - tidak dihapus karena mungkin sewaktu - waktu data dibawah ini digunakan -->
          <!-- <tr>
            <?php
            function getRangeWaktu($kode_range)
            {
              $waktu = [
                '1' => '06:00 - 09:00',
                '2' => '09:15 - 11:45',
                '3' => '12:30 - 14:00',
                '4' => '14:00 - 16:00',
                '5' => '16:15 - 18:00',
                '6' => '18:45 - 22:00',
                '7' => '22:00 - 01:00',
                '8' => '01:00 - 05:00',
              ];

              return $waktu[$kode_range] ?: '-';
            }

            function getRangeHour($kode_range)
            {
              $waktu = [
                '1' => 'Awal - Break',
                '2' => 'Break - Istirahat',
                '3' => 'Istirahat - Pulang',
              ];

              return $waktu[$kode_range] ?: '-';
            }
            ?>
            <td class="italic bold">9. Range Waktu</td>
            <td>:</td>
            <td colspan="2" class="border-bottom"><?= getRangeHour($kecelakaan['range_waktu2']) . " (" . getRangeWaktu($kecelakaan['range_waktu2']) . ")" ?> </td>
          </tr>
          <tr>
            <td class="italic bold">10. Lokasi Kerja</td>
            <td>:</td>
            <td colspan="2" class="border-bottom"><?= $kecelakaan['lokasi_kerja_kecelakaan'] ?></td>
          </tr>
          <tr>
            <td class="italic bold">12. Penyebab Kecelakaan</td>
            <td>:</td>
            <td colspan="2" class="border-bottom"><?= $kecelakaan['penyebab'] ?></td>
          </tr>
          <tr>
            <?php
            function getKategori($id)
            {
              $kategori = [
                '1' => 'Tertusuk',
                '2' => 'Terjepit',
                '3' => 'Kejatuhan / Jatuh',
                '4' => 'Terbentur',
                '5' => 'Terbakar',
                '6' => 'Kelilipan',
                '7' => 'Tersangkut',
                '8' => 'Tergiras',
                '9' => 'Lain',
              ];

              return @$kategori[$id] ?: '-';
            }
            $kategoriKecelakaan = array_map('getKategori', $kategoric);
            $kategoriKecelakaan = implode(', ', $kategoriKecelakaan);

            ?>
            <td class="italic bold">13. Kategori Kecelakaan</td>
            <td>:</td>
            <td colspan="2" class="border-bottom"><?= $kategoriKecelakaan ?></td>
          </tr>
          <tr>
            <?php
            function getFaktorKecelakaan($id)
            {
              $faktor = [
                '1' => 'Man',
                '2' => 'Machine',
                '3' => 'Methode',
                '4' => 'Material',
                '5' => 'Working Area',
                '6' => 'Others',
              ];

              return $faktor[$id] ?: '-';
            }

            $faktor = array_map('getFaktorKecelakaan', $faktorc);
            $faktor = implode(', ', $faktor);
            ?>
            <td class="italic bold">14. Faktor Kecelakaan</td>
            <td>:</td>
            <td colspan="2" class="border-bottom"><?= $faktor ?></td>
          </tr>
          <tr>
            <?php
            function getBSLR($id)
            {
              $data = [
                '0' => 'Sangat Berat',
                '1' => 'Berat',
                '2' => 'Sedang',
                '3' => 'Ringan',
                '4' => 'Laka',
              ];

              return $data[$id] ?: '-';
            }
            ?>
            <td class="italic bold">15. BSRL</td>
            <td>:</td>
            <td colspan="2" class="border-bottom"><?= getBSLR($kecelakaan['bsrl']) ?></td>
          </tr>
          <tr>
            <?php
            function getBagianTubuh($id)
            {
              $data = [
                '1' => 'Wajah',
                '2' => 'Mata',
                '3' => 'Tangan  ',
                '4' => 'Kaki',
                '5' => 'Lainnya',
              ];

              return @$data[$id] ?: '-';
            }

            $bagianTubuh = array_map('getFaktorKecelakaan', $bagianc);
            $bagianTubuh = implode(', ', $bagianTubuh);

            ?>
            <td class="italic bold">16. Bagian Tubuh</td>
            <td>:</td>
            <td colspan="2" class="border-bottom"><?= $bagianTubuh ?></td>
          </tr>
          <tr>
            <td class="italic bold">17. Unsafe</td>
            <td>:</td>
            <td colspan="2" class="border-bottom"><?= $kecelakaan['unsafe'] == 1 ? 'Condition' : 'Action' ?></td>
          </tr>
          <tr>
            <?php
            function getKriteriaStopSix($id)
            {
              $data = [
                '1' => 'Apparatus',
                '2' => 'Big Heavy',
                '3' => 'Car',
                '4' => 'Drop',
                '5' => 'Electrical',
                '6' => 'Fire',
              ];

              return $data[$id] ?: '-';
            }
            ?>
            <td class="italic bold">18. Kriteria Stop Six</td>
            <td>:</td>
            <td colspan="2" class="border-bottom"><?= getKriteriaStopSix($kecelakaan['kriteria_stop_six']) ?></td>
          </tr>
          <tr>
            <?php
            function getPenggunaanAPD($id)
            {
              $faktor = [
                '1' => 'Pakai',
                '2' => 'Tidak Pakai',
                '3' => 'Tidak Terdapat Standar',
              ];

              return $faktor[$id] ?: '-';
            }

            $penggunaanAPD = array_map('getPenggunaanAPD', $apdc);
            $penggunaanAPD = implode(', ', $penggunaanAPD);

            ?>
            <td class="italic bold">19. Penggunaan APD</td>
            <td>:</td>
            <td colspan="2" class="border-bottom"><?= $penggunaanAPD ?></td>
          </tr> -->
          <tr>
            <td class="italic bold">11. Urutan Terjadinya Kecelakaan</td>
            <td></td>
            <td colspan="2"></td>
          </tr>
        </table>
        <div class="ml-4">
          <table class="table" id="sub-content" autosize="0">
            <tr>
              <td class="vertical-top bold italic" style="width: 33%;">a. Kasus</td>
              <td class="vertical-top" width="2%">:</td>
              <td class="vertical-top"></td>
            </tr>
            <tr>
              <td class="vertical-top pl-5" colspan="3" style="text-align: justify; font-size:12px;">
                <?php $maxLength = 340; ?>
                <?= substr($kecelakaan['kasus'], 0, $maxLength) ?>
              </td>
            </tr>
            <tr>
              <td class="vertical-top bold italic" style="width: 33%;">b. Kronologis Kejadian</td>
              <td class="vertical-top" width="2%">:</td>
              <td class="vertical-top"></td>
            </tr>
            <tr>
              <td class="vertical-top pl-5" colspan="3" style="text-align: justify; font-size:12px;">
                <?php $maxLength = 340; ?>
                <?= substr($kecelakaan['kronologi'], 0, $maxLength) ?>
              </td>
            </tr>
            <tr>
              <td class="vertical-top bold italic">c. Kondisi Korban</td>
              <td class="vertical-top">:</td>
              <td style=""></td>
            </tr>
            <tr>
              <td class="vertical-top pl-5" colspan="3" style="text-align: justify; font-size:12px;">
                <?= substr($kecelakaan['kondisi'], 0, $maxLength) ?>
              </td>
            </tr>
            <tr>
              <td class="vertical-top bold italic">d. Penanganan Korban</td>
              <td class="vertical-top">:</td>
              <td></td>
            </tr>
            <tr>
              <td class="vertical-top pl-5" colspan="3" style="text-align: justify; font-size:12px;">
                <?= substr($kecelakaan['tindakan'], 0, $maxLength) ?>
              </td>
            </tr>
            <tr>
              <td colspan="3">
                <span class="bold italic">e. Prosedur Kerja **</span>
                <table class="ml-4">
                  <tr>
                    <td class="checkbox bordered italic px-5px"><?= ($kecelakaan['prosedur'] == '1') ? 'v' : '<span style="color: white;">0</span>' ?></td>
                    <td>Sesuai Standard</td>
                    <td class="checkbox bordered italic px-5px"><?= ($kecelakaan['prosedur'] == '2') ? 'v' : '<span style="color: white;">0</span>' ?></td>
                    <td>Tidak Sesuai Standard</td>
                    <td class="checkbox bordered italic px-5px"><?= ($kecelakaan['prosedur'] == '3') ? 'v' : '<span style="color: white;">0</span>' ?></td>
                    <td>Tidak Ada Standard</td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="3">
                <span class="bold italic" style="display: block;">f. APD yang digunakan **</span>
              </td>
            </tr>
          </table>
          <div class="width-100" style="padding-left: 1.5em;">
            <?php foreach ($apd_list_chunk_3 as $items) : ?>
              <div class="width-25">
                <table width="170px" style="font-size: 9pt">
                  <tr>
                    <td class="checkbox">Std</td>
                    <td class="checkbox">Act</td>
                    <td></td>
                  </tr>
                  <?php foreach ($items as $apd) : ?>
                    <?php
                        $used_apd_index = array_search($apd['name'], $apd_digunakan_name);
                        $standard_checklist = '';
                        $actual_checklist = '';

                        if ($used_apd_index !== false) {
                          $standard_checklist = $apd_digunakan[$used_apd_index]['standard'] == 't' ? 'v' : '';
                          $actual_checklist = $apd_digunakan[$used_apd_index]['actual'] == 't' ? 'v' : '';
                        }

                        ?>
                    <tr>
                      <td class="bordered checkbox italic"><?= $standard_checklist ?></td>
                      <td class="bordered checkbox"><?= $actual_checklist ?></td>
                      <td><?= $apd['name'] ?></td>
                    </tr>
                  <?php endforeach ?>
                </table>
              </div>
            <?php endforeach ?>
            <div class="width-25">
              <table width="170px" style="font-size: 9pt">
                <tr>
                  <td class="checkbox">Std</td>
                  <td class="checkbox">Act</td>
                  <td>(Lain-lain)</td>
                </tr>
                <?php
                $apd_digunakan_lain = array_pad($apd_digunakan_lain, 7, [
                  'nama_apd' => '-',
                  'standard' => 'f',
                  'actual' => 'f',
                ]);
                ?>
                <?php foreach ($apd_digunakan_lain as $item) : ?>
                  <tr>
                    <td class="bordered checkbox"><?= $item['standard'] == 't' ? 'v' : '' ?></td>
                    <td class="bordered checkbox"><?= $item['actual'] == 't' ? 'v' : '' ?></td>
                    <td class="border-bottom"><?= $item['nama_apd'] ?></td>
                  </tr>
                <?php endforeach ?>
              </table>
            </div>
          </div>
        </div>
        <!-- <pagebreak /> -->
        <div class="width-100">
          <span class="bold italic">12. Gambar</span>
          <div class="width-50">
            <div class="ml-4">
              <img style="min-width: 70%; width: auto; height: 120px; max-height: 120px; object-fit: cover;" src="<?= base_url('assets/upload/P2K3v2/kecelakaan_kerja/foto/' . $kecelakaan['lampiran_1']) ?>" alt="">
              <!-- <p>---Keterangan gambar---</p> -->
            </div>
          </div>
          <div class="width-50">
            <div class="ml-4">
              <img style="min-width: 70%; width: auto; height: 120px; max-height: 120px; object-fit: cover;" src="<?= base_url('assets/upload/P2K3v2/kecelakaan_kerja/foto/' . $kecelakaan['lampiran_2']) ?>" alt="">
              <!-- <p>---Keterangan gambar---</p> -->
            </div>
          </div>
        </div>
      </div>
    </main>
    <footer class="avoid-pagebreak-@" style="margin-top: 1em;">
      <div class="width-50">
        <span>Tembusan</span>
        <ol style="padding-left: 1.5em;">
          <li>Kepala Departemen</li>
          <li>Kepala/Ass Kepala Unit</li>
          <li>Seksi Hubungan Kerja</li>
          <li>Tim P2K3</li>
        </ol>
      </div>
      <div class="width-50">
        <div class="text-center" style="width: 300px; float: right;">
          <p class="m-0 block">Yogyakarta, <?= date('d-m-Y') ?></p>
          <p class="m-0 block">Yang melaporkan</p>
          <div style="margin-top: 50px">
            <div><?= $kecelakaan['userName_created_by']; ?></div>
            <div style="margin-top:-10px"> _______________________</div>
          </div>
        </div>
      </div>
    </footer>
  </div>
</body>

</html>