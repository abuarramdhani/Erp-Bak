<style type="text/css">


#generate {
    border-radius: 25px;
}

#btnShow {
    border-radius: 25px;
}

#btnExportOBS {
    border-radius: 25px;
}

#btnImportOBS {
    border-radius: 25px;
}

#btnInsert{
    border-radius: 25px;
}

#inputInsertPosiition{
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

#txtTanggal{
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
  } */

}

</style>

<section class="content">
<?php foreach ($lihat_tabelElemen_Edit as $key) {
	$id = $key['id_tskk'];
} ?>
<form method="POST" action="<?php echo base_url('GeneratorTSKK/resaveEditObservation/'.$id); ?>">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-center">
							<h1><b>EDIT TSKK</b></h1>

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
								$dst =array_column($lihat_hasilObservasi_elemen, 'waktu_distribusi');
							if (empty($lihat_hasilObservasi_elemen)) {
							}else{
								// echo "<pre>";print_r($lihat_hasilObservasi_elemen);exit();
							$no=1;
							foreach ($lihat_hasilObservasi_elemen as $key) {
                                //header
                                $id = $key['id_tskk'];
                                $judul = $key['judul_tskk'];
                                $type = $key['tipe'];
                                $kode_part = $key['kode_part'];
                                $nama_part = $key['nama_part'];
                                // $no_alat = $key['no_alat_bantu'];
                                $seksi = $key['seksi'];
								$proses = $key['proses'];
								$kode_proses = $key['kode_proses'];
								$jenis_mesin = $key['mesin'];
								$jm = str_replace("; ","; \n", $jenis_mesin);
								$no_mesin = $key['no_mesin'];
								$resource_mesin = $key['resource_mesin'];
								$rm = str_replace("; ","; \n", $resource_mesin);
								$line_process = $key['line_process'];
								$alat_bantu = $key['alat_bantu'];
								$tools = $key['tools'];
								$jumlah_operator = $key['jumlah_operator'];
								$jumlah_operator_dari = $key['jumlah_operator_dari'];
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
								// $distribution_time = array_column($wktDistribusi, 'waktu_distribusi');
								// print_r($wktDistribusi);exit();
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
						<?php } } ?>
						<!--Judul TSKK :-->
						<label style="margin-left:4%;" for="norm">Judul: </label>
							<input type="text" style="width:50%; height:34px;  margin-left:2%; text-align:center;" value="<?php echo $judul ?>" placeholder="Input Judul TSKK" name="txtTitle" id="judul" class="lockscreen-credentials judul" readonly required/>
						<label for="norm" style="margin-left:5%; margin-right:-4%;" >Tanggal Observasi:</label>
						<input type="text" style="width:17%; height:34px; text-align:center;" value="<?php echo $tanggal ?>" placeholder="Input Tanggal" name="txtTanggal" id="txtTanggal" class="lockscreen-credentials txtTanggal" readonly required/>
						</div>
							<div class="panel-body">
							<div class="row">
							<!--PART-->
							<div class="col-lg-4">
							<input hidden class="form-control idTSKK" style="display:none" value="<?php echo $id; ?>">
								<div class="col-lg-12 box box-primary box-solid" style="padding-right: 7px;padding-left: 7px; padding-top: 5px; padding-bottom: 15px; ">
								<label for="norm" class="control-label" style="color:#428bca;font-size:18px;">PART</label>
									<br /><br>
									<!-- <input type="radio" name="terdaftar" value="Terdaftar" readonly> <label for="norm" class="control-label" >&nbsp;&nbsp;Terdaftar </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" name="terdaftar" value="tdkTerdaftar" readonly><label for="norm" class="control-label" >&nbsp;&nbsp; Tidak Terdaftar </label> -->
									<div class="row terdaftar">
										<br />
											<label for="norm" class="control-label col-lg-4">Type Product:</label>
											<div class="col-lg-8">
											<!-- <select style="height: 35px;" class="form-control select2 type" id="typeProduct" name="txtType" data-placeholder="Input Product Type" tabindex="-1" aria-hidden="true" disabled>
											<?php $listSeksi = explode(",", $type) ?>
											<?php foreach ($listSeksi as $tp => $item) {
														echo '<option value="'.$item.'" selected>'.$item.'</option>';
														}
											?>
											</select> -->
											<input type="text" placeholder="Input Type" value="<?php echo $type; ?>" name="txtType" value="" id="typeiNPUT" class="form-control type" readonly required/>
											</div>
									</div>
									<div class="row tdkTerdaftar" style="display:none">
										<br>
											<label for="norm" class="control-label col-lg-4">Type Product:</label>
											<div class="col-lg-8">
											<!-- <select style="height: 35px;" class="form-control select2" id="typeProduct" name="txtType" data-placeholder="Input Product Type" tabindex="-1" aria-hidden="true">
											</select> -->
											<input type="text" placeholder="Input Product Type" value="<?php echo $type; ?>"name="txtTypeT" value="" id="typeiNPUT" class="form-control type" readonly/>
											</div>
									</div>
									<br>
									<div class="row terdaftar">
											<label for="norm" class="control-label col-lg-4">Kode Part :</label>
											<div class="col-lg-8">
											<?php $listKodePart = explode(",", $kode_part) ?>
												<input type="text" data-placeholder="Input Kode Part" value="<?php echo $kode_part;?>" id="kodepartINPUT" name="txtKodepart" class="form-control kodepart" readonly/>
												<!-- <select style="height: 35px;" class="form-control select2 kodepart" id="kodepart" name="txtKodepart[]" data-placeholder="Input Kode Part" tabindex="-1" aria-hidden="true" disabled multiple>
												<?php foreach ($listKodePart as $kode => $item) {
														echo '<option value="'.$item.'" selected>'.$item.'</option>';
														}
													?>
												</select> -->
											</div>
									</div>
									<div class="row tdkTerdaftar" style="display:none">
											<label for="norm" class="control-label col-lg-4">Kode Part :</label>
											<div class="col-lg-8">
												<input type="text" placeholder="Input Kode Part" id="kodepartT" value="<?php echo $kode_part;?>" name="txtKodepartT" class="form-control kodepart" readonly/>
												<!-- <select style="height: 35px;" class="form-control select2" id="kodepart" name="txtKodepart[]" data-placeholder="Input Kode Part" tabindex="-1" aria-hidden="true" multiple> -->
												</select>
											</div>
									</div>
									<br>
									<div class="row terdaftar">
											<label for="norm" class="control-label col-lg-4">Nama Part :</label>
											<div id="divPassCheck" class="col-lg-8">
												<input type="text" style="height: 35px;" value="<?= $nama_part; ?>" placeholder="Input Nama Part" name="txtNamaPart" value="" id="namaPart" class="form-control namaPart" readonly required/>
											</div>
									</div>
									<div class="row tdkTerdaftar" style="display:none">
											<label for="norm" class="control-label col-lg-4">Nama Part :</label>
											<div id="divPassCheck" class="col-lg-8">
												<input type="text" style="height: 35px;" value="<?= $nama_part; ?>" placeholder="Input Nama Part" name="txtNamaPartT" value="" id="namaPart" class="form-control namaPart" readonly/>
											</div>
									</div>
								</div>
							</div>

							<!-- EQUIPMENT -->
							<div class="col-lg-8">
								<div class="box box-primary box-solid col-lg-12" style="padding-right: 7px;padding-left: 7px; padding-top: 5px; padding-bottom: 11px;">
									<label for="norm" class="control-label" style="color:#428bca;font-size:18px;">EQUIPMENT</label><br/>
									<br/><br/>
									<div class="col-lg-6">
										<div class="row">
												<label for="norm" class="control-label col-lg-4">No. Mesin :</label>
												<div class="col-lg-8">
												<input type="text" value="<?= $no_mesin; ?>" placeholder="Input Nomor Mesin" name="txtNoMesin" value="" id="txtNoMesinTSKK" class="form-control noMesin" readonly required/>
												</div>
										</div>
										<br>
										<!-- <input hidden class="form-control getID" value="<?php echo $id ?>"> -->
										<div class="row">
												<label for="norm" class="control-label col-lg-4">Jenis Mesin :</label>
												<div class="col-lg-8">
													<textarea type="text" value="<?= $jm; ?>" style="height: 35px;" placeholder="Input Jenis Mesin" name="txtJenisMesin[]" value="" id="jenisMesin" class="form-control jenisMesin" readonly><?= $jm;?></textarea>
													<!-- <input type="text" value="<?= $jenis_mesin; ?>" placeholder="Input Jenis Mesin" value="" id="jenisMesin" name="txtJenisMesin" class="form-control jenisMesin" readonly/> -->
												</div>
										</div>
										<br>
										<div class="row">
												<label for="norm" class="control-label col-lg-4">Resource :</label>
												<div id="divPassCheck" class="col-lg-8">
												<textarea type="text" value="<?= $rm; ?>" style="height: 35px;" placeholder="Input Resource" name="txtResource[]" value="" id="txtResource" class="form-control resource" readonly><?= $rm; ?></textarea>
													<!-- <input type="text" value="<?= $resource_mesin; ?>" style="height: 35px;" placeholder="Input Resource" name="txtResource" value="" id="txtResource" class="form-control resource" readonly/> -->
												</div>
										</div>
										<br>
									</div>
									<!--2-->
									<div class="col-lg-6">
										<div class="row">
												<label for="norm" class="control-label col-lg-4">Line :</label>
												<div class="col-lg-8">
													<input type="text" value="<?= $line_process; ?>" class="form-control line" id="line" name="txtLine" placeholder="Input Line" tabindex="-1" aria-hidden="true" readonly required/>
												</div>
										</div>
										<br>
										<div class="row">
												<label for="norm" class="control-label col-lg-4">Alat Bantu :</label>
												<div class="col-lg-8">
												<input type="text" value="<?= $alat_bantu; ?>" placeholder="Input Alat Bantu" name="txtAlatBantu" value="" id="txtAlatBantuEdit" class="form-control txtAlatBantu" readonly required/>
												</div>
										</div>
										<br>
										<div class="row">
												<label for="norm" class="control-label col-lg-4">Tools:</label>
												<div class="col-lg-8">
												<input type="text" value="<?= $tools; ?>" placeholder="Input Tools" name="txtTools" value="" id="txtToolsEdit" class="form-control tools" readonly/>
												</div>
										</div>
										<br>
									</div>
									</div>
								</div>
							</div>

							<!--SDM-->
							<div class="row">
								<div class="col-lg-4">
									<div class="box box-primary box-solid" style="padding-right: 7px;padding-left: 7px; padding-top: 5px;">
								<label for="norm" class="control-label" style="color:#428bca;font-size:18px;">SDM</label>
								<br />
									<div class="row">
									<br>
										<label for="norm" class="control-label col-lg-4">Nama :</label>
										<div class="col-lg-8">
										<input type="text" value="<?= $operator; ?>" placeholder="Input Nama Operator" name="txtNamaINPUT" id="txtOperatorinput" class="form-control txtOperator" readonly/>
										<!-- <?php $listOperator = explode(",", $operator) ?>
											<select class="form-control select2" data-placeholder="Input Nama Operator" name="txtNama[]" value="" id="txtOperator" disabled required multiple>
											<?php foreach ($listOperator as $opr) {
												echo '<option value="'.$opr.'" selected>'.$opr.'</option>';
												}
											?>
											</select> -->
										</div>
									</div>
									<br>
									<div class="row">
										<label for="norm" class="control-label col-lg-4">Jumlah Operator :</label>
										<div class="col-lg-3">
											<input type="text" value="<?= $jumlah_operator; ?>" placeholder="Input Jumlah Operator" name="txtJmlOperator" value="" id="txtJmlOperator" class="form-control jml_oprator" readonly/>
										</div>
										<label class="control-label col-lg-2 text-left">Dari:</label>
										<div class="col-lg-3">
											<input type="text" value="<?= $jumlah_operator_dari; ?>" placeholder="Input" name="txtDariOperator" value="" id="txtDari" class="form-control txtDari" readonly/>
										</div>
									</div>
									<br>
									<div class="row">
										<label for="norm" class="control-label col-lg-4">Seksi :</label>
										<div class="col-lg-8">
										<input type="text" value="<?= $seksi; ?>" placeholder="Input Seksi" name="txtSeksiINPUT" id="pilihseksiinput" class="form-control pilihseksi" readonly/>
										<!-- <?php $listSeksi = explode(",", $seksi) ?>
										<select class="form-control select2" id="pilihseksi" name="txtSeksi" data-placeholder="Input Seksi" tabindex="-1" aria-hidden="true" disabled>
										<?php foreach ($listSeksi as $sk => $section) {
											echo '<option value="'.$section.'" selected>'.$section.'</option>';
											}
										?> -->
										</select>
										</div>
									</div>
									<br>
								</div>
								<!--ACTIVITY-->
								<div class="row" style="display:none">
									<div class="col-lg-12">
										<div class="box box-primary box-solid" style="padding-right: 7px;padding-left: 7px; padding-top: 5px;">
										<label for="norm" class="control-label" style="color:#428bca;font-size:18px;">ACTIVITY</label>
											<div class="row">
											<br>
													<label for="norm" class="control-label col-lg-4">Tanggal :</label>
													<div class="col-lg-8">
													<!-- <input type="text" placeholder="Input Tanggal" id="txtTanggal" class="form-control txtTanggal" required/> -->
													</div>
											</div>
											<br>
										</div>
									</div>
								</div>
							</div>
							<!-- PROCESS -->
							<div class="col-lg-8">
								<div class="col-lg-12 box box-primary box-solid" style="padding-right: 7px;padding-left: 7px; padding-top: 5px; padding-bottom: 33px;">
									<label for="norm" class="control-label" style="color:#428bca;font-size:18px;">PROCESS</label>
									<br>
									<div class="col-lg-12">
									<div class="row">
									<br>
										<label for="norm" class="control-label col-lg-2">Proses :</label>
										<div id="divPassCheck" class="col-lg-10">
											<input type="text" value="<?= $proses; ?>" style="height: 35px;" placeholder="Input Proses" name="txtProses" value="" id="txtProses" class="form-control proses" readonly required/>
										</div>
										</div>
										<br>
										<div class="row">
												<label for="norm" class="control-label col-lg-2">Kode Proses :</label>
												<div id="divPassCheck" class="col-lg-10">
													<input type="text" value="<?= $kode_proses; ?>" style="height: 35px;" placeholder="Input Kode Proses" name="txtKodeProses" value="" id="txtKodeProses" class="form-control kodeproses" readonly required/>
												</div>
										</div>
										<br>
										<!-- <div class="row">
												<label for="norm" class="control-label col-lg-2">Proses ke :</label>
												<div class="col-lg-10">
												<input type="text" placeholder="Input Proses ke" name="txtProsesKe" value="" id="txtProsesKe" class="form-control proses_ke" required/>
												</div>
										</div> -->
										<div class="row">
										<label for="norm" class="control-label col-lg-2">Proses ke :</label>
										<div class="col-lg-4">
										<input type="text" placeholder="Input Proses ke"  value="<?= $proses_ke; ?>" name="txtProsesKe" value="" id="txtProsesKe" class="form-control proses_ke" readonly required/>
										</div>
										<label class="control-label col-lg-2 text-left">Dari :</label>
										<div class="col-lg-4">
											<input type="text" placeholder="Input"  value="<?= $dari; ?>" name="txtDariProses" value="" id="txtDariProses" class="form-control txtDariProses" readonly/>
										</div>
										</div>
										<br>
										<!-- <input hidden class="form-control getID" value="<?php echo $id ?>"> -->
										<div class="row">
												<label for="norm" class="control-label col-lg-2">Qty/Proses :</label>
												<div class="col-lg-10">
													<input type="text"  value="<?= $qty; ?>" placeholder="Input Qty/Proses" value="" id="qtyProses" name="txtQtyProses" class="form-control qty_proses" readonly/>
												</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<br>
                            <div class="panel panel-default">
                            <div class="panel-heading text-left">
								<label style="margin-left: 2%;">Perhitungan Takt Time</label>
							</div>
                            <div class="panel-body">
								<?php
								if (!empty($lihat_perhitungan_takt_time)) {
									foreach ($lihat_perhitungan_takt_time as $pt) {
										$waktu_satu_shift = $pt['waktu_satu_shift'];
										$jumlah_shift = $pt['jumlah_shift'];
										$rencana_produksi = $pt['rencana_produksi'];
										$jumlah_hari_kerja = $pt['jumlah_hari_kerja'];
										$forecast = $pt['forecast'];
										$qty_unit = $pt['qty_unit'];
									}
								}else{
									$waktu_satu_shift = null;
									$jumlah_shift = null;
									$rencana_produksi = null;
									$jumlah_hari_kerja = null;
									$forecast = null;
									$qty_unit = null;
								}
								?>
									<div class="col-lg-6">
										<div class="row">
												<label for="norm" class="control-label col-lg-6">Waktu 1 Shift (Detik) : </label>
												<div class="col-lg-6">
													<input type="number" value="<?php echo $waktu_satu_shift;?>" style="margin-left:-35px;" placeholder="Input Waktu Satu Shift" name="txtWaktu1Shift"  id="txtWaktu1Shift" class="form-control waktu1Shift" readonly/>
												</div>
										</div>
										<br>
										<div class="row">
												<label for="norm" class="control-label col-lg-6">Jumlah Shift (Shift) :</label>
												<div class="col-lg-6">
													<input type="number" value="<?php echo $jumlah_shift;?>" style="margin-left:-35px;" placeholder="Input Jumlah Shift" name="txtJumlahShift"  id="txtJumlahShift" class="form-control jumlahShift" readonly />
												</div>
										</div>
										<br>
										<div class="row">
												<label for="norm" class="control-label col-lg-6">Jumlah Hari Kerja (Hari) :</label>
												<div class="col-lg-6">
													<input type="number" style="margin-left:-35px;" value="<?php echo $jumlah_hari_kerja;?>" placeholder="Input Jumlah Hari Kerja" name="txtJumlahHariKerja" id="txtJumlahHariKerja" class="form-control jumlahHariKerja" readonly />
												</div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="row">
												<label for="norm" class="control-label col-lg-6">Forecast (Unit) : </label>
												<div class="col-lg-6">
													<input type="number" placeholder="Forecast" value="<?php echo $forecast;?>" name="txtForecast" id="txtForecast" class="form-control forecast" readonly/>
												</div>
										</div>
										<br>
										<div class="row">
												<label for="norm" class="control-label col-lg-6">Qty / Unit: </label>
												<div class="col-lg-6">
													<input type="number" placeholder="Qty / Unit" value="<?php echo $qty_unit;?>" name="txtQtyUnit" id="txtQtyUnit" class="form-control qtyUnit" readonly/>
												</div>
										</div>
										<br>
										<div class="row">
												<label for="norm" value="<?php echo $rencana_produksi;?>" class="control-label col-lg-6">Rencana Produksi/Forecast (Pcs) : </label>
												<div class="col-lg-6">
													<input type="number" value="<?php echo $rencana_produksi;?>" placeholder="Input Rencana Produksi" name="txtRencana" id="txtRencana" class="form-control forecast" readonly/>
												</div>
										</div>
									</div>
                            </div>
                            </div>
							<br>
								<div class="row">
										<div class="row">
											<div class="col-lg-12" >
												<?php if ($dst != null) {
													$nDistribusi = array_sum($dst);
													$wktDistribusi = null;
												}else{
													$nDistribusi = null;
												}
												// echo $wktKerja;
												// 	exit();
												?>
												<div class="panel panel-default">
													<div class="panel-heading" style="">
														<label for="norm" style="margin-left:75%;">Takt Time : </label>
															<input type="number" style="width:10%; height:34px; margin-right:5%;  margin-left:2%; text-align:center;" value="<?php echo $takt_time; ?>" placeholder="Input Takt Time" name="taktTime" id="inputInsert" class="lockscreen-credentials taktTime" readonly/>
													</div>
