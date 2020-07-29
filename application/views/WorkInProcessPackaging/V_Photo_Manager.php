<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;"><i class="fa fa-newspaper-o"></i> Photo Manager</h4>
        </div>
        <div class="box-body" style="background:#f0f0f0 !important;">
          <div class="row">
            <div class="col-md-2">

            </div>
            <div class="col-md-8">
              <br>
              <form action="<?php echo base_url('WorkInProcessPackaging/PhotoManager/Save') ?>" method="post" enctype="multipart/form-data">
                <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:15px;">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label for="">Kode Komponen</label>
                        <select class="form-control select2itemcodewipp" name="kode_komponen" id="kode_komponen" style="width:100%" required></select>
                      </div>
                      <div class="col-md-6">
                        <label for="">Nama Komponen</label>
                        <input type="hidden" name="type_gambar" value="<?php echo $param ?>">
                        <input type="text" class="form-control" readonly name="nama_komponen" id="nama_komponen" placeholder="Nama Komponen">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="seksi_pengirim">File</label>
                    <div class="row">
                      <div class="col-md-12">
                        <input type="file" class="form-control" name="filenyagan" placeholder="Nama Komponen" onchange="readFile(this)">
                        <br>
                        <iframe src="<?php echo base_url('/assets/img/erp.png') ?>" id="showPre" frameborder="0" class="mt-1" style="width:100%;"></iframe>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <center><button type="submit" class="btn btn-md btn-primary"><i class="fa fa-space-shuttle"></i> <b>Save</b></button> </center>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-md-2">

            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <br>
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:15px;">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover text-left tblwiip" style="font-size:12px;">
                  <thead>
                    <tr class="bg-info">
                      <th>
                        <center>No</center>
                      </th>
                      <th>
                        <center>Kode Komponen</center>
                      </th>
                      <th>
                        <center>Nama Komponen</center>
                      </th>
                      <th>
                        <center>Foto </center>
                      </th>
                      <th>
                        <center>Action</center>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($get as $key => $g): ?>
                      <tr>
                        <td><?php echo $key+1 ?></td>
                        <td><?php echo $g['kode_item'] ?></td>
                        <td><?php echo $g['nama_item'] ?></td>
                        <td>
                          <center><center><button type="button" class="btn bg-maroon" data-toggle="modal" data-target="#wipp3" name="button" onclick="photoWIPP('<?php echo $g['photo'] ?>')"><i class="fa fa-eye"></i> Lihat</button></center>
                        </td>
                        <td>
                          <center><button type="button" class="btn bg-maroon" name="button" data-toggle="modal" data-target="#wipp4<?php echo $g['kode_item']?>"><i class="fa fa-edit"></i> Edit</button>
                          <button type="button" class="btn bg-maroon" name="button" onclick="update_null('<?php echo $g['kode_item'] ?>')"><i class="fa fa-trash"></i> Delete</button></center>
                        </td>
                      </tr>
                      <div class="modal fade bd-example-modal-xl" id="wipp4<?php echo $g['kode_item']?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
                            <div class="panel-body">
                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="box box-primary box-solid">
                                    <div class="box-header with-border">
                                      <div style="float:left">
                                        <h4 style="font-weight:bold;">Edit (<?php echo $g['kode_item'] ?>) </h4>
                                      </div>
                                      <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal">Close</button>
                                    </div>
                                    <div class="box-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <br>
                                          <form action="<?php echo base_url('WorkInProcessPackaging/PhotoManager/Save') ?>" method="post" enctype="multipart/form-data">
                                            <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:15px;">
                                              <div class="form-group">
                                                <div class="row">
                                                  <div class="col-md-6">
                                                    <label for="">Kode Komponen</label>
                                                    <input type="hidden" name="id_photo" value="<?php echo $g['id'] ?>">
                                                    <select class="form-control select2itemcodewipp2 kode_item_upd_<?php echo $g['kode_item'] ?>"  onchange="gantiKomp('<?php echo $g['kode_item'] ?>')" name="kode_komponen" style="width:100%" required>
                                                      <option value="<?php echo $g['kode_item'] ?>" selected><?php echo $g['kode_item'] ?></option>
                                                    </select>
                                                  </div>
                                                  <div class="col-md-6">
                                                    <label for="">Nama Komponen</label>
                                                    <input type="hidden" name="type_gambar" value="<?php echo $param ?>">
                                                    <input type="text" class="form-control" readonly name="nama_komponen" id="nama_komponen_update_<?php echo $g['kode_item'] ?>" placeholder="Nama Komponen" value="<?php echo $g['nama_item'] ?>">
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label for="seksi_pengirim">File</label>
                                                <div class="row">
                                                  <div class="col-md-12">
                                                    <input type="file" class="form-control" value="" name="filenyagan" placeholder="Nama Komponen" onchange="readFileForEdit(this)">
                                                    <br>
                                                    <iframe src="<?php echo base_url($g['photo']) ?>" id="showPreEdit" frameborder="0" class="mt-1" style="width:100%;height:350px"></iframe>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <center><button type="submit" class="btn btn-md btn-primary"><i class="fa fa-space-shuttle"></i> <b>Edit</b></button> </center>
                                              </div>
                                            </div>
                                          </form>
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

<div class="modal fade bd-example-modal-xl" id="wipp3" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">DETAIL </h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal">Close</button>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <center>
                    <div >
                      <center><img style="width: 100%" id="showPhoto"></center>
                    </div>
                  </center>
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
