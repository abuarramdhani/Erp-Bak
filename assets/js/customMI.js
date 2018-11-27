
$(document).ready(function(){

	$('#tabel_invoice, #tbListSubmit, #tbListInvoice, #rejectinvoice, #tbListBatchPembelian, #tbListSubmit, #finishInvoice, #unprocessTabel').dataTable({
		"pageLength": 10,
        "paging": true,
        "searching": true,
        "order": [[0, "asc"]]
	});

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
			}
		});
		$('#jmlChecked').text(jml);
		$('#content1').slideDown();
		$('#content2').slideUp();
	});

	// $('.inv_amount').moneyFormat();
	// $('.po_amount').moneyFormat();

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

	// $("input[id='invoice_amounttttt']").keyup(function() {
 //    	var invAmount = $(this).val($(this).val().replace( /[^0-9]+/g, "").replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
	// });

	$(document).on('input click', '.qty_invoice, .del_row, input[id="invoice_amounttttt"]', function(){
		var total=0;
		var invAmount = $("input[id='invoice_amounttttt']").val(); //.replace( /[^0-9]+/g, "");
		$('.qty_invoice').each(function() {
			var qty = $(this).val();
			var rownum = $(this).attr('row-num')
			var price = $('.unit_price[row-num="'+rownum+'"]').val();
			var rowtotal = qty*price;
			total+=Number(rowtotal);
		});	
		$('#AmountOtomatis').html(total);
		//$('#AmountOtomatis').html($('#AmountOtomatis').html().replace( /[^0-9]+/g, "").replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));

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
				$('#poLinesTable').DataTable();

				$('#btnAddPoNumber').on('click', function(){
				    var inputName = ['line_num','vendor_name','po_number','lppb_number','status','shipment_number',
				    'received_date','item_description','item_id','qty_receipt','quantity_billed','qty_reject','currency','unit_price']
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
					           					html+='<td><input name="'+inputName[(col-2)]+'[]" type="text" class="form-control '+inputName[(col-2)]+'" value="'+$(this).text()+'" row-num="'+num+'" readonly>'
					           				}
					           			});
					           		})
					               html+='<td><input required type="text" name="qty_invoice[]" class="form-control qty_invoice" row-num="'+num+'"></td>'; 
					               html+='<td><button type="button"class="del_row btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button></td>'; 
					               html+='</tr>'; 
					               $('#tbodyPoDetailAll').append(html);
					           }
						});
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
	

	$('.idDateInvoice').datepicker({
		format: 'dd-M-yyyy',
		autoclose: true,
	});

	$('#btnHapus').click(function(){
		alert('Yakin untuk menghapusnya ?');
	});

	$('table#tbListInvoice tbody tr, #tbListBatchPembelian  tbody tr, #finishInvoice tbody tr, #tabel_invoice tbody tr, #unprocessTabel tbody tr, #rejectinvoice tbody tr').each(function(){
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
			var inv_amount = $('#invoice_amount').text().replace( /[^0-9]+/g, "");

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
			var inv_amount = $('#invoice_amount').val().replace( /[^0-9]+/g, "");

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
		alert('Invoice akan di submit ke finance');
	});
});

function prosesInvMI(th){
	var invoice_id = $(th).attr('data-id');
	var proses = $(th).attr('value');

	var request = $.ajax ({
			url: baseurl+'AccountPayables/MonitoringInvoice/Unprocess/prosesAkuntansi/'+invoice_id,
			data: {
					proses : proses
					},
			type: 'POST',
			dataType: 'html', 
		});
		$(th).parent().html('<img src="'+baseurl+'assets/img/gif/loading5.gif" id="gambarloading">');
		
		if (proses == 2) {
			request.done(function(output){
				$("#gambarloading").parent().html('<button class="btn btn-success">Accept</button>');
			});
		} else {
			request.done(function(output){
				$("#gambarloading").parent().html('<button class="btn btn-danger">Reject</button>');
				alert('Alasan harus diisi');
			});
		}
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




