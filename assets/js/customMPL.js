$(document).ready(function(){
	$('.tblPurcOrderClass').DataTable({
		"paging":   true,
		"ordering": true,
		"info":     false,
		"pageLength": 50
	});
})

$(document).ready(function(){
	$('#tabelPengirimanMPL').DataTable({
		"paging":   true,
		"ordering": true,
		"info":     false,
		"pageLength": 50
	});
})

$(document).ready(function(){
	$('.tblSetting').DataTable({
		"paging":   true,
		"ordering": true,
		"info":     false
	});
})

var num = 2;
function addRowMpplPO(){ //APPEND DI NEW SHIPMENT
		
		$.ajax({
		type: "GET",
		url: baseurl+"MonitoringPengirimanPesananLuar/InputPurchaseOrder/getKode",
		dataType: 'json'
	}).done(function(result){
		// kolom 1 
		var html = '<tr class="number'+num+'"><td>'+num+'</td>';
		// kolom 2
		html += '<td><input readonly type="text" class="form-control 1 kodeItemClsPOApp" style="width: 100%" id="slcKodeItem" name="slcKodeItem[]" readonly></td>'
		// kolom 3
		html += '<td><select onChange="cariKodeItemPOApp(this)" type="text" class="form-control select2 1 selectPOAppend selectdesApp selectPOHtml deskripsiClsPOApp" style="width: 100%" id="txtDeskripsi" name="txtDeskripsi[]">'
		html += '<option value="">Pilih</option>'
		$.each(result, function(i,item) {
		html += '<option value="'+item.id+'">'+item.nama_item+'</option>';
        })
		html +=	'</select></td>';
        // kolom 4
        html += '<td><input type="number" class="form-control QtyClsPOApp" style="width: 100%" id="txnQtyOrder" name="txnQtyOrder[]"></td>'
        html += '<td><input readonly type="text" class="form-control UomClsPOApp" style="width: 100%" id="txtUom" name="txtUom[]"></td>'
		html += '<td><button type="button" onClick="onClickBakso1('+num+')" class="btnDeleteRowUnit btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button></td>';
		html += "</tr>";
	num++;
    	$('#tabelAddMpplPO').append(html);

    	$('.selectPOAppend').select2({
		  allowClear: true,
		});

})
}

const onClickBakso1 = (th) => { 

	$('tr.number'+th).remove()
		num -=1
}


var numbrr = Number($('#tabelAddMpplEditPO tr:last td.editnum').text()) + 1;
function addRowMpplEditPO(){ //APPEND DI NEW SHIPMENT
		
		$.ajax({
		type: "GET",
		url: baseurl+"MonitoringPengirimanPesananLuar/InputPurchaseOrder/getKode",
		dataType: 'json'
	}).done(function(result){
		// kolom 1 
		var html = '<tr class="number'+numbrr+'"><td>'+numbrr+'</td>';
		// kolom 2
		// html += '<td><select onChange="cariKodeItemPOApp(this)" type="text" class="form-control selectPOAppend kodeItemClsPOApp" style="width: 100%" id="slcKodeItem" name="slcKodeItem[]">'
		// html += '<option value="" > Pilih  </option>'
		// $.each(result, function(i,item) {
		// html += '<option value="'+item.id+'">'+item.kode_item+'</option>';
  //       })
		// html +=	'</select></td>'
		html += '<td><input readonly type="text" class="form-control 1 kodeItemClsPOApp" style="width: 100%" id="slcKodeItem" name="slcKodeItemUpd[]" readonly></td>'
		// kolom 3
		html += '<td><select onChange="cariKodeItemPOApp(this)" type="text" class="form-control select2 1 selectPOAppend selectdesApp selectPOHtml deskripsiClsPOApp" style="width: 100%" id="txtDeskripsi" name="txtDeskripsiUpd[]">'
		html += '<option value="">Pilih</option>'
		$.each(result, function(i,item) {
		html += '<option value="'+item.id+'">'+item.nama_item+'</option>';
        })
		html +=	'</select></td>';
		// kolom 3
        html += '<td><input type="number" class="form-control QtyClsPOApp" style="width: 100%" id="txnQtyOrder" name="txnQtyOrderUpd[]"></td>'
        html += '<td><input type="text" class="form-control UomClsPOApp" style="width: 100%" id="txtUom" name="txtUomUpd[]"></td>'
		html += '<td><button type="button" onClick="onClickBakso12('+numbrr+')" class="btnDeleteRowUnit btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button></td>';
		html += "</tr>";
	numbrr++;
    	$('#tabelAddMpplEditPO').append(html);

    	$('.selectPOAppend').select2({
		  allowClear: true,
		});

})
}

const onClickBakso12 = (th) => { 

	$('tr.number'+th).remove()
		numbrr -=1
}


'use strict';

