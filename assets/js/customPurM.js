$(document).ready(function() {
    function readURL(input) {
        console.log(input)
        $('.photoNonConformity').html('');
        if (input.files && input.files[0]) {

            for (var i = 0; i < input.files.length; i++) {
                var element = input.files[i];
                var count = input.files.length;
                var reader = new FileReader();

                reader.onload = function(e) {
                    // $('#blah').attr('src', e.target.result);
                    $('.photoNonConformity').append('<img src="' + e.target.result + '" style="max-height: 50px; max-width: 50px;" onclick="showBigImage(this)">');

                    $('.previewImageNonConformity').html('<img src="' + e.target.result + '" class="previewImageSrcNonConformity" alt="your image" style="max-height: 250px; max-width: 250px; text-align: center; padding:13px;"/>');
                }

                reader.readAsDataURL(element);

            }
        }
    }

    $(".nonconfPhoto").change(function() {
        readURL(this);
    });

    $('.slcRemarkNonConformity').change(function() {
        var valArray = $(this).val();
        var htmlArray = new Array();

        for (let i = 0; i < valArray.length; i++) {
            var elm = valArray[i];
            var hau = $('.slcRemarkNonConformity option[value="' + elm + '"]').html();
            htmlArray.push(hau);
        }
        console.log(htmlArray);
        $('.remarkReviewNonConformity').html('');
        for (var i = 0; i < htmlArray.length; i++) {
            var elm = htmlArray[i];
            $('.remarkReviewNonConformity').append('<span class="label label-default">' + elm + '</span>&nbsp;<br>');
        }
    });

    $('.descriptionRemarkNonConformity').change(function() {
        var descrip = $(this).val();
        // alert(descrip);
        $('.descriptionReviewNonConformity').html('<div style="word-wrap: break-word;">' + descrip + '</div>');
    })

    if ($('.descriptionRemarkNonConformity').val() == '') {
        $('.review').removeAttr('data-toggle');
    }
    $('.descriptionRemarkNonConformity').on('input', function() {
        if ($('.descriptionRemarkNonConformity').val() == '') {
            $('.review').removeAttr('data-toggle');
        } else {
            $('.review').attr('data-toggle', 'tab');
        }
    })

    $('.tep-nonconformity').click(function() {
        var tabNow = $(this).attr('href');
        console.log($('.descriptionRemarkNonConformity').val() + '-' + tabNow);
        if (tabNow == '#review' && $('.descriptionRemarkNonConformity').val() == '') {
            // tabNow = '#remark';
            alert('anda harus mengisi kolom remark dan description');
        }

        if (tabNow == '#review' && $('.descriptionRemarkNonConformity').val() != '') {
            $('.submitNonConformity').css('display', 'block');
            $('.btnNextNonConformity').css('display', 'none');
        } else {
            $('.submitNonConformity').css('display', 'none');
            $('.btnNextNonConformity').css('display', 'block');
        }

        if (tabNow != '#photo') {
            $('.btnBackNonConformity').removeAttr('disabled');
        } else {
            $('.btnBackNonConformity').attr('disabled', 'disabled');
        }
        $('.btnNextNonConformity').attr('tab-now', tabNow);
    });
    $('.btnNextNonConformity').click(function() {
        var tabNow = $(this).attr('tab-now');
        $('.btnBackNonConformity').removeAttr('disabled');
        if (tabNow == '#photo') {
            $('.btnBackNonConformity').attr('tab-now', '#remark');
            $('.remark').click()
        } else if (tabNow == '#remark') {
            var desc = $('.descriptionRemarkNonConformity').val();
            if (desc != '') {
                $('.btnBackNonConformity').attr('tab-now', '#review');
                $('.review').click();
                // $('.btnNextNonConformity').css('display', 'none');
                $('.submitNonConformity').css('display', 'block');
                $('.btnNextNonConformity').css('display', 'none');
            } else { alert('anda harus mengisi kolom remark dan description') }

        } else if (tabNow == '#review') {
            $('.photo').click();

        }
    })

    $('.btnBackNonConformity').click(function() {
        var tabNow = $(this).attr('tab-now');
        if (tabNow == '#review') {
            $('.btnBackNonConformity').attr('tab-now', '#remark');
            $('.submitNonConformity').css('display', 'none');
            $('.btnNextNonConformity').css('display', 'block');
            $('.remark').click()
        } else if (tabNow == '#remark') {
            $('.btnBackNonConformity').attr('tab-now', '#photo');
            $('.photo').click();

            $('.btnBackNonConformity').attr('disabled', 'disabled');
        }
    })



    $('.slcRemarkNonConformity').select2({
        placeholder: 'Select Remark'
    });

    $(document).on('click', '.btnSetItemNonC', function() {
        $('#mdl-setItemNonConformity').modal('show');
    })

    $(document).on('click', '.btnSetJudgementNonC', function() {
        $('#mdl-JudgementNonConformity').modal('show');
    })

    $(document).on('click', '.btnSetRemarkNonC', function() {
        $('#mdl-remarkNonConformity').modal('show');
    })

    $(".slcItemNonConformity").select2({
        ajax: {
            url: baseurl + 'PurchaseManagementGudang/NonConformity/searchItem/',
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
                            id: item.ITEM_KODE + ' | ' + item.DESCRIPTION,
                            text: item.ITEM_KODE + ' - ' + item.DESCRIPTION,
                            title: item.DESCRIPTION,
                        }
                    })
                };
            },
            cache: true,
        },
        minimumInputLength: 2,
        placeholder: 'Masukan kode',

    });

    $('.dateDelivNonConformity').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd'
    });

    $('.slcJudgementNonConformity').select2({
        placeholder: 'Choose Judgement Type'
    })

    $('.slcCaseNonC').select2({
        placeholder: 'Set Status'
    });

    $('.slcScopeNonC').select2({
        placeholder: 'Set Scope'
    });

    $('.slcCarNonC').select2({
        placeholder: 'Set CAR'
    });

    $('.completionDateNonC').datepicker({
        autoclose: true,
        todayHighlight: true,
        forformat: 'yyyy-mm-dd'
    })


    $('.poNumberNonC').keypress(function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
        }
    });

    $(document).on('click', '.poNumberNonC', function() {
        var poNumber = $('.poNonC').val();
        var supplier = $('.splrNonC').val();
        
        // alert(poNumber);
        
        if (poNumber != '') {
            $('#waitLineNonC').modal('show');

            if (supplier == '') {
                
                $.ajax({
                    type: "POST",
                    url: baseurl + 'PurchaseManagementGudang/NonConformity/getDetailPO',
                    data: {
                        poNumber: poNumber
                    },
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response);
                        // $('.byrNonC').val(response[0]['NATIONAL_IDENTIFIER'] + ', ' + response[0]['FULL_NAME']);
                        $('.splrNonC').val(response[0]['VENDOR_NAME']);
                        $('.splrAddresNonC').val(response[0]['ALAMAT_LENGKAP']);
                        $('.picNonC').val(response[0]['PIC']);
                        $('.phoneNonC').val(response[0]['PHONE_NUMBER']);
                        $('.headerStatusNonC').html(response[0]['CLOSED_CODE']);
                        $('.txtheaderStatusNonC').val(response[0]['CLOSED_CODE']);
                    }
                });
            }

            $.ajax({
                type: "POST",
                url: baseurl + 'PurchaseManagementGudang/NonConformity/getLinesNew',
                data:   {
                            po: poNumber
                        },
                success: function (response) {
                    $('.addLineNonC').html(response);
                    $('#waitLineNonC').modal('hide');
                    $('.checkBoxAllNonC').iCheck({
                        checkboxClass: 'icheckbox_square-blue',
                        radioClass: 'iradio_flat-blue'
                    });
                    $('.checkBoxNonC').iCheck({
                        checkboxClass: 'icheckbox_square-blue',
                        radioClass: 'iradio_flat-blue'
                    });

                    $('#tblLinesNonC').DataTable({
                        "paging": false,
                    });

                    var checkboxAll = $('.checkBoxAllNonC');
                    var checkbox = $('.checkBoxNonC');

                    checkboxAll.on('ifChecked ifUnchecked', function(event) {
                        if (event.type == 'ifChecked') {
                            checkbox.iCheck('check');
                        } else {
                            checkbox.iCheck('uncheck');
                        }

                        checkbox.on('ifChanged', function(event) {
                            if (checkbox.filter(':checked').length == checkbox.length) {
                                checkboxAll.prop('checked', 'checked');
                            } else {
                                checkboxAll.prop('checked', false);
                            }
                            checkboxAll.iCheck('update');
                        });
                    });
                }
            });


            // $.ajax({
            //     type: "POST",
            //     url: baseurl + 'PurchaseManagementGudang/NonConformity/getLinesNew',
            //     data: {
            //         po: poNumber
            //     },
            //     dataType: "JSON",
            //     success: function(response) {
            //         console.log(response);
            //         var html = '';
            //         var no = 1;
            //         for (var i = 0; i < response.length; i++) {
            //             var data = response[i];
            //             html += '<tr class="trLineNonC" data-row="' + no + '">' +
            //                 '<td><input type="checkbox" class="minimal checkBoxNonC" item="' + data['ITEM_ID'] + '" desc="' + data['DESCRIPTION'] + '" qtyRecipt="' + data['QTY_RECEIPT'] + '" qtyBilled="' + data['QUANTITY_BILLED'] + '" qtyReject="' + data['REJECTED'] + '" unitPrice="' + data['UNIT_PRICE'] + '" qtyPo="' + data['QUANTITY'] + '" currency="' + data['CURRENCY'] + '" nomer="' + no + '" po="'+data['NO_PO']+'" line="'+data['LINE_NUM']+'" status="'+data['CLOSED_CODE']+'" lppb="'+data['NO_LPPB']+'" buyer="'+data['BUYER']+'" noind="'+data['NATIONAL_IDENTIFIER']+'"></td>' +
            //                 '<td>' + data['LINE_NUM'] + '</td>' +
            //                 '<td>' + data['ITEM_ID'] + '</td>' +
            //                 '<td>' + data['DESCRIPTION'] + '</td>' +
            //                 '<td>' + data['QTY_RECEIPT'] + '</td>' +
            //                 '<td>' + data['QUANTITY_BILLED'] + '</td>' +
            //                 '<td>' + data['REJECTED'] + '</td>' +
            //                 '<td>' + data['UNIT_PRICE'] + '</td>' +
            //                 '<td>' + data['QUANTITY'] + '</td>' +
            //                 '</tr>';
            //             no++;
            //         }
            //         $('.lineNonC').html(html);
            //         $('.checkBoxNonC').iCheck({
            //             checkboxClass: 'icheckbox_square-blue',
            //             radioClass: 'iradio_flat-blue'
            //         });
            //         $('#waitLineNonC').modal('hide');

            //         var checkboxAll = $('.checkBoxAllNonC');
            //         var checkbox = $('.checkBoxNonC');

            //         checkboxAll.on('ifChecked ifUnchecked', function(event) {
            //             if (event.type == 'ifChecked') {
            //                 checkbox.iCheck('check');
            //             } else {
            //                 checkbox.iCheck('uncheck');
            //             }

            //             checkbox.on('ifChanged', function(event) {
            //                 if (checkbox.filter(':checked').length == checkbox.length) {
            //                     checkboxAll.prop('checked', 'checked');
            //                 } else {
            //                     checkboxAll.prop('checked', false);
            //                 }
            //                 checkboxAll.iCheck('update');
            //             });
            //         });



                    // $('.btnAddNonCLine').on('click', function() {
                    //     var chck = $('.checkBoxNonC').filter(':checked');
                    //     if ($('.checkBoxNonC').filter(':checked')) {
                    //         var list = '';
                    //         $(chck).each(function() {
                    //             var item = $(this).attr('item');
                    //             var desc = $(this).attr('desc');
                    //             var qtyRecipt = $(this).attr('qtyRecipt');
                    //             var qtyBilled = $(this).attr('qtyBilled');
                    //             var qtyReject = $(this).attr('qtyReject');
                    //             var unitPrice = $(this).attr('unitPrice');
                    //             var qtyPo = $(this).attr('qtyPo');
                    //             var currency = $(this).attr('currency');
                    //             var nomer = $(this).attr('nomer');

                    //             $(this).closest('tr').hide();

                    //             list += '<tr class="trSelectedLineNonC" data-row="' + nomer + '">' +
                    //                 '<td>' + item + '<input type="hidden" class="form-control" name="hdnItem[]" value="' + item + '"></td>' +
                    //                 '<td>' + desc + '<input type="hidden" class="form-control" name="hdnDesc[]" value="' + desc + '"></td>' +
                    //                 '<td>' + qtyRecipt + '<input type="hidden" class="form-control" name="hdnQtyRecipt[]" value="' + qtyRecipt + '"></td>' +
                    //                 '<td>' + qtyBilled + '<input type="hidden" class="form-control" name="hdnQtyBilled[]" value="' + qtyBilled + '"></td>' +
                    //                 '<td>' + qtyReject + '<input type="hidden" class="form-control" name="hdnQtyReject[]" value="' + qtyReject + '"></td>' +
                    //                 '<td>' + currency + '<input type="hidden" class="form-control" name="hdnCurrency[]" value="' + currency + '"></td>' +
                    //                 '<td>' + unitPrice + '<input type="hidden" class="form-control" name="hdnUnitPrice[]" value="' + unitPrice + '"></td>' +
                    //                 '<td>' + qtyPo + '<input type="hidden" class="form-control" name="hdnQtyPo[]" value="' + qtyPo + '"></td>' +
                    //                 '<td><input type="text" class="form-control" name="txtQtyProblem[]" required></td>' +
                    //                 '<td><button type="button" class="btn btn-danger btnRevoke" revoke="' + nomer + '"><i class="fa fa-trash"></i></button></td>' +
                    //                 '</tr>';

                    //             // console.log(desc + '' + qtyRecipt + '' + qtyBilled + '' + qtyReject + '' + unitPrice + '' + qtyPo);
                    //         })

                    //         $('.selectedLineNonC').html(list);
                    //         $('.panelSelectedLineNonC').css('display', 'block');
                    //     }
                    //     $('.btnRevoke').on('click', function() {
                    //         var num = $(this).attr('revoke');
                    //         $('.trSelectedLineNonC[data-row="' + num + '"]').remove();
                    //         if ($('.btnRevoke').length == 0) {
                    //             $('.panelSelectedLineNonC').css('display', 'none');
                    //         }
                    //         $('.trLineNonC[data-row="' + num + '"]').show();
                    //     })
                    // })

            //     }
            // });
        }


    });

    $('.btnAddNonCLine').on('click', function () {

        var chck = $('.checkBoxNonC').filter(':checked');
                        if ($('.checkBoxNonC').filter(':checked')) {
                            var list = '';
                            $(chck).each(function() {
                                var item = $(this).attr('item');
                                var desc = $(this).attr('desc');
                                var qtyRecipt = $(this).attr('qtyRecipt');
                                var qtyBilled = $(this).attr('qtyBilled');
                                var qtyReject = $(this).attr('qtyReject');
                                var unitPrice = $(this).attr('unitPrice');
                                var qtyPo = $(this).attr('qtyPo');
                                var currency = $(this).attr('currency');
                                var rowId = $(this).attr('data-row');
                                var po = $(this).attr('po');
                                var line = $(this).attr('line');
                                var status = $(this).attr('status');
                                var lppb = $(this).attr('lppb');
                                var buyer = $(this).attr('buyer');
                                var noind = $(this).attr('noind');

                                // $(this).closest('tr').hide();
                                $(this).iCheck('destroy');
                                $(this).attr('type','hidden');
                                $(this).prop('checked', false);
                                $(this).closest('tr').css('background-color','#b1ff89');
                                list += '<tr class="trSelectedLineNonC" data-row="' + rowId + '">' +
                                    '<td>'+ po +'<input type="hidden" class="form-control" name="hdnPO[]" value="' + po + '"></td>' +
                                    '<td>'+ line +'<input type="hidden" class="form-control" name="hdnLine[]" value="' + line + '"></td>' +
                                    '<td>'+ status +'<input type="hidden" class="form-control" name="hdnStatusLine[]" value="' + status + '"></td>' +
                                    '<td>'+noind+', '+buyer+'<input type="hidden" class="form-control" name="hdnBuyer[]" value="'+noind+', '+buyer+'"></td>'+
                                    '<td>'+ lppb +'<input type="hidden" class="form-control" name="hdnLppb[]" value="' + lppb + '"></td>'+
                                    '<td>' + item + '<input type="hidden" class="form-control" name="hdnItem[]" value="' + item + '"></td>' +
                                    '<td>' + desc + '<input type="hidden" class="form-control" name="hdnDesc[]" value="' + desc + '"></td>' +
                                    // '<td>' + qtyBilled + '<input type="hidden" class="form-control" name="hdnQtyBilled[]" value="' + qtyBilled + '"></td>' +
                                    // '<td>' + qtyReject + '<input type="hidden" class="form-control" name="hdnQtyReject[]" value="' + qtyReject + '"></td>' +
                                    // '<td>' + currency + '<input type="hidden" class="form-control" name="hdnCurrency[]" value="' + currency + '"></td>' +
                                    // '<td>' + unitPrice + '<input type="hidden" class="form-control" name="hdnUnitPrice[]" value="' + unitPrice + '"></td>' +
                                    '<td>' + qtyPo + '<input type="hidden" class="form-control" name="hdnQtyPo[]" value="' + qtyPo + '"></td>' +
                                    '<td>' + qtyRecipt + '<input type="hidden" class="form-control" name="hdnQtyRecipt[]" value="' + qtyRecipt + '"></td>' +
                                    '<td><input type="text" class="form-control" name="txtQtyProblem[]" required></td>' +
                                    '<td><button type="button" class="btn btn-danger btnRevoke" revoke="' + rowId + '"><i class="fa fa-trash"></i></button></td>' +
                                    '</tr>';

                                // console.log(desc + '' + qtyRecipt + '' + qtyBilled + '' + qtyReject + '' + unitPrice + '' + qtyPo);
                            })
                            // $('.panelSelectedLineNonC').css('display', 'block');
                            $('.checkBoxNonC').iCheck('uncheck');

                            $('.selectedLineNonC').append(list);
                            $('.panelSelectedLineNonC').css('display', 'block');

                            $('.btnRevoke').on('click', function() {
                                var num = $(this).attr('revoke');
                                $('.lineListNonC[data-row="' + num + '"]').css('background-color','#fff');
                                $('.checkBoxNonC[data-row="' + num + '"]').attr('type','checkbox');
                                $('.checkBoxNonC[data-row="' + num + '"]').iCheck({
                                    checkboxClass: 'icheckbox_square-blue',
                                    radioClass: 'iradio_flat-blue'
                                });
                                // $('.checkBoxNonC[data-row="' + num + '"]').iCheck('enable');
                                $('.trSelectedLineNonC[data-row="' + num + '"]').remove();
                                    // if ($('.btnRevoke').length == 0) {
                                    //     $('.panelSelectedLineNonC').css('display', 'none');
                                    // }
                                // $('.trLineNonC[data-row="' + num + '"]').show();
                                $('.trLineNonC[data-row="' + num + '"]').css('background-color', '#fff');
                            })
                        }
    })

    $(document).on('input', '.qtyProblem', function(event) {

        var contnt = $(this).val();
        var rgxNum = contnt.replace(/[\D]/g, '');
        $(this).val(rgxNum);
    });

    $(document).on('click','.btnHapusLineNonC', function () {

        // alert('tes')
        var lineid = $(this).attr('lineid');
        $('.hdnLineItemIdNonC').val(lineid);
        $('#modal-konfirmasi').modal('show');
    })

    $(document).on('click','.btnKonfirmasiHapusLineNonC', function () {
        var lineid = $('.hdnLineItemIdNonC').val();

        // alert(lineid);
        $.ajax({
            type: "POST",
            url: baseurl + "PurchaseManagementGudang/NonConformity/hapusItemSelected",
            data: {
                lineid : lineid
            },
            dataType: "JSON",
            success: function (response) {
                if (response == 1) {
                    $('.btnHapusLineNonC[lineid="'+lineid+'"]').closest('tr').remove();
                    $('#modal-konfirmasi').modal('hide');
                }else{
                    $('#modal-konfirmasi').modal('hide');
                    alert('hapus gagal karena kesalahan fungsi!');
                }
            }
        });
    })


});

