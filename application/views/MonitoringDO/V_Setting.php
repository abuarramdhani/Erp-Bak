<style media="screen">
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
<input type="hidden" id="punyaeDO" value="trueDO">
<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item active" style="background:#e7e7e7">
              <a class="nav-link" onclick="dodo0()" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">SIAP ASSIGN <span id="jumlah0"></span> </a>
            </li>
            <li class="nav-item" style="background:#e7e7e7">
              <a class="nav-link" onclick="dodo1()" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">SUDAH ASSIGN <span id="jumlah1"></span></a>
            </li>
            <!-- <li class="nav-item" style="background:#e7e7e7">
              <a class="nav-link" onclick="dodo2()" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">SUDAH ALLOCATE <span id="jumlah2"></span></a>
            </li> -->
            <li class="nav-item" style="background:#e7e7e7">
              <a class="nav-link" onclick="dodo3()" id="pills-transact-tab" data-toggle="pill" href="#pills-transact" role="tab" aria-controls="pills-home" aria-selected="true">SUDAH TRANSACT <span id="jumlah3"></span></a>
            </li>
            <li class="nav-item" style="background:#e7e7e7">
              <a class="nav-link" onclick="dodo4()" id="pills-transact-tab" data-toggle="pill" href="#pills-cetak" role="tab" aria-controls="pills-home" aria-selected="true">SUDAH CETAK <span id="jumlah4"></span></a>
            </li>
            <!-- <li class="nav-item" style="background:#e7e7e7">
              <a class="nav-link" onclick="dodo5()" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">SIAP INTERORG <span id="jumlah5"></span></a>
            </li> -->
            <li>
              <h5 style="margin-top:15px;font-weight:bold;margin-left:10px;"> Sub Inventory : <?php echo $this->session->datasubinven ?></h5>
            </li>
          </ul>
        </div>
        <div class="box-body">
          <div class="tab-content" id="pills-tabContent" >
            <div class="tab-pane fade in active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
              <div id="loadingArea0" style="display:none;">
                <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
              </div>
              <div class="table_area_DO_0">

              </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
              <div id="loadingArea1" style="display:none;">
                <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
              </div>
              <div class="table_area_DO_1">

              </div>
            </div>
            <!-- <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
              <div id="loadingArea2" style="display:none;">
                <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
              </div>
              <div class="table_area_DO_2">

              </div>
            </div> -->
            <div class="tab-pane fade" role="tabpanel" id="pills-transact" >
              <div id="loadingArea3" style="display:none;">
                <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
              </div>
              <div class="table_area_DO_3">

              </div>
            </div>
            <div class="tab-pane fade" role="tabpanel" id="pills-cetak" >
              <div id="loadingArea4" style="display:none;">
                <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
              </div>
              <div class="table_area_DO_4">

              </div>
            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
              <div id="loadingArea5" style="display:none;">
                <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
              </div>
              <div class="table_area_DO_5">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- modal area -->
<div class="modal fade bd-example-modal-xl" id="MyModal2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">DETAIL</h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal">Close</button>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <center>
                  <div id="loadingArea" style="display:none;">
                    <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                  </div>
                  </center>
                  <div id="table-area">

                  </div>
                </div>
                <input type="hidden" id="user_mdo">
                <input type="hidden" id="headerid_mdo" >
                <input type="hidden" id="rm_mdo">
                <input type="hidden" id="row_id">
                <!-- <center><button type="button" class="btn btn-success" name="button" id="rootbutton" onclick="rootsubmit()" style="font-weight:bold;display:none;margin-top:10px">ROOT APPROVE</button> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- modal area detail assign -->
<div class="modal fade bd-example-modal-xl" id="MyModalAssign" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">DETAIL</h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal">Close</button>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <center>
                  <div id="loadingArea_Assign" style="display:none;">
                    <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                  </div>
                  </center>
                  <div id="table-area_Assign">

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

<!-- modal area detail ALLOCATE -->
<div class="modal fade bd-example-modal-xl" id="MyModalAllocate" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">DETAIL</h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal">Close</button>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <center>
                  <div id="loadingArea_Terlayani" style="display:none;">
                    <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                  </div>
                  </center>
                  <div id="table-area_Terlayani">

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

<!-- modal area detail TRANSACT -->
<div class="modal fade bd-example-modal-xl" id="MyModalTransact" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">DETAIL</h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal">Close</button>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <center>
                  <div id="loadingArea_Muat" style="display:none;">
                    <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                  </div>
                  </center>
                  <div id="table-area_Muat">

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

<!-- modal area SPBKIT -->
<div class="modal fade bd-example-modal-md" id="MyModalSPBKIT" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;"><span id="tipe_spbkit"></span> <span id="nospbkit"></span> </h4>
                </div>
                <!-- <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal">Close</button> -->
              </div>
              <div class="box-body">
                <form class="cetak_spbkit" action="index.html" method="post">
                  <div class="form-group">
                    <label for="">Org :</label>
                    <div class="row">
                      <div class="col-md-6">
                        <input type="text" class="form-control" id="org_code_spbkit" value="" readonly>
                      </div>
                      <div class="col-md-6">
                        <input type="text" class="form-control" id="org_id_spbkit" value="" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="">Sub.Inv :</label>
                    <select class="select2subinv_spbkit" name="" style="width:100%" required>
                      <option value=""></option>
                    </select>
                  </div>
                  <center><button type="submit" class="btn btn-success" name="button" style="font-weight:bold;margin-top:10px;margin-bottom:10px"> <i class="fa fa-save"></i> Submit </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
