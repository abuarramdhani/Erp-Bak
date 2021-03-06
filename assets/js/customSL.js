$(document).ready(function() {
    $(".select-2").select2({
        allowClear: true,
        placeholder: "Choose Option"
    });
    $(".jsComponent").select2({
        allowClear: true,
        placeholder: "Choose Component Code",
        ajax: {
            url: baseurl + "StorageLocation/Ajax/getComponentCode",
            dataType: 'json',
            type: "post",
            data: function(params) {
                var queryParameters = {
                    term: params.term,
                    org_id: $('select#IdOrganization').val()
                }
                return queryParameters;
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return {
                            id: obj.SEGMENT1 + '|' + obj.DESCRIPTION,
                            text: obj.SEGMENT1 + " | " + obj.DESCRIPTION
                        };
                    })
                };
            }
        },
        minimumInputLength: 3
    });
    $(".jsCompByAssy").select2({
        allowClear: true,
        placeholder: "Choose Component Code",
        ajax: {
            url: baseurl + "StorageLocation/Ajax/getComponentCode",
            dataType: 'json',
            type: "post",
            data: function(params) {
                var queryParameters = {
                    term: params.term,
                    org_id: $('select#IdOrganization').val(),
                    assy: $("select#SlcKodeAssy option:selected").val()
                }
                return queryParameters;
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return {
                            id: obj.SEGMENT1 + '|' + obj.DESCRIPTION,
                            text: obj.SEGMENT1 + " | " + obj.DESCRIPTION
                        };
                    })
                };
            }
        },
        minimumInputLength: 0
    });
    $(".jsAssembly").select2({
        placeholder: " Choose Assembly Code",
        allowClear: true,
        ajax: {
            url: baseurl + "StorageLocation/Ajax/GetAssy",
            dataType: 'json',
            type: "POST",
            data: function(params) {
                var queryParameters = {
                    term: params.term,
                    org_id: $('select#IdOrganization').val()
                }
                return queryParameters;
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return {
                            id: obj.SEGMENT1 + '|' + obj.DESCRIPTION + '|' + obj.ASSTYPE,
                            text: obj.SEGMENT1 + " - " + obj.DESCRIPTION
                        };
                    })
                };
            }
        },
        minimumInputLength: 3
    });
    $('#table1').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        // "ordering": false,
        "info": false,
        "autoWidth": false,
    });
});

function GetDescription(m) {
    var component = $(m).val();
    var a = component.split('|');
    $("input#txtDesc").val(a[1]);
}

function GetDescAssy() {
    var data = $("select#SlcKodeAssy option:selected").attr('value');
    var a = data.split('|');
    $('input#txtNameAssy').val(a[1]);
    $('input#txtTypeAssy').val(a[2]);
}

function GetName(th) {
    var val = $(th).val();
    var desc = val.split('|');
    $(th).closest('tr').find('input.nama_input').val(desc[1]);
}

function koreksi_table(base) {
    document.getElementById("table_koreksi").hidden = false;
}

function perKopm(base) {
    document.getElementById("formPerSA").hidden = true;
    document.getElementById("formPerKopm").hidden = false;
}

function perSA(base) {
    document.getElementById("formPerSA").hidden = false;
    document.getElementById("formPerKopm").hidden = true;
}

