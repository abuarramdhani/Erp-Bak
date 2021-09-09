<style>
  h3 {
    margin: 0;
  }

  .font-weight-bold {
    font-weight: bold;
  }

  tr.bordered>td {
    border: 1px solid black !important;
  }

  .btn-black {
    background-color: black;
    color: white;
  }

  /* customize modal open animation */
  .fade-scale {
    transform: scale(0);
    opacity: 0;
    -webkit-transition: all .25s linear;
    -o-transition: all .25s linear;
    transition: all .25s linear;
  }

  .modal.in>.fade-scale {
    opacity: 1;
    transform: scale(1);
  }

  input {
    width: 100% !important;
  }

  button.shimmer {
    background-image: linear-gradient(to right, transparent 50%, rgba(0, 0, 0, .05) 70%);
    background-size: 200% 100%;
    animation: loading 2s cubic-bezier(0.4, 0, 0.2, 1) infinite;
  }

  .select2 {
    width: 100% !important;
  }

  /* OVERRIDING DEFAULT ALERT BOOTSTRAP */
  .alert.alert-success {
    background-color: #bcffc1 !important;
    color: #188118 !important;
    border: none;
  }

  .alert.alert-warning {
    background-color: #ffedbc !important;
    color: #815218 !important;
    border: none;
  }

  .alert.alert-error {
    background-color: #ffbcbc !important;
    color: #811818 !important;
    border: none;
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
                <h1><b>Notula Sampling Catering</b></h1>
              </div>
            </div>
            <div class="col-lg-1">
              <div class="text-right hidden-md hidden-sm hidden-xs">
                <a href="" class="btn btn-default btn-lg">
                  <i class="icon-wrench icon-2x"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header">
              </div>
              <div class="box-body">
                <div class="col-md-4 mb-4">
                  <form action="<?= base_url('CateringManagement/NotulaSampling') ?>">
                    <div class="form-group">
                      <label for="">Bulan</label>
                      <div class="input-group">
                        <input type="text" placeholder="Bulan" class="form-control js-month-datepicker" name="year_month" value="<?= $this->input->get('year_month') ?: date('Y-m') ?>">
                        <div class="input-group-addon bg-primary">
                          <i class="fa fa-calendar"></i>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="">Penyedia Catering</label>
                      <div class="row">
                        <div class="col-md-12">
                          <select name="kd_katering" id="" class="form-control select2">
                            <option value="">Semua</option>
                            <?php foreach ($cateringProvider as $catering) : ?>
                              <option value="<?= $catering->fs_kd_katering ?>" <?= $catering->fs_kd_katering == $this->input->get('kd_katering') ? 'selected' : '' ?>><?= $catering->fs_nama_katering ?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div>
                      <?php if ($this->input->get('year_month')) : ?>
                        <small>*) Menampilkan hasil untuk <span class="text-danger"><?= $this->input->get('kd_katering') ?: "Semua" ?></span> Catering dengan rentang waktu <span class="text-danger"><?= $this->input->get('year_month') ?></span></small>
                      <?php endif ?>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">
                      <i class="fa fa-search"></i>
                      Cari
                    </button>
                  </form>
                  <div class="col-md-12">
                    <?php if ($this->session->flashdata('success')) : ?>
                      <?= $this->session->flashdata('success') ?>
                    <?php endif ?>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="pull-right">
                    <button role="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-generate-menu">
                      Generate Menu per Bulan
                    </button>
                  </div>
                </div>
                <div class="col-md-12">
                  <hr>
                </div>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="mb-4">
                        <form action="<?= base_url('CateringManagement/NotulaSampling/Export') ?>" target="_blank">
                          <input type="hidden" name="year_month" id="year_month_displayed" value="<?= $this->input->get('year_month') ?: date('Y-m') ?>">
                          <input type="hidden" name="kd_katering" value="<?= $this->input->get('kd_katering') ?>">
                          <button type="submit" name="export_type" value="excel" class="btn btn-success">
                            <i class="fa fa-file-excel-o"></i>
                            Excel
                          </button>
                          <button type="submit" name="export_type" value="pdf" class="btn btn-danger">
                            <i class="fa fa-file-pdf-o"></i>
                            PDF
                          </button>
                        </form>
                      </div>
                      <div class="table-responsive">
                        <table id="sampling-catering" class="table table-bordered">
                          <thead class="bg-primary">
                            <tr>
                              <th>Hari <br> Tanggal</th>
                              <th width="15%">Menu</th>
                              <th width="5%">Std</th>
                              <th width="5%">Berat</th>
                              <th width="10%">Rasa</th>
                              <th width="10%">Keterangan</th>
                              <th width="10%">PIC</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                            $redColor = "#ff9494";
                            $greenColor = "#ceffc1";
                            ?>
                            <?php foreach ($notulaSamplings as $sampling) : ?>
                              <?php
                              $date = $sampling->tanggal . " / " .  $dayNames[strftime('%w', strtotime($sampling->tanggal))] . " / Shift " . $sampling->shift;
                              $base64_id = base64_encode($date);

                              $rowColor = "#fff";

                              if (!is_null($sampling->denda)) {
                                if ($sampling->denda == 1) {
                                  $rowColor = $redColor;
                                } else { // 0
                                  $rowColor = $greenColor;
                                }
                              }

                              ?>
                              <tr data-group="<?= $base64_id ?>" data-id="<?= $sampling->id ?>" class="bordered" style="background: <?= $rowColor ?>">
                                <td>
                                  <h3>
                                    <?= $date ?>
                                  </h3>
                                  <span>
                                    <?= $sampling->fs_nama_katering ?>
                                  </span>
                                </td>
                                <td class="font-weight-bold"><?= $sampling->menu ?></td>
                                <td>
                                  <input type="number" value="<?= $sampling->standard ?>" placeholder="Standard..." name="standard" id="" disabled>
                                </td>
                                <td>
                                  <input type="number" value="<?= $sampling->berat ?>" placeholder="Berat..." name="berat" disabled>
                                </td>
                                <td>
                                  <input type="text" value="<?= $sampling->rasa ?>" placeholder="Rasa..." name="rasa" disabled>
                                </td>
                                <td>
                                  <input type="text" value="<?= $sampling->keterangan ?>" placeholder="Keterangan" name="keterangan" disabled>
                                </td>
                                <td>
                                  <input type="text" value="<?= $sampling->pic ?>" placeholder="PIC" name="pic" disabled>
                                </td>
                              </tr>
                            <?php endforeach ?>
                          </tbody>
                        </table>
                        <?php if (empty($notulaSamplings)) : ?>
                          <div class="row">
                            <div class="col-md-12 text-center mb-4">
                              Menu kosong atau belum digenerate
                            </div>
                          </div>
                        <?php endif ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="modal-generate-menu" class="modal">
    <div class="modal-dialog">
      <div class="modal-content" style="margin: 0 auto; width: 300px;">
        <div class="modal-header">
          <h3>Generate Menu</h3>
        </div>
        <div class="modal-body">
          <form action="">
            <div class="form-group">
              <label for="">Bulan</label>
              <input type="text" placeholder="Periode bulan" value="<?= date('Y-m') ?>" autocomplete="off" name="year_month" class="form-control js-month-datepicker">
            </div>
            <div class="form-group">
              <label for="">Catering</label>
              <select class="form-control select2" name="kd_catering" id="" required>
                <?php foreach ($cateringProvider as $catering) : ?>
                  <option value="<?= $catering->fs_kd_katering ?>"><?= $catering->fs_nama_katering ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="alert-wrapper">
            </div>
            <button role="button" id="generate" class="btn btn-primary btn-block">
              Generate Menu
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    baseurl = '<?= base_url() ?>';

    $(document).ready(function() {
      $('.select2').select2()
      $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
      });
      $('.js-daterange-picker').daterangepicker({
        todayHighlight: true,
        locale: {
          format: 'YYYY/MM/DD'
        }
      })
      $('.js-month-datepicker').datepicker({
        autoClose: true,
        changeMonth: true,
        changeYear: true,
        todayHighlight: true,
        format: 'yyyy-mm',
        viewMode: "months",
        minViewMode: "months"
      })

      const HTMLdenda = `
        <span style="background: #eaea3e;
                    border-radius: 6px;
                    font-weight: bold;
                    color: #ff1919;
                    padding: 0.5em 1em;
                    border: 1px solid #ff5e4e;
        ">
          Denda 5%
        </span>
      `

      // Tampil Notif Denda
      // jika berat kurang dr standard maka merah
      // jika lebih maka hijau
      // jika isian kosong salah satu atau kosong semua, warna menjadi putih
      const redColor = "#ff9494";
      const greenColor = "#ceffc1";
      // Set color of row when berat or standard is changed
      const mixinSetColorOfRow = ($row, $berat, $standard) => {
        const group_id = $row.data('group')

        // color of row
        if ($berat.val() && $standard.val()) {
          if (Number($berat.val()) < Number($standard.val())) {
            $row.css('background-color', redColor)
            $(`tr.group-title[data-group-title-id="${group_id}"]`).find('.js-denda').html(HTMLdenda)
          } else {
            $row.css('background-color', greenColor)
            $(`tr.group-title[data-group-title-id="${group_id}"]`).find('.js-denda').html('')
          }
        } else {
          $row.css('background-color', '#fff')

        }
      }

      const mixinSetDendaOfGroup = ($row) => {
        const group_id = $row.data('group')

        // find invalid berat on group
        let hasDenda = false;
        $(`tr[data-group="${group_id}"]`).each(function() {
          const berat = $(this).find('input[name=berat]').val();
          const standard = $(this).find('input[name=standard]').val();

          if (hasDenda === false) {
            if (Number(berat) && Number(standard)) {
              if (Number(berat) < Number(standard)) hasDenda = true;
            }
          }
        })

        // display denda or not
        if (hasDenda) {
          $(`tr.group-title[data-group-title-id="${group_id}"]`).find('.js-denda').html(HTMLdenda)
        } else {
          $(`tr.group-title[data-group-title-id="${group_id}"]`).find('.js-denda').html('')
        }
      }

      $('table#sampling-catering tbody input[name=standard]').on('keyup change', function() {
        const $row = $(this).parents('tr')
        const $berat = $row.find('input[name=berat]')
        const $standard = $(this)

        mixinSetColorOfRow($row, $berat, $standard);
        mixinSetDendaOfGroup($row);
      })

      $('table#sampling-catering tbody input[name=berat]').on('keyup change', function() {
        const $row = $(this).parents('tr')
        const $berat = $(this)
        const $standard = $row.find('input[name=standard]')

        mixinSetColorOfRow($row, $berat, $standard);
        mixinSetDendaOfGroup($row);
      })

      var groupColumn = 0;
      if ($('table#sampling-catering tbody tr').length > 0) {
        var table = $('table#sampling-catering').DataTable({
          orderable: false,
          "columnDefs": [{
            "visible": false,
            "targets": groupColumn
          }],
          "order": [
            [groupColumn, 'asc']
          ],
          initComplete() {},
          "displayLength": 25,
          "drawCallback": function(settings) {
            var api = this.api();
            var rows = api.rows({
              page: 'current'
            }).nodes();

            var last = null;

            api.column(groupColumn, {
              page: 'current'
            }).data().each(function(group, i) {

              mixinSetDendaOfGroup($(rows).eq(i));

              if (last !== group) {
                const group_id = $(rows).eq(i).data('group')
                const inputIsHidden = $(rows).eq(i).find('input:first').is(':disabled');

                const standardWeight = $(rows).eq(i).find('input[name=standard]').val();
                const actualWeight = $(rows).eq(i).find('input[name=berat]').val();

                /**
                 * @param Int standard
                 * @param Int weight
                 */
                const weightIsValid = (standard, weight) => {
                  if (!Number(standard) && !Number(weight)) return null;

                  if (weight < standard) return false;

                  return true;
                }

                $(rows).eq(i).before(
                  `
                  <tr class="group text-center bordered group-title" data-group-title-id="${group_id}">
                    <td class="bg-primary" colspan="6">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="mt-4 text-left js-denda">
                          ${ weightIsValid(standardWeight, actualWeight) === false ? 
                            HTMLdenda  : ''
                          }
                          </div>
                        </div>
                        <div class="col-md-4">
                          <h3>${group}</h3>
                        </div>
                        <div class="col-md-4">
                          <div class="pull-right">
                            <button class="btn btn-primary ${inputIsHidden ? '' : 'open' } js-edit">
                              <i class="fa ${inputIsHidden ? 'fa-pencil' : 'fa-close' }" />
                            </button>
                            <button class="btn btn-success ${inputIsHidden ? 'hidden' : ''} js-save">
                              <i class="fa fa-save" /> Simpan perubahan
                            </button>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                  `
                );

                const $header = $(rows).eq(i).prev();

                const $edit_button = $header.find('.js-edit');
                const $save_button = $header.find('.js-save');

                let state = {
                  data: null,
                  isChanged: false
                }

                const hideSaveButton = (group) => {
                  // show edit button
                  $edit_button.find('i').addClass('fa-pencil');
                  $edit_button.find('i').removeClass('fa-close');
                  $edit_button.removeClass('open')
                  $save_button.addClass('hidden')

                  // set all input
                  $(`tr[data-group="${group}"] input`).each(function(i, elem) {
                    if (!state.data) return;
                    $(elem).replaceWith(state.data.get(i));
                  })

                  $(`tr[data-group="${group}"] input`).prop('disabled', true);
                }

                const showSaveButton = (group) => {
                  // show close button
                  $edit_button.find('i').removeClass('fa-pencil');
                  $edit_button.find('i').addClass('fa-close');
                  $edit_button.addClass('open')
                  $save_button.removeClass('hidden')

                  $(`tr[data-group="${group}"] input`).prop('disabled', false);

                  // backup all input
                  state.data = $(`tr[data-group="${group}"] input`).clone();
                }

                $edit_button.on('click', function(e) {
                  e.stopPropagation()
                  const $tr = $(this).parents('tr').next();
                  const group = $tr.data('group')

                  // edit button
                  if ($edit_button.hasClass('open')) {
                    hideSaveButton(group)
                  } else {
                    showSaveButton(group)
                  }
                })

                $save_button.on('click', function(e) {
                  e.stopPropagation();
                  const $this = $(this);
                  const $tr = $(this).parents('tr').next();
                  const group = $tr.data('group')

                  const tempAllInput = $(`tr[data-group="${group}"] input`).clone();

                  let data = []
                  $(`tr[data-group="${group}"]`).each(function(i, elem) {
                    const id = $(elem).data('id');

                    data.push({
                      id,
                      standard: $(elem).find('input[name=standard]').val(),
                      berat: $(elem).find('input[name=berat]').val(),
                      rasa: $(elem).find('input[name=rasa]').val(),
                      keterangan: $(elem).find('input[name=keterangan]').val(),
                      pic: $(elem).find('input[name=pic]').val(),
                    })
                  });

                  Swal.fire({
                    title: 'Apakah anda yakin untuk mengupdate data ini ?',
                    text: '',
                    type: 'question',
                    showCancelButton: true,
                  }).then(({
                    value
                  }) => {
                    if (!value) return;

                    $.ajax({
                      method: 'POST',
                      url: baseurl + 'CateringManagement/NotulaSampling/Api/UpdateSampling',
                      data: {
                        data
                      },
                      beforeSend() {
                        // Show loading
                        $this.prop('disabled', true)
                      },
                      success() {
                        // Alert on top right if success
                        $.toaster("menyimpan sampling", "Sukses", 'success')

                        $(`tr[data-group="${group}"] input`).each(function(i, elem) {
                          if (!tempAllInput) return;
                          $(elem).replaceWith(tempAllInput.get(i));
                        })

                        state.data = tempAllInput;
                        hideSaveButton(group)
                      },
                      error() {
                        // Alert on top right if failed
                        $.toaster('Gagal menyimpan sampling', 'Error', 'danger');
                      },
                      complete() {
                        // Hide loading
                        $this.prop('disabled', false)
                      }
                    })
                  }); // end swal fire
                }); // end $save_button on click
                last = group;
              } // end if
            }); // end Jquery $.each
          } // end draw callback function
        }); // end datatable
      } // end if

      // Order by the grouping
      $('table#sampling-catering tbody').on('click', 'tr.group', function() {
        var currentOrder = table.order()[0];
        if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
          table.order([groupColumn, 'desc']).draw();
        } else {
          table.order([groupColumn, 'asc']).draw();
        }
      });

      /** 
       * Modal life cycle
       */
      ! function() {
        // Generate Menu
        const modalGenerateMenus = {
          $modal: $('#modal-generate-menu'),
          $year_month: $('#modal-generate-menu').find('input[name=year_month]'),
          $kd_catering: $('#modal-generate-menu').find('select[name=kd_catering]'),
          $submitButton: $('#modal-generate-menu').find('button#generate'),
          $alertWrapper: $('#modal-generate-menu').find('.alert-wrapper'),
          showAlert(type, text = "Alert has not been configured") {
            this.$alertWrapper.html(`
              <div class="alert alert-${type} p-3">
                ${text}
              </div>
            `)
          },
          hideAlert() {
            this.$alertWrapper.html('')
          },
          checkCateringAlreadyGenerated() {
            const _this = this;
            $.ajax({
              method: 'GET',
              url: baseurl + 'CateringManagement/NotulaSampling/CheckCateringGenerated',
              data: {
                kd_catering: this.$kd_catering.val(),
                year_month: this.$year_month.val()
              },
              beforeSend() {
                _this.hideAlert()
              },
              success(response) {
                if (response.exist) {
                  _this.$submitButton.prop('disabled', true)
                  _this.showAlert('error', 'Sudah pernah digenerate !')
                } else {
                  _this.$submitButton.prop('disabled', false)
                  _this.hideAlert()
                }
              },
              error() {
                console.error('Failed to fetch')
                this.$submitButton.prop('disabled', false)
              },
              complete() {}
            })
          },
          onClick(e) {
            e.preventDefault()
            const month = this.$year_month.val();
            const _this = this

            if (!month) return;

            $.ajax({
              method: 'POST',
              url: baseurl + 'CateringManagement/NotulaSampling/GenerateSamplingTemplate',
              data: {
                year_month: _this.$year_month.val(),
                kd_catering: _this.$kd_catering.val()
              },
              beforeSend() {
                _this.$submitButton.prop('disabled', true)
              },
              success(response) {
                if (response.status == 'ok') {
                  $.toaster(`Berhasil generate sampling bulan ${_this.$year_month.val()}`, 'Success', 'success')
                } else if (response.status == 'exist') {
                  $.toaster(`Sampling sudah pernah digenerate`, 'Failed', 'warning')
                } else {
                  $.toaster(response.message, 'Failed', 'error')
                }

                // reload page if month is same with displayed month
                if ($('input#year_month_displayed') == _this.$year_month.val()) window.location.reload();
              },
              error() {
                $.toaster(`Kesalahan server ..`, 'Fail', 'error')
              },
              complete() {
                _this.$submitButton.prop('disabled', false)
              }
            })
          },
          init() {
            this.$submitButton.on('click', (e) => this.onClick(e))
            this.$year_month.on('change', () => this.checkCateringAlreadyGenerated())
            this.$kd_catering.on('change', () => this.checkCateringAlreadyGenerated())
            this.$modal.on('show.bs.modal', () => this.checkCateringAlreadyGenerated())
          }
        }

        modalGenerateMenus.init()
      }();
    });
  </script>