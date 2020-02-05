$(document).ready( _ => {

    const dataTableADOList = $('.tblADOList').DataTable({
        columnDefs    : [{
            orderable   : false,
            targets     : 'no-orderable'
        }],
		scrollY 	  : '350px'
    })

    const dataTableADODetailList = $('.tblADODetailList').DataTable({
        columnDefs    : [{
            orderable   : false,
            targets     : 'no-orderable'
        }],
        drawCallback  : function () {
            $('.chkADOPickedRelease, .chkADOPickedReleaseAll').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_flat-blue'
            })        
        },
        fixedHeader   : true,
        pageLength    : 25,
		scrollY 	  : '350px'
    })

    const dataTableADODetailAllPageList = dataTableADODetailList.cells().nodes()

    const swalADOQuestionAjax = ( title, success, fail, url, data ) => {
        return new Promise( (response) => {
            Swal.fire({
                customClass       : 'swal-font-small',
                type              : 'question',
                title             : title,
                confirmButtonText : 'Ya',
                cancelButtonText  : 'Tidak',
                cancelButtonColor : '#d33',
                showCancelButton  : true
            }).then( (result) => {
                if ( result.value ) {
                    Swal.fire({
                        customClass       : 'swal-font-small',
                        title             : 'Mohon menunggu',
                        text              : 'Sedang memproses ...',
                        onBeforeOpen      : () => {
                            Swal.showLoading()
                        },
                        allowOutsideClick : false
                    })
                    $.ajax({
                        type     : 'POST',
                        url      : url,
                        data     : data,
                        dataType : 'JSON',
                    }).done( (resp) => {
                        swalADOMixinToast('success', success)
                        response(resp)
                    }).fail( () => {
                        swalADOMixinToast('error', fail)
                        response('Fail')
                    })
                } else {
                    response('Cancelled')
                }
            })
        })
    }

    const swalADOMixinToast = ( type, title ) => {
        Swal.mixin({
            toast             : true,
            position          : 'top-end',
            showConfirmButton : false,
            timer             : 3000
        }).fire({
            customClass : 'swal-font-small',
            type        : type,
            title       : title
        })
    }

    $('.divADOLoadingTable').fadeOut('slow').promise().done( _ => {
        $('.tblADOList, .tblADODetailList').fadeIn( _ => {
            $($.fn.dataTable.tables(true)).DataTable().draw()
        })
    })

    $('.slcADOAssignerList').select2({
        width : 'resolve'
    })

    $(document).on('ifChanged', '.chkADOPickedReleaseAll', function (e) {
        e.target.checked ?
            $(dataTableADODetailAllPageList).find('.chkADOPickedRelease').iCheck('check') :
            $(dataTableADODetailAllPageList).find('.chkADOPickedRelease').iCheck('uncheck')
    })

    $('.btnADOSelectApprover').on('click', function () {
        // $('.trADOQtyZero').length === 0 || $('.txtADOOrderType').val() === 'HO-Perlengkapan-DN' ?
        //     $('#mdlADOAssignApprover').modal('show') :
        //     swalADOMixinToast('error', 'Quantity on hand tidak memenuhi. Silahkan dilakukan pengecekan ulang')
        $('#mdlADOAssignApprover').modal('show')
    })

    $('.btnADORequestApproveDO').on('click', function () {
        let data     = {
            doNumber        : $('.spnADODONumber').html(),
            soNumber        : $('.spnADOSONumber').html(),
            approver        : $('.slcADOAssignerList').val(),
            approverName    : $('.slcADOAssignerList').find(':selected').text().split(' - ').slice(-1).pop(),
            approverAddress : $('.slcADOAssignerList').find(':selected').attr('address')
        }
        let url      = `${baseurl}ApprovalDO/ListDO/requestApproveDO`
        let question = `Request Approve DO Ini ke ${data.approver} ?`
        let success  = 'Berhasil Request Approve DO'
        let fail     = 'Gagal Request Approve DO'
        swalADOQuestionAjax(question, success, fail, url, data).then( (resp) => {
            if ( resp != 'Cancelled' && resp != 'Fail' ) {
                $('.btnADOSelectApprover').attr('disabled', '')
                $('.btnADOSelectApprover').html(
                    '<i class="fa fa-check"></i>&nbsp; Approval Requested'
                )
                $('#mdlADOAssignApprover').modal('hide')
                $('.btnADOPending').remove()
            }
        })
    })

    $('.btnADORequestApproveSPB').on('click', function () {
        let data     = {
            spbNumber       : $('.spnADODONumber').html(),
            approver        : $('.slcADOAssignerList').val(),
            approverName    : $('.slcADOAssignerList').find(':selected').text().split(' - ').slice(-1).pop(),
            approverAddress : $('.slcADOAssignerList').find(':selected').attr('address')
        }
        let url      = `${baseurl}ApprovalDO/ListSPB/requestApproveSPB`
        let question = `Request Approve SPB Ini ke ${data.approver} ?`
        let success  = 'Berhasil Request Approve SPB'
        let fail     = 'Gagal Request Approve SPB'
        swalADOQuestionAjax(question, success, fail, url, data).then( (resp) => {
            if ( resp != 'Cancelled' && resp != 'Fail' ) {
                $('.btnADOSelectApprover').attr('disabled', '')
                $('.btnADOSelectApprover').html(
                    '<i class="fa fa-check"></i>&nbsp; Approval Requested'
                )
                $('#mdlADOAssignApprover').modal('hide')
                $('.btnADOPending').remove()
            }
        })
    })

    $('.btnADOApprove').on('click', function () {
        let data     = {
            doNumber : $('.spnADODONumber').html()
        }
        let url      = `${baseurl}ApprovalDO/Approval/approveDO`
        let question
        $('.spnADODetailType').html().includes('SPB') ? 
            question = 'Approve SPB Ini?' :
            question = 'Approve DO Ini?'
        let success  = 'Berhasil Melakukan Approve DO'
        let fail     = 'Gagal Melakukan Approve DO'
        swalADOQuestionAjax(question, success, fail, url, data).then( (resp) => {
            if ( resp != 'Cancelled' && resp != 'Fail' ) {
                $(this).attr('disabled', '')
                $(this).removeClass('btn-primary').addClass('btn-success').html(
                    '<i class="fa fa-check-circle-o"></i>&nbsp; Approved'
                )
                $('.btnADOReject, .btnADOPending').remove()
            }
        })
    })
    
    $('.btnADOReject').on('click', function () {
        let data     = {
            doNumber : $('.spnADODONumber').html()
        }
        let url      = `${baseurl}ApprovalDO/Approval/rejectDO`
        let question
        $('.spnADODetailType').html().includes('SPB') ? 
            question = 'Reject SPB Ini?' :
            question = 'Reject DO Ini?'
        let success  = 'Berhasil Melakukan Reject DO'
        let fail     = 'Gagal Melakukan Reject DO'
        swalADOQuestionAjax(question, success, fail, url, data).then( (resp) => {
            if ( resp != 'Cancelled' && resp != 'Fail' ) {
                $(this).attr('disabled', '')
                $(this).removeClass('btn-primary').addClass('btn-danger').html(
                    '<i class="fa fa-remove"></i>&nbsp; Rejected'
                )
                $('.btnADOApprove, .btnADOPending').remove()
            }
        })
    })

    $('.btnADOPending').on('click', function () {
        let data     = {
            doNumber : $('.spnADODONumber').html() 
        }
        let url      = `${baseurl}ApprovalDO/Approval/pendingDO`
        let question
        $('.spnADODetailType').html().includes('SPB') ? 
            question = 'Pending SPB Ini?' :
            question = 'Pending DO Ini?'
        let success  = 'Berhasil Melakukan Pending DO'
        let fail     = 'Gagal Melakukan Pending DO'
        swalADOQuestionAjax(question, success, fail, url, data).then( (resp) => {
            if ( resp != 'Cancelled' && resp != 'Fail' ) {
                $(this).attr('disabled', '')
                $(this).removeClass('btn-primary').addClass('btn-default').html(
                    '<i class="fa fa-clock-o"></i>&nbsp; Pending'
                )
                $('.btnADOReject, .btnADOApprove').remove()
            }
        })
    })

    $('.btnADOLaunchRelease').on('click', function () {
        let data     = {
            deliveryId : ( _ => {
                let checkedVal = []
                $(dataTableADODetailAllPageList).find('.chkADOPickedRelease:checked').each( function () {
                    checkedVal.push($(this).parents('tr').find('.spnADODeliveryID').html())
                })
                return checkedVal
            }) ()
        }
        let url      = `${baseurl}ApprovalDO/LaunchPickRelease/releaseDO`
        let question = 'Lakukan Launch Pick Release?'
        let success  = 'Berhasil Melakukan Launch Pick Release'
        let fail     = 'Gagal Melakukan Launch Pick Release'
        $('.chkADOPickedRelease:checked').length != 0 ?
            swalADOQuestionAjax(question, success, fail, url, data) :
            swalADOMixinToast('error', 'Anda Belum Menchecklist Apapun.')
    })

    $('.btnADOSave').on('click', function () {
        let data = {
            prNumber              : $('.spnADOPRNumber').html(),
            vehicleCategory       : $('.txtADOVehicleCategory').val(),
            vehicleId             : $('.txtADOVehicleIdentity').val(),
            driverName            : $('.txtADODriverName').val(),
            driverPhone           : $('.txtADODriverPhoneNumber').val(),
            additionalInformation : $('.txtADOAdditionalInformation').val()
        }
        let url      = `${baseurl}ApprovalDO/DPB/saveDetail`
        let question = 'Simpan Data Ini?'
        let success  = 'Berhasil Menyimpan Data'
        let fail     = 'Gagal Menyimpan Data'
        swalADOQuestionAjax(question, success, fail, url, data)
    })

    if ( window.location.href.indexOf('ApprovalDO/ListDO') > -1 ) {
        setTimeout( _ => {
            window.location.reload(1)
        }, 300000)
    }

    if ( window.location.href.indexOf('ApprovalDO/Detail/ListDO') > -1 ) {
        $('.tdADOQtyATR').each( function () {
            if ( $(this).html() === '0' )
                $(this).parents('tr').addClass('bg-red trADOQtyZero')
        })
    }

})