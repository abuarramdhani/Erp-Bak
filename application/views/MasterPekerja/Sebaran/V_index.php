<style type="text/css">
.tag {
  position:absolute;
  background: #fdcb6e;
  -webkit-border-radius: 20px;
  -moz-border-radius: 20px;
  border-radius: 20px;
  border:2px solid #ffeaa7;
  visibility: hidden;
  height:22px;
  width:22px;
  //padding:11px;
  z-index:2;
}
.tag span {
  position:absolute;
  width:20px;
  color: blue;
  font-family: Helvetica, Arial, Sans-Serif;
  font-size: .8rem;
  text-align:center;
  margin:4px 0;
}
.tag1 {
  position:absolute;
  -webkit-border-radius: 20px;
  -moz-border-radius: 20px;
  border-radius: 20px;
  border:2px solid #FFFFFF;
  height:22px;
  width:22px;
  //padding:11px;
  z-index:2;
}
.tag1 span {
  position:absolute;
  width:20px;
  color: #FFFFFF;
  font-family: Helvetica, Arial, Sans-Serif;
  font-size: .8rem;
  text-align:center;
  margin:4px 0;
}
</style>
<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><?=$Title ?></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header">
								<table style="width: 100%">
									<tr>
										<td>Merah</td>
										<td>:</td>
										<td>Batuk, Pilek, Sakit Tenggorokan, Demam + Sesak Nafas.</td>
									</tr>
									<tr>
										<td>Biru</td>
										<td>:</td>
										<td>Batuk, Pilek, Sakit Tenggorokan, Demam.</td>
									</tr>
									<tr>
										<td>Abu-abu</td>
										<td>:</td>
										<td>Tidak Bisa Cium Bau / Tidak Dapat Merasakan Asin/Manis/Asam.</td>
									</tr>
									<tr>
										<td>Hitam</td>
										<td>:</td>
										<td>Tidak Ditemukan Gejala warna Merah, Biru, Abu-abu.</td>
									</tr>
									<tr>
										<td colspan="3">
											Angka Yang ditampilkan di lingkaran berwarna merupakan Jumlah Pekerja yang sudah Input Data Di titik tersebut.
										</td>
									</tr>
									
								</table>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12" style="overflow-x: scroll;padding: 50px;">
										<form name="pointformp" id="formSebaranGejalaPusat" method="post">
											<div style="position: relative;">
												<div id="taggedp" class="tag">
											    	<span id="span-id"></span>
												</div>
												<?php 
													if (isset($sebaran_pusat) && !empty($sebaran_pusat)) {
														$nomor = 0;
														$kosongY = 0;
														$kosongX = 0;
														foreach ($sebaran_pusat as $sbr) {
															if ($sbr['posX'] =='0' && $sbr['posY'] == '0') {
																if ($kosongY == 15) {
																	$kosongY = 0;
																	$kosongX++;
																}
																$sbr['posX'] = 50 + ($kosongX * 20);
																$sbr['posY'] = 350 + ($kosongY * 20);
																$kosongY++;
															}
															?>
															<div id="tagged<?php echo $nomor ?>" 
																class="tag1" 
																style="top: <?php echo $sbr['posY'] ?>px; left: <?php echo $sbr['posX'] ?>px;background: <?php echo $sbr['color'] ?>;border-color: <?php echo $sbr['border'] ?>" 
																data-toggle="popover" 
																title="<?php echo $sbr['title'] ?>" 
																data-content="<b style='color: red'>MERAH   : <?php echo $sbr['merah'] ?></b><br>
																<b style='color: blue'>BIRU    : <?php echo $sbr['biru'] ?></b><br>
															    <b style='color: grey'>ABU-ABU : <?php echo $sbr['abu'] ?></b><br>
															    <b style='color: black'>SUDAH ISI : <?php echo $sbr['jumlah'] ?></b><br>" 
																data-html="true" 
																data-placement="top" 
																role="button" 
																tabindex="0">
														    	<span id="span-id"><?php echo $sbr['jumlah'] ?></span>
															</div>
															<?php 
															$nomor++;
														}
													}
												?>
											  
												<img src="<?php echo base_url('assets/img/map/pusat.png') ?>" width="1000" id="pointer_divp" onclick="clickcoordp(event)">

												<div style="display: none;">
												  	You pointed on
													x = <input type="text" name="form_xp" size="4" />
												  	y = <input type="text" name="form_yp" size="4" />
												</div>																								    
												  
											</div>
											<div></div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12" style="overflow-x: scroll;padding: 50px;">
										<form name="pointformt" id="formSebaranGejalaTuksono" method="post">
											<div style="position: relative;">
												<div id="taggedt" class="tag">
											    	<span id="span-id"></span>
												</div>
												<?php 
													if (isset($sebaran_tuksono) && !empty($sebaran_tuksono)) {
														$nomor = 0;
														$kosongY = 0;
														$kosongX = 0;
														foreach ($sebaran_tuksono as $sbr) {
															if ($sbr['posX'] =='0' && $sbr['posY'] == '0') {
																if ($kosongY == 15) {
																	$kosongY = 0;
																	$kosongX++;
																}
																$sbr['posX'] = 650 + ($kosongX * 20);
																$sbr['posY'] = 50 + ($kosongY * 20);
																$kosongY++;
															}
															?>
															<div id="tagged<?php echo $nomor ?>" 
																class="tag1" 
																style="top: <?php echo $sbr['posY'] ?>px; left: <?php echo $sbr['posX'] ?>px;background: <?php echo $sbr['color'] ?>;border-color: <?php echo $sbr['border'] ?>" 
																data-toggle="popover" 
																title="<?php echo $sbr['title'] ?>" 
																data-content="<b style='color: red'>MERAH   : <?php echo $sbr['merah'] ?></b><br>
																<b style='color: blue'>BIRU    : <?php echo $sbr['biru'] ?></b><br>
															    <b style='color: grey'>ABU-ABU : <?php echo $sbr['abu'] ?></b><br>
															    <b style='color: black'>SUDAH ISI : <?php echo $sbr['jumlah'] ?></b><br>" 
																data-html="true" 
																data-placement="top" 
																role="button" 
																tabindex="0">
														    	<span id="span-id"><?php echo $sbr['jumlah'] ?></span>
															</div>
															<?php 
															$nomor++;
														}
													}
												?>
											  
												<img src="<?php echo base_url('assets/img/map/tuksono.png') ?>" width="1000" id="pointer_divt" onclick="clickcoordt(event)">

												<div style="display: none;">
												  	You pointed on
													x = <input type="text" name="form_xt" size="4" />
												  	y = <input type="text" name="form_yt" size="4" />
												</div>																								    
												  
											</div>
											<div></div>
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
<script type="text/javascript">
	function clickcoordp(event){
  
		var image = document.getElementById("pointer_divp");
		var tag = document.getElementById("taggedp");

		var pos_x = event.offsetX?(event.offsetX):event.pageX-image.offsetLeft;
		var pos_y = event.offsetY?(event.offsetY):event.pageY-image.offsetTop;

		tag.style.left = (pos_x).toString() + 'px';
		tag.style.top = (pos_y).toString() + 'px';
		tag.style.visibility = "visible";

		document.pointformp.form_xp.value = pos_x;
		document.pointformp.form_yp.value = pos_y;
		console.log("Titik Pusat = Y: " + pos_y + "px; X: " + pos_x + "px;");
	}

	function clickcoordt(event){
  
		var image = document.getElementById("pointer_divt");
		var tag = document.getElementById("taggedt");

		var pos_x = event.offsetX?(event.offsetX):event.pageX-image.offsetLeft;
		var pos_y = event.offsetY?(event.offsetY):event.pageY-image.offsetTop;

		tag.style.left = (pos_x).toString() + 'px';
		tag.style.top = (pos_y).toString() + 'px';
		tag.style.visibility = "visible";

		document.pointformt.form_xt.value = pos_x;
		document.pointformt.form_yt.value = pos_y;
		console.log("Titik Tuksono = Y: " + pos_y + "px; X: " + pos_x + "px;");
	}
</script>

<!-- sumber : https://codepen.io/perikan/pen/PwjoLQ -->