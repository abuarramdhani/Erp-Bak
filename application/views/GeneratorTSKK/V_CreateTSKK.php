<style type="text/css">


#generate {
    border-radius: 25px;
}

#btnShow {
    border-radius: 25px;
}

#btnEdit {
    border-radius: 25px;
}

.select2 {
    border-radius: 4px;
}

.select2-selection {
  text-align: left;
}

#judul {
    border-radius: 25px;
}

tbody {
    overflow-y: auto;    /* Trigger vertical scroll    */
}

.lockscreen-credentials {

padding: 6px 12px;
font-size: 14px;
line-height: 1.42857143;
color: #555;
background-color: #fff;
background-image: none;
border: 1px solid #ccc;
border-radius: 4px;
-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
		box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
-webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
	 -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
		transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
}
.lockscreen-credentials:focus {
border-color: #66afe9;
outline: 0;
-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
		box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
}
.lockscreen-credentials::-moz-placeholder {
color: #999;
opacity: 1;
}
.lockscreen-credentials:-ms-input-placeholder {
color: #999;
}
.lockscreen-credentials::-webkit-input-placeholder {
color: #999;
}
.lockscreen-credentials::-ms-expand {
background-color: transparent;
border: 0;
}
.lockscreen-credentials[disabled],
.lockscreen-credentials[readonly],
fieldset[disabled] .lockscreen-credentials {
background-color: #eee;
opacity: 1;
}
.lockscreen-credentials[disabled],
fieldset[disabled] .lockscreen-credentials {
cursor: not-allowed;
}
textarea.lockscreen-credentials {
height: auto;
}
input[type="search"] {
-webkit-appearance: none;
}

#inputInsert {
    border-radius: 25px;
}

#dst {
    border-radius: 25px;
}

/* .zui-table {
    border: none;
    border-right: solid 1px #DDEFEF;
    border-collapse: separate;
    border-spacing: 0;
    font: normal 13px Arial, sans-serif;
} */
/* .zui-table thead th {
    background-color: #DDEFEF;
    border: none;
    color: #336B6B;
    padding: 10px;
    text-align: left;
    text-shadow: 1px 1px 1px #fff;
    white-space: nowrap;
} */

/* .zui-table tbody td {
    border-bottom: solid 1px #DDEFEF;
    color: #333;
    padding: 10px;
    text-shadow: 1px 1px 1px #fff;
    white-space: nowrap;
} */
.zui-wrapper {
    position: relative;
}

.zui-scroller {
    /* margin-left: 141px; */
    overflow-x: scroll;
    overflow-y: visible;
    padding-bottom: 5px;
    /* width: 300px; */
}
.tblObservasi .zui-sticky-col {
    /* border-left: solid 1px #DDEFEF;
    border-right: solid 1px #DDEFEF; */
    /* left: 0; */
    position: absolute;
    top: auto;
}

/* .wrapper{
background: linear-gradient(#cf455c, white);
background-size: 1800% 1800%;
-webkit-animation: rainbow 10s ease infinite;
-z-animation: rainbow 5s ease infinite;
-o-animation: rainbow 5s ease infinite;
  animation: rainbow 2s ease infinite;
  }

@-webkit-keyframes rainbow {
    0%{background-position:0% 82%}
    50%{background-position:100% 19%}
    100%{background-position:0% 82%}
}
@-moz-keyframes rainbow {
    0%{background-position:0% 82%}
    50%{background-position:100% 19%}
    100%{background-position:0% 82%}
}
@-o-keyframes rainbow {
    0%{background-position:0% 82%}
    50%{background-position:100% 19%}
    100%{background-position:0% 82%}
}
@keyframes rainbow {
    0%{background-position:0% 82%}
    50%{background-position:100% 19%}
    100%{background-position:0% 82%}
}
.blink_me {
  animation: blinker 1.5s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}

@keyframes blinker {
  50% {
    opacity: 0;
  }

} */

</style>

