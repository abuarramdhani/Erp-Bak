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
                                    <b>Edit Pertanyaan</b>
                                </div>
                                <div class="box-body">
                                    <form method="post" action="<?php echo base_url('ADMSeleksi/Setting/SetupPertanyaan/execute_edit_question')?>" enctype="multipart/form-data">
                                        <div class="box-body">
                                            <div class="col-md-12">
                                                <input type="hidden" name="id_pertanyaan" value="<?= $data[0]['id_pertanyaan'] ?>">
                                                <input type="hidden" name="id_tes" value="<?= $data[0]['id_tes'] ?>">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-2">Question</label>
                                                    <div class="col-lg-6">
                                                        <textarea name="pertanyaan" class="form-control" cols="80" rows="5" style="resize:none;text-align: left;width: 100%;height: 20%;"><?= $data[0]['pertanyaan'] ?></textarea>
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
                                                            <img id="source" src="<?= base_url($fileval['doc_path']) ?>" style="width:100%;height:200px;display:block;">
                                                            <img class="hide" src="#" id="target" style="width:100%;height:200px;display:block;" />
                                                            <input type="file" name="userfile" style="margin-top:5px;width:80%;" id="userfile" class="btn pull-left">
                                                            <a class="btn question-image-preview" data-src="">
                                                                <span class="fa fa-image"></span>
                                                            </a>
                                                            <input type="hidden" name="image_path" value="<?= $fileval['doc_path'] ?>" style="margin-top:5px;width:100%;" />
                                                            <input type="hidden" name="id_file" value="<?= $fileval['id'] ?>" style="margin-top:5px;width:100%;" />
                                                        <?php } } else { ?>
                                                            <input type="file" name="userfile" style="margin-top:5px;width:80%;" id="userfile" class="btn pull-left">
                                                            <a class="btn question-image-preview" data-src="">
                                                                <span class="fa fa-image"></span>
                                                            </a>
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

                                                if ($jwb['status_correct'] == 1) {
                                                    $select = "checked";
                                                } else {
                                                    $select = "";
                                                }
                                            ?>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <?= $label; ?>
                                                    <div class="col-lg-6">
                                                        <div class="input-group" style="margin-bottom:5px;">
                                                            <span class="input-group-addon">
                                                                <input type="radio" value="1" id="answer<?= $no; ?>" name="status[]" <?= $select; ?>> &raquo; 
                                                                <font ><?= $pilihan?></font>
                                                                <input type="hidden" name="answer_val[]" id="radio<?= $no; ?>" value="<?= $jwb['status_correct']?>">
                                                                <input type="hidden" name="id_jawaban[]" value="<?= $jwb['id_jawaban']?>">
                                                            </span>
                                                            <input type="text" onfocus="this.select()" id="answer_<?= $no; ?>" name="jawaban[]" value="<?= $jwb['jawaban']?>" autocomplete="off" class="form-control">
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
                                                        <img id="source_ans<?php echo $no ?>" src="<?= base_url($jwb['doc_path']) ?>" style="width:100%;height:200px;display:block;">
                                                        <img class="hide" id="target_ans<?php echo $no ?>" src="#" style="width:100%;height:200px;display:block;">
                                                        <input type="file" name="file_answer[]" style="margin-top:5px;width:80%;" id="file_answer<?php echo $no; ?>" class="btn pull-left">
                                                        <a class="btn answer-image-preview" data-src="">
                                                            <span class="fa fa-image"></span>
                                                        </a>
                                                        <input type="hidden" name="image_path_ans[]" value="<?= $jwb['doc_path'] ?>" style="margin-top:5px;width:100%;" />
                                                    <?php } else { ?>
                                                        <span><label style="float:left; width:100%;" class="control-label">File Answer <?= $pilihan?></label>
                                                        <input type="file" name="file_answer[]" style="margin-top:5px;width:80%;" id="file_answer<?php echo $no; ?>" class="btn pull-left">
                                                        <a class="btn answer-image-preview" data-src="">
                                                            <span class="fa fa-image"></span>
                                                        </a>
                                                    <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $no++; $char++; } ?>
                                        <div class="form-group">
                                            <div class="col-md-12 text-right">
                                                <a href="<?php echo site_url('ADMSeleksi/Setting/SetupPertanyaan');?>" class="btn btn-primary btn btn-flat">Back</a>
                                                &nbsp;&nbsp;
                                                <button type="submit" class="btn btn-success btn btn-flat">Update</button>
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

<script>
    $(document).on('ifChecked', 'input[name^="status"]', function(){
        // $('input[type=radio][name^=status]').on('change', function() {
        //loop through each radio
        $('input:radio').each(function() {
        //if checked
            if ($(this).is(':checked')) {
                //get closest div with class=form-group-addon and add value to input
                $(this).closest(".input-group-addon").find("input[name^=answer_val]").val('1');
            } else {
                //add 0
                $(this).closest(".input-group-addon").find("input[name^=answer_val]").val('0');
            }
        });
    });

    $('.question-image-preview, .answer-image-preview').popover({
        html: true,
        placement: 'left',
        trigger: 'hover',
        content() {
            const base64images = $(this).data('src');
            // console.log(base64images);
            if (base64images == "") return "<b>Select image first</b>";

            const contentHTML = `
            <div>
                <img src="${base64images}" style="height: 100px; width: auto;" />
            </div>
            `
            return contentHTML;
        }
    });

    $('input[name^=userfile').on('change', setImagePreview);

    $('input[name^=file_answer').on('change', setImagePreview);

    function setImagePreview() {
        const $siblingAnchor = $(this).siblings('a[data-src]');
        const nodeElement = $(this).get(0);
        // console.log($siblingAnchor, nodeElement);

        setDataBase64Image(nodeElement, $siblingAnchor);
    }

    const setDataBase64Image = ($element, $dest) => {
        if ($element.files && $element.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $dest.data('src', e.target.result);
            }

            reader.readAsDataURL($element.files[0]);
        }
    }

</script>