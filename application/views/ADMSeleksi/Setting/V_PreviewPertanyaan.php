<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1><b>Setup Pertanyaan</b></h1>
                            </div>
                        </div>
                        <div class="col-lg-1"></div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-md-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">
                                    <b>Preview Pertanyaan</b>
                                </div>
                                <div class="box-body">
                                    <div class="box-body">
                                        <div class="col-md-12">
                                            <input type="hidden" name="id_pertanyaan" value="<?= $data[0]['id_pertanyaan'] ?>">
                                            <div class="form-group">
                                                <label class="control-label col-lg-2">Question</label>
                                                <div class="col-lg-6">
                                                    <?php if ($data[0]['pertanyaan']) { ?>
                                                        <textarea name="pertanyaan" class="form-control" cols="80" rows="5" style="resize:none;text-align: left;width: 100%;height: 20%;"><?= $data[0]['pertanyaan'] ?></textarea>
                                                    <?php } else { ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-lg-2"></div>
                                                <div class="col-lg-6" id="col_file_question">
                                                    <?php if ($data[0]['file_pertanyaan'] != NULL) { 
                                                        foreach ($data[0]['file_pertanyaan'] as $key => $fileval) { 
                                                    ?> 
                                                        <img id="source" src="<?= base_url($fileval['doc_path']) ?>" style="width:100%;height:200px;display:block;margin-bottom:10px;">
                                                    <?php } } else { ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $no = 1; $char = 'A'; foreach ($data[0]['jawaban'] as $key2 => $jwb) {
                                            if ($no == 1) {
                                                $label = "<label class='control-label col-lg-2'>Answer</label>";
                                            } else {
                                                $label = "<label class='control-label col-lg-2'></label>";
                                            }

                                            if ($data[0]['tipe_pilihan'] == 'ANGKA'){
                                                $pilihan = $no;
                                            } else if ($data[0]['tipe_pilihan'] == 'HURUF'){
                                                $pilihan = $char;
                                            } else {
                                                $pilihan = "";
                                            }
                                        ?>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <?= $label; ?>
                                                <div class="col-lg-6">
                                                    <div class="input-group" style="margin-bottom:5px;">
                                                        <?php if ($jwb['jawaban'] != NULL) { ?>
                                                        <span class="input-group-addon">
                                                            <input type="radio" value="1" id="answer<?= $no; ?>" name="status[]"> &raquo; 
                                                            <font ><?= $pilihan?></font>
                                                            <input type="hidden" name="answer_val[]" id="radio<?= $no; ?>" value="">
                                                            <input type="hidden" name="id_jawaban[]" value="<?= $jwb['id_jawaban']?>">
                                                        </span>
                                                            <input type="text" onfocus="this.select()" id="answer_<?= $no; ?>" name="jawaban[]" value="<?= $jwb['jawaban']?>" autocomplete="off" class="form-control">
                                                        <?php } else { ?>
                                                            <input type="radio" value="1" id="answer<?= $no; ?>" name="status[]"> &raquo; 
                                                            <font ><?= $pilihan?></font>
                                                            <input type="hidden" name="answer_val[]" id="radio<?= $no; ?>" value="">
                                                            <input type="hidden" name="id_jawaban[]" value="<?= $jwb['id_jawaban']?>">
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-lg-2"></div>
                                                <div class="col-lg-6">
                                                <?php if ($jwb['doc_path'] != NULL) { ?>
                                                    <span><label style="float:left;" class="control-label">File Answer <?= $pilihan?></label>
                                                    <img id="source_ans<?php echo $no ?>" src="<?= base_url($jwb['doc_path']) ?>" style="width:100%;height:200px;display:block;margin-bottom:10px;">
                                                <?php } else { ?>
                                                <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $no++; $char++; } ?>
                                    <div class="form-group">
                                        <div class="col-md-12 text-right">
                                            <a href="<?php echo site_url('ADMSeleksi/Setting/SetupPertanyaan');?>" class="btn btn-primary btn btn-flat">Back</a>
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