document.addEventListener('DOMContentLoaded', async _ => {
	await unlockForm();
	if (proses && filterData != 'tabelseksi') {
		await initGraph();
		setOnClickListener();
	}
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

const print = async _ => {
	const table = document.getElementById('table-rekap-sdm');
	const chart1 = document.getElementById('chart1');
	const chart2 = document.getElementById('chartBar1');
	const chart3 = document.getElementById('chartBar2');
	new Promise(resolve => {
		loading.showInButton(document.getElementById('icon-button-print'), 'fa-print');
		resolve();
	}).then( _ => {
		new Promise(resolve => {
			let win;
			html2canvas(table, {
				scale: 2,
				letterRendering: true,
				onclone: doc => {
					doc.getElementById('table-rekap-sdm').style.display = 'block';
				}
			}).then(table_canvas => {
				table_canvas.webkitImageSmoothingEnabled = false;
				table_canvas.mozImageSmoothingEnabled = false;
				table_canvas.imageSmoothingEnabled = false;
				win = window.open();
				win.document.body.appendChild(table_canvas);
				html2canvas(chart1, {
					scale: 2,
					letterRendering: true
				}).then(chart1_canvas => {
					win.document.body.appendChild(chart1_canvas);
					html2canvas(chart2, {
						scale: 2,
						letterRendering: true
					}).then(chart2_canvas => {
						win.document.body.appendChild(chart2_canvas);
						html2canvas(chart3, {
							scale: 2,
							letterRendering: true
						}).then(chart3_canvas => {
							win.document.body.appendChild(chart3_canvas);
							win.focus();
							win.print();
							resolve();
						});
					});
				});
			});
		}).then( _ => {
			loading.hideInButton(document.getElementById('icon-button-print'), 'fa-print');
		});
	});
};

const save = async _ => {
	new Promise( resolve => {
		loading.showInButton(document.getElementById('icon-button-save'), 'fa-floppy-o');
		$("#table-rekap-sdm").table2excel({
			filename: document.getElementById('title').innerHTML + ' - ' + document.getElementById('data-title').innerHTML + '.xls',
			preserveColors: true
		});
		resolve();
	}).then( _ => {
		setTimeout(_ => {
			loading.hideInButton(document.getElementById('icon-button-save'), 'fa-floppy-o');
		}, 500);
	});
};