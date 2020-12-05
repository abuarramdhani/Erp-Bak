<section class="content">
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
                          <form onkeydown="return event.key != 'Enter';" method="post" action="<?= base_url('PengembanganSistem/input_data_ms') ?>" class="form-horizontal" enctype="multipart/form-data">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Input Data</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group row">
                                                    <label for="date_ms" class="control-label col-lg-4">Tanggal Memo/Surat</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="date_ms" id="date_ms" onclick="datepsfunction()" class="form-control date_pengSistem" data-inputmask="'alias': 'dd-mm-yyyy'">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="kode_ms" class="control-label col-lg-4">Kode Memo/Surat:</label>
                                                    <div class="col-lg-8">
                                                        <select name="kode_ms" id="kode_ms" class="form-control select2" data-placeholder="--Pilih Data--">
                                                            <option hidden ></option>
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
                                                        <div class="col-sm-6">
                                                            <input type="radio" class="radioselectsys" name="r2sys" value="user">
                                                            Orang/Penerima
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="radio" class="radioselectsys" name="r2sys" value="siedept">
                                                            Seksi/Unit/Deprt
                                                        </div>
                                                        <div class="orang">
                                                            <select name="ditujukan_ms" id="ditujukan_ms1" class="form-control notif_ms select2" data-placeholder="-->Pilih Data<--">
                                                                <option></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="siepenerima_ms" class="control-label col-lg-4">Departemen Penerima</label>
                                                    <div class="col-lg-8">
                                                        <select required="" name="siepenerima_ms" id="siepenerima_ms" class="form-control select2" data-placeholder="-->Pilih Data<--">
                                                            <option></option>
                                                                            <?php foreach ($listseksi as $seksi) 
                                                                            {
                                                                                echo '  <option value="'.$seksi['seksi'].'">'.$seksi['seksi'].'</option>';
                                                                            }
                                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group row">
                                                    <label for="makeby_ms" class="control-label col-lg-4">Dibuat</label>
                                                    <div class="col-lg-8">
                                                        <select required="" name="pic_ms" id="makeby_ms" class="form-control select2" data-placeholder="-->Pilih Data<--">
                                                            <option></option>
                                                                            <?php foreach ($listorg as $org) 
                                                                            {
                                                                                echo '  <option value="'.$org['daftar_pekerja'].'">'.$org['daftar_pekerja'].'</option>';
                                                                            }
                                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="date_distribusi_ms" class="control-label col-lg-4">Tgl. Distribusi</label>
                                                    <div class="col-lg-8">
                                                      <input type="text" required="" name="date_distribusi" id="date_distribusi_ms" onclick="datepsfunction()" class="form-control date_pengSistem" data-inputmask="'alias': 'dd-mm-yyyy'">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="perihal_ms" class="control-label col-lg-4">Perihal</label>
                                                    <div class="col-lg-8">
                                                        <textarea required=""name="perihal_ms" id="perihal_ms" placeholder="Input Judul Dok." class="form-control"></textarea>    
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="perihal_ms" class="control-label col-lg-4">Preview Number</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="a" id="a_number" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="row text-right">
                                                <a href="javascript:history.back(1)" class="btn btn-primary btn-rect">Back</a>
                                                &nbsp;&nbsp;
                                                <button type="button" onclick="notif_input_memo()" data-toggle="modal" data-target="#modal-default" class="btn btn-primary btn-rect">Save Data</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/.modal -->
                                    <div class="modal fade" id="modal-default">
                                        <div class="modal-dialog" style="width: fit-content">
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
                                                                    <td class="ams"></td>
                                                                    <td class="bms"></td>
                                                                    <td class="cms"></td>
                                                                    <td class="dms"></td>
                                                                    <td class="ems"></td>
                                                                    <td class="fms"></td>
                                                                    <td class="gms"></td>
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
                            <!-- </div> -->
                          </form>
                          <div class="box box-primary ">
                            <div class="box-header with-border">
                              <h4 style="font-weight:bold;"><i class="fa fa-files-o"></i> Monitoring Surat/Memo Sie Pengembangan Sistem</h4>
                            </div>
                            <div class="box-body">
                              <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover text-left " id="dataTables-PengSistem" style="font-size:12px;">
                                  <thead>
                                    <tr class="bg-info">
                                        <th style="max-width:1px;">No.</th>
                                        <th style="max-width:10px;">Tanggal Dibuat</th>
                                        <th style="max-width:15px;">No. Surat / Memo</th>
                                        <th style="max-width:10px;">Ditujukan</th>
                                        <th style="max-width:20px;">Seksi / Departemen</th>
                                        <th style="max-width:10px;">Dibuat</th>
                                        <th style="max-width:10px;">Tgl. Distribusi</th>
                                        <th style="max-width:30px; width: 80px">Perihal</th>
                                        <th style="max-width:10px;">File</th>
                                        <th style="max-width:30px; width:70px;">Action</th>
                                    </tr>
                                  </thead>
                                      <tbody>
                                    <?php $no= 1; foreach ($listdata_memo as $row) { ?>
                                        <tr row-id="<?php echo $row['id']?>">
                                        <td><b><?php echo $no++; ?></b></td>
                                        <td><?php echo $row["date_doc"];?></td>
                                        <td style="font-weight: bold;"><?php echo $row["number_memo"];?></td>
                                        <td><?php echo $row["for_doc"];?></td>
                                        <td><?php echo $row["seksi_depart"];?></td>
                                        <td><?php echo $row["pic_doc"];?></td>
                                        <td><?php echo $row["date_distribusion"];?></td>
                                        <td><?php echo $row["perihal_doc"];?></td>
                                        <td><a data-toggle="tooltip" title="<?= $row['file'];?>" href="<?php echo base_url('assets/upload/PengembanganSistem/memo').'/'.$row['file'];?>" target="_blank"><?php if ($row['file'] != "" ) {echo '<i class="far fa-file-pdf"> View</i>'; } ?></a>
                                        </td>
                                        <td>
                                        <div <?php if(strlen($row['file']) !== 0){echo 'hidden=""';} ?> >
                                            <div class="btn-group">
                                            <a class="btn btn-success" style="padding: 6px;" href="<?php echo base_url('PengembanganSistem/edit_memo/'.$row['id'])?>" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-warning" style="padding: 6px;" data-toggle="modal" data-toggle="tooltip" data-target="<?php echo "#modal_edit".$row['id'];?>" title="Upload"><i class="fa fa-cloud-upload"></i></a>
                                            <a class="btn btn-danger" style="padding: 6px;" href="<?php echo base_url('PengembanganSistem/delete_code/'.$row['id'])?>" title="Delete" onclick="return confirm('Anda Yakin Dengan Langkah Pilihan Anda ?')"><i class="fa fa-close"></i></a>
                                            </div>
                                        </div>
                                        </td>
                                            <div class="modal fade" id="<?php echo "modal_edit".$row['id'];?>" role="dialog" aria-labelledby="largeModal" aria-hidden="true" align="center">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" align="left">Upload File :</h4>
                                                </div>
                                                <form class="form-validate form-horizontal" enctype="multipart/form-data" method="post" enctype="multipart/form-data">
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label class="control-label col-xs-3" >File : </label>
                                                            <div class="col-xs-8">
                                                                <input id="file_ps_<?php echo $row['id'];?>" name="file_ps" class="form-control" type="file">
                                                            </div>
                                                        </div>

                                                        <div style="display:none;" class="form-group">
                                                            <label class="control-label col-xs-3" >File Name : </label>
                                                            <div class="col-xs-8">
                                                                <input disabled="" id="file_name_<?php echo $row['id'];?>" class="form-control" name="file_name" value="<?=$row["perihal_doc"]; ?>">
                                                            </div>
                                                        </div>
                                                            
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                        <button type="button" onclick="upload_file_memo(<?php echo $row['id'];?>)" data-id="<?php echo $row['id']?>" class="btn btn-info"><i class="fa fa-upload"> Upload</i></button>
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