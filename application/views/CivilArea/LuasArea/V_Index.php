<style>
  .d-flex {
    display: flex;
  }

  .justify-content-between {
    justify-content: space-between;
  }

  .table-border-gray>thead>tr>th,
  .table-border-gray>thead>th,
  .table-border-gray>tbody>tr>td {
    border-color: #929292 !important;
  }

  .hover-gray:hover {
    background-color: #e8e8e8;
  }

  .border-none {
    border: none !important;
  }

  span.select2 {
    width: 100% !important;
  }

  table.table-hovered>tbody>tr:hover {
    background-color: antiquewhite !important;
  }

  /* OVERRIDE BOOTSTRAP CSS */
  .bg-warning {
    background-color: #ffe973;
  }

  tr.loading {
    background-image: linear-gradient(to right, transparent 50%, rgba(0, 0, 0, .05) 70%);
    background-size: 200% 100%;
    animation: loading 2s cubic-bezier(0.4, 0, 0.2, 1) infinite;
  }

  tr.loading td {
    opacity: .45;
    pointer-events: none;
  }

  @keyframes loading {
    0% {
      background-position: 0;
    }

    50% {
      background-position: -30%;
    }

    80% {
      background-position: -100%;
    }

    100% {
      background-position: -200%;
    }
  }

  /* .form-control {
    height: 25px !important;
    padding: 
  } */
