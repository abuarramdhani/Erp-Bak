<input type="hidden" id="opp_punya" value="1">
<input type="hidden" id="opp_kodesie" value="<?php echo $this->session->kodesie ?>">

<div class="content">
  <button type="button" class="btn btn-primary" name="button" onclick="opp_add_data_in()" style="position:fixed;bottom:5%;right: 5%;border-radius: 50%;z-index: 9999;height: 37px;"> <b class="fa fa-plus-square"></b> </button>

  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <div class="row">
            <div class="col-md-4">
              <a class="btn btn-success" style="margin-top:2px;" href="<?php echo base_url('OrderPrototypePPIC/OrderIn')?>"><i class="fa fa-reply"></i> Back</a>
            </div>
            <div class="col-md-4">
              <center><h4 style="font-weight:bold;"><i class="fa fa-cloud-upload"></i> Tambah Order Masuk</h4></center>
            </div>
            <div class="col-md-4">

            </div>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <form action="<?php echo base_url('OrderPrototypePPIC/OrderIn/Insert')?>" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="col-md-12" style="margin-top:10px">
              <b>*NB:</b> <span class="text-danger">Tidak Wajib Melakukan Upload File</span>
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:15px;margin-top:20px">
                <div class="row">
                  <div class="col-md-2"> </div>
                  <div class="col-md-8">
                    <!-- <div class="form-group">
                      <label for=""> <b>No Order</b> </label>
                      <input type="text" class="form-control" name="no_order" value="">
                    </div> -->
                    <div class="form-group">
                      <!-- <label for=""> <b> Pengorder</b> </label> -->
                      <table style="width:100%">
                        <tr style="height:61px">
                          <td style="width:15%"><label>No Order</label></td>
                          <td style="width:3%"><label>:</label></td>
                          <td style="width:82%"><input type="text" class="form-control" name="no_order" value=""></td>
                        </tr>
                        <tr style="height:61px">
                          <td style="vertical-align:top"><label><br>Pengorder</label></td>
                          <td style="vertical-align:top"><label><br></label></td>
                          <td >
                            <div class="row">
                              <div class="col-md-2">
                                <br>
                                <b class="text-primary">PIC</b>
                              </div>
                              <div class="col-md-1">
                                <br>
                                <b>:</b>
                              </div>
                              <div class="col-md-9">
                                <br>
                                <input type="text" readonly class="form-control" name="pic" value="<?php echo $this->session->employee ?>"><br>
                              </div>
                              <div class="col-md-2">
                                <b class="text-primary">SEKSI</b>
                              </div>
                              <div class="col-md-1">
                                <b>:</b>
                              </div>
                              <div class="col-md-9">
                                <input type="text" class="form-control" readonly id="opp_seksi" name="seksi" value=""><br>
                              </div>
                            </div>
                          </td>
                        </tr>
                      </table>
                    </div>
                    <hr>
                  </div>
                  <div class="col-md-2"> </div>
                </div>
                <div class="row">
                  <!-- komponen area -->
                  <div class="col-md-2" style="text-align:right;padding: 0px 29px 0 0;font-size: 30px;"> <b>Data.</b> <b class="opp_data_number">1</b> </div>
                  <div class="col-md-8">
                    <table style="width:100%">
                      <tr style="height:61px">
                        <td style="width:20%"><label>Gambar Kerja</label></td>
                        <td style="width:3%"><label>:</label></td>
                        <td style="width:77%">
                          <input type="file" class="form-control" onchange="readFilePdf_opp(this)" name="file_gm[]" value="">
                        </td>
                      </tr>
                      <tr>
                        <td colspan="3">
                          <iframe src="" style="width:100%;height:0" id="showPre" frameborder="0" class="mt-1"></iframe>
                        </td>
                      </tr>
                      <tr style="height:61px">
                        <td ><label>Kode Komponen</label></td>
                        <td ><label>:</label></td>
                        <td ><input type="text" class="form-control" name="kode_komp[]" value=""></td>
                      </tr>
                      <tr style="height:61px">
                        <td ><label>Nama Komponen</label></td>
                        <td ><label>:</label></td>
                        <td ><input type="text" class="form-control" name="nama_komp[]" value=""></td>
                      </tr>

                      <tr style="height:61px">
                        <td ><label>QTY /UNIT</label></td>
                        <td ><label>:</label></td>
                        <td ><input type="number" class="form-control" name="qty[]" value=""></td>
                      </tr>
                      <tr style="height:61px">
                        <td ><label>Need</label></td>
                        <td ><label>:</label></td>
                        <td ><input type="number" class="form-control" name="need[]" value=""></td>
                      </tr>
                      <tr style="height:61px">
                        <td ><label>Material</label></td>
                        <td ><label>:</label></td>
                        <td ><input type="text" class="form-control" name="material[]" value=""></td>
                      </tr>
                      <tr style="height:167px">
                        <td style="vertical-align:top;padding-top:12px"><label>Dimensi PO/T</label></td>
                        <td style="vertical-align:top"><label></label></td>
                        <td >
                          <div class="row">
                            <div class="col-md-1">
                              <b class="text-primary">Ø/t</b>
                            </div>
                            <div class="col-md-1">
                              <b>:</b>
                            </div>
                            <div class="col-md-10">
                              <input type="number" class="form-control" name="dimensi_t[]" value=""><br>
                            </div>
                            <div class="col-md-1">
                              <b class="text-primary">P</b>
                            </div>
                            <div class="col-md-1">
                              <b>:</b>
                            </div>
                            <div class="col-md-10">
                              <input type="number" class="form-control" name="dimensi_p[]" value=""><br>
                            </div>
                            <div class="col-md-1">
                              <b class="text-primary">L</b>
                            </div>
                            <div class="col-md-1">
                              <b>:</b>
                            </div>
                            <div class="col-md-10">
                              <input type="number" class="form-control" name="dimensi_l[]" value="">
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr style="height:61px">
                        <td ><label>Gol</label></td>
                        <td ><label>:</label></td>
                        <td ><input type="text" class="form-control" name="gol[]" value=""></td>
                      </tr>
                      <tr style="height:61px">
                        <td ><label>Jenis</label></td>
                        <td ><label>:</label></td>
                        <td ><input type="text" class="form-control" name="jenis[]" value=""></td>
                      </tr>
                      <tr style="height:61px">
                        <td ><label>P/A</label></td>
                        <td ><label>:</label></td>
                        <td >
                          <select class="form-control" name="p_a[]">
                            <option value="P">P</option>
                            <option value="A">A</option>
                          </select>
                        </td>
                      </tr>
                      <tr style="height:61px">
                        <td ><label>Produk</label></td>
                        <td ><label>:</label></td>
                        <td ><input type="text" class="form-control" name="produk[]" value=""></td>
                      </tr>
                      <tr style="height:61px">
                        <td ><label>Project</label></td>
                        <td ><label>:</label></td>
                        <td ><input type="text" class="form-control" name="project[]" value=""></td>
                      </tr>
                      <tr style="height:61px">
                        <td ><label>Upper Level</label></td>
                        <td ><label>:</label></td>
                        <td ><input type="text" class="form-control" name="upper_level[]" value=""></td>
                      </tr>
                      <tr style="height:61px">
                        <td style="vertical-align:top;padding-top:7px;"><label><br>Proses</label></td>
                        <td style="vertical-align:top;padding-top:7px;"><label><br>:</label></td>
                        <td >
                          <div class="row">
                            <div class="col-md-12">
                              <table class="table table-bordered table_opp">
                                <br>
                                <tr row-id="1">
                                  <td style="text-align:center">1</td>
                                  <td>
                                    <select class="form-control" name="p_proses[1][]" required>
                                      <option value="">Pilih...</option>
                                      <?php foreach ($jenis_proses as $key => $value): ?>
                                        <option value="<?php echo $value['nama_proses'] ?>"><?php echo $value['nama_proses'] ?></option>
                                      <?php endforeach; ?>
                                    </select>
                                  </td>
                                  <td style="width:30%">
                                    <select class="form-control pilihseksiOPP" required name="p_seksi[1][]" style="width:100%"></select>
                                  </td>
                                  <td>
                                    <center><button type="button" name="button" class="btn btn-sm" onclick="plus_proses_opp()"><i class="fa fa-plus-square"></i></button></center>
                                  </td>
                                </tr>
                              </table>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr style="height:61px">
                        <td ><label>Cek Kode</label></td>
                        <td ><label>:</label></td>
                        <td ><input type="number" class="form-control" name="cek_kode[]" value=""></td>
                      </tr>
                      <tr style="height:61px">
                        <td ><label>Cek Mon</label></td>
                        <td ><label>:</label></td>
                        <td ><input type="number" class="form-control" name="cek_mon[]" value=""></td>
                      </tr>
                      <tr style="height:61px">
                        <td ><label>Cek Nama</label></td>
                        <td ><label>:</label></td>
                        <td ><input type="number" class="form-control" name="cek_nama[]" value=""></td>
                      </tr>
                    </table>
                    <br>
                    <br>
                    </div>
                    <div class="col-md-2"></div>
                  </div>
                  <div class="opp_add_target">

                  </div>
                  <center><button type="submit" name="button" style="width:30%" class="btn btn-success"> <b class="fa fa-floppy-o"></b> <b>Save</b> </button></center>
                </div>
              </div>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<textarea style="display:none" id="opp_jenis_proses" rows="8" cols="80"><?php echo json_encode($jenis_proses) ?></textarea>
