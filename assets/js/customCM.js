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

	$("#cateringBatch").change(cekpphBatch);
	$("#pphverifyBatch").click(cekpphBatch);

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

	function cekpphBatch(){
		$.ajax({
			type:'POST',
			data:{id:$("#cateringBatch").val()},
			url:baseurl+"CateringManagement/ReceiptBatch/Checkpph",
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

	$("#orderqtyBatch,#singlepriceBatch,#fineBatch").keyup(checkncalcBatch);
	$("#orderqtyBatch,#singlepriceBatch,#fineBatch").click(checkncalcBatch);
	$("#DelFineBatch").click(checkncalcBatch);
	$("#ReCalculateBatch").click(checkncalcBatch);
	$("#tbodyFineCateringBatch input").keyup(checkncalcBatch);
	$("#tbodyFineCateringBatch input").click(checkncalcBatch);
	$("#tbodyFineCateringBatch select").change(checkncalcBatch);
	$("#bonusBatch, #slcLocationBatch, orderqtyBatch").change(checkncalcBatch);

	$('#txtDeptQtyBatch1, #txtDeptQtyBatch2, #txtDeptQtyBatch3, #txtDeptQtyBatch4').on('change',function(){
		var qty1 = $('#txtDeptQtyBatch1').val();
		var qty2 = $('#txtDeptQtyBatch2').val();
		var qty3 = $('#txtDeptQtyBatch3').val();
		var qty4 = $('#txtDeptQtyBatch4').val();

		if (qty1 && qty2 && qty3 && qty4) {
			total_qty = parseInt(qty1) + parseInt(qty2) + parseInt(qty3) + parseInt(qty4);
			// console.log(total_qty);
			$('#orderqtyBatch').val(total_qty);
		}
	});

	$('#txtDeptQtyBatch1, #txtDeptQtyBatch2, #txtDeptQtyBatch3, #txtDeptQtyBatch4').on('keyup',function(){
		var qty1 = $('#txtDeptQtyBatch1').val();
		var qty2 = $('#txtDeptQtyBatch2').val();
		var qty3 = $('#txtDeptQtyBatch3').val();
		var qty4 = $('#txtDeptQtyBatch4').val();

		if (qty1 && qty2 && qty3 && qty4) {
			total_qty = parseInt(qty1) + parseInt(qty2) + parseInt(qty3) + parseInt(qty4);
			// console.log(total_qty);
			$('#orderqtyBatch').val(total_qty);
		}
	});

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

	function calculationBatch(pphstatus){
		var $qty = $('#orderqtyBatch').val();
		var $price = $('#singlepriceBatch').val();
		var $ordertype = $('#ordertypeBatch').val();
		var $bonus = $('#bonusBatch').val();

		if($ordertype==2 && $bonus==1){
			var $bonus_qty = Math.floor($qty/50);
		} else {
			var $bonus_qty = 0;
		}

		var $net = $qty - $bonus_qty;
		var $calc = $net * $price;
		var $fine = $('#fineBatch').val();
		var $est = $calc - $fine;

		if (pphstatus==1){
			var $pph = Math.ceil((2 / 100) * $est);
		} else {
			var $pph = Math.ceil((0 / 100) * $est);
		}

		var $total = $est - $pph;

		$("#orderbonusBatch").val($bonus_qty);
		$("#ordernetBatch").val($net);
		$("#calcBatch").val($calc);
		$("#pphBatch").val($pph);
		$("#totalBatch").val($total);
	};

	//MELAKUKAN CEK PPH SEKALIGUS KALKULASI NILAI AKHIR
	function checkncalc(){
		cekpph();
		calculation();
	}

	function checkncalcBatch(){
		cekpphBatch();
		calculationBatch();
	}


	$('#ordertypeBatch, #cateringBatch, #slcLocationBatch, #TxtOrderDateBatch').on('change',getQtyPerDeptBatch);

	function getQtyPerDeptBatch(){
		var tipe = $('#ordertypeBatch').val();
		var catering = $('#cateringBatch').val();
		var location = $('#slcLocationBatch').val();
		var orderDate = $('#TxtOrderDateBatch').val();

		if (tipe && catering && location && orderDate) {
			$.ajax({
				data  : {tipe: tipe, catering: catering, location: location, date: orderDate},
				type  : 'GET',
				url   : baseurl + 'CateringManagement/ReceiptBatch/getQtyPerDeptBatch',
				error: function(xhr,status,error){
				console.log(xhr);
				console.log(status);
				console.log(error);
				swal.fire({
				    title: xhr['status'] + "(" + xhr['statusText'] + ")",
				    html: xhr['responseText'],
				    type: "error",
				    confirmButtonText: 'OK',
				    confirmButtonColor: '#d63031',
				})
				},
				success: function(result){
					if (result) {
						obj = JSON.parse(result);
						// console.log(obj);
						$('#txtDeptQtyBatch1').val(obj['keuangan']);
						$('#txtDeptQtyBatch2').val(obj['pemasaran']);
						$('#txtDeptQtyBatch3').val(obj['produksi']);
						$('#txtDeptQtyBatch4').val(obj['personalia']);
						$('#orderqtyBatch').val(parseInt(obj['keuangan']) + parseInt(obj['pemasaran']) + parseInt(obj['produksi']) + parseInt(obj['personalia']));
					}else{
						$('#txtDeptQtyBatch1').val('0');
						$('#txtDeptQtyBatch2').val('0');
						$('#txtDeptQtyBatch3').val('0');
						$('#txtDeptQtyBatch4').val('0');
						$('#orderqtyBatch').val('0');
					}
				}
			})
		}
	}

	//Untuk Catering Tambahan Rekap Dinas
	$("#prosesTambahanDinas").on('click', function () {
		window.location.href = baseurl + "ApprovalTambahan/PemrosesCatering";
		let loading = 'assets/img/gif/loadingquick.gif'
		swal.fire({
				html : "<img style='width: 320px; height: auto;'src='"+loading+"'>",
				text : 'Loading...',
				customClass: 'swal-wide',
				showConfirmButton:false,
				allowOutsideClick: false
			});
	})

	$("input.tanggalRekapDinas").daterangepicker({
		autoUpdateInput: false,
		locale: {
			cancelLabel: 'Clear'
		}
	});

	$('input.tanggalRekapDinas').on('apply.daterangepicker', function(ev, picker) {
		$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
	});

	$('input.tanggalRekapDinas').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val('');
	});

	$('#cariRekapDinas').on('click', function () {
		let tanggal = $('#tanggalRekapDinas').val();
		let loading = 'assets/img/gif/loadingquick.gif'

		$.ajax({
			type: 'post',
			dataType: 'json',
			data: { tanggal: tanggal},
			url: baseurl + 'ApprovalTambahan/rekapDinas',
			beforeSend: function(){
					swal.fire({
							html : "<img style='width: 320px; height: auto;'src='"+loading+"'>",
							text : 'Loading...',
							customClass: 'swal-wide',
							showConfirmButton:false,
							allowOutsideClick: false
						});
					},
			success: function (data) {
				if (data == 'Kosong') {
					swal.fire({
						title: "Peringatan !",
						text: "Mohon Maaf Data Tidak Ditemukan",
						type: 'warning',
						allowOutsideClick: false
					})
				}else {
					swal.close()
					$('#gantiHariRekap').html(data).find('.approveCatering').dataTable()
					$('.detailPekerjaDinasPlus').on('click', function () {
						let detail = $(this).attr('value')

						$.ajax({
							type: 'post',
							data: {
								value: detail
							},
							url: baseurl + 'ApprovalTambahan/getDetailPekerjaDinasPlus',
							beforeSend: function () {
								swal.fire({
									html: "<img style='width: 320px; height: auto;' src='"+loading+"'>",
									showConfirmButton: false,
									allowOutsideClick: false
								})
							},
							success: function (data) {
								swal.close()
								$('#detailPekerjaDinas').modal('show')
								$('#Dinas_result').html(data)
							}
						})
					})
					$('.detailPekerjaDinasMin').on('click', function () {
						let detail = $(this).attr('value')
						$.ajax({
							type: 'post',
							data: {
								value: detail
							},
							url: baseurl + 'ApprovalTambahan/getDetailPekerjaDinasMin',
							beforeSend: function () {
								swal.fire({
									html: "<img style='width: 320px; height: auto;' src='"+loading+"'>",
									showConfirmButton: false,
									allowOutsideClick: false
								})
							},
							success: function (data) {
								swal.close()
								$('#detailPekerjaDinas').modal('show')
								$('#Dinas_result').html(data)
							}
						})
					})
				}
			}
		})
	})

	$('.detailPekerjaDinasPlus').on('click', function () {
		let detail = $(this).attr('value')
		let loading = 'assets/img/gif/loadingquick.gif'

		$.ajax({
			type: 'post',
			data: {
				value: detail
			},
			url: baseurl + 'RekapTambahan/getDetailPekerjaDinasPlus',
			beforeSend: function () {
				swal.fire({
					html: "<img style='width: 320px; height: auto;' src='"+loading+"'>",
					showConfirmButton: false,
					allowOutsideClick: false
				})
			},
			success: function (data) {
				swal.close()
				$('#detailPekerjaDinas').modal('show')
				$('#Dinas_result').html(data)
			}
		})
	})

	$('.detailPekerjaDinasMin').on('click', function () {
		let detail = $(this).attr('value')
		let loading = 'assets/img/gif/loadingquick.gif'

		$.ajax({
			type: 'post',
			data: {
				value: detail
			},
			url: baseurl + 'RekapTambahan/getDetailPekerjaDinasMin',
			beforeSend: function () {
				swal.fire({
					html: "<img style='width: 320px; height: auto;' src='"+loading+"'>",
					showConfirmButton: false,
					allowOutsideClick: false
				})
			},
			success: function (data) {
				swal.close()
				$('#detailPekerjaDinas').modal('show')
				$('#Dinas_result').html(data)
			}
		})
	})

	$('#Rekap_Dinas1').on('click', function () {
		let tanggal = $('#tanggalRekapDinas').val()
		window.location.href = baseurl+ 'RekapTambahan/exportDinas?jenis=Excel&tanggal='+tanggal
	})

	$('#Rekap_Dinas2').on('click', function () {
		let tanggal = $('#tanggalRekapDinas').val()
		window.location.href = baseurl+ 'RekapTambahan/exportDinas?jenis=PDF&tanggal='+tanggal
	})
	//Selesai
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

	function AddFineBatch(base){
		var newgroup = $('<tr>').addClass('clone');
		var e = jQuery.Event( "click" );
		e.preventDefault();
		$("select#finetypeBatch:last").select2("destroy");

		$('.clone').last().clone().appendTo(newgroup).appendTo('#tbodyFineCateringBatch');

		$("select#finetypeBatch").select2({
			placeholder: "",
			allowClear : true,
		});

		$("select#finetypeBatch:last").select2({
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

		$("select#finetypeBatch:last").val("").change();
		$("input#finepriceBatch:last").val("").change();
		$("input#fineqtyBatch:last").val("").change();

		$("#DelFineBatch").click(multInputs);
		$("#tbodyFineCateringBatch input").keyup(finerowall);
		$("#tbodyFineCateringBatch input").click(finerowall);
		$("#tbodyFineCateringBatch select").change(finerowall);

		// Function 1 : CALCULATE FINE PER ROW
		function multInputs() {

			$("tr.clone").each(function () {

				var qty = $('#fineqtyBatch', this).val();
				var ordertype = $('#ordertypeBatch').val();
					if(ordertype==2){var bonus_qty = Math.floor(qty/50);}else {var bonus_qty = 0;}
				var price = $('#finepriceBatch', this).val();
				var percentage = $('#finetypeBatch', this).val();
				var total = Math.ceil((qty-bonus_qty)*price*percentage/100);
				$("#finenominalBatch", this).val(total);
			});

			var item = document.getElementsByClassName("finenominal");
			var itemCount = item.length;
			var total = 0;
			for(var i = 0; i < itemCount; i++){
				total = total +  parseInt(item[i].value);
			}
			document.getElementById('fineBatch').value = total;
		}

		// Function 2 : CHECK PPH (COPY)
		function cekpphalias(){
			$.ajax({
				type:'POST',
				data:{id:$("#cateringBatch").val()},
				url:baseurl+"CateringManagement/ReceiptBatch/Checkpph",
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

			var $qty = $('#orderqtyBatch').val();
			var $price = $('#singlepriceBatch').val();
			var $ordertype = $('#ordertypeBatch').val();

			if($ordertype==2){
				var $bonus_qty = Math.floor($qty/50);
			}
			else {
				var $bonus_qty = 0;
			}

			var $calc = (($qty-$bonus_qty) * $price);
			var $fine = $('#fineBatch').val();
			var $est = $calc - $fine;
			if (pphstatus==1){
				var $pph = Math.ceil((2 / 100) * $est);
			} else {
				var $pph = Math.ceil((0 / 100) * $est);
			}

			var $total = $est - $pph;

			$("#calcBatch").val($calc);
			$("#pphBatch").val($pph);
			$("#totalBatch").val($total);

		};

		//FUNCTION 4 : RUN ALL FUNCTION
		function finerowall(){
			multInputs();
			cekpphalias();
			calculationalias();
		}

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

		setTimeout(function(){
		  $('#AddFineBatch').click();
		},10);
		setTimeout(function(){
		  $('#HiddenDelFineBatch').click();
		},20);
		setTimeout(function(){
		  $('#ReCalculateBatch').click();
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
		$('.dataTable-EditTmp').DataTable( {});
		$('.dataTable_receipt').DataTable( {});
		$('.approveCatering').DataTable( {});
		$('.approvedCat').DataTable( {});
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

	$('#btnProsesPP').on('click',function(){
		var ppAwal = $('#txtPeriodeCateringAwalPP').val();
		var ppAkhir = $('#txtPeriodeCateringAkhirPP').val();
		var ppLokasi = $('#slcLokasiKateringPP').val();
		var ppJenis = $('#slcJenisPesananPP').val();

		if (ppJenis && ppLokasi && ppAkhir && ppAwal) {
			$.ajax({
				data  : {ppjenis: ppJenis, pplokasi: ppLokasi, ppawal: ppAwal, ppakhir: ppAkhir},
				type  : 'GET',
				url   : baseurl + 'CateringManagement/PrintPPCatering/getQtyPerDeptBatch',
				error: function(xhr,status,error){
					console.log(xhr);
					console.log(status);
					console.log(error);
					swal.fire({
					    title: xhr['status'] + "(" + xhr['statusText'] + ")",
					    html: xhr['responseText'],
					    type: "error",
					    confirmButtonText: 'OK',
					    confirmButtonColor: '#d63031',
					})
				},
				success: function(result){
					if (result) {
						if (result.search('A PHP Error was encountered') < 0) {
							obj = JSON.parse(result);
							console.log(obj);
							$('#printpp').html("");
							for (var i = 0; i < obj.length; i++) {
								console.log(obj[i]);
								text_row = '<tr>'
                                text_row = text_row + '    <td>'
                                text_row = text_row + '        <select type="text" placeholder="Pp Kodebarang" name="txtPpKodebarangHeader[]" id="txtPpKodebarangHeader" class="form-control cm_select2" >'
                                text_row = text_row + '            <option value="' + obj[i]['kode'] + '" selected>' + obj[i]['kode'] + '</option>'
                                text_row = text_row + '        </select>'
                                text_row = text_row + '    </td>'
                                text_row = text_row + '    <td>'
                                text_row = text_row + '        <input value="' + obj[i]['jumlah'] + '" type="text" placeholder="Pp Jumlah" name="txtPpJumlahHeader[]" id="txtPpJumlahHeader" class="form-control hapusaja" />'
                                text_row = text_row + '    </td>'
                                text_row = text_row + '    <td>'
                                text_row = text_row + '        <input value="' + obj[i]['satuan'] + '" type="text" placeholder="Pp Satuan" name="txtPpSatuanHeader[]" id="txtPpSatuanHeader" class="form-control hapusaja"  />'
                                text_row = text_row + '    </td>'
                                text_row = text_row + '    <td>'
                                text_row = text_row + '        <input value="' + obj[i]['nama'] + obj[i]['katering'] + ' TANGGAL ' + obj[i]['awal'] + ' - ' + obj[i]['akhir'] + ' DEPT ' + obj[i]['dept'] + '" type="text" placeholder="Pp Nama Barang" name="txtPpNamaBarangHeader[]" id="txtPpNamaBarangHeader" class="form-control cm_namaItem" />'
                                text_row = text_row + '    </td>'
                                text_row = text_row + '    <td>'
                                text_row = text_row + '        <input value="' + obj[i]['branch'] + '" type="text" placeholder="Pp Branch" name="txtPpBranchHeader[]" id="txtPpBranchHeader" class="form-control cm_branch" />'
                                text_row = text_row + '    </td>'
                                text_row = text_row + '    <td>'
                                text_row = text_row + '        <input value="' + obj[i]['cc'] + '" type="text" placeholder="Pp Cost Center" name="txtPpCostCenterHeader[]" id="txtPpCostCenterHeader" class="form-control cm_costCenter" />'
                                text_row = text_row + '    </td>'
                                text_row = text_row + '    <td>'
                                text_row = text_row + '        <input type="text" maxlength="10" placeholder="NBD" name="txtPpNbdHeader[]" class="pp-date date form-control hapusaja" data-date-format="yyyy-mm-dd" id="txtPpNbdHeader" />'
                                text_row = text_row + '    </td>'
                                text_row = text_row + '    <td>'
                                text_row = text_row + '        <input type="text" placeholder="Pp Keterangan" name="txtPpKeteranganHeader[]" id="txtPpKeteranganHeader" class="form-control hapusaja" />'
                                text_row = text_row + '    </td>'
                                text_row = text_row + '    <td>'
                                text_row = text_row + '        <input type="text" placeholder="Pp Supplier" name="txtPpSupplierHeader[]" id="txtPpSupplierHeader" class="form-control hapusaja" />'
                                text_row = text_row + '    </td>'
                                text_row = text_row + '    <td><a href="" class="btn btn-primary btn-sm delete-row-printpp"><i class="fa fa-minus"></i></a></td>'
                                text_row = text_row + '</tr>'
								$('#printpp').append(text_row);
							}

							$('.cm_select2').select2({
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
						}else{
							swal.fire({
							    title: "Error",
							    html: result,
							    type: "error",
							    confirmButtonText: 'OK',
							    confirmButtonColor: '#d63031',
							})
						}
					}else{
						swal.fire({
						    title: "Peringatan",
						    html: "Data Kosong",
						    type: "warning",
						    confirmButtonText: 'OK',
						    confirmButtonColor: '#d63031',
						})
					}
				}
			})
		}
	});

	$(".select-employee-batch").select2({
	  	ajax: {
	        url: baseurl+'CateringManagement/PrintPPCatering/Employee',
	        dataType: 'json',
	        delay: 250,
	        data: function (params) {
	          return {
	            q: params.term,
	        };
	        },
	        processResults: function (data) {
	          return {
	                results: $.map(data, function (item) {
	                    return {
	                      id: item.employee_id,
	                      text: item.employee_name,
	                    }
	                })
	            };
	      },
	      cache: true
	    },
	    minimumInputLength: 2,
	    allowClear: true,
	});

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
			url: baseurl+'CateringTambahan/tempatMakan',
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {
								term: params.term,
								lokasi: $('select[name="lokasi_pesanan"]').val()
				};
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
		url		: baseurl+'CateringManagement/Puasa/Transfer/Proses',
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
			var implode = 1;
		}else if (kep == "LEMBUR"){
			var ket = $('#noindpribadi').val();
			var implode = 1;
		}
		var approval = $('#app').val();
		var loading = baseurl + 'assets/img/gif/loadingquick.gif';

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

//Untuk Catering tambahan
function KeperluanSelekted() {
	let kep = $('#keperluanCat').val();

	if( kep == "SELEKSI" || kep == "all") {
     $('#ketinputdiv').removeClass('hilang');
     $('#tempatMakan_plus').removeClass('hilang');
     $('#br_plus').removeClass('hilang');

		 $('#ketinput2div').addClass('hilang');
		 $('#ketareadiv').addClass('hilang');
	}else if (kep == "T/V") {
		$('#ketareadiv').removeClass('hilang');
		$('#tempatMakan_plus').removeClass('hilang');
		$('#br_plus').removeClass('hilang');

		$('#ketinputdiv').addClass('hilang');
		$('#ketinput2div').addClass('hilang');
	}else if (kep == "LEMBUR_DATANG" || kep == "LEMBUR_PULANG") {
		$('#ketinput2div').removeClass('hilang');

		$('#ketareadiv').addClass('hilang');
		$('#ketinputdiv').addClass('hilang');
		$('#tempatMakan_plus').addClass('hilang');
		$('#br_plus').addClass('hilang');
	}else {
		$('#ketinputdiv').removeClass('hilang');

		$('#ketareadiv').addClass('hilang');
		$('#ketinput2div').addClass('hilang');
		$('#tempatMakan_plus').addClass('hilang');
		$('#br_plus').addClass('hilang');
	}
}

function kirimapprove(){
		var shift = $('#shift_pesanan').val();
		var tmp_makan = $('#slc_tempat_makan').val();
		var kep = $('#keperluanCat').val();
		var tambah = $('#total_pesanan').val();
		if (kep == "SELEKSI") {
			var ket = $('#ketnoind').val();
			var implode = 1;
		}else if (kep == "T/V") {
			var ket = $('#TamuVendor').val();
			var implode = 1;
		}else if (kep == "LEMBUR_DATANG" || kep == "LEMBUR_PULANG"){
			var ket = $('#noindpribadi').val();
			var implode = 1;
		}
		var approval = $('#app').val();
		var loading = baseurl + 'assets/img/gif/loadingquick.gif';

		if (kep == 'SELEKSI' || kep == 'T/V') {
			if (ket == null || ket == '' || approval == '' || tmp_makan == null) {
				Swal.fire(
				  'Peringatan!',
				  'Data Harap di isi dengan Lengkap!',
				  'warning'
				)
			}else{
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
								tempat_makan: tmp_makan,
								total_pesanan: tambah,
								keperluan: kep,
								ketnoind: ket,
								implode: implode
							},
							url:baseurl+"CateringTambahan/simpan",
							success:function(result){
								swal.close();
								window.location.reload();
								Swal.fire({
								  title: 'SUCCESS',
								  text: 'Data akan dimintakan Approve',
								  type: 'success',
									showConfirmButton:false
								});
								return true;
								}
						});
						return true;
					}
				});
			}
		}else if (kep == 'LEMBUR_DATANG' || kep == 'LEMBUR_PULANG') {
			if (ket == null || ket == '' || approval == '') {
				Swal.fire(
				  'Peringatan!',
				  'Data Harap di isi dengan Lengkap!',
				  'warning'
				)
			}else{
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
					$.ajax({
						type:'POST',
						data:{
							shift_pesanan: shift,
							total_pesanan: tambah,
							keperluan: kep,
							ketnoind: ket,
							implode: implode
						},
						beforeSend: function(){
							Swal.fire({
								html : "<img style='width: 100px; height: auto;'src='"+loading+"'>",
								text : 'Loading...',
								customClass: 'swal-wide',
								showConfirmButton:false
							});
						},
						url:baseurl+"CateringTambahan/simpan",
						dataType: 'json',
						success: function(result){
							if(result[0] == 'invalid'){
								swal.close();
								swal.fire({
									title: 'Noind ' + result[1] + ' Sudah Dipesankan',
									text: '',
									type: 'warning'
								});
								window.location.reload();
							}else{
								swal.fire('Sukses Menambah Data Pesanan');
								window.location.reload();
							}
						}
					});
					return true;
				}
			});
		}
	}else {
		Swal.fire(
			'Peringatan!',
			'Data Harap di isi dengan Lengkap!',
			'warning'
		)
	}
}

