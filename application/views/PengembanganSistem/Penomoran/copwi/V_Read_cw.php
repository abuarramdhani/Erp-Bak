<section class="content">
    <div class="inner" >
        <div class="row">
            <form onkeydown="return event.key != 'Enter';" method="post" action="<?php echo base_url().'PengembanganSistem/update_cop_wi/'.$listdatacw[0]['id'] ?>" class="form-horizontal" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b>Code Of Practice (COP) / Work Instruction (WI)</b></h1></div>
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
                                <div class="box-header with-border">Edit Data</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group row">
                                                    <label for="inputnumberfp" class="control-label col-lg-4">Nomor Dokumen</label>
                                                    <div class="col-lg-8">
                                                        <input value="<?= $listdatacw[0]['nomor_doc'];?>" data-toggle="tooltip" title="Akan muncul notifikasi jika nomor pernah diinput" type="text" name="nomor_doc" class="form-control" id="number_copwi_ps" readonly="">
                                                    </div>
                                                    <p class="clas_number" style="display: none;"><?= $listdatacw[0]['nomor_copwi'];?></p>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputseksicw" class="control-label col-lg-4">Judul Dokumen</label>
                                                    <div class="col-lg-8">
                                                        <textarea name="judulcw" id="judulcw" placeholder="Input Judul Dok." class="form-control"><?= $listdatacw[0]['judul_doc'];?></textarea>    
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="cop_wi_cw" class="control-label col-lg-4">Dokumen COP/WI</label>
                                                    <div class="col-lg-8">
                                                        <select name="cop_wi_cw" id="cop_wi_cw" class="form-control select2" placeholder="Pilih COP/WI">
                                                            <option id="select_doc" value="<?= $listdatacw[0]['doc'];?>"><?php if ($listdatacw[0]['doc'] == 'COP') {
                                                                echo 'Code Of Practice';
                                                            } else {
                                                                if ($listdatacw[0]['doc'] == 'WI') {
                                                                    echo 'Work Instruction';
                                                                }
                                                            }?></option>
                                                            <option value="COP">Code Of Practice</option>
                                                            <option value="WI">Work Instruction</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="seksicw" class="control-label col-lg-4">Seksi Pengguna</label>
                                                    <div class="col-lg-8">
                                                        <select name="seksi_cw" id="seksi_cw" class="form-control select2" placeholder="Pilih Seksi/Unit">
                                                            <option id="select_seksi" value="<?= $listdatacw[0]['seksi_sop'];?>"><?= $listdatacw[0]['seksi_full'];?></option>
                                                            <?php foreach ($listseksi as $seksi) 
                                                            {
                                                                echo '  <option value="'.$seksi['singkat'].'">'.$seksi['seksi'].'</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="doc_cw" class="control-label col-lg-4">Oracle / Android / Web Base / Form</label>
                                                    <div class="col-lg-8">
                                                        <select name="doc_cw" id="doc_cw" class="form-control select2" placeholder="Pilih Data">
                                                            <option><?= $listdatacw[0]['jenis_doc_cw'];?></option>
                                                            <option value="Oracle" >Oracle</option>
                                                            <option value="Android">Android</option>
                                                            <option value="Web Base">Web Base</option>
                                                            <option value="Form">Form</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group row">
                                                    <label for="sop_cw" class="control-label col-lg-4">No. SOP :</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" value="<?= $listdatacw[0]['seksi_sop'];?>" name="sop_cw" class="form-control" id="sop_cw" placeholder="" readonly="">
                                                    </div>
                                                    <div class="col-sm-1">-</div>
                                                    <div class="col-sm-2">
                                                        <input autocomplete="off" type="number" min="00" max="1000" name="number_sop_cw" value="<?= $listdatacw[0]['number_sop'];?>" class="form-control" id="nomor_sop_cw" oninput="nomor_cop_wi_ps()" placeholder="00" >
                                                    </div>
                                                    <p class="cle_number" style="display: none;"><?= $listdatacw[0]['number_sop'];?></p>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="daterev_fp" class="control-label col-lg-4">Tgl. Revisi</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" value="<?= $listdatacw[0]['date_rev'];?>" name="date_rev_cw" id="date_rev_cw" onclick="datepsfunction()" class="form-control date_pengSistem" data-inputmask="'alias': 'dd-mm-yyyy'">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="numberrev_fp" class="control-label col-lg-4">No. Revisi</label>
                                                    <div class="col-lg-8">
                                                        <input type="number" value="<?= $listdatacw[0]['number_rev'];?>" name="number_rev_cw" id="number_rev-cw" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="pic_fp" class="control-label col-lg-4">PIC Pembuat</label>
                                                    <div class="col-lg-8">
                                                        <select name="pic_cw" id="pic-cw" class="form-control select2">
                                                            <option value="<?= $listdatacw[0]['a'].' - '.$listdatacw[0]['pic_doc'];?>"><?= $listdatacw[0]['a'].' - '.$listdatacw[0]['pic_doc'];?></option>
                                                            <?php foreach ($listorg as $org) 
                                                            {
                                                                echo '  <option value="'.$org['nama_pekerja'].'">'.$org['daftar_pekerja'].'</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="status_fp" class="control-label col-lg-4">Status Dokumen</label>
                                                    <div class="col-lg-8">
                                                        <select name="status_cw" id="status-cw" class="form-control select2">
                                                            <option><?= $listdatacw[0]['status_doc'];?></option>
                                                            <option value="Baru">Baru</option>
                                                            <option value="Approval">Approval</option>
                                                            <option value="On Proses">On Proses</option>
                                                            <option value="Cansel">Cancel</option>
                                                        </select>
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
                                            <button type="button" onclick="notif_edit_cop_wi()" data-toggle="modal" data-target="#modal-default" class="btn btn-primary btn-lg btn-rect">Save Data</button>
                                        </div>
                                    </div>
                                </div>
                                    <!--/.modal -->
                                    <div class="modal fade" id="modal-default">
                                      <div class="modal-dialog" style="width:80%;">
                                          <div class="modal-content">
                                          <div class="modal-header">
                                              <h4 class="modal-title"><b> Perhatian !!! </b>, Pastikan Data Benar &hellip;</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          <div class="modal-body">
                                          <table id="table" border="1" class="dataTable" style="width:100%">
                                                                     <thead>
                                                                        <tr>
                                                                            <th><center>COP / WI<center></th>
                                                                            <th><center>No. Dokumen<center></th>
                                                                            <th><center>Judul Dokumen<center></th>
                                                                            <th style="width: 80px; font-size:smaller;"><center>Oracle / Android / Web Base / Form<center></th>
                                                                            <th><center>Rev.Date<center></th>
                                                                            <th><center>No.Rev.<center></th>
                                                                            <th><center>SOP<center></th>
                                                                            <th><center>PIC<center></th>
                                                                            <th><center>Seksi Pengguna<center></th>
                                                                            <th><center>Status<center></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="ac"></td>
                                                                            <td class="bc"></td>
                                                                            <td class="cc"></td>
                                                                            <td class="dc"></td>
                                                                            <td class="ec"></td>
                                                                            <td class="fc"></td>
                                                                            <td class="gc"></td>
                                                                            <td class="hc"></td>
                                                                            <td class="ic"></td>
                                                                            <td class="jc"></td>
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