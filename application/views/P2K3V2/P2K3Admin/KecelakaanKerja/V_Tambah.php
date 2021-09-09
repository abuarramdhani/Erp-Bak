<!-- Form TRial -->
<style>
  .nopadding {
    padding: 0 !important;
  }

  .martop {
    margin-top: 5px;
  }

  .bordered {
    border: 1px solid #555555 !important;
  }

  .square-checkbox {
    width: 25px;
    height: 25px;
  }

  .cropper-container {
    max-width: 100%;
  }

  .daterangepicker.auto-apply .drp-buttons {
    display: block !important;
  }
</style>
<link rel="stylesheet" href="<?= base_url('assets/plugins/cropperjs/dist/cropper.min.css') ?>">
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="col-lg-11">
          <div class="text-right">
            <h1><b><?= $Title ?></b></h1>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="col-lg-11"></div>
            <div class="col-lg-1 "></div>
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col-lg-12" id="apddivaddmkk">
            <div class="box box-primary box-solid">
              <div class="box-header with-border"></div>
              <div class="box-body">
                <form id="form" method="post" action="<?= base_url('p2k3adm_V2/Admin/submit_monitoringKK'); ?>" enctype="multipart/form-data">
                  <input type="hidden" name="user_kodesie">
                  <div class="panel-body">
                    <div class="col-md-6 nopadding">
                      <div class="col-md-12 nopadding">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">No Induk</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <select class="form-control" id="apdslcpkj" name="noind" required>

                          </select>
                        </div>
                      </div>
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Seksi</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <input class="form-control" name="seksi" disabled="">
                        </div>
                      </div>
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Unit</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <input class="form-control" name="unit" disabled="">
                        </div>
                      </div>
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Bidang</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <input class="form-control" name="bidang" disabled="">
                        </div>
                      </div>
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Departemen</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <input class="form-control" name="dept" disabled="">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-12" style="height: 1px;background-color: grey; margin-top: 20px; margin-bottom: 20px;">

                    </div>
                    <div class="col-md-6 nopadding">
                      <div class="col-md-12 nopadding">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 0px;">Tgl Kecelakaan & Jam Kecelakaan</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <input class="form-control daterangepickerYMDhis" name="tgl_kecelakaan" id="apdinptglkc" required>
                        </div>
                      </div>
                      <div class="col-md-12 nopadding martop" style="margin-top: 0px;">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Tgl Mulai Di Pos Kecelakaan</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <input class="form-control" id="apdmaspos" name="tgl_masuk_pos" placeholder="Tanggal Mulai Di Pos" required>
                        </div>
                      </div>
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Tempat / TKP</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <select class="form-control apdSlcTags" name="tkp" id="apdslclstkp-xxx" required>
                            <option></option>
                            <?php foreach ($tkp as $k) : ?>
                              <option value="<?= $k['tkp'] ?>"><?= $k['tkp'] ?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-12 nopadding martop" style="margin-top: 15px;">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Range Waktu 1</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <label><input class="apdinprngwkt1mkk" type="radio" name="range1" value="1"> Awal - Break</label>
                          <br>
                          <label><input class="apdinprngwkt1mkk" type="radio" name="range1" value="2"> Break - Istirahat</label>
                          <br>
                          <label><input class="apdinprngwkt1mkk" type="radio" name="range1" value="3"> Istirahat - Pulang</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 nopadding">
                      <div class="col-md-12 nopadding">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Masa Kerja</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <input class="form-control" name="masa_kerja" readonly="">
                        </div>
                      </div>
                      <div class="col-md-12 nopadding martop" style="margin-top: 15px;">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Lokasi Kerja</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <select class="form-control apd_select2" name="lokasi_kerja" placeholder="Pilih Salah 1" id="apdslcmkkloker" required>
                            <option></option>
                            <?php foreach ($lokasi as $key) : ?>
                              <option value="<?= $key['id_'] ?>"><?= $key['lokasi_kerja'] ?></option>
                            <?php endforeach ?>
                            <option value="999">LAKA</option>
                          </select>
                        </div>
                      </div>
                      <!-- <div class="col-md-12 nopadding" style="margin-top: 15px;">
                          <div class="col-md-3 nopadding">
                              <label style="margin-top: 5px;">Range Waktu 2</label>
                          </div>
                          <div class="col-md-8 nopadding">
                              <input class="form-control" name="range2" readonly="">
                          </div>
                      </div> -->
                      <div class="col-md-12 nopadding martop" style="margin-top: 15px;">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Range Waktu 2</label>
                        </div>
                        <div class="col-md-4 nopadding">
                          <label><input class="apdinprngwkt2mkk" type="radio" name="range2" value="1"> 06:00:00 - 09:00:00</label>
                          <br>
                          <label><input class="apdinprngwkt2mkk" type="radio" name="range2" value="2"> 09:15:00 - 11:45:00</label>
                          <br>
                          <label><input class="apdinprngwkt2mkk" type="radio" name="range2" value="3"> 12:30:00 - 14:00:00</label>
                          <br>
                          <label><input class="apdinprngwkt2mkk" type="radio" name="range2" value="4"> 14:00:00 - 16:00:00</label>
                        </div>
                        <div class="col-md-4 nopadding">
                          <label><input class="apdinprngwkt2mkk" type="radio" name="range2" value="5"> 16:15:00 - 18:00:00</label>
                          <br>
                          <label><input class="apdinprngwkt2mkk" type="radio" name="range2" value="6"> 18:45:00 - 22:00:00</label>
                          <br>
                          <label><input class="apdinprngwkt2mkk" type="radio" name="range2" value="7"> 22:00:00 - 01:00:00</label>
                          <br>
                          <label><input class="apdinprngwkt2mkk" type="radio" name="range2" value="8"> 01:00:00 - 05:00:00</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12"></div>
                    <div class="col-md-6 nopadding">

                    </div>
                    <div class="col-md-6 nopadding">

                    </div>
                    <div class="col-md-12"></div>
                    <div class="col-md-6 nopadding" style="margin-top: 20px;">
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Nama Pekerjaan</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <input type="text" name="nama_pekerjaan" placeholder="Nama Pekerjaan" class="form-control">
                        </div>
                        <div class="col-md-3 nopadding martop">
                          <label style="margin-top: 5px;">Jenis Pekerjaan</label>
                        </div>
                        <div class="col-md-8 nopadding martop apdSbgRadio">
                          <label><input class="apdinpjpmkk" type="radio" name="jenis_pekerjaan" value="1"> Reguler</label>
                          <br>
                          <label><input class="apdinpjpmkk" type="radio" name="jenis_pekerjaan" value="2"> Non Reguler</label>
                          <br>
                          <label><input class="apdinpjpmkk" type="radio" name="jenis_pekerjaan" value="3"> Lain - lain</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 nopadding" style="margin-top: 20px;">
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Kasus</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <textarea class="form-control toupper- limiter" maxlength="340" placeholder="Judul Kasus" name="kasus" style="width: 100%; min-height: 80px; height: 100px; max-height: 200px; resize: vertical;" required></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 nopadding" style="margin-top: 20px;">
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Kronologi</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <textarea class="form-control toupper- limiter" maxlength="680" placeholder="Kronologi kejadian" name="kronologi" style="width: 100%; min-height: 80px; height: 100px; max-height: 200px; resize: vertical;" required></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 20px;"></div>
                    <div class="col-md-6 nopadding">
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Bagian Tubuh</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <label><input type="checkbox" name="bagian_tubuh[]" value="1"> Wajah</label>
                          <br>
                          <label><input type="checkbox" name="bagian_tubuh[]" value="2"> Mata</label>
                          <br>
                          <label><input type="checkbox" name="bagian_tubuh[]" value="3"> Tangan</label>
                          <br>
                          <label><input type="checkbox" name="bagian_tubuh[]" value="4"> Kaki</label>
                          <br>
                          <label><input type="checkbox" name="bagian_tubuh[]" value="5"> Lainnya</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 nopadding">
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Kondisi</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <textarea class="form-control toupper- limiter" maxlength="340" placeholder="Kondisi korban" name="kondisi" style="width: 100%; min-height: 80px; height: 100px; max-height: 200px; resize: vertical;" required></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 nopadding" style="margin-top: 20px;">
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Penyebab</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <textarea class="form-control toupper- limiter" maxlength="340" placeholder="Penyebab kejadian" name="penyebab" style="width: 100%; min-height: 80px; height: 100px; max-height: 200px; resize: vertical;" required></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 20px;"></div>
                    <div class="col-md-6 nopadding">
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Kategori Kecelakaan</label>
                        </div>
                        <div class="col-md-4 nopadding">
                          <label><input type="checkbox" name="kategori[]" value="1"> Tertusuk</label>
                          <br>
                          <label><input type="checkbox" name="kategori[]" value="2"> Terjepit</label>
                          <br>
                          <label><input type="checkbox" name="kategori[]" value="3"> Kejatuhan / Jatuh</label>
                          <br>
                          <label><input type="checkbox" name="kategori[]" value="4"> Terbentur</label>
                          <br>
                          <label><input type="checkbox" name="kategori[]" value="5"> Terbakar</label>
                        </div>
                        <div class="col-md-4 nopadding">
                          <label><input type="checkbox" name="kategori[]" value="6"> Kelilipan</label>
                          <br>
                          <label><input type="checkbox" name="kategori[]" value="7"> Tersangkut</label>
                          <br>
                          <label><input type="checkbox" name="kategori[]" value="8"> Tergores</label>
                          <br>
                          <label><input type="checkbox" name="kategori[]" value="9"> Lain</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 nopadding">
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Tindakan/Penanganan</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <textarea class="form-control toupper- limiter" maxlength="340" placeholder="Tindakan/Penanganan terhadap korban" name="tindakan" style="width: 100%; min-height: 80px; height: 100px; max-height: 200px; resize: vertical;" required></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 20px;"></div>
                    <div class="col-md-6 nopadding">
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">BSRL</label>
                        </div>
                        <div class="col-md-3 nopadding">
                          <label><input class="apdinpbsrlmkk" type="radio" name="bsrl" value="0"> Sangat Berat</label>
                          <br>
                          <label><input class="apdinpbsrlmkk" type="radio" name="bsrl" value="1"> Berat</label>
                          <br>
                          <label><input class="apdinpbsrlmkk" type="radio" name="bsrl" value="2"> Sedang</label>
                          <br>
                          <label><input class="apdinpbsrlmkk" type="radio" name="bsrl" value="3"> Ringan</label>
                          <br>
                          <label><input class="apdinpbsrlmkk" type="radio" name="bsrl" value="4"> Laka</label>
                        </div>
                        <div class="col-md-5 nopadding float-left">
                          <textarea rows="3" id="keterangan" class="form-control" style="resize:none"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 nopadding">
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Penggunaan APD</label>
                        </div>
                        <div class="col-md-4 nopadding">
                          <label><input class="" type="checkbox" name="apd[]" value="1"> Pakai</label>
                          <br>
                          <label><input class="" type="checkbox" name="apd[]" value="2"> Tidak pakai</label>
                          <br>
                          <label><input class="" type="checkbox" name="apd[]" value="3"> Tidak Terdapat Standar</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 20px;"></div>
                    <div class="col-md-6 nopadding">
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Prosedur</label>
                        </div>
                        <div class="col-md-4 nopadding">
                          <label><input class="apdinpprosmkk" type="radio" name="prosedur" value="1"> Sesuai</label>
                          <br>
                          <label><input class="apdinpprosmkk" type="radio" name="prosedur" value="2"> Tidak Sesuai</label>
                          <br>
                          <label><input class="apdinpprosmkk" type="radio" name="prosedur" value="3"> Belum Ada Standar</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 nopadding">
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Faktor kecelakaan</label>
                        </div>
                        <div class="col-md-4 nopadding">
                          <label><input type="checkbox" name="faktor[]" value="1"> Man</label>
                          <br>
                          <label><input type="checkbox" name="faktor[]" value="2"> Machine</label>
                          <br>
                          <label><input type="checkbox" name="faktor[]" value="3"> Methode</label>
                        </div>
                        <div class="col-md-4 nopadding">
                          <label><input type="checkbox" name="faktor[]" value="4"> Material</label>
                          <br>
                          <label><input type="checkbox" name="faktor[]" value="5"> Working Area</label>
                          <br>
                          <label><input type="checkbox" name="faktor[]" value="6"> Others</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 20px;"></div>
                    <div class="col-md-6 nopadding">
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Unsafe</label>
                        </div>
                        <div class="col-md-4 nopadding">
                          <label><input class="apdinpunsmkk" type="radio" name="unsafe" value="1"> Action</label>
                          <br>
                          <label><input class="apdinpunsmkk" type="radio" name="unsafe" value="2"> Condition</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 nopadding">
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Kriteria<br>Stop SIX</label>
                        </div>
                        <div class="col-md-4 nopadding">
                          <label><input class="apdinpkssmkk" type="radio" name="kriteria" value="1"> Apparatus</label>
                          <br>
                          <label><input class="apdinpkssmkk" type="radio" name="kriteria" value="2"> Big heavy</label>
                          <br>
                          <label><input class="apdinpkssmkk" type="radio" name="kriteria" value="3"> Car</label>
                        </div>
                        <div class="col-md-4 nopadding">
                          <label><input class="apdinpkssmkk" type="radio" name="kriteria" value="4"> Drop</label>
                          <br>
                          <label><input class="apdinpkssmkk" type="radio" name="kriteria" value="5"> Electrical</label>
                          <br>
                          <label><input class="apdinpkssmkk" type="radio" name="kriteria" value="6"> Fire</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 nopadding">
                      <div class="col-md-12 nopadding martop">
                        <label for="">Apd Yang digunakan</label>
                        <table class="table">
                          <tr>
                            <?php foreach ($apd_list_chunk as $items) : ?>
                              <td width="25%">
                                <table class="table" width="170px" style="font-size: 9pt">
                                  <tr>
                                    <td class="">Std</td>
                                    <td class="">Act</td>
                                    <td></td>
                                  </tr>
                                  <?php foreach ($items as $i => $item) : ?>
                                    <tr>
                                      <input type="hidden" name="apd_digunakan[<?= $item['id'] ?>][nama_apd]" value="<?= $item['name'] ?>">
                                      <td class="bordered square-checkbox">
                                        <input type="checkbox" name="apd_digunakan[<?= $item['id'] ?>][standard]">
                                      </td>
                                      <td class="bordered square-checkbox">
                                        <input type="checkbox" name="apd_digunakan[<?= $item['id'] ?>][actual]">
                                      </td>
                                      <td><?= $item['name'] ?></td>
                                    </tr>
                                  <?php endforeach ?>
                                </table>
                              </td>
                            <?php endforeach ?>
                            <td width="25%">
                              <table class="table" width="170px" style="font-size: 9pt">
                                <tr>
                                  <td class="">Std</td>
                                  <td class="">Act</td>
                                  <td>(Lain - lain)</td>
                                </tr>
                                <?php
                                $items = [
                                  '-',
                                  '‎‎‎‏‏‎-',
                                  '‎‎‎‏‏‎-',
                                  '‎‎‎‏‏‎-',
                                  '‎‎‎‏‏‎-',
                                  '‎‎‎‏‏‎-',
                                  '‎‎‎‏‏‎-'
                                ];
                                ?>
                                <?php foreach ($items as $i => $item) : ?>
                                  <tr>
                                    <td class="bordered square-checkbox">
                                      <input type="checkbox" name="apd_digunakan_lain[<?= $i ?>][standard]">
                                    </td>
                                    <td class="bordered square-checkbox">
                                      <input type="checkbox" name="apd_digunakan_lain[<?= $i ?>][actual]">
                                    </td>
                                    <td style="padding: 0.5em;">
                                      <input type="text" name="apd_digunakan_lain[<?= $i ?>][nama_apd]" style="height: 25px;" placeholder="Isi manual" class="form-control">
                                    </td>
                                  </tr>
                                <?php endforeach ?>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-12" style="height: 1px;background-color: grey; margin-top: 20px; margin-bottom: 20px;"></div>
                    <div class="col-md-6 nopadding">
                      <h3>Foto Kecelakaan Kerja</h3>
                      <div class="col-md-12">
                        <?php for ($x = 1; $x <= 2; $x++) : ?>
                          <div class="col-md-12 nopadding martop">
                            <div class="col-md-3 nopadding">
                              <label style="margin-top: 5px;">Lampiran <?= $x ?></label>
                            </div>
                            <div class="col-md-7 nopadding">
                              <input type="hidden" name="lampiran_foto[<?= $x; ?>]" class="attachment<?= $x; ?>">
                              <input class="form-control" accept="image/jpg, image/jpeg, image/png" type="file" data-attachment="<?= $x ?>">
                            </div>
                            <div class="col-md-1">
                              <button role="button" data-attachment-remove="<?= $x ?>" class="btn btn-sm">
                                <i class="fa fa-times"></i>
                              </button>
                            </div>
                          </div>
                        <?php endfor ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="row">
                        <div class="col-md-6">
                          <img class="img-fluid img-preview" data-bind-attachment="1" style="background: #e8e8e8; height: 130px; width: 100%; object-fit: cover;" />
                        </div>
                        <div class="col-md-6">
                          <img class="img-fluid img-preview" data-bind-attachment="2" style="background: #e8e8e8; height: 130px; width: 100%; object-fit: cover;" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12" style="height: 1px;background-color: grey; margin-top: 20px; margin-bottom: 20px;"></div>
                    <div class="col-md-12 text-center" style="margin-top: 50px;">
                      <label style="color: red;">* Pastikan Data Sudah Sesuai Sebelum Klik Submit</label>
                      <br>
                      <a href="<?= base_url('p2k3adm_V2/Admin/monitoringKK') ?>" class="btn btn-warning btn-md">Kembali</a>
                      <button type="submit" class="btn btn-success" id="apdbtnupdatemkk">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="modal" id="modal-image-preview">
  <div class="modal-dialog" style="width: 80%;">
    <div class="modal-content">
      <div class="modal-body">
        <img src="" class="img-fluid img-content" style="width: 100%; height: auto;" alt="">
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modal-image-cropper">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h3 class="m-0 text-bold">Crop the image</h3>
      </div>
      <div class="modal-body">
        <div class="img-container img-rounded" style="max-height: 400px;">
          <img src="" class="image" style="max-width: 100%; width: 100%; height: auto;" alt="">
        </div>
        <div class="mt-2 text-center">
          <button class="btn btn-primary" id="cropper-rotate-left">
            <i class="fa fa-rotate-left"></i>
          </button>
          <button class="btn btn-primary" id="cropper-rotate-right">
            <i class="fa fa-rotate-right"></i>
          </button>
        </div>
      </div>
      <div class="modal-footer">
        <div class="pull-right">
          <button class="btn btn-primary" id="crop">Crop</button>
          <button class="btn" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;" hidden="hidden">
  <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>

