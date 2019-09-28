$(document).ready(function () {
    var tblItem = $('#masterItem').DataTable({
        dom: 'Bfrtip',
        columnDefs: [
            {
                orderable: false,
                className: 'select-checkbox',
                targets: 1
            }
        ],
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Master_Item ' + moment().format('DD-MMM-YYYY h:mm:ss'),
                exportOptions: {
                    columns: ':visible',
                    modifier: {
                        selected: true
                            },
                    columns: [12, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                },
                customize: function( xlsx ) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    $('row c[r*="A"]', sheet).attr( 's', '51');
                }
            }
        ],
        select: {
            style: 'multi',
            selector: 'td:nth-child(2)'
        },
        order: [[12, 'asc']],
        scrollX: true
    });
})

$('#tblCore').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
});
$('#tblMixing').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
});
$('#tblMoulding').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
}); //Ngaruh di absen dan OTT

$('#tblQualityControl').DataTable({
    initComplete: function () {
        this.api()
            .columns([5])
            .every(function () {
                var thsUP2L1 = this;
                var slcUP2L1 = $(
                        '<select class="form-control"><option selected value="">Semua Shift</option></select>'
                    )
                    .appendTo("#searchShiftUP2L")
                    .on("change", function () {
                        var val1 = $.fn.dataTable.util.escapeRegex($(this).val());
                        thsUP2L1.search(val1 ? "^" + val1 + "$" : "", true, false).draw();
                    });
                thsUP2L1
                    .data()
                    .unique()
                    .sort()
                    .each(function (d, j) {
                        slcUP2L1.append('<option value="' + d + '">' + d + "</option>");
                    });
            });
        this.api()
            .columns([10])
            .every(function () {
                var thsUP2L1 = this;
                var slcUP2L1 = $(
                        '<select class="form-control"><option selected value="">Semua Employee</option></select>'
                    )
                    .appendTo("#searchEmpUP2L")
                    .on("change", function () {
                        var val1 = $.fn.dataTable.util.escapeRegex($(this).val());
                        thsUP2L1.search(val1 ? "^" + val1 + "$" : "", true, false).draw();
                    });
                thsUP2L1
                    .data()
                    .unique()
                    .sort()
                    .each(function (d, j) {
                        slcUP2L1.append('<option value="' + d + '">' + d + "</option>");
                    });
            });
    },
    dom: 'Bfrtip',
    buttons: ['excel',
    {
        extend: 'pdfHtml5',
        orientation : 'landscape',
        filename : 'Cetak QC',
    }
    ]
});
$('#tblSelep').DataTable({
    initComplete: function () {
        this.api()
            .columns([7])
            .every(function () {
                var thsUP2L1 = this;
                var slcUP2L1 = $(
                        '<select class="form-control"><option selected value="">Semua Shift</option></select>'
                    )
                    .appendTo("#searchSShiftUP2L")
                    .on("change", function () {
                        var val1 = $.fn.dataTable.util.escapeRegex($(this).val());
                        thsUP2L1.search(val1 ? "^" + val1 + "$" : "", true, false).draw();
                    });
                thsUP2L1
                    .data()
                    .unique()
                    .sort()
                    .each(function (d, j) {
                        slcUP2L1.append('<option value="' + d + '">' + d + "</option>");
                    });
            });
        this.api()
            .columns([8])
            .every(function () {
                var thsUP2L1 = this;
                var slcUP2L1 = $(
                        '<select class="form-control"><option selected value="">Semua Employee</option></select>'
                    )
                    .appendTo("#searchSEmpUP2L")
                    .on("change", function () {
                        var val1 = $.fn.dataTable.util.escapeRegex($(this).val());
                        thsUP2L1.search(val1 ? "^" + val1 + "$" : "", true, false).draw();
                    });
                thsUP2L1
                    .data()
                    .unique()
                    .sort()
                    .each(function (d, j) {
                        slcUP2L1.append('<option value="' + d + '">' + d + "</option>");
                    });
            });
    },
    dom: 'Bfrtip',
    buttons: ['excel',
    {
        extend: 'pdfHtml5',
        orientation : 'landscape',
        filename : 'Cetak Selep',
    }
    ]
});
$('#jobTable').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
});
$('#rejectTable').DataTable({
    dom: 'frtip'
});
$('#MasterPersonal').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
});
$('#masterScrap').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
});
// $('#tglBerlaku').datepicker({
//     format: 'mm/dd/yyyy',
//     container: container,
//     todayHighlight: true,
//     autoclose: true,
// });

