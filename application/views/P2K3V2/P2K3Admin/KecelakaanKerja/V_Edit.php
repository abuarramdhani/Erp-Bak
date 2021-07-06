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
<!-- ie; ?> -->
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
                <!-- <?php if ($this->session->flashdata('success')) : ?>
                  <div class="alert alert-success">
                    <?= $this->session->flashdata('success') ?>
                  </div>
                <?php endif ?> -->
                <form method="post" action="<?= base_url('p2k3adm_V2/Admin/update_monitoringKK'); ?>" enctype="multipart/form-data">
                  <div class="panel-body">
                    <div class="col-md-6 nopadding">
                      <div class="col-md-12 nopadding">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">No Induk</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <input class="form-control" disabled="" value="<?= $pkj['noind'] . ' - ' . trim($pkj['nama']) ?>">
                          <input style="display: none;" hidden="" value="<?= $pkj['noind'] ?>" id="apdslcpkj">
                        </div>
                      </div>
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Seksi</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <input class="form-control" name="seksi" disabled="" value="<?= $pkj['seksi'] ?>">
                        </div>
                      </div>
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Unit</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <input class="form-control" name="unit" disabled="" value="<?= $pkj['unit'] ?>">
                        </div>
                      </div>
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Bidang</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <input class="form-control" name="bidang" disabled="" value="<?= $pkj['bidang'] ?>">
                        </div>
                      </div>
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Departemen</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <input class="form-control" name="dept" disabled="" value="<?= $pkj['dept'] ?>">
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
                          <input class="form-control daterangepickerYMDhis" attr-name="tgl_kecelakaan" id="apdinptglkc" required="" value="<?= $kecelakaan['waktu_kecelakaan'] ?>">
                        </div>
                      </div>
                      <div class="col-md-12 nopadding martop" style="margin-top: 0px;">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Tgl Mulai Di Pos Kecelakaan</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <input class="form-control" id="apdmaspos" name="tgl_masuk_pos" placeholder="Tanggal Mulai Di Pos" required value="<?= $kecelakaan['tgl_masuk_pos']; ?>" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Tempat / TKP</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <select class="form-control apdSlcTags" attr-name="tkp" required="" id="apdslclstkp">
                            <option selected="" value="<?= $kecelakaan['tkp'] ?>"><?= $kecelakaan['tkp'] ?></option>
                          </select>
                        </div>
                      </div>
                      <!-- <div class="col-md-12 nopadding martop" style="margin-top: 15px;">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">Range Waktu 1</label>
                                                </div>
                                                <div class="col-md-8 nopadding">
                                                    <input class="form-control" name="range1" readonly="">
                                                </div>
                                            </div> -->
                      <div class="col-md-12 nopadding martop" style="margin-top: 15px;">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Range Waktu 1</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <label><input class="apdinprngwkt1mkk" type="radio" attr-name="range1" name="range1" value="1" <?= ($kecelakaan['range_waktu1'] == '1') ? 'checked' : '' ?>> Awal - Break</label>
                          <br>
                          <label><input class="apdinprngwkt1mkk" type="radio" attr-name="range1" name="range1" value="2" <?= ($kecelakaan['range_waktu1'] == '2') ? 'checked' : '' ?>> Break - Istirahat</label>
                          <br>
                          <label><input class="apdinprngwkt1mkk" type="radio" attr-name="range1" name="range1" value="3" <?= ($kecelakaan['range_waktu1'] == '3') ? 'checked' : '' ?>> Istirahat - Pulang</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 nopadding">
                      <div class="col-md-12 nopadding">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Masa Kerja</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <input class="form-control" attr-name="masa_kerja" readonly="" value="<?= $kecelakaan['masa_kerja'] ?>">
                        </div>
                      </div>
                      <div class="col-md-12 nopadding martop" style="margin-top: 15px;">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Lokasi Kerja</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <select class="form-control apd_select2" attr-name="lokasi_kerja" placeholder="Pilih Salah 1" id="apdslcmkkloker" required="">
                            <option selected="" value="<?= $kecelakaan['lokasi_kerja'] ?>"><?= $lokasi[$kecelakaan['lokasi_kerja']] ?></option>
                            <?php foreach ($lokasi as $lokasiKey => $lokasiVal) : ?>
                              <?php if ($lokasiKey == $kecelakaan['lokasi_kerja']) continue; ?>
                              <option value="<?= $lokasiKey ?>"><?= $lokasiVal ?></option>
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
                          <label><input class="apdinprngwkt2mkk" type="radio" attr-name="range2" name="range2" value="1" <?= ($kecelakaan['range_waktu2'] == '1') ? 'checked' : '' ?>> 06:00:00 - 09:00:00</label>
                          <br>
                          <label><input class="apdinprngwkt2mkk" type="radio" attr-name="range2" name="range2" value="2" <?= ($kecelakaan['range_waktu2'] == '2') ? 'checked' : '' ?>> 09:15:00 - 11:45:00</label>
                          <br>
                          <label><input class="apdinprngwkt2mkk" type="radio" attr-name="range2" name="range2" value="3" <?= ($kecelakaan['range_waktu2'] == '3') ? 'checked' : '' ?>> 12:30:00 - 14:00:00</label>
                          <br>
                          <label><input class="apdinprngwkt2mkk" type="radio" attr-name="range2" name="range2" value="4" <?= ($kecelakaan['range_waktu2'] == '4') ? 'checked' : '' ?>> 14:00:00 - 16:00:00</label>
                        </div>
                        <div class="col-md-4 nopadding">
                          <label><input class="apdinprngwkt2mkk" type="radio" attr-name="range2" name="range2" value="5" <?= ($kecelakaan['range_waktu2'] == '5') ? 'checked' : '' ?>> 16:15:00 - 18:00:00</label>
                          <br>
                          <label><input class="apdinprngwkt2mkk" type="radio" attr-name="range2" name="range2" value="6" <?= ($kecelakaan['range_waktu2'] == '6') ? 'checked' : '' ?>> 18:45:00 - 22:00:00</label>
                          <br>
                          <label><input class="apdinprngwkt2mkk" type="radio" attr-name="range2" name="range2" value="7" <?= ($kecelakaan['range_waktu2'] == '7') ? 'checked' : '' ?>> 22:00:00 - 01:00:00</label>
                          <br>
                          <label><input class="apdinprngwkt2mkk" type="radio" attr-name="range2" name="range2" value="8" <?= ($kecelakaan['range_waktu2'] == '8') ? 'checked' : '' ?>> 01:00:00 - 05:00:00</label>
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
                          <input type="text" name="nama_pekerjaan" value="<?= $kecelakaan['nama_pekerjaan'] ?>" placeholder="Nama Pekerjaan" class="form-control">
                        </div>
                        <div class="col-md-3 nopadding martop">
                          <label style="margin-top: 5px;">Jenis Pekerjaan</label>
                        </div>
                        <div class="col-md-8 nopadding martop apdSbgRadio">
                          <label><input class="apdinpjpmkk" type="radio" attr-name="jenis_pekerjaan" name="jenis_pekerjaan" value="1" <?= ($kecelakaan['jenis_pekerjaan'] == '1') ? 'checked' : '' ?>> Reguler</label>
                          <br>
                          <label><input class="apdinpjpmkk" type="radio" attr-name="jenis_pekerjaan" name="jenis_pekerjaan" value="2" <?= ($kecelakaan['jenis_pekerjaan'] == '2') ? 'checked' : '' ?>> Non Reguler</label>
                          <br>
                          <label><input class="apdinpjpmkk" type="radio" attr-name="jenis_pekerjaan" name="jenis_pekerjaan" value="3" <?= ($kecelakaan['jenis_pekerjaan'] == '3') ? 'checked' : '' ?>> Lain - lain</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 nopadding" style="margin-top: 20px;">
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Kasus</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <textarea class="form-control toupper- limiter" maxlength="112" placeholder="Judul Kasus" name="kasus" style="width: 100%; min-height: 80px; height: 100px; max-height: 200px; resize: vertical;" required><?= $kecelakaan['kasus']; ?></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 nopadding" style="margin-top: 20px;">
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Kronologi</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <textarea class="form-control toupper- limiter" maxlength="672" placeholder="Kronologi kejadian" name="kronologi" style="width: 100%; min-height: 80px; height: 100px; max-height: 200px; resize: vertical;" required=""><?= $kecelakaan['kronologi'] ?></textarea>
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
                          <label><input type="checkbox" name="bagian_tubuh[]" attr-name="bagian_tubuh[]" value="1" <?= (in_array('1', $bagianc)) ? 'checked' : '' ?>> Wajah</label>
                          <br>
                          <label><input type="checkbox" name="bagian_tubuh[]" attr-name="bagian_tubuh[]" value="2" <?= (in_array('2', $bagianc)) ? 'checked' : '' ?>> Mata</label>
                          <br>
                          <label><input type="checkbox" name="bagian_tubuh[]" attr-name="bagian_tubuh[]" value="3" <?= (in_array('3', $bagianc)) ? 'checked' : '' ?>> Tangan</label>
                          <br>
                          <label><input type="checkbox" name="bagian_tubuh[]" attr-name="bagian_tubuh[]" value="4" <?= (in_array('4', $bagianc)) ? 'checked' : '' ?>> Kaki</label>
                          <br>
                          <label><input type="checkbox" name="bagian_tubuh[]" attr-name="bagian_tubuh[]" value="5" <?= (in_array('5', $bagianc)) ? 'checked' : '' ?>> Lainnya</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 nopadding">
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Kondisi</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <textarea class="form-control toupper- limiter" maxlength="224" attr-name="kondisi" style="width: 100%; height: 100px;" required=""><?= $kecelakaan['kondisi'] ?></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 nopadding">
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Penyebab</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <textarea class="form-control toupper- limiter" maxlength="146" attr-name="penyebab" style="width: 100%; height: 100px;" required=""><?= $kecelakaan['penyebab'] ?></textarea>
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
                          <label><input type="checkbox" attr-name="kategori[]" name="kategori[]" value="1" <?= (in_array('1', $kategoric)) ? 'checked' : '' ?>> Tertusuk</label>
                          <br>
                          <label><input type="checkbox" attr-name="kategori[]" name="kategori[]" value="2" <?= (in_array('2', $kategoric)) ? 'checked' : '' ?>> Terjepit</label>
                          <br>
                          <label><input type="checkbox" attr-name="kategori[]" name="kategori[]" value="3" <?= (in_array('3', $kategoric)) ? 'checked' : '' ?>> Kejatuhan / Jatuh</label>
                          <br>
                          <label><input type="checkbox" attr-name="kategori[]" name="kategori[]" value="4" <?= (in_array('4', $kategoric)) ? 'checked' : '' ?>> Terbentur</label>
                          <br>
                          <label><input type="checkbox" attr-name="kategori[]" name="kategori[]" value="5" <?= (in_array('5', $kategoric)) ? 'checked' : '' ?>> Terbakar</label>
                        </div>
                        <div class="col-md-4 nopadding">
                          <label><input type="checkbox" attr-name="kategori[]" name="kategori[]" value="6" <?= (in_array('6', $kategoric)) ? 'checked' : '' ?>> Kelilipan</label>
                          <br>
                          <label><input type="checkbox" attr-name="kategori[]" name="kategori[]" value="7" <?= (in_array('7', $kategoric)) ? 'checked' : '' ?>> Tersangkut</label>
                          <br>
                          <label><input type="checkbox" attr-name="kategori[]" name="kategori[]" value="8" <?= (in_array('8', $kategoric)) ? 'checked' : '' ?>> Tergores</label>
                          <br>
                          <label><input type="checkbox" attr-name="kategori[]" name="kategori[]" value="9" <?= (in_array('9', $kategoric)) ? 'checked' : '' ?>> Lain</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 nopadding">
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Tindakan/Penanganan</label>
                        </div>
                        <div class="col-md-8 nopadding">
                          <textarea class="form-control toupper- limiter" maxlength="336" attr-name="tindakan" style="width: 100%; height: 100px;" required=""><?= $kecelakaan['tindakan'] ?></textarea>
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
                          <label><input <?= ($kecelakaan['bsrl'] == '0') ? 'checked' : '' ?> class="apdinpbsrlmkk" type="radio" attr-name="bsrl" name="bsrl" value="0" required> Sangat Berat</label>
                          <br>
                          <label><input <?= ($kecelakaan['bsrl'] == '1') ? 'checked' : '' ?> class="apdinpbsrlmkk" type="radio" attr-name="bsrl" name="bsrl" value="1" required> Berat</label>
                          <br>
                          <label><input <?= ($kecelakaan['bsrl'] == '2') ? 'checked' : '' ?> class="apdinpbsrlmkk" type="radio" attr-name="bsrl" name="bsrl" value="2" required> Sedang</label>
                          <br>
                          <label><input <?= ($kecelakaan['bsrl'] == '3') ? 'checked' : '' ?> class="apdinpbsrlmkk" type="radio" attr-name="bsrl" name="bsrl" value="3" required> Ringan</label>
                          <br>
                          <label><input <?= ($kecelakaan['bsrl'] == '4') ? 'checked' : '' ?> class="apdinpbsrlmkk" type="radio" attr-name="bsrl" name="bsrl" value="4" required> Laka</label>
                        </div>
                        <?php
                        $keterangan = [
                          'Meninggal Dunia',
                          'Terluka, Diobati & Dirawat Inap',
                          'Terluka, Diobati & Diminta Pulang Tidak Bisa Melanjutkan Pekerjaan',
                          'Terluka, Diobati & Bisa Melanjutkan Pekerjaan',
                          'Kecelakaan Lalu Lintas'
                        ]
                        ?>
                        <div class="col-md-5 nopadding float-left">
                          <textarea rows="3" id="keterangan" class="form-control" style="resize:none" readonly><?= $keterangan[$kecelakaan['bsrl']]; ?></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 nopadding">
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Penggunaan APD</label>
                        </div>
                        <div class="col-md-4 nopadding">
                          <label><input class="" type="checkbox" attr-name="apd[]" name="apd[]" value="1" <?= (in_array('1', $apdc)) ? 'checked' : '' ?>> Pakai</label>
                          <br>
                          <label><input class="" type="checkbox" attr-name="apd[]" name="apd[]" value="2" <?= (in_array('2', $apdc)) ? 'checked' : '' ?>> Tidak pakai</label>
                          <br>
                          <label><input class="" type="checkbox" attr-name="apd[]" name="apd[]" value="3" <?= (in_array('3', $apdc)) ? 'checked' : '' ?>> Tidak Terdapat Standar</label>
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
                          <label><input class="apdinpprosmkk" type="radio" attr-name="prosedur" name="prosedur" value="1" <?= ($kecelakaan['prosedur'] == '1') ? 'checked' : '' ?>> Sesuai</label>
                          <br>
                          <label><input class="apdinpprosmkk" type="radio" attr-name="prosedur" name="prosedur" value="2" <?= ($kecelakaan['prosedur'] == '2') ? 'checked' : '' ?>> Tidak Sesuai</label>
                          <br>
                          <label><input class="apdinpprosmkk" type="radio" attr-name="prosedur" name="prosedur" value="3" <?= ($kecelakaan['prosedur'] == '3') ? 'checked' : '' ?>> Belum Ada Standar</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 nopadding">
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Faktor kecelakaan</label>
                        </div>
                        <div class="col-md-4 nopadding">
                          <label><input type="checkbox" attr-name="faktor[]" name="faktor[]" value="1" <?= (in_array('1', $faktorc)) ? 'checked' : '' ?>> Man</label>
                          <br>
                          <label><input type="checkbox" attr-name="faktor[]" name="faktor[]" value="2" <?= (in_array('2', $faktorc)) ? 'checked' : '' ?>> Machine</label>
                          <br>
                          <label><input type="checkbox" attr-name="faktor[]" name="faktor[]" value="3" <?= (in_array('3', $faktorc)) ? 'checked' : '' ?>> Methode</label>
                        </div>
                        <div class="col-md-4 nopadding">
                          <label><input type="checkbox" attr-name="faktor[]" name="faktor[]" value="4" <?= (in_array('4', $faktorc)) ? 'checked' : '' ?>> Material</label>
                          <br>
                          <label><input type="checkbox" attr-name="faktor[]" name="faktor[]" value="5" <?= (in_array('5', $faktorc)) ? 'checked' : '' ?>> Working Area</label>
                          <br>
                          <label><input type="checkbox" attr-name="faktor[]" name="faktor[]" value="6" <?= (in_array('6', $faktorc)) ? 'checked' : '' ?>> Others</label>
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
                          <label><input class="apdinpunsmkk" type="radio" attr-name="unsafe" name="unsafe" value="1" <?= ($kecelakaan['unsafe'] == '1') ? 'checked' : '' ?>> Action</label>
                          <br>
                          <label><input class="apdinpunsmkk" type="radio" attr-name="unsafe" name="unsafe" value="2" <?= ($kecelakaan['unsafe'] == '2') ? 'checked' : '' ?>> Condition</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 nopadding">
                      <div class="col-md-12 nopadding martop">
                        <div class="col-md-3 nopadding">
                          <label style="margin-top: 5px;">Kriteria<br>Stop SIX</label>
                        </div>
                        <div class="col-md-4 nopadding">
                          <label><input class="apdinpkssmkk" type="radio" attr-name="kriteria" name="kriteria" value="1" <?= ($kecelakaan['kriteria_stop_six'] == '1') ? 'checked' : '' ?>> Apparatus</label>
                          <br>
                          <label><input class="apdinpkssmkk" type="radio" attr-name="kriteria" name="kriteria" value="2" <?= ($kecelakaan['kriteria_stop_six'] == '2') ? 'checked' : '' ?>> Big heavy</label>
                          <br>
                          <label><input class="apdinpkssmkk" type="radio" attr-name="kriteria" name="kriteria" value="3" <?= ($kecelakaan['kriteria_stop_six'] == '3') ? 'checked' : '' ?>> Car</label>
                        </div>
                        <div class="col-md-4 nopadding">
                          <label><input class="apdinpkssmkk" type="radio" attr-name="kriteria" name="kriteria" value="4" <?= ($kecelakaan['kriteria_stop_six'] == '4') ? 'checked' : '' ?>> Drop</label>
                          <br>
                          <label><input class="apdinpkssmkk" type="radio" attr-name="kriteria" name="kriteria" value="5" <?= ($kecelakaan['kriteria_stop_six'] == '5') ? 'checked' : '' ?>> Electrical</label>
                          <br>
                          <label><input class="apdinpkssmkk" type="radio" attr-name="kriteria" name="kriteria" value="6" <?= ($kecelakaan['kriteria_stop_six'] == '6') ? 'checked' : '' ?>> Fire</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 nopadding">
                      <div class="col-md-12 nopadding martop">
                        <label for="">Apd Yang digunakan</label>
                        <table class="table">
                          <tr>
                            <?php foreach ($apd_list_chunk_3 as $items) : ?>
                              <td width="25%">
                                <table class="table" width="170px" style="font-size: 9pt">
                                  <tr>
                                    <td class="">Std</td>
                                    <td class="">Act</td>
                                    <td></td>
                                  </tr>
                                  <?php foreach ($items as $i => $item) : ?>
                                    <tr>
                                      <?php
                                          $used_apd_index = array_search($item['name'], $apd_digunakan_name);
                                          $standard_checklist = '';
                                          $actual_checklist = '';

                                          if ($used_apd_index !== false) {
                                            $standard_checklist = $apd_digunakan[$used_apd_index]['standard'] == 't';
                                            $actual_checklist = $apd_digunakan[$used_apd_index]['actual'] == 't';
                                          }

                                          ?>
                                      <input type="hidden" name="apd_digunakan[<?= $item['id'] ?>][nama_apd]" value="<?= $item['name'] ?>">
                                      <td class="bordered square-checkbox">
                                        <input type="checkbox" name="apd_digunakan[<?= $item['id'] ?>][standard]" <?= $standard_checklist ? 'checked' : '' ?>>
                                      </td>
                                      <td class="bordered square-checkbox">
                                        <input type="checkbox" name="apd_digunakan[<?= $item['id'] ?>][actual]" <?= $actual_checklist ? 'checked' : '' ?>>
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
                                $apd_digunakan_lain = array_pad($apd_digunakan_lain, 7, [
                                  'nama_apd' => '',
                                  'standard' => 'f',
                                  'actual' => 'f',
                                ]);
                                ?>
                                <?php foreach ($apd_digunakan_lain as $i => $item) : ?>
                                  <tr>
                                    <td class="bordered square-checkbox">
                                      <input type="checkbox" name="apd_digunakan_lain[<?= $i ?>][standard]" <?= $item['standard'] == 't' ? 'checked' : '' ?>>
                                    </td>
                                    <td class="bordered square-checkbox">
                                      <input type="checkbox" name="apd_digunakan_lain[<?= $i ?>][actual]" <?= $item['actual'] == 't' ? 'checked' : '' ?>>
                                    </td>
                                    <td style="padding: 0.5em;">
                                      <input type="text" name="apd_digunakan_lain[<?= $i ?>][nama_apd]" value="<?= $item['nama_apd'] ?>" style="height: 25px;" placeholder="Isi manual" class="form-control">
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
                        <small class="text-danger">*) Masukkan file gambar jika ingin merubah lampiran</small>
                        <?php for ($x = 1; $x <= 2; $x++) : ?>
                          <div class="col-md-12 nopadding martop">
                            <div class="col-md-3 nopadding">
                              <label style="margin-top: 5px;">Lampiran <?= $x ?></label>
                            </div>
                            <div class="col-md-7 nopadding">
                              <!-- <?php if ($kecelakaan['lampiran_' . $x]) : ?>
                                <a target="_blank" href="<?= base_url('/assets/upload/P2K3v2/kecelakaan_kerja/foto/' . $kecelakaan['lampiran_' . $x]) ?>">Klik disini untuk melihat gambar <?= $x ?></a>
                              <?php endif ?> -->
                              <input type="hidden" name="lampiran_foto[<?= $x ?>]" class="<?= "lampiran_$x" ?>" value="<?= $base64Attachment[$x] ?>">
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
                          <img src="<?= base_url('/assets/upload/P2K3v2/kecelakaan_kerja/foto/' . $kecelakaan['lampiran_1']) ?>" class="<?= $kecelakaan['lampiran_1'] ?> img-preview" data-bind-attachment="1" style="height: 130px; width: 100%; object-fit: cover;" />
                          <label for="" class="text-center">Lampiran 1</label>
                        </div>
                        <div class="col-md-6">
                          <img src="<?= base_url('/assets/upload/P2K3v2/kecelakaan_kerja/foto/' . $kecelakaan['lampiran_2']) ?>" class="<?= $kecelakaan['lampiran_2'] ?> img-preview" data-bind-attachment="2" style="height: 130px; width: 100%; object-fit: cover;" />
                          <div>
                            <label for="" class="text-center">Lampiran 2</label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12" style="height: 1px;background-color: grey; margin-top: 20px; margin-bottom: 20px;"></div>
                    <div class="col-md-12 text-center" style="margin-top: 50px;">
                      <label style="color: red;">* Pastikan Data Sudah Sesuai Sebelum Klik Submit</label>
                      <br>
                      <a href="<?= base_url('p2k3adm_V2/Admin/monitoringKK') ?>" class="btn btn-warning btn-md">Kembali</a>
                      <button type="submit" class="btn btn-success btn-md" id="apdbtnupdatemkk" value="<?= $kecelakaan['id_kecelakaan'] ?>" name="id_kecelakaan" disabled>Update</button>
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

    $('.limiter').each(function() {
      const maxLength = $(this).attr('maxlength')
      $(this).inputlimiter({
        limit: maxLength,
        remText: 'Sisa %n karakter lagi...',
        limitText: 'Limit %n karakter.'
      });
    })

    // force close loading in second if not work
    setTimeout(() => {
      $('#surat-loading').attr('hidden', 'hidden')
    }, 3 * 1000)
  })

  window.addEventListener('load', function() {
    InitK3kForm();
    InitK3kFormEdit();
    // apd_alert_mixin('success', 'Berhasil Update Data :)');
    <?= ($this->session->userdata('update_mkk') == 'true') ? "apd_alert_mixin('success', 'Berhasil Update Data :)');" : "" ?>

    $(document).on('ifClicked', '.apdinpbsrlmkk', function() {
      $('.apdinpbsrlmkk').each(function() {
        $(this).iCheck('uncheck');
      });
    });

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
      $(`img[data-bind-attachment=${id_attachment}]`).removeAttr('src')
      // $(`input[name="lampiran_foto[${id_attachment}]]"`).val('')
      $(`input.lampiran_${id_attachment}`).val('')
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
    $modalImageCropper.find('#crop').on('click', function() {
      const $preview = $(`img[data-bind-attachment=${id_attachment}]`)
      const $fileInput = $(`input[name='lampiran_foto[${id_attachment}]'`)

      const canvas = cropper.getCroppedCanvas({
        width: 400,
        height: 400,
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high'
      });
      const base64Image = canvas.toDataURL()

      $preview.attr('src', base64Image)
      $fileInput.val(base64Image)
      $modalImageCropper.modal('hide')
    })

  });
</script>