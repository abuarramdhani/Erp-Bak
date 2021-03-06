<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>Edit Memo</b></h1>
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
                                                    <option <?php if ($memo[0]['pilih'] == '4') {
                                                        echo "selected";
                                                    } ?> id="4" value="4">Seksi</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="no_surat" id="evt_lbl_pilih">Pilih :</label>
                                                <select multiple="multiple" name="evt_departemen[]" required="" type="text" class="form-control" id="evt_departemen">
                                                <?php   $x = explode(',', $memo[0]['bagian']);
                                                        $y = explode(',', $memo[0]['potongan_kodesie']);
                                                 ?>
                                                <?php for ($i=0; $i < count($x); $i++) { ?>
                                                    <option selected="" value="<?php echo $x[$i].' | '.$y[$i]; ?>"><?php echo $x[$i]; ?></option>
                                                <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="no_surat">Lampiran (angka):</label>
                                                <select name="evt_lampiran_angka" type="number" class="form-control" id="evt_lampiran_angka">
                                                    <option id="evt_-" value="-">-</option>
                                                    <option id="evt_1" value="1">1</option>
                                                    <option id="evt_2" value="2">2</option>
                                                    <option id="evt_3" value="3">3</option>
                                                    <option id="evt_4" value="4">4</option>
                                                    <option id="evt_5" value="5">5</option>
                                                    <option id="evt_6" value="6">6</option>
                                                    <option id="evt_7" value="7">7</option>
                                                    <option id="evt_8" value="8">8</option>
                                                    <option id="evt_9" value="9">9</option>
                                                    <option id="evt_10" value="10">10</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="no_surat">Lampiran (satuan):</label>
                                                <input name="evt_lampiran_satuan" type="text" class="form-control" id="evt_lampiran_satuan" readonly="" value="<?php echo $memo[0]['lampiran_satuan']; ?>">
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
                                                <select name="evt_kepada" required="" readonly="" type="text" class="form-control" id="evt_kepada">
                                                <option selected="" value="<?php echo $memo[0]['kepada']; ?>"><?php echo $memo[0]['kepada']; ?></option>
                                                <?php foreach ($namaKadept as $key): ?>
                                                        <option value="<?php echo $key['nama']; ?>"><?php echo $key['nama'] ?></option>
                                                    <?php endforeach ?>
                                                </select>
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
<script>
    $(document).ready(function(){
        var isi = '<?php echo $memo[0]['lampiran']; ?>';
        $('#evt_'+isi).attr('selected', true);
        // var cobba = .select2();
        // $('#evt_departemen').val(["Keuangan | 1", "Personalia | 4"]).trigger("change");
    });
</script>