;( function ( document, window, index )
{
	var inputs = document.querySelectorAll( '.inputfile' );
	Array.prototype.forEach.call( inputs, function( input )
	{
		var label	 = input.nextElementSibling,
			labelVal = label.innerHTML;

		input.addEventListener( 'change', function( e )
		{
			var fileName = '';
			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				label.querySelector( 'span' ).innerHTML = fileName;
			else
				label.innerHTML = labelVal;
		});

		// Firefox bug fix
		input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
		input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
	});
}( document, window, 0 ));

	$('#btnSavePO').click(function(){
		Swal.fire({
			  type: 'success',
			  title: 'Data has been saved!',
			  showConfirmButton: false,
			  timer: 1500
			})
	})

	function backIP() {
		window.location.replace(baseurl+"MonitoringPengirimanPesananLuar/RekapPengiriman")
	}

	function backPO() {
		window.location.replace(baseurl+"MonitoringPengirimanPesananLuar/RekapPurchaseOrder")
	}

var num = 2;
function addRowMpplIP(){ //APPEND DI NEW SHIPMENT
		// kolom 1 
		var html = '<tr class="number'+num+'"><td>'+num+'</td>';
		// kolom 2
		html += '<td><input type="text" onChange="cariKodeItemIP()" class="form-control kodeItemClsIP" style="width: 100%" id="txtKodeItem" name="txtKodeItem[]"></td>';
		// kolom 3
		html += '<td><input type="text" class="form-control deskripsiClsIP" style="width: 100%" id="txtDeskripsi" name="txtDeskripsi[]"></td>';
        // kolom 4
        html += '<td><input type="number" class="form-control QtyClsIP" style="width: 100%" id="txnQtyOrder" name="txnQtyOrder[]"></td>'
        html += '<td><input type="text" class="form-control UomClsIP" style="width: 100%" id="txtUom" name="txtUom[]"></td>'
        html += '<td><input type="number" class="form-control deliveredClsIP" style="width: 100%" id="txnDelivered" name="txnDelivered[]"></td>'
		html +=	'<td><input type="number" class="form-control ACCClsIP" style="width: 100%" id="txnACC" name="txnACC[]"></td>'
		html +=	'<td><input type="number" class="form-control OutPoClsIP" style="width: 100%" id="txnOutPO" name="txnOutPO[]"></td>'
		html += '<td><button type="button" onClick="onClickBakso2('+num+')" class="btnDeleteRowUnit btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button></td>';
		html += "</tr>";
	num++;
    	$('#tabelAddMpplIP').append(html);

    	$('.selectUnitMPM').select2({
		  placeholder: 'Pilih',
		  allowClear: true,
		});

}

const onClickBakso2 = (th) => { 

	$('tr.number'+th).remove()
		num -=1
}

function cariKodeItemPO(th) {
		var row = $(th).closest('tr')
		var deskripsi = row.find('.deskripsiClsPO').val(); //isinya id nama_item 
		var kodeitem = row.find('.kodeItemClsPO');
		var uom = row.find('.UomClsPO');

		console.log(deskripsi);
		
		$.ajax({
			method: "POST",
			url: baseurl+"MonitoringPengirimanPesananLuar/InputPurchaseOrder/getItem",
			dataType: 'JSON',
			data:{
					kodeitem:deskripsi, //ini id nama_item
				},
			success: function(response) {
			var val1 = '';	
			var val2 = '';

			console.log(response)
			$.each(response, (i, item) => {
					val1 = item.kode_item
					val2 = item.uom					
				})	
				kodeitem.val(val1);
				kodeitem.trigger('change');
				uom.val(val2);
				uom.trigger('change');
			}

		});
}


// var nun = 2;
function cariKodeItemPOApp(th) {
		var row = $(th).closest('tr')
		var kodeitem = row.find('.kodeItemClsPOApp');
		console.log(kodeitem)
		var deskripsi = row.find('.selectdesApp').val();
		console.log(deskripsi)
		var uom = row.find('.UomClsPOApp');
		
		$.ajax({
			method: "POST",
			url: baseurl+"MonitoringPengirimanPesananLuar/InputPurchaseOrder/getItemApp",
			dataType: 'JSON',
			data:{
					kodeitem:deskripsi,
				},
			success: function(response) {
			console.log(response)
			var val1 = '';	
			var val2 = '';

			console.log(response)
			$.each(response, (i, item) => {
					val1 = item.kode_item
					val2 = item.uom					
				})	
				kodeitem.val(val1);
				kodeitem.trigger('change');
				uom.val(val2);
				uom.trigger('change');

				// nun++;

			}

		});
}


	const deleteEdit2 = (th) => {
		var row = $(th).closest('tr');
		row.remove();
		numbrr -=1
}
	//  a-=

	// inputDes.val(null).trigger('change');
	// selectItem.val(null).trigger('change');
	
 //    var row2 = $(th).closest('tr')
 //    var teer = row2.find('tr')
 //    teer.remove()
    

