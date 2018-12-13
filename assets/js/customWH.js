


$(document).ready(function() {
	
	$("#tanggalReportAwal" ).datepicker({ format: 'DD, dd MM yyyy' });
	$("#tanggalReportAkhir" ).datepicker({ format: 'DD, dd MM yyyy' });
	$("#txtTanggalUsableKu").datepicker({ format: 'DD, dd MM yyyy' });
	$("#txtTanggalConsumableKu").datepicker({ format: 'DD, dd MM yyyy' });
	$("#txtTanggalPengembalian").datepicker({ format: 'DD, dd MM yyyy' });


	$('#tblMasterItemConsumable').DataTable({"lengthChange": false});
	$(".select-item-wh").select2({
		allowClear: true,
		placeholder: "[Select Item]",
		minimumInputLength: 3,
		ajax: {		
				url: baseurl+"Warehouse/Transaksi/getItem",
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
	
	$(".select-item-wh-consumable").select2({
		allowClear: true,
		placeholder: "[Select Item]",
		minimumInputLength: 3,
		ajax: {		
				url: baseurl+"Warehouse/Transaksi/getItemConsumable",
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
							return { id:obj.consumable_id, text:obj.item_code+" ( "+obj.item_name+" )"};
						})
					};
				}
			}
	});
	$(".select-noind-wh").select2({
		allowClear: true,
		placeholder: "[Select Noind]",
		minimumInputLength: 1,
		ajax: {		
				url: baseurl+"Warehouse/Transaksi/getNoind",
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
	
	if(window.location.href == baseurl+"Warehouse/Transaksi/CreatePeminjaman"){
		window.onload = function() {            
		function realtime() {
		   $.ajax({
					url :baseurl+"Warehouse/Transaksi/Time_",
					success:function(result){
						$('#hdnDate').val(result);
					}
				});
		}
		setInterval(realtime, 1000);
	}
	}
});

$(document).on("click", "#btnExecuteSaveWh", function () {
	var shift = $('#txsShift option:selected').attr('value');
	var noind = $('#txtNoind').val();
	var user = $('#hdnUser').val();
	var date = $('#txtTanggalUsableKu').val();
	var name = $('#txtName').val();


	if(shift.length === 0 || noind.length === 0 || date.length === 0){
		alert('your application form is not complete yet (SHIFT/NOIND/DATE). Please check again !!');
	}else{
		$.ajax({
			type:'POST',
			data:{noind: noind,user:user,date:date,shift:shift,name:name},
			url :baseurl+"Warehouse/Transaksi/addNewLending",
			success:function(result){
				$('#table-create-peminjaman tbody tr').each(function() {
					var item_id = $(this).find(".item_id").html();    
					var item_name = $(this).find(".item_name").html();    
					var sisa_stok = $(this).find(".sisa_stok").html();    
					var item_out = $(this).find(".item_out").val();
					$.ajax({
						type:'POST',
						data:{noind: noind,user:user,date:date,item_id:item_id,item_name:item_name,sisa_stok:sisa_stok,item_out:item_out,id_transaction:result},
						url :baseurl+"Warehouse/Transaksi/addNewLendingList"
					});
				});
				$('#table-create-peminjaman tbody').html("");
				$('#txtNoind').val('');
				$('#txtName').val('');
				$('#txsSelect').val('');
				$('#txtTanggalUsableKu').val('');
				alert('List Item Has Been Added !');
			}
		});
	}
	$('#txtBarcode').focus();
});

$(document).on("click", "#btnExecuteSaveWhConsumable", function () {
	var shift = $('#txsShift option:selected').attr('value');
	var noind = $('#txtNoind').val();
	var user = $('#hdnUser').val();
	var date = $('#txtTanggalConsumableKu').val();
	var name = $('#txtName').val();

	if(shift.length === 0 || noind.length === 0 || date.length === 0){
		alert('your application form is not complete yet (SHIFT/NOIND/DATE). Please check again !!');
	}else{
		$.ajax({
			type:'POST',
			data:{noind: noind,user:user,date:date,shift:shift,name:name},
			url :baseurl+"Warehouse/Transaksi/addNewLendingConsumable",
			success:function(result){
				$('#table-create-peminjaman tbody tr').each(function() {
					var item_id = $(this).find(".item_id").html();    
					var item_name = $(this).find(".item_name").html();    
					var sisa_stok = $(this).find(".sisa_stok").html();    
					var item_out = $(this).find(".item_out").val();
					$.ajax({
						type:'POST',
						data:{noind: noind,user:user,date:date,item_id:item_id,item_name:item_name,sisa_stok:sisa_stok,item_out:item_out,id_transaction:result},
						url :baseurl+"Warehouse/Transaksi/addNewLendingList"
					});
				});
				$('#table-create-peminjaman tbody').html("");
				$('#txtNoind').val('');
				$('#txtName').val('');
				$('#txsSelect').val('');
				$('#txtTanggalConsumableKu').val('');
				alert('List Item Has Been Added !');
				clearListOutItemWhConsumable(0)
			}
		});
	}
	$('#txtBarcode').focus();
});

$(document).on("click", "#btnExecuteUpdateWh", function () {
	var id = $('#txtID').val();
	var noind = $('#txtNoind').val();
	var shift = $('#txsShift').val();
	var user = $('#hdnUser').val();
	var date = $('#hdnDate').val();
	var txtQtyPinjam = $('#txtQtyPinjam').val();
	$.ajax({
		type:'POST',
		data:{id:id,noind: noind,user:user,date:date,shift:shift,txtQtyPinjam:txtQtyPinjam},
		url :baseurl+"Warehouse/Transaksi/UpdateNewLendingList",
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
					
				});
			});
			window.location.replace(baseurl+"Warehouse/Transaksi/Keluar");
			alert('List Item Has Been Updated !');
		}
	});
});

