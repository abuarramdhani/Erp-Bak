<style media="screen">

.tblJMT {
  display: none !important;
}
.loadingjti{
  display: none;
}

</style>
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
                    Cetak Jembatan Timbang
                  </b>
                </h1>
              </div>
            </div>
            <div class="col-lg-1 ">
              <div class="text-right hidden-md hidden-sm hidden-xs">
                <a class="btn btn-default btn-lg" href="#">
                  <i aria-hidden="true" class="fa fa-line-chart fa-2x">
                  </i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                 <h4>Search data Jembatan Timbang</h4>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12">
                    <!-- <form id="formSPB" onsubmit="getDataSPB()"> -->
                    <div class="col-md-12">
                      <label for="">Scan Ticket Number</label>
                      <input type="text" name="QRCODE" class="form-control" id="qrcode" placeholder="Scan your QRcode" required="" oninput="getDataTicketJTI()">
                    </div>
                    <!-- <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-sm btn-block">SEARCH</button>
                    </div> -->
                  </div>
                </div>
                <div class="row" style="padding-top:30px;">
                  <div class="col-md-12">
                    <div id="tableSPBArea" style="overflow-x:auto;"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- form aja -->

        <div class="row" id="loadingArea" style="padding-top:30px; color: #3c8dbc;  display: none;">
          <div class="col-md-12 text-center">
            <i class="fa fa-spinner fa-4x fa-pulse"></i>
          </div>
        </div>

        <div class="row" id="nothing" style="padding-top:30px; color: #3c8dbc;  display: none;">
          <div class="col-md-12 text-center">
            <div style="text-align:center">
              <h2>Can't found data.<br> Please try again</h2>
            </div>
          </div>
        </div>

        <div class="row tblJMT" id="tblJMT">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                 <h4>Cetak Bukti Timbang</h4>
              </div>
              <div class="panel-body">

                <div class="row">

                  <div class="col-md-12">
                    <!-- <form id="formaja" onsubmit="getDataSPB()"> -->
                    <div class="col-md-2">
                      <center><img style="height: auto; width:100%;border-color:#ec4b19;" id="photo" src="" /></center>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group">
                        <label for="usr">Nama Driver</label>
                        <input type="text" class="form-control" id="nama" placeholder="Nama Driver" value="">
                      </div>
                      <div class="form-group">
                        <label for="usr">Vendor</label>
                        <input type="text" class="form-control" id="vendor" placeholder="Vendor" value="">
                      </div>
                      <div class="form-group">
                        <label for="usr">No Dokumen</label>
                        <input type="text" class="form-control" id="noDokumen" placeholder="No Dokument" value="">
                      </div>
                      <div class="form-group">
                        <label for="usr">No Tiket</label>
                        <input type="text" class="form-control" id="noTiket" placeholder="No Tiket" value="">
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group">
                        <label for="usr">Nomor Polisi</label>
                        <input type="text" class="form-control" id="noPolisi" placeholder="No Polisi" value="">
                      </div>
                      <div class="form-group">
                        <label for="usr">Jenis Kendaraan</label>
                        <input type="text" class="form-control" id="jenKen" placeholder="Jenis Kendaraan" value="">
                      </div>
                      <div class="form-group">
                        <label for="usr">Tanggal Timbang</label>
                        <input type="text" class="form-control" id="tglTim" placeholder="Tanggal Timbang" value="<?php echo date("Y-m-d H:i:s")?>" readonly>
                      </div>
                      <div class="form-group">
                        <label for="usr">Keperluan</label>
                        <input type="text" class="form-control" id="keperluan" placeholder="Keperluan" value="">
                      </div>
                    </div>
                  </div>
                </div>
                <br><br>
                <!-- <div class="row">
                  <div class="col-md-12">
                    <table class="table table-bordered" id="dataTableJT" width="100%" cellspacing="0">
                      <thead style="background:#22aadd; color:#FFFFFF;">
                        <tr>
                          <th>NO</th>
                          <th>ITEM</th>
                          <th>DESKRIPSI</th>
                          <th>QUANTITY</th>
                          <th>UOM</th>
                          <th>TUJUAN</th>
                        </tr>
                      </thead>
                      <tbody id="tbody">
                        <tr id="Kawaki" style="display:none">
                          <td>1</td>
                          <td>STATIC TRIAL</td>
                          <td>STATIC TRIAL</td>
                          <td>STATIC TRIAL</td>
                          <td>STATIC TRIAL</td>
                          <td>STATIC TRIAL</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div> -->
                <br><br>
                <div class="row">
                  <div class="col-md-10">
                    <div class="row">
                      <div class="col-md-1" style="padding-top:5px;">
                        <label>Petugas</label>
                      </div>
                      <div class="col-md-11">
                        <div class="form-group">
                          <input type="text" readonly id="namaPetu" value="<?= $this->session->employee ?>" class="form-control" style="width: 100%;padding-left: 10px" placeholder="Nama Petugas Otomatis">
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <!-- <div class="col-md-2">
                        <button type="button" style="height:35px;" id="submitTimbangan" class="btn btn-primary btn-sm btn-block">TIMBANG</button>
                      </div> -->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Berat 1</label>
                          <input type="text" style="width:85%;float:left;" disabled class="form-control" id="berat1" placeholder="Berat 1" value="" required>
                          <span style="width:10%;float:left;padding:5px"><b>Kg</b></span>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Berat 2</label>
                          <input type="text" class="form-control" disabled id="berat2" placeholder="Berat 2" style="width:85%;float:left;" value="" required>
                          <span style="width:10%;float:left;padding:5px"><b>Kg</b></span>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Berat 3</label>
                          <input type="text" class="form-control" disabled style="width:85%;float:left;" id="berat3" placeholder="Berat 3" value="" required>
                          <span style="width:10%;float:left;padding:5px"><b>Kg</b></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <!-- onclick="SubmitMasterTimbangan()" -->
                    <button type="button" style="height:150px !important" disabled class="btn btn-primary btn-sm btn-block">
                        <h4 style="text-align:center"><i class="fa fa-file-pdf-o"></i></h4>
                        <h4 style="text-align:center">CETAK<br>DOKUMEN</h4>
                    </button>
                  </div>
                </div>
                <!-- </form> -->
                <div class="row" style="padding-top:30px;">
                  <div class="col-md-12">
                    <div id="tableJTArea" style="overflow-x:auto;"></div>
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
<input type="hidden" id="no_id" name="" value="">
<input type="hidden" id="pass" value="<?php echo $password ?>">
<input type="hidden" id="noind" value="<?php echo $username ?>">
