<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/leaflet/leaflet.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/leaflet-draw/src/leaflet.draw.css') ?>"/>
<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						<h1><b><?=$Title ?></b></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-md-12">
										<form class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-md-4">Seksi</label>
												<div class="col-md-4">
													<input type="text" 
														class="form-control" 
														placeholder="Masukkan Nama Area" 
														id="txt-CVD-ZonaKHS-Seksi"
														value="<?php echo isset($zona) && !empty($zona) ? $zona->nama_seksi : '' ?>"
														autocomplete="off">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-4">Lokasi</label>
												<div class="col-md-4">
													<select class="select2" style="width: 100%;" id="slc-CVD-ZonaKHS-Lokasi" autocomplete="off">
														<?php 
														if (isset($lokasi) && !empty($lokasi)) {
															foreach ($lokasi as $l) {
																if (isset($zona) && !empty($zona) && $zona->lokasi == $l['lokasi_kerja']) {
																	$select = "selected";
																}else{
																	$select = "";
																}
																?>
																<option <?php echo $select ?>><?php echo $l['lokasi_kerja'] ?></option>
																<?php
															}
														}
														?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-2">Detail Kasus</label>
												<div class="col-sm-8">
													<table class="table table-striped table-bordered table-hover" id="tbl-CVD-ZonaKHS-Kasus">
														<thead class="bg-primary">
															<tr>
																<th style="text-align: center;vertical-align: middle;width: 20%">Mulai Isolasi</th>
																<th style="text-align: center;vertical-align: middle;width: 20%">Selesai Isolasi</th>
																<th style="text-align: center;vertical-align: middle;width: 50%">Detail Kasus</th>
																<th style="text-align: center;vertical-align: middle;width: 10%">Action</th>
															</tr>
														</thead>
														<tbody>
															<?php 
															if (isset($kasus) && !empty($kasus)) {
																foreach ($kasus as $k) {
																	?>
																	<tr>
																		<td>
																			<input 
																				type="text" 
																				class="form-control txt-CVD-ZonaKHS-PeriodeAwal" 
																				placeholder="Tanggal Mulai" 
																				autocomplete="off"
																				value="<?php echo $k['tgl_awal_isolasi'] ?>">
																		</td>
																		<td>
																			<input 
																				type="text" 
																				class="form-control txt-CVD-ZonaKHS-PeriodeAkhir" 
																				placeholder="Tanggal Selesai" 
																				autocomplete="off"
																				value="<?php echo $k['tgl_akhir_isolasi'] ?>">
																		</td>
																		<td>
																			<textarea 
																				class="form-control txa-CVD-ZonaKHS-Kasus" 
																				placeholder="Masukkan Kasus" 
																				autocomplete="off"><?php 
																				echo $k['kasus'];
																				?></textarea>
																		</td>
																		<td>
																			<button type="button" class="btn btn-danger btn-CVD-ZonaKHS-RemoveKasus" title="Hapus Kasus"><span class="fa fa-trash"></span></button>
																		</td>
																	</tr>
																	<?php
																}
															}else{
																?>
																<tr>
																	<td>
																		<input type="text" class="form-control txt-CVD-ZonaKHS-PeriodeAwal" placeholder="Tanggal Mulai" autocomplete="off">
																	</td>
																	<td>
																		<input type="text" class="form-control txt-CVD-ZonaKHS-PeriodeAkhir" placeholder="Tanggal Selesai" autocomplete="off">
																	</td>
																	<td>
																		<textarea class="form-control txa-CVD-ZonaKHS-Kasus" placeholder="Masukkan Kasus" autocomplete="off"></textarea>
																	</td>
																	<td>
																		<button type="button" class="btn btn-danger btn-CVD-ZonaKHS-RemoveKasus" title="Hapus Kasus"><span class="fa fa-trash"></span></button>
																	</td>
																</tr>
																<?php
															}
															?>
														</tbody>
													</table>
												</div>
												<div class="col-sm-2">
													<button type="button" class="btn btn-primary" title="Tambah Kasus" id="btn-CVD-ZonaKHS-AddKasus"><span class="fa fa-plus"></span></button>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-12">
													<div id="map-pst" 
														style="height: 700px;width: 100%;">
													</div>
													<input type="hidden" 
														id="txt-CVD-ZonaKHS-Koordinat"
														value="<?php echo isset($zona) && !empty($zona) ? htmlspecialchars($zona->koordinat) : '' ?>">
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-12">
													<div id="map-tks" 
														style="height: 700px;width: 100%;">
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-12 text-center">
													<button type="button" 
														class="btn btn-primary" 
														id="btn-CVD-ZonaKHS-Update"
														data-id="<?php echo $idEncoded ?>">
														<span class="fa fa-save"></span> Simpan
													</button>
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
		</div>
	</div>
