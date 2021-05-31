<style>

</style>
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="col-lg-11">
          <div class="text-right">
            <h1><b><?= $Title ?></b></h1>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="col-lg-11"></div>
            <div class="col-lg-1 "></div>
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border"></div>
              <div class="box-body">
                <div class="panel-body">
                  <form action="" method="GET">
                    <div class="col-md-1">
                      <label style="margin-top: 5px;">Tahun</label>
                    </div>
                    <div class="col-md-2">
                      <input class="form-control" name="y" id="apd_yearonly" value="<?= $year ?>" />
                    </div>
                    <div class="col-md-2">
                      <button class="btn btn-primary" id="apdmkkbyyear">Lihat</button>
                    </div>
                  </form>
                  <div class="col-md-12" style="height: 50px;"></div>
                  <div class="col-md-12" style="margin-bottom: 20px; padding: 0px;">
                    <?php if ($isAdmin) : ?>
                      <a href="<?= base_url('p2k3adm_V2/Admin/excel_monitoringKK?y=' . $year); ?>" title="Cetak daftar rekapan ke Excel" class="btn btn-success pull-left">
                        <i class="fa fa-file-excel-o"></i> Excel
                      </a>
                    <?php endif ?>
                    <a href="<?= base_url('p2k3adm_V2/Admin/pdf_monitoringKK?y=' . $year); ?>" title="Cetak daftar rekapan ke PDF" class="btn btn-danger pull-left" style="margin-left: 10px;" target="_blank">
                      <i class="fa fa-file-pdf-o"></i> PDF
                    </a>
                    <?php if ($index != $allIndex) : ?>
                      <a href="<?= base_url('p2k3adm_V2/Admin/add_monitoringKK'); ?>" title="Tambah data kecelakaan baru" class="btn btn-info pull-right">
                        <i class="fa fa-plus"></i> Tambah
                      </a>
                    <?php endif ?>
                  </div>
                  <table class="table table-bordered table-hover" id="monitoring-kecelaakaan">
                    <thead>
                      <tr class="bg-primary">
                        <th class="bg-primary text-center" style="width: 10;">No</th>
                        <th class="bg-primary text-center" style="width: 60px;">Action</th>
                        <th class="bg-primary text-center">Noind</th>
                        <th class="bg-primary text-center" style="width: 200px;">Nama</th>
                        <th class="text-center" style="width: 200px;">Seksi</th>
                        <th class="text-center" style="width: 200px;">Unit</th>
                        <th class="text-center">Dept</th>
                        <th class="text-center">Tgl. Kecelakaan</th>
                        <th class="text-center">Lokasi Kecelakaan</th>
                        <th class="text-center">Tempat Kecelakaan</th>
                        <th class="text-center">Dibuat pada</th>
                        <th class="text-center">Penginput</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $x = 1;
                      foreach ($list as $key) : ?>
                        <tr>
                          <td class="text-center"><?= $x++; ?></td>
                          <td class="text-center" nowrap>
                            <a href="<?= base_url('p2k3adm_V2/Admin/exportKecelakaanKerjaPDF?id=' . $key['id_kecelakaan']) ?>" title="Cetak PDF" target="_blank" class="btn btn-danger btn-sm">
                              <i class="fa fa-file-pdf-o"></i>
                            </a>
                            <?php if ($index !== $allIndex) : ?>
                              <!-- Dapat di edit sebelum 7 hari dari tanggal pembuatan-->
                              <?php if ((new DateTime($key['user_created_at']))->diff(new DateTime())->d < 700) : ?>
                                <a href="<?= base_url('p2k3adm_V2/Admin/edit_monitoringKK?id=' . $key['id_kecelakaan']); ?>" title="Edit rekapan" class="btn btn-primary btn-sm" title="Edit">
                                  <i class="fa fa-edit"></i>
                                </a>
                              <?php endif ?>
                              <button class="btn btn-danger btn-sm apdbtndelmkk" title="Hapus Rekap" value="<?= $key['id_kecelakaan'] ?>" pkj="<?= $key['noind'] . ' - ' . $key['nama'] ?>">
                                <i class="fa fa-trash"></i>
                              </button>
                              <?php if ($isAdmin) : ?>
                                <!-- Tampilan di TIM -->
                                <?php if ($key['car_is_created'] == 't') : ?>
                                  <a target="_blank" href="<?= base_url("p2k3adm_V2/Admin/Car/Approval/Tim/$key[id_kecelakaan]") ?>" title="Verifikasi CAR File" class="btn <?= $key['car_tim_is_approved'] ? 'btn-success' : 'btn-info' ?> btn-sm">
                                    <i class="fa fa-check-circle"></i>
                                  </a>
                                <?php else : ?>
                                  <!-- <a target="_blank" title="Lampiran CAR belum dibuat" class="btn btn-sm btn-warning">
                                    <i class="fa fa-check"></i>
                                  </a> -->
                                <?php endif ?>
                              <?php else : ?>
                                <!-- Tampilan di seksi -->
                                <?php if ($key['car_is_created'] == 't') : ?>
                                  <a target="_blank" href="<?= base_url("p2k3adm_V2/Admin/Car/View/$key[id_kecelakaan]") ?>" title="Edit file CAR" class="btn btn-info btn-sm">
                                    <i class="fa fa-check-circle"></i>
                                  </a>
                                <?php else : ?>
                                  <a target="_blank" href="<?= base_url("p2k3adm_V2/Admin/Car/Create/$key[id_kecelakaan]") ?>" title="Lampirkan file CAR" class="btn btn-sm">
                                    <i class="fa fa-check"></i>
                                  </a>
                                <?php endif ?>
                              <?php endif ?>
                            <?php endif ?>
                          </td>
                          <td><?= $key['noind'] ?></td>
                          <td><?= $key['nama'] ?></td>
                          <td><?= $key['seksi'] ?></td>
                          <td><?= $key['unit'] ?></td>
                          <td><?= $key['dept'] ?></td>
                          <td><?= date('d-m-Y', strtotime($key['waktu_kecelakaan'])) ?></td>
                          <td><?= $lokasi[$key['lokasi_kerja_kecelakaan']] ?></td>
                          <td><?= $key['tkp'] ?></td>
                          <td nowrap><?= date('d-m-Y', strtotime($key['user_created_at'])) ?></td>
                          <td><?= $key['user_created_by'] ?></td>
                        </tr>
                      <?php endforeach ?>
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
<script>
  var year = '<?= $year ?>';

  $(() => {
    $("#monitoring-kecelaakaan").DataTable({
      scrollX: true,
      fixedColumns: {
        leftColumns: 3,
      },
      fnInitComplete() {
        $('[title]').tooltip({
          container: 'body'
        })
      }
    })
  });
</script>