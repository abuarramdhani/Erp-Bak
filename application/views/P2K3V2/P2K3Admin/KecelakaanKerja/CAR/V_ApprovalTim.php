<style>
  .form-group {
    margin-bottom: 0.25em;
  }

  .select2 {
    width: 100% !important;
  }

  /* .btn-danger {
    background: none;
    color: red;
  }

  .btn-danger:hover {
    background: tomato;
  }

  .btn-success {
    background: none;
    color: green;
  }

  .btn-success:hover {
    background: greenyellow;
  }

  .btn-warning {
    background: none;
    color: orange;
  }

  .btn-warning:hover {
    color: orange;
    background: yellow;
  } */
</style>
<?php $this->load->view('P2K3V2/P2K3Admin/KecelakaanKerja/CAR/css/StatusColor') ?>

<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-md-6">
            <a href="<?= base_url('p2k3adm_V2/Admin/monitoringKK') ?>" class="btn btn-primary">
              <i class="fa fa-arrow-left"></i>
              Kembali
            </a>
          </div>
          <div class="col-md-6">
            <div class="pull-right">
              <h1><b>Verifikasi CAR</b></h1>
            </div>
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
                    </div>
                    <form action="<?= base_url('p2k3adm_V2/Admin/Car/Update') ?>" method="POST">
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
                                <th>Action</th>
                                <th></th>
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
                                    <textarea data-id="<?= $car->kecelakaan_car_id ?>" name="" id="" placeholder="Catatan" style="resize: vertical; max-height: 75px; min-height: 25px; height: 35px;" class="form-control js-car-notes" <?= in_array($car->approval_status, [CAR_STATUS::CLOSED, CAR_STATUS::REVISI]) ? 'readonly' : '' ?>><?= $car->notes ?></textarea>
                                  </td>
                                  <td style="display: flex; align-items: center;">
                                    <span class="status <?= $car->approval_status ?>">
                                      <?= CAR_STATUS::getStatus($car->approval_status) ?>
                                    </span>
                                  </td>
                                  <td nowrap>
                                    <?php if (in_array($car->approval_status, [CAR_STATUS::VERIFIED, CAR_STATUS::OPEN])) : ?>
                                      <a href="" data-id="<?= $car->kecelakaan_car_id ?>" class="btn btn-sm btn-danger js-approval-revisi">Revisi</a>
                                      <a href="" data-id="<?= $car->kecelakaan_car_id ?>" class="btn btn-sm btn-warning js-approval-open">
                                        Open <?= $car->approval_status == CAR_STATUS::OPEN && $car->open_status_count > 1 ? $car->open_status_count : '' ?>
                                      </a>
                                      <a href="" data-id="<?= $car->kecelakaan_car_id ?>" class="btn btn-sm btn-success js-approval-close">Close</a>
                                    <?php elseif ($car->approval_status == CAR_STATUS::REVISI) : ?>
                                      <!-- no action -->

                                    <?php endif ?>
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
                                      <?= $car_revisi->factor ?>
                                    </td>
                                    <td>
                                      <?= $car_revisi->root_cause ?>
                                    </td>
                                    <td>
                                      <?= $car_revisi->corrective_action ?>
                                    </td>
                                    <td>
                                      <?= $car_revisi->noind_pic . " - " . $car_revisi->nama_pic ?>
                                    </td>
                                    <td>
                                      <?= $car_revisi->due_date ?>
                                    </td>
                                    <td>
                                      <textarea data-id="<?= $car_revisi->kecelakaan_car_id ?>" name="" id="" placeholder="Catatan" style="resize: vertical; max-height: 75px; min-height: 25px; height: 35px;" class="form-control js-car-notes" <?= in_array($car_revisi->approval_status, [CAR_STATUS::CLOSED, CAR_STATUS::REVISI]) ? 'readonly' : '' ?>><?= $car_revisi->notes ?></textarea>
                                    </td>
                                    <td style="display: flex; align-items: center;">
                                      <span class="status <?= $car_revisi->approval_status ?>">
                                        <?= CAR_STATUS::getStatus($car_revisi->approval_status) ?>
                                      </span>
                                    </td>
                                    <td nowrap>
                                      <?php if (in_array($car_revisi->approval_status, [CAR_STATUS::VERIFIED, CAR_STATUS::OPEN])) : ?>
                                        <a href="" data-id="<?= $car_revisi->kecelakaan_car_id ?>" class="btn btn-sm btn-danger js-approval-revisi">Revisi</a>
                                        <a href="" data-id="<?= $car_revisi->kecelakaan_car_id ?>" class="btn btn-sm btn-warning js-approval-open">
                                          Open <?= $car_revisi->approval_status == CAR_STATUS::OPEN && $car_revisi->open_status_count > 1 ? $car_revisi->open_status_count : '' ?>
                                        </a>
                                        <a href="" data-id="<?= $car_revisi->kecelakaan_car_id ?>" class="btn btn-sm btn-success js-approval-close">Close</a>
                                      <?php elseif ($car_revisi->approval_status == CAR_STATUS::REVISI) : ?>
                                        <!-- no action -->
                                      <?php endif ?>
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
  'use strict';

  ! function() {
    const $form = $('form');
    const $car_table = $('table#car_table');
    const $addButton = $('#add_button');
    const $firstRow = $car_table.find('tbody > tr');
    const $firstRowClone = $firstRow.clone()

    // When notes on changed
    $('.js-car-notes').on('change', function() {
      const value = $(this).val()
      const id = $(this).data('id')

      $.ajax({
        method: 'POST',
        url: baseurl + 'p2k3adm_V2/Admin/Car/Approval/Tim/Notes',
        data: {
          id,
          notes: value
        },
        success() {
          $.toaster('Sukses memperbaharui catatan')
        },
        error() {
          $.toaster('Gagal memperbaharui catatan', 'Gagal', 'error')

        },
        complete() {

        }
      })
    })

    const approvalService = (buttonNode, id, approval_status, action) => {
      return new Promise((resolve, reject) => {

        Swal.fire({
          title: `Apakah anda yakin ${action}?`,
          text: '',
          type: 'question',
          showCancelButton: true
        }).then(({
          value
        }) => {
          if (!value) return;

          const $tr = $(buttonNode).parents('tr')
          console.log($tr);

          $.ajax({
            method: 'POST',
            url: baseurl + 'p2k3adm_V2/Admin/Car/Approval/Tim',
            data: {
              id,
              approval_status
            },
            beforeSend() {
              // make row unclickable
              $tr.css({
                opacity: 0.6,
                cursor: 'progress',
                'pointer-events': 'none',
              })
            },
            success(response) {
              resolve(response)
            },
            error() {
              reject('Failed');
            },
            complete() {
              console.log("System: Approval complete")
              $tr.css({
                opacity: 1,
                cursor: 'default',
                'pointer-events': 'all',
              })
            }
          })
        })
      })
    }

    // When click revisi
    $('.js-approval-revisi').on('click', function(e) {
      e.preventDefault()
      const id = $(this).data('id');
      const approval_status = '<?= CAR_STATUS::REVISI ?>'
      const _this = this

      approvalService(_this, id, approval_status, 'untuk Revisi CAR ini')
        .then(() => {
          // change status to revisi
          $(_this).parents('tr').find('.status')
            .attr('class', 'status <?= CAR_STATUS::REVISI ?>')
            .text('<?= CAR_STATUS::getStatus(CAR_STATUS::REVISI) ?>')
          // remove all action
          $(_this).parents('td').html('')

          // show alert
          $.toaster('CAR telah diubah menjadi revisi')
        })
        .catch((err) => {
          // do nothing, all has been handled
        })
    });

    // When click open
    $('.js-approval-open').on('click', function(e) {
      e.preventDefault()
      const id = $(this).data('id');
      const approval_status = '<?= CAR_STATUS::OPEN ?>'
      const _this = this

      approvalService(_this, id, approval_status, 'untuk Open CAR ini')
        .then((response) => {
          // set status to open
          // update status to open
          $(_this).parents('tr').find('.status')
            .attr('class', 'status <?= CAR_STATUS::OPEN ?>')
            .text('<?= CAR_STATUS::getStatus(CAR_STATUS::OPEN) ?>')

          const openCount = response.approval_status.open.count

          // if more than 1 update to dom
          if (openCount > 1) {
            $(_this).text(`Open ${openCount}`)
          }
          $.toaster('CAR berhasil di open')
        })
        .catch((err) => {
          // do nothing, all has been handled
        })
    });

    // When click close
    $('.js-approval-close').on('click', function(e) {
      e.preventDefault()
      const id = $(this).data('id');
      const approval_status = '<?= CAR_STATUS::CLOSED ?>'
      const _this = this

      approvalService(_this, id, approval_status, 'untuk close CAR ini')
        .then(() => {
          // update status to closed
          $(_this).parents('tr').find('.status')
            .attr('class', 'status <?= CAR_STATUS::CLOSED ?>')
            .text('<?= CAR_STATUS::getStatus(CAR_STATUS::CLOSED) ?>')
          // remove all action
          $(_this).parents('td').html('')
          // disabled notes
          $(_this).find('textarea.js-car-notes').prop('disabled', true)

          // show alert
          $.toaster('CAR berhasil di close')
        })
        .catch((err) => {
          // do nothing, all has been handled
        })
    });
  }();
</script>