function getCompDescMO(th) {
    var val = $(th).val();
    var desc = val.split('|');
    desc = desc[1];
    $('input[name="component_description"]').val(desc);
}

function kurang() {
    var qtyScrap = Number($('#txtScrapQuantityHeader').val());
    var qtySelep = Number($('#txtSelepQuantityHeader').val());
    if (qtySelep < qtyScrap) {
        alert("Warning!", "Nilai Selep lebih kecil", "warning");
        $('#txtScrapQuantityHeader').val('').trigger('change');
        $('#txtSelepQuantityHeader').val('').trigger('change');
    }
}


$(window).load(function () {

    $('.slcShift').select2({
        placeholder: "Shift",
    });

    $('.jsSlcComp').select2({
        allowClear: true,
        placeholder: "Choose Component Code",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + "ManufacturingOperationUP2L/Ajax/getComponent",
            dataType: 'json',
            type: "post",
            data: function (params) {
                var queryParameters = {
                    term: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return {
                            id: obj.kode_barang + " | " + obj.nama_barang + ' | ' + obj.kode_proses,
                            text: obj.kode_barang + " | " + obj.nama_barang + ' | ' + obj.kode_proses
                        };
                    })
                };
            },
            error: function (error, status) {
                console.log(error);
            }
        }
    });

    $('.jsSlcEmpl').select2({
        allowClear: true,
        placeholder: "Choose Employee",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + "ManufacturingOperationUP2L/Ajax/getEmployee",
            dataType: 'json',
            type: "post",
            data: function (params) {
                var queryParameters = {
                    term: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return {
                            id: obj.no_induk + '|' + obj.nama,
                            text: obj.no_induk + " | " + obj.nama
                        };
                    })
                };
            }
        }
    });

    $('.jsSlcScrap').select2({
        allowClear: true,
        placeholder: "Choose Scrap",
        ajax: {
            url: baseurl + "ManufacturingOperationUP2L/Ajax/getScrap",
            dataType: 'json',
            type: "post",
            data: function (params) {
                var queryParameters = {
                    term: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return {
                            id: obj.scrap_code + '|' + obj.description,
                            text: obj.scrap_code + " | " + obj.description
                        };
                    })
                };
            }
        }
    });


    $('.add_emp').click(function () {
        $('.jsSlcEmpl').select2('destroy').end();
        $(this).parent().clone(true).appendTo($("#container-employee"));
        $('.remove_emp').show();
        $('.jsSlcEmpl').select2({
            allowClear: true,
            placeholder: "Choose Employee",
            minimumInputLength: 3,
            ajax: {
                url: baseurl + "ManufacturingOperationUP2L/Ajax/getEmployee",
                dataType: 'json',
                type: "post",
                data: function (params) {
                    var queryParameters = {
                        term: params.term
                    }
                    return queryParameters;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (obj) {
                            return {
                                id: obj.no_induk + '|' + obj.nama,
                                text: obj.no_induk + " | " + obj.nama
                            };
                        })
                    };
                }
            }
        });
    });


    $('.remove_emp').click(function () {
        var count = $('#container-employee').children().length;
        console.log(count);
        c = count - parseInt(1);
        console.log(c);

        if (count > 1) {
            $(this).parent().remove();
        }

        if (c == 1) {
            $('.remove_emp').hide()
        }
    });

    $('.selcDateUp2L').datepicker({
        autoclose: true,
        format: 'yyyy/mm/dd',
        todayHighlight: true
    });

    $('.time-form1.ajaxOnChange').datepicker({
        autoclose: true,
        format: 'yyyy/mm/dd',
        todayHighlight: true
    });

    $('.time-form1.ajaxOnChange').on('change', function (ev, picker) {
        $('.slcShift').val('').trigger('change');
        if ($('.time-form1').val() == '' || $('.time-form1').val() == null) {
            $('div#print_code_area').html('<div class="col-md-6">' +
                '<small>-- Select production date to generate print code --</small>' +
                '</div>');
        } else {
            $.ajax({
                url: baseurl + 'ManufacturingOperationUP2L/Ajax/getPrintCode',
                type: 'post',
                data: {
                    tanggal: $('.time-form1.ajaxOnChange').val()
                },
                beforeSend: function () {
                    $('div#print_code_area').html('<img src="' + baseurl + 'assets/img/gif/loading5.gif" style="width: auto; padding-left: 25px;">');
                },
                success: function (results) {
                    $('div#print_code_area').html(results);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
                }
            });
        }

        //SHIFT
        $.ajax({
            type: "POST",
            url: baseurl + 'ManufacturingOperationUP2L/Ajax/getShift',
            data: {
                tanggal: $('.time-form1.ajaxOnChange').val()
            },
            dataType: "JSON",
            success: function (response) {
                //console.log(response);
                var html = '';
                html += '<option></option>';
                for (var i = 0; i < response.length; i++) {
                    if (i == 0) {
                        html += '<option value="' + response[i]['DESCRIPTION'] + '">' + response[i]['DESCRIPTION'] + '</option>';
                    } else {
                        html += '<option value="' + response[i]['DESCRIPTION'] + '">' + response[i]['DESCRIPTION'] + '</option>';
                    }
                }
                $('.slcShift').html(html);
            }
        });

    });
});

