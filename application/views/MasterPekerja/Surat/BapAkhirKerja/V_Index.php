<style type="text/css">
  .dataTable_Button {
    width: 350px;
    float: left;
    margin-left: 1px;
    margin-bottom: 2px;
  }

  .dataTable_Filter {
    width: 450px;
    float: right;
    margin-right: 1px;
    margin-bottom: 2px;
  }

  .dataTable_Information {
    width: 350px;
    float: left;
    margin-left: 1px;
    margin-top: 7px;
  }

  .dataTable_Pagination {
    width: 450px;
    float: right;
    margin-right: 1px;
    margin-top: 14px;
  }

  .dataTable_Processing {
    z-index: 999;
  }

  td>a {
    padding: 0 3px;
  }

  td,
  th {
    text-align: center;
  }
</style>
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="col-lg-11">
              <div class="text-right">
                <h1><b><?= $Title; ?></b></h1>
              </div>
            </div>
            <div class="col-lg-1">
              <div class="text-right hidden-md hidden-sm hidden-xs">
                <a class="btn btn-default btn-lg" href="<?= site_url('MasterPekerja/Surat/BapAkhirKerja'); ?>">
                  <i class="icon-wrench icon-2x"></i>
                  <br />
                </a>
              </div>
            </div>
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <a href="<?= site_url('MasterPekerja/Surat/BapAkhirKerja/create'); ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New">
                  <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                </a>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover table-responsive" id="tbl" style="width:100%; font-size:12px; overflow-x: scroll;">
                    <thead class="bg-primary">
                      <tr>
                        <th>No</th>
                        <th>Aksi</th>
                        <th>Noind</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Departemen/Unit/Seksi</th>
                        <th>Tanggal Akhir Kerja</th>
                        <th>Tanggal Dibuat</th>
                      </tr>
                    </thead>
                    <?php $index = 1; ?>
                    <?php foreach ($all_surat as $as) : ?>
                      <tr>
                        <td><?= $index; ?></td>
                        <td style="display:flex; justify-content: space-evenly; align-items:center;">
                          <a target="_blank" href="<?= site_url('MasterPekerja/Surat/BapAkhirKerja/printSurat/' . $this->general->enkripsi($as['id'])) ?>" title="Preview Cetak"><i class="fa fa-file-pdf-o fa-2x"></i></a>
                          <a href="<?= site_url('MasterPekerja/Surat/BapAkhirKerja/update/' . $this->general->enkripsi($as['id'])); ?>" title="Edit Surat"><i class="fa fa-pencil-square fa-2x"></i></a>
                          <a data-id="<?= $this->general->enkripsi($as['id']) ?>" title="Hapus Surat" class="btn-trash" style="cursor:pointer"><i class="fa fa-trash fa-2x"></i></a>
                        </td>
                        <td><?= $as['noind_pekerja']; ?></td>
                        <td><?= $as['nama_pekerja']; ?></td>
                        <td><?= $as['jabatan_pekerja']; ?></td>
                        <td><?= $as['seksi_pekerja']; ?></td>
                        <td><?= $as['tgl_akhir_kerja']; ?></td>
                        <td><?= $as['date_created']; ?></td>
                      </tr>
                      <?php $index++ ?>
                    <?php endforeach; ?>
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