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
  .al_up2l td{
    padding-bottom: 20px !important;
  }
</style>
<section class="content">
    <div class="inner">
        <div class="row">
            <form autocomplete="off" method="post" action="<?php echo site_url('ManufacturingOperationUP2L/Selep/create'); ?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                    <h1><b><?= $Title ?></b></h1>
                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/Selep/'); ?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <span><br /></span> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Create Selep</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                        <div class="form-group">
                                            <label for="txtSelepDateHeader" class="control-label col-lg-4">Selep Date</label>
                                            <div class="col-lg-6">
                                            <input type="text" name="txtSelepDateHeader" class="form-control time-form1 ajaxOnChange" placeholder="Production Date">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="txtShift" class="control-label col-lg-4">Shift</label>
                                            <div class="col-lg-6">
                                                <select class="form-control slcShift" id="txtShift" name="txtShift">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="box box-default box-solid">
                                                <div class="box-header with-border"><div class="col-lg-12">
                                                <div class="col-lg-10">
                                                    <b>Employee</b>
                                                </div>
                                                <div class="col-lg-2">
                                                        <button class="btn btn-info" onclick="add_emp_selep()" style="color:white;"><i class="fa fa-plus"></i></button>
                                                        <button class="btn btn-danger" onclick="remove_emp_selep()" style="color:white;"><i class="fa fa-close"></i></button>
                                                </div>
                                                </div></div>
                                                <div class="panel-body" id="container-employee">
                                                    <div class="form-group employee">
                                                        <label for="txtSelepQuantityHeader" class="control-label col-lg-4">Nama</label>
                                                        <div class="col-lg-6">
                                                            <select class="form-control jsSlcEmpl toupper" id="txtEmployeeHeader" style="width:100%" name="txt_employee[]" required data-placeholder="Employee Name">
                                                                <option></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="box box-default box-solid">
                                                <div class="box-header with-border">
                                                    <div class="col-lg-12">
                                                        <div class="col-lg-10"><b>Component</b></div>
                                                        <div class="col-lg-2" style="float:right;">
                                                            <button onclick="<!--addcompSelep()-->" class="btn btn-info" style="display:none"> <i class="fa fa-plus"></i></button>
                                                            <button onclick="<!--delcompSelep()-->" class="btn btn-danger" style="display:none"> <i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-body" id="container-component">
                                                    <div class="form-group">
                                                        <label for="txtComponentCodeHeader" class="control-label col-lg-4">Component</label>
                                                        <div class="col-lg-6">
                                                            <select class="form-control jsSlcComp toupper" style="width:100%" id="txtComponentCodeHeader" name="component_code[]" required data-placeholder="Component Code">
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="txtSelepQuantityHeader" class="control-label col-lg-4">Selep Quantity</label>
                                                        <div class="col-lg-6">
                                                          <input type="number" placeholder="Selep Quantity" name="txtSelepQuantityHeader[]" id="txtSelepQuantityHeader" class="form-control" />
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="txtSelepQuantityHeader" class="control-label col-lg-4">Batch Number</label>
                                                        <div class="col-lg-6">
                                                          <input type="number" placeholder="Batch No" readonly name="txtSelepBatchHeader" id="txtSelepBatchHeader" class="form-control" />
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="txtKeterangan" class="control-label col-lg-4">Keterangan</label>
                                                        <div class="col-lg-6">
                                                            <select name="txtKeterangan[]" class="form-control">
                                                                <option value="">null</option>
                                                                <option value="RE">RE</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="box box-default box-solid">
                                                    <div class="box-header with-border">
                                                        <div class="col-lg-12">
                                                            <div class="col-lg-10"><b>Pemotongan Target</b></div>
                                                        </div>
                                                    </div>
                                                    <div class="panel-body" id="container-component">
                                                        <div class="form-group">
                                                            <label for="txtKeteranganPemotonganTarget" class="control-label col-lg-4">Keterangan</label>
                                                            <div class="col-lg-6">
                                                                <input type="text" placeholder="Keterangan Pemotongan Target" name="txtKeteranganPemotonganTarget" id="txtKeteranganPemotonganTarget" maxlength="29" class="form-control" />
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="txtJamPemotonganTarget" class="control-label col-lg-4">Jam</label>
                                                            <div class="col-lg-6">
                                                                <input type="text" name="txtJamPemotonganTarget" id="txtJamPemotonganTarget" class="txtJamPemotonganTarget form-control" disabled="disabled" />
                                                            </div>
                                                            <span class="btn btn-info onBtn" >ON</span>
                                                            <span class="btn btn-danger offBtn" style="display: none">OFF</span>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>


                                    </div>
                                    <div class="panel-footer ">
                                      <div class="row">
                                        <div class="col-md-6 text-left">
                                          <button type="button" data-toggle="modal" data-target="#modalUP2LCreateKIB" class="btn btn-danger btn-lg btn-up2l-cetakkib" ><i class="fa fa-file-pdf-o"></i></i>  Cetak KIB</button>
                                          <button type="button" data-toggle="modal" data-target="#modalUP2LCompleteJob" class="btn btn-primary btn-lg btn-complate-job" disabled><i class="fa fa-upload"></i></i>  Complete Job</button>
                                          <button type="button" onclick="createBatchMO()" class="btn btn-primary btn-lg"><i class="fa fa-rocket"></i></i>  Create Batch</button>
                                        </div>
                                        <div class="col-md-6 text-right">
                                          <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i></i>  Save</button>
                                          <a href="<?php echo site_url('ManufacturingOperationUP2L/Selep'); ?>" class="btn btn-danger btn-lg"><i class="fa fa-arrow-left"></i></i>  Back</a>
                                        </div>
                                      </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- show recipe -->