function getJobData(th) {
    event.preventDefault();
    $.ajax({
        url: baseurl + 'ManufacturingOperationUP2L/Ajax/getJobData',
        type: 'post',
        data: $(th).serialize(),
        beforeSend: function () {
            $('div#jobTableArea').html('<img src="' + baseurl + 'assets/img/gif/loading5.gif" style="width: auto;">');
        },
        success: function (results) {
            $('div#jobTableArea').html(results);
            $('#jobTable').DataTable({
                dom: 'rtBp',
                buttons: ['excel', 'pdf']
            });
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('div#jobTableArea').html('');
            $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
        }
    });
}

function modalReject(th, rowid) {
    $('form#rejectForm input[name="rowID"]').val(rowid);

    var jobNumber = $('div#parentData input[name="jobNumber"').val();
    var assyCode = $('div#parentData input[name="assyCode"').val();
    var assyDesc = $('div#parentData input[name="assyDesc"').val();
    var section = $('div#parentData input[name="section"').val();
    $('form#rejectForm input[name="jobNumber"]').val(jobNumber);
    $('form#rejectForm input[name="assyCode"]').val(assyCode);
    $('form#rejectForm input[name="assyDesc"]').val(assyDesc);
    $('form#rejectForm input[name="section"]').val(section);

    var compCode = $(th).closest('tr').find('input[name="compCode"]').val();
    var compDesc = $(th).closest('tr').find('input[name="compDesc"]').val();
    var qty = $(th).closest('tr').find('input[name="qty"]').val();
    var uom = $(th).closest('tr').find('input[name="uom"]').val();
    var subinv = $(th).closest('tr').find('input[name="subinv"]').val();
    $('form#rejectForm input[name="compCode"]').val(compCode);
    $('form#rejectForm input[name="compDesc"]').val(compDesc);
    $('form#rejectForm input[name="qty"]').val(qty);
    $('form#rejectForm input[name="uom"]').val(uom);
    $('form#rejectForm input[name="subinv"]').val(subinv);

    var qtyReject = $(th).closest('tr').find('td.rejectArea').attr('data-reject');
    var maxReturn = Number(qty) - Number(qtyReject);
    $('form#rejectForm input[name="returnQty"]').attr('max', maxReturn);
    $('form#rejectForm input[name="returnQty"]').val('');
    $('form#rejectForm textarea[name="returnInfo"]').val('');

    $('#rejectForm #btnSubmit').html('PROCEED');
    $('#modalReject').modal('show');
}

