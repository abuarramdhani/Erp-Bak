$(document).ready(function () {
	$('#org').trigger("change");
	$("#prodd").select2({
		allowClear: true,
		minimumInputLength: 0,
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
							id: obj.FLEX_VALUE,
							text: obj.FLEX_VALUE+' - '+obj.DESCRIPTION
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

$( '#comp').change(function() {
	var value = $(this).val();
	if (value == '') {
		$('#org').prop("disabled",true);
	} else {
		$('#org').prop("disabled",false);
	}
	
});

$( '#org').change(function() {
	var value = $(this).val();
	var kode = $("#comp").val();
	// if (kode == null) {
	// 	$("#recipe").html('<option value="" selected><b style="color:red;">HARAP PILIH KOMPONEN</b></option>');
	// 	$("#recipe").prop("disabled",true);
	// } else {
		if (value == 'OPM') {
					$("#recipe").prop("disabled",false);
					$.ajax({
						type:'POST',
						data:{segment1:kode},
						url:baseurl+"CetakBOMResources/Cetak/getRecipe",
						success:function(result)
						{	
							console.log(result);
								$("#recipe").html(result);
						}
					})
				
			// $("#recipe").html(hasil);
		} else if (value == 'ODM') {
			$("#recipe").val("");
			$("#recipe").prop("disabled",true);
		}
	// }
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

$('#org').change(function () {
	var value = $(this).val();
	console.log(value)
	$("#seksii").select2('val', null);
	$.ajax({
		type:'POST',
		data:{segment1:value},
		url:baseurl+"CetakBOMResources/Cetak/getseksi",
		success:function(result)
		{
			if (result != '<option></option>') {
				$("#seksii").html(result);
				// $("#typeCetak").attr("required","required");
				// $("#typeCetak").removeAttr("disabled");

			}else{
				$("#seksii").attr("disabled","disabled");
				// $("#typeCetak").attr("disabled","disabled");
				// $("#typeCetak").removeAttr("required","required");


			}
		}
	})
});

// $('#recipe').change(function () {
// 	var value = $("#comp").val();
// 	console.log(value)
// 	// $("#seksii").select2('val', null);
// 	// $.ajax({
// 	// 	type:'POST',
// 	// 	data:{segment1:value},
// 	// 	url:baseurl+"CetakBOMResources/Cetak/getRecipe",
// 	// 	success:function(result)
// 	// 	{	
// 	// 			console.log(result);
// 	// 			$("#recipe").html(result);
// 	// 	}
// 	// })
// });