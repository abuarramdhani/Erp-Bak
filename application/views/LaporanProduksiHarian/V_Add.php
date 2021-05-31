<style media="screen">
.modal {
text-align: center;
padding: 0!important;
}

.modal:before {
content: '';
display: inline-block;
height: 100%;
vertical-align: middle;
margin-right: -4px; /* Adjusts for spacing */
}

.modal-dialog {
display: inline-block;
text-align: left;
vertical-align: middle;
}
</style>
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">

        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary color-palette-box">
              <div class="panel-body">
                <input type="hidden" id="mon_agt_2021" value="1">
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs pull-right">
                    <!-- <li onclick="lphgetmon()"><a href="#lph-monitoring" data-toggle="tab">Monitoring</a></li> -->
                    <!-- <li class="active" onclick="agtMonJobRelease()"><a href="#lph-import" data-toggle="tab">Import</a></li> -->
                    <li class="pull-left header"><b class="fa fa-rocket"></b> Laporan Produksi Harian Operator </li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="lph-import">
                      <div class="row pt-3">
                        <div class="col-md-12">
                          <div class="row">
                            <!-- <div class="col-md-12">
                              <div class="alert bg-primary alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">
                                    <i class="fa fa-close"></i>
                                  </span>
                                </button>
                                <strong>Sekilas Info! </strong> Klik 2 kali jika hanya memilih 1 tanggal</strong>
                              </div>
                            </div> -->
                            <div class="col-md-4">
                              <label for="">Pilih Tanggal RKH</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="text" name="date" class="form-control LphTanggal lph_search_tanggal" onchange="lph_filter_shift(this)" placeholder="Select Yout Current Date" required="" >
                              </div>
                            </div>
                            <div class="col-md-3">
                              <label for="">Pilih Shift</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-fire"></i></div>
                                <select class="select2 lph_shift_dinamis" name="shift" style="width:100%">

                                </select>
                              </div>

                            </div>
                            <div class="col-md-3">
                              <label for="">Pekerja</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                <select class="select2 lphgetEmployee lph_search_pekerja" name="shift" style="width:100%">

                                </select>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <label for="" style="color:transparent">Ini Submit</label>
                              <button type="button" style="font-size:15px"  class="btn btn-primary btn-sm btn-block" onclick="lph_search_rkh()"> <i class="fa fa-book"></i> <strong>Submit</strong> </button>
                            </div>
                          </div>
                          <hr>
                        </div>
                        <div class="col-md-7">
                          <div class="box box-primary box-solid">
                            <div class="box-header" style="padding:5px !important">
                              <b>Seksi - Tanggal - Shift - Standar Waktu</b>
                            </div>
                            <div class="box-body">
                              <div class="row">
                                <div class="col-md-5">
                                  <div class="form-group">
                                    <label for="">Tanggal</label>
                                    <input type="text" class="form-control LphTanggal lph_tdl_add"  name="" value="">
                                  </div>
                                  <div class="form-group">
                                    <label for="">Shift</label>
                                    <select class="select2" name=""  style="width:100%">

                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="">Kelompok</label>
                                    <input type="text" class="form-control"  name="" value="">
                                  </div>
                                </div>
                                <div class="col-md-7">
                                  <table class="table no-border" style="width:100%;margin:0">
                                    <tr>
                                      <td style="width:65%">Waktu Kerja</td>
                                      <td style="width:25%;">: <span class="lph_waktu_kerja">..</span> </td>
                                      <td style="float:right">Menit</td>
                                    </tr>
                                    <tr>
                                      <td>Breafing Awal Kerja</td>
                                      <td>: <span class="lph_w_brefing_awal">5</span> </td>
                                      <td style="float:right">Menit</td>
                                    </tr>
                                    <tr>
                                      <td>Persiapan Kerja</td>
                                      <td>: <span class="lph_w_persiapan">5</span> </td>
                                      <td style="float:right">Menit</td>
                                    </tr>
                                    <tr>
                                      <td>Cleaning Akhir Job</td>
                                      <td>: <span class="lph_w_cleaning">12</span> </td>
                                      <td style="float:right">Menit</td>
                                    </tr>
                                    <tr>
                                      <td>Breafing Akhir Kerja</td>
                                      <td>: <span class="lph_w_brefing_akhir">3</span> </td>
                                      <td style="float:right">Menit</td>
                                    </tr>
                                    <tr style="border-bottom:1px solid black !important">
                                      <td>Lain-Lain</td>
                                      <td>: <span class="lph_w_ll">5</span> </td>
                                      <td style="float:right">Menit</td>
                                    </tr>
                                    <tr >
                                      <td> <b>Standar Waktu Efektif Seksi</b> </td>
                                      <td>: <span class="lph_w_standar_efk">..</span> </td>
                                      <td style="float:right">Menit</td>
                                    </tr>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-5">
                          <div class="box box-primary box-solid" style="height:305px">
                            <div class="box-header" style="padding:5px !important">
                              <b>Pengawas & Operator</b>
                            </div>
                            <div class="box-body" style="padding-top:60px">
                              <div class="form-group">
                                <label for="">Cari Pekerja</label>
                                <select class="lphgetEmployee" name=""  style="width:100%">

                                </select>
                              </div>
                              <div class="form-group">
                                <label for="">Cari Pengawas</label>
                                <select class="lphgetEmployee" name=""  style="width:100%">

                                </select>
                                <!-- <div class="row">
                                  <div class="col-sm-8">
                                  </div>
                                  <div class="col-sm-4">
                                    <button type="button" class="btn btn-primary" style="width:100%" name="button"> <i class="fa fa-download"></i> Tambah </button>
                                  </div>
                                </div> -->
                                <!-- <div class="mt-4" style="overflow-y:scroll;height:164px;">
                                  <table class="table" style="width:100%;">
                                    <thead class="bg-primary">
                                      <tr>
                                        <td style="width:30%">No. Induk</td>
                                        <td>Nama Pengawas</td>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                  </table>
                                </div> -->
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row pt-2">
                        <div class="col-md-6">
                          <div class="box box-primary box-solid">
                            <div class="box-header" style="padding:5px !important">
                              <b>Pengurangan Waktu Efektif</b>
                            </div>
                            <div class="box-body">
                              <div class="form-group">
                                <div class="row">
                                  <div class="col-sm-5">
                                    <label for="">Faktor</label>
                                    <input type="text" class="form-control"  name="" value="">
                                  </div>
                                  <div class="col-sm-7">
                                    <label for="">Menit</label>
                                    <div class="row">
                                      <div class="col-sm-7">
                                        <input type="text" class="form-control"  name="" value="">
                                      </div>
                                      <div class="col-sm-5">
                                        <button type="button" class="btn btn-primary" style="width:100%" name="button"> <i class="fa fa-download"></i> Tambah </button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="mt-4" style="overflow-y:scroll;height:164px;">
                                  <table class="table" style="width:100%;">
                                    <thead class="bg-primary">
                                      <tr>
                                        <td style="width:30%">Faktor</td>
                                        <td>Menit</td>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <!-- <tr>
                                        <td>t0012</td>
                                        <td>aldipradana</td>
                                      </tr> -->
                                    </tbody>
                                  </table>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="box box-primary box-solid" style="height:305px">
                            <div class="box-header" style="padding:5px !important">
                              <b>Operator Tanpa Target</b>
                            </div>
                            <div class="box-body" style="padding-top:37px">
                              <div class="form-group">
                                <label for="">Jenis</label>
                                <select class="select2" name=""  style="width:100%">
                                  <option value="OTT">OTT</option>
                                  <option value="IK">IK</option>
                                </select>
                               </div>
                               <div class="form-group">
                                 <label for="">Keterangan</label>
                                 <textarea name="name" class="form-control" rows="4" style="width:100%"></textarea>
                               </div>
                            </div>
                          </div>
                        </div>
                      </div>
                        <div class="row pt-2">
                          <div class="col-md-12">
                            <div class="box box-primary box-solid">
                              <div class="box-header" style="padding:5px !important">
                                <b>Hasil Produksi</b>
                              </div>
                              <div class="box-body">
                                <div class="row">
                                  <!-- <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="">Alat Bantu</label>
                                      <select class="select2" name="" style="width:100%">

                                      </select>
                                     </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="">Umur Pakai</label>
                                      <input type="text" readonly class="form-control"  name="" value="">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="">Toleransi</label>
                                      <input type="text" readonly class="form-control"  name="" value="">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="">Proses</label>
                                      <input type="text" readonly class="form-control"  name="" value="">
                                    </div>
                                  </div> -->
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="">Alat Bantu</label>
                                      <select class="select2" name="" style="width:100%">

                                      </select>
                                     </div>
                                     <div class="form-group">
                                       <label for="">Kode Part</label>
                                       <input type="text" class="form-control"  name="" value="">
                                     </div>
                                     <div class="form-group">
                                       <label for="">Nama Part</label>
                                       <input type="text" readonly class="form-control"  name="" value="">
                                     </div>
                                     <div class="form-group">
                                       <label for="">Kode Proses</label>
                                       <select class="select2" name="" style="width:100%">

                                       </select>
                                      </div>
                                      <div class="form-group">
                                        <label for="">Nama Proses</label>
                                        <input type="text" readonly class="form-control"  name="" value="">
                                       </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="">Umur Pakai</label>
                                      <input type="text" readonly class="form-control"  name="" value="">
                                    </div>
                                    <div class="form-group">
                                      <label for="">Toleransi</label>
                                      <input type="text" readonly class="form-control"  name="" value="">
                                    </div>
                                    <div class="form-group">
                                      <label for="">Proses</label>
                                      <input type="text" readonly class="form-control"  name="" value="">
                                    </div>
                                    <div class="form-group">
                                      <label for="">No Mesin</label>
                                      <div class="row">
                                        <div class="col-sm-7">
                                          <input type="text" class="form-control"  name="" value="">
                                        </div>
                                        <div class="col-sm-5">
                                          <input type="text" readonly class="form-control"  name="" value="">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label for="">Target PPIC</label>
                                      <input type="number" class="form-control"  name="" value="">
                                    </div>
                                  </div>
                                <div class="col-md-12">
                                  <hr>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                    <label for="">Target S-K</label>
                                    <input type="text" class="form-control" readonly  name="" value="">
                                  </div>
                                  <div class="form-group">
                                    <label for="">Target 100%</label>
                                    <input type="text" class="form-control" readonly  name="" value="">
                                  </div>
                                  <div class="form-group">
                                    <label for="">Aktual</label>
                                    <input type="text" class="form-control"  name="" value="">
                                  </div>
                                  <div class="form-group">
                                    <label for="">%tase</label>
                                    <input type="text" class="form-control" readonly  name="" value="">
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                    <label for="">Hasil Baik</label>
                                    <input type="text" class="form-control" readonly  name="" value="">
                                  </div>
                                  <div class="form-group">
                                    <label for="">Repair MAN</label>
                                    <input type="text" class="form-control"  name="" value="">
                                  </div>
                                  <div class="form-group">
                                    <label for="">Repair MAT</label>
                                    <input type="text" class="form-control"  name="" value="">
                                  </div>
                                  <div class="form-group">
                                    <label for="">Repair MACH</label>
                                    <input type="text" class="form-control"  name="" value="">
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group" style="margin-top:74px">
                                    <label for="">Scrap MAN</label>
                                    <input type="text" class="form-control"  name="" value="">
                                  </div>
                                  <div class="form-group">
                                    <label for="">Scrap MAT</label>
                                    <input type="text" class="form-control"  name="" value="">
                                  </div>
                                  <div class="form-group">
                                    <label for="">Scrap MACH</label>
                                    <input type="text" class="form-control"  name="" value="">
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="mt-4" style="overflow:scroll;height:204px;">
                                    <table class="table" style="width:1200px;">
                                      <thead class="bg-primary">
                                        <tr>
                                          <td style="width:120px">Kode Part</td>
                                          <td>Nama Part</td>
                                          <td>Kode Proses</td>
                                          <td>Nama Proses</td>
                                          <td>Target PE</td>
                                          <td>100%</td>
                                          <td>AKT.</td>
                                          <td>%TASE</td>
                                          <td>Hasil Baik</td>
                                          <td>Repair Man</td>
                                          <td>Repair Mat</td>
                                          <td>Repair Mach</td>
                                          <td>Scrap Man</td>
                                          <td>Scrap Mat</td>
                                          <td>Scrap Mach</td>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <!-- <tr>
                                          <td>t0012</td>
                                          <td>aldipradana</td>
                                        </tr> -->
                                      </tbody>
                                    </table>
                                  </div>
                                  <table style="width:60%;margin-top:20px;margin-bottom: 20px;float:right">
                                    <tr>
                                      <td style="width:70px"> <b>Total</b> </td>
                                      <td>:</td>
                                      <td><center><input type="text" class="form-control" readonly style="width:80%" name="" value=""></center> </td>
                                      <td style="width:70px"> <b>Kurang</b> </td>
                                      <td>:</td>
                                      <td><center><input type="text" class="form-control" readonly style="width:80%" name="" value=""></center> </td>
                                    </tr>
                                  </table>
                                </div>
                              </div>

                                </div>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <center> <button type="button" class="btn btn-success mb-4 mt-2" name="button" style="width:20%;font-weight:bold"> <i class="fa fa-save"></i> Save</button> </center>
                            </div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>


              </div>


            </div>
          </div>
        </div>


      </div>
    </div>
  </div>
</section>

<!-- 210515171 -->
