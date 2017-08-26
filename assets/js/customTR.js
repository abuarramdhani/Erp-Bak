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
		placeholder: "[Select Item]",
		minimumInputLength: 3,
		ajax: {		
				url: baseurl+"Toolroom/Transaksi/getItem",
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
							return { id:obj.item_id, text:obj.item_id+" ( "+obj.item_name+" )"};
						})
					};
				}
			}
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

$(document).on("click", "#showModalItem", function () {
	$('#modalSearchItem').modal();
});

$(document).on("click", "#showModalNoind", function () {
	$('#modalSearchNoind').modal();
});

function AddPinjamItem(){
	var barcode = $('#txtBarcode').val();
	$.ajax({
		type:'POST',
		data:{id: barcode},
		url :baseurl+"Toolroom/Transaksi/addNewItem",
		success:function(result){
			if(result == "out"){
				alert('Out Of Stock !!!');
			}else{
				$('#table-create-peminjaman tbody').html(result);
			}
		}
	});
	$('#txtBarcode').val('');
}

function removeListOutItem(id){
	$.ajax({
		type:'POST',
		data:{id: id},
		url :baseurl+"Toolroom/Transaksi/removeNewItem",
		success:function(result){
				$('#table-create-peminjaman tbody').html(result);
		}
	});
}

function clearListOutItem(){
	$.ajax({
		type:'POST',
		url :baseurl+"Toolroom/Transaksi/clearNewItem",
		success:function(result){
				$('#table-create-peminjaman tbody').html(result);
		}
	});
}