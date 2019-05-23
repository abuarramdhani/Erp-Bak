$(document).ready(function(){
				$('.cmdaterange').daterangepicker({
				    "showDropdowns": true,
				    "autoApply": true,
				    "locale": {
				        "format": "DD-MM-YYYY",
				        "separator": " - ",
				        "applyLabel": "OK",
				        "cancelLabel": "Batal",
				        "fromLabel": "Dari",
				        "toLabel": "Hingga",
				        "customRangeLabel": "Custom",
				        "weekLabel": "W",
				        "daysOfWeek": [
				            "Mg",
				            "Sn",
				            "Sl",
				            "Rb",
				            "Km",
				            "Jm",
				            "Sa"
				        ],
				        "monthNames": [
				            "Januari",
				            "Februari",
				            "Maret",
				            "April",
				            "Mei",
				            "Juni",
				            "Juli",
				            "Agustus ",
				            "September",
				            "Oktober",
				            "November",
				            "Desember"
				        ],
				        "firstDay": 1
				    }
				}, function(start, end, label) {
				  console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
				});
				$('.cmsingledate').daterangepicker({
				    "singleDatePicker": true,
				    "showDropdowns": true,
				    "autoApply": true,
				    "locale": {
				        "format": "DD-MM-YYYY",
				        "separator": " - ",
				        "applyLabel": "OK",
				        "cancelLabel": "Batal",
				        "fromLabel": "Dari",
				        "toLabel": "Hingga",
				        "customRangeLabel": "Custom",
				        "weekLabel": "W",
				        "daysOfWeek": [
				            "Mg",
				            "Sn",
				            "Sl",
				            "Rb",
				            "Km",
				            "Jm",
				            "Sa"
				        ],
				        "monthNames": [
				            "Januari",
				            "Februari",
				            "Maret",
				            "April",
				            "Mei",
				            "Juni",
				            "Juli",
				            "Agustus ",
				            "September",
				            "Oktober",
				            "November",
				            "Desember"
				        ],
				        "firstDay": 1
				    }
				}, function(start, end, label) {
				  console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
				});				

				$('.cmsingledate-mycustom').daterangepicker({
				    "singleDatePicker": true,
				    "showDropdowns": true,
				    "autoApply": true,
				    "locale": {
				        "format": "YYYY-MM-DD",
				        "separator": " - ",
				        "applyLabel": "OK",
				        "cancelLabel": "Batal",
				        "fromLabel": "Dari",
				        "toLabel": "Hingga",
				        "customRangeLabel": "Custom",
				        "weekLabel": "W",
				        "daysOfWeek": [
				            "Mg",
				            "Sn",
				            "Sl",
				            "Rb",
				            "Km",
				            "Jm",
				            "Sa"
				        ],
				        "monthNames": [
				            "Januari",
				            "Februari",
				            "Maret",
				            "April",
				            "Mei",
				            "Juni",
				            "Juli",
				            "Agustus ",
				            "September",
				            "Oktober",
				            "November",
				            "Desember"
				        ],
				        "firstDay": 1
				    }
				}, function(start, end, label) {
				  console.log("New date range selected: ' + start.format('YYYY-MM-DD H:i:s') + ' to ' + end.format('YYYY-MM-DD H:i:s') + ' (predefined range: ' + label + ')");
				});				
	// DATE RANGE PICKER UNTUK 'RECEIPT DATE'
	// $('.singledate').daterangepicker({
	// 	"singleDatePicker": true,
	// 	"timePicker": false,
	// 	"timePicker24Hour": true,
	// 	"showDropdowns": false,
	// 	locale: {
	// 		format: 'YYYY-MM-DD'
	// 	},
	// });
	// if (typeof $('#receipt-date').val() !== 'undefined'){
	// var startDate = $('#receipt-date').val()
	// $(".singledate").data('daterangepicker').setStartDate(startDate);
	// $(".singledate").data('daterangepicker').setEndDate(startDate)};
	
	// // DATE RANGE PICKER UNTUK 'ORDER DATE'
	// $('.doubledate').daterangepicker({
	// 	"timePicker": false,
	// 	"timePicker24Hour": true,
	// 	"showDropdowns": false,
	// 	locale: {
	// 		format: 'YYYY-MM-DD'
	// 	},
	// });
	// if (typeof $('#order-start-date').val() !== 'undefined'){
	// var startDate = $('#order-start-date').val()
	// var endDate = $('#order-end-date').val()
	// $(".doubledate").data('daterangepicker').setStartDate(startDate);
	// $(".doubledate").data('daterangepicker').setEndDate(endDate)};
	
	$("#catering").change(cekpph);
	$("#pphverify").click(cekpph);
	
	//CEK STATUS PPH PADA CATERING YANG DIPILIH
	function cekpph(){
		$.ajax({
			type:'POST',
			data:{id:$("#catering").val()},
			url:baseurl+"CateringManagement/Receipt/Checkpph",
			success:function(result)
			{
				calculation(result);
			},
			error: function() {
				alert('error');
			}
		});
	};
	
	//MELAKUKAN KALKULASI NILAI AKHIR
	$("#orderqty,#singleprice,#fine").keyup(checkncalc);
	$("#orderqty,#singleprice,#fine").click(checkncalc);
	$("#DelFine").click(checkncalc);
	$("#ReCalculate").click(checkncalc);
	$("#tbodyFineCatering input").keyup(checkncalc);
	$("#tbodyFineCatering input").click(checkncalc);
	$("#tbodyFineCatering select").change(checkncalc);
	$("#bonus").change(checkncalc);
		
	function calculation(pphstatus){
		var $qty = $('#orderqty').val();
		var $price = $('#singleprice').val();
		var $ordertype = $('#ordertype').val();
		var $bonus = $('#bonus').val();
		
		if($ordertype==2 && $bonus==1){
			var $bonus_qty = Math.floor($qty/50);
		} else {
			var $bonus_qty = 0;
		}
		
		var $net = $qty - $bonus_qty;
		var $calc = $net * $price;
		var $fine = $('#fine').val();
		var $est = $calc - $fine;

		if (pphstatus==1){
			var $pph = Math.ceil((2 / 100) * $est);
		} else {
			var $pph = Math.ceil((0 / 100) * $est);
		}
		
		var $total = $est - $pph;
		
		$("#orderbonus").val($bonus_qty);
		$("#ordernet").val($net);
		$("#calc").val($calc);
		$("#pph").val($pph);
		$("#total").val($total);
	};
		
	//MELAKUKAN CEK PPH SEKALIGUS KALKULASI NILAI AKHIR
	function checkncalc(){
		cekpph();
		calculation();
	}
});

	//MENAMBAH ROW UNTUK FINE DETAILS
	function AddFine(base){
		var newgroup = $('<tr>').addClass('clone');
		var e = jQuery.Event( "click" );
		e.preventDefault();
		$("select#finetype:last").select2("destroy");
		
		$('.clone').last().clone().appendTo(newgroup).appendTo('#tbodyFineCatering');

		$("select#finetype").select2({
			placeholder: "",
			allowClear : true,
		});
		
		$("select#finetype:last").select2({
			placeholder: "",
			allowClear : true,
		});
		
			$('.cmsingledate').daterangepicker({
				    "singleDatePicker": true,
				    "showDropdowns": true,
				    "autoApply": true,
				    "locale": {
				        "format": "DD-MM-YYYY",
				        "separator": " - ",
				        "applyLabel": "OK",
				        "cancelLabel": "Batal",
				        "fromLabel": "Dari",
				        "toLabel": "Hingga",
				        "customRangeLabel": "Custom",
				        "weekLabel": "W",
				        "daysOfWeek": [
				            "Mg",
				            "Sn",
				            "Sl",
				            "Rb",
				            "Km",
				            "Jm",
				            "Sa"
				        ],
				        "monthNames": [
				            "Januari",
				            "Februari",
				            "Maret",
				            "April",
				            "Mei",
				            "Juni",
				            "Juli",
				            "Agustus ",
				            "September",
				            "Oktober",
				            "November",
				            "Desember"
				        ],
				        "firstDay": 1
				    }
				}, function(start, end, label) {
				  console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
				});	
						
		$("select#finetype:last").val("").change();
		$("input#fineprice:last").val("").change();
		$("input#fineqty:last").val("").change();
		
		$("#DelFine").click(multInputs);
		$("#tbodyFineCatering input").keyup(finerowall);
		$("#tbodyFineCatering input").click(finerowall);
		$("#tbodyFineCatering select").change(finerowall);
		
		// Function 1 : CALCULATE FINE PER ROW
		function multInputs() {

			$("tr.clone").each(function () {

				var qty = $('#fineqty', this).val();
				var ordertype = $('#ordertype').val();
					if(ordertype==2){var bonus_qty = Math.floor(qty/50);}else {var bonus_qty = 0;}
				var price = $('#fineprice', this).val();
				var percentage = $('#finetype', this).val();
				var total = Math.ceil((qty-bonus_qty)*price*percentage/100);
				$("#finenominal", this).val(total);
			});
			
			var item = document.getElementsByClassName("finenominal");
			var itemCount = item.length;
			var total = 0;
			for(var i = 0; i < itemCount; i++){
				total = total +  parseInt(item[i].value);
			}
			document.getElementById('fine').value = total;	
		}
		
		// Function 2 : CHECK PPH (COPY)
		function cekpphalias(){
			$.ajax({
				type:'POST',
				data:{id:$("#catering").val()},
				url:baseurl+"CateringManagement/Receipt/Checkpph",
				success:function(result)
				{
					calculationalias(result);
				},
				error: function() {
					alert('error');
				}
			});
		};
		
		//FUNCTION 3 : FINAL CALCULATION (COPY)
		function calculationalias(pphstatus){
				
			var $qty = $('#orderqty').val();
			var $price = $('#singleprice').val();
			var $ordertype = $('#ordertype').val();
				
			if($ordertype==2){
				var $bonus_qty = Math.floor($qty/50);
			}
			else {
				var $bonus_qty = 0;
			}
				
			var $calc = (($qty-$bonus_qty) * $price);
			var $fine = $('#fine').val();
			var $est = $calc - $fine;
			if (pphstatus==1){
				var $pph = Math.ceil((2 / 100) * $est);
			} else {
				var $pph = Math.ceil((0 / 100) * $est);
			}
				
			var $total = $est - $pph;
				
			$("#calc").val($calc);
			$("#pph").val($pph);
			$("#total").val($total);
			
		};
		
		//FUNCTION 4 : RUN ALL FUNCTION
		function finerowall(){
			multInputs();
			cekpphalias();
			calculationalias();
		}
		
		// $('.singledate:last').daterangepicker({
		// 	"singleDatePicker": true,
		// 	"timePicker": false,
		// 	"timePicker24Hour": true,
		// 	"showDropdowns": false,
		// 	locale: {
		// 		format: 'YYYY-MM-DD'
		// 	},
		// });
		
		// if (typeof $('#receipt-date').val() !== 'undefined'){
		// var startDate = $('#receipt-date').val()
		// $(".singledate:last").data('daterangepicker').setStartDate(startDate);
		// $(".singledate:last").data('daterangepicker').setEndDate(startDate)};
	}

	//RECEIPT MANAGEMENT AUTO-ADD-REMOVE ROW
	
	$(function(){
		setTimeout(function(){
		  $('#AddFine').click();
		},10);
		setTimeout(function(){
		  $('#HiddenDelFine').click();
		},20);
		setTimeout(function(){
		  $('#ReCalculate').click();
		},15);
	});


	//Setup

	$(function(){
		$('#txtAkhirJamDatang').timepicker({
	  		maxHours:24,
	  		showMeridian:false,
	  	});
		$('#txtAwalJamDatang').timepicker({
	  		maxHours:24,
	  		showMeridian:false,
	  	});
	  	$('#txtJamDatang').timepicker({
	  		maxHours:24,
	  		showMeridian:false,
	  	});
	  	$('#txtJamPesan').timepicker({
	  		maxHours:24,
	  		showMeridian:false,
	  	});
	  	$('.dataTable-TmpMakan').DataTable( {
	  		dom:'frtp',
	  	});
	  	$('.dataTable-Tmp').DataTable( {
	      	dom: 'Brtip',
        	buttons: [
            { extend: 
            	'pdfHtml5',
            	 pageSize:'A4',
            	 orientation:'landscape',
            	 text: 'Export Pdf',
            	 title: 'DATA_PEKERJA_ABSEN_BERDASARKAN_TEMPAT_MAKAN',
            	 filename : 'Data_Pekerja_Absen',
            	 className: 'btn btn-danger btn-lg fa fa-file-pdf-o', 
        		init: function(api, node, config) {
       			$(node).removeClass('dt-button')
       			}
       		}]
	    });
	});


	//Penjadwalan

	$(function(){
		$('#txtperiodePenjadwalanCatering').datepicker({
		      "autoclose": true,
		      "todayHiglight": true,
		      "format":'MM yyyy',
		      "viewMode":'months',
		      "minViewMode":'months'
		});
		$('#txtperiodePengajuanLibur').datepicker({
		      "autoclose": true,
		      "todayHiglight": true,
		      "format":'MM yyyy',
		      "viewMode":'months',
		      "minViewMode":'months'
		});

		
		
	});

