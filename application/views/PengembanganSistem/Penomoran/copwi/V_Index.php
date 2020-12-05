<?php echo $this->session->flashdata('notifikasi');?>
<style>
    .vel_ps{
        vertical-align : middle;
        text-align : center;
    }
</style>
<section class="content">
    <div class="inner" >
        <div class="row">
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
                           <form onkeydown="return event.key != 'Enter';" method="post" action="<?= base_url('PengembanganSistem/input_cop_wi') ?>" class="form-horizontal" enctype="multipart/form-data">
                              <div class="box box-primary box-solid">
                                  <div class="box-header with-border">Input Data</div>
                                  <div class="box-body">
                                      <div class="panel-body">
                                          <div class="row">
                                              <div class="col-lg-6">
                                                  <div class="form-group row">
                                                      <label for="inputnumberfp" class="control-label col-lg-4">Nomor Dokumen</label>
                                                      <div class="col-lg-8">
                                                          <input data-toggle="tooltip" title="Akan otomatis terisi setelah mengisi seksi pengguna" type="text" name="n" readonly="" class="form-control" id="number_copwi_ps" placeholder="">
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label for="inputseksicw" class="control-label col-lg-4">Judul Dokumen</label>
                                                      <div class="col-lg-8">
                                                          <textarea required="" name="judul_cw" id="judulcw" placeholder="Input Judul Dok." class="form-control"></textarea>    
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label for="cop_wi_cw" class="control-label col-lg-4">Dokumen COP/WI</label>
                                                      <div class="col-lg-8">
                                                          <select name="doccopwi_cw" required="" id="cop_wi_cw" class="form-control select2" data-placeholder="--PIlih Data--">
                                                              <option hidden=""></option>
                                                              <option value="COP">Code Of Practice</option>
                                                              <option value="WI">Work Instruction</option>
                                                          </select>
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label for="seksicw" class="control-label col-lg-4">Seksi Pengguna</label>
                                                      <div class="col-lg-8">
                                                          <select name="seksi_cw" required="" id="seksi_copwi_ps" class="form-control select2" data-placeholder="--PIlih Data--">
                                                              <option hidden=""></option>
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
                                                          <select name="doc_cw" required="" id="doc_cw" class="form-control select2" data-placeholder="--Pilih data--">
                                                              <option hidden=""></option>
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
                                                          <input type="text" required="" name="sop_cw" class="form-control" id="doc_sop_cw" placeholder="" readonly="">
                                                      </div>
                                                      <div class="col-sm-1">-</div>
                                                      <div class="col-sm-4">
                                                          <input autocomplete="off" type="number" oninput="input_nomor_cop_wi_ps()" min="00" value="00" required="" name="number_sop_cw" class="form-control" id="nomor_sop_cw" placeholder="00" >
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label for="daterev_cw" class="control-label col-lg-4">Tgl. Revisi</label>
                                                      <div class="col-lg-8">
                                                          <input placeholder="dd-mm-yyyy" required="" type="text" onclick="datepsfunction()" name="date_rev_cw" id="date_rev_cw" class="form-control date_pengSistem" data-inputmask="'alias': 'dd-mm-yyyy'">
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label for="numberrev_cw" class="control-label col-lg-4">No. Revisi</label>
                                                      <div class="col-lg-8">
                                                          <input type="number" required="" min="00" max="100" value="00" name="number_rev_cw" id="number_rev-cw" class="form-control">
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label for="pic_cw" class="control-label col-lg-4">PIC Pembuat</label>
                                                      <div class="col-lg-8">
                                                          <select name="pic_cw" required="" id="pic-cw" class="form-control select2 input_selectpic" data-placeholder="--Pilih data--">
                                                              <option hidden=""></option>
                                                          </select>
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label for="status_cw" class="control-label col-lg-4">Status Dokumen</label>
                                                      <div class="col-lg-8">
                                                          <select name="status_cw" required="" id="status-cw" class="form-control select2" data-placeholder="--Pilih data--">
                                                              <option hidden=""></option>
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
                                              <button type="button" onclick="notif_input_cop_wi()" data-toggle="modal" data-target="#modal-default" class="btn btn-primary btn-rect">Save Data</button>
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
                           </form>
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h4 style="font-weight:bold;"><i class="fa fa-files-o"></i> Monitoring Code Of Practice and Work Instruction</h4>
                                </div>
                              <div class="box-body">
                                <div class="table-responsive">
                                  <table class="table table-striped table-bordered table-hover text-left " id="dataTables-PengSistem" style="font-size:12px;">
                                        <thead>
                                            <tr class="bg-info">
                                                <th class="vel_ps" style="vertical-align: middle; width: 1%">No.</th>
                                                <th class="vel_ps" style="vertical-align: middle; width: 5%">COP / WI</th>
                                                <th class="vel_ps" style="vertical-align: middle; width: 10%">No. Dokumen</th>
                                                <th class="vel_ps" style="vertical-align: middle; width: 25%">Judul Dokumen</th>
                                                <th class="vel_ps" style="width: 80px; vertical-align: middle">Oracle / Android / Web Base / Form</th>
                                                <th class="vel_ps" style="vertical-align: middle; width: 60px">Rev.Date</th>
                                                <th class="vel_ps" style="vertical-align: middle; width: 60px">No.Rev.</th>
                                                <th class="vel_ps" style="vertical-align: middle; width: 10%">SOP</th>
                                                <th class="vel_ps" style="vertical-align: middle; width: 10%">PIC</th>
                                                <th class="vel_ps" style="vertical-align: middle; width: 5%">File</th>
                                                <th class="vel_ps" style="vertical-align: middle; width: 10%">Status</th>
                                                <th class="vel_ps" style="vertical-align: middle; width: 15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no= 1; foreach ($listdatacopwi as $row) { ?>
                                            <tr row-id="<?php echo $row['id']?>">
                                                <td><b><?php echo $no++; ?></b></td>
                                                <td><?php if($row["doc"] =='COP'){echo "Code Of Practice";}
                                                elseif ($row["doc"] =='WI') {
                                                    echo "Work Instruction";
                                                };?></td>
                                                <td><?php echo $row["nomor_doc"];?></td>
                                                <td><?php echo $row["judul_doc"];?></td>
                                                <td><?php echo $row["jenis_doc_cw"];?></td>
                                                <td><?php echo date('d-m-Y', strtotime($row["date_rev"]));?></td>
                                                <td><?php echo $row["number_rev"];?></td>
                                                <td><?php echo 'SOP-'.$row["seksi_sop"].'-'.$row["number_sop"];?></td>
                                                <td><?php echo $row["pic_doc"];?></td>
                                                <td><a onmouseover="link_cop(<?php echo $row['id']?>)" id="cop_lilola<?php echo $row['id']?>" data-toggle="tooltip" title="<?= $row['file']; ?>" href="<?php echo base_url('assets/upload/PengembanganSistem/um').'/'.$row['file'];?>" target="_blank"><?php if ($row['file'] != "" ) {echo '<i class="far fa-file-pdf"> View</i>'; } ?></a>
                                                </td>
                                                <td><?php echo $row["status_doc"];?></td>
                                                <td>
                                                    <div <?php if(strlen($row['file']) !== 0){echo 'hidden=""';} ?>>
                                                        <div class="btn-group">
                                                            <a style="padding: 6px" class="icon-action btn btn-success" href="<?php echo base_url('PengembanganSistem/edit_cop_wi/'.$row['id'])?>" title="Edit"><i class="fa fa-pencil"></i></a>
                                                            <a style="padding: 6px" class="icon-action btn btn-warning" data-toggle="modal" data-toggle="tooltip" data-target="<?php echo "#modal_edit".$row['id'];?>" title="Upload"><i class="fa fa-cloud-upload"></i></a>
                                                            <a style="padding: 6px" class="icon-action btn btn-danger" title="Delete" onclick="delete_cop_wi(<?= $row['id'];?>)"><i class="fa fa-close"></i></a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <div class="modal fade" id="<?php echo "modal_edit".$row['id'];?>" role="dialog" aria-labelledby="largeModal" aria-hidden="true" align="center">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" align="left">Upload File :</h4>
                                                            </div>
                                                            <form class="form-validate form-horizontal " method="post"  enctype="multipart/form-data">
                                                                <div class="modal-body">

                                                                    <div class="form-group">
                                                                        <label class="control-label col-xs-3" >File : </label>
                                                                            <div class="col-xs-8">
                                                                                <input id="file_cop_<?php echo $row['id']?>" name="file_ps" class="form-control" type="file" value="<?php echo $row['file']?>">
                                                                            </div>
                                                                    </div>
                                                                    <input id="judul_cop_<?php echo $row['id']?>" name="judul_cop_wi" hidden="" value="<?=$row["judul_doc"].'?'.$row['nomor_doc']; ?>">
                                                                        <div class="form-group">
                                                                            <label class="col-xs-3 control-label">Status :</label>
                                                                                <div class="col-xs-8">
                                                                                    <select id="status_cop_<?php echo $row['id']?>" name="status" class="form-control sensitive-input" data-placeholder="Pilih" required="">
                                                                                    <option value="<?php echo $row['status_doc']?>" hidden="hidden"><?php echo $row['status_doc']?></option>
                                                                                    <option value="Baru">Baru</option>
                                                                                    <option value="Approval">Approval</option>
                                                                                    <option value="On Proses">On Proses</option>
                                                                                    <option value="Cansel">Cancel</option>
                                                                                    </select>
                                                                                </div>
                                                                        </div>
                                                                </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Tutup</button>
                                                                        <button type="button" onclick="upload_file_cop(<?php echo $row['id']?>)" data-id="<?php echo $row['id']?>" class="btn btn-info swalDefaultSuccess"><i class="fa fa-upload"> Upload</i></button>
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