$( () => {

    $('.ADOEstDatang').datetimepicker({
        locale : 'id'
    });

    $('.txttglKirimADO').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'dd-M-yyyy'
    })

    const dataTableADOList = $('.tblADOList').DataTable({
        columnDefs    : [{
            orderable   : false,
            targets     : 'no-orderable'
        }],
        scrollY 	  : '350px',
        // scrollX: true,
        // scrollCollapse: true,
    })

    dataTableADODetailList = $('.tblADODetailList').DataTable({
        columnDefs    : [{
            orderable   : false,
            targets     : 'no-orderable'
        }],
        drawCallback  : () => {
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

    const swalADOQuestionAjax1 = ( title, success, fail, url, data ) => {
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
                        if (resp == 'error stok gudang tidak mencukupi') {
                            
                            Swal.fire({
                                type: 'error',
                                title: 'Gagal',
                                text: 'Stok gudang tidak mencukupi!',
                            });
                        }
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

    $('.divADOLoadingTable').fadeOut('slow').promise().done( () => {
        $('.tblADOList, .tblADODetailList').fadeIn( () => {
            $($.fn.dataTable.tables(true)).DataTable().draw()
        })
    })

    $('a[disabled=""]').on('click', function (e) {
        e.preventDefault()
    })

    $('.slcADOAssignerList').select2({
        width : 'resolve'
    })

    $('.slcADOAssignerList1').select2({
        width : 'resolve'
    })

    $('.slcADOAssignerList2').select2({
        width : 'resolve'
    })
    
    $('.slcADOGudangPengirim').select2({
        placeholder : 'Pilih Gudang Pengirim'
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
        var permintaanTanggalKirim = $('.txttglKirimADO').val();

        if (permintaanTanggalKirim) {
            
            $('#mdlADOAssignApprover').modal('show')
        }else{
            Swal.fire({
                customClass: 'swal-font-large',
                type: 'error',
                title: 'Gagal',
                text: 'Tanggal Permintaan Kirim tidak boleh kosong!',
            });

            $('.txttglKirimADO').attr({
                style: 'background-color :#fbfb5966; min-width:150px;'
            });
        }
    })

    $('.btnADORequestApproveDO').on('click', function () {
        let data     = {
            doNumber        : $('.spnADODONumber').html(),
            soNumber        : $('.spnADOSONumber').html(),
            approver1        : $('.slcADOAssignerList1').val(),
            approver2        : $('.slcADOAssignerList2').val(),
            tglPermintaanKirim : $('.txttglKirimADO').val(),
            approver1Name    : $('.slcADOAssignerList1').find(':selected').text().split(' - ').slice(-1).pop(),
            approver2Name    : $('.slcADOAssignerList2').find(':selected').text().split(' - ').slice(-1).pop(),
            approver1Address : $('.slcADOAssignerList1').find(':selected').attr('address'),
            approver2Address : $('.slcADOAssignerList2').find(':selected').attr('address')
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
            deliveryId : ( () => {
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
            driverPhone           : $('.txtADODriverContact').val(),
            expVendor             : $('.txtADOExpeditionVendor').val(),
            estDatang             : $('.txtADOEstDatang').val(),
            tglKirim              : $('.txttglKirimADO').val(),
            gudangPengirim        : $('.slcADOGudangPengirim').val(),
            alamatBongkar         : $('.txtADOAlamatBongkar').val(),
            catatan               : $('.txtADOCatatan').val()
        }
        let url      = `${baseurl}ApprovalDO/ListDPBVendor/saveDetail`
        let question = 'Simpan Data Ini?'
        let success  = 'Berhasil Menyimpan Data'
        let fail     = 'Gagal Menyimpan Data'
        swalADOQuestionAjax(question, success, fail, url, data)
    })
    
    $('.btnADOCreateDPB').on('click', function () {

        var tgl_kirim = $('.txttglKirimADO').val();

        var gudang_pengirim = $('.slcADOGudangPengirim').val();

        var no_do = new Array();

        $('.nodoADO').each(function (i) {
            var nodo = $(this).val();
            no_do[i] = {nomor_do : nodo};
        });

        console.log(no_do);


        if (tgl_kirim && gudang_pengirim) {
            let data = {
                prNumber              : $('.spnADOPRNumber').html(),
                vehicleCategory       : $('.txtADOVehicleCategory').val(),
                vehicleId             : $('.txtADOVehicleIdentity').val(),
                driverName            : $('.txtADODriverName').val(),
                driverPhone           : $('.txtADOExpeditionVendor').val(),
                // additionalInformation : $('.txtADOAdditionalInformation').val(),
                tglKirim              : $('.txttglKirimADO').val(),
                gudangPengirim        : $('.slcADOGudangPengirim').val(),
                alamatBongkar         : $('.txtADOAlamatBongkar').val(),
                catatan               : $('.txtADOCatatan').val(),
                noDO                : no_do
            }
            let url      = `${baseurl}ApprovalDO/ListPR/saveDetail`
            let question = 'Simpan Data Ini?'
            let success  = 'Berhasil Menyimpan Data'
            let fail     = 'Gagal Menyimpan Data'
            swalADOQuestionAjax1(question, success, fail, url, data)
        }else{

            Swal.fire({
                customClass: 'swal-font-large',
                type: 'error',
                title: 'Gagal',
                text: 'Tanggal Kirim & Gudang Pengirim tidak boleh kosong!',
            });
        }
    })

    $('.btnApproveDPBDO').on('click', function () {
        var value = $(this).val();
        if (value == 0) {
            let data = {
                flag : 'N',
                prNumber              : $('.spnADOPRNumber').html(),
            }
            let url      = `${baseurl}ApprovalDO/ApprovalDPB/Action`
            let question = 'Reject Data Ini?'
            let success  = 'Berhasil Reject Data'
            let fail     = 'Gagal Reject Data'
            swalADOQuestionAjax(question, success, fail, url, data)
        }else{
            let data = {
                flag : 'Y',
                prNumber              : $('.spnADOPRNumber').html(),
            }
            let url      = `${baseurl}ApprovalDO/ApprovalDPB/Action`
            let question = 'Approve Data Ini?'
            let success  = 'Berhasil Approve Data'
            let fail     = 'Gagal Approve Data'
            swalADOQuestionAjax(question, success, fail, url, data)
        }

    })

    $('.btnADOAddNewRow').on('click', function () {
        let rownum = dataTableADODetailList.rows().count() + 1
        dataTableADODetailList.row.add([
            rownum,
            '<select class="form-control-auto form-control txtADODONumber" style="width:200px;"></select>',
            '<input type="text" class="form-control-auto form-control txtADOItemName">',
            '<input type="number" class="form-control-auto form-control txtADOQty">',
            '<input type="text" class="form-control-auto form-control txtADOUOM">',
            '<input type="text" class="form-control-auto form-control txtADOShopName">',
            '<input type="text" class="form-control-auto form-control txtADOCity">',
            '<button title="Hapus Baris" class="btn btn-danger btnADODeleteRow"><i class="fa fa-trash"></i></button>'
            // '<input type="number" class="form-control-auto form-control txtADODONumber">',
            // '<input type="text" class="form-control-auto form-control txtADOItemName">',
            // '<input type="number" class="form-control-auto form-control txtADOQty">',
            // '<input type="text" class="form-control-auto form-control txtADOUOM">',
            // '<input type="text" class="form-control-auto form-control txtADOShopName">',
            // '<input type="text" class="form-control-auto form-control txtADOCity">',
            // '<button title="Hapus Baris" class="btn btn-danger btnADODeleteRow"><i class="fa fa-trash"></i></button>'
        ])
        $(dataTableADODetailList.row(':last').nodes())
            .attr('data-type', 'new')
            .children(':first').addClass('text-right').css('width', '5%')
            .parent().children(':last').addClass('text-center').css('width', '5%')
        dataTableADODetailList.draw()
        $('.txtADODONumber').select2({
            allowClear: true,
            placeholder: "Insert Kode DO",
            minimumInputLength: 5,
            ajax: {
                url:baseurl+"ApprovalDO/DPBKHS/AddDetailInformationList",
                dataType: 'json',
                type: "GET",
                data: function(params) {
                    return {
                        q: params.term,
                    };
                },
                processResults: function (data) {
                    console.log(data);
                    return {
                        results: $.map(data, function(obj) {
                            return { 
                                id: obj.NO_DO_SPB,
                                text: obj.NO_DO_SPB,
                                nama_barang: obj.ITEM,
                                qty: obj.QUANTITY,
                                uom: obj.UOM,
                                nama_toko: obj.RELATION,
                                kota: obj.CITY
                            };
                        })
                    };
                }
            }
        });
        
        $(document).on('change','.txtADODONumber', function () {
            var row_ini = $(this).parentsUntil('tbody');
            var nama_barang = $(this).select2('data')[0]['nama_barang'];
            var qty = $(this).select2('data')[0]['qty'];
            var uom = $(this).select2('data')[0]['uom'];
            var nama_toko = $(this).select2('data')[0]['nama_toko'];
            var kota = $(this).select2('data')[0]['kota'];

            row_ini.find('.txtADOItemName').val(nama_barang);
            row_ini.find('.txtADOQty').val(qty);
            row_ini.find('.txtADOUOM').val(uom);
            row_ini.find('.txtADOShopName').val(nama_toko);
            row_ini.find('.txtADOCity').val(kota);
        })
    })

    $('.btnADODPBSaveNew').on('click', function () {
        let data = {
            header : {
                vehicleCategory       : $('.txtADOVehicleCategory').val(),
                vehicleId             : $('.txtADOVehicleIdentity').val(),
                driverName            : $('.txtADODriverName').val(),
                driverPhone           : $('.txtADOExpeditionVendor').val(),
                alamatBongkar         : $('.txtADOAlamatBongkar').val(),
                gudangPengirim        : $('.slcADOGudangPengirim').val(),
                catatan               : $('.txtADOCatatan').val()
                // additionalInformation : $('.txtADOAdditionalInformation').val()
            },
            line : ( () => {
                let data = []
                $(dataTableADODetailList.rows('[data-type="new"]').nodes()).each( function (key) { 
                    data.push({
                        line     : key + 1,
                        doNumber : $(this).find('.txtADODONumber').val(),
                        itemName : $(this).find('.txtADOItemName').val(),
                        qty      : $(this).find('.txtADOQty').val(),
                        uom      : $(this).find('.txtADOUOM').val(),
                        shopName : $(this).find('.txtADOShopName').val(),
                        city     : $(this).find('.txtADOCity').val()
                    })
                })
                return data
            }) ()
        }
        let url      = `${baseurl}ApprovalDO/DPBKHS/saveNew`
        let question = 'Simpan Data Ini?'
        let success  = 'Berhasil Menyimpan Data'
        let fail     = 'Gagal Menyimpan Data'
        swalADOQuestionAjax(question, success, fail, url, data).then( (resp) => {
            if ( resp !== 'Cancelled' && resp !== 'Fail' ) {
                Swal.fire({
                    customClass : 'swal-font-small',
                    type        : 'success',
                    title       : 'Berhasil!',
                    text        : `Sukses menambahkan data dengan Nomor PR ${resp} !`,
                    footer      : `<form action="${baseurl}ApprovalDO/DPBKHS/Detail" method="post">
                                        <input type="hidden" name="data-pr" value="${resp}">
                                        <button class="btn-link">Untuk memperbarui data ini silahkan klik disini.</button>
                                   </form>`
                })
            }
        })
    })

    $('.tblADODetailList').on('click', '.btnADODeleteRow', function () {
        let dataType = $(this).parents('tr').attr('data-type')
        if (dataType !== 'new') {
            $(this).parents('tr').addClass('bg-danger-important').attr({
                'data-store' : dataType,
                'data-type'  : 'delete'
            })
            $(this).parent().html(
                '<button title="Batalkan Hapus" class="btn btn-success btnADOUndeleteRow"><i class="fa fa-repeat"></i></button>'
            )
        } else {
            dataTableADODetailList.rows($(this).parents('tr')).remove().draw()   
        }
    })
    
    $('.tblADODetailList').on('click', '.btnADOUndeleteRow', function () {
        let dataType = $(this).parents('tr').attr('data-store')
        $(this).parents('tr').removeClass('bg-danger-important').attr({
            'data-type'  : dataType
        })
        $(this).parent().html(
            '<button title="Hapus Baris" class="btn btn-danger btnADODeleteRow"><i class="fa fa-trash"></i></button>'
        )
    })

    $('.btnADOSaveUpdate').on('click', function () {
        let data = {
            header : {
                prNumber              : $('.spnADOPRNumber').html(),
                vehicleCategory       : $('.txtADOVehicleCategory').val(),
                vehicleId             : $('.txtADOVehicleIdentity').val(),
                driverName            : $('.txtADODriverName').val(),
                driverPhone           : $('.txtADOExpeditionVendor').val(),
                alamatBongkar         : $('.txtADOAlamatBongkar').val(),
                catatan               : $('.txtADOCatatan').val()

                // additionalInformation : $('.txtADOAdditionalInformation').val()
            },
            newLine : ( () => {
                let data = []
                let line = []
                $(dataTableADODetailList.rows('[data-type="update"]').nodes()).each( function () { 
                    line.push($(this).attr('data-line'))
                })
                let max = Math.max(...line) + 1
                $(dataTableADODetailList.rows('[data-type="new"]').nodes()).each( function (key) { 
                    data.push({
                        lineNumber : key + max,
                        doNumber   : $(this).find('.txtADODONumber').val(),
                        itemName   : $(this).find('.txtADOItemName').val(),
                        qty        : $(this).find('.txtADOQty').val(),
                        uom        : $(this).find('.txtADOUOM').val(),
                        shopName   : $(this).find('.txtADOShopName').val(),
                        city       : $(this).find('.txtADOCity').val()
                    })
                })
                return data
            }) (),
            updateLine : ( () => {
                let data = []
                $(dataTableADODetailList.rows('[data-type="update"]').nodes()).each( function () { 
                    data.push({
                        lineNumber : $(this).attr('data-line'),
                        doNumber   : $(this).find('.txtADODONumber').val(),
                        itemName   : $(this).find('.txtADOItemName').val(),
                        qty        : $(this).find('.txtADOQty').val(),
                        uom        : $(this).find('.txtADOUOM').val(),
                        shopName   : $(this).find('.txtADOShopName').val(),
                        city       : $(this).find('.txtADOCity').val()
                    })
                })
                return data
            }) (),
            deleteLine : ( () => {
                let data = []
                $(dataTableADODetailList.rows('[data-type="delete"]').nodes()).each( function () { 
                    data.push({
                        lineNumber : $(this).attr('data-line')
                    })
                })
                return data
            }) ()
        }
        let url      = `${baseurl}ApprovalDO/DPBKHS/saveUpdate`
        let question = 'Simpan Data Ini?'
        let success  = 'Berhasil Menyimpan Data'
        let fail     = 'Gagal Menyimpan Data'
        swalADOQuestionAjax(question, success, fail, url, data).then( (resp) => {
            if ( resp !== 'Cancelled' && resp !== 'Fail' ) {
                dataTableADODetailList.rows('[data-type="delete"]').remove().draw()
                dataTableADODetailList.rows('[data-type="new"]').attr('data-type', 'update')
            }
        })
    })

    $(document).on('click', '.btnADODeleteDPBKHS', function () {
        let data     = {
            prNumber : $(this).parents('tr').find('td:eq(1)').html()
        }
        let url      = `${baseurl}ApprovalDO/DPBKHS/delete`
        let question = `Hapus DO ini?`
        let success  = 'Berhasil Menghapus DO'
        let fail     = 'Gagal Menghapus DO'
        swalADOQuestionAjax(question, success, fail, url, data).then( (resp) => {
            if ( resp != 'Cancelled' && resp != 'Fail' ) {
                dataTableADOList.rows($(this).parents('tr')).remove().draw()
            }
        })
    })

    $('#txtADOSearchByCreationDate').datepicker({
        autoclose : true,
        format    : 'dd-M-yy'
    })

    $('#txtADOSearchByCreationDate').on('change', function () {
        dataTableADOList.columns(2).search($(this).val()).draw()
    })

    if ( window.location.href.indexOf('ApprovalDO/ListDO') > -1 ) {
        setTimeout( () => {
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