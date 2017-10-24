$(document).ready(function() {
	$('.table-item-usable').DataTable({"lengthChange": false,"searching": true,"ordering": false,"info": false});
	$('.table-create-pengembalian-today').DataTable({"lengthChange": false,"searching": true,"ordering": false,"info": false});
	$('.datepicker-range').datepicker({
		 autoclose: true,
	});
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
	
	if(window.location.href == baseurl+"Toolroom/Transaksi/CreatePeminjaman"){
		window.onload = function() {            
		function realtime() {
		   $.ajax({
					url :baseurl+"Toolroom/Transaksi/Time_",
					success:function(result){
						$('#hdnDate').val(result);
					}
				});
		}
		setInterval(realtime, 1000);
	}
	}
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
		var shift = $('#txsShift option:selected').attr('value');
		var noind = $('#txtNoind').val();
		var user = $('#hdnUser').val();
		var date = $('#hdnDate').val();
		var name = $('#txtName').val();
		if(shift.length === 0 || noind.length === 0){
				alert('your application form is not complete yet (SHIFT/NOIND). Please check again !!');
		}else{
				$.ajax({
				type:'POST',
				data:{noind: noind,user:user,date:date,shift:shift,name:name},
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
					$('#table-create-peminjaman tbody').html("");
					$('#txtNoind').val('');
					$('#txtName').val('');
					$('#txsSelect').val('');
					alert('List Item Has Been Added !');
				}
			});
		}
	// }
});

$(document).on("click", "#btnExecuteUpdate", function () {
	// if (confirm('Are you sure you want to save this thing into the database?')) {
		var id = $('#txtID').val();
		var noind = $('#txtNoind').val();
		var shift = $('#txsShift').val();
		var user = $('#hdnUser').val();
		var date = $('#hdnDate').val();
		$.ajax({
			type:'POST',
			data:{id:id,noind: noind,user:user,date:date,shift:shift},
			url :baseurl+"Toolroom/Transaksi/UpdateNewLending",
			success:function(result){
				$('#table-update-peminjaman tbody tr').each(function() {
					var list_id = $(this).find(".list_id").html();    
					var item_id = $(this).find(".item_id").html();    
					var item_name = $(this).find(".item_name").html();    
					var sisa_stok = $(this).find(".sisa_stok").html();    
					var item_out = $(this).find(".item_out").val();
					$.ajax({
						type:'POST',
						data:{id:id,noind: noind,user:user,date:date,item_id:item_id,item_name:item_name,sisa_stok:sisa_stok,item_out:item_out,id_transaction:result,list_id:list_id},
						url :baseurl+"Toolroom/Transaksi/UpdateNewLendingList"
					});
				});
				window.location.replace(baseurl+"Toolroom/Transaksi/Keluar");
				alert('List Item Has Been Updated !');
			}
		});
	// }
});

function AddItem(exe){
	var barcode = $('#txtBarcode').val(),
		user = $('#hdnUser').val(),
		type = $('#txtID').val(),
		count = $('#table-'+exe+'-peminjaman tbody tr').length,
		no = 0;
		$('#txtBarcode').attr("readonly", 'readonly');
		if(count == 0){
			no = parseInt(no)+1;
			$.ajax({
					type:'POST',
					data:{id: barcode},
					url :baseurl+"Toolroom/Transaksi/getItemUpdate",
					success:function(result){
						if(result == "null"){
							alert('There is no item !!!');
						}else if(result == "out"){
							alert('Out Of Stock !!!');
						}else{
							$('#table-'+exe+'-peminjaman tbody').append(result);
							$('#no_mor').html(no);
						}
					}
				});
		$('#txtBarcode').removeAttr("readonly", 'readonly');
		}else{
			$('#table-'+exe+'-peminjaman tbody tr').each(function() {
				no = parseInt(no)+1;
				var barcode2 = $(this).find(".item_id").html(),
					stok = $(this).find(".sisa_stok").html();
					if(stok == 0 && barcode2 == barcode){
						alert('Out Of Stock !!!');
					}else{
						if(barcode == barcode2){
							var item_out = $(this).find(".item_out").val();
							$(this).find(".item_out").val(parseInt(item_out)+1);
							$(this).find(".sisa_stok").html(parseInt(stok)-1);
							return false;
						}else if(no==count){
							no = parseInt(no)+1;
							 $.ajax({
									type:'POST',
									data:{id: barcode,no:no},
									url :baseurl+"Toolroom/Transaksi/getItemUpdate",
									success:function(result){
										if(result == "null"){
											alert('There is no item !!!');
										}else if(result == "out"){
											alert('Out Of Stock !!!');
										}else{
											$('#table-'+exe+'-peminjaman tbody tr:last').after(result);
										}
									}
								});
						}		
					}	
			});
		}
	$('#txtBarcode').removeAttr("readonly", 'readonly');
	$('#txtBarcode').val('');
}

function removeListOutItem(id,id_trans,user){
	$.ajax({
		type:'POST',
		data:{id: id,id_trans:id_trans,user:user},
		url :baseurl+"Toolroom/Transaksi/removeNewItem",
		success:function(result){
			if(id_trans === 0){
				$('#table-create-peminjaman tbody').html(result);
			}else{
				$('#table-update-peminjaman tbody').html(result);
			}
		}
	});
}

function clearListOutItem(id){
	$.ajax({
		type:'POST',
		data:{id: id},
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

function AddPengembalianItem(id,date){
	var barcode = $('#txtBarcode').val();
	$.ajax({
		type:'POST',
		data:{barcode: barcode,trans : id,date:date},
		url :baseurl+"Toolroom/Transaksi/addNewPengembalianItem",
		success:function(result){
			$('#table-create-pengembalian-today tbody').html(result);
		}
	});
	$('#txtBarcode').val('');
}

function copyPekerja(){
	var noind = $('#slcModalNoind').val();
	$('#txtNoind').val(noind);
	$.ajax({
		type:'POST',
		data:{id: noind},
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
	$('#modalSearchNoind').modal('hide');
}

function copyItem(){
	var barcode = $('#slcModalBarcode').val();
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
	$('#modalSearchItem').modal('hide');
}

function copyItemUpdate(){
	var barcode = $('#slcModalBarcodeUpdate').val();
	var user = $('#hdnUser').val();
	var type = $('#txtID').val();
	$.ajax({
		type:'POST',
		data:{id: barcode,user:user,type:type},
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
	$('#modalSearchItem').modal('hide');
}

function copyPekerjaUpdate(){
	var noind = $('#slcNoindUpdate').val();
	$('#txtNoind').val(noind);
	$.ajax({
		type:'POST',
		data:{id: noind},
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
	$('#modalSearchNoind').modal('hide');
}

