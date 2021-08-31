<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
					<div class="text-right">
						<h1><b>Setup Pertanyaan</b></h1>
					</div>
				</div>
                <div class="col-lg-1 "></div>
                <br/>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <b>Form Tambah Pertanyaan</b>
                            </div>
                            <div class="box-body">
                                <form method="post" action="<?php echo base_url('ADMSeleksi/Setting/SetupPertanyaan/execute_tambah_soal')?>" enctype="multipart/form-data">
                                <?php foreach($data as $key => $value){ ?> 
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 form-group" style="margin-top: 10px;">
                                                <label style="margin-top: 5px;" class="col-sm-2 col-form-label">Nama Tes</label>
                                                <div class="col-md-6">
                                                    <input placeholder="Nama Tes" id="nama_tes" class="form-control nama_tes" name="nama_tes" value="<?= $value['nama_tes'] ?>" readonly>
                                                    <input type="hidden" id="id_tes" class="form-control id_tes" name="id_tes" value="<?= $value['id_tes'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12 form-group" style="margin-top: 10px;">
                                                <label style="margin-top: 5px;" class="col-sm-2 col-form-label">Jumlah Soal Per Halaman</label>
                                                <div class="col-md-6">
                                                    <input id="jml_soal" class="form-control jml_soal" name="jml_soal" value="" readonly>
                                                    <input type="hidden" id="jml_soal_old" class="form-control jml_soal_old" name="jml_soal_old" value="<?= $value['jml_soal'] ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-12 form-group" style="margin-top: 10px;">
                                                <label style="margin-top: 5px;" class="col-sm-2 col-form-label">Tipe Pilihan Jawaban</label>
                                                <div class="col-md-6">
                                                    <input id="tipe_pilihan" class="form-control tipe_pilihan" name="tipe_pilihan" value="<?= $value['tipe_pilihan'] ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 form-group">
                                                <h4 class="box-title" style="margin-top: 20px"></i>   Instruksi Tes :</h4>
                                                <textarea name="instruksi_tes" id="instruksi_tes" style="width: 100%; height: 300px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" readonly="readonly"><?= $value['instruksi_tes']?></textarea>
                                            </div>
                                            <div class="col-lg-12 form-group">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped" id="table_question" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 10%">No : </th>
                                                                <th style="width: 45%">Pertanyaan : </th>
                                                                <th style="width: 45%">Jawaban : </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $no = 1; foreach ($value['pertanyaan'] as $key2 => $val) {?>
                                                            <tr data-index="<?= $no?>" class="">
                                                                <td>
                                                                    <!-- NO SOAL -->
                                                                    <input type="hidden" id="id_pertanyaan" value="<?= $val['id_pertanyaan'] ?>"  name="id_pertanyaan[<?= $no?>]" class="form-control"/>
                                                                    <input type="text" id="no_soal" value="<?= $no?>" name="no_soal[<?= $no?>]" class="form-control text-center text-bold" readonly/>
                                                                </td>
                                                                <td>
                                                                    <!-- QUESTION -->
                                                                    <textarea id="pertanyaan" autocomplete="off" rows="4" cols="6" name="pertanyaan[<?= $no?>]" class="form-control" style="resize: none;" placeholder="Write a question" readonly><?= $val['pertanyaan']?></textarea>
                                                                    <div class="row" style="margin-top: 0.5em;">
                                                                        <div class="col-md-12 js-question-image-wrapper">
                                                                            <div class="input-group" style="margin-bottom: 0.5em;">
                                                                            <?php foreach ($val['file_pertanyaan'] as $key3 => $fileval) {
                                                                                if ($fileval['doc_path'] != NULL) {
                                                                            ?>
                                                                                <img src="<?= base_url($fileval['doc_path']) ?>" style="border:solid #ababab;width:100px;height:auto;display:block;"/>
                                                                            <?php } else { ?>
                                                                            <?php } } ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                <?php $no2=1; $char="A"; foreach ($val['jawaban'] as $key4 => $jwb) {
                                                                    if ($data[0]['tipe_pilihan'] == 'ANGKA'){
                                                                        $pilihan = $no2;
                                                                    } else if ($data[0]['tipe_pilihan'] == 'HURUF'){
                                                                        $pilihan = $char;
                                                                    } else {
                                                                        $pilihan = "";
                                                                    }
                                                                ?>
                                                                    <!-- ANSWERS -->
                                                                    <div class="js-answer-wrapper">
                                                                        <div class="input-group" style="margin-bottom: 5px;">
                                                                            <span class="input-group-addon">
                                                                                <span><?= $pilihan?></span>
                                                                            </span>
                                                                            <input type="text" name="jawaban[<?= $no?>][]" autocomplete="off" class="form-control" placeholder="Write an answer" value="<?= $jwb['jawaban']?>" readonly/>
                                                                            <?php
                                                                                if ($jwb['doc_path'] != NULL) {
                                                                            ?>
                                                                                <img src="<?= base_url($jwb['doc_path']) ?>" style="border:solid #ababab;width:100px;height:auto;display:block;" />
                                                                            <?php } else { ?>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                <?php $no2++; $char++; } ?>
                                                                </td>
                                                            </tr>
                                                            <!-- js on bottom -->
                                                            <?php $no++; } ?>
                                                        </tbody>
                                                    </table>
                                                    <div class="col-xs-2">
                                                        <div class="text-right">
                                                            <a class="btn btn-success" id="js-add-question">
                                                                <span>Tambahkan Soal</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <div class="text-right">
                                                            <a class="btn btn-danger" id="js-remove-question">
                                                                <span>Hapus Soal</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 form-group" style="margin-top: 10px;">
                                                <label style="margin-top: 5px;" class="col-sm-2 col-form-label">Waktu Per Halaman : </label>
                                                <div class="col-lg-12">
                                                    <div class="col-lg-1">
                                                        <i class="fa fa-clock-o" style="font-size: 40px;"></i>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <input name="menit" class="form-control"  type="number" placeholder="Menit" value="<?= $value['menit'] ?>" readonly>
                                                    </div>
                                                    <div class="col-lg-1 text-center">
                                                        :
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <input name="detik" class="form-control"  type="number" placeholder="Detik" value="<?= $value['detik'] ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 form-group" style="margin-top: 10px;">
                                                <span style="font-style: italic; font-size: 14px;">
                                                    <input type="checkbox" id="checkinstruksi" name="checkinstruksi" <?= ($value['instruksi_flag']=='Y' ? 'checked' : '');?> disabled>  
                                                    Ulangi instruksi tes sebagai header di setiap halaman
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 text-right">
                                            <a href="<?php echo site_url('ADMSeleksi/Setting/SetupPertanyaan');?>"  class="btn btn-primary btn btn-flat">Back</a>
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-success btn btn-flat">Save Data</button>
                                        </div>
                                    </div>
                                <?php } ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
	// (function($) {
    $(document).ready(function(){
        const $questionTable = $('table#table_question');

        $(document).on('ifChecked', 'input[name^="radio_correct_answer"]', function(){
        // $('input[type=radio][name^=radio_correct_answer]').on('change', function() {
            //loop through each radio
            $('input:radio').each(function() {
            //if checked
                if ($(this).is(':checked')) {
                //get closest div with class=form-group-addon and add value to input
                $(this).closest(".input-group-addon").find("input[name^=correct_answer]").val('1');

                } else {
                //add 0
                $(this).closest(".input-group-addon").find("input[name^=correct_answer]").val('0');
                }
            });
        });

        const getTableBodyLength = () => $questionTable.find('tbody > tr').length;
        const getLastTableIndex = () => getTableBodyLength() + 1;

        let lastQuestionNumber = getLastTableIndex() - 1;
        let idpertanyaan = <?= $idpertanyaan?>;
        
        const generateQuestionHTML = (index, questionNumber, idpertanyaan, pilihan) => {
			return `
			<tr data-index="${index}" class="">
				<td>
                    <!-- NO SOAL -->
                    <input type="hidden" id="id_pertanyaan" value="${idpertanyaan}" name="id_pertanyaan[${index}]" class="form-control text-center text-bold" readonly="readonly" />
					<input type="text" id="no_soal" value="${questionNumber}" name="no_soal[${index}]" class="form-control text-center text-bold" readonly="readonly" />
				</td>
				<td>
					<!-- QUESTION -->
					<textarea id="pertanyaan" autocomplete="off" rows="4" cols="6" name="pertanyaan[${index}]" class="form-control" style="resize: none;" placeholder="Write a question"></textarea>
					<div class="row" style="margin-top: 0.5em;">
						<div class="col-md-12 js-question-image-wrapper">
							<div class="input-group" style="margin-bottom: 0.5em;">
								<input type="file" name="userfile[${index}][]"style="width: 80%;" class="form-control pull-left">
								<a class="btn js-question-image-preview" data-src="">
									<span class="fa fa-image"></span>
								</a>
							</div>
						</div>
					</div>
				</td>
				<td>
                    <!-- ANSWERS -->
                    <div class="js-answer-wrapper">
                        <div class="input-group" style="margin-bottom: 5px;">
                            <span class="input-group-addon">
                                <input checked value="1" type="radio" name="radio_correct_answer[${index}]">
                                &raquo; 
                                <span id="pilihan">${pilihan}</span>
                                <input value="1" type="hidden" name="correct_answer[${index}][]">
                            </span>
                            <input type="text" name="jawaban[${index}][]" autocomplete="off" class="form-control" placeholder="Write an answer" />
                            <input type="file" style="margin-bottom:5px;width:70%;" name="file_answers[${index}][]" class="form-control pull-left" />
                            <a class="btn js-question-answer-image-preview" data-src="">
                                <i class="fa fa-image"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="text-center">
                            <a class="btn btn-warning" id="js-add-answer">
                                <span>Tambah Pilihan Jawaban</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="text-center">
                            <a class="btn btn-danger" id="js-delete-answer">
                                <span>Hapus Pilihan Jawaban</span>
                            </a>
                        </div>
                    </div>
				</td>
			</tr>
			`;
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

        const addQuestionField = () => {
            lastQuestionNumber++;
            idpertanyaan++;

            $('input[name="jml_soal"]').val(lastQuestionNumber);

            var tipe_pilihan = $('.tipe_pilihan').val();
            // console.log(tipe_pilihan);
            if (tipe_pilihan == 'ANGKA'){
                pilihan = 1;
            } else if (tipe_pilihan == 'HURUF'){
                pilihan = 'A';
            } else{
                pilihan = 'A/1';
            }

			const htmlQuestionField = generateQuestionHTML(getLastTableIndex(), lastQuestionNumber, idpertanyaan, pilihan);
			$questionTable.find('tbody').append(htmlQuestionField);
			lastRowListenerInit()
        }

        $('#js-add-question').on('click', addQuestionField);

        $('#js-remove-question').on('click', function() {
            let jml_soal_old = $('input[name="jml_soal_old"]').val();
            
			if (getTableBodyLength() == (parseInt(jml_soal_old) + 1)) return alert("Cannot remove question");

			const isYes = confirm("Do you want to remove last question ?");
			if (!isYes) return;

			$questionTable.find('tbody > tr:last').remove();
            lastQuestionNumber--;
            idpertanyaan--;
            
            $('input[name="jml_soal"]').val(lastQuestionNumber);
        });
        
        // console.log(parseInt(jml_soal_old) + 1);
        
        function lastRowListenerInit() {
            const $lastRow = $questionTable.find('tbody > tr:last')

			function setImagePreview() {
				const $siblingAnchor = $(this).siblings('a[data-src]');
				const nodeElement = $(this).get(0);

				setDataBase64Image(nodeElement, $siblingAnchor);
			}

			function setImagePreviewOnQuestion() {
				$lastRow.find('input[name^=userfile]:last').on('change', setImagePreview);
			}

			function setImagePreviewOnAnswer() {
				$lastRow.find('input[name^=file_answers]').on('change', setImagePreview);
			}

			function tooltipInit() {
				$lastRow.find('.js-question-image-preview, .js-question-answer-image-preview').popover({
					html: true,
					placement: 'left',
					trigger: 'hover',
					content() {
                        const base64images = $(this).data('src');
						if (base64images == "") return "<b>Select image first</b>";

						const contentHTML = `
						<div>
						<img src="${base64images}" style="height: 100px; width: auto;" />
						</div>
						`
						return contentHTML;
					}
				});
			}

            // const htmlAnswer = $lastRow.find('.js-answer-wrapper').html();
            // console.log(htmlAnswer);

            const generatehtmlAnswer = (index, vallastpilihan) => {
                return `
                <div class="input-group" style="margin-bottom: 5px;">
                    <div class="input-group-addon">
                        <input value="1" type="radio" name="radio_correct_answer[${index}]">
                        &raquo; 
                        <span id="pilihan">${vallastpilihan}</span>
                        <input value="" type="hidden" name="correct_answer[${index}][]">
                    </div>
                    <input type="text" name="jawaban[${index}][]" autocomplete="off" class="form-control" placeholder="Write an answer" />
                    <input type="file" style="margin-bottom:5px;width:70%;" name="file_answers[${index}][]" class="form-control pull-left" />
                    <a class="btn js-question-answer-image-preview" data-src="">
                        <i class="fa fa-image"></i>
                    </a>
                </div>
                `;
            }
                        
            $lastRow.find('#js-add-answer').on('click', function() {
                // lastAnswerIndex++;
                // console.log(lastAnswerIndex);
                const answerLength = $lastRow.find('.js-answer-wrapper').find('.input-group').length
                // console.log(answerLength);
                if (answerLength >= 5) return alert("Maximal answer added is 5");
                
                var tipe_pilihan = $('#tipe_pilihan').val();

                if (tipe_pilihan == 'ANGKA'){
                    var lastpilihan = $lastRow.find('.js-answer-wrapper').find('.input-group').find('.input-group-addon').find('#pilihan');
                    var vallastpilihan = lastpilihan[lastpilihan.length - 1].innerHTML;
                    vallastpilihan++;
                } else if (tipe_pilihan == 'HURUF') {
                    var lastpilihan = $lastRow.find('.js-answer-wrapper').find('.input-group').find('.input-group-addon').find('#pilihan');
                    var vallastpilihan = lastpilihan[lastpilihan.length - 1].innerHTML;
                    var vallastpilihan = String.fromCharCode(vallastpilihan.charCodeAt(0) + 1)
                } else {
                    var vallastpilihan = '';
                }
                
                

                const htmlAnswer = generatehtmlAnswer(lastQuestionNumber, vallastpilihan);
                $lastRow.find('.js-answer-wrapper').append(htmlAnswer)

                // const cek = $lastRow.find('.js-answer-wrapper').find('.input-group').find('.input-group-addon').find('#pilihan');
                // console.log(cek[cek.length - 1].innerHTML)

                $('input[type="radio"]').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue'
                });
                
                tooltipInit()
				setImagePreviewOnAnswer()
            })
            
            $lastRow.find('#js-delete-answer').on('click', function() {
				const answerLength = $lastRow.find('.js-answer-wrapper').find('.input-group').length
                
				if (answerLength == 1) return alert("Cannot remove first answer");

				// const lastInputElement = $lastRow.find('.js-answer-wrapper').find('.input-group:last').val();
				// if (lastInputElement != "") {
                const isYes = confirm("Do you want to delete this answer ?")
                if (!isYes) return;
                // }

                $lastRow.find('.js-answer-wrapper').find('.input-group:last').remove()
			})

			tooltipInit()
			setImagePreviewOnQuestion()
			setImagePreviewOnAnswer()
        }
        addQuestionField()
    // })(jQuery);
    });
</script>