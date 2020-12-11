<!DOCTYPE html>
<html>
<head>
	<title>Zona Covid CV. KHS</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="<?php echo base_url('assets/img/virus.png') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/Bootstrap/3.3.7/css/bootstrap.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/datatables/datatables.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/leaflet/leaflet.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/leaflet-draw/src/leaflet.draw.css') ?>"/>
	<style type="text/css">
		.pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
			    background-color: #ffeaa7;
    			border-color: #ffeaa7;
		}
		.pagination>li>a:focus, .pagination>li>a:hover, .pagination>li>span:focus, .pagination>li>span:hover,.pagination>li>a, .pagination>li>span {
			color: #ffeaa7;
		}
	</style>

	<script type="text/javascript" src="<?php echo base_url('assets/plugins/jQuery/jquery-1.12.4.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/Bootstrap/3.3.7/js/bootstrap.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/datatables/datatables.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet/leaflet-src.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/Leaflet.draw.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/Leaflet.Draw.Event.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/Toolbar.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/Tooltip.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/ext/GeometryUtil.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/ext/LatLngUtil.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/ext/LineUtil.Intersect.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/ext/Polygon.Intersect.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/ext/Polyline.Intersect.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/ext/TouchEvents.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/draw/DrawToolbar.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/draw/handler/Draw.Feature.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/draw/handler/Draw.SimpleShape.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/draw/handler/Draw.Polyline.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/draw/handler/Draw.Marker.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/draw/handler/Draw.Circle.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/draw/handler/Draw.CircleMarker.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/draw/handler/Draw.Polygon.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/draw/handler/Draw.Rectangle.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/edit/EditToolbar.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/edit/handler/EditToolbar.Edit.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/edit/handler/EditToolbar.Delete.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/Control.Draw.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/edit/handler/Edit.Poly.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/edit/handler/Edit.SimpleShape.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/edit/handler/Edit.Rectangle.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/edit/handler/Edit.Marker.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/edit/handler/Edit.CircleMarker.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/leaflet-draw/src/edit/handler/Edit.Circle.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/custom.js') ?>"></script>
