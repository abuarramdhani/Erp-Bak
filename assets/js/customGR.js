document.addEventListener('DOMContentLoaded', async _ => {
	await unlockForm();
	if (proses && filterData != 'tabelseksi') await initGraph();
	setOnClickListener();
});

const animation = {
	fadeIn: async (elem) => {
		new Promise(resolve => {
			elem.classList.remove('is-size-gone');
			elem.classList.add('is-size-auto');
			resolve();
		}).then( _ => {
			elem.classList.remove('is-invicible');
			elem.classList.add('is-shown');
		});
	},
	fadeOut: async (elem) => {
		new Promise(resolve => {
			elem.classList.remove('is-shown');
			elem.classList.add('is-invicible');
			resolve();
		}).then( _ => {
			setTimeout( _ => {
				elem.classList.remove('is-size-auto');
				elem.classList.add('is-size-gone');
			}, 250);
		});
	}
};

const setOnClickListener = async _ => {
	document.getElementById('button-fullscreen').removeEventListener('click', showFullscreen);
	document.getElementById('button-fullscreen').addEventListener('click', showFullscreen);
	document.getElementById('button-print').removeEventListener('click', print);
	document.getElementById('button-print').addEventListener('click', print);
	document.getElementById('button-save').removeEventListener('click', save);
	document.getElementById('button-save').addEventListener('click', save);
};

const unlockForm = async _ => {
	document.getElementById('filter-data').disabled = false;
	if (filterData !== '') setSelectedFilterData();
	if (withPKL === 'on') setSelectedWithPKL();
};

const initGraph = async _ => {
	await showChart1();
	await showChartBar1();
	await showChartBar2();
};

const showChart1 = async _ => {
	const contextChart1 = document.getElementById('chart1').getContext('2d');
	const stepSize = (Number(Math.max.apply(Math, targetKaryawan)) < 10) ? 'stepSize: 1' : '';
	if (nama === 'Semua Data') {
		new Chart(contextChart1, {
			type: 'line',
			data: {
				labels: tgl,
				datasets: [{
					label: 'Target Semua Karyawan',
					data: targetKaryawan,
					backgroundColor: 'rgba(0, 0, 0, 0)',
					borderColor: 'rgba(54, 162, 225, 1)',
					borderWidth: 2
				}, {
					label: 'Jumlah Semua Karyawan',
					data: jumlahKaryawan,
					backgroundColor: 'rgba(0, 0, 0, 0)',
					borderColor: 'rgba(251, 136, 60, 0.94)',
					borderWidth: 2
				}
				// , {
				// 	label: 'Target Semua Karyawan Langsung',
				// 	data: targetSemuaKaryawanLangsung,
				// 	backgroundColor: 'rgba(0, 0, 0, 0)',
				// 	borderColor: 'rgba(54, 162, 225, 1)',
				// 	borderWidth: 2
				// }, {
				// 	label: 'Jumlah Semua Karyawan Langsung',
				// 	data: jumlahSemuaKaryawanLangsung,
				// 	backgroundColor: 'rgba(0, 0, 0, 0)',
				// 	borderColor: 'rgb(0, 204, 0)',
				// 	borderWidth: 2
				// }, {
				// 	label: 'Target Semua Karyawan Tidak Langsung',
				// 	data: targetSemuaKaryawanTidakLangsung,
				// 	backgroundColor: 'rgba(0, 0, 0, 0)',
				// 	borderColor: 'rgba(54, 162, 225, 1)',
				// 	borderWidth: 2
				// }, {
				// 	label: 'Jumlah Semua Karyawan Tidak Langsung',
				// 	data: jumlahSemuaKaryawanTidakLangsung,
				// 	backgroundColor: 'rgba(0, 0, 0, 0)',
				// 	borderColor: 'rgb(255, 0, 0)',
				// 	borderWidth: 2
				// }
				]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true, stepSize,
							suggestedMax: 10
						}
					}]
				}
			}
		});
	} else {
		new Chart(contextChart1, {
			type: 'line',
			data: {
				labels: tgl,
				datasets: [{
					label: 'Target Karyawan',
					data: targetKaryawan,
					backgroundColor: 'rgba(0, 0, 0, 0)',
					borderColor: 'rgba(54, 162, 225, 1)',
					borderWidth: 2
				},{
					label: 'Jumlah Karyawan',
					data: jumlahKaryawan,
					backgroundColor: 'rgba(0, 0, 0, 0)',
					borderColor: 'rgba(251, 136, 60, 0.94)',
					borderWidth: 2
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true, stepSize,
							suggestedMax: 10
						}
					}]
				}
			}
		});
	}
};

