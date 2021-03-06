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
                    <li onclick="lphgetmon()"><a href="#lph-monitoring" data-toggle="tab">Monitoring</a></li>
                    <li class="active"><a href="#lph-import" data-toggle="tab">Import</a></li>
                    <li class="pull-left header"><b class="fa fa-download"></b> Rencana Kerja Operator </li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="lph-import">
                      <div class="row">
                        <div class="col-md-12">
                          <?php echo $this->session->flashdata('message_lph') ?>
                        </div>
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-6  pt-4 pb-4">
                          <div class="form-group">
                            <form class="" action="<?php echo base_url('LaporanProduksiHarian/action/submit_import') ?>" method="post" enctype="multipart/form-data">
                              <div class="form-group">
                                <label for="">Pilih Shift</label>
                                <div class="input-group">
                                  <div class="input-group-addon"><i class="fa fa-fire"></i></div>
                                  <select class="select2" name="shift" style="width:100%">
                                    <?php foreach ($shift as $key => $value): ?>
                                      <option value="<?php echo $value['SHIFT_NUM'] ?>"><?php echo $value['SHIFT_NUM'] ?> - <?php echo $value['DESCRIPTION'] ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="">Pilih File</label>
                                <div class="input-group">
                                  <div class="input-group-addon"><i class="fa fa-file-excel-o"></i></div>
                                  <input type="file" class="form-control" name="excel_file" value="" accept=".xlsx, .xls" required>
                                </div>
                              </div>

                              <center>
                                <button type="submit" class="btn btn-primary mt-4 pull-left" style="width:150px;font-weight:bold" name="button"> <i class="fa fa-download"></i> Import</button>
                                <a target="_blank" href="<?php echo base_url('assets/upload/LaporanProduksiHarian/example-lph-import-format.xlsx') ?>" class="btn btn-success mt-4 pull-right" name="button" style="width: 150px;font-weight:bold"> <i class="fa fa-file-excel-o"></i> Template</a>
                              </center>
                            </form>
                          </div>
                        </div>
                        <div class="col-md-3">

                        </div>
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
                        <form class="" action="<?php echo base_url('LaporanProduksiHarian/action/lph_pdf_rk') ?>" method="post" target="_blank">
                          <div class="col-md-5">
                            <label for="">Filter By Date Range</label>
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                              <input type="text" name="range_date" class="form-control tanggal_lph_99" placeholder="Select Yout Current Date" required="" >
                            </div>
                          </div>
                          <div class="col-md-3">
                            <label for="">Pilih Shift</label>
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-fire"></i></div>
                              <select class="select2 lph_pilih_shift" name="shift" style="width:200px">
                                <?php foreach ($shift as $key => $value): ?>
                                  <option value="<?php echo $value['SHIFT_NUM'] ?>"><?php echo $value['SHIFT_NUM'] ?> - <?php echo $value['DESCRIPTION'] ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <label for="" style="color:transparent">Ini Filter</label>
                            <button type="button" onclick="lphgetmon()" style="font-size:15px" class="btn btn-primary btn-sm btn-block"> <i class="fa fa-search"></i> <strong>Filter</strong> </button>
                          </div>
                          <div class="col-md-2">
                            <label for="" style="color:transparent">Ini Cetak</label>
                            <button type="submit" style="font-size:15px"  class="btn btn-danger btn-sm btn-block lph_cetak_rkh"> <i class="fa fa-file-pdf-o"></i> <strong>Cetak RKH</strong> </button>
                          </div>
                        </form>
                      </div>
                      <hr>
                      <div class="table-responsive area-lph-monitoring">

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
