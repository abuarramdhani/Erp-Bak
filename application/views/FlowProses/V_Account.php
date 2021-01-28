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
<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <ul class="list-inline">
            <li>
              <h4 style="margin: 5px 0 0 0;font-weight:bold;">Management Account</h4>
            </li>
            <li style="float:right;margin-top:0;"><button type="button" style="border-radius:7px;font-weight:bold;" data-toggle="modal" data-target="#modalfp4" class="btn btn-success btn_fp_operation" onclick="fp_add_account()" name="button"> <i class="fa fa-cogs"></i> Add Account</button></li>
          </ul>
        </div>
        <div class="box-body" style="background:#f0f0f0 !important;">
          <div class="row">
            <div class="col-md-12">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin:15px 0 15px 0;">
                <div class="row">
                  <div class="col-md-12">
                    <h6 class="text-danger"> <b>NB :</b> <br>
                      <ul style="margin-top: 5px;margin-left: -23px;">
                        <li><b>Super User</b> : Memiliki Akses Penuh Pada Aplikasi Flow Proses </li>
                        <li><b>Admin (Serah Terima)</b> : Memiliki akses untuk menu product, component, dan memo.</li>
                        <li><b>Admin (Operation)</b> : Memiliki akses untuk menu product, operation, operation process standard.</li>
                      </ul>
                    </h6>
                    <div class="table-responsive" style="margin-top:20px">
                      <table class="table table-striped table-bordered table-hover text-left datatable-account-fp" style="font-size:11px;">
                        <thead class="bg-primary">
                          <tr>
                            <th style="width:7%">No</th>
                            <th>Employee</th>
                            <th>User Access</th>
                            <th style="width:10%;text-align:center">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($get as $key => $var): ?>
                            <tr>
                              <td style="text-align:center"><?php echo $key+1 ?></td>
                              <td><?php echo $var['employee_name'] ?> - <?php echo $var['no_induk'] ?></td>
                              <td><?php echo $var['user_access'] ?></td>
                              <td>
                               <center>
                                <button type="button" style="border-radius:7px;font-weight:bold;" data-toggle="modal" data-target="#modalfp4" class="btn btn-success btn_fp_operation" onclick="fp_update_account('<?php echo $var['id'] ?>', '<?php echo $var['employee_name'] ?> - <?php echo $var['no_induk'] ?>', '<?php echo $var['user_access'] ?>')" name="button"> <i class="fa fa-pencil"></i></button>
                                <a class="btn btn-danger" onclick="return confirm('Are You Sure?');" style="border-radius:7px;" href="<?php echo base_url('FlowProses/ManagementAccount/delaccount/'.$var['id']) ?>"> <i class="fa fa-trash"></i></a>
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

<div class="modal fade bd-example-modal-md" id="modalfp4" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left;margin-top:6px;">
                  <h4 style="font-weight:bold;display:inline;"> <span id="title_modal_account_fp">Add User</span></h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal"><i class="fa fa-close"></i></button>
              </div>
              <div class="box-body">
                <div class="row">
                <form action="<?php echo base_url('FlowProses/ManagementAccount/Add') ?>" method="post">
                  <input type="hidden" id="fp_id_account" name="id" value="">
                  <div class="col-md-12">
                    <div class="form-data">
                      <label for="" style="margin-top:10px;">Employee</label>
                      <select class="form-control select2FP" style="width:100%" name="no_induk" required></select>
                    </div>
                    <div class="form-data">
                      <label for="" style="margin-top:10px;">User Access</label>
                      <select class="form-control select2 " style="width:100%" name="user_access" required>
                        <option value="">Select..</option>
                        <option value="Super User">Super User</option>
                        <option value="Admin (Serah Terima)">Admin (Serah Terima)</option>
                        <option value="Admin (Operation)">Admin (Operation)</option>
                      </select>
                    </div>
                  </div>
                <div class="col-md-12">
                  <br>
                  <center>
                    <button type="submit" class="btn btn-success" style="width:30%" name="button"> <i class="fa fa-file"></i> <b>Save</b> </button>
                  </center>
                </div>
              </form>

              </div>

            </form>

              </div>
            </div>
      		</div>
      	</div>
      </div>
    </div>
  </div>
</div>
