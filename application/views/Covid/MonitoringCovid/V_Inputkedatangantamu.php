
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1>
                                    <b>
                                        Input Data Laporan Pekerja
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/InputMasterItem');?>">
                                    <i aria-hidden="true" class="fa fa-line-chart fa-2x">
                                    </i>
                                    <span>
                                        <br/>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                Input Data Laporan Pekerja Kedatangan Tamu Luar Kota
                            </div>
                            <div class="panel-body">
                              <div class="row">
                                  <form method="post" action="<?php echo base_url('Covid/MonitoringCovid/insertKedatanganTamu')?>">
                                      <div class="col-md-12">
                                        <?php echo $this->session->flashdata('status_insert_cvd'); ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Biodata</div>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label for="usr">Pekerja</label>
                                                    <!-- <input type="number" class="form-control" name="tSK" placeholder="Target Senin-Kamis" required> -->

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
                                                      <label for="usr">Wilayah asal tamu/keluarga :</label>
                                                      <input type="text" class="form-control" name="Wilayah" placeholder="Kabupaten / Provinsi" required>
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="usr">Transportasi yang digunakan (spesifik kalau kendaraan umum):</label>
                                                      <input type="text" class="form-control" name="Transportasi" placeholder="Transportasi" required>
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="usr">Jumlah tamu yang datang :</label>
                                                      <input type="number" class="form-control" name="Jumlah_tamu" placeholder="Jumlah Tamu" required>
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="usr">Tujuan / Alasan kedatangan tamu :</label>
                                                      <input type="text" class="form-control" name="Tujuan Alasan" placeholder="Tujuan / Alasan" required>
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="usr">Aktifitas selama kedatangan tamu :</label>
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
                                                      <label for="">Jumlah Malam</label>
                                                      <input type="number" name="nbr-jumlah-hari" value=""class="form-control">
                                                    </div>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-md-12">
                                          <div class="panel panel-default">
                                              <div class="panel-heading">Riwayat Kesehatan</div>
                                              <div class="panel-body">
                                                  <div class="form-group">
                                                      <label for="usr">Apakah tamu yang datang ada yang sakit ? </label>
                                                      &nbsp; &nbsp;&nbsp;
                                                      <input type="radio" name="covid_sakit" value="1"> <label for="" class="control-label">&nbsp;&nbsp;Ya </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                      <input type="radio" name="covid_sakit" value="0"><label for="" class="control-label">&nbsp;&nbsp; Tidak </label>
                                                  </div>
                                                  <div class="form-group covid_show_sakit" style="display:none">
                                                    <label for="">Keterangan Penyakit (Sakit Apa / Sudahkah Periksa ke Dokter / Hasil Diagnosa / Ada Tes (PCR/Rapid) / Hasil Tes) : </label>
                                                    <textarea
                                                      class="form-control"
                                                      id="txt-CVD-Penyakit"
                                                      name="txt-CVD-Penyakit"
                                                      placeholder="Keterangan Penyakit"
                                                      ></textarea>
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="usr">Tamu Yang Datang Dalam 14 Hari Terakhir ada Interaksi Dengan Probable Covid :</label>
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
                                                    <!-- <input type="text" name="" value=""class="form-control"placeholder="Ngobrol/Salaman/Bersentuhan/Lain-Lain"> -->
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
                                                    <!-- <input type="number" class="form-control" name="tSK" placeholder="Target Senin-Kamis" required> -->
                                                      <select id="slc-CVD-MonitoringCovid-Tambah-Pekerja" name="slc-CVD-MonitoringCovid-Atasan" class="select2 select2Covid" style="width: 100%" data-placeholder="Pilih Atasan">
                                                          <option value=""></option>
                                                      </select>
                                                      <input type="hidden" id="txt-CVD-MonitoringCovid-Tambah-PekerjaId" name="txt-CVD-MonitoringCovid-AtasanId" value="<?php echo (isset($data) && !empty($data)) ? $data->cvd_pekerja_id : ''; ?>">

                                                </div>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-md-12">
                                        <button type="submit" class="btn btn-default" style="float:right" >Submit</button>
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
