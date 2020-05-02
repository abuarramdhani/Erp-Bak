$(document).ready(function () {
	$("#prodd").select2({
		allowClear: true,
		minimumInputLength: 1,
		ajax: {
			url: baseurl + "CetakBOMResources/Cetak/suggestproduk",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
				}
				return queryParameters;
			},
			processResults: function (data) {
				// console.log(data);
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.KODE_DIGIT,
							text: obj.DESCRIPTION
						};
					})
				};
			}
		}
	});
});

$( '#prodd').change(function() {
	var value = $(this).val();
	console.log(value)
	$("#comp").select2('val', null);
	$("#comp").prop("disabled",true);
	$.ajax({
		type:'POST',
		data:{segment1:value},
		url:baseurl+"CetakBOMResources/Cetak/getkomponen",
		success:function(result)
		{
			if (result != '<option></option>') {
				$("#comp").prop("disabled",false).html(result);
			}else{

			}
		}
	})
});
$( '#org').change(function() {
	var value = $(this).val();
	console.log(value)
	$("#seksii").select2('val', null);
	$("#seksii").prop("disabled",true);
	$.ajax({
		type:'POST',
		data:{segment1:value},
		url:baseurl+"CetakBOMResources/Cetak/getseksi",
		success:function(result)
		{
			if (result != '<option></option>') {
				$("#seksii").prop("disabled",false).html(result);
			}else{

			}
		}
	})
});