function keterangan(a) {
	var seleksi = $('#ketnoind').val();
	var tamu	  = $('#TamuVendor').val();
	var lembur  = $('#noindpribadi').val();

	if(a == 1){
		if (seleksi != null) {
			var jumlah = $('#ketnoind').val().length;
		}else{
			var jumlah = $('#ketnoind').val();
		}
	}else if(a == 2){
		if (tamu != null) {
			var jumlah = $('#TamuVendor').val().length;
		}else {
			var jumlah = $('#TamuVendor').val();
		}
	}else if(a == 3){
		if (lembur != null) {
			var jumlah = $('#noindpribadi').val().length;
		}else {
			var jumlah = $('#noindpribadi').val();
		}
	}
	$('#total_pesanan').val(jumlah);
}

function listdatadetail(id)
{
	var kosong1 = $('#jml_plus_Tambahan_List').val();
	$.ajax({
		method: 'POST',
		url:baseurl+"CateringTambahan/Seksi/detailList",
		data:{id:id},
		dataType:'json',
		success: function(data){
			$('#id_Tambahan_List').val(data[0].id);
			$('#Shift_Tambahan_List').val(function() {
				if (data[0].shift_tambahan == 1 || data[0].shift_tambahan == 4) {
					return 'MAKAN SIANG';
				}else if (data[0].shift_tambahan == 2) {
					return 'MAKAN MALAM';
				}else {
					return 'MAKAN DINI HARI';
				}
			});
			$('#lokasi_kerja_Tambahan_List').val(function() {
				if (data[0].lokasi_kerja == 1) {
					return 'YOGYAKARTA (PUSAT)';
				}else if (data[0].lokasi_kerja == 2) {
					return 'TUKSONO';
				}
			});
			$('#tempat_makan_Tambahan_List').val(data[0].tempat_makan);
			$('#jml_plus_Tambahan_List').val(function(){
				if(data[0].tambahan == ''){
					return '-';
				}else{
					return data[0].tambahan;
				}
			});

			var ket_split = data[0].nama.split(",");
			if(ket_split.length < 2){
				$('#data_ket_list').html('<input class="form-control col-lg-7" name="ket1"  id="keterangan_List" value="'+ket_split+'"readonly style="width: 52%">');
			}else{
				var html = "";
				ket_split.forEach(function(item, index){
					html += '<div class="col-lg-5"></div> <input class="form-control col-lg-7"  align="right" name="ket1"  id="keterangan_List" value="'+item+'"readonly style="width: 52%"><br><br><br>';
				});
				$('#data_ket_list').html(html);
			}

			$('#Keperluan_List').val(data[0].keperluan);
			$('#pemesan_List').val(data[0].nama1);
			$('#siePesan_List').val(data[0].seksi);
			if (kosong1 == null) {
				$('#jml_plus_Tambahan_List').html("-");
			}
			if (data[0].status == 1) {
				$('#listcatering2').hide();
				$('#listcatering3').hide();
				$('#listcatering1').hide();
				$('#listcatering4').hide();

				$('#listcatering1').show();
			}else if (data[0].status == 2) {
				$('#listcatering2').hide();
				$('#listcatering3').hide();
				$('#listcatering1').hide();
				$('#listcatering4').hide();

				$('#listcatering2').show();
			}else if (data[0].status == 4) {
				$('#listcatering2').hide();
				$('#listcatering3').hide();
				$('#listcatering1').hide();
				$('#listcatering2').hide();

				$('#listcatering4').show();
			}else{
				$('#listcatering2').hide();
				$('#listcatering3').hide();
				$('#listcatering1').hide();
				$('#listcatering4').hide();

				$('#listcatering3').show();
			}
			$("#modal_ListPesanan-catering").modal();

		}
	})
}
//

