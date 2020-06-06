<input type="hidden" class="wipp2" value="<?php echo $param ?>">
<input type="hidden" class="wipp2_" value="2">
<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;"><i class="fa fa-cloud-upload"></i> Job Manager</h4>
        </div>
        <div class="box-body" style="background:#f0f0f0 !important;">
          <div class="row">

            <div class="col-md-12">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:15px;">
                <center>
                  <h4 style="font-weight:bold">JOB LIST</h4>
                </center>
                <div class="table-list-arrange">

                </div>
                <div class="form-group">
                  <center><button type="button" class="btn btn-md btn-primary" name="button" onclick="arrange('<?php echo $param ?>')"><i class="fa fa-gears"></i> <b>Arrange</b></button> </center>
                </div>
              </div>
            </div>
            <form action="<?php echo base_url('WorkInProcessPackaging/JobManager/saveLine') ?>" method="post">
              <input type="hidden" name="param" value="<?php echo $param ?>">
              <div class="lines-area">

              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- wipp2 -->
<div class="modal fade bd-example-modal-lg" id="wipp2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">SPLIT JOB (<span id="jobnumber"></span>)</h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal"><i class="fa fa-close"></i></button>
              </div>
              <div class="box-body">
                <center>
                  <div id="loading-pbi" style="display:none;">
                    <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                  </div>
                </center>
                <div class="row">
                  <div class="col-md-12">
                    <div class="box-body" style="background:#ffffff !important; border-radius:7px;">
                      <center>
                        <h4 style="font-weight:bold;display:inline-block;">QTY Avaliable :</h4> <input type="number" onkeyup="splitqty()" id="qtySplit" style="display:inline-block;width:10%;margin-left:10px;" class="form-control" placeholder="QTY">
                      </center>
                      <input type="hidden" id="qty_split_save" readonly>
                      <input type="hidden" id="usage_rate_split" readonly>
                      <input type="hidden" id="wss" readonly>
                      <input type="hidden" id="dt" readonly>
                      <input type="hidden" id="created_at" readonly>
                      <br>
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover text-left line0wipp" style="font-size:11px;">
                          <thead>
                            <tr class="bg-info">
                              <th style="width:26%">
                                <center>JOB</center>
                              </th>
                              <th style="width:35%">
                                <center>ITEM</center>
                              </th>
                              <th style="width:17%">
                                <center>QTY</center>
                              </th>
                              <th style="width:17%">
                                <center>TARGET PE (%)</center>
                              </th>
                              <th hidden>
                                <center>CREATED AT</center>
                              </th>
                              <th style="width:5%">
                                <center><button type="button" class="btn btn-sm bg-navy" onclick="addrowlinewipp0()" style="border-radius:10px;" name="button"><i class="fa fa-plus-square"></i></button></center>
                              </th>
                            </tr>
                          </thead>
                          <tbody id="tambahisiwipp0" class="tbl_row_split">

                          </tbody>
                        </table>
                        <br>
                        <center class="btnsplit" hidden><button type="button" style="margin-bottom:10px !important;" hidden class="btn bg-maroon" onclick="saveSplit()" name="button"><i class="fa fa-file"></i> Save</button>
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

<!-- wipp2 -->
<div class="modal fade bd-example-modal-sm" id="wipp4" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h5 style="font-weight:bold;">SETTING TARGET LINE <span id="linenumber"></span></h5>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal"><i class="fa fa-close"></i></button>
              </div>
                <div class="box-body">
                  <center>
                    <div id="loading-wipp" style="display:none;">
                      <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                    </div>
                  </center>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="box-body" style="background:#ffffff !important; border-radius:7px;">
                        <input type="text" class="form-control" name="" id="get_val_target_pe_max" required autocomplete="off">
                        <br>
                        <center><button type="button" class="btn bg-maroon" onclick="updateTargetPe()" name="button"><i class="fa fa-file"></i> Update</button>
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
