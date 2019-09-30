var no = 1;
var id = 1;

$(document).ready(function () {
	$(".preloader").fadeOut();
});


$(document).ready(function () {
	$("#search_cc").select2({
		allowClear: false,
		placeholder: "Nomor Cost Center",
		minimumInputLength: 1,
		ajax: {
			url: baseurl + "CetakStikerCC/Cetak/suggestions",
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
							id: obj.COST_CENTER,
							text: obj.COST_CENTER
						};
					})
				};
			}
		}
	});
});

$(document).ready(function(){
	  $(document).on('change', '.importtt', function(){
    	$('.button1').removeAttr('disabled')
    	// $(this).parentsUntil('tr').find('input').attr('disabled', 'disabled')
	    // console.log('2')
    })

});

$("#search_cc").change(function () {
	$.ajax({
		url: baseurl + 'CetakStikerCC/Cetak/getItemDetail',
		dataType: 'json',
		type: 'POST',
		data: {
			params: $(this).val()
		},
		success: function (result) {
			console.log(result);
			var html = '';
			$.each(result, function (i, data) {
				html += '<tr row-id="' + (id++) + '">' +
					'<td>' + (no++) + '</td>' +
					'<td><input type="hidden" name="center[]" id="center" value="' + data.COST_CENTER + '">' + data.COST_CENTER + '</td>' +
					'<td><input type="hidden" name="seksi[]" id="seksi" value="' + data.SEKSI_NOMESIN + '">' + data.SEKSI_NOMESIN + '</td>' +
					'<td><input type="hidden" name="tag[]" id="tag" value="' + data.TAG_NUMBER + '">' + data.TAG_NUMBER + '</td>' +
					'<td><input type="hidden" name="kode[]" id="kode" value="' + data.KODE_RESOURCE + '">' + data.KODE_RESOURCE + '</td>' +
					'<td><input type="hidden" name="desc[]" id="desc" value="' + data.DESKRIPSI + '">' + data.DESKRIPSI + '</td>' +
					'<td><input type="hidden" name="tgl[]" id="tgl" value="' + data.TANGGAL_UPDATE + '">' + data.TANGGAL_UPDATE + '</td>' +
					'<td><center><button type="button" onclick="deleteRowThisHehe(this)" class="btn btn-danger btn-xs hapus' + id + '" title="Delete" >' +
					'<span class="icon-trash"></span>'
				'</button></center></td>' +
				'</tr>';
			});

			console.log(html);
			$("#body-cc").append(html);
			$(".import").hide();
			$(".saveall").show();
		},
		error: function (error, status) {
			console.log(error);
		}
	});
});

function deleteRowThisHehe(th) {
	$(th).parents("tr").remove();
}