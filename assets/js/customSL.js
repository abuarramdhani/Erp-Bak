$(document).ready(function() {
    $("#form").submit(function() {
        $(this + 'input[type=checkbox]:not(:checked)').each(function() {
            $(this).attr('checked', true).val(0);
        });
    });
    $(".select-2").select2({
        allowClear: true,
        placeholder: "Choose Option"
    });
    $(".jsSubinventori").select2({
        tags: true,
        placeholder: "Choose Sub Inventory",
        allowClear: true,
        minimumInputLength: 0,
        ajax: {
            url: baseurl + "StorageLocation/Ajax/GetSubinventori",
            dataType: 'json',
            type: "GET",
            data: function(params) {
                var queryParameters = {
                    term: params.term,
                    org: $('input[name="txtOrg"]:checked').val()
                }
                return queryParameters;
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return {
                            id: obj.SECONDARY_INVENTORY_NAME,
                            text: obj.SECONDARY_INVENTORY_NAME
                        };
                    })
                };
            }
        }
    });
    $(".jsItem").select2({
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
                            id: obj.SEGMENT1+'|'+obj.DESCRIPTION,
                            text: obj.SEGMENT1 + " | " + obj.DESCRIPTION
                        };
                    })
                };
            }
        },
        minimumInputLength: 3
    });
    $(".jsAssembly").select2({
        tags: true,
        placeholder: " Pilih Kode Assembly",
        allowClear: true,
        ajax: {
            url: baseurl + "StorageLocation/Ajax/GetAssy",
            dataType: 'json',
            type: "GET",
            data: function(params) {
                var queryParameters = {
                    term: params.term,
                    org: $('select#IdOrganization').val(),
                    item: $('select[name="SlcItem"]').val()
                }
                return queryParameters;
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return {
                            id: obj.SEGMENT1,
                            text: obj.SEGMENT1 + " - " + obj.DESCRIPTION
                        };
                    })
                };
            }
        }
    });
    $('#table_comp').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": false,
    });
    $('#table_SA').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": false,
    });
    $('#table1').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": false,
    });
});

function GetDescription(base) {
    var kode_item = $("select#SlcItem option:selected").attr('value');
    $.post(base + "StorageLocation/Ajax/getDescriptionItem", {
        id: kode_item
    }, function(data) {
        $("input#txtDesc").val(data);
    })
}

function GetDescAssy(base) {
    var kode_assy = $("select#SlcKodeAssy option:selected").attr('value');
    $.post(base + "StorageLocation/Ajax/getDescriptionAssy", {
        id: kode_assy
    }, function(data) {
        $("input#txtNameAssy").val(data);
    });
    $.post(base + "StorageLocation/Ajax/getTypeAssy", {
        id: kode_assy
    }, function(data) {
        $("input#txtTypeAssy").val(data);
    });
}

function GetName(base, en, th) {
    var kode_item = $(th).val();
    $.post(base + "StorageLocation/Ajax/getDescriptionItem", {
        id: kode_item
    }, function(data) {
        $(th).closest('tr').find('.nama_input').val(data);
    })
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
    var locator = $("#SlcLocator").val();
    var request = $.ajax({
        url: base_url + "StorageLocation/Ajax/searchComponent",
        data: "org=" + org + "&sub_inv=" + sub_inv + "&item=" + item + "&locator=" + locator,
        type: "GET",
        dataType: "html"
    });
    $('#res').html("<center><img id='loading' style='margin-top: 2%; ' src='" + base_url + "assets/img/gif/loading5.gif'/><p style='color:#575555;'>Searching Data</p></center><br />");
    request.done(function(output) {
        window.setTimeout(function() {
            $('#res').html(''); //Prints the progress text into our Progress DIV
            $('#res').html(output); //Prints the data into the table
        }, 1000);
    });
}

