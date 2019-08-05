//Android List
$(document).ready(function(){

	$('.erp-androedit').select2({
		allowClear: false,
		searching: true,
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
						return {id: obj.employee_code+" - "+obj.employee_name, text: obj.employee_code+" - "+obj.employee_name};
					})
				};
			}
		}
	});

});