$(document).on("click", "#btnExecuteUpdateWhConsumable", function () {
	var id = $('#txtID').val();
	var noind = $('#txtNoind').val();
	var shift = $('#txsShift').val();
	var user = $('#hdnUser').val();
	var date = $('#hdnDate').val();
	var txtQtyPinjam = $('#txtQtyPinjam').val();
	$.ajax({
		type:'POST',
		data:{id:id,noind: noind,user:user,date:date,shift:shift,txtQtyPinjam:txtQtyPinjam},
		url :baseurl+"Warehouse/Transaksi/UpdateNewLendingList",
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
					
				});
			});
			window.location.replace(baseurl+"Warehouse/Transaksi/Keluar/Consumable");
			alert('List Item Has Been Updated !');
		}
	});
});

function AddItemWh(exe){
	var barcode = $('#txtBarcode').val(),
		user = $('#hdnUser').val(),
		type = $('#txtID').val(),
		count = $('#table-'+exe+'-peminjaman tbody tr').length,
		no = 0;

		console.log(exe);

		$('#txtBarcode').attr("readonly", 'readonly');
		if(count == 0){
			no = parseInt(no)+1;
			$.ajax({
					type:'POST',
					data:{id: barcode},
					url :baseurl+"Warehouse/Transaksi/getItemUpdate",
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
							$(this).find(".sisa_stok").html(parseInt(stok));
							return false;
						}else if(no==count){
							no = parseInt(no)+1;
							 $.ajax({
									type:'POST',
									data:{id: barcode,no:no},
									url :baseurl+"Warehouse/Transaksi/getItemUpdate",
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
	$( "#txtNoind" ).focus();
}

function AddItemWhConsumable(exe){
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
					url :baseurl+"Warehouse/Transaksi/getItemUpdateConsumable",
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
							$(this).find(".sisa_stok").html(parseInt(stok));
							return false;
						}else if(no==count){
							no = parseInt(no)+1;
							 $.ajax({
									type:'POST',
									data:{id: barcode,no:no},
									url :baseurl+"Warehouse/Transaksi/getItemUpdateConsumable",
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
	$( "#txtNoind" ).focus();
}

function removeListOutItemWh(id,id_trans,user){
	$.ajax({
		type:'POST',
		data:{id: id,id_trans:id_trans,user:user},
		url :baseurl+"Warehouse/Transaksi/removeNewItem",
		success:function(result){
			if(id_trans == 0){
			console.log(result)
				$('#table-create-peminjaman tbody').html(result);
			}else{
				$('#table-update-peminjaman tbody').html(result);
			}
		}
	});
}

function removeListOutItemWhConsumable(id,id_trans,user){
	$.ajax({
		type:'POST',
		data:{id: id,id_trans:id_trans,user:user},
		url :baseurl+"Warehouse/Transaksi/removeNewItemConsumable",
		success:function(result){
			if(id_trans == 0){
			console.log(result)
				$('#table-create-peminjaman tbody').html(result);
			}else{
				$('#table-update-peminjaman tbody').html(result);
			}
		}
	});
}

function clearListOutItemWh(id){
	$.ajax({
		type:'POST',
		data:{id: id},
		url :baseurl+"Warehouse/Transaksi/clearNewItem",
		success:function(result){
				$('#table-create-peminjaman tbody').html(result);
		}
	});
}

function clearListOutItemWhConsumable(id){
	$.ajax({
		type:'POST',
		data:{id: id},
		url :baseurl+"Warehouse/Transaksi/clearNewItemConsumable",
		success:function(result){
				$('#table-create-peminjaman tbody').html(result);
		}
	});
}

function getNameWh(){
	var id = $('#txtNoind').val();
	$.ajax({
		type:'POST',
		data:{id: id},
		url :baseurl+"Warehouse/Transaksi/getName",
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

function AddPengembalianItemWh(){
	// var barcode = $('#txtBarcode').val();
	// var txtQtyKembali = $('#txtQtyKembali').val();
	// $.ajax({
	// 	type:'POST',
	// 	data:{barcode: barcode,trans : id,date:date,txtQtyKembali:txtQtyKembali},
	// 	url :baseurl+"Warehouse/Transaksi/addNewPengembalianItem",
	// 	success:function(result){
	// 		$('#table-create-pengembalian-today tbody').html(result);
		
	// }
	// });

	var induk = $('#txtNoInduk').val();
	var barcode = $('#txtBarcode').val();
	var txtQtyKembali = $('#txtQtyKembali').val();
	var id = $('#table-create-pengembalian-today').find('#barcode'+barcode).find('input[type="hidden"]').val();
	var	date = $('#txtTanggalPengembalian').val();
	console.log(id);
	 $.ajax({
		type:'POST',
		data:{barcode: barcode,txtQtyKembali:txtQtyKembali,induk:induk,id:id,date:date},
		url :baseurl+"Warehouse/Transaksi/addNewPengembalianItem",
		success:function(result){
			console.log(result);
			searchPekerja()
			//$('#table-create-pengembalian-today tbody').html(result);
		}
	});


	$('#txtBarcode').val('');
	$('#txtQtyKembali').val('');
	$('#txtTanggalPengembalian').val('');
	$('#txtTanggalPengembalian').attr('disabled','disabled');
	$('#txtQtyKembali').attr('readonly','readonly');
}

function openTanggal(){
	var barcode = $('#txtBarcode').val();
	$.ajax({
		type:'POST',
		data:{barcode: barcode},
		url :baseurl+"Warehouse/Transaksi/CheckBarcodekembali",
		success:function(result){
			if(result == "null"){
				alert('There is no item !!!');
			}
			else{
				$('#txtTanggalPengembalian').removeAttr('disabled');
			}
		}
	});
}

function openInputQtyKembali(){
	var date = $('#txtTanggalPengembalian').val();
	if(date.length > 0){
		$('#txtQtyKembali').removeAttr('disabled');
	}	
}



function copyPekerjaWh(){
	var noind = $('#slcModalNoind').val();
	$('#txtNoind').val(noind);
	$.ajax({
		type:'POST',
		data:{id: noind},
		url :baseurl+"Warehouse/Transaksi/getName",
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

function copyItemWh(){
	var barcode = $('#slcModalBarcode').val();
	var user = $('#hdnUser').val();
	$.ajax({
		type:'POST',
		data:{id: barcode,user:user,type:0},
		url :baseurl+"Warehouse/Transaksi/addNewItem",
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

function copyItemUpdateWh(){
	var barcode = $('#slcModalBarcodeUpdate').val();
	var user = $('#hdnUser').val();
	var type = $('#txtID').val();
	$.ajax({
		type:'POST',
		data:{id: barcode,user:user,type:type},
		url :baseurl+"Warehouse/Transaksi/addNewItem",
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

function copyItemWhConsumable(){
	var barcode = $('#slcModalBarcodeConsumable').val();
	var user = $('#hdnUser').val();
	console.log('consum');
	$.ajax({
		type:'POST',
		data:{id: barcode,user:user,type:0},
		url :baseurl+"Warehouse/Transaksi/addNewItem",
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

function copyItemUpdateWhConsumable(){
	var barcode = $('#slcModalBarcodeUpdateConsumable').val();
	var user = $('#hdnUser').val();
	var type = $('#txtID').val();
	$.ajax({
		type:'POST',
		data:{id: barcode,user:user,type:type},
		url :baseurl+"Warehouse/Transaksi/addNewItemConsumable",
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

function copyItemWhConsumable(){
	var barcode = $('#slcModalBarcodeConsumable').val();
	var user = $('#hdnUser').val();
	$.ajax({
		type:'POST',
		data:{id: barcode,user:user,type:0},
		url :baseurl+"Warehouse/Transaksi/addNewItemConsumable",
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

function copyItemUpdateWhConsumable(){
	var barcode = $('#slcModalBarcodeUpdateConsumable').val();
	var user = $('#hdnUser').val();
	var type = $('#txtID').val();
	$.ajax({
		type:'POST',
		data:{id: barcode,user:user,type:type},
		url :baseurl+"Warehouse/Transaksi/addNewItem",
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

function copyPekerjaUpdateWh(){
	var noind = $('#slcNoindUpdate').val();
	$('#txtNoind').val(noind);
	$.ajax({
		type:'POST',
		data:{id: noind},
		url :baseurl+"Warehouse/Transaksi/getName",
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

function searchPekerja(){
	var noind = $('#txtNoInduk').val();
	
	$.ajax({
		type:'POST',
		data:{id: noind},
		url :baseurl+"Warehouse/Transaksi/getPinjamanUser",
		success:function(result){
			if(result == "null"){
				alert('Tidak ada data pinjaman');
				$('#txtNoInduk').val('');
			}else{
				$('#table-create-pengembalian-today tbody').html(result);
				$('#txtBarcode').removeAttr('readonly');
			}
		},
		error:function(error,status){
			console.log(error);
		}
	});
}



