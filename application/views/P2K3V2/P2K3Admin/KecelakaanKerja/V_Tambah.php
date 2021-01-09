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
                                <form method="post" action="<?= base_url('p2k3adm_V2/Admin/submit_monitoringKK'); ?>">
                                    <div class="panel-body">
                                        <div class="col-md-6 nopadding">
                                            <div class="col-md-12 nopadding">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">No Induk</label>
                                                </div>
                                                <div class="col-md-8 nopadding">
                                                    <select class="form-control" id="apdslcpkj" name="noind" required="">

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
                                                    <input class="form-control daterangepickerYMDhis" name="tgl_kecelakaan" id="apdinptglkc" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-12 nopadding martop">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">Tempat / TKP</label>
                                                </div>
                                                <div class="col-md-8 nopadding">
                                                    <select class="form-control apdSlcTags" name="tkp" id="apdslclstkp-xxx" required="">
                                                        <option></option>
                                                        <?php foreach ($tkp as $k): ?>
                                                            <option value="<?= $k['tkp'] ?>"><?= $k['tkp'] ?></option>    
                                                        <?php endforeach ?>
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
                                                    <label><input class="apdinprngwkt1mkk" type="radio" name="range1" value="1" > Awal - Break</label>
                                                    <br>
                                                    <label><input class="apdinprngwkt1mkk" type="radio" name="range1" value="2" > Break - Istirahat</label>
                                                    <br>
                                                    <label><input class="apdinprngwkt1mkk" type="radio" name="range1" value="3" > Istirahat - Pulang</label>
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
                                                    <select class="form-control apd_select2" name="lokasi_kerja" placeholder="Pilih Salah 1" id="apdslcmkkloker" required="">
                                                        <option></option>
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
                                                    <label><input class="apdinprngwkt2mkk" type="radio" name="range2" value="1" > 06:00:00 - 09:00:00</label>
                                                    <br>
                                                    <label><input class="apdinprngwkt2mkk" type="radio" name="range2" value="2" > 09:15:00 - 11:45:00</label>
                                                    <br>
                                                    <label><input class="apdinprngwkt2mkk" type="radio" name="range2" value="3" > 12:30:00 - 14:00:00</label>
                                                    <br>
                                                    <label><input class="apdinprngwkt2mkk" type="radio" name="range2" value="4" > 14:00:00 - 16:00:00</label>
                                                </div>
                                                <div class="col-md-4 nopadding">
                                                    <label><input class="apdinprngwkt2mkk" type="radio" name="range2" value="5" > 16:15:00 - 18:00:00</label>
                                                    <br>
                                                    <label><input class="apdinprngwkt2mkk" type="radio" name="range2" value="6" > 18:45:00 - 22:00:00</label>
                                                    <br>
                                                    <label><input class="apdinprngwkt2mkk" type="radio" name="range2" value="7" > 22:00:00 - 01:00:00</label>
                                                    <br>
                                                    <label><input class="apdinprngwkt2mkk" type="radio" name="range2" value="8" > 01:00:00 - 05:00:00</label>
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
                                                    <label><input class="apdinpjpmkk" type="radio" name="jenis_pekerjaan" value="1" > Reguler</label>
                                                    <br>
                                                    <label><input class="apdinpjpmkk" type="radio" name="jenis_pekerjaan" value="2" > Non Reguler</label>
                                                    <br>
                                                    <label><input class="apdinpjpmkk" type="radio" name="jenis_pekerjaan" value="3" > Lain - lain</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 nopadding" style="margin-top: 20px;">
                                            <div class="col-md-12 nopadding martop">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">Kondisi</label>
                                                </div>
                                                <div class="col-md-8 nopadding">
                                                   <textarea class="form-control toupper" name="kondisi" style="width: 100%; height: 100px;" required=""></textarea>
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
                                                    <label><input type="checkbox" name="bagian_tubuh[]" value="1" > Wajah</label>
                                                    <br>
                                                    <label><input type="checkbox" name="bagian_tubuh[]" value="2" > Mata</label>
                                                    <br>
                                                    <label><input type="checkbox" name="bagian_tubuh[]" value="3" > Tangan</label>
                                                    <br>
                                                    <label><input type="checkbox" name="bagian_tubuh[]" value="4" > Kaki</label>
                                                    <br>
                                                    <label><input type="checkbox" name="bagian_tubuh[]" value="5" > Lainnya</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 nopadding">
                                            <div class="col-md-12 nopadding martop">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">Penyebab</label>
                                                </div>
                                                <div class="col-md-8 nopadding">
                                                   <textarea class="form-control toupper" name="penyebab" style="width: 100%; height: 100px;" required=""></textarea>
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
                                                    <label><input type="checkbox" name="kategori[]" value="1" > Tertusuk</label>
                                                    <br>
                                                    <label><input type="checkbox" name="kategori[]" value="2" > Terjepit</label>
                                                    <br>
                                                    <label><input type="checkbox" name="kategori[]" value="3" > Kejatuhan / Jatuh</label>
                                                    <br>
                                                    <label><input type="checkbox" name="kategori[]" value="4" > Terbentur</label>
                                                    <br>
                                                    <label><input type="checkbox" name="kategori[]" value="5" > Terbakar</label>
                                                </div>
                                                <div class="col-md-4 nopadding">
                                                    <label><input type="checkbox" name="kategori[]" value="6" > Kelilipan</label>
                                                    <br>
                                                    <label><input type="checkbox" name="kategori[]" value="7" > Tersangkut</label>
                                                    <br>
                                                    <label><input type="checkbox" name="kategori[]" value="8" > Tergires</label>
                                                    <br>
                                                    <label><input type="checkbox" name="kategori[]" value="9" > Lain</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 nopadding">
                                            <div class="col-md-12 nopadding martop">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">Tindakan</label>
                                                </div>
                                                <div class="col-md-8 nopadding">
                                                   <textarea class="form-control toupper" name="tindakan" style="width: 100%; height: 100px;" required=""></textarea>
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
                                                    <label><input class="apdinpbsrlmkk" type="radio" name="bsrl" value="1" required="" > Berat</label>
                                                    <br>
                                                    <label><input class="apdinpbsrlmkk" type="radio" name="bsrl" value="2" > Sedang</label>
                                                    <br>
                                                    <label><input class="apdinpbsrlmkk" type="radio" name="bsrl" value="3"> Ringan</label>
                                                    <br>
                                                    <label><input class="apdinpbsrlmkk" type="radio" name="bsrl" value="4" > Lain</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 nopadding">
                                            <div class="col-md-12 nopadding martop">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">Penggunaan APD</label>
                                                </div>
                                                <div class="col-md-4 nopadding">
                                                    <label><input class="" type="checkbox" name="apd[]" value="1" > Pakai</label>
                                                    <br>
                                                    <label><input class="" type="checkbox" name="apd[]" value="2" > Tidak pakai</label>
                                                    <br>
                                                    <label><input class="" type="checkbox" name="apd[]" value="3" > Tidak Terdapat Standar</label>
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
                                                    <label><input class="apdinpprosmkk" type="radio" name="prosedur" value="1" > Sesuai</label>
                                                    <br>
                                                    <label><input class="apdinpprosmkk" type="radio" name="prosedur" value="2" > Tidak Sesuai</label>
                                                    <br>
                                                    <label><input class="apdinpprosmkk" type="radio" name="prosedur" value="3" > Belum Ada Standar</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 nopadding">
                                            <div class="col-md-12 nopadding martop">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">Faktor kecelakaan</label>
                                                </div>
                                                <div class="col-md-4 nopadding">
                                                    <label><input type="checkbox" name="faktor[]" value="1" > Man</label>
                                                    <br>
                                                    <label><input type="checkbox" name="faktor[]" value="2" > Machine</label>
                                                    <br>
                                                    <label><input type="checkbox" name="faktor[]" value="3" > Methode</label>
                                                </div>
                                                <div class="col-md-4 nopadding">
                                                    <label><input type="checkbox" name="faktor[]" value="4" > Material</label>
                                                    <br>
                                                    <label><input type="checkbox" name="faktor[]" value="5" > Working Area</label>
                                                    <br>
                                                    <label><input type="checkbox" name="faktor[]" value="6" > Others</label>
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
                                                    <label><input class="apdinpunsmkk" type="radio" name="unsafe" value="1" > Action</label>
                                                    <br>
                                                    <label><input class="apdinpunsmkk" type="radio" name="unsafe" value="2" > Condition</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 nopadding">
                                            <div class="col-md-12 nopadding martop">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">Kriteria<br>Stop SIX</label>
                                                </div>
                                                <div class="col-md-4 nopadding">
                                                    <label><input class="apdinpkssmkk" type="radio" name="kriteria" value="1" > Apparatus</label>
                                                    <br>
                                                    <label><input class="apdinpkssmkk" type="radio" name="kriteria" value="2" > Big heavy</label>
                                                    <br>
                                                    <label><input class="apdinpkssmkk" type="radio" name="kriteria" value="3" > Car</label>
                                                </div>
                                                <div class="col-md-4 nopadding">
                                                    <label><input class="apdinpkssmkk" type="radio" name="kriteria" value="4" > Drop</label>
                                                    <br>
                                                    <label><input class="apdinpkssmkk" type="radio" name="kriteria" value="5" > Electrical</label>
                                                    <br>
                                                    <label><input class="apdinpkssmkk" type="radio" name="kriteria" value="6" > Fire</label>
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
                                                   <input class="form-control daterangepickerYMD" name="tgl_car">
                                                </div>
                                            </div>
                                            <div class="col-md-12 nopadding martop">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">PIC</label>
                                                </div>
                                                <div class="col-md-8 nopadding">
                                                   <select class="form-control" id="apdslcpic" name="pic" data-allow-clear="true"></select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 nopadding martop">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">Seksi</label>
                                                </div>
                                                <div class="col-md-8 nopadding">
                                                   <input class="form-control" disabled="" name="seksi_car">
                                                </div>
                                            </div>
                                            <div class="col-md-12 nopadding martop">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">Target Selesai</label>
                                                </div>
                                                <div class="col-md-8 nopadding">
                                                   <input class="form-control daterangepickerYMD" name="target_car">
                                                </div>
                                            </div>
                                            <div class="col-md-12 nopadding martop">
                                                <div class="col-md-3 nopadding">
                                                    <label style="margin-top: 5px;">Target Closed</label>
                                                </div>
                                                <div class="col-md-8 nopadding">
                                                   <input class="form-control daterangepickerYMD" name="close_car">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-center" style="margin-top: 50px;">
                                            <label style="color: red;">* Pastikan Data Sudah Sesuai Sebelum Klik Submit</label>
                                            <br>
                                            <a href="<?= base_url('p2k3adm_V2/Admin/monitoringKK') ?>" class="btn btn-warning btn-md">Kembali</a>
                                            <button type="submit" class="btn btn-success btn-md" id="apdbtnupdatemkk">Simpan</button>
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
        getAllPekerjaTpribadi('#apdslcpkj');
     });
</script>