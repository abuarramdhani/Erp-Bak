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

  #btnInsert {
    border-radius: 25px;
  }

  #inputInsertPosiition {
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

  #btnSaveObservation {
    border-radius: 25px;
  }

  tbody {
    overflow-y: auto;
    /* Trigger vertical scroll */
  }

  .select2-container {
    width: 200px;
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
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(102, 175, 233, .6);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(102, 175, 233, .6);
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

  #txtTanggal {
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

  }
</style>

<section class="content">
  <?php foreach ($lihat_hasilObservasi_elemen as $key) {
	$id = $key['id_tskk'];
} ?>
  <form id='Observasi' method="POST" action="<?php echo base_url('GeneratorTSKK/resaveEditObservation/'.$id); ?>">
    <div class="inner">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-12">
              <div class="col-lg-11">
                <div class="text-center">
                  <h1><b>EDIT LEMBAR OBSERVASI</b></h1>

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
								$jenisInputPart = $key['jenis_input_part'];
								$jenisInputElement = $key['jenis_input_element'];
						?>
                  <?php } } ?>
                  <!--Judul TSKK :-->
                  <label style="margin-left:4%;" for="norm">Judul: </label>
                  <input type="text" style="width:50%; height:34px;  margin-left:2%; text-align:center;" value="<?php echo $judul ?>" placeholder="Input Judul TSKK" name="txtTitle" id="judul" class="lockscreen-credentials judul" required />
                  <label for="norm" style="margin-left:5%; margin-right:-4%;">Tanggal Observasi:</label>
                  <input type="text" style="width:17%; height:34px; text-align:center;" value="<?php echo $tanggal ?>" placeholder="Input Tanggal" name="txtTanggal" id="txtTanggal" class="lockscreen-credentials txtTanggal" required />
                </div>
                <div class="panel-body">
                  <div class="row">
                    <!--PART-->
                    <div class="col-lg-4">
                      <input hidden class="form-control idTSKK" name="id_tskk" style="display:none" value="<?php echo $id; ?>">
                      <div class="col-lg-12 box box-primary box-solid" style="padding-right: 7px;padding-left: 7px; padding-top: 5px; padding-bottom: 15px; ">
                        <label for="norm" class="control-label" style="color:#428bca;font-size:18px;">PART</label>
                        <br />
                        <input type="radio" name="terdaftar" value="Terdaftar" <?php if($jenisInputPart == "Terdaftar") { echo "checked";}?>> <label for="norm" class="control-label">&nbsp;&nbsp;Terdaftar </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="terdaftar" value="TidakTerdaftar" <?php if($jenisInputPart == "TidakTerdaftar") { echo "checked";}?>><label for="norm" class="control-label">&nbsp;&nbsp; Tidak Terdaftar </label>
                        <div class="row terdaftar" style="<?php if ($jenisInputPart != "Terdaftar") { echo "display:none";}?>">
                          <br />
                          <label for="norm" class="control-label col-lg-4">Type Product:</label>
                          <div class="col-lg-8">
                            <select style="height: 35px; width:200px;" class="select2 type" id="typeProduct" name="txtType" data-placeholder="Input Product Type" tabindex="-1" aria-hidden="true">
                              <?php if ($jenisInputPart == 'Terdaftar') {
													$listSeksi = explode(",", $type);
														foreach ($listSeksi as $tp => $item) {
															echo '<option value="'.$item.'" selected>'.$item.'</option>';
												} } ?>
                            </select>
                          </div>
                        </div>
                        <div class="row tdkTerdaftar" style="<?php if ($jenisInputPart != "TidakTerdaftar") { echo "display:none";}?>">
                          <br>
                          <label for="norm" class="control-label col-lg-4">Type Product:</label>
                          <div class="col-lg-8">
                            <input type="text" placeholder="Input Product Type" value="<?php if ($jenisInputPart == "TidakTerdaftar") { echo $type; } ?>" name="txtTypeT" id="typeiNPUT" class="form-control type" />
                          </div>
                        </div>
                        <br>
                        <div class="row terdaftar" style="<?php if ($jenisInputPart != "Terdaftar") { echo "display:none";}?>">
                          <label for="norm" class="control-label col-lg-4">Kode Part :</label>
                          <div class="col-lg-8">
                            <select style="height: 35px; width:200px;" onchange="detectSelectKodePart(this)" class="select2 kodepart" id="kodepart" name="txtKodepart[]" data-placeholder="Input Kode Part" tabindex="-1" aria-hidden="true" multiple>
                              <?php if ($jenisInputPart == 'Terdaftar') {
														$listKodePart = explode(",", $kode_part);
															foreach ($listKodePart as $kode => $item) {
																echo '<option value="'.$item.'" selected>'.$item.'</option>';
													} } ?>
                            </select>
                          </div>
                        </div>
                        <div class="row tdkTerdaftar" style="<?php if ($jenisInputPart != "TidakTerdaftar") { echo "display:none";}?>">
                          <label for="norm" class="control-label col-lg-4">Kode Part :</label>
                          <div class="col-lg-8">
                            <input type="text" placeholder="Input Kode Part" id="kodepartT" value="<?php if ($jenisInputPart == "TidakTerdaftar") { echo $kode_part; }?>" name="txtKodepartT" class="form-control kodepart" />
                          </div>
                        </div>
                        <br>
                        <div class="row terdaftar" style="<?php if ($jenisInputPart != "Terdaftar") { echo "display:none";}?>">
                          <label for="norm" class="control-label col-lg-4">Nama Part :</label>
                          <div id="divPassCheck" class="col-lg-8">
                            <input type="text" style="height: 35px;" value="<?php if ($jenisInputPart == "Terdaftar") { echo $nama_part; }?>" placeholder="Input Nama Part" name="txtNamaPart" id="namaPart" class="form-control namaPart" />
                          </div>
                        </div>
                        <div class="row tdkTerdaftar" style="<?php if ($jenisInputPart != "TidakTerdaftar") { echo "display:none";}?>">
                          <label for="norm" class="control-label col-lg-4">Nama Part :</label>
                          <div id="divPassCheck" class="col-lg-8">
                            <input type="text" style="height: 35px;" value="<?php if ($jenisInputPart == "TidakTerdaftar") { echo $nama_part; }?>" placeholder="Input Nama Part" name="txtNamaPartT" id="namaPart" class="form-control namaPart" />
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- EQUIPMENT -->
                    <div class="col-lg-8">
                      <div class="box box-primary box-solid col-lg-12" style="padding-right: 7px;padding-left: 7px; padding-top: 5px; padding-bottom: 11px;">
                        <label for="norm" class="control-label" style="color:#428bca;font-size:18px;">EQUIPMENT</label><br />
                        <!-- <br/><br/> -->
                        <div class="col-lg-6">
                          <div class="row">
                            <br><br>
                            <label for="norm" class="control-label col-lg-4">No. Mesin :</label>
                            <div class="col-lg-8">
                              <?php $listNoMesin = explode(";", $no_mesin) ?>
                              <select style="height: 35px;" class="form-control select2 noMesin" id="txtNoMesinTSKK" name="txtNoMesin[]" data-placeholder="Input Nomor Mesin" tabindex="-1" aria-hidden="true" multiple>
                                <?php foreach ($listNoMesin as $nm) {
													echo '<option value="'.$nm.'" selected>'.$nm.'</option>';
												}
												?>
                              </select>
                              <!-- <input type="text" value="<?= $no_mesin; ?>" placeholder="Input Nomor Mesin" name="txtNoMesin" id="txtNoMesinTSKK" class="form-control noMesin" required/> -->
                            </div>
                          </div>
                          <br>
                          <!-- <input hidden class="form-control getID" value="<?php echo $id ?>"> -->
                          <div class="row">
                            <label for="norm" class="control-label col-lg-4">Jenis Mesin :</label>
                            <div class="col-lg-8">
                              <textarea type="text" value="<?= $jm; ?>" style="height: 35px;" placeholder="Input Jenis Mesin" name="txtJenisMesin[]" id="jenisMesin" class="form-control jenisMesin"><?= $jm;?></textarea>
                              <!-- <input type="text" value="<?= $jenis_mesin; ?>" placeholder="Input Jenis Mesin" id="jenisMesin" name="txtJenisMesin" class="form-control jenisMesin" readonly/> -->
                            </div>
                          </div>
                          <br>
                          <div class="row">
                            <label for="norm" class="control-label col-lg-4">Resource :</label>
                            <div id="divPassCheck" class="col-lg-8">
                              <textarea type="text" value="<?= $rm; ?>" style="height: 35px;" placeholder="Input Resource" name="txtResource[]" value="" id="txtResource" class="form-control resource"><?= $rm; ?></textarea>
                              <!-- <input type="text" value="<?= $resource_mesin; ?>" style="height: 35px;" placeholder="Input Resource" name="txtResource" value="" id="txtResource" class="form-control resource" readonly/> -->
                            </div>
                          </div>
                          <br>
                        </div>
                        <!--2-->
                        <!-- <br> -->
                        <div class="col-lg-6">
                          <input type="radio" name="equipmenTerdaftar" value="Terdaftar" <?php if($jenisInputElement == "Terdaftar") { echo "checked";}?>> <label for="norm" class="control-label">&nbsp;&nbsp;Terdaftar </label>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="equipmenTerdaftar" value="TidakTerdaftar" <?php if($jenisInputElement == "TidakTerdaftar") { echo "checked";}?>><label for="norm" class="control-label">&nbsp;&nbsp; Tidak Terdaftar </label>
                          <br /><br />
                          <div class="row equipmenTerdaftar" style="<?php if ($jenisInputElement != "Terdaftar") { echo "display:none";}?>">
                            <label for="norm" class="control-label col-lg-4">Alat Bantu :</label>
                            <div class="col-lg-8">
                              <select style="height: 35px; width:200px;" class="select2 txtAlatBantu" id="txtAlatBantu" name="txtAlatBantu[]" data-placeholder="Input Alat Bantu" tabindex="-1" aria-hidden="true" multiple>
                                <?php if ($jenisInputElement == "Terdaftar") {
																$listAlatBantu = explode("; ", $alat_bantu);
																		foreach ($listAlatBantu as $ab => $albt) {
																			echo '<option value="'.$albt.'" selected>'.$albt.'</option>';
															} } ?>
                              </select>
                            </div>
                          </div>
                          <div class="row equipmenTdkTerdaftar" style="<?php if ($jenisInputElement != "TidakTerdaftar") { echo "display:none";}?>">
                            <label for="norm" class="control-label col-lg-4">Alat Bantu :</label>
                            <div class="col-lg-8">
                              <input type="text" value="<?php if ($jenisInputElement == "TidakTerdaftar") { echo $alat_bantu; } ?>" placeholder="Input Alat Bantu" name="txtAlatBantuT" value="" id="txtAlatBantu" class="form-control txtAlatBantu"
                                required />
                            </div>
                          </div>
                          <br>
                          <div class="row equipmenTerdaftar" style="<?php if ($jenisInputElement != "Terdaftar") { echo "display:none";}?>">
                            <label for="norm" class="control-label col-lg-4">Tools:</label>
                            <div class="col-lg-8">
                              <select style="height: 35px; width:200px;" class="select2 tools" id="txtTools" name="txtTools[]" data-placeholder="Input Tools" tabindex="-1" aria-hidden="true" multiple>
                                <?php if ($jenisInputElement == "Terdaftar") {
														$listTools = explode("; ", $tools);
															foreach ($listTools as $tl => $tools) {
																echo '<option value="'.$tools.'" selected>'.$tools.'</option>';
													} } ?>
                              </select>
                            </div>
                          </div>
                          <div class="row equipmenTdkTerdaftar" style="<?php if ($jenisInputElement != "TidakTerdaftar") { echo "display:none";}?>">
                            <label for="norm" class="control-label col-lg-4">Tools:</label>
                            <div class="col-lg-8">
                              <input type="text" value="<?php if ($jenisInputElement == "TidakTerdaftar") { echo $tools; }?>" placeholder="Input Tools" name="txtToolsT" value="" id="txtTools" class="form-control tools" />
                            </div>
                          </div>
                          <br>
                          <div class="row">
                            <label for="norm" class="control-label col-lg-4">Line :</label>
                            <div class="col-lg-8">
                              <input type="text" value="<?= $line_process; ?>" class="form-control line" id="line" name="txtLine" placeholder="Input Line" tabindex="-1" aria-hidden="true" required />
                            </div>
                          </div>
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
                            <!-- <input type="text" value="<?= $operator; ?>" placeholder="Input Nama Operator" name="txtNamaINPUT" id="txtOperatorinput" class="form-control txtOperator"/> -->
                            <?php $listOperator = explode(",", $operator) ?>
                            <select class="form-control select2" data-placeholder="Input Nama Operator" name="txtNama[]" value="" id="txtOperator" required multiple>
                              <?php foreach ($listOperator as $opr) {
												echo '<option value="'.$opr.'" selected>'.$opr.'</option>';
												}
											?>
                            </select>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label for="norm" class="control-label col-lg-4">Jumlah Operator :</label>
                          <div class="col-lg-3">
                            <input type="text" value="<?= $jumlah_operator; ?>" placeholder="Input Jumlah Operator" name="txtJmlOperator" value="" id="txtJmlOperator" class="form-control jml_oprator" />
                          </div>
                          <label class="control-label col-lg-2 text-left">Dari:</label>
                          <div class="col-lg-3">
                            <input type="text" value="<?= $jumlah_operator_dari; ?>" placeholder="Input" name="txtDariOperator" value="" id="txtDari" class="form-control txtDari" />
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label for="norm" class="control-label col-lg-4">Seksi :</label>
                          <div class="col-lg-8">
                            <!-- <input type="text" value="<?= $seksi; ?>" placeholder="Input Seksi" name="txtSeksiINPUT" id="pilihseksiinput" class="form-control pilihseksi"/> -->
                            <?php $listSeksi = explode("#", $seksi) ?>
                            <select class="form-control select2" id="pilihseksi" name="txtSeksi" data-placeholder="Input Seksi" tabindex="-1" aria-hidden="true">
                              <?php foreach ($listSeksi as $sk => $section) {
											echo '<option value="'.$section.'" selected>'.$section.'</option>';
											}
										?>
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
                              <input type="text" value="<?= $proses; ?>" style="height: 35px;" placeholder="Input Proses" name="txtProses" id="txtProcess" class="form-control process" required />
                            </div>
                          </div>
                          <br>
                          <div class="row">
                            <label for="norm" class="control-label col-lg-2">Kode Proses :</label>
                            <div id="divPassCheck" class="col-lg-10">
                              <input type="text" value="<?= $kode_proses; ?>" style="height: 35px;" placeholder="Input Kode Proses" name="txtKodeProses" id="txtKodeProses" class="form-control kodeproses" required />
                            </div>
                          </div>
                          <br>
                          <!-- <div class="row">
												<label for="norm" class="control-label col-lg-2">Proses ke :</label>
												<div class="col-lg-10">
												<input type="text" placeholder="Input Proses ke" name="txtProsesKe" id="txtProsesKe" class="form-control proses_ke" required/>
												</div>
										</div> -->
                          <div class="row">
                            <label for="norm" class="control-label col-lg-2">Proses ke :</label>
                            <div class="col-lg-4">
                              <input type="text" placeholder="Input Proses ke" value="<?= $proses_ke; ?>" name="txtProsesKe" id="txtProsesKe" class="form-control proses_ke" required />
                            </div>
                            <label class="control-label col-lg-2 text-left">Dari :</label>
                            <div class="col-lg-4">
                              <input type="text" placeholder="Input" value="<?= $dari; ?>" name="txtDariProses" id="txtDariProses" class="form-control txtDariProses" />
                            </div>
                          </div>
                          <br>
                          <!-- <input hidden class="form-control getID" value="<?php echo $id ?>"> -->
                          <div class="row">
                            <label for="norm" class="control-label col-lg-2">Qty/Proses :</label>
                            <div class="col-lg-10">
                              <input type="text" value="<?= $qty; ?>" placeholder="Input Qty/Proses" id="qtyProses" name="txtQtyProses" class="form-control qty_proses" />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="panel panel-default">
                    <div class="panel-heading text-left">
                      <label style="margin-left: 2%;">Perhitungan Takt Time </label> &nbsp;&nbsp; &nbsp; &nbsp;
                      <input type="radio" name="perhitunganTakt" value="1" <?php echo $takt_time != '99999' ? 'checked' : ''?>> <label for="" class="control-label">&nbsp;&nbsp;Ya </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <input type="radio" name="perhitunganTakt" value="0" <?php echo $takt_time == '99999' ? 'checked' : ''?>><label for="norm" class="control-label">&nbsp;&nbsp; Tidak </label>
                    </div>
                    <div class="panel-body tskk_delik_cek" <?php echo $takt_time == '99999' ? 'style="display:none"' : ''?>>
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
                            <input type="number" style="margin-left:-35px;" value="<?php echo $waktu_satu_shift;?>" placeholder="Input Waktu Satu Shift" oninput="countTaktTime()" name="txtWaktu1Shift" id="txtWaktu1Shift"
                              class="form-control waktu1Shift" />
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label for="norm" class="control-label col-lg-6">Jumlah Shift (Shift) :</label>
                          <div class="col-lg-6">
                            <input type="number" style="margin-left:-35px;" value="<?php echo $jumlah_shift;?>" placeholder="Input Jumlah Shift" name="txtJumlahShift" id="txtJumlahShift" class="form-control jumlahShift" />
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label for="norm" class="control-label col-lg-6">Jumlah Hari Kerja (Hari) :</label>
                          <div class="col-lg-6">
                            <input type="number" style="margin-left:-35px;" value="<?php echo $jumlah_hari_kerja;?>" placeholder="Input Jumlah Hari Kerja" name="txtJumlahHariKerja" id="txtJumlahHariKerja" class="form-control jumlahHariKerja" />
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="row">
                          <label for="norm" class="control-label col-lg-6">Forecast (Unit) : </label>
                          <div class="col-lg-6">
                            <input type="number" placeholder="Forecast" value="<?php echo $forecast;?>" name="txtForecast" id="txtForecast" class="form-control forecast" oninput="countRencanaProduksi(this)" />
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label for="norm" class="control-label col-lg-6">Qty / Unit: </label>
                          <div class="col-lg-6">
                            <input type="number" placeholder="Qty / Unit" value="<?php echo $qty_unit;?>" name="txtQtyUnit" id="txtQtyUnit" class="form-control qtyUnit" oninput="countRencanaProduksi(this)" />
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label for="norm" class="control-label col-lg-6">Rencana Produksi/Forecast (Pcs) : </label>
                          <div class="col-lg-6">
                            <input type="number" value="<?php echo $rencana_produksi;?>" placeholder="Input Rencana Produksi" name="txtRencana" id="txtRencana" readonly class="form-control rencanaKerja" />
                          </div>
                        </div>

                      </div>
                      <br><br>
                      <!-- <div class="col-lg-12" style="padding-top: 8px;">
										<br>
											<div style="text-align:center;">
												<button type="button" onclick="countTaktTime(this)" style="float: center; margin-right: 3%; margin-top: -0.5%;" class="btn btn-primary btn-md" id="btnSaveObservation"><i class="fa fa-calculator "></i>  HITUNG TAKT TIME</button>
											</div>
										</div> -->
                    </div>
                  </div>
                  <div class="row">
                    <label for="norm" class="control-label col-lg-4"></label>
                  </div>
                  <br>
                    <div class="row">
                      <div class="col-lg-12">
                        <?php if ($dst != null) {
													$nDistribusi = array_sum($dst);
													$wktDistribusi = null;
												}else{
													$nDistribusi = null;
												}
												?>
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <label for="norm" class="tskk_tt" style="<?php echo $takt_time == '99999' ? 'display:none;' : ''?>margin-left:1%;">Takt Time : </label>
                            <input type="number" style="<?php echo $takt_time == '99999' ? 'display:none;' : ''?>width:13%; height:34px;  margin-left:2%; text-align:center;" value="<?php echo $takt_time; ?>" placeholder="Input Takt Time"
                              name="taktTime" id="inputInsert" class="lockscreen-credentials taktTime" />
                            <label for="norm" style="margin-left:3% ;">Nilai Distribusi : </label>
                            <input type="number" style="width:13%; height:34px;  margin-left:3%; text-align:center" name="inputInsert" id="dst" value="<?php echo $nDistribusi ?>" class="lockscreen-credentials" readonly />
                            <label for="norm" style="margin-left:2%;">Posisi Elemen Tambahan : </label>
                            <input type="number" style="width:20%; height:34px;  margin-left:2%; margin-right:2%;" placeholder="Input Posisi untuk Menyisipkan Elemen" name="inputInsert" id="inputInsertPosiition" class="lockscreen-credentials" />
                            <button type="button" class=" btn btn-primary btn-md" style="height:34px;float:right" onclick="attachRowObservation(this)" id="btnInsert">Add</button>
                          </div>
                          <div class="panel-body">
                            <div class="table-responsive" id="tableGenerate">
                              <!-- <div class="zui-scroller"> -->
                              <table class="table table-striped table-bordered table-hover text-center tblObservasiEdit" style="width:2300px; padding-bottom: 0;" name="tblObservasi" id="tblObservasiEdit">
                                <thead>
                                  <tr class="bg-primary">
                                    <th rowspan="2" style="width: 50px;  text-align:center;">NO</th>
                                    <th rowspan="2" style="width: 50px;   text-align:center;">PARALEL</th>
                                    <th style="text-align:center;" colspan="2">FOLLOW</th>
                                    <th rowspan="2" style="width: 200px;  text-align:center;">JENIS PROSES</th>
                                    <th rowspan="2" style="width: 400px;  text-align:center;">ELEMEN KERJA</th>
                                    <th rowspan="2" style="width: 100px;  text-align:center;">1</th>
                                    <th rowspan="2" style="width: 100px;  text-align:center;">2</th>
                                    <th rowspan="2" style="width: 100px;  text-align:center;">3</th>
                                    <th rowspan="2" style="width: 100px;  text-align:center;">4</th>
                                    <th rowspan="2" style="width: 100px;  text-align:center;">5</th>
                                    <th rowspan="2" style="width: 100px;  text-align:center;">6</th>
                                    <th rowspan="2" style="width: 100px;  text-align:center;">7</th>
                                    <th rowspan="2" style="width: 100px;  text-align:center;">8</th>
                                    <th rowspan="2" style="width: 100px;  text-align:center;">9</th>
                                    <th rowspan="2" style="width: 100px;  text-align:center;">10</th>
                                    <th rowspan="2" style="width: 100px;  text-align:center;">X MIN</th>
                                    <th rowspan="2" style="width: 100px;  text-align:center;">R</th>
                                    <th rowspan="2" style="width: 100px;  text-align:center;">WAKTU DISTRIBUSI <i class="fa fa-copy fa-md" onclick="copyAutoWaktuDistribusi(this)" style="color:red" id="copy" title="Copy Waktu Distribusi"></i></th>
                                    <th rowspan="2" style="width: 100px;  text-align:center;">AUTO WAKTU DISTRIBUSI</th>
                                    <th rowspan="2" style="width: 100px;  text-align:center;">WAKTU KERJA</th>
                                    <th rowspan="2" style="width: 150px;  text-align:center;">KETERANGAN</th>
                                    <th rowspan="2" style="width: 50px;  text-align:center;">HAPUS</th>
                                  </tr>
                                  <tr class="bg-primary">
                                    <th>START</th>
                                    <th>END</th>
                                  </tr>
                                </thead>
                                <tbody id="tbodyLembarObservasiEdit">
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
																			if ($dst != null) {
																				$nDistribusi = array_sum($dst);
																				$wktDistribusi = null;
																				$waktu = $x_min;
																				// echo $nDistribusi;
																				// exit();
																			}else{
																				$nDistribusi = null;
																			}
																	?>
                                  <tr class="nomor_" .$no>
                                    <!--NO-->
                                    <td class="posisi"><?php echo $no; ?></td>
                                    <!--TIPE URUTAN-->
                                    <td style="text-align: center;">
                                      <input type="checkbox" <?php if ($tipe_urutan == 'PARALEL') { echo 'checked'; }?> name="checkBoxParalel[<?php echo $no-1;?>]" value="PARALEL" class="checkBoxParalel" id="checkBoxParalel"
                                        onchange="//chckParalel(this)">
                                      <!-- <input type="text" id="YesOrNo" class="YesOrNo" name="chckTipeUrutan[]"> -->
                                    </td>
                                    <!-- FOLLOW START END -->
                                    <td>
                                      <input type="number" class="form-control" style="width: 70px;" name="start_time_together[]" value="<?php echo $key['start_together'] ?>">
                                    </td>
                                    <td>
                                      <input type="number" class="form-control" style="width: 70px;" name="end_time_together[]" value="<?php echo $key['end_together'] ?>">
                                    </td>
                                    <!--JENIS PROSES-->
                                    <td>
                                      <select class="form-control select4" onchange="myFunctionTSKK(this)" style="text-align:left" data-placeholder="Jenis Proses" name="slcJenisProses[]" id="slcJenis">
                                        <?php
                                                                                echo '<option value="'.$jenis_proses.'" selected>'.$jenis_proses.'</option>';
                                                                            ?>
                                        <option value="MANUAL">MANUAL</option>
                                        <option value="AUTO">AUTO</option>
                                        <!-- <option value="AUTO (Inheritance)">AUTO (Inheritance)</option> -->
                                        <option value="WALK">WALK</option>
                                        <!-- <option value="WALK (Inheritance)">WALK (Inheritance)</option> -->
                                      </select>
                                    </td>
                                    <!--ELEMEN KERJA-->
                                    <td>
                                      <div class="col-lg-12">
                                        <div class="col-lg-6">
                                          <select class="form-control select2 slcElemen" id="slcElemen" name="txtSlcElemen[]" data-placeholder="Elemen">
                                            <?php
																				if ($elemen != null) {
																					echo '<option value="'.$elemen.'" selected>'.$elemen.'</option>';
																				}
                                                                            ?>
                                          </select>
                                        </div>
                                        <div class="col-lg-6">
                                          <input type="text" value="<?php echo $keterangan_elemen; ?>" id="elemen" name="elemen[]" class="form-control elemen" placeholder="Keterangan Elemen">
                                        </div>
                                      </div>
                                    </td>
                                    <!--1-->
                                    <td><input type="number" value="<?php echo $waktu_1; ?>" onchange="minMaxId(this)" name="waktu1[]" class="form-control waktuObs inputWaktuKolom1" placeholder="Detik"></td>
                                    <!--2-->
                                    <td><input type="number" value="<?php echo $waktu_2; ?>" onchange="minMaxId(this)" name="waktu2[]" class="form-control waktuObs inputWaktuKolom2" placeholder="Detik"></td>
                                    <!--3-->
                                    <td><input type="number" value="<?php echo $waktu_3; ?>" onchange="minMaxId(this)" name="waktu3[]" class="form-control waktuObs inputWaktuKolom3" placeholder="Detik"></td>
                                    <!--4-->
                                    <td><input type="number" value="<?php echo $waktu_4; ?>" onchange="minMaxId(this)" name="waktu4[]" class="form-control waktuObs inputWaktuKolom4" placeholder="Detik"></td>
                                    <!--5-->
                                    <td><input type="number" value="<?php echo $waktu_5; ?>" onchange="minMaxId(this)" name="waktu5[]" class="form-control waktuObs inputWaktuKolom5" placeholder="Detik"></td>
                                    <!--6-->
                                    <td><input type="number" value="<?php echo $waktu_6; ?>" onchange="minMaxId(this)" name="waktu6[]" class="form-control waktuObs inputWaktuKolom6" placeholder="Detik"></td>
                                    <!--7-->
                                    <td><input type="number" value="<?php echo $waktu_7; ?>" onchange="minMaxId(this)" name="waktu7[]" class="form-control waktuObs inputWaktuKolom7" placeholder="Detik"></td>
                                    <!--8-->
                                    <td><input type="number" value="<?php echo $waktu_8; ?>" onchange="minMaxId(this)" name="waktu8[]" class="form-control waktuObs inputWaktuKolom8" placeholder="Detik"></td>
                                    <!--9-->
                                    <td><input type="number" value="<?php echo $waktu_9; ?>" onchange="minMaxId(this)" name="waktu9[]" class="form-control waktuObs inputWaktuKolom9" placeholder="Detik"></td>
                                    <!--10-->
                                    <td><input type="number" value="<?php echo $waktu_10; ?>" onchange="minMaxId(this)" name="waktu10[]" class="form-control waktuObs inputWaktuKolom10" placeholder="Detik"></td>
                                    <!--X MIN-->
                                    <td><input type="number" value="<?php echo $x_min; ?>" id="xmin" name="xmin[]" class="form-control xmin" placeholder="Detik" readonly></td>
                                    <!--R-->
                                    <td><input type="number" value="<?php echo $range; ?>" id="range" name="range[]" class="form-control range" placeholder="Detik" readonly></td>
                                    <!--W DISTRIBUSI-->
                                    <!--<td><input type="number" value="<?php echo $wktDistribusi ?>" onchange="minMaxId(this)" id="wDistribusi" name="wDistribusi[]" class="form-control wDistribusi" placeholder="Detik"></td>-->
                                    <!--W DISTRIBUSI-->
                                    <td><input type="number" value="<?php echo $wktDistribusi ?>" onchange="minMaxId(this)" onclick="checkDistributionTime(this)" id="wDistribusi" name="wDistribusi[]" class="form-control wDistribusi"
                                        placeholder="Detik"></td>
                                    <!--W DISTRIBUSI AUTO-->
                                    <td><input type="number" onchange="minMaxId(this)" onclick="checkDistributionTime(this)" id="wDistribusiAuto" name="wDistribusiAuto[]" class="form-control wDistribusiAuto" placeholder="Detik" readonly></td>
                                    <!--W KERJA-->
                                    <td><input type="number" value="<?php echo $waktu; ?>" id="wKerja" name="wKerja[]" class="form-control wKerja" placeholder="Detik" readonly></td>
                                    <!--KETERANGAN-->
                                    <td><input type="text" id="keterangan" value="<?php echo $keterangan; ?>" name="keterangan[]" class="form-control keterangan" placeholder="Input Keterangan"></td>
                                    <!--HAPUS-->
                                    <td>
                                      <i class="fa fa-times fa-2x" onclick="deleteObserve(this)" style="color:red" id="hapus" title="Hapus Elemen"></i>
                                    </td>
                                  </tr>
                                  <?php $no++; }  } ?>
                                </tbody>
                              </table>
                            </div>
                            <br><br>
                          </div>
  </div>
    <div class="panel panel-default">
      <div class="panel-heading text-left">
        <label style="margin-left: 2%;">Input Irregular Job</label>
        <label style="margin-left: 70%; <?php if (!empty($lihat_irregular_jobs)) { echo "display:none";}?>">Add Irregular Job</label>
        <a class="fa fa-plus fa-2x fa-primary" style="margin-left:1%; <?php if (!empty($lihat_irregular_jobs)) { echo "display:none"; }?>" onclick="addRowIrregularJob($(this))" title="Tambah Irregular Job"></a>
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
              <th width="10%" class="text-center">ACTION</th>
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
              <td style="text-align: center;"> <input type="text" value="<?php echo $irregular_job;?>" class="form-control irregularJob" name="txtIrregularJob[]" id="irregularJob"></td>
              <td style="text-align: center;"> <input type="number" value="<?php echo $ratio_irregular;?>" onchange="countIrregularJobs(this)" style="text-align: center;" class="form-control ratio" name="txtRatioIrregular[]"
                  id="ratio"></td>
              <td style="text-align: center;"> <input type="number" value="<?php echo $waktu_irregular;?>" onchange="countIrregularJobs(this)" style="text-align: center;" class="form-control waktu" name="txtWaktuIrregular[]"
                  id="waktu"></td>
              <td style="text-align: center;" class="hasilIrregularJob" id="hasilIrregularJob"><input type="text" value="<?php echo $hasil_irregular_job;?>" style="text-align: center;" class="form-control hasilIrregularJob"
                  name="txtHasilWaktuIrregular[]" readonly></td>
              <td style="text-align: center;">
                <i class="fa fa-times fa-2x deleteIrregularJob" id="deleteIrregularJob" onclick="deleteIrregularJobs(this)" style="color:red" title="Hapus Irregular Job"></i>&nbsp;&nbsp;
                <a class="fa fa-plus fa-2x fa-primary" onclick="addRowIrregularJob($(this))" title="Tambah Irregular Job"></a>
              </td>
            </tr>
            <?php $no++; } ?>
          </tbody>
        </table>
      </div>
    </div>

  <br>
  <div class="col-lg-12" style="padding-top: 8px;">
    <div style="text-align: center;">
      <button type="submit" style="float: center; margin-right: 3%; margin-top: -0.5%; display: none" class="btn btn-primary" id="btnHidden"><i class="fa fa-floppy-o"></i> SIMPAN LEMBAR OBSERVASI</button>
      <button type="button" onclick="checkNilaiDistribusiObservasi(this)" style="float: center; margin-left: 3%; margin-right: 5%; margin-top: -0.5%;" class="btn btn-primary" id="btnShow"><i class="fa fa-floppy-o"></i>
        SIMPAN LEMBAR OBSERVASI</button>
      <!-- <a style="float: center; margin-right: 4%; margin-top: -0.5%;" class="btn btn-success" id="btnExportOBS" href="<?=base_url('GeneratorTSKK/C_Observation/exportObservation/'.$id)?>"><i class="fa fa-download"></i> EXPORT OBSERVATION</a>
<button type="button" style="float: center; margin-right: 3%; margin-top: -0.5%;" class="btn btn-warning" data-toggle="modal" data-target="#Modalku<?php echo $id; ?>" id="btnImportOBS"><i class="fa fa-upload"></i> IMPORT OBSERVATION</button>										 -->
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
  </div>

  <button type="button" onclick="addRowObservationEdit($(this))" id="myBtn" class="fa fa-plus fa-lg"
    style="display: none;  position: fixed;  bottom: 45px;  right: 30px;  z-index: 99;  font-size: 30px  text-center;  border: none; outline: none; background-color: green; color: white; cursor: pointer; width:35px; height:35px; border-radius: 50%;"
    title="Tambah Elemen"></button>

  <script>
    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {
      scrollFunction()
    };

    function scrollFunction() {
      if (document.body.scrollTop > 250 || document.documentElement.scrollTop > 250) {
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