function searchAssy(base) {
    var base_url = base;
    var org = $('input[name="txtOrg"]:checked').val()
    var kode_assy = $("#SlcKodeAssy").val();
    var sub_inv = $("#SlcSubInventori2").val();
    var request = $.ajax({
        url: base_url + "StorageLocation/Ajax/searchAssy",
        data: "org=" + org + "&sub_inv=" + sub_inv + "&kode_assy=" + kode_assy,
        type: "GET",
        dataType: "html"
    });
    $('#res').html('');
    $('#res').html("<center><img id='loading' style='margin-top: 2%; ' src='" + base_url + "assets/img/gif/loading5.gif'/><br /><p style='color:#575555;'>Searching Data</p></center><br />");
    request.done(function(output) {
        window.setTimeout(function() {
            $('#res').html('');
            $('#res').html(output);
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
    var base_url = base;
    var sub_inv = $("#SlcSubInventori").val();
    var locator = $("#SlcLocator").val();
    var kode_item = $("#SlcItem").val();
    var org = $('input[name="txtOrg"]:checked').val()
    var request = $.ajax({
        url: base_url + "StorageLocation/AddressMonitoring/searchByKomp",
        data: {
            sub_inv:sub_inv,
            locator:locator,
            kode_item:kode_item,
            org:org
        },
        type: "post",
        dataType: "html"
    });
    $('#result').html("<center><img id='loading' style='margin-top: 2%; ' src='" + base_url + "assets/img/gif/loading5.gif'/><p style='color:#575555;'>Searching Data</p></center><br />");
    request.done(function(output) {
        window.setTimeout(function() {
            $('#result').html('');
            $('#result').html(output);
        }, 1000);
    });
}

function searchBySA(base) {
    var base_url = base;
    var sub_inv = $("#SlcSubInventori").val();
    var locator = $("#SlcLocator").val();
    var kode_assy = $("#SlcKodeAssy").val();
    var org = $('input[name="txtOrg"]:checked').val()
    //var org = $('input[name="org"]:checked').val()
    //meminta request ajax
    var request = $.ajax({
        url: base_url + "StorageLocation/AddressMonitoring/searchBySA",
        data: "&sub_inv=" + sub_inv + "&locator=" + locator + "&kode_assy=" + kode_assy + "&org_id=" + org,
        type: "GET",
        dataType: "html"
    });
    //menampilkan pesan Sedang mencari saat aplikasi melakukan proses pencarian
    //$('#loading').html('');
    $('#result').html("<center><img id='loading' style='margin-top: 2%; ' src='" + base_url + "assets/img/gif/loading5.gif'/><p style='color:#575555;'>Searching Data</p></center><br />");
    //$('#loading').html("<tbody><tr><td colspan='12' style='text-align:center'><img id='loading'  style='margin-top: 2%; ' src='"+base_url+"assets/img/gif/loading5.gif'/><p style='color:#575555;'>Searching Data</p></td></tr></tbody>");
    //Jika pencarian selesai
    request.done(function(output) {
        window.setTimeout(function() {
            $('#result').html('');
            $('#result').html(output);
        }, 1000);
    });
}

function searchByAll(base) {
    var base_url = base;
    var sub_inv = $("#SlcSubInventori").val();
    var locator = $("#SlcLocator").val();
    var alamat = $("#txtAlamat").val();
    //var org = $('input[name="org"]:checked').val()
    //meminta request ajax
    var request = $.ajax({
        url: base_url + "StorageLocation/AddressMonitoring/searchByAll",
        data: "&sub_inv=" + sub_inv + "&locator=" + locator + "&alamat=" + alamat,
        type: "GET",
        dataType: "html"
    });
    //menampilkan pesan Sedang mencari saat aplikasi melakukan proses pencarian
    //$('#loading').html('');
    $('#result').html("<center><img id='loading' style='margin-top: 2%; ' src='" + base_url + "assets/img/gif/loading5.gif'/><p style='color:#575555;'>Searching Data</p></center><br />");
    //$('#loading').html("<tbody><tr><td colspan='12' style='text-align:center'><img id='loading'  style='margin-top: 2%; ' src='"+base_url+"assets/img/gif/loading5.gif'/><p style='color:#575555;'>Searching Data</p></td></tr></tbody>");
    //Jika pencarian selesai
    request.done(function(output) {
        window.setTimeout(function() {
            $('#result').html('');
            $('#result').html(output);
        }, 1000);
    });
}

function entir(e, t) {
    if (e.keyCode === 13) {
        var alamat = $(t).closest('td').find('.alamat').val();
        var item = $(t).closest('td').find('.item').val();
        var kode_assy = $(t).closest('td').find('.kode_assy').val();
        var type_assy = $(t).closest('td').find('.type_assy').val();
        var sub_inv = $(t).closest('td').find('.sub_inv').val();
        $.ajax({
            type: 'POST',
            url: baseurl + "save/alamat",
            data: {
                alamat: alamat,
                item: item,
                kode_assy: kode_assy,
                type_assy: type_assy,
                sub_inv: sub_inv,
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

function enter(en, th) {
    var item = $(th).closest('tr').find('.item').val();
    var kode_assy = $(th).closest('tr').find('.kode_assy').val();
    var type_assy = $(th).closest('tr').find('.type_assy').val();
    var sub_inv = $(th).closest('tr').find('.sub_inv').val();
    if ($(th).is(':checked')) {
        $(th).val('1');
    } else {
        $(th).val('0');
    }
    var lmk = $(th).val();
    $.ajax({
        type: 'POST',
        url: baseurl + "save/lmk",
        data: {
            lmk: lmk,
            item: item,
            kode_assy: kode_assy,
            type_assy: type_assy,
            sub_inv: sub_inv,
        },
        success: function(result) {
            alert('edit berhasil!');
        },
        error: function() {
            alert('terjadi kesalahan');
        }
    })
}

function enter2(en, th) {
    var item = $(th).closest('tr').find('.item').val();
    var kode_assy = $(th).closest('tr').find('.kode_assy').val();
    var type_assy = $(th).closest('tr').find('.type_assy').val();
    var sub_inv = $(th).closest('tr').find('.sub_inv').val();
    if ($(th).is(':checked')) {
        $(th).val('1');
    } else {
        $(th).val('0');
    }
    var picklist = $(th).val();
    $.ajax({
        type: 'POST',
        url: baseurl + "save/picklist",
        data: {
            picklist: picklist,
            item: item,
            kode_assy: kode_assy,
            type_assy: type_assy,
            sub_inv: sub_inv,
        },
        success: function(result) {
            alert('edit berhasil!');
        },
        error: function() {
            alert('terjadi kesalahan');
        }
    })
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

function inputKomp() {
    document.location = baseurl + "inputComponent";
}

function inputAssy() {
    document.location = baseurl + "inputAssy";
}
function add_row(tableID) {
    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
    var colCount = table.rows[0].cells.length;
    for (var i = 0; i < colCount; i++) {
        var newcell = row.insertCell(i);
        $('.jsItem').select2('destroy');
        $('.select-2').select2('destroy');
        newcell.innerHTML = table.rows[1].cells[i].innerHTML;
        $(".jsItem").select2({
            tags: true,
            allowClear: true,
            placeholder: " Pilih item",
            ajax: {
                url: baseurl+"StorageLocation/Ajax/GetItem",
                dataType: 'json',
                type: "POST",
                data: function(params) {
                    var queryParameters = {
                        term: params.term,
                        org_id: $('select#IdOrganization').val(),
                        assy: $('select[name="SlcKodeAssy2"]').val()
                    }
                    return queryParameters;
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(obj) {
                            return {
                                id: obj.SEGMENT1,
                                text: obj.SEGMENT1 + " - " + obj.DESCRIPTION
                            };
                        })
                    };
                }
            }
        });
        $('.select-2').select2();
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
        }
    });
}

function getKodeKomp() {
    var org_id = $('select#IdOrganization').val();
    var sub_inv = $('select#SlcSubInventori').val();
    $('select#SlcItem').prop('disabled', true);
    $('select#SlcItem').html('');
    $('select#SlcLocator').select2('val', null);
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
    var desc = val.split('|',);
    $("input#txtDesc").val(desc[1]);
    $.ajax({
        type: 'POST',
        url: baseurl + "StorageLocation/Ajax/GetAssy",
        data: {
            org_id: $('select#IdOrganization').val(),
            item: $('select#SlcItem').val()
        },
        success: function(result) {
            if (result != 0) {
                $('select#SlcKodeAssy').prop('disabled', false).html(result);
            }
        }
    });
}

function getDescTypeAssy(){
    var desc = $('select#SlcKodeAssy option:selected').attr('data-desc');
    var type = $('select#SlcKodeAssy option:selected').attr('data-type');
    $("input#txtNameAssy").val(desc);
    if (type == '' || type == null) {
        $("input#txtTypeAssy").val('-');
    }else{
        $("input#txtTypeAssy").val(type);
    }

}


    // $.ajax({
    //     type: 'POST',
    //     data: {
    //         org_id: org_id
    //     },
    //     url: baseurl + 'StorageLocation/Ajax/getComponentCode',
    //     cache: false,
    //     success: function(result) {
    //         $('select#SlcItem').prop('disabled', false);
    //         $('select#SlcItem').html(result);
    //     }
    // })