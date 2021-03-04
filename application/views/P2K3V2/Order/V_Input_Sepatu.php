<style>
  .select2 {
    width: 100% !important;
  }

  div {
    transition: 1s;
  }
</style>
<section class="content">
  <div class="inner">
    <div class="col-lg-12">
      <div class="text-left">
        <h1>
          <b>Input Bon Sepatu</b>
          <!-- <span style="width: 50px; height: 50px; background-color: #fff; border-radius: 8px;">
                  <svg style="width: 30px;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="boot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-boot fa-w-16 fa-3x">
                    <path fill="currentColor" d="M0 480l32 32h64l32-32 32 32h64l32-32 32 32h64l32-32 32 32h64l32-32v-32H0v32zM352 80V16c0-8.8-7.2-16-16-16H16C7.2 0 0 7.2 0 16v80h336c8.8 0 16-7.2 16-16zm87.3 205.8L320 256h-56c-4.4 0-8-3.6-8-8v-16c0-4.4 3.6-8 8-8h56v-32h-56c-4.4 0-8-3.6-8-8v-16c0-4.4 3.6-8 8-8h56v-32H0v288h512v-37c0-44.1-30-82.5-72.7-93.2z" class=""></path>
                  </svg>
                </span> -->
        </h1>
      </div>
    </div>
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border"></div>
        <div class="box-body">
          <div class="panel-body" style="overflow-x: scroll;">
            <div class="col-md-12" id="app_screen">
              <div class="row">
                <div class="col-md-6">
                  <h4>
                    Input Order
                  </h4>
                </div>
                <div class="col-md-6 text-right">
                  <button class="btn btn-primary" id="see-stock" data-toggle="modal" data-target="#modal-stock-sepatu"><i class="fa fa-eye"></i> Lihat Stok</button>
                  <button type="button" class="btn btn-success add-row"><i class="fa fa-plus"></i> Tambah</button>
                </div>
                <form>
                  <div class="col-md-12">
                    <!-- <div class="table-responsive"> -->
                    <table id="table-shoes" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr class="bg-primary">
                          <td class="text-center">No</td>
                          <td class="text-center" width="30%">Nama APD</td>
                          <td class="text-center">Kode Barang</td>
                          <td class="text-center" width="30%">Nama / No Induk</td>
                          <td class="text-center" width="30%">Alasan</td>
                          <td class="text-center">Tanggal Terakhir Bon</td>
                          <td class="text-center">Jumlah</td>
                          <td class="text-center">Action</td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr valid="0" class="item">
                          <td class="text-center">1</td>
                          <td>
                            <select required="required" name="shoes_code" data-placeholder="Pilih sepatu - ukuran" class="form-control select-shoes select2">
                              <option></option>
                              <?php foreach ($safetyShoes as $item) : ?>
                                <option <?= $item['STOCK'] <= 0 ? 'disabled' : '' ?> value="<?= $item['ITEM_CODE'] ?>"><?= $item['ITEM_CODE'] . " - " . $item['DESCRIPTION'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                          <td class="text-center apd_code"></td>
                          <td class="pekerja">
                            <select name="worker_code" name="" id="" required class="form-control select-pekerja">
                              <option value=""></option>
                            </select>
                          </td>
                          <td>
                            <textarea maxlength="30" name="reason" style="resize: vertical;max-height: 100px; min-height: 34px; height: 34px;" class="form-control reason" id="" placeholder="Alasan" required></textarea>
                          </td>
                          <td class="text-center latest_bon"></td>
                          <td class="text-center">1</td>
                          <td class="text-center">
                            <button class="btn btn-sm btn-danger delete">
                              <i class="fa fa-trash"></i>
                            </button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-12">
                    <label>Seksi Pemakai</label>
                  </div>
                  <div class="col-md-12">
                    <select class="form-control apd_slccostc" name="cost_center" placeholder="Pilih Seksi Pemakai" id="apd_seksi_pemakai_ss">
                      <option></option>
                      <?php foreach ($listcc as $key): ?>
                        <option <?= ($key['COST_CENTER']==$costc) ? 'selected':''; ?> value="<?= $key['COST_CENTER']; ?>">
                          <?= $key['COST_CENTER'].' - '.$key['PEMAKAI']; ?>
                        </option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <div class="col-md-12">
                    <hr>
                    <div style="display: flex; justify-content: space-between;">
                      <div class="text-left">
                        <button type="button" id="reset" class="btn btn-default">Reset</button>
                      </div>
                      <div class="text-right">
                        <button class="btn btn-primary" id="submit_bon" disabled>Simpan bon</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-md-12 hidden" id="app_loading_screen">
              <!-- // app loading when submit pressed  -->
              <div style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <img style="height: 200px; width: auto;" src="<?= base_url('assets/img/gif/loadingquick.gif') ?>" alt="Loading ..." srcset="">
                <h2>Sedang menyimpan bon ...</h2>
              </div>
            </div>
            <div class="col-md-12 hidden" id="app_result_screen" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
              <!-- app result -->
              <div style="display: flex;
                          width: 40%;
                          border-radius: 10px; 
                          box-shadow: 5px 5px 10px 5px #e8e8e8; 
                          flex-direction: column; 
                          justify-content: center; 
                          align-items: center; 
                          padding: 2em;">
                <img style="height: 150px; width: auto;" src="<?= base_url('assets/img/icon/success.png') ?>" alt="Loading ..." srcset="">
                <h2>Sukses menyimpan bon</h2>
                <p>Tunggu <span class="counter">5</span> detik untuk <b>mencetak Bon</b></p>
                <p>atau</p>
                <a target="_blank" id="pdf_button" href="#">Klik disini</a>
                <a href="<?= base_url('P2K3_V2/Order/MonitoringBon') ?>" style="margin-top: 2em;" class="btn btn-success">Lihat Monitoring Bon</a>
                <a href="<?= base_url('P2K3_V2/Order/SafetyShoes') ?>" id="back" style="margin-top: 0.2em;" class="">Kembali</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ---- MODAL ---- -->
<div class="modal" id="modal-stock-sepatu">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 1em;">
      <style>
        .modal-body thead th {
          position: sticky;
          top: 0;
          color: #fff;
          background-color: #337ab7;
        }
      </style>
      <div class="modal-header">
        <h2>Stok Sepatu - Gudang <?= $gudang ?></h2>
      </div>
      <div class="modal-body text-center"></div>
      <div class="modal-footer"></div>
    </div>
  </div>
</div>
<!-- ---- END MODAL ---- -->

<!-- <script src="<?= base_url('assets/plugins/vue/vue@2.6.11.dev.js') ?>"></script> -->
<script>
  //   let x = new Vue({
  //     el: '#app',
  //     data() {
  //       return {
  //         jumlah: new Array(5).fill('d')
  //       }
  //     }
  //   })
  // better use js framework like vue :), but i just follow the line
</script>
<script>
  // button action script
  $(() => {
    // tombol lihat stock
    $('#see-stock').click(function() {
      $.ajax({
        url: baseurl + 'P2K3_V2/Order/CheckStockSafetyShoes',
        method: 'GET',
        dataType: 'json',
        beforeSend() {
          $('#modal-stock-sepatu .modal-body').html('<span><i class="fa fa-spinner fa-spin"></i> memuat data</span>')
        },
        success(response) {
          if (response.error) throw "err"
          let HTMLStockTable = `
              <table class="table table-bordered table-striped">
                <thead class="bg-primary">
                  <th class="text-center">No</th>
                  <th class="text-center">Kode Item</th>
                  <th class="text-center">Nama Item</th>
                  <th class="text-center">Stok</th>
                </thead>
                <tbody>
                  ${
                    response.data.map((item, i) => {
                      return `
                        <tr>
                          <td class="text-center">${i+1}</td>
                          <td>${item.ITEM_CODE}</td>
                          <td>${item.DESCRIPTION}</td>
                          <td class="text-center text-${item.STOCK == 0 ? '' : 'bold'}">${item.STOCK}</td>
                        </tr>
                      `
                    }).join('')
                  }
                </tbody>
              </table>
            `
          $('#modal-stock-sepatu .modal-body').html(HTMLStockTable)
        },
        error(e) {
          $('#modal-stock-sepatu .modal-body').html('<span>Error mengambil data sepatu</span>')
        }
      })
    })

    // tombol submit / simpan bon
    $('#submit_bon').click(function(e) {
      e.preventDefault()

      sweet_alert('Yakin untuk melakukan bon sepatu ?', '', 'question', true, e => {
        if (!e.value) return
        let data = (function() {
          let data = []
          $('#table-shoes tbody > tr').each(function() {
            let apd = $(this).find('.select-shoes').val()
            let noind = $(this).find('.select-pekerja').val()
            let reason = $(this).find('.reason').val()
            let cost_center = $('#apd_seksi_pemakai_ss').val();
            data.push({
              item_code: apd,
              noind,
              reason,
              cost_center: cost_center
            })
          })
          return data
        })()

        let valid = checkValid()
        if (!valid) return Swal.fire('Pastikan semua data terisi', 'isi data dengan lengkap', 'warning')

        $.ajax({
          url: baseurl + 'P2K3_V2/Order/BonSafetyShoes',
          method: 'POST',
          dataType: 'json',
          data: {
            data
          },
          beforeSend() {
            switch_screen('#app_loading_screen')
          },
          success(res) {
            if (res.error) {
              return sweet_alert(res.message, '', 'error', false, () => switch_screen('#app_screen'))
            }
            switch_screen('#app_result_screen')
            var count = 5
            var counter = setInterval(() => {
              $('.counter').text(count--)
              if (count < 0) clearInterval(counter)
            }, 1000)
            var timeout = setTimeout(() => window.open(pdf_url), 5200)

            let pdf_url = baseurl + 'P2K3_V2/Order/PDFSafetyShoes/' + res.no_bon
            $('#pdf_button').click(e => clearTimeout(timeout))
            $('#pdf_button').attr('href', pdf_url)
          },
          error(e) {
            return Swal.fire(e, '', 'error')
          },
          complete() {
            console.log("log: Proses simpan bon telah selesai")
          }
        })
      })
    })

    // tombol menambahkan row
    $('.add-row').click(function() {
      let row = $('#table-shoes > tbody > tr.item').last().clone()
      $('#table-shoes > tbody').append(row)
      let last_shoes = $('#table-shoes > tbody > tr .select-shoes').last()
      let last_pekerja = $('#table-shoes > tbody > tr .select-pekerja').last()
      let last_kode = $('#table-shoes > tbody > tr .apd_code').last()
      let last_bon = $('#table-shoes > tbody > tr .latest_bon').last()
      let last_pekerja_column = $('#table-shoes > tbody > tr > td.pekerja').last()
      let last_reason = $('#table-shoes > tbody > tr > td > .reason').last()

      last_kode.text('')
      last_bon.text('')
      last_shoes.next().remove()
      last_pekerja.next().remove()
      last_shoes.select2()
      last_pekerja.select2()
      last_shoes.closest('tr').find('td').first().text($('#table-shoes > tbody > tr').length)
      last_pekerja_column.css({
        backgroundColor: '',
        color: ''
      })
      last_pekerja_column.find('p').remove()
      last_pekerja_column.attr('valid', 0)
      last_reason.val('')
      refreshPlugin()
      clearNonChar()
    })

    $('#reset').click(function(e) {
      e.preventDefault()
      $('#table-shoes > tbody > tr').not($('#table-shoes > tbody > tr').first()).remove()
      $('#table-shoes > tbody > tr').attr('valid', 0)
      $('.select-shoes').val('').trigger('change')
      $('.select-pekerja').val('').trigger('change')
      $('.pekerja > p').first().remove()
      $('.pekerja').first().css({
        backgroundColor: ''
      })
      $('.latest_bon').first().text('')
      $('.reason').first().val('')
      $('#submit_bon').prop('disabled', true)
    })

    $('#back').click(function(e) {
      e.preventDefault()
      $('#reset').trigger('click')
      switch_screen('#app_screen')
    })

    clearNonChar()

    setTimeout(() => {
      refreshPlugin()
    }, 500)
  })
</script>
<script>
  // switch app, loading, result screen
  const switch_screen = (screen) => {
    const id_screen = ['#app_screen', '#app_loading_screen', '#app_result_screen']
    id_screen.map(item => {
      if (item == screen) {
        $(item).removeClass('hidden')
      } else {
        $(item).addClass('hidden')
      }
    })
  }

  // cek form sudah valid belum / tidak ada error
  const checkValid = () => {
    console.log("function check valid: running .........");

    let invalid = []
    $('#table-shoes > tbody > tr.item').each(function() {
      if ($(this).attr('valid') == 0) {
        invalid.push(false)
      }
    });


    // disable or enable submit button
    $('#submit_bon').prop('disabled', invalid.length)
    let cost_center = $('#apd_seksi_pemakai_ss').val();
    if(cost_center == '') return false;
    return (invalid.length == 0)
  }

  // element adalah tr element
  function checkBon(element) {
    const sepatu = $(element).closest('tr').find('.select-shoes')
    const noind = $(element).closest('tr').find('.select-pekerja')
    const pekerjaColumn = $(element).closest('tr').find('.pekerja')

    if (!sepatu.val() || !noind.val()) return

    // show animation
    const latest_bon = $(element).closest('tr').find('.latest_bon')

    latest_bon.html('<span><i class="fa fa-spinner fa-spin"></i> memuat data</span>')

    $.ajax({
      url: baseurl + 'P2K3_V2/Order/CheckBonSafetyShoes',
      method: 'get',
      dataType: 'json',
      data: {
        sepatu: sepatu.val(),
        noind: noind.val()
      },
      beforeSend() {
        pekerjaColumn.find('p').remove()
      },
      success(response) {
        if (response.error) {
          pekerjaColumn.css({
            backgroundColor: 'rgb(255, 230, 230)',
            color: 'red'
          })
          pekerjaColumn.append(`<p class="text-center"><b><i class="fa fa-lg fa-info-circle"></i> Peringatan : </b>${response.message}</p>`)
          $(element).closest('tr').attr('valid', 0)
        } else {
          pekerjaColumn.css({
            backgroundColor: '',
            color: ''
          })
          $(element).closest('tr').attr('valid', 1)
        }
        latest_bon.html(`<span>${response.data.bon_terakhir}</span>`)
      },
      error() {
        latest_bon.html(`<span style="color: red;">Gagal mendapatkan data</span>, cek koneksi dan ulangi lagi`)
      },
      complete() {
        checkValid()
      }
    })
  }

  // untuk menginisialisasi select2 dan dll ke element baru(tr paling bawah)
  const refreshPlugin = () => {
    $('.select-pekerja').last().select2({
      minimumInputLength: 2,
      placeholder: "Pekerja",
      allowClear: true,
      ajax: {
        url: baseurl + "P2K3_V2/Order/Pekerja",
        dataType: "json",
        type: "get",
        data: e => {
          let select = $('tbody > tr .select-pekerja')
          let selectedWorker = []
          select.each(function() {
            selectedWorker.push($(this).val())
          })
          return {
            q: e.term,
            withOutWorker: selectedWorker.filter(String)
          }
        },
        processResults(data) {
          return {
            results: data.map(item => ({
              id: item.noind,
              text: `${item.noind} - ${item.nama}`
            }))
          };
        },
        cache: true,
      },
    })
    $('.select-shoes').last().select2({
      placeholder: "Nama Sepatu"
    })
    $('.select-shoes').last().on('change', function() {
      const code = $(this).val()
      $(this).closest('tr').find('.apd_code').text(code)
      checkBon(this)
    })
    $('.select-pekerja').last().on('change', function() {
      checkBon(this)
    })
    $('.delete').last().click(function(e) {
      e.preventDefault()
      if ($('#table-shoes > tbody > tr.item').length == 1) return
      $(this).closest('tr').remove()

      let i = 1
      $('#table-shoes > tbody > tr').each(function() {
        $(this).find('td').first().text(i++)
      })
    })
  }

  // hilangi char yg bukan word
  const clearNonChar = () => {
    $('textarea').keydown(function(e) {
      if (!!e.key.match(/[^a-zA-Z0-9, ]/g)) e.preventDefault()
    })
  }

  // sweet alert2 function
  const sweet_alert = (title, text, type, cancelButton, callback = function() {}) => {
    Swal.fire({
      title,
      text,
      type,
      showCancelButton: cancelButton
    }).then(callback)
  }
</script>