<section class="content">
    <div class="inner" >
        <div class="row">
            <form onkeydown="return event.key != 'Enter';" method="post" action="<?php echo base_url().'PengembanganSistem/update_data_ms/'.$listdata_memo[0]['id'] ?>" class="form-horizontal" enctype="multipart/form-data">
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
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border"><div class="col-sm-6">Edit Data </div>
                                    <div class="col-sm-6 text-right">
                                        <p class="btn btn-info" style="margin-right:25px;" data-toggle="tooltip" title="Icon Untuk Input Data Seksi/Departemen" id="tmbh_data"><i class="fa fa-plus"></i></p>
                                        <p class="btn btn-info" data-toggle="tooltip" title="Icon Untuk Melihat Data Seksi/Departemen" id="view_seunt"><i class="fa fa-table"></i></p>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group row">
                                                    <label for="date_ms" class="control-label col-lg-4">Tanggal Memo/Surat</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" disabled value="<?= $listdata_memo[0]['date_doc']?>" name="date_ms" id="date_ms" onclick="datepsfunction()" class="form-control date_pengSistem" data-inputmask="'alias': 'dd-mm-yyyy'">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="kode_ms" class="control-label col-lg-4">Kode Memo/Surat:</label>
                                                    <div class="col-lg-8">
                                                        <select disabled name="kode_ms" id="kode_ms" class="form-control select2" placeholder="--Pilih Data--">
                                                            <option id="seleksidata" value=""><?php if ($listdata_memo[0]['kode_doc'] == 'I') {
                                                                echo "Internal";
                                                            }elseif ($listdata_memo[0]['kode_doc'] == 'E') {
                                                                echo "Eksternal";
                                                            }if ($listdata_memo[0]['kode_doc'] == 'C') {
                                                                echo "Cabang";
                                                            }else {
                                                                echo false;
                                                            }?></option>
                                                            <option value="I" data-toggle="tooltip" title="Internal Jika Dokumen merupakan dokumen internal" data-placement="right">Internal</option>
                                                            <option value="E" data-toggle="tooltip" title="Internal Jika Dokumen merupakan dokumen Eksternal" data-placement="right">External</option>
                                                            <option value="C" data-toggle="tooltip" title="Internal Jika Dokumen merupakan dokumen Cabang" data-placement="right">Cabang</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="control-label col-lg-4">Ditujukan :</label>
                                                    <div class="col-sm-8">
                                                        <!-- radio -->
                                                        <div class="col-sm-6" style="padding-bottom: 10px;">
                                                            <input type="radio" name="r2sys" value="user"value="user" <?php if ($listdata_memo[0]['conect'] == 'user') {
                                                                echo'checked=""';
                                                            } else {
                                                                true;
                                                            }
                                                            ?>>
                                                            Orang/Penerima
                                                        </div>
                                                        <div class="col-sm-6" style="padding-bottom: 10px;">
                                                            <input type="radio" name="r2sys" value="siedept"<?php if ($listdata_memo[0]['conect'] == 'siedept') {
                                                                echo'checked=""';
                                                            } else {
                                                                false;
                                                            }
                                                            ?>>
                                                            Seksi/Unit/Deprt
                                                        </div>
                                                        <div class="col-sm-6" style="padding-bottom: 10px;">
                                                            <input type="radio" name="r2sys" value="manual"<?php if ($listdata_memo[0]['conect'] == 'manual') {
                                                                echo'checked=""';
                                                            } else {
                                                                false;
                                                            }
                                                            ?>>
                                                            Input Manual
                                                        </div>
                                                        <div class="orang" >
                                                            <?php if ($listdata_memo[0]['conect'] != 'manual') {
                                                               echo ' <select data-id="',$listdata_memo[0]['for_doc'],'" name="ditujukan_ms" id="ditujukan_ms1" class="form-control notif_ms select2" data-placeholder="-->Pilih Data<--" >
                                                                    <option id="check" value="',$listdata_memo[0]['for_doc'],'">',$listdata_memo[0]['for_doc'],'</option>
                                                                </select>';
                                                            } else {
                                                                echo '<input type="text" name="ditujukan_ms" id="ditujukan_ms1" class="form-control" placeholder="Input Data" value="'.$listdata_memo[0]['for_doc'],'">';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="siepenerima_ms" class="control-label col-lg-4">Penerima Surat/Memo</label>
                                                    <div class="col-lg-8">
                                                        <div class="col-sm-6">
                                                            <input type="button" class="btn btn-info btn-xs" id="input_auto" value="clik!">Input Manual
                                                            
                                                        </div>
                                                        <div class="siepenerima_ms">
                                                            <select required="" name="siepenerima_ms" id="siepenerima_ms" class="form-control select2" data-placeholder="-->Pilih Data<--">
                                                                <option value="<?= $listdata_memo[0]['seksi_depart'];?>"><?= $listdata_memo[0]['seksi_depart'];?></option>
                                                                                <?php foreach ($listseksi as $seksi) 
                                                                                {
                                                                                    echo '  <option value="'.$seksi['seksi'].'">'.$seksi['seksi'].'</option>';
                                                                                }
                                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group row">
                                                    <label for="makeby_ms" class="control-label col-lg-4">Dibuat</label>
                                                    <div class="col-lg-8">
                                                        <select name="pembuat_ms" id="makeby_ms" class="form-control select2 input_selectpic">
                                                            <option value="<?= $listdata_memo[0]['pic_doc']?>"><?= $listdata_memo[0]['pic_doc']?></option>
                                                            </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="date_distribusi_ms" class="control-label col-lg-4">Tgl. Distribusi</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" value="<?= $listdata_memo[0]['date_distribusion']?>" name="date_distribusi" id="date_distribusi_ms" onclick="datepsfunction()" class="form-control date_pengSistem" data-inputmask="'alias': 'dd-mm-yyyy'">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="perihal_ms" class="control-label col-lg-4">Perihal</label>
                                                    <div class="col-lg-8">
                                                        <textarea name="perihal_ms" id="perihal_ms" placeholder="Input Judul Dok." class="form-control"><?= $listdata_memo[0]['perihal_doc']?></textarea>    
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="perihal_ms" class="control-label col-lg-4">Preview Number</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="a" id="a_number" class="form-control" value="<?= $listdata_memo[0]['number_memo']?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <br />
                                            <br />
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
                                                    </ul>
                                                    <div class="tab-content">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row text-right">
                                            <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
                                            <button type="button" onclick="notif_create_memo()" data-toggle="modal" data-target="#modal-default" class="btn btn-primary btn-lg btn-rect">Save Data</button>
                                        </div>
                                    </div>
                                </div>
                                    <!--/.modal -->
                                    <div class="modal fade" id="modal-default">
                                    <div class="modal-dialog" style="width:80%;">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Perhatian !!!</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                </div>
                                                    <div class="modal-body">
                                                        <table id="table" border="1" class="dataTable" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th style="font-weight: bold;"><center>No. Surat / Memo</center></th>
                                                                    <th><center>Tgl. Dibuat</center></th>
                                                                    <th><center>Ditujukan</center></th>
                                                                    <th><center>Sie Penerima</center></th>
                                                                    <th><center>Perihal</center></th>
                                                                    <th><center>PIC Dokumen</center></th>
                                                                    <th><center>Tgl. Distribusi</center></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="hms"></td>
                                                                    <td class="ims"></td>
                                                                    <td class="jms"></td>
                                                                    <td class="kms"></td>
                                                                    <td class="lms"></td>
                                                                    <td class="mms"></td>
                                                                    <td class="nms"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save </button>
                                                </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>