$(document).ready(function(){
	$('.cm_select2').select2(
	{
		allowClear: false,
		placeholder: "Pp Kodebarang",
		minimumInputLength: 3,
		ajax: 
		{
			url: baseurl+'CateringManagement/PrintPP/kodeItem2',
			dataType: 'json',
			delay: 500,
			data: function (params){
				return {
					term: params.term
				}
			},
			processResults: function(data) {
				return {
					results: $.map(data, function(obj){
						return {id: obj.kode_item, text: obj.kode_item};
					})
				};
			}
		}
	});

	$('.cm_select2').on('change',function(){
		var kode = $('.cm_select2').val();
		// alert(kode);
		$.ajax({
							type:'POST',
							data:{item: kode},
							url:baseurl+"CateringManagement/PrintPP/namaItem",
							success:function(result)
							{
								var result = JSON.parse(result);
								$('#txtPpNamaBarangHeader').val(result['namaBarang']);
							}
						});
	});

	$('#tblPrintpp').DataTable();
	$('#tblDataPesanan').DataTable({
		"lengthMenu" : [20],
		 "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
		  "info": true,
          "autoWidth": false,
		  "deferRender" : true,
		  "scroller": true,
	});

	$('.tblDataPesanan').DataTable({
		"lengthMenu" : [20],
		 "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
		  "info": true,
          "autoWidth": false,
		  "deferRender" : true,
		  "scroller": true,
	});

	$('#btn_pesanan_lihat').on('click',function(){
		$('#frm_pesanan').attr('action',baseurl+"CateringManagement/DataPesanan/lihat");
		$('#frm_pesanan').submit();
	});
	$('#btn_pesanan_refresh').on('click',function(){
		$('#frm_pesanan').attr('action',baseurl+"CateringManagement/DataPesanan/refresh");
		$('#frm_pesanan').submit();
	});

	$('#slc_tempat_makan').select2({
		minimumInputLength: 1,
		allowClear: true,
		placeholder: "Tempat Makan",
		ajax: {
			url: baseurl+'CateringManagement/PesananTambahan/tempatMakan',
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {term: params.term};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.nama,
							text: item.nama
						};
					})
					
				};
			},
		},
	});

	$('#Tranfer_modal').on('show.bs.modal', function (event) {
	    var button = $(event.relatedTarget) // Button that triggered the modal
	    var recipient = button.data('whatever') // Extract info from data-* attributes
	    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
	    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
	    var modal = $(this)
	    modal.find('.modal-title').text('New message to ' + recipient)
	    modal.find('.modal-body input').val(recipient)

	    var tgl = $(event.relatedTarget).data('tgl');
	    var shift = $(event.relatedTarget).data('shift');
	    var lokasi = $(event.relatedTarget).data('loker');
	    var tempat_makan = $(event.relatedTarget).data('tempat-makan');
	    var jml = $(event.relatedTarget).data('jml');
	    $('#modal-tanggal_katering').val(tgl);
	    $('#modal-Shift_pesan').val(shift);
	    $('#modal-tanggal_katering').val(tgl);
	    $('#modal-lokasi_kerja').val(lokasi);
	    $('#modal-tempat_makan').val(tempat_makan);
	    $('#modal-jml_total').val(jml);
	    $('#modal-select2_katering').select2({
	    	minimumInputLength: 0,
	    	allowClear: true,
	    	placeholder: "Tempat Pesan",
	    	ajax: {
	    		url: baseurl+'CateringManagement/DataPesanan/tempatPesan',
	    		dataType:'json',
	    		type: "GET",
	    		data: function (params) {
	    			return {term: params.term,
	    					tgl: tgl,
	    					shift: shift,
	    					lokasi:lokasi};
	    		},
	    		processResults: function (data) {
	    			return {
	    				results: $.map(data, function (item) {
	    					return {
	    						id: item.fs_kd_katering,
	    						text: item.fs_nama_katering
	    					};
	    				})
	    				
	    			};
	    		},
	    	},
	    });
	    
	  });
});


