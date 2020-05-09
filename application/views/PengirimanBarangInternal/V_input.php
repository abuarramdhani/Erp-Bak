<input type="hidden" id="cekapp" value="punyaPBI">
<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;"><i class="fa fa-cloud-upload"></i> Input Data PBI</h4>
        </div>
        <div class="box-body">
          <div class="row">
            <form action="<?php echo base_url('PengirimanBarangInternal/Input/Save') ?>" method="post">
            <div class="col-md-2"></div>
            <div class="col-md-8 mt-4">
              <br>
                <div class="form-group">
                  <label for="seksi_pengirim">Tujuan</label>
                  <div class="row">
                    <div class="col-md-12">
                      <select class="form-control select2" name="tujuan" required>
                        <option value="PUSAT">PUSAT</option>
                        <option value="MLATI">MLATI</option>
                        <option value="TUKSONO">TUKSONO</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="seksi_pengirim">Pengirim</label>
                  <div class="row">
                    <div class="col-md-4">
                      <input type="text" class="form-control" id="nama_pengirim" name="nama_pengirim" value="<?php echo $this->session->employee ?>" readonly>
                    </div>
                    <div class="col-md-8">
                      <input type="text" class="form-control" id="seksi_pengirim" name="seksi_pengirim" value="" readonly>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="tujuan">Penerima</label>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4">
                        <select class="form-control select2PBI" id="employee" onchange="nama()" name="employee_seksi_tujuan" required></select>
                      </div>
                      <div class="col-md-8">
                        <input type="text" class="form-control" id="seksi_tujuan" name="seksi_tujuan" value="" readonly>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-12 mt-4">
              <hr>
            </div>
            <div class="col-lg-12 mt-4">
                <div class="table-responsive">
                    <div class="row" style="margin: 1px;">
                        <div class="panel-body">
                          <table class="table table-bordered cektable">
                            <thead class="bg-success">
                              <tr>
                                <th class="text-center" style="width:35px; !important">Line</th>
                                <th class="text-center" style="width:250px; !important">Item Code</th>
                                <th class="text-center" style="width:300px;">Description</th>
                                <th class="text-center" style="width:120px;">Quantity</th>
                                <th class="text-center" style="width:70px;">UOM</th>
                                <th class="text-center" style="width:110px;">Item Type</th>
                                <th class="text-center" style="width:50px;">Add/Min</th>
                              </tr>
                            </thead>
                            <tbody id="tambahisi">
                              <tr id="teer1">
                                <td class="text-center"><input type="text" class="form-control" name="line_number[]" value="1" readonly></td>
                                <td class="text-center"><select class="form-control select2PBILine" id="item_code_1" name="item_code[]" onchange="autofill(1)" required></select></td>
                                <td class="text-center"><input type="text" class="form-control" id="description_1" name="description[]" readonly></td>
                                <td class="text-center"><input type="number" class="form-control" name="quantity[]" required></td>
                                <td class="text-center"><input type="text" class="form-control" id="uom_1" name="uom[]" readonly></td>
                                <td class="text-center"><input type="text" class="form-control" id="itemtype_1" name="item_type[]" readonly></td>
                                <td class="text-center"><a class="btn btn-default btn-sm" onclick="btnPlusPBI()"><i class="fa fa-plus"></i></a></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="panel-body">
                          <button type="submit" style="float:right !important;font-weight:bold" onclick="summitpbiarea()" class="btn btn-success" name="button">Submit</button>
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
