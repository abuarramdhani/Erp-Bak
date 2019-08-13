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


            <div class="box-header with-border" style="text-align: center"><br>

              <div class="form-group" style="text-align: left">
                
                <label for="txtPMSPONoPO" class="col-sm-3 control-label" style="font-weight:normal;">Silahkan Pilih Akun
                  Biaya</label>
               
                <div class="col-sm-3" style="left: -100px">
                  <select class="form-control select2 slcMBKAccountName" style="width: 100%;">
                    <option value="" disabled selected></option>
                    <?php foreach ($AccountList as $key => $val) { ?>
                    <option title="<?= $val['DESCRIPTION'] ?>"><?= $val['ACCOUNT'] ?></option>
                    <?php } ?>
                  </select>
                </div>
                
                <div class="col-sm-6" style="left: -125px">
                  
                  <div class="col-sm-3">
                    <button type="button" title="Tampilkan Grafik" class="btn btn-default btnMBKShowChart"><i
                        class="fa fa-bar-chart"></i>&nbsp; Tampilkan</a></button>
                  </div>

                  <div class="col-sm-1 divMBKimgLoad" style="display:none;margin-left:-10px;margin-right:10px">
                    <img src="<?=base_url('assets/img/gif/loading5.gif')?>"
                      style="width:35px; height:35px; float:left;">
                  </div>

                  <div class="col-sm-8 divMBKWarnAccount" style="display:none">
                    <ul class="timeline" style="margin:0px;float:left;">
                      <li class="time-label" style="margin:0px">
                        <span class="bg-red spnMBKWarnAccountColor">&nbsp;<i class="fa fa-remove"></i>&nbsp;<span
                            class="spnMBKWarnAccount"></span></span>
                      </li>
                    </ul>
                  </div>

                </div>

              </div><br><br>
              
              <h3 class="box-title"><b>Grafik Biaya Bulanan Departemen Keuangan</b><br>
                <span class="spnMBKAccountNameTitle"></span></h3>
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
            
              <div class="col-sm-11 divMBKWarnExport" style="display:none">
                <ul class="timeline" style="margin:0px;float:right;">
                  <li class="time-label" style="margin:0px">
                    <span class="bg-yellow">
                      &nbsp;<i class="fa fa-warning"></i>&nbsp; Anda belum memilih akun biaya.
                    </span>
                  </li>
                </ul>
              </div>

              <div style="height:50px">
                <div style="float:right;">
                  <a title="Export report to Excel"
                    href="#"
                    class="btn btn-default aMBKExportExcel"><i class="fa fa-download"></i>&nbsp; Export</a>
                </div>
              </div>

              <div class="box-body">
                <div style="overflow-x: scroll;">
                  <div class="divMBKChart chart" style="width: 100%">
                    <canvas class="cnvMBKChart" height="350px"></canvas>
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