<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-warning">
                        <div class="box-header">
                            <h2 style="font-weight:bold;color:#444"><i class="fa fa-user"></i> <?= $Title?></h2>
                        </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-4 text-right">
                                        <label style="color:#444">User :</label>
                                    </div>
                                    <div class="col-md-4">
                                        <select id="user" class="form-control select2 getusermjp" data-placeholder="Pilih User">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-4 text-right">
                                        <label style="color:#444">Jenis :</label>
                                    </div>
                                    <div class="col-md-4">
                                        <select id="kategori" class="form-control select2" data-placeholder="Pilih Kategori">
                                            <option></option>
                                            <option value="Superuser">Superuser</option>
                                            <option value="Admin">Admin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="panel-body text-center">
                                    <button type="button" class="btn" style="margin-left:15px;color:#444;background-color:#ff851b" onclick="saveUserMng(this)"><i class="fa fa-user-plus"></i> Tambah</button>
                                </div>
                                <div class="panel-body" id="tbl_usermng"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<form method="post">
<div class="modal fade" id="mdleditUser" role="dialog">
    <div class="modal-dialog" style="padding-left:5px;">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="font-size:25px;background-color:#82E5FA">
            <i class="fa fa-pencil"></i> Edit User
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div id="dataedituser"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
</form>