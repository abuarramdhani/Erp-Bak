<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="col-lg-11">
					<div class="text-right">
						<h1><b>Trend Jumlah Pekerja</b></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11"></div>
						<div class="col-lg-1 "></div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
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
											<div class="form-group col-md-12">
												<h2>Grafik Jumlah Pekerja 2018 vs 2019 <small>TANPA PKL, Magang & TKPW</small></h2>
												<small>Data Per Tanggal 1 Setiap bulannya.</small>
												<canvas id="chartjs-0"></canvas>	
											</div>
											<div class="form-group col-md-12">
												<h2>Grafik Jumlah Pekerja 2018 vs 2019 <small>TERMASUK PKL, Magang & TKPW</small></h2>
												<small>Data Per Tanggal 1 Setiap bulannya.</small>
												<canvas id="chartjs-1"></canvas>	
											</div>
										</div>
									</div>

									<script type="text/javascript" src="<?= base_url('assets/plugins/chartjs/Chart.js') ?>"></script>
<script>

new Chart(document.getElementById("chartjs-0"),
{"type":"line",
"data":{
	"labels":[
	<?php foreach($tabel2017 as $tb){
		echo '"'.$tb['bulan'].'",';}
		?>],
	"datasets":[
		
		{	"label":"Tahun 2018",
			"data":[
				<?php foreach($tabel2018 as $tb){
				echo '"'.$tb['tahun'].'",';}
				?>		
				],
			"fill":false,
			"backgroundColor:":"rgb(54, 162, 235)",
			"borderColor":"rgb(54, 162, 235)",
			"lineTension":0.1
		},
		{	"label":"Tahun 2019",
			"data":[<?php 

				$bln=1;
				foreach($tabel2019pkl as $tb){
				if(date("n")>=$bln)
				{
				echo '"'.$tb['tahun'].'",';	
				}
				else
				{
				echo '"0",';		
				}
				$bln++;
								
	}
		?>],
			"fill":false,
			"backgroundColor:":"rgb(255, 99, 132)",
			"borderColor":"rgb(255, 99, 132)",
			"lineTension":0.1
		}
	]},
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
		    },
}

});

</script>
<script>

new Chart(document.getElementById("chartjs-1"),
{"type":"line",
"data":{
	"labels":[
	<?php foreach($tabel2017pkl as $tb){
		echo '"'.$tb['bulan'].'",';}
		?>],
	"datasets":[
		
		{	"label":"Tahun 2018",
			"data":[
				<?php foreach($tabel2018pkl as $tb){
				echo '"'.$tb['tahun'].'",';}
				?>		
				],
			"fill":false,
			"backgroundColor:":"rgb(54, 162, 235)",
			"borderColor":"rgb(54, 162, 235)",
			"lineTension":0.1
		},
		{	"label":"Tahun 2019",
			"data":[<?php 
				$bln=1;
				foreach($tabel2019pkl as $tb){
				if(date("n")>=$bln)
				{
				echo '"'.$tb['tahun'].'",';	
				}
				else
				{
				echo '"0",';		
				}
				$bln++;
				
				}
		?>],
			"fill":false,
			"backgroundColor:":"rgb(255, 99, 132)",
			"borderColor":"rgb(255, 99, 132)",
			"lineTension":0.1
		}
	]},
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
		    },
}

});

</script>
									<!--<div class="panel-footer">
										<div class="row">
											<button type="submit" class="btn btn-primary btn-lg" style="float: right;">Proses</button>
										</div>
									</div>-->
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
