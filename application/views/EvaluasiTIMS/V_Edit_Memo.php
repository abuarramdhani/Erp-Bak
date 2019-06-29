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
                                <form action="<?php echo site_url('EvaluasiTIMS/Setup/saveEditMemo');?>" method="post" id="evt_form_memo">
                                    <div class="panel-body">
                                       <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="no_surat">Nomor Surat :</label>
                                                <input name="evt_no_surat" required="" type="text" class="form-control" id="evt_no_surat" value="<?php echo $memo[0]['nomor_surat']; ?>">
                                                <input name="evt_id" hidden="" value="<?php echo $memo[0]['id']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="no_surat">Pilih :</label>
                                                <select name="evt_pilih" required="" type="text" class="form-control" id="evt_pilih">
                                                    <option <?php if ($memo[0]['pilih'] == '1') {
                                                        echo "selected";
                                                    } ?> id="1" value="1">Departemen</option>
                                                    <option <?php if ($memo[0]['pilih'] == '2') {
                                                        echo "selected";
                                                    } ?> id="2" value="2">Bidang</option>
                                                    <option <?php if ($memo[0]['pilih'] == '3') {
                                                        echo "selected";
                                                    } ?> id="3" value="3">Unit</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="no_surat" id="evt_lbl_pilih">Pilih :</label>
                                                <select name="evt_departemen" required="" type="text" class="form-control" id="evt_departemen">
                                                    <option value="<?php echo $memo[0]['bagian']; ?>" selected=""><?php echo $memo[0]['bagian']; ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="no_surat">Lampiran (angka):</label>
                                                <input name="evt_lampiran_angka" type="number" class="form-control" id="evt_lampiran_angka" value="<?php echo $memo[0]['lampiran']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="no_surat">Lampiran (satuan):</label>
                                                <input name="evt_lampiran_satuan" type="text" class="form-control" id="evt_lampiran_satuan" value="<?php echo $memo[0]['lampiran_satuan']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="no_surat">People Development :</label>
                                                <select name="evt_pdev" type="text" class="form-control" id="evt_pdev">
                                                    <option selected value="<?php echo $memo[0]['kasie_pdev']; ?>">
                                                        <?php echo $memo[0]['kasie_pdev']; ?> - <?php echo $memo[0]['nama']; ?>
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="no_surat">Kepada :</label>
                                                <input name="evt_kepada" required="" readonly="" type="text" class="form-control" id="evt_kepada" value="<?php echo $memo[0]['kepada']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="no_surat">Isi :</label>
                                                <textarea name="evt_isi" required="" id="evt_isi">
                                                    <?php echo $memo[0]['isi']; ?>
                                                </textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="no_surat">Alasan :</label>
                                                <textarea name="evt_alasan" required="" id="evt_alasan">
                                                    <?php echo $memo[0]['alasan']; ?>
                                                </textarea>
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
                                                <textarea name="evt_result" required="" id="evt_result">
                                                    <?php echo $memo[0]['memo']; ?>
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-right">
                                    <button type="submit" class="btn btn-success btn-lg">Simpan</button>
                                    <button type="button" class="btn btn-danger btn-lg evt_btn_view">Lihat</button>
                                    <!-- <button type="button" class="btn btn-warning btn-lg evt_btn_reset">Reset</button> -->
                                </div>
                                <div class="evt_pdf">
                                    <div class="evt_pdf2">
                                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                                    <object class="evt_pdff" onload="form_base64_decode_preview(this)" onplay="this.onload()" onloadedmetadata="this.onload()" type="application/pdf" internalinstanceid="8"></object>
                                    </div>
                                </div>
                            </form>
                            <form target="_blank" method="post" action="<?php echo site_url('EvaluasiTIMS/Setup/testPreview');?>">
                                <input hidden="" name="data" id="evt_inp_hidden">
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