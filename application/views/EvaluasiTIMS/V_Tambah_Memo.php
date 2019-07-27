<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/redactor-line-control/editor.css');?>">
<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>Create Memo</b></h1>
                    </div>
                </div>
                <div class="col-lg-1">
                    <div class="text-right hidden-md hidden-sm hidden-xs">

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11"></div>
                        <div class="col-lg-1 "></div>
                    </div>
                </div>
                <br />
                <div class="">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                            </div>
                            <div class="box-body">
                                <form action="<?php echo site_url('EvaluasiTIMS/Setup/saveMemo');?>" method="post" id="evt_form_memo">
                                    <div class="panel-body">
                                     <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="no_surat">Nomor Surat :</label>
                                                <input name="evt_no_surat" required="" type="text" class="form-control" id="evt_no_surat">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="no_surat">Pilih :</label>
                                                <select name="evt_pilih" required="" type="text" class="form-control" id="evt_pilih">
                                                    <option value="" disabled selected>Select your option</option>
                                                    <option id="1" value="1">Departemen</option>
                                                    <option id="2" value="2">Bidang</option>
                                                    <option id="3" value="3">Unit</option>
                                                    <option id="4" value="4">Seksi</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="no_surat" id="evt_lbl_pilih">Pilih :</label>
                                                <select multiple="multiple" disabled="" name="evt_departemen[]" required="" type="text" class="form-control" id="evt_departemen">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="no_surat">Lampiran (angka):</label>
                                                <select name="evt_lampiran_angka" type="number" class="form-control" id="evt_lampiran_angka">
                                                    <option disabled="" selected="">Pilih Salah Satu</option>
                                                    <option value="-">-</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="no_surat">Lampiran (satuan):</label>
                                                <input name="evt_lampiran_satuan" type="text" class="form-control" id="evt_lampiran_satuan" readonly="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="no_surat">People Development :</label>
                                                <select name="evt_pdev" type="text" class="form-control" id="evt_pdev">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="no_surat">Kepada :</label>
                                                <select name="evt_kepada" required="" type="text" class="form-control" id="evt_kepada">
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="no_surat">Isi :</label>
                                                <textarea name="evt_isi" required="" id="evt_isi"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="no_surat">Alasan :</label>
                                                <textarea name="evt_alasan" required="" id="evt_alasan"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-center">
                                            <button type="button" class="btn btn-primary" id="evt_preview">
                                                Preview
                                            </button>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="no_surat">Result :</label>
                                                <textarea name="evt_result" required="" id="evt_result"></textarea>
                                            </div>
                                        </div>
                                       <!--  <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="no_surat">Result :</label>
                                                <textarea class="editor" name="editor1"></textarea>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="panel-footer text-right">
                                    <button type="submit" class="btn btn-success btn-lg">Simpan</button>
                                    <button type="button" class="btn btn-danger btn-lg evt_btn_view">Lihat</button>
                                    <!-- <button type="button" class="btn btn-warning btn-lg evt_btn_reset">Reset</button> -->
                                </div>
                            </form>
                            <form target="_blank" method="post" action="<?php echo site_url('EvaluasiTIMS/Setup/testPreview');?>">
                                <input hidden="" name="data" id="evt_inp_hidden">
                                <input hidden="" name="no" id="evt_hidden_no_surat">
                                <button type="submit" hidden="" class="evt_btn_hidden"></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div hidden id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
</section>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/redactor-line-control/editor.js');?>"></script>
<!--     <script>
        $(document).ready(function() {
                // $("#evt-txtEditor").Editor();
               CKEDITOR.replace("editor1");
            });
        </script>
        <script>
            CKEDITOR.disableAutoInline = true;
            CKEDITOR.inline('editor<?php echo $sub_category['id'] ?>');
        </script> -->