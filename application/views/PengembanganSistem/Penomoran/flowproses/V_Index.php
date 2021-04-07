<section class="content">
    <style>
        th,td{
            white-space: nowrap;
        }
        th{
            background-color: #d9edf7;
        }
    </style>
    <div class="inner" >
        <div class="row">
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
                            <form onkeydown="return event.key != 'Enter';" method="post" action="<?php echo base_url('PengembanganSistem/Input_fp') ?>" class="form-horizontal">
                              <div class="box box-primary box-solid">
                                <div class="box-header with-border"><div class="col-sm-6">Input Data </div>
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
                                                          <input data-toggle="tooltip" title="Akan otomatis terisi setelah mengisi seksi pengguna" type="text" name="n" readonly="" class="form-control" id="number_flow_ps" placeholder="">
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label for="inputseksi_fp" class="control-label col-lg-4">Judul Dokumen</label>
                                                      <div class="col-lg-8">
                                                          <textarea required="" name="judul_fp" id="judul_fp" placeholder="Input Judul Dok." class="form-control"></textarea>    
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label for="seksi_fp" class="control-label col-lg-4">Seksi Pengguna</label>
                                                      <div class="col-lg-8">
                                                          <select name="seksi_fp" required="" id="seksi_fp" class="form-control select2" data-placeholder="--PIlih Data--">
                                                              <option></option>
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
                                                          <input type="text" required="" name="date_rev_fp" id="date_rev_fp" onclick="datepsfunction()" class="form-control date_pengSistem" data-inputmask="'alias': 'dd-mm-yyyy'">
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
                                                          <input type="number" required="" value="00" min="00" max="10000" name="number_rev_fp" id="number_rev-fp" class="form-control" placeholder="input nomor revisi doc">
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label for="pic_fp" class="control-label col-lg-4">PIC Pembuat</label>
                                                      <div class="col-lg-8">
                                                          <select name="pic_fp" required="" id="pic-fp" class="form-control select2 input_selectpic" data-placeholder="--Pilih data--">
                                                              <option></option>
                                                          </select>
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label for="status_fp" class="control-label col-lg-4">Status Dokumen</label>
                                                      <div class="col-lg-8">
                                                          <select name="status_fp" required="" id="status-fp" class="form-control select2" data-placeholder="--Pilih data--">
                                                              <option></option>
                                                              <option value="Baru">Baru</option>
                                                              <option value="Approval">Approval</option>
                                                              <option value="On Proses">On Proses</option>
                                                              <option value="Cansel">Cancel</option>
                                                          </select>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      <div class="panel-footer">
                                          <div class="row text-right">
                                              <a href="javascript:history.back(1)" class="btn btn-primary btn-rect">Back</a>
                                              &nbsp;&nbsp;
                                              <button type="button" onclick="notif_input_flow()" data-toggle="modal" data-target="#modal-default" class="btn btn-primary btn-rect">Save Data</button>
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
                            </form>
                              <div class="box box-primary">
                                <div class="box-header with-border">
                                    <div class="col-lg-6"><h4 style="font-weight:bold;"><i class="fa fa-files-o"></i> Monitoring Flow Proses</h4></div>
                                        <form  onkeydown="return event.key != 'Enter';" method="post" action="<?php echo base_url('PengembanganSistem/excel_masterlist') ?>" class="form-horizontal">
                                            <div class="col-sm-12 row">
                                                <h5 class="col-sm-2" style="margin-top: 25px;"><b> Cetak Masterlist &nbsp;:</b></h5>
                                                <div class="col-sm-3"><b>Judul Masterlist</b>
                                                    <input type="text" style="display:none;" name="data" value="FP">
                                                    <input type="text" name="judulmasterlist" placeholder="Judul Masterlist" class="form-control" style="text-transform:uppercase">
                                                </div>
                                                <div class="col-sm-3"><b>Document Controller</b>
                                                    <select class="form-control select2 input_selectpic" name="picmasterlist" id="master" required="">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                                <button class="btn btn-sm btn-warning" style="bottom: 0.5em; position: relative; top: 20px;"><span style="font-size: 16px;" class="fa fa-file-excel-o"></span> - Excel </button>
                                            </div>
                                        </form>
                                </div>
                                <div class="box-body">
                                  <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover text-left " id="dataTables-PengSistem" style="font-size:12px; width:max-content;">
                                      <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>No. Dokumen</th>
                                            <th>Judul Dokumen</th>
                                            <th>Date.Rev.</th>
                                            <th>No.Rev.</th>
                                            <th>File</th>
                                            <th>PIC</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                    <?php $no= 1; foreach ($listdatafp as $row) { ?>
                                        <tr row-id="<?php echo $row['id']?>" class="ta-ta">
                                        <td><b><?php echo $no++; ?></b></td>
                                        <td><?php echo $row["nomor_doc"];?></td>
                                        <td><?php echo $row["judul_doc"];?></td>
                                        <td><?php if ($row["date_rev"] == "          ") {
                                            echo "-";
                                        }else{
                                                $datatanggal = explode("-", $row["date_rev"]);
                                                $day = $datatanggal[2];
                                                $bulan = $datatanggal[1];
                                                $tahun = $datatanggal[0];
                                                $hasil = $day."-".$bulan."-".$tahun;
                                                echo $hasil;
                                        }?></td>
                                        <td><?php echo $row["number_rev"];?></td>
                                        <td><?php if ($row['file'] != "" ) {echo '<p class="btn btn-xs btn-success" onclick="link_ps('.$row['id'].')" id="fp_lilola'.$row['id'].'" kkk="'.$row["dept"].'-'.$dept.'" data-id="'.$row["file"].'='.$row['link_file'].'"><i class="fa fa-eye"> View</i></p>'; } ?></td>
                                        </td>
                                        <td><?php echo $row["pic_doc"];?></td>
                                        <td><?php echo $row["status_doc"];?></td>
                                        <td>
                                        <div  >
                                            <div class="btn-group" style="width: max-content;<?php if(strlen($row['file']) !== 0){echo 'display:none';} ?>">
                                            <a class="btn-xs btn btn-success" href="<?php echo base_url('PengembanganSistem/edit_flow/'.$row['id'])?>" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <a class="btn-xs btn btn-warning" data-toggle="modal" data-toggle="tooltip" data-target="<?php echo "#modal_edit".$row['id'];?>" title="Upload"><i class="fa fa-cloud-upload"></i></a>
                                            <a class="btn-xs btn btn-danger" title="Delete" onclick="delete_flow(<?= $row['id']?>)"><i class="fa fa-close"></i></a>
                                            </div>
                                        </div>
                                        </td>
                                            <div class="modal fade" id="<?php echo "modal_edit".$row['id'];?>" role="dialog" aria-labelledby="largeModal" aria-hidden="true" align="center">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" align="left">Upload File :</h4>
                                                    </div>
                                                    <form class="form-validate form-horizontal " method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">

                                                            <div class="form-group">
                                                                <label class="control-label col-xs-3" >File : </label>
                                                                <div class="col-xs-8">
                                                                    <input id="file_fp_<?php echo $row['id']?>" name="file_flow_ps" class="form-control" type="file">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="col-xs-3 control-label">Status :</label>
                                                                <div class="col-xs-8">
                                                                <select id="status_flow_<?php echo $row['id']?>" name="status" class="form-control sensitive-input" data-placeholder="Pilih" required="">
                                                                    <option><?=$row["status_doc"]?></option>
                                                                    <option value="Baru">Baru</option>
                                                                    <option value="Approval">Approval</option>
                                                                    <option value="On Proses">On Proses</option>
                                                                    <option value="Cansel">Cancel</option>
                                                                </select>
                                                                </div>
                                                            </div>

                                                            <div style="display:none;" class="form-group">
                                                                <label class="control-label col-xs-3" >File Name : </label>
                                                                <div class="col-xs-8">
                                                                <input class="form-control" disabled="" id="judul_flow_<?php echo $row['id']?>" name="judul_fp" hidden="" value="<?=$row["judul_doc"].'?'.$row['nomor_doc'];; ?>">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                            <button type="button" onclick="upload_file_flow(<?php echo $row['id']?>)" data-id="<?php echo $row['id']?>" class="btn btn-info"><i class="fa fa-upload"> Upload</i></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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