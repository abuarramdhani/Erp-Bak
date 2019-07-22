//if (window.history.replaceState) window.history.replaceState(null, null, window.location.href);
$(function() {
    $('#formFilterLkhPekerja').off('submit').on('submit', function() {
        if($('#filterPeriode').val()) {
            $('#formFilterLkhPekerjaData1').attr('value', $('#filterPeriode').val());
            if($('#filterPekerja').select2('data')) {
                var raw = $('#filterPekerja').select2('data');
                var data = [];
                for(let i = 0; i < raw.length; i++) data[i] = raw[i].text;
                $('#formFilterLkhPekerjaData2').attr('value', data);
            }
        }
    });
    $("#filterPekerja").select2({
        placeholder: 'Nomor induk',
        minimumInputLength: 3,
        allowClear: true,
        ajax: {		
            url: baseurl + "LkhPekerjaBatch/TargetWaktu/getListFilterPekerja",
            type: 'POST',
            dataType: 'json',
            data: function (params) {
                var queryParameters = {
                    term: params.term,
                    periode: $('#filterPeriode').val()
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                        return {
                            id:obj.employee_code,
                            text:obj.employee_code + ' - ' + obj.employee_name
                        };
                    })
                };
            }
        }	
    });
    $('#slcApprover1').select2({
        allowClear: true,
        placeholder: 'Pilih Approver 1',
        ajax: {
            url: baseurl + 'LkhPekerjaBatch/TargetWaktu/getApprover',
            type: 'POST',
            delay: 250,
            dataType: 'json',
            data: function (params) {
                var queryParameters = {
                    term: params.term,
                    approver1: null
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return {
                            id: obj.noind,
                            text: obj.noind + ' - ' + obj.nama
                        };
                    })
                };
            }
        }
    }).off('change').on('change', function() {
        $('#slcApprover2').val(null).trigger('change');
        if($('#slcApprover1').select2().val() != '') {
            $('#slcApprover2').attr('disabled', false);
        } else {
            $('#slcApprover2').attr('disabled', true);
        }
    });
    $('#slcApprover2').select2({
        allowClear: true,
        placeholder: 'Pilih Approver 2',
        ajax: {
            url: baseurl + 'LkhPekerjaBatch/TargetWaktu/getApprover',
            type: 'POST',
            delay: 250,
            dataType: 'json',
            data: function (params) {
                var queryParameters = {
                    term: params.term,
                    approver1: $('#slcApprover1').val()
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return {
                            id: obj.noind,
                            text: obj.noind + ' - ' + obj.nama
                        };
                    })
                };
            }
        }
    });
});

function initCheckbox() {
    $('input').iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal'
    });
    $('#checkbox-all').on('ifChanged', function(event) {
        if(event.target.checked) {
            $('.checkBoxDataList:enabled').iCheck('check');
        } else {
            $('.checkBoxDataList:enabled').iCheck('uncheck');
        }
    });
}