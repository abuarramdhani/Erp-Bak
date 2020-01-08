<style type="text/css">
  .dataTables_filter { 
    float: right;
  }
  .dataTables_info { 
    float: left;
  }
</style>
<section class="content">
  <div class="inner" >
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="col-lg-11">
              <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
            </div>
            <div class="col-lg-1">
              <div class="text-right hidden-md hidden-sm hidden-xs">
                <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPresensi/Lelayu');?>">
                  <i class="icon-wrench icon-2x"></i>
                  <br/>
                </a>
              </div>
            </div>
          </div>
        </div>
        <br/>
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border"></div>
              <div style="margin-top: 20px; margin-right: 10px;">
                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-md-1">
                      <label style="margin-top: 5px;" class="control-label">Periode</label>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-addon">
                            From
                          </div>
                          <input type="text" id="duka_rekapBegin" class="form-control duka_dpicker">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-addon">
                            To
                          </div>
                          <input type="text" id="duka_rekapEnd" class="form-control duka_dpicker">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <button class="btn btn-primary" id="duka_prk">Proses</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12" id="duka_table_rekap" style="margin-top: 30px;">
                </div>
              </div>
              <div class="box-body box-primary">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>