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
                    <li><a href="#lph-monitoring" data-toggle="tab">Monitoring</a></li>
                    <li class="active"><a href="#lph-form" data-toggle="tab">Form Input</a></li>
                    <li class="pull-left header"><b class="fa fa-rocket"></b> Laporan Produksi Harian Operator </li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="lph-form">
                      <div class="row pt-3">
                        <div class="col-md-12">
                          <form id="lph_search_rkh" action="index.html" method="post">
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
                              <div class="col-md-3">
                                <label for="">Pilih Tanggal RKH</label>
                                <div class="input-group">
                                  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                  <input type="text" name="date" class="form-control LphTanggal lph_search_tanggal" placeholder="Select Yout Current Date" required="" >
                                </div>
                              </div>
                              <div class="col-md-3">
                                <label for="">Pilih Shift</label>
                                <div class="input-group">
                                  <div class="input-group-addon"><i class="fa fa-fire"></i></div>
                                  <select class="select2 lph_shift_dinamis" name="shift" style="width:200px" required>
                                    <?php foreach ($shift as $key => $value): ?>
                                      <option value="<?php echo $value['SHIFT_NUM'] ?>"><?php echo $value['SHIFT_NUM'] ?> - <?php echo $value['DESCRIPTION'] ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>

                              </div>
                              <div class="col-md-3">
                                <label for="">Pekerja</label>
                                <div class="input-group">
                                  <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                  <select class="lphgetEmployee lph_search_pekerja" name="Pekerja" style="width:200px" required>

                                  </select>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div style="width:46%;float:left">
                                  <label for="" style="color:transparent">Ini Submit</label>
                                  <button type="submit" style="font-size:15px;border:1px solid black"  class="btn btn-sm btn-block"> <i class="fa fa-search"></i> <strong>Find</strong> </button>
                                </div>
                                <div style="width:51%;float:left;margin-left:5px;">
                                  <label for="" style="color:transparent">Ini Refresh</label>
                                  <button type="button" style="font-size:15px;border:1px solid black"  class="btn btn-sm btn-block" onclick="lph_empty_form()"> <i class="fa fa-pencil-square"></i> <strong>Empty Form</strong> </button>
                                </div>
                              </div>
                            </div>
                          </form>
                          <hr>
                        </div>
                      </div>
                      <div class="area-lph-2021">

                      </div>
                    </div>

                    <div class="tab-pane" id="lph-monitoring">
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
                        <form class="lph_search" action="index.html" method="post">
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
                      <div class="area-getlph-2021">

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
