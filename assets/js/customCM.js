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
			$('.dataTable-EditTmp').DataTable( {

	  	});
			$('.approveCatering').DataTable( {

	  	});
			$('.approvedCat').DataTable( {

	  	});
	  	$('.dataTable-Tmp').DataTable( {
	      	dom: 'Blrtip',
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
			url: baseurl+'CateringManagement/CateringTambahan/tempatMakan',
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

		$('#Tranfer_modal_ploting-').on('show.bs.modal', function (event) {
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
	    $('#modal-tanggal_katering-').val(tgl);
	    $('#modal-Shift_pesan-').val(shift);
	    $('#modal-tanggal_katering-').val(tgl);
	    $('#modal-lokasi_kerja-').val(lokasi);
	    $('#modal-tempat_makan-').val(tempat_makan);
	    $('#modal-jml_total-').val(jml);
	    $('#modal-select2_katering-').select2({
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
	    					lokasi: lokasi
							};
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
	$('#btnPilihReadPuasaCatering').hide();
	$('#formDeleteReadPuasaCatering').hide();

	$('#formEditReadPuasaCatering').show();
	$('#formStatusReadPuasaCatering').show();
	$('#btnSubmitReadPuasaCatering').show();
}

function batalPilihPuasa(){
	$('#formEditReadPuasaCatering').hide();
	$('#formStatusReadPuasaCatering').hide();
	$('#formDeleteReadPuasaCatering').hide();
	$('#btnSubmitReadPuasaCatering').hide();

	$('#btnPilihReadPuasaCatering').show();
}

$(document).ready(function(){
	$('.tabel_pesan_manual').DataTable();
});

function modalDelete(id) {
Swal.fire({
  title: 'Apakah Anda Yakin?',
  text: "Mengapus data ini secara permanent !",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.value) {
  	window.location.href = baseurl+"CateringManagement/Extra/PesananManual/hapus/"+id;
  }
});
return false;
}
$(document).ready(function(){
	$('#cm_btn_submit').click(function(){
		// alert(id);
	 Swal.fire({
	  title: 'Apakah Anda Yakin?',
	  text: "Menyimpan Perubahan Pada Data Ini !",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Ya, Saya Yakin!'
	}).then((result) => {
	  if (result.value) {
	  	$('#cm_btn_submit2').click();
	  	return true;
	  }
	});
	return false;
	});
});

$(document).ready(function() {
	$('#txtSeksiEdit').on('change',function() {

		var seksi = $('#txtSeksiEdit').val();
		$.ajax({
			 type:'POST',
			 data:{seksi:seksi},
			 url:baseurl+"CateringManagement/Extra/EditTempatMakan/getKirimID",
			 success:function(result)
			 {
				var result = JSON.parse(result);
				 $('#txtDepartmenEditMakan').val(result['dept']);
				 $('#txtEditBidangMakan').val(result['bidang']);
				 $('#txtEditUnitMakan').val(result['unit']);
				 $('#txtEditSeksiMakan').val(result['seksi']);
				 $('#txtEditPekerjaanMakan').val(result['pekerjaan']);
				 $('#makan1').val(result['tempat_makan']);
				 $('#makan1').select2().trigger('change');
				 $('#kirimAll').prop('disabled',false);
		 		 $('#kirimStaff').prop('disabled',false);
		 	 	 $('#kirimNonStaff').prop('disabled',false);
			 }
				 });
	})
})

$(document).ready(function() {
		$('#kirim').click(function() {
			Swal.fire({
		  title: 'Apakah Anda Yakin ?',
		  text: "Menyimpan Perubahan Pada Data Ini",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes'
		}).then((result) => {
		  if (result.value) {
				$('#kirim2').click();
				return true;
		  }
		});
	return false;
	})
})

function simpansemua(){
	text = $('.edit_tempat_makan_semua').text();
	if (text == 'Edit Semua') {
		$('#makan1').prop('disabled',false);
		$('#makan2').prop('disabled',false);
		$('#kirimStaff').prop('disabled',true);
		$('#kirimNonStaff').prop('disabled',true);
		$('.edit_tempat_makan_semua').text('Simpan Semua');
		document.getElementById("kirimAll").classList.remove('btn-primary');
		document.getElementById("kirimAll").classList.add('btn-success');
		var x = document.getElementById("batal1");
		  if (x.style.display === "none") {
		    x.style.display = "";
		  } else {
		    x.style.display = "none";
		  }
	}else{
		tmp_makan1 = $('#makan1').val();
		tmp_makan2 = $('#makan2').val();
		kodesie = $('#txtSeksiEdit').val();
		Swal.fire({
		title: 'Apakah Anda Yakin ?',
		text: "Menyimpan Perubahan Pada Data Ini",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes'
	}).then((result) => {
		if (result.value) {
			$.ajax({
				 type:'POST',
				 data:{makan1: tmp_makan1, makan2: tmp_makan2, kodesie: kodesie},
				 url:baseurl+"CateringManagement/Extra/EditTempatMakan/updateAll",
				 success:function(result){
					 window.location.reload();
				 }
		});
			return true;
		}
	});
}
}

function simpanstaff(){
	text = $('.edit_tempat_makan_staff').text();
	if (text == 'Edit Staff') {
		$('#makan1').prop('disabled',false);
		$('#makan2').prop('disabled',false);
		$('#kirimAll').prop('disabled',true);
		$('#kirimNonStaff').prop('disabled',true);
		$('.edit_tempat_makan_staff').text('Simpan Staff');
		document.getElementById("kirimStaff").classList.remove('btn-primary');
		document.getElementById("kirimStaff").classList.add('btn-success');
		var x = document.getElementById("batal1");
		  if (x.style.display === "none") {
		    x.style.display = "";
		  } else {
		    x.style.display = "none";
		  }
	}else{
		tmp_makan1 = $('#makan1').val();
		tmp_makan2 = $('#makan2').val();
		kodesie = $('#txtSeksiEdit').val();
		Swal.fire({
		title: 'Apakah Anda Yakin ?',
		text: "Menyimpan Perubahan Pada Data Ini",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes'
	}).then((result) => {
		if (result.value) {
			$.ajax({
				 type:'POST',
				 data:{makan1: tmp_makan1, makan2: tmp_makan2, kodesie: kodesie},
				 url:baseurl+"CateringManagement/Extra/EditTempatMakan/updateStaff",
				 success:function(result){
					 window.location.reload();
				 }
		});
			return true;
		}
	});
}
}

function simpannonstaff(){
	text = $('.edit_tempat_makan_nonstaff').text();
	if (text == 'Edit NonStaff') {
		$('#makan1').prop('disabled',false);
		$('#makan2').prop('disabled',false);
		$('#kirimAll').prop('disabled',true);
		$('#kirimStaff').prop('disabled',true);
		$('.edit_tempat_makan_nonstaff').text('Simpan NonStaff');
		document.getElementById("kirimNonStaff").classList.remove('btn-primary');
		document.getElementById("kirimNonStaff").classList.add('btn-success');
		var x = document.getElementById("batal1");
		  if (x.style.display === "none") {
		    x.style.display = "";
		  } else {
		    x.style.display = "none";
		  }
	}else{
		tmp_makan1 = $('#makan1').val();
		tmp_makan2 = $('#makan2').val();
		kodesie = $('#txtSeksiEdit').val();
		Swal.fire({
		title: 'Apakah Anda Yakin ?',
		text: "Menyimpan Perubahan Pada Data Ini",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes'
	}).then((result) => {
		if (result.value) {
			$.ajax({
				 type:'POST',
				 data:{makan1: tmp_makan1, makan2: tmp_makan2, kodesie: kodesie},
				 url:baseurl+"CateringManagement/Extra/EditTempatMakan/updateNonStaff",
				 success:function(result){
					 window.location.reload();
				 }
		});
			return true;
		}
	});
}
}

function batal(){
		$('#makan1').prop('disabled',true);
		$('#makan2').prop('disabled',true);
		$('#kirimAll').prop('disabled',false);
		$('#kirimStaff').prop('disabled',false);
		$('#kirimNonStaff').prop('disabled',false);
		$('.edit_tempat_makan_semua').text('Edit Semua');
		$('.edit_tempat_makan_staff').text('Edit Staff');
		$('.edit_tempat_makan_nonstaff').text('Edit NonStaff');
		document.getElementById("kirimAll").classList.remove('btn-success');
		document.getElementById("kirimStaff").classList.remove('btn-success');
		document.getElementById("kirimNonStaff").classList.remove('btn-success');
		document.getElementById("kirimAll").classList.add('btn-primary');
		document.getElementById("kirimStaff").classList.add('btn-primary');
		document.getElementById("kirimNonStaff").classList.add('btn-primary');

		var x = document.getElementById("batal1");
		  if (x.style.display === "") {
		    x.style.display = "none";
		  } else {
		    x.style.display = "none";
		  }
}

function resetEdit(){
	$('#makan1').select2('val', '');
	$('#makan2').select2('val', '');
	$('#txtSeksiEdit').select2('val', '');
}

function disableinput()
{
	var x = $('#tambahan_pesanan').val();
	var y = $('#pengurangan_pesanan').val();

	if (x.length > 0 ) {
		$('#pengurangan_pesanan').attr('disabled',true);
	}else{
		$('#pengurangan_pesanan').attr('disabled',false);
	}
	if (y.length > 0 ) {
		$('#tambahan_pesanan').attr('disabled',true);
	}else {
		$('#tambahan_pesanan').attr('disabled',false);
	}
}

$('#ketnoind').select2({
		minimumInputLength: 3,
		allowClear: true,
		placeholder: "Input Nomor Induk / Nama"
	})

	$('#noindpribadi').select2({
		minimumInputLength: 3,
		allowClear: true,
		placeholder: "Input Nomor Induk / Nama"
	})

function kirimapprove(){
		var shift = $('#shift_pesanan').val();
		var loker = $('#lokasi_pesanan').val();
		var tmp_makan = $('#slc_tempat_makan').val();
		var tambah = $('#tambahan_pesanan').val();
		var kurang = $('#pengurangan_pesanan').val();
		var kep = $('#keperluanCat').val();
		if (kep == "SELEKSI") {
			var ket = $('#ketnoind').val();
			var implode = 1;
		}else if (kep == "T/V") {
			var ket = $('#TamuVendor').val();
			var implode = 0;
		}else if (kep == "LEMBUR"){
			var ket = $('#noindpribadi').val();
			var implode = 1;
		}
		var approval = $('#app').val();
		var loading = baseurl + 'assets/img/gif/loadingquick.gif';

		console.log(shift);
		console.log(loker);
		console.log(tmp_makan);
		console.log(tambah);
		console.log(kurang);
		console.log(ket);
		console.log(kep);

		if (tmp_makan == null || (tambah == "" && kurang == "") || ket == null  || approval == '') {
			Swal.fire(
			  'Peringatan!',
			  'Data Harap di isi dengan Lengkap!',
			  'warning'
			)
		}else {
			Swal.fire({
				title: 'Apakah Anda Yakin ?',
				text: "Pesanan akan di Proses",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes'
			}).then((result) => {
				if (result.value) {
					Swal.fire({
						html : "<img style='width: 100px; height: auto;'src='"+loading+"'>",
						text : 'Loading...',
						customClass: 'swal-wide',
						showConfirmButton:false
					});
					$.ajax({
						type:'POST',
						data:{
							shift_pesanan: shift,
							lokasi_pesanan: loker,
							tempat_makan: tmp_makan,
							tambahan_pesanan: tambah,
							pengurangan_pesanan: kurang,
							keperluan: kep,
							ketnoind: ket,
							implode: implode
						},
						url:baseurl+"CateringTambahan/simpan",
						success:function(result){
							swal.close();
							window.location.reload();
							Swal.fire(
							  'SUCCESS',
							  'Data akan dimintakan Approve',
							  'success'
							)
							return true;
						}
					});
					return true;
				}
			});
		}
}

function reseta(){
	window.location.reload();
}

$(document).ready(function(){
	$('#transfer_all').click(function(){
		var tanggal = $('#modal-tanggal_katering').val();
		var shift = $('#modal-Shift_pesan').val();
		var lokasi_kerja = $('#modal-lokasi_kerja').val();
		var tempat_makan = $('#modal-tempat_makan').val();
		var jml_total = $('#modal-jml_total').val();
		var tempat_katering = $('#modal-select2_katering').val();
		var loading = baseurl + 'assets/img/gif/loadingquick.gif';

		Swal.fire({
			title: 'Apakah Anda Yakin ?',
			text : 'TEMPAT MAKAN ' + $('#modal-tempat_makan').val() + ' AKAN DI PLOTTING KE ' + $('#modal-select2_katering').text(),
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type:'POST',
					data:{
						tanggal_katering: tanggal,
						Shift_pesan: shift,
						lokasi_kerja: lokasi_kerja,
						tempat_makan: tempat_makan,
						jml_total: jml_total,
						tempat_katering: tempat_katering
					},
					url:baseurl+"CateringManagement/DataPesanan/transfer",
				  success:function(result){
				  	Swal.fire({
					  html : "<img style='width: 100px; height: auto;'src='"+loading+"'>",
			  	  text : 'Loading...',
				    customClass: 'swal-wide',
					  showConfirmButton:false
					 })
					 window.location.reload();
				 return true;
				 },
				 error:function(result){
					 alert('error');
				 }
				});
			}
		});
		return false;
	})
})