<!--SECOND TABLE-->
<div class="panel panel-default">
<div class="table-responsive tableGenerate" id="tableGenerate" style="padding-left: 17px; padding-right: 17px;"><br>
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
						// foreach ($lihat_hasilObservasi as $key) {
						// 	$takt_time2 = $key['takt_time'];
						// }
						if ($status == 0) { //after next being clicked
							// echo "<pre>";print_r($lihat_tabelElemen_Edit);
							if (empty($lihat_tabelElemen_Edit)) {
								// echo
							}else{
							$no=1;
							$prev = null;
							// $takt_time2 = $lihat_hasilObservasi[0]['takt_time'];
							// echo "<pre>";
							// echo ($takt_time2);
							// exit();
							foreach ($lihat_tabelElemen_Edit as $key) {
								// echo "<pre>";print_r($key);
                                //elemen tskk
								$jenis_proses = $key['jenis_proses'];
								$elemen = $key['elemen'];
								$keterangan_elemen = $key['keterangan_elemen'];
								$ek = $elemen." ".$keterangan_elemen;
								$tipe_urutan = $key['tipe_urutan'];
								$waktu = $key['waktu'];
								$start = $key['mulai'];
								$finish = $key['finish'];
									?>
								<tr class='<?php echo "number_".$no ?>'>
									<td class= "<?php if ( $tipe_urutan == 'PARALEL') { echo "wrapper"; }; ?> position"><?php echo $no?></td>
									<td class="<?php if ( $tipe_urutan == 'PARALEL') { echo "wrapper"; }; ?>">
										<input type="text" style="<?php if ( $tipe_urutan == 'PARALEL') { echo "background-color: #d55d71;color:white;"; }; ?>;"
										value="<?php echo $jenis_proses; ?>" id="jenisProses" name="jenisProsesElemen[]" class="form-control jnsProses" placeholder="Jenis Proses" readonly></td>
									</td>
									<td class="<?php if ( $tipe_urutan == 'PARALEL') { echo "wrapper"; }; ?>">
										<input type="text" style="<?php if ( $tipe_urutan == 'PARALEL') { echo "background-color: #d55d71;color:white;"; }; ?>;" value="<?php echo $ek; ?>" name="elemenKerja[]" class="form-control" placeholder="Input Elemen Kerja" readonly>
										<input type="hidden" value="<?php echo $elemen?>" name="txtElemenKerja[]"/>
										<input type="hidden" value="<?php echo $keterangan_elemen?>" name="txtKeteranganElemenKerja[]"/>
									</td>
									<td class="<?php if ( $tipe_urutan == 'PARALEL') { echo "wrapper"; }; ?>">
										<input type="text" style="<?php if ( $tipe_urutan == 'PARALEL') { echo "background-color: #d55d71;color:white;"; }; ?>;" value="<?php echo $tipe_urutan; ?>" id="urutanProses" name="tipeUrutanElemen[]" class="form-control" placeholder="Tipe Urutan Proses" readonly></td>
									</td>
									<td class="<?php if ( $tipe_urutan == 'PARALEL') { echo "wrapper"; }; ?>"><input type="number" style="<?php if ( $tipe_urutan == 'PARALEL') { echo "background-color: #d55d71;color:white;"; }; ?>;" value="<?php echo $waktu; ?>" id="waktu" name="waktuKerja[]" class="form-control waktu" placeholder="Detik" readonly></td>
									<td class="<?php if ( $tipe_urutan == 'PARALEL') { echo "wrapper"; }; ?>"><input type="number" style="<?php if ( $tipe_urutan == 'PARALEL') { echo "background-color: #006bb3;color:white;"; }; ?>;" value="<?php echo $start; ?>" onchange="finishTableElement(this)" name="mulai[]" class="form-control mulai" placeholder="Detik" <?php if ( $tipe_urutan == 'SERIAL') { echo "readonly"; }; ?>></td>
									<td class="<?php if ( $tipe_urutan == 'PARALEL') { echo "wrapper"; }; ?>"><input type="number" style="<?php if ( $tipe_urutan == 'PARALEL') { echo "background-color: #d55d71;color:white;"; }; ?>;" value="<?php echo $finish; ?>"id="finish" name="finish[]" class="form-control finish" placeholder="Detik" <?php if ( $tipe_urutan == 'SERIAL') { echo "readonly"; }; ?> readonly></td>
								</tr>
								<?php $no++; ?>
					<?php	} }
					}else{ //beginning load
							if (empty($lihat_hasilObservasi_elemen)) {
								// echo
							}else{
							$no=1;
							$prev = null;
							// $takt_time2 = $lihat_hasilObservasi[0]['takt_time'];
							// foreach ($lihat_hasilObservasi as $key) {
							// 	$takt_time2 = $key['takt_time'];
							// }
							// echo "<pre>";
							// echo ($takt_time2);
							// exit();
							foreach ($lihat_hasilObservasi_elemen as $key) {
								// echo "<pre>";print_r($key);
                                //elemen tskk
								$jenis_proses = $key['jenis_proses'];
								$elemen = $key['elemen'];
								$keterangan_elemen = $key['keterangan_elemen'];
								$ek = $elemen." ".$keterangan_elemen;
								$tipe_urutan = $key['tipe_urutan'];
								$waktu = $key['waktu_kerja'];
								$takt_time2 = $key['takt_time'];
								// $start = $key['mulai'];
								// $finish = $key['finish'];
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
                    <td class="<?php if ( $tipe_urutan == 'PARALEL') { echo "wrapper"; }; ?>"><input type="number" style="<?php if ( $tipe_urutan == 'PARALEL') { echo "background-color: #d55d71;color:white;"; }; ?>;" value="<?php echo $finish; ?>"id="finish" name="finish[]" class="form-control finish" placeholder="Detik" <?php if ( $tipe_urutan == 'SERIAL') { echo "readonly"; }; ?> readonly></td>
                </tr>
			<?php $no++; ?>
			<?php }  }  } ?>
			</tbody>
    </table>
