$( _ => {

    const datePSPT      = new Date()
    const datePSPTDay   = String(datePSPT.getDate()).padStart(2, '0')
    const datePSPTMonth = String(datePSPT.getMonth() + 1).padStart(2, '0')
    const datePSPTYear  = datePSPT.getFullYear()

    const checkPSPTEmptyField = ( target ) => {
        $('.PSPTRegisterFormField').find(target).each( function () {
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
            select2PSPTWorkLocation.val(null).trigger('change')
            $('.has-error, .has-success').removeClass('has-error has-success')
        }
    }

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

    const select2PSPTWorkLocation = $('#slcPSPTWorkLocation').select2()

    const select2PSPTWorkerStats = $('#slcPSPTWorkerStats').select2()

    $('[data-toggle="tooltipPSPT"]').tooltip()

    $('.spnPSPTDate').html(`${datePSPTDay}/${datePSPTMonth}/${datePSPTYear}`)

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
                    checkPSPTEmptyField('input')
                    $(this).removeAttr('readonly')
                    $(this).siblings('.spnPSPTLoading').fadeOut()
                })
            } else if ( userId.length === 5 && userId.includes('P')|| userId.includes('K') ) {
                tooltipPSPTDestroy('#txtPSPTIdentityNumber').then( _ => {
                    tooltipPSPTValidation('#txtPSPTIdentityNumber', 'Untuk pekerja OS pendampingan dilakukan oleh perusahaan masing-masing')
                })                
            } else {
                tooltipPSPTDestroy('#txtPSPTIdentityNumber').then( _ => {
                    tooltipPSPTValidation('#txtPSPTIdentityNumber', 'Data yang anda tulis belum sesuai')    
                })
            }
        },
        'input' : function () {
            $(this).val(function(_, val) {
                return val.toUpperCase();
            })
        }
    })

    $('.btnPSPTRefresh').on('click', function () {
        setPSPTRegisterFieldValue('refresh')
    })

    $('.btnPSPTRegister').on('click', function () {
        checkPSPTEmptyField('input, select')
        if ( $('.has-error').length === 0 && $('#txtPSPTTRN').val() != '-' ) {
            $('#mdlPSPTAlertNPWP').modal('hide')
            Swal.fire({
                customClass       : 'swal-font-small',
                type              : 'question',
                html              : '<h4>Anda sudah yakin dengan informasi yang anda berikan?</h4>',
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
                                onBeforeOpen      : () => {
                                    Swal.showLoading()
                                },
                                allowOutsideClick : false
                            })
                        },
                        type     : 'post',
                        url      : `${baseurl}PendampinganSPT/Daftar/addRegisteredUser`,
                        data     : {
                            nomor_induk    : $('#txtPSPTIdentityNumber').val(),
                            nama           : $('#txtPSPTWorkerName').val(),
                            status_pekerja : $('#txtPSPTWorkerStats').val(),
                            seksi          : $('#txtPSPTSection').val(),
                            nomor_npwp     : $('#txtPSPTTRN').val(),
                            lokasi_kerja   : $('#slcPSPTWorkLocation').val(),
                            tanggal_daftar : `${datePSPTYear}-${datePSPTMonth}-${datePSPTDay}`
                        },
                        dataType : 'json'
                    }).done( (resp) => {
                        if ( resp.status === 'Already Available' ) {
                            swalPSPTToastrAlert('error', `Gagal melakukan pendaftaran.`)
                            $('#mdlPSPTAlertRegister').find('.modal-title').html('<i class="fa fa-warning"></i> Peringatan')
                            $('#mdlPSPTAlertRegister').find('p').html(`Nomor induk <b>${$('#txtPSPTIdentityNumber').val()}</b> sebelumnya telah melakukan pendaftaran dengan detail nomor pendaftaran sebagai berikut.`)
                        } else {
                            swalPSPTToastrAlert('success', 'Berhasil melakukan pendaftaran.')
                            $('#mdlPSPTAlertRegister').find('.modal-title').html('<i class="fa fa-info"></i> Informasi')
                            $('#mdlPSPTAlertRegister').find('p').html('Pendaftaran sukses dilakukan dengan detail nomor pendaftaran sebagai berikut.')
                        }
                        $('#txtPSPTRegisterId').val(resp.registered_number)
                        $('#mdlPSPTAlertRegister').modal('show')
                        setPSPTRegisterFieldValue('refresh')
                    }).fail ( _ => {
                        swalPSPTToastrAlert('error', 'Gagal melakukan pendaftaran.')
                    })
                }
            })
        } else if ( $('.has-error').length === 0 ) {
            $('#mdlPSPTAlertNPWP').modal('show')
            swalPSPTToastrAlert('info', 'Silahkan mengisikan NPWP terlebih dahulu.')
        } else {
            swalPSPTToastrAlert('error', 'Silahkan mengisi informasi yang masih kosong.')
        }
    })

    $('.linkPSPTDetailSchedule').on('click', function (e) {
        e.preventDefault()
        $('#mdlPSPTDetailSchedule').modal('show')
    })

})