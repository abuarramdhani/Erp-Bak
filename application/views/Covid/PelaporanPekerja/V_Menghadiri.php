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
                                    Acara Melibatkan Banyak Orang - Menghadiri Acara
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                         <form id="cvd_frmsbmtcvd" method="post" action="<?php echo base_url('Covid/MonitoringCovid/insertMenghadiriAcara')?>" enctype="multipart/form-data">
                                            <div class="col-md-12">
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
                                                            <label for="usr">Jenis acara yang dihadiri :</label>
                                                            <input type="text" class="form-control" name="Jenis_acara" placeholder="Jenis Acara" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Jumlah Tamu yang Datang :</label>
                                                            <input type="number" class="form-control" name="Jumlah_tamu" placeholder="Jumlah Tamu" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Apakah ada interaksi dengan orang dari luar kota ? </label>
                                                            &nbsp; &nbsp;&nbsp;
                                                            <input type="radio" name="covid_orang_luar" value="1"> <label for="" class="control-label">&nbsp;&nbsp;Ya </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" name="covid_orang_luar" value="0"><label for="" class="control-label">&nbsp;&nbsp; Tidak </label>
                                                        </div>
                                                        <div class="form-group covid_show_orang_luar" style="display:none">
                                                            <label for="">Orang Berasal Dari Mana Saja : </label>
                                                            <textarea
                                                            class="form-control"
                                                            id="txt-CVD-Orang-Luar"
                                                            name="txt-CVD-Orang-Luar"
                                                            placeholder="Asal Orang Dari Luar Kota"
                                                            ></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Aktifitas Selama Acara :</label>
                                                            <textarea
                                                            class="form-control"
                                                            id="txt-CVD-MonitoringCovid-Aktifitas-Acara"
                                                            name="txt-CVD-MonitoringCovid-Aktifitas-Acara"
                                                            placeholder="Aktifitas Selama Acara"
                                                            ></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Protokol Kesehatan Penyelenggara Acara :</label>
                                                            <textarea
                                                            class="form-control"
                                                            id="txt-CVD-Prokes-Penyelenggara"
                                                            name="txt-CVD-Prokes-Penyelenggara"
                                                            placeholder="Protokol Kesehatan Penyelenggara"
                                                            ></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Protokol Kesehatan Pekerja Saat Menghadiri Acara :</label>
                                                            <textarea
                                                            class="form-control"
                                                            id="txt-CVD-Prokes-Pekerja"
                                                            name="txt-CVD-Prokes-Pekerja"
                                                            placeholder="Protokol Kesehatan Pekerja"
                                                            ></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Lokasi Pelaksanaan Acara :</label>
                                                            &nbsp; &nbsp;&nbsp;
                                                            <input type="radio" name="covid_lokasi_acara" value="1"> <label for="" class="control-label">&nbsp;&nbsp;Indoor </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" name="covid_lokasi_acara" value="0"><label for="" class="control-label">&nbsp;&nbsp; Outdoor </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Kapasitas Tempat Acara :</label>
                                                            <input type="number" class="form-control" name="Kapasitas_tempat" placeholder="Kapasitas Tempat" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="usr">Lampiran Foto :</label>
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
                                                                                <input type="file" class="form-control" name="filesCVDLampiran[]" onchange="readFilePdf(this, 1)" multiple="multiple" style="margin-bottom:12px;">
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
                                                <button type="submit" name="source" value="menghadiri_acara" class="btn btn-success">Submit</button>
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
              'Berhasil Menyimpan Data',
              'Data Anda telah tersimpan dan otomatis terkirim ke Tim Covid CV. KHS.',
              'success'
              )
        });
      </script>
<?php endif ?>
<?php $this->session->unset_userdata('result'); ?>