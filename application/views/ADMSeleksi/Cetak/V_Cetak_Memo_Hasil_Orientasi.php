<style>
  .form-inline .form-control {
    width: 300px;
  }

  .lbl {
    width: 65px;
  }

  .lbl2 {
    width: 100px;
  }

  .mt-5 {
    margin-top: 5px;
  }

  .mt-15 {
    margin-top: 15px;
  }

  .mt-10 {
    margin-top: 10px;
  }

  .ml-10 {
    margin-left: 10px;
  }

  .ml-15 {
    margin-left: 15px;
  }

  .ml-20 {
    margin-left: 20px;
  }

  .ml-5 {
    margin-left: 5px;
  }

  .mr-5 {
    margin-right: 5px;
  }

  .mb-10 {
    margin-bottom: 10px;
  }

  #box1 {
    height: 25px;
    width: 25px;
    background: #000000;
  }

  #box2 {
    height: 25px;
    width: 25px;
    background: #0000ff;
  }

  #box3 {
    height: 25px;
    width: 25px;
    background: #008000;
  }

  table#tb4.dataTable tbody tr:hover {
    background-color: #ffaa;
    cursor: pointer;
  }

  th {
    text-align: center !important;
    vertical-align: initial !important;
  }

  .no-pointer {
    pointer-events: none;
  }

  /* .tb1 th {
        position: relative;
        min-height: 41px;
    }

    .tb1 th span {
        display: block;
        position: absolute;
        left: 0;
        right: 0;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    } */

  .freeze {
    position: absolute;
  }
</style>

