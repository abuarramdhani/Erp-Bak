<style>
    .nopadding {
       padding: 0 !important;
   }
   .martop{
    margin-top: 5px;
   }
   .daterangepicker.auto-apply .drp-buttons{
    display: block !important;
   }
</style>
<section class="content">
    <div class="inner" >
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
                                <form method="post" action="<?= base_url('p2k3adm_V2/Admin/update_monitoringKK'); ?>">
                                    <div class="panel-body">
                                        <div class="col-md-6 nopadding">
                                            <div class="col-md-12 nopadding">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">No Induk</label>
                                                </div>
                                                <div class="col-md-8 nopadding">
                                                    <input class="form-control" disabled="" value="<?= $pkj['noind'].' - '.trim($pkj['nama']) ?>">
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
                                                    <label><input class="apdinprngwkt1mkk" type="radio" attr-name="range1" name="range1" value="1" <?= ($kecelakaan['range_waktu1'] == '1') ? 'checked':'' ?> > Awal - Break</label>
                                                    <br>
                                                    <label><input class="apdinprngwkt1mkk" type="radio" attr-name="range1" name="range1" value="2" <?= ($kecelakaan['range_waktu1'] == '2') ? 'checked':'' ?> > Break - Istirahat</label>
                                                    <br>
                                                    <label><input class="apdinprngwkt1mkk" type="radio" attr-name="range1" name="range1" value="3" <?= ($kecelakaan['range_waktu1'] == '3') ? 'checked':'' ?> > Istirahat - Pulang</label>
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
                                                        <?php foreach ($lokasi as $key): ?>
                                                            <option value="<?=$key['id_']?>"><?=$key['lokasi_kerja']?></option>   
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
                                                    <label><input class="apdinprngwkt2mkk" type="radio" attr-name="range2" name="range2" value="1"  <?= ($kecelakaan['range_waktu2'] == '1') ? 'checked':'' ?> > 06:00:00 - 09:00:00</label>
                                                    <br>
                                                    <label><input class="apdinprngwkt2mkk" type="radio" attr-name="range2" name="range2" value="2"  <?= ($kecelakaan['range_waktu2'] == '2') ? 'checked':'' ?> > 09:15:00 - 11:45:00</label>
                                                    <br>
                                                    <label><input class="apdinprngwkt2mkk" type="radio" attr-name="range2" name="range2" value="3"  <?= ($kecelakaan['range_waktu2'] == '3') ? 'checked':'' ?> > 12:30:00 - 14:00:00</label>
                                                    <br>
                                                    <label><input class="apdinprngwkt2mkk" type="radio" attr-name="range2" name="range2" value="4"  <?= ($kecelakaan['range_waktu2'] == '4') ? 'checked':'' ?> > 14:00:00 - 16:00:00</label>
                                                </div>
                                                <div class="col-md-4 nopadding">
                                                    <label><input class="apdinprngwkt2mkk" type="radio" attr-name="range2" name="range2" value="5"  <?= ($kecelakaan['range_waktu2'] == '5') ? 'checked':'' ?> > 16:15:00 - 18:00:00</label>
                                                    <br>
                                                    <label><input class="apdinprngwkt2mkk" type="radio" attr-name="range2" name="range2" value="6"  <?= ($kecelakaan['range_waktu2'] == '6') ? 'checked':'' ?> > 18:45:00 - 22:00:00</label>
                                                    <br>
                                                    <label><input class="apdinprngwkt2mkk" type="radio" attr-name="range2" name="range2" value="7"  <?= ($kecelakaan['range_waktu2'] == '7') ? 'checked':'' ?> > 22:00:00 - 01:00:00</label>
                                                    <br>
                                                    <label><input class="apdinprngwkt2mkk" type="radio" attr-name="range2" name="range2" value="8"  <?= ($kecelakaan['range_waktu2'] == '8') ? 'checked':'' ?> > 01:00:00 - 05:00:00</label>
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
                                                    <label style="margin-top: 5px;">Jenis Pekerjaan</label>
                                                </div>
                                                <div class="col-md-8 nopadding apdSbgRadio">
                                                    <label><input class="apdinpjpmkk" type="radio" attr-name="jenis_pekerjaan" name="jenis_pekerjaan" value="1" <?= ($kecelakaan['jenis_pekerjaan'] == '1') ? 'checked':'' ?>> Reguler</label>
                                                    <br>
                                                    <label><input class="apdinpjpmkk" type="radio" attr-name="jenis_pekerjaan" name="jenis_pekerjaan" value="2" <?= ($kecelakaan['jenis_pekerjaan'] == '2') ? 'checked':'' ?>> Non Reguler</label>
                                                    <br>
                                                    <label><input class="apdinpjpmkk" type="radio" attr-name="jenis_pekerjaan" name="jenis_pekerjaan" value="3" <?= ($kecelakaan['jenis_pekerjaan'] == '3') ? 'checked':'' ?>> Lain - lain</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 nopadding" style="margin-top: 20px;">
                                            <div class="col-md-12 nopadding martop">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">Kondisi</label>
                                                </div>
                                                <div class="col-md-8 nopadding">
                                                   <textarea class="form-control toupper" attr-name="kondisi" style="width: 100%; height: 100px;" required=""><?= $kecelakaan['kondisi'] ?></textarea>
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
                                                    <label><input type="checkbox" attr-name="bagian_tubuh[]" value="1" <?= (in_array('1', $bagianc)) ? 'checked':'' ?> > Wajah</label>
                                                    <br>
                                                    <label><input type="checkbox" attr-name="bagian_tubuh[]" value="2" <?= (in_array('2', $bagianc)) ? 'checked':'' ?> > Mata</label>
                                                    <br>
                                                    <label><input type="checkbox" attr-name="bagian_tubuh[]" value="3" <?= (in_array('3', $bagianc)) ? 'checked':'' ?> > Tangan</label>
                                                    <br>
                                                    <label><input type="checkbox" attr-name="bagian_tubuh[]" value="4" <?= (in_array('4', $bagianc)) ? 'checked':'' ?> > Kaki</label>
                                                    <br>
                                                    <label><input type="checkbox" attr-name="bagian_tubuh[]" value="5" <?= (in_array('5', $bagianc)) ? 'checked':'' ?> > Lainnya</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 nopadding">
                                            <div class="col-md-12 nopadding martop">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">Penyebab</label>
                                                </div>
                                                <div class="col-md-8 nopadding">
                                                   <textarea class="form-control toupper" attr-name="penyebab" style="width: 100%; height: 100px;" required=""><?= $kecelakaan['penyebab'] ?></textarea>
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
                                                    <label><input type="checkbox" attr-name="kategori[]" name="kategori[]" value="1" <?= (in_array('1', $kategoric)) ? 'checked':'' ?> > Tertusuk</label>
                                                    <br>
                                                    <label><input type="checkbox" attr-name="kategori[]" name="kategori[]" value="2" <?= (in_array('2', $kategoric)) ? 'checked':'' ?> > Terjepit</label>
                                                    <br>
                                                    <label><input type="checkbox" attr-name="kategori[]" name="kategori[]" value="3" <?= (in_array('3', $kategoric)) ? 'checked':'' ?> > Kejatuhan / Jatuh</label>
                                                    <br>
                                                    <label><input type="checkbox" attr-name="kategori[]" name="kategori[]" value="4" <?= (in_array('4', $kategoric)) ? 'checked':'' ?> > Terbentur</label>
                                                    <br>
                                                    <label><input type="checkbox" attr-name="kategori[]" name="kategori[]" value="5" <?= (in_array('5', $kategoric)) ? 'checked':'' ?> > Terbakar</label>
                                                </div>
                                                <div class="col-md-4 nopadding">
                                                    <label><input type="checkbox" attr-name="kategori[]" name="kategori[]" value="6" <?= (in_array('6', $kategoric)) ? 'checked':'' ?> > Kelilipan</label>
                                                    <br>
                                                    <label><input type="checkbox" attr-name="kategori[]" name="kategori[]" value="7" <?= (in_array('7', $kategoric)) ? 'checked':'' ?> > Tersangkut</label>
                                                    <br>
                                                    <label><input type="checkbox" attr-name="kategori[]" name="kategori[]" value="8" <?= (in_array('8', $kategoric)) ? 'checked':'' ?> > Tergires</label>
                                                    <br>
                                                    <label><input type="checkbox" attr-name="kategori[]" name="kategori[]" value="9" <?= (in_array('9', $kategoric)) ? 'checked':'' ?> > Lain</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 nopadding">
                                            <div class="col-md-12 nopadding martop">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">Tindakan</label>
                                                </div>
                                                <div class="col-md-8 nopadding">
                                                   <textarea class="form-control toupper" attr-name="tindakan" style="width: 100%; height: 100px;" required=""><?= $kecelakaan['tindakan'] ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 20px;"></div>
                                        <div class="col-md-6 nopadding">
                                            <div class="col-md-12 nopadding martop">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">BSRL</label>
                                                </div>
                                                <div class="col-md-4 nopadding">
                                                    <label><input <?= ($kecelakaan['bsrl'] == '1') ? 'checked':'' ?> class="apdinpbsrlmkk" type="radio" attr-name="bsrl" name="bsrl" value="1" required="" > Berat</label>
                                                    <br>
                                                    <label><input <?= ($kecelakaan['bsrl'] == '2') ? 'checked':'' ?> class="apdinpbsrlmkk" type="radio" attr-name="bsrl" name="bsrl" value="2" required> Sedang</label>
                                                    <br>
                                                    <label><input <?= ($kecelakaan['bsrl'] == '3') ? 'checked':'' ?> class="apdinpbsrlmkk" type="radio" attr-name="bsrl" name="bsrl" value="3" required> Ringan</label>
                                                    <br>
                                                    <label><input <?= ($kecelakaan['bsrl'] == '4') ? 'checked':'' ?> class="apdinpbsrlmkk" type="radio" attr-name="bsrl" name="bsrl" value="4" required> Lain</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 nopadding">
                                            <div class="col-md-12 nopadding martop">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">Penggunaan APD</label>
                                                </div>
                                                <div class="col-md-4 nopadding">
                                                    <label><input class="" type="checkbox" attr-name="apd[]" name="apd[]" value="1" <?= (in_array('1', $apdc)) ? 'checked':'' ?> > Pakai</label>
                                                    <br>
                                                    <label><input class="" type="checkbox" attr-name="apd[]" name="apd[]" value="2" <?= (in_array('2', $apdc)) ? 'checked':'' ?> > Tidak pakai</label>
                                                    <br>
                                                    <label><input class="" type="checkbox" attr-name="apd[]" name="apd[]" value="3" <?= (in_array('3', $apdc)) ? 'checked':'' ?> > Tidak Terdapat Standar</label>
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
                                                    <label><input class="apdinpprosmkk" type="radio" attr-name="prosedur" name="prosedur" value="1" <?= ($kecelakaan['prosedur'] == '1') ? 'checked':'' ?> > Sesuai</label>
                                                    <br>
                                                    <label><input class="apdinpprosmkk" type="radio" attr-name="prosedur" name="prosedur" value="2" <?= ($kecelakaan['prosedur'] == '2') ? 'checked':'' ?> > Tidak Sesuai</label>
                                                    <br>
                                                    <label><input class="apdinpprosmkk" type="radio" attr-name="prosedur" name="prosedur" value="3" <?= ($kecelakaan['prosedur'] == '3') ? 'checked':'' ?> > Belum Ada Standar</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 nopadding">
                                            <div class="col-md-12 nopadding martop">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">Faktor kecelakaan</label>
                                                </div>
                                                <div class="col-md-4 nopadding">
                                                    <label><input type="checkbox" attr-name="faktor[]" name="faktor[]" value="1" <?= (in_array('1', $faktorc)) ? 'checked':'' ?> > Man</label>
                                                    <br>
                                                    <label><input type="checkbox" attr-name="faktor[]" name="faktor[]" value="2" <?= (in_array('2', $faktorc)) ? 'checked':'' ?> > Machine</label>
                                                    <br>
                                                    <label><input type="checkbox" attr-name="faktor[]" name="faktor[]" value="3" <?= (in_array('3', $faktorc)) ? 'checked':'' ?> > Methode</label>
                                                </div>
                                                <div class="col-md-4 nopadding">
                                                    <label><input type="checkbox" attr-name="faktor[]" name="faktor[]" value="4" <?= (in_array('4', $faktorc)) ? 'checked':'' ?> > Material</label>
                                                    <br>
                                                    <label><input type="checkbox" attr-name="faktor[]" name="faktor[]" value="5" <?= (in_array('5', $faktorc)) ? 'checked':'' ?> > Working Area</label>
                                                    <br>
                                                    <label><input type="checkbox" attr-name="faktor[]" name="faktor[]" value="6" <?= (in_array('6', $faktorc)) ? 'checked':'' ?> > Others</label>
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
                                                    <label><input class="apdinpunsmkk" type="radio" attr-name="unsafe" name="unsafe" value="1" <?= ($kecelakaan['unsafe'] == '1') ? 'checked':'' ?> > Action</label>
                                                    <br>
                                                    <label><input class="apdinpunsmkk" type="radio" attr-name="unsafe" name="unsafe" value="2" <?= ($kecelakaan['unsafe'] == '2') ? 'checked':'' ?> > Condition</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 nopadding">
                                            <div class="col-md-12 nopadding martop">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">Kriteria<br>Stop SIX</label>
                                                </div>
                                                <div class="col-md-4 nopadding">
                                                    <label><input class="apdinpkssmkk" type="radio" attr-name="kriteria" name="kriteria" value="1" <?= ($kecelakaan['kriteria_stop_six'] == '1') ? 'checked':'' ?> > Apparatus</label>
                                                    <br>
                                                    <label><input class="apdinpkssmkk" type="radio" attr-name="kriteria" name="kriteria" value="2" <?= ($kecelakaan['kriteria_stop_six'] == '2') ? 'checked':'' ?> > Big heavy</label>
                                                    <br>
                                                    <label><input class="apdinpkssmkk" type="radio" attr-name="kriteria" name="kriteria" value="3" <?= ($kecelakaan['kriteria_stop_six'] == '3') ? 'checked':'' ?> > Car</label>
                                                </div>
                                                <div class="col-md-4 nopadding">
                                                    <label><input class="apdinpkssmkk" type="radio" attr-name="kriteria" name="kriteria" value="4" <?= ($kecelakaan['kriteria_stop_six'] == '4') ? 'checked':'' ?> > Drop</label>
                                                    <br>
                                                    <label><input class="apdinpkssmkk" type="radio" attr-name="kriteria" name="kriteria" value="5" <?= ($kecelakaan['kriteria_stop_six'] == '5') ? 'checked':'' ?> > Electrical</label>
                                                    <br>
                                                    <label><input class="apdinpkssmkk" type="radio" attr-name="kriteria" name="kriteria" value="6" <?= ($kecelakaan['kriteria_stop_six'] == '6') ? 'checked':'' ?> > Fire</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="height: 1px;background-color: grey; margin-top: 20px; margin-bottom: 20px;"></div>
                                        <div class="col-md-12 nopadding">
                                            <label>CAR</label>
                                        </div>
                                        <div class="col-md-6 nopadding">
                                            <div class="col-md-12 nopadding martop">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">Tgl CAR diterima</label>
                                                </div>
                                                <div class="col-md-8 nopadding">
                                                   <input class="form-control daterangepickerYMD" attr-name="tgl_car" value="<?= (!empty($kecelakaan['tgl_car'])) ? date('Y-m-d', strtotime($kecelakaan['tgl_car'])):'' ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12 nopadding martop">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">PIC</label>
                                                </div>
                                                <div class="col-md-8 nopadding">
                                                   <select class="form-control" id="apdslcpic" attr-name="pic" data-allow-clear="true">
                                                    <?php if (isset($pic)): ?>
                                                       <option value="<?= $kecelakaan['pic'] ?>" selected><?= $pic['noind'].' - '.$pic['nama'] ?></option>
                                                    <?php endif ?>
                                                   </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 nopadding martop">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">Seksi</label>
                                                </div>
                                                <div class="col-md-8 nopadding">
                                                   <input class="form-control" disabled="" attr-name="seksi_car" value="<?= (isset($pic)) ? $pic['seksi']:'' ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12 nopadding martop">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">Target Selesai</label>
                                                </div>
                                                <div class="col-md-8 nopadding">
                                                   <input class="form-control daterangepickerYMD" attr-name="target_car" value="<?= (!empty($kecelakaan['tgl_selesai_car'])) ? date('Y-m-d', strtotime($kecelakaan['tgl_selesai_car'])):'' ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12 nopadding martop">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">Target Closed</label>
                                                </div>
                                                <div class="col-md-8 nopadding">
                                                   <input class="form-control daterangepickerYMD" attr-name="close_car" 
                                                   value="<?= (!empty($kecelakaan['tgl_close_car'])) ? date('Y-m-d', strtotime($kecelakaan['tgl_close_car'])):''  ?>">
                                                </div>
                                            </div>
                                        </div>
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
<div id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;" hidden="hidden">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<script>
    window.addEventListener('load', function () {
        InitK3kForm();
        InitK3kFormEdit();
        // apd_alert_mixin('success', 'Berhasil Update Data :)');
        <?= ($this->session->userdata('update_mkk') == 'true') ? "apd_alert_mixin('success', 'Berhasil Update Data :)');":"" ?>

        $(document).on('ifClicked', '.apdinpbsrlmkk', function(){
            $('.apdinpbsrlmkk').each(function(){
                $(this).iCheck('uncheck');
            });
        });
     });
</script>