function showBigImage(elm) {
    var src = elm.getAttribute('src');
    // $('#previewImageNonConformity').modal('show');
    // $('.previewImageSrcNonConformity').attr('src', src);
    $('.previewImageNonConformity').html('<img src="' + src + '" class="previewImageSrcNonConformity" alt="your image" style="max-height: 250px; max-width: 250px; text-align: center; padding:13px;"/>');
}

$('#tblPoOracleNonConfirmityHeaders').DataTable({
    dom: 'Bfrtip',
    "aoColumns": [ 
        null, {
            "bSortable": false,
            "bVisible": true
        },
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null
    ],
    buttons: ['excel']
});

function previewImg(m) {
    var src1 = $(m).attr('src');
    $('#previewImgArea').show();
    $('#preview-Img').attr('src', src1);
}

function closepreviewImg() {
    $('#previewImgArea').hide();
}

function judgementModal(m) {
    var head = $('input#header_id').val();
    var data = $(m).attr('data-judgement');
    var type = $(m).attr('data-judgementType');
    var id = $(m).attr('data-id');
    var status = $(m).attr('data-status');
    var status = status.replace(/ /g, "");
    if (status == 'close') {
        if (type == 'CAR') {
            var typeVal = 'CLOSE WITH CAR';
        } else {
            var typeVal = 'CLOSE WITHOUT CAR';
        }
        $('div#judgementTypeArea').html('<input type="text" name="judgementType" disabled class="form-control" value="' + typeVal + '">');
        $('#judgementData').prop('disabled', true);
        $('button#judgementSubmit').hide();
    } else {
        $('div#judgementTypeArea').html('<select class="form-control" style="width: 100%;" name="judgementType" id="judgementType" required><option disabled selected>Choose Judgement Type</option><option value="CAR">Close with CAR</option><option value="NO CAR">Close without CAR</option></select>');
        $('#judgementType').select2({
            placeholder: "Please select a country"
        })
        $('#judgementData').prop('disabled', false);
        $('button#judgementSubmit').show();
    }
    $('#judgementData').val(data);
    $('#judgementModal').modal();
    $('#judgement_line_id').val(id);
    $('#header').val(head);
    $('select#judgementType option[value="' + type + '"]').attr('selected');
}