function searchComponent(base) {
    var base_url = base;
    var org = $('#IdOrganization').val();
    var sub_inv = $("#SlcSubInventori").val();
    var item = $("#SlcItem").val();
    if (item !== null) {
        var compnt = item.split('|');
    } else {
        var compnt = '';
    }
    var locator = $("#SlcLocator").val();
    var request = $.ajax({
        url: base_url + "StorageLocation/Correction/searchComponent",
        type: 'POST',
        data: {
            org: org,
            sub_inv: sub_inv,
            item: compnt[0],
            locator: locator
        },
        dataType: "html"
    });
    $('#res').html("<center><img id='loading' style='margin-top: 2%; ' src='" + base_url + "assets/img/gif/loading5.gif'/><p style='color:#575555;'>Searching Data</p></center><br />");
    request.done(function(output) {
        window.setTimeout(function() {
            $('#res').html('');
            $('#res').html(output);
            $(".jsComponent").select2({
                allowClear: true,
                placeholder: "Choose Component Code",
                ajax: {
                    url: baseurl + "StorageLocation/Ajax/getComponentCode",
                    dataType: 'json',
                    type: "post",
                    data: function(params) {
                        var queryParameters = {
                            term: params.term,
                            org_id: $(this).closest('tr').find('input.org_id').val()
                        }
                        return queryParameters;
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(obj) {
                                return {
                                    id: obj.SEGMENT1 + '|' + obj.DESCRIPTION,
                                    text: obj.SEGMENT1 + " | " + obj.DESCRIPTION
                                };
                            })
                        };
                    }
                },
                minimumInputLength: 3
            });
            $(".slcSubInv").select2({
                ajax: {
                    url: baseurl + "StorageLocation/Ajax/GetSubinventori",
                    dataType: 'json',
                    type: "post",
                    data: function(params) {
                        var queryParameters = {
                            term: params.term,
                            org_id: $(this).closest('tr').find('input.org_id').val()
                        }
                        return queryParameters;
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(obj) {
                                return {
                                    id: obj.SEGMENT1 + '|' + obj.DESCRIPTION,
                                    text: obj.SEGMENT1 + " | " + obj.DESCRIPTION
                                };
                            })
                        };
                    }
                }
            });
            $.fn.dataTable.ext.order['dom-select'] = function(settings, col) {
                return this.api().column(col, {
                    order: 'index'
                }).nodes().map(function(td, i) {
                    return $('select', td).val();
                });
            };
            $('#table_comp').DataTable({
                "dom": '<"pull-left"f>tip',
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "info": false,
                "autoWidth": false,
                "columns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null, {
                        "orderDataType": "dom-text",
                        type: 'string'
                    }, {
                        "orderDataType": "dom-select"
                    }, {
                        "orderDataType": "dom-select"
                    }
                ]
            });
            $(".select-2").select2({
                allowClear: false,
                placeholder: "Choose Option"
            });
        }, 1000);
    });
}

function searchAssy(base) {
    var base_url = base;
    var org = $('#IdOrganization').val()
    var sub_inv = $("#SlcSubInventori").val();
    var a = $("#SlcKodeAssy").val();
    if (a !== null) {
        var b = a.split('|');
        var kode_assy = b[0];
    } else {
        var kode_assy = '';
    }
    var request = $.ajax({
        url: base_url + "StorageLocation/Correction/searchAssy",
        type: "post",
        data: {
            org: org,
            sub_inv: sub_inv,
            kode_assy: kode_assy
        },
        dataType: "html"
    });
    $('#res').html('');
    $('#res').html("<center><img id='loading' style='margin-top: 2%; ' src='" + base_url + "assets/img/gif/loading5.gif'/><br /><p style='color:#575555;'>Searching Data</p></center><br />");
    request.done(function(output) {
        window.setTimeout(function() {
            $('#res').html('');
            $('#res').html(output);
            $(".jsComponent").select2({
                allowClear: true,
                placeholder: "Choose Component Code",
                ajax: {
                    url: baseurl + "StorageLocation/Ajax/getComponentCode",
                    dataType: 'json',
                    type: "post",
                    data: function(params) {
                        var queryParameters = {
                            term: params.term,
                            org_id: $(this).closest('tr').find('input.org_id').val()
                        }
                        return queryParameters;
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(obj) {
                                return {
                                    id: obj.SEGMENT1 + '|' + obj.DESCRIPTION,
                                    text: obj.SEGMENT1 + " | " + obj.DESCRIPTION
                                };
                            })
                        };
                    }
                },
                minimumInputLength: 3
            });
            $(".slcSubInv").select2({
                ajax: {
                    url: baseurl + "StorageLocation/Ajax/GetSubinventori",
                    dataType: 'json',
                    type: "post",
                    data: function(params) {
                        var queryParameters = {
                            term: params.term,
                            org_id: $(this).closest('tr').find('input.org_id').val()
                        }
                        return queryParameters;
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(obj) {
                                return {
                                    id: obj.SEGMENT1 + '|' + obj.DESCRIPTION,
                                    text: obj.SEGMENT1 + " | " + obj.DESCRIPTION
                                };
                            })
                        };
                    }
                }
            });
            $.fn.dataTable.ext.order['dom-select'] = function(settings, col) {
                return this.api().column(col, {
                    order: 'index'
                }).nodes().map(function(td, i) {
                    return $('select', td).val();
                });
            };
            $('#table_SA').DataTable({
                "dom": '<"pull-left"f>tp',
                "paging": true,
                "searching": true,
                "columns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null, {
                        "orderDataType": "dom-text",
                        type: 'string'
                    }, {
                        "orderDataType": "dom-select"
                    }, {
                        "orderDataType": "dom-select"
                    }
                ]
            });
            $(".select-2").select2({
                allowClear: false,
                placeholder: "Choose Option"
            });
        }, 1000);
    });
}

