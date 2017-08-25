$(document).ready(function() {
	$('.table-item-usable').DataTable({"lengthChange": false,"searching": true,"info": false});
	$('.select-group-item').select2({
		allowClear: true,
		placeholder: "[Select Group Toolkit]",
		minimumInputLength: 0,
		minimumResultsForSearch: -1
	});
	$(".select-item").select2({
		allowClear: true,
		tags: true,
		placeholder: "[Barcode]"
	});
	$(".select-noind").select2({
		allowClear: true,
		placeholder: "[Select Noind]",
		minimumInputLength: 1,
		ajax: {		
				url: baseurl+"Toolroom/Transaksi/getNoind",
				dataType: 'json',
				type: "POST",
				data: function (params) {
					var queryParameters = {
						term: params.term
					}
					return queryParameters; 
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
							return { id:obj.noind, text:obj.noind+" ( "+obj.nama+" )"};
						})
					};
				}
			}
	});
});

function AddPinjamItem(){
	var barcode = $('#txtBarcode').val();
		$.ajax({
			type:'POST',
			data:{id: barcode},
			url :baseurl+"Toolroom/Transaksi/addNewItem",
			success:function(result){
				$('#table-create-peminjaman').append(result);
				count = $('.clone').length;
				$("span#no:last").html(count);
			}
		});
}