function judgementSubmit() {
    var id = $('input#judgement_line_id').val();
    $.ajax({
        type: 'POST',
        data: $('#formJudgement').serialize(),
        url: baseurl + 'PurchaseManagementGudang/NonConformity/Judgement',
        cache: false,
        success: function(result) {
            var a = JSON.parse(result);
            $('#judgementModal').modal('hide');
            $('a[data-line="judgement"][data-id="' + id + '"]').attr('data-judgement', a[0]['judgement_description']);
            $('a[data-line="judgement"][data-id="' + id + '"]').attr('data-judgementType', a[0]['judgement']);
            $('a[data-line="judgement"][data-id="' + id + '"]').attr('data-status', 'close');
            $('td#LineStatus[row-id="' + id + '"]').html(a[0]['status']);
            if (a[1] != null) {
                $('div#header_status').html(a[1]);
            }
        }
    });
}

function ItemsModal(m) {
    var id = $(m).attr('data-id');
    $.ajax({
        type: 'POST',
        data: {
            id: id
        },
        url: baseurl + 'PurchaseManagementGudang/NonConformity/getLineItems',
        cache: false,
        success: function(result) {
            if (result == 0) {
                $('#ItemsModalArea').html('<h3 class="text-center">This line dont have any line items.</h3>');
            } else {
                $('#ItemsModalArea').html(result);
            }
            $('#ItemsModal').modal();
        }
    });
}

function remarkModal(m) {
    var head = $('input#header_id').val();
    var data = $(m).attr('data-remark');
    var id = $(m).attr('data-id');
    $('#remarkModal').modal();
    $('textarea#remarkData').val(data);
    $('input#remark_line_id').val(id);
}

function remarkSubmit() {
    var id = $('input#remark_line_id').val();
    $.ajax({
        type: 'POST',
        data: $('#formRemark').serialize(),
        url: baseurl + 'PurchaseManagementGudang/NonConformity/Remark',
        cache: false,
        success: function(result) {
            var a = JSON.parse(result);
            $('#remarkModal').modal('hide');
            $('a[data-line="remark"][data-id="' + id + '"]').attr('data-remark', a[0]['remark']);
        }
    });
}

function exportPDF(m) {
    var header_id = $('input#header_id').val();
    var line_id = $(m).attr('data-id');
    var win = window.open(baseurl + 'PurchaseManagementGudang/NonConformity/ExportPDF/' + header_id + '/' + line_id, '_blank');
    if (win) {
        win.focus();
    } else {
        alert('Please allow popups for this website.');
    }
}