$(document).ready(function(){
	$('#txtMulaiLajuPekerjalaju').datepicker({
        "autoclose": true,
        "todayHiglight": true,
        "format": 'yyyy-mm-dd'
    });

	$('.slcNoindPekerjalaju').select2({
		searching: true,
        minimumInputLength: 3,
        placeholder: "No. Induk / Nama Pekerja",
        allowClear: false,
        ajax: {
            url: baseurl + 'AbsenPekerjaLaju/PekerjaLaju/getPekerjaByKey',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.noind, text: obj.noind + " - " + obj.nama };
                    })
                }
            }
        }
	});

	$('.slcNoindPekerjalaju').on('change',function(){
		var noind = $(this).val();

		$.ajax({
			type: 'GET',
			url : baseurl + 'AbsenPekerjaLaju/PekerjaLaju/getPekerjaDetailByNoind',
			data: {noind: noind},
			error: function(xhr,status,error){
                console.log(xhr);
                console.log(status);
                console.log(error);
                swal.fire({
                    title: xhr['status'] + "(" + xhr['statusText'] + ")",
                    html: xhr['responseText'],
                    type: "error",
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#d63031',
                })
            },
            success: function(result){
                if (result) {
                     obj = JSON.parse(result);
                     console.log(obj);
                     $('#txtNamaPekerjalaju').val(obj['nama']);
                     $('#txtAlamatPekerjalaju').val(obj['alamat']);
                     $('#txtDesaPekerjalaju').val(obj['desa']);
                     $('#txtKecamatanPekerjalaju').val(obj['kecamatan']);
                     $('#txtKabupatenPekerjalaju').val(obj['kabupaten']);
                     $('#txtProvinsiPekerjalaju').val(obj['provinsi']);
                }
            }
		})
	});

	$('#tblPekerjaLaju').DataTable({
		"scrollX" : true,
		"fixedColumns":   {
            leftColumns: 4
        },
        "lengthMenu": [
            [ 5, 10, 25, 50, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "dom" : 'Bfrtip',
        "buttons" : [
            'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
        ],
	});



});