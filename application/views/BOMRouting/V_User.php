<section class="content">
  <div class="inner">
    <div class="row">
      <form method="post" action="<?php echo base_url('PendaftaranBomRouting/UserManagement/') ?>" autocomplete="off">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-12">
              <div class="col-lg-11">
                <div class="text-right">
                  <h1>
                    <b>
                      <?php echo $Title ?>
                    </b>
                  </h1>
                </div>
              </div>
              <div class="col-lg-1 ">
                <div class="text-right hidden-md hidden-sm hidden-xs">
                  <a class="btn btn-default btn-lg" href="">
                    <i aria-hidden="true" class="fa fa-line-chart fa-2x">
                    </i>
                    <span>
                      <br />
                    </span>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <br />
          <br />
          <div class="row">
            <div class="col-lg-12">
              <div class="box box-primary box-solid">
                <div class="box-header with-border">
                  <div class="col-md-10">
                    <h4>Management Account</h4>
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-info btn-sm" title="Add New" style="float:right;margin-top:5px;" data-toggle="modal" data-target="#MyModal">
                      <i class="icon-plus icon-2x"></i>
                    </button>
                  </div>
                </div>
                <div class="panel-body">
                  <div id="1by1" class="tab-pane fade in">

                    <!-- do something -->
                    <div class="row">
                      <div class="card-body collapse in">
                        <div class="card-block">
                          <div class="table-responsive">
                            <table class="table table-striped table-hover text-left" id="tblSeksi" style="font-size:14px;">
                              <thead class="bg-success">
                                <tr>
                                  <th style="text-align:center; width:5%">
                                    No
                                  </th>
                                  <th>
                                    Nama User
                                  </th>
                                  <th style="text-align:center">
                                    Username
                                  </th>
                                  <th style="text-align:center">
                                    Status
                                  </th>
                                  <th style="text-align:center">
                                    Action
                                  </th>
                                </tr>
                              </thead>
                              <tbody>

                                <?php
                                    $no = 1;
                                    foreach($get as $row):
                                    $encrypted_string = $this->encrypt->encode($row['id']);
                                    $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                ?>
                                <tr>
                                  <td align="center">
                                    <?php echo $no++;?>
                                  </td>
                                  <td>
                                    <?php echo $row['nama'] ?>
                                  </td>
                                  <td align="center">
                                    <?php echo $row['no_induk'] ?>
                                  </td>
                                  <td align="center">
                                    <?php echo $row['role_access'] ?>
                                  </td>
                                  <td align="center">
                                    <input type="hidden" value="<?php $idd = $row['id'] ?>">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                      <button type="button" onclick="modalPBRUpdate(<?php echo $idd ?>)" class="btn btn-info btn-sm" title="Edit Data" data-toggle="modal" data-target="#MyModal1">
                                        Edit
                                      </button>
                                      <button class="btn btn-danger btn-sm" data-placement="bottom" data-toggle="tooltip" onclick="deleteUser('<?php echo $idd ?>')" title="Hapus Data">
                                        Delete
                                      </button>
                                    </div>
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
      </form>

    </div>
  </div>
</section>

<!-- modal area -->
<div class="modal fade bd-example-modal-md" id="MyModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="panel-body">
        <div class="modal-header">
          <h3 class="modal-title" style="text-align:center" id="exampleModalLabel">Add User</h3>
        </div>
        <form action="<?php echo base_url('PendaftaranBomRouting/UserManagement/CreateUser') ?>" method="post">
          <div class="p-5">
            <div class="form-group row">
              <div class="col-sm-6">
                <label for="">No Induk</label>
                <select class="form-control select2ind" id="indID" onchange="getDataUserCreate()" data-placeholder="No Induk" name="txtNoInduk" title="Cari berdasar No Induk">
                </select>
              </div>
              <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="">Nama User</label>
                <select required class="form-control selectNameUser" id="txtUser" name="txtUser" data-placeholder="Nama"></select>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-12 mt-3">
                <label for="">Permission</label><br>
                <select class="form-control select2manual" data-placeholder="Product" name="txtPermission" data-toggle="tooltip" data-placement="top" title="Cari berdasar Product">
                  <option value="Admin">Admin</option>
                  <option value="Member">Member</option>
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="button" class="btn btn-primary bg-gradient-primary btn-icon-split" id="UpdateComp">
              <span class="icon text-white-50">
                <i class="fa fa-check"></i>
              </span>
              <span class="text">Save</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- modal update area -->
<div class="modal fade bd-example-modal-md" id="MyModal1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="panel-body">
        <div class="modal-header">
          <h3 class="modal-title" style="text-align:center" id="exampleModalLabel">Update User</h3>
        </div>
        <form action="<?php echo base_url('PendaftaranBomRouting/UserManagement/UpdateUser') ?>" method="post">
          <input type="hidden" name="txt_id_us" id="IDusr">
          <div class="p-5">
            <div class="form-group row">
              <div class="col-sm-6">
                <label for="">No Induk</label>
                <!-- <input type="text" class="form-control" name="txtNoIndukBefore" id="indukk" readonly> -->
                <select disabled class="form-control select2ind toupper" id="indIDUp" data-placeholder="No induk" name="txtNoInduk" title="Cari berdasar No Induk">
                </select>
              </div>
              <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="">Nama User</label>
                <!-- <input type="text" class="form-control" name="txtUserBefore" id="userr" readonly> -->
                <select disabled class="form-control selectNameUser toupper" id="txtUserUp" name="txtUser" data-placeholder="Nama"></select>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-12 mt-3">
                <label for="">Permission</label><br>
                <select class="form-control select2manual" id="txtPermissionUp" data-placeholder="Product" name="txtPermission" data-toggle="tooltip" data-placement="top" title="Cari berdasar Product">
                  <!-- <option value="Admin">Admin</option>
                  <option value="Member">Member</option> -->
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="button" class="btn btn-primary bg-gradient-primary btn-icon-split" id="UpdateComp">
              <span class="icon text-white-50">
                <i class="fa fa-check"></i>
              </span>
              <span class="text">Save</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