function proceedRejectComp() {
    event.preventDefault();
    var rowid = $('form#rejectForm input[name="rowID"]').val();
    $.ajax({
        type: 'POST',
        url: baseurl + 'ManufacturingOperationUP2L/Ajax/setRejectComp',
        data: $('form#rejectForm').serialize(),
        beforeSend: function () {
            $('#rejectForm #btnSubmit').html('<i class="fa fa-spinner fa-pulse" aria-hidden="true"></i>');
        },
        success: function (results) {
            var data = JSON.parse(results);
            $('#rejectTable').DataTable().destroy();
            var rowCount = $('table#rejectTable tbody tr').length;
            var rowNumb = rowCount + 1;
            var rejectQty = $('table#jobTable tbody tr[row-id="' + rowid + '"] td.rejectArea').attr('data-reject');
            var picklistQty = $('table#jobTable tbody tr[row-id="' + rowid + '"] input[name="qty"]').val();
            var newRjctQty = Number(rejectQty) + Number(data[0]['return_quantity']);

            if ($('#generateBtnArea .btnReject').attr('disabled', true)) {
                $('#generateBtnArea .btnReject').attr('disabled', false);
            }
            $('table#jobTable tbody tr[row-id="' + rowid + '"] td.rejectArea').html(newRjctQty);
            if (newRjctQty == picklistQty) {
                $('table#jobTable tbody tr[row-id="' + rowid + '"] button').attr('disabled', true);
            }
            $('table#jobTable tbody tr[row-id="' + rowid + '"] td.rejectArea').attr('data-reject', newRjctQty);

            var deleteSendData = data[0]['replacement_component_id'] + "," + rowNumb + "," + rowid;
            var newRow = jQuery("<tr row-id='" + rowNumb + "'>" +
                "<td>" + rowNumb + "</td>" +
                "<td>" + data[0]['component_code'] + "</td>" +
                "<td>" + data[0]['component_description'] + "</td>" +
                "<td>" + data[0]['return_quantity'] + "</td>" +
                "<td>" + data[0]['uom'] + "</td>" +
                "<td>" + data[0]['return_information'] + "</td>" +
                "<td>" + data[0]['subinventory_code'] + "</td>" +
                "<td>" +
                "<a onclick='deleteRejectComp(" + deleteSendData + ");' class='btn btn-danger btn-block' data-toggle='tooltip' data-placement='left' title='Remove Reject Component'><i class='fa fa-minus'></i></a>" +
                "</td>" +
                "</tr>");
            jQuery("table#rejectTable").append(newRow);
            var subInvData = $('#modalFormReject input[name="subInvData"]').val();
            if (subInvData.trim() == '') {
                $('#modalFormReject input[name="subInvData"]').val(data[0]['subinventory_code']);
                $('#modalFormReject #subinvArea').html('<input type="radio" value="' + data[0]['subinventory_code'] + '"> ' + data[0]['subinventory_code']);
            } else {
                var subInvDataArr = subInvData.split(',');
                if (jQuery.inArray(data[0]['subinventory_code'], subInvDataArr) == -1) {
                    var subInvDataVal = subInvData + ',' + data[0]['subinventory_code'];
                    $('#modalFormReject input[name="subInvData"]').val(subInvDataVal);
                    $('#modalFormReject #subinvArea').html('<input type="radio" value="' + data[0]['subinventory_code'] + '"> ' + data[0]['subinventory_code']);
                }
            }
            $('#rejectTable').DataTable({
                dom: 'frtip'
            });
            $('#modalReject').modal('hide');
            $.toaster('New Reject Component Recorded!', 'Success', 'success');
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('#modalReject').modal('hide');
            $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
        }
    });
}

function deleteRejectComp(replacement_component_id, rowNumb, rowid) {
    $.ajax({
        url: baseurl + 'ManufacturingOperationUP2L/Ajax/deleteRejectComp/' + replacement_component_id,
        success: function (results) {
            var data = JSON.parse(results);
            $('table#rejectTable tbody tr[row-id="' + rowNumb + '"]').remove();
            $('#rejectTable').DataTable().destroy();
            var rowCount = $('table#rejectTable tbody tr').length;
            if (rowCount == 0) {
                $('#generateBtnArea .btnReject').attr('disabled', true);
            }
            var rejectQty = $('table#jobTable tbody tr[row-id="' + rowid + '"] td.rejectArea').attr('data-reject');
            var newRjctQty = Number(rejectQty) + Number(data[0]['return_quantity']);
            $('table#jobTable tbody tr[row-id="' + rowid + '"] td.rejectArea').attr('data-reject', newRjctQty);
            $('#rejectTable').DataTable({
                dom: 'frtip'
            });
            $.toaster('Data was deleted!', 'Deleted', 'success');
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
        }
    });
}

function submitJobKIB(th, jobID) {
    window.open(baseurl + 'ManufacturingOperationUP2L/Job/ReplaceComp/submitJobKIB/' + jobID, '_blank');
}