//Cetak

	$(function(){
		
		$('#txtTanggalJadwalLayanan').datepicker({
		      "autoclose": true,
		      "todayHiglight": true,
		      "format":'dd MM yyyy'
		});

		$('#txtPeriodeJadwalLayanan').datepicker({
		      "autoclose": true,
		      "todayHiglight": true,
		      "format":'MM yyyy',
		      "viewMode":'months',
		      "minViewMode":'months'
		});

		$('#txtPeriodeJadwalPengiriman').datepicker({
		      "autoclose": true,
		      "todayHiglight": true,
		      "format":'MM yyyy',
		      "viewMode":'months',
		      "minViewMode":'months'
		});

		$('#txtTanggalPembuatanJadwalPengiriman').datepicker({
		      "autoclose": true,
		      "todayHiglight": true,
		      "format":'dd MM yyyy'
		});
	});

function saveKeterangan(ket,tgl,kd_kat,shift){
	var val = $(ket).closest('tr').eq(0).find('input').val();
	$.ajax({
		type : 'POST',
		url : baseurl+'CateringManagement/Cetak/JadwalPengiriman/Save',
		data : {keterangan:val,tanggal:tgl,catering:kd_kat,shift:shift},
		success: function(data){
			alert("success");
		}
	});
}

//Puasa
$(document).ready(function(){
	$('#txtNoindPenguranganPuasa').on('change',function(){
		var kodesie = $(this).find(':selected').attr('data-kodesie');
		var seksi = $(this).find(':selected').attr('data-seksi');
		var nama = $(this).find(':selected').attr('data-nama');
		$('#txtKodesieTransferPuasa').val(kodesie);
		$('#txtSeksiTransferPuasa').val(seksi);
		$('#txtNamaTransferPuasa').val(nama);
	});
	$('.cmpuasadaterange').daterangepicker({
				    "autoApply": true,
				    "locale": {
				        "format": "DD MMMM YYYY",
				        "separator": " - ",
				        "applyLabel": "OK",
				        "cancelLabel": "Batal",
				        "fromLabel": "Dari",
				        "toLabel": "Hingga",
				        "customRangeLabel": "Custom",
				        "weekLabel": "W",
				        "daysOfWeek": [
				            "Mg",
				            "Sn",
				            "Sl",
				            "Rb",
				            "Km",
				            "Jm",
				            "Sa"
				        ],
				        "monthNames": [
				            "Januari",
				            "Februari",
				            "Maret",
				            "April",
				            "Mei",
				            "Juni",
				            "Juli",
				            "Agustus ",
				            "September",
				            "Oktober",
				            "November",
				            "Desember"
				        ],
				        "firstDay": 1
				    }
	});
});