</style>
<div class="container-fluid mt-4" id="civil_area_seksi_app">
  <div class="card">
    <div class="card-body">
      <div class="nav-tabs-custom" style="position: relative;">
        <div style="left: 0.5em;width: 500px;">
          <div class="row">
            <div class="col-md-6">
              <h1 class="m-0">LUAS AREA</h1>
            </div>
            <div class="col-md-6">
              <a class="btn btn-success" href="<?= base_url('/CivilLuasArea/api/excel') ?>">
                <i class="fa fa-file-excel-o"></i>
                Export Excel - All
              </a>
            </div>
          </div>
        </div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <?php foreach ($cost_center_category as $item) : ?>
            <li class="pull-right <?= $item['active'] ? 'active' : '' ?>">
              <a class="nav-link text-center" data-toggle="tab" href="#<?= $item['target'] ?>" role="tab">
                <?= $item['name'] ?>
              </a>
            </li>
          <?php endforeach ?>
        </ul>
        <div class="tab-content">
          <?php foreach ($cost_center_category as $cost_center_item) : ?>
            <div class="tab-pane <?= $cost_center_item['active'] ? 'active' : '' ?>" id="<?= $cost_center_item['target'] ?>" role="tabpanel">
              <div class="table-responsive">
                <div class="row">
                  <div class="col-md-4 mb-2">
                    <a class="btn btn-success" href="<?= base_url('CivilLuasArea/api/excel?code=' . $cost_center_item['head_code']) ?>">
                      <i class="fa fa-file-excel-o"></i>
                      Export Excel - <?= $cost_center_item['name'] ?>
                    </a>
                  </div>
                  <div class="col-md-4"></div>
                  <div class="col-md-4">
                    <input type="text" placeholder="Cari Cost Center" data-target="#<?= $cost_center_item['table_id'] ?>" class="form-control search-box">
                  </div>
                </div>
                <table id="<?= $cost_center_item['table_id'] ?>" class="table table-bordered table-border-gray">
                  <thead class="bg-primary">
                    <th class="text-center" width="5%"></th>
                    <th class="text-center" width="5%">No</th>
                    <th class="text-center" width="10%">Cost Center</th>
                    <th class="text-center">Description</th>
                    <th class="text-center" width="10%">Branch</th>
                    <th class="text-center" width="10%">Total Luas Area (m<sup>2</sup>)</th>
                  </thead>
                  <tbody>
                    <?php foreach ($cost_center_item['data'] as $i => $item) : ?>
                      <tr data-cost_center="<?= $item->ID ?>" class="tr-parent">
                        <td colspan="6" class="p-0">
                          <table class="table table-bordered table-hovered mb-0">
                            <tr class="click-inside-target">
                              <td width="5%" data-cost_center="<?= $item->COST_CENTER ?>" data-toggled="0" class="text-center hover-gray toggle-table-child" style="cursor: pointer;">
                                <img src="<?= base_url('assets/img/icon/details_open.png') ?>">
                              </td>
                              <td width="5%" class="text-center">
                                <?= $i + 1 ?>
                              </td>
                              <td width="10%" class="text-center">
                                <?= $item->COST_CENTER ?>
                              </td>
                              <td>
                                <?= $item->SECTION ?>
                              </td>
                              <td width="10%">
                                <?= $item->LOCATION ?>
                              </td>
                              <td width="10%" class="text-center luas_area <?= !isset($item->AREA) ? 'bg-warning' : '' ?>">
                                <?= isset($item->AREA) ? $item->AREA . "  m<sup>2</sup>" : '' ?>
                              </td>
                            </tr>
                          </table>
                          <div class="area-detail p-3 hidden">
                            <div class="row">
                              <div class="col-md-12">
                                <?php if ($is_admin) : ?>
                                  <button data-toggle="tooltip" title="Tambah Area Baru" data-placement="left" class="btn btn-success pull-right mb-2 area_detail__add">
                                    <i class="fa fa-plus"></i>
                                  </button>
                                <?php endif ?>
                              </div>
                              <div class="col-md-1"></div>
                              <div class="col-md-11">
                                <table class="table table-child table-bordered">
                                  <thead class="bg-info">
                                    <th class="text-center">No</th>
                                    <th class="text-center">Area</th>
                                    <th class="text-center">Lokasi</th>
                                    <th class="text-center">Gedung</th>
                                    <th class="text-center">Lantai</th>
                                    <th class="text-center" width="10%">Luas Area <br>(m<sup>2</sup>)</th>
                                    <th class="text-center">Last Update</th>
                                    <th class="text-center">Action</th>
                                  </thead>
                                  <tbody>
                                    <?php if (isset($item->DATA)) : ?>
                                      <?php foreach ($item->DATA as $x => $child) : ?>
                                        <tr data-id="<?= $child->luas_area_id ?>" data-default="">
                                          <td class="text-center"><?= $x + 1 ?></td>
                                          <td>
                                            <select class="form-control select2-tag" name="area" id="" disabled>
                                              <?php foreach ($area as $item) : ?>
                                                <option value="<?= $item->nama_area ?>" <?= $child->nama_area == $item->nama_area ? 'selected' : '' ?>><?= $item->nama_area ?></option>
                                              <?php endforeach ?>
                                            </select>
                                          </td>
                                          <td>
                                            <select name="lokasi" class="form-control select2-tag" id="" disabled>
                                              <?php foreach ($lokasi_option as $lokasi) : ?>
                                                <option value="<?= $lokasi ?>" <?= $child->lokasi == $lokasi ? 'selected' : '' ?>><?= $lokasi ?></option>
                                              <?php endforeach ?>
                                            </select>
                                          </td>
                                          <td>
                                            <input type="text" placeholder="Nama gedung" name="nama_gedung" value="<?= $child->nama_gedung ?>" class="form-control" disabled>
                                          </td>
                                          <td>
                                            <select class="form-control select2-tag" name="lantai" id="" disabled>
                                              <?php foreach ($floor as $item) : ?>
                                                <option value="<?= $item->nama_lantai ?>" <?= $child->lantai == $item->nama_lantai ? 'selected' : '' ?>><?= $item->nama_lantai ?></option>
                                              <?php endforeach ?>
                                            </select>
                                          </td>
                                          <td>
                                            <input type="number" min="1" name="luas_area" value="<?= $child->luas_area ?>" class="form-control" disabled>
                                          </td>
                                          <td class="timestamp" title="Oleh <?= $child->created_by . " - " . $child->created_by_name ?>">
                                            <?= $child->updated_at ?: $child->created_at ?>
                                          </td>
                                          <td>
                                            <?php if ($is_admin) : ?>
                                              <button data-toggle="tooltip" title="Edit" class="btn btn-sm text-success area_detail__edit">
                                                <i class="fa fa-pencil"></i>
                                              </button>
                                              <button data-toggle="tooltip" title="Hapus" class="btn btn-sm text-danger area_detail__remove">
                                                <i class="fa fa-trash"></i>
                                              </button>

                                              <button data-toggle="tooltip" title="Simpan" class="btn btn-sm btn-primary area_detail__save hidden">
                                                <i class="fa fa-save"></i>
                                              </button>
                                              <button data-toggle="tooltip" title="Batal" class="btn btn-sm area_detail__cancel hidden">
                                                <i class="fa fa-times"></i>
                                              </button>
                                            <?php endif ?>
                                          </td>
                                        </tr>
                                      <?php endforeach ?>
                                    <?php endif ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // App logic
  $(() => {
    if (!$('#civil_area_seksi_app').length) return;

    $('[data-toggle=tooltip]').tooltip();

    // toggle image
    const toggleImage = {
      active: baseurl + '/assets/img/icon/details_open.png',
      inactive: baseurl + '/assets/img/icon/details_close.png'
    }

    // DONE
    function showDisplay1() {
      const $tr = $(this).closest('tr')
      $tr.find('.area_detail__edit, .area_detail__remove').removeClass('hidden')
      $tr.find('.area_detail__save, .area_detail__cancel').addClass('hidden')

      // set to non editable
      $tr.find('input, select').prop('disabled', true)
      // set to value of backup
      const defaultValue = $tr.attr('data-default');
      console.log(defaultValue);

      if (!defaultValue) return;

      const jsonDefault = (defaultValue instanceof Array) ? defaultValue : JSON.parse(defaultValue)
      console.log(jsonDefault);
      if (jsonDefault instanceof Array) {
        jsonDefault.forEach((item, i) => {
          $tr.find(`${item.tag}[name=${item.name}]`).val(item.value).trigger('change')
        })
      }
    }

    // DONE
    function showDisplay2() {
      const $tr = $(this).closest('tr')
      $tr.find('.area_detail__edit, .area_detail__remove').addClass('hidden')
      $tr.find('.area_detail__save, .area_detail__cancel').removeClass('hidden')

      // :TODO
      // set to editable
      $tr.find('input, select').prop('disabled', false)

      // make an backup of data
      let defaultValue = [];
      $tr.find('input, select').each(function(e, elem) {
        defaultValue.push({
          tag: $(this).prop('tagName'), // html tag
          name: $(this).attr('name'),
          value: $(this).val()
        })
      })

      const jsonOfDefault = JSON.stringify(defaultValue);
      $tr.attr('data-default', jsonOfDefault)
    }

    // DONE
    function removeRow() {
      const $tr = $(this).closest('tr');
      const $tbody = $tr.closest('tbody')
      const cost_center = $tr.closest('tr.tr-parent').data('cost_center')
      const id = $tr.attr('data-id')

      // to rearrange table row
      function rearrange_row() {
        $tbody.find('tr').each(function(index) {
          $(this).find('td').eq(0).text(index + 1)
        })
      }

      Swal.fire({
        title: "Apakah anda yakin untuk menghapus area ini ?",
        text: '',
        type: 'question',
        showCancelButton: true
      }).then(({
        value
      }) => {
        if (!value) return;

        // if id is not empty
        if (id) {
          // ajax
          $.ajax({
            method: 'POST',
            url: baseurl + '/CivilLuasArea/api/area/remove',
            data: {
              id
            },
            beforeSend() {
              $tr.addClass('loading')
            },
            success() {
              // nothing
              $tr.remove();
              rearrange_row()
              calcCostCenterArea(cost_center)
            },
            error(e) {
              alert("Gagal menghapus area: " + JSON.stringify(e))
            },
            complete() {
              $tr.removeClass('loading')
            }
          })
        } else {
          $tr.remove()
          rearrange_row()
          calcCostCenterArea(cost_center)
        }
      })
    }

    // DONE
    function saveArea() {
      const $tr = $(this).closest('tr');
      const $tbody = $tr.parents('tbody');
      const cost_center = $tr.parents('tr.tr-parent').data('cost_center');
      const id = $tr.data('id');

      const data = {
        cost_center,
        area: $tr.find('select[name=area]').val(),
        lokasi: $tr.find('select[name=lokasi]').val(),
        gedung: $tr.find('input[name=nama_gedung]').val(),
        lantai: $tr.find('select[name=lantai]').val(),
        luas_area: $tr.find('input[name=luas_area]').val()
      }

      // add validation
      // :TODO

      // if not has id
      if (!id) {
        // INSERT
        Swal.fire({
          title: "Apakah anda yakin untuk menyimpan area ini ?",
          text: '',
          type: 'question',
          showCancelButton: true
        }).then(({
          value
        }) => {
          if (!value) return;

          $.ajax({
            method: 'POST',
            url: baseurl + '/CivilLuasArea/api/area/add',
            data,
            beforeSend() {
              $tr.addClass('loading')
            },
            success({
              code,
              message,
              data
            }) {
              const {
                id,
                created_by,
                created_by_name,
                created_at
              } = data
              // set id
              $tr.attr('data-id', id);
              const timestampTd = $tr.find('td.timestamp')
              timestampTd.text(created_at)
              timestampTd.attr('title', `Oleh ${created_by} - ${created_by_name}`)

              // set last update and who
              $tr.find('button.area_detail__cancel').click();
              calcCostCenterArea(cost_center)

            },
            error() {
              alert("Error");
            },
            complete() {
              $tr.removeClass('loading')
            }
          })
        })
      } else {
        // UPDATE
        Swal.fire({
          title: "Apakah anda yakin untuk mengupdate area ini ?",
          text: '',
          type: 'question',
          showCancelButton: true
        }).then(({
          value
        }) => {
          $.ajax({
            method: 'POST',
            url: baseurl + '/CivilLuasArea/api/area/update',
            data: Object.assign(data, {
              id
            }),
            beforeSend() {
              $tr.addClass('loading')
            },
            success({
              code,
              message,
              data
            }) {
              const {
                updated_by,
                updated_by_name,
                updated_at
              } = data

              // set last update and who
              const timestampTd = $tr.find('td.timestamp')
              timestampTd.text(updated_at)
              timestampTd.attr('title', `Oleh ${updated_by} - ${updated_by_name}`)
              // remove default json
              $tr.attr('data-default', '')
              $tr.find('button.area_detail__cancel').click();
              calcCostCenterArea(cost_center)
            },
            error() {
              alert("Error");
            },
            complete() {
              $tr.removeClass('loading')
            }
          })
        })
      }
    }

    // Calculate area of cost center after save / update / delete
    // DONE
    function calcCostCenterArea(cost_center) {
      const $parentRow = $(`table tr[data-cost_center=${cost_center}]`);
      const $childTable = $parentRow.find('table.table-child')

      let luas_area = 0;
      $childTable.find('input[name=luas_area]').each(function() {
        luas_area += Number($(this).val())
      });

      // add animation updated
      $parentRow.find('td.luas_area').html(luas_area + ' m<sup>2</sup>')

      // remove bg-warning when area is > 0
      if (luas_area > 0) {
        $parentRow.find('td.luas_area').removeClass('bg-warning')
      } else {
        $parentRow.find('td.luas_area').addClass('bg-warning')
        $parentRow.find('td.luas_area').html('')
      }
    }

    /**
     * Handle select2 tags when on selected
     */
    function handleTagSelected() {
      const eventType = $(this).attr('name')
      const value = $(this).val()

      let endpoint = '';

      switch (eventType) {
        case 'area':
          endpoint = baseurl + '/CivilLuasArea/api/master/area';
          break;
        case 'lokasi':
          endpoint = baseurl + '/CivilLuasArea/api/master/lokasi';
          break;
        case 'lantai':
          endpoint = baseurl + '/CivilLuasArea/api/master/lantai';
          break;
        default:
          // this will stop this function
          return;
      }

      $.ajax({
        url: endpoint,
        method: 'POST',
        data: {
          value
        },
        success() {
          console.log(`Success add new ${eventType} with ${value}`);
        },
        error() {
          console.error(`Error add new ${eventType} with ${value}`);
        },
        complete() {
          // nothing, this will work in future
        }
      })
    }

    // toggle button
    // DONE
    $('td.toggle-table-child').click(function(e) {
      e.stopPropagation()
      const $this = $(this)
      const $trParent = $this.parents('tr.tr-parent')
      // toggle img
      const isToggled = $this.data('toggled');

      // add next
      const $row = $this.closest('tr.tr-parent')
      const cost_center = $this.data('cost_center')

      // if toggled then hide
      if (isToggled > 0) {
        $row.find(`.area-detail`).addClass('hidden')
        $this.data('toggled', 0);
        $this.find('img').attr('src', toggleImage.active)
      } else {
        $row.find(`.area-detail`).removeClass('hidden')
        $this.data('toggled', 1);
        $this.find('img').attr('src', toggleImage.inactive)
      }

      // initialize select2 where that element is not yet initialized
      // to improve perfomance :)
      $trParent.find("select.select2-tag").each(function() {
        if (!$(this).hasClass('select2-hidden-accessible')) {
          $(this).select2({
            tags: true
          });
          $(this).on('select2:select', handleTagSelected);
        }
      })

    })

    // alternative when row is clicked then click td.toggle-table-child
    $('tr.click-inside-target').click(function(e) {
      $(this).find('td.toggle-table-child').click();
    })

    // button to add new row
    // DONE
    $('.area-detail').on('click', 'button.area_detail__add', function() {
      const $parent = $(this).closest('.area-detail')
      const $childTable = $parent.find('table')

      // add new row
      const template = ({
        no
      }) => `
        <tr data-id="" data-default="">
          <td class="text-center">${no}</td>
          <td>
            <select class="form-control select2-tag" name="area" id="">
              <?php foreach ($area as $item) : ?>
                <option value="<?= $item->nama_area ?>"><?= $item->nama_area ?></option>
              <?php endforeach ?>
            </select>
          </td>
          <td>
            <select name="lokasi" class="form-control select2-tag" id="">
              <?php foreach ($lokasi_option as $lokasi) : ?>
                <option value="<?= $lokasi ?>"><?= $lokasi ?></option>
              <?php endforeach ?>
            </select>
          </td>
          <td>
            <input type="text" placeholder="Nama gedung" name="nama_gedung" value="" class="form-control" >
          </td>
          <td>
            <select class="form-control select2-tag" name="lantai" id="">
              <?php foreach ($floor as $item) : ?>
                <option value="<?= $item->nama_lantai ?>"><?= $item->nama_lantai ?></option>
              <?php endforeach ?>
            </select>
          </td>
          <td>
            <input type="number" min="1" name="luas_area" value="0" class="form-control">
          </td>
          <td title="" class="timestamp"></td>
          <td>
            <button data-toggle="tooltip" title="Edit" class="btn btn-sm text-success area_detail__edit hidden">
              <i class="fa fa-pencil"></i>
            </button>
            <button data-toggle="tooltip" title="Simpan" class="btn btn-sm btn-primary area_detail__save">
              <i class="fa fa-save"></i>
            </button>
            <button data-toggle="tooltip" title="Hapus" class="btn btn-sm text-danger area_detail__remove">
              <i class="fa fa-trash"></i>
            </button>
            <button data-toggle="tooltip" title="Batal" class="btn btn-sm area_detail__cancel hidden">
              <i class="fa fa-times"></i>
            </button>
          </td>
        </tr>
      `;

      const lastRow = $childTable.find('tbody > tr').length + 1;
      // append to last row
      $appendedElement = $childTable.find('tbody').append(template({
        no: lastRow
      }))

      // initialize select2 to new DOM
      $select2_tagElements = $appendedElement.find('tr').last().find("select.select2-tag")
      $select2_tagElements.select2({
        tags: true
      });
      $select2_tagElements.on('select2:select', handleTagSelected);
    })

    // button inside column
    $('table.table-child').on('click', 'button.area_detail__edit', showDisplay2);
    $('table.table-child').on('click', 'button.area_detail__cancel', showDisplay1);
    $('table.table-child').on('click', 'button.area_detail__save', saveArea);
    $('table.table-child').on('click', 'button.area_detail__remove', removeRow);

    // $('table#table-non-produksi').DataTable();
  })

  // Utility
  $(() => {
    $('.search-box').on('input', function() {
      const $target = $($(this).data('target'));
      const value = $(this).val().toLowerCase();

      $target.find('tbody > tr.tr-parent').each(function() {
        const $row = $(this)
        let match = false;

        $(this).find('td').each(function() {
          if (match) return;

          const text = $(this).text()
          const containValue = text.match(new RegExp(value, 'ig')) !== null;

          if (containValue) {
            match = true;
            $row.show()
          } else {
            $row.hide()
          }
        })
      })
    })
  })
</script>