function deleteMasterItem(id, rowid) {
    var confirmDel = confirm('Apakah anda Yakin?');
    if (confirmDel) {
        $('.hapus').prop('disabled', true);
        $('tr[row-id="' + rowid + '"]').find('i.fa-trash').addClass('fa-spinner fa-spin').removeClass('fa-trash');
        $('.edit').prop('disabled', true);
        $.ajax({
            url: baseurl + 'ManufacturingOperationUP2L/Ajax/deleteItem/' + id,
            success: function (results) {
                var data = JSON.parse(results);
                $('table#masterItem').DataTable().destroy();
                $('table#masterItem tbody tr[row-id="' + rowid + '"]').remove();
                $('table#masterItem').DataTable({
                    dom: 'Bfrtip',
                    buttons: ['excel', 'pdf']
                });
                $.toaster('Data was deleted!', 'Deleted', 'success');
                $('.hapus').prop('disabled', false);
                $('tr[row-id="' + rowid + '"]').find('i.fa-trash').removeClass('fa-spinner fa-spin').addClass('fa-trash');
                $('.edit').prop('disabled', false);

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
            }
        })
    }
}

function editScr(th) {
    var qtyScr = $('#editQtyScrap' + th).html();
    var ambilScr = $('#editTypeScrap' + th).html();
    var ambilCdScr = $('#editCodeScrap' + th).html();

    $('.btnSubmitScrap').attr('onclick', 'updScr(' + th + ')');
    var valScrap = ambilCdScr + " | " + ambilScr;
    console.log(valScrap);

    // var optSlcScr = '<option selected value="' + valScrap + '">' + valScrap + '</option>';
    // var txtSlcdScrap = '<option selected value="' + valScrap + '">' + valScrap +'</option>';
    // $('#txtMdlScrap').val(ambilScr);
    // $('#txtMdlScrap').append(optSlcScr);
    // $('#txtMdlScrap option[value=' + valScrap +']').attr('selected', 'selected');
    // $('#txtScrap').val(type).change();
    // $('#mdlSlcBarang').val('1').trigger('change')
    // $('#mdlSlcBarang').select2({ id: valScrap2, text: valScrap2})
    // $('#mdlSlcBarang').val(valScrap2, 'selected');

    $('#txtMdlScrap').val(ambilCdScr + " | " + ambilScr).trigger('change');
    $('#newQtyScrap').val(qtyScr);
    $('#mdlEditScrap').modal('show');
}

function updScr(th) {
    var idScr = th;
    var qtyScr = $('#newQtyScrap').val();
    var typeScr = $('#txtMdlScrap').val();
    var splttypeScr = typeScr.split("|");

    $.ajax({
        method: 'POST',
        dataType: 'JSON',
        url: baseurl + "ManufacturingOperationUP2L/Moulding/updScr",
        data: {
            idScr: idScr,
            qtyScr: qtyScr,
            typeScr: typeScr
        },
        success: function (response) {
            if (response == 1) {
                $('#editTypeScrap' + th).html(splttypeScr[1]);
                $('#editCodeScrap' + th).html(splttypeScr[0]);
                $('#editQtyScrap' + th).html(qtyScr);
                $('#mdlEditScrap').modal('hide');
            }
        }
    })
}

function editBon(th) {

    var qtyBon = $('#editQtyBongkar' + th).html();
    // console.log(qtyBon);

    $('.btnSubmitBongkar').attr('onclick', 'updBon(' + th + ')');

    $('#newQtyBongkar').val(qtyBon);
    $('#mdlEditBongkar').modal('show');
}

function updBon(th) {
    var idBongkar = th;
    var qtyBon = $('#newQtyBongkar').val();

    $.ajax({
        method: 'POST',
        dataType: 'JSON',
        url: baseurl + "ManufacturingOperationUP2L/Moulding/updBon",
        data: {
            idBongkar: idBongkar,
            qtyBon: qtyBon,
        },
        success: function (response) {
            if (response == 1) {
                $('#editQtyBongkar' + th).html(qtyBon);
                $('#mdlEditBongkar').modal('hide');
            }
        }
    })
}

function delScr(ths) {
    $.ajax({
        method: 'post',
        url: baseurl + 'ManufacturingOperationUP2L/Moulding/delScr/' + ths,
        dataType: 'json',
        success: function (response) {
            if (response == 1) {
                $('tr[data="' + ths + '"]').remove()
            }
        }
    })
}

function delBon(ths) {
    $.ajax({
        method: 'post',
        url: baseurl + 'ManufacturingOperationUP2L/Moulding/delBon/' + ths,
        dataType: 'json',
        success: function (response) {
            if (response == 1) {
                $('tr[data="' + ths + '"]').remove()
            }
        }
    })
}

