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
        Monitoring Biaya Produksi
        <small>
          <p class="pMBPDate"></p>
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
                <b> GRAFIK BIAYA BULANAN DEPARTEMEN PRODUKSI</b><br>
              </h3><br>
              <span style="font-family: sans-serif" class="spnMBPGroupNameTitle"></span>
              <p class="pMBPDateNow"></p>

              <table align="center">
                <tr>
                  <td><div class="LegendRectangleWhite"></div></td>
                  <td>&nbsp;&nbsp;Tahun 2018&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td><div class="LegendRectangleBlue"></div></td>
                  <td>&nbsp;&nbsp;Tahun 2019</td>
                </tr>
              </table><br><br>

              <div class="form-group" style="text-align: left">

                <label class="col-sm-3 control-label" style="font-weight:normal;">Silahkan Pilih Golongan</label>
               
                <div class="col-sm-3" style="left: -100px">
                  <select class="form-control select2 slcMBPGroupName" style="width: 100%;">
                      <option value="" disabled selected></option>
                      <?php foreach ($GroupList as $key => $val) { ?>
                        <option Group="<?= $val['SEQUENCE'] ?>" title="<?= $val['GOLONGAN'] ?>"><?= $val['GOLONGAN'] ?></option>
                      <?php } ?>
                  </select>
                </div>
                
                <div class="col-sm-6" style="left: -125px">
                  
                  <div class="col-sm-3">
                    <button type="button" title="Tampilkan Grafik" class="btn btn-default btnMBPShowChartDetail"><i
                        class="fa fa-bar-chart"></i>&nbsp; Tampilkan</a></button>
                  </div>

                  <div class="col-sm-1 divMBPimgLoad" style="display:none;margin-left:-10px;margin-right:10px">
                    <img src="<?=base_url('assets/img/gif/loading5.gif')?>"
                      style="width:35px; height:35px; float:left;">
                  </div>

                </div>

                <label class="col-sm-3 control-label"></label>
               
                  <div class="col-sm-8 divMBPWarnGroup" style="left: -100px;margin-top:5px;display:none">
                    <ul class="timeline" style="margin:0px;float:left;">
                      <li class="time-label" style="margin:0px">
                        <span class="bg-red spnMBPWarnGroupColor">&nbsp;<i class="fa fa-remove"></i>&nbsp;<span
                            class="spnMBPWarnGroup"></span></span>
                      </li>
                    </ul>
                  </div>

              </div><br><br>

            </div>


            <div class="box-body">
            
              <div class="col-sm-9 divMBPWarnExport" style="margin-left:50px;display:none">
                <ul class="timeline" style="margin:0px;float:right;">
                  <li class="time-label" style="margin:0px">
                    <span class="bg-yellow">
                      &nbsp;<i class="fa fa-warning"></i>&nbsp; Anda belum memilih golongan.
                    </span>
                  </li>
                </ul>
              </div>

              <div style="height:50px">
                <div style="float:right;margin-left: 10px">
                  <form method="post" target="_blank">
                    <button type="button" title="Export report to Excel" class="btn btn-default btnMBPExportExcel">
                      <i class="fa fa-download"></i>&nbsp; Export
                    </button>
                    <input type="text" name="GroupName" style="display:none" value="">
                    <button type="submit" title="Export report to Excel" class="btn btn-default" style="display:none"></button>
                  </form>
                </div>
                <div style="float:right;">
                  <form method="post" target="_blank">
                    <!-- <a href="" class="aMBPDetailExportExcel"> -->
                      <button type="button" title="Export detail report to Excel" class="btn btn-primary btnMBPDetailExportExcel">
                        <i class="fa fa-download"></i>&nbsp; Export Detail
                      </button>
                      <input type="text" name="GroupName" style="display:none" value="">
                      <button type="submit" title="Export report to Excel" class="btn btn-default" style="display:none"></button>
                    <!-- </a> -->
                  </form>
                </div>
              </div>

                <div class="chartWrapper">
                  <div class="chartAreaWrapper">
                    <div class="chartAreaWrapper2">
                      <canvas class="cnvMBPChart"></canvas>
                    </div>
                  </div>
                  <canvas class="cnvMBPChartAxis" height="0" width="0" 
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