<section class="content">
<form method="POST" action="<?php echo base_url('GeneratorTSKK/resaveObservation/'); ?>">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-center">
							<h1><b>GENERATOR TSKK</b></h1>

							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
						<div class="box-header with-border">
                        <?php
						// echo "<pre>";
						// print_r ($lihat_hasilObservasi);
                        // exit();
							if (empty($lihat_hasilObservasi_elemen)) {
							}else{
							$no=1;
							foreach ($lihat_hasilObservasi_elemen as $key) {
                                //header
                                $id = $key['id_tskk'];
                                $judul = $key['judul_tskk'];
                                $type = $key['tipe'];
                                $kode_part = $key['kode_part'];
                                $nama_part = $key['nama_part'];
                                $no_alat = $key['no_alat_bantu'];
                                $seksi = $key['seksi'];
                                $proses = $key['proses'];
                                $kode_proses = $key['kode_proses'];
                                $mesin = $key['mesin'];
                                $proses_ke = $key['proses_ke'];
                                $dari =	$key['proses_dari'];
                                $tanggal = $key['tanggal'];
								$newDate = date("d-M-Y", strtotime($tanggal));
                                $qty = $key['qty'];
								$operator =	$key['operator'];
								$nilai_distribusi =	$key['nilai_distribusi'];
                                //observasi
                                $waktu_1= $key['waktu_1'];
                                $waktu_2= $key['waktu_2'];
                                $waktu_3= $key['waktu_3'];
                                $waktu_4= $key['waktu_4'];
                                $waktu_5= $key['waktu_5'];
                                $waktu_6= $key['waktu_6'];
                                $waktu_7= $key['waktu_7'];
                                $waktu_8= $key['waktu_8'];
                                $waktu_9= $key['waktu_9'];
                                $waktu_10= $key['waktu_10'];
                                $x_min= $key['x_min'];
                                $range= $key['r'];
                                $wktDistribusi= $key['waktu_distribusi'];
                                $wktKerja= $key['waktu_kerja'];
                                $keterangan= $key['keterangan'];
                                $takt_time= $key['takt_time'];
                                //elemen tskk
								$jenis_proses = $key['jenis_proses'];
								$elemen = $key['elemen'];
								$keterangan_elemen = $key['keterangan_elemen'];
								$ek = $elemen." ".$keterangan_elemen;
								$tipe_urutan = $key['tipe_urutan'];
								$waktu = $key['waktu_kerja'];
								$dst =array_column($lihat_hasilObservasi_elemen, 'waktu_distribusi');
						?>
						<?php } } ?>
						<!--Judul TSKK :-->
						<label style="margin-left:7% ;" for="norm">Judul: </label>
							<input type="text" style="width:80%; height:34px;  margin-left:2% ;" placeholder="Input Judul TSKK" value="<?php echo $judul; ?>" name="txtTitle" id="judul" class="lockscreen-credentials judul" readonly required/>
						</div>
						<div class="box-body">
							<div class="panel-body">
								<!--1-->
								<div class="col-lg-4">
									<div class="row">
											<label for="norm" class="control-label col-lg-5">Type :</label>
											<div class="col-lg-7">
											<input type="text" placeholder="Input Type" name="txtType" value="<?php echo $type ?>" id="type" class="form-control type" readonly required/>
											</div>
									</div>
									<br>
									<input hidden style="display:none" class="form-control getID" value="<?php echo $id ?>">
									<div class="row">
											<label for="norm" class="control-label col-lg-5">Kode Part :</label>
											<div class="col-lg-7">
												<input type="text" placeholder="Input Kode Part" value="<?php echo $kode_part ?>" id="kodepart" name="txtKodepart" class="form-control kodepart" readonly/>
											</div>
									</div>
									<br>
									<div class="row">
											<label for="norm" class="control-label col-lg-5">Nama Part :</label>
											<div id="divPassCheck" class="col-lg-7">
												<input type="text" style="height: 35px;" placeholder="Input Nama Part" name="txtNamaPart" value="<?php echo $nama_part ?>" id="namaPart" class="form-control namaPart" readonly required/>
											</div>
									</div>
									<br>
									<div class="row">
											<label for="norm" class="control-label col-lg-5">No. Alat Bantu :</label>
											<div class="col-lg-7">
											<input type="text" placeholder="Input No. Alat Bantu" name="txtNoAlat" value="<?php echo $no_alat ?>" id="noAlat" class="form-control noAlat" readonly/>
											</div>
									</div>
								</div>
									<!--2-->
								<div class="col-lg-4">
									<div class="row">
											<label for="norm" class="control-label col-lg-4">Seksi :</label>
											<div class="col-lg-8">
												<input type="text" class="form-control pilihseksi" value="<?php echo $seksi ?>" id="pilihseksi" name="txtSeksi" placeholder="Input Seksi" tabindex="-1" aria-hidden="true" readonly required/>
											</div>
									</div>
									<br>
									<div class="row">
											<label for="norm" class="control-label col-lg-4">Proses :</label>
											<div class="col-lg-8">
											<input type="text" placeholder="Input Proses" name="txtProses" value="<?php echo $proses ?>" id="txtProses" class="form-control txtProses" readonly required/>
											</div>
									</div>
									<br>
									<div class="row">
											<label for="norm" class="control-label col-lg-4">Kode Proses :</label>
											<div class="col-lg-8">
											<input type="text" placeholder="Input Kode Proses" name="txtKodeProses" value="<?php echo $kode_proses ?>" id="kodeProses" class="form-control kodeProses" readonly/>
											</div>
									</div>
									<br>
									<div class="row">
											<label for="norm" class="control-label col-lg-4">Mesin :</label>
											<div class="col-lg-8">
												<input type="text"  style="height: 35px;" value="<?php echo $mesin ?>" class="form-control txtMesin" id="txtMesin" name="txtMesin" placeholder="Input Mesin" tabindex="-1" aria-hidden="true" readonly/>
											</div>
									</div>
								</div>
									<!--3-->
								<div class="col-lg-4">
									<div class="row">
											<label for="norm" class="control-label col-lg-4">Proses ke :</label>
											<div class="col-lg-3">
											<input type="text" placeholder="Input Proses" name="txtProsesKe" value="<?php echo $proses_ke ?>" id="txtProsesKe" class="form-control txtProsesKe" readonly/>
											</div>

											<label class="control-label col-lg-2 text-left">Dari:</label>
											<div class="col-lg-3">
											<input type="text" placeholder="Input" name="txtDari" value="<?php echo $dari ?>" id="txtDari" class="form-control txtDari" readonly/>
											</div>
									</div>
									<br>

									<div class="row">
											<label for="norm" class="control-label col-lg-4">Tanggal :</label>
											<div class="col-lg-8">
											<input type="text" placeholder="Input Tanggal" value="<?php echo $newDate ?>" name="txtTanggal" id="txtTanggal" class="form-control txtTanggal" readonly required/>
											</div>
									</div>
									<br>
									<div class="row">
											<label for="norm" class="control-label col-lg-4">Qty :</label>
											<div class="col-lg-8">
											<input type="text" placeholder="Input Qty" name="txtQty" value="<?php echo $qty ?>" id="txtQty" class="form-control txtQty" readonly/>
											</div>
									</div>
									<br>
									<div class="row">
											<label for="norm" class="control-label col-lg-4">Operator :</label>
											<div class="col-lg-8">
											<input type="text" placeholder="Input Operator" value="<?php echo $operator ?>" id="txtOperator" name="txtOperator" class="form-control txtOperator" readonly/>
											</div>
									</div>
									<input hidden class="form-control idTSKK" style="display:none" value="<?php echo $id ?>">
								</div>

								<br>

								<div class="row">
									<label for="norm" class="control-label col-lg-4"></label>
								</div>
								<br>
								<br>
								<div class="row">
										<div class="row">
											<div class="col-lg-12" >
											<?php if ($dst != null) {
													$nDistribusi = array_sum($dst);
													$nilai_distribusi=$nilai_distribusi-$nDistribusi;
													// $wktDistribusi = null;
												}else{
													$nilai_distribusi = 0;
												}
											?>
												<div class="panel panel-default">
													<div class="panel-heading">
														<label style="margin-left:5% ;" for="norm">Takt Time : </label>
															<input type="number" style="width:45%; height:34px; margin-right:8%;  margin-left:3% ;" value="<?php echo $takt_time; ?>" placeholder="Input Takt Time" name="taktTime" id="inputInsert" class="lockscreen-credentials taktTime" readonly/>
														<label for="norm">Nilai Distribusi : </label>
															<input type="number" style="width:15%; height:34px; margin-right:2%;  margin-left:2%; text-align:center" name="inputInsert" id="dst" value="<?php echo $nilai_distribusi ?>" class="lockscreen-credentials" readonly/>
													</div>
													<div class="panel-body">
														<div class="table-responsive" id="tableGenerate">
															<!-- <div class="zui-scroller"> -->
															<table class="table table-striped table-bordered table-hover text-center tblObservasi" style="width:2400px; padding-bottom: 0;" name="tblObservasi" id="tblObservasi">
																<thead>
																	<tr class="bg-primary">
																		<th style="width: 50 px;  text-align:center;">NO</th>
																		<th style="width: 200px;  text-align:center;">JENIS PROSES</th>
																		<th style="width: 400px;  text-align:center;">ELEMEN KERJA</th>
																		<th style="width: 150px;  text-align:center;">TIPE URUTAN</th>
																		<th style="width: 100px;  text-align:center;">1</th>
																		<th style="width: 100px;  text-align:center;">2</th>
																		<th style="width: 100px;  text-align:center;">3</th>
																		<th style="width: 100px;  text-align:center;">4</th>
																		<th style="width: 100px;  text-align:center;">5</th>
																		<th style="width: 100px;  text-align:center;">6</th>
																		<th style="width: 100px;  text-align:center;">7</th>
																		<th style="width: 100px;  text-align:center;">8</th>
																		<th style="width: 100px;  text-align:center;">9</th>
																		<th style="width: 100px;  text-align:center;">10</th>
																		<th style="width: 100px;  text-align:center;">X MIN</th>
																		<th style="width: 100px;  text-align:center;">R</th>
																		<th style="width: 100px;  text-align:center;">WAKTU DISTRIBUSI</th>
																		<th style="width: 100px;  text-align:center;">WAKTU KERJA</th>
																		<th style="width: 150px;  text-align:center;">KETERANGAN</th>
																		<th style="width: 50 px;  text-align:center;">HAPUS</th>
																	</tr>
																</thead>
																<tbody id="tbodyLembarObservasi">
																<?php
																	// echo "<pre>";
																	// print_r ($lihat_hasilObservasi);
																	// exit();
																		if (empty($lihat_hasilObservasi)) {
																		}else{
																		$no=1;
																		foreach ($lihat_hasilObservasi as $key) {
																			//observasi
																			$waktu_1= $key['waktu_1'];
																			$waktu_2= $key['waktu_2'];
																			$waktu_3= $key['waktu_3'];
																			$waktu_4= $key['waktu_4'];
																			$waktu_5= $key['waktu_5'];
																			$waktu_6= $key['waktu_6'];
																			$waktu_7= $key['waktu_7'];
																			$waktu_8= $key['waktu_8'];
																			$waktu_9= $key['waktu_9'];
																			$waktu_10= $key['waktu_10'];
																			$x_min= $key['x_min'];
																			$range= $key['r'];
																			$wktDistribusi= $key['waktu_distribusi'];
																			$wktKerja= $key['waktu_kerja'];
																			$keterangan= $key['keterangan'];
																			$takt_time= $key['takt_time'];
																			//elemen tskk
																			$jenis_proses = $key['jenis_proses'];
																			$elemen = $key['elemen'];
																			$keterangan_elemen = $key['keterangan_elemen'];
																			$ek = $elemen." ".$keterangan_elemen;
																			$tipe_urutan = $key['tipe_urutan'];
																			$waktu = $key['waktu_kerja'];


																	?>
																		<tr class="nomor_".$no>
									<!--NO-->							<td class="posisi"><?php echo $no; ?></td>
									<!--JENIS PROSES-->					<td>
																			<select class="form-control select4" onchange="myFunctionTSKK(this)" style="text-align:left" data-placeholder="Jenis Proses" name="slcJenisProses[]" id="slcJenis" disabled>
                                                                            <?php
                                                                                echo '<option value="'.$jenis_proses.'" selected>'.$jenis_proses.'</option>';
                                                                            ?>
																				<option value="MANUAL">MANUAL</option>
																				<option value="AUTO">AUTO</option>
																				<option value="AUTO (Inheritance)">AUTO (Inheritance)</option>
																				<option value="WALK">WALK</option>
																				<option value="WALK (Inheritance)">WALK (Inheritance)</option>
																			</select>
																		</td>
									<!--ELEMEN KERJA-->					<td>
																		<div class="col-lg-12">
																			<div class="col-lg-6">
																			<select class="form-control select2 slcElemen" id="slcElemen" name="txtSlcElemen[]" data-placeholder="Elemen" disabled>
																			<?php
																				if ($elemen != null) {
																					echo '<option value="'.$elemen.'" selected>'.$elemen.'</option>';
																				}
                                                                            ?>
                                                                            </select>
																			</div>
																			<div class="col-lg-6">
																				<input type="text" value="<?php echo $keterangan_elemen; ?>" id="elemen" name="julia[]" class="form-control elemen" placeholder="Keterangan Elemen" readonly>
																			</div>
																		</div>
																		</td>
									<!--TIPE URUTAN-->					<td>
																			<select class="form-control select4 tipe_urutan" data-placeholder="Tipe Urutan" name="slcTipeUrutan[]" id="slcTipeUrutan" disabled>
                                                                            <?php
																				echo '<option value="'.$tipe_urutan.'" selected>'.$tipe_urutan.'</option>';
																			?>
																				<option value="SERIAL">SERIAL</option>
																				<option value="PARALEL">PARALEL</option>
																			</select>
																		</td>
									<!--1-->					<td><input type="number" value="<?php echo $waktu_1; ?>" onchange="minMaxId(this)"  name="fanny[]" class="form-control waktuObs inputWaktuKolom1" placeholder="Detik" readonly></td>
									<!--2-->					<td><input type="number" value="<?php echo $waktu_2; ?>" onchange="minMaxId(this)"  name="waktu2[]" class="form-control waktuObs inputWaktuKolom2" placeholder="Detik" readonly></td>
									<!--3-->					<td><input type="number" value="<?php echo $waktu_3; ?>" onchange="minMaxId(this)"  name="waktu3[]" class="form-control waktuObs inputWaktuKolom3" placeholder="Detik" readonly></td>
									<!--4-->					<td><input type="number" value="<?php echo $waktu_4; ?>" onchange="minMaxId(this)"  name="waktu4[]" class="form-control waktuObs inputWaktuKolom4" placeholder="Detik" readonly></td>
									<!--5-->					<td><input type="number" value="<?php echo $waktu_5; ?>" onchange="minMaxId(this)"  name="waktu5[]" class="form-control waktuObs inputWaktuKolom5" placeholder="Detik" readonly></td>
									<!--6-->					<td><input type="number" value="<?php echo $waktu_6; ?>" onchange="minMaxId(this)"  name="waktu6[]" class="form-control waktuObs inputWaktuKolom6" placeholder="Detik" readonly></td>
									<!--7-->					<td><input type="number" value="<?php echo $waktu_7; ?>" onchange="minMaxId(this)"  name="waktu7[]" class="form-control waktuObs inputWaktuKolom7" placeholder="Detik" readonly></td>
									<!--8-->					<td><input type="number" value="<?php echo $waktu_8; ?>" onchange="minMaxId(this)"  name="waktu8[]" class="form-control waktuObs inputWaktuKolom8" placeholder="Detik" readonly></td>
									<!--9-->					<td><input type="number" value="<?php echo $waktu_9; ?>" onchange="minMaxId(this)"  name="waktu9[]" class="form-control waktuObs inputWaktuKolom9" placeholder="Detik" readonly></td>
									<!--10-->					<td><input type="number" value="<?php echo $waktu_10; ?>" onchange="minMaxId(this)" name="waktu10[]" class="form-control waktuObs inputWaktuKolom10" placeholder="Detik" readonly></td>
									<!--X MIN-->				<td><input type="number" value="<?php echo $x_min; ?>" id="xmin" name="xmin[]" class="form-control xmin" placeholder="Detik" readonly></td>
									<!--R-->					<td><input type="number" value="<?php echo $range; ?>" id="range" name="range[]" class="form-control range" placeholder="Detik" readonly></td>
									<!--W DISTRIBUSI-->			<td><input type="number" value="<?php echo $wktDistribusi ?>" onchange="minMaxId(this)" id="wDistribusi" name="wDistribusi[]" class="form-control wDistribusi" placeholder="Detik" readonly></td>
									<!--W KERJA-->				<td><input type="number" value="<?php echo $waktu; ?>" id="wKerja" name="wKerja[]" class="form-control wKerja" placeholder="Detik" readonly></td>
									<!--KETERANGAN-->			<td><input type="text" id="keterangan" value="<?php echo $keterangan; ?>" name="keterangan[]" class="form-control keterangan" placeholder="Input Keterangan" readonly></td>
									<!--HAPUS-->				<td>
																	<i class="fa fa-times fa-2x" onclick="deleteObserve(this)" style="color:red" id="hapus" title="Hapus Elemen"></i>
																</td>
																	</tr>
																<?php $no++; }  } ?>
																	</tbody>
																</table>
															</div>
															<br>
									<div class="col-lg-12" style="padding-top: 8px;" >
										<div style="text-align: center;">
										<button type="submit" style="float: center; margin-right: 3%; margin-top: -0.5%; display: none" class="btn btn-info" id="btnHidden"><i class="fa fa-arrow-right"></i> NEXT</button>
										<button type="button" style="float: center; margin-right: 3%; margin-top: -0.5%;" class="btn btn-info" id="btnShow"><i class="fa fa-arrow-right"></i> NEXT</button>
										<button type="button" style="float: center; margin-right: 3%; margin-top: -0.5%;" class="btn btn-success" id="btnEdit"><i class="fa fa-pencil-square-o"></i> EDIT OBSERVATION</button>
										</div>
									</div>
									<br> <br>
									<br>
								</div>
								</form>