$(document).ready(function(){
	$('#pindahAll').click(function(){
		var tanggal = $('#modal-tanggal_katering-').val();
		var shift = $('#modal-Shift_pesan-').val();
		var lokasi_kerja = $('#modal-lokasi_kerja-').val();
		var tempat_makan = $('#modal-tempat_makan-').val();
		var jml_total = $('#modal-jml_total-').val();
		var tempat_katering = $('#modal-select2_katering-').val();
		var loading = baseurl + 'assets/img/gif/loadingquick.gif';

		Swal.fire({
			title: 'Apakah Anda Yakin ?',
			text : 'TEMPAT MAKAN ' + $('#modal-tempat_makan-').val() + ' AKAN DI PINDAH KE ' + $('#modal-select2_katering-').text(),
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes'
		}).then((result) => {
				if (result.value) {
					$.ajax({
						url:baseurl+"CateringManagement/DataPesanan/pindah",
						method:'POST',
						data:{
							tanggal_katering: tanggal,
							Shift_pesan: shift,
							lokasi_kerja: lokasi_kerja,
							tempat_makan: tempat_makan,
							jml_total: jml_total,
							tempat_katering: tempat_katering
						},
						success:function(result){
							Swal.fire({
 						 	html : "<img style='width: 100px; height: auto;'src='"+loading+"'>",
 							customClass: 'swal-wide',
 							showConfirmButton:false
 						 })
 						  window.location.reload();
 		 				 return true;
		 				 },
						 error:function(result){
							 alert('error');
						 }
					});
				}
			});
			return false;
		})
	})