function onDeletePO(th) {

	var row = $(th).closest('tr');
	var id_rekap_po = row.find('#hdnPO').val();
	var no_po = row.find('#hdnPO2').val();
	console.log(no_po, id_rekap_po);

	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

	swalWithBootstrapButtons.fire({
		  title: 'Purchase Order Akan Dihapus',
		  text: 'Yakin ingin menghapus Purchase Order No.'+id_rekap_po+'?',
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Yes, delete it!',
		  cancelButtonText: 'No, cancel!',
		  reverseButtons: true
	}).then((result) => {
  if (result.value) {
	  	$.ajax({
					type: "POST",
					url: baseurl+"MonitoringPengirimanPesananLuar/RekapPurchaseOrder/delete",
					data:{
						id_rekap_po:id_rekap_po,
						no_po:no_po
					},
					success: function(response) {
						  swalWithBootstrapButtons.fire(
					      'Deleted!',
					      'Purchase Order No.'+id_rekap_po+' berhasil dihapus!',
					      'success'
					    	)
						  window.location.reload();
			 		}

				});
  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelled',
      'Purchase Order No.'+id_rekap_po+' batal dihapus :)',
      'error'
    )
  }
})
}

function onDeletePengiriman(th) {
	var id_rekap_pengiriman = th;

	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

	swalWithBootstrapButtons.fire({
		  title: 'Pengiriman Akan Dihapus',
		  text: 'Yakin ingin menghapus Pengiriman No.'+id_rekap_pengiriman+'?',
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Yes, delete it!',
		  cancelButtonText: 'No, cancel!',
		  reverseButtons: true
	}).then((result) => {
  if (result.value) {
	  	$.ajax({
					type: "POST",
					url: baseurl+"MonitoringPengirimanPesananLuar/RekapPengiriman/delete2",
					data:{
						id_rekap_pengiriman:id_rekap_pengiriman,
					},
					success: function(response) {
						  swalWithBootstrapButtons.fire(
					      'Deleted!',
					      'Pengiriman No.'+id_rekap_pengiriman+' berhasil dihapus!',
					      'success'
					    	)
						  window.location.reload();
			 		}

				});
  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelled',
      'Pengiriman No.'+id_rekap_po+' batal dihapus :)',
      'error'
    )
  }
})
}

function openModalPO(th) {
	id_rekap_po = th;

	$('#mdlDetailPo').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengirimanPesananLuar/RekapPurchaseOrder/openModalPO",
			data:{
				id:id_rekap_po,
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);

			}
		})
}

function onchangePOPengiriman() { 
	var customer = $('.selectCustPeng').val();
	var no_po = $('.slcPo');

$('.div_loading').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
	$.ajax({
			method: "POST",
			url: baseurl+"MonitoringPengirimanPesananLuar/InputPengiriman/selectPO",
			dataType: 'JSON',
			data:{
					id:customer,
				},
			success: function(response) {
				var dataItem = '';

				$.each(response, (i, item) => {
					dataItem += '<option value="'+item.no_po+'">'+item.no_po+'</option>'
				})	

				no_po.html(dataItem);
				no_po.trigger('change');
				var val = no_po.val();
				pilihPO(item); 

			}
		})

}

function pilihPO(th) { 
	var row = $(th).closest('tr')
	var no_po = row.find('.slcPo').val();

	console.log(no_po)
	
	if (no_po == null){
		Swal.fire({
			  type: 'error',
			  title: 'Data not found!',
			  showConfirmButton: false,
			  timer: 1500
			})

		$('#tblViewInputPengiriman tr').remove()
	}

	$.ajax({ 
			method: "POST",
			url: baseurl+"MonitoringPengirimanPesananLuar/InputPengiriman/ambilData",
			dataType: 'JSON',
			data:{
					no_po:no_po,
				},
			success: function(response) {
				console.log(response)
				var kode_item = '';
				var nama_item = '';
				var ordered_qty = '';
				var uom = '';
var numbb = 1;
let html = null
$.each(response, (i, item) => {
		html += '<tr class="bakso'+numbb+'"><td disabled>'+numbb+'</td>';
		// kolom 2
		html += '<td><input readonly type="text" value="'+item.kode_item+'" class="form-control kodeItemClsIP" style="width: 100%" id="txtKodeItemAut" name="txtKodeItem[]"></td>';
		// kolom 3
		html += '<td><input readonly type="text" value="'+item.nama_item+'" class="form-control deskripsiClsIP" style="width: 100%" id="txtDeskripsiAut" name="txtDeskripsi[]"></td>';
        // kolom 4
        html += '<td><input readonly type="number" value="'+item.ordered_qty+'" class="form-control QtyClsIP" style="width: 100%" id="txnQtyOrderAut" name="txnQtyOrder[]"></td>'
        html += '<td><input type="number" max="'+item.ordered_qty+'" onkeyup="if(this.value > '+item.ordered_qty+') this.value = null" onchange="functionDelivered(this)" class="form-control deliveredClsIP" style="width: 100%" id="txnDeliveredAut" name="txnDelivered[]"></td>'
		html +=	'<td><input readonly type="number" class="form-control ACCClsIP" style="width: 100%" id="txnACCAut" name="txnACC[]"></td>'
		html +=	'<td><input readonly type="number" class="form-control OutPoClsIP" style="width: 100%" id="txnOutPOAut" name="txnOutPO[]"></td>'
        html += '<td><input readonly type="text" value="'+item.uom+'" class="form-control UomClsIP" style="width: 100%" id="txtUomAut" name="txtUom[]"></td>'
		html += "</tr>";
		

		numbb++;

				})	

$('#tblViewInputPengiriman').html(html);
			}
		})

}