function transferPuasa(banyak,tglsmtr){
	var valtgl = $('#txtPeriodeTranferPuasa').val();
	var tgl = valtgl.split(" - ");
	var tgl1 = tgl[0].split(" ");
	var tglawal = tgl1[0];
	var blnthn = tgl1[1]+" "+tgl1[2];
	var tgl2 = tgl[1].split(" ");
	var tglakhir = tgl2[0];
	var blnthn2 = tgl2[1]+" "+tgl2[2];

	if (tglsmtr !== 0) {
		var tglarray = tglsmtr.split(" - ");
		var tglsementara = tglarray[1].split(" ");
		var periode = tglarray[0].split(" ");
		var tglnow = parseInt(tglsementara[0])+" "+tglsementara[1]+" "+tglsementara[2];
		var persentaseprogress = ((parseInt(periode[0])+1)/parseInt(periode[1]))*100;
	}else{
		var tglnow = parseInt(tglawal)+banyak;
		tglnow = tglnow+" "+blnthn;
		if (tgl[0] == tgl[1]) {
			var persentaseprogress = 100;
		}else{
			var persentaseprogress = ((parseInt(tglnow)-parseInt(tglawal))/(parseInt(tglakhir)-parseInt(tglawal)))*100;
		}
		
	}
	
	$.ajax({
		type 	: 'POST',
		url		: baseurl+'CateringManagement/Puasa/Transfer/Transfer',
		data 	: {tanggal : tglnow,periode : valtgl},
		success	: function(data){
			$('#progressTransferPuasa').attr('style','width: '+persentaseprogress+"%;");
			$('#progressTransferPuasa').text(Math.round(persentaseprogress)+" %");
			console.log(persentaseprogress+"% ,tanggal : "+tglnow+" && "+data);
			if ((parseInt(tglakhir)+" "+blnthn2).toLowerCase() !== tglnow.toLowerCase()) {
				transferPuasa(banyak+1,data);
			}else{
				alert("Sukses Mentransfer Puasa");
				setTimeout(function(){
					$('#progressTransferPuasa').attr('style','width: 0%;');
					$('#progressTransferPuasa').text("");
				},2000);
			}
		}
	});
	
};


