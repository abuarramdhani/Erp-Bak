<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="col-lg-11">
          <div class="text-right">
            <h1><b><?= $Title ?></b></h1>
          </div>
        </div>
        <div class="col-lg-1">
          <div class="text-right hidden-md hidden-sm hidden-xs">

          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="col-lg-11"></div>
            <div class="col-lg-1 "></div>
          </div>
        </div>
        <br />
        <div class="">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border"></div>
              <div class="box-body">
                <div class="col-md-12 text-right">
                  <!-- <button data-toggle="modal" data-target="#cmojenisorder" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</button> -->
                </div>
                <div class="col-md-12" style="margin-top: 20px;" id="CMO_tblJnsOrder">
                  <table class="table table-bordered table-hover table-striped" id="CMOtblJpkj">
                    <thead class="bg-primary">
                      <th width="10%" style="text-align: center;">No</th>
                      <th style="text-align: center;">Status</th>
                      <th style="text-align: center;">Warna</th>
                      <th width="20%" style="text-align: center;">Action</th>
                    </thead>
                    <tbody class="text-center">
                      <?php $x = 1;
                      foreach ($list as $key) : ?>
                        <tr>
                          <td><?= $x ?></td>
                          <td style="text-align: left"><?= $key['status'] ?></td>
                          <td class="text-center" style="display: flex; justify-content: center;">
                            <div style="height: 20px; width: 20px; background-color: <?= $key['status_color'] ?: '#000' ?>; border-radius: 50%;"></div>
                          </td>
                          <td>
                            <button value="<?= $key['status_id'] ?>" data-color="<?= $key['status_color'] ?>" data-target="#cmoupjenisorder" data-toggle="modal" class="btn btn-primary cmo_upJnsOrder" nama="<?= $key['status'] ?>"><i class="fa fa-edit"></i></button>
                            <!-- <button class="btn btn-danger cmo_delsto" value="<?= $key['status_id'] ?>" nama="<?= $key['status'] ?>"><i class="fa fa-trash"></i></button> -->
                          </td>
                        </tr>
                      <?php $x++;
                      endforeach ?>
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
</section>
<div class="modal fade" id="cmojenisorder" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="<?= base_url('civil-maintenance-order/setting/add_sto') ?>">
        <div class="modal-header">
          <label class="modal-title" id="exampleModalLabel">Tambah Status Order</label>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          <div class="form-group">
            <div class="row">
              <label class="label-control col-md-4">Status Order</label>
              <div class="col-md-8">
                <input placeholder="Masukan Status Order" class="form-control" name="status">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label class="label-control col-md-4">Warna</label>
              <div class="col-md-8">
                <input style="height: 2em;" class="pull-left" value="#fffe00" name="color" type="color">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="cmoupjenisorder" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="<?= base_url('civil-maintenance-order/setting/up_sto') ?>">
        <div class="modal-header">
          <label class="modal-title" id="exampleModalLabel">Edit Status Order</label>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          <input hidden="" name="idJnsOrder">
          <div class="form-group">
            <div class="row">
              <label class="label-control col-md-4">Status Order</label>
              <div class="col-md-8">
                <input placeholder="Masukan Status Order" class="form-control" name="upjenisOrder">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label class="label-control col-md-4">Warna</label>
              <div class="col-md-8">
                <input style="height: 2em;" class="pull-left" value="" name="color" type="color">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>