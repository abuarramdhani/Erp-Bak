<style media="screen">
  td{
    padding-bottom: 20px !important;
  }
  .modal {
  text-align: center;
  padding: 0!important;
  overflow-y: auto !important;
  }

  .modal:before {
  content: '';
  display: inline-block;
  height: 100%;
  vertical-align: middle;
  margin-right: -4px; /* Adjusts for spacing */
  }

  .modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
  }
  body{
    padding-right: 0px!important;
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
                 <h4 style="font-weight:bold"><i aria-hidden="true" class="fa fa-file"></i> Pengiriman Barang Bekas - Transact</h4>
              </div>
              <div class="panel-body">
                <form class="form-pbb-transact" action="" method="post">
                <div class="row">
                  <div class="col-md-7">
                    <div class="row mb-4">
                      <div class="col-md-12">
                        <b style="font-size:20px;color:#3c8dbc">Asal</b>
                      </div>
                    </div>
                    <table style="width:100%">
                      <tr>
                        <td><b>No Document</b> </td>
                        <td>:</td>
                        <td>
                          <select class="form-control slc_pbb pbb_transact" name="no_document" style="text-transform:uppercase !important;width:100%;" required>
                            <option value="">Cari Dokumen..</option>
                            <?php foreach ($document_number as $key => $value): ?>
                              <option value="<?php echo $value['DOCUMENT_NUMBER'] ?>"><?php echo $value['DOCUMENT_NUMBER'] ?></option>
                            <?php endforeach; ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td style="width:15%"><b>Seksi</b> </td>
                        <td style="width:5%;">:</td>
                        <td style="width:80%">
                          <input type="text" class="form-control" readonly id="pbbt_seksi" name="seksi" value="" required>
                        </td>
                      </tr>
                      <tr>
                        <td><b>Cost Center</b> </td>
                        <td>:</td>
                        <td>
                          <input type="text" class="form-control" id="pbbt_cost_center" readonly name="cost_center" value="">
                        </td>
                      </tr>
                      <tr id="pbbt_subinv_check" hidden>
                        <td><b>SubInv</b> </td>
                        <td>:</td>
                        <td>
                          <input type="text" class="form-control" id="pbbt_subinv" readonly name="subinv" value="">
                        </td>
                      </tr>
                      <tr id="pbbt_locator_check" hidden>
                        <td><b>Locator</b> </td>
                        <td>:</td>
                        <td class="pbb_locator">
                          <input type="text" class="form-control" readonly id="pbbt_locator" name="locator" value="">
                        </td>
                      </tr>
                    </table>
                  </div>
                  <div class="col-md-5">
                    <div class="row mb-4">
                      <div class="col-md-12">
                        <b style="font-size:20px;color:#3c8dbc">Tujuan</b>
                      </div>
                    </div>
                    <table style="width:100%">
                      <tr>
                        <td style="width:15%"><b>Tujuan</b> </td>
                        <td style="width:5%;">:</td>
                        <td style="width:80%">
                          <input type="radio" name="pbb_tujuan" style="width:20px;height:20px" value="BARKAS-DM"> <label for="norm" class="control-label" >&nbsp;&nbsp;Pusat </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="pbb_tujuan" style="width:20px;height:20px" value="BARKAST-DM"><label for="norm" class="control-label" >&nbsp;&nbsp; Tuksono </label>
                        </td>
                      </tr>
                      <tr>
                        <td><b>Locator</b> </td>
                        <td>:</td>
                        <td class="pbb_locator_tujuan">
                          -
                        </td>
                      </tr>
                      <tr>
                        <td><b>Item</b> </td>
                        <td>:</td>
                        <td>
                          <select class="form-control slc_pbb" id="pbbtt_item" name="" style="width:350px">
                            <option value="">Select..</option>
                            <?php foreach ($item as $key => $value): ?>
                              <option value="<?php echo $value['INVENTORY_ITEM_ID'] ?>"><?php echo $value['SEGMENT1'] ?> -  <?php echo $value['DESCRIPTION'] ?></option>
                            <?php endforeach; ?>
                          </select>
                        </td>
                      </tr>
                    </table>
                  </div>
                  <div class="col-md-12">
                    <hr>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="pbbt_area_item">
                      <div class="table-responsive">
                        <table class="table table-bordered table_pbbt" style="width:100%">
                          <thead class="bg-primary">
                            <tr>
                              <th class="text-center" style="width:5%; !important">No</th>
                              <th class="text-center">Item Code</th>
                              <th class="text-center" style="width:10%">Onhand</th>
                              <th class="text-center" style="width:10%;">Jumlah</th>
                              <th class="text-center" style="width:10%;">UOM</th>
                              <th class="text-center" style="width:10%;">Terima</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <button type="button" style="float:right !important;font-weight:bold"  class="btn btn-success submit-pbb-transact" name=""><i class="fa fa-file"></i> Transact</button>
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