//Approval tambahan
function detailcatering(id)
{
	var kosong1 = $('#modal-jml_plus_Tambahan').val();
	$.ajax({
		method: 'POST',
		url:baseurl+"ApprovalTambahan/Detail",
		data:{id:id},
		dataType:'json',
		success: function(data){
			$('#modal-id_Tambahan').val(data[0].id);
			$('#modal-Shift_Tambahan').attr('shift',data[0].shift_tambahan)
			$('#modal-Shift_Tambahan').val(function() {
				if (data[0].shift_tambahan == 1 || data[0].shift_tambahan == 4) {
					return 'MAKAN SIANG';
				}else if (data[0].shift_tambahan == 2) {
					return 'MAKAN MALAM';
				}else {
					return 'MAKAN DINI HARI';
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
			var ket_split1 = data[0].nama.split(",");
			if(ket_split1.length < 2){
				$('#data_keterangan_approv').html('<input class="form-control col-lg-7" name="ket"  id="modal-keterangan" value="'+ket_split1+'"readonly style="width: 52%">');
			}else{
				var html1 = "";
				ket_split1.forEach(function(item, index){
					html1 += '<div class="col-lg-5"></div> <input class="form-control col-lg-7" name="ket"  id="modal-keterangan" value="'+item+'"readonly style="width: 52%"><br><br><br>';
				});
				$('#data_keterangan_approv').html(html1);
			}
			$('#modal-Keperluan').val(data[0].keperluan);
			$('#modal-pemesan').val(data[0].user_ +' - '+ data[0].nama1);
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
	let shift = $('#modal-Shift_Tambahan').attr('shift');
	let loker = $('#modal-lokasi_kerja_Tambahan').val();
	let tmp_makan = $('#modal-tempat_makan_Tambahan').val();
	let plus = $("#modal-jml_plus_Tambahan").val();
	$.ajax({
		method: 'POST',
		url: baseurl+"ApprovalTambahan/Approval",
		data:{
			id:id,
			Shift_Tambahan: shift,
			lokasi_kerja: loker,
			tempat_makan: tmp_makan,
			plus:plus,
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


// start Hitung Pesanan
$(document).ready(function(){
	$('#CateringHitungPesananTanggal').datepicker({
	      "autoclose": true,
	      "todayHighlight": true,
	      "todayBtn": "linked",
	      "format":'yyyy-mm-dd'
	});

	$('#CateringHitungPesananForm').on('submit',function(e){
		tanggal = $('#CateringHitungPesananTanggal').val();
		shift 	= $('#CateringHitungPesananShift').val();
		lokasi 	= $('#CateringHitungPesananLokasi').val();
		if (tanggal && shift && lokasi) {
			$.ajax({
				method: 'POST',
				url: baseurl + 'CateringManagement/HitungPesanan/cekLihat',
				data: {tanggal: tanggal, shift: shift, lokasi: lokasi},
				error: function(xhr,status,error){
					e.preventDefault();
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					e.preventDefault();
					if (data != "done") {
						if (data == "Data Pesanan Belum Ada") {
							Swal.fire(
						     	'Data Pesanan Belum Ada',
						     	'Pastikan Sudah Dilakukan Refresh Pesanan',
						     	'warning'
					    	)
						}
						if (data == "Jadwal Katering Belum Ada") {
							Swal.fire(
						     	'Jadwal Katering Belum Ada',
						     	'Pastikan Jadwal Katering Sudah Disetting',
						     	'warning'
					    	)
						}
					}else{
						// lanjut submit
					}
				}
			})
		}else{
			e.preventDefault();
			Swal.fire(
		     	'Pengisian Belum Lengkap',
		     	'Pastikan Tanggal, Shift, dan Lokasi Kerja Terisi !',
		     	'warning'
	    	)
		}
	});

	$('#CateringHitungRefreshMakan').on('click',function(){
		tanggal = $('#CateringHitungPesananTanggal').val();
		shift 	= $('#CateringHitungPesananShift').val();
		lokasi 	= $('#CateringHitungPesananLokasi').val();
		if (tanggal && shift && lokasi) {
			cekPesananCatering(tanggal, shift, lokasi, "Makan", "NormalDate");
		}else{
			Swal.fire(
		     	'Pengisian Belum Lengkap',
		     	'Pastikan Tanggal, Shift, dan Lokasi Kerja Terisi !',
		     	'warning'
	    	)
		}
	});

	$('#CateringHitungRefreshMakanBackDate').on('click',function(){
		tanggal = $('#CateringHitungPesananTanggal').val();
		shift 	= $('#CateringHitungPesananShift').val();
		lokasi 	= $('#CateringHitungPesananLokasi').val();
		if (tanggal && shift && lokasi) {
			cekPesananCatering(tanggal, shift, lokasi, "Makan", "BackDate");
		}else{
			Swal.fire(
		     	'Pengisian Belum Lengkap',
		     	'Pastikan Tanggal, Shift, dan Lokasi Kerja Terisi !',
		     	'warning'
	    	)
		}
	});

	$('#CateringHitungRefreshSnack').on('click',function(){
		tanggal = $('#CateringHitungPesananTanggal').val();
		shift 	= $('#CateringHitungPesananShift').val();
		lokasi 	= $('#CateringHitungPesananLokasi').val();
		if (tanggal && shift && lokasi) {
			cekPesananCatering(tanggal, shift, lokasi, "Snack", "NormalDate");
		}else{
			Swal.fire(
		     	'Pengisian Belum Lengkap',
		     	'Pastikan Tanggal, Shift, dan Lokasi Kerja Terisi !',
		     	'warning'
	    	)
		}
	});

	$('#CateringHitungRefreshSnackBackDate').on('click',function(){
		tanggal = $('#CateringHitungPesananTanggal').val();
		shift 	= $('#CateringHitungPesananShift').val();
		lokasi 	= $('#CateringHitungPesananLokasi').val();
		if (tanggal && shift && lokasi) {
			cekPesananCatering(tanggal, shift, lokasi, "Snack", "BackDate");
		}else{
			Swal.fire(
		     	'Pengisian Belum Lengkap',
		     	'Pastikan Tanggal, Shift, dan Lokasi Kerja Terisi !',
		     	'warning'
	    	)
		}
	});
});

function cekPesananCatering(tanggal, shift, lokasi, jenis, keterangan){
	$('#CateringHitungLoading').show();
	if (keterangan == "BackDate") {
		link = baseurl + 'CateringManagement/HitungPesanan/cekPesananBackDate';
	}else{
		link = baseurl + 'CateringManagement/HitungPesanan/cekPesanan';
	}
	$.ajax({
		method: 'POST',
		url: link,
		data: {tanggal: tanggal, shift: shift, lokasi: lokasi, jenis: jenis},
		error: function(xhr,status,error){
			$('#CateringHitungLoading').hide();
			swal.fire({
                title: xhr['status'] + "(" + xhr['statusText'] + ")",
                html: xhr['responseText'],
                type: "error",
                confirmButtonText: 'OK',
                confirmButtonColor: '#d63031',
            })
		},
		success: function(data){
			var obj = JSON.parse(data);
			console.log(obj);
			if (obj.statusKatering == "ada" && obj.statusJadwal == "ada" && obj.statusBatasDatang == "ada" && obj.statusAbsenShift == "ada" && obj.statusUrutanJadwal == 'ada') {
				if (obj.statusPesanan == "ada") {
					$('#CateringHitungLoading').hide();
					swal.fire({
						title: 'Apakah Anda Yakin Ingin Refresh Ulang ?',
						text: "Data Mungkin Berubah Setelah Refresh",
						type: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Refresh',
						cancelButtonText: 'Tidak'
					}).then((result) => {
					 	if (!result.value) {
					    	Swal.fire(
						     	'Refresh Telah Dibatalkan',
						     	'Action Refresh Dibatalkan',
						     	'error'
					    	)
					 	}else{
					 		if (keterangan == "BackDate") {
						 		Swal.fire({
						 			title: "Masukkan Password ERP",
						 			input: 'password',
						 			inputPlaceholder: 'Masukkan Password ERP',
						 			inputAttributes: {
						 				autocorrect: 'off',
						 				autocapitalize: 'off'
						 			},
									showCancelButton: true,
									confirmButtonColor: '#3085d6',
									cancelButtonColor: '#d33',
									confirmButtonText: 'Refresh',
									cancelButtonText: 'Tidak'
						 		}).then((result) => {
						 			if (!result.value) {
						 				Swal.fire(
									     	'Refresh Telah Dibatalkan',
									     	'Action Refresh Dibatalkan',
									     	'error'
								    	)
						 			}else{
						 				var password = result.value;
						 				Swal.fire({
								 			title: "Masukkan Alasan Anda Melakukan Refresh BackDate",
								 			input: 'textarea',
								 			inputPlaceholder: 'Masukkan Alasan',
								 			inputAttributes: {
								 				autocorrect: 'off',
								 				autocapitalize: 'off'
								 			},
											showCancelButton: true,
											confirmButtonColor: '#3085d6',
											cancelButtonColor: '#d33',
											confirmButtonText: 'Refresh',
											cancelButtonText: 'Tidak'
								 		}).then((result) => {
								 			if (!result.value) {
								 				Swal.fire(
											     	'Refresh Telah Dibatalkan',
											     	'Action Refresh Dibatalkan',
											     	'error'
										    	)
								 			}else{
								 				var alasan = result.value;
										 		$('#CateringHitungLoading').show();
										 		hitungCatering(jenis, password, alasan);
								 				
								 			}
								 		})
						 			}
						 		})
					 		}else{
					 			$('#CateringHitungLoading').show();
								hitungCatering(jenis, "-", "-");
					 		}
					 	}
					})
				}else{
					if (keterangan == "BackDate") {
						$('#CateringHitungLoading').hide();
				 		Swal.fire({
				 			title: "Masukkan Password ERP",
				 			input: 'password',
				 			inputPlaceholder: 'Masukkan Password ERP',
				 			inputAttributes: {
				 				autocorrect: 'off',
				 				autocapitalize: 'off'
				 			},
							showCancelButton: true,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'Refresh',
							cancelButtonText: 'Tidak'
				 		}).then((result) => {
				 			if (!result.value) {
				 				Swal.fire(
							     	'Refresh Telah Dibatalkan',
							     	'Action Refresh Dibatalkan',
							     	'error'
						    	)
				 			}else{
				 				var password = result.value;
				 				Swal.fire({
						 			title: "Masukkan Alasan Anda Melakukan Refresh BackDate",
						 			input: 'textarea',
						 			inputPlaceholder: 'Masukkan Alasan',
						 			inputAttributes: {
						 				autocorrect: 'off',
						 				autocapitalize: 'off'
						 			},
									showCancelButton: true,
									confirmButtonColor: '#3085d6',
									cancelButtonColor: '#d33',
									confirmButtonText: 'Refresh',
									cancelButtonText: 'Tidak'
						 		}).then((result) => {
						 			if (!result.value) {
						 				Swal.fire(
									     	'Refresh Telah Dibatalkan',
									     	'Action Refresh Dibatalkan',
									     	'error'
								    	)
						 			}else{
						 				var alasan = result.value;
								 		$('#CateringHitungLoading').show();
								 		hitungCatering(jenis,password,alasan);
						 				
						 			}
						 		})
				 			}
				 		})
			 		}else{
						hitungCatering(jenis,"-","-");
			 		}
				}
			}else{
				$('#CateringHitungLoading').hide();
				if (obj.statusTanggal == "not ok") {
					if (keterangan == "BackDate") {
						Swal.fire(
					     	'Refresh Telah Dihentikan',
					     	'Tanggal Yang Dipilih Harus Lebih Kecil Dari Tanggal Hari Ini dan Maksimal 7 Hari yang Lalu',
					     	'error'
				    	)
					}else{
						Swal.fire(
					     	'Refresh Telah Dihentikan',
					     	'Tanggal Yang Dipilih Harus Sama Dengan Tanggal Hari Ini',
					     	'error'
				    	)
					}
				}else if (obj.statusKatering == "tidak ada") {
					Swal.fire(
				     	'Refresh Telah Dihentikan',
				     	'Tidak ada Katering yang berstatus AKTIF',
				     	'error'
			    	)
				}else if (obj.statusJadwal == "tidak ada") {
					Swal.fire(
				     	'Refresh Telah Dihentikan',
				     	'Belum ada Jadwal Katering',
				     	'error'
			    	)
				}else if (obj.statusBatasDatang == "tidak ada") {
					Swal.fire(
				     	'Refresh Telah Dihentikan',
				     	'Batas Jam Datang Belum Di Atur',
				     	'error'
			    	)
				}else if (obj.statusAbsenShift == "tidak ada") {
					Swal.fire(
				     	'Refresh Telah Dihentikan',
				     	'Data Absensi di shift yang anda pilih kosong',
				     	'error'
			    	)
				}else if (obj.statusUrutanJadwal == 'tidak ada') {
					Swal.fire(
				     	'Refresh Telah Dihentikan',
				     	'Data Katering di shift yang anda pilih kosong',
				     	'error'
			    	)
				}
			}
		}
	});
}

function hitungCatering(jenis, password, alasan){
	tanggal = $('#CateringHitungPesananTanggal').val();
	shift 	= $('#CateringHitungPesananShift').val();
	lokasi 	= $('#CateringHitungPesananLokasi').val();
	$.ajax({
		method: 'POST',
		url: baseurl + 'CateringManagement/HitungPesanan/prosesHitung',
		data: {tanggal: tanggal, shift: shift, lokasi: lokasi, jenis: jenis, password: password, alasan: alasan},
		error: function(xhr,status,error){
			$('#CateringHitungLoading').hide();
			swal.fire({
                title: xhr['status'] + "(" + xhr['statusText'] + ")",
                html: xhr['responseText'],
                type: "error",
                confirmButtonText: 'OK',
                confirmButtonColor: '#d63031',
            })
		},
		success: function(data){
			$('#CateringHitungLoading').hide();
			if (data == "selesai") {
				Swal.fire(
			     	'Berhasil',
			     	'Refresh Pesanan Selesai Dijalankan',
			     	'success'
				)
			}else{
				swal.fire({
	                title: "Proses Refresh Gagal !!",
	                html: data,
	                type: "error",
	                confirmButtonText: 'OK',
	                confirmButtonColor: '#d63031',
	            })
			}
		}
	})	
}

$(document).ready(function(){
	$('#txt-CM-HitungPesanan-CopyPembagian-Tanggal').datepicker({
	      "autoclose": true,
	      "todayHighlight": true,
	      "todayBtn": "linked",
	      "format":'yyyy-mm-dd'
	});

	$('#CateringHitungPesananLihatTabel').on('click','tbody tr',function(){
		var urutan = $(this).attr('data-urutan');
		var tempatMakan = $(this).attr('data-katering');
		if (urutan && tempatMakan) {
			$('#slcCateringHitungPesananUrutan').val(urutan);
			$('#slcCateringHitungPesananUrutan').change();
			$('#txtCateringHitungPesananTempatmakan').val(tempatMakan);
			$('#CateringHitungPesananLihatModal').modal('show');			
		}
	});

	$('#btnCateringHitungPesananSimpan').on('click',function(){
		var urutan = $('#slcCateringHitungPesananUrutan').val();
		var tempatMakan = $('#txtCateringHitungPesananTempatmakan').val();
		var tanggal = $('#txtCateringHitungPesananTanggal').val();
		var lokasi = $('#txtCateringHitungPesananLokasi').val();
		var shift = $('#txtCateringHitungPesananShift').val();

		if (urutan && tempatMakan) {
			$.ajax({
				method: 'POST',
				url: baseurl + 'CateringManagement/HitungPesanan/gantiUrutan',
				data: {tanggal: tanggal, shift: shift, lokasi: lokasi,tempat_makan: tempatMakan, urutan: urutan},
				error: function(xhr,status,error){
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					obj = JSON.parse(data);
					$('#CateringHitungPesananLihatModal').modal('hide');	
					if (data != "Tidak Ditemukan Data") {
						$('#CateringHitungPesananLihatTabel').html(obj['table']);						
						$('#CateringHitungPesananLihatJumlah').html(obj['katering']);	
					}else{
						window.location.href = baseurl+'CateringManagement/HitungPesanan';
					}
				}
			})			
		}
	});

	$('#btn-CM-HitungPesanan-CopyPembagian').on('click', function(){
		$('#mdl-CM-HitungPesanan-CopyPembagian').modal('show');
	})

	$('#btn-CM-HitungPesanan-CopyPembagian-Proses').on('click', function(){
		var tanggal = $('#txtCateringHitungPesananTanggal').val();
		var lokasi = $('#txtCateringHitungPesananLokasi').val();
		var shift = $('#txtCateringHitungPesananShift').val();
		var tanggalCopy = $('#txt-CM-HitungPesanan-CopyPembagian-Tanggal').val();

		if (tanggal && tanggalCopy) {
			$.ajax({
				method: 'POST',
				url: baseurl + 'CateringManagement/HitungPesanan/copyPembagian',
				data: {tanggal: tanggal, shift: shift, lokasi: lokasi, tanggal_copy: tanggalCopy},
				error: function(xhr,status,error){
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					obj = JSON.parse(data);
					$('#mdl-CM-HitungPesanan-CopyPembagian').modal('hide');	
					if (data != "Tidak Ditemukan Data") {
						$('#CateringHitungPesananLihatTabel').html(obj['table']);						
						$('#CateringHitungPesananLihatJumlah').html(obj['katering']);	
					}else{
						window.location.href = baseurl+'CateringManagement/HitungPesanan';
					}
				}
			})
		}
	})

	$('#btn-CM-HitungPesanan-SimpanMakan').on('click', function(){
		var tanggal = $('#txtCateringHitungPesananTanggal').val();
		var lokasi = $('#txtCateringHitungPesananLokasi').val();
		var shift = $('#txtCateringHitungPesananShift').val();

		if (tanggal) {
			$.ajax({
				method: 'POST',
				url: baseurl + 'CateringManagement/HitungPesanan/simpanHistory',
				data: {tanggal: tanggal, shift: shift, lokasi: lokasi, jenis: '1'},
				error: function(xhr,status,error){
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					if (data == 'success') {
						swal.fire('Sukses!',
							'Simpan Pembagian Makan Berhasil !',
							'success'
						)
					}else{
						swal.fire('Gagal!',
							'Simpan Pembagian Makan Gagal !',
							'error'
						)
					}
				}
			})
		}
	})

	$('#btn-CM-HitungPesanan-SimpanSnack').on('click', function(){
		var tanggal = $('#txtCateringHitungPesananTanggal').val();
		var lokasi = $('#txtCateringHitungPesananLokasi').val();
		var shift = $('#txtCateringHitungPesananShift').val();

		if (tanggal) {
			$.ajax({
				method: 'POST',
				url: baseurl + 'CateringManagement/HitungPesanan/simpanHistory',
				data: {tanggal: tanggal, shift: shift, lokasi: lokasi, jenis: '0'},
				error: function(xhr,status,error){
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					if (data == 'success') {
						swal.fire('Sukses!',
							'Simpan Pembagian Makan Sukses!',
							'success'
						)
					}else{
						swal.fire('Gagal!',
							'Simpan Pembagian Makan Gagal!',
							'error'
						)
					}
				}
			})
		}
	})

	$('#btn-CM-HitungPesanan-CetakMakan').on('click', function(){
		var tanggal = $('#txtCateringHitungPesananTanggal').val();
		var lokasi = $('#txtCateringHitungPesananLokasi').val();
		var shift = $('#txtCateringHitungPesananShift').val();

		if (tanggal) {
			$.ajax({
				method: 'POST',
				url: baseurl + 'CateringManagement/HitungPesanan/simpanHistory',
				data: {tanggal: tanggal, shift: shift, lokasi: lokasi, jenis: '0'},
				error: function(xhr,status,error){
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					if (data == 'success') {
						swal.fire('Sukses!',
							'Simpan Pembagian Makan Sukses!',
							'success'
						)
					}else{
						swal.fire('Gagal!',
							'Simpan Pembagian Makan Gagal!',
							'error'
						)
					}
					window.open(baseurl + 'CateringManagement/HitungPesanan/cetakHistory?tanggal=' + tanggal + '&lokasi=' + lokasi + '&shift=' + shift + '&jenis=1');
				}
			})
		}
	})

	$('#btn-CM-HitungPesanan-CetakSnack').on('click', function(){
		var tanggal = $('#txtCateringHitungPesananTanggal').val();
		var lokasi = $('#txtCateringHitungPesananLokasi').val();
		var shift = $('#txtCateringHitungPesananShift').val();

		if (tanggal) {
			$.ajax({
				method: 'POST',
				url: baseurl + 'CateringManagement/HitungPesanan/simpanHistory',
				data: {tanggal: tanggal, shift: shift, lokasi: lokasi, jenis: '0'},
				error: function(xhr,status,error){
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					if (data == 'success') {
						swal.fire('Sukses!',
							'Simpan Pembagian Makan Sukses!',
							'success'
						)
					}else{
						swal.fire('Gagal!',
							'Simpan Pembagian Makan Gagal!',
							'error'
						)
					}
					window.open(baseurl + 'CateringManagement/HitungPesanan/cetakHistory?tanggal=' + tanggal + '&lokasi=' + lokasi + '&shift=' + shift + '&jenis=0');
				}
			})
		}
	})

	$('#btn-CM-HitungPesanan-FormPesanan').on('click', function(){
		var tanggal = $('#txtCateringHitungPesananTanggal').val();
		var lokasi = $('#txtCateringHitungPesananLokasi').val();
		var shift = $('#txtCateringHitungPesananShift').val();

		if (tanggal) {
			window.open(baseurl + 'CateringManagement/HitungPesanan/cetakFormPesananMakan?tanggal=' + tanggal + '&lokasi=' + lokasi + '&shift=' + shift);
		}
	})
});
// end Hitung Pesanan
$(document).on('ready',function(){
	$('#tblMuslimTidakPuasa').dataTable();
	$('#tblNonMuslimPuasa').dataTable();
});

// start Pesanan Tambahan
$(document).on('ready', function(){
	$('#CateringTambahanLoading').hide();

	$('#txt-CM-Tambahan-Tanggal').datepicker({
		"autoclose": true,
		"todayHighlight": true,
		"todayBtn": "linked",
		"format":'yyyy-mm-dd'
	});

	var tblCMTambahanPenerima = $('#tbl-CM-Tambahan-Penerima-Table').DataTable({
		"paging" : false,
		"searching" : false,
		"scrollY" : '180px',
		"scrollCollapse" : true,
		"info" : false,
		"scrollX" : true
	});

	var tblCMTambahan = $('#tbl-CM-Tambahan-Table').DataTable({
		"scrollX" : true,
        "lengthMenu": [
            [ 5, 10, 25, 50, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "dom" : 'Bfrtip',
        "buttons" : [
            'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
        ],
	});

	$('.slc-CM-Tambahan-Pekerja').select2({
        searching: true,
        minimumInputLength: 3,
        allowClear: false,
        ajax: {
            url: baseurl + 'CateringManagement/Pesanan/Tambahan/searchActiveEmployees',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.noind, text: obj.noind + " - " + obj.nama };
                    })
                }
            }
        }
    });

	$('.slc-CM-Tambahan-Penerima').select2({
        searching: true,
        minimumInputLength: 3,
        allowClear: false,
        ajax: {
            url: baseurl + 'CateringManagement/Pesanan/Tambahan/getPenerima',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
                return {
                    term: params.term,
                    tempat_makan: $('#slc-CM-Tambahan-TempatMakan').val(),
                    kategori: $('#slc-CM-Tambahan-Kategori').val()
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.noind, text: obj.noind + " - " + obj.nama };
                    })
                }
            }
        }
    });

	$('#slc-CM-Tambahan-Kategori').on('change', function(){
		var kategori = $(this).val();

		if (kategori) {
			if (kategori == '1' || kategori == '2' || kategori == '3' || kategori == '4' || kategori == '5') {
				var trow = "<tr><td></td><td></td><td></td></tr>";

				$('#tbody-CM-Tambahan-Penerima-Table').html(trow + trow + trow + trow + trow);

				$('#opt-CM-Tambahan-Penerima').show();
				$('#opt-CM-Tambahan-Penerima-Table').show();
				
				$('#opt-CM-Tambahan-JumlahPesan').hide();
				$('#opt-CM-Tambahan-Pemohon').hide();
				$('#opt-CM-Tambahan-Keterangan').hide();
			}else if (kategori == '6' || kategori == '7') {
				$('#opt-CM-Tambahan-JumlahPesan').show();
				$('#opt-CM-Tambahan-Pemohon').show();
				$('#opt-CM-Tambahan-Keterangan').show();

				$('#opt-CM-Tambahan-Penerima').hide();
				$('#opt-CM-Tambahan-Penerima-Table').hide();
			}
		}else{
			$('#opt-CM-Tambahan-JumlahPesan').hide();
			$('#opt-CM-Tambahan-Pemohon').hide();
			$('#opt-CM-Tambahan-Keterangan').hide();

			$('#opt-CM-Tambahan-Penerima').hide();
			$('#opt-CM-Tambahan-Penerima-Table').hide();
		}
	});

	$('#slc-CM-Tambahan-Penerima').on('change', function(){
		$('#CateringTambahanLoading').show();
		var penerima_noind = $(this).val();
		var penerima_nama = $(this).text();
		var tanggal = $('#txt-CM-Tambahan-Tanggal').val();
		var shift = $('#slc-CM-Tambahan-Shift').val();
		if (penerima_noind) {
			penerima_nama = penerima_nama.replace(penerima_noind + " - ", "");
			var penerima_identik = 0;

			var data = tblCMTambahanPenerima.rows().data();

			for (var i = 0; i < data.length; i++) {
				if (data[i][0].substr(0,5) == penerima_noind) {
					penerima_identik += 1;
				}
			}
			var tambah = 0; 
			$.ajax({
				method: 'GET',
				url: baseurl + 'CateringManagement/Pesanan/Tambahan/getTambahanPengurangan',
				data: {tanggal: tanggal,shift: shift, noind: penerima_noind},
				error: function(xhr,status,error){
					$('#CateringTambahanLoading').hide();
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					obj = JSON.parse(data);
					if (obj.status == "ada") {
						$('#CateringTambahanLoading').hide();
						swal.fire({
			                title: "Terdapat Tambah/Kurang sebagai berikut. Apakah Anda yakin Ingin Menambahkan " + penerima_noind + ' ' + penerima_nama +" sebagai Penerima ?",
			                html: obj.data,
			                type: "warning",
			            	showCancelButton: true,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'Tambah',
							cancelButtonText: 'Batal'
			            }).then((result) => {
							if (result.value) {
								$('#CateringTambahanLoading').show();
								tambah = 1;
								tambahPenerimaCMTambahan(penerima_identik, penerima_noind, penerima_nama, tambah)
							}else{
								tambah = 0;
								tambahPenerimaCMTambahan(penerima_identik, penerima_noind, penerima_nama, tambah)
							}
						})		
					}else{
						tambah = 1;
						tambahPenerimaCMTambahan(penerima_identik, penerima_noind, penerima_nama, tambah)
					}
				}
			})	
		}
	});

	function tambahPenerimaCMTambahan(penerima_identik, penerima_noind, penerima_nama, tambah){
		if (penerima_identik == 0 && tambah == 1) {
			tblCMTambahanPenerima.row.add([
				penerima_noind + "<input type='hidden' name='txt-CM-Tambahan-Penerima-Noind[]' value='" + penerima_noind + "'>",
				penerima_nama,
				'<button type="button" class="btn btn-xs btn-danger"><span class="fa fa-trash"></span></button>'
			]).draw(false);
		}else{
			if (penerima_identik > 0) {
				swal.fire('Peringatan!',
					'Pekerja ' + penerima_noind + ' ' + penerima_nama + ' Sudah Ada di tabel penerima!',
					'warning'
				)
			}
			if(tambah == 0){
				swal.fire('Peringatan!',
					'tambah Pekerja ' + penerima_noind + ' ' + penerima_nama + ' dibatalkan!',
					'warning'
				)
			}
		}
		$('#slc-CM-Tambahan-Penerima').html("").change();
		$('#CateringTambahanLoading').hide();
	}

	$('#tbl-CM-Tambahan-Penerima-Table').on('click','tbody tr button', function(){
		var statusDisable = $('#slc-CM-Tambahan-Penerima').attr('disabled');
		
		if (statusDisable == false || statusDisable == undefined) {
			row = $(this).closest("tr").get(0);
			tblCMTambahanPenerima.row( row ).remove().draw();
		}
	});

	$('#txt-CM-Tambahan-Tanggal').on('change', function(){
		document.title = 'Pesanan Tambahan ' + $(this).val();
		$('#CateringTambahanLoading').show();
		$('#slc-CM-Tambahan-Kategori').val("").change();
		$('#slc-CM-Tambahan-Shift').val("").change();
		$('#slc-CM-Tambahan-TempatMakan').val("").change();
		$('#slc-CM-Tambahan-Urutan').val("").change();
		$('#slc-CM-Tambahan-Pemohon').val("").change();
		$('#slc-CM-Tambahan-Penerima').val("").change();
		$('#txt-CM-Tambahan-JumlahPesan').val("").change();
		$('#txt-CM-Tambahan-Keterangan').val("").change();

		$('#opt-CM-Tambahan-Penerima').hide();
		$('#opt-CM-Tambahan-Penerima-Table').hide();

		$('#txt-CM-Tambahan-Tanggal').attr('disabled',false);
		$('#slc-CM-Tambahan-Kategori').attr('disabled',true);
		$('#slc-CM-Tambahan-Shift').attr('disabled',true);
		$('#slc-CM-Tambahan-TempatMakan').attr('disabled',true);
		$('#slc-CM-Tambahan-Urutan').attr('disabled',true);
		$('#slc-CM-Tambahan-Pemohon').attr('disabled',true);
		$('#slc-CM-Tambahan-Penerima').attr('disabled',true);
		$('#txt-CM-Tambahan-JumlahPesan').attr('disabled',true);
		$('#txt-CM-Tambahan-Keterangan').attr('disabled',true);

		$('#btn-CM-Tambahan-Hapus').text('Hapus');
		$('#btn-CM-Tambahan-Tambah').text('Tambah');
		$('#btn-CM-Tambahan-Edit').attr('disabled',true);
		$('#btn-CM-Tambahan-Hapus').attr('disabled',true);

		tblCMTambahanPenerima.clear().draw();

		var tanggal = $(this).val();
		if (tanggal) {
			$.ajax({
				method: 'GET',
				url: baseurl + 'CateringManagement/Pesanan/Tambahan/getListTambahan',
				data: {tanggal: tanggal},
				error: function(xhr,status,error){
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					obj = JSON.parse(data);
					tblCMTambahan.clear().draw();
					obj.forEach(function(tambahan, index){
						tblCMTambahan.row.add([
							(index + 1),
							tambahan.fs_tempat_makan + "<input type='hidden' value='" + tambahan.id_tambahan + "'>",
							tambahan.shift,
							tambahan.fb_kategori,
							tambahan.fn_jumlah_pesanan,
							tambahan.fs_pemohon,
							tambahan.fs_keterangan,
							tambahan.list_pekerja
						]).draw(false);
					})
					tblCMTambahan.columns.adjust().draw();
				}
			})
		}
		$('#CateringTambahanLoading').hide();
	});

	$('#tbl-CM-Tambahan-Table').on('dblclick','td',function(){
		$('#CateringTambahanLoading').show();
		$('#txt-CM-Tambahan-Tanggal').attr('disabled',false);
		$('#slc-CM-Tambahan-Kategori').attr('disabled',true);
		$('#slc-CM-Tambahan-Shift').attr('disabled',true);
		$('#slc-CM-Tambahan-TempatMakan').attr('disabled',true);
		$('#slc-CM-Tambahan-Urutan').attr('disabled',true);
		$('#slc-CM-Tambahan-Pemohon').attr('disabled',true);
		$('#slc-CM-Tambahan-Penerima').attr('disabled',true);
		$('#txt-CM-Tambahan-JumlahPesan').attr('disabled',true);
		$('#txt-CM-Tambahan-Keterangan').attr('disabled',true);

		row = $(this).parents("tr").find('td');
		cell = row.text();

		var id_tambahan = $(this).parents("tr").find('input').val();
		
		if (cell !== 'No data available in table') {
			if (id_tambahan) {
				$.ajax({
					method: 'GET',
					url: baseurl + 'CateringManagement/Pesanan/Tambahan/getTambahanDetail',
					data: {id_tambahan: id_tambahan},
					error: function(xhr,status,error){
						swal.fire({
			                title: xhr['status'] + "(" + xhr['statusText'] + ")",
			                html: xhr['responseText'],
			                type: "error",
			                confirmButtonText: 'OK',
			                confirmButtonColor: '#d63031',
			            })
					},
					success: function(data){
						obj = JSON.parse(data);
						if (obj.status == 'success') {
							$('#txt-CM-Tambahan-Tanggal-Baru').val(obj.tambahan.fd_tanggal);
							$('#txt-CM-Tambahan-IdTambahan').val(obj.tambahan.id_tambahan);

							$('#slc-CM-Tambahan-Kategori').val(obj.tambahan.fb_kategori).change();
							$('#slc-CM-Tambahan-Shift').val(obj.tambahan.fs_kd_shift).change();
							$('#slc-CM-Tambahan-TempatMakan').val(obj.tambahan.fs_tempat_makan).change();
							$('#txt-CM-Tambahan-JumlahPesan').val(obj.tambahan.fn_jumlah_pesanan).change();
							$('#slc-CM-Tambahan-Pemohon').append("<option value='" + obj.tambahan.fs_pemohon + "' selected>" + obj.tambahan.fs_pemohon + " - " + obj.tambahan.nama_pemohon + "</option>").change();
							$('#txt-CM-Tambahan-Keterangan').val(obj.tambahan.fs_keterangan).change();

							if (obj.tambahan_detail.status == 'success') {
								tblCMTambahanPenerima.clear().draw();
								for (var i = 0; i < obj.tambahan_detail.tambahan_detail.length; i++) {
									tblCMTambahanPenerima.row.add([
										obj.tambahan_detail.tambahan_detail[i]['fs_noind'] + "<input type='hidden' name='txt-CM-Tambahan-Penerima-Noind[]' value='" + obj.tambahan_detail.tambahan_detail[i]['fs_noind'] + "'>",
										obj.tambahan_detail.tambahan_detail[i]['fs_nama'],
										'<button type="button" class="btn btn-xs btn-danger"><span class="fa fa-trash"></span></button>'
									]).draw(false);
								}
							}

							$('#btn-CM-Tambahan-Tambah').text('Tambah');
							$('#btn-CM-Tambahan-Edit').text('Edit');
							$('#btn-CM-Tambahan-Hapus').text('Hapus');

							$('#btn-CM-Tambahan-Edit').attr('disabled',false);
							$('#btn-CM-Tambahan-Hapus').attr('disabled',false);
						}
					}
				})
			}
		}
		$('#CateringTambahanLoading').hide();
	});

	$('#btn-CM-Tambahan-Edit').on('click', function(){
		$('#txt-CM-Tambahan-Tanggal').attr('disabled',true);
		
		$('#slc-CM-Tambahan-Pemohon').attr('disabled',false);
		$('#slc-CM-Tambahan-Penerima').attr('disabled',false);
		$('#txt-CM-Tambahan-JumlahPesan').attr('disabled',false);
		$('#txt-CM-Tambahan-Keterangan').attr('disabled',false);

		$('#btn-CM-Tambahan-Tambah').text('Simpan');
		$('#btn-CM-Tambahan-Hapus').text('Batal');
		$('#btn-CM-Tambahan-Edit').attr('disabled',true);
		$('#btn-CM-Tambahan-Hapus').attr('disabled',false);
	});

	$('#btn-CM-Tambahan-Tambah').on('click', function(){
		$('#CateringTambahanLoading').show();
		ButtonText = $(this).text();
		if (ButtonText == "Simpan") {

			var elem_tanggal = $('#txt-CM-Tambahan-Tanggal').val();
			var elem_tempatMakan = $('#slc-CM-Tambahan-TempatMakan').val();
			var elem_shift = $('#slc-CM-Tambahan-Shift').val();
			var elem_kategori = $('#slc-CM-Tambahan-Kategori').val();
			var elem_urutan = $('#slc-CM-Tambahan-Urutan').val();
			var elem_jumlah = $('#txt-CM-Tambahan-JumlahPesan').val();
			var elem_pemohon = $('#slc-CM-Tambahan-Pemohon').val();
			var elem_keterangan = $('#txt-CM-Tambahan-Keterangan').val();


			var stat_tanggal = 0;
			var stat_tempatMakan = 0;
			var stat_shift = 0;
			var stat_kategori = 0;
			var stat_urutan = 0;
			var stat_jumlah = 0;
			var stat_pemohon = 0;
			var stat_keterangan = 0;
			var stat_penerima = 0;

			if (elem_tanggal) {
				stat_tanggal = 1;
			}
			if (elem_tempatMakan) {
				stat_tempatMakan = 1;
			}
			if (elem_shift) {
				stat_shift = 1;
			}
			if (elem_kategori) {
				stat_kategori = 1;
				if (elem_kategori == "6" || elem_kategori == "7") {
					if (elem_jumlah) {
						stat_jumlah = 1;
					}
					if (elem_pemohon) {
						stat_pemohon = 1;
					}
					if (elem_keterangan) {
						stat_keterangan = 1;
					}

					stat_penerima = 1;
				}else{
					stat_jumlah = 1;
					stat_pemohon = 1;
					stat_keterangan = 1;

					if (!tblCMTambahanPenerima.data().count()) {
						stat_penerima = 0;
					}else{
						stat_penerima = 1;
					}
				}
			}
			if (elem_urutan) {
				stat_urutan = 1;
			}



			
			if (stat_tanggal == 1 && stat_tempatMakan == 1 && stat_shift == 1 && stat_kategori == 1 && stat_urutan == 1 && stat_jumlah == 1 && stat_pemohon == 1 && stat_keterangan == 1 && stat_penerima == 1) {
				var formData = $('#frm-CM-Tambahan-Form').serialize();
				
				$.ajax({
						method: 'POST',
						url: baseurl + 'CateringManagement/Pesanan/Tambahan/simpan',
						data: formData,
						error: function(xhr,status,error){
							swal.fire({
				                title: xhr['status'] + "(" + xhr['statusText'] + ")",
				                html: xhr['responseText'],
				                type: "error",
				                confirmButtonText: 'OK',
				                confirmButtonColor: '#d63031',
				            })
						},
						success: function(data){
							var obj = JSON.parse(data);
							if (obj && obj.status == 'sukses') {
								$('#slc-CM-Tambahan-Kategori').val("").change();
								$('#slc-CM-Tambahan-Shift').val("").change();
								$('#slc-CM-Tambahan-TempatMakan').val("").change();
								$('#slc-CM-Tambahan-Urutan').val("").change();
								$('#slc-CM-Tambahan-Pemohon').val("").change();
								$('#slc-CM-Tambahan-Penerima').val("").change();
								$('#txt-CM-Tambahan-JumlahPesan').val("").change();
								$('#txt-CM-Tambahan-Keterangan').val("").change();

								$('#txt-CM-Tambahan-Tanggal-Baru').val("");
								$('#txt-CM-Tambahan-IdTambahan').val("");

								$('#opt-CM-Tambahan-Penerima').hide();
								$('#opt-CM-Tambahan-Penerima-Table').hide();

								$('#txt-CM-Tambahan-Tanggal').attr('disabled',false);
								$('#slc-CM-Tambahan-Kategori').attr('disabled',true);
								$('#slc-CM-Tambahan-Shift').attr('disabled',true);
								$('#slc-CM-Tambahan-TempatMakan').attr('disabled',true);
								$('#slc-CM-Tambahan-Urutan').attr('disabled',true);
								$('#slc-CM-Tambahan-Pemohon').attr('disabled',true);
								$('#slc-CM-Tambahan-Penerima').attr('disabled',true);
								$('#txt-CM-Tambahan-JumlahPesan').attr('disabled',true);
								$('#txt-CM-Tambahan-Keterangan').attr('disabled',true);

								tblCMTambahanPenerima.clear().draw();

								$('#btn-CM-Tambahan-Tambah').text('Tambah');
								$('#btn-CM-Tambahan-Hapus').text('Hapus');
								$('#btn-CM-Tambahan-Edit').attr('disabled',true);
								$('#btn-CM-Tambahan-Hapus').attr('disabled',true);

								var tanggal = $('#txt-CM-Tambahan-Tanggal').val();
								if (tanggal) {
									$.ajax({
										method: 'GET',
										url: baseurl + 'CateringManagement/Pesanan/Tambahan/getListTambahan',
										data: {tanggal: tanggal},
										error: function(xhr,status,error){
											$('#CateringTambahanLoading').hide();
											swal.fire({
								                title: xhr['status'] + "(" + xhr['statusText'] + ")",
								                html: xhr['responseText'],
								                type: "error",
								                confirmButtonText: 'OK',
								                confirmButtonColor: '#d63031',
								            })
										},
										success: function(data){
											obj = JSON.parse(data);
											tblCMTambahan.clear().draw();
											obj.forEach(function(tambahan, index){
												tblCMTambahan.row.add([
													(index + 1),
													tambahan.fs_tempat_makan + "<input type='hidden' value='" + tambahan.id_tambahan + "'>",
													tambahan.shift,
													tambahan.fb_kategori,
													tambahan.fn_jumlah_pesanan,
													tambahan.fs_pemohon,
													tambahan.fs_keterangan,
													tambahan.list_pekerja
												]).draw(false);
											})
											tblCMTambahan.columns.adjust().draw();
										}
									})
								}
								$('#CateringTambahanLoading').hide();
								Swal.fire(
									'Disimpan!',
									'Data Sudah Disimpan.',
									'success'
								)
							}else{
								$('#CateringTambahanLoading').hide();
								Swal.fire(
									'Gagal Disimpan!',
									'Data Gagal Disimpan.',
									'error'
								)
							}
						}
					})
			}else{
				$('#CateringTambahanLoading').hide();
				swal.fire('Peringatan!',
					'Pastikan Form Terisi Semua !',
					'warning'
				)
			}
				
		}else{
			var tanggal = $('#txt-CM-Tambahan-Tanggal').val();
			
			if (tanggal) {
				tblCMTambahanPenerima.clear().draw();

				$('#slc-CM-Tambahan-Kategori').val("").change();
				$('#slc-CM-Tambahan-Shift').val("").change();
				$('#slc-CM-Tambahan-TempatMakan').val("").change();
				$('#slc-CM-Tambahan-Urutan').val("").change();
				$('#slc-CM-Tambahan-Pemohon').val("").change();
				$('#slc-CM-Tambahan-Penerima').val("").change();
				$('#txt-CM-Tambahan-JumlahPesan').val("").change();
				$('#txt-CM-Tambahan-Keterangan').val("").change();

				$('#txt-CM-Tambahan-Tanggal-Baru').val(tanggal);
				$('#txt-CM-Tambahan-IdTambahan').val("");

				$('#txt-CM-Tambahan-Tanggal').attr('disabled',true);
				$('#slc-CM-Tambahan-Kategori').attr('disabled',false);
				$('#slc-CM-Tambahan-Shift').attr('disabled',false);
				$('#slc-CM-Tambahan-TempatMakan').attr('disabled',false);
				$('#slc-CM-Tambahan-Urutan').attr('disabled',false);
				$('#slc-CM-Tambahan-Pemohon').attr('disabled',false);
				$('#slc-CM-Tambahan-Penerima').attr('disabled',false);
				$('#txt-CM-Tambahan-JumlahPesan').attr('disabled',false);
				$('#txt-CM-Tambahan-Keterangan').attr('disabled',false);

				$('#btn-CM-Tambahan-Tambah').text('Simpan');
				$('#btn-CM-Tambahan-Hapus').text('Batal');

				$('#btn-CM-Tambahan-Edit').attr('disabled',true);
				$('#btn-CM-Tambahan-Hapus').attr('disabled',false);
			}else{
				swal.fire('Peringatan!',
					'Tanggal Masih Kosong, Mohon Diisi Terlebih Dahulu !',
					'warning'
				)
			}
		}
		$('#CateringTambahanLoading').hide();
	});

	$('#btn-CM-Tambahan-Hapus').on('click', function(){
		ButtonText = $(this).text();
		if (ButtonText == "Hapus") {
			var id_tambahan = $('#txt-CM-Tambahan-IdTambahan').val();
			Swal.fire({
				title: 'Apakah Anda Yakin Menghapus Data Ini ?',
				text: "Data Yang Sudah Dihapus Tidak Dapat Dipulihkan",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Hapus',
				cancelButtonText: 'Batal'
			}).then((result) => {
				if (result.value) {
					$('#CateringTambahanLoading').show();
					$.ajax({
						method: 'POST',
						url: baseurl + 'CateringManagement/Pesanan/Tambahan/hapus',
						data: {id_tambahan: id_tambahan},
						error: function(xhr,status,error){
							swal.fire({
				                title: xhr['status'] + "(" + xhr['statusText'] + ")",
				                html: xhr['responseText'],
				                type: "error",
				                confirmButtonText: 'OK',
				                confirmButtonColor: '#d63031',
				            })
						},
						success: function(data){
							var obj = JSON.parse(data);
							if (obj && obj.status == 'sukses') {
								$('#slc-CM-Tambahan-Kategori').val("").change();
								$('#slc-CM-Tambahan-Shift').val("").change();
								$('#slc-CM-Tambahan-TempatMakan').val("").change();
								$('#slc-CM-Tambahan-Urutan').val("").change();
								$('#slc-CM-Tambahan-Pemohon').val("").change();
								$('#slc-CM-Tambahan-Penerima').val("").change();
								$('#txt-CM-Tambahan-JumlahPesan').val("").change();
								$('#txt-CM-Tambahan-Keterangan').val("").change();

								$('#txt-CM-Tambahan-Tanggal-Baru').val("");
								$('#txt-CM-Tambahan-IdTambahan').val("");

								$('#opt-CM-Tambahan-Penerima').hide();
								$('#opt-CM-Tambahan-Penerima-Table').hide();

								$('#txt-CM-Tambahan-Tanggal').attr('disabled',false);
								$('#slc-CM-Tambahan-Kategori').attr('disabled',true);
								$('#slc-CM-Tambahan-Shift').attr('disabled',true);
								$('#slc-CM-Tambahan-TempatMakan').attr('disabled',true);
								$('#slc-CM-Tambahan-Urutan').attr('disabled',true);
								$('#slc-CM-Tambahan-Pemohon').attr('disabled',true);
								$('#slc-CM-Tambahan-Penerima').attr('disabled',true);
								$('#txt-CM-Tambahan-JumlahPesan').attr('disabled',true);
								$('#txt-CM-Tambahan-Keterangan').attr('disabled',true);

								tblCMTambahanPenerima.clear().draw();

								$('#btn-CM-Tambahan-Tambah').text('Tambah');
								$('#btn-CM-Tambahan-Hapus').text('Hapus');
								$('#btn-CM-Tambahan-Edit').attr('disabled',true);
								$('#btn-CM-Tambahan-Hapus').attr('disabled',true);

								var tanggal = $('#txt-CM-Tambahan-Tanggal').val();
								if (tanggal) {
									$.ajax({
										method: 'GET',
										url: baseurl + 'CateringManagement/Pesanan/Tambahan/getListTambahan',
										data: {tanggal: tanggal},
										error: function(xhr,status,error){
											swal.fire({
								                title: xhr['status'] + "(" + xhr['statusText'] + ")",
								                html: xhr['responseText'],
								                type: "error",
								                confirmButtonText: 'OK',
								                confirmButtonColor: '#d63031',
								            })
										},
										success: function(data){
											obj = JSON.parse(data);
											tblCMTambahan.clear().draw();
											obj.forEach(function(tambahan, index){
												tblCMTambahan.row.add([
													(index + 1),
													tambahan.fs_tempat_makan + "<input type='hidden' value='" + tambahan.id_tambahan + "'>",
													tambahan.shift,
													tambahan.fb_kategori,
													tambahan.fn_jumlah_pesanan,
													tambahan.fs_pemohon,
													tambahan.fs_keterangan,
													tambahan.list_pekerja
												]).draw(false);
											})
											tblCMTambahan.columns.adjust().draw();
										}
									})
								}
								Swal.fire(
									'Dihapus!',
									'Data Sudah Dihapus.',
									'success'
								)
							}else{
								Swal.fire(
									'Gagal Dihapus!',
									'Data Gagal Dihapus.',
									'error'
								)
							}
						}
					})
				}
			})
		}else{
			$('#slc-CM-Tambahan-Kategori').val("").change();
			$('#slc-CM-Tambahan-Shift').val("").change();
			$('#slc-CM-Tambahan-TempatMakan').val("").change();
			$('#slc-CM-Tambahan-Urutan').val("").change();
			$('#slc-CM-Tambahan-Pemohon').val("").change();
			$('#slc-CM-Tambahan-Penerima').val("").change();
			$('#txt-CM-Tambahan-JumlahPesan').val("").change();
			$('#txt-CM-Tambahan-Keterangan').val("").change();

			$('#txt-CM-Tambahan-Tanggal-Baru').val("");
			$('#txt-CM-Tambahan-IdTambahan').val("");

			$('#opt-CM-Tambahan-Penerima').hide();
			$('#opt-CM-Tambahan-Penerima-Table').hide();

			$('#txt-CM-Tambahan-Tanggal').attr('disabled',false);
			$('#slc-CM-Tambahan-Kategori').attr('disabled',true);
			$('#slc-CM-Tambahan-Shift').attr('disabled',true);
			$('#slc-CM-Tambahan-TempatMakan').attr('disabled',true);
			$('#slc-CM-Tambahan-Urutan').attr('disabled',true);
			$('#slc-CM-Tambahan-Pemohon').attr('disabled',true);
			$('#slc-CM-Tambahan-Penerima').attr('disabled',true);
			$('#txt-CM-Tambahan-JumlahPesan').attr('disabled',true);
			$('#txt-CM-Tambahan-Keterangan').attr('disabled',true);

			tblCMTambahanPenerima.clear().draw();			

			$('#btn-CM-Tambahan-Tambah').text('Tambah');
			$('#btn-CM-Tambahan-Hapus').text('Hapus');
			$('#btn-CM-Tambahan-Edit').attr('disabled',true);
			$('#btn-CM-Tambahan-Hapus').attr('disabled',true);
		}
		$('#CateringTambahanLoading').hide();
	});

	$('#txt-CM-Tambahan-Tanggal, #slc-CM-Tambahan-TempatMakan, #slc-CM-Tambahan-Shift').on('change', function(){
		$('#CateringTambahanLoading').show();
		tanggal = $('#txt-CM-Tambahan-Tanggal').val();
		tempatMakan = $('#slc-CM-Tambahan-TempatMakan').val();
		shift = $('#slc-CM-Tambahan-Shift').val();
		
		if (tanggal && tempatMakan && shift) {
			$.ajax({
				method: 'GET',
				url: baseurl + 'CateringManagement/Pesanan/Tambahan/getUrutan',
				data: {tanggal: tanggal, tempat_makan: tempatMakan, shift: shift},
				error: function(xhr,status,error){
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					obj = JSON.parse(data);
					if (obj.status == 'success') {
						// $('#slc-CM-Tambahan-Urutan').val(obj.urutan).change();
						$('#slc-CM-Tambahan-Urutan').append("<option value='" + obj.urutan + "' selected>" + obj.urutan + "</option>").change();
					}
				}
			})
		}
		$('#CateringTambahanLoading').hide();
	});
});
// end Pesanan Tambahan

// start Pengurangan Pesanan
$(document).on('ready', function(){
	$('#CateringPenguranganLoading').hide();

	$('#txt-CM-Pengurangan-Tanggal').datepicker({
		"autoclose": true,
		"todayHighlight": true,
		"todayBtn": "linked",
		"format":'yyyy-mm-dd'
	});

	var tblCMPenguranganPenerima = $('#tbl-CM-Pengurangan-Penerima-Table').DataTable({
		"paging" : false,
		"searching" : false,
		"scrollY" : '180px',
		"scrollCollapse" : true,
		"info" : false,
		"scrollX" : true
	});

	var tblCMPengurangan = $('#tbl-CM-Pengurangan-Table').DataTable({
        "lengthMenu": [
            [ 5, 10, 25, 50, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "dom" : 'Bfrtip',
        "buttons" : [
            'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
        ],
	});

	$('.slc-CM-Pengurangan-Penerima').select2({
        searching: true,
        minimumInputLength: 3,
        allowClear: false,
        ajax: {
            url: baseurl + 'CateringManagement/Pesanan/Pengurangan/getPenerima',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
                return {
                    term: params.term,
                    tempat_makan: $('#slc-CM-Pengurangan-TempatMakan').val()
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.noind, text: obj.noind + " - " + obj.nama };
                    })
                }
            }
        }
    });

	$('.slc-CM-Pengurangan-TempatMakanBaru').select2({
        searching: true,
        minimumInputLength: 3,
        allowClear: false,
        ajax: {
            url: baseurl + 'CateringManagement/Pesanan/Pengurangan/getTempatMakanBaru',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
                return {
                    term: params.term,
                    tempat_makan: $('#slc-CM-Pengurangan-TempatMakan').val(),
                    kategori: $('#slc-CM-Pengurangan-Kategori').val()
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.fs_tempat_makan, text: obj.fs_tempat_makan + " - " + obj.lokasi };
                    })
                }
            }
        }
    });

	$('#slc-CM-Pengurangan-Kategori').on('change', function(){
		var kategori = $(this).val();

		if (kategori) {
			if (kategori == '2' || kategori == '3' || kategori == '4' || kategori == '5' || kategori == '6') {
				$('#opt-CM-Pengurangan-TempatMakanBaru').show();				
			}else{
				$('#opt-CM-Pengurangan-TempatMakanBaru').hide();
			}
			var trow = "<tr><td></td><td></td><td></td></tr>";
			$('#tbody-CM-Pengurangan-Penerima-Table').html(trow + trow + trow + trow + trow);

			$('#opt-CM-Pengurangan-Penerima').show();
			$('#opt-CM-Pengurangan-Penerima-Table').show();
		}else{
			$('#opt-CM-Pengurangan-Penerima').hide();
			$('#opt-CM-Pengurangan-Penerima-Table').hide();
		}
	});

	$('#slc-CM-Pengurangan-Penerima').on('change', function(){
		$('#CateringPenguranganLoading').show();
		var penerima_noind = $(this).val();
		var penerima_nama = $(this).text();
		var tanggal = $('#txt-CM-Pengurangan-Tanggal').val();
		var shift = $('#slc-CM-Pengurangan-Shift').val();
		if (penerima_noind) {
			penerima_nama = penerima_nama.replace(penerima_noind + " - ", "");

			var penerima_identik = 0;

			var data = tblCMPenguranganPenerima.rows().data();

			for (var i = 0; i < data.length; i++) {
				if (data[i][0].substr(0,5) == penerima_noind) {
					penerima_identik += 1;
				}
			}
			var tambah = 0; 
			$.ajax({
				method: 'GET',
				url: baseurl + 'CateringManagement/Pesanan/Pengurangan/getTambahanPengurangan',
				data: {tanggal: tanggal,shift: shift, noind: penerima_noind},
				error: function(xhr,status,error){
					$('#CateringPenguranganLoading').hide();
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					obj = JSON.parse(data);
					if (obj.status == "ada") {
						$('#CateringPenguranganLoading').hide();
						swal.fire({
			                title: "Terdapat Tambah/Kurang sebagai berikut. Apakah Anda yakin Ingin Menambahkan " + penerima_noind + ' ' + penerima_nama +" sebagai Penerima ?",
			                html: obj.data,
			                type: "warning",
			            	showCancelButton: true,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'Tambah',
							cancelButtonText: 'Batal'
			            }).then((result) => {
							if (result.value) {
								$('#CateringPenguranganLoading').show();
								tambah = 1;
								tambahPenerimaCMPengurangan(penerima_identik, penerima_noind, penerima_nama, tambah)
							}else{
								tambah = 0;
								tambahPenerimaCMPengurangan(penerima_identik, penerima_noind, penerima_nama, tambah)
							}
						})		
					}else{
						tambah = 1;
						tambahPenerimaCMPengurangan(penerima_identik, penerima_noind, penerima_nama, tambah)
					}
				}
			})	
			
		}else{
			$('#CateringPenguranganLoading').hide();
		}
	});

	function tambahPenerimaCMPengurangan(penerima_identik, penerima_noind, penerima_nama, tambah){
		if (penerima_identik == 0 && tambah == 1) {
			tblCMPenguranganPenerima.row.add([
				penerima_noind + "<input type='hidden' name='txt-CM-Pengurangan-Penerima-Noind[]' value='" + penerima_noind + "'>",
				penerima_nama,
				'<button type="button" class="btn btn-xs btn-danger"><span class="fa fa-trash"></span></button>'
			]).draw(false);
		}else{
			if (penerima_identik > 0) {
				swal.fire('Peringatan!',
					'Pekerja ' + penerima_noind + ' ' + penerima_nama + ' Sudah Ada di tabel penerima!',
					'warning'
				)
			}
			if(tambah == 0){
				swal.fire('Peringatan!',
					'tambah Pekerja ' + penerima_noind + ' ' + penerima_nama + ' dibatalkan!',
					'warning'
				)
			}
		}		
		
		$('#slc-CM-Pengurangan-Penerima').html("").change();
		$('#CateringPenguranganLoading').hide();
	}

	$('#tbl-CM-Pengurangan-Penerima-Table').on('click','tbody tr button', function(){
		var statusDisable = $('#slc-CM-Pengurangan-Penerima').attr('disabled');
		if (status == false || status == undefined) {
			row = $(this).closest("tr").get(0);
			tblCMPenguranganPenerima.row( row ).remove().draw();
		}
	});

	$('#txt-CM-Pengurangan-Tanggal').on('change', function(){
		document.title = 'Pengurangan Pesanan ' + $(this).val();
		$('#CateringPenguranganLoading').show();
		$('#slc-CM-Pengurangan-Kategori').val("").change();
		$('#slc-CM-Pengurangan-Shift').val("").change();
		$('#slc-CM-Pengurangan-TempatMakan').val("").change();
		$('#slc-CM-Pengurangan-TempatMakanBaru').val("").change();
		$('#slc-CM-Pengurangan-Penerima').val("").change();

		$('#opt-CM-Pengurangan-TempatMakanBaru').hide();
		$('#opt-CM-Pengurangan-Penerima').hide();
		$('#opt-CM-Pengurangan-Penerima-Table').hide();

		$('#txt-CM-Pengurangan-Tanggal').attr('disabled',false);
		$('#slc-CM-Pengurangan-Kategori').attr('disabled',true);
		$('#slc-CM-Pengurangan-Shift').attr('disabled',true);
		$('#slc-CM-Pengurangan-TempatMakan').attr('disabled',true);
		$('#slc-CM-Pengurangan-TempatMakanBaru').attr('disabled',true);
		$('#slc-CM-Pengurangan-Penerima').attr('disabled',true);

		$('#btn-CM-Pengurangan-Tambah').text('Tambah');
		$('#btn-CM-Pengurangan-Hapus').text('Hapus');
		$('#btn-CM-Pengurangan-Edit').attr('disabled',true);
		$('#btn-CM-Pengurangan-Hapus').attr('disabled',true);

		tblCMPenguranganPenerima.clear().draw();

		var tanggal = $(this).val();
		if (tanggal) {
			$.ajax({
				method: 'GET',
				url: baseurl + 'CateringManagement/Pesanan/Pengurangan/getListPengurangan',
				data: {tanggal: tanggal},
				error: function(xhr,status,error){
					$('#CateringPenguranganLoading').hide();
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					obj = JSON.parse(data);
					tblCMPengurangan.clear().draw();
					obj.forEach(function(pengurangan, index){
						tblCMPengurangan.row.add([
							(index + 1),
							pengurangan.fs_tempat_makan + "<input type='hidden' value='" + pengurangan.id_pengurangan + "'>",
							pengurangan.shift,
							pengurangan.fb_kategori,
							pengurangan.fs_tempat_makanpg,
							pengurangan.fn_jml_tdkpesan,
							pengurangan.list_pekerja
						]).draw(false);
					})
					$('#CateringPenguranganLoading').hide();
					tblCMPengurangan.columns.adjust().draw();
				}
			})
		}
	});

	$('#tbl-CM-Pengurangan-Table').on('dblclick','td',function(){
		$('#CateringPenguranganLoading').show();
		$('#btn-CM-Pengurangan-Tambah').attr('disabled',false);
		$('#txt-CM-Pengurangan-Tanggal').attr('disabled',false);
		$('#slc-CM-Pengurangan-Kategori').attr('disabled',true);
		$('#slc-CM-Pengurangan-Shift').attr('disabled',true);
		$('#slc-CM-Pengurangan-TempatMakan').attr('disabled',true);
		$('#slc-CM-Pengurangan-TempatMakanBaru').attr('disabled',true);
		$('#slc-CM-Pengurangan-Penerima').attr('disabled',true);

		row = $(this).parents("tr").find('td');
		cell = row.text();

		var id_pengurangan = $(this).parents("tr").find('input').val();

		if (cell !== 'No data available in table') {
			tempatMakan = row[1].innerText;
			shift = row[2].innerText;
			status = row[3].innerText;
			tempatMakanBaru = row[4].innerText;
			jumlah = row[5].innerText;
			tanggal = $('#txt-CM-Pengurangan-Tanggal').val();
			$.ajax({
				method: 'GET',
				url: baseurl + 'CateringManagement/Pesanan/Pengurangan/getPenguranganDetail',
				data: {id_pengurangan: id_pengurangan},
				error: function(xhr,status,error){
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					obj = JSON.parse(data);
					if (obj.status == 'success') {
						$('#txt-CM-Pengurangan-Tanggal-Baru').val(obj.pengurangan.fd_tanggal);
						$('#txt-CM-Pengurangan-IdPengurangan').val(obj.pengurangan.id_pengurangan);

						$('#slc-CM-Pengurangan-Kategori').val(obj.pengurangan.fb_kategori).change();
						$('#slc-CM-Pengurangan-Shift').val(obj.pengurangan.fs_kd_shift).change();
						$('#slc-CM-Pengurangan-TempatMakan').val(obj.pengurangan.fs_tempat_makan).change();
						$('#slc-CM-Pengurangan-TempatMakanBaru').html("<option value='" + obj.pengurangan.fs_tempat_makanpg + "' >" + obj.pengurangan.fs_tempat_makanpg + " - " + obj.pengurangan.lokasipg + "</option>");
						$('#slc-CM-Pengurangan-TempatMakanBaru').val(obj.pengurangan.fs_tempat_makanpg).change();

						tblCMPenguranganPenerima.clear().draw();
						for (var i = 0; i < obj.pengurangan_detail.pengurangan_detail.length; i++) {
							tblCMPenguranganPenerima.row.add([
								obj.pengurangan_detail.pengurangan_detail[i]['fs_noind'] + "<input type='hidden' name='txt-CM-Pengurangan-Penerima-Noind[]' value='" + obj.pengurangan_detail.pengurangan_detail[i]['fs_noind'] + "'>",
								obj.pengurangan_detail.pengurangan_detail[i]['fs_nama'],
								'<button type="button" class="btn btn-xs btn-danger"><span class="fa fa-trash"></span></button>'
							]).draw(false);
							// tblCMPenguranganPenerima.scroller.measure().draw();
							tblCMPenguranganPenerima.columns.adjust().draw();
						}
						

						$('#btn-CM-Pengurangan-Tambah').text('Tambah');
						$('#btn-CM-Pengurangan-Edit').text('Edit');
						$('#btn-CM-Pengurangan-Hapus').text('Hapus');

						$('#btn-CM-Pengurangan-Edit').attr('disabled',false);
						$('#btn-CM-Pengurangan-Hapus').attr('disabled',false);
					}
				}
			})
		}
		$('#CateringPenguranganLoading').hide();
	});

	$('#btn-CM-Pengurangan-Edit').on('click', function(){
		$('#txt-CM-Pengurangan-Tanggal').attr('disabled',true);
		$('#slc-CM-Pengurangan-Kategori').attr('disabled',true);
		$('#slc-CM-Pengurangan-Shift').attr('disabled',true);
		$('#slc-CM-Pengurangan-TempatMakan').attr('disabled',true);
		$('#slc-CM-Pengurangan-TempatMakanBaru').attr('disabled',true);
		$('#slc-CM-Pengurangan-Penerima').attr('disabled',false);

		$('#btn-CM-Pengurangan-Tambah').text('Simpan');
		$('#btn-CM-Pengurangan-Hapus').text('Batal');
		$('#btn-CM-Pengurangan-Edit').attr('disabled',true);
		$('#btn-CM-Pengurangan-Hapus').attr('disabled',false);
	});

	$('#btn-CM-Pengurangan-Tambah').on('click', function(){
		$('#CateringPenguranganLoading').show();
		ButtonText = $(this).text();
		if (ButtonText == "Simpan") {
			
			var elem_tanggal = $('#txt-CM-Pengurangan-Tanggal').val();
			var elem_tempatMakan = $('#slc-CM-Pengurangan-TempatMakan').val();
			var elem_shift = $('#slc-CM-Pengurangan-Shift').val();
			var elem_kategori = $('#slc-CM-Pengurangan-Kategori').val();
			var elem_tempatMakanBaru = $('#slc-CM-Pengurangan-TempatMakanBaru').val();

			var stat_tanggal = 0;
			var stat_tempatMakan = 0;
			var stat_shift = 0;
			var stat_kategori = 0;
			var stat_tempatMakanBaru = 0;
			var stat_penerima = 0;

			if (elem_tanggal) {
				stat_tanggal = 1;
			}else{
				stat_tanggal = 0;
			}
			if (elem_tempatMakan) {
				stat_tempatMakan = 1;
			}else{
				stat_tempatMakan = 0;
			}
			if (elem_shift) {
				stat_shift = 1;
			}else{
				stat_shift = 0;
			}
			if (elem_kategori) {
				stat_kategori = 1;
				if (elem_kategori == "2" || elem_kategori == "3" || elem_kategori == "4" || elem_kategori == "5") {
					if (elem_tempatMakanBaru) {
						stat_tempatMakanBaru = 1;
					}else{
						stat_tempatMakanBaru = 0;
					}
				}else{
					stat_tempatMakanBaru = 1;
				}
			}else{
				stat_kategori = 0;
			}

			if (tblCMPenguranganPenerima.data().count() > 0) {
				stat_penerima = 1;
			}else{
				stat_penerima = 0;
			}
			
			if (stat_tanggal == 1 && stat_tempatMakan == 1 && stat_shift == 1 && stat_kategori == 1 && stat_tempatMakanBaru == 1 && stat_penerima == 1) {
				var formData = $('#frm-CM-Pengurangan-Form').serialize();
				
				$.ajax({
						method: 'POST',
						url: baseurl + 'CateringManagement/Pesanan/Pengurangan/simpan',
						data: formData,
						error: function(xhr,status,error){
							$('#CateringPenguranganLoading').hide();
							swal.fire({
				                title: xhr['status'] + "(" + xhr['statusText'] + ")",
				                html: xhr['responseText'],
				                type: "error",
				                confirmButtonText: 'OK',
				                confirmButtonColor: '#d63031',
				            })
						},
						success: function(data){
							var obj = JSON.parse(data);
							if (obj && obj.status == 'sukses') {
								$('#slc-CM-Pengurangan-Kategori').val("").change();
								$('#slc-CM-Pengurangan-Shift').val("").change();
								$('#slc-CM-Pengurangan-TempatMakan').val("").change();
								$('#slc-CM-Pengurangan-TempatMakanBaru').val("").change();
								$('#slc-CM-Pengurangan-Penerima').val("").change();

								$('#opt-CM-Pengurangan-TempatMakanBaru').hide();
								$('#opt-CM-Pengurangan-Penerima').hide();
								$('#opt-CM-Pengurangan-Penerima-Table').hide();

								$('#txt-CM-Pengurangan-Tanggal').attr('disabled',false);
								$('#slc-CM-Pengurangan-Kategori').attr('disabled',true);
								$('#slc-CM-Pengurangan-Shift').attr('disabled',true);
								$('#slc-CM-Pengurangan-TempatMakan').attr('disabled',true);
								$('#slc-CM-Pengurangan-TempatMakanBaru').attr('disabled',true);
								$('#slc-CM-Pengurangan-Penerima').attr('disabled',true);

								$('#btn-CM-Pengurangan-Tambah').text('Tambah');
								$('#btn-CM-Pengurangan-Hapus').text('Hapus');
								$('#btn-CM-Pengurangan-Edit').attr('disabled',true);
								$('#btn-CM-Pengurangan-Hapus').attr('disabled',true);

								tblCMPenguranganPenerima.clear().draw();

								var tanggal = $('#txt-CM-Pengurangan-Tanggal').val();
								if (tanggal) {
									$.ajax({
										method: 'GET',
										url: baseurl + 'CateringManagement/Pesanan/Pengurangan/getListPengurangan',
										data: {tanggal: tanggal},
										error: function(xhr,status,error){
											swal.fire({
								                title: xhr['status'] + "(" + xhr['statusText'] + ")",
								                html: xhr['responseText'],
								                type: "error",
								                confirmButtonText: 'OK',
								                confirmButtonColor: '#d63031',
								            })
										},
										success: function(data){
											obj = JSON.parse(data);
											tblCMPengurangan.clear().draw();
											obj.forEach(function(pengurangan, index){
												tblCMPengurangan.row.add([
													(index + 1),
													pengurangan.fs_tempat_makan + "<input type='hidden' value='" + pengurangan.id_pengurangan + "'>",
													pengurangan.shift,
													pengurangan.fb_kategori,
													pengurangan.fs_tempat_makanpg,
													pengurangan.fn_jml_tdkpesan,
													pengurangan.list_pekerja
												]).draw(false);
											})
											tblCMPengurangan.columns.adjust().draw();
										}
									})
								}
								$('#CateringPenguranganLoading').hide();
								Swal.fire(
									'Disimpan!',
									'Data Sudah Disimpan.',
									'success'
								)
							}else{
								$('#CateringPenguranganLoading').hide();
								Swal.fire(
									'Gagal Disimpan!',
									'Data Gagal Disimpan.',
									'error'
								)
							}
						}
					})
			}else{
				swal.fire('Peringatan!',
					'Pastikan Form Terisi Semua !',
					'warning'
				)
				$('#CateringPenguranganLoading').hide();
			}
		}else{
			tanggal = $('#txt-CM-Pengurangan-Tanggal').val();
			if (tanggal) {
				$('#txt-CM-Pengurangan-Tanggal-Baru').val(tanggal);

				$('#slc-CM-Pengurangan-Kategori').val("").change();
				$('#slc-CM-Pengurangan-Shift').val("").change();
				$('#slc-CM-Pengurangan-TempatMakan').val("").change();
				$('#slc-CM-Pengurangan-TempatMakanBaru').val("").change();
				$('#slc-CM-Pengurangan-Penerima').val("").change();

				$('#txt-CM-Pengurangan-Tanggal').attr('disabled',true);
				$('#slc-CM-Pengurangan-Kategori').attr('disabled',false);
				$('#slc-CM-Pengurangan-Shift').attr('disabled',false);
				$('#slc-CM-Pengurangan-TempatMakan').attr('disabled',false);
				$('#slc-CM-Pengurangan-TempatMakanBaru').attr('disabled',false);
				$('#slc-CM-Pengurangan-Penerima').attr('disabled',false);

				$('#btn-CM-Pengurangan-Tambah').text('Simpan');
				$('#btn-CM-Pengurangan-Hapus').text('Batal');

				tblCMPenguranganPenerima.clear().draw();			

				$('#btn-CM-Pengurangan-Edit').attr('disabled',true);
				$('#btn-CM-Pengurangan-Hapus').attr('disabled',false);
			}else{
				swal.fire('Peringatan!',
					'Tanggal Masih Kosong, Mohon Diisi Terlebih Dahulu !',
					'warning'
				)
			}
			$('#CateringPenguranganLoading').hide();
		}
	});

	$('#btn-CM-Pengurangan-Hapus').on('click', function(){
		ButtonText = $(this).text();
		if (ButtonText == "Hapus") {
			var id_pengurangan = $('#txt-CM-Pengurangan-IdPengurangan').val();
			Swal.fire({
				title: 'Apakah Anda Yakin Menghapus Data Ini ?',
				text: "Data Yang Sudah Dihapus Tidak Dapat Dipulihkan",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Hapus',
				cancelButtonText: 'Batal'
			}).then((result) => {
				if (result.value) {
					$('#CateringPenguranganLoading').show();
					$.ajax({
						method: 'POST',
						url: baseurl + 'CateringManagement/Pesanan/Pengurangan/hapus',
						data: {id_pengurangan: id_pengurangan},
						error: function(xhr,status,error){
							$('#CateringPenguranganLoading').hide();
							swal.fire({
				                title: xhr['status'] + "(" + xhr['statusText'] + ")",
				                html: xhr['responseText'],
				                type: "error",
				                confirmButtonText: 'OK',
				                confirmButtonColor: '#d63031',
				            })
						},
						success: function(data){
							var obj = JSON.parse(data);
							if (obj && obj.status == 'sukses') {
								$('#slc-CM-Pengurangan-Kategori').val("").change();
								$('#slc-CM-Pengurangan-Shift').val("").change();
								$('#slc-CM-Pengurangan-TempatMakan').val("").change();
								$('#slc-CM-Pengurangan-TempatMakanBaru').val("").change();
								$('#slc-CM-Pengurangan-Penerima').val("").change();

								$('#opt-CM-Pengurangan-TempatMakanBaru').hide();
								$('#opt-CM-Pengurangan-Penerima').hide();
								$('#opt-CM-Pengurangan-Penerima-Table').hide();

								$('#txt-CM-Pengurangan-Tanggal').attr('disabled',false);
								$('#slc-CM-Pengurangan-Kategori').attr('disabled',true);
								$('#slc-CM-Pengurangan-Shift').attr('disabled',true);
								$('#slc-CM-Pengurangan-TempatMakan').attr('disabled',true);
								$('#slc-CM-Pengurangan-TempatMakanBaru').attr('disabled',true);
								$('#slc-CM-Pengurangan-Penerima').attr('disabled',true);

								$('#btn-CM-Pengurangan-Tambah').text('Tambah');
								$('#btn-CM-Pengurangan-Hapus').text('Hapus');
								$('#btn-CM-Pengurangan-Edit').attr('disabled',true);
								$('#btn-CM-Pengurangan-Hapus').attr('disabled',true);

								tblCMPenguranganPenerima.clear().draw();

								var tanggal = $('#txt-CM-Pengurangan-Tanggal').val();
								if (tanggal) {
									$.ajax({
										method: 'GET',
										url: baseurl + 'CateringManagement/Pesanan/Pengurangan/getListPengurangan',
										data: {tanggal: tanggal},
										error: function(xhr,status,error){
											swal.fire({
								                title: xhr['status'] + "(" + xhr['statusText'] + ")",
								                html: xhr['responseText'],
								                type: "error",
								                confirmButtonText: 'OK',
								                confirmButtonColor: '#d63031',
								            })
										},
										success: function(data){
											obj = JSON.parse(data);
											tblCMPengurangan.clear().draw();
											obj.forEach(function(pengurangan, index){
												tblCMPengurangan.row.add([
													(index + 1),
													pengurangan.fs_tempat_makan + "<input type='hidden' value='" + pengurangan.id_pengurangan + "'>",
													pengurangan.shift,
													pengurangan.fb_kategori,
													pengurangan.fs_tempat_makanpg,
													pengurangan.fn_jml_tdkpesan,
													pengurangan.list_pekerja
												]).draw(false);
											})
											tblCMPengurangan.columns.adjust().draw();
										}
									})
								}
								$('#CateringPenguranganLoading').hide();
								Swal.fire(
									'Dihapus!',
									'Data Sudah Dihapus.',
									'success'
								)
							}else{
								$('#CateringPenguranganLoading').hide();
								Swal.fire(
									'Gagal Dihapus!',
									'Data Gagal Dihapus.',
									'error'
								)
							}
						}
					})
				}else{
					$('#CateringPenguranganLoading').hide();
				}
			})
		}else{
			$('#slc-CM-Pengurangan-Kategori').val("").change();
			$('#slc-CM-Pengurangan-Shift').val("").change();
			$('#slc-CM-Pengurangan-TempatMakan').val("").change();
			$('#slc-CM-Pengurangan-TempatMakanBaru').val("").change();
			$('#slc-CM-Pengurangan-Penerima').val("").change();

			$('#opt-CM-Pengurangan-TempatMakanBaru').hide();
			$('#opt-CM-Pengurangan-Penerima').hide();
			$('#opt-CM-Pengurangan-Penerima-Table').hide();

			$('#txt-CM-Pengurangan-Tanggal').attr('disabled',false);
			$('#slc-CM-Pengurangan-Kategori').attr('disabled',true);
			$('#slc-CM-Pengurangan-Shift').attr('disabled',true);
			$('#slc-CM-Pengurangan-TempatMakan').attr('disabled',true);
			$('#slc-CM-Pengurangan-TempatMakanBaru').attr('disabled',true);
			$('#slc-CM-Pengurangan-Penerima').attr('disabled',true);
			
			tblCMPenguranganPenerima.clear().draw();			

			$('#btn-CM-Pengurangan-Tambah').text('Tambah');
			$('#btn-CM-Pengurangan-Hapus').text('Hapus');
			$('#btn-CM-Pengurangan-Edit').attr('disabled',true);
			$('#btn-CM-Pengurangan-Hapus').attr('disabled',true);

			$('#CateringPenguranganLoading').hide();
		}
	});
});
// end Pengurangan Pesanan

