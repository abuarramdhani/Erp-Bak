$(document).ready(function() {
	$('.table-item-usable').DataTable({"lengthChange": false,"searching": true,"info": false});
	$('.table-create-pengembalian-today').DataTable({"lengthChange": false,"searching": true,"info": false});
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

$(document).on("keyup", "#txtBarcode", function () {
	var barcode = $('#txtBarcode').val().length;
	 if (event.ctrlKey && event.keyCode == 16) {
		$( "#txtNoind" ).focus();
	}
});

$(document).on("keyup", "#txtNoind", function () {
	var barcode = $('#txtNoind').val().length;
	 if (event.ctrlKey && event.keyCode == 16) {
		$( "#txtBarcode" ).focus();
	}
});

$(document).on("click", "#btnExecuteSave", function () {
	// if (confirm('Are you sure you want to save this thing into the database?')) {
		var noind = $('#txtNoind').val();
		var user = $('#hdnUser').val();
		var date = $('#hdnDate').val();
		$.ajax({
			type:'POST',
			data:{noind: noind,user:user,date:date},
			url :baseurl+"Toolroom/Transaksi/addNewLending",
			success:function(result){
				$('#table-create-peminjaman tbody tr').each(function() {
					var item_id = $(this).find(".item_id").html();    
					var item_name = $(this).find(".item_name").html();    
					var sisa_stok = $(this).find(".sisa_stok").html();    
					var item_out = $(this).find(".item_out").val();
					$.ajax({
						type:'POST',
						data:{noind: noind,user:user,date:date,item_id:item_id,item_name:item_name,sisa_stok:sisa_stok,item_out:item_out,id_transaction:result},
						url :baseurl+"Toolroom/Transaksi/addNewLendingList"
					});
				});
				$('#table-create-peminjaman tbody').html("<tr></tr>");
				$('#txtNoind').val('');
				$('#txtName').val('');
				alert('List Item Has Been Added !');
			}
		});
	// }
});

function AddPinjamItem(){
	var barcode = $('#txtBarcode').val();
	var user = $('#hdnUser').val();
	$.ajax({
		type:'POST',
		data:{id: barcode,user:user,type:0},
		url :baseurl+"Toolroom/Transaksi/addNewItem",
		success:function(result){
			if(result == "null"){
				alert('There is no item !!!');
			}else if(result == "out"){
				alert('Out Of Stock !!!');
			}else{
				$('#table-create-peminjaman tbody').html(result);
			}
		}
	});
	$('#txtBarcode').val('');
}

function UpdatePinjamItem(){
	var barcode = $('#txtBarcode').val();
	$.ajax({
		type:'POST',
		data:{id: barcode},
		url :baseurl+"Toolroom/Transaksi/addNewItem",
		success:function(result){
			if(result == "null"){
				alert('There is no item !!!');
			}else if(result == "out"){
				alert('Out Of Stock !!!');
			}else{
				$('#table-update-peminjaman tbody').html(result);
			}
		}
	});
	$('#txtBarcode').val('');
}

function removeListOutItem(id,id_trans,user){
	$.ajax({
		type:'POST',
		data:{id: id,id_trans:id_trans,user:user},
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

function getName(){
	var id = $('#txtNoind').val();
	$.ajax({
		type:'POST',
		data:{id: id},
		url :baseurl+"Toolroom/Transaksi/getName",
		success:function(result){
			if(result == "null"){
				alert('No matching Id Number !');
				$('#txtName').val('');
			}else{
				$('#txtName').val(result);
			}
		}
	});
}

function AddPengembalianItem(){
	var barcode = $('#txtBarcode').val();
	$.ajax({
		type:'POST',
		data:{id: barcode},
		url :baseurl+"Toolroom/Transaksi/addNewPengembalianItem",
		success:function(result){
			$('#table-create-pengembalian-today tbody').html(result);
		}
	});
	$('#txtBarcode').val('');
}