function monkompactive(base) {
    document.getElementById("findbyKomp").hidden = false;
    document.getElementById("findbySA").hidden = true;
    document.getElementById("findbyAll").hidden = true;
    document.getElementById("button1").hidden = false;
    document.getElementById("button2").hidden = true;
    document.getElementById("button3").hidden = true;
    $('#monsa').removeClass("active");
    $('#monkomp').addClass("active");
    $('#monall').removeClass("active");
}

function monsaactive(base) {
    document.getElementById("findbyKomp").hidden = true;
    document.getElementById("findbySA").hidden = false;
    document.getElementById("findbyAll").hidden = true;
    document.getElementById("button1").hidden = true;
    document.getElementById("button2").hidden = false;
    document.getElementById("button3").hidden = true;
    $('#monkomp').removeClass("active");
    $('#monsa').addClass("active");
    $('#monall').removeClass("active");
}

function monallactive(base) {
    document.getElementById("findbyKomp").hidden = true;
    document.getElementById("findbySA").hidden = true;
    document.getElementById("findbyAll").hidden = false;
    document.getElementById("button1").hidden = true;
    document.getElementById("button2").hidden = true;
    document.getElementById("button3").hidden = false;
    $('#monsa').removeClass("active");
    $('#monkomp').removeClass("active");
    $('#monall').addClass("active");
}

function searchByKomp(base) {
    var sub_inv = $("#SlcSubInventori").val();
    var locator = $("#SlcLocator").val();
    var compnt = $("#SlcItem").val();
    var org = $('select#IdOrganization').val()
    var request = $.ajax({
        url: base + "StorageLocation/AddressMonitoring/searchByKomp",
        data: {
            sub_inv: sub_inv,
            locator: locator,
            kode_item: compnt,
            org: org
        },
        type: "post",
        dataType: "html"
    });
    $('#result').html("<center><img id='loading' style='margin-top: 2%; ' src='" + base + "assets/img/gif/loading5.gif'/><p style='color:#575555;'>Searching Data</p></center><br />");
    request.done(function(output) {
        window.setTimeout(function() {
            $('#result').html('');
            $('#result').html(output);
            $.fn.dataTable.ext.order['dom-checkbox'] = function(settings, col) {
                return this.api().column(col, {
                    order: 'index'
                }).nodes().map(function(td, i) {
                    return $('input', td).prop('checked') ? '1' : '0';
                });
            };
            $('#tableMonitor').dataTable({
                "dom": '<"pull-left"f>tp',
                "paging": true,
                "searching": true,
                "columns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null, {
                        "orderDataType": "dom-checkbox"
                    }, {
                        "orderDataType": "dom-checkbox"
                    }
                ]
            });
        }, 1000);
    });
}

function searchBySA(base) {
    var sub_inv = $("#SlcSubInventori").val();
    var locator = $("#SlcLocator").val();
    var a = $("#SlcKodeAssy").val();
    var b = a.split('|', 1);
    var assy = b[0];
    var org = $('select#IdOrganization').val()
    var request = $.ajax({
        url: base + "StorageLocation/AddressMonitoring/searchBySA",
        data: {
            sub_inv: sub_inv,
            locator: locator,
            kode_assy: assy,
            org_id: org
        },
        type: "post",
        dataType: "html"
    });
    $('#result').html("<center><img id='loading' style='margin-top: 2%; ' src='" + base + "assets/img/gif/loading5.gif'/><p style='color:#575555;'>Searching Data</p></center><br />");
    request.done(function(output) {
        window.setTimeout(function() {
            $('#result').html('');
            $('#result').html(output);
            $.fn.dataTable.ext.order['dom-checkbox'] = function(settings, col) {
                return this.api().column(col, {
                    order: 'index'
                }).nodes().map(function(td, i) {
                    return $('input', td).prop('checked') ? '1' : '0';
                });
            };
            $('#tableMonitor').dataTable({
                "dom": '<"pull-left"f>tp',
                "paging": true,
                "searching": true,
                "columns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null, {
                        "orderDataType": "dom-checkbox"
                    }, {
                        "orderDataType": "dom-checkbox"
                    }
                ]
            });
        }, 1000);
    });
}