function pilihPOEdit(th) { 
	var row = $(th).closest('tr')
	var no_po = row.find('.slcPo').val();

	console.log(no_po)
	
	if (no_po == null){
		Swal.fire({
			  type: 'error',
			  title: 'Data not found!',
			  showConfirmButton: false,
			  timer: 1500
			})
	}

	$.ajax({ 
			method: "POST",
			url: baseurl+"MonitoringPengirimanPesananLuar/InputPengiriman/ambilDataEdit",
			dataType: 'JSON',
			data:{
					no_po:no_po,
				},
			success: function(response) {
				console.log(response)
				var kode_item = '';
				var nama_item = '';
				var ordered_qty = '';
				var uom = '';
var numbb = 1;
let html = null
$.each(response, (i, item) => {
		html += '<tr class="bakso'+numbb+'"><td disabled>'+numbb+'</td>';
		// kolom 2
		html += '<td><input readonly type="text" value="'+item.kode_item+'" class="form-control kodeItemClsIP" style="width: 100%" id="txtKodeItemAut" name="txtKodeItem[]"></td>';
		// kolom 3
		html += '<td><input readonly type="text" value="'+item.nama_item+'" class="form-control deskripsiClsIP" style="width: 100%" id="txtDeskripsiAut" name="txtDeskripsi[]"></td>';
        // kolom 4
        html += '<td><input readonly type="number" value="'+item.ordered_qty+'" class="form-control QtyClsIP" style="width: 100%" id="txnQtyOrderAut" name="txnQtyOrder[]"></td>'
        html += '<td><input type="number" max="'+item.ordered_qty+'" onkeyup="if(this.value > '+item.ordered_qty+') this.value = null" onchange="functionDelivered(this)" class="form-control deliveredClsIP" style="width: 100%" id="txnDeliveredAut" name="txnDelivered[]"></td>'
		html +=	'<td><input readonly type="number" class="form-control ACCClsIP" style="width: 100%" id="txnACCAut" name="txnACC[]"></td>'
		html +=	'<td><input readonly type="number" class="form-control OutPoClsIP" style="width: 100%" id="txnOutPOAut" name="txnOutPO[]"></td>'
        html += '<td><input readonly type="text" value="'+item.uom+'" class="form-control UomClsIP" style="width: 100%" id="txtUomAut" name="txtUom[]"></td>'
		html += "</tr>";
		

		numbb++;

				})	

$('#tblViewInputPengiriman').html(html);
			}
		})

}

function functionDelivered(th) {

	var row = $(th).closest('tr');
	var delivered = row.find('.deliveredClsIP').val();
	var ordered = row.find('.QtyClsIP').val();
	console.log("ini ordered qty", ordered);

	var hasil_acc = delivered
	var acc = row.find('.ACCClsIP');
	acc.val(hasil_acc);
	var new_acc = acc.val();
	console.log('ini new acc', new_acc)

	var hasil_out_po = Number(new_acc) - Number(ordered)
	console.log('ini hasilnya', hasil_out_po)


	var out_po = row.find('.OutPoClsIP');
	out_po.val(hasil_out_po);
	var checkNol = $('.OutPoClsIP').val()

	// if (checkNol == 0) {
	// 	console.log("sama dengan nol")
	// 	out_po.css('background-color', 'red')
	// 	out_po.prop('disabled', true)
	// }else if (checkNol !== 0) {
	// 	console.log("ga sama dengan nol")
	// 	out_po.css('background-color', 'white');
	// 	out_po.prop('disabled', true)
	// } 
	
}

function functionDelivered2(th) {

	var row = $(th).closest('tr');
	var delivered = row.find('.deliveredClsIP2').val();
	var ordered = row.find('.QtyClsIP2').val();
	var acc = row.find('.ACCClsIP2').val();
	var delivered_c = row.find('.deliveredClsIP2');
	var out = row.find('.OutPoClsIP2').val();
			var out2 = row.find('.OutPoClsIP2').val();
			console.log(out2)

	console.log("ini delivered qty", delivered);
	console.log("ini out qty", out2);

	// var hasil_acc = delivered
	var hasil_acc = Number(acc) + Number(delivered)
	var acc = row.find('.ACCClsIP2');
	acc.val(hasil_acc).trigger('change');
	var new_acc = acc.val();
	// delivered_c.prop('readonly', true);

	console.log('ini new acc', new_acc)

	var hasil_out_po = Number(delivered) + Number(out)
	console.log('ini hasilnya out po', hasil_out_po)


	var out_po = row.find('.OutPoClsIP2');
	out_po.val(hasil_out_po);
	var checkNol = $('.OutPoClsIP2').val()


	// if (checkNol == 0) {
	// 	console.log("sama dengan nol")
	// 	out_po.css('background-color', 'red')
	// 	out_po.prop('disabled', true)
	// }else if (checkNol !== 0) {
	// 	console.log("ga sama dengan nol")
	// 	out_po.css('background-color', 'white');
	// 	out_po.prop('disabled', true)
	// } 
	
}

