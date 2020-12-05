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
                                     Luar Kota - Anggota Keluarga Serumah
                                </div>
                                <div class="panel-body">
                                  <div class="row">
                                        <form method="post" action="<?php echo base_url('Covid/MonitoringCovid/insertAnggotaKeluarga')?>" enctype="multipart/form-data">
                                            <div class="col-md-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">Biodata</div>
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <label for="usr">Pekerja</label>
                                                            <select id="slc-CVD-MonitoringCovid-Tambah-Pekerja" name="slc-CVD-MonitoringCovid-Tambah-Pekerja" style="width: 100%" data-placeholder="Pilih Pekerja">
                                                                <?php
                                                                if (isset($data) && !empty($data)) {
                                                                    ?>
                                                                    <option value="<?php echo $data->noind ?>"><?php echo $data->noind." - ".$data->nama ?></option>
                                                                    <?php
                                                                }
                                                                ?>
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
                                                            <label for="usr">Status Anggota Keluarga Serumah yang Keluar Kota (Bisa diisi lebih dari 1) :</label>
                                                            <input type="text" class="form-control" name="Status_anggota" placeholder="Status Anggota Keluarga" required>
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
                                                            <label for="usr">Wilayah yang dikunjungi (kabupaten/provinsi) :</label>
                                                            <input type="text" class="form-control" name="Wilayah" placeholder="Kabupaten / Provinsi" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Transportasi yang digunakan (spesifik kalau kendaraan umum):</label>
                                                            <input type="text" class="form-control" name="Transportasi" placeholder="Transportasi" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Yang ikut keluar kota :</label>
                                                            <input type="text" class="form-control" name="Anggota" placeholder="Yang Ikut" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Tujuan / Alasan Keluar Kota :</label>
                                                            <input type="text" class="form-control" name="Tujuan Alasan" placeholder="Tujuan / Alasan" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Aktifitas selama di luar kota :</label>
                                                            <textarea
                                                            class="form-control"
                                                            id="txt-CVD-Aktifitas"
                                                            name="txt-CVD-Aktifitas"
                                                            placeholder="Aktifitas"
                                                            ></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Protokol Kesehatan yang Dilakukan :</label>
                                                            <textarea
                                                            class="form-control"
                                                            id="txt-CVD-Prokes"
                                                            name="txt-CVD-Prokes"
                                                            placeholder="Protokol Kesehatan"
                                                            ></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Menginap / Tidak :</label>
                                                            &nbsp; &nbsp;&nbsp;
                                                            <input type="radio" name="covid_menginap" value="1"> <label for="" class="control-label">&nbsp;&nbsp;Ya </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" name="covid_menginap" value="0"><label for="" class="control-label">&nbsp;&nbsp; Tidak </label>
                                                        </div>
                                                        <div class="form-group covid_show_menginap" style="display:none">
                                                            <label for="">Jumlah Hari</label>
                                                            <input type="number" name="nbr-jumlah-hari" value=""class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Lampiran Foto Pelaksanaan Acara :</label>
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
                                                    <div class="panel-heading">Riwayat Kesehatan</div>
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <label for="usr">Apakah anggota keluarga yang berpergian dan atau orang yang dikunjungi mengalami sakit ? </label>
                                                            &nbsp; &nbsp;&nbsp;
                                                            <input type="radio" name="covid_sakit" value="1"> <label for="" class="control-label">&nbsp;&nbsp;Ya </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" name="covid_sakit" value="0"><label for="" class="control-label">&nbsp;&nbsp; Tidak </label>
                                                        </div>
                                                        <div class="form-group covid_show_sakit" style="display:none">
                                                            <label for="">Keterangan Penyakit (Siapa Yang Sakit / Sakit Apa / Sudahkah Periksa ke Dokter / Hasil Diagnosa / Ada Tes (PCR/Rapid) / Hasil Tes) : </label>
                                                            <textarea
                                                            class="form-control"
                                                            id="txt-CVD-Penyakit"
                                                            name="txt-CVD-Penyakit"
                                                            placeholder="Keterangan Penyakit"
                                                            ></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Apakah anggota keluarga yang berpergian mengalami sakit setelah kembali ? </label>
                                                            &nbsp; &nbsp;&nbsp;
                                                            <input type="radio" name="covid_sakit_kembali" value="1"> <label for="" class="control-label">&nbsp;&nbsp;Ya </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" name="covid_sakit_kembali" value="0"><label for="" class="control-label">&nbsp;&nbsp; Tidak </label>
                                                        </div>
                                                        <div class="form-group covid_show_sakit_kembali" style="display:none">
                                                            <label for="">Keterangan Penyakit (Siapa Yang Sakit / Sakit Apa / Sudahkah Periksa ke Dokter / Hasil Diagnosa / Ada Tes (PCR/Rapid) / Hasil Tes) : </label>
                                                            <textarea
                                                            class="form-control"
                                                            id="txt-CVD-Penyakit_kembali"
                                                            name="txt-CVD-Penyakit_kembali"
                                                            placeholder="Keterangan Penyakit"
                                                            ></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">14 Hari Terakhir ada Interaksi Dengan Probable Covid :</label>
                                                            &nbsp; &nbsp;&nbsp;
                                                            <input type="radio" name="covid_interaksi" value="1"> <label for="" class="control-label">&nbsp;&nbsp;Ya </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" name="covid_interaksi" value="0"><label for="" class="control-label">&nbsp;&nbsp; Tidak </label>
                                                        </div>
                                                        <div class="form-group covid_show_interaksi" style="display:none">
                                                            <label for="">Jenis Interaksi (Bisa Lebih dari Satu)</label>
                                                            <textarea
                                                            class="form-control"
                                                            id="txt-CVD-Jenis_interaksi"
                                                            name="txt-CVD-Jenis_interaksi"
                                                            placeholder="Ngobrol/Salaman/Bersentuhan/Lain-Lain"
                                                            ></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">Approver</div>
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <label for="usr">Atasan</label>
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
                                                <button name="source" value="anggota_keluarga" type="submit" class="btn btn-success">Submit</button>
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