function goback(){
	window.history.back();
}

function detailcatering(id)
{
	var kosong1 = $('#modal-jml_plus_Tambahan').val();
	var kosong2 = $('#modal-jml_min_Tambahan').val();
	$.ajax({
		method: 'POST',
		url:baseurl+"ApprovalTambahan/Detail",
		data:{id:id},
		dataType:'json',
		success: function(data){
			console.log(data);
			$('#modal-id_Tambahan').val(data[0].id);
			$('#modal-Shift_Tambahan').val(function() {
				if (data[0].kd_shift == 1) {
					return 'SHIFT 1 DAN UMUM';
				}else if (data[0].kd_shift == 2) {
					return 'SHIFT 2';
				}else {
					return 'SHIFT 3';
				}
			});
			$('#modal-lokasi_kerja_Tambahan').val(function() {
				if (data[0].lokasi_kerja == 1) {
					return 'YOGYAKARTA (PUSAT)';
				}else if (data[0].lokasi_kerja == 2) {
					return 'TUKSONO';
				}
			});
			$('#modal-tempat_makan_Tambahan').val(data[0].tempat_makan);
			$('#modal-jml_plus_Tambahan').val(function(){
				if(data[0].tambahan == ''){
					return '-';
				}else{
					return data[0].tambahan;
				}
			});
			$('#modal-jml_min_Tambahan').val(function() {
				if (data[0].pengurangan == '') {
					return '-';
				}else {
					return data[0].pengurangan;
				}
			});
			$('#modal-keterangan').val(data[0].keterangan);
			$('#modal-Keperluan').val(data[0].keperluan);
			$('#modal-pemesan').val(data[0].user_ +' - '+ data[0].nama);
			$('#modal-siePesan').val(data[0].seksi);
			if (kosong1 == null) {
				$('#modal-jml_plus_Tambahan').html("-");
			}
			if (data[0].status == 1) {
				$('#appcatering2').hide();
				$('#appcatering3').hide();
				$('#appcatering1').hide();
				$('#appcatering4').hide();

				$('#appcatering1').show();
			}else if (data[0].status == 2) {
				$('#appcatering2').hide();
				$('#appcatering3').hide();
				$('#appcatering1').hide();
				$('#appcatering4').hide();

				$('#appcatering2').show();
			}else if (data[0].status == 4) {
				$('#appcatering2').hide();
				$('#appcatering3').hide();
				$('#appcatering1').hide();
				$('#appcatering2').hide();

				$('#appcatering4').show();
			}else{
				$('#appcatering2').hide();
				$('#appcatering3').hide();
				$('#appcatering1').hide();
				$('#appcatering4').hide();

				$('#appcatering3').show();
			}

			$("#modal-approve-catering").modal();
		}
	})

}