<div class="modal fade bd-example-modal-lg" id="modalMOreceip" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;" id="mo_comp_code"> </h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal"><i class="fa fa-times"></i></button>
              </div>
              <div class="box-body">
                <div class="form-group">
                  <label for="">Sub.Inv :</label>
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-external-link"></i></div>
                    <select class="select2subinv_up2l" name="" style="width:100%">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Selep Quantity</label>
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-balance-scale"></i></div>
                    <input type="number" readonly id="txtSelepQuantityHeaderModal" class="form-control"/>
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Pilih Salah Satu Recipe Number</label>
                  <table class="table table-bordered" style="width:100%;text-align:center">
                    <thead class="bg-primary">
                      <tr>
                        <td>ITEM</td>
                        <td>ITEM_ID</td>
                        <td>RECIPE_ID</td>
                        <td>RECIPE_NO</td>
                        <td>RECIPE_VERSION</td>
                        <td>UOM</td>
                        <td>ACTION</td>
                      </tr>
                    </thead>
                    <tbody id="area-up2l-body-recipe">

                    </tbody>
                  </table>
                </div>

                  <!-- <center><button type="submit" class="btn btn-success" name="button" style="font-weight:bold;margin-top:10px;margin-bottom:10px"> <i class="fa fa-save"></i> Submit </button> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- show complate job -->
<div class="modal fade bd-example-modal-md" id="modalUP2LCompleteJob" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">Complete Job</h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal"><i class="fa fa-times"></i></button>
              </div>
              <div class="box-body">
                <div class="form-group">
                  <label for="txtComponentCodeHeader" class="control-label">Component</label>
                  <input type="text" id="txtSelepComponentConfrm" class="form-control" readonly />
                </div>
                <div class="form-group">
                  <label for="txtSelepQuantityHeader" class="control-label">Selep Quantity</label>
                  <input type="number" id="txtSelepQuantityConfrm" class="form-control" readonly />
                </div>
                <div class="form-group">
                  <label for="txtSelepQuantityHeader" class="control-label">Batch Number</label>
                  <input type="number" id="txtSelepBatchConfrm" class="form-control" readonly />
                </div>
                <center><button type="button" onclick="completejobUP2L2021()" class="btn btn-success" name="button" style="font-weight:bold;margin-top:10px;margin-bottom:10px;width:20%"> <i class="fa fa-save"></i> Submit </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- prepare cetak kib -->
<div class="modal fade bd-example-modal-lg" id="modalUP2LCreateKIB" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">Create KIB</h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal"><i class="fa fa-times"></i></button>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-10">
                    <form class="" target="_blank" action="<?php echo base_url('ManufacturingOperationUP2L/Selep/generate_kib') ?>" method="post">
                      <br>
                      <table style="width:100%" class="al_up2l">
                        <tr>
                          <td style="width:15%"><b>IO Tujuan</b> </td>
                          <td style="width:5%;">:</td>
                          <td style="width:80%">
                            <select class="slcUP2L2021 up2l_io_99" name="io" style="width:100%" required>
                              <option value="">Select..</option>
                              <?php foreach ($io as $key => $value): ?>
                                <option value="<?php echo $value['ORGANIZATION_ID'] ?>"><?php echo strtoupper($value['ORGANIZATION_CODE']) ?></option>
                              <?php endforeach; ?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td><b>SubInv Tujuan</b> </td>
                          <td>:</td>
                          <td class="pbb_sudah_pilih_io">
                            <select class="slcUP2L2021 up2l_subinv_99" name="subinv" style="width:100%" required>
                              <option value="">Select..</option>
                            </select>
                          </td>
                        </tr>
                        <tr id="locator_check">
                          <td><b>Locator Tujuan</b> </td>
                          <td>:</td>
                          <td class="up2l_locator">
                            <input type="text" readonly class="form-control slc_up2l_locator" name="locator" value="">
                          </td>
                        </tr>
                        <tr id="">
                          <td><b>Batch Number</b> </td>
                          <td>:</td>
                          <td class="">
                            <input type="number" id="txtSelepBatchCetakKIB" name="batch_no" class="form-control" readonly />
                          </td>
                        </tr>
                        <tr id="">
                          <td><b>Selep Quantity</b> </td>
                          <td>:</td>
                          <td class="">
                            <input type="number" id="txtSelepQtyCetakKIB" name="qty_selep" class="form-control" readonly />
                            <input type="hidden" id="txtSelepSubInvFromCetakKIB" name="from_sub_code" value="">
                          </td>
                        </tr>
                      </table>
                      <center><button type="submit" class="btn btn-success" name="button" style="font-weight:bold;margin-top:10px;margin-bottom:10px;width:20%"> <i class="fa fa-rocket"></i> Create KIB </button>
                    </form>
                  </div>
                  <div class="col-md-1"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