// start pekerja terhitung katering
$(document).ready(function(){
	var tblCMPekerjaTerhitungKatering = $('#tbl-CM-PekerjaTerhitungKatering-Table').DataTable({
        "lengthMenu": [
            [ 5, 10, 25, 50, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "dom" : 'Bfrtip',
        "buttons" : [
            'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
        ],
        "rowCallback": function( row, data, index ){
        	var ket = $(row).find('td:eq(8)').text();
        	
        	if (ket.substring(0,11) == "PENGURANGAN") {
        		$(row).css('color','red')
        	}else if (ket.substring(0,8) == "TAMBAHAN") {
        		$(row).css('color','green')
        	}else{
        		$(row).css('color','black')
        	}
        }
	});

	$('#txt-CM-PekerjaTerhitungCatering-Tanggal').datepicker({
		"autoclose": true,
		"todayHighlight": true,
		"todayBtn": "linked",
		"format":'yyyy-mm-dd'
	});

	$('#btn-CM-PekerjaTerhitungCatering-Lihat').on('click', function(){
		tanggal = $('#txt-CM-PekerjaTerhitungCatering-Tanggal').val();
		shift = $('#slc-CM-PekerjaTerhitungCatering-Shift').val();
		jenis = $('#slc-CM-PekerjaTerhitungCatering-Jenis').val();
		lokasi = $('#slc-CM-PekerjaTerhitungCatering-TempatMakan').find('option:selected').attr('data-lokasi');
		tempat_makan = $('#slc-CM-PekerjaTerhitungCatering-TempatMakan').val();
		$('#ldg-CM-PekerjaTerhitungKatering-Loading').show();

		if (tanggal && shift && lokasi && tempat_makan) {
			$.ajax({
				method: 'GET',
				url: baseurl + 'CateringManagement/Extra/PekerjaTerhitungCatering/getList',
				data: {tanggal: tanggal, shift: shift, lokasi: lokasi, tempat_makan: tempat_makan,jenis: jenis},
				error: function(xhr,status,error){
					$('#ldg-CM-PekerjaTerhitungKatering-Loading').hide();
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					$('#ldg-CM-PekerjaTerhitungKatering-Loading').hide();
					obj = JSON.parse(data);
					tblCMPekerjaTerhitungKatering.clear().draw();
					obj.forEach(function(daftar, index){
						tblCMPekerjaTerhitungKatering.row.add([
							(index + 1),
							daftar.noind,
							daftar.nama,
							daftar.waktu,
							daftar.tempat_makan,
							daftar.user_,
							daftar.seksi,
							daftar.shift,
							daftar.status
						]).draw(false);
					})
					tblCMPekerjaTerhitungKatering.columns.adjust().draw();
				}
			})
		}else{
			$('#ldg-CM-PekerjaTerhitungKatering-Loading').hide();
			swal.fire(
				'Peringatan!',
				'Pastikan Form Sudah Terisi Semua !',
				'warning'
			)
		}
	})
});
// end pekerja terhitung katering

// start absen per lokasi absen
$(document).ready(function(){
	var tblCMAbsenPerLokasiAbsen = $('#tbl-CM-AbsenPerLokasiAbsen-table').DataTable({
        "lengthMenu": [
            [ 5, 10, 25, 50, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "iDisplayLength" : -1,
        "dom" : 'Bfrtip',
        "buttons" : [
            'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
        ],
	});

	var tblCMAbsenPerLokasiAbsenDetailAbsen = $('#tbl-CM-AbsenPerLokasiAbsen-Absen').DataTable({
        "lengthMenu": [
            [ 5, 10, 25, 50, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "dom" : 'Bfrtip',
        "buttons" : [
            'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
        ],
	});

	var tblCMAbsenPerLokasiAbsenDetailKatering = $('#tbl-CM-AbsenPerLokasiAbsen-Katering').DataTable({
        "lengthMenu": [
            [ 5, 10, 25, 50, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "dom" : 'Bfrtip',
        "buttons" : [
            'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
        ],
	});

	$('#txt-CM-AbsenPerLokasiAbsen-Tanggal').datepicker({
		"autoclose": true,
		"todayHighlight": true,
		"todayBtn": "linked",
		"format":'yyyy-mm-dd'
	});

	$('#btn-CM-AbsenPerLokasiAbsen-cari').on('click', function(){
		tanggal = $('#txt-CM-AbsenPerLokasiAbsen-Tanggal').val();
		$('#ldg-CM-AbsenPerLokasiAbsen-Loading').show();
		if (tanggal) {
			$.ajax({
				method: 'GET',
				url: baseurl + 'CateringManagement/Extra/AbsenPerLokasiAbsen/getList',
				data: {tanggal: tanggal},
				error: function(xhr,status,error){
					$('#ldg-CM-AbsenPerLokasiAbsen-Loading').hide();
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					obj = JSON.parse(data);
					tblCMAbsenPerLokasiAbsen.clear().draw();
					obj.forEach(function(daftar, index){
						tblCMAbsenPerLokasiAbsen.row.add([
							daftar.device_name + '<input class="lokasi" type="hidden" value="' + daftar.device_name + '">',
							daftar.inisial_lokasi + '<input class="inisial_lokasi" type="hidden" value="' + daftar.inisial_lokasi + '">',
							daftar.office + '<input class="tanggal" type="hidden" value="' + tanggal + '">',
							daftar.jml_absen,
							daftar.jml_katering,
							daftar.last_update,
						]).draw(false);
					})
					tblCMAbsenPerLokasiAbsen.columns.adjust().draw();
					$('#ldg-CM-AbsenPerLokasiAbsen-Loading').hide();
				}
			})
		}else{
			$('#ldg-CM-AbsenPerLokasiAbsen-Loading').hide();
			swal.fire(
				'Peringatan!',
				'Pastikan Tanggal Sudah Terisi !',
				'warning'
			)
		}
	});

	$('#tbl-CM-AbsenPerLokasiAbsen-table').on('click', 'td', function(){
		tanggal = $(this).closest('tr').find('.tanggal').val();
		inisial_lokasi = $(this).closest('tr').find('.inisial_lokasi').val();
		lokasi = $(this).closest('tr').find('.lokasi').val();
		$('#ldg-CM-AbsenPerLokasiAbsen-Loading').show();
		$('#mdl-CM-AbsenPerLokasiAbsen-judul').text(lokasi + " ( " + inisial_lokasi + " )");
		$.ajax({
			method: 'GET',
			url: baseurl + 'CateringManagement/Extra/AbsenPerLokasiAbsen/getDetail',
			data: {tanggal: tanggal, inisial_lokasi: inisial_lokasi},
			error: function(xhr,status,error){
				$('#ldg-CM-AbsenPerLokasiAbsen-Loading').hide();
				swal.fire({
	                title: xhr['status'] + "(" + xhr['statusText'] + ")",
	                html: xhr['responseText'],
	                type: "error",
	                confirmButtonText: 'OK',
	                confirmButtonColor: '#d63031',
	            })
			},
			success: function(data){
				obj = JSON.parse(data);
				tblCMAbsenPerLokasiAbsenDetailAbsen.clear().draw();
				obj.absen.forEach(function(daftar, index){
					tblCMAbsenPerLokasiAbsenDetailAbsen.row.add([
						daftar.noind ,
						daftar.nama,
						daftar.shift,
						daftar.waktu,
						daftar.tempat_makan
					]).draw(false);
				})

				tblCMAbsenPerLokasiAbsenDetailKatering.clear().draw();
				obj.katering.forEach(function(daftar, index){
					tblCMAbsenPerLokasiAbsenDetailKatering.row.add([
						daftar.noind ,
						daftar.nama,
						daftar.shift,
						daftar.waktu,
						daftar.tempat_makan
					]).draw(false);
				})

				$('#ldg-CM-AbsenPerLokasiAbsen-Loading').hide();
				$('#mdl-CM-AbsenPerLokasiAbsen').modal('show');

				tblCMAbsenPerLokasiAbsenDetailAbsen.columns.adjust().draw();
				tblCMAbsenPerLokasiAbsenDetailKatering.columns.adjust().draw();
			}
		})
	})

	$('#mdl-CM-AbsenPerLokasiAbsen-close').on('click', function(){
		$('#mdl-CM-AbsenPerLokasiAbsen').modal('hide');
	})
})
// end absen per lokasi absen

// start izin dinas pusat tuksono mlati
$(document).ready(function(){
	var tblCMIzinDinasPTM = $('#tbl-CM-IzinDinasPTM-table').DataTable({
        "lengthMenu": [
            [  -1, 5, 10, 25, 50 ],
            [ 'Show all', '5 rows', '10 rows', '25 rows', '50 rows' ]
        ],
        "dom" : 'Bfrtip',
        "buttons" : [
            'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
        ],
	});

	$('#btn-CM-IzinDinasPTM-Proses').on('click', function(){
		$('#ldg-CM-IzinDinasPTM-Loading').show();
		$.ajax({
			method: 'GET',
			url: baseurl + 'CateringManagement/Extra/IzinDinasPTM/proses',
			error: function(xhr,status,error){
				$('#ldg-CM-IzinDinasPTM-Loading').hide();
				swal.fire({
	                title: xhr['status'] + "(" + xhr['statusText'] + ")",
	                html: xhr['responseText'],
	                type: "error",
	                confirmButtonText: 'OK',
	                confirmButtonColor: '#d63031',
	            })
			},
			success: function(data){
				obj = JSON.parse(data);
				tblCMIzinDinasPTM.clear().draw();
				console.log(obj);
				obj.forEach(function(daftar, index){
					tblCMIzinDinasPTM.row.add([
						daftar.tanggal ,
						daftar.izin_id ,
						daftar.noind ,
						daftar.nama,
						daftar.tempat_makan,
						daftar.tujuan,
						daftar.keterangan,
						daftar.jenis_dinas,
						daftar.diproses_tambah,
						daftar.diproses_kurang
					]).draw(false);
				})

				$('#ldg-CM-IzinDinasPTM-Loading').hide();
			}
		})
	});

	$.ajax({
		method: 'GET',
		url: baseurl + 'CateringManagement/Extra/IzinDinasPTM/getUserCatering',
		error: function(xhr,status,error){
			swal.fire({
                title: xhr['status'] + "(" + xhr['statusText'] + ")",
                html: xhr['responseText'],
                type: "error",
                confirmButtonText: 'OK',
                confirmButtonColor: '#d63031',
            })
		},
		success: function(data){
			if (data == "ya") {
				localStorage.setItem("lastMinutesID", -1)
				setInterval(function(){
					var waktuCatering = new Date();
					jamKatering = waktuCatering.getHours();
					menitKatering = waktuCatering.getMinutes();
					detikKatering = waktuCatering.getSeconds();
					// console.log(localStorage.getItem("lastMinutes"))
					if ( parseInt(jamKatering) == 8 || (parseInt(jamKatering) == 9 && parseInt(menitKatering) <= 45 ) ) {
						if ( parseInt(menitKatering)%5 == 0 && localStorage.getItem("lastMinutesID") != parseInt(menitKatering) ) {
							localStorage.setItem("lastMinutesID", parseInt(menitKatering))
							$.ajax({
								method: 'GET',
								url: baseurl + 'CateringManagement/Extra/IzinDinasPTM/getNotifikasiIzinDinasPTM',
								error: function(xhr,status,error){
									swal.fire({
						                title: xhr['status'] + "(" + xhr['statusText'] + ")",
						                html: xhr['responseText'],
						                type: "error",
						                confirmButtonText: 'OK',
						                confirmButtonColor: '#d63031',
						            })
								},
								success: function(data){
									if (data != "0") {
										swal.fire({
							                title: "Notifikasi Izin Dinas Pusat Tuksono Mlati",
							                html: "Terdapat " + data + " yang belum terproses, <a href='" + baseurl + "CateringManagement/Extra/IzinDinasPTM'>klik disini </a> untuk masuk ke menu catering izin dinas pusat tuksono mlati",
							                type: "warning",
							                confirmButtonText: 'Close',
							                confirmButtonColor: '#d63031',
							            })
									}							
								}
							});
						}
					}
				},1000);
			}
		}
	});
})
// end izin dinas pusat tuksono mlati

// start mutasi pekerja
$(document).ready(function(){
	$('#tbl-CM-MutasiPekerja-Table').DataTable({
        "lengthMenu": [
            [ 5, 10, 25, 50, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "dom" : 'Bfrtip',
        "buttons" : [
            'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
        ],
	});
})
// end mutasi pekerja

// start notifikasi dinas luar
$(document).ready(function(){
	var tblCMNotifDL = $('#tbl-CM-NotifDL-Table').DataTable({
        "lengthMenu": [
            [ 5, 10, 25, 50, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "dom" : 'Bfrtip',
        "buttons" : [
            'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
        ],
	});

	$('#btn-CM-NotifDL-Proses').on('click', function(){
		$('#ldg-CM-NotifDL-Loading').show();
		$.ajax({
			method: 'GET',
			url: baseurl + 'CateringManagement/Extra/NotifDL/proses',
			error: function(xhr,status,error){
				$('#ldg-CM-NotifDL-Loading').hide();
				swal.fire({
	                title: xhr['status'] + "(" + xhr['statusText'] + ")",
	                html: xhr['responseText'],
	                type: "error",
	                confirmButtonText: 'OK',
	                confirmButtonColor: '#d63031',
	            })
			},
			success: function(data){
				obj = JSON.parse(data);
				tblCMNotifDL.clear().draw();
				console.log(obj);
				obj.forEach(function(daftar, index){
					tblCMNotifDL.row.add([
						daftar.noind ,
						daftar.nama,
						daftar.tempat_makan,
						daftar.lokasi_kerja,
						daftar.spdl_id,
						daftar.status,
						daftar.wkt_realisasi,
						daftar.dikurangi
					]).draw(false);
				})

				$('#ldg-CM-NotifDL-Loading').hide();
			}
		})
	});

	$.ajax({
		method: 'GET',
		url: baseurl + 'CateringManagement/Extra/IzinDinasPTM/getUserCatering',
		error: function(xhr,status,error){
			swal.fire({
                title: xhr['status'] + "(" + xhr['statusText'] + ")",
                html: xhr['responseText'],
                type: "error",
                confirmButtonText: 'OK',
                confirmButtonColor: '#d63031',
            })
		},
		success: function(data){
			if (data == "ya") {
				localStorage.setItem("lastMinutesDL", -1)
				setInterval(function(){
					var waktuCatering = new Date();
					jamKatering = waktuCatering.getHours();
					menitKatering = waktuCatering.getMinutes();
					detikKatering = waktuCatering.getSeconds();
					// console.log(localStorage.getItem("lastMinutesDL"))
					if ( parseInt(jamKatering) == 8 || (parseInt(jamKatering) == 9 && parseInt(menitKatering) <= 45 ) ) {
						if ( parseInt(menitKatering)%5 == 0 && localStorage.getItem("lastMinutesDL") != parseInt(menitKatering) ) {
							localStorage.setItem("lastMinutesDL", parseInt(menitKatering))
							// swal.fire({
				   //              title: "Notifikasi Izin Dinas Pusat Tuksono Mlati",
				   //              html: "Terdapat XX yang belum terproses, <a href='" + baseurl + "CateringManagement/Extra/IzinDinasPTM'>klik disini </a> untuk masuk ke menu catering izin dinas tuksono mlati",
				   //              type: "warning",
				   //              confirmButtonText: 'Close',
				   //              confirmButtonColor: '#d63031',
				   //          })
							$.ajax({
								method: 'GET',
								url: baseurl + 'CateringManagement/Extra/NotifDL/getNotifikasiDinasLuar',
								error: function(xhr,status,error){
									swal.fire({
						                title: xhr['status'] + "(" + xhr['statusText'] + ")",
						                html: xhr['responseText'],
						                type: "error",
						                confirmButtonText: 'OK',
						                confirmButtonColor: '#d63031',
						            })
								},
								success: function(data){
									if (data != "0") {
										swal.fire({
							                title: "Notifikasi Dinas Luar",
							                html: "Terdapat " + data + " yang belum terproses, <a href='" + baseurl + "CateringManagement/Extra/NotifDL'>klik disini </a> untuk masuk ke menu catering dinas luar",
							                type: "warning",
							                confirmButtonText: 'Close',
							                confirmButtonColor: '#d63031',
							            })
									}							
								}
							});
						}
					}
				},1000);
			}
		}
	});
})
// end notifikasi dinas luar

// start Presensi Pekerja
$(document).ready(function(){
	var tblCMPresensipekerja = $('#tbl-CM-PresensiPekerja-Table').DataTable({
		"lengthMenu": [
            [ 5, 10, 25, 50, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "dom" : 'Bfrtip',
        "buttons" : [
            'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
        ],
        "scrollX" : true,
		"fixedColumns":   {
            leftColumns: 6
        },
	})

	$('#txt-CM-PresensiPekerja-TanggalAwal').datepicker({
		"autoclose": true,
		"todayHighlight": true,
		"todayBtn": "linked",
		"format":'yyyy-mm-dd'
	});

	$('#txt-CM-PresensiPekerja-TanggalAkhir').datepicker({
		"autoclose": true,
		"todayHighlight": true,
		"todayBtn": "linked",
		"format":'yyyy-mm-dd'
	});

	$('#slc-CM-PresensiPekerja-Dept').select2({
		searching: true,
        minimumInputLength: 0,
        placeholder: "Pilih Departement",
        allowClear: true,
        ajax: {
            url: baseurl + 'CateringManagement/Extra/PresensiPekerja/getDepartement',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.kodesie, text: obj.kodesie + " - " + obj.dept };
                    })
                }
            }
        }
	});

	$('#slc-CM-PresensiPekerja-Bidang').select2({
		searching: true,
        minimumInputLength: 0,
        placeholder: "Pilih Bidang",
        allowClear: true,
        ajax: {
            url: baseurl + 'CateringManagement/Extra/PresensiPekerja/getBidang',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
            	var query = {
            		term: params.term,
            		kode: $('#slc-CM-PresensiPekerja-Dept').val()
            	}
                return query;
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.kodesie, text: obj.kodesie + " - " + obj.bidang };
                    })
                }
            }
        }
	});

	$('#slc-CM-PresensiPekerja-Unit').select2({
		searching: true,
        minimumInputLength: 0,
        placeholder: "Pilih Unit",
        allowClear: true,
        ajax: {
            url: baseurl + 'CateringManagement/Extra/PresensiPekerja/getUnit',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
            	var query = {
            		term: params.term,
            		kode: $('#slc-CM-PresensiPekerja-Bidang').val()
            	}
                return query;
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.kodesie, text: obj.kodesie + " - " + obj.unit };
                    })
                }
            }
        }
	});

	$('#slc-CM-PresensiPekerja-Seksi').select2({
		searching: true,
        minimumInputLength: 0,
        placeholder: "Pilih Seksi",
        allowClear: true,
        ajax: {
            url: baseurl + 'CateringManagement/Extra/PresensiPekerja/getSeksi',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
            	var query = {
            		term: params.term,
            		kode: $('#slc-CM-PresensiPekerja-Unit').val()
            	}
                return query;
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.kodesie, text: obj.kodesie + " - " + obj.seksi };
                    })
                }
            }
        }
	});

	$('#slc-CM-PresensiPekerja-Dept').on('change', function(){
		var kodesie = $(this).val();
		if (kodesie == '-') {
			$('#slc-CM-PresensiPekerja-Bidang').select2("").trigger('change');
			$('#slc-CM-PresensiPekerja-Unit').val("").trigger('change');
			$('#slc-CM-PresensiPekerja-Seksi').val("").trigger('change');
			$('#slc-CM-PresensiPekerja-Bidang').attr('disabled', true);
			$('#slc-CM-PresensiPekerja-Unit').attr('disabled', true);
			$('#slc-CM-PresensiPekerja-Seksi').attr('disabled', true);
		}else{
			$('#slc-CM-PresensiPekerja-Bidang').attr('disabled', false);
			$('#slc-CM-PresensiPekerja-Unit').attr('disabled', true);
			$('#slc-CM-PresensiPekerja-Seksi').attr('disabled', true);
		}
	})

	$('#slc-CM-PresensiPekerja-Bidang').on('change', function(){
		var kodesie = $(this).val();
		if (kodesie) {
			var kodesie_text = kodesie.substr(kodesie.length - 2);
			
			if (kodesie_text == '00') {
				$('#slc-CM-PresensiPekerja-Unit').val("").trigger('change');
				$('#slc-CM-PresensiPekerja-Seksi').val("").trigger('change');
				$('#slc-CM-PresensiPekerja-Unit').attr('disabled', true);
				$('#slc-CM-PresensiPekerja-Seksi').attr('disabled', true);
			}else{
				$('#slc-CM-PresensiPekerja-Unit').attr('disabled', false);
				$('#slc-CM-PresensiPekerja-Seksi').attr('disabled', true);
			}
		}
	})
	
	$('#slc-CM-PresensiPekerja-Unit').on('change', function(){
		var kodesie = $(this).val();
		if (kodesie) {
			var kodesie_text = kodesie.substr(kodesie.length - 2);
			
			if (kodesie_text == '00') {
				$('#slc-CM-PresensiPekerja-Seksi').val("").trigger('change');
				$('#slc-CM-PresensiPekerja-Seksi').attr('disabled', true);
			}else{
				$('#slc-CM-PresensiPekerja-Seksi').attr('disabled', false);
			}
		}
	})

	$('#btn-CM-PresensiPekerja-Tampil').on('click', function(){
		$('#ldg-CM-PresensiPekerja-Loading').show();
		var tanggalAwal = $('#txt-CM-PresensiPekerja-TanggalAwal').val();
		var tanggalAkhir = $('#txt-CM-PresensiPekerja-TanggalAkhir').val();
		var dept = $('#slc-CM-PresensiPekerja-Dept').val();
		var bidang = $('#slc-CM-PresensiPekerja-Bidang').val();
		var unit = $('#slc-CM-PresensiPekerja-Unit').val();
		var seksi = $('#slc-CM-PresensiPekerja-Seksi').val();

		var kodesie = "";
		if (seksi.length > 0) {
			kodesie = seksi;
		}else if(unit.length > 0) {
			kodesie = unit;
		}else if(bidang.length > 0){
			kodesie = bidang;
		}else if (dept.length > 0) {
			kodesie = dept
		}
		console.log('kodesie : ' + kodesie);
		if (kodesie.length > 0 && tanggalAwal && tanggalAkhir) {
			$.ajax({
				method: 'GET',
				url: baseurl + 'CateringManagement/Extra/PresensiPekerja/tampil',
				data: {kodesie: kodesie, tanggal_awal: tanggalAwal, tanggal_akhir: tanggalAkhir},
				error: function(xhr,status,error){
					$('#ldg-CM-PresensiPekerja-Loading').hide();
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					obj = JSON.parse(data);
					tblCMPresensipekerja.clear().draw();
					console.log(obj);
					obj.forEach(function(daftar, index){
						tblCMPresensipekerja.row.add([
							(index + 1),
							daftar.dept,
							daftar.bidang,
							daftar.unit,
							daftar.seksi,
							daftar.tanggal,
							daftar.estimasi_satu,
							daftar.realitas_satu,
							daftar.cuti_satu,
							daftar.sakit_satu,
							daftar.mangkir_satu,
							daftar.lain_satu,
							daftar.estimasi_dua,
							daftar.realitas_dua,
							daftar.cuti_dua,
							daftar.sakit_dua,
							daftar.mangkir_dua,
							daftar.lain_dua,
							daftar.estimasi_tiga,
							daftar.realitas_tiga,
							daftar.cuti_tiga,
							daftar.sakit_tiga,
							daftar.mangkir_tiga,
							daftar.lain_tiga,
							daftar.estimasi_umum,
							daftar.realitas_umum,
							daftar.cuti_umum,
							daftar.sakit_umum,
							daftar.mangkir_umum,
							daftar.lain_umum,
						]).draw(false);
					})

					tblCMPresensipekerja.columns.adjust().draw();
					$('#ldg-CM-PresensiPekerja-Loading').hide();
				}
			})
		}else{
			$('#ldg-CM-PresensiPekerja-Loading').hide();
			swal.fire(
				'Peringatan!',
				'Pastikan Form Sudah Terisi !',
				'warning'
			)
		}

	})
})
// end Presensi Pekerja

