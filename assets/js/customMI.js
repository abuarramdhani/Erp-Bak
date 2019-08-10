$(document).ready(function(){
	//mengatur semua tabel
	$('#btn_clear_invoice').click(function() {
		$('#nama_vendor').val('').trigger('change')
	})
	$('#btnMICancel').click(function() {
		$('#poLinesTable').remove()
	})
	$('.tblMI').DataTable({
		"paging":   true,
		"ordering": true,
		"info":     false
	});
	$('span[class~="statusInvoice"]').each(function(){
	var status = $(this).attr('value');
		if(status == 2){
			$(this).parent().parent().closest('tr').find('input[class~="chckInvoice"]').iCheck('check');
		}
		if(status == 1){
			$(this).parent().parent().closest('tr').find('input[class~="chckInvoice"]').iCheck('uncheck');
		}
		if(status == 3){
			$(this).parent().parent().closest('tr').find('input[class~="chckInvoice"]').iCheck('disable');
			$(this).parent().parent().closest('tr').find('button[name="checkbtndisable[]"]').toggleClass('btn-primary btn-info');
		}
	})
	$(document).on('ifChanged','.submit_checking_all', function() {
		if ($('.submit_checking_all').iCheck('update')[0].checked) {
			$('.chckInvoice').each(function () {
				var a = $(this).parent().parent().closest('tr').find('input[class~="chckInvoice"]');
				if (a) {
					$(this).iCheck('check');
				}
				// $(this).prop('checked',true);
			});
		}else{
			$('.chckInvoice').each(function () {
				// $(this).prop('checked',false);
				$(this).iCheck('uncheck');
			});
		};
	})
	$('#btnSubmitChecking').click(function(){
		var jml = 0;
		var arrId = [];
		$('input[name="mi-check-list[]"]').each(function(){
			if ($(this).parent().hasClass('checked')) {
				jml = jml +1;
				valueId = $(this).val();
				arrId.push(valueId);
				var hasil = arrId.join();
				$('input[name="idYangDiPilih"]').val(hasil);
				
				$('.invoice_category').val($(this).attr('inv-cat'));
			}
		});
		$('#jmlChecked').text(jml);
		// $('#content1').slideDown();
		// $('#content2').slideUp();
	});
	// $('.inv_amount').moneyFormat();
	// $('.po_amount').moneyFormat();
	//formatting input di tax invoice number
	$("input[name='tax_invoice_number']").attr({ maxLength : 19 }).keyup(function() {
		$(this).val($(this).val().replace(/^(\d{3})(\d{3})(\d{2})(\d)+$/, "$1.$2-$3.$4"));
	});
	$('#slcVendor').val($('#slcVendor').attr('value')).trigger('change');
	
	var $po_num_btn = $('#slcPoNumberMonitoring');
	$('.btn_search').on('mousedown', function () {
		$(this).data('inputFocused', $po_num_btn.is(":focus"));
	}).click(function () {
		if ($(this).data('inputFocused')) {
			$po_num_btn.blur();
		} else {
			$po_num_btn.focus();
		}
	});
	//Untuk fungsi separator ribuan.
	$("input[id='invoice_amounttttt']").change(function() {
    	var invAmount = $(this).moneyFormat();
    	// var invAmount = $(this).val($(this).val().moneyFormat());
    	// var invAmount = $(this).val($(this).val().replace( /[^0-9]+/g, "").replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
	});
	$("input[id='nominalDpp']").keyup(function() {
    	var NomDpp = $(this).val($(this).val().replace( /[^0-9]+/g, "").replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
	});
	// $("input[id='AmountOtomatis']").keyup(function() {
 //    	var AmountOto = $(this).val($(this).val().replace( /[^0-9]+/g, "").replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
	// });
	//untuk total po amount di halaman add invoice
	$(document).on('input click', '.qty_invoice, .del_row, input[id="invoice_amounttttt"]', function(){
		var total=0;
		var invAmount = $("input[id='invoice_amounttttt']").val(); //.replace( /[^0-9]+/g, "");
		$('.qty_invoice').each(function() {
			var qty = $(this).val();
			var rownum = $(this).attr('row-num')
			var price = $('.unit_price[row-num="'+rownum+'"]').val();
			var rowtotal = qty*price;
			total+=Number(Math.round(rowtotal));
		});	
		$('#AmountOtomatis').html(total).moneyFormat();
		 // $('#AmountOtomatis').html(total).replace( /[^0-9]+/g, "").replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
		if (total == invAmount) {
			$('#invoice_amounttttt, #AmountOtomatis').css("background-color","white");
		}else{
			$('#invoice_amounttttt, #AmountOtomatis').css("background-color","red");
		}
	});
	
	var num=0;
	$('#btnSearchPoNumber').click(function(){
		$('#tablePoLines').html("<center><img id='loading12' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading12.gif'/><br /><p style='color:#575555;'>Searching Data</p></center><br />");
		var po_no = $('#slcPoNumberMonitoring').val();
		var line_number_sent = '0';
		$('.line_number').each(function(){
			var linenumval = $(this).val();
			line_number_sent += (', '+linenumval);
		});
		$.ajax({
			type: "POST",
			url: baseurl+"AccountPayables/MonitoringInvoice/Invoice/getPoNumber/"+po_no,
			data: {line_number_sent:line_number_sent},
			// dataType: "json",
			success: function (response) {
				// console.log(response);
				
				$('#tablePoLines').html(response);
				$('#poLinesTable').DataTable({
					"paging":   false,
					"ordering": true,
					"info":     false	
				});
				//button Add menuju Invoice PO Detail (checkbox)
				$('#btnAddPoNumber').on('click', function(){
					var inputName = ['line_num','vendor_name','po_number','lppb_number','status','shipment_number',
					'received_date','item_id','item_description','qty_receipt','quantity_billed','qty_reject','currency','unit_price']
					$('.addMonitoringInvoice').each(function () {
						var html ='';
						if (this.checked) {
							var id_num = $(this).val();
							html += '<tr id="row-1">';
							$('tr#'+id_num).each(function(){
								num++;
								var col=0;
								$(this).find('td').each(function(){
									col++;
									if (col==1) {
										html+='<td>'+num+'</td>'
									}else{
										html+='<td><input style="width: 100%" name="'+inputName[(col-2)]+'[]" type="hidden" class="form-control '+inputName[(col-2)]+'" value="'+$(this).text()+'" row-num="'+num+'" readonly>'
										html+='<span>'+$(this).text()+'</span></td>';
									}
								});
							})
							html+='<td><input style="width: 100%" type="text" onchange="PresTab(this)" name="qty_invoice[]" class="form-control qty_invoice" row-num="'+num+'"></td>'; 
							html+='<td><button type="button"class="del_row btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button></td>'; 
							html+='</tr>'; 
							$('#tbodyPoDetailAll').append(html);
						}
					});
					//untuk menghapus baris di halaman add invoice
					$('.del_row').click(function(){
						var cnf = confirm('Yakin untuk menghapusnya ?');
						var ths = $(this);
						if (cnf) {
							ths.parent('td').parent('tr').remove();
						}else{
							alert('Hapus dibatalkan');
						}
					});
					var inputCurr = $('input[name="currency[]"]').val();
					$('#currency').append(inputCurr);
				});
			}
		});
	});
	
	//formatting tanggal
	$('.idDateInvoice').datepicker({
		format: 'dd-M-yyyy',
		autoclose: true,
	});
	$('#btnHapus').click(function(){
		alert('Yakin untuk menghapusnya ?');
	});
	$('table#tbListInvoice tbody tr, #tabel_detail_purchasing tbody tr, #finishInvoice tbody tr, #tabel_invoice tbody tr, #unprocessTabel tbody tr, #rejectinvoice tbody tr').each(function(){
		var po_amount = $(this).find('.po_amount').text();
		var inv_amount = $(this).find('.inv_amount').text();
		if (po_amount == inv_amount) {
			$(this).find('.po_amount').css("background-color","white");
			$(this).find('.inv_amount').css("background-color","white");
		}else{
			$(this).find('.po_amount').css("background-color","red").css("color","white");
			$(this).find('.inv_amount').css("background-color","red").css("color","white");
		}
	})
	$('table#tbInvoiceEdit tbody tr, #editlinespo tbody tr, #tbInvoiceKasie tbody tr, #invoiceKasiePembelian tbody tr, #filInvoice tbody tr, #detailUnprocessed tbody tr, #processedinvoice tbody tr').each(function(){
		var po_amount = $('.po_amount').text();
		var inv_amount = $('#invoice_amount').text();
		if (po_amount == inv_amount) {
			$('.po_amount').css("background-color","white");
			$('#invoice_amount').css("background-color","white");
		}else{
			$('.po_amount').css("background-color","red").css("color","white");
			$('#invoice_amount').css("background-color","red").css("color","white");
		}
	});
	$('table#tbInvoice tbody tr, #rejectdetail tbody tr').each(function(){
		var po_amount = $('.po_amount').text();
		var inv_amount = $('#invoice_amount').text();
		if (po_amount == inv_amount) {
			$('.po_amount').css("background-color","white");
			$('#invoice_amount').css("background-color","white");
		}else{
			$('.po_amount').css("background-color","red").css("color","white");
			$('#invoice_amount').css("background-color","red").css("color","white");
		}
	});
	$('table#tbInvoiceEdit tbody tr, #editlinespo tbody tr').each(function(){
		var po_amount = $('.po_amount').text();
		var inv_amount = $('#invoice_amount').val();
		if (po_amount == inv_amount) {
			$('.po_amount').css("background-color","white").css("color","black");
			$('#invoice_amount').css("background-color","white").css("color","black");
		}else{
			$('.po_amount').css("background-color","red").css("color","white");
			$('#invoice_amount').css("background-color","red").css("color","white");
		}
	});
	
	$('#btnGenerate').click(function(){
		var invoice_date = $('#invoice_dateid').val();
		$.ajax({
			type: 'POST',
			url: baseurl+"AccountPayables/MonitoringInvoice/Invoice/GenerateInvoice/",
			data: {
				invoice_date : invoice_date,
			},
			success: function(response){
				$('#invoice_numbergenerate').val('');
				$('#invoice_numbergenerate').val(response);
			}
		});
	});
	$('.RejectByKasiePurc').click(function(){
		alert('NOT OK = ALASAN HARUS DI ISI');
	});
	$("input[name='tax_input']").attr({ maxLength : 19 }).keyup(function() {
		$(this).val($(this).val().replace(/^(\d{3})(\d{3})(\d{2})(\d)+$/, "$1.$2-$3.$4"));
	});
	$('.saveTaxInvoice').click(function(){
		var tax_invoice_number = $(this).siblings('.tax_id').val();
		var id = $(this).siblings('.text_invoice_id').val();
		$.ajax({
			type: 'POST',
			url: baseurl+"AccountPayables/MonitoringInvoice/Invoice/tax_invoice_number/",
			data: {
				tax_input : tax_invoice_number,
				id : id
			},
			success: function(response){
				alert('Tax Invoice Number telah di tambahkan');
			}
		});
	});
	$('#btnToFinance').click(function(){
		var status = $('.statusInvoice').attr('value');
		var arrId = [];
		$('button.statusInvoice').each(function(){
			if ($(this).hasClass('checked')) {
			var valueId = $(this).attr('inv-id');
			arrId.push(valueId);
			}
		});
		var invoice_id = arrId.join();
		var submit_finance = $(this).val();
		if (status == 1 > 0) {
			alert('Mohon pengecekan ulang. Ada line yang belum di approve/reject');
		}else{
			alert('Invoice akan di submit ke finance');
			$.ajax({
				url: baseurl+'AccountPayables/MonitoringInvoice/InvoiceKasie/submittofinance',
				data: {
					invoice_id : invoice_id,
					submit_finance: submit_finance
				},
				type: 'POST',
				success: function(response){
					// console.log(invoice_id);
					window.location.replace(baseurl+"AccountPayables/MonitoringInvoice/InvoiceKasie/finishBatch");
				}
			})
		}
	});
	// new edit icheck testing chamber
	
	
	$('#invoice_category').on('change', function(){
		var jasa = $(this).val();
		if (jasa == 'JASA NON EKSPEDISI TRAKTOR' || jasa == 'JASA EKSPEDISI TRAKTOR') {
			$('#jenis_jasa').show();
		}
	})
	
});
var simpanHtml = new Array();
function prosesInvMI(th){
	var invoice_id = $(th).attr('data-id');
	var proses = $(th).attr('value');
	var prnt = $(th).parent();
	// prnt.html('<img src="'+baseurl+'assets/img/gif/loading5.gif" id="gambarloading">');
	simpanHtml[invoice_id]= $('.ganti_'+invoice_id+'').html();
	console.log(simpanHtml)
	if (proses == 2) {
		prnt.html('<span class="btn btn-success" style="cursor: none;font-size: 10pt;" >Diterima<input type="hidden" name="hdnTerima[]" class="hdnProses" value="'+invoice_id+'"></span><a class="btn btn-sm btn-primary" onclick="reloadTerimaInnvoice('+invoice_id+');"><i class="fa fa-refresh"></i></a>');
	} else {
		prnt.html('<span class="btn btn-danger" style="font-size: 8pt ;cursor: none;">Ditolak (Isikan Alasan)<input type="hidden" name="hdnTolak[]" class="hdnProses" value="'+invoice_id+'"></span><a class="btn btn-sm btn-primary" onclick="reloadTolakInnvoice('+invoice_id+');"><i class="fa fa-refresh"></i></a>');
		prnt.siblings('td').children('.reason_finance_class'+invoice_id+'').show();
		prnt.siblings('td').children('.reason_finance_class'+invoice_id+'').attr('required',true);
		alert('Alasan harus diisi');
	}
}
function reloadTerimaInnvoice(th) {
	var id = th;
	$('.ganti_'+id+'').html(simpanHtml[id]);
}
function reloadTolakInnvoice(th) {
	var id = th;
	$('.ganti_'+id+'').html(simpanHtml[id]);
	$('.reason_finance_class'+id+'').remove();
}
function deleteLinePO(th){
	var id = $(th).attr('data-id');
	$.ajax({
		url: baseurl+'AccountPayables/MonitoringInvoice/Invoice/deletePOLine/'+id,
		data: {
			invoice_po_id : id
		},
		type: 'POST',
		success: function(response){
			alert('Po Line di hapus');
			$(th).parent('td').parent('tr').remove();
		}
	});
}
function chkAllAddMonitoringInvoice() {
	if ($('.chkAllAddMonitoringInvoice').is(':checked')) {
		$('.addMonitoringInvoice').each(function () {
			$(this).prop('checked',true);
		});
	}else{
		$('.addMonitoringInvoice').each(function () {
			$(this).prop('checked',false);
		});
	};
}
function bukaMOdal(elm){
	var id = $(elm).attr('inv');
	$.ajax({
		url: baseurl+'AccountPayables/MonitoringInvoice/InvoiceKasie/modal_approve_reject_invoice/'+id,
		data:{
			invoice_id: id
		},
		type: 'POST',
		success: function(response){
			$('.body_invoice').html(response);
			$('.invoice_id').val(id);
			$('#modal-invoice').modal('show');
			$('#invoice_categorySlc').select2();
			$('#jenis_jasaSlc').select2();
		}
	});
}
function PresTab(th)
{
	$(th).parent().parent().next().find('.qty_invoice').focus();
}
function rejectAction(th){
	var invoice_id = $(th).attr('data-id');
}
function submitUlangKasieGudang(th) {
	var batch_number = th.attr('value');
	$.ajax({
		type: "POST",
		url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceKasie/submitUlangKasieGudang",
		data:{
			batch_number: batch_number
		},
		success: function(response){
			window.location.href = baseurl+"AccountPayables/MonitoringInvoice/InvoiceKasie";
		}
	})
}
function approveInvoice(th) {
	var invoice_id = $('#invoice_id').val();
	var status = th.attr('value');
	var batch_number = th.attr('batch-num');
	var invoice_number = $('#invoice_number').val();
	var invoice_date = $('#invoice_date').val();
	var invoice_amount = $('#invoice_amountt').val();
	var tax_invoice_number = $('#tax_invoice_number').val();
	var invoice_category = $('#invoice_categorySlc').val();
	var jenis_jasa = $('#jenis_jasaSlc').val();
	var nominal_dpp = $('#nominal_dpp').val();
	var info = $('#info').val();
	$.ajax({
		type: "POST",
		url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceKasie/approveInvoice",
		data:{
			invoice_id: invoice_id,
			status: status,
			invoice_number: invoice_number,
			invoice_date: invoice_date,
			invoice_amount: invoice_amount,
			tax_invoice_number: tax_invoice_number,
			invoice_category: invoice_category,
			jenis_jasa: jenis_jasa,
			nominal_dpp: nominal_dpp,
			info: info
		},
		success: function(response){
			// console.log(invoice_id,invoice_number,invoice_date,invoice_amount,tax_invoice_number,invoice_category
			// 	,jenis_jasa,nominal_dpp,info,status);
			window.location.href = baseurl+"AccountPayables/MonitoringInvoice/InvoiceKasie/batchDetailPembelian/"+batch_number;
		}
	})
} 
function btnApproveNew(th){		
	var btn = th.parent().parent().closest('tr').find('button.statusInvoice');
	var isChecked = btn.html();
	var invoice_id = th.attr('inv-id');
        if(isChecked == 'Approve'){
          	btn.attr('value','1').removeClass('checked').toggleClass('btn-info').toggleClass('btn-success').html('Submit');
			var status = btn.attr('value');
	        $.ajax({
			type: "POST",
			url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceKasie/approveInvoice2",
			data:{
				invoice_id: invoice_id,
				status: status,
				 },
	    	})
        }
        if(isChecked == 'Submit'){
			btn.attr('value','2').addClass('checked').toggleClass('btn-success').toggleClass('btn-info').html('Approve');
			var status = btn.attr('value');
			$.ajax({
			type: "POST",
			url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceKasie/approveInvoice2",
			data:{
				invoice_id: invoice_id,
				status: status,
				},
	    	})
		}	  
}
function btn_cari(th) {
	var id = th.attr('invoice');
	var win = window.open(baseurl+'Monitoring/TrackingInvoice/DetailInvoice/'+id);
}