function ApproveCatering()
{
	let id = $('#modal-id_Tambahan').val();
	let shift = $('#modal-Shift_Tambahan').val();
	let loker = $('#modal-lokasi_kerja_Tambahan').val();
	let tmp_makan = $('#modal-tempat_makan_Tambahan').val();
	let plus = $("#modal-jml_plus_Tambahan").val();
	let min = $('#modal-jml_min_Tambahan').val();
	$.ajax({
		method: 'POST',
		url: baseurl+"ApprovalTambahan/Approval",
		data:{
			id:id,
			Shift_Tambahan: shift,
			lokasi_kerja: loker,
			tempat_makan: tmp_makan,
			plus:plus,
			min: min,
			status:2
		},
		success:function(data){
			var url = baseurl + "ApprovalTambahan";
			$('#page').load(url + " #page");
			$("#modal-approve-catering").modal('hide');
			Swal.fire({
				title: 'Success',
				text: "Pesanan Telah di Approve",
				type: 'success'
			})
		}
	})
}

function RejectCatering() {
	let id = $('#modal-id_Tambahan').val();

	$.ajax({
		method: 'POST',
		url: baseurl+"ApprovalTambahan/Approval",
		data:{
			id:id,
			status:3
		},
		success:function(data){
			var url = baseurl + "ApprovalTambahan";
			$('#page').load(url + " #page");
			$("#modal-approve-catering").modal('hide');
			Swal.fire({
				title: 'Reject Success',
				text: "Pesanan Telah di Reject",
				type: 'error'
			})
		}
	})
}

function KeperluanSelekted() {
	let kep = $('#keperluanCat').val();

	if( kep == "SELEKSI" || kep == "all") {
     $('#ketinputdiv').removeClass('hilang');

		 $('#ketinput2div').addClass('hilang');
		 $('#ketareadiv').addClass('hilang');
	}else if (kep == "T/V") {
		$('#ketareadiv').removeClass('hilang');

		$('#ketinputdiv').addClass('hilang');
		$('#ketinput2div').addClass('hilang');
	}else if (kep == "LEMBUR") {
		$('#ketinput2div').removeClass('hilang');

		$('#ketareadiv').addClass('hilang');
		$('#ketinputdiv').addClass('hilang');
	}
}
