$(function() {
    $('#formFilterLkhPekerja').off('submit').on('submit', function() {
        if($('#filterPeriode').val()) {
            $('#formFilterLkhPekerjaData1').attr('value', $('#filterPeriode').val());
            if($('#filterPekerja').select2('data')) {
                var raw = $('#filterPekerja').select2('data'); var data = [];
                for(let i = 0; i < raw.length; i++) data[i] = raw[i].text.trim();
                $('#formFilterLkhPekerjaData2').attr('value', data);
            }
        }
    });
    $("#filterPekerja").select2({
        placeholder: "No Induk",
        minimumInputLength: 3,
        ajax: {		
            url: baseurl + "RekapTIMSPromosiPekerja/GetNoInduk",
            dataType: 'json',
            type: "GET",
            data: function (params) {
                var queryParameters = {
                    term: params.term,
                    type: $('select#slcNoInduk').val(),
                    stat: $('select#slcStatus').val()
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                        return {id:obj.NoInduk, text:obj.NoInduk+' - '+obj.Nama};
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
            $('.checkBoxDataList').iCheck('check');
        } else {
            $('.checkBoxDataList').iCheck('uncheck');
        }
    });
}

function deleteListLkhPekerja(id, row) {
    if(id) {
        Swal.fire({
            html:   "Anda yakin ingin menghapus data ini?",
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) $('#delete-row-lkh-' + row).trigger('click');
        });
    }
}