$(document).ready(function(){
	// var trgtK = $('.trgt-karyawan').val();
	// // alert(arr);
	// var ctx = document.getElementById("myChart").getContext('2d');

	// var myChart = new Chart(ctx, {
	// 	type: 'line',
	// 	data: {
	// 		labels: tgl,
	// 		datasets: [{
	// 			label: 'Target Karyawan',
	// 			data: arr,
	// 			backgroundColor: 'rgba(0, 0, 0, 0)',
	// 			borderColor: [
	// 			'rgba(54, 162, 225, 1)'
	// 			],
	// 			borderWidth: 2
	// 		},{
	// 			label: 'Jumlah Karyawan',
	// 			data: kar,
	// 			backgroundColor: 'rgba(0, 0, 0, 0)',
	// 			borderColor: [
	// 			'rgba(251, 136, 60, 0.94)'
	// 			],
	// 			borderWidth: 2
	// 		}]
	// 	},
	// 	options: {
	// 		scales: {
	// 			yAxes: [{
	// 				ticks: {
	// 					beginAtZero:true
	// 				}
	// 			}]
	// 		}
	// 	}
	// });

	// var ctb = document.getElementById("myChartBar").getContext('2d');
	// var myChartBar = new Chart(ctb, {
	// 	type: 'bar',
	// 	data: {
	// 		labels: tgl,
	// 		datasets: [{
	// 			label: 'Jumlah Turun Per Bulan',
	// 			data: jumTur,
	// 			backgroundColor: '#cbc3b1',
	// 			borderWidth: 1
	// 		},{
	// 			label: 'Target Turun Per Bulan',
	// 			data: consta,
	// 			backgroundColor: '#ffbf00',
	// 			borderWidth: 1
	// 		}]
	// 	},
	// 	options: {
	// 		responsive: true,
	// 		scales: {
	// 			yAxes: [{
	// 				ticks: {
	// 					beginAtZero:true
	// 				}
	// 			}]
	// 		}
	// 	}
	// });

	// var ctb2 = document.getElementById("myChartBar2").getContext('2d');
	// var myChartBar = new Chart(ctb2, {
	// 	type: 'bar',
	// 	data: {
	// 		labels: tgl,
	// 		datasets: [{
	// 			label: 'Jumlah Turun Akumulasi',
	// 			data: TurAku,
	// 			backgroundColor: '#cbc3b1',
	// 			borderWidth: 1
	// 		},{
	// 			label: 'Target Turun Akumulasi',
	// 			data: TrgAku,
	// 			backgroundColor: '#ffbf00',
	// 			borderWidth: 1
	// 		}]
	// 	},
	// 	options: {
	// 		responsive: true,
	// 		scales: {
	// 			yAxes: [{
	// 				ticks: {
	// 					beginAtZero:true
	// 				}
	// 			}]
	// 		}
	// 	}
	// });

	// $('#bt_trig').click(function(){
	// 	html2canvas(document.getElementById('myChart'),{scale : 2}).then(function(canvas){
	// 		var imgData = canvas.toDataURL('image/jpg',1.0);
	// 		$('input[name="myChart"]').val(imgData);
	// 	});
	// 	html2canvas(document.getElementById('myChartBar'),{scale : 2}).then(function(canvas){
	// 		var imgData2 = canvas.toDataURL('image/png',1.0);
	// 		$('input[name="myChartBar"]').val(imgData2);
	// 	});
	// 	html2canvas(document.getElementById('myChartBar2'),{scale : 2}).then(function(canvas){
	// 		var imgData3 = canvas.toDataURL('image/png',1.0);
	// 		$('input[name="myChartBar2"]').val(imgData3);
	// 	});
	// 	setTimeout(function () {
	// 			// alert($('input[name="myChartBar2"]').val());
	// 			$('#bt_export').click();
 //    	}, 5000);
	// });	
	$(function(){
	    $('#divselector').change(function(){
	      $('html,body').animate({scrollTop:$('#'+$('#divselector').val()).offset().top}, 'slow'); 
	     })
	});

	$('.grData').change(function(){
		var angka = $('.grData').val();
		var sek = $('.grSek').val();
		// alert(angka);
		if (angka == '2') {
			$('.grDept').prop('disabled', false);
			$('.grDept').select2({
				placeholder: "Departamen",
				minimumResultsForSearch: -1,
				allowClear: false,
				ajax:
				{
					url: baseurl+'RekapTIMSPromosiPekerja/RekapAbsensiPekerja/daftarDepartemen',
					dataType: 'json',
					delay: 500,
					type: 'GET',
					data: function(params){
						return {
							term: params.term
						}
					},
					processResults: function (data){
						return {
							results: $.map(data, function(obj){
								return {id: obj.nama_departemen, text: obj.nama_departemen};
							})
						}
					}
				}
			});
		}else{
			$('.grDept').each(function () {
				$(this).select2('destroy').val("").select2();
			});
			$('.grDept').prop('disabled', true);
			if (sek.length > 1) {
				$('.grSek').each(function () {
					$(this).select2('destroy').val("").select2();
				});
			}
			$('.grSek').prop('disabled', true);
		}
	});

	$('.grDept').change(function(){
		if ($('.grSek').val().length > 1) {
			$('.grSek').each(function () { //added a each loop here
				$(this).select2('destroy').val("").select2();
			});
		}
		var dept = $('.grDept').val();
		if (dept == "SEMUA DEPARTEMEN") {
			$('.grSek').prop('disabled', true);
			if ($('.grSek').val().length > 1) {
			$('.grSek').each(function () { //added a each loop here
				$(this).select2('destroy').val("").select2();
			});
		}
	}else{
		$('.grSek').prop('disabled', false);
		$('.grSek').select2({
			placeholder: "Seksi",
			searching: true,
			minimumInputLength: 3,
			allowClear: false,
			ajax:
			{
				url: baseurl+'SDM/data',
				dataType: 'json',
				delay: 500,
				type: 'POST',
				data: function(params){
					return {
						term: params.term,
						dept: dept
					}
				},
				processResults: function (data){
					return {
						results: $.map(data, function(obj){
							return {id: obj.kodesie, text: obj.seksi};
						})
					}
				}
			}
		});
	}
		// alert($('.grSek').val().le);
	})
	if (proses == 'true') {		
		// alert(inde);
		for (var i = 1; i <= inde; i++) {
			var arrayname = "targetKaryawan";
			var number = window[arrayname][i];
			var arrayname2 = "jumlahKaryawan";
			var number2 = window[arrayname2][i];
			var arrayname3 = "trgTurunBln";
			var number3 = window[arrayname3][i];
			var arrayname4 = "jumTurunBln";
			var number4 = window[arrayname4][i];
			var arrayname5 = "trgAkumulasi";
			var number5 = window[arrayname5][i];
			var arrayname6 = "turAkumulasi";
			var number6 = window[arrayname6][i];

			var chartt = "myChart"+(i-1);
			var chartt2 = "myChartbar1"+(i-1);
			var chartt3 = "myChartbar2"+(i-1);
			// alert(i);

			// alert(targetKaryawan[i]);
			var ctx = document.getElementById(chartt).getContext('2d');
			var maxValueInArray = Math.max.apply(Math, number);
			var xx = '';
			if (Number(maxValueInArray) < 10) {
				xx = 'stepSize: 1';
				// alert(number);
			}else{
				xx = '';
			}

			var myChart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: tgl,
					datasets: [{
						label: 'Target Karyawan',
						data: number,
						backgroundColor: 'rgba(0, 0, 0, 0)',
						borderColor: [
						'rgba(54, 162, 225, 1)'
						],
						borderWidth: 2
					},{
						label: 'Jumlah Karyawan',
						data: number2,
						backgroundColor: 'rgba(0, 0, 0, 0)',
						borderColor: [
						'rgba(251, 136, 60, 0.94)'
						],
						borderWidth: 2
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero:true,xx,
								suggestedMax: 10
							}
						}]
					}
				}
			});
			// alert(number4);
			var ctb = document.getElementById(chartt2).getContext('2d');
			var myChartBar = new Chart(ctb, {
				type: 'bar',
				data: {
					labels: tgl,
					datasets: [{
						label: 'Jumlah Turun Per Bulan',
						data: number4,
						backgroundColor: '#cbc3b1',
						borderWidth: 1
					},{
						label: 'Target Turun Per Bulan',
						data: number3,
						backgroundColor: '#ffbf00',
						borderWidth: 1
					}]
				},
				options: {
					responsive: true,
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero:true
							}
						}]
					}
				}
			});

			var ctb2 = document.getElementById(chartt3).getContext('2d');
			var myChartBar = new Chart(ctb2, {
				type: 'bar',
				data: {
					labels: tgl,
					datasets: [{
						label: 'Jumlah Turun Akumulasi',
						data: number6,
						backgroundColor: '#cbc3b1',
						borderWidth: 1
					},{
						label: 'Target Turun Akumulasi',
						data: number5,
						backgroundColor: '#ffbf00',
						borderWidth: 1
					}]
				},
				options: {
					responsive: true,
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero:true
							}
						}]
					}
				}
			});
		}
	}

	$('#btnExportSDM').click(function(){
		// $("select#grapicID option").each(function(){
		// 	alert($(this).val());
		// });
		var angka = ["13", "0", "1","2","3","4","5","6","7","8","9","10", "11", "12","14","15","16","17"];
		
		var tampungan1 = [];
		var tampungan2 = [];
		var tampungan3 = [];
		var tampungan4 = [];
		angka.forEach(function(item) {
			var chartt = "myChart"+(item);
			var chartt2 = "myChartbar"+(item);
			var chartt3 = "myChartbar2"+(item);
			var tabel = "SDMdivToCan"+(item);
			alert(tabel);
			var canvas1 = document.getElementById(chartt);
			var imgData1 = canvas1.toDataURL('image/jpg',1.0);
			var canvas2 = document.getElementById(chartt2);
			var imgData2 = canvas2.toDataURL('image/jpg',1.0);
			var canvas3 = document.getElementById(chartt3);
			var imgData3 = canvas3.toDataURL('image/jpg',1.0);
			html2canvas(document.getElementById(tabel),{scale : 2}).then(function(canvas){
				var imgData4 = canvas.toDataURL('image/png',1.0);
				alert(imgData4);
			});
			tampungan1.push(imgData1);
			tampungan2.push(imgData2);
			tampungan3.push(imgData3);
			// alert(chartt);
		});
			// alert(tampungan.length);
			$.ajax({
				type: "POST",
				url: baseurl+"SDM/exportGambar",
				data: {
					data1:tampungan1,
					data2:tampungan2,
					data3:tampungan3,
					data4:tampungan4,
				},
				success: function (response) {
					alert(angka);
				}
			});
		});	
});