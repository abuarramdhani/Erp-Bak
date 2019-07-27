$(document).ready(function(){
	
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

			var semua1 = "targetKaryawan";
			var semua1 = window[semua1][1];
			var semua2 = "jumlahKaryawan";
			var semua2 = window[semua2][1];
			var semua3 = "trgTurunBln";
			var semua3 = window[semua3][1];
			var semua4 = "jumTurunBln";
			var semua4 = window[semua4][1];
			var semua5 = "trgAkumulasi";
			var semua5 = window[semua5][1];
			var semua6 = "turAkumulasi";
			var semua6 = window[semua6][1];

			var langsung1 = "targetKaryawan";
			var langsung1 = window[langsung1][13];
			var langsung2 = "jumlahKaryawan";
			var langsung2 = window[langsung2][13];
			var langsung3 = "trgTurunBln";
			var langsung3 = window[langsung3][13];
			var langsung4 = "jumTurunBln";
			var langsung4 = window[langsung4][13];
			var langsung5 = "trgAkumulasi";
			var langsung5 = window[langsung5][13];
			var langsung6 = "turAkumulasi";
			var langsung6 = window[langsung6][13];

			var tdklangsung1 = "targetKaryawan";
			var tdklangsung1 = window[tdklangsung1][12];
			var tdklangsung2 = "jumlahKaryawan";
			var tdklangsung2 = window[tdklangsung2][12];
			var tdklangsung3 = "trgTurunBln";
			var tdklangsung3 = window[tdklangsung3][12];
			var tdklangsung4 = "jumTurunBln";
			var tdklangsung4 = window[tdklangsung4][12];
			var tdklangsung5 = "trgAkumulasi";
			var tdklangsung5 = window[tdklangsung5][12];
			var tdklangsung6 = "turAkumulasi";
			var tdklangsung6 = window[tdklangsung6][12];

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

			if (i == 1) {
			var myChart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: tgl,
					datasets: [{
						label: 'Target Semua Karyawan',
						data: semua1,
						backgroundColor: 'rgba(0, 0, 0, 0)',
						borderColor: [
						'rgba(54, 162, 225, 1)'
						],
						borderWidth: 2
					},{
						label: 'Jumlah Semua Karyawan',
						data: semua2,
						backgroundColor: 'rgba(0, 0, 0, 0)',
						borderColor: [
						'rgba(251, 136, 60, 0.94)'
						],
						borderWidth: 2
					},{
						label: 'Target Semua Karyawan Langsung',
						data: langsung1,
						backgroundColor: 'rgba(0, 0, 0, 0)',
						borderColor: [
						'rgba(54, 162, 225, 1)'
						],
						borderWidth: 2
					},{
						label: 'Jumlah Semua Karyawan Langsung',
						data: langsung2,
						backgroundColor: 'rgba(0, 0, 0, 0)',
						borderColor: [
						'rgb(0, 204, 0)'
						],
						borderWidth: 2
					},{
						label: 'Target Semua Karyawan Tidak Langsung',
						data: tdklangsung1,
						backgroundColor: 'rgba(0, 0, 0, 0)',
						borderColor: [
						'rgba(54, 162, 225, 1)'
						],
						borderWidth: 2
					},{
						label: 'Jumlah Semua Karyawan Tidak Langsung',
						data: tdklangsung2,
						backgroundColor: 'rgba(0, 0, 0, 0)',
						borderColor: [
						'rgb(255, 0, 0)'
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
		}else{
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
		}
			// alert(number4);
			var ctb = document.getElementById(chartt2).getContext('2d');
			if (i == 1 ) {
				var myChartBar = new Chart(ctb, {
				type: 'bar',
				data: {
					labels: tgl,
					datasets: [{
						label: 'Target Semua Karyawan Turun Per Bulan',
						data: number3,
						backgroundColor: 'rgba(54, 162, 225, 1)',
						borderWidth: 1
					},{
						label: 'Jumlah Semua Karyawan Turun Per Bulan',
						data: number4,
						backgroundColor: '(251, 136, 60, 0.94)',
						borderWidth: 1
					},{
						label: 'Jumlah Semua Karyawan Langsung Turun Per Bulan',
						data: number4,
						backgroundColor: '#ff0000',
						borderWidth: 1
					},{
						label: 'Jumlah Semua Karyawan Tidak Langsung Turun Per Bulan',
						data: number4,
						backgroundColor: '#00cc00',
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
			} else {
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
			}

			var ctb2 = document.getElementById(chartt3).getContext('2d');
			if (i == 1) {
				var myChartBar = new Chart(ctb2, {
				type: 'bar',
				data: {
					labels: tgl,
					datasets: [{
						label: 'Target Semua Karyawan Turun Akumulasi',
						data: number5,
						backgroundColor: 'rgba(54, 162, 225, 1)',
						borderWidth: 1
					},{
						label: 'Jumlah Semua Karyawan Turun Akumulasi',
						data: number6,
						backgroundColor: '(251, 136, 60, 0.94)',
						borderWidth: 1
					},{
						label: 'Jumlah Semua Karyawan Langsung Akumulasi',
						data: number6,
						backgroundColor: '#ff0000',
						borderWidth: 1
					},{
						label: 'Jumlah Semua Karyawan Tidak Langsung Akumulasi',
						data: number6,
						backgroundColor: '#00cc00',
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
			} else {
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

	$('#sdm_select_tahun').select2({
		allowClear: true,
		placeholder: "Pilih Tahun",
		minimumInputLength: 1,
		tags:true,
		minimumResultsForSearch: -1,
	});

	$('#tabelseksi').DataTable({
        paging	: false,
        filter: false
    });
});