<!-- </div> -->
<!-- </div> -->
						<br>
                            <div class="panel panel-default">
                            <div class="panel-heading text-left">
								<label style="margin-left: 2%;">Irregular Job</label>
							</div>
                            <div class="panel-body">
                              <table class="datatable table table-striped table-bordered table-hover tabel_irregular_job" style="width: 100%">
							    <thead class="bg-primary">
                                  <tr>
                                    <th width="5%" class="text-center">NO</th>
                                    <th width="40%" class="text-center">IRREGULAR JOB</th>
                                    <th width="15%" class="text-center">RATIO <br> (KALI)</th>
									<th width="15%" class="text-center">WAKTU <br> (DETIK)</th>
									<th width="15%" class="text-center">WAKTU/RATIO <br> (DETIK)</th>
                                  </tr>
                                </thead>
                                <tbody id="tbodyIrregularJob">
								<?php $no=1;
									foreach ($lihat_irregular_jobs as $ij) {
										$irregular_job = $ij['irregular_job'];
										$ratio_irregular = $ij['ratio'];
										$waktu_irregular = $ij['waktu'];
										$hasil_irregular_job = $ij['hasil_irregular_job'];
								?>
                                    <tr class="nmbr_1">
                                      <td style="width: 5%; text-align:center;" class="position"><?php echo $no;?></td>
                                      <td style="text-align: center;"> <input type="text" value="<?php echo $irregular_job;?>" class="form-control irregularJob" name="txtIrregularJob[]" id="irregularJob" readonly></td>
                                      <td style="text-align: center;"> <input type="number" value="<?php echo $ratio_irregular;?>" onchange="countIrregularJobs(this)" style="text-align: center;" class="form-control ratio" name="txtRatioIrregular[]" id="ratio" readonly></td>
                                      <td style="text-align: center;"> <input type="number" value="<?php echo $waktu_irregular;?>" onchange="countIrregularJobs(this)" style="text-align: center;" class="form-control waktu" name="txtWaktuIrregular[]" id="waktu" readonly></td>
									  <td style="text-align: center;" class="hasilIrregularJob" id="hasilIrregularJob"><input type="text" value="<?php echo $hasil_irregular_job;?>" style="text-align: center;" class="form-control hasilIrregularJob" name="txtHasilWaktuIrregular[]" readonly></td>
                                    </tr>
								<?php $no++; } ?>
                                </tbody>
                              </table>
                            </div>
                            </div>
    <!-- <br> -->
				<div class="col-lg-12" style="padding-top: 8px; padding-bottom: 15px;">
					<div style="text-align: center;">
						<button type="button" onclick="generateTSKK(this)" style="float: center; margin-right: 3%; margin-top: -0.5%;" class="btn btn-primary" id="generate" target="_blank"></i>GENERATE TSKK</button>
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
</section>

<!--LOADING-->
<div id="loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;" hidden="hidden">
  <img src="<?= base_url(); ?>/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
