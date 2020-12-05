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
                                Input Data Laporan Pekerja Menghadiri Acara
                            </div>
                            <div class="panel-body">
                              <div class="row">
                                  <form method="post" action="<?php echo base_url('ManufacturingOperationUP2L/InputMasterItem/insertMasIt')?>">
                                      <div class="col-md-12">
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
                                                      <label for="usr">Jenis acara yang dihadiri :</label>
                                                      <input type="text" class="form-control" name="Jenis Acara" placeholder="Jenis Acara" required>
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="usr">Jumlah Tamu yang Datang :</label>
                                                      <input type="number" class="form-control" name="Jumlah Tamu" placeholder="Jumlah Tamu" required>
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
                                                      <input type="number" class="form-control" name="Kapasitas Tempat" placeholder="Kapasitas Tempat" required>
                                                  </div>
                                                  <div class="form-group">
                            												<label for="usr">Lampiran Foto Pelaksanaan Acara :</label>
                            													<div class="div-CVD-MonitoringCovid-Tambah-Lampiran" style="margin-bottom: 5px;margin-top: 5px;">
                            														<?php
                            														if (isset($lampiran) && !empty($lampiran)) {
                            															foreach ($lampiran as $key_lamp => $val_lamp) {
                            																?>
                            																<a target="_blank" href="<?php echo base_url($val_lamp['lampiran_path']) ?>"  class="label label-info" style="margin: 5px;"><?php echo $val_lamp['lampiran_nama'] ?></a>
                            																<?php
                            															}
                            														}
                            														?>
                            														<input type="file" class="form-control file-CVD-MonitoringCovid-Tambah-Lampiran" name="file-CVD-MonitoringCovid-Tambah-Lampiran[]" style="display: none;">
                            													</div>
                            													<button class="btn btn-success btn-CVD-MonitoringCovid-Tambah-Lampiran" type="button"><span class="fa fa-upload"></span> Tambah Lampiran</button>
                            											</div>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-md-12">
                                          <div class="panel panel-default">
                                              <div class="panel-heading">Approver</div>
                                              <div class="panel-body">
                                                <div class="form-group">
                                                    <label for="usr">Atasan : </label>
                                                    <!-- <input type="number" class="form-control" name="tSK" placeholder="Target Senin-Kamis" required> -->
                                                      <select id="slc-CVD-MonitoringCovid-Tambah-Pekerja" name="slc-CVD-MonitoringCovid-Tambah-Pekerja" class="select2 select2Covid" style="width: 100%" data-placeholder="Pilih Atasan">
                                                          <option value=""></option>
                                                      </select>
                                                      <input type="hidden" id="txt-CVD-MonitoringCovid-Tambah-PekerjaId" name="txt-CVD-MonitoringCovid-Tambah-PekerjaId" value="<?php echo (isset($data) && !empty($data)) ? $data->cvd_pekerja_id : ''; ?>">

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
