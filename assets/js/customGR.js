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

const print = async _ => {
	const element = document.getElementById('table-rekap-sdm');
	new Promise(resolve => {
		loading.showInButton(document.getElementById('icon-button-print'), 'fa-print');
		//element.parentNode.style.display = 'block';
		resolve();
	}). then( _ => {
		setTimeout( _ => {
			html2canvas(element, {
				scale: 1,
				onclone: doc => {
					doc.getElementById('table-rekap-sdm').style.display = 'block';
					console.log(doc);
				}
			}).then((canvas) => {
				new Promise(resolve => {
					let newWindow = window.open();
					newWindow.document.body.appendChild(canvas);
					newWindow.focus();
					newWindow.print();
					resolve();
				}).then( _ => {
					setTimeout( _ => {
						loading.hideInButton(document.getElementById('icon-button-print'), 'fa-print');
					}, 100);
				});
			});
		}, 250);
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
};