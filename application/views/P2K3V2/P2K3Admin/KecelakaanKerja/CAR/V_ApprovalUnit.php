<style>
  .form-group {
    margin-bottom: 0.25em;
  }

  .select2 {
    width: 100% !important;
  }
</style>
<?php $this->load->view('P2K3V2/P2K3Admin/KecelakaanKerja/CAR/css/StatusColor') ?>

<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="col-lg-12">
          <div class="pull-left">
            <a href="<?= base_url('p2k3adm_V2/Admin/monitoringKK') ?>" class="btn btn-primary">
              <i class="fa fa-arrow-left"></i>
              Kembali
            </a>
          </div>
          <div class="pull-right">
            <h1><b>Approval CAR</b></h1>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border"></div>
              <div class="box-body">
                <div class="panel-body">
                  <div class="row">
                    <?php $this->load->view('P2K3V2/P2K3Admin/KecelakaanKerja/CAR/_partials/KecelakaanHeader') ?>
                    <div class="col-md-12 mb-2">
                      <hr>
                      <span class="pull-left">Action :</span>
                      <!-- <div class="pull-right">
                        <button id="add_button" class="btn btn-primary">
                          <i class="fa fa-plus"></i>
                          Tambah
                        </button>
                        <button id="revision_button" class="btn btn-warning">
                          Revisi
                        </button>
                      </div> -->
                    </div>
                    <form action="<?= base_url('p2k3adm_V2/Admin/Car/Approval/Unit/') ?>" method="POST">
                      <input type="hidden" name="id_kecelakaan" value="<?= $id_kecelakaan ?>">
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table class="table" id="car_table">
                            <thead class="bg-primary">
                              <tr>
                                <th>No</th>
                                <th>Faktor</th>
                                <th>Root Cause</th>
                                <th>Corrective Action</th>
                                <th>PIC</th>
                                <th>Due Date</th>
                                <th>Catatan</th>
                                <th>Status</th>
                                <th>History</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($cars as $i => $car) : ?>
                                <tr>
                                  <td class="text-center js-row-number">
                                    <input type="hidden" name="action[]" value="<?= $car->approval_status == CAR_STATUS::PROCESS ? 'UPDATE' : '' ?>" disabled>
                                    <input type="hidden" name="car_id[]" value="<?= $car->kecelakaan_car_id ?>" disabled>
                                    <input type="hidden" name="sub_car_revision_id[]" value="" disabled>
                                    <span>
                                      <?= $i + 1 ?>
                                    </span>
                                  </td>
                                  <td>
                                    <?= $car->factor ?>
                                  </td>
                                  <td>
                                    <?= $car->root_cause ?>
                                  </td>
                                  <td>
                                    <?= $car->corrective_action ?>
                                  </td>
                                  <td>
                                    <?= $car->noind_pic . " - " . $car->nama_pic ?>
                                  </td>
                                  <td>
                                    <?= $car->due_date ?>
                                  </td>
                                  <td>
                                    <?= $car->notes ?>
                                  </td>
                                  <td style="display: flex; align-items: center;">
                                    <span class="status <?= $car->approval_status ?>">
                                      <?= CAR_STATUS::getStatus($car->approval_status) ?>
                                    </span>
                                  </td>
                                  <td>
                                    <a href="#" data-id="<?= $car->kecelakaan_car_id ?>" data-toggle="modal" data-target="#modal-approval-history" class="js-approval-history">Riwayat</a>
                                  </td>
                                </tr>

                                <?php foreach ($car->revisi as $car_revisi) : ?>
                                  <tr data-status="<?= $car_revisi->approval_status ?>">
                                    <td class="text-center js-row-number">
                                      <input type="hidden" name="car_id[]" value="<?= $car_revisi->kecelakaan_car_id ?>">
                                      <input type="hidden" name="sub_car_revision_id[]" value="<?= $car_revisi->sub_revisi_kecelakaan_car_id ?>">
                                    </td>
                                    <td>
                                      <?php
                                      $factors = ['Man', 'Machine', 'Method', 'Working', 'Area', 'Other'];
                                      ?>
                                      <select class="form-control" name="factor[]" required <?= $car_revisi->approval_status == CAR_STATUS::PROCESS ? '' : 'readonly' ?>>
                                        <?php foreach ($factors as $factor) : ?>
                                          <option value="<?= $factor ?>" <?= $factor == $car_revisi->factor ? 'selected' : '' ?>><?= $factor ?></option>
                                        <?php endforeach ?>
                                      </select>
                                    </td>
                                    <td>
                                      <input autocomplete="off" type="text" placeholder="Tulis akar masalah ..." value="<?= $car_revisi->root_cause ?>" name="root_cause[]" class="form-control" required <?= $car_revisi->approval_status == CAR_STATUS::PROCESS ? '' : 'readonly' ?>>
                                    </td>
                                    <td>
                                      <input autocomplete="off" type="text" placeholder="Tulis tindakan ..." value="<?= $car_revisi->corrective_action ?>" name="corrective_action[]" class="form-control" required <?= $car_revisi->approval_status == CAR_STATUS::PROCESS ? '' : 'readonly' ?>>
                                    </td>
                                    <td>
                                      <?php if ($car_revisi->approval_status == CAR_STATUS::PROCESS) : ?>
                                        <select class="form-control js-pic-select2" value="<?= $car_revisi->noind_pic ?>" name="noind_pic[]" required <?= $car_revisi->approval_status == CAR_STATUS::PROCESS ? '' : 'readonly' ?>>
                                          <option value="<?= $car_revisi->noind_pic ?>" selected><?= $car_revisi->noind_pic . " - " . $car_revisi->nama_pic ?></option>
                                        </select>
                                      <?php else : ?>
                                        <input autocomplete="off" type="text" value="<?= $car_revisi->noind_pic . " - " . $car_revisi->nama_pic ?>" name="noind_pic[]" class="form-control" readonly>
                                      <?php endif ?>
                                    </td>
                                    <td>
                                      <input type="text" autocomplete="off" placeholder="Tanggal jatuh tempo" value="<?= $car_revisi->due_date ?>" name="due_date[]" class="form-control js-datepicker" required <?= $car_revisi->approval_status == CAR_STATUS::PROCESS ? '' : 'readonly' ?>>
                                    </td>
                                    <td>
                                      <?= $car_revisi->notes ?>
                                    </td>
                                    <td style="display: flex; align-items: center;">
                                      <span class="status <?= $car_revisi->approval_status ?>">
                                        <?= CAR_STATUS::getStatus($car_revisi->approval_status) ?>
                                      </span>
                                    </td>
                                    <td>
                                      <a href="#" data-id="<?= $car_revisi->kecelakaan_car_id ?>" data-toggle="modal" data-target="#modal-approval-history" class="js-approval-history">Riwayat</a>
                                    </td>
                                  </tr>
                                <?php endforeach ?>
                              <?php endforeach ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="pull-right">
                          <?php if ($show_approve) : ?>
                            <button class="btn btn-success" id="approve_button">Approve</button>
                          <?php endif ?>
                        </div>
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
  </div>
</section>

<?php
$this->load->view('P2K3V2/P2K3Admin/KecelakaanKerja/CAR/_partials/ModalApprovalHistory');
?>

<script>
  ! function() {
    'use strict';
    $(() => {
      const $form = $('form');
      const $car_table = $('table#car_table');
      const $addButton = $('#add_button');
      const $firstRow = $car_table.find('tbody > tr');
      const $firstRowClone = $firstRow.clone()
      const $saveButton = $('#approve_button');

      // updating with ajax
      $saveButton.on('click', function(e) {
        e.preventDefault();
        Swal.fire({
          title: 'Apakah anda yakin untuk mengapprove semua CAR ini ?',
          text: '',
          type: 'question',
          showCancelButton: true
        }).then(({
          value
        }) => {
          if (!value) return;
          $saveButton.prop('disabled', true)
          $form.submit();
        })
      })
    })
  }();
</script>