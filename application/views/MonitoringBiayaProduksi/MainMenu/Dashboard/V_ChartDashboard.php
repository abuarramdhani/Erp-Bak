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
                <b> GRAFIK BIAYA PER GOLONGAN DEPARTEMEN PRODUKSI</b><br>
              </h3><br>
              <span style="font-family: sans-serif" class="spnMBPSectionNameTitle"></span>
              <p class="pMBPDateNow"></p>

              <table align="center">
                <tr>
                  <td><div class="LegendRectangleWhite"></div></td>
                  <td>&nbsp;&nbsp;Tahun 2018&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td><div class="LegendRectangleBlue"></div></td>
                  <td>&nbsp;&nbsp;Tahun 2019</td>
                </tr>
              </table><br>

            </div>
            

            <div class="box-body">

              <div style="height:50px">
                <div style="float:right;">
                  <a target="_blank" href="<?= base_url() ?>MonitoringBiayaProduksi/Dashboard/ExportReportToExcel" class="aMBPExportExcel">
                    <button title="Export report to Excel"  class="btn btn-default btnMBPExportExcel">
                      <i class="fa fa-download"></i>&nbsp; Export
                    </button>
                  </a>
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