<script src="<?= base_url('assets/plugins/chartjs/Chart.js') ?>"></script>
<style type="text/css">
	body { scroll-behavior: smooth; }
	@page, .box-body { size: landscape; }
	.box-body { background-color: #ffffff; }
	canvas {
		transition: height 350ms ease-in-out, opacity 750ms ease-in-out;
		display: none;
		opacity: 0;
	}
	canvas.is-visible {
		height: auto;
		display: block;
		opacity: 1;
	}
	.loading-chart {
		transition: height 350ms ease-in-out, opacity 750ms ease-in-out;
		display: none;
		opacity: 0;
		margin-top: 12px;
	}
	.loading-chart.is-visible {
		height: auto;
		display: block;
		opacity: 1;
	}
</style>
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left" style="margin-top: -12px; margin-bottom: 18px;">
							<h1><b>Trend Jumlah Pekerja</b></h1>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<div class="btn-group pull-right">
									<button class="btn btn-primary" onclick="javascript:showFullscreen(0);"><i style="margin-right: 8px;" class="fa fa-desktop"></i>Show in Fullscreen</button>
									<button class="btn btn-primary" onclick="javascript:print(0);"><i id="btn-print-0" style="margin-right: 8px;" class="fa fa-print"></i>Print</button>
									<button class="btn btn-primary" onclick="javascript:save(0);"><i id="btn-save-0" style="margin-right: 8px;" class="fa fa-floppy-o"></i>Save</button>
								</div>
							</div>
							<div class="box-body" id="box-0">
								<form method="post" action="<?php echo base_url('Sdm/Grafik/TrendJumlahPekerja'); ?>">
									<div class="panel-body">
										<div class="form-inline">
											<div class="form-group" style="width: 100%;">
												<div id="chart-title-0">
													<h2 style="margin-top: -8px;">Grafik Jumlah Pekerja 2018 vs 2019 <small>TANPA PKL, Magang & TKPW</small></h2>
													<small>Data Per Tanggal 1 Setiap bulannya.</small>
												</div>
												<div id="loading-chart-0" class="loading-chart"><b>Memuat data...</b></div>
												<canvas id="chart-0"></canvas>	
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<div class="btn-group pull-right">
									<button class="btn btn-primary" onclick="javascript:showFullscreen(1);"><i style="margin-right: 8px;" class="fa fa-desktop"></i>Show in Fullscreen</button>
									<button class="btn btn-primary" onclick="javascript:print(1);"><i id="btn-print-1" style="margin-right: 8px;" class="fa fa-print"></i>Print</button>
									<button class="btn btn-primary" onclick="javascript:save(1);"><i id="btn-save-1" style="margin-right: 8px;" class="fa fa-floppy-o"></i>Save</button>
								</div>
							</div>
							<div class="box-body" id="box-1">
								<form method="post" action="<?php echo base_url('Sdm/Grafik/TrendJumlahPekerja'); ?>">
									<div class="panel-body">
										<div class="form-inline">
											<div class="form-group" style="width: 100%;">
												<div id="chart-title-1">
													<h2 style="margin-top: -8px;">Grafik Jumlah Pekerja 2018 vs 2019 <small>TERMASUK PKL, Magang & TKPW</small></h2>
													<small>Data Per Tanggal 1 Setiap bulannya.</small>
												</div>
												<div id="loading-chart-1" class="loading-chart"><b>Memuat data...</b></div>
												<canvas id="chart-1"></canvas>	
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	const animation = {
		fadeIn: async (elem) => {
			const getHeight = _ => {
				elem.style.display = 'block';
				var height = elem.scrollHeight + 'px';
				elem.style.display = '';
				return height;
			};
			var height = getHeight();
			elem.classList.add('is-visible');
			elem.style.height = height;
			setTimeout(_ => {
				elem.style.height = '';
			}, 350);
		},
		fadeOut: async (elem) => {
			elem.style.height = elem.scrollHeight + 'px';
			setTimeout(_ => {
				elem.style.height = '0';
			}, 1);
			setTimeout(_ => {
				elem.classList.remove('is-visible');
			}, 350);
		}
	};

	document.addEventListener('DOMContentLoaded', async _ => {
		let ctx0 = document.getElementById('chart-0');
		const loadingCtx0 = document.getElementById('loading-chart-0');
		let ctx1 = document.getElementById('chart-1');
		const loadingCtx1 = document.getElementById('loading-chart-1');
		animation.fadeIn(loadingCtx0);
		animation.fadeIn(loadingCtx1);
		fetch('<?= base_url() ?>Sdm/Grafik/getTrendJumlahPekerjaEmployee')
			.then(response => response.json())
			.then(data => {
				let labels = '', data2018 = '', data2019 = '', data2019MonthCounter = 1;

				ctx0.style.backgroundColor = '#ffffff';

				data.tabel2019.forEach(list => { labels += `${list.bulan},`; });
				labels = labels.slice(0, labels.length - 1);
				labels = labels.split(',');

				data.tabel2018.forEach(list => { data2018 += `${list.tahun},`; });	
				data2018 = data2018.slice(0, data2018.length - 1);
				data2018 = data2018.split(',');
				
				const currentMonth = new Date().getMonth() + 1;
				data.tabel2019.forEach(list => { data2019 += `${((currentMonth >= data2019MonthCounter) ? list.tahun : 0 )},`; data2019MonthCounter++; });	
				data2019 = data2019.slice(0, data2019.length - 1);
				data2019 = data2019.split(',');

				new Chart(ctx0, {
					type: 'line',
					data: {
						labels: labels,
						datasets: [
							{
								label: 'Tahun 2018',
								data: data2018,
								fill: false,
								backgroundColor: 'rgb(54, 162, 235)',
								borderColor: 'rgb(54, 162, 235)',
								lineTension: 0.1
							}, {
								label: 'Tahun 2019',
								data: data2019,
								fill: false,
								backgroundColor: 'rgb(255, 99, 132)',
								borderColor: 'rgb(255, 99, 132)',
								lineTension: 0.1
							}
						]
					}, 
					options: {
						events: 'click',
						responsive: true,
						animation: {
							duration: 1,
							onComplete: function () {
								var chartInstance = this.chart,
								ctx = chartInstance.ctx;
								ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
								ctx.textAlign = 'center';
								ctx.fillStyle = '#666';
								ctx.textBaseline = 'bottom';
								this.data.datasets.forEach(function (dataset, i) {
									var meta = chartInstance.controller.getDatasetMeta(i);
									meta.data.forEach(function (bar, index) {
										var data = dataset.data[index];                            
										ctx.fillText(data, bar._model.x, bar._model.y - 5);
									});
								});
							}
						}
					}
				});
			})
			.then(_ => {
				new Promise(resolve => {
					animation.fadeOut(loadingCtx0);
					resolve();
				}).then( _ => {
					animation.fadeIn(ctx0);
				});
			})
			.then(_ => {
				fetch('<?= base_url() ?>Sdm/Grafik/getTrendJumlahPekerjaPkl')
					.then(response => response.json())
					.then(data => {
						let labels = '', data2018 = '', data2019 = '', data2019MonthCounter = 1;
						
						ctx1.style.backgroundColor = '#ffffff';

						data.tabel2019pkl.forEach(list => { labels += `${list.bulan},`; });
						labels = labels.slice(0, labels.length - 1);
						labels = labels.split(',');

						data.tabel2018pkl.forEach(list => { data2018 += `${list.tahun},`; });	
						data2018 = data2018.slice(0, data2018.length - 1);
						data2018 = data2018.split(',');
						
						const currentMonth = new Date().getMonth() + 1;
						data.tabel2019pkl.forEach(list => { data2019 += `${((currentMonth >= data2019MonthCounter) ? list.tahun : 0 )},`; data2019MonthCounter++; });	
						data2019 = data2019.slice(0, data2019.length - 1);
						data2019 = data2019.split(',');

						new Chart(ctx1, {
							type: 'line',
							data: {
								labels: labels,
								datasets: [
									{
										label: 'Tahun 2018',
										data: data2018,
										fill: false,
										backgroundColor: 'rgb(54, 162, 235)',
										borderColor: 'rgb(54, 162, 235)',
										lineTension: 0.1
									}, {
										label: 'Tahun 2019',
										data: data2019,
										fill: false,
										backgroundColor: 'rgb(255, 99, 132)',
										borderColor: 'rgb(255, 99, 132)',
										lineTension: 0.1
									}
								]
							}, 
							options: {
								events: 'click',
								responsive: true,
								animation: {
									duration: 1,
									onComplete: function () {
										var chartInstance = this.chart,
										ctx = chartInstance.ctx;
										ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
										ctx.textAlign = 'center';
										ctx.fillStyle = '#666';
										ctx.textBaseline = 'bottom';
										this.data.datasets.forEach(function (dataset, i) {
											var meta = chartInstance.controller.getDatasetMeta(i);
											meta.data.forEach(function (bar, index) {
												var data = dataset.data[index];                            
												ctx.fillText(data, bar._model.x, bar._model.y - 5);
											});
										});
									}
								}
							}
						});
					})
					.then( _ => {
						new Promise(resolve => {
							animation.fadeOut(loadingCtx1);
							resolve();
						}).then( _ => {
							animation.fadeIn(ctx1);
						});
					})
					.catch(e => {
						loadingCtx1.innerHTML = 'Terjadi kesalahan saat memuat data Grafik 2';
						loadingCtx1.style.color = 'red';
						loadingCtx1.style.fontWeight = 'bold';
						$.toaster('Terjadi kesalahan saat memuat data Grafik 2', '', 'danger');
						console.log('Terjadi kesalahan saat memuat data Grafik 2 | ' + e);
					});
			})
			.catch(e => {
				loadingCtx0.innerHTML = 'Terjadi kesalahan saat memuat data Grafik 1';
				loadingCtx0.style.color = 'red';
				loadingCtx0.style.fontWeight = 'bold';
				loadingCtx1.innerHTML = 'Terjadi kesalahan saat memuat data Grafik 2';
				loadingCtx1.style.color = 'red';
				loadingCtx1.style.fontWeight = 'bold';
				$.toaster('Terjadi kesalahan saat memuat data Grafik 1 dan 2', '', 'danger');
				console.log('Terjadi kesalahan saat memuat data Grafik 1 | ' + e);
			});
	});

	const showFullscreen = async (id) => {
		const element = document.getElementById('box-' + id);
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
		const element = document.getElementById('box-' + id);
		const buttonSave = document.getElementById('btn-save-' + id);
		let title = 'Grafik Jumlah Pekerja 2018 vs 2019 (tanpa PKL, Magang & TKPW)';
		if(id == 1) title = 'Grafik Jumlah Pekerja 2018 vs 2019 (termasuk PKL, Magang & TKPW)';
		loading.showInButton(buttonSave, 'fa-floppy-o');
		html2canvas(element, {
			scale: 1,
			height: 600
		}).then((canvas) => {
			setTimeout(_ => {
				let doc = new jsPDF('L', 'mm', 'a4');
				doc.addImage(canvas.toDataURL('image/jpeg'), 'JPEG', 8, 8);
				doc.save(title + '.pdf', { 
					returnPromise: true
				}).then(_ => {
					setTimeout(_ => {
						loading.hideInButton(buttonSave, 'fa-floppy-o');
					}, 2500);
				});
			}, 500);
		});
	};
</script>