//---------------------invoice faktur pajak---------------//
$(document).ready(function() {
	$("#slcSupplier").select2({
		placeholder: "SUPPLIER",
		minimumInputLength: 2,
		ajax: {		
			url:baseurl+"AccountPayables/C_Invoice/getSupplier",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term
				}
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
					return { id:obj.VENDOR_NAME, text:obj.VENDOR_NAME};
					})
				};
			}
		}	
	});

	$("#slcInvoiceNumber").select2({
		placeholder: "INVOICE NUMBER",
		minimumInputLength: 2,
		ajax: {		
			url:baseurl+"AccountPayables/C_Invoice/getInvoiceNumber",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
					tanggal_awal: $('input[name="tanggal_awal"]').val(),
					tanggal_akhir: $('input[name="tanggal_akhir"]').val(),
					supplier: $('select[name="supplier"]').val(),
				}
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
					return { id:obj.INVOICE_NUM, text:obj.INVOICE_NUM};
					})
				};
			}
		}	
	});
	
	//GET INVOICE NUMBER LIST BASED PERIOD AND YEAR
	$("#slcInvoiceNumber2").select2({
		placeholder: "NOMOR FAKTUR",
		minimumInputLength: 2,
		ajax: {		
			url:baseurl+"AccountPayables/C_Invoice/getInvoiceNumber2",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
					period: $('input[name="TxtMasaPajak"]').val(),
					year: $('input[name="TxtTahun"]').val(),
				}
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
					return { id:obj.FAKTUR_PAJAK, text:obj.FAKTUR_PAJAK};
					})
				};
			}
		}	
	});
	
	//GET NAME AFTER SELECT INVOICE NUMBER
	$('#slcInvoiceNumber2').change(function(){
		$('#loadAjax').show();
		var val = $('select[name="TxtInvoiceNumber"]').val();
		$.ajax({
			type:'POST',
			data:{invoice_num:val},
			url:baseurl+"AccountPayables/C_Invoice/getInvoiceNumber3",
			success:function(result)
			{
				$('#TxtNama').val(result);
			}
		});
	});
	
	
	function findfakturtable(){
		$('#tabel-retur-faktur').dataTable({
			"bSort" : false,
			"searching": false,
			"bLengthChange": false,
			"scrollX": true
		});
	}
	
	//CLICK BTN
	$(document).ready(function() {	
		$('#FindFakturButton').click(function(){
			var period 		= $('input[name="TxtMasaPajak"]').val();
			var year 		= $('input[name="TxtTahun"]').val();
			var invoice_num = $('select[name="TxtInvoiceNumber"]').val();
			var name 		= $('input[name="TxtNama"]').val();
			
			var ket1		= 'no'; if(document.getElementById('ket1').checked){ket1= 'yes';}
			var ket2		= 'no'; if(document.getElementById('ket2').checked){ket2= 'yes';}
			
			var sta1		= 'no'; if(document.getElementById('sta1').checked){sta1= 'yes';}
			var sta2		= 'no'; if(document.getElementById('sta2').checked){sta2= 'yes';}
			var sta3		= 'no'; if(document.getElementById('sta3').checked){sta3= 'yes';}
			
			$.ajax({
				type: "POST",
				data:{
						month:period,
						year:year,
						invoice_num:invoice_num,
						name:name,
						ket1:ket1,
						ket2:ket2,
						sta1:sta1,
						sta2:sta2,
						sta3:sta3 
					},
				url:baseurl+"AccountPayables/C_Invoice/FindFaktur",
				success:function(result)
				{
					$("#table-full").html(result);
					findfakturtable();
				}
			});
		});
	});
});
	