// start Menu
$(document).ready(function(){
	var tblCMMenu = $('#tbl-CM-Menu-Table').DataTable({
		"lengthMenu": [
            [ 5, 10, 25, 50, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "dom" : 'Bfrtip',
        "buttons" : [
            'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
        ],
        'columnDefs': [
			{
			    "targets": 0,
			    "className": "text-center"
			},
			{
			    "targets": 1,
			    "className": "text-center"
			}
		],
	})

	var tblCMMenuDetail = $('#tbl-CM-Menu-Detail').DataTable({
		"lengthMenu": [
            [ 5, 10, 25, 50, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "dom" : 'Bfrtip',
        "buttons" : [
            'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
        ]
	})

	$('#txt-CM-Menu-BulanTahun-Copy').datepicker({
	    "autoclose": true,
	    "todayHiglight": true,
	    "format":'MM yyyy',
	    "viewMode":'months',
	    "minViewMode":'months'
	});

	$('#txt-CM-Menu-BulanTahun').datepicker({
	    "autoclose": true,
	    "todayHiglight": true,
	    "format":'MM yyyy',
	    "viewMode":'months',
	    "minViewMode":'months'
	});

	$('#txt-CM-Menu-Export-BulanTahun').datepicker({
	    "autoclose": true,
	    "todayHiglight": true,
	    "format":'MM yyyy',
	    "viewMode":'months',
	    "minViewMode":'months'
	});

	var tblCMMenuCreate = $('#tbl-CM-Menu-Create').DataTable({
		"paging": false,
		"searching": false,
		"sort": false,
		"info": false
	})

	$('.slc-CM-Menu-Sayur').select2({
		tags: true,
		tokenSeparators: [','],
		createTag: function (params) {
		    var term = $.trim(params.term);

		    if (term === '') {
		    	return null;
		    }

		    return {
		    	id: term,
		    	text: term,
		    	newTag: true
		    }
		}
	});
	$('.slc-CM-Menu-LaukUtama').select2({
		tags: true,
		// tokenSeparators: [','],
		createTag: function (params) {
		    var term = $.trim(params.term);

		    if (term === '') {
		    	return null;
		    }

		    return {
		    	id: term,
		    	text: term,
		    	newTag: true 
		    }
		},
	});
	$('.slc-CM-Menu-LaukPendamping').select2({
		tags: true,
		// tokenSeparators: [','],
		createTag: function (params) {
		    var term = $.trim(params.term);

		    if (term === '') {
		    	return null;
		    }

		    return {
		    	id: term,
		    	text: term,
		    	newTag: true
		    }
		}
	});
	$('.slc-CM-Menu-Buah').select2({
		tags: true,
		// tokenSeparators: [','],
		createTag: function (params) {
		    var term = $.trim(params.term);

		    if (term === '') {
		    	return null;
		    }

		    return {
		    	id: term,
		    	text: term,
		    	newTag: true 
		    }
		}
	});

	$('#slc-CM-Menu-Shift').on('change', function(){
		CMMenuCreateChange(tblCMMenuCreate)
	});
	$('#slc-CM-Menu-Lokasi').on('change', function(){
		CMMenuCreateChange(tblCMMenuCreate)
	});
	$('#txt-CM-Menu-BulanTahun').on('change', function(){
		CMMenuCreateChange(tblCMMenuCreate)
	});
	
	$('#btn-CM-Menu-CopyMenu').on('click', function(){
		$('#ldg-CM-Menu-Loading').show();
		var shift = $('#slc-CM-Menu-Shift').val();
		var lokasi = $('#slc-CM-Menu-Lokasi').val();
		var bulan_tahun = $('#txt-CM-Menu-BulanTahun').val();

		var shift_copy = $('#slc-CM-Menu-Shift-Copy').val();
		var lokasi_copy = $('#slc-CM-Menu-Lokasi-Copy').val();
		var bulan_tahun_copy = $('#txt-CM-Menu-BulanTahun-Copy').val();

		if (shift && lokasi && bulan_tahun && shift_copy && lokasi_copy && bulan_tahun_copy) {
			$.ajax({
				method: 'GET',
				url: baseurl + 'CateringManagement/Setup/Menu/copyMenu',
				data: {
						shift: shift, 
						lokasi: lokasi, 
						bulan_tahun: bulan_tahun,
						shift_copy: shift_copy, 
						lokasi_copy: lokasi_copy, 
						bulan_tahun_copy: bulan_tahun_copy
				},
				error: function(xhr,status,error){
					$('#ldg-CM-Menu-Loading').hide();
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					obj = JSON.parse(data);
					if (obj) {
						tblCMMenuCreate.clear().draw();
						if (obj.status == "INSERT") {

							if (obj.isi > 0) {
								obj.data.forEach(function(daftar, index){
									tblCMMenuCreate.row.add([
										daftar.tanggal,
										"<select class=\"slc-CM-Menu-Sayur\" data-placeholder=\"Pilih Sayur...\" style=\"width: 200px\" autocomplete=\"off\" multiple=\"multiple\"></select>",
										"<select class=\"slc-CM-Menu-LaukUtama\" data-placeholder=\"Pilih lauk Utama...\" style=\"width: 200px\" autocomplete=\"off\" multiple=\"multiple\"></select>",
										"<select class=\"slc-CM-Menu-LaukPendamping\" data-placeholder=\"Pilih Lauk Pendamping...\" style=\"width: 200px\" autocomplete=\"off\" multiple=\"multiple\"></select>",
										"<select class=\"slc-CM-Menu-Buah\" data-placeholder=\"Pilih Buah...\" style=\"width: 200px\" autocomplete=\"off\" multiple=\"multiple\"></select>"
									]).draw(false);
								})
							}

							if (obj.sayur_jumlah > 0) {
								obj.sayur.forEach(function(text, index){
									$('.slc-CM-Menu-Sayur').append("<option>" + text.text + "</option>")
								})
							}

							if (obj.lauk_utama_jumlah > 0) {
								obj.lauk_utama.forEach(function(text, index){
									$('.slc-CM-Menu-LaukUtama').append("<option>" + text.text + "</option>")
								})
							}

							if (obj.lauk_pendamping_jumlah > 0) {
								obj.lauk_pendamping.forEach(function(text, index){
									$('.slc-CM-Menu-LaukPendamping').append("<option>" + text.text + "</option>")
								})
							}

							if (obj.buah_jumlah > 0) {
								obj.buah.forEach(function(text, index){
									$('.slc-CM-Menu-Buah').append("<option>" + text.text + "</option>")
								})
							}

							tblCMMenuCreate.columns.adjust().draw();
						}else if(obj.status == "UPDATE"){
							if (obj.isi > 0) {
								obj.data.forEach(function(daftar, index){
									tblCMMenuCreate.row.add([
										daftar.tanggal,
										"<select class=\"slc-CM-Menu-Sayur\" data-placeholder=\"Pilih Sayur...\" style=\"width: 200px\" autocomplete=\"off\" multiple=\"multiple\">" + daftar.sayur_option + "</select>",
										"<select class=\"slc-CM-Menu-LaukUtama\" data-placeholder=\"Pilih lauk Utama...\" style=\"width: 200px\" autocomplete=\"off\" multiple=\"multiple\">" + daftar.lauk_utama_option + "</select>",
										"<select class=\"slc-CM-Menu-LaukPendamping\" data-placeholder=\"Pilih Lauk Pendamping...\" style=\"width: 200px\" autocomplete=\"off\" multiple=\"multiple\">" + daftar.lauk_pendamping_option + "</select>",
										"<select class=\"slc-CM-Menu-Buah\" data-placeholder=\"Pilih Buah...\" style=\"width: 200px\" autocomplete=\"off\" multiple=\"multiple\">" + daftar.buah_option + "</select>"
									]).draw(false);
								})
							}

							tblCMMenuCreate.columns.adjust().draw();

						}

						$('.slc-CM-Menu-Sayur').select2({
							tags: true,
							tokenSeparators: [','],
							createTag: function (params) {
							    var term = $.trim(params.term);

							    if (term === '') {
							    	return null;
							    }

							    return {
							    	id: term,
							    	text: term,
							    	newTag: true
							    }
							}
						});
						$('.slc-CM-Menu-LaukUtama').select2({
							tags: true,
							// tokenSeparators: [','],
							createTag: function (params) {
							    var term = $.trim(params.term);

							    if (term === '') {
							    	return null;
							    }

							    return {
							    	id: term,
							    	text: term,
							    	newTag: true 
							    }
							},
						});
						$('.slc-CM-Menu-LaukPendamping').select2({
							tags: true,
							// tokenSeparators: [','],
							createTag: function (params) {
							    var term = $.trim(params.term);

							    if (term === '') {
							    	return null;
							    }

							    return {
							    	id: term,
							    	text: term,
							    	newTag: true
							    }
							}
						});
						$('.slc-CM-Menu-Buah').select2({
							tags: true,
							// tokenSeparators: [','],
							createTag: function (params) {
							    var term = $.trim(params.term);

							    if (term === '') {
							    	return null;
							    }

							    return {
							    	id: term,
							    	text: term,
							    	newTag: true 
							    }
							}
						});

						swal.fire(
							'Peringatan!',
							'Copy Data Sudah Selesai !',
							'success'
						)
					}
					$('#ldg-CM-Menu-Loading').hide();
				}
			})
		}else{
			$('#ldg-CM-Menu-Loading').hide();
			swal.fire(
				'Peringatan!',
				'Pastikan Form Sudah Terisi !',
				'warning'
			)
		}
	});

	$('#btn-CM-Menu-Simpan').on('click', function(){
		$('#ldg-CM-Menu-Loading').show();
		var shift = $('#slc-CM-Menu-Shift').val();
		var lokasi = $('#slc-CM-Menu-Lokasi').val();
		var bulan_tahun = $('#txt-CM-Menu-BulanTahun').val();
		if (shift && lokasi && bulan_tahun) {
			var data_tanggal_array = $('#tbl-CM-Menu-Create tbody tr');
			var data_tanggal = {};
			var sayur_kosong = 0;
			var lauk_utama_kosong = 0;
			var lauk_pendamping_kosong = 0;
			var buah_kosong = 0;
			for (var i = 0; i < data_tanggal_array.length; i++) {
				data_tanggal[i] = {}
				data_tanggal[i]['tanggal'] = data_tanggal_array[i]['children'][0]['innerText'];

				data_tanggal[i]['sayur'] = []
				selectedOptions = data_tanggal_array[i]['children'][1]['children'][0]['selectedOptions'];
				if (selectedOptions.length > 0) {
					for (var j = 0; j < selectedOptions.length; j++) {
						data_tanggal[i]['sayur'][j] = selectedOptions[j]['value'];
					}
				}else{
					sayur_kosong++;
				}

				data_tanggal[i]['lauk_utama'] = []
				selectedOptions = data_tanggal_array[i]['children'][2]['children'][0]['selectedOptions'];
				if (selectedOptions.length > 0) {
					for (var j = 0; j < selectedOptions.length; j++) {
						data_tanggal[i]['lauk_utama'][j] = selectedOptions[j]['value'];
					}
				}else{
					lauk_utama_kosong++;
				}

				data_tanggal[i]['lauk_pendamping'] = []
				selectedOptions = data_tanggal_array[i]['children'][3]['children'][0]['selectedOptions'];
				if (selectedOptions.length > 0) {
					for (var j = 0; j < selectedOptions.length; j++) {
						data_tanggal[i]['lauk_pendamping'][j] = selectedOptions[j]['value'];
					}
				}else{
					lauk_pendamping_kosong++;
				}

				data_tanggal[i]['buah'] = []
				selectedOptions = data_tanggal_array[i]['children'][4]['children'][0]['selectedOptions'];
				if (selectedOptions.length > 0) {
					for (var j = 0; j < selectedOptions.length; j++) {
						data_tanggal[i]['buah'][j] = selectedOptions[j]['value'];
					}
				}else{
					buah_kosong++;
				}
			}
			if (sayur_kosong > 0 || lauk_utama_kosong > 0 || lauk_pendamping_kosong > 0 || buah_kosong > 0) {
				$('#ldg-CM-Menu-Loading').hide();
				swal.fire(
					'Peringatan!',
					'Pastikan Menu Sudah Lengkap !',
					'warning'
				)
			}else{
				formData = {
					shift: shift,
					lokasi: lokasi,
					bulan_tahun: bulan_tahun,
					data: data_tanggal
				}
				// console.log(formData);
				$.ajax({
					method: 'POST',
					url: baseurl + 'CateringManagement/Setup/Menu/simpan',
					contentType: 'application/json',
					dataType: 'json',
					data: JSON.stringify(formData),
					error: function(xhr,status,error){
						$('#ldg-CM-Menu-Loading').hide();
						if (xhr['responseText'] == "sukses") {
							Swal.fire(
								'Berhasil Diinput!',
								'Data Berhasil Diinput !!',
								'success'
							)
							tblCMMenuCreate.clear().draw();
							window.location.href = baseurl + "CateringManagement/Setup/Menu";
						}else{
							swal.fire({
				                title: xhr['status'] + "(" + xhr['statusText'] + ")",
				                html: xhr['responseText'],
				                type: "error",
				                confirmButtonText: 'OK',
				                confirmButtonColor: '#d63031',
				            })
				        }
					},
					success: function(data){
						$('#ldg-CM-Menu-Loading').hide();
						swal.fire(
							'Sukses!',
							'Data Berhasil Diinput !',
							'success'
						)
						window.location.href = baseurl + "CateringManagement/Setup/Menu";
					}
				})
			}
		}else{
			$('#ldg-CM-Menu-Loading').hide();
			swal.fire(
				'Peringatan!',
				'Pastikan Form Sudah Terisi !',
				'warning'
			)
		}
	})

	$('#tbl-CM-Menu-Table').on('click','.btn-CM-Menu-Hapus', function(){
		var bulan = $(this).attr("data-bulan");
		var tahun = $(this).attr("data-tahun");
		var shift = $(this).attr("data-shift");
		var menuId = $(this).attr("data-menuid");
		Swal.fire({
			title: 'Apakah Anda yakin ?',
			text: 'Data Bulan ' + bulan + ' ' + tahun + ' Shift ' + shift + ' yang Sudah Dihapus Tidak Dapat Dikembalikan !!',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			confirmButtonText: 'Hapus',
			cancelButtonColor: '#d33',
			cancelButtonText: 'Batal'
		}).then((result) => {			
			if (result.value) {
				$('#ldg-CM-Menu-Loading').show();
				$.ajax({
					method: 'GET',
					url: baseurl + 'CateringManagement/Setup/Menu/delete',
					data: {menu_id: menuId},
					error: function(xhr,status,error){
						$('#ldg-CM-Menu-Loading').hide();
						swal.fire({
			                title: xhr['status'] + "(" + xhr['statusText'] + ")",
			                html: xhr['responseText'],
			                type: "error",
			                confirmButtonText: 'OK',
			                confirmButtonColor: '#d63031',
			            })
					},
					success: function(data){
						obj = JSON.parse(data);
						tblCMMenu.clear().draw();
						if (obj) {
							obj.forEach(function(daftar, index){
								tblCMMenu.row.add([
									(index + 1),
									daftar.action,
									daftar.bulan_tahun,
									daftar.shift
								]).draw(false);
							})
						}
						$('#ldg-CM-Menu-Loading').hide();
						Swal.fire(
							'Berhasil Dihapus!',
							'Data Bulan ' + bulan + ' ' + tahun + ' Shift ' + shift + ' Berhasil Dihapus !!',
							'success'
						)
					}
				})
			}
		})
	})
})

function CMMenuCreateChange(tblCMMenuCreate){
	var shift = $('#slc-CM-Menu-Shift').val();
	var lokasi = $('#slc-CM-Menu-Lokasi').val();
	var bulan_tahun = $('#txt-CM-Menu-BulanTahun').val();

	if (shift && lokasi && bulan_tahun) {
		$('#ldg-CM-Menu-Loading').show();
		$.ajax({
			method: 'GET',
			url: baseurl + 'CateringManagement/Setup/Menu/listTanggal',
			data: {shift: shift, lokasi: lokasi, bulan_tahun: bulan_tahun},
			error: function(xhr,status,error){
				$('#ldg-CM-Menu-Loading').hide();
				swal.fire({
	                title: xhr['status'] + "(" + xhr['statusText'] + ")",
	                html: xhr['responseText'],
	                type: "error",
	                confirmButtonText: 'OK',
	                confirmButtonColor: '#d63031',
	            })
			},
			success: function(data){
				obj = JSON.parse(data);
				if (obj) {
					tblCMMenuCreate.clear().draw();
					if (obj.status == "INSERT") {

						if (obj.isi > 0) {
							obj.data.forEach(function(daftar, index){
								tblCMMenuCreate.row.add([
									daftar.tanggal,
									"<select class=\"slc-CM-Menu-Sayur\" data-placeholder=\"Pilih Sayur...\" style=\"width: 200px\" autocomplete=\"off\" multiple=\"multiple\"></select>",
									"<select class=\"slc-CM-Menu-LaukUtama\" data-placeholder=\"Pilih lauk Utama...\" style=\"width: 200px\" autocomplete=\"off\" multiple=\"multiple\"></select>",
									"<select class=\"slc-CM-Menu-LaukPendamping\" data-placeholder=\"Pilih Lauk Pendamping...\" style=\"width: 200px\" autocomplete=\"off\" multiple=\"multiple\"></select>",
									"<select class=\"slc-CM-Menu-Buah\" data-placeholder=\"Pilih Buah...\" style=\"width: 200px\" autocomplete=\"off\" multiple=\"multiple\"></select>"
								]).draw(false);
							})
						}

						if (obj.sayur_jumlah > 0) {
							obj.sayur.forEach(function(text, index){
								$('.slc-CM-Menu-Sayur').append("<option>" + text.text + "</option>")
							})
						}

						if (obj.lauk_utama_jumlah > 0) {
							obj.lauk_utama.forEach(function(text, index){
								$('.slc-CM-Menu-LaukUtama').append("<option>" + text.text + "</option>")
							})
						}

						if (obj.lauk_pendamping_jumlah > 0) {
							obj.lauk_pendamping.forEach(function(text, index){
								$('.slc-CM-Menu-LaukPendamping').append("<option>" + text.text + "</option>")
							})
						}

						if (obj.buah_jumlah > 0) {
							obj.buah.forEach(function(text, index){
								$('.slc-CM-Menu-Buah').append("<option>" + text.text + "</option>")
							})
						}

						tblCMMenuCreate.columns.adjust().draw();
					}else if(obj.status == "UPDATE"){
						if (obj.isi > 0) {
							obj.data.forEach(function(daftar, index){
								tblCMMenuCreate.row.add([
									daftar.tanggal,
									"<select class=\"slc-CM-Menu-Sayur\" data-placeholder=\"Pilih Sayur...\" style=\"width: 200px\" autocomplete=\"off\" multiple=\"multiple\">" + daftar.sayur_option + "</select>",
									"<select class=\"slc-CM-Menu-LaukUtama\" data-placeholder=\"Pilih lauk Utama...\" style=\"width: 200px\" autocomplete=\"off\" multiple=\"multiple\">" + daftar.lauk_utama_option + "</select>",
									"<select class=\"slc-CM-Menu-LaukPendamping\" data-placeholder=\"Pilih Lauk Pendamping...\" style=\"width: 200px\" autocomplete=\"off\" multiple=\"multiple\">" + daftar.lauk_pendamping_option + "</select>",
									"<select class=\"slc-CM-Menu-Buah\" data-placeholder=\"Pilih Buah...\" style=\"width: 200px\" autocomplete=\"off\" multiple=\"multiple\">" + daftar.buah_option + "</select>"
								]).draw(false);
							})
						}

						tblCMMenuCreate.columns.adjust().draw();

						Swal.fire(
							'Peringatan!',
							'Data Sudah Ada Di Database !!',
							'warning'
						)
					}

					$('.slc-CM-Menu-Sayur').select2({
						tags: true,
						// tokenSeparators: [','],
						createTag: function (params) {
						    var term = $.trim(params.term);

						    if (term === '') {
						    	return null;
						    }

						    return {
						    	id: term,
						    	text: term,
						    	newTag: true
						    }
						}
					});
					$('.slc-CM-Menu-LaukUtama').select2({
						tags: true,
						// tokenSeparators: [','],
						createTag: function (params) {
						    var term = $.trim(params.term);

						    if (term === '') {
						    	return null;
						    }

						    return {
						    	id: term,
						    	text: term,
						    	newTag: true 
						    }
						},
					});
					$('.slc-CM-Menu-LaukPendamping').select2({
						tags: true,
						// tokenSeparators: [','],
						createTag: function (params) {
						    var term = $.trim(params.term);

						    if (term === '') {
						    	return null;
						    }

						    return {
						    	id: term,
						    	text: term,
						    	newTag: true
						    }
						}
					});
					$('.slc-CM-Menu-Buah').select2({
						tags: true,
						// tokenSeparators: [','],
						createTag: function (params) {
						    var term = $.trim(params.term);

						    if (term === '') {
						    	return null;
						    }

						    return {
						    	id: term,
						    	text: term,
						    	newTag: true 
						    }
						}
					});
				}
				$('#ldg-CM-Menu-Loading').hide();
			}
		})
	}else{
		tblCMMenuCreate.clear().draw();
	}
}
// end Menu

// start Pekerja Makan Khusus
$(document).ready(function(){
	var tblCMPekerjaMakanKhusus = $('#tbl-CM-PekerjaMakanKhusus-Table').DataTable({
		"lengthMenu": [
            [ 5, 10, 25, 50, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "dom" : 'Bfrtip',
        "buttons" : [
            'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
        ],
        'columnDefs': [
			{
			    "targets": 0,
			    "className": "text-center"
			},
			{
			    "targets": 1,
			    "className": "text-center"
			}
		],
	})

	$('#slc-CM-PekerjaMakanKhusus-Pekerja').select2({
		minimumInputLength: 1,
		allowClear: true,
		ajax: {
			url: baseurl+'CateringManagement/Setup/PekerjaMakanKhusus/getPekerja',
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {
					term: params.term
				};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.noind,
							text: item.noind + ' - ' + item.nama
						};
					})

				};
			},
		},
	})

	$('#slc-CM-PekerjaMakanKhusus-Sayur').select2({
		tags: true,
		// tokenSeparators: [','],
		createTag: function (params) {
		    var term = $.trim(params.term);

		    if (term === '') {
		    	return null;
		    }

		    return {
		    	id: term,
		    	text: term,
		    	newTag: true 
		    }
		}
	})

	$('#slc-CM-PekerjaMakanKhusus-LaukUtama').select2({
		tags: true,
		// tokenSeparators: [','],
		createTag: function (params) {
		    var term = $.trim(params.term);

		    if (term === '') {
		    	return null;
		    }

		    return {
		    	id: term,
		    	text: term,
		    	newTag: true 
		    }
		}
	})

	$('#slc-CM-PekerjaMakanKhusus-LaukPendamping').select2({
		tags: true,
		// tokenSeparators: [','],
		createTag: function (params) {
		    var term = $.trim(params.term);

		    if (term === '') {
		    	return null;
		    }

		    return {
		    	id: term,
		    	text: term,
		    	newTag: true 
		    }
		}
	})

	$('#slc-CM-PekerjaMakanKhusus-Buah').select2({
		tags: true,
		// tokenSeparators: [','],
		createTag: function (params) {
		    var term = $.trim(params.term);

		    if (term === '') {
		    	return null;
		    }

		    return {
		    	id: term,
		    	text: term,
		    	newTag: true 
		    }
		}
	})

	$('#slc-CM-PekerjaMakanKhusus-SayurPengganti').select2({
		tags: true,
		// tokenSeparators: [','],
		createTag: function (params) {
		    var term = $.trim(params.term);

		    if (term === '') {
		    	return null;
		    }

		    return {
		    	id: term,
		    	text: term,
		    	newTag: true 
		    }
		}
	})

	$('#slc-CM-PekerjaMakanKhusus-LaukUtamaPengganti').select2({
		tags: true,
		// tokenSeparators: [','],
		createTag: function (params) {
		    var term = $.trim(params.term);

		    if (term === '') {
		    	return null;
		    }

		    return {
		    	id: term,
		    	text: term,
		    	newTag: true 
		    }
		}
	})

	$('#slc-CM-PekerjaMakanKhusus-LaukPendampingPengganti').select2({
		tags: true,
		// tokenSeparators: [','],
		createTag: function (params) {
		    var term = $.trim(params.term);

		    if (term === '') {
		    	return null;
		    }

		    return {
		    	id: term,
		    	text: term,
		    	newTag: true 
		    }
		}
	})

	$('#slc-CM-PekerjaMakanKhusus-BuahPengganti').select2({
		tags: true,
		// tokenSeparators: [','],
		createTag: function (params) {
		    var term = $.trim(params.term);

		    if (term === '') {
		    	return null;
		    }

		    return {
		    	id: term,
		    	text: term,
		    	newTag: true 
		    }
		}
	})

	$('#txt-CM-PekerjMakanKhusus-TanggalMulai').datepicker({
		"autoclose": true,
		"todayHighlight": true,
		"todayBtn": "linked",
		"format":'yyyy-mm-dd'
	});

	$('#txt-CM-PekerjMakanKhusus-TanggalSelesai').datepicker({
		"autoclose": true,
		"todayHighlight": true,
		"todayBtn": "linked",
		"format":'yyyy-mm-dd'
	});

	$('#btn-CM-PekerjaMakanKhusus-Simpan').on('click', function(){
		var pekerja = $('#slc-CM-PekerjaMakanKhusus-Pekerja').val();
		var sayur = $('#slc-CM-PekerjaMakanKhusus-Sayur').val();
		var lauk_utama = $('#slc-CM-PekerjaMakanKhusus-LaukUtama').val();
		var lauk_pendamping = $('#slc-CM-PekerjaMakanKhusus-LaukPendamping').val();
		var buah = $('#slc-CM-PekerjaMakanKhusus-Buah').val();
		var sayur_pengganti = $('#slc-CM-PekerjaMakanKhusus-SayurPengganti').val();
		var lauk_utama_pengganti = $('#slc-CM-PekerjaMakanKhusus-LaukUtamaPengganti').val();
		var lauk_pendamping_pengganti = $('#slc-CM-PekerjaMakanKhusus-LaukPendampingPengganti').val();
		var buah_pengganti = $('#slc-CM-PekerjaMakanKhusus-BuahPengganti').val();
		var pekerja_makan_khusus_id = $('#txt-CM-PekerjMakanKhusus-Id').val();
		var tanggal_mulai = $('#txt-CM-PekerjMakanKhusus-TanggalMulai').val();
		var tanggal_selesai = $('#txt-CM-PekerjMakanKhusus-TanggalSelesai').val();

		if (pekerja && sayur && lauk_utama && lauk_pendamping && buah && sayur_pengganti && lauk_utama_pengganti && lauk_pendamping_pengganti && buah_pengganti && tanggal_mulai && tanggal_selesai) {
			$('#ldg-CM-PekerjaMakanKhusus-Loading').show();
			$.ajax({
				method: 'POST',
				url: baseurl + 'CateringManagement/Setup/PekerjaMakanKhusus/simpan',
				data: {
					pekerja: pekerja,
					sayur: sayur,
					lauk_utama: lauk_utama,
					lauk_pendamping: lauk_pendamping,
					buah: buah,
					sayur_pengganti: sayur_pengganti,
					lauk_utama_pengganti: lauk_utama_pengganti,
					lauk_pendamping_pengganti: lauk_pendamping_pengganti,
					buah_pengganti: buah_pengganti,
					pekerja_makan_khusus_id: pekerja_makan_khusus_id,
					tanggal_mulai: tanggal_mulai,
					tanggal_selesai, tanggal_selesai
				},
				error: function(xhr,status,error){
					$('#ldg-CM-PekerjaMakanKhusus-Loading').hide();
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					$('#ldg-CM-PekerjaMakanKhusus-Loading').hide();
					Swal.fire(
						'Behasil!',
						'Data Berhasil Disimpan !!',
						'success'
					)
					window.location.href = baseurl + 'CateringManagement/Setup/PekerjaMakanKhusus';
				}
			})
		}else{
			Swal.fire(
				'Peringatan!',
				'Pastikan Semua Sudah Terisi !!',
				'warning'
			)
		}

	})

	$('#tbl-CM-PekerjaMakanKhusus-Table').on('click','.btn-CM-PekerjaMakanKhusus-Hapus', function(){
		var id = $(this).attr('data-id');
		Swal.fire({
			title: 'Apakah Anda yakin ?',
			text: 'Data yang Sudah Dihapus Tidak Dapat Dikembalikan !!',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			confirmButtonText: 'Hapus',
			cancelButtonColor: '#d33',
			cancelButtonText: 'Batal'
		}).then((result) => {			
			if (result.value) {
				$('#ldg-CM-PekerjaMakanKhusus-Loading').show();
				$.ajax({
					method: 'GET',
					url: baseurl + 'CateringManagement/Setup/PekerjaMakanKhusus/delete',
					data: {id: id},
					error: function(xhr,status,error){
						$('#ldg-CM-PekerjaMakanKhusus-Loading').hide();
						swal.fire({
			                title: xhr['status'] + "(" + xhr['statusText'] + ")",
			                html: xhr['responseText'],
			                type: "error",
			                confirmButtonText: 'OK',
			                confirmButtonColor: '#d63031',
			            })
					},
					success: function(data){
						obj = JSON.parse(data);
						tblCMPekerjaMakanKhusus.clear().draw();
						if (obj) {
							obj.forEach(function(daftar, index){
								tblCMPekerjaMakanKhusus.row.add([
									(index + 1),
									daftar.action,
									daftar.pekerja,
									daftar.menu,
									daftar.pengganti,
									daftar.tanggal_mulai,
									daftar.tanggal_selesai
								]).draw(false);
							})
						}
						$('#ldg-CM-PekerjaMakanKhusus-Loading').hide();
						Swal.fire(
							'Berhasil Dihapus!',
							'Data Berhasil Dihapus !!',
							'success'
						)
					}
				})
			}
		})
	})
})
// end Pekerja Makan Khusus

// start Pekerja Tidak Makan
$(document).ready(function(){
	var tblCMPekerjaTidakMakan = $('#tbl-CM-PekerjaTidakMakan-Table').DataTable({
		"lengthMenu": [
            [ 5, 10, 25, 50, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "dom" : 'Bfrtip',
        "buttons" : [
            'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
        ],
        'columnDefs': [
			{
			    "targets": 0,
			    "className": "text-center"
			},
			{
			    "targets": 1,
			    "className": "text-center"
			}
		],
	})

	$('#txt-CM-PekerjaTidakMakan-TanggalAwal').datepicker({
		"autoclose": true,
		"todayHighlight": true,
		"todayBtn": "linked",
		"format":'yyyy-mm-dd'
	});

	$('#txt-CM-PekerjaTidakMakan-TanggalAkhir').datepicker({
		"autoclose": true,
		"todayHighlight": true,
		"todayBtn": "linked",
		"format":'yyyy-mm-dd'
	});

	$('#slc-CM-PekerjaTidakMakan-Pekerja').select2({
		minimumInputLength: 1,
		allowClear: true,
		ajax: {
			url: baseurl+'CateringManagement/Extra/PekerjaTidakMakan/getPekerja',
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {
					term: params.term
				};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.noind,
							text: item.noind + ' - ' + item.nama
						};
					})

				};
			},
		},
	})

	$('#btn-CM-PekerjaTidakMakan-Simpan').on('click', function(){
		var pekerja = $('#slc-CM-PekerjaTidakMakan-Pekerja').val();
		var tanggalAwal = $('#txt-CM-PekerjaTidakMakan-TanggalAwal').val();
		var tanggalAkhir = $('#txt-CM-PekerjaTidakMakan-TanggalAkhir').val();
		var keterangan = $('#txa-CM-PekerjaTidakMakan-Keterangan').val();
		var permintaanId = $('#txt-CM-PekerjaTidakMakan-PermintaanId').val();
		if (pekerja && tanggalAwal && tanggalAkhir && keterangan) {
			$('#ldg-CM-PekerjaTidakMakan-Loading').show();
			$.ajax({
				method: 'POST',
				url: baseurl + 'CateringManagement/Extra/PekerjaTidakMakan/simpan',
				data: {
					pekerja: pekerja,
					tanggal_awal: tanggalAwal,
					tanggal_akhir: tanggalAkhir,
					keterangan: keterangan,
					permintaan_id: permintaanId
				},
				error: function(xhr,status,error){
					$('#ldg-CM-PekerjaTidakMakan-Loading').hide();
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					$('#ldg-CM-PekerjaTidakMakan-Loading').hide();
					Swal.fire(
						'Berhasil Disimpan!',
						'Data Berhasil Disimpan !!',
						'success'
					)
					window.location.href = baseurl + 'CateringManagement/Extra/PekerjaTidakMakan';
				}
			})
		}else{
			Swal.fire(
				'Peringatan!',
				'Pastikan Semua Sudah Terisi !!',
				'warning'
			)
		}
	});

	$('#tbl-CM-PekerjaTidakMakan-Table').on('click','.btn-CM-PekerjaTidakMakan-Delete', function(){
		var permintaanId = $(this).attr("data-id");
		Swal.fire({
			title: 'Apakah Anda yakin ?',
			text: 'Data yang Sudah Dihapus Tidak Dapat Dikembalikan !!',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			confirmButtonText: 'Hapus',
			cancelButtonColor: '#d33',
			cancelButtonText: 'Batal'
		}).then((result) => {			
			if (result.value) {
				$('#ldg-CM-Menu-Loading').show();
				$.ajax({
					method: 'GET',
					url: baseurl + 'CateringManagement/Extra/PekerjaTidakMakan/hapus',
					data: {id: permintaanId},
					error: function(xhr,status,error){
						$('#ldg-CM-Menu-Loading').hide();
						swal.fire({
			                title: xhr['status'] + "(" + xhr['statusText'] + ")",
			                html: xhr['responseText'],
			                type: "error",
			                confirmButtonText: 'OK',
			                confirmButtonColor: '#d63031',
			            })
					},
					success: function(data){
						obj = JSON.parse(data);
						tblCMPekerjaTidakMakan.clear().draw();
						if (obj) {
							obj.forEach(function(daftar, index){
								tblCMPekerjaTidakMakan.row.add([
									(index + 1),
									daftar.action,
									daftar.pekerja,
									daftar.dari,
									daftar.sampai,
									daftar.keterangan
								]).draw(false);
							})
						}
						$('#ldg-CM-Menu-Loading').hide();
						Swal.fire(
							'Berhasil Dihapus!',
							'Data Berhasil Dihapus !!',
							'success'
						)
					}
				})
			}
		})
	})
})
// end Pekerja Tidak Makan