<script src="<?= base_url('assets/plugins/cropperjs/dist/cropper.min.js') ?>"></script>
<script>
  $('#surat-loading').removeAttr('hidden')
  $(document).on('ready', function() {
    $('#surat-loading').attr('hidden', 'hidden')
    $('#apdmaspos').datepicker({
      format: 'yyyy-mm-dd',
      autoClose: true,
      autoApply: true,
    })
    // Add Keterangan
    const keterangan = [
      'Meninggal Dunia',
      'Terluka, Diobati & Dirawat Inap',
      'Terluka, Diobati & Diminta Pulang Tidak Bisa Melanjutkan Pekerjaan',
      'Terluka, Diobati & Bisa Melanjutkan Pekerjaan',
      'Kecelakaan Lalu Lintas'
    ]
    $.makeArray($('input[name="bsrl"]')).forEach(function(bsrl) {
      $(bsrl).on('ifChecked', function() {
        $('#keterangan').val(keterangan[$(this).val()])
      })
    })

    // input limiter
    $('.limiter').each(function() {
      const maxLength = $(this).attr('maxlength')
      $(this).inputlimiter({
        limit: maxLength,
        remText: 'Sisa %n karakter lagi...',
        limitText: 'Limit %n karakter.'
      });
    })

    // force close loading after 3 second if not work
    setTimeout(() => {
      $('#surat-loading').attr('hidden', 'hidden')
    }, 3 * 1000) // 3 seconds
  })

  window.addEventListener('load', function() {
    InitK3kForm();

    let temp_select2 = [];

    $('#apdslcpkj').select2({
      ajax: {
        url: baseurl + "p2k3adm_V2/Admin/getAllEmployees",
        dataType: "json",
        type: "get",
        data: function(params) {
          return {
            keyword: params.term
          };
        },
        processResults: function({
          data
        }) {
          const temp = {
            results: $.map(data, function(item) {
              return {
                id: item.noind,
                text: item.noind.trim() + " - " + item.nama.trim(),
                kodesie: item.kodesie
              };
            }),
          };

          temp_select2 = temp.results;
          return temp;
        },
        cache: true,
      },
      delay: 1000,
      minimumInputLength: 3,
      placeholder: "Pilih Pekerja",
      allowClear: true
    });

    $('#apdslcpkj').on('change', function() {
      const val = $(this).val()
      const getDetail = temp_select2.find((item) => item.id == val)
      if (val == null) return
      $('input[name=user_kodesie]').val(getDetail.kodesie)
    })

    // img preview
    $('img.img-preview').on('click', function() {
      const src = $(this).attr('src')

      if (src) {
        $('#modal-image-preview').find('img.img-content').attr('src', src);
        $('#modal-image-preview').modal('show');
      }
    })

    // convert to 
    function readURL(input, $target) {
      if (input.files && input.files[0]) {
        if (URL) {
          return $target.attr('src', URL.createObjectURL(input.files[0]))
        }

        var reader = new FileReader();
        reader.onload = function(e) {
          $target.attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
      } else {
        $target.attr('src', '')
      }
    }

    $('button[data-attachment-remove]').on('click', function(e) {
      e.preventDefault()
      const id_attachment = $(this).attr('data-attachment-remove');
      $(`input[type=file][data-attachment=${id_attachment}]`).val('').trigger('change')
      $(`img[data-bind-attachment=${id_attachment}]`).attr('src', '')
      $(`lampiran_foto[${id_attachment}]`).val('')
    })

    // experimental image cropper with cropper.js
    const $modalImageCropper = $('#modal-image-cropper');
    const $modalImageCropperImage = $modalImageCropper.find('img.image');
    let cropper;
    // id from input file element
    let id_attachment;

    $('input[type=file][data-attachment]').on('change', function() {
      id_attachment = $(this).attr('data-attachment');
      // if user click an image
      if ($(this).val()) {
        readURL(this, $modalImageCropperImage)
        $modalImageCropper.modal({
          backdrop: 'static',
          keyboard: false
        })
      } else {
        // if user click cancel
        $(`img[data-bind-attachment=${id_attachment}]`).attr('src', '')
        $(`lampiran_foto[${id_attachment}]`).val('')
      }
    });

    $modalImageCropper
      // When modal image cropper is opened
      .on('shown.bs.modal', function() {
        cropper = new Cropper($modalImageCropperImage.get(0), {
          aspectRatio: 4 / 2,
          viewMode: 1,
          minCropBoxWidth: 200,
          containerMaxHeight: 150,
          containerMaxWidth: 100,
          dragMode: 'move',
          ready() {
            $modalImageCropper.find('#cropper-rotate-left').on('click', () => cropper.rotate(-90))
            $modalImageCropper.find('#cropper-rotate-right').on('click', () => cropper.rotate(90))
          }
        })
      })
      // When modal image cropper is closed
      .on('hidden.bs.modal', function() {
        cropper.destroy()
        cropper = null
      });

    // crop button
    $modalImageCropper.find('#crop').on('click', () => {
      const $preview = $(`img[data-bind-attachment=${id_attachment}]`)
      const $fileInput = $(`input[name='lampiran_foto[${id_attachment}]'`)

      const canvas = cropper.getCroppedCanvas({
        width: 200,
        height: 200,
        imageSmoothingEnabled: false,
        imageSmoothingQuality: 'low'
      });
      const base64Image = canvas.toDataURL()

      $preview.attr('src', base64Image)
      $fileInput.val(base64Image)
      $modalImageCropper.modal('hide')
    })
  });
</script>