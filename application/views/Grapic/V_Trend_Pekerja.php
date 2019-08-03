<style type="text/css">
	@page, .box-body {
		size: landscape;
	}
	.box-body {
		background-color: #ffffff;
	}
</style>
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left">
							<h1><b>Trend Jumlah Pekerja</b></h1>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<div class="btn-group pull-right">
									<button class="btn btn-primary" onclick="javascript:showFullscreen('box-0');"><i style="margin-right: 8px;" class="fa fa-desktop"></i>Show in Fullscreen</button>
									<button class="btn btn-primary" onclick="javascript:print('box-0');"><i id="btn-print-0" style="margin-right: 8px;" class="fa fa-print"></i>Print</button>
									<button class="btn btn-primary" onclick="javascript:save('box-0', 0);"><i id="btn-save-0" style="margin-right: 8px;" class="fa fa-floppy-o"></i>Save</button>
								</div>
							</div>
							<div class="box-body" id="box-0">
								<form method="post" action="<?php echo base_url('Sdm/Grafik/TrendJumlahPekerja'); ?>">
									<!--<div class="panel-body">
										<div class="form-inline">
											<div class="form-group col-md-12">
												<div class="col-md-2">
													<label class="control-label">Pilih Tahun</label>
												</div>
												<div class="col-md-6">
													<select required="" name="select_tahun[]" style="width: 100%" class="form-control" id="sdm_select_tahun" multiple="multipe">
														<option></option>
														<?php 
														$tahun=date("Y");
														for ($i=2016; $i <= $tahun; $i++) { ?>
														<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="form-group col-md-12" style="margin-top: 20px;">
												<div class="col-md-2">
													<label class="control-label">Hitung Dengan PKL, Magang & TKPW</label>
												</div>
												<div class="col-md-1">
													<input type="checkbox" value="1" name="pkl">
												</div>
											</div>
										</div>
									</div>-->
									<div class="panel-body">
										<div class="form-inline">
											<div class="form-group" style="width: 100%;">
												<h2 style="margin-top: -8px;">Grafik Jumlah Pekerja 2018 vs 2019 <small>TANPA PKL, Magang & TKPW</small></h2>
												<small>Data Per Tanggal 1 Setiap bulannya.</small>
												<canvas id="chartjs-0"></canvas>	
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
									<button class="btn btn-primary" onclick="javascript:showFullscreen('box-1');"><i style="margin-right: 8px;" class="fa fa-desktop"></i>Show in Fullscreen</button>
									<button class="btn btn-primary" onclick="javascript:print('box-1');"><i id="btn-print-1" style="margin-right: 8px;" class="fa fa-print"></i>Print</button>
									<button class="btn btn-primary" onclick="javascript:save('box-1', 1);"><i id="btn-save-1" style="margin-right: 8px;" class="fa fa-floppy-o"></i>Save</button>
								</div>
							</div>
							<div class="box-body" id="box-1">
								<form method="post" action="<?php echo base_url('Sdm/Grafik/TrendJumlahPekerja'); ?>">
									<div class="panel-body">
										<div class="form-inline">
											<div class="form-group" style="width: 100%;">
												<h2 style="margin-top: -8px;">Grafik Jumlah Pekerja 2018 vs 2019 <small>TERMASUK PKL, Magang & TKPW</small></h2>
												<small>Data Per Tanggal 1 Setiap bulannya.</small>
												<canvas id="chartjs-1"></canvas>	
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
<script src="<?= base_url('assets/plugins/chartjs/Chart.js') ?>"></script>
<script>
	document.addEventListener('DOMContentLoaded', () => {
		new Chart(document.getElementById("chartjs-0"), {
			"type":"line",
			"data":{
				"labels":[
				<?php foreach($tabel2017 as $tb) { echo '"'.$tb['bulan'].'",'; } ?>
				],
				"datasets":[
					{
						"label":"Tahun 2018",
						"data":[
							<?php foreach($tabel2018 as $tb){
							echo '"'.$tb['tahun'].'",';}
							?>		
							],
						"fill":false,
						"backgroundColor:":"rgb(54, 162, 235)",
						"borderColor":"rgb(54, 162, 235)",
						"lineTension":0.1
					}, {
						"label":"Tahun 2019",
						"data":[
							<?php
							$bln=1; 
							foreach($tabel2019 as $tb) {
								if(date("n")>=$bln) {
									echo '"'.$tb['tahun'].'",';
								} else {
									echo '"0",';
								}
								$bln++;
							}
							?>
						],
						"fill":false,
						"backgroundColor:":"rgb(255, 99, 132)",
						"borderColor":"rgb(255, 99, 132)",
						"lineTension":0.1
					}
				]
			}, 
			"options":{
				"events": ['click'],
				"animation": {
					"duration": 1,
					onComplete: function () {
						var chartInstance = this.chart,
						ctx = chartInstance.ctx;
						ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
						ctx.textAlign = 'center';
						ctx.fillStyle = "#666";
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
		new Chart(document.getElementById("chartjs-1"), {
			"type":"line",
			"data": {
				"labels": [
					<?php foreach($tabel2017pkl as $tb) { echo '"'.$tb['bulan'].'",'; } ?>
				],
				"datasets": [
					{
						"label":"Tahun 2018",
						"data":[
							<?php foreach($tabel2018pkl as $tb) { echo '"'.$tb['tahun'].'",'; } ?>		
						],
						"fill":false,
						"backgroundColor:":"rgb(54, 162, 235)",
						"borderColor":"rgb(54, 162, 235)",
						"lineTension":0.1
					}, {
						"label": "Tahun 2019",
						"data": [
							<?php 
							$bln = 1;
							foreach($tabel2019pkl as $tb) {
								if(date("n")>=$bln) {
									echo '"'.$tb['tahun'].'",';
								} else {
									echo '"0",';
								}
								$bln++;
							}
							?>
						],
						"fill": false,
						"backgroundColor:": "rgb(255, 99, 132)",
						"borderColor": "rgb(255, 99, 132)",
						"lineTension": 0.1
					}
				]
			},
			"options":{
				"events": ['click'],
				"animation": {
					"duration": 1,
					onComplete: function () {
						var chartInstance = this.chart,
						ctx = chartInstance.ctx;
						ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
						ctx.textAlign = 'center';
						ctx.fillStyle = "#666";
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
	});

	function showFullscreen(element) {
		element = document.getElementById(element);
		if (element.requestFullscreen) {
			element.requestFullscreen();
		} else if (element.mozRequestFullScreen) {
			element.mozRequestFullScreen();
		} else if (element.webkitRequestFullscreen) {
			element.webkitRequestFullscreen();
		} else if (element.msRequestFullscreen) {
			element.msRequestFullscreen();
		}
	}

	function print(element) {
		html2canvas(document.getElementById(element), {
			scale: 1
		}).then((canvas) => {
			let newWindow = window.open();
			newWindow.document.body.appendChild(canvas);
			newWindow.focus();
			newWindow.print();
		});
	}

	function save(element, type) {
		switch(type) {
			case 0:
				var title = 'Grafik Jumlah Pekerja 2018 vs 2019 (tanpa PKL, Magang & TKPW)';
				break;
			default:
				var title = 'Grafik Jumlah Pekerja 2018 vs 2019 (termasuk PKL, Magang & TKPW)';
				break;
		}
		document.getElementById('btn-save-0').disabled = true;
		document.getElementById('btn-save-0').classList.remove('fa-floppy-o');
		document.getElementById('btn-save-0').classList.add('fa-spin', 'fa-spinner');
		html2canvas(document.getElementById(element), {
			scale: 1
		}).then((canvas) => {
			var img = canvas.toDataURL('image/jpeg');
			var doc = new jsPDF('L', 'mm', 'a4');
			doc.addImage(img, 'JPEG', 0, 0);
			doc.save(title + '.pdf', { returnPromise:true }).then(() => {
				document.getElementById('btn-save-0').classList.remove('fa-spinner', 'fa-spin');
				document.getElementById('btn-save-0').classList.add('fa-floppy-o');
				document.getElementById('btn-save-0').disabled = false;
			});
		});
	}
</script>