// start Prediksi Snack
$(document).ready(function(){
	$('#ldg-CM-PrediksiSnack-Loading').hide();
	$('#txt-CM-PrediksiSnack-Tanggal').datepicker({
		"autoclose": true,
		"todayHighlight": true,
		"todayBtn": "linked",
		"format":'yyyy-mm-dd'
	});

	var tblCMPrediksiSnack = $('#tbl-CM-PrediksiSnack-Table').DataTable({
		"lengthMenu": [
            [ -1, 5, 10, 25, 50 ],
            [ 'Show all', '5 rows', '10 rows', '25 rows', '50 rows' ]
        ],
        "dom" : 'Bfrtip',
        "buttons" : [
        	{ 
        		extend: 'copyHtml5', 
        		footer: true 
        	},
            { 
            	extend: 'excelHtml5', 
            	footer: true 
            },
            { 
            	extend: 'csvHtml5', 
            	footer: true 
            },
            { 
            	extend: 'pdfHtml5', 
            	footer: true
			}, 
            'pageLength'
        ],
        'columnDefs': [
			{
			    "targets": 0,
			    "className": "text-center"
			},
			{
			    "targets": 2,
			    "className": "text-right"
			},
			{
			    "targets": 3,
			    "className": "text-right"
			},
			{
			    "targets": 4,
			    "className": "text-right"
			},
			{
			    "targets": 5,
			    "className": "text-right"
			},
			{
			    "targets": 6,
			    "className": "text-right"
			},
			{
			    "targets": 7,
			    "className": "text-right"
			}
		],
	})

	var tblCMPrediksiSnackList = $('#tbl-CM-PrediksiSnack-List').DataTable({
		"lengthMenu": [
            [ -1, 5, 10, 25, 50 ],
            [ 'Show all', '5 rows', '10 rows', '25 rows', '50 rows' ]
        ],
        "dom" : 'Bfrtip',
        "buttons" : [
            'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
        ],
        'columnDefs': [
			{
			    "targets": 0,
			    "className": "text-center"
			}
		],
	})

	$('#btn-CM-PrediksiSnack-Prediksi').on('click', function(){
		tanggal = $('#txt-CM-PrediksiSnack-Tanggal').val();
		shift = $('#slc-CM-PrediksiSnack-Shift').val();
		lokasi = $('#slc-CM-PrediksiSnack-Lokasi').val();

		if (tanggal && shift && lokasi) {
			$('#ldg-CM-PrediksiSnack-Loading').show();
			$.ajax({
				method: 'GET',
				url: baseurl + 'CateringManagement/Pesanan/PrediksiSnack/Proses',
				data: {tanggal: tanggal,shift: shift,lokasi: lokasi},
				error: function(xhr,status,error){
					$('#ldg-CM-PrediksiSnack-Loading').hide();
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					$('#ldg-CM-PrediksiSnack-Loading').hide();
					obj = JSON.parse(data);
					console.log(obj.status);
					if (obj.status && obj.status == 'sukses') {
						Swal.fire({
							title: 'Prediksi selesai',
							text: "Apakah Anda Ingin Melihat Hasil Prediksi ?",
							type: 'success',
							showCancelButton: true,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'Ya',
							cancelButtonText: 'Tidak'
						}).then((result) => {
						  	if (result.value) {
						  		window.location.href = baseurl+"CateringManagement/Pesanan/PrediksiSnack/lihat/"+obj.text;
						  	}
						});
					}else{
						swal.fire({
			                title: "Output Tidak Sesuai...",
			                html: data,
			                type: "error",
			                confirmButtonText: 'OK',
			                confirmButtonColor: '#d63031',
			            })
					}
				}
			})
		}else{
			Swal.fire(
				'Peringatan !!!',
				'Pastikan Semua Data Terisi',
				'warning'
			)
		}
	})

	$('#btn-CM-PrediksiSnack-List').on('click', function(){
		tanggal = $('#txt-CM-PrediksiSnack-Tanggal').val();
		shift = $('#slc-CM-PrediksiSnack-Shift').val();
		lokasi = $('#slc-CM-PrediksiSnack-Lokasi').val();
		if (tanggal && shift && lokasi) {
			window.location.href = baseurl+"CateringManagement/Pesanan/PrediksiSnack/daftar/"+tanggal+"_"+shift+"_"+lokasi;
		}
	})
})
// end Prediksi Snack

