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

.tbl_lph_mesin td{
  padding-top:10px !important;
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
                    <li><a href="#lph-data-mesin" data-toggle="tab" onclick="pemakaianjammesin()">Pemakaian Jam Mesin</a></li>
                    <li class="active"><a href="#lph-tambah-mesin" data-toggle="tab">Tambah Mesin</a></li>
                    <li class="pull-left header"><b class="fa fa-cog"></b> Setting Mesin</li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="lph-tambah-mesin">
                      <div class="row pt-3">
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-6">
                          <form class="" action="#" method="post" id="form_lph_add_mesin">
                            <table style="width:100%" class="tbl_lph_mesin">
                              <tr>
                                <td style="width:20%">No Mesin</td>
                                <td> <input type="text" required class="form-control" placeholder="ex: PUN19" name="no_mesin" value=""> </td>
                              </tr>
                              <tr>
                                <td>Nama Mesin</td>
                                <td> <input type="text" required class="form-control" placeholder="ex: CHINFONG" name="nama_mesin" value=""> </td>
                              </tr>
                              <tr>
                                <td>Tonase</td>
                                <td> <input type="text" required class="form-control" placeholder="ex: 110" name="tonase" value=""> </td>
                              </tr>
                            </table>
                            <br>
                            <center>
                              <button type="submit" class="btn btn-primary" name="button"> <i class="fa fa-save"></i> Submit</button>
                            </center>
                          </form>
                        </div>
                        <div class="col-md-3">

                        </div>
                      </div>
                      <br>
                      <h4 class="text-bold"> <i class="fa fa-database"></i> Data Mesin</h4>
                      <hr style="margin: 0 0 20px;">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="table-responsive">
                            <table class="table table-bordered tbl_lph_mon_mesin" style="width:100%;text-align:center">
                              <thead class="bg-primary">
                                <tr>
                                  <td style="width:30px">No</td>
                                  <td>No Mesin</td>
                                  <td>Nama Mesin</td>
                                  <td>Tonase</td>
                                </tr>
                              </thead>
                              <tbody>
                                <?php foreach ($mesin as $key => $value): ?>
                                  <tr>
                                    <td><?php echo $key+1 ?></td>
                                    <td><?php echo $value['fs_no_mesin'] ?></td>
                                    <td><?php echo $value['fs_nama_mesin'] ?></td>
                                    <td><?php echo $value['fn_tonase'] ?></td>
                                  </tr>
                                <?php endforeach; ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="tab-pane" id="lph-data-mesin">
                      <br>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="alert bg-primary alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">
                                <i class="fa fa-close"></i>
                              </span>
                            </button>
                            <strong>Sekilas Info! </strong> Klik 2 kali jika hanya memilih 1 tanggal</strong>
                          </div>
                        </div>
                        <form id="lph_search_rkh_mesin" action="index.html" method="post">
                          <div class="col-md-5">
                            <label for="">Filter By Date Range</label>
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                              <input type="text" required name="range_date" class="form-control tanggal_lph_99 123_lph_mon_tgl" placeholder="Select Yout Current Date" required="" >
                            </div>
                          </div>
                          <div class="col-md-5">
                            <label for="">Pilih Shift</label>
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-fire"></i></div>
                              <select class="select2 lph_pilih_shift_97" required name="shift" style="width:380px">
                                <?php foreach ($shift as $key => $value): ?>
                                  <option value="<?php echo $value['SHIFT_NUM'] ?> - <?php echo $value['DESCRIPTION'] ?>"><?php echo $value['SHIFT_NUM'] ?> - <?php echo $value['DESCRIPTION'] ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <label for="" style="color:transparent">Ini Filter</label>
                            <button type="submit" style="font-size:15px" class="btn btn-primary btn-sm btn-block"> <i class="fa fa-search"></i> <strong>Filter</strong> </button>
                          </div>
                        </form>
                      </div>
                      <hr>
                      <div class="area-pemakaian-jam-mesin">

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
