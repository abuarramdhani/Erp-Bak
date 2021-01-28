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
body{
  padding-right: 0px!important;
}
</style>
<div class="content" style="max-width:100%">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <ul class="list-inline">
            <li><h4 style="font-weight:bold;"  onclick="getOPS()"><i class="fa fa-cog"></i> Operation Process Standard</h4></li>
            <li style="float:right;margin-top:5px;"><button type="button" data-toggle="modal" data-target="#modalfp1" class="btn btn-success" name="button" onclick="fp_add_operation_std()"> <i class="fa fa-plus"></i> Add Operation Std</button></li>
          </ul>
        </div>
        <div class="box-body" style="background:#f0f0f0 !important;">
          <div class="row">
            <div class="col-md-12" style="margin-top:10px">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:15px;">
                <div class="table-area-std">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover text-left dt-fp-std" style="font-size:11px;">
                      <thead class="bg-primary">
                        <tr>
                          <th style="text-align:center">No</th>
                          <th>Operation Std</th>
                          <th>Operation Std Desc</th>
                          <th>Operation Group</th>
                          <th style="text-align:center">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($get as $key => $value): ?>
                          <tr>
                            <td style="text-align:center"><?php echo $key+1 ?></td>
                            <td><?php echo $value['operation_std'] ?></td>
                            <td><?php echo $value['operation_desc'] ?></td>
                            <td><?php echo $value['operation_std_group'] ?></td>
                            <td>
                              <center>
                                <a class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure?');" style="border-radius:7px;" href="<?php echo base_url('FlowProses/OperationProcessStandard/delops/'.$value['id']) ?>"> <i class="fa fa-trash"></i></a>
                                <button type="button" data-toggle="modal" data-target="#modalfp1" class="btn btn-sm btn-success" style="border-radius:7px;" onclick="fp_update_opration_std('<?php echo $value['id'] ?>', '<?php echo $value['operation_std'] ?>', '<?php echo $value['operation_desc'] ?>', '<?php echo $value['operation_std_group'] ?>')" name="button">
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

<div class="modal fade bd-example-modal-lg" id="modalfp1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left;margin-top:6px;">
                  <h4 style="font-weight:bold;display:inline;"> <i class="fa fa-cube"></i> Add Operation</h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal"><i class="fa fa-close"></i></button>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-data">
                      <input type="hidden" id="id_fp_std" value="">
                      <label for="" style="margin-top:10px;">Operation Std</label>
                      <input type="text" class="form-control" id="operation_std" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-data">
                      <label for="" style="margin-top:10px;">Operation Group</label>
                      <input type="text" class="form-control" id="operation_std_group" value="">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-data">
                      <label for="" style="margin-top:10px;">Operation Std Description</label>
                      <input type="text" class="form-control" id="operation_std_desc" value="">
                    </div>
                  </div>
                  <div class="col-md-12">
                  <br>
                  <center>
                    <button type="button" class="btn btn-success" style="width:30%" onclick="saveOperationStd()" name="button"> <i class="fa fa-file"></i> <b>Save</b> </button>
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
