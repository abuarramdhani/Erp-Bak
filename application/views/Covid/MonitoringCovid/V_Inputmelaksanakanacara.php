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
                                Input Data Laporan Pekerja Melaksanakan Acara
                            </div>
                            <div class="panel-body">
                              <div class="row">
                                  <form method="post" action="<?php echo base_url('Covid/MonitoringCovid/insertMelaksanakanAcara')?>"  enctype="multipart/form-data">
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
                                                      <label for="usr">Jenis acara yang diselenggarakan :</label>
                                                      <input type="text" class="form-control" name="Jenis_acara" placeholder="Jenis Acara" required>
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="usr">Jumlah Tamu yang Datang :</label>
                                                      <input type="number" class="form-control" name="Jumlah_tamu" placeholder="Jumlah Tamu" required>
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="usr">Apakah ada tamu yang datang dari luar kota ? </label>
                                                      &nbsp; &nbsp;&nbsp;
                                                      <input type="radio" name="covid_tamu_luar" value="1"> <label for="" class="control-label">&nbsp;&nbsp;Ya </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                      <input type="radio" name="covid_tamu_luar" value="0"><label for="" class="control-label">&nbsp;&nbsp; Tidak </label>
                                                  </div>
                                                  <div class="form-group covid_show_tamu_luar" style="display:none">
                                                    <label for="">Tamu Berasal Dari Mana Saja : </label>
                                                    <textarea
                                                      class="form-control"
                                                      id="txt-CVD-Tamu-Luar"
                                                      name="txt-CVD-Tamu-Luar"
                                                      placeholder="Asal Tamu Dari Luar Kota"
                                                      ></textarea>
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="usr">Waktu dan Run Down Acara :</label>
                                                      <textarea
                                                        class="form-control"
                                                        id="txt-CVD-MonitoringCovid-Run-Down"
                                                        name="txt-CVD-MonitoringCovid-Run-Down"
                                                        placeholder="Waktu & Run Down Acara"
                                                        ></textarea>
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="usr">Protokol Kesehatan Selama Acara :</label>
                                                      <textarea
                            														class="form-control"
                            														id="txt-CVD-Prokes"
                            														name="txt-CVD-Prokes"
                            														placeholder="Protokol Kesehatan"
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
                            												<label for="usr">Lampiran Foto Pelaksanaan Acara :</label>
                            													<!-- <div class="div-CVD-MonitoringCovid-Tambah-Lampiran" style="margin-bottom: 5px;margin-top: 5px;">
                            																<a target="_blank" href=""  class="label label-info" style="margin: 5px;"</a>
                            														<input type="file" class="form-control file-CVD-MonitoringCovid-Tambah-Lampiran" name="file-CVD-MonitoringCovid-Tambah-Lampiran" style="display: none;">
                            													</div>
                            													<button class="btn btn-success btn-CVD-MonitoringCovid-Tambah-Lampiran" type="button"><span class="fa fa-upload"></span> Tambah Lampiran</button> -->
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
