$(document).ready(function () {
    
    $(document).on('click', '.btnOKBNewOrderList', function(){
        $('.btnOKBNewOrderListDelete:first').removeAttr('disabled');
        let LastOrderList = $('.trOKBNewOrderListDataRow:last').clone(),
            LastDataRow   = Number($('.trOKBNewOrderListDataRow:last').attr('data-row'))

        var html = '<tr class="trOKBNewOrderListDataRow" data-row="'+(LastDataRow+1)+'">'+
                        '<td class="OKB-sticky-col" style="height:55px;">'+(LastDataRow+1)+'</td>'+
                        '<td class="text-center OKB-sticky-col2"> <select class="select2 slcOKBNewOrderList" name="slcOKBinputCode[]" required style="width:200px"></select> </td>'+
                        '<td class="OKB-sticky-col3"> <input class="form-control txtOKBNewOrderListItemName" name="txtOKBitemName[]" readonly> </td>'+
                        '<td class="OKB-sticky-col4"> <textarea style="height: 34px;" class="form-control txaOKBNewOrderDescription" name="txtOKBinputDescription[]" readonly></textarea> </td>'+
                        '<td> <input type="text" class="form-control txtOKBNewOrderListQty" name="txtOKBinputQty[]" required style="background-color: #fbfb5966;"> </td>'+
                        '<td class="text-center"> <select class="form-control select2 slcOKBNewUomList" name="slcOKBuom[]" required style="width:120px"></select> </td>'+
                        '<td> <input type="text" class="form-control leadtimeOKB" name="txtOKBLeadtime[]" id="" readonly> </td>'+
                        '<td> <input type="text" class="form-control nbdOKB" id="" name="txtOKBnbd[]" required style="background-color: #fbfb5966;"> </td>'+
                        '<td><input type="text" class="form-control txtDestLineOKB" placeholder="Click Here!" data-row="'+(LastDataRow+1)+'" required style="background-color: #fbfb5966;"></td>'+
                        '<td> <textarea style="height: 34px; background-color: #fbfb5966;" class="form-control txaOKBNewOrderListReason" name="txtOKBinputReason[]" required></textarea> </td>'+
                        '<td> <textarea style="height: 34px;" class="form-control txaOKBNewOrderListUrgentReason" name="txtOKBinputUrgentReason[]" required></textarea> </td>'+
                        '<td> <textarea style="height: 34px;" class="form-control txaOKBNewOrderListNote" name="txtOKBinputNote[]"></textarea> </td>'+
                        '<td><input type="file" name="fileOKBAttachment'+(LastDataRow+1)+'[]" multiple></td>'+
                        '<td class="text-center">'+
                            '<button type="button" class="btn btn-success btnOKBNewOrderListCancel" title="Batal">'+
                                '<i class="fa fa-refresh"></i>'+
                            '</button>&nbsp;'+
                            '<button type="button" class="btn btn-danger btnOKBNewOrderListDelete" title="Hapus">'+
                                '<i class="fa fa-trash"></i>'+
                            '</button>'+
                        '</td>'+
                        '<td style="display:none;"><input type="hidden" class=" hdnDestOKB" name="hdnDestinationOKB[]"></td>'+
                        '<td style="display:none;"><input type="hidden" class=" hdnOrgOKB" name="hdnOrganizationOKB[]"></td>'+
                        '<td style="display:none;"><input type="hidden" class=" hdnLocOKB" name="hdnLocationOKB[]"></td>'+
                        '<td style="display:none;"><input type="hidden" class=" hdnSubinvOKB" name="hdnSubinventoyOKB[]"></td>'+
                        '<td style="display:none;"><input type="hidden" class="hdUrgentFlagOKB" name="hdnUrgentFlagOKB[]"></td>'+
                        '<td style="display:none;"><input type="hidden" class="hdnItemCodeOKB" name="hdnItemCodeOKB[]"></td>'+
                    '</tr>';
            
        var modal ='<div class="modal fade" id="modal-destination-okb" data-row="'+(LastDataRow+1)+'">'+
                        '<div class="modal-dialog" style="width: 470px;">'+
                            '<div class="modal-content">'+
                                '<div class="modal-header" style="background-color: #337AB7; color:#FFF;">'+
                                    '<h4 class="modal-title text-center">Destination Line</h4>'+
                                '</div>'+
                                '<div class="modal-body">'+
                                    '<form class="form-horizontal">'+
                                        '<div class="box-body">'+
                                            '<div class="form-group">'+
                                                '<label class="col-sm-4 control-label">Destination Type :</label>'+
                                                '<div class="loadingDestinationOKB" style="display: none;width:100%;margin-top: 0px;margin-bottom: 20px" data-row="'+(LastDataRow+1)+'">'+
                                                    '<img style="width:50px" src="' + baseurl + 'assets/img/gif/loading5.gif"/>'+
                                                '</div>'+
                                                '<div class="col-sm-8 dest_typeOKB" data-row="'+(LastDataRow+1)+'" style="display: block;">'+
                                                    '<input type="text" class="form-control text-center destinationOKB" id="txtModalDestination" style="width: 250px;" title="Destination Type" data-row="'+(LastDataRow+1)+'" readonly>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="form-group">'+
                                                '<label class="col-sm-4 control-label">Organization :</label>'+
                                                '<div class="loadingOrganizationOKB" data-row="'+(LastDataRow+1)+'" style="display: none; width:100%;margin-top: 0px;margin-bottom: 20px">'+
                                                    '<img style="width:50px" src="' + baseurl + 'assets/img/gif/loading5.gif"/>'+
                                                '</div>'+
                                                '<div class="col-sm-8 viewOrganizationOKB"  style="display: block;" data-row="'+(LastDataRow+1)+'">'+
                                                    '<select class="select2 organizationOKB" id="slcModalOrganization" style="width: 250px;" name="slcOrganization" title="Organization" data-row="'+(LastDataRow+1)+'"><option></option></select>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="form-group">'+
                                                '<label class="col-sm-4 control-label">Location :</label>'+
                                                '<div class="loadingLocationOKB" style="display: none; width:100%;margin-top: 0px;margin-bottom: 20px" data-row="'+(LastDataRow+1)+'">'+
                                                    '<img style="width:50px" src="' + baseurl + 'assets/img/gif/loading5.gif"/>'+
                                                '</div>'+
                                                '<div class="col-sm-8 viewLocationOKB" data-row="'+(LastDataRow+1)+'">'+
                                                    '<select class="select2 locationOKB" id="slcLocation" style="width: 250px;" name="slcLocation" title="Location" data-row="'+(LastDataRow+1)+'">'+
                                                        '<option></option>'+
                                                    '</select>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="form-group">'+
                                                '<label class="col-sm-4 control-label">Subinventory :</label>'+
                                                '<div class="loadingSubinventoryOKB" style="display: none; width:100%;margin-top: 0px;margin-bottom: 20px" data-row="'+(LastDataRow+1)+'">'+
                                                    '<img style="width:50px" src="' + baseurl + 'assets/img/gif/loading5.gif"/>'+
                                                '</div>'+
                                                '<div class="col-sm-8 viewSubinventoryOKB" data-row="'+(LastDataRow+1)+'">'+
                                                    '<select class="select2 subinventoryOKB" id="slcSubinventory" data-row="'+(LastDataRow+1)+'" style="width: 250px;" name="slcSubinventory" ><option></option></select>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</form>'+
                                '</div>'+
                                '<div class="modal-footer">'+
                                    '<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>';

        $('.trOKBNewOrderListDataRow').parent().append(html)
        $('.btnOKBNewOrderListDelete:last').removeAttr('disabled');
        $('.mdlTambahDestOKB').append(modal);
        // $('.trOKBNewOrderListDataRow:last').attr('data-row', (LastDataRow+1))
        // $('.trOKBNewOrderListDataRow:last').children(':first').html(LastDataRow+1)
        
        $('.slcOKBNewOrderList').select2({
            ajax: {
                url: baseurl + 'OrderKebutuhanBarangDanJasa/Requisition/searchItem',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.INVENTORY_ITEM_ID,
                                text: item.SEGMENT1 + ' | ' + item.DESCRIPTION,
                                title: item.DESCRIPTION,
                                uom1: item.PRIMARY_UOM,
                                uom2: item.SECONDARY_UOM,
                                leadtime : item.LEAD_TIME,
                                allow_desc : item.ALLOW_DESC,
                                txt : item.SEGMENT1,
                            }
                        })
                    };
                },
                cache: true,
            },
            minimumInputLength: 4,
            placeholder: 'Kode / deskripsi barang',
        })

        $('.nbdOKB').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'dd-M-yyyy'
        });
        
        $('.slcOKBNewUomList').select2();
        $('.organizationOKB').select2();
        $('.locationOKB').select2();
        $('.subinventoryOKB').select2();
    })

    $(document).on('click', '.btnAddUser', function () {
        $('.btnOKBNewUserDelete:first').removeAttr('disabled');
        let LastUserList = $('.trOKBNewSetupUserDataRow:last').clone(),
            LastDataRowUser   = Number($('.trOKBNewSetupUserDataRow:last').attr('data-row'))

        var html = '<tr class="trOKBNewSetupUserDataRow" data-row="'+(LastDataRowUser+1)+'">'+
                        '<td><select class="select2 slcAtasanOKB" style="width:200px" name="slcAtasanOKB[]" required></td>'+
                        '<td><select class="select2 slcAtasanOKB okbSFA1" jenis="1" style="width:200px" name="slcAtasanUnit1OKB[]" required></td>'+
                        '<td><select class="select2 slcAtasanOKB" style="width:200px" name="slcAtasanUnit2OKB[]"></td>'+
                        '<td><select class="select2 slcAtasanOKB" style="width:200px" name="slcAtasanDepartmentOKB[]" required></td>'+
                        // '<td><input type="text" class="form-control" name="" value="Hendro Wijayanto" readonly></td>'+
                        '<td><button type="button" class="btn btn-danger btnOKBNewUserDelete" title="Hapus"><i class="fa fa-trash"></i></button></td>'+
                    '</tr>';
        
        $('.trOKBNewSetupUserDataRow').parent().append(html);

        $('.slcAtasanOKB').select2({
            ajax: {
                url: baseurl + 'OrderKebutuhanBarangDanJasa/Requisition/searchAtasan',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.PERSON_ID,
                                text: item.FULL_NAME,
                                title: item.FULL_NAME
                            }
                        })
                    };
                },
                cache: true,
            },
            minimumInputLength: 4,
            placeholder: 'Search Name',
        })
    })
    
    $('.mdlOKBStatusOrder').modal('show');

    $('.btnOKBChangeStatusOrder').on('click', function () {
        $('.mdlOKBStatusOrder').modal('show');
    })

    $('.btnOKBStatusOrderNormal').on('click', function () {
        $('#txtOKBStatusOrder').val('NORMAL');
        $('#txtOKBHdnStatusOrder').val('N');
        $('.bright-warning').children().attr('class', 'fa fa-fw fa-check');
        $('.bright-warning').attr('class', 'input-group-addon bright-success');
    });

    $('.btnOKBStatusOrderFollowUp').on('click', function () {
        $('#txtOKBStatusOrder').val('SUSULAN');
        $('#txtOKBHdnStatusOrder').val('Y');
        $('.bright-success').children().attr('class', 'fa fa-warning');
        $('.bright-success').attr('class', 'input-group-addon bright-warning');
    });

    $('.slcOKBNewOrderList').select2({
        ajax: {
            url: baseurl + 'OrderKebutuhanBarangDanJasa/Requisition/searchItem',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term,
                };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            id: item.INVENTORY_ITEM_ID,
                            text: item.SEGMENT1 + ' | ' + item.DESCRIPTION,
                            title: item.DESCRIPTION,
                            uom1: item.PRIMARY_UOM,
                            uom2: item.SECONDARY_UOM,
                            leadtime : item.LEAD_TIME,
                            allow_desc : item.ALLOW_DESC,
                            txt : item.SEGMENT1,
                        }
                    })
                };
            },
            cache: true,
        },
        minimumInputLength: 4,
        placeholder: 'Kode / deskripsi barang',
    })

    $('.slcAtasanOKB').select2({
        ajax: {
            url: baseurl + 'OrderKebutuhanBarangDanJasa/Requisition/searchAtasan',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term,
                };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            id: item.PERSON_ID,
                            text: item.FULL_NAME,
                            title: item.FULL_NAME
                        }
                    })
                };
            },
            cache: true,
        },
        minimumInputLength: 4,
        placeholder: 'Search Name',
    })

    ////Bondan Start///
    
    $('.checkBoxConfirmOrderOkebaja').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_flat-blue'
    });

    $('.checkAllApproveOKB').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_flat-blue'
    });

    $('.checkApproveOKB').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_flat-blue'
    });

    $('.checkBoxConfirmOrderOkebaja').on('ifChecked ifUnchecked', function(event) {
        if (event.type == 'ifChecked') {
            $('.btnBuatOrderOkebaja').removeAttr('disabled');
        } else {
            $('.btnBuatOrderOkebaja').attr('disabled','disabled');
        }
    });

    
    $('.nbdOKB').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'dd-M-yyyy'
    });
    
    $('.tblOKBOrderListPengorder').DataTable({
        scrollY: "370px",
        scrollX: true,
        scrollCollapse: true,
        fixedColumns:   {
            leftColumns: 5
        }
    });
    
    $('.tblOKBReleasedOrderList').DataTable({
        scrollX: true,
        scrollCollapse: true,
    });
    
    var tableOKB = $('.tblOKBOrderList').DataTable({
        scrollY: "370px",
        // fixedColumns:   {
        //     leftColumns: 5
        // },
        scrollX: true,
        scrollCollapse: true,
        columnDefs: [ {
            "targets": 0,
            "orderable": false
        } ],
        order: [[1, 'asc']],
    });
    $('.checkAllApproveOKB').on('ifChecked ifUnchecked', function(event) {
        if (event.type == 'ifChecked') {
            $('.checkApproveOKB').iCheck('check');
            // alert('benith my skins');
        } else {
            $('.checkApproveOKB').iCheck('uncheck');
        }
                                                    
        $('.checkApproveOKB').on('ifChanged', function(event) {
            if ($('.checkApproveOKB').filter(':checked').length == $('.checkApproveOKB').length) {
                // alert('benith my skins');
                $('.checkAllApproveOKB').prop('checked', 'checked');
            } else {
                $('.checkAllApproveOKB').prop('checked', false);
            }
                $('.checkAllApproveOKB').iCheck('update');
            });
    });

    $(document).on('click', '.btnOKBListOrderHistory', function () {
        let orderid = $(this).parentsUntil('tbody').find('.tdOKBListOrderId').html()        
        $('.mdlOKBListOrderHistory-'+orderid).modal('show');
        if ( $('.divOKBListOrderHistory-'+orderid).find('span:first').html() == '' ) {
            $('.divOKBListOrderHistoryLoading-'+orderid).fadeIn();
            $.ajax({
                type: "post",
                url: baseurl+"OrderKebutuhanBarangDanJasa/Requisition/getHistoryOrder",
                data: {orderid: orderid},
                dataType: "json",
                success: function (resp) {
                    $('.divOKBListOrderHistoryLoading-'+orderid).hide();
                    $('.divOKBListOrderHistory-'+orderid).fadeIn();
                    $(resp).each( function ( index, value ) {
                        console.log(value)
                        if ( value.JUDGEMENT == 'A' ) {
                            var order_class = 'approved',
                                status      = 'Order Approved',
                                icon_class  = 'fa fa-check',
                                date        = '['+value.JUDGEMENT_DATE+'] - ';                                
                                if ( value.NATIONAL_IDENTIFIER == $('#txtOKBOrderRequestorId').val() ) {
                                    var explain = 'Anda telah memberi keputusan Approved pada order ini.';
                                } else {
                                    var explain = value.FULL_NAME+' telah memberi keputusan Approved pada order ini.';
                                }
                        } else if ( value.JUDGEMENT == 'R' ) {
                            var order_class = 'rejected',
                                status      = 'Order Rejected',
                                icon_class  = 'fa fa-times-circle-o',
                                date        = '['+value.JUDGEMENT_DATE+'] - ';
                                if ( value.NATIONAL_IDENTIFIER == $('#txtOKBOrderRequestorId').val() ) {
                                    var explain = 'Anda telah memberi keputusan Rejected pada order ini dengan alasan '+value.NOTE+'.';
                                } else {
                                    var explain = value.FULL_NAME+' telah memberi keputusan Rejected pada order ini dengan alasan '+value.NOTE+'.';
                                }                                
                        } else {
                            var order_class = 'waiting',
                                status      = 'Sedang Menunggu Keputusan',
                                icon_class  = 'fa fa-clock-o',
                                date        = '';
                                if ( value.NATIONAL_IDENTIFIER == $('#txtOKBOrderRequestorId').val() ) {
                                    var explain = 'Approval order ini menunggu keputusan anda.';
                                } else {
                                    var explain = 'Approval order ini sedang diproses oleh '+value.FULL_NAME+'.';
                                }
                        }
                        if ( index == 0 ) {
                            $('.divOKBListOrderHistory-'+orderid).find('span:first').append(
                                '<p>\
                                    <b>'+date+'</b>\
                                    <span class="'+order_class+'"><label class="control-label"><i class="'+icon_class+'"></i><b> '+status+' </b></label> - '+explain+' </span>\
                                </p>'
                            );
                        } else if ( index > 0 && resp[index-1].JUDGEMENT != null && resp[index-1].JUDGEMENT != 'R' ) {
                            $('.divOKBListOrderHistory-'+orderid).find('span:first').append(
                                '<p>\
                                    <b>'+date+'</b>\
                                    <span class="'+order_class+'"><label class="control-label"><i class="'+icon_class+'"></i><b> '+status+' </b></label> - '+explain+' </span>\
                                </p>'
                            );
                        }
                    })
                }
            });
        }   
    });

    $(document).on('click', '.btnOKBListRequisitionHistory', function () {
        let orderid = $(this).parentsUntil('tbody').find('.tdOKBListOrderId').html()        
        // alert(orderid)
        $('.mdlOKBListRequisitionHistory-'+orderid).modal('show');
        if ( $('.divOKBListRequisitionHistory-'+orderid).find('span:first').html() == '' ) {
            $('.divOKBListRequisitionHistoryLoading-'+orderid).fadeIn();
            $.ajax({
                type: "post",
                url: baseurl+"OrderKebutuhanBarangDanJasa/Pengelola/getHistoryRequisition",
                data: {pre_req_id: orderid},
                dataType: "json",
                success: function (resp) {
                    $('.divOKBListRequisitionHistoryLoading-'+orderid).hide();
                    $('.divOKBListRequisitionHistory-'+orderid).fadeIn();
                    $(resp).each( function ( index, value ) {
                        console.log(value)
                        if ( value.JUDGEMENT == 'A' ) {
                            var order_class = 'approved',
                                status      = 'Order Approved',
                                icon_class  = 'fa fa-check',
                                date        = '['+value.JUDGEMENT_DATE+'] - ';                                
                                if ( value.NATIONAL_IDENTIFIER == $('#txtOKBOrderRequestorId').val() ) {
                                    var explain = 'Anda telah memberi keputusan Approved pada order ini.';
                                } else {
                                    var explain = value.FULL_NAME+' telah memberi keputusan Approved pada order ini.';
                                }
                        } else if ( value.JUDGEMENT == 'R' ) {
                            var order_class = 'rejected',
                                status      = 'Order Rejected',
                                icon_class  = 'fa fa-times-circle-o',
                                date        = '['+value.JUDGEMENT_DATE+'] - ';
                                if ( value.NATIONAL_IDENTIFIER == $('#txtOKBOrderRequestorId').val() ) {
                                    var explain = 'Anda telah memberi keputusan Rejected pada order ini dengan alasan '+value.NOTE+'.';
                                } else {
                                    var explain = value.FULL_NAME+' telah memberi keputusan Rejected pada order ini dengan alasan '+value.NOTE+'.';
                                }                                
                        } else {
                            var order_class = 'waiting',
                                status      = 'Sedang Menunggu Keputusan',
                                icon_class  = 'fa fa-clock-o',
                                date        = '';
                                if ( value.NATIONAL_IDENTIFIER == $('#txtOKBOrderRequestorId').val() ) {
                                    var explain = 'Approval order ini menunggu keputusan anda.';
                                } else {
                                    var explain = 'Approval order ini sedang diproses oleh '+value.FULL_NAME+'.';
                                }
                        }
                        if ( index == 0 ) {
                            $('.divOKBListRequisitionHistory-'+orderid).find('span:first').append(
                                '<p>\
                                    <b>'+date+'</b>\
                                    <span class="'+order_class+'"><label class="control-label"><i class="'+icon_class+'"></i><b> '+status+' </b></label> - '+explain+' </span>\
                                </p>'
                            );
                        } else if ( index > 0 && resp[index-1].JUDGEMENT != null && resp[index-1].JUDGEMENT != 'R' ) {
                            $('.divOKBListRequisitionHistory-'+orderid).find('span:first').append(
                                '<p>\
                                    <b>'+date+'</b>\
                                    <span class="'+order_class+'"><label class="control-label"><i class="'+icon_class+'"></i><b> '+status+' </b></label> - '+explain+' </span>\
                                </p>'
                            );
                        }
                    })
                }
            });
        }   
    });

    
    $('.slcTindakanOKB').select2({
        placeholder: '--tindakan untuk semua yang ditandai--'
    });


    $('.slcOKBNewUomList').select2();

    $('.slcApproverUnitOKB').select2();

    $('.organizationOKB').select2();
    $('.locationOKB').select2();
    $('.subinventoryOKB').select2();

    // get all value 
    // console.log($('.orderidOKB').map((_,el) => el.value).get());

    ///Bondan End////
      
    $(document)
        .on('change','.slcOKBNewOrderList', function(){
            let ItemName = $(this).select2('data')[0]['title'];
            var itemkode = $(this).select2('data')[0]['txt'];

            $(this).parentsUntil('tbody').find('.txtOKBNewOrderListItemName').val(ItemName);
            
            ////bondan start/////
            leadtime = $(this).select2('data')[0]['leadtime'];
            allow_desc = $(this).select2('data')[0]['allow_desc'];
            // alert(leadtime)
            $(this).parentsUntil('tbody').find('.leadtimeOKB').val(leadtime);
            primary_uom = $(this).select2('data')[0]['uom1'];
            secondary_uom = $(this).select2('data')[0]['uom2'];
            

            var desc = $(this).parentsUntil('tbody').find('.txaOKBNewOrderDescription');
            if (allow_desc == 'Y') {
                desc.removeAttr('readonly');
                desc.attr('required','required');
                desc.attr({
                    style: 'height: 34px; background-color :#fbfb5966;'
                });
            }else if(allow_desc == 'N'){
                desc.val(ItemName);
            }

            // console.log(primary_uom);

            var html = '<option value="'+primary_uom+'" selected>'+primary_uom+'</option>';
            if (secondary_uom != null && secondary_uom!='') {
                html += '<option value="'+secondary_uom+'">'+secondary_uom+'</option>';
            }

            $(this).parentsUntil('tbody').find('.slcOKBNewUomList').html(html);
            $(this).parentsUntil('tbody').find('.slcOKBNewUomList').val(primary_uom).trigger('change.select2');

            $(this).parentsUntil('tbody').find('.hdnItemCodeOKB').val(itemkode+' - '+ItemName);
            ////bondan end/////
        })
        .on('click', '.btnOKBNewOrderListCancel', function(){
            $(this).parentsUntil('tbody').find('input, textarea').val('')
            $(this).parentsUntil('tbody').find('select').val('').trigger('change.select2');
        })
        .on('click', '.btnOKBNewOrderListDelete', function(){
            var count = $('.trOKBNewOrderListDataRow').length;
            // alert(count);
            $(this).parentsUntil('tbody').remove();

            if (count == 2) {
                $('.btnOKBNewOrderListDelete').attr('disabled','disabled')
            }
        })
        .on('click', '.btnOKBNewUserDelete', function(){
            var count = $('.trOKBNewSetupUserDataRow').length;
            // alert(count);
            $(this).parentsUntil('tbody').remove();

            if (count == 2) {
                $('.btnOKBNewUserDelete').attr('disabled','disabled')
            }
        })
        ///Bondan Start/////
        .on('input','.txtOKBNewOrderListQty', function(event) {

            var value_input = $(this).val();
            var value_split = value_input.split(".");
            var hasil = value_split[0].replace(/\D/g, '').toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
    
            if (value_split.length > 1) {
                return $(this).val(hasil + '.' + value_split[1].slice(0, 1));
            } else if (value_split.length <= 1) {
                return $(this).val(hasil);
            }
    
        })

        .on('click','.btnOKBApproverAct', function () {
            var checkbox = $('.checkApproveOKB').filter(':checked');
            var judgement = $('.slcOKBTindakanApprover').val();
            var person_id = $('.txtOKBPerson_id').val();


            if (judgement =='') {
                Swal.fire({
                    type: 'error',
                    title: 'Gagal',
                    text: 'Anda belum memilih tindakan !',
                });
            } else if (checkbox.length == 0) {
                Swal.fire({
                    type: 'error',
                    title: 'Gagal',
                    text: 'Anda belum memilih order !',
                });
            } else if (judgement == 'R') {

                ( async function () {
                        let { value: reason, dismiss } = await Swal.fire({
                            text: 'Silahkan berikan alasan anda .',
                            input: 'textarea',
                            inputPlaceholder: 'Alasan anda...',
                            inputAttributes: {
                                'aria-label': 'Alasan anda...'
                            },
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ok',
                            showCloseButton: true
                        });
                        
                        if ( dismiss != 'close' ) {
                            if ( reason == null || reason == '' ) {
                                Swal.fire({
                                    customClass: 'swal-font-large',
                                    type: 'error',
                                    title: 'Gagal',
                                    text: 'Alasan tidak boleh kosong!',
                                });
                            } else {
                                $('.btnOKBApproverAct').attr('disabled','disabled');
                                $('.imgOKBLoading').fadeIn();
                                var orderid = new Array();
                                if (checkbox) {
                                    $(checkbox).each(function () {
                                        var order_id = $(this).val();
                                        orderid.push(order_id);
                                    })
                                };
                                $.ajax({
                                    type: "POST",
                                    url: baseurl + 'OrderKebutuhanBarangDanJasa/Approver/ApproveOrder',
                                    data: {
                                            orderid : orderid,
                                            judgment : judgement,
                                            person_id : person_id,
                                            note : reason
                                        },
                                    success: function (response) {
                                        if (response == 1) {
                                            Swal.fire({
                                                type: 'success',
                                                title: 'Berhasil',
                                                text: 'Order berhasil di reject',
                                            })
                                            tableOKB.rows(checkbox.parentsUntil('tbody')).remove().draw();
                                            // checkbox.parentsUntil('tbody').remove();
                                            $('#modalReasonRejectOrderOKB').modal('hide');
                                        } else {
                                            Swal.fire({
                                                type: 'error',
                                                title: 'Gagal',
                                                text: 'Order gagal di reject',
                                            })
                                        };                
                                        $('.imgOKBLoading').fadeOut();            
                                        $('.btnOKBApproverAct').removeAttr('disabled');
                                        // $('.tblOKBOrderList').DataTable().draw();
                                    }
                                });
                            };
                        };
                    }) ();
            } else {
                $('.btnOKBApproverAct').attr('disabled','disabled');
                $('.imgOKBLoading').fadeIn();
                var orderid = new Array();
                if (checkbox) {
                    $(checkbox).each(function () {
                        var order_id = $(this).val();
                        orderid.push(order_id);
                      })
                };
                $.ajax({
                    type: "POST",
                    url: baseurl + 'OrderKebutuhanBarangDanJasa/Approver/ApproveOrder',
                    data: {
                            orderid : orderid,
                            judgment : judgement,
                            person_id : person_id
                        },
                    success: function (response) {
                        if (response == 1) {
                            Swal.fire({
                                type: 'success',
                                title: 'Berhasil',
                                text: 'Order berhasil di approve',
                            });
                            tableOKB.rows(checkbox.parentsUntil('tbody')).remove().draw();
                            // checkbox.parentsUntil('tbody').remove();
                        } else {
                            Swal.fire({
                                type: 'error',
                                title: 'Gagal',
                                text: 'Order gagal di approve',
                            });
                        };
                        $('.imgOKBLoading').fadeOut();
                        $('.btnOKBApproverAct').removeAttr('disabled');
                    }
                });
            }
        })
        
        // TODO:
        .on('click','.btnOKBPengelolaAct', function () {

            var pengelola = $('.txtOKBPerson_id').val();
            var checkbox = $('.checkApproveOKB').filter(':checked');
            var orderClass = $('.slcOKBTindakanPengelola').val();

            if (orderClass =='') {
                Swal.fire({
                    type: 'error',
                    title: 'Gagal',
                    text: 'Anda belum memilih tindakan !',
                });
            } else if (checkbox.length == 0) {
                Swal.fire({
                    type: 'error',
                    title: 'Gagal',
                    text: 'Anda belum memilih order !',
                });
            } else if (orderClass == 'R') {
                ( async function () {
                    let { value: reason, dismiss } = await Swal.fire({
                        text: 'Silahkan berikan alasan anda .',
                        input: 'textarea',
                        inputPlaceholder: 'Alasan anda...',
                        inputAttributes: {
                            'aria-label': 'Alasan anda...'
                        },
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ok',
                        showCloseButton: true
                    });
                    
                    if ( dismiss != 'close' ) {
                        if ( reason == null || reason == '' ) {
                            Swal.fire({
                                customClass: 'swal-font-large',
                                type: 'error',
                                title: 'Gagal',
                                text: 'Alasan tidak boleh kosong!',
                            });
                        } else {
                            $('.btnOKBPengelolaAct').attr('disabled','disabled');
                            $('.imgOKBLoading').fadeIn();
                            var orderid = new Array();
                            if (checkbox) {
                                $(checkbox).each(function () {
                                    var order_id = $(this).val();
                                    orderid.push(order_id);
                                })
                            };
                            
                            $.ajax({
                                type: "POST",
                                url: baseurl + 'OrderKebutuhanBarangDanJasa/Approver/ApproveOrder',
                                data: {
                                        orderid : orderid,
                                        judgment : orderClass,
                                        person_id : pengelola,
                                        note : reason
                                    },
                                success: function (response) {
                                    if (response == 1) {
                                        Swal.fire({
                                            type: 'success',
                                            title: 'Berhasil',
                                            text: 'Order berhasil di reject',
                                        })
                                        tableOKB.rows(checkbox.parentsUntil('tbody')).remove().draw();
                                        // checkbox.parentsUntil('tbody').remove();
                                    } else {
                                        Swal.fire({
                                            type: 'error',
                                            title: 'Gagal',
                                            text: 'Order gagal di reject',
                                        })
                                    };                
                                    $('.imgOKBLoading').fadeOut();            
                                    $('.btnOKBPengelolaAct').removeAttr('disabled');
                                    $('.btnOKBApproverAct').removeAttr('disabled');
                                }
                            });
                        };
                    };
                }) (); 
            } else if (orderClass == '1') {
                // ( async function () {
                //     let { value: note, dismiss } = await Swal.fire({
                //         text: 'Silahkan berikan note to buyer .',
                //         input: 'textarea',
                //         inputPlaceholder: 'Catatan anda...',
                //         inputAttributes: {
                //             'aria-label': 'Catatan anda...'
                //         },
                //         confirmButtonColor: '#3085d6',
                //         cancelButtonColor: '#d33',
                //         confirmButtonText: 'Ok',
                //         showCloseButton: true
                //     });
                    
                    // if ( dismiss != 'close' ) {
                        // if ( note == null || note == '' ) {
                        //     Swal.fire({
                        //         customClass: 'swal-font-large',
                        //         type: 'error',
                        //         title: 'Gagal',
                        //         text: 'Catatan tidak boleh kosong!',
                        //     });
                        // } else {
                            $('.btnOKBPengelolaAct').attr('disabled','disabled');
                            $('.imgOKBLoading').fadeIn();
                            var orderid = new Array();
                            if (checkbox) {
                                $(checkbox).each(function () {
                                    var order_id = $(this).val();
                                    var notes = $(this).parentsUntil('tbody').find('.noteBuyerOKB').val();
                                    var orderDanNote = order_id + '-' + notes;
                                    orderid.push(orderDanNote);
                                })
                            };
                            console.log(orderid)
                            $.ajax({
                                type: "POST",
                                url: baseurl + 'OrderKebutuhanBarangDanJasa/Pengelola/TindakanPengelola2',
                                data: {
                                        orderid : orderid,
                                        orderClass : orderClass,
                                        person_id : pengelola,
                                        // note : note
                                    },
                                success: function (response) {
                                    if (response == 1) {
                                        Swal.fire({
                                            type: 'success',
                                            title: 'Berhasil',
                                            text: 'Order berhasil di approve',
                                        })
                                        tableOKB.rows(checkbox.parentsUntil('tbody')).remove().draw();
                                        // checkbox.parentsUntil('tbody').remove();
                                        $('#modalReasonRejectOrderOKB').modal('hide');
                                    } else {
                                        Swal.fire({
                                            type: 'error',
                                            title: 'Gagal',
                                            text: 'Order gagal di approve',
                                        })
                                    }                 
                                    $('.imgOKBLoading').fadeOut();            
                                    $('.btnOKBPengelolaAct').removeAttr('disabled');

                                }
                            });
                        // };
                    // };
                // }) (); 
            } else {
                var orderid = new Array();
                if (checkbox) {
                    $(checkbox).each(function () {
                        var order_id = $(this).val();
                        orderid.push(order_id);
                      })
                };
                // console.log(orderid);
                $('.btnOKBPengelolaAct').attr('disabled','disabled');
                $('.imgOKBLoading').fadeIn();
                $.ajax({
                    type: "POST",
                    url: baseurl +'OrderKebutuhanBarangDanJasa/Pengelola/TindakanPengelola',
                    data: {
                        orderid : orderid,
                        orderClass: orderClass,
                        person_id : pengelola                        
                    },
                    success: function (response) {
                        if (response == 1) {
                            Swal.fire({
                                type: 'success',
                                title: 'Berhasil',
                                text: 'Order berhasil di approve',
                            })
                            tableOKB.rows(checkbox.parentsUntil('tbody')).remove().draw();
                            checkbox.parentsUntil('tbody').remove();
                            $('#modalReasonRejectOrderOKB').modal('hide');
                        } else {
                            Swal.fire({
                                type: 'error',
                                title: 'Gagal',
                                text: 'Order gagal di approve',
                            })
                        }                
                        $('.imgOKBLoading').fadeOut();            
                        $('.btnOKBPengelolaAct').removeAttr('disabled');
                    }
                });
            };
        })

        .on('click','.btnOKBPengelolaBeliAct', function () {
            
            var checkbox = $('.checkApproveOKB').filter(':checked');
            var pengelolaAct = $('.slcOKBTindakanPengelolaBeli').val();
           
            if ( pengelolaAct == 1 ) {

                ( async function () {
                    let { value: reason } = await Swal.fire({
                        title: 'Note To Agent',
                                confirmButtonText: 'Process',
                                html:
                                    '<div class="form-group">\
                                        <label class="pull-left">Note to Agent</label>\
                                        <textarea class="form-control" id="txaNoteToAgentOKB" rows="3" placeholder="Please Insert Note to Agent ..." style="max-width: 525px;"></textarea>\
                                        </div>' + 
                                    '<div class="form-group">\
                                        <label class="pull-left">Need By Date</label>\
                                        <input type="text" class="form-control" id="txtNeedByDateOKB" placeholder="Please Insert Need By Date ..." value="">\
                                        </div>'+
                                    '<div class="form-group">\
                                        <label class="pull-left">Item Description</label>\
                                        <div class="form-group">\
                                        <textarea class="form-control" id="txaItemDescPengelolaOKB" rows="3" placeholder="Please Insert Item Description ..." style="max-width: 525px;"></textarea>\
                                        </div>',
                                focusConfirm: false,
                        preConfirm: function () {
                        return {
                            noteToAgent     : $('#txaNoteToAgentOKB').val(),
                            needByDate      : $('#txtNeedByDateOKB').datepicker({ dateFormat: 'yy-mm-dd' }).val(),
                            itemDescription : $('#txaItemDescPengelolaOKB').val()
                        }
                      }
                    });

                    if ( reason ) {
                        var noteToAgent = reason.noteToAgent,
                            nbd         = reason.needByDate,
                            itemDesc    = reason.itemDescription
                            
                        $('.imgOKBLoading').fadeIn();
                        $('.btnCreatePRPengelolaOKB').attr('disabled','disabled');
                        $('.btnOKBPengelolaBeliAct').attr('disabled','disabled');

                        if (checkbox) {
                            var totalQty = 0;
                            var statusItem = "";
                            var orderid = new Array();
                            var itemkode1= "";
                            // var itemkode = "";
                            var uom = "";
                            var dest1 = "";
                            var org1 = "";
                            var loc1 = "";

                            $(checkbox).each(function (i, value) {
                                var order_id = $(this).val();
                                orderid.push(order_id);
                                var qty = $(this).attr('quantity');
                                totalQty += Number(qty);
                                uom = $(this).attr('uom');

                                if (i == 0) {
                                    var itemkode = $(this).attr('itemKode');
                                    itemkode1 = itemkode;
                                    dest1 = $(this).attr('dest');
                                    org1 = $(this).attr('org');
                                    loc1 = $(this).attr('loc');
                                } else {
                                    itemkode = $(this).attr('itemKode');
                                    dest = $(this).attr('dest');
                                    org = $(this).attr('org');
                                    loc = $(this).attr('loc');
                                    if (itemkode != itemkode1 && dest != dest1 && org != org1 && loc != loc1) {
                                        statusItem = 2;
                                    }
                                }
                            });

                            if (statusItem == 2) {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Gagal',
                                    text: 'Tidak boleh karena item berbeda',
                                })
                            } else {
                                $.ajax({
                                    type: "POST",
                                    url: baseurl+"OrderKebutuhanBarangDanJasa/Pengelola/PengelolaCreatePR",
                                    data: {
                                        orderid: orderid,
                                        itemkode: itemkode1,
                                        nbd: nbd,
                                        quantity: totalQty,
                                        uom: uom,
                                        note: noteToAgent,
                                        desc: itemDesc,
                                        dest: dest1,
                                        org: org1,
                                        loc: loc1
                                    },
                                    success: function (response) {
                                        if (response == 1) {
                                            Swal.fire({
                                                type: 'success',
                                                title: 'Berhasil',
                                                text: 'Order berhasil di buat PR',
                                            })
                                            checkbox.parentsUntil('tbody').remove();
                                            $('.slcTindakanOKB').val('').trigger('change.select2');
                                        } else {
                                            Swal.fire({
                                                type: 'error',
                                                title: 'Gagal',
                                                text: 'Order gagal di buat PR',
                                            })
                                        }                                        
                                        $('.btnCreatePRPengelolaOKB').removeAttr('disabled');
                                        $('.btnOKBPengelolaBeliAct').removeAttr('disabled');
                                        $('.imgOKBLoading').fadeOut();
                                    }
                                });
                            }
                        }
                    }

                }) ();
                
                $('#txtNeedByDateOKB').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'dd-M-yyyy'
                });

            }
        })

        .on('click','.btnOKBApproverPRAct', function () {
            var checkbox = $('.checkApproveOKB').filter(':checked');
            var judgement = $('.slcOKBTindakanApproverPR').val();
            var person_id = $('.txtOKBPerson_id').val();

            // alert(checkbox.length);

            if (judgement =='') {
                Swal.fire({
                    type: 'error',
                    title: 'Gagal',
                    text: 'Anda belum memilih tindakan !',
                });
            } else if (checkbox.length == 0) {
                Swal.fire({
                    type: 'error',
                    title: 'Gagal',
                    text: 'Anda belum memilih order !',
                });
            } else if (judgement == 'R') {
                ( async function () {
                    let { value: reason, dismiss } = await Swal.fire({
                        text: 'Silahkan berikan alasan anda .',
                        input: 'textarea',
                        inputPlaceholder: 'Alasan anda...',
                        inputAttributes: {
                            'aria-label': 'Alasan anda...'
                        },
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ok',
                        showCloseButton: true
                    });
                    if ( dismiss != 'close' ) {
                        if ( reason == null || reason == '' ) {
                            Swal.fire({
                                customClass: 'swal-font-large',
                                type: 'error',
                                title: 'Gagal',
                                text: 'Alasan tidak boleh kosong!',
                            });
                        } else {
                            $('.btnOKBApproverPRAct').attr('disabled','disabled');
                            $('.imgOKBLoading').fadeIn();
                            var pre_reqid = new Array();
                            if (checkbox) {
                                $(checkbox).each(function () {
                                    var pre_req_id = $(this).val();
                                    pre_reqid.push(pre_req_id);
                                })
                            }     
                            $.ajax({
                                type: "POST",
                                url: baseurl + 'OrderKebutuhanBarangDanJasa/Approver/ApproveOrderPR',
                                data: {
                                        pre_reqid : pre_reqid,
                                        judgment : judgement,
                                        person_id : person_id,
                                        note : reason
                                    },
                                success: function (response) {
                                    if (response == 1) {
                                        Swal.fire({
                                            type: 'success',
                                            title: 'Berhasil',
                                            text: 'Order berhasil di reject',
                                        })
                                        checkbox.parentsUntil('tbody').remove();
                                    } else {
                                        Swal.fire({
                                            type: 'error',
                                            title: 'Gagal',
                                            text: 'Order gagal di reject',
                                        })
                                    }                
                                    $('.imgOKBLoading').fadeOut();            
                                    $('.btnOKBApproverPRAct').removeAttr('disabled');
                                }
                            });
                        }
                    }
                }) ()
            } else {
                $('.btnOKBApproverPRAct').attr('disabled','disabled');
                $('.imgOKBLoading').fadeIn();
                var pre_reqid = new Array();
                    if (checkbox) {
                        $(checkbox).each(function () {
                            var pre_req_id = $(this).val();
                            pre_reqid.push(pre_req_id);
                        })
                    }
                $.ajax({
                    type: "POST",
                    url: baseurl + 'OrderKebutuhanBarangDanJasa/Approver/ApproveOrderPR',
                    data: {
                            pre_req_id : pre_reqid,
                            judgment : judgement,
                            person_id : person_id
                        },
                    success: function (response) {
                        if (response == 1) {
                            Swal.fire({
                                type: 'success',
                                title: 'Berhasil',
                                text: 'Order berhasil di approve',
                            })
                            checkbox.parentsUntil('tbody').remove();
                        } else {
                            Swal.fire({
                                type: 'error',
                                title: 'Gagal',
                                text: 'Order gagal di approve',
                            })
                        } 
                        $('.imgOKBLoading').fadeOut();            
                        $('.btnOKBApproverPRAct').removeAttr('disabled');
                    }
                });
            }
        })
        .on('click','.txtDestLineOKB', function () {
            var row_id = $(this).attr('data-row');
            var itemkode = $(this).parentsUntil('tbody').find('.slcOKBNewOrderList').val();
            var dest = $(this).parentsUntil('tbody').find('.hdnDestOKB');
            var org = $(this).parentsUntil('tbody').find('.hdnOrgOKB');
            var loc = $(this).parentsUntil('tbody').find('.hdnLocOKB');
            var sub = $(this).parentsUntil('tbody').find('.hdnSubinvOKB');
            
            $('#modal-destination-okb[data-row="'+row_id+'"]').modal('show');
            if ($('.destinationOKB[data-row="'+row_id+'"]').val() == '' || $('.destinationOKB[data-row="'+row_id+'"]').val() == null) {
                
                $('.loadingDestinationOKB[data-row="'+row_id+'"]').css('display','block');
                $('.dest_typeOKB[data-row="'+row_id+'"]').css('display','none')
                $.ajax({
                    type: "POST",
                    url: baseurl+"OrderKebutuhanBarangDanJasa/Requisition/getDestination",
                    data: {
                        itemkode : itemkode
                    },
                    dataType: "JSON",
                    success: function (response) {
                        // console.log(response);
                        $('.loadingDestinationOKB[data-row="'+row_id+'"]').css('display','none');
                        $('.dest_typeOKB[data-row="'+row_id+'"]').css('display','block');
                        $('.destinationOKB[data-row="'+row_id+'"]').val(response[0]['DESTINATION_TYPE_CODE']);
                        $('.txtDestLineOKB[data-row="'+row_id+'"]').val(response[0]['DESTINATION_TYPE_CODE']);
                        dest.val(response[0]['DESTINATION_TYPE_CODE']);
                        if(response[0]['DESTINATION_TYPE_CODE'] == 'EXPENSE'){
                            $('.subinventoryOKB[data-row="'+row_id+'"]').attr('disabled','diabled');
                        }else{
                            $('.subinventoryOKB[data-row="'+row_id+'"]').removeAttr('disabled');
                        }
                        // alert(response[0]['DESTINATION_TYPE_CODE']);
                    }
                });
            }

            if ($('.organizationOKB[data-row="'+row_id+'"]').val() == '' || $('.organizationOKB[data-row="'+row_id+'"]').val() == null) {
                $('.loadingOrganizationOKB[data-row="'+row_id+'"]').css('display','block');
                $('.viewOrganizationOKB[data-row="'+row_id+'"]').css('display','none');
                $.ajax({
                    type: "POST",
                    url: baseurl+"OrderKebutuhanBarangDanJasa/Requisition/getOrganization",
                    data: {
                        itemkode : itemkode
                    },
                    dataType: "JSON",
                    success: function (response) {
                        $('.organizationOKB[data-row="'+row_id+'"]').empty();
                        var html = '';
                        for (var i = 0; i < response.length; i++) {
                            if (i == 0) {
                                html += '<option value="'+response[i]['ORGANIZATION_ID']+'" title="'+response[i]['ORGANIZATION_NAME']+'">'+response[i]['IO']+'</option>';
                            }else{
                                html += '<option value="'+response[i]['ORGANIZATION_ID']+'" title="'+response[i]['ORGANIZATION_NAME']+'">'+response[i]['IO']+'</option>';
                            }
                        }
    
                        $('.organizationOKB[data-row="'+row_id+'"]').append(html);
                        $('.organizationOKB[data-row="'+row_id+'"]').val('').trigger('change.select2');
                        $('.loadingOrganizationOKB[data-row="'+row_id+'"]').css('display','none');
                        $('.viewOrganizationOKB[data-row="'+row_id+'"]').css('display','block');
                        // console.log(response);
                    }
                });
            }

            $(document).on('change', '.organizationOKB[data-row="'+row_id+'"]', function () {
                // alert(row_id)
                var organization = $(this).val();
                org.val(organization);
                if (organization != '' && organization != null) {
                    $('.loadingLocationOKB[data-row="'+row_id+'"]').css('display', 'block');
                    $('.viewLocationOKB[data-row="'+row_id+'"]').css('display', 'none');
                    $('.loadingSubinventoryOKB[data-row="'+row_id+'"]').css('display', 'block');
                    $('.viewSubinventoryOKB[data-row="'+row_id+'"]').css('display', 'none');
                    $('.locationOKB[data-row="'+row_id+'"]').val('');
                    $('.subinventoryOKB[data-row="'+row_id+'"]').val('');

                    if ($('.locationOKB[data-row="'+row_id+'"]').val() == '' || $('.locationOKB[data-row="'+row_id+'"]').val() == null) {
                        
                        $.ajax({
                            type: "POST",
                            url: baseurl+"OrderKebutuhanBarangDanJasa/Requisition/getLocation",
                            data: {},
                            dataType: "JSON",
                            success: function (response) {
                                // console.log(response);
                                $('.locationOKB[data-row="'+row_id+'"]').empty();
                                var html = '';
                                for (var i = 0; i < response.length; i++) {
                                    if (i == 0) {
                                        html += '<option value="'+response[i]['LOCATION_ID']+'">'+response[i]['LOC']+'</option>';
                                    }else{
                                        html += '<option value="'+response[i]['LOCATION_ID']+'">'+response[i]['LOC']+'</option>';
                                    }
                                }

                                $('.locationOKB[data-row="'+row_id+'"]').append(html);
                                $('.locationOKB[data-row="'+row_id+'"]').val('').trigger('change.select2');
                                $('.loadingLocationOKB[data-row="'+row_id+'"]').css('display', 'none');
                                $('.viewLocationOKB[data-row="'+row_id+'"]').css('display', 'block');
                            }
                        });
                    }

                    if ($('.subinventoryOKB[data-row="'+row_id+'"]').val() == '' || $('.subinventoryOKB[data-row="'+row_id+'"]').val() == null) {
                        
                        $.ajax({
                            type: "POST",
                            url: baseurl+"OrderKebutuhanBarangDanJasa/Requisition/getSubinventory",
                            data: {
                                organization: organization
                            },
                            dataType: "JSON",
                            success: function (response) {
                                console.log(response)
                                $('.subinventoryOKB[data-row="'+row_id+'"]').empty();
                                var html = '';
                                for (let i = 0; i < response.length; i++) {
                                    if (i == 0) {
                                        html += '<option value="'+response[i]['SUBINV']+'" title="'+response[i]['DESCRIPTION']+'">'+response[i]['SUBINV']+'</option>';
                                    }else{
                                        html += '<option value="'+response[i]['SUBINV']+'" title="'+response[i]['DESCRIPTION']+'">'+response[i]['SUBINV']+'</option>';
                                    }
                                }

                                $('.subinventoryOKB[data-row="'+row_id+'"]').append(html);
                                $('.subinventoryOKB[data-row="'+row_id+'"]').val('').trigger('change.select2');
                                $('.loadingSubinventoryOKB[data-row="'+row_id+'"]').css('display', 'none');
                                $('.viewSubinventoryOKB[data-row="'+row_id+'"]').css('display', 'block');
                            }
                        });
                    }
                }
            })
            $(document).on('change', '.locationOKB[data-row="'+row_id+'"]', function () {
                // alert(row_id)
                var location = $(this).val();
                loc.val(location);
            })
            $(document).on('change', '.subinventoryOKB[data-row="'+row_id+'"]', function () {
                // alert(row_id)
                var subinventory = $(this).val();
                sub.val(subinventory);
            })

        })
        .on('change','.nbdOKB', function () {
            var estArrival = new Date();
            var leadtime = $(this).parentsUntil('tbody').find('.leadtimeOKB').val();
            var urgentReason = $(this).parentsUntil('tbody').find('.txaOKBNewOrderListUrgentReason');
            var urgentFlag = $(this).parentsUntil('tbody').find('.hdUrgentFlagOKB');

            estArrival.setDate(estArrival.getDate() + Number(leadtime));

            var year = estArrival.getFullYear();
            var month = estArrival.getMonth();
            var date = estArrival.getDate();

            var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            
            date = ("00" + date).slice(-2);

            if($(this).val() != ''){

                var tanggal = date + '-' + monthNames[month] + '-' + year
                var nbd = $(this).val();
    
                nbd = nbd.split('-');
    
                if (year < nbd[2]) {
                    var tahunBaru = 1;
                } else if (year == nbd[2]) {
                    var tahunBaru = 0.5;
                } else {
                    var tahunBaru = 0;
                }
                if (month < monthNames.indexOf(nbd[1])) {
                    var bulanBaru = 1;
                } else if (month == monthNames.indexOf(nbd[1])) {
                    var bulanBaru = 0.5;
                } else {
                    var bulanBaru = 0;
                }
                if (date < nbd[0]) {
                    var tanggalBaru = 1;
                } else if (date == nbd[0]) {
                    var tanggalBaru = 0.5;
                } else {
                    var tanggalBaru = 0;
                }
    
                if (tahunBaru == 1 || (tahunBaru == 0.5 && bulanBaru == 1) || (tahunBaru == 0.5 && bulanBaru == 0.5 && tanggalBaru == 1) || (tahunBaru == 0.5 && bulanBaru == 0.5 && tanggalBaru == 0.5)) {
                    $(this).attr('style', 'background-color : #00bf024d; min-width:120px;');
                    urgentReason.removeAttr('required');
                    urgentReason.css('background-color', '#FFFFFF; min-width:150px;');
                    urgentFlag.val('N');
                }else{
                    Swal.fire({
                        type: 'warning',
                        title: 'Peringatan',
                        text: 'Order ini berstatus urgent, Silahkan mengisi alasan urgensi !',
                    });
                    $(this).attr('style', 'background-color : #ff00004d; min-width:120px;');
                    urgentReason.attr('required','required');
                    urgentReason.attr({
                        style: 'height: 34px; background-color :#fbfb5966; min-width:150px;'
                    });
                    urgentFlag.val('Y');
                }
            }

        })
        .on('click','.btnOKBReleaseOrderPulling', function () {
            $(this).attr('disabled','disabled');
            var checkbox = $('.checkApproveOKB').filter(':checked');
            $('.imgOKBLoading').fadeIn();

            if (checkbox.length == 0) {
                Swal.fire({
                    type: 'error',
                    title: 'Gagal',
                    text: 'Anda belum memilih order !',
                });
            }else{
                var orderid = new Array();
                if (checkbox) {
                    $(checkbox).each(function () {
                        var order_id = $(this).val();
                            orderid.push(order_id);
                    })
                }; 

                $.ajax({
                    type: "POST",
                    url: baseurl+"OrderKebutuhanBarangDanJasa/Puller/ReleaseOrder",
                    data: {
                        order_id : orderid
                    },
                    success: function (response) {
                        if (response == 1) {
                            Swal.fire({
                                type: 'success',
                                title: 'Berhasil',
                                text: 'Order berhasil direlease !',
                            });
                            // checkbox.parentsUntil('tbody').remove();
                            tableOKB.rows(checkbox.parentsUntil('tbody')).remove().draw();
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Gagal',
                                text: 'Order gagal direlease !',
                            });
                        }
                        $('.btnOKBReleaseOrderPulling').removeAttr('disabled');
                        $('.imgOKBLoading').hide();
                    }
                });
            }
        })
        .on('click','.btnOKBDetailReleasedOrder', function () {
            var orderid = $(this).parentsUntil('tbody').find('.tdOKBListOrderId').html();
            $('.modalDetailReleasedOrderOKB-'+orderid).modal('show');
            
            $.ajax({
                type: "POST",
                url: baseurl+"OrderKebutuhanBarangDanJasa/Puller/ShowDetailReleasedOrder",
                data: {
                    pre_req_id : orderid
                },
                success: function (response) {
                    $('.newtableDetailOKB').html(response);
                }
            });
        })

        .on('click','.btnOKBPurchasingAct', function () {
            var checkbox = $('.checkApproveOKB').filter(':checked');
            var judgement = $('.slcOKBTindakanPurchasing').val();
            var person_id = $('.txtOKBPerson_id').val();

            // alert(judgement);

            if (judgement =='') {
                Swal.fire({
                    type: 'error',
                    title: 'Gagal',
                    text: 'Anda belum memilih tindakan !',
                });
            } else if (checkbox.length == 0) {
                Swal.fire({
                    type: 'error',
                    title: 'Gagal',
                    text: 'Anda belum memilih order !',
                });
            } else {
                $('.btnOKBPurchasingAct').attr('disabled','disabled');
                $('.imgOKBLoading').fadeIn();
                var orderid = new Array();
                if (checkbox) {
                    $(checkbox).each(function () {
                        var order_id = $(this).val();
                        orderid.push(order_id);
                      })
                };
                $.ajax({
                    type: "POST",
                    url: baseurl + 'OrderKebutuhanBarangDanJasa/Purchasing/ApproveOrder',
                    data: {
                            pre_req_id : orderid,
                            judgement : judgement,
                            person_id : person_id
                        },
                    success: function (response) {
                        if (response == 1) {
                            Swal.fire({
                                type: 'success',
                                title: 'Berhasil',
                                text: 'Order berhasil di approve',
                            });
                            checkbox.parentsUntil('tbody').remove();
                        } else {
                            Swal.fire({
                                type: 'error',
                                title: 'Gagal',
                                text: 'Order gagal di approve',
                            });
                        };
                        $('.imgOKBLoading').fadeOut();
                        $('.btnOKBPurchasingAct').removeAttr('disabled');
                    }
                });
            }
        })
        .on('click','.btnNormalOrderOKB', function () {
            window.location.href = baseurl + "OrderKebutuhanBarangDanJasa/Approver/PermintaanApproveNormal";
        })
        .on('click','.btnSusulanOrderOKB', function () {
            window.location.href = baseurl + "OrderKebutuhanBarangDanJasa/Approver/PermintaanApproveSusulan";
        })
        .on('click','.btnUrgentOrderOKB', function () {
            window.location.href = baseurl + "OrderKebutuhanBarangDanJasa/Approver/PermintaanApproveUrgent";
        })
        .on('click','.btnNormalOrderOKBPengelola', function () {
            window.location.href = baseurl + "OrderKebutuhanBarangDanJasa/Pengelola/OpenedOrderNormal";
        })
        .on('click','.btnSusulanOrderOKBPengelola', function () {
            window.location.href = baseurl + "OrderKebutuhanBarangDanJasa/Pengelola/OpenedOrderSusulan";
        })
        .on('click','.btnUrgentOrderOKBPengelola', function () {
            window.location.href = baseurl + "OrderKebutuhanBarangDanJasa/Pengelola/OpenedOrderUrgent";
        })
        .on('click','.checkStokOKB', function () {
            var orderid = $(this).parentsUntil('tbody').find('.tdOKBListOrderId').html();
            var itemDesc = $(this).html();
            var item = itemDesc.split("-");

            $('.mdlOKBListOrderStock-'+orderid).modal('show');
            console.log($('.divStockOKB-'+orderid).html())
            if ($('.divStockOKB-'+orderid).html() == '') {
                $('.divOKBListOrderStockLoading-'+orderid).fadeIn();
                
                $.ajax({
                    type: "POST",
                    url: baseurl+"OrderKebutuhanBarangDanJasa/Approver/getStock",
                    data: {
                        itemkode : item[0]
                    },
                    dataType: "json",
                    success: function (response) {
                        $('.divOKBListOrderStockLoading-'+orderid).hide();
                        if (response == null || response =='') {
                            html = '<center><span><i class="fa fa-warning">No Data Found</i></span></center>';
                        }else{

                            var html = '<div class="col-lg-12">'+
                                '<table class="table table-bordered table-stripped text-center">'+
                                    '<thead>'+
                                    '<tr class="bg-primary">'+
                                    '<th>No</th>'+
                                    '<th>Item</th>'+
                                    '<th>MOQ</th>'+
                                    '<th>FLM</th>'+
                                    '<th>OnHand</th>'+
                                    '<th>ATT</th>'+
                                    '<th>ATR</th>'+
                                    '<th>Subinventory Code</th>'+
                                    '<th>Organization Code</th>'+
                                    '</tr>'+
                                    '</thead>'+
                                    '<tbody>';
                                    
                                    for (let i = 0; i < response.length; i++) {
                                        const el = response[i];
                                        if (el['MOQ'] == null) {
                                            el['MOQ'] = '-';
                                        }
                                        if (el['FLM'] == null) {
                                            el['FLM'] = '-';
                                        }
                                        if (el['ONHAND'] == null) {
                                            el['ONHAND'] = '-';
                                        }
                                        if (el['SUBINVENTORY_CODE'] == null) {
                                            el['SUBINVENTORY_CODE'] = '-';
                                        }
                                        if (el['ORGANIZATION_CODE'] == null) {
                                            el['ORGANIZATION_CODE'] = '-';
                                        }
                                        html += '<tr>'+
                                        '<td>'+Number(i+1)+'</td>'+
                                        '<td>'+el['ITEM']+'</td>'+
                                        '<td>'+el['MOQ']+'</td>'+
                                        '<td>'+el['FLM']+'</td>'+
                                        '<td>'+el['ONHAND']+'</td>'+
                                        '<td>'+el['ATT']+'</td>'+
                                        '<td>'+el['ATR']+'</td>'+
                                        '<td>'+el['SUBINVENTORY_CODE']+'</td>'+
                                        '<td>'+el['ORGANIZATION_CODE']+'</td>'+
                                        '</tr>';
                                        
                                    }
                                
                                html += '</tbody>'+
                                '</table>'+
                            '</div>';
                        }
                            // alert(response[0]['ONHAND'])
                        // var stock = '<span>'+response[0]['ONHAND']+'</span>';
                        $('.divStockOKB-'+orderid).html(html);
                    }
                });
            }
            
        })
        .on('click','.btnSetApproverOKB', function () {
            var appUnit = $('.slcApproverUnitOKB').val();
            var person = $('.hdnPersonIdOKB').val();

            $('.imgOKBLoading').fadeIn();
            $(this).attr('disabled','disabled');

            $.ajax({
                type: "POST",
                url: baseurl+"OrderKebutuhanBarangDanJasa/Requisition/SetActiveApprover",
                data: {
                    approver : appUnit,
                    person_id : person
                },
                success: function (response) {
                    if(response == 1){
                        Swal.fire({
                            type: 'success',
                            title: 'Berhasil',
                            text: 'Data berhasil diupdate!',
                        })
                        $('.imgOKBLoading').fadeOut();
                        $('.btnSetApproverOKB').removeAttr('disabled');
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Gagal',
                            text: 'Data gagal diupdate!',
                        })
                        $('.imgOKBLoading').fadeOut();
                        $('.btnSetApproverOKB').removeAttr('disabled');
                    }
                }
            });
        })
        .on('click','.btnSetRequestorOKB', function () {
            $('.imgOKBLoading').fadeIn();
            $(this).attr('disabled','disabled');
            var requestor = $('.slcRequestorOKB').val();
            var person = $('.hdnPersonIdOKB').val();
            
            var namaRequestor = $('.slcRequestorOKB').select2('data')[0]['title'];

            $.ajax({
                type: "POST",
                url: baseurl+"OrderKebutuhanBarangDanJasa/Requisition/SetRequestor",
                data: {
                    person_id : person,
                    requestor : requestor
                },
                success: function (response) {
                    if(response == 1){
                        Swal.fire({
                            type: 'success',
                            title: 'Berhasil',
                            text: 'Data berhasil diupdate!',
                        })
                        $('.imgOKBLoading').fadeOut();
                        $('.btnSetRequestorOKB').removeAttr('disabled');
                        $('.txtRequestoractOKB').val(namaRequestor);
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Gagal',
                            text: 'Data gagal diupdate!',
                        })
                        $('.imgOKBLoading').fadeOut();
                        $('.btnSetRequestorOKB').removeAttr('disabled');
                    }
                }
            });

        })
        .on('click','.btnAttachmentOKB', function () {
            var orderid = $(this).parentsUntil('tbody').find('.tdOKBListOrderId').html();

            $('.mdlOKBListOrderAttachment-'+orderid).modal('show');

            if ($('.divAttachmentOKB-'+orderid).html() == '') {
                $('.divOKBListOrderAttachmentLoading-'+orderid).fadeIn();

                $.ajax({
                    type: "POST",
                    url: baseurl+"OrderKebutuhanBarangDanJasa/Approver/getAttachment",
                    data: {
                        order_id : orderid
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        $('.divOKBListOrderAttachmentLoading-'+orderid).hide();
                        console.log(response);
                        var html = '';
                            html += '<center>';
                            for (let i = 0; i < response.length; i++) {
                                const elm = response[i];
                                if (elm['FILE_NAME'] == null) {
                                    html+='<span><i class="fa fa-warning"></i>Tidak ada attachment</span><br>';
                                }else{
                                    if (response.length == 1) {
                                        html += '<a href="'+baseurl+elm['ADDRESS']+elm['FILE_NAME']+'" target="_blank" rel="noopener noreferrer"><img style="max-width:500px; max-height:500px;" src="'+baseurl+elm['ADDRESS']+elm['FILE_NAME']+'" alt="'+elm['FILE_NAME']+'"></a><br>';
                                    }else{

                                        html += '<a href="'+baseurl+elm['ADDRESS']+elm['FILE_NAME']+'" target="_blank" rel="noopener noreferrer"><img style="max-width:200px; max-height:200px;" src="'+baseurl+elm['ADDRESS']+elm['FILE_NAME']+'" alt="'+elm['FILE_NAME']+'"></a><br>';
                                    }
                                }
                                
                            }
                            html += '</center>';
                        

                        $('.divAttachmentOKB-'+orderid).html(html);
                    }
                });
            }

        })
        .on('click','.btnOKBInfoPR', function () {
            var order_id = $(this).parentsUntil('tbody').find('.tdOKBListOrderId').html();

            $('.mdlOKBOrderPR-'+order_id).modal();
            if ($('.divOKBOrderPR-'+order_id).html() == '') {
                
                $('.divOKBOrderPRLoading-'+order_id).fadeIn();
    
                $.ajax({
                    type: "POST",
                    url: baseurl+"OrderKebutuhanBarangDanJasa/Requisition/InfoOrderPR",
                    data: {
                        order_id : order_id
                    },
                    success: function (response) {
                        $('.divOKBOrderPR-'+order_id).fadeIn();
                        $('.divOKBOrderPR-'+order_id).html(response);
                        $('.divOKBOrderPRLoading-'+order_id).hide();
                    }
                });
            }
        })
        ////Bondan End/////

})