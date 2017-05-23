//---------------------invoice faktur pajak----------------//
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

	//$("#slcInvoiceNumber").select2({
	//	placeholder: "INVOICE NUMBER",
	//	minimumInputLength: 2,
	//	ajax: {		
	//		url:baseurl+"AccountPayables/C_Invoice/getInvoiceNumber",
	//		dataType: 'json',
	//		type: "GET",
	//		data: function (params) {
	//			var queryParameters = {
	//				term: params.term,
	//				tanggal_awal: $('input[name="tanggal_awal"]').val(),
	//				tanggal_akhir: $('input[name="tanggal_akhir"]').val(),
	//				supplier: $('select[name="supplier"]').val(),
	//			}
	//			return queryParameters;
	//		},
	//		processResults: function (data) {
	//			return {
	//				results: $.map(data, function(obj) {
	//				return { id:obj.INVOICE_NUM, text:obj.INVOICE_NUM};
	//				})
	//			};
	//		}
	//	}	
	//});
	
	//GET INVOICE NAME
	$("#slcnama").select2({
		tags: "true",
		placeholder: "NAMA",
		minimumInputLength: 2,
		ajax: {		
			url:baseurl+"AccountPayables/C_Invoice/getInvoiceName",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
				}
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
					return { id:obj.NAME, text:obj.NAME};
					})
				};
			}
		}	
	});
	
	//GET INVOICE NUMBER LIST BASED PERIOD AND YEAR
	$("#slcInvoiceNumber2").select2({
		tags: "true",
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
				$('#slcnama').append('<option value="'+ result +'">'+ result +'</option>').val(result).trigger('change');
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
			$('#loading').html('<img src="'+baseurl+'assets/img/gif/loading12.gif" width="34px"/>');
			var period 		= $('input[name="TxtMasaPajak"]').val();
			var year 		= $('input[name="TxtTahun"]').val();
			var invoice_num = $('input[name="TxtInvoiceNumber"]').val();
			var name 		= $('select[name="TxtNama"]').val();
			var tanggal_awal 	= $('input[name="tanggal_awal"]').val();
    		var tanggal_akhir 	= $('input[name="tanggal_akhir"]').val();
			var ket1		= 'no'; if(document.getElementById('ket1').checked){ket1= 'yes';}
			var ket2		= 'no'; if(document.getElementById('ket2').checked){ket2= 'yes';}
			
			var sta1		= 'no'; if(document.getElementById('sta1').checked){sta1= 'yes';}
			var sta2		= 'no'; if(document.getElementById('sta2').checked){sta2= 'yes';}
			var sta3		= 'no'; if(document.getElementById('sta3').checked){sta3= 'yes';}

			var typ1		= 'no'; if(document.getElementById('typ1').checked){typ1= 'yes';}
			var typ2		= 'no'; if(document.getElementById('typ2').checked){typ2= 'yes';}
			
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
						sta3:sta3, 
						typ1:typ1, 
						typ2:typ2, 
						tanggal_awal:tanggal_awal,
    					tanggal_akhir:tanggal_akhir,

					},
				url:baseurl+"AccountPayables/C_Invoice/FindFaktur",
				success:function(result)
				{
					$('#loading').html('');
					$("#table-full").html(result);
					findfakturtable();
				}
			});
		});
	});
	
	//INSPECT QRCODE
	$(document).ready(function() {	
		$('.inspectqr').click(function(){
			
			$('.qrarea').html('<img src="'+baseurl+'assets/img/gif/loading12.gif" width="34px"/>');
			var invid 		= $(this).closest('.data-row').find('.uniqpartcode').val()
			
			$.ajax({
				type: "POST",
				data:{invid:invid},
				url:baseurl+"AccountPayables/C_Invoice/generateQR",
				success:function(result)
				{
					$('.qrarea').html('<img src="'+(result)+'"/></br><b>'+invid+'<b>');
				}
			});
		});
	});
	
	//CLEAR BUTTON
	$(document).ready(function() {	
		$('#ClearFakturButton').click(function(){
			document.getElementById("fm-form").reset();
			$("#slcInvoiceNumber2").select2("val", "");
		});
	});
	
	//CLEAR BUTTON
	$(document).ready(function() {	
		$('#ClearSearch').click(function(){
			$("#tanggal_akhir").datepicker('setDate', new Date());
			$("#tanggal_awal").datepicker('setDate', new Date());
			$("#tanggal_akhir_pilih").datepicker();
			$("#tanggal_awal_pilih").datepicker();
			$("#slcSupplier").select2("val", "");
			$("#slcInvoiceNumber").select2("val", "");
		});
	});

	$('#tanggal_akhir').datepicker('setDate', new Date());
	$('#tanggal_awal').datepicker('setDate', new Date());
	$('#tanggal_akhir_pilih').datepicker();
	$('#tanggal_awal_pilih').datepicker();

})

