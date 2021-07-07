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
                    <!-- <li><a href="#lph-data-mesin" data-toggle="tab">View Data Mesin</a></li> -->
                    <!-- <li class="active"><a href="#lph-tambah-mesin" data-toggle="tab">Tambah Mesin</a></li> -->
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