function Resetdata(th) {
	var row = $(th).closest('tr');
	var deliver = row.find('.deliveredClsIP').val()
	console.log(deliver)
	var acc = row.find('.ACCClsIP2').val()
	var out = row.find('.OutPoClsIP2')
	var qty = row.find('.QtyClsIP2').val()
	var hasil = Number(acc) - Number(deliver);
	var acc2 = row.find('.ACCClsIP').val(hasil);
	var acc3 = acc2.val();
	console.log(acc3)
	var hasil2 = Number(acc3) - Number(qty);
	out.val(hasil2);
	row.find('.deliveredClsIP').val(null);
	row.find('.deliveredClsIP').prop('disabled', false);

}

function Resetdata2(th) {
	var row = $(th).closest('tr');
	var deliver = row.find('.deliveredClsIP2').val()
	console.log(deliver)
	var acc = row.find('.ACCClsIP2').val()
	var out = row.find('.OutPoClsIP2')
	var qty = row.find('.QtyClsIP2').val()
	var hasil = Number(acc) - Number(deliver);
	var acc2 = row.find('.ACCClsIP2').val(hasil);
	var acc3 = acc2.val();
	console.log(acc3)
	var hasil2 = Number(acc3) - Number(qty);
	out.val(hasil2);
	row.find('.deliveredClsIP2').val(null);
	row.find('.deliveredClsIP2').prop('disabled', false);

}

function functionDelivered3(th) {

	var row = $(th).closest('tr');
	var delivered = row.find('.deliveredClsIP2').val();
	var ordered = row.find('.QtyClsIP2').val();
	var acc = row.find('.ACCClsIP2').val();
	var delivered_c = row.find('.deliveredClsIP2');
	var out = row.find('.OutPoClsIP2').val();
	console.log("ini delivered qty", delivered);

	// var hasil_acc = delivered

	var hasil_acc = Number(delivered) + Number(acc)
	var acc = row.find('.ACCClsIP2');
	acc.val(hasil_acc).trigger('change');
	var new_acc = acc.val();
	// delivered_c.prop('readonly', true);

	console.log('ini new acc', new_acc)

	var hasil_out_po = Number(out) + Number(delivered)
	console.log('ini hasilnya', hasil_out_po)


	var out_po = row.find('.OutPoClsIP2');
	out_po.val(hasil_out_po);
	var checkNol = $('.OutPoClsIP2').val()


	// if (checkNol == 0) {
	// 	console.log("sama dengan nol")
	// 	out_po.css('background-color', 'red')
	// 	out_po.prop('disabled', true)
	// }else if (checkNol !== 0) {
	// 	console.log("ga sama dengan nol")
	// 	out_po.css('background-color', 'white');
	// 	out_po.prop('disabled', true)
	// } 
	
}

function saveInputPengiriman() {
	var customer = $('#slcCustomerPeng').val();
	var no_po = $('#slcNoPoPengiriman').val();
	var no_so = $('#txtNoSO').val();
	var no_dosp = $('#txtDOSP').val();
	var keterangan = $('#txaKeterangan').val();
	var ekspedisi = $('#slcEkspedisi').val();
	var delivery_date = $('#txdDeliveryDate').val();
	// console.log(delivery_date)

	var arry = [];
	$('input#txtKodeItemAut').each(function(){
	var kodeitem = $(this).val();
	arry.push(kodeitem);
	});

	var arry2 = [];
	$('input#txtDeskripsiAut').each(function(){
	var nama_item = $(this).val();
	arry2.push(nama_item);
	});

	var arry3 = [];
	$('input#txnQtyOrderAut').each(function(){
	var ordered = $(this).val();
	arry3.push(ordered);
	});

	var arry4 = [];
	$('input#txnDeliveredAut').each(function(){
	var delivered = $(this).val();
	arry4.push(delivered);
	});

	var arry5 = [];
	$('input#txnACCAut').each(function(){
	var acc = $(this).val();
	arry5.push(acc);
	});

	var arry6 = [];
	$('input#txnOutPOAut').each(function(){
	var outpo = $(this).val();
	arry6.push(outpo);
	});

	var arry7 = [];
	$('input#txtUomAut').each(function(){
	var uom = $(this).val();
	arry7.push(uom);
	});

 $.ajax({
 	type : "POST",
 	url : baseurl+'MonitoringPengirimanPesananLuar/InputPengiriman/submitInputPengiriman',
 	data : {
 		customer:customer,
 		delivery_date:delivery_date,
 		no_po:no_po,
 		no_so:no_so,
 		no_dosp:no_dosp,
 		keterangan:keterangan,
 		ekspedisi:ekspedisi,
 		kodeitem:arry,
 		nama_item:arry2,
 		ordered:arry3,
 		delivered:arry4,
 		acc:arry5,
 		outpo:arry6,
 		uom:arry7
 	},
 	success : function(response) {
 		console.log(response)
 		Swal.fire({
			  type: 'success',
			  title: 'Data has been saved!',
			  showConfirmButton: false,
			  timer: 1500
			})
		window.location.replace(baseurl+"MonitoringPengirimanPesananLuar/RekapPengiriman")
 	}
 })

}


