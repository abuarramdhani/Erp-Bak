<style media="screen">
  td{
    padding-bottom: 20px !important;
  }
</style>
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">

        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                 <h4 style="font-weight:bold"><i aria-hidden="true" class="fa fa-bar-chart-o"></i> Monitoring Stok Item Barang Bekas</h4>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-8">
                    <br>
                    <form class="form_submit_filter_grafik" action="" method="post">
                      <table style="width:100%">
                        <tr>
                          <td style="width:15%"><b>IO</b> </td>
                          <td style="width:5%;">:</td>
                          <td style="width:80%">
                            <select class="slc_pbb pbb_io" name="io" style="width:100%">
                              <option value="">Select..</option>
                              <?php foreach ($io as $key => $value): ?>
                                <option value="<?php echo $value['ORGANIZATION_ID'] ?>"><?php echo strtoupper($value['ORGANIZATION_CODE']) ?></option>
                              <?php endforeach; ?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td><b>SubInv</b> </td>
                          <td>:</td>
                          <td class="pbb_sudah_pilih_io">
                            <select class="slc_pbb pbb_subinv" name="subinv" style="width:100%">
                              <option value="">Select..</option>
                            </select>
                          </td>
                        </tr>
                        <tr id="locator_check">
                          <td><b>Locator</b> </td>
                          <td>:</td>
                          <td class="pbb_locator">
                          -
                          <input type="hidden" class="slc_pbb_locator" name="locator" value="">
                          </td>
                        </tr>
                      </table>
                      <br>
                      <center><button type="submit" class="btn btn-success text-bold" name="button"> Tampilkan Grafik</button></center>
                    </form>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-12">
                    <hr>
                  </div>
                  <div class="col-md-12">
                    <div class="pbb_grafik_mon">

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