const showChartBar1 = async _ => {
	const contextChartBar1 = document.getElementById('chartBar1').getContext('2d');
	if (nama === 'Semua Data') {
		new Chart(contextChartBar1, {
			type: 'bar',
			data: {
				labels: tgl,
				datasets: [{
					label: 'Target Semua Karyawan Turun Per Bulan',
					data: targetTurunPerBulan,
					backgroundColor: 'rgba(54, 162, 225, 1)',
					borderWidth: 1
				}, {
					label: 'Jumlah Semua Karyawan Turun Per Bulan',
					data: jumlahTurunPerBulan,
					backgroundColor: 'rgba(251, 136, 60, 0.94)',
					borderWidth: 1
				}
				// , {
				// 	label: 'Jumlah Semua Karyawan Langsung Turun Per Bulan',
				// 	data: jumlahSemuaKaryawanLangsungTurunPerBulan,
				// 	backgroundColor: '#ff0000',
				// 	borderWidth: 1
				// }, {
				// 	label: 'Jumlah Semua Karyawan Tidak Langsung Turun Per Bulan',
				// 	data: jumlahSemuaKaryawanTidakLangsungTurunPerBulan,
				// 	backgroundColor: '#00cc00',
				// 	borderWidth: 1
				// }
				]
			},
			options: {
				responsive: true,
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				}
			}
		});
	} else {
		new Chart(contextChartBar1, {
			type: 'bar',
			data: {
				labels: tgl,
				datasets: [{
					label: 'Target Turun Per Bulan',
					data: targetTurunPerBulan,
					backgroundColor: 'rgba(54, 162, 225, 1)',
					borderWidth: 1
				}, {
					label: 'Jumlah Turun Per Bulan',
					data: jumlahTurunPerBulan,
					backgroundColor: 'rgba(251, 136, 60, 0.94)',
					borderWidth: 1
				}]
			},
			options: {
				responsive: true,
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				}
			}
		});
	}
};

const showChartBar2 = async _ => {
	const contextChartBar2 = document.getElementById('chartBar2').getContext('2d');
	if (nama === 'Semua Data') {
		new Chart(contextChartBar2, {
			type: 'bar',
			data: {
				labels: tgl,
				datasets: [{
					label: 'Target Semua Karyawan Turun Akumulasi',
					data: targetTurunAkumulasi,
					backgroundColor: 'rgba(54, 162, 225, 1)',
					borderWidth: 1
				}, {
					label: 'Jumlah Semua Karyawan Turun Akumulasi',
					data: jumlahTurunAkumulasi,
					backgroundColor: 'rgba(251, 136, 60, 0.94)',
					borderWidth: 1
				}
				// , {
				// 	label: 'Jumlah Semua Karyawan Langsung Akumulasi',
				// 	data: jumlahSemuaKaryawanTurunLangsungAkumulasi,
				// 	backgroundColor: '#ff0000',
				// 	borderWidth: 1
				// }, {
				// 	label: 'Jumlah Semua Karyawan Tidak Langsung Akumulasi',
				// 	data: jumlahSemuaKaryawanTurunTidakLangsungAkumulasi,
				// 	backgroundColor: '#00cc00',
				// 	borderWidth: 1
				// }
				]
			},
			options: {
				responsive: true,
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				}
			}
		});
	} else {
		new Chart(contextChartBar2, {
			type: 'bar',
			data: {
				labels: tgl,
				datasets: [{
					label: 'Target Turun Akumulasi',
					data: targetTurunAkumulasi,
					backgroundColor: 'rgba(54, 162, 225, 1)',
					borderWidth: 1
				}, {
					label: 'Jumlah Turun Akumulasi',
					data: jumlahTurunAkumulasi,
					backgroundColor: 'rgba(251, 136, 60, 0.94)',
					borderWidth: 1
				}]
			},
			options: {
				responsive: true,
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				}
			}
		});
	}
};