function deleteMasterScrap(id, rowid) {
    var confirmDel = confirm('Apakah anda Yakin?');
    if (confirmDel) {
        $('.hapus').prop('disabled', true);
        $('tr[row-id="' + rowid + '"]').find('i.fa-trash').addClass('fa-spinner fa-spin').removeClass('fa-trash');
        $('.edit').prop('disabled', true);
        $.ajax({
            url: baseurl + 'ManufacturingOperationUP2L/Ajax/deleteScrap/' + id,
            success: function (results) {
                var data = JSON.parse(results);
                $('table#masterScrap').DataTable().destroy();
                $('table#masterScrap tbody tr[row-id="' + rowid + '"]').remove();
                $('table#masterScrap').DataTable({
                    dom: 'Bfrtip',
                    buttons: ['excel', 'pdf']
                });
                $.toaster('Data was deleted!', 'Deleted', 'success');
                $('.hapus').prop('disabled', false);
                $('tr[row-id="' + rowid + '"]').find('i.fa-trash').removeClass('fa-spinner fa-spin').addClass('fa-trash');
                $('.edit').prop('disabled', false);

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
            }
        })
    }
}

function deleteMasterPersonal(id, rowid) {
    var confirmDel = confirm('Apakah anda Yakin?');
    if (confirmDel) {
        $('.hapus').prop('disabled', true);
        $('tr[row-id="' + rowid + '"]').find('i.fa-trash').addClass('fa-spinner fa-spin').removeClass('fa-trash');
        $('.edit').prop('disabled', true);
        $.ajax({
            url: baseurl + 'ManufacturingOperationUP2L/Ajax/deletePerson/' + id,
            success: function (results) {
                var data = JSON.parse(results);
                $('table#MasterPersonal').DataTable().destroy();
                $('table#MasterPersonal tbody tr[row-id="' + rowid + '"]').remove();
                $('table#MasterPersonal').DataTable({
                    dom: 'Bfrtip',
                    buttons: ['excel', 'pdf']
                });
                $.toaster('Data was deleted!', 'Deleted', 'success');
                $('.hapus').prop('disabled', false);
                $('tr[row-id="' + rowid + '"]').find('i.fa-trash').removeClass('fa-spinner fa-spin').addClass('fa-trash');
                $('.edit').prop('disabled', false);

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
            }
        })
    }
}

function editMasterItem(id) {
    $.ajax({
        url: baseurl + 'ManufacturingOperationUP2L/Ajax/editItem/' + id,
        success: function (results) {
            console.log(results);
            $('#editMasterItem').html(results);
        },
        error: function (results) {
            console.log('error');
        }
    })
}

function editMasterScrap(id) {
    $.ajax({
        url: baseurl + 'ManufacturingOperationUP2L/Ajax/editScrap/' + id,
        success: function (results) {
            console.log(results);
            $('#editMasterScrap').html(results);
        },
        error: function (results) {
            console.log('error');
        }
    })
}

function editMasterPerson(id) {
    $.ajax({
        url: baseurl + 'ManufacturingOperationUP2L/Ajax/editPerson/' + id,
        success: function (results) {
            console.log(results);
            $('#editMasterPerson').html(results);
        },
        error: function (results) {
            console.log('error');
        }
    })
}

function checkQuantity(th) {
    var id = $('#mould_id').val().trim();
    var scrap = $('#scrap_qty').val().trim();
    var quantity = $('#checking_qty').val().trim();

    var date = $('#production_date').text().trim();
    var selep_qty = $('#selep_qty').text().trim();
    var employee = $('#job_id').text().trim();
    var component = $('#component_code').text().trim();
    var description = $('#description').text().trim();
    var shift = $('#shift').text().trim();


    if ((parseInt(scrap) + parseInt(quantity)) > parseInt(selep_qty)) {
        alert('Jumlah melebihi quantity');
    } else {

        var remain = parseInt(selep_qty) - (parseInt(scrap) + parseInt(quantity));
        
        $.ajax({
            type: 'post',
            url: baseurl + 'ManufacturingOperationUP2L/Ajax/addQuality',
            data: {
                SCRAP: scrap,
                CHECK: quantity,
                REMAIN: remain,
                CHECKING_DATE: date,
                COMPONENT: component,
                SHIFT: shift,
                EMPLOYEE: employee,
                DESCRIPTION: description,
                SELEPQTY: selep_qty,
                ID: id
            },
            success: function (results) {
                window.location.replace(baseurl + 'ManufacturingOperationUP2L/QualityControl');
                
            },
            error: function (error, status, f, s) {
                console.log(error);
            }
        });
    }
}

