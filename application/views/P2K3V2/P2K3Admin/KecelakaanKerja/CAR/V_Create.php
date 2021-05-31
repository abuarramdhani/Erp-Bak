<style>
  .form-group {
    margin-bottom: 0.25em;
  }

  .select2 {
    width: 100% !important;
  }

  .status.process {
    padding: 0.2em 0.7em;
    border-radius: 8px;
    background-color: #ffe266;
    color: #d17c00;
  }
</style>
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
              <h1><b>Input CAR</b></h1>
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
                      <div class="pull-right">
                        <button id="add_button" class="btn btn-primary">
                          <i class="fa fa-plus"></i>
                          Tambah
                        </button>
                      </div>
                    </div>
                    <form action="<?= base_url('p2k3adm_V2/Admin/Car/Create') ?>" method="POST">
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
                                <th>Status</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td class="text-center js-row-number">1</td>
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
                                <td style="display: flex; align-items: center;">
                                  <span class="status process">
                                    Pending
                                  </span>
                                </td>
                                <td class="text-center">
                                  <a class="text-danger js-remove-row" href="">
                                    <i class="fa fa-trash"></i>
                                  </a>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="pull-right">
                          <button class="btn btn-success" id="save_button">Simpan</button>
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

<script>
  'use strict';

  ! function() {
    const $form = $('form');
    const $car_table = $('table#car_table');
    const $addButton = $('#add_button');
    const $firstRow = $car_table.find('tbody > tr');
    const $firstRowClone = $firstRow.clone()
    const $saveButton = $('#save_button');

    /**
     * last row init
     * when new dom of row created
     */
    function lastRowInit() {
      const $lastRow = $car_table.find('tbody > tr:last');
      // init select2
      $lastRow.find('.js-pic-select2').select2({
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

      // init datepicker
      $lastRow.find('.js-datepicker').datepicker({
        todayHighlight: true,
      })
    }

    // when add button on click
    $addButton.on('click', () => {
      const $body = $car_table.find('tbody')
      const $lastRow = $firstRowClone.clone();
      $lastRow.find('.js-row-number').text($car_table.find('tbody > tr').length + 1)

      $body.append($lastRow)
      lastRowInit()
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
      }
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
          $form.submit()
        }
      })
    })

    $(document).on('ready', lastRowInit)
  }();
</script>