// start edit tempat makan
$(document).ready(function(){

	var tblCMEditTempatMakanPerPekerja = $('#tbl-CM-EditTempatMakan-PerPekerja').DataTable({
        "lengthMenu": [
            [ 5, 10, 25, 50, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "dom" : 'Bfrtip',
        "buttons" : [
            'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
        ]
	});

	$('.slc-CM-EditTempatMakan-Departemen').select2({
		minimumInputLength: 0,
		allowClear: true,
		ajax: {
			url: baseurl+'CateringManagement/Extra/EditTempatMakan/getSeksi',
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {
					level: 'departemen',
					kodesie: '0',
					term: params.term
				};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.kodesie,
							text: item.nama
						};
					})

				};
			},
		}
	})

	$('.slc-CM-EditTempatMakan-Bidang').select2({
		minimumInputLength: 0,
		allowClear: true,
		ajax: {
			url: baseurl+'CateringManagement/Extra/EditTempatMakan/getSeksi',
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {
					level: 'bidang',
					kodesie: $(this).closest('form').find('.slc-CM-EditTempatMakan-Departemen').val(),
					term: params.term
				};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.kodesie,
							text: item.nama
						};
					})

				};
			},
		}
	})

	$('.slc-CM-EditTempatMakan-Unit').select2({
		minimumInputLength: 0,
		allowClear: true,
		ajax: {
			url: baseurl+'CateringManagement/Extra/EditTempatMakan/getSeksi',
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {
					level: 'unit',
					kodesie: $(this).closest('form').find('.slc-CM-EditTempatMakan-Bidang').val(),
					term: params.term
				};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.kodesie,
							text: item.nama
						};
					})

				};
			},
		}
	})

	$('.slc-CM-EditTempatMakan-Seksi').select2({
		minimumInputLength: 0,
		allowClear: true,
		ajax: {
			url: baseurl+'CateringManagement/Extra/EditTempatMakan/getSeksi',
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {
					level: 'seksi',
					kodesie: $(this).closest('form').find('.slc-CM-EditTempatMakan-Unit').val(),
					term: params.term
				};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.kodesie,
							text: item.nama
						};
					})

				};
			},
		}
	})

	$('.slc-CM-EditTempatMakan-Pekerjaan').select2({
		minimumInputLength: 0,
		allowClear: true,
		ajax: {
			url: baseurl+'CateringManagement/Extra/EditTempatMakan/getSeksi',
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {
					level: 'pekerjaan',
					kodesie: $(this).closest('form').find('.slc-CM-EditTempatMakan-Seksi').val(),
					term: params.term
				};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.kodesie,
							text: item.nama
						};
					})

				};
			},
		}
	})

	$('.slc-CM-EditTempatMakan-TempatMakanLama').select2({
		minimumInputLength: 0,
		allowClear: true,
		ajax: {
			url: baseurl+'CateringManagement/Extra/EditTempatMakan/getTempatMakan',
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {
					stat: 'lama',
					term: params.term
				};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.fs_tempat_makan,
							text: item.fs_tempat_makan
						};
					})

				};
			},
		}
	})

	$('.slc-CM-EditTempatMakan-TempatMakanBaru').select2({
		minimumInputLength: 0,
		allowClear: true,
		ajax: {
			url: baseurl+'CateringManagement/Extra/EditTempatMakan/getTempatMakan',
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {
					stat: 'baru',
					term: params.term
				};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.fs_tempat_makan,
							text: item.fs_tempat_makan
						};
					})

				};
			},
		}
	})

	$('.slc-CM-EditTempatMakan-TempatMakanPekerja').select2({
		minimumInputLength: 0,
		dropdownParent: $('#mdl-CM-EditTempatMakan-PerPekerja'),
		allowClear: true,
		ajax: {
			url: baseurl+'CateringManagement/Extra/EditTempatMakan/getTempatMakan',
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {
					stat: 'baru',
					term: params.term
				};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.fs_tempat_makan,
							text: item.fs_tempat_makan
						};
					})

				};
			},
		}
	})

	$('.slc-CM-EditTempatMakan-LokasiKerja').select2({
		minimumInputLength: 0,
		allowClear: true,
		ajax: {
			url: baseurl+'CateringManagement/Extra/EditTempatMakan/getLokasiKerja',
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {
					term: params.term
				};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.kode_lokasi,
							text: item.kode_lokasi + ' - ' + item.lokasi_kerja
						};
					})

				};
			},
		}
	})

	$('.slc-CM-EditTempatMakan-KodeInduk').select2({
		minimumInputLength: 0,
		allowClear: true,
		ajax: {
			url: baseurl+'CateringManagement/Extra/EditTempatMakan/getKodeInduk',
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {
					term: params.term
				};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.fs_noind,
							text: item.fs_noind + ' - ' + item.fs_ket
						};
					})

				};
			},
		}
	})

	$('.slc-CM-EditTempatMakan-Departemen').on('change', function(){
		var txtEditTempatMakanSelected = $(this).find('option:selected').text();

		if (txtEditTempatMakanSelected.substr(0,5) == 'SEMUA') {
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Bidang').val('').change();
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Unit').val('').change();
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Seksi').val('').change();
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Pekerjaan').val('').change();
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Bidang').attr('disabled', true);
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Unit').attr('disabled', true);
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Seksi').attr('disabled', true);
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Pekerjaan').attr('disabled', true);
		}else{
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Bidang').attr('disabled', false);
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Unit').attr('disabled', true);
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Seksi').attr('disabled', true);
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Pekerjaan').attr('disabled', true);
		}
	})

	$('.slc-CM-EditTempatMakan-Bidang').on('change', function(){
		var txtEditTempatMakanSelected = $(this).find('option:selected').text();
		$(this).closest('form').find('.slc-CM-EditTempatMakan-Unit').val('').change();
		$(this).closest('form').find('.slc-CM-EditTempatMakan-Seksi').val('').change();
		$(this).closest('form').find('.slc-CM-EditTempatMakan-Pekerjaan').val('').change();
		
		if (txtEditTempatMakanSelected.substr(0,5) == 'SEMUA') {
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Unit').attr('disabled', true);
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Seksi').attr('disabled', true);
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Pekerjaan').attr('disabled', true);
		}else{
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Unit').attr('disabled', false);
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Seksi').attr('disabled', true);
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Pekerjaan').attr('disabled', true);
		}
	})

	$('.slc-CM-EditTempatMakan-Unit').on('change', function(){
		var txtEditTempatMakanSelected = $(this).find('option:selected').text();
		$(this).closest('form').find('.slc-CM-EditTempatMakan-Seksi').val('').change();
		$(this).closest('form').find('.slc-CM-EditTempatMakan-Pekerjaan').val('').change();
		
		if (txtEditTempatMakanSelected.substr(0,5) == 'SEMUA') {
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Seksi').attr('disabled', true);
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Pekerjaan').attr('disabled', true);
		}else{
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Seksi').attr('disabled', false);
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Pekerjaan').attr('disabled', true);
		}
	})

	$('.slc-CM-EditTempatMakan-Seksi').on('change', function(){
		var txtEditTempatMakanSelected = $(this).find('option:selected').text();
		$(this).closest('form').find('.slc-CM-EditTempatMakan-Pekerjaan').val('').change();
		
		if (txtEditTempatMakanSelected.substr(0,5) == 'SEMUA') {
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Pekerjaan').attr('disabled', true);
		}else{
			$(this).closest('form').find('.slc-CM-EditTempatMakan-Pekerjaan').attr('disabled', false);
		}
	})

	$('#btn-CM-EditTempatMakan-CariPekerja').on('click', function(){
		var dept = $(this).closest('form').find('.slc-CM-EditTempatMakan-Departemen').val();
		var bidang = $(this).closest('form').find('.slc-CM-EditTempatMakan-Bidang').val();
		var unit = $(this).closest('form').find('.slc-CM-EditTempatMakan-Unit').val();
		var seksi = $(this).closest('form').find('.slc-CM-EditTempatMakan-Seksi').val();
		var pekerjaan = $(this).closest('form').find('.slc-CM-EditTempatMakan-Pekerjaan').val();

		var bidang_dis = $(this).closest('form').find('.slc-CM-EditTempatMakan-Bidang').attr('disabled');
		var unit_dis = $(this).closest('form').find('.slc-CM-EditTempatMakan-Unit').attr('disabled');
		var seksi_dis = $(this).closest('form').find('.slc-CM-EditTempatMakan-Seksi').attr('disabled');
		var pekerjaan_dis = $(this).closest('form').find('.slc-CM-EditTempatMakan-Pekerjaan').attr('disabled');

		var status = "0";

		if (dept) {
			if ((bidang_dis == undefined && bidang) || bidang_dis == "disabled") {
				if ((unit_dis == undefined && unit) || unit_dis == "disabled") {
					if ((seksi_dis == undefined && seksi) || seksi_dis == "disabled") {
						if ((pekerjaan_dis == undefined && pekerjaan) || pekerjaan_dis == "disabled") {
							status = "1";
						}else{
							status = "0";
						}
					}else{
						status = "0";
					}
				}else{
					status = "0";
				}
			}else{
				status = "0";
			}
		}else{
			status = "0";
		}

		if (status == "1") {
			$('#ldg-CM-EditTempatMakan-Loading').show();
			var kodesie = "";
			if (pekerjaan) {
				kodesie = pekerjaan;
			}else if (seksi) {
				kodesie = seksi;
			}else if (unit) {
				kodesie = unit;
			}else if (bidang) {
				kodesie = bidang;
			}else if (dept) {
				kodesie = dept;
			}
			$('#txt-CM-EditTempatMakan-Kodesie').val(kodesie);
			$.ajax({
				method: 'GET',
				url: baseurl + 'CateringManagement/Extra/EditTempatMakan/getPekerja',
				data: {kodesie: kodesie},
				error: function(xhr,status,error){
					$('#ldg-CM-EditTempatMakan-Loading').hide();
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					$('#ldg-CM-EditTempatMakan-Loading').hide();
					obj = JSON.parse(data);
					tblCMEditTempatMakanPerPekerja.clear().draw();
					obj.forEach(function(daftar, index){
						tblCMEditTempatMakanPerPekerja.row.add([
							(index + 1),
							daftar.noind,
							daftar.nama,
							daftar.tempat_makan,
							daftar.lokasi_kerja
						]).draw(false);
					})
					tblCMEditTempatMakanPerPekerja.columns.adjust().draw();
				}
			})
		}else{
			Swal.fire(
				'Peringatan !!!',
				'Pastikan Data Pekerjaan/Seksi/Unit/Bidang/Dept Sudah Terisi',
				'warning'
			)
		}
	})

	$('#tbl-CM-EditTempatMakan-PerPekerja').on('click', 'td', function(){
		var textRow = $(this).closest('tr').text();
		if (textRow != 'No data available in table') {
			var noind = $(this).closest('tr').find('td:eq(1)').text();
			var nama = $(this).closest('tr').find('td:eq(2)').text();
			var tempatMakan = $(this).closest('tr').find('td:eq(3)').text();
			var lokasiKerja = $(this).closest('tr').find('td:eq(4)').text();
			$('#txt-CM-EditTempatMakan-Noind').val(noind);
			$('#txt-CM-EditTempatMakan-Nama').val(nama);
			$('#txt-CM-EditTempatMakan-LokasiKerja').val(lokasiKerja);
		    $('#txt-CM-EditTempatMakan-TempatMakanPekerja-lama').val(tempatMakan);
			if ($('.slc-CM-EditTempatMakan-TempatMakanPekerja').find("option[value='" + tempatMakan + "']").length) {
			    $('.slc-CM-EditTempatMakan-TempatMakanPekerja').val(tempatMakan).trigger('change');
			} else { 
			    var newOption = new Option(tempatMakan, tempatMakan, true, true);
			    $('.slc-CM-EditTempatMakan-TempatMakanPekerja').append(newOption).trigger('change');
			} 
			$('#mdl-CM-EditTempatMakan-PerPekerja').modal('show');
		}
	})

	$('#btn-CM-EditTempatMakan-SimpanPerPekerja').on('click', function(){
		var noind = $('#txt-CM-EditTempatMakan-Noind').val();
		var nama = $('#txt-CM-EditTempatMakan-Nama').val();
		var lokasiKerja = $('#txt-CM-EditTempatMakan-LokasiKerja').val();
	    var tempatMakanLama = $('#txt-CM-EditTempatMakan-TempatMakanPekerja-lama').val();
	    var tempatMakan = $('.slc-CM-EditTempatMakan-TempatMakanPekerja').val();
	    var kodesie = $('#txt-CM-EditTempatMakan-Kodesie').val();
	    if (tempatMakan) {
	    	$('#ldg-CM-EditTempatMakan-Loading').show();
	    	$.ajax({
	    		method: 'POST',
	    		url: baseurl + 'CateringManagement/Extra/EditTempatMakan/simpanPerPekerja',
	    		data: {noind: noind, tempat_makan: tempatMakan, kodesie: kodesie, tempat_makan_lama: tempatMakanLama},
	    		error: function(xhr,status,error){
					$('#ldg-CM-EditTempatMakan-Loading').hide();
					swal.fire({
		                title: xhr['status'] + "(" + xhr['statusText'] + ")",
		                html: xhr['responseText'],
		                type: "error",
		                confirmButtonText: 'OK',
		                confirmButtonColor: '#d63031',
		            })
				},
				success: function(data){
					$('#ldg-CM-EditTempatMakan-Loading').hide();
					obj = JSON.parse(data);
					tblCMEditTempatMakanPerPekerja.clear().draw();
					obj.forEach(function(daftar, index){
						tblCMEditTempatMakanPerPekerja.row.add([
							(index + 1),
							daftar.noind,
							daftar.nama,
							daftar.tempat_makan,
							daftar.lokasi_kerja
						]).draw(false);
					})
					tblCMEditTempatMakanPerPekerja.columns.adjust().draw();
					Swal.fire(
						'Simpan Sukses !!!',
						'Tempat Makan Berhasil diubah !!',
						'success'
					)
				}
	    	});
	    }else{
			Swal.fire(
				'Peringatan !!!',
				'Pastikan Tempat Makan Sudah Terisi',
				'warning'
			)
		}
	})

	$('#btn-CM-EditTempatMakan-SimpanPerSeksi').on('click', function(){
		var dept = $(this).closest('form').find('.slc-CM-EditTempatMakan-Departemen').val();
		var bidang = $(this).closest('form').find('.slc-CM-EditTempatMakan-Bidang').val();
		var unit = $(this).closest('form').find('.slc-CM-EditTempatMakan-Unit').val();
		var seksi = $(this).closest('form').find('.slc-CM-EditTempatMakan-Seksi').val();
		var pekerjaan = $(this).closest('form').find('.slc-CM-EditTempatMakan-Pekerjaan').val();

		var bidang_dis = $(this).closest('form').find('.slc-CM-EditTempatMakan-Bidang').attr('disabled');
		var unit_dis = $(this).closest('form').find('.slc-CM-EditTempatMakan-Unit').attr('disabled');
		var seksi_dis = $(this).closest('form').find('.slc-CM-EditTempatMakan-Seksi').attr('disabled');
		var pekerjaan_dis = $(this).closest('form').find('.slc-CM-EditTempatMakan-Pekerjaan').attr('disabled');

		var status = "0";

		if (dept) {
			if ((bidang_dis == undefined && bidang) || bidang_dis == "disabled") {
				if ((unit_dis == undefined && unit) || unit_dis == "disabled") {
					if ((seksi_dis == undefined && seksi) || seksi_dis == "disabled") {
						if ((pekerjaan_dis == undefined && pekerjaan) || pekerjaan_dis == "disabled") {
							status = "1";
						}else{
							status = "0";
						}
					}else{
						status = "0";
					}
				}else{
					status = "0";
				}
			}else{
				status = "0";
			}
		}else{
			status = "0";
		}

		if (status == "1") {
			var kodesie = "";
			if (pekerjaan) {
				kodesie = pekerjaan;
			}else if (seksi) {
				kodesie = seksi;
			}else if (unit) {
				kodesie = unit;
			}else if (bidang) {
				kodesie = bidang;
			}else if (dept) {
				kodesie = dept;
			}
			var lokasi  = $(this).closest('form').find('.slc-CM-EditTempatMakan-LokasiKerja').val();
			var kodeInduk = $(this).closest('form').find('.slc-CM-EditTempatMakan-KodeInduk').val();
			var tempatMakanLama = $(this).closest('form').find('.slc-CM-EditTempatMakan-TempatMakanLama').val();
			var tempatMakanBaru = $(this).closest('form').find('.slc-CM-EditTempatMakan-TempatMakanBaru').val();

			if (lokasi && kodeInduk && tempatMakanLama && tempatMakanBaru) {
				$('#ldg-CM-EditTempatMakan-Loading').show();
				$.ajax({
					method: 'POST',
					url: baseurl + 'CateringManagement/Extra/EditTempatMakan/simpanPerSeksi',
					data: {kodesie: kodesie, lokasi: lokasi, kode_induk: kodeInduk, tempat_makan_lama: tempatMakanLama, tempat_makan_baru: tempatMakanBaru},
					error: function(xhr,status,error){
						$('#ldg-CM-EditTempatMakan-Loading').hide();
						swal.fire({
			                title: xhr['status'] + "(" + xhr['statusText'] + ")",
			                html: xhr['responseText'],
			                type: "error",
			                confirmButtonText: 'OK',
			                confirmButtonColor: '#d63031',
			            })
					},
					success: function(data){
						$('#ldg-CM-EditTempatMakan-Loading').hide();
						
						Swal.fire(
							'Simpan Sukses !!!',
							'Tempat Makan Berhasil diubah !!',
							'success'
						)
					}
				})
			}else{
				Swal.fire(
					'Peringatan !!!',
					'Pastikan Data Lokasi, Kode Induk, Tempat Makan Lama, Tempat Makan Baru Sudah Terisi',
					'warning'
				)
			}
		}else{
			Swal.fire(
				'Peringatan !!!',
				'Pastikan Data Pekerjaan/Seksi/Unit/Bidang/Dept Sudah Terisi',
				'warning'
			)
		}
	})
})
// end edit tempat makan