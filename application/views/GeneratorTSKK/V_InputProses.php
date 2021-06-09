<style type="text/css">
  .modal {
    text-align: center;
    padding: 0 !important;
  }

  .modal:before {
    content: '';
    display: inline-block;
    height: 100%;
    vertical-align: middle;
    margin-right: -4px;
    /* Adjusts for spacing */
  }

  .modal-dialog {
    display: inline-block;
    text-align: left;
    vertical-align: middle;
  }

  body {
    padding-right: 0px !important;
  }

  #inputElemen {
    border-radius: 25px;
  }

  #save {
    border-radius: 25px;
  }

  input[type="text"]::placeholder {
    /* Firefox, Chrome, Opera */
    text-align: center;
  }
</style>

<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="text-center">
              <h1><b>Manajemen Proses</b></h1>              
            </div>
          </div>
        </div>
        <br />

        <div class="row" style="">
          <div class="col-lg-12">
            <div class="box box-primary color-palette-box">
              <div class="box-body">
                <ul class="nav nav-tabs pull-right">
                </ul>
                <div class="tab-content">
                  <div class="row">
                    <div class="col-md-12">
                      <div style="float:right;margin-top:5px;"><button type="button" data-toggle="modal" data-target="#modalgtskk1" class="btn btn-success" name="button"> <i class="fa fa-plus"></i> Tambah Proses</button></div>
                    </div>
                    <div class="col-md-12" style="margin-top:10px">
                      <div class="table-area-proses-gtskk">
                        <div class="table-responsive">
                          <table class="table table-striped table-bordered table-hover text-left dt-gentskk" style="font-size:11px;">
                            <thead class="bg-primary">
                              <tr>
                                <th style="text-align:center;width:5%">No</th>
                                <th>Nama Proses</th>
                                <th style="width:20%">Kode Proses</th>
                                <th style="text-align:center;width:10%">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($get as $key => $value): ?>
                                <tr>
                                  <td style="text-align:center"><?php echo $key+1 ?></td>
                                  <td><?php echo $value['PROSES'] ?></td>
                                  <td><?php echo $value['KODE_PROSES'] ?></td>
                                  <td>
                                    <center>
                                      <button type="button" class="btn btn-danger btn-sm" style="border-radius:7px;" onclick="delprosesgtskk(<?php echo $value['ID_PROSES'] ?>)" name="button"><i class="fa fa-trash"></i></button>
                                      <button type="button" data-toggle="modal" data-target="#modalgtskk_u1" class="btn btn-sm btn-success" style="border-radius:7px;" onclick="ambildataprosesby('<?php echo $value['ID_PROSES'] ?>', '<?php echo $value['PROSES'] ?>', '<?php echo $value['KODE_PROSES'] ?>')" name="button">
                                       <i class="fa fa-pencil"></i>
                                      </button>
                                    </center>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                          </table>
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
  </div>
</section>


<!-- save -->
<div class="modal fade bd-example-modal-lg" id="modalgtskk1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left;margin-top:6px;">
                  <h4 style="font-weight:bold;display:inline;"> <i class="fa fa-cube"></i> Tambah Proses</h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal"><i class="fa fa-close"></i></button>
              </div>
              <div class="box-body">
                <div class="row p-3">
                  <div class="col-md-8">
                    <div class="form-data">
                      <label for="" style="margin-top:10px;">Nama Proses</label>
                      <input type="text" class="form-control touppergtskk" id="gtskk_proses" value="" autocomplete="off">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-data">
                      <label for="" style="margin-top:10px;">Kode Proses</label>
                      <input type="text" class="form-control touppergtskk" id="gtskk_kode_proses" value="" autocomplete="off">
                    </div>
                  </div>
                  <div class="col-md-12">
                  <br>
                  <center>
                    <button type="button" class="btn btn-success mt-2" style="width:30%" onclick="saveGtskkProses()" name="button"> <i class="fa fa-file"></i> <b>Save</b> </button>
                  </center>
                  <br>
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

<!-- update -->
<div class="modal fade bd-example-modal-lg" id="modalgtskk_u1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left;margin-top:6px;">
                  <h4 style="font-weight:bold;display:inline;"> <i class="fa fa-cube"></i> Update Proses</h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal"><i class="fa fa-close"></i></button>
              </div>
              <div class="box-body">
                <div class="row p-3">
                  <div class="col-md-8">
                    <div class="form-data">
                      <input type="hidden" id="id_proses" value="">
                      <label for="" style="margin-top:10px;">Nama Proses</label>
                      <input type="text" class="form-control touppergtskk" id="gtskk_proses_u" value="" autocomplete="off">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-data">
                      <label for="" style="margin-top:10px;">Kode Proses</label>
                      <input type="text" class="form-control touppergtskk" id="gtskk_kode_proses_u" value="" autocomplete="off">
                    </div>
                  </div>
                  <div class="col-md-12">
                  <br>
                  <center>
                    <button type="button" class="btn btn-success mt-2" style="width:30%" onclick="updateProses()" name="button"> <i class="fa fa-pencil"></i> <b>Update</b> </button>
                  </center>
                  <br>
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