function batalTransferPuasa(){
	var valtgl = $('#txtPeriodeTranferPuasa').val();
	$('#TransferProgress2').show();
	$('#TransferProgress1').hide();
		
	$.ajax({
		type 	: 'POST',
		url		: baseurl+'CateringManagement/Puasa/Transfer/Batal',
		data 	: {tanggal : valtgl},
		success	: function(data){
			alert(data);
			$('#TransferProgress2').hide();
			$('#TransferProgress1').show();
		}
	});
};

function pilihDeletePuasa(){
	$('#formEditReadPuasaCatering').hide();
	$('#formStatusReadPuasaCatering').hide();
	$('#btnPilihReadPuasaCatering').hide();
	$('#formDeleteReadPuasaCatering').show();
	$('#btnSubmitReadPuasaCatering').show();
}

function pilihEditPuasa(){
	$('#formEditReadPuasaCatering').show();
	$('#formStatusReadPuasaCatering').show();
	$('#btnPilihReadPuasaCatering').hide();
	$('#formDeleteReadPuasaCatering').hide();
	$('#btnSubmitReadPuasaCatering').show();
}

function batalPilihPuasa(){
	$('#formEditReadPuasaCatering').hide();
	$('#formStatusReadPuasaCatering').hide();
	$('#btnPilihReadPuasaCatering').show();
	$('#formDeleteReadPuasaCatering').hide();
	$('#btnSubmitReadPuasaCatering').hide();
}