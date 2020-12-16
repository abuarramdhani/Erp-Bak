<style>
    .nopadl{
        padding-left: 0px;
        margin-top: 2px;
    }
</style>
<div class="col-md-2"></div>
<div class="col-md-8">
    <section class="content">
        <div class="inner">
            <div class="row">
                <div class="col-lg-12">
                    <br/>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border text-center" style="font-weight: bold; font-size: 20px;">
                                     Kontak dengan Probable/Konfirmasi Covid 19 - Satu Rumah
                                </div>
                                <div class="panel-body">
                                  <div class="row">
                                      <form method="post" action="<?php echo base_url('Covid/MonitoringCovid/insertSatuRumah')?>" enctype="multipart/form-data">
                                            <div class="col-md-12">
                                                <?php echo $this->session->flashdata('status_insert_cvd'); ?>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">Biodata</div>
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <label for="usr">Pekerja</label>
                                                            <select id="slc-CVD-MonitoringCovid-Tambah-Pekerja" name="slc-CVD-MonitoringCovid-Tambah-Pekerja" style="width: 100%" data-placeholder="Pilih Pekerja">
                                                                <option value=""></option>
                                                            </select>
                                                            <input type="hidden" id="txt-CVD-MonitoringCovid-Tambah-PekerjaId" name="txt-CVD-MonitoringCovid-Tambah-PekerjaId" value="<?php echo (isset($data) && !empty($data)) ? $data->cvd_pekerja_id : ''; ?>">

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Seksi:</label>
                                                            <input type="text" value="<?php echo (isset($data) && !empty($data)) ? $data->seksi : ''; ?>" class="form-control" id="txt-CVD-MonitoringCovid-Tambah-Seksi" name="txt-CVD-MonitoringCovid-Tambah-Seksi" readonly placeholder="Seksi Pekerja">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Departemen:</label>
                                                            <input type="text" value="<?php echo (isset($data) && !empty($data)) ? $data->dept : ''; ?>" class="form-control" id="txt-CVD-MonitoringCovid-Tambah-Departemen" name="txt-CVD-MonitoringCovid-Tambah-Departemen" readonly placeholder="Departemen Pekerja">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Tanggal Kejadian:</label>
                                                            <input type="text" class="date form-control" name="txtPeriodeKejadian" id="txtPeriodeKejadian" autocomplete="off" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Keterangan Tambahan :</label>
                                                            <textarea
                                                            class="form-control"
                                                            id="txt-CVD-MonitoringCovid-Tambah-Keterangan"
                                                            name="txt-CVD-MonitoringCovid-Tambah-Keterangan"
                                                            placeholder="Keterangan"
                                                            ></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">Keterangan</div>
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <label for="usr">Interaksi dengan Terduga/Terkonfirmasi Covid 19</label>
                                                            <br>
                                                            <input type="radio" name="yang_kontak" required value="Konfirmasi Covid 19" style="clear: none;width: auto;">
                                                            <label style="margin-left: 10px;clear: none;width: auto;">
                                                                Konfirmasi Covid 19 (Sudah melakukan PCR-Swab Dan Hasilnya Positif)
                                                            </label>
                                                            <br>
                                                            <input type="radio" name="yang_kontak" value="Probable Covid">
                                                            <label style="margin-left: 10px;">
                                                                Probable Covid (Dugaan terpapar Covid 19, tetapi tidak/belum ada hasil PCR-Swab)
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Hubungan Orang Tersebut Dengan Anda</label>
                                                            <br>
                                                            <input type="radio" name="hubungan" required value="Orang Tua Kandung" style="clear: none;width: auto;">                                                            
                                                            <label style="margin-left: 10px;clear: none;width: auto;">
                                                                Orang Tua Kandung
                                                            </label>
                                                            <br>
                                                            <input type="radio" name="hubungan" value="Mertua">
                                                            <label style="margin-left: 10px;">
                                                                Mertua
                                                            </label>
                                                            <br>
                                                            <input type="radio" name="hubungan" value="Istri/Suami">
                                                            <label style="margin-left: 10px;">
                                                                Istri/Suami
                                                            </label>
                                                            <br>
                                                            <input type="radio" name="hubungan" value="Anak">
                                                            <label style="margin-left: 10px;">
                                                                Anak
                                                            </label>
                                                            <br>
                                                            <input type="radio" name="hubungan" value="Kakak / Adik Kandung/Ipar">
                                                            <label style="margin-left: 10px;">
                                                                Kakak / Adik Kandung/Ipar
                                                            </label>
                                                            <br>
                                                            <input type="radio" name="hubungan" value="Saudara Tidak Kandung">
                                                            <label style="margin-left: 10px;">
                                                                Saudara Tidak Kandung
                                                            </label>
                                                            <br>
                                                            <input type="radio" name="hubungan" value="lainnya">
                                                            <label style="margin-left: 10px;">
                                                                Lainnya
                                                            </label>
                                                            <br>
                                                            <input style="display: none;" class="form-control" name="hubungan_lainnya" placeholder="Siapa?" required="" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Riwayat orang tersebut sampai terduga covid (riwayat kegiatan yang dilakukan) / terkonfirmasi positif (Alasan awal di tes dan kronologi sampai dilakukan tes) :</label>
                                                            <textarea
                                                            class="form-control"
                                                            id="txt-CVD-Prokes"
                                                            name="riwayat"
                                                            placeholder="Riwayat orang tersebut"
                                                            ></textarea>                                                        
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Gejala awal yang dialami :</label>
                                                            <br>
                                                            <input type="checkbox" name="gejala[]" value="Batuk">
                                                            <label style="margin-left: 10px;">
                                                                Batuk
                                                            </label>
                                                            <br>
                                                            <input type="checkbox" name="gejala[]" value="Pilek">
                                                            <label style="margin-left: 10px;">
                                                                Pilek
                                                            </label>
                                                            <br>
                                                            <input type="checkbox" name="gejala[]" value="Demam">
                                                            <label style="margin-left: 10px;">
                                                                Demam
                                                            </label>
                                                            <br>
                                                            <input type="checkbox" name="gejala[]" value="Sesak Nafas">
                                                            <label style="margin-left: 10px;">
                                                                Sesak Nafas
                                                            </label>
                                                            <br>
                                                            <input type="checkbox" name="gejala[]" value="Tidak Bergejala">
                                                            <label style="margin-left: 10px;">
                                                                Tidak Bergejala
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Tanggal sejak gejala Covid 19 Muncul :</label>
                                                            <input type="text" class="form-control cvd_drange" name="tgl_gejala" placeholder="masukan Tanggal" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Apakah ada Hasil Uji Covid 19 ?</label>
                                                            <br>
                                                            <input type="radio" name="hasil_uji" value="Ya" required="">
                                                            <label style="margin-left: 10px;">
                                                                Ya
                                                            </label>
                                                            <br>
                                                            <input type="radio" name="hasil_uji" value="Tidak">
                                                            <label style="margin-left: 10px;">
                                                                Tidak
                                                            </label>
                                                            <br>
                                                            <div class="col-md-12" style="padding: 0px; display: none;" id="cvd_divtest">
                                                                <div>
                                                                    <input type="checkbox" name="fantibody" value="1">
                                                                    <label for="usr">Rapid Antibody :</label> <br>
                                                                    <div class="col-md-4">
                                                                        <label for="usr">Tanggal Tes :</label> <br>
                                                                        <input type="text" class="form-control cvd_drange" name="tgl_tes_antibody" placeholder="Masukan Tanggal" required disabled="">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="usr">Tanggal Keluar Hasil :</label> <br>
                                                                        <input type="text" class="form-control cvd_drange" name="tgl_keluar_tes_antibody" placeholder="Masukan Tanggal" required disabled="">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="usr">Hasil :</label> <br>
                                                                        <input type="text" class="form-control" name="hasil_antibody" placeholder="Masukan Tanggal" required disabled="">
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="col-md-12" style="margin-top: 20px;"></div>
                                                                    <input type="checkbox" name="fantigen" value="1">
                                                                    <label for="usr">Rapid Antigen :</label> <br>
                                                                    <div class="col-md-4">
                                                                        <label for="usr">Tanggal Tes :</label> <br>
                                                                        <input type="text" class="form-control cvd_drange" name="tgl_tes_antigen" placeholder="Masukan Tanggal" required disabled="">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="usr">Tanggal Keluar Hasil :</label> <br>
                                                                        <input type="text" class="form-control cvd_drange" name="tgl_keluar_tes_antigen" placeholder="Masukan Tanggal" required disabled="">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="usr">Hasil :</label> <br>
                                                                        <input type="text" class="form-control" name="hasil_antigen" placeholder="Masukan Hasil" required disabled="">
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="col-md-12" style="margin-top: 20px;"></div>
                                                                    <input type="checkbox" name="fpcr" value="1">
                                                                    <label for="usr">PCR - Swab :</label> <br>
                                                                    <div class="col-md-4">
                                                                        <label for="usr">Tanggal Tes :</label> <br>
                                                                        <input type="text" class="form-control cvd_drange" name="tgl_tes_pcr" placeholder="Masukan Tanggal" required disabled="">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="usr">Tanggal Keluar Hasil :</label> <br>
                                                                        <input type="text" class="form-control cvd_drange" name="tgl_keluar_tes_pcr" placeholder="Masukan Tanggal" required disabled="">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="usr">Hasil :</label> <br>
                                                                        <input type="text" class="form-control" name="hasil_pcr" placeholder="Masukan Hasil" required disabled="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Anggota Keluarga yang tinggal serumah dengan anda dan Terduga/Terkonfirmasi Positif :</label>
                                                            <div class="col-md-12 nopadl">
                                                                <div class="col-md-4 nopadl">
                                                                <input type="checkbox" class="cvd_inboxjml" value="orangtua_kandung" name="anggota_keluarga[]">
                                                                    <label style="margin-left: 10px;">
                                                                        Orang Tua Kandung
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <label style="margin-top: 5px;">Jumlah</label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="number" min="0" class="form-control" name="jml_orangtua" placeholder="Masukan Jumlah" required disabled="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 nopadl">
                                                                <div class="col-md-4 nopadl">
                                                                <input type="checkbox" class="cvd_inboxjml" value="mertua" name="anggota_keluarga[]">
                                                                    <label style="margin-left: 10px;">
                                                                        Mertua
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <label style="margin-top: 5px;">Jumlah</label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="number" min="0" class="form-control" name="jml_mertua" placeholder="Masukan Jumlah" required disabled="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 nopadl">
                                                                <div class="col-md-4 nopadl">
                                                                <input type="checkbox" class="cvd_inboxjml" value="bojo" name="anggota_keluarga[]">
                                                                    <label style="margin-left: 10px;">
                                                                        Suami/Istri
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <label style="margin-top: 5px;">Jumlah</label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="number" min="0" class="form-control" name="jml_bojo" placeholder="Masukan Jumlah" required disabled="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 nopadl">
                                                                <div class="col-md-4 nopadl">
                                                                <input type="checkbox" class="cvd_inboxjml" value="anak" name="anggota_keluarga[]">
                                                                    <label style="margin-left: 10px;">
                                                                        Anak
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <label style="margin-top: 5px;">Jumlah</label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="number" min="0" class="form-control" name="jml_anak" placeholder="Masukan Jumlah" required disabled="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 nopadl">
                                                                <div class="col-md-4 nopadl">
                                                                <input type="checkbox" class="cvd_inboxjml" value="saudara_kandung" name="anggota_keluarga[]">
                                                                    <label style="margin-left: 10px;">
                                                                        Kakak/Adik Kandung/Ipar
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <label style="margin-top: 5px;">Jumlah</label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="number" min="0" class="form-control" name="jml_saudara_kandung" placeholder="Masukan Jumlah" required disabled="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 nopadl">
                                                                <div class="col-md-4 nopadl">
                                                                <input type="checkbox" class="cvd_inboxjml" value="saudara_tidak_kandung" name="anggota_keluarga[]">
                                                                    <label style="margin-left: 10px;">
                                                                        Saudara Tidak Kandung
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <label style="margin-top: 5px;">Jumlah</label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="number" min="0" class="form-control" name="jml_saudara_tidak_kandung" placeholder="Masukan Jumlah" required disabled="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 nopadl">
                                                                <div class="col-md-4 nopadl">
                                                                    <input type="checkbox" id="cvd_inboxjmllainya" name="anggota_keluarga[]" value="lainnya">
                                                                    <label style="margin-left: 10px;">
                                                                        Lainnya
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 nopadl" id="cvd_taanggotalainnya" style="display: none">
                                                                <textarea 
                                                                class="form-control txt-CVD-Prokes"
                                                                id=""
                                                                name="anggota_lainnya"
                                                                placeholder="Masukan Anggota Keluarga"
                                                                ></textarea>   
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Apakah sudah melapor ke Puskesmas Terdekat ?</label>
                                                            <br>
                                                            <input type="radio" name="lapor_puskesmas" value="Sudah" required="">
                                                            <label style="margin-left: 10px;">
                                                                Sudah
                                                            </label>
                                                            <br>
                                                            <input type="radio" name="lapor_puskesmas" value="Belum">
                                                            <label style="margin-left: 10px;">
                                                                Belum
                                                            </label>
                                                            <br>
                                                            <div style="display: none" id="cvd_divlappuskes">
                                                                <label>Arahan dari Puskesmas untuk :</label>
                                                                <br>
                                                                <label>a. Orang yang terduga/terkonfirmasi Covid 19</label>
                                                                <br>
                                                                <input type="text" class="form-control" placeholder="Masukan Arahan" disabled="" required="" name="arahan_terduga" />
                                                                <br>
                                                                <label>b. Orang yang tinggal serumah</label>
                                                                <br>
                                                                <input type="text" class="form-control" placeholder="Masukan Arahan" disabled="" required="" name="arahan_serumah" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Fasilitas yang dipakai bersama didalam rumah :</label>
                                                            <br>
                                                            <div class="col-md-12" style="padding: 0px;">
                                                                <table class="table table-bordered" id="cvd_tblfasilitas">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="text-align: center;" width="90%">Fasilitas</th>
                                                                            <th style="text-align: center;">
                                                                                <button class="btn btn-success btn-sm" type="button" id="cvd_btnaddfasilitas">
                                                                                    <i class="fa fa-plus"></i>
                                                                                </button>
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <input class="form-control" placeholder="Masukan Fasilitas" name="fasilitas[]" />
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <button class="btn btn-danger btn-sm cvd_btnrmfasilitas" type="button">
                                                                                    <i class="fa fa-minus"></i>
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Apakah sudah dilakukan dekontaminasi pada fasilitas yang digunakan bersama secara  rutin?</label>
                                                            <br>
                                                            <input type="radio" name="dekontaminasi" value="Sudah" required="">
                                                            <label style="margin-left: 10px;">
                                                                Sudah
                                                            </label>
                                                            <br>
                                                            <input type="radio" name="dekontaminasi" value="Belum">
                                                            <label style="margin-left: 10px;">
                                                                Belum
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Lampiran Gambar (Jika ada) :</label>
                                                            <div class="area-upload">
                                                                <table class="table table-bordered table-add-image-cvd" style="width:100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <td>File</td>
                                                                            <td style="text-align:center"> <button type="button" class="btn btn-sm btn-success" onclick="addimgcvd()" name="button"> <i class="fa fa-plus"></i> </button> </td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr row="1">
                                                                            <td>
                                                                                <input type="file" class="form-control" name="filesCVDLampiran[]" onchange="readFilePdf(this, 1)" style="margin-bottom:12px;">
                                                                                <center><img preview_cvd="1" src="" alt=""></center>
                                                                            </td>
                                                                            <td style="text-align:center">
                                                                                <button type="button" class="btn btn-sm btn-success" name="button" onclick="minimgcvd(1)"> <i class="fa fa-minus"></i> </button>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">Atasan</div>
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <select id="slc-CVD-MonitoringCovid-Tambah-Pekerja" name="slc-CVD-MonitoringCovid-Atasan" class="select2 select2Covid" style="width: 100%" data-placeholder="Pilih Atasan">
                                                                <option value=""></option>
                                                            </select>
                                                            <input type="hidden" id="txt-CVD-MonitoringCovid-Tambah-PekerjaId" name="txt-CVD-MonitoringCovid-AtasanId" value="<?php echo (isset($data) && !empty($data)) ? $data->cvd_pekerja_id : ''; ?>">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-center">
                                                <a href="<?= base_url('Covid/PelaporanPekerja/index') ?>" class="btn btn-warning">Kembali</a>
                                                <button name="source" value="satu_rumah" type="submit" class="btn btn-success">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php if ($this->session->result == 'berhasil'): ?>
    <script>
        window.addEventListener('load', function () {
            Swal.fire(
              'Berhasil Insert Data',
              ':D',
              'success'
              )
        });
      </script>
<?php endif ?>
<?php $this->session->unset_userdata('result'); ?>