$('.add_scrap').click(function () {
    var type = $('#txtScrap').val();
    var qty = $('#scrap_qty').val();
    var mould_qty = $('#mould_qty').val();
    var id = $('#mould_id').val();
    var jml = $('#jumlah_scrap').val();
    if (jml == '-') {
        total = parseInt(0);
    } else {
        total = jml;
    }
    var jumlah = parseInt(qty) + parseInt(total);

    console.log(jumlah);
    if (jumlah > mould_qty) {
        alert('Jumlah scrap melebihi quantity moulding');
    } else {
        $.ajax({
            type: 'post',
            url: baseurl + 'ManufacturingOperationUP2L/Ajax/addScrap/',
            data: {
                id: id,
                qty: qty,
                type: type
            },
            success: function (results) {
                location.reload();
            },
            error: function (results) {
                alert('error');
            }
        });
    }
})

$('.add_bongkar').click(function () {
    var qty = $('#bongkar_qty').val();
    var mould_qty = $('#mould_qty').val();
    var id = $('#mould_id').val();
    var jml = $('#jumlah_bongkar').val();

    console.log(qty);
    console.log(mould_qty);
    console.log(id);
    console.log(jml);

    if (jml == '-') {
        total = parseInt(0);
    } else {
        total = jml;
    }

    var jumlah = parseInt(qty) + parseInt(total);

    console.log(jumlah);
    if (jumlah > mould_qty) {
        alert('Jumlah scrap melebihi quantity moulding');
    } else {
        $.ajax({
            type: 'post',
            url: baseurl + 'ManufacturingOperationUP2L/Ajax/addBongkar/',
            data: {
                id: id,
                qty: qty
            },
            success: function (results) {
                location.reload();
            },
            error: function (results) {
                alert('error');
            }
        });
    }
})

$("#tanggal_cetak").on("click", function () {

    var val = $('.time-form').val();
    console.log(val);

    $.ajax({
        url: baseurl + 'ManufacturingOperationUP2L/Ajax/getDatePrintCode',
        type: 'post',
        dataType: 'json',
        data: {
            TANGGAL: val
        },
        beforeSend: function () {
            $('div#jobTableArea').html('<img src="' + baseurl + 'assets/img/gif/loading5.gif" style="width: auto;">');
        },
        complete: function () {

        },
        success: function (results) {
            $("#tableQuality").empty();
            var html = '';
            $.each(results, function (i, data) {
                html += "<tr><td align='center'>" + (i + 1) + "</td>" +
                    "<td align='center'>" +
                    "<a href='" + baseurl + "ManufacturingOperationUP2L/QualityControl/read_detail/" + data.selep_id + "' data-toggle='tooltip' data-placement='bottom' title='Read Data'><i class='fa fa-list-alt fa-2x'></i></a>" +
                    "</td>" +
                    "<td>" + data.component_code + "</td>" +
                    "<td>" + data.component_description + "</td>" +
                    "<td>" + data.selep_date + "</td>" +
                    "<td>" + data.shift + "</td>" +
                    "<td>" + data.selep_quantity + "</td>" +
                    "<td>" + data.job_id + "</td></tr>";
            });

            $("#tableQuality").append(html);

        },
        error: function (textStatus, errorThrown) {
            $('div#jobTableArea').html('');
            console.log(textStatus);
            $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
        }
    });
});

function searchDateUP2L() {
    var dateQCUp2l = $('#dateQCUp2l').val();
    if (dateQCUp2l == ''){}
    else{
        $.ajax({
        dataType:"JSON",
        type:"POST",
        url: baseurl + 'ManufacturingOperationUP2L/QualityControl/selectByDate',
        data:{
            dateQCUp2l:dateQCUp2l
        },
        success: function () {
            alert('sukses')
        }
    })
    }
};

// QC Checking Qty OK dan Scrap