</head>
<body class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel" style="border: 1px solid #fdcb6e;">
				<div class="panel-heading" style="background-color: #fdcb6e">
				</div>
				<div class="panel-body" style="text-align: center;">
					<h1>Zona Covid CV. KHS</h1>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel" style="border: 1px solid #fdcb6e;">
				<div class="panel-heading" style="background-color: #fdcb6e;">
					Detail
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered table-hover table-striped" style="width: 100%">
								<thead>
									<tr>
										<th style="width: 3%;background-color: #ffeaa7;text-align: center;vertical-align: middle;">No.</th>
										<th style="width: 7%;background-color: #ffeaa7;text-align: center;vertical-align: middle;">Lokasi</th>
										<th style="width: 10%;background-color: #ffeaa7;text-align: center;vertical-align: middle;">Nama Seksi</th>
										<th style="width: 5%;background-color: #ffeaa7;text-align: center;vertical-align: middle;">Isolasi</th>
										<th style="width: 10%;background-color: #ffeaa7;text-align: center;vertical-align: middle;">Tanggal Awal Isolasi</th>
										<th style="width: 10%;background-color: #ffeaa7;text-align: center;vertical-align: middle;">Tanggal Akhir Isolasi</th>
										<th style="width: 45%;background-color: #ffeaa7;text-align: center;vertical-align: middle;">Kasus</th>
										<th style="width: 10%;background-color: #ffeaa7;text-align: center;vertical-align: middle;">Keputusan</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if (isset($zona) && !empty($zona)) {
										$nomor = 1;
										foreach ($zona as $z) {
											if ($z['isolasi'] == "Ya") {
											?>
												<tr>
													<td style="text-align: center;"><?php echo $nomor ?></td>
													<td><?php echo $z['lokasi'] ?></td>
													<td><?php echo $z['nama_seksi'] ?></td>
													<td style="text-align: center;"><?php echo $z['isolasi'] ?></td>
													<td style="text-align: center;"><?php echo !empty($z['tgl_awal_isolasi']) ? date('d/m/Y',strtotime($z['tgl_awal_isolasi'])) : '' ?></td>
													<td style="text-align: center;"><?php echo !empty($z['tgl_akhir_isolasi']) ? date('d/m/Y',strtotime($z['tgl_akhir_isolasi'])) : '' ?></td>
													<td><?php echo $z['kasus'] ?></td>
													<td style="background-color: #d63031;color: white;font-weight: bold;text-align: center;">Tidak Boleh Dikunjungi</td>
												</tr>
												<?php
											}elseif ($z['isolasi'] == "Tidak" && !empty($z['last_tgl_akhir_isolasi']) && strtotime($z['last_tgl_akhir_isolasi']) > strtotime(date('Y-m-d')." - 2 day")) {
												?>
												<tr>
													<td style="text-align: center;"><?php echo $nomor ?></td>
													<td><?php echo $z['lokasi'] ?></td>
													<td><?php echo $z['nama_seksi'] ?></td>
													<td style="text-align: center;"><?php echo $z['isolasi'] ?></td>
													<td style="text-align: center;">-</td>
													<td style="text-align: center;">-</td>
													<td><?php echo $z['kasus'] ?></td>
													<td style="background-color: #00b894;color: white;font-weight: bold;text-align: center;">Boleh Dikunjungi</td>
												</tr>
												<?php
											}
											?>
											<?php
											$nomor++;
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
		<div class="col-md-6">
			<div class="panel" style="border: 1px solid #fdcb6e;">
				<div class="panel-heading" style="background-color: #fdcb6e">
					PETA KHS JOGJA (PUSAT)
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<div id="map-pst" style="height: 700px;width: 100%;"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel" style="border: 1px solid #fdcb6e;">
				<div class="panel-heading" style="background-color: #fdcb6e">
					PETA KHS TUKSONO
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<div id="map-tks" style="height: 700px;width: 100%;"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" type="text/javascript">
		$(document).ready(function(){
			var mapPst = L.map('map-pst', {
				crs: L.CRS.Simple
			});

			var bounds = [[0,0], [1000,1000]];
			var imagePst = L.imageOverlay('<?php echo base_url('assets/img/map/zona_covid_pusat.png') ?>', bounds).addTo(mapPst);
			mapPst.fitBounds(bounds);

			var drawnItemsPst = new L.FeatureGroup();
			mapPst.addLayer(drawnItemsPst);

			var mapTks = L.map('map-tks', {
				crs: L.CRS.Simple
			});

			var bounds = [[0,0], [1000,1000]];
			var imageTks = L.imageOverlay('<?php echo base_url('assets/img/map/zona_covid_tuksono.png') ?>', bounds).addTo(mapTks);
			mapTks.fitBounds(bounds);

			var drawnItemsTks = new L.FeatureGroup();
			mapTks.addLayer(drawnItemsTks);

		    <?php if(isset($zona) && !empty($zona)){
		    	foreach ($zona as $key => $z) {
		    		$js = $z['koordinat'];
		    		if (!empty($z['koordinat'])) {
		    			if ($z['lokasi'] == "JOGJA") {
		    				$map = "mapPst";
		    			}else{
		    				$map = "mapTks";
		    			}
					    $arr = json_decode($js);
					    $arr->properties->nama_seksi = $z['nama_seksi'];
					    $arr->properties->isolasi = $z['isolasi'];
					    $arr->properties->tgl_awal_isolasi = date('d/m/Y',strtotime($z['tgl_awal_isolasi']));
					    $arr->properties->tgl_akhir_isolasi = date('d/m/Y',strtotime($z['tgl_akhir_isolasi']));
					    $arr->properties->kasus = $z['kasus'];
					    $json = json_encode($arr);
					    if ($z['isolasi'] == "Ya") {
							?>
					    	var area<?php echo $key ?> = <?php echo $json ?>;
					    	L.geoJSON(area<?php echo $key ?>, {
								style: function(feature) {
									var filcolor = '#d63031';
									return {
										fillColor: filcolor,
										fillOpacity: 0.8,
										stroke: true,
										color: "white",
										weight: 0.5
									};
								}
							}).bindPopup(function(layer) {
								var text = layer.feature.properties.nama_seksi;
								text += "<br>Isolasi : " + layer.feature.properties.isolasi; 
								if (layer.feature.properties.isolasi == "Ya") {
									text += "<br>Periode Isolasi : " + layer.feature.properties.tgl_awal_isolasi + " s/d " + layer.feature.properties.tgl_akhir_isolasi;
									text += "<br>Kasus : " + layer.feature.properties.kasus; 
								}
								return text;
							}).addTo(<?php echo $map ?>);
							<?php
					    }elseif ($z['isolasi'] == "Tidak" && !empty($z['last_tgl_akhir_isolasi']) && strtotime($z['last_tgl_akhir_isolasi']) > strtotime(date('Y-m-d')." - 2 day")) {
					    	?>
					    	var area<?php echo $key ?> = <?php echo $json ?>;
					    	L.geoJSON(area<?php echo $key ?>, {
								style: function(feature) {
									var filcolor = '#00b894';
									return {
										fillColor: filcolor,
										fillOpacity: 0.8,
										stroke: true,
										color: "white",
										weight: 0.5
									};
								}
							}).bindPopup(function(layer) {
								var text = layer.feature.properties.nama_seksi;
								text += "<br>Isolasi : " + layer.feature.properties.isolasi; 
								if (layer.feature.properties.isolasi == "Ya") {
									text += "<br>Periode Isolasi : " + layer.feature.properties.tgl_awal_isolasi + " s/d " + layer.feature.properties.tgl_akhir_isolasi;
									text += "<br>Kasus : " + layer.feature.properties.kasus; 
								}
								return text;
							}).addTo(<?php echo $map ?>);
							<?php
					    }
		    		}
		    	}
		    }else{
		    	?>
		    	console.log("tidak ada");
		    	<?php
		    } ?>
		})
	</script>
</body>
</html>