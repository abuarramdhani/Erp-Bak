    <style>
      .LegendRectangleWhite {
        height: 15px;
        width: 40px;
        background-color: #ffff;
        border: 1px solid black;
      }
      .LegendRectangleBlue {
        height: 15px;
        width: 40px;
        background-color: #00bbff;
        border: 1px solid black;
      }
      .Center {
        display: block;
        margin-left: auto;
        margin-right: auto;
      }
      .chartWrapper {
        position: relative;
      }
      .chartWrapper>canvas {
        position: absolute;
        left: 0;
        top: 0;
        pointer-events: none;
      }
      .chartAreaWrapper {
        overflow-x: scroll;
        position: relative;
        width: 100%;
      }
      .chartAreaWrapper2 {
        position: relative;
        height: 300px;
      }
    </style>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Monitoring Biaya Keuangan
        <small>
          <p class="pMBKDate"></p>
        </small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">


            <div class="box-header with-border" style="text-align: center">

              <h3 class="box-title">
                <b> GRAFIK BIAYA BULANAN DEPARTEMEN KEUANGAN</b><br>
              </h3><br>
              <span style="font-family: sans-serif" class="spnMBKSectionNameTitle"></span>
              <span style="font-family: sans-serif" class="spnMBKAccountNameTitle"></span>
              <p class="pMBKDateNow"></p>

              <table align="center">
                <tr>
                  <td><div class="LegendRectangleWhite"></div></td>
                  <td>&nbsp;&nbsp;Tahun 2018&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td><div class="LegendRectangleBlue"></div></td>
                  <td>&nbsp;&nbsp;Tahun 2019</td>
                </tr>
              </table><br><br>

              <div class="form-group" style="text-align: left">

                <label class="col-sm-3 control-label" style="font-weight:normal;">Silahkan Pilih Seksi</label>
      
                <div class="col-sm-3" style="left: -100px">
                  <select class="form-control select2 slcMBKSectionName" style="width: 100%;">
                      <option section="All" title="All" selected>All</option>
                    <?php foreach ($SectionList as $key => $val) { ?>
                      <option section="<?= $val['SEKSI'] ?>" title="<?= $val['DESCRIPTION'] ?>"><?= $val['DESCRIPTION'] ?></option>
                    <?php } ?>
                  </select>
                </div> 
                
                  <div class="col-sm-1 divMBKimgLoadSec" style="margin-left:-125px;margin-right:10px;display:none">
                    <img src="<?=base_url('assets/img/gif/loading5.gif')?>"
                      style="width:35px; height:35px; float:left;">
                  </div><br><br>

                <label class="col-sm-3 control-label" style="font-weight:normal;">Silahkan Pilih Akun Biaya</label>
               
                <div class="col-sm-3" style="left: -100px">
                  <select class="form-control select2 slcMBKAccountName" style="width: 100%;">
                      <option value="" disabled selected></option>
                    <?php foreach ($AccountList as $key => $val) { ?>
                      <option account="<?= $val['ACCOUNT'] ?>" title="<?= $val['DESCRIPTION'] ?>"><?= $val['DESCRIPTION'] ?></option>
                    <?php } ?>
                  </select>
                </div>
                
                <div class="col-sm-6" style="left: -125px">
                  
                  <div class="col-sm-3">
                    <button type="button" title="Tampilkan Grafik" class="btn btn-default btnMBKShowChartDetail"><i
                        class="fa fa-bar-chart"></i>&nbsp; Tampilkan</a></button>
                  </div>

                  <div class="col-sm-1 divMBKimgLoad" style="display:none;margin-left:-10px;margin-right:10px">
                    <img src="<?=base_url('assets/img/gif/loading5.gif')?>"
                      style="width:35px; height:35px; float:left;">
                  </div>

                </div>

                <label class="col-sm-3 control-label"></label>
               
                  <div class="col-sm-8 divMBKWarnAccount" style="left: -100px;margin-top:5px;display:none">
                    <ul class="timeline" style="margin:0px;float:left;">
                      <li class="time-label" style="margin:0px">
                        <span class="bg-red spnMBKWarnAccountColor">&nbsp;<i class="fa fa-remove"></i>&nbsp;<span
                            class="spnMBKWarnAccount"></span></span>
                      </li>
                    </ul>
                  </div>

              </div><br><br>

            </div>


            <div class="box-body">
            
              <div class="col-sm-9 divMBKWarnExport" style="margin-left:50px;display:none">
                <ul class="timeline" style="margin:0px;float:right;">
                  <li class="time-label" style="margin:0px">
                    <span class="bg-yellow">
                      &nbsp;<i class="fa fa-warning"></i>&nbsp; Anda belum memilih akun biaya.
                    </span>
                  </li>
                </ul>
              </div>

              <div style="height:50px">
                <div style="float:right;margin-left: 10px">
                  <a href="" class="aMBKExportExcel">
                    <button title="Export report to Excel" class="btn btn-default btnMBKExportExcel">
                      <i class="fa fa-download"></i>&nbsp; Export
                    </button>
                  </a>
                </div>
                <div style="float:right;">
                  <a href="" class="aMBKDetailExportExcel">
                    <button title="Export detail report to Excel" class="btn btn-primary btnMBKDetailExportExcel">
                      <i class="fa fa-download"></i>&nbsp; Export Detail
                    </button>
                  </a>
                </div>
              </div>

                <div class="chartWrapper">
                  <div class="chartAreaWrapper">
                    <div class="chartAreaWrapper2">
                      <canvas class="cnvMBKChart"></canvas>
                    </div>
                  </div>
                  <canvas class="cnvMBKChartAxis" height="0" width="0" 
                  style="display:none; background-color:white; padding-right:10px; border-right:1px solid #b5b5b5;">
                  </canvas>
                </div>

            </div>


            <div class="box-footer"></div>


          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->