const setSelectedFilterData = async _ => {
	document.getElementById('filter-data').value = filterData;
};

const setSelectedWithPKL = async _ => {
	$('#pkl-checkbox').iCheck('check');
	document.getElementById('pkl-checkbox').style.display = 'block';
};

const showFullscreen = async _ => {
	const element = document.getElementById('box-body-data');
	if (element.requestFullscreen) {
		element.requestFullscreen();
	} else if (element.mozRequestFullScreen) {
		element.mozRequestFullScreen();
	} else if (element.webkitRequestFullscreen) {
		element.webkitRequestFullscreen();
	} else if (element.msRequestFullscreen) {
		element.msRequestFullscreen();
	}
};

const print = async (id) => {
	const element = document.getElementById('box-' + id);
	const buttonPrint = document.getElementById('button-print-');
	loading.showInButton(buttonPrint, 'fa-print');
	html2canvas(element, {
		scale: 1,
		height: 600
	}).then((canvas) => {
		setTimeout(_ => {
			new Promise(resolve => {
				let newWindow = window.open();
				newWindow.document.body.appendChild(canvas);
				newWindow.focus();
				newWindow.print();
				resolve();
			}).then(_ => {
				setTimeout(_ => {
					loading.hideInButton(buttonPrint, 'fa-print');
				}, 1000);
			});
		}, 500);
	});
};

const save = async (id) => {
	// const element = document.getElementById('box-' + id);
	// const buttonSave = document.getElementById('btn-save-' + id);
	// let title = 'Grafik Jumlah Pekerja 2018 vs 2019 (tanpa PKL, Magang & TKPW)';
	// if(id == 1) title = 'Grafik Jumlah Pekerja 2018 vs 2019 (termasuk PKL, Magang & TKPW)';
	// loading.showInButton(buttonSave, 'fa-floppy-o');
	// html2canvas(element, {
	// 	scale: 1,
	// 	height: 600
	// }).then((canvas) => {
	// 	setTimeout(_ => {
	// 		let doc = new jsPDF('L', 'mm', 'a4');
	// 		doc.addImage(canvas.toDataURL('image/jpeg'), 'JPEG', 8, 8);
	// 		doc.save(title + '.pdf', { 
	// 			returnPromise: true
	// 		}).then(_ => {
	// 			setTimeout(_ => {
	// 				loading.hideInButton(buttonSave, 'fa-floppy-o');
	// 			}, 2500);
	// 		});
	// 	}, 500);
	// });

	// const table_html = document.getElementById('tableRekapSDM').outerHTML.replace(/ /g, '%20');
	// let a = document.createElement('a');
	// a.href = 'data:application/vnd.ms-excel, ' + table_html;
	// a.download = 'exported_table_' + Math.floor((Math.random() * 9999999) + 1000000) + '.xls';
	// a.click();
	$("#tableRekapSDM").table2excel({
		name: 'Worksheet Name',
		filename: 'test.xls',
		preserveColors: true
		
	});
};

// $('#divselector').change(_ => {
// 	$('html,body').animate({scrollTop:$('#'+$('#divselector').val()).offset().top}, 'fast'); 
// });

