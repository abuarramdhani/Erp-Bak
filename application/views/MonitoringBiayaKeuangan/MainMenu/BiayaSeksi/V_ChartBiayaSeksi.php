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
                <b> GRAFIK BIAYA SEMUA SEKSI DEPARTEMEN KEUANGAN</b><br>
              </h3><br>
              <span style="font-family: sans-serif" class="spnMBKSectionNameTitle"></span>
              <p class="pMBKDateNow"></p>

              <table align="center">
                <tr>
                  <td><div class="LegendRectangleWhite"></div></td>
                  <td>&nbsp;&nbsp;Tahun 2018&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td><div class="LegendRectangleBlue"></div></td>
                  <td>&nbsp;&nbsp;Tahun 2019</td>
                </tr>
              </table><br><br>

            </div>
            

            <div class="box-body">
            
              <div style="height:50px">
                <div style="float:right;">
                  <a href="<?= base_url('MonitoringBiayaKeuangan/BiayaSeksi/ExportReportToExcel') ?>" class="aMBKExportExcel">
                    <button title="Export report to Excel"  class="btn btn-default btnMBKExportExcel">
                      <i class="fa fa-download"></i>&nbsp; Export
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


            <div class="box-footer"></div>


          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->