
<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;"><i class="fa fa-cube"></i> Data Component</h4>
        </div>
        <div class="box-body" style="background:#f0f0f0 !important;">
          <div class="row">
            <div class="col-md-12" style="margin-top:10px">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:15px;">
                <div class="row">
                  <div class="col-md-6">
                    <label for="" style="font-weight:bold;">Tipe</label><br>
                    <select class="select2" id="fp_tipe_produk" style="width:100% !important">
                      <option value="product" selected>Mass Production</option>
                      <option value="prototype">Prototype</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="" style="font-weight:bold;">Search by product</label><br>
                    <select class="select2" id="product_fp" style="width:100% !important">
                      <option value="" selected>Choose..</option>
                      <?php foreach ($product as $key => $value): ?>
                        <option value="<?php echo $value['product_id'] ?>"><?php echo $value['product_name'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <hr>
                <div class="fp_area_component">
                  <div class="table-responsive" style="margin-top:13px;">
                    <table class="table table-striped table-bordered table-hover text-left dt-fp-comp" style="font-size:11px;">
                      <thead class="bg-primary">
                        <tr>
                          <th style="text-align:center; width:5%">
                              No
                          </th>
                          <th>
                              Product
                          </th>
                          <th>
                              Code
                          </th>
                          <th style="min-width: 100px">
                              Number
                          </th>
                          <th style="min-width: 170px">
                              Description
                          </th>
                          <th style="max-width: 20px;">
                              Rev
                          </th>
                          <th style="min-width: 70px">
                              Revision Date
                          </th>
                          <th>
                              Material Type
                          </th>
                          <th style="min-width: 100px">
                              Oracle Item
                          </th>
                          <th>
                              Weight
                          </th>
                          <th>
                              Status
                          </th>
                          <th>
                              Upper Level
                          </th>
                          <th>
                              Memo Number
                          </th>
                          <th style="min-width: 170px">
                              Explanation
                          </th>
                          <th style="min-width: 170px">
                              Changing Date
                          </th>
                          <th>
                              Changing Status
                          </th>
                          <th>
                              File
                          </th>
                          <th>
                              Qty
                          </th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="fp_area_prototype">

                </div>
                  <br>
                  <i class="text-danger">*Default search avaliable on column <b>Code</b>, <b>Number</b>, <b>Description</b>, <b>Material Type</b> </i>

              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-lg"  id="modalfpgambar" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="width:90%" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left;margin-top:6px;">
                  <h4 style="font-weight:bold;display:inline;">Gambar Kerja (<span id="fp_code_component"></span>)</h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal"><i class="fa fa-close"></i></button>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="area-gambar-kerja">

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
