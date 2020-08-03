<input type="hidden" id="cek-pbi-pengiriman" value="ok">
<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;"><i class="fa fa-newspaper-o"></i> Monitoring Pengiriman Barang Internal</h4>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-3">
             <span style="font-weight:bold;">VOIP</span>   <br>
              Seksi Pengeluaran PUSAT : <span style="color:red;font-weight:bold">13401 / 13416</span>  <br>
              Seksi Penerimaan PUSAT : <span style="color:red;font-weight:bold">13405</span> <br>
            </div>
            <div class="col-md-3">
              <span style="color:transparent">VOIP</span><br>
              Seksi Pengeluaran TKS : <span style="color:red;font-weight:bold">23401</span>  <br>
              Seksi Penerimaan TKS :  <span style="color:red;font-weight:bold">23400</span>  <br>
            </div>
            <div class="col-md-6"> </div>

          </div>
          <div class="area-pengiriman">

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-xl" id="Mpbi" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">DETAIL (<span id="nodoc"></span>) </h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal">Close</button>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <center>
                    <div id="loading-pbi" style="display:none;">
                      <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                    </div>
                  </center>
                  <div id="table-pbi-area">

                  </div>
                </div>
                <!-- <center><button type="button" class="btn btn-success" name="button" id="rootbutton" onclick="rootsubmit()" style="font-weight:bold;display:none;margin-top:10px">ROOT APPROVE</button> -->
              </div>
            </div>
      		</div>
      	</div>
      </div>
    </div>
  </div>
</div>

<!-- edit -->
<div class="modal fade bd-example-modal-md" id="edit_pbi" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">EDIT (<span id="nodoc_edit"></span>) </h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal">Close</button>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group b01dqd" hidden>
                      <label for="tujuan">Seksi Tujuan</label>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-4">
                            <select class="form-control select2PBI" style="width:100%" id="employee" onchange="nama()" name="employee_seksi_tujuan" required></select>
                          </div>
                          <div class="col-md-8">
                            <input type="text" class="form-control" id="seksi_tujuan" name="seksi_tujuan" value="" readonly>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="area-edit-pbi">

                    </div>
                  </div>
                </div>
                <!-- <center><button type="button" class="btn btn-success" name="button" id="rootbutton" onclick="rootsubmit()" style="font-weight:bold;display:none;margin-top:10px">ROOT APPROVE</button> -->
              </div>
            </div>
      		</div>
      	</div>
      </div>
    </div>
  </div>
</div>