function saveEditPengiriman(th) {
	var id_rekap_pengiriman = th;
	var no_po = $('#slcNoPoPengiriman').val();
	var no_so = $('#txtNoSOEd').val();
	var no_dosp = $('#txtDOSPEd').val();
	var keterangan = $('#txaKeteranganEd').val();
	var id_ekspedisi = $('#slcEkspedisiEd').val();
	var delivery_date = $('#txdDeliveryDate').val();
	var customer = $('#slcCustomerPengEd').val();

	console.log(no_so)

	var arry = [];
	$('input#txtKodeItemEd').each(function(){
	var kodeitem = $(this).val();
	arry.push(kodeitem);
	});

	var arry2 = [];
	$('input#txtDeskripsiEd').each(function(){
	var nama_item = $(this).val();
	arry2.push(nama_item);
	});

	var arry3 = [];
	$('input#txnQtyOrderEd').each(function(){
	var ordered = $(this).val();
	arry3.push(ordered);
	});

	var arry4 = [];
	$('input#txnDeliveredEd').each(function(){
	var delivered = $(this).val();
	arry4.push(delivered);
	});

	var arry5 = [];
	$('input#txnACCEd').each(function(){
	var acc = $(this).val();
	arry5.push(acc);
	});

	var arry6 = [];
	$('input#txnOutPOEd').each(function(){
	var outpo = $(this).val();
	arry6.push(outpo);
	});

	var arry7 = [];
	$('input#txtUomEd').each(function(){
	var uom = $(this).val();
	arry7.push(uom);
	});

	var arry8 = [];
	$('input#txtIdLIneEd').each(function(){
	var idLine = $(this).val();
	arry8.push(idLine);
	}); 

	var arry9 = [];
	$('input#txtActionDetail').each(function(){
	var idAction = $(this).val();
	arry9.push(idAction);
	});

	
 $.ajax({
 	type : "POST",
 	url : baseurl+'MonitoringPengirimanPesananLuar/RekapPengiriman/editInputPengiriman',
 	data : {
 		id_rekap_pengiriman:th,
 		no_po:no_po,
 		no_so:no_so,
 		no_dosp:no_dosp,
 		keterangan:keterangan,
 		id_ekspedisi:id_ekspedisi,
 		delivery_date:delivery_date,
 		customer:customer,
 		kodeitem:arry,
 		nama_item:arry2,
 		ordered:arry3,
 		delivered:arry4,
 		acc:arry5,
 		outpo:arry6,
 		uom:arry7,
 		id_line:arry8,
 		id_action:arry9
 	},
 	success : function(response) {
 		console.log(response)
 		Swal.fire({
			  type: 'success',
			  title: 'Data has been saved!',
			  showConfirmButton: false,
			  timer: 1500
			})
		window.location.replace(baseurl+"MonitoringPengirimanPesananLuar/RekapPengiriman")
 	}
 })
}


function saveTambahPengiriman(th) {
	var id_rekap_pengiriman = th;
	var no_po = $('#slcNoPoPengiriman').val();
	var no_so = $('#txtNoSOEd').val();
	var no_dosp = $('#txtDOSPEd').val();
	var keterangan = $('#txaKeteranganEd').val();
	var id_ekspedisi = $('#slcEkspedisiEd').val();
	var delivery_date = $('#txdDeliveryDate').val();
	var customer = $('#slcCustomerPengEd').val();

	console.log(no_so)

	var arry = [];
	$('input#txtKodeItemEd').each(function(){
	var kodeitem = $(this).val();
	arry.push(kodeitem);
	});

	var arry2 = [];
	$('input#txtDeskripsiEd').each(function(){
	var nama_item = $(this).val();
	arry2.push(nama_item);
	});

	var arry3 = [];
	$('input#txnQtyOrderEd').each(function(){
	var ordered = $(this).val();
	arry3.push(ordered);
	});

	var arry4 = [];
	$('input#txnDeliveredEd').each(function(){
	var delivered = $(this).val();
	arry4.push(delivered);
	});

	var arry5 = [];
	$('input#txnACCEd').each(function(){
	var acc = $(this).val();
	arry5.push(acc);
	});

	var arry6 = [];
	$('input#txnOutPOEd').each(function(){
	var outpo = $(this).val();
	arry6.push(outpo);
	});

	var arry7 = [];
	$('input#txtUomEd').each(function(){
	var uom = $(this).val();
	arry7.push(uom);
	});

	var arry8 = [];
	$('input#txtIdLIneEd').each(function(){
	var idLine = $(this).val();
	arry8.push(idLine);
	}); 

	var arry9 = [];
	$('input#txtActionDetail').each(function(){
	var idAction = $(this).val();
	arry9.push(idAction);
	});

	
 $.ajax({
 	type : "POST",
 	url : baseurl+'MonitoringPengirimanPesananLuar/RekapPengiriman/tambahInputPengiriman',
 	data : {
 		id_rekap_pengiriman:th,
 		no_po:no_po,
 		no_so:no_so,
 		no_dosp:no_dosp,
 		keterangan:keterangan,
 		id_ekspedisi:id_ekspedisi,
 		delivery_date:delivery_date,
 		customer:customer,
 		kodeitem:arry,
 		nama_item:arry2,
 		ordered:arry3,
 		delivered:arry4,
 		acc:arry5,
 		outpo:arry6,
 		uom:arry7,
 		id_line:arry8,
 		id_action:arry9
 	},
 	success : function(response) {
 		console.log(response)
 		Swal.fire({
			  type: 'success',
			  title: 'Data has been saved!',
			  showConfirmButton: false,
			  timer: 1500
			})
		window.location.replace(baseurl+"MonitoringPengirimanPesananLuar/RekapPengiriman")
 	}
 })
}