<!--SECOND TABLE-->
<div class="table-responsive tableGenerate" id="tableGenerate" style="padding-left: 17px; padding-right: 17px;">
    <table class="table table-striped table-bordered table-hover text-center tblGenerate" style="table-layout: fixed;" name="tblUserResponsbility" id="tblGenerate" >
        <thead style="position: sticky; top: 0;">
            <tr class="bg-primary">
                <th style="position:sticky;top:0;" width="5%">SEQ</th>
                <th style="position:sticky;top:0;" width="20%">JENIS PROSES</th>
                <th style="position:sticky;top:0;" width="25%">ELEMEN KERJA</th>
                <th style="position:sticky;top:0;" width="20%">TIPE URUTAN</th>
                <th style="position:sticky;top:0;" width="10%">WAKTU</th>
                <th style="position:sticky;top:0;" width="10%">START</th>
                <th style="position:sticky;top:0;" width="10%">FINISH</th>
            </tr>
        </thead>
            <tbody id="tbodyGeneratorTSKK">
                        <?php
						// echo "<pre>";
						// print_r ($lihat_hasilObservasi);
                        // exit();
							if (empty($lihat_hasilObservasi_elemen)) {
								// echo
							}else{
							$no=1;
							$prev = null;
							$takt_time2 = $lihat_hasilObservasi[0]['takt_time'];
							// echo "<pre>";
							// print_r ($taktime2);
							// exit();
							foreach ($lihat_hasilObservasi_elemen as $key) {
                                //elemen tskk
								$jenis_proses = $key['jenis_proses'];
								$elemen = $key['elemen'];
								$keterangan_elemen = $key['keterangan_elemen'];
								$ek = $elemen." ".$keterangan_elemen;
								$tipe_urutan = $key['tipe_urutan'];
								$waktu = $key['waktu_kerja'];
									if ($no == 1) {
											$start = 1;
											$finish1 = ($waktu + 1) - 1;
											if ($finish1 > $takt_time2) {
												$finish = $finish1 - $takt_time2;
												$stat = 'eksekusi >';
											} else {
												$finish = $finish1;
												$stat = 'eksekusi =';
											}
											// echo "<pre>";
											// echo $finish;
									}else{
										if ($prev == 'AUTO (Inheritance)') {
											for ($i=0; $i < count($waktu) ; $i++) {
												$finish1 = ($waktu + $start) - 1;
												if ($finish1 > $takt_time2) {
													$finish = $finish1 - $takt_time2;
													$stat = 'eksekusi >';
												} else {
													$finish = $finish1;
													$stat = 'eksekusi =';
												}
												// echo "<pre>";
												// echo $finish;
											}
										}else{
											for ($i=0; $i < count($waktu) ; $i++) {
												$start = $finish + 1;
												$finish1 = ($waktu + $start) - 1;
												if ($finish1 > $takt_time2) {
													$finish = $finish1 - $takt_time2;
													$stat = 'eksekusi >';
												} else {
													$finish = $finish1;
													$stat = 'eksekusi =';
												}
												// echo "<pre>";
												// echo 'ini taktime = '.$takt_time2;
												// echo "<br>";
												// echo $finish;
												// echo ' '.$stat;
											}
										}
										$prev = $key['jenis_proses'];
									}
						?>
                <tr class='<?php echo "number_".$no ?>'>
                    <td class= "<?php if ( $tipe_urutan == 'PARALEL') { echo "wrapper"; }; ?> position"><?php echo $no?></td>
                    <td class="<?php if ( $tipe_urutan == 'PARALEL') { echo "wrapper"; }; ?>">
						<input type="text" style="<?php if ( $tipe_urutan == 'PARALEL') { echo "background-color: #d55d71;color:white;"; }; ?>;"
					 	value="<?php echo $jenis_proses; ?>" id="jenisProses" name="jenisProsesElemen[]" class="form-control jnsProses" placeholder="Jenis Proses" readonly></td>
                    </td>
                    <td class="<?php if ( $tipe_urutan == 'PARALEL') { echo "wrapper"; }; ?>">
                    	<input type="text" style="<?php if ( $tipe_urutan == 'PARALEL') { echo "background-color: #d55d71;color:white;"; }; ?>;" value="<?php echo $ek; ?>" name="elemenKerja[]" class="form-control" placeholder="Input Elemen Kerja" readonly>
					</td>
                    <td class="<?php if ( $tipe_urutan == 'PARALEL') { echo "wrapper"; }; ?>">
                    	<input type="text" style="<?php if ( $tipe_urutan == 'PARALEL') { echo "background-color: #d55d71;color:white;"; }; ?>;" value="<?php echo $tipe_urutan; ?>" id="urutanProses" name="tipeUrutanElemen[]" class="form-control" placeholder="Tipe Urutan Proses" readonly></td>
                    </td>
                    <td class="<?php if ( $tipe_urutan == 'PARALEL') { echo "wrapper"; }; ?>"><input type="number" style="<?php if ( $tipe_urutan == 'PARALEL') { echo "background-color: #d55d71;color:white;"; }; ?>;" value="<?php echo $waktu; ?>" id="waktu" name="waktuKerja[]" class="form-control waktu" placeholder="Detik" readonly></td>
                    <td class="<?php if ( $tipe_urutan == 'PARALEL') { echo "wrapper"; }; ?>"><input type="number" style="<?php if ( $tipe_urutan == 'PARALEL') { echo "background-color: #006bb3;color:white;"; }; ?>;" value="<?php echo $start; ?>" onchange="finishTableElement(this)" name="mulai[]" class="form-control mulai" placeholder="Detik" <?php if ( $tipe_urutan == 'SERIAL') { echo "readonly"; }; ?>></td>
                    <td class="<?php if ( $tipe_urutan == 'PARALEL') { echo "wrapper"; }; ?>"><input type="number" style="<?php if ( $tipe_urutan == 'PARALEL') { echo "background-color: #d55d71;color:white;"; }; ?>;" value="<?php echo $finish; ?>" name="finish[]" class="form-control finish" placeholder="Detik" <?php if ( $tipe_urutan == 'SERIAL') { echo "readonly"; }; ?> readonly></td>
                </tr>

			<?php $no++; ?>

			<?php }
			// exit();
			 } ?>
			</tbody>
    </table>
    <br>
				<div class="col-lg-12" style="padding-top: 8px; padding-bottom: 15px;">
					<div style="text-align: center;">
						<button type="button" onclick="generateTSKK(this)" style="float: center; margin-right: 3%; margin-top: -0.5%;" class="btn btn-info" id="generate" target="_blank"></i>GENERATE TSKK</button>
					</div>
				</div>
				<br>
		</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

<button onclick="addRowObservationAfterNext($(this))" id="myBtn" class="fa fa-plus fa-lg" style="display: none;  position: fixed;  bottom: 45px;  right: 30px;  z-index: 99;  font-size: 30px  text-center;  border: none; outline: none; background-color: green; color: white; cursor: pointer; width:35px; height:35px; border-radius: 50%;" title="Tambah Elemen"></button>

							<script>
							// When the user scrolls down 20px from the top of the document, show the button
							window.onscroll = function() {scrollFunction()};

							function scrollFunction() {
							  if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) {
							    document.getElementById("myBtn").style.display = "block";
							  } else {
							    document.getElementById("myBtn").style.display = "none";
							  }
							}

							// When the user clicks on the button, scroll to the top of the document
							function topFunction() {
							  document.body.scrollTop = 425;
							  document.documentElement.scrollTop = 425;
							}
							</script>
</section>

<!--LOADING-->
<div id="loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;" hidden="hidden">
  <img src="<?= base_url(); ?>/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
