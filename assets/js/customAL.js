//Android List
$(document).ready(function(){

	$('.erp-androedit').select2({
		allowClear: false,
		searching: true,
		minimumInputLength: 2,
		placeholder: 'No. Induk dan Nama Karyawan',
		ajax: 
		{
			url: baseurl+'SystemAdministration/Android/listPekerja',
			dataType: 'json',
			type: 'GET',
			delay: 500,
			data: function (params){
				return {
					term: params.term,
				}
			},
			processResults: function(data) {
				return {
					results: $.map(data, function(obj){
						// return {id: obj.employee_name, text: obj.employee_name};
						return {id: obj.noind+" - "+obj.nama, text: obj.noind+" - "+obj.nama};
					})
				};
			}
		}
	});

});

