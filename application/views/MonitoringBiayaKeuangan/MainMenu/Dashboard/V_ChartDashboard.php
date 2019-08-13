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
                <b> Grafik Biaya Departemen Keuangan</b>
              </h3>

              <p class="pMBKDateNow"></p>

              <table align="center">
                <tr>
                  <td><div class="LegendRectangleWhite"></div></td>
                  <td>&nbsp;&nbsp;Tahun 2018&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td><div class="LegendRectangleBlue"></div></td>
                  <td>&nbsp;&nbsp;Tahun 2019</td>
                </tr>
              </table>

            </div>
            

            <div class="box-body">
              <div style="height:50px">
                <div style="float:right;">
                  <a title="Export to Excel"
                    href="<?= base_url('MonitoringBiayaKeuangan/Dashboard/ExportReportToExcel') ?>"
                    class="btn btn-default"><i class="fa fa-download"></i>&nbsp; Export</a>
                </div>
              </div>
              
              <div class="box-body">
                <div style="overflow-x: scroll;">
                  <div class="divMBKChart chart" style="width: 500%">
                    <canvas class="cnvMBKChart" height="375px"></canvas>
                  </div>
                </div>
              </div>
            </div>


            <div class="box-footer"></div>


          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->