</section>
<style type="text/css">
	.loading {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(0,0,0,.5);
    z-index: 9999;
}
.loading-wheel {
    width: 40px;
    height: 40px;
    margin-top: -80px;
    margin-left: -40px;
    
    position: absolute;
    top: 50%;
    left: 50%;
}
.loading-wheel-2 {
    width: 100%;
    height: 20px;
    margin-top: -50px;
    
    position: absolute;
    top: 70%;
    font-weight: bold;
    font-size: 30pt;
    color: white;
    text-align: center;
}

</style>
<div class="loading" id="ldg-CVD-ZonaKHS-Add" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>

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
<script type="text/javascript" type="text/javascript">
	$(document).ready(function(){
		//pst
		var mapPst = L.map('map-pst', {
			crs: L.CRS.Simple,
			drawControl: true
		});

		var boundsPst = [[0,0], [1000,1000]];
		var imagePst = L.imageOverlay('<?php echo base_url('assets/img/map/zona_covid_pusat.png') ?>', boundsPst).addTo(mapPst);
		mapPst.fitBounds(boundsPst);

		var drawnItemsPst = new L.FeatureGroup();
		mapPst.addLayer(drawnItemsPst);

		L.control.layers(
			{ 'drawlayer': drawnItemsPst }, 
		).addTo(mapPst);
	    mapPst.addControl(new L.Control.Draw({
	        edit: {
	            featureGroup: drawnItemsPst,
	            edit: false
	        },
	        draw: false
	    }));
	    <?php if(isset($zona) && !empty($zona) && !empty($zona->koordinat) && $zona->lokasi == "JOGJA"){
			?>
	    	var areaPst = <?php echo $zona->koordinat ?>;
	    	var geoJsonLayerPst = L.geoJson(areaPst);
	    	geoJsonLayerPst.getLayers()[0].addTo(drawnItemsPst);
			<?php
	    }else{
	    	?>
	    	console.log("tidak ada");
	    	<?php
	    } ?>

		mapPst.on(L.Draw.Event.CREATED, function (event) {
	        var layer = event.layer;
	        var shape = layer.toGeoJSON();
	        $('#txt-CVD-ZonaKHS-Koordinat').val(JSON.stringify(shape));
	        console.log($('#txt-CVD-ZonaKHS-Koordinat').val());
	        drawnItemsPst.addLayer(layer);
	    });

	    //tks
		var mapTks = L.map('map-tks', {
			crs: L.CRS.Simple,
			drawControl: true
		});

		var boundsTks = [[0,0], [1000,1000]];
		var imageTks = L.imageOverlay('<?php echo base_url('assets/img/map/zona_covid_tuksono.png') ?>', boundsTks).addTo(mapTks);
		mapTks.fitBounds(boundsTks);

		var drawnItemsTks = new L.FeatureGroup();
		mapTks.addLayer(drawnItemsTks);

		L.control.layers(
			{ 'drawlayer': drawnItemsTks }, 
		).addTo(mapTks);
	    mapTks.addControl(new L.Control.Draw({
	        edit: {
	            featureGroup: drawnItemsTks,
	            edit: false
	        },
	        draw: false
	    }));
	    <?php if(isset($zona) && !empty($zona) && !empty($zona->koordinat) && $zona->lokasi == "TUKSONO"){
			?>
	    	var areaTks = <?php echo $zona->koordinat ?>;
	    	var geoJsonLayerTks = L.geoJson(areaTks);
	    	geoJsonLayerTks.getLayers()[0].addTo(drawnItemsTks);
			<?php
	    }else{
	    	?>
	    	console.log("tidak ada");
	    	<?php
	    } ?>

		mapTks.on(L.Draw.Event.CREATED, function (event) {
	        var layer = event.layer;
	        var shape = layer.toGeoJSON();
	        $('#txt-CVD-ZonaKHS-Koordinat').val(JSON.stringify(shape));
	        console.log($('#txt-CVD-ZonaKHS-Koordinat').val());
	        drawnItemsTks.addLayer(layer);
	    });

	    $('#<?php echo !empty($zona) && $zona->lokasi == "TUKSONO" ? 'map-pst' : 'map-tks'; ?>').hide();
	})
</script>