// $('.grData').change(async _ => {
// 	var angka = $('.grData').val();
// 	var sek = $('.grSek').val();
// 	if (angka == '2') {
// 		$('.grDept').prop('disabled', false);
// 		$('.grDept').select2({
// 			placeholder: "Departamen",
// 			minimumResultsForSearch: -1,
// 			allowClear: false,
// 			ajax:
// 			{
// 				url: baseurl+'RekapTIMSPromosiPekerja/RekapAbsensiPekerja/daftarDepartemen',
// 				dataType: 'json',
// 				delay: 500,
// 				type: 'GET',
// 				data: function(params){
// 					return {
// 						term: params.term
// 					}
// 				},
// 				processResults: function (data){
// 					return {
// 						results: $.map(data, function(obj){
// 							return {id: obj.nama_departemen, text: obj.nama_departemen};
// 						})
// 					}
// 				}
// 			}
// 		});
// 	} else {
// 		$('.grDept').each(function () {
// 			$(this).select2('destroy').val("").select2();
// 		});
// 		$('.grDept').prop('disabled', true);
// 		if (sek.length > 1) {
// 			$('.grSek').each(function () {
// 				$(this).select2('destroy').val("").select2();
// 			});
// 		}
// 		$('.grSek').prop('disabled', true);
// 	}
// });

// $('.grDept').change(async _ => {
// 	if ($('.grSek').val().length > 1) {
// 		$('.grSek').each(function () { //added a each loop here
// 			$(this).select2('destroy').val("").select2();
// 		});
// 	}
// 	var dept = $('.grDept').val();
// 	if (dept == "SEMUA DEPARTEMEN") {
// 		$('.grSek').prop('disabled', true);
// 		if ($('.grSek').val().length > 1) {
// 			$('.grSek').each( _ => { //added a each loop here
// 				$(this).select2('destroy').val("").select2();
// 			});
// 		}
// 	} else {
// 		$('.grSek').prop('disabled', false);
// 		$('.grSek').select2({
// 			placeholder: "Seksi",
// 			searching: true,
// 			minimumInputLength: 3,
// 			allowClear: false,
// 			ajax:
// 			{
// 				url: baseurl+'SDM/data',
// 				dataType: 'json',
// 				delay: 500,
// 				type: 'POST',
// 				data: function(params){
// 					return {
// 						term: params.term,
// 						dept: dept
// 					}
// 				},
// 				processResults: function (data){
// 					return {
// 						results: $.map(data, function(obj){
// 							return {id: obj.kodesie, text: obj.seksi};
// 						})
// 					}
// 				}
// 			}
// 		});
// 	}
// })

// $('#btnExportSDM').click(async _ => {
// 	var angka = ["13", "0", "1","2","3","4","5","6","7","8","9","10", "11", "12","14","15","16","17"];
// 	var tampungan1 = [];
// 	var tampungan2 = [];
// 	var tampungan3 = [];
// 	var tampungan4 = [];

// 	angka.forEach(item => {
// 		var chartt = "myChart"+(item);
// 		var chartt2 = "myChartbar"+(item);
// 		var chartt3 = "myChartbar2"+(item);
// 		var tabel = "SDMdivToCan"+(item);
// 		alert(tabel);
// 		var canvas1 = document.getElementById(chartt);
// 		var imgData1 = canvas1.toDataURL('image/jpg',1.0);
// 		var canvas2 = document.getElementById(chartt2);
// 		var imgData2 = canvas2.toDataURL('image/jpg',1.0);
// 		var canvas3 = document.getElementById(chartt3);
// 		var imgData3 = canvas3.toDataURL('image/jpg',1.0);
// 		html2canvas(document.getElementById(tabel),{scale : 2}).then(function(canvas){
// 			var imgData4 = canvas.toDataURL('image/png',1.0);
// 			alert(imgData4);
// 		});
// 		tampungan1.push(imgData1);
// 		tampungan2.push(imgData2);
// 		tampungan3.push(imgData3);
// 	});

// 	$.ajax({
// 		type: "POST",
// 		url: baseurl+"SDM/exportGambar",
// 		data: {
// 			data1:tampungan1,
// 			data2:tampungan2,
// 			data3:tampungan3,
// 			data4:tampungan4,
// 		},
// 		success: _ => {
// 			alert(angka);
// 		}
// 	});
// });	

// $('#sdm_select_tahun').select2({
// 	allowClear: true,
// 	placeholder: "Pilih Tahun",
// 	minimumInputLength: 1,
// 	tags:true,
// 	minimumResultsForSearch: -1,
// });

// $('#tabelseksi').DataTable({
//     paging	: false,
//     filter: false
// });