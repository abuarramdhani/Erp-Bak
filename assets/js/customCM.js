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
		
	function calculation(pphstatus){
			
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
	      	dom: 'frtp',
	    });
	});