<section class="content">

  <div class="panel-group col-md-12">

    <div class="panel panel-primary">

      <div class="panel-heading">
        <h4>Cetak Memo Hasil Nilai Orientasi</h4>
      </div>

      <div class="panel-body">
        <div class="col-md-12">

          <div class="from-group mb-10 ml-15">
            <button type="button" data-toggle="modal" data-target=".myModal" class="btn btn-success">Pencarian</button>
            <!-- <button class="btn btn-primary"> <a href="#ShowDaftarNilai">Tambah</a></button> -->
            <!-- <button class="btn btn-warning">Ubah</button>
                        <button class="btn btn-danger">Hapus</button> -->
            <button class="btn btn-primary" id="pdf">Export PDF</button>
            <br>
            <span style="color: red;">*Cari data terlebih dahulu</span>
          </div>
          <form class="col-md-6">
            <div class="form-group form-inline">
              <label class="lbl2">No surat</label>
              <input id="inp-no-surat" type="text" class="no-pointer" require>
            </div>

            <div class="form-group form-inline">
              <label class="lbl2">Hal surat</label>
              <select id="slc-hal-surat" class="form-control no-pointer" style="width: auto;">
                <!-- <option>Hasil Nilai Orientasi</option>
                                <option>Hasil Nilai Orientasi Non Staff</option> -->
              </select>
            </div>

            <div class="form-inline">
              <label class="lbl2">Tanggal surat</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control no-pointer" id="datepicker">
              </div>
            </div>

            <div class="form-inline mt-15">
              <label class="lbl2">Periode test</label>
              <input id="inp-periode-test" type="text" class="form-control no-pointer" value="" require>
            </div>
          </form>

          <form class="col-md-6">
            <label>Pengirim surat :</label>
            <div class="form-group form-inline no-pointer">
              <label class="lbl2">Nama</label>
              <select class="form-control select2 no-pointer" style="width: 300px;" id="slc-nama-pengirim" placeholder="-">
              </select>
            </div>

            <div class="form-group form-inline">
              <label class="lbl2">Jabatan</label>
              <input id="inp-jabatan-pengirim" type="text" class="form-control no-pointer" value="" require>
            </div>

            <div class="form-group form-inline">
              <label class="lbl2">Seksi/uni/dept</label>
              <input id="inp-seksi-pengirim" type="text" class="form-control no-pointer" value="" require>
            </div>
          </form>

        </div>

        <div class="col-md-12 mt-15">
          <form class="col-md-6">
            <label>Tujuan Surat :</label>
            <div class="form-group form-inline no-pointer">
              <label class="lbl2">Nama</label>
              <select id="slc-gender-tujuan" class="form-control no-pointer" style="width: auto;">
                <!-- <option>Bapak</option>
                                <option>Ibu</option> -->
              </select>
              <select id="slc-nama-tujuan" class="form-control select2 no-pointer" style="width: 187px;">
                <!-- <option>Rayhan</option>
                                <option>Rayhan Aswiansyah</option> -->
              </select>
            </div>

            <div class="form-group form-inline">
              <label class="lbl2">Jabatan</label>
              <input id="inp-jabatan-tujuan" type="text" class="form-control no-pointer" value="" require>
            </div>

            <div class="form-inline">
              <label class="lbl2 ">Seksi/unit/dept</label>
              <input id="inp-seksi-tujuan" type="text" class="form-control no-pointer" value="" require>
            </div>
          </form>
          <form class="col-md-6">
            <label>Tembusan Surat :</label>
            <div class="form-group form-inline">
              <label class="lbl2">Tembusan 1</label>
              <input id="inp-tembusan1" type="text" class="form-control no-pointer" value="" require>
            </div>

            <div class="form-group form-inline">
              <label class="lbl2">Tembusan 2</label>
              <input id="inp-tembusan2" type="text" class="form-control no-pointer" value="" require>
            </div>

            <div class="form-group form-inline">
              <label class="lbl2">Tembusan 3</label>
              <input id="inp-tembusan3" type="text" class="form-control no-pointer" value="" require>
            </div>

            <div class="form-group form-inline">
              <label class="lbl2">Tembusan 4</label>
              <input id="inp-tembusan4" type="text" class="form-control no-pointer" value="" require>
            </div>

            <div class="form-group form-inline">
              <label class="lbl2">Tembusan 5</label>
              <input id="inp-tembusan5" type="text" class="form-control no-pointer" value="" require>
            </div>
          </form>

          <div class="form-group col-md-6 menu2 mb-10" style="text-align: right; display: none;">
            <button class="btn btn-success" disabled>Simpan</button>
            <button class="btn btn-warning" disabled>Batal</button>
            <button class="btn btn-primary" disabled>Tambah Peseta</button>
            <button class="btn btn-danger" disabled>Hapus</button>
            <button class="btn btn-danger" disabled>Kosongkan</button>
          </div>

          <section class="content">
            <div class="row">
              <div class="col-xs-12">
                <div class="box">
                  <div class="box-body">
                    <div class="table-responsive" style="overflow-x: auto;">
                      <table id="tb1" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Nama</th>
                            <th rowspan="2">No induk</th>
                            <th rowspan="2">Seksi</th>
                            <th colspan="16">Nilai</th>
                          </tr>
                          <tr>
                            <th id="cv"> </th>
                            <th id="cp"> </th>
                            <th id="ap"> </th>
                            <th id="nb"> </th>
                            <th id="sf"> </th>
                            <th id="s5"> </th>
                            <th id="hdl"> </th>
                            <th id="bgab"> </th>
                            <th id="bcc1"> </th>
                            <th id="cc1"> </th>
                            <th id="cc2"> </th>
                            <th id="bcm1"> </th>
                            <th id="bcm2"> </th>
                            <th id="cm1"> </th>
                            <th id="cm2"> </th>
                            <th id="abu"> </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $i = 1;
                          foreach ($getDaftarNilai as $dataNilai) : ?>
                            <tr>
                              <td><?= $i++ ?></td>
                              <td><?= $dataNilai['nama'] ?></td>
                              <td><?= $dataNilai['noind'] ?></td>
                              <td><?= $dataNilai['seksi'] ?></td>
                              <td><?= $dataNilai['cv'] ?></td>
                              <td><?= $dataNilai['cp'] ?></td>
                              <td><?= $dataNilai['ap'] ?></td>
                              <td><?= $dataNilai['nb'] ?></td>
                              <td><?= $dataNilai['sf'] ?></td>
                              <td><?= $dataNilai['s5'] ?></td>
                              <td><?= $dataNilai['hdl'] ?></td>
                              <td><?= $dataNilai['bgab'] ?></td>
                              <td><?= $dataNilai['bcc1'] ?></td>
                              <td><?= $dataNilai['cc1'] ?></td>
                              <td><?= $dataNilai['cc2'] ?></td>
                              <td><?= $dataNilai['bcm1'] ?></td>
                              <td><?= $dataNilai['bcm2'] ?></td>
                              <td><?= $dataNilai['cm1'] ?></td>
                              <td><?= $dataNilai['cm2'] ?></td>
                              <td><?= $dataNilai['abu'] ?></td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <!-- Modal -->
          <div class="modal fade myModal" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Daftar Memo</h4>
                </div>
                <div class="modal-body">
                  <section>
                    <div class="form-inline mb-10 ml-15">
                      <label class="lbl2">Pertahun</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control" id="datemomen">
                      </div>
                      <button class="btn btn-success" id="carimemo">Cari</button>
                      <button class="btn btn-primary ml-15" id="refresh">Refresh Data</button>
                    </div>
                  </section>
                  <section style="margin-bottom: 25px;">
                    <div>
                      <div class="col-md-1" style="padding-right: 0px; margin-right: 0; width: 40px;">
                        <div id="box3"></div>
                      </div>
                      <div class="col-md-3" style="text-align: left !important;">
                        <label>Sudah Dicetak</label>
                      </div>
                    </div>
                    <div>
                      <div class="col-md-1" style="padding-right: 0px; margin-right: 0; width: 40px;">
                        <div id="box1"></div>
                      </div>
                      <div class="col-md-3" style="text-align: left!important;">
                        <label>Belum dicetak</label>
                      </div>
                    </div>
                  </section>
                  <section class="content">
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="box">
                          <div class="box-body">
                            <div class="table-responsive">
                              <table id="tb4" class="table table-bordered table-striped" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th>No surat</th>
                                    <th>Hal</th>
                                    <th>Tanggal</th>
                                    <th>Periode</th>
                                    <th>Seksi</th>
                                    <th class="hidden">Kdmemo</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php foreach ($getDaftarMemo as $data) : ?>
                                    <tr id="<?= $data['kdmemo'] ?>" title="Double klik" style="color:<?= ($data['cetak'] == 't') ? "#008000" :  "#000"  ?> ;">
                                      <td><?= $data['nosurat'] ?></td>
                                      <td><?= $data['hal'] ?></td>
                                      <td><?= $data['tanggal'] ?></td>
                                      <td><?= $data['periode'] ?></td>
                                      <td><?= $data['seksitujuan'] ?></td>
                                      <td class="hidden"><?= $data['kdmemo'] ?></td>
                                    </tr>
                                  <?php endforeach ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </section>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- //Sementara tidak digunakan -->
    <!-- <div id="ShowDaftarNilai" style="opacity: 0.5; pointer-events: none;display: none;">
            <div class="panel panel-primary mt-10" id="DaftarNilai">
                <div class="panel-heading">
                    <h4>Daftar Nilai</h4>
                </div>
                <div class=" panel-body">

                    <form class="col-md-6 mb-10">

                        <div class="form-group form-inline">
                            <div class="checkbox">
                                <input type="checkbox" id="checkbox-kategori">
                            </div>
                            <label class="lbl" for="checkbox-kategori">Kategori</label>
                            <select class="form-control" style="width: auto;">
                                <option>Option 1</option>
                                <option>Option 2</option>
                                <option>Option 3</option>
                                <option>Option 4</option>
                                <option>Option 5</option>
                            </select>
                        </div>

                        <div class="form-group form-inline mt-5">
                            <div class="checkbox">
                                <input type="checkbox" id="checkbox-periode">
                            </div>
                            <label class="lbl" for="checkbox-periode"> Periode </label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control" id="reservation1">
                            </div>
                        </div>

                        <button type="btn-submit" class="btn btn-primary">Cari</button>
                    </form>

                    <section class="content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="table-responsive">

                                            <table id="tb2" class="table table-ordered table stiped">
                                                <thead>
                                                    <tr>
                                                        <th>Kategori</th>
                                                        <th>Periode</th>
                                                        <th>Ruang</th>
                                                        <th>Jenis</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>kategori</td>
                                                        <td>periode</td>
                                                        <td>ruang</td>
                                                        <td>jenis</td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div>
                        <div class="form-inline col-md-6" style="margin: 10px 0;">
                            <div class="checkbox">
                                <input type="checkbox" id="checkbox-all">
                            </div>
                            <label for="checkbox-all">All</label>
                        </div>

                        <div class="form-inline col-md-6" style="text-align: right;">
                            <button class="btn btn-primary">Tambah</button>
                            <button class="btn btn-danger">Batal</button>
                        </div>
                    </div>

                    <section class="content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="table-responsive">

                                            <table id="tb3" class="table table-ordered table stiped">
                                                <thead>
                                                    <tr>
                                                        <th>No Induk</th>
                                                        <th>Nama</th>
                                                        <th>Seksi</th>
                                                        <th>Tgl Ujian</th>
                                                        <th>Materi</th>
                                                        <th>Nilai</th>
                                                        <th>Lulus</th>
                                                        <th>Remidi</th>
                                                        <th>Remidi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>no induk</td>
                                                        <td>nama</td>
                                                        <td>seksi</td>
                                                        <td>tgl ujian</td>
                                                        <td>materi</td>
                                                        <td>nilai</td>
                                                        <td>lulus</td>
                                                        <td>remidi</td>
                                                        <td>2</td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section>
                        <div>
                            <div class="col-md-1" style="padding-right: 0px; margin-right: 0; width: 40px;">
                                <div id="box1"></div>
                            </div>
                            <div class="col-md-3">
                                <p>Belum ada memo</p>
                            </div>
                        </div>
                        <div>
                            <div class="col-md-1" style="padding-right: 0px; margin-right: 0; width: 40px;">
                                <div id="box2"></div>
                            </div>
                            <div class="col-md-3">
                                <p>Sudah ada memo</p>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div> -->
  </div>
  <script src="<?= base_url('assets') ?>/js/customCMHO.js"></script>
</section>