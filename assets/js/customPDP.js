$(document).ready(function() {

        var checkAll = $('input#checkall');
        var checkboxes = $('input.check');

        checkAll.on('ifChecked ifUnchecked', function(event) {
            if (event.type == 'ifChecked') {
                checkboxes.iCheck('check');
            } else {
                checkboxes.iCheck('uncheck');
            }
        });


        $('#modalNoInduk').select2({
            placeholder: 'noind',
            minimumInputLength: 2,
            ajax: {
                type: 'GET',
                url: baseurl + 'PengirimanDokumen/ajax/noind',
                dataType: 'json',
                data: (params) => {
                    return {
                        params: params.term
                    }
                },
                processResults: data => {
                    if (data.length == 1) {
                        $('#modalNameWorker').val(data[0].nama)
                        $('#modalSeksi').val(data[0].seksi)
                    } else {
                        $('#modalNameWorker').val('')
                        $('#modalSeksi').val('')
                    }
                    return {
                        results: $.map(data, item => {
                            return {
                                id: item.noind,
                                // text: item.noind+" - "+item.nama
                                text: item.noind
                            }
                        })
                    }
                }
            }
        })

        //View Master

        $('#modalNoInduk').on('change', function() {
            let noind = $(this).val()

            if (noind == null) return
            $.ajax({
                type: 'GET',
                url: baseurl + 'PengirimanDokumen/ajax/noind',
                dataType: 'json',
                data: {
                    params: noind
                },
                success: data => {
                    $('#modalNameWorker').val(data[0].nama)
                    $('#modalSeksi').val(data[0].seksi)
                }
            })
        })

        $('#modalLevelOne, #modalLevelTwo').select2({
            width: '100%',
        })

        // view input
        $('#modalInputInformation').select2({
                width: '100%',
                placeholder: 'jenis keterangan'
            }

        )
        $('#modalDate').datepicker({
            todayHighlight: true,
            format: 'yyyy/mm/dd',
        })

        //  view rekap semua dokumen
        $('.RekapAll').dataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excelHtml5',
                    exportOptions: { orthogonal: 'export' },
                    title: 'Rekap Dokumen'
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: { orthogonal: 'export' },
                    download: 'open',
                    pageSize: 'A4',
                    orientation: 'portrait',
                    title: 'Rekap Dokumen'
                }
            ]
        })

        $('.dt-buttons button.buttons-excel').removeClass('btn-default').addClass('btn-success')
        $('.dt-buttons button.buttons-excel span').html('<i class="fa fa-file-excel-o"></i> Excel')
        $('.dt-buttons button.buttons-pdf').removeClass('btn-default').addClass('btn-danger')
        $('.dt-buttons button.buttons-pdf span').html('<i class="fa fa-file-pdf-o"></i> PDF')

        $('#periode').daterangepicker({
            locale: {
                format: 'YYYY/MM/DD'
            }
        })

    })
    //end ready

const deleteMaster = id => {

    swal.fire({
        title: "Apakah anda yakin",
        text: "Menghapus Data ini ?",
        type: "warning",
        showCancelButton: true
    }).then(val => {
        if (val.value) {
            $.ajax({
                method: 'POST',
                data: {
                    id: id
                },
                url: baseurl + 'PengirimanDokumen/ajax/deleteMaster',
                success: res => {
                    if (res == 'ok') {
                        swal.fire('Data telah dihapus', '', 'success')
                        loadTable()
                    } else {
                        swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Data tidak boleh dihapus!',
                            footer: `<small>terdapat data input yang telah menggunakan master ini</small>`
                        })
                    }
                }
            })
        } else {
            return
        }
    })
}

const showSuccessAlert = () => {
    swal.fire('Sukses Menambahkan data', '', 'success')
}

const showSweetAlert = mess => {
    swal.fire(mess)
}