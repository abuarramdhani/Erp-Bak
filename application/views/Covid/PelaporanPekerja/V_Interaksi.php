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
                                     Interaksi dengan Orang Yang Habis Berinteraksi dengan Terduga / Terkonfirmasi Covid 19
                                </div>
                                <div class="panel-body">
                                  <div class="row">
                                      <form method="post" action="<?php echo base_url('Covid/MonitoringCovid/insertProblaby')?>" enctype="multipart/form-data">
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
                                                            <label for="usr">Keterangan :</label>
                                                            <input
                                                            class="form-control"
                                                            name="txt-CVD-MonitoringCovid-Tambah-Keterangan"
                                                            placeholder="Keterangan"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">Keterangan</div>
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <label for="usr">Yang kontak dengan Orang Tersebut</label>
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
                                                            <input type="radio" name="hubungan_relasi" required value="Saudara" style="clear: none;width: auto;">                                                            
                                                            <label style="margin-left: 10px;clear: none;width: auto;">
                                                                Saudara
                                                            </label>
                                                            <br>
                                                            <input type="radio" name="hubungan_relasi" value="Tetangga Dalam 1 RT">
                                                            <label style="margin-left: 10px;">
                                                                Tetangga Dalam 1 RT
                                                            </label>
                                                            <br>
                                                            <input type="radio" name="hubungan_relasi" value="Tetangga Dalam 1 Dusun / Desa">
                                                            <label style="margin-left: 10px;">
                                                                Tetangga Dalam 1 Dusun / Desa
                                                            </label>
                                                            <br>
                                                            <input type="radio" name="hubungan_relasi" value="Teman / Relasi">
                                                            <label style="margin-left: 10px;">
                                                                Teman / Relasi
                                                            </label>
                                                            <br>
                                                            <input type="radio" name="hubungan_relasi" value="lainnya">
                                                            <label style="margin-left: 10px;">
                                                                Lainnya
                                                            </label>
                                                            <br>
                                                            <input style="display: none;" class="form-control" name="lainnya" placeholder="Siapa?" required="" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Jenis interaksi dengan orang yang berinteraksi dengan orang terduga/terkonfirmasi Covid 19 :</label>
                                                            <input type="text" class="form-control" name="jenis_interaksi" placeholder="Jenis Interaksi" required>                                                        
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Intensitas interaksi dengan orang yang berinteraksi dengan orang terduga/terkonfirmasi Covid 19 tersebut :</label>
                                                            <input type="text" class="form-control" name="intensitas" placeholder="(Contoh : Sehari 2 kali ketemu dan ngobrol)" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Durasi interaksi dengan orang yang berinteraksi dengan orang terduga/terkonfirmasi Covid 19 tersebut :</label>
                                                            <input type="text" class="form-control" name="durasi" placeholder="Durasi Interaksi" required>                                                        
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Protokol kesehatan yang diterapkan saat interaksi dengan orang yang berinteraksi dengan orang terduga/terkonfirmasi Covid 19 tersebut :</label>
                                                            <textarea
                                                            class="form-control"
                                                            id="txt-CVD-Prokes"
                                                            name="protokol"
                                                            placeholder="Protokol Kesehatan"
                                                            ></textarea>                                                      
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Ada arahan dari lingkungan sekitar (RT/RW/Dukuh)?</label>
                                                            &nbsp; &nbsp;&nbsp;
                                                            <input type="radio" class="cvd_arahanprob" name="arahan" value="1"> <label for="" class="control-label" required>&nbsp;&nbsp;Ya </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" class="cvd_arahanprob" name="arahan" value="0"><label for="" class="control-label">&nbsp;&nbsp; Tidak </label>
                                                            <div id="cvd_arahan123" style="display: none;">
                                                                <textarea 
                                                                class="form-control txt-CVD-Prokes"
                                                                id=""
                                                                name="arahan_deskripsi"
                                                                placeholder="Masukan Arahan"
                                                                ></textarea>   
                                                            </div>
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
                                                        <div class="form-group">
                                                            <label for="usr">Keterangan Tambahan:</label>
                                                            <textarea
                                                            class="form-control txt-CVD-Prokes"
                                                            name="Keterangan_Tambahan"
                                                            placeholder="Keterangan Tambahan"
                                                            ></textarea>
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
                                                <button name="source" value="problaby" type="submit" class="btn btn-success">Submit</button>
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