function searchByAll(base) {
    var base_url = base;
    var sub_inv = $("#SlcSubInventori").val();
    var locator = $("#SlcLocator").val();
    var alamat = $("#txtAlamat").val();
    var request = $.ajax({
        type: 'POST',
        url: base + "StorageLocation/AddressMonitoring/searchByAll",
        data: {
            sub_inv: sub_inv,
            locator: locator,
            alamat: alamat
        },
        dataType: 'html'
    });
    $('#result').html("<center><img id='loading' style='margin-top: 2%; ' src='" + base + "assets/img/gif/loading5.gif'/><p style='color:#575555;'>Searching Data</p></center><br />");
    request.done(function(output) {
        window.setTimeout(function() {
            $('#result').html('');
            $('#result').html(output);
            $.fn.dataTable.ext.order['dom-checkbox'] = function(settings, col) {
                return this.api().column(col, {
                    order: 'index'
                }).nodes().map(function(td, i) {
                    return $('input', td).prop('checked') ? '1' : '0';
                });
            };
            $('#tableMonitor').dataTable({
                "dom": '<"pull-left"f>tp',
                "paging": true,
                "searching": true,
                "columns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null, {
                        "orderDataType": "dom-checkbox"
                    }, {
                        "orderDataType": "dom-checkbox"
                    }
                ]
            });
        }, 1000);
    });
}

function updateStorage(e, th) {
    if (e.keyCode === 13) {
        var ID  = $(th).closest('tr').find('.ID').val();
        var alamat = $(th).val();
        $.ajax({
            type: 'POST',
            url: baseurl + "StorageLocation/Correction/saveAlamat",
            data: {
                alamat: alamat,
                ID: ID
            },
            success: function(result) {
                alert('edit berhasil!');
            },
            error: function() {
                alert('terjadi kesalahan');
            }
        })
    }
}

function updateLMK(th) {
    var ID  = $(th).closest('tr').find('.ID').val();
    var lmk = $(th).val();
    $.ajax({
        type: 'POST',
        url: baseurl + "StorageLocation/Correction/saveLmk",
        data: {
            lmk: lmk,
            ID: ID
        },
        success: function(result) {
            alert('edit berhasil!');
        },
        error: function() {
            alert('terjadi kesalahan');
        }
    });
}

function updatePicklist(th) {
    var ID        = $(th).closest('tr').find('.ID').val();
    var picklist = $(th).val();
    $.ajax({
        type: 'POST',
        url: baseurl + "StorageLocation/Correction/savePicklist",
        data: {
            picklist: picklist,
            ID: ID
        },
        success: function(result) {
            alert('edit berhasil!');
        },
        error: function() {
            alert('terjadi kesalahan');
        }
    });
}

function lmkcheck(en, th) {
    if ($(th).is(':checked')) {
        $(th).closest('td').find('.lmk_check').prop("disabled", true);
    } else {
        $(th).closest('td').find('.lmk_check').prop("disabled", false);
    }
}

function pickcheck(en, th) {
    if ($(th).is(':checked')) {
        $(th).closest('td').find('.pick_check').prop("disabled", true);
    } else {
        $(th).closest('td').find('.pick_check').prop("disabled", false);
    }
}
$('#SlcSubInventori2').change(function() {
    var sub_inv = $(this).val();
    $('#SlcLocator2').select2('val', null);
    $('#SlcLocator2').prop('disabled', true);
    $.ajax({
        type: 'POST',
        url: baseurl + "StorageLocation/Ajax/locator",
        data: {
            sub_inv: sub_inv
        },
        success: function(result) {
            if (result != '<option></option>') {
                $('#SlcLocator2').prop('disabled', false).html(result);
            }
        }
    })
});

function add_row(tableID) {
    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
    var colCount = table.rows[0].cells.length;
    for (var i = 0; i < colCount; i++) {
        var newcell = row.insertCell(i);
        $('.jsCompByAssy').select2('destroy');
        $('.select-2').select2('destroy');
        newcell.innerHTML = table.rows[1].cells[i].innerHTML;
        $(".jsCompByAssy").select2({
            allowClear: true,
            placeholder: "Choose Component Code",
            ajax: {
                url: baseurl + "StorageLocation/Ajax/getComponentCode",
                dataType: 'json',
                type: "POST",
                data: function(params) {
                    var queryParameters = {
                        term: params.term,
                        org_id: $('select#IdOrganization').val(),
                        assy: $("select#SlcKodeAssy option:selected").val()
                    }
                    return queryParameters;
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(obj) {
                            return {
                                id: obj.SEGMENT1 + '|' + obj.DESCRIPTION,
                                text: obj.SEGMENT1 + " | " + obj.DESCRIPTION
                            };
                        })
                    };
                }
            },
            minimumInputLength: 0
        });
        $(".select-2").select2({
            allowClear: true,
            placeholder: "Choose Option"
        });
        switch (newcell.childNodes[0].type) {
            case "text":
                newcell.childNodes[0].value = "";
                break;
            case "checkbox":
                newcell.childNodes[0].checked = false;
                break;
        }
    }
}

