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
                 <h4 style="font-weight:bold"><i aria-hidden="true" class="fa fa-file-pdf-o"></i> Pengiriman Barang Bekas Stok</h4>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12">
                    <?php echo $this->session->flashdata('message_pbbs') ?>
                  </div>
                </div>
                <form class="form_submit_pbbs" action="" method="post">
                <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-8">
                    <br>
                      <table style="width:100%">
                        <tr>
                          <td style="width:15%"><b>Seksi</b> </td>
                          <td style="width:5%;">:</td>
                          <td style="width:80%">
                            <select class="slc_pbb_seksi" name="seksi_n_cc" style="width:100%" required>
                              <option value="">Select..</option>
                              <?php foreach ($seksi as $key => $value): ?>
                                <option value="<?php echo $value['PEMAKAI'] ?> ~ <?php echo $value['COST_CENTER'] ?>"><?php echo $value['PEMAKAI'] ?></option>
                              <?php endforeach; ?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td><b>Cost Center</b> </td>
                          <td>:</td>
                          <td>
                            <input type="text" style="width:40%" class="form-control" id="pbb_cost_center" readonly name="" value="">
                          </td>
                        </tr>
                        <tr>
                          <td><b>SubInv</b> </td>
                          <td>:</td>
                          <td>
                            <select class="slc_pbb pbb_subinv" name="subinv" style="width:100%">
                              <option value="">Select..</option>
                              <?php foreach ($subinv as $key => $value): ?>
                                <option value="<?php echo $value['SUBINV'] ?> - <?php echo $value['ORGANIZATION_ID'] ?>"><?php echo $value['SUBINV'] ?> - <?php echo strtoupper($value['DESCRIPTION']) ?></option>
                              <?php endforeach; ?>
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
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-12">
                    <hr>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-responsive">
                        <div class="panel-body">
                          <table class="table table-bordered pbbs_table" style="width:100%">
                            <thead class="bg-primary">
                              <tr>
                                <th class="text-center" style="width:5%; !important">No</th>
                                <th class="text-center">Item Code</th>
                                <th class="text-center" style="width:10%">Onhand</th>
                                <th class="text-center" style="width:10%;">Jumlah</th>
                                <th class="text-center" style="width:7%;">UOM</th>
                                <th class="text-center" style="width:10%;">Plus/Min</th>
                              </tr>
                            </thead>
                            <tbody id="pbbs_set_row">
                              <tr row-id="1">
                                <td class="text-center">1</td>
                                <td class="text-center check_pbb_param"style="vertical-align:middle">
                                  <select class="form-control slc_pbb_item" id="item_code_1" name="item_code[]" style="text-transform:uppercase !important;width:582px;" required>
                                    <option selected="selected"></option>
                                  </select>
                                </td>
                                <td class="text-center"><input type="text" class="form-control" id="onhand" name="onhand[]" readonly autocomplete="off"></td>
                                <td class="text-center"><input type="number" class="form-control" id="jumlah" name="jumlah[]" required></td>
                                <td class="text-center"><input type="text" class="form-control" id="pbb_uom" name="uom[]" readonly></td>
                                <td class="text-center"><button type="button" class="btn btn-default btn-sm" onclick="btnPBBS()"><i class="fa fa-plus"></i></button></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="panel-body check_locator__">
                          <button type="submit" style="float:right !important;font-weight:bold" class="btn btn-success btn_pbbs_submit" name=""><i class="fa fa-file"></i> Submit</button>
                        </div>
                    </div>
                  </div>
                </div>
              </form>
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>
  </div>
</section>
