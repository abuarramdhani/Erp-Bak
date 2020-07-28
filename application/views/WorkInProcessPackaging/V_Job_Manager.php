<style media="screen">
.modal {
text-align: center;
padding: 0!important;
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
</style>
<input type="hidden" class="wipp" value="1">
<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;"><i class="fa fa-cloud-upload"></i> Job Manager</h4>
        </div>
        <div class="box-body" style="background:#f0f0f0 !important;">
          <div class="row">
            <div class="col-md-6">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:15px;">
              <div class="row">
                <div class="col-md-6">
                  <h4 style="font-weight:bold">LIST RKH</h4>
                </div>
                <div class="col-md-6">
                  <div style="margin-top:15px;float:right">
                    <div style="width: 20%;color:transparent; border:1px solid #5e5e5e;display:inline;background:#f4f4f4">______</div> <span style="display:inline"> : Reguler</span>
                    <div style="width: 20%;color:transparent; margin-top: 5px;border:1px solid #5e5e5e; background:rgba(255, 0, 84, 0.29);display:inline;margin-left:5px;">______</div> <span style="display:inline"> : Lembur</span>
                  </div>
                </div>
              </div>
              <hr>
              <div class="table-list-RKH">
               <!-- +_+ -->
              </div>
            </div>
          </div>
            <div class="col-md-6">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:15px;">
              <center> <h4 style="font-weight:bold">PRODUCT PRIORITY</h4> </center>
              <hr>
              <div class="table-product-priority">
                <!-- +_+ -->
              </div>
              <div class="form-group">
                <center><button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#wipp1" name="button"><i class="fa fa-plus-square"></i> <b>Add New</b></button> </center>
              </div>
            </div>
            </div>
            <div class="col-md-12">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:15px;">
              <center> <h4 style="font-weight:bold" onclick="refreshWIPP()">JOB RELEASED</h4> </center>
              <hr>
              <div class="table-job-released">
                <!-- +_+ -->
              </div>
              <div class="form-group">
                <center class="btnWIPP" hidden><button type="button" class="btn btn-md btn-primary btnWIPP" name="button" data-toggle="modal" onclick="getJobReleased()" data-target="#wipp2"><i class="fa fa-plus-square"></i> <b>Create New RKH</b></button> </center>
              </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- wipp1 -->
<div class="modal fade bd-example-modal-md" id="wipp1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;"><i class="fa fa-plus-square"></i> Add New Product Priority</h4>
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
                      <div class="form-group">
                      <div class="col-md-4">
                        <label for="">Kode Komponen</label>
                        <select class="form-control select2itemcodewipp" id="kode_komponen" style="width:100%" required></select>
                      </div>
                      <div class="col-md-8">
                        <label for="">Nama Komponen</label>
                        <input type="text" class="form-control" id="nama_komponen" readonly placeholder="Nama Komponen">
                      </div>
                      <div class="col-md-12">
                        <br>
                        <center><button type="button" class="btn bg-maroon" name="button" onclick="product_priority_save()"><i class="fa fa-file"></i> Save</button>
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
<div class="modal fade bd-example-modal-lg" id="wipp2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;display:inline">Create New RKH</h4>
                  <button type="button" class="btn btn-default btnWippRefresh" style="margin-left: 10px;display:inline"><i class="fa fa-refresh"></i> Refresh</button>
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
                  <div class="form-group">
                    <div class="col-md-4">
                      <h5 style="display:inline-block !important; font-weight:bold">Jenis : </h5>
                      <select class="form-control" id="jenisSaveWIIP" style="width:55%;display:inline-block; margin-left:10px;" autocomplete="off">
                        <option value="">Chosee..</option>
                        <option value="Reguler">Reguler</option>
                        <option value="Lembur">Lembur</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <div style="float:left">
                        <h5 style="display:inline-block !important; font-weight:bold">Tanggal : </h5> <input type="text" onchange="jenisRKH()" autocomplete="off" class="form-control txtWIIPdate" id="dateSaveWIIP" placeholder="..." style="display:inline-block !important; width:65%;" name="" value="">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <h5 style="display:inline-block !important; font-weight:bold">Waktu Satu Shift : </h5> <input type="number" autocomplete="off" id="waktuSaveWIIP" class="form-control" placeholder="..." style="width:50%;display:inline-block; margin-left:10px;" name="" value="">
                    </div>
                    <div class="col-md-12">
                      <br>
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover text-left tblNewRKH" style="font-size:12px;">
                          <thead>
                            <tr class="bg-info">
                              <th><center>NO</center></th>
                              <th><center>NO JOB</center></th>
                              <th><center>KODE ITEM</center></th>
                              <th><center>NAMA ITEM</center></th>
                              <th><center>QTY</center></th>
                              <th><center>USAGE RATE</center></th>
                              <th><center>SCHEDULED START DATE </center></th>
                              <th hidden><center></center></th>
                              <th style="width:15%"><center>ACTION </center></th>
                            </tr>
                          </thead>
                          <tbody id="create-new-rkh">

                          </tbody>
                        </table>
                      </div>
                      <div class="mt-4">
                        <center><button type="button" style="margin-bottom:10px !important;" class="btn bg-maroon wipp_hided" onclick="saveNewRKH()" name="button"><i class="fa fa-file"></i> Save</button>
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
