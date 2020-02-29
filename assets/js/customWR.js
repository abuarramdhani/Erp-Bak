/* Work Relationship JS */
$(document).ready(function() {

	$('#txtTanggalKeluarWR').daterangepicker({
        "autoclose": true,
        "todayHiglight": true,
        locale: {
            cancelLabel: 'Clear',
            "format": "YYYY-MM-DD",
            "separator": " - ",
        }
    });

	$("#slcWrEmployeeAll").select2({
		ajax: {
			url: baseurl+'WorkRelationship/RekapBon/getEmployeeAll',
			dataType: 'json',
			delay: 250,
			data: function (params) {
			  return {term: params.term,};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (obj) {
						return { id:obj.noind, text:obj.noind+' - '+obj.nama }
					})
			    };
			},
			cache: true
	    },
	    minimumInputLength: 2,
	    placeholder: 'Masukkan kode/nama pekerja'
	});
	$('#slcWrEmployeeAll').change(function(event) {
		var loadImg = '<img src="'+baseurl+'assets/img/gif/loading3.gif" width="130px" width="auto">'
		$('#tbWrEmployeeAllContainer').html(loadImg);
		var employee =$(this).val();
		$.ajax({
			url: baseurl+'WorkRelationship/RekapBon/getTableWrEmployeeAll',
			type: 'POST',
			data: {employee: employee},
		})
		.done(function(result) {
			$('#tbWrEmployeeAllContainer').html(result);
			// $('#wr-rekapbon').dataTable();
		})
		.fail(function() {
			console.log("error");
		});		
	});
});