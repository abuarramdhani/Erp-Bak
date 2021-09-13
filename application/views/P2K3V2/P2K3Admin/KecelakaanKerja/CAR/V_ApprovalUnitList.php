<?php $this->load->view('P2K3V2/P2K3Admin/KecelakaanKerja/CAR/css/StatusColor') ?>
<style>
  .btn-pdf {
    background: transparent;
    padding: 0.2em 0.7em;
    background: pink;
    color: red;
    border-radius: 8px;
  }

  .btn-pdf:hover {
    background: red;
    color: white;
  }
</style>
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="col-lg-11">
          <div class="text-right">
            <h1><b>Approval CAR</b></h1>
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
                      <input class="form-control yearpicker" name="year" value="<?= $year ?>" />
                    </div>
                    <div class="col-md-2">
                      <button class="btn btn-primary">Lihat</button>
                    </div>
                  </form>
                  <div class="col-md-12" style="height: 50px;"></div>
                  <div class="col-md-12" style="margin-bottom: 20px; padding: 0px;">
                    <!-- <a href="<?= base_url('p2k3adm_V2/Admin/excel_monitoringKK?y=' . $year); ?>" title="Cetak daftar rekapan ke Excel" class="btn btn-success pull-left">
                      <i class="fa fa-file-excel-o"></i> Excel
                    </a> -->
                    <a href="<?= base_url('p2k3adm_V2/Admin/pdf_monitoringKK?y=' . $year); ?>" title="Cetak daftar rekapan ke PDF" class="btn btn-danger pull-left" style="margin-left: 10px;" target="_blank">
                      <i class="fa fa-file-pdf-o"></i> PDF
                    </a>
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
                        <!-- <th class="text-center">Status</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $x = 1;
                      foreach ($list as $key) : ?>
                        <?php $key['id_kecelakaan'] = EncryptCar::encode($key['id_kecelakaan']) ?>
                        <?php
                        // tim approved && unit approved -> closed |
                        if ($key['car_tim_is_approved'] == 't' && $key['car_unit_is_approved'] == 't') {
                          $carButtonClass = 'status closed';
                          $unitCarButtonTitle = 'CAR is closed';
                        } else if ($key['car_unit_is_approved'] == 't') {
                          // unit approved -> verified -> green
                          $carButtonClass = 'status verified';
                          $unitCarButtonTitle = 'CAR telah di approve';
                        } else {
                          // else -> prosess
                          $carButtonClass = 'status process';
                          $unitCarButtonTitle = 'Approve CAR';
                        }
                        ?>
                        <tr>
                          <td class="text-center"><?= $x++; ?></td>
                          <td class="text-center" nowrap>
                            <a href="<?= base_url('p2k3adm_V2/Admin/exportKecelakaanKerjaPDF?id=' . $key['id_kecelakaan']) ?>" title="Cetak PDF" target="_blank" class="btn btn-pdf btn-sm">
                              <i class="fa fa-file-pdf-o"></i>
                            </a>
                            <?php if ($key['car_is_created'] == 't') : ?>
                              <a target="_blank" href="<?= base_url("p2k3adm_V2/Admin/Car/Approval/Unit/$key[id_kecelakaan]") ?>" title="<?= $unitCarButtonTitle ?>" class="btn <?= $carButtonClass ?> btn-sm">
                                <i class="fa fa-check-circle"></i>
                              </a>
                            <?php else : ?>
                              <!-- <a target="_blank" title="CAR belum dibuat" class="btn btn-sm">
                                <i class="fa fa-check"></i>
                              </a> -->
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
                          <!-- <td><?= $key['approval_status'] ?></td> -->
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
    $('.yearpicker').datepicker({
      autoclose: true,
      todayHighlight: true,
      format: "yyyy",
      viewMode: "years",
      minViewMode: "years",
    })
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