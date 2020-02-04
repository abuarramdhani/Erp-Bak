$( _ => {

    /* 
    | Global Function
    */
    const datePSPT = new Date()

    const datePSPTDay = String(datePSPT.getDate()).padStart(2, '0')

    const datePSPTMonth = String(datePSPT.getMonth() + 1).padStart(2, '0')

    const datePSPTYear = datePSPT.getFullYear()

    const swalPSPTToastrAlert = ( type, message ) => {
        Swal.mixin({
            toast             : true,
            position          : 'top-end',
            showConfirmButton : false,
            timer             : 3000
        }).fire({
            customClass : 'swal-font-small',
            type        : type,
            title       : message
        })
    }

    const swalPSPTAjaxConfirmation = ( type, text, url, data, success, fail, isFormData = 'no' ) => {
        return new Promise ( (response) => {
            Swal.fire({
                customClass       : 'swal-font-small',
                type              : type,
                html              : text,
                confirmButtonText : 'Ya',
                cancelButtonText  : 'Tidak',
                cancelButtonColor : '#d33',
                showCancelButton  : true
            }).then( (result) => {
                if ( result.value ) {
                    $.ajax({
                        beforeSend : _ => {        
                            Swal.fire({
                                customClass       : 'swal-font-small',
                                title             : 'Mohon menunggu',
                                text              : 'Sedang memproses ...',
                                onBeforeOpen      : _ => {
                                    Swal.showLoading()
                                },
                                allowOutsideClick : false
                            })
                        },
                        contentType: ( _ => {
                            if ( isFormData === 'yes' )
                                return false
                        }) (),
                        processData: ( _ => {
                            if ( isFormData === 'yes' )
                                return false
                        }) (),
                        type     : 'post',
                        url      : url,
                        data     : data,
                        dataType : 'json'
                    }).done( (resp) => {
                        swalPSPTToastrAlert('success', success)
                        response({
                            message : 'success',
                            data    : resp
                        })
                    }).fail ( (resp) => {
                        swalPSPTToastrAlert('error', fail)
                        response({
                            message : 'fail',
                            data    : resp.responseJSON
                        })
                    })
                } else {
                    response({
                        message : 'cancelled'
                    })
                }
            })
        })
    }

    const tooltipPSPTValidation = ( selector, message ) => {
        $(selector).attr({
            title            : `<i class="fa fa-remove"></i> ${message}`,
            'data-html'      : 'true',
            'data-placement' : 'bottom'
        }).tooltip({
            template : `<div class="tooltip" role="tooltip">
                            <div class="tooltip-arrow"></div>
                            <div class="tooltip-inner bg-red"></div>
                        </div>`,
            trigger  : 'manual'
        }).tooltip('show')
    }

    const tooltipPSPTDestroy = ( selector ) => {
        return new Promise( (response) => {
            $(selector).removeAttr('title data-html data-placement').tooltip('destroy')
            setTimeout( _ => {
                response(true)
            }, 250)
        })
    }

    $('[data-toggle="tooltipPSPT"]').tooltip()

    $('.spnPSPTDate').html(`${datePSPTDay}/${datePSPTMonth}/${datePSPTYear}`)


    /*
    | Register Page
    */
    const checkPSPTEmptyField = ( form, target ) => {
        $(form).find(target).each( function () {
            $(this).val() === '' || $(this).val() === null ?
                $(this).parents('.form-group').addClass('has-error') :
                $(this).parents('.form-group').removeClass('has-error').addClass('has-success')
        })
    }

    const setPSPTRegisterFieldValue = ( type = null, name = null, workerStats = null, section = null, trn = null ) => {
        $('#txtPSPTWorkerName').val(name)
        $('#txtPSPTWorkerStats').val(workerStats)
        $('#txtPSPTSection').val(section)
        $('#txtPSPTTRN').val(trn)
        if ( type === 'refresh' ) {
            $('#txtPSPTIdentityNumber').val(null)
            $('#slcPSPTWorkLocation').val(null).trigger('change')
            $('.has-error, .has-success').removeClass('has-error has-success')
        }
    }

    $('#slcPSPTWorkLocation').select2()

    $('#slcPSPTWorkLocation').on('change', function () {
        checkPSPTEmptyField('.divPSPTRegisterFormField', '#slcPSPTWorkLocation')
    })

    $('#txtPSPTIdentityNumber').on({
        'blur': function () {
            let userId = $(this).val()
            if ( userId.length === 5 && userId.includes('P') === false && userId.includes('K') === false ) {
                $.ajax({
                    beforeSend : _ => {        
                        tooltipPSPTDestroy('#txtPSPTIdentityNumber')
                        $(this).attr('readonly', '')
                        $(this).siblings('.spnPSPTLoading').fadeIn()
                    },
                    type     : 'post',
                    url      : `${baseurl}PendampinganSPT/Daftar/getUserInformation`,
                    data     : { userId : userId },
                    dataType : 'json'
                }).done( (resp) => {
                    if ( resp.length != 0 ) {
                        swalPSPTToastrAlert('success', 'Berhasil mendapatkan data.')
                        setPSPTRegisterFieldValue(null, resp[0].nama.trim(), resp[0].fs_ket.trim(), resp[0].seksi.trim(), resp[0].npwp.trim())
                    } else {
                        tooltipPSPTValidation('#txtPSPTIdentityNumber', 'Data dengan nomor induk ini tidak ditemukan.')
                        swalPSPTToastrAlert('error', `Data dengan nomor induk ${userId} tidak ditemukan.`)
                        setPSPTRegisterFieldValue()
                    }
                }).fail ( _ => {
                    swalPSPTToastrAlert('error', 'Gagal mendapatkan data.')
                }).always( _ => {
                    checkPSPTEmptyField('.divPSPTRegisterFormField', 'input')
                    $(this).removeAttr('readonly')
                    $(this).siblings('.spnPSPTLoading').fadeOut()
                })
            } else if ( userId.length === 5 && userId.includes('P')|| userId.includes('K') ) {
                tooltipPSPTDestroy('#txtPSPTIdentityNumber').then( _ => {
                    tooltipPSPTValidation('#txtPSPTIdentityNumber', 'Untuk pekerja OS pendampingan dilakukan oleh perusahaan masing-masing')
                    setPSPTRegisterFieldValue()
                    checkPSPTEmptyField('.divPSPTRegisterFormField', 'input')
                })                
            } else {
                tooltipPSPTDestroy('#txtPSPTIdentityNumber').then( _ => {
                    tooltipPSPTValidation('#txtPSPTIdentityNumber', 'Data yang anda tulis belum sesuai')    
                    setPSPTRegisterFieldValue()
                    checkPSPTEmptyField('.divPSPTRegisterFormField', 'input')
                })
            }
        },
        'input' : function () {
            $(this).val( ( _ , val) => {
                return val.toUpperCase()
            })
        }
    })

    $('.btnPSPTRefresh').on('click', function () {
        setPSPTRegisterFieldValue('refresh')
    })

    $('.btnPSPTRegister').on('click', function () {
        checkPSPTEmptyField('.divPSPTRegisterFormField', 'input, select')
        if ( $('.has-error').length === 0 && $('#txtPSPTTRN').val() != '-' ) {
            $('#mdlPSPTAlertNPWP').modal('hide')
            let type    = 'question'
            let text    = '<h4>Anda sudah yakin dengan informasi yang anda berikan?</h4>'
            let success = 'Berhasil melakukan pendaftaran.'
            let fail    = 'Gagal melakukan pendaftaran.'
            let url     = `${baseurl}PendampinganSPT/Daftar/addRegisteredUser`
            let data    = {
                nomor_induk    : $('#txtPSPTIdentityNumber').val(),
                nama           : $('#txtPSPTWorkerName').val(),
                status_pekerja : $('#txtPSPTWorkerStats').val(),
                seksi          : $('#txtPSPTSection').val(),
                nomor_npwp     : $('#txtPSPTTRN').val(),
                lokasi_kerja   : $('#slcPSPTWorkLocation').val(),
                tanggal_daftar : `${datePSPTYear}-${datePSPTMonth}-${datePSPTDay}`
            }
            swalPSPTAjaxConfirmation(type, text, url, data, success, fail).then( (resp) => {
                if ( resp.message === 'fail' && resp.data === undefined ) {
                    console.warn('Oops, something went wrong :(')
                    console.warn('Check your browser network tab to identify it.')
                } else if ( resp.message === 'fail' && resp.data.status === 'already available' ) {
                    $('#mdlPSPTAlertRegister').find('.modal-title').html('<i class="fa fa-warning"></i> Peringatan')
                    $('#mdlPSPTAlertRegister').find('p').html(`Nomor induk <b>${$('#txtPSPTIdentityNumber').val()}</b> sebelumnya telah melakukan pendaftaran dengan detail nomor pendaftaran sebagai berikut.`)
                    $('#txtPSPTRegisterId').val(resp.data.registered_number)
                    $('#mdlPSPTAlertRegister').modal('show')
                } else if ( resp.message === 'success' ) {
                    $('#mdlPSPTAlertRegister').find('.modal-title').html('<i class="fa fa-info"></i> Informasi')
                    $('#mdlPSPTAlertRegister').find('p').html('Pendaftaran sukses dilakukan dengan detail nomor pendaftaran sebagai berikut.')
                    $('#txtPSPTRegisterId').val(resp.data.registered_number)
                    $('#mdlPSPTAlertRegister').modal('show')
                    setPSPTRegisterFieldValue('refresh')
                } 
            })
        } else if ( $('.has-error').length === 0 ) {
            $('#mdlPSPTAlertNPWP').modal('show')
            swalPSPTToastrAlert('info', 'Silahkan mengisikan NPWP terlebih dahulu.')
        } else {
            swalPSPTToastrAlert('error', 'Silahkan mengisi informasi yang masih kosong.')
        }
    })

    $('.btnPSPTDetailSchedule').on('click', function () {
        $('#mdlPSPTDetailSchedule').modal('show')
    })


    /*
    | List Data Page 
    */
    const dataTablePSPTList = $('#tblPSPTList').DataTable({
        buttons: [
            {
                action    : _ => {
                    window.location = `${baseurl}PendampinganSPT/Data/exportExcel`
                },
                className : 'btn btn-default',
                text      : '<i class="fa fa-cloud-download"></i> Export'
                /* Archived for Example Data Table Export Excel
                exportOptions : {
                    columns : [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                },
                extend    : 'excelHtml5',
                title     : 'Data Pendaftar Pendampingan Surat Pajak Tahunan'
                */
            },
            {
                action    : _ => {
                    $('#mdlPSPTImportExcel').modal('show')
                },
                className : 'btn btn-default',
                text      : '<i class="fa fa-cloud-upload"></i> Import'
            }
        ],
        columnDefs  : [
            {
                orderable : false,
                targets   : 'no-orderable'
            },
            {
                targets    : [0, 12],
                searchable : false
            }
        ],
        dom :  `<'row' <'col-sm-12 col-md-4'l> <'col-sm-12 col-md-4 text-center'B> <'col-sm-12 col-md-4'f> >
                <'row' <'col-sm-12'tr> >
                <'row' <'col-sm-12 col-md-5'i> <'col-sm-12 col-md-7'p> >`,
        scrollX     : true,
        scrollY     : '425px'
    })

    $('#slcPSPTDataWorkerStats, #slcPSPTDataWorkLocation').select2()

    $('#slcPSPTDataWorkerStats, #slcPSPTDataWorkLocation').on('change', function () {
        dataTablePSPTList
            .columns(13).search($('#slcPSPTDataWorkerStats').val())
            .columns(2).search($('#slcPSPTDataWorkLocation').val())
            .draw()
    })

    $('#txtPSPTSchedule, #txtPSPTReportDate').datepicker({
        autoclose : true,
        format    : 'yyyy-mm-dd'
    })

    $('#filePSPTImportExcel').on('change', function () {
        tooltipPSPTDestroy('#filePSPTImportExcel')
    })

    $('.btnPSPTImportExcel').on('click', function () {
        checkPSPTEmptyField('#mdlPSPTImportExcel', '#filePSPTImportExcel')
        if ( $('.has-error').length === 0 ) {
            let type    = 'warning'
            let text    = `<h4>Anda yakin akan melakukan import File Excel?</h4>
                           <h4><b><i class="fa fa-warning"></i> Data yang telah tertimpa tidak bisa dikembalikan!</b></h4>`
            let success = 'Berhasil melakukan import excel.'
            let fail    = 'Gagal melakukan import excel.'
            let url     = `${baseurl}PendampinganSPT/Data/importExcel`
            let data = new FormData()
            data.append('file', $('#filePSPTImportExcel').prop('files')[0])
            swalPSPTAjaxConfirmation(type, text, url, data, success, fail, 'yes').then( (resp) => {
                if ( resp.message === 'fail' && resp.data === undefined ) {
                    console.warn('Oops, something went wrong :(')
                    console.warn('Check your browser network tab to identify it.')
                } else if ( resp.message === 'fail' && resp.data.detail === 'wrong data' ) {
                    tooltipPSPTValidation('#filePSPTImportExcel', 'File yang anda berikan tidak sesuai. Silahkan melakukan export ulang terlebih dahulu.')
                } else if ( resp.message === 'fail' && resp.data.detail === 'data not equal' ) {
                    tooltipPSPTValidation('#filePSPTImportExcel', 'Data pada file ini telah usang. Silahkan melakukan export ulang terlebih dahulu.')
                } else if ( resp.message === 'fail' && resp.data.detail === 'wrong file format' ) {
                    tooltipPSPTValidation('#filePSPTImportExcel', 'File ini tidak dapat diimport. Silahkan cek kembali file yang akan anda import.')
                } else if ( resp.message === 'success' ) {
                    setTimeout( _ => {
                        location.reload()
                    }, 1000)
                }
            })
        } else {
            swalPSPTToastrAlert('error', 'Silahkan memilih file excel terlebih dahulu.')
        }
    })

    $(document).on('click', '.btnPSPTDelete', function () {
        let type    = 'warning'
        let text    = '<h4>Anda yakin akan menghapus data ini?</h4>'
        let success = 'Berhasil menghapus data.'
        let fail    = 'Gagal menghapus data.'
        let url     = `${baseurl}PendampinganSPT/Data/delete`
        let data    = {
            'data-id' : $(this).siblings('input').val()
        }
        swalPSPTAjaxConfirmation(type, text, url, data, success, fail).then( (resp) => {
            if ( resp.message === 'success' ) {
                dataTablePSPTList
                    .rows($(this).parents('tr')).remove()
                    .draw()
                $('#tblPSPTList').find('td:first-child').each( function ( key ) {
                    $(this).html(key+1)
                })                
            }
        })
    })

    $('.btnPSPTSaveEdit').on('click', function () {
        let type    = 'question'
        let text    = '<h4>Anda sudah yakin dengan informasi yang anda berikan?</h4>'
        let success = 'Berhasil memperbarui data.'
        let fail    = 'Gagal memperbarui data.'
        let url     = `${baseurl}PendampinganSPT/Data/saveEdit`
        let data    = {
            'data-id'      : $('#txtPSPTHiddenId').val(),
            jadwal         : $('#txtPSPTSchedule').val(),
            lokasi         : $('#txtPSPTRoom').val(),
            efin           : $('#txtPSPTEFIN').val(),
            email          : $('#txtPSPTEmail').val(),
            tanggal_lapor  : $('#txtPSPTReportDate').val()
        }
        swalPSPTAjaxConfirmation(type, text, url, data, success, fail)
    })


    /*
    | Schedule Page 
    */
    const dataTablePSPTSchedule = $('#tblPSPTSchedule').DataTable({
        buttons: [{
            className : 'btn btn-default',
            extend    : 'excelHtml5',
            text      : '<i class="fa fa-cloud-download"></i> Export',
            title     : 'Jadwal Pendampingan Pelaporan Surat Pajak Tahunan'
        }],
        columnDefs  : [{
            targets    : 0,
            searchable : false
        }],
        dom :  `<'row' <'col-sm-12 col-md-4'l> <'col-sm-12 col-md-4 text-center'B> <'col-sm-12 col-md-4'f> >
                <'row' <'col-sm-12'tr> >
                <'row' <'col-sm-12 col-md-5'i> <'col-sm-12 col-md-7'p> >`,
        scrollY     : '425px'
    })

    $('#slcPSPTSearchBy').select2()

    $('#slcPSPTSearchBy').on('change', function () {
        $('#txtPSPTSearchBy').val(null)
        dataTablePSPTSchedule
            .columns(4).search('')
            .columns(2).search('')
            .columns(3).search('')
            .draw()
    })

    $('#txtPSPTSearchBy').on('input', function () {
        let searchBy = $('#slcPSPTSearchBy').val()
        if ( searchBy === 'Nama' ) {
            dataTablePSPTSchedule.columns(4).search($(this).val()).draw()
        } else if ( searchBy === 'No. Pendaftaran' ) {
            dataTablePSPTSchedule.columns(2).search($(this).val()).draw()
        } else if ( searchBy === 'Seksi' ) {
            dataTablePSPTSchedule.columns(5).search($(this).val()).draw()
        }
    })


    /*
    |
    */
    $('.lblPSPTLoading').fadeOut('slow').promise().done( _ => {
        $('.divPSPTTableContent').fadeIn( _ => {            
            dataTablePSPTList.draw()
            dataTablePSPTSchedule.draw()
        })
    })

    /*
    | DRY *
    */

})