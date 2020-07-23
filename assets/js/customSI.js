$(function() {
    $('.dataTable-pekerja').DataTable()

    $(document).on('ifChecked','#myCheck', function(event) {
        if (event.target.checked && $('#youCheck').prop('checked') && $('#Check').prop('checked') && $('#tglCheck').prop('checked')) {
            $('#btnAprroveOkSI').prop('disabled', false);
            $('#textcheckbox').hide();
        } else {
            $('#btnAprroveOkSI').prop('disabled', true);
            $('#textcheckbox').show();
        }
    })

    $(document).on('ifChanged','#youCheck', function(event) {
        if (event.target.checked && $('#myCheck').prop('checked') && $('#Check').prop('checked') && $('#tglCheck').prop('checked')) {
            $('#btnAprroveOkSI').prop('disabled', false)
            $('#textcheckbox').hide()
        } else {
            $('#btnAprroveOkSI').prop('disabled', true)
            $('#textcheckbox').show()
        }
    })

    $(document).on('ifChanged','#Check', function(event) {
        if (event.target.checked && $('#myCheck').prop('checked') && $('#youCheck').prop('checked') && $('#tglCheck').prop('checked')) {
            $('#btnAprroveOkSI').prop('disabled', false)
            $('#textcheckbox').hide()
        } else {
            $('#btnAprroveOkSI').prop('disabled', true)
            $('#textcheckbox').show()
        }
    })

    $(document).on('ifChanged','#tglCheck', function(event) {
        if (event.target.checked && $('#myCheck').prop('checked') && $('#youCheck').prop('checked') && $('#Check').prop('checked')) {
            $('#btnAprroveOkSI').prop('disabled', false)
            $('#textcheckbox').hide()
        } else {
            $('#btnAprroveOkSI').prop('disabled', true)
            $('#textcheckbox').show()
        }
    })

    $('.textareaKaizen').redactor({
        imageUpload: baseurl + 'SystemIntegration/KaizenGenerator/Submit/upload',
        imageUploadErrorCallback: function(json) {
            alert(json.error);
        }
    })

    $('.textareaKaizenAprove').redactor({
        imageUpload: baseurl + 'SystemIntegration/KaizenGenerator/ApprovalKaizen/upload',
        imageUploadErrorCallback: function(json) {
            alert(json.error)
        }
    })

    $('#txtPertimbangan').redactor({
        imageUpload: baseurl + 'SystemIntegration/KaizenGenerator/Submit/upload',
        imageUploadErrorCallback: function(json) {
            alert(json.error)
        }
    })

    $('#txtRencanaRealisasiSI, #txtEndDateSI, #txtStartDateSI ,.datetimeSI').datepicker({
        autoclose: true,
        todayHighlight: true
    });

    $('input#checkKaizenKomp').on('ifChecked', function() {
        $(this).closest("input").attr('checked', true);
        $('.komponenKaizenSI').removeAttr('disabled')
    })

    $('input#checkKaizenKomp').on('ifUnchecked', function() {
        $(this).closest("input").attr('checked', false)
        $('.komponenKaizenSI').attr("disabled", "disabled")
        $('.komponenKaizenSI').val(null).trigger('change')
    })

    $('input#checkNextApprover').on('ifChecked', function() {
        $('input#checkNextApprover').attr("checked", "checked")
        $('select#slcApprover').removeAttr("disabled")
    })

    $('input#checkNextApprover').on('ifUnchecked', function() {
        $('input#checkNextApprover').removeAttr("checked")
        $('select#slcApprover').attr("disabled", "disabled")
        $('select#slcApprover').val(null).trigger('change')
    })

    $('input#checkRealisasiKai').on('ifChecked', function() {
        var name = $(this).attr('data-class')
        $(this).closest("input").attr('checked', 'checked')
        $(this).parent().parent().parent().find(".must").removeAttr('disabled')
        $(this).parent().parent().parent().find(".must").attr('required', 'required')
        $('.' + name).redactor({
            imageUpload: baseurl + 'SystemIntegration/KaizenGenerator/Submit/upload',
            imageUploadErrorCallback: function(json) {
                alert(json.error)
            }
        })
        checkFillRealisasi()
    })

    $('input#checkRealisasiKai').on('ifUnchecked', function() {
        var name = $(this).attr('data-class')
        $(this).closest("input").removeAttr('checked')
        $(this).parent().parent().parent().find(".must").attr("disabled", "disabled")
        $(this).parent().parent().parent().find(".must").removeAttr('required')
        $(this).closest("input.must").val(null).trigger('change')
        $('.' + name).redactor({
            imageUpload: baseurl + 'SystemIntegration/KaizenGenerator/Submit/upload',
            imageUploadErrorCallback: function(json) {
                alert(json.error)
            }
        })
        $('.' + name).redactor('destroy')
        $('.' + name).val('')
        $('.' + name).attr('disabled', 'disabled')
        checkFillRealisasi()
    })

    $(document).on('ifUnchecked','input#checkRealisasiStandarisasiKai', function() {
        var name = $(this).attr('data-class')
        $(this).closest("input").removeAttr('checked')
        $(this).parent().parent().parent().find(".must").attr("disabled", "disabled")
        $(this).parent().parent().parent().find(".must").removeAttr('required')
        $(this).closest("input.must").val(null).trigger('change')
        $('.' + name).redactor({
            imageUpload: baseurl + 'SystemIntegration/KaizenGenerator/Submit/upload',
            imageUploadErrorCallback: function(json) {
                alert(json.error)
            }
        })
        $('.' + name).redactor('destroy')
        $('.' + name).val('')
        $('.' + name).attr('disabled', 'disabled')
        checkFillRealisasi()
    })

    $(document).on('ifChecked','input#checkRealisasiStandarisasiKai', function() {
        var name = $(this).attr('data-class')
        $(this).closest("input").attr('checked', 'checked')
        $(this).parent().parent().parent().find(".must").removeAttr('disabled')
        $(this).parent().parent().parent().find(".must").attr('required', 'required')
        $('.' + name).redactor({
            imageUpload: baseurl + 'SystemIntegration/KaizenGenerator/Submit/upload',
            imageUploadErrorCallback: function(json) {
                alert(json.error)
            }
        })
        checkFillRealisasi()
    })

    $(document).on('ifChecked','input#checkRealisasiSosialisasiKai', function() {
        var name = $(this).attr('data-class')
        $(this).closest("input").attr('checked', 'checked')
        $(this).parent().parent().parent().find(".must").removeAttr('disabled')
        $(this).parent().parent().parent().find(".must").attr('required', 'required')
        $('.' + name).redactor({
            imageUpload: baseurl + 'SystemIntegration/KaizenGenerator/Submit/upload',
            imageUploadErrorCallback: function(json) {
                alert(json.error)
            }
        })
        checkFillRealisasi()
    })

    $(document).on('ifUnchecked','input#checkRealisasiSosialisasiKai', function() {
        var name = $(this).attr('data-class')
        $(this).closest("input").removeAttr('checked')
        $(this).parent().parent().parent().find(".must").attr("disabled", "disabled")
        $(this).parent().parent().parent().find(".must").removeAttr('required')
        $(this).closest("input.must").val(null).trigger('change')
        $('.' + name).redactor({
            imageUpload: baseurl + 'SystemIntegration/KaizenGenerator/Submit/upload',
            imageUploadErrorCallback: function(json) {
                alert(json.error)
            }
        })
        $('.' + name).redactor('destroy')
        $('.' + name).val('')
        $('.' + name).attr('disabled', 'disabled')
        checkFillRealisasi()
    })

    $('.select2si').select2({
        allowClear: true,
        tabindex: true
    })

    $('#btnAprroveOkSI').click(function() {
        var id = $(this).attr('data-id')
        var level = $(this).attr('data-level')
        var next = $('#next').val()
        $('#hdnStatus').val(3)
        $('#levelApproval').val(level)
        $('#formReason').attr('action', baseurl + 'SystemIntegration/MainMenu/ApprovalKaizen/C_ApprovalKaizen/result/' + id)
        if ((level == '2' || level == '3') && next == 0) {
            $('#btn_result').show()
            $('#btn_result2').hide()
        } else {
            $('#btn_result').hide()
            $('#btn_result2').show()
        }
        $('#modalReason').modal('show')
    })

    $('#btnAprroveRealSI').click(function() {
        var id = $(this).attr('data-id')
        var level = $(this).attr('data-level')
        $('#hdnStatus').val(3)
        $('#levelApproval').val(level)
        $('#formReason').attr('action', baseurl + 'SystemIntegration/MainMenu/ApprovalKaizen/C_ApprovalKaizen/resultRealisasi/' + id)
        $('#modalReason').modal('show')
    })

    $('#btnAprroveRevSI').click(function() {
        var id = $(this).attr('data-id')
        var level = $(this).attr('data-level')
        $('#hdnStatus').val(4)
        $('#levelApproval').val(level)
        $('#formReason').attr('action', baseurl + 'SystemIntegration/MainMenu/ApprovalKaizen/C_ApprovalKaizen/result/' + id)
        $('#btn_result').hide()
        $('#btn_result2').show()
        $('#formNextApprover').hide()
        $('#modalReason').modal('show')
    });

    $('#btnAprroveNotSI').click(function() {
        var id = $(this).attr('data-id')
        var level = $(this).attr('data-level')
        $('#hdnStatus').val(5)
        $('#levelApproval').val(level)
        $('#formReason').attr('action', baseurl + 'SystemIntegration/MainMenu/ApprovalKaizen/C_ApprovalKaizen/result/' + id)
        $('#btn_result').hide()
        $('#btn_result2').show()
        $('#formNextApprover').hide()
        $('#modalReason').modal('show')
    });

    $(".tblSIKaizen").DataTable()

    $(".komponenKaizenSI").select2({
        tags: true,
        allowClear: true,
        minimumInputLength: 3,
        ajax: {
            url: baseurl + "SystemIntegrationKaizenGenerator/Submit/getItem",
            dataType: 'json',
            type: 'get',
            data: function(params) {
                return { p: params.term }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            id: item.INVENTORY_ITEM_ID,
                            text: item.SEGMENT1 + ' -- ' + item.ITEM_NAME,
                        }
                    })
                }
            },
        },
    })

    $('#rmthreadkai').click(function() {
        $('#threadmorekai').show()
        $('#rmthreadkai').hide()
        $('#rlthreadkai').show()
    });

    $('#rlthreadkai').click(function() {
        $('#threadmorekai').hide()
        $('#rlthreadkai').hide()
        $('#rmthreadkai').show()
    });

    $('#btn_result').click(function() {
        var val = $('#txtReason').val()
        $('#formReasonApprover').slideUp('slow')
        $('#formNextApprover').slideDown('slow')
        $('#next').val(1)
        $('#btn_result').hide()
        $('#btn_result2').show()
        $('c').text(val)
    });

    $('#btn_batal').click(function() {
        $('#formNextApprover').slideUp('slow')
        $('#formReasonApprover').slideDown('slow')
        $('#txtReason').val('')
        $('#next').val(0)
        $('#btn_result2').hide()
        $('#btn_result').show()
    });

    $('.siSlcTgr').change(function() {
        var type = $('input[name="typeApp"]').val()
        var a = $('select[name="SlcAtasanLangsung"]').val()
        var b = $('select[name="SlcAtasanAtasanLangsung"]').val()
        var c = $('select[name="SlcAtasanDepartment"]').val()
        var checkFill = function(val) {
            if (type == 1) {
                if ((a !== "") && (b !== "") && (val == 1)) {
                    $('#subApprSI').removeAttr("disabled")
                } else {
                    $('#subApprSI').attr("disabled", "disabled")
                }
            } else {
                if (a !== "") {
                    $('#subApprSI').removeAttr("disabled")
                } else {
                    $('#subApprSI').attr("disabled", "disabled")
                }
            }
        }
        var error = function(sel) {
            for (var i = 0; i < sel.length; i++) $('.sel' + sel[i]).addClass('has-error')
        }
        if (type == 1) {
            if (typeof a !== typeof undefined && a !== false) {
                if ((a == b) && (a !== "" && b !== "")) {
                    var select = [1, 2]
                    $('#subApprSI').attr("disabled", "disabled")
                    error(select)
                    checkFill(0)
                } else {
                    $('.sel1').removeClass('has-error')
                    $('.sel2').removeClass('has-error')
                    $('#subApprSI').removeAttr("disabled")
                    checkFill(1)
                }
                // else if((a == c) && (a !== "" && c !== "")){
                //   var select = [1,3];
                //   error(select);
                //   $('#subApprSI').attr("disabled","disabled");
                //   checkFill(0);
                // }else if((b == c) && (c !== "" && b !== "")){
                //   var select = [2,3];
                //   error(select);
                //   $('#subApprSI').attr("disabled","disabled");
                //   checkFill(0);
                // }else if( ((b == c) && (a == b)) && (a !== "" && b !== "" && c !== "") ){
                //   var select = [1,2,3];
                //   error(select);
                //   $('#subApprSI').attr("disabled","disabled");
                //   checkFill(0);
                // }
            } else {
                checkFill(1);
            }
        } else {
            checkFill(0);
        }
    })

    $('.buttonsi').click(function() {
        $('.custNotifBody').slideToggle('slow')
    })

    $('input#checkKaizenKomp').on('ifChecked', function() {
        if ($(this).is(':checked')) {
            $('.komponenKaizenSI').removeAttr('disabled')
        } else {
            $('.komponenKaizenSI').attr("disabled", "disabled")
            $('.komponenKaizenSI').val(null).trigger('change')
        }
    })

    if (typeof(realisasiSIpage) != "undefined" && realisasiSIpage !== null) $('.select2').prepend('<div class="disabled-select"></div>')
})

