<style>
  .form-group {
    margin-bottom: 0.25em;
  }

  .select2 {
    width: 100% !important;
  }

  @keyframes blink {
    0% {
      opacity: 1;
    }

    50% {
      opacity: 0;
    }

    100% {
      opacity: 1;
    }
  }
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
              <h1><b>Lihat CAR</b></h1>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border"></div>
              <div class="box-body">
                <div class="panel-body">
                  <?php if ($this->session->flashdata('success')) : ?>
                    <div class="alert alert-success">
                      <?= $this->session->flashdata('success') ?>
                    </div>
                  <?php elseif ($this->session->flashdata('error')) :  ?>
                    <div class="alert alert-error">
                      <?= $this->session->flashdata('error') ?>
                    </div>
                  <?php endif ?>
                  <div class="row">
                    <?php $this->load->view('P2K3V2/P2K3Admin/KecelakaanKerja/CAR/_partials/KecelakaanHeader') ?>
                    <div class="col-md-12 mb-2">
                      <hr>
                      <span class="pull-left">Action :</span>
                      <div class="pull-right">
                        <?php if (!$isAllClosed) : ?>
                          <button id="add_button" class="btn btn-primary">
                            <i class="fa fa-plus"></i>
                            Tambah
                          </button>
                        <?php endif ?>
                      </div>
                    </div>
                    <form action="<?= base_url('p2k3adm_V2/Admin/Car/Update/' . $id_kecelakaan) ?>" method="POST">
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
                                <th>Catatan dr Tim</th>
                                <th>Status</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($cars as $i => $car) : ?>
                                <tr>
                                  <td class="text-center js-row-number">
                                    <input type="hidden" name="action[]" value="<?= $car->approval_status == CAR_STATUS::PROCESS ? 'UPDATE' : '' ?>" <?= $car->approval_status == CAR_STATUS::PROCESS ? '' : 'disabled' ?>>
                                    <input type="hidden" name="car_id[]" value="<?= $car->kecelakaan_car_id ?>" <?= $car->approval_status == CAR_STATUS::PROCESS ? '' : 'disabled' ?>>
                                    <input type="hidden" name="sub_car_revision_id[]" value="" <?= $car->approval_status == CAR_STATUS::PROCESS ? '' : 'disabled' ?>>
                                    <span>
                                      <?= $i + 1 ?>
                                    </span>
                                  </td>
                                  <td>
                                    <?php
                                    $factors = ['Man', 'Machine', 'Method', 'Working', 'Area', 'Other'];
                                    ?>
                                    <select class="form-control" name="factor[]" required <?= $car->approval_status == CAR_STATUS::PROCESS ? '' : 'disabled' ?>>
                                      <?php foreach ($factors as $factor) : ?>
                                        <option value="<?= $factor ?>" <?= $factor == $car->factor ? 'selected' : '' ?>><?= $factor ?></option>
                                      <?php endforeach ?>
                                    </select>
                                  </td>
                                  <td>
                                    <input autocomplete="off" type="text" placeholder="Tulis akar masalah ..." value="<?= $car->root_cause ?>" name="root_cause[]" class="form-control" required <?= $car->approval_status == CAR_STATUS::PROCESS ? '' : 'disabled' ?>>
                                  </td>
                                  <td>
                                    <input autocomplete="off" type="text" placeholder="Tulis tindakan ..." value="<?= $car->corrective_action ?>" name="corrective_action[]" class="form-control" required <?= $car->approval_status == CAR_STATUS::PROCESS ? '' : 'disabled' ?>>
                                  </td>
                                  <td>
                                    <?php if ($car->approval_status == CAR_STATUS::PROCESS) : ?>
                                      <select class="form-control js-pic-select2" name="noind_pic[]" required>
                                        <option value="<?= $car->noind_pic ?>" selected="selected"><?= $car->noind_pic . " - " . $car->nama_pic ?></option>
                                      </select>
                                    <?php else : ?>
                                      <input autocomplete="off" type="text" value="<?= $car->noind_pic . " - " . $car->nama_pic ?>" name="noind_pic[]" class="form-control" disabled>
                                    <?php endif ?>
                                  </td>
                                  <td>
                                    <input type="text" autocomplete="off" placeholder="Tanggal jatuh tempo" value="<?= $car->due_date ?>" name="due_date[]" class="form-control js-datepicker" required <?= $car->approval_status == CAR_STATUS::PROCESS ? '' : 'disabled' ?>>
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
                                      <input type="hidden" name="car_id[]" value="<?= $car_revisi->kecelakaan_car_id ?>" <?= $car_revisi->approval_status == CAR_STATUS::PROCESS ? '' : 'disabled' ?>>
                                      <input type="hidden" name="sub_car_revision_id[]" value="<?= $car_revisi->sub_revisi_kecelakaan_car_id ?>" <?= $car_revisi->approval_status == CAR_STATUS::PROCESS ? '' : 'disabled' ?>>
                                    </td>
                                    <td>
                                      <?php
                                      $factors = ['Man', 'Machine', 'Method', 'Working', 'Area', 'Other'];
                                      ?>
                                      <select class="form-control" name="factor[]" required <?= $car_revisi->approval_status == CAR_STATUS::PROCESS ? '' : 'disabled' ?>>
                                        <?php foreach ($factors as $factor) : ?>
                                          <option value="<?= $factor ?>" <?= $factor == $car_revisi->factor ? 'selected' : '' ?>><?= $factor ?></option>
                                        <?php endforeach ?>
                                      </select>
                                    </td>
                                    <td>
                                      <input autocomplete="off" type="text" placeholder="Tulis akar masalah ..." value="<?= $car_revisi->root_cause ?>" name="root_cause[]" class="form-control" required <?= $car_revisi->approval_status == CAR_STATUS::PROCESS ? '' : 'disabled' ?>>
                                    </td>
                                    <td>
                                      <input autocomplete="off" type="text" placeholder="Tulis tindakan ..." value="<?= $car_revisi->corrective_action ?>" name="corrective_action[]" class="form-control" required <?= $car_revisi->approval_status == CAR_STATUS::PROCESS ? '' : 'disabled' ?>>
                                    </td>
                                    <td>
                                      <?php if ($car_revisi->approval_status == CAR_STATUS::PROCESS) : ?>
                                        <select class="form-control js-pic-select2" value="<?= $car_revisi->noind_pic ?>" name="noind_pic[]" required <?= $car_revisi->approval_status == CAR_STATUS::PROCESS ? '' : 'disabled' ?>>
                                          <option value="<?= $car_revisi->noind_pic ?>" selected><?= $car_revisi->noind_pic . " - " . $car_revisi->nama_pic ?></option>
                                        </select>
                                      <?php else : ?>
                                        <input autocomplete="off" type="text" value="<?= $car_revisi->noind_pic . " - " . $car_revisi->nama_pic ?>" name="noind_pic[]" class="form-control" disabled>
                                      <?php endif ?>
                                    </td>
                                    <td>
                                      <input type="text" autocomplete="off" placeholder="Tanggal jatuh tempo" value="<?= $car_revisi->due_date ?>" name="due_date[]" class="form-control js-datepicker" required <?= $car_revisi->approval_status == CAR_STATUS::PROCESS ? '' : 'disabled' ?>>
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

                                <?php if (count($car->revisi) > 0 && end($car_revisi)->approval_status == CAR_STATUS::REVISI) : ?>
                                  <?php
                                  $this->load->view('P2K3V2/P2K3Admin/KecelakaanKerja/CAR/_partials/EmptyCarList', [
                                    'kecelakaan_car_id' => $car->kecelakaan_car_id
                                  ]);
                                  ?>
                                <?php endif ?>

                                <!-- jika ada car dengan status revisi dan belum ada revisi maka tampilkan form revisi kosong -->
                                <?php if ($car->approval_status == CAR_STATUS::REVISI && count($car->revisi) == 0) : ?>
                                  <?php $this->load->view('P2K3V2/P2K3Admin/KecelakaanKerja/CAR/_partials/EmptyCarList', [
                                    'kecelakaan_car_id' => $car->kecelakaan_car_id
                                  ]) ?>
                                <?php endif ?>
                              <?php endforeach ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="pull-right">
                          <a id="cancel_button" style="display: none;" class="btn">Batal</a>
                          <button class="btn btn-success" style="display: none;" id="save_button">Simpan dan ajukan</button>
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

  // show save button
  // if has any delete button
  // if has process approval status
  function showOrNotSaveButton() {
    // if has remove button or has any car with process status or has a empty car template
    if ($('.js-remove-row').length > 0 || $('.status.process').length > 0 || $('.empty-car').length > 0) {
      $('#save_button').show();
    } else {
      $('#save_button').hide();
    }
  }

  showOrNotSaveButton();

  ! function() {
    $(() => {

      const baseurl = '<?= base_url() ?>';
      const $form = $('form');
      const $car_table = $('table#car_table');
      const $addButton = $('#add_button');
      const $firstRow = $car_table.find('tbody > tr:first');
      const $firstRowClone = $firstRow.clone()
      const $saveButton = $('#save_button');
      const $cancelButton = $('#cancel_button');

      $('.js-datepicker').not('[readonly]').datepicker({
        todayHighlight: true,
        format: 'yyyy-mm-dd'
      })

      const initPICSelect = ($elem) => {
        $elem.select2({
          ajax: {
            url: baseurl + "p2k3adm_V2/Admin/Car/api/employeePIC",
            dataType: "json",
            type: "get",
            data: function(params) {
              return {
                q: params.term
              };
            },
            processResults: function({
              data
            }) {
              const temp = {
                results: $.map(data, function(item) {
                  return {
                    id: item.noind,
                    text: item.noind.trim() + " - " + item.nama.trim(),
                  };
                }),
              };

              return temp;
            },
            cache: true,
          },
          delay: 1000,
          minimumInputLength: 3,
          placeholder: "Pilih PIC",
        })
      }

      $(window).load(() => {
        initPICSelect($('.js-pic-select2'));
      })

      /**
       * last row init
       * when new dom of row created
       */
      function lastRowInit() {
        const $lastRow = $car_table.find('tbody > tr:last');

        initPICSelect($lastRow.find('.js-pic-select2'));
        // init datepicker
        $lastRow.find('.js-datepicker').datepicker({
          todayHighlight: true,
          format: 'yyyy-mm-dd',
          autoclose: true
        })
      }

      // when add button on click
      $addButton.on('click', () => {
        const $tbody = $car_table.find('tbody')

        const $lastRow = `
        <tr>
          <td class="text-center js-row-number">${$car_table.find('tbody > tr').length + 1}</td>
          <td>
            <select class="form-control" name="factor[]" required>
              <option value="Man" selected>Man</option>
              <option value="Machine">Machine</option>
              <option value="Method">Method</option>
              <option value="Working">Working</option>
              <option value="Area">Area</option>
              <option value="Other">Other</option>
            </select>
          </td>
          <td>
            <input type="text" placeholder="Tulis akar masalah ..." name="root_cause[]" class="form-control" required>
          </td>
          <td>
            <input type="text" placeholder="Tulis tindakan ..." name="corrective_action[]" class="form-control" required>
          </td>
          <td>
            <select class="form-control js-pic-select2" name="noind_pic[]" required>
            </select>
          </td>
          <td>
            <input type="text" autocomplete="off" placeholder="Tanggal jatuh tempo" name="due_date[]" class="form-control js-datepicker" required>
          </td>
          <td></td>
          <td style="display: flex; align-items: center;">

          </td>
          <td class="text-center">
            <a class="text-danger js-remove-row" href="">
              <i class="fa fa-trash"></i>
            </a>
          </td>
        </tr>
        `

        $tbody.append($lastRow)
        lastRowInit()
        // show save button
        $saveButton.show();
        $cancelButton.show();
      })

      // when delete button on each row on click
      $car_table.on('click', '.js-remove-row', function(e) {
        e.preventDefault()
        if (confirm("Apakah yakin ingin menghapus data ini ?")) {
          $(this).parents('tr').remove();
          // rearrange number
          $car_table.find('tbody > tr').each((i, elem) => {
            $(elem).find('.js-row-number').text(i + 1)
          })

          showOrNotSaveButton()
          if ($('.js-remove-row').length == 0) {
            $cancelButton.hide()
          }
        }
      })

      $cancelButton.on('click', () => {
        if (!confirm('Yakin untuk membatalkan ?')) return;

        $('.js-remove-row').parents('tr').remove()
        showOrNotSaveButton()
        $cancelButton.hide()
      })

      // when save button is click
      $saveButton.on('click', function(e) {
        e.preventDefault()

        return Swal.fire({
          title: "Apakah anda yakin untuk submit CAR ?",
          text: "",
          type: "question",
          showCancelButton: true,
        }).then(({
          value
        }) => {
          if (!value) return;

          // TODO: add validation logic
          const valid = true;

          if (valid) {
            $saveButton.prop('disabled', true)
            $form.submit()
          }
        })
      })
    })
  }();
</script>