<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>Permintaan Perhitungan Harga Sparepart</h1>
</section>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-lg-12 container">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-pencil"></i> Informasi Penginput</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="col-sm-3 control-label">No. Induk</label>
                  <div class="input-group col-sm-8">
                    <span class="input-group-addon"><i class="fa fa-list-ol"></i></span>
                    <input type="text" class="form-control" value="<?= $this->session->user ?>" readonly>
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label class="col-sm-3 control-label">Nama</label>
                  <div class="input-group col-sm-8">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" value="<?= $this->session->employee ?>" readonly>
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.panel -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /. box -->
      <div class="box box-primary">
        <form class="frmPHSInput" action="<?= base_url('PerhitunganHargaSparepart/Marketing/Input/save') ?>" method="post">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-table"></i> Data</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="panel-body">
              <div class="row">
                <!-- TODO: Responsive -->
                <div class="col-sm-6">
                  <button class="btn btn-success btnPHSAddRow" data-toggle="tooltip" type="button" title="Tambah Baris Data">
                    <i class="fa fa-plus"></i> Tambah Data
                  </button>
                </div>
              </div>
              <!-- /.col-sm-6 -->
              <!-- <div class="col-sm-6 text-right">
                  <button class="btn btn-default" data-toggle="tooltip" type="button"
                    title="Tambahkan Data dengan Mengupload Template File Excel">
                    <i class="fa fa-cloud-upload"></i> Upload Excel
                  </button>
                  <button class="btn btn-default" data-toggle="tooltip" type="button"
                    title="Download Template Excel">
                    <i class="fa fa-file-excel-o"></i> Template Excel
                  </button>
                </div> -->
              <!-- /.col-sm-6 -->
            </div>
            <div class="panel-body">
              <!-- /.row -->
              <div class="row">
                <div class="col-sm-12">
                  <div style="overflow-x: auto;">
                    <table class="table table-bordered table-hover tblPHSInput" style="min-width: 150%;">
                      <thead>
                        <tr class="bg-primary">
                          <th class="t-head-center" style="width: 2%">No.</th>
                          <th class="t-head-center" style="width: 10%;">Produk</th>
                          <th class="t-head-center" style="width: 15%;">Kode Barang</th>
                          <th class="t-head-center" style="width: 15%;">Deskripsi</th>
                          <th class="t-head-center" style="width: 5%;">Bungkus<br>(Ya/Tidak)</th>
                          <th class="t-head-center" style="width: 5%;">Isi/bungkus</th>
                          <th class="t-head-center" style="width: 5%;">Kategori Part</th>
                          <th class="t-head-center" style="width: 10%;">Info Pesaing<br>(Ada/Tidak)</th>
                          <!-- <th class="t-head-center" style="width: 10%">Referensi Harga<br>(DPP)</th> -->
                          <th class="t-head-center" style="width: 20%;">Keterangan</th>
                          <th class="t-head-center" style="width: 3%">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- /.col-sm-12 -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.panel -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer with-border">
            <div class="box-tools pull-right">
              <button data-toggle="tooltip" type="submit" class="btn btn-primary btnPHSSaveInput" title="Simpan Data">
                <i class="fa fa-save"></i> Simpan
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->
        </form>
      </div>
      <!-- /. box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->