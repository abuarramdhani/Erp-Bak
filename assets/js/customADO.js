$(document).ready( _ => {

    const dataTableADOList = $('.tblADOList').DataTable({
		scrollY 	  : '350px',
        fixedHeader   : true,
        columnDefs    : [{
            orderable   : false,
            targets     : 'no-orderable'
        }]
    })

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
                        Swal.mixin({
                            toast             : true,
                            position          : 'top-end',
                            showConfirmButton : false,
                            timer             : 3000
                        }).fire({
                            customClass : 'swal-font-small',
                            type        : 'success',
                            title       : success
                        })
                        response(resp)
                    }).fail( () => {      
                        Swal.mixin({
                            toast             : true,
                            position          : 'top-end',
                            showConfirmButton : false,
                            timer             : 3000
                        }).fire({
                            customClass : 'swal-font-small',
                            type        : 'error',
                            title       : fail
                        })
                        response('Fail')
                    })
                } else {
                    response('Cancelled')
                }
            })
        })
    }

    $('.divADOLoadingTable').fadeOut('slow').promise().done( _ => {
        $('.tblADOList').fadeIn( _ => {
            dataTableADOList.draw()
        })
    })

    $('.slcADOAssignerList').select2({
        width : 'resolve'
    })

    $('.chkADOPickedRelease').iCheck('checkboxClass', 'icheckbox_flat')

    $(document).on('click', '.btnADORequestApprove', function () {
        let data     = {
            doNumber : $('.spnADODONumber').html(),
            soNumber : $('.spnADOSONumber').html(),
            approver : $('.slcADOAssignerList').val()
        }
        let url      = `${baseurl}ApprovalDO/List/requestApproveDO`
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
            }
        })
    })

    $('.btnADOApprove').on('click', function () {
        let data     = {
            doNumber : $('.spnADODONumber').html()
        }
        let url      = `${baseurl}ApprovalDO/Approval/approveDO`
        let question = 'Approve DO Ini?'
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
        let question = 'Reject DO Ini?'
        let success  = 'Berhasil Melakukan Reject DO'
        let fail     = 'Gagal Melakukan Reject DO'
        swalADOQuestionAjax(question, success, fail, url, data).then( (resp) => {
            if ( resp != 'Cancelled' && resp != 'Fail' ) {
                $(this).attr('disabled', '')
                $(this).removeClass('btn-primary').addClass('btn-danger').html(
                    '<i class="fa fa-remove"></i>&nbsp; Rejected'
                )
                $('.btnADOApprove').remove()
            }
        })
    })

    $('.btnADOPending').on('click', function () {
        let data     = {
            doNumber : $('.spnADODONumber').html() 
        }
        let url      = `${baseurl}ApprovalDO/Approval/pendingDO`
        let question = 'Pending DO Ini?'
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

    $(document).on('click', '.btnADOLaunchRelease', function () {
        let data     = {
            deliveryId : ( _ => {
                let data = []
                $('.chkADOPickedRelease:checked').each( function () {
                    data.push($(this).parents('tr').find('.spnADODeliveryID').html())
                })
                return data
            }) ()
        }
        let url      = `${baseurl}ApprovalDO/LaunchPickRelease/releaseDO`
        let question = 'Anda Yakin Melakukan Launch Pick Release?'
        let success  = 'Berhasil Melakukan Launch Pick Release'
        let fail     = 'Gagal Melakukan Launch Pick Release'
        $('.chkADOPickedRelease:checked').length != 0 ?
            swalADOQuestionAjax(question, success, fail, url, data) :
            Swal.mixin({
                toast             : true,
                position          : 'top-end',
                showConfirmButton : false,
                timer             : 3000
            }).fire({
                customClass : 'swal-font-small',
                type        : 'error',
                title       : 'Anda Belum Menchecklist Apapun.'
            })
    })

    if ( window.location.href.indexOf('ApprovalDO/List') > -1 ) {
        setTimeout( _ => {
            window.location.reload(1)
        }, 300000)
    }

})