$('#mo_txtScrapQuantityHeader').on('change', function () {
    var txtSelepQuantityHeader = Number($('#mo_txtSelepQuantityHeader').val());
    var txtCheckingQuantityHeader = Number($('#mo_txtCheckingQuantityHeader').val());
    var txtScrapQuantityHeader = Number($('#mo_txtScrapQuantityHeader').val());
    if ((txtCheckingQuantityHeader + txtScrapQuantityHeader) >  txtSelepQuantityHeader) {
        alert("Jumlah Checking ditambah Scrap melebihi Selep Qty");
        $('#mo_txtCheckingQuantityHeader').val('');
    } else { }
})
$('#mo_txtCheckingQuantityHeader').on('change', function () {
    var txtSelepQuantityHeader = Number($('#mo_txtSelepQuantityHeader').val());
    var txtCheckingQuantityHeader = Number($('#mo_txtCheckingQuantityHeader').val());
    var txtScrapQuantityHeader = Number($('#mo_txtScrapQuantityHeader').val());
    if ((txtCheckingQuantityHeader + txtScrapQuantityHeader) >  txtSelepQuantityHeader) {
        alert("Jumlah Checking ditambah Scrap melebihi Selep Qty");
        $('#mo_txtScrapQuantityHeader').val('');
    } else { }
})

$(function () {
    $('#mo_button1').addClass('active');
    $('#mo_tab2').css("display", "none");
    $('#sear_2').css("display", "none");

    $('#ottShift').select2({
        allowClear: true,
        tags: true,
        placeholder: "ex : SHIFT 1",
        minimumInputLength: 7,
        ajax : {
            type: "GET",
            placeholder: 'Shift',
            url: baseurl + 'ManufacturingOperationUP2L/Ajax/getAllShift',
            dataType: "JSON",
            data: function (params) {
                var queryParameters = {
                    term: params.term
                };
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return {
                            id: obj.DESCRIPTION,
                            text: obj.DESCRIPTION
                        };
                    })
                };
            }
        }
    })
});

$('#mo_button1').click(function () {
    $('#mo_button1').addClass('active');
    $('#mo_button2').removeClass('active');
    $('#mo_tab2').css("display", "none");
    $('#mo_tab1').removeAttr('style');
    $('#sear_2').css("display", "none");
    $('#sear_1').removeAttr('style');
})

$('#mo_button2').click(function () {
    $('#mo_button2').addClass('active');
    $('#mo_button1').removeClass('active');
    $('#mo_tab1').css("display", "none");
    $('#mo_tab2').removeAttr('style');
    $('#sear_1').css("display", "none");
    $('#sear_2').removeAttr('style');
})

if($('#up2l_tmpl').val() == 'A1'){
    $('#mo_button2').hide();
    jQuery(function(){
        jQuery('#mo_button1').click();
     });
} else if ($('#up2l_tmpl').val() == 'A2'){
    $('#mo_button1').hide();
    jQuery(function(){
        jQuery('#mo_button2').click();
     });
}

$(function(){
    $('#ott_Name').select2();
    $('#ottKodeP').select2();
})

function ottPlusBtn(){
    
    var ottPlus =
    `<br /><br /><select name="ottName[]" id="ott_Name" class="form-control ottName" required>
    <option value="">Pilih Pekerja</option>
    <option name="ottName" value="<?= $pekerja?>"><?= $pekerja?></option>
    </select>`;

    $('#tmpNama').append(ottPlus);
    
    $('.ottName').select2({
        minimumInputLength: 0,
        placeholder: 'Pilih Pekerja',
        allowClear: true,
        ajax: {
            method: 'GET',
            url: baseurl + 'ManufacturingOperationUP2L/Absen/pekerja',
            dataType: 'JSON',
            data: function (param) {
                return param.term
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return {
                            id: obj.no_induk + " | " + obj.nama,
                            text: obj.no_induk + " | " + obj.nama
                        };
                    })
                };
            }
        }
    })
}

function ottTimesBtn() {
    var ottPlus =
    `<select name="ottName[]" id="ott_Name" class="form-control ottName" required>
    <option value="">Pilih Pekerja</option>
    <option name="ottName" value="<?= $pekerja?>"><?= $pekerja?></option>
    </select>`;
    $('#tmpNama').html(ottPlus);
    $('.ottName').select2({
        minimumInputLength: 0,
        placeholder: 'Pilih Pekerja',
        allowClear: true,
        ajax: {
            method: 'GET',
            url: baseurl + 'ManufacturingOperationUP2L/Absen/pekerja',
            dataType: 'JSON',
            data: function (param) {
                return param.term
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return {
                            id: obj.no_induk + " | " + obj.nama,
                            text: obj.no_induk + " | " + obj.nama
                        };
                    })
                };
            }
        }
    })
}