function delete_row(tableID) {
    try {
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;
        var i = rowCount - 1;
        if (rowCount > 2) {
            table.deleteRow(i);
        } else {
            alert('Baris Tidak Tersedia');
        }
    } catch (e) {
        alert(e);
    }
}

function getSubInvent() {
    var org_id = $('select#IdOrganization').val();
    $.ajax({
        type: 'POST',
        data: {
            org_id: org_id
        },
        url: baseurl + 'StorageLocation/Ajax/GetSubinventori',
        cache: false,
        success: function(result) {
            $('select#SlcSubInventori').prop('disabled', false);
            $('select#SlcSubInventori').html(result);
            $('select#SlcItem').prop('disabled', false);
            $('select#SlcKodeAssy').prop('disabled', false);
        }
    });
}

function getLocator() {
    var sub_inv = $('select#SlcSubInventori').val();
    $('select#SlcLocator').val('');
    $('select#SlcLocator').prop('disabled', true);
    $.ajax({
        type: 'POST',
        url: baseurl + "StorageLocation/Ajax/locator",
        data: {
            sub_inv: sub_inv
        },
        success: function(result) {
            if (result != 0) {
                $('#SlcLocator').prop('disabled', false).html(result);
            }
        }
    });
}

function getKodeAssem() {
    var val = $("select#SlcItem option:selected").val();
    var desc = val.split('|');
    $("input#txtDesc").val(desc[1]);
    $.ajax({
        type: 'POST',
        url: baseurl + "StorageLocation/Ajax/GetAssy",
        data: {
            org_id: $('select#IdOrganization').val(),
            item: desc[0]
        },
        success: function(result) {
            if (result != 0) {
                $('select#SlcKodeAssy').prop('disabled', false).html(result);
            }
        }
    });
}

function getDescTypeAssy() {
    var desc = $('select#SlcKodeAssy option:selected').attr('data-desc');
    var type = $('select#SlcKodeAssy option:selected').attr('data-type');
    $("input#txtNameAssy").val(desc);
    if (type == '' || type == null) {
        $("input#txtTypeAssy").val('-');
    } else {
        $("input#txtTypeAssy").val(type);
    }
}

function updateCompCode(th) {
    var a           = $(th).val();
    var b           = a.split('|');
    var compCode    = b[0];
    var ID          = $(th).closest('tr').find('.ID').val();
    $.ajax({
        type: 'POST',
        url: baseurl + "StorageLocation/Correction/compCodeSave",
        data: {
            compCode: compCode,
            ID: ID
        },
        success: function(result) {
            $(th).closest('tr').find('td.compDescArea').html(b[1]);
            alert('edit berhasil!');
        },
        error: function() {
            alert('terjadi kesalahan');
        }
    });
}

function updateSubInv(th) {
    var sub_inv     = $(th).val();
    var ID        = $(th).closest('tr').find('.ID').val();
    $.ajax({
        type: 'POST',
        url: baseurl + "StorageLocation/Correction/subInvSave",
        data: {
            sub_inv: sub_inv,
            ID: ID
        },
        success: function(result) {
            alert('edit berhasil!');
        },
        error: function() {
            alert('terjadi kesalahan');
        }
    });
}

function DeleteConfir(th,no){
    var id          = $(th).closest('tr').find('.ID').val();
    var assCode     = $(th).attr('data-assCode');
    var compCode    = $(th).closest('tr').find('.item').val();
    var sub_inv     = $(th).closest('tr').find('.sub_inv').val();
    var alamat      = $(th).closest('tr').find('.alamat').val();
    var lmk         = $(th).closest('tr').find('.lmk').val();
    var picklist    = $(th).closest('tr').find('.picklist').val();
    if (lmk == '1') {
        var ctkLMK = "YES";
    }else{
        var ctkLMK = "NO";
    }
    if (picklist == '1') {
        var ctkPick = "YES";
    }else{
        var ctkPick = "NO";
    }
    $('#mdlStrgLoc #deleteIdData').val(id);
    $('#mdlStrgLoc #tdno').html(no);
    $('#mdlStrgLoc #tdassCode').html(assCode);
    $('#mdlStrgLoc #tdcompCode').html(compCode);
    $('#mdlStrgLoc #tdsubInv').html(sub_inv);
    $('#mdlStrgLoc #tdstrgLoc').html(alamat);
    $('#mdlStrgLoc #tdLMK').html(ctkLMK);
    $('#mdlStrgLoc #tdpick').html(ctkPick);
    $('#mdlStrgLoc').modal();
}