$(document).ready(function() {
	$('.tanggal_cari').daterangepicker({
		"singleDatePicker": true,
		"timePicker": false,
		"timePicker24Hour": true,
		"showDropdowns": false,
		locale: {
			format: 'DD-MM-YYYY'
		},
	});
	if (typeof $('#tanggal_asli').val() !== 'undefined'){
	var startDate = $('#tanggal_asli').val()
	$(".tanggal_cari").data('daterangepicker').setStartDate(startDate);
	$(".tanggal_cari").data('daterangepicker').setEndDate(startDate)};
});

//---------------------Account Payable KlikBCA----------------//

$(document).ready(function(){
	if (document.getElementById('dropzone')) {
		Dropzone.autoDiscover = false;

		var klik_upload = new Dropzone(".dropzone",{
		url: baseurl+"AccountPayables/KlikBCAChecking/Insert/proses_upload",
		maxFilesize: 2,
		method:"post",
		acceptedFiles:".htm",
		paramName:"userfile",
		dictInvalidFileType:"Type file ini tidak dizinkan",
		addRemoveLinks:true,
		});

		klik_upload.on('sending', function(file, xhr, formData){
			var type = $('select#type').val();
            formData.append('fileType', type);
        });

		//upload
		klik_upload.on("success",function(file, response){
			$('#cobaco').append('<tr><td>'+response+'</td></tr>');
		});
	}

});


$(document).ready(function() {

	//DATEPICKER CHECK DATA
	$('.bcacheck').daterangepicker({
		"singleDatePicker": true,
		"timePicker": false,
		"timePicker24Hour": true,
		"showDropdowns": false,
		autoUpdateInput: false,
		locale: {
			cancelLabel: 'Clear'
		}
	});
	
	$('.bcacheck').on('apply.daterangepicker', function(ev, picker) {
		$(this).val(picker.startDate.format('DD/MM/YYYY'));
	});

	$('.bcacheck').on('cancel.daterangepicker', function(ev, picker) {
		$(this).val('');
  	});

	//TABEL CHECK DATA
	$('#tblrecordbca').DataTable({	
		"lengthChange": false,
		"ordering": false,
		"autoWidth": false,
		"scrollX": true,
	});

	function tablerecordbca(){
		$('#tblrecordbca').DataTable({
			"lengthChange": false,
			"ordering": false,
			"autoWidth": false,
			"scrollX": true,
		});
	}

	$('#ShowBCAbydate').click(function(){
		$('#loading').html('<img src="'+baseurl+'assets/img/gif/loading12.gif" width="34px"/>');
		
		var start 		= $('input[name="TxtStartDate"]').val();
		var end 		= $('input[name="TxtEndDate"]').val();

		$.ajax({
			type: "POST",
			data:{
					start:start,
					end:end,
			},
			url:baseurl+"AccountPayables/KlikBCAChecking/Check/show",
			success:function(result)
			{
				$('#loading').html('');
				$("#table-full").html(result);
				tablerecordbca();
			}
		});
	});
});