function openModalPengiriman(th) {
	var id_rekap_pengiriman = th;

	$('#mdlPengiriman').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengirimanPesananLuar/RekapPengiriman/openModalPengiriman",
			data:{
				id:id_rekap_pengiriman,
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);

			}
		})

}

function openModalPengiriman(th) {
	var id_rekap_pengiriman = th;

	$('#mdlPengiriman').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengirimanPesananLuar/RekapPengiriman/openModalPengiriman",
			data:{
				id:id_rekap_pengiriman,
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);

			}
		})

}

function MdlEditPo(th) {
	var id_rekap_po = th;

	$('#mdlDetailPo').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengirimanPesananLuar/RekapPurchaseOrder/edit",
			data:{
				id:id_rekap_po,
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);

			}
		})

}

function openHistoryPengiriman(th) {
	var id_rekap_pengiriman = th;

	$('#mdlPengiriman').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengirimanPesananLuar/RekapPengiriman/openHistoryPengiriman",
			data:{
				id:id_rekap_pengiriman,
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);

			}
		})
}

function saveSetupItem(th) {
	var kodeitem = $('#txtKodeItemSet').val();
	var namaitem = $('#txtDeskripsiItemSet').val();
	var uom = $('#txtUomSet').val();

	$.ajax({
		type: "POST",
		url: baseurl+"MonitoringPengirimanPesananLuar/Setting/Item/SaveItem",
		data: {
			kodeitem:kodeitem,
			namaitem:namaitem,
			uom:uom
		},
		success: function(response) {
			Swal.fire({
			  type: 'success',
			  title: ''+kodeitem+', '+namaitem+', and '+uom+' is added!',
			  showConfirmButton: false,
			  timer: 1500
			})
			window.location.reload()
		}
	})
}

function saveSetupCustomer(th) {
	var namacustomer = $('#txtNamaCustomerSet').val();

	$.ajax({
		type: "POST",
		url: baseurl+"MonitoringPengirimanPesananLuar/Setting/Customer/SaveCustomer",
		data: {
			namacustomer:namacustomer
		},
		success: function(response) {
			Swal.fire({
			  type: 'success',
			  title: ''+namacustomer+' is added!',
			  showConfirmButton: false,
			  timer: 1500
			})
			window.location.reload()
		}
	})
}

function saveSetupEkspedisi(th) {
	var namaekspedisi = $('#txtNamaEkspedisiSet').val();

	$.ajax({
		type: "POST",
		url: baseurl+"MonitoringPengirimanPesananLuar/Setting/Ekspedisi/SaveEkspedisi",
		data: {
			namaekspedisi:namaekspedisi
		},
		success: function(response) {
			Swal.fire({
			  type: 'success',
			  title: ''+namaekspedisi+' is added!',
			  showConfirmButton: false,
			  timer: 1500
			})
			window.location.reload()
		}
	})
}

function DeleteItem(th) {
   var id_kode_item = th;


   	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

	swalWithBootstrapButtons.fire({
		  title: 'Item akan dihapus',
		  text: 'Yakin ingin menghapus Item ini?',
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Yes, delete it!',
		  cancelButtonText: 'No, cancel!',
		  reverseButtons: true
	}).then((result) => {
  if (result.value) {
	  	$.ajax({
					type: "POST",
					url: baseurl+"MonitoringPengirimanPesananLuar/Setting/Item/deleteItem",
					data:{
						id_kode_item:id_kode_item
					},
					success: function(response) {
						  swalWithBootstrapButtons.fire(
					      'Deleted!',
					      'Item ini berhasil dihapus!',
					      'success'
					    	)
						  window.location.reload();
			 		}

				});
  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelled',
      'Item batal dihapus :)',
      'error'
    )
  }
})
}

