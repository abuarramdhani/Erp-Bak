<style type="text/css">
  #generate {
    border-radius: 25px;
  }

  #btnSaveObservation {
    border-radius: 25px;
    /* padding: 10px 15px;
	font-size: 16px; */
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

  #txtTanggal {
    border-radius: 25px;
  }

  tbody {
    overflow-y: auto;
    /* Trigger vertical scroll    */
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

  .table-responsive-custom{
    height:570px;
    overflow:scroll;
  }

  .tblObservasi thead tr th{
    position: sticky;
    background: #337ab7;
    top: 0;
    flex: 0 0 auto;
    z-index: 10;
  }

  .first-col-h {
    position: sticky;
    background: #dff0d8;
    z-index: 12 !important;
    width: 50px;
    min-width: 50px;
    max-width: 50px;
    left: 0px;
  }

  .first-col {
    position: sticky;
    background: #dff0d8;
    z-index: 8;
    left: 0px;
  }

  .second-col-h {
    position: sticky;
    background: #337ab7;
    z-index: 12 !important;
    left: 50px;
  }

  .second-col {
    background: #fff;
    position: sticky;
    z-index: 8;
    left: 50px;
  }

</style>

<section class="content">

  <datalist id="brow_jenis_proses">
    <option value=""></option>
    <option value="MANUAL">MANUAL</option>
    <option value="AUTO">AUTO</option>
    <!-- <option value="AUTO (Inheritance)">AUTO (Inheritance)</option> -->
    <option value="WALK">WALK</option>
  </datalist>

  <datalist id="brow_slc_elemen">
    <?php foreach ($data_element_kerja as $key => $value): ?>
      <option value="<?php echo $value['elemen_kerja'] ?>"><?php echo $value['elemen_kerja'] ?></option>
    <?php endforeach; ?>
  </datalist>
  <input type="hidden" id="untuk_keperluan_gtskk" name="" value="1">
  <input type="hidden" id="untuk_keperluan_gtskk_input_observasi" name="" value="1">
  <textarea hidden name="name" id="gtskk_proses_get_code" rows="8" cols="80"><?php echo json_encode($proses) ?></textarea>
  <!-- <datalist id="brow_slc_proses">
    <?php// foreach ($proses as $key => $value): ?>
      <option><?php //echo $value['PROSES'] ?></option>
    <?php //endforeach; ?>
  </datalist> -->

  <form id='Observasi' method="POST" action="<?php echo base_url('GeneratorTSKK/saveObservation/'); ?>">
    <div class="inner">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-12">
              <div class="text-center">
                <h1><b>LEMBAR OBSERVASI ELEMEN KERJA</b></h1>
              </div>
            </div>
          </div>
          <br />
          <div class="row">
            <div class="col-lg-12">
              <!-- <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-warning"></i> Info!</h4>
                  Aplikasi Terakhir Diperbarui Pada 2021-04-21 16:30:23. <b>Reload halaman ini</b> dengan menekan <b>CTRL+SHIFT+R</b> secara berurutan jika telah melewati tanggal pembaruan..
              </div> -->

              <div class="box box-primary box-solid">
                <div class="box-header with-border">
                  <?php
							//if (empty($lihat_observasi)) {
							//}else{
							//$no=1;
							//	foreach ($lihat_observasi as $key) {
							//		$id = $key['id_tskk'];

						?>
                  <?php //} } ?>
                  <!--Judul TSKK :-->
                  <label style="margin-left:4%;" for="norm">Judul: </label>
                  <input type="text" style="width:50%; height:34px;  margin-left:2%; text-align:center;" placeholder="Input Judul TSKK" name="txtTitle" id="judul" class="lockscreen-credentials judul" required />
                  <label for="norm" style="margin-left:5%; margin-right:-4%;">Tanggal Observasi:</label>
                  <input type="text" style="width:17%; height:34px; text-align:center;" placeholder="Input Tanggal" name="txtTanggal" id="txtTanggal" class="lockscreen-credentials txtTanggal" required  autocomplete="off" />
                </div>
                <div class="panel-body">
                  <div class="row">
                    <!--PART-->
                    <div class="col-lg-4">
                      <div class="col-lg-12 box box-primary box-solid" style="padding-right: 7px;padding-left: 7px; padding-top: 5px; padding-bottom: 15px; ">
                        <label for="norm" class="control-label" style="color:#428bca;font-size:18px;">PART</label>
                        <br />
                        <input type="radio" name="terdaftar" value="Terdaftar" checked> <label for="norm" class="control-label">&nbsp;&nbsp;Terdaftar </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="terdaftar" value="TidakTerdaftar"><label for="norm" class="control-label">&nbsp;&nbsp; Tidak Terdaftar </label>
                        <div class="row terdaftar">
                          <br />
                          <label for="norm" class="control-label col-lg-4">Type Product:</label>
                          <div class="col-lg-8">
                            <select style="height: 35px;" class="form-control type" id="typeProduct" name="txtType[]" data-placeholder="Input Product Type" tabindex="-1" aria-hidden="true" multiple>
                              <option value=""></option>
                              <?php foreach ($product as $key => $value): ?>
                                <option value="<?php echo $value['DESCRIPTION'] ?>"><?php echo $value['DESCRIPTION'] ?></option>
                              <?php endforeach; ?>
                            </select>
                            <!-- <input type="text" placeholder="Input Type" name="txtType" value="" id="typeProduct" class="form-control type" required/> -->
                          </div>
                        </div>
                        <div class="row tdkTerdaftar" style="display:none">
                          <br>
                          <label for="norm" class="control-label col-lg-4">Type Product:</label>
                          <div class="col-lg-8">
                            <!-- <select style="height: 35px;" class="form-control select2" id="typeProduct" name="txtType" data-placeholder="Input Product Type" tabindex="-1" aria-hidden="true">
											</select> -->
                            <input type="text" placeholder="Input Product Type" name="txtTypeT" id="typeProductH" class="form-control type" />
                          </div>
                        </div>
                        <br>
                        <div class="row terdaftar">
                          <label for="norm" class="control-label col-lg-4">Kode Part :</label>
                          <div class="col-lg-8">
                            <!-- <input type="text" data-placeholder="Input Kode Part" value="" id="kodepart" name="txtKodepart" class="form-control kodepart" /> -->
                            <select style="height: 35px;" class="form-control select2 kodepart" id="kodepart" name="txtKodepart[]" data-placeholder="Input Kode Part/ Nama Part" tabindex="-1" aria-hidden="true" multiple>
                            </select>
                          </div>
                        </div>
                        <div class="row tdkTerdaftar" style="display:none">
                          <label for="norm" class="control-label col-lg-4">Kode Part :</label>
                          <div class="col-lg-8">
                            <input type="text" placeholder="Input Kode Part" value="" id="kodepartT" name="txtKodepartT" class="form-control kodepart" />
                            <!-- <select style="height: 35px;" class="form-control select2" id="kodepart" name="txtKodepart[]" data-placeholder="Input Kode Part" tabindex="-1" aria-hidden="true" multiple> -->
                            </select>
                          </div>
                        </div>
                        <br>
                        <div class="row terdaftar">
                          <label for="norm" class="control-label col-lg-4">Nama Part :</label>
                          <div id="divPassCheck" class="col-lg-8">
                            <input type="text" style="height: 35px;" placeholder="Input Nama Part" name="txtNamaPart" value="" id="namaPart" class="form-control namaPart" readonly />
                            <!-- <textarea type="text" style="height: 35px;" placeholder="Input Resource" name="txtResource[]" value="" id="txtResource" class="form-control resource" required></textarea> -->
                          </div>
                        </div>
                        <div class="row tdkTerdaftar" style="display:none">
                          <label for="norm" class="control-label col-lg-4">Nama Part :</label>
                          <div id="divPassCheck" class="col-lg-8">
                            <input type="text" style="height: 35px;" placeholder="Input Nama Part" name="txtNamaPartT" value="" id="namaPartH" class="form-control namaPart" />
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
                          <input type="radio" name="equipmenTerdaftarMesin" value="Terdaftar" checked> <label for="norm" class="control-label">&nbsp;&nbsp;Terdaftar </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="equipmenTerdaftarMesin" value="TidakTerdaftar"><label for="norm" class="control-label">&nbsp;&nbsp; Tidak Terdaftar </label>
                          <div class="row equipmenTerdaftarMesin">
                            <br>
                            <label for="norm" class="control-label col-lg-4">No. Mesin :</label>
                            <div class="col-lg-8">
                              <select style="height: 35px;" class="form-control select2 noMesin" id="txtNoMesinTSKK" name="txtNoMesin[]" data-placeholder="Search By No / Jenis Mesin" multiple>
                              </select>
                              <!-- <input type="text" placeholder="Input Nomor Mesin" name="txtNoMesin" value="" id="txtNoMesin" class="form-control noMesin" required/> -->
                            </div>
                          </div>
                          <div class="row equipmenTdkTerdaftarMesin" style="display:none">
                            <br>
                            <label for="norm" class="control-label col-lg-4">No. Mesin :</label>
                            <div class="col-lg-8">
                              <input type="text" placeholder="Input No Mesin" name="txtNoMesinT" value="" class="form-control noMesin" />
                            </div>
                          </div>
                          <br>
                          <!-- <input hidden class="form-control getID" value="<?php echo $id ?>"> -->
                          <div class="row equipmenTerdaftarMesin">
                            <label for="norm" class="control-label col-lg-4">Jenis Mesin :</label>
                            <div class="col-lg-8">
                              <!-- <texarea type="text" placeholder="Input Jenis Mesin" value="" id="jenisMesin" name="txtJenisMesin" class="form-control jenisMesin"></textarea> -->
                              <textarea type="text" style="height: 35px;" placeholder="Input Jenis Mesin" name="txtJenisMesin[]" value="" id="jenisMesin" class="form-control jenisMesin"></textarea>
                              <!-- <select data-placeholder="Input Jenis Mesin" id="jenisMesin" name="txtJenisMesin" class="form-control select2 jenisMesin" multiple>
													</select> -->
                            </div>
                          </div>
                          <div class="row equipmenTdkTerdaftarMesin" style="display:none">
                            <label for="norm" class="control-label col-lg-4">Jenis Mesin :</label>
                            <div class="col-lg-8">
                              <textarea type="text" style="height: 35px;" placeholder="Input Jenis Mesin" name="txtJenisMesinT" value="" class="form-control jenisMesin"></textarea>
                            </div>
                          </div>
                          <br>
                          <div class="row equipmenTerdaftarMesin">
                            <label for="norm" class="control-label col-lg-4">Resource :</label>
                            <div id="divPassCheck" class="col-lg-8">
                              <textarea type="text" style="height: 35px;" placeholder="Input Resource" name="txtResource[]" value="" id="txtResource" class="form-control resource"></textarea>
                              <!-- <select style="height: 35px;" data-placeholder="Input Resource" name="txtResource" value="" id="txtResource" class="form-control select2 resource" multiple>
													</select> -->
                              <!-- <input type="text" style="height: 35px;" placeholder="Input Resource" name="txtResource" value="" id="txtResource" class="form-control resource"/> -->
                            </div>
                          </div>
                          <div class="row equipmenTdkTerdaftarMesin" style="display:none">
                            <label for="norm" class="control-label col-lg-4">Resource :</label>
                            <div class="col-lg-8">
                              <textarea type="text" style="height: 35px;" placeholder="Input Resource" name="txtResourceT" value="" class="form-control resource"></textarea>
                            </div>
                          </div>
                          <br>
                        </div>
                        <!--2-->
                        <div class="col-lg-6">
                          <input type="radio" name="equipmenTerdaftar" value="Terdaftar" checked> <label for="norm" class="control-label">&nbsp;&nbsp;Terdaftar </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="equipmenTerdaftar" value="TidakTerdaftar"><label for="norm" class="control-label">&nbsp;&nbsp; Tidak Terdaftar </label>
                          <div class="row equipmenTerdaftar">
                            <br />
                            <label for="norm" class="control-label col-lg-4">Alat Bantu :</label>
                            <div class="col-lg-8">
                              <select style="height: 35px;" class="form-control select2 txtAlatBantu" id="txtAlatBantu" name="txtAlatBantu[]" data-placeholder="Input Alat Bantu" tabindex="-1" aria-hidden="true" multiple>
                              </select>
                            </div>
                          </div>
                          <div class="row equipmenTdkTerdaftar" style="display:none">
                            <br>
                            <label for="norm" class="control-label col-lg-4">Alat Bantu :</label>
                            <div class="col-lg-8">
                              <input type="text" placeholder="Input Alat Bantu" name="txtAlatBantuT" value="" id="txtAlatBantuT" class="form-control txtAlatBantu" />
                            </div>
                          </div>
                          <br>
                          <div class="row equipmenTerdaftar">
                            <label for="norm" class="control-label col-lg-4">Tools:</label>
                            <div class="col-lg-8">
                              <select style="height: 35px;" class="form-control select2 tools" id="txtTools" name="txtTools[]" data-placeholder="Input Tools" tabindex="-1" aria-hidden="true" multiple>
                              </select>
                              <!-- <input type="text" placeholder="Input Tools" name="txtTools[]" value="" id="txtTools" class="form-control tools" /> -->
                            </div>
                          </div>
                          <div class="row equipmenTdkTerdaftar" style="display:none">
                            <label for="norm" class="control-label col-lg-4">Tools:</label>
                            <div class="col-lg-8">
                              <input type="text" placeholder="Input Tools" name="txtToolsT" value="" id="txtToolsH" class="form-control tools" />
                            </div>
                          </div>
                          <br>
                          <div class="row">
                            <label for="norm" class="control-label col-lg-4">Line :</label>
                            <div class="col-lg-8">
                              <input type="text" class="form-control line" id="line" name="txtLine" placeholder="Input Line" tabindex="-1" aria-hidden="true" required />
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
                            <select class="form-control select2" data-placeholder="Input Nama Operator" name="txtNama[]" value="" id="txtOperator" required multiple></select>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label for="norm" class="control-label col-lg-4">Jumlah Operator :</label>
                          <div class="col-lg-3">
                            <input type="text" placeholder="Input Jumlah Operator" name="txtJmlOperator" value="" id="txtJmlOperator" class="form-control jml_oprator" />
                          </div>
                          <label class="control-label col-lg-2 text-left">Dari:</label>
                          <div class="col-lg-3">
                            <input type="text" placeholder="Input" name="txtDariOperator" value="" id="txtDari" class="form-control txtDari" />
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label for="norm" class="control-label col-lg-4">Seksi :</label>
                          <div class="col-lg-8">
                            <select class="form-control select2" id="pilihseksi" name="txtSeksi" data-placeholder="Input Seksi" tabindex="-1" aria-hidden="true">
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
                              <!-- <input list="brow_slc_proses" autocomplete="off" type="text" style="height: 35px;" placeholder="Input Proses" name="txtProses" id="txtProcess" class="form-control process" required /> -->
                              <select class="gtskkmultipleproses" name="txtProses[]" id="txtProcess"  autocomplete="off" multiple required style="width:100%">
                                <?php foreach ($proses as $key => $value): ?>
                                  <option><?php echo $value['PROSES'] ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                          <br>
                          <div class="row">
                            <label for="norm" class="control-label col-lg-2">Kode Proses :</label>
                            <div id="divPassCheck" class="col-lg-10">
                              <input type="text" style="height: 35px;" autocomplete="off" placeholder="Input Kode Proses" name="txtKodeProses" id="txtKodeProses" class="form-control kodeproses" required />
                            </div>
                          </div>
                          <br>
                          <div class="row">
                            <label for="norm" class="control-label col-lg-2">Proses ke :</label>
                            <div class="col-lg-4">
                              <input type="text" placeholder="Input Proses ke" name="txtProsesKe" id="txtProsesKe" class="form-control proses_ke" required />
                            </div>
                            <label class="control-label col-lg-2 text-left">Dari :</label>
                            <div class="col-lg-4">
                              <input type="text" placeholder="Input" name="txtDariProses" id="txtDariProses" class="form-control txtDariProses" />
                            </div>
                          </div>
                          <br>
                          <!-- <input hidden class="form-control getID" value="<?php echo $id ?>"> -->
                          <div class="row">
                            <label for="norm" class="control-label col-lg-2">Qty/Proses :</label>
                            <div class="col-lg-10">
                              <input type="text" placeholder="Input Qty/Proses" id="qtyProses" name="txtQtyProses" class="form-control qty_proses" />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="panel panel-default">
                    <div class="panel-heading text-left">
                      <label style="margin-left: 2%;">Perhitungan Takt Time</label> &nbsp;&nbsp;&nbsp;&nbsp;
                      <input type="radio" name="perhitunganTakt" value="1" checked> <label for="" class="control-label">&nbsp;&nbsp;Ya </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <input type="radio" name="perhitunganTakt" value="0"><label for="norm" class="control-label">&nbsp;&nbsp; Tidak </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <input type="radio" name="perhitunganTakt" value="2"><label for="" class="control-label">&nbsp;&nbsp; Manual </label>
                    </div>
                    <div class="panel-body tskk_delik_cek_pakai">

                      <div class="col-lg-6">
                        <div class="row">
                          <label for="norm" class="control-label col-lg-6">Waktu 1 Shift (Detik) : </label>
                          <div class="col-lg-6">
                            <input type="number" style="margin-left:-35px;" placeholder="Input Waktu Satu Shift" value="0" oninput="countTaktTime(this)" name="txtWaktu1Shift" class="form-control waktu1Shift" />
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label for="norm" class="control-label col-lg-6">Jumlah Shift (Shift) :</label>
                          <div class="col-lg-6">
                            <input type="number" style="margin-left:-35px;" placeholder="Input Jumlah Shift" name="txtJumlahShift" id="txtJumlahShift" class="form-control jumlahShift" />
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label for="norm" class="control-label col-lg-6">Jumlah Hari Kerja (Hari) :</label>
                          <div class="col-lg-6">
                            <input type="number" placeholder="Input Jumlah Hari Kerja" style="margin-left:-35px;" name="txtJumlahHariKerja" id="txtJumlahHariKerja" class="form-control jumlahHariKerja" />
                          </div>
                        </div>
                        <!-- <br> -->
                      </div>
                      <div class="col-lg-6">
                        <div class="row">
                          <label for="norm" class="control-label col-lg-6">Forecast (Unit) : </label>
                          <div class="col-lg-6">
                            <input type="number" placeholder="Input Forecast" name="txtForecast" id="txtForecast" class="form-control forecast" oninput="countRencanaProduksi(this)" />
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label for="norm" class="control-label col-lg-6">Qty / Unit: </label>
                          <div class="col-lg-6">
                            <input type="number" placeholder="Input Qty / Unit" name="txtQtyUnit" id="txtQtyUnit" class="form-control qtyUnit" oninput="countRencanaProduksi(this)" />
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label for="norm" class="control-label col-lg-6">Rencana Produksi (Pcs) : </label>
                          <div class="col-lg-6">
                            <input type="number" placeholder="Rencana Produksi" name="txtRencanaProduksi" readonly id="txtRencanaProduksi" class="form-control rencanaKerja" />
                          </div>
                        </div>
                      </div>
                      <br><br>
                      <!-- <div class="col-lg-12" style="padding-top: 8px;">
										<br>
											<div style="text-align:center;">
												<button type="button" onclick="countTaktTime(this)" style="float: center; margin-right: 3%; margin-top: -0.5%;" class="btn btn-primary btn-md" id="btnSaveObservationTaktTime"><i class="fa fa-calculator "></i>  HITUNG TAKT TIME</button>
											</div>
										</div>	 -->
                    </div>
                    <div class="panel-body tskk_delik_cek_tidak_pakai" style="display:none">

                      <div class="col-lg-6">
                        <div class="row">
                          <label for="norm" class="control-label col-lg-6">Waktu 1 Shift (Detik) : </label>
                          <div class="col-lg-6">
                            <input type="number" style="margin-left:-35px;" placeholder="Input Waktu Satu Shift" oninput="countTaktTime(this)" name="txtWaktu1ShiftT" class="form-control waktu1Shift" value="0" />
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label for="norm" class="control-label col-lg-6">Jumlah Shift (Shift) :</label>
                          <div class="col-lg-6">
                            <input type="number" style="margin-left:-35px;" placeholder="Input Jumlah Shift" value="0" name="txtJumlahShiftT" class="form-control jumlahShift" />
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label for="norm" class="control-label col-lg-6">Jumlah Hari Kerja (Hari) :</label>
                          <div class="col-lg-6">
                            <input type="number" value="0" placeholder="Input Jumlah Hari Kerja" style="margin-left:-35px;" name="txtJumlahHariKerjaT" class="form-control jumlahHariKerja" />
                          </div>
                        </div>
                        <!-- <br> -->
                      </div>
                      <div class="col-lg-6">
                        <div class="row">
                          <label for="norm" class="control-label col-lg-6">Forecast (Unit) : </label>
                          <div class="col-lg-6">
                            <input type="number" value="0" placeholder="Input Forecast" name="txtForecastT"  class="form-control forecast" oninput="countRencanaProduksi(this)" />
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label for="norm" class="control-label col-lg-6">Qty / Unit: </label>
                          <div class="col-lg-6">
                            <input type="number" value="0" placeholder="Input Qty / Unit" name="txtQtyUnitT"  class="form-control qtyUnit" oninput="countRencanaProduksi(this)" />
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label for="norm" class="control-label col-lg-6">Rencana Produksi (Pcs) : </label>
                          <div class="col-lg-6">
                            <input type="number" value="0" placeholder="Rencana Produksi" name="txtRencanaProduksiT" readonly  class="form-control rencanaKerja" />
                          </div>
                        </div>
                      </div>
                      <br><br>
                      <!-- <div class="col-lg-12" style="padding-top: 8px;">
                    <br>
                      <div style="text-align:center;">
                        <button type="button" onclick="countTaktTime(this)" style="float: center; margin-right: 3%; margin-top: -0.5%;" class="btn btn-primary btn-md" id="btnSaveObservationTaktTime"><i class="fa fa-calculator "></i>  HITUNG TAKT TIME</button>
                      </div>
                    </div>	 -->
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-lg-12">

                      <div class="alert bg-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">
                            <i class="fa fa-close"></i>
                          </span>
                        </button>
                        <strong>Sekilas Info! </strong> Klik pada kolom <b>NO</b> Untuk Menambah Elemen</strong>
                      </div>

                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <label style="" class="tskk_tt" for="norm">Takt Time : </label>
                          <input type="number" style="width:15%; height:34px; margin-right:2%;  margin-left:3%;text-align:center" placeholder="Hasil Takt Time" name="taktTime" id="inputInsert" class="lockscreen-credentials" readonly />
                          <label for="norm">Nilai Distribusi : </label>
                          <input type="number" style="width:15%; height:34px; margin-right:1%;  margin-left:2%; text-align:center" name="inputInsert" id="dst" class="lockscreen-credentials dst" readonly />
                          <!-- <label for="norm" style="margin-left:1.5%;">Posisi Elemen Tambahan : </label>
                          <input type="number" style="width:17%; height:34px;  margin-left:2%; margin-right:2%;border-radius:25px;" placeholder="Input Posisi untuk Menyisipkan Elemen" name="inputInsert" id="inputInsertPosiition" class="lockscreen-credentials"  />
                          <button type="button" class=" btn btn-primary btn-md" style="height:34px;float:right" onclick="attachRowObservation_new(this)" id="btnInsert">Add</button> -->
                        </div>
                        <div class="panel-body">
                          <div class="table-responsive" id="tableGenerate">
                            <table class="table table-striped table-bordered table-hover text-center tblObservasi" style="width:2300px; padding-bottom: 0;" name="tblObservasi" id="tblObservasi">
                              <thead>
                                <tr class="bg-primary">
                                  <th style="width: 50px;  text-align:center;" class="first-col-h">NO</th>
                                  <th style="width: 50px;   text-align:center;">PARALEL</th>
                                  <th style="text-align:center;">FOLLOW START</th>
                                  <th style="text-align:center;">FOLLOW END</th>
                                  <th style="width: 200px;  text-align:center;">JENIS PROSES</th>
                                  <th style="width: 400px;  text-align:center;" class="second-col-h">ELEMEN KERJA</th>
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
                                  <th style="width: 100px;  text-align:center;">WAKTU DISTRIBUSI <i class="fa fa-copy fa-md" onclick="copyAutoWaktuDistribusi(this)" style="color:red" id="copy" title="Copy Waktu Distribusi"></i></th>
                                  <th style="width: 100px;  text-align:center;">AUTO WAKTU DISTRIBUSI</th>
                                  <th style="width: 100px;  text-align:center;">WAKTU KERJA</th>
                                  <th style="width: 150px;  text-align:center;">KETERANGAN</th>
                                  <th style="width: 50px;  text-align:center;">HAPUS</th>
                                </tr>
                              </thead>
                              <tbody id="tbodyLembarObservasi">
                                <?php
																			for ($no = 1; $no <=5;) {
																		?>
                                <tr class="nomor_<?= $no ?>">
                                  <!--NO-->
                                  <td class="posisi bg-success first-col" title="Klik Untuk Menambah Elemen Disini" onclick="attachRowObservation_new(this)"><?php echo $no; ?></td>
                                  <!--TIPE URUTAN-->
                                  <td style="text-align: center;">
                                    <input type="checkbox" style="width:19px;height:19px;" name="checkBoxParalel[<?php echo $no-1;?>]" value="PARALEL" class="checkBoxParalel" onclick="checkBoxParalel_(this)">
                                  </td>
                                  <!-- FOLLOW START END -->
                                  <td>
                                    <input type="number" class="form-control" style="width: 70px;" name="start_time_together[]" value="" readonly>
                                  </td>
                                  <td>
                                    <input type="number" class="form-control" style="width: 70px;" name="end_time_together[]" value="" readonly>
                                  </td>
                                  <!--JENIS PROSES-->
                                  <td>
                                    <input list="brow_jenis_proses" class="form-control select00004" onchange="myFunctionTSKK(this)" style="text-align:left;width:100%" data-placeholder="Jenis Proses" name="slcJenisProses[]" id="slcJenis_<?= $no ?>" required>
                                    <!-- <select class="form-control select4" onchange="myFunctionTSKK(this)" style="text-align:left;width:100%" data-placeholder="Jenis Proses" name="slcJenisProses[]" id="slcJenis_<?= $no ?>">
                                      <option value=""></option>
                                      <option value="MANUAL">MANUAL</option>
                                      <option value="AUTO">AUTO</option>
                                      <option value="WALK">WALK</option>
                                    </select> -->
                                  </td>
                                  <!--ELEMEN KERJA-->
                                  <td class="second-col">
                                    <div class="row">
                                      <div class="col-lg-6">
                                        <!-- <select class="form-control select2 slcElemen" onchange="//disableOrnot(this)" id="slcElemen" name="txtSlcElemen[]" data-placeholder="Elemen">
                                        </select> -->
                                        <input list="brow_slc_elemen" class="form-control slcElemen0000" onchange="//disableOrnot(this)" name="txtSlcElemen[]" data-placeholder="Elemen">
                                      </div>
                                      <div class="col-lg-6">
                                        <input type="text" name="elemen[]" class="form-control elemen" placeholder="Keterangan Elemen">
                                      </div>
                                    </div>
                                  </td>
                                  <!--1-->
                                  <td><input type="number" onchange="minMaxId(this)" name="waktu1[]" class="form-control waktuObs inputWaktuKolom1" placeholder="Detik"></td>
                                  <!--2-->
                                  <td><input type="number" onchange="minMaxId(this)" name="waktu2[]" class="form-control waktuObs inputWaktuKolom2" placeholder="Detik"></td>
                                  <!--3-->
                                  <td><input type="number" onchange="minMaxId(this)" name="waktu3[]" class="form-control waktuObs inputWaktuKolom3" placeholder="Detik"></td>
                                  <!--4-->
                                  <td><input type="number" onchange="minMaxId(this)" name="waktu4[]" class="form-control waktuObs inputWaktuKolom4" placeholder="Detik"></td>
                                  <!--5-->
                                  <td><input type="number" onchange="minMaxId(this)" name="waktu5[]" class="form-control waktuObs inputWaktuKolom5" placeholder="Detik"></td>
                                  <!--6-->
                                  <td><input type="number" onchange="minMaxId(this)" name="waktu6[]" class="form-control waktuObs inputWaktuKolom6" placeholder="Detik"></td>
                                  <!--7-->
                                  <td><input type="number" onchange="minMaxId(this)" name="waktu7[]" class="form-control waktuObs inputWaktuKolom7" placeholder="Detik"></td>
                                  <!--8-->
                                  <td><input type="number" onchange="minMaxId(this)" name="waktu8[]" class="form-control waktuObs inputWaktuKolom8" placeholder="Detik"></td>
                                  <!--9-->
                                  <td><input type="number" onchange="minMaxId(this)" name="waktu9[]" class="form-control waktuObs inputWaktuKolom9" placeholder="Detik"></td>
                                  <!--10-->
                                  <td><input type="number" onchange="minMaxId(this)" name="waktu10[]" class="form-control waktuObs inputWaktuKolom10" placeholder="Detik"></td>
                                  <!--X MIN-->
                                  <td><input type="number" name="xmin[]" class="form-control xmin" placeholder="Detik" readonly></td>
                                  <!--R-->
                                  <td><input type="number" name="range[]" class="form-control range" placeholder="Detik" readonly></td>
                                  <!--W DISTRIBUSI-->
                                  <td><input type="number" onchange="minMaxId(this)" onclick="checkDistributionTime(this)" name="wDistribusi[]" class="form-control wDistribusi" placeholder="Detik" readonly></td>
                                  <!--W DISTRIBUSI AUTO-->
                                  <td><input type="number" onchange="minMaxId(this)" onclick="checkDistributionTime(this)" name="wDistribusiAuto[]" class="form-control wDistribusiAuto" placeholder="Detik" readonly></td>
                                  <!--W KERJA-->
                                  <td><input type="number" name="wKerja[]" class="form-control wKerja" placeholder="Detik" readonly></td>
                                  <!--KETERANGAN-->
                                  <td><input type="text" name="keterangan[]" class="form-control keterangan" placeholder="Input Keterangan"></td>
                                  <!--HAPUS-->
                                  <td>
                                    <i class="fa fa-times fa-2x" onclick="deleteObserve(this)" style="color:red" id="hapus" title="Hapus Elemen"></i>
                                  </td>
                                </tr>
                                <?php
																		$no++; }
																		?>
                              </tbody>
                            </table>
                          </div>
                          <br>
                        </div>
                      </div>
                    </div>
  </div>
  <br>
  <div class="panel panel-default">
    <div class="panel-heading text-left">
      <label>Input Irregular Job</label>
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
          <tr class="nmbr_1">
            <td style="width: 5%; text-align:center;" class="position">1</td>
            <td style="text-align: center;"> <input type="text" required class="form-control irregularJob" name="txtIrregularJob[]" id="irregularJob" placeholder="Input Irregular Job"></td>
            <td style="text-align: center;"> <input type="number" required onchange="countIrregularJobs(this)" style="text-align: center;" class="form-control ratio" name="txtRatioIrregular[]" id="ratio" placeholder="Input Ratio"></td>
            <td style="text-align: center;"> <input type="number" required onchange="countIrregularJobs(this)" style="text-align: center;" class="form-control waktu" name="txtWaktuIrregular[]" id="waktu" placeholder="Input Waktu"></td>
            <td style="text-align: center;" class="hasilIrregularJob" id="hasilIrregularJob"><input type="text" style="text-align: center;" class="form-control hasilIrregularJob" name="txtHasilWaktuIrregular[]" placeholder="Hasil" readonly></td>
            <td style="text-align: center;">
              <i class="fa fa-times fa-2x deleteIrregularJob" id="deleteIrregularJob" onclick="deleteIrregularJobs(this)" style="color:red" title="Hapus Irregular Job"></i>&nbsp;&nbsp;
              <a class="fa fa-plus fa-2x fa-primary" onclick="addRowIrregularJob($(this))" title="Tambah Irregular Job"></a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <br>
   <div class="panel panel-default">
     <div class="panel-heading text-left">
       <label style="">Status Observasi</label>
     </div>
     <div class="panel-body">
       <select class="select2" name="status_observasi" style="width:100%" required>
         <option value="publish" selected>Siap Dicetak</option>
         <option value="draft">Belum Siap Cetak</option>
       </select>
     </div>
   </div>

  <div class="col-md-12" style="padding-top:8px">
    <div style="text-align:center;">
      <button type="submit" style="float: center; margin-right: 3%; margin-top: -0.5%;  display: none" class="btn btn-primary btn-md" id="btnSaveObservationHidden"><i class="fa fa-floppy-o "></i> SIMPAN LEMBAR OBSERVASI</button>
      <button type="button" onclick="checkNilaiDistribusiObservasi(this)" style="float: center; margin-right: 3%; margin-top: -0.5%;" class="btn btn-primary btn-md" id="btnSaveObservation"><i class="fa fa-floppy-o "></i> SIMPAN LEMBAR
        OBSERVASI</button>
    </div>
    <br>
  </div>
  </div>

</form>

  <button type="button" onclick="addRowObservation($(this))" id="myBtn" class="fa fa-plus fa-lg"
    style=" position: fixed;  bottom: 50px;  right: 45px;  z-index: 99;  font-size: 30px  text-center;  border: none; outline: none; background-color: green; color: white; cursor: pointer; width:35px; height:35px; border-radius: 50%;"
    title="Tambah Elemen">
  </button>


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
