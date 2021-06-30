<style media="screen">
  thead>tr>th,
  tbody>tr>td {
    text-align: center;
  }
</style>
<section class="content">

  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="col-lg-11">
          <div class="text-right">
            <h1><b><?= $Title; ?></b></h1>
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
        <div class="mx-auto">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <button data-toggle="modal" data-target="#modal" type="button" class="btn btn-default btn-sm" id="add-akses-pekerja">
                  <i data-toggle="tooltip" data-title="tambah" class="icon-plus icon-2x"></i>
                </button>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hovered" id="aksesList">
                    <thead class="bg-primary ">
                      <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">No Induk</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Seksi</th>
                        <th class="text-center">Jumlah Akses</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $index = 1 ?>
                      <?php foreach ($akses as $key) : ?>
                        <tr>
                          <td class="text-center"><?= $index; ?></td>
                          <td class="text-center"><?= $key['noind']; ?></td>
                          <td class="text-center"><?= $key['nama'] ?></td>
                          <td class="text-center"><?= $key['seksi'] ?></td>
                          <td class="text-center"><?= $key['jumlah_akses']; ?></td>
                          <td class="col-lg-2 text-center">
                            <button data-noind="<?= $key['noind']; ?>" data-nama="<?= $key['nama']; ?>" type="button" class="btn btn-success detailAkses" data-toggle="modal" data-target=" #modal">
                              <span data-toggle="tooltip" data-title="edit">
                                <i class=" fa fa-edit"></i>
                              </span>
                            </button>
                          </td>
                        </tr>
                        <?php $index++ ?>

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
</section>

<div class="modal fade" role="dialog" area-hidden="true" id="modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 10px;">
      <div class="modal-header bg-primary">
        <label>Tambah Akses Seksi</label>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group col-lg-12">
              <label>Pekerja</label>
              <select class="form-control select2 select-pekerja" style="width: 100%;">
                <!-- ajax -->
              </select>
            </div>
            <div class=" form-group col-lg-12">
              <label>Seksi</label>
              <select class="form-control select2 select-seksi" style="width: 100%;">
                <!-- ajax -->
              </select>
            </div>
            <div class="form-group col-lg-12 text-right">
              <small style="float: left; color: red;">*isian untuk menambah seksi</small>
              <button type="button" class="btn btn-primary btn-sm add-akses" name="button"><i class="fa fa-plus"></i></button>
            </div>
            <table class="table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kodesie</th>
                  <th>Seksi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="tableAkses">
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="background-color: #3c8dbc;">
        <button type="button" style="float: left;" class="btn btn-danger hapus-akses" style="border-radius: 10px">Hapus Akses<i class="fa fa-trash"></i></button>
        <button type="button" class="btn btn-success btn-save" id="save" style="border-radius: 10px">Simpan</button>
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal" style="border-radius: 10px">Batal</button>
      </div>
    </div>
  </div>
</div>