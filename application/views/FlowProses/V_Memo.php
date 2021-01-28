<style media="screen">
  body{
    padding-right: 0px!important;
  }
</style>
<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;"><i class="fa fa-legal"></i> Memo Data</h4>
        </div>
        <div class="box-body" style="background:#f0f0f0 !important;">
          <div class="row">
            <div class="col-md-12" style="margin-top:10px">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:15px;">
                   <i class="text-danger"><b>NB :</b> Proses Approval Dilakukan Di Dalam Detail Memo</i>
                  <div class="row"  style="margin-top:20px;">
                    <div class="col-md-6">
                      <label for="" style="font-weight:bold;">Tipe</label><br>
                      <select class="select2" id="fp_tipe_produk_memo" style="width:100% !important">
                        <option value="Product">Mass Production</option>
                        <option value="Prototype">Prototype</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label for="" style="font-weight:bold;">Search by product</label><br>
                      <select class="select2" id="product_fp_memo" style="width:100% !important">
                        <option value="" selected>Choose..</option>
                        <?php foreach ($product as $key => $value): ?>
                          <option value="<?php echo $value['product_name'] ?>"><?php echo $value['product_name'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <hr>
                  <div id="table-area-memo-fp" style="margin-top:20px;">  </div>
            </div>
          </div>


          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-lg"  id="modalfpmemocomponent" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left;margin-top:6px;">
                  <h4 style="font-weight:bold;display:inline;">Memo (<span id="fp_memo"></span>)</h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal"><i class="fa fa-close"></i></button>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="fp-area-memo">

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
