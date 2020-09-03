<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Wilayah Covid 19</title>
	<link rel="icon" href="<?php echo base_url('assets/img/virus.png') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/Bootstrap/3.3.7/css/bootstrap.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/datatables/datatables.min.css') ?>">
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/jQuery/jquery-1.12.4.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/Bootstrap/3.3.7/js/bootstrap.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/datatables/datatables.min.js') ?>"></script>
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/leaflet/leaflet.css') ?>" />
  	<script src="<?php echo base_url('assets/plugins/leaflet/leaflet.js') ?>"></script>

	<style type="text/css">
		#table-utama th {
			vertical-align: middle;
			text-align: center;
			background-color: #00cec9;
			color: white;
		}
		.pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
			    background-color: #00cec9;
    			border-color: #00cec9;
		}
		.pagination>li>a:focus, .pagination>li>a:hover, .pagination>li>span:focus, .pagination>li>span:hover,.pagination>li>a, .pagination>li>span {
			color: #00cec9;
		}
	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="panel">
					<div class="panel-heading" style="background-color: #81ecec">Portal Wilayah Covid-19</div>
					<div class="panel-body" style="border: 1px solid #81ecec">
						<div class="row">
							<div class="col-lg-12">
								<table class="table table-bordered table-hover" id="table-utama">
									<thead>
										<tr>
											<th>No.</th>
											<th>Provinsi</th>
											<th>Kabupaten/Kota</th>
											<th>Status Sebelumnya</th>
											<th>Status Sekarang</th>
											<th>Tanggal Berubah</th>
											<th>Ketentuan KHS</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if (isset($data) && !empty($data)) {
											$nomor = 1;
											$bulan = array(
												'januari' 	=> '01',
												'februari' 	=> '02',
												'maret' 	=> '03',
												'april' 	=> '04',
												'mei' 		=> '05',
												'juni' 		=> '06',
												'juli' 		=> '07',
												'agustus' 	=> '08',
												'september' => '09',
												'oktober' 	=> '10',
												'november' 	=> '11',
												'desember' 	=> '12'
											);
											foreach ($data as $key => $value) {
												$tgl = explode(" ", $value['tanggal']);
												$time = strtotime($tgl[2]."-".$bulan[$tgl[1]]."-".$tgl[0]);
												$nowMin7 = strtotime(date('Y-m-d')." - 7 day");
												$daerah_kdu = array(
												    'sleman',
												    'bantul',
												    'kulon progo',
												    'gunung kidul',
												    'kota yogyakarta',
													'kebumen',
													'wonosobo',
													'purworejo',
													'magelang',
													'temanggung',
													'salatiga',
													'boyolali',
													'klaten',
													'sragen',
													'surakarta',
													'karanganyar',
													'sukoharjo',
													'wonogiri'
												);
												$status_warna1 = "";
												foreach ($status_kondisi as $st) {
													if ($st['status_nama'] == $value['zona']) {
														$status_warna1 = $st['status_warna'];
													}
												}
												$status_warna2 = "";
												foreach ($status_kondisi as $st) {
													if ($st['status_nama'] == $value['zona_sebelumnya']) {
														$status_warna2 = $st['status_warna'];
													}
												}
												if ($value['zona_sebelumnya'] == "") {
													$value['zona_sebelumnya'] = "belum berubah";
												}
												if (in_array($value['provinsi'], array('DAERAH ISTIMEWA YOGYAKARTA','JAWA TENGAH'))) {
													$status = "";
													$warna = "";
													if (in_array(strtolower($value['kabupaten']), $daerah_kdu) && $value['zona'] != 'RESIKO TINGGI' && ((in_array($value['zona_sebelumnya'], array('RESIKO TINGGI')) && $time < $nowMin7) || !in_array($value['zona_sebelumnya'], array('RESIKO TINGGI')))) {
														$status = "Boleh Dikunjungi & Menginap (KDU)";
														$warna = "#3ae374";
													}elseif(in_array($value['zona'], array('TIDAK ADA KASUS','TIDAK TERDAMPAK')) && ((in_array($value['zona_sebelumnya'], array('RESIKO TINGGI','RESIKO SEDANG',"RESIKO RENDAH")) && $time < $nowMin7) || !in_array($value['zona_sebelumnya'], array('RESIKO TINGGI','RESIKO SEDANG',"RESIKO RENDAH")))){
														$status = "Boleh Dikunjungi & Menginap";
														$warna = "#3ae374";
													}elseif ($value['zona'] == "RESIKO RENDAH" && ((in_array($value['zona_sebelumnya'], array('RESIKO TINGGI','RESIKO SEDANG')) && $time < $nowMin7) || !in_array($value['zona_sebelumnya'], array('RESIKO TINGGI','RESIKO SEDANG')))) {
														$status = "Boleh Dikunjungi TAPI Tidak Menginap";
														$warna = "#fff200";
													}else{
														$status = "Tidak Boleh Dikunjungi";
														$warna = "#ff3838";
													}
													?>
													<tr>
														<td><?php echo $nomor ?></td>
														<td><?php echo $value['provinsi'] ?></td>
														<td><?php echo $value['kabupaten'] ?></td>
														<td style="background-color: <?php echo $status_warna2 ?>"><?php echo $value['zona_sebelumnya'] ?></td>
														<td style="background-color: <?php echo $status_warna1 ?>"><?php echo $value['zona'] ?></td>
														<td><?php echo $value['tanggal'] ?></td>
														<td style="background-color: <?php echo $warna ?>"><?php echo $status?></td>
													</tr>
													<?php
													$nomor++;
												}else{
													$status = "Tidak Boleh Dikunjungi";
													$warna = "#ff3838";
												}
												$data[$key]['status'] = $status;
												$data[$key]['status_color'] = $warna;
												$data[$key]['status_warna'] = $status_warna1;
											}
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="panel">
					<div class="panel-heading" style="background-color: #81ecec">Peta Resiko Sumber : https://covid19.go.id/peta-risiko</div>
					<div class="panel-body" style="border: 1px solid #81ecec">
						<div id="map1" style="width: 100%; height: 400px;"></div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="panel">
					<div class="panel-heading" style="background-color: #81ecec">Zona Boleh Dikunjungi, Boleh Menginap, Tidak Boleh Dikunjungi, Tidak Boleh Menginap</div>
					<div class="panel-body" style="border: 1px solid #81ecec">
						<div id="map2" style="width: 100%; height: 400px;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="<?php echo base_url('assets/js/countries.js') ?>"></script>
	<script type="text/javascript">
		$(document).on('ready', function(){
			$('#table-utama').DataTable();
		})
		var zona = <?php echo json_encode($data) ?>;
		var map1 = L.map('map1').setView([-7.198390526400885,110.25880464981577],8);
		L.geoJSON(countries, {
			style: function(feature) {
				var filcolor = "#ff3838";
				zona.forEach(function(dataZona,index){
					if (dataZona.provinsi == feature.properties.provinsi && dataZona.kabupaten == feature.properties.kota) {
						filcolor = dataZona.status_warna;	
					}
				})
				return {
					fillColor: filcolor,
					fillOpacity: 0.8,
					stroke: true,
					color: "white",
					weight: 0.5
				};
			}
		}).bindPopup(function(layer) {
			return layer.feature.properties.provinsi + "<br>" + layer.feature.properties.kota;
		}).addTo(map1);
		map1.on('zoomend', function(){
			map2.setZoom(map1.getZoom());
			map2.panTo(map1.getCenter());
		})
		map1.on('dragend', function(){
			map2.setZoom(map1.getZoom());
			map2.panTo(map1.getCenter());
		})

		var map2 = L.map('map2').setView([-7.198390526400885,110.25880464981577],8);
		L.geoJSON(countries, {
			style: function(feature) {
				var filcolor = "#ff3838";
				zona.forEach(function(dataZona,index){
					if (dataZona.provinsi == feature.properties.provinsi && dataZona.kabupaten == feature.properties.kota) {
						filcolor = dataZona.status_color;	
					}
				})
				return {
					fillColor: filcolor,
					fillOpacity: 0.8,
					stroke: true,
					color: "white",
					weight: 0.5
				};
			}
		}).bindPopup(function(layer) {
			return layer.feature.properties.provinsi + "<br>" + layer.feature.properties.kota;
		}).addTo(map2);
		map2.on('zoomend', function(){
			map1.setZoom(map2.getZoom());
			map1.panTo(map2.getCenter());
		})
		map2.on('dragend', function(){
			map1.setZoom(map2.getZoom());
			map1.panTo(map2.getCenter());
		})
	</script>
</body>
</html>