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
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Rekap Data</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
              </div>
              <div class="box-body box-primary">
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
                      <div class="col-md-3">
                        <div class="form-group">
                          <button class="btn btn-primary" id="duka_prk">Proses</button>
                          &nbsp;&nbsp;
                          <a class="btn btn-success" title="Versi Bu Angel" data-toggle="modal" data-target="#Mdl_ttd_duka">
                            <i class="fa fa-file-excel-o"></i> Export Excel
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12" id="duka_table_rekap" style="margin-top: 30px;">
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

<div class="modal fade" id="Mdl_ttd_duka" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document" style="width: 600px">
     <div class="modal-content">
       <div class="modal-header text-center">
         <button type="button" class="close hover" data-dismiss="modal">&times;</button>
         <h3>Pilih Tertanda</h3>
       </div>
       <div class="modal-body" style="width: 100%; text-align: center;">
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-12 text-center">Tertanda</label><br>
              <select  class=" col-lg-8 select select2 text-center" name="Penerima_kasbon" id="Penerima_kasbon"  style="width: 55%">
              <option></option>
              <?php foreach ($namaPekerja as $key): ?>
                <option value="<?= $key['noind'] ?>"><?= $key['noind'].' - '.rtrim($key['nama']) ?></option>  
              <?php endforeach ?>
              </select>
            </div>
          </div>
          <br>
        </div>
       <div class="modal-footer" style="text-align: center;">
         <button id="duka_to_excel" type="button" class="btn btn-success">Kirim</button>
       </div>
     </div>
   </div>
 </div>