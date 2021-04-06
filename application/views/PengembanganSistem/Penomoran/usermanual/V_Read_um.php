<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo base_url().'PengembanganSistem/update_UM/'.$listdataum[0]['id'] ?>" class="form-horizontal" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b> User Manual</b></h1></div>
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
                                                    <label for="inputnumberum" class="control-label col-lg-4">Nomor Dokumen</label>
                                                    <div class="col-lg-8">
                                                        <input data-toggle="tooltip" readonly="" value="<?= $listdataum[0]['nomor_doc']?>" title="Akan otomatis terisi setelah mengisi seksi pengguna" type="text" name="number_doc_um" class="form-control" id="number_um" placeholder="">
                                                    </div>
                                                    <p class="check_number" style="display: none;"><?= $listdataum[0]['nomor_um']?></p>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputseksi_um" class="control-label col-lg-4">Judul Dokumen</label>
                                                    <div class="col-lg-8">
                                                        <textarea name="judul_um" id="judul_um" placeholder="Input Judul Dok." class="form-control"><?= $listdataum[0]['judul_doc']?></textarea>    
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="seksi_um" class="control-label col-lg-4">Seksi Pengguna</label>
                                                    <div class="col-lg-8">
                                                        <select name="seksi_um" id="seksi_um" class="form-control select2" placeholder="Pilih Seksi/Unit">
                                                            <option value="<?php echo $listdataum[0]['seksi_sop']?>"><?php echo $listdataum[0]['seksi_pengguna']?></option>
                                                            <?php foreach ($listseksi as $seksi) 
                                                            {
                                                                echo '  <option value="'.$seksi['singkat'].'">'.$seksi['seksi'].'</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="doc_um" class="control-label col-lg-4">Oracle / Android / Web Base / Form</label>
                                                    <div class="col-lg-8">
                                                        <select name="doc_um" id="doc_um" class="form-control select2" placeholder="Pilih Data">
                                                            <option><?= $listdataum[0]['jenis_doc']?></option>
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
                                                    <label for="sop_um" class="control-label col-lg-4">No. SOP :</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" value="<?= $listdataum[0]['seksi_sop']?>" name="sop_um" class="form-control" id="sop_um" placeholder="" readonly="">
                                                    </div>
                                                    <div class="col-sm-1">-</div>
                                                    <div class="col-sm-4">
                                                        <input autocomplete="off" type="number" value="<?= $listdataum[0]['number_sop']?>" oninput="nomor_um_ps()" min="00" name="number_sop_um" value="00" class="form-control" id="nomor_sop_um" placeholder="00" >
                                                    </div>
                                                    <p class="chle_number" style="display: none"><?= $listdataum[0]['number_sop']?></p>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="daterev_um" class="control-label col-lg-4">Tgl. Revisi</label>
                                                    <div class="col-lg-8" style="padding-right:0">
                                                        <input type="date" value="<?= $listdataum[0]['date_rev']?>" name="date_rev_um" id="date_rev_um" class="form-control">
                                                    </div>
                                                    <div onclick="reset_date_jquery()" class="btn">
                                                    <span class="remove-date"><i class="fa fa-close fa-fw"></i></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="numberrev_um" class="control-label col-lg-4">No. Revisi</label>
                                                    <div class="col-lg-8">
                                                        <input type="number" min="00" max="1000" value="<?= $listdataum[0]['number_rev']?>" name="number_rev_um" id="number_rev-fp" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="pic_um" class="control-label col-lg-4">PIC Pembuat</label>
                                                    <div class="col-lg-8">
                                                        <select name="pic_um" id="pic-um" class="form-control select2">
                                                            <option value="<?= $listdataum[0]['a'].' - '.$listdataum[0]['pic_doc'];?>"><?= $listdataum[0]['a'].' - '.$listdataum[0]['pic_doc'];?></option>
                                                            <?php foreach ($listorg as $org) 
                                                            {
                                                                echo '  <option value="'.$org['daftar_pekerja'].'">'.$org['daftar_pekerja'].'</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="status_um" class="control-label col-lg-4">Status Dokumen</label>
                                                    <div class="col-lg-8">
                                                        <select name="status_um" id="status-um" class="form-control select2">
                                                            <option><?= $listdataum[0]['status_doc']?></option>
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
                                            <button type="button" onclick="notif_edit_um()" data-toggle="modal" data-target="#modal-default" class="btn btn-primary btn-lg btn-rect">Save Data</button>
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
                                                                            <td class="am"></td>
                                                                            <td class="bm"></td>
                                                                            <td class="cm"></td>
                                                                            <td class="dm"></td>
                                                                            <td class="em"></td>
                                                                            <td class="fm"></td>
                                                                            <td class="gm"></td>
                                                                            <td class="hm"></td>
                                                                            <td class="im"></td>
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