function DeleteEkspedisi(th) {
   var id_ekspedisi = th;


   	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

	swalWithBootstrapButtons.fire({
		  title: 'Ekspedisi akan dihapus',
		  text: 'Yakin ingin menghapus Ekspedisi ini?',
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Yes, delete it!',
		  cancelButtonText: 'No, cancel!',
		  reverseButtons: true
	}).then((result) => {
  if (result.value) {
	  	$.ajax({
					type: "POST",
					url: baseurl+"MonitoringPengirimanPesananLuar/Setting/Ekspedisi/deleteEkspedisi",
					data:{
						id_ekspedisi:id_ekspedisi
					},
					success: function(response) {
						  swalWithBootstrapButtons.fire(
					      'Deleted!',
					      'Ekspedisi ini berhasil dihapus!',
					      'success'
					    	)
						  window.location.reload();
			 		}

				});
  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelled',
      'Ekspedisi batal dihapus :)',
      'error'
    )
  }
})
}

function DeleteCustomer(th) {
   var id_customer = th;


   	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: true
		})

	swalWithBootstrapButtons.fire({
		  title: 'Customer akan dihapus',
		  text: 'Yakin ingin menghapus Customer ini?',
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Yes, delete it!',
		  cancelButtonText: 'No, cancel!',
		  reverseButtons: true
	}).then((result) => {
  if (result.value) {
	  	$.ajax({
					type: "POST",
					url: baseurl+"MonitoringPengirimanPesananLuar/Setting/Customer/deleteCustomer",
					data:{
						id_customer:id_customer
					},
					success: function(response) {
						  swalWithBootstrapButtons.fire(
					      'Deleted!',
					      'Customer ini berhasil dihapus!',
					      'success'
					    	)
						  window.location.reload();
			 		}

				});
  } else if (
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelled',
      'Customer batal dihapus :)',
      'error'
    )
  }
})
}

function OpenModalItem(th) {
	var id_kode_item = th;

	$('#MdlSettingItem').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengirimanPesananLuar/Setting/Item/ModalItem",
			data:{
				id_kode_item:id_kode_item,
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);

			}
		})
}

function OpenModalCustomer(th) {
	var id_customer = th;

	$('#MdlCustomer').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengirimanPesananLuar/Setting/Customer/ModalCustomer",
			data:{
				id_customer:id_customer,
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);

			}
		})
}

function OpenModalEkspedisi(th) {
	var id_ekspedisi = th;

	$('#MdlEkspedisi').modal('show');
	$('.modal-tabel').html("<center><img id='loading12' style='width:200px ;margin-top: 2%;' src='"+baseurl+"assets/img/gif/loadingquick.gif'/><br /></center><br />");
		$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengirimanPesananLuar/Setting/Ekspedisi/ModalEkspedisi",
			data:{
				id_ekspedisi:id_ekspedisi,
			},
			success: function(response) {
				$('.modal-tabel').html("");
				$('.modal-tabel').html(response);

			}
		})
}

function UpdateItem(th) {
	var id_kode_item = th
	var kode_item = $('#kodeItemSett').val();
	var nama_item = $('#deskripsiSett').val();
	var uom = $('#uomSett').val();
	console.log(kode_item, nama_item, uom)

	$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengirimanPesananLuar/Setting/Item/UpdateItem",
			data:{
				id_kode_item:id_kode_item,
				kode_item:kode_item,
				nama_item:nama_item,
				uom:uom
			},
			success: function(response) {
			Swal.fire({
			  type: 'success',
			  title: ''+nama_item+' is edited!',
			  showConfirmButton: false,
			  timer: 1500
			})
			window.location.reload()
			$('#MdlSettingItem').modal('hide');
			}
		})

	}


function UpdateEkspedisi(th) {
	var id_ekspedisi = th;
	var nama_ekspedisi = $('#txtEkpedisiSett').val();

	$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengirimanPesananLuar/Setting/Ekspedisi/UpdateEkspedisi",
			data:{
				id_ekspedisi:id_ekspedisi,
				nama_ekspedisi:nama_ekspedisi
			},
			success: function(response) {
			Swal.fire({
			  type: 'success',
			  title: ''+nama_ekspedisi+' is edited!',
			  showConfirmButton: false,
			  timer: 1500
			})
			window.location.reload()
			$('#MdlEkspedisi').modal('hide');
			}
		})

	}

function UpdateCustomer(th) {
	var id_customer = th;
	var nama_customer = $('#txtCustomerSett').val();

	$.ajax({
			type: "POST",
			url: baseurl+"MonitoringPengirimanPesananLuar/Setting/Customer/UpdateCustomer",
			data:{
				id_customer:id_customer,
				nama_customer:nama_customer
			},
			success: function(response) {
			Swal.fire({
			  type: 'success',
			  title: ''+nama_customer+' is edited!',
			  showConfirmButton: false,
			  timer: 1500
			})
			window.location.reload()
			$('#MdlCustomer').modal('hide');
			}
		})

	}
