<section class="content">
    <div class="inner" >
        <div class="row">
            <form onkeydown="return event.key != 'Enter';" method="post" action="<?php echo base_url().'DokumenUnit/update_flow/'.$listdatafp[0]['id'] ?>" class="form-horizontal" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b>FLOW PROSES</b></h1></div>
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
                                                    <label for="inputnumberfp" class="control-label col-lg-4">Nomor Dokumen</label>
                                                    <div class="col-lg-8">
                                                        <input autocomplete="off" type="text" name="nomor_doc" value="<?php echo $listdatafp[0]['nomor_doc']?>" class="form-control" id="numberflow" >
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputseksifp" class="control-label col-lg-4">Judul Dokumen</label>
                                                    <div class="col-lg-8">
                                                        <textarea name="judul_fp" id="judulfp" placeholder="Input Judul Dok." class="form-control"><?php echo $listdatafp[0]['judul_doc']?></textarea>    
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="seksifp" class="control-label col-lg-4">Seksi Pengguna</label>
                                                    <div class="col-lg-8">
                                                        <select name="seksi_fp" id="seksi_fp" class="form-control select2" placeholder="Pilih Seksi/Unit">
                                                            <option value="<?php echo $listdatafp[0]['seksi_pengguna']?>"><?php echo $listdatafp[0]['seksi_full']?></option>
                                                            <?php foreach ($listseksi as $seksi) 
                                                            {
                                                                echo '  <option value="'.$seksi['singkat'].'">'.$seksi['seksi'].'</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="daterev_fp" class="control-label col-lg-4">Tgl. Revisi</label>
                                                    <div class="col-lg-7" style="padding-right: 0">
                                                        <input value="<?php echo $listdatafp[0]['date_rev']?>" type="text" onclick="datepsfunction()" name="date_rev_fp" id="date_rev_fp" class="form-control date_pengSistem" data-inputmask="'alias': 'dd-mm-yyyy'">
                                                    </div>
                                                    <div onclick="reset_date_jquery()" class="btn">
                                                        <span class="remove-date"><i class="fa fa-close fa-fw"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group row">
                                                    <label for="numberrev_fp" class="control-label col-lg-4">No. Revisi</label>
                                                    <div class="col-lg-8">
                                                        <input value="<?php echo $listdatafp[0]['number_rev']?>" min="00" type="number" name="number_rev_fp" id="number_rev-fp" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="pic_fp" class="control-label col-lg-4">PIC Pembuat</label>
                                                    <div class="col-lg-8">
                                                        <select name="pic_fp" id="pic-fp" class="form-control select2 input_selectpic">
                                                            <option value="<?= $listdatafp[0]['a'].' - '.$listdatafp[0]['pic_doc'];?>"><?= $listdatafp[0]['a'].' - '.$listdatafp[0]['pic_doc'];?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="status_fp" class="control-label col-lg-4">Status Dokumen</label>
                                                    <div class="col-lg-8">
                                                        <select name="status_fp" id="status-fp" class="form-control select2">
                                                            <option><?php echo $listdatafp[0]['status_doc']?></option>
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
                                            <button type="button" onclick="notif_edit_flow()" data-toggle="modal" data-target="#modal-default" class="btn btn-primary btn-lg btn-rect">Save Data</button>
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
                                                                            <th><center>No. Dokumen</center></th>
                                                                            <th><center>Judul Dokumen</center></th>
                                                                            <th><center>Seksi Pengguna</center></th>
                                                                            <th><center>Tgl.Rev.</center></th>
                                                                            <th><center>No.Rev.</center></th>
                                                                            <th><center>PIC</center></th>
                                                                            <th><center>Status</center></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="as"></td>
                                                                            <td class="bs"></td>
                                                                            <td class="cs"></td>
                                                                            <td class="ds"></td>
                                                                            <td class="es"></td>
                                                                            <td class="fs"></td>
                                                                            <td class="gs"></td>
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