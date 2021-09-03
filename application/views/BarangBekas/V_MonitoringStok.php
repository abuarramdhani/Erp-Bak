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

            <div class="box box-primary color-palette-box">
              <div class="panel-body">
                <input type="hidden" id="mon_agt_2021" value="1">
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs pull-right">
                    <li ><a href="#pbb-tabel" data-toggle="tab">Data Tabel</a></li>
                    <li class="active"><a href="#pbb-grafik" data-toggle="tab">Data Grafik</a></li>
                    <li class="pull-left header">
                      <input type="hidden" id="pbb_mon_stok_barkas" value="1">
                      <h4 style="font-weight:bold"><i aria-hidden="true" class="fa fa-bar-chart-o"></i> Monitoring Stok Item Barang Bekas</h4>
                    </li>
                  </ul>

                </div>
                <div class="tab-content">
                  <div class="tab-pane active" id="pbb-grafik">
                    <div class="row pt-3">
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
                              <!-- <tr id="locator_check">
                                <td><b>Locator</b> </td>
                                <td>:</td>
                                <td class="pbb_locator">
                                -
                                <input type="hidden" class="slc_pbb_locator" name="locator" value="">
                                </td>
                              </tr> -->
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
                          <div class="panel-body">
                            <div class="pbb_grafik_mon">

                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="tab-pane" id="pbb-tabel">
                    <br>
                    <div class="row">
                      <!-- <div class="col-md-12">
                        <div class="alert bg-primary alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">
                              <i class="fa fa-close"></i>
                            </span>
                          </button>
                          <strong>Sekilas Info! </strong> Klik 2 kali jika hanya memilih 1 tanggal</strong>
                        </div>
                      </div> -->
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table class="table table-bordered pbb_default_datatable">
                            <thead class="bg-primary">
                              <tr>
                                <td>No.</td>
                                <td>Component Code</td>
                                <td style="width:20%">Description</td>
                                <td>OnHand</td>
                                <td>Max Qty</td>
                                <td>SubInv</td>
                                <td>Locator</td>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $no= 1;foreach ($getitembarkas as $key => $value): ?>
                                <tr>
                                  <td><center><?php echo $no++ ?></center></td>
                                  <td><?php echo $value['SEGMENT1'] ?></td>
                                  <td><?php echo $value['DESCRIPTION'] ?></td>
                                  <td><?php echo $value['QTY_ONHAND'] ?></td>
                                  <td><?php echo $value['MAX_MINMAX_QUANTITY'] ?></td>
                                  <td><?php echo $value['SUBINVENTORY_CODE'] ?></td>
                                  <td><?php echo $value['LOCATOR'] ?></td>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                          </table>
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
  </div>
</section>
