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
                                <div class="col-md-12">
                                    <h4 style="font-weight: bold;">
                                        Input Order
                                    </h4>
                                </div>
                                <hr>
                                <div class="col-md-6">
                                    <div class="col-md-3" style="padding-left: 0px;">
                                        <label style="margin-top: 5px;">Nomor Bon</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input placeholder="Masukan Nomor Bon" class="form-control" type="text" id="apd_inpnobon"></input>
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-primary" id="apd_btnceknoBon">
                                            Cek
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button class="btn btn-primary" id="see-stock" data-toggle="modal" data-target="#modal-stock-sepatu"><i class="fa fa-eye"></i> Lihat Stok</button>
                                </div>
                                <div class="col-md-12" id="apd_tblshoesm" style="margin-top: 10px;">
                                    <table id="apd_table-shoes" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr class="bg-primary">
                                                <td class="text-center">No</td>
                                                <td class="text-center" width="30%">Nama APD</td>
                                                <td class="text-center">Kode Barang</td>
                                                <td class="text-center" width="30%">Nama / No Induk</td>
                                                <td class="text-center" width="30%">Alasan</td>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                    <div style="display: flex; justify-content: space-between;">
                                        <div class="text-left">
                                            <button type="button" id="reset" class="btn btn-default" onClick="window.location.reload();">Reset</button>
                                        </div>
                                        <div class="text-right">
                                            <button class="btn btn-primary" id="apd_submit_bonM" disabled>Simpan bon</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 hidden" id="app_loading_screen">
                            <div style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                <img style="height: 200px; width: auto;" src="<?= base_url('assets/img/gif/loadingquick.gif') ?>" alt="Loading ..." srcset="">
                                <h2>Sedang menyimpan bon ...</h2>
                            </div>
                        </div>
                        <div class="col-md-12 hidden" id="app_result_screen" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
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
<div id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;" hidden="hidden">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
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
<script>
  $(() => {
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
                        data.push({
                            item_code: apd,
                            noind,
                            reason
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
    })

    // disable or enable submit button
    $('#submit_bon').prop('disabled', invalid.length)
        return (invalid.length == 0)
    }

    // element adalah tr element
    function checkBon(element) {
        const sepatu = $(element).closest('tr').find('.select-shoes')
        const noind = $(element).closest('tr').find('.select-pekerja')
        const pekerjaColumn = $(element).closest('tr').find('.pekerja')

        if (!sepatu.val() || !noind.val()) return

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