function openTabSI(th, tab) {
    $('.tabcontent').hide()
    $('.tablinks').removeClass('active')
    $('#' + tab).show()
    $(th).addClass('active')
}

function getDelDataSI(th) {
    var kaizen_id = $(th).attr('data-id')
    var judul = $(th).closest('tr').find('#judul').text()
    $('#deljudul').html('')
    $('#deljudul').append(judul)
    $('#delUrlSI').attr('href', '')
    $('#delUrlSI').attr('href', baseurl + 'SystemIntegration/KaizenGenerator/Delete/' + kaizen_id)
}

function checkFillRealisasi() {
    if (($('input[name="chkStandarisasiRealisasi"]').is(':checked')) && ($('input[name="chkSosialisasiRealisasi"]').is(':checked'))) {
        $("#btnSubmitRealisasi").removeAttr("disabled")
    } else {
        $("#btnSubmitRealisasi").attr("disabled", "disabled")
    }
}

// start kaizen akuntansi
$(document).on('ready', function(){
    $('#txt-SI-SubmitIde-DueDate').datepicker({
        "autoclose": true,
        "todayHighlight": true,
        "todayBtn": "linked",
        "format":'yyyy-mm-dd'
    });
    $('#txt-SI-SubmitF4-TanggalRealisasi').datepicker({
        "autoclose": true,
        "todayHighlight": true,
        "todayBtn": "linked",
        "format":'yyyy-mm-dd'
    });

    $('#btn-SI-SubmitIde-Submit').on('click', function(){
        var seksi = $('#txt-SI-SubmitIde-Seksi').val();
        var judul = $('#txt-SI-SubmitIde-Judul').val();
        var dueDate = $('#txt-SI-SubmitIde-DueDate').val();
        if (seksi && judul && dueDate) {
            Swal.fire({
                title: 'Peringatan !!!',
                text: "Apakah Ide Yang Anda Submit Sudah Sesuai ?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        data: {seksi: seksi, judul: judul,dueDate: dueDate},
                        method: 'POST',
                        url: baseurl + 'SystemIntegration/KaizenAkt/SimpanIde',
                        error: function(xhr,status,error){
                            swal.fire({
                                title: xhr['status'] + "(" + xhr['statusText'] + ")",
                                html: xhr['responseText'],
                                type: "error",
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#d63031',
                            })
                        },
                        success: function(data){
                            if (!isNaN(data)) {
                                Swal.fire(
                                    'Sukses !!!',
                                    'Data Berhasil Diinput',
                                    'success'
                                )
                                $('#txt-SI-SubmitIde-Seksi').val('').change();
                                $('#txt-SI-SubmitIde-Judul').val('').change();
                                $('#txt-SI-SubmitIde-DueDate').val('').change();
                            }else{
                                swal.fire({
                                    title: "Error",
                                    html: data,
                                    type: "error",
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#d63031',
                                })
                            }
                        }
                    })
                }
            });
        }else{
            Swal.fire(
                'Peringatan !!!',
                'Pastikan Semua Data Terisi',
                'warning'
            )
        }
    })

    $('#txa-SI-SubmitF4-KondisiSaatIni').redactor({
        imageUpload: baseurl + 'SystemIntegration/KaizenAkt/uploadSubmitF4',
        imageUploadErrorCallback: function(json) {
            alert(json.error);
        }
    })

    $('#txa-SI-SubmitF4-UsulanKaizen').redactor({
        imageUpload: baseurl + 'SystemIntegration/KaizenAkt/uploadSubmitF4',
        imageUploadErrorCallback: function(json) {
            alert(json.error);
        }
    })

    $('#txa-SI-SubmitF4-PertimbanganUsulanKaizen').redactor({
        imageUpload: baseurl + 'SystemIntegration/KaizenAkt/uploadSubmitF4',
        imageUploadErrorCallback: function(json) {
            alert(json.error);
        }
    })

    $("#slc-SI-SubmitF4-Komponen").select2({
        allowClear: true,
        minimumInputLength: 3,
        ajax: {
            url: baseurl + "SystemIntegration/KaizenAkt/getKomponen",
            dataType: 'json',
            type: 'get',
            data: function(params) {
                return { p: params.term }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            id: item.INVENTORY_ITEM_ID,
                            text: item.SEGMENT1 + ' -- ' + item.ITEM_NAME,
                        }
                    })
                }
            },
        },
    })

    $(document).on('ifChecked','#chk-SI-SubmitF4-Komponen', function(){
        $('#slc-SI-SubmitF4-Komponen').attr('disabled', false);
    })

    $(document).on('ifUnchecked','#chk-SI-SubmitF4-Komponen', function(){
        $('#slc-SI-SubmitF4-Komponen').attr('disabled', true);
        $('#slc-SI-SubmitF4-Komponen').val('').change();
    })

    $('#btn-SI-SubmitF4-Submit').on('click', function(){
        var judul           = $('#slc-SI-SubmitF4-Judul option:selected').text();
        var kaizenId        = $('#slc-SI-SubmitF4-Judul').val();
        var nama            = $('#txt-SI-SubmitF4-NamaPencetus').val();
        var noind           = $('#txt-SI-SubmitF4-NoindPencetus').val();
        var komponen        = $('#slc-SI-SubmitF4-Komponen').val();
        var kondisi         = $('#txa-SI-SubmitF4-KondisiSaatIni').val();
        var usulan          = $('#txa-SI-SubmitF4-UsulanKaizen').val();
        var pertimbangan    = $('#txa-SI-SubmitF4-PertimbanganUsulanKaizen').val();
        var realisasi       = $('#txt-SI-SubmitF4-TanggalRealisasi').val();

        if (judul && nama && noind && kondisi && usulan && pertimbangan && realisasi) {
            $.ajax({
                data: {
                    judul       : judul,
                    kaizen_id   : kaizenId,
                    nama        : nama,
                    noind       : noind,
                    kondisi     : kondisi,
                    usulan      : usulan,
                    pertimbangan: pertimbangan,
                    realisasi   : realisasi,
                    komponen    : komponen
                },
                method: 'POST',
                url: baseurl + 'SystemIntegration/KaizenAkt/SimpanF4',
                error: function(xhr,status,error){
                    swal.fire({
                        title: xhr['status'] + "(" + xhr['statusText'] + ")",
                        html: xhr['responseText'],
                        type: "error",
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#d63031',
                    })
                },
                success: function(data){
                    if (data.includes("A PHP Error was encountered",0)) {
                        swal.fire({
                            title: "Error",
                            html: data,
                            type: "error",
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#d63031',
                        })
                    }else if (data == "sukses") {
                        $('#btn-SI-SubmitF4-Cetak').attr('disabled', false);
                        Swal.fire({
                            title: 'Sukses !!!',
                            text: "Apakah Anda Ingin Mengcetak F4 ?",
                            type: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya',
                            cancelButtonText: 'Tidak'
                        }).then((result) => {
                            if (result.value) {
                                window.open(baseurl+'SystemIntegration/KaizenAkt/CetakF4/'+kaizenId,'_blank');
                            }
                        });
                    }                    
                }
            })
        }else{
            Swal.fire(
                'Peringatan !!!',
                'Pastikan Semua Data Terisi',
                'warning'
            )
        }
    })

    $('#btn-SI-SubmitF4-Cetak').on('click', function(){
        var kaizenId        = $('#slc-SI-SubmitF4-Judul').val();
        if (kaizenId) {
            window.open(baseurl+'SystemIntegration/KaizenAkt/CetakF4/'+kaizenId,'_blank');
        }
    })
})
// end kaizen akuntansi