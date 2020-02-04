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
            <li class="nav-item" style="background:#e7e7e7">
              <a class="nav-link" onclick="dodo2()" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">SUDAH ALLOCATE <span id="jumlah2"></span></a>
            </li>
            <li class="nav-item" style="background:#e7e7e7">
              <a class="nav-link" onclick="dodo3()" id="pills-transact-tab" data-toggle="pill" href="#pills-transact" role="tab" aria-controls="pills-home" aria-selected="true">SUDAH TRANSACT <span id="jumlah3"></span></a>
            </li>
            <li class="nav-item" style="background:#e7e7e7">
              <a class="nav-link" onclick="dodo4()" id="pills-transact-tab" data-toggle="pill" href="#pills-cetak" role="tab" aria-controls="pills-home" aria-selected="true">SUDAH CETAK <span id="jumlah4"></span></a>
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
          <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
            <div id="loadingArea2" style="display:none;">
              <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
            </div>
            <div class="table_area_DO_2">

            </div>
          </div>

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
