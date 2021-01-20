<section class="content">
    <style>
        th{
            background-color: #d9edf7;
        }
    </style>
    <script src="<?= base_url('assets/plugins/ckeditor-full/ckeditor/ckeditor.js') ?>"></script>
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b>Surat/Memo Sie Peng. Sistem</b></h1></div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="">
                                    <i class="icon-wrench icon-2x"></i>
                                    <span ><br /></span>
                                </a>                             
                            </div>
                        </div>
                    </div>
                </div>
                <br />

                <div class="row">
                    <div class="col-lg-12">
                        <form onkeydown="return event.key != 'Enter';" method="post" action="<?= base_url().'PengembanganSistem/sm/creat_data_ms/'.$list[0]['id'] ?>" class="form-horizontal" enctype="multipart/form-data">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"><div class="col-sm-6">Buat Surat / Memo </div>
                            </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group row">
                                                <label for="date_ms" class="control-label col-lg-4">Nomor Surat / Memo</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="number_surat" id="editing_memo" class="form-control" value="<?= $list[0]['number_memo']?>" redionly="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="date_ms" class="control-label col-lg-4">Hal.</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="perihal" id="" class="form-control" value="<?= $list[0]['perihal_doc']?>" redionly="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="date_ms" class="control-label col-lg-4">Lampiran.</label>
                                                <div class="col-lg-8">
                                                    <input type="number" name="lampiran" id="" class="form-control" value="<?= $list[0]['perihal_doc']?>" redionly="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group row">
                                                <label for="date_ms" class="control-label col-lg-4">Kepada Yth.</label>
                                                <div class="col-lg-8">
                                                    <textarea name="yth" id="" class="form-control" rows="5"><?= $lists[0]['yth']?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="form-group row">
                                            <label for="date_ms" class="control-label col-lg-2">Dengan Hormat,</label>
                                            <div class="col-lg-12"><br>
                                                <textarea name="body_surat" editor="myeditor" editor-config="headings links" id="summernoteps" class="form-control ckeditor" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required> <?= $lists[0]['body_surat']?></textarea>
                                                    <script>
                                                                
                                                    CKEDITOR.replace( 'summernoteps', {
                                                        filebrowserBrowseUrl: '',
                                                        filebrowserUploadUrl: '<?php echo base_url("PengembanganSistem/sm/upload_file/".$list[0]['id'])?>',
                                                        stylesSet: [{

                                                            name: 'Narrow image',
                                                            type: 'widget',
                                                            widget: 'image',
                                                            attributes: {
                                                                'class': 'image-narrow'
                                                                }
                                                        },
                                                        {
                                                            name: 'Wide image',
                                                            type: 'widget',
                                                            widget: 'image',
                                                            attributes: {
                                                                'class': 'image-wide'
                                                            }
                                                        },
                                                        ],
                                                        image2_alignClasses: ['image-align-left', 'image-align-center', 'image-align-right'],
                                                        image2_disableResizer: true

                                                    });
                                                    var editor = CKEDITOR.instances['summernoteps'];
                                                        editor.setData($('summernoteps').val());
                                                    CKEDITOR.addCss('.cke_editable p { margin: 0 ; }');
                                                    </script>
                                            </div>
                                        </div>
                                </div>
                                <div class="panel-footer">
                                    <div class="row text-right">
                                        <a href="javascript:history.back(1)" class="btn btn-primary btn-rect">Back</a>
                                        &nbsp;&nbsp;
                                        <button type="submit" class="btn btn-primary btn-rect">Save Data</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                            <div class="box box-primary">
                                <div class="box-body">
                                  <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover text-left " id="dataTables-PengSistem" style="font-size:12px; width:100%;">
                                      <thead>
                                        <tr>
                                            <th><center>No.</center></th>
                                            <th><center>Update</center></th>
                                            <th><center>No. Dokumen</center></th>
                                            <th><center>Kepada Yth.</center></th>
                                            <th><center>Perihal</center></th>
                                            <th><center>Action</center></th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                    <?php $no= 1; foreach ($listdata as $row) { ?>
                                        <tr row-id="<?php echo $row['id']?>" class="ta-ta">
                                            <td><b><?php echo $no++; ?></b></td>
                                            <td style="font-weight: bold;"><a href="<?php echo base_url('PengembanganSistem/sm/create_memo/'.$row['id_data'].'ke'.$row['ke'])?>" >Edit_<?php echo $row["ke"];?></a></td>
                                            <td><a href="<?php echo base_url('PengembanganSistem/sm/cetak_memo/'.$row['id_data'].'ke'.$row['ke'])?>" target="_blank"><?php echo $row["number_surat"];?></a></td>
                                            <td><?php echo $row["yth"];?></td>
                                            <td><?php echo $row["perihal"];?></td>
                                            <td><a class="btn btn-xs btn-danger" style="padding: 6px;" title="Delete" onclick="deletedata(<?= $row['id']?>)"><i class="fa fa-close"></i></a></td>
                                        </tr>
                                    <?php } ?>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>