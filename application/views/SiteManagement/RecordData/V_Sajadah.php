<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('SiteManagement');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
          
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h4>Record Data Pembersihan Karpet Sajadah</h4>
                            </div>
                            <div class="box-body">
                                <div>
                                    <table class="table table-striped table-bordered table-hover text-left sm_datatable" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th>Date</th>
                                                <th>Status (OK/Not OK)</th>
                                                <th>Nama PU</th>
                                                <th>Keterangan</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
											</tr>
                                        </thead>
                                        <tbody>
                                           <?php $no=1;foreach ($Sajadah as $key):
                                                    $encrypted_string = $this->encrypt->encode($key['id_jadwal']);
                                                    $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <?php if ($this->session->userdata['user']=='J1236'):?>
                                                <td><?php echo date('d F Y', strtotime($key['tanggal_jadwal']));?></td>
                                                <td align="center"><input type="checkbox" name="sm_status" <?php if($key['status']==='t') {echo "checked";} ?> data-id="<?php echo $key['id_jadwal']?>" id="sm_status" class="sm_status" value="" disabled="disabled"></td>
                                                <td><input type="text" name="sm_pic" value="<?php echo $key['pic'];?>" placeholder="input nama" class="form-control" style="width: 170px" id="sm_pic" data-id="<?php echo $key['id_jadwal']?>" readonly="readonly"></td>
                                                <td><textarea placeholder="input keterangan" class="form-control" id="sm_keterangan" data-id="<?php echo $key['id_jadwal']?>" data-id="<?php echo $key['id_jadwal']?>" readonly="readonly"><?php echo $key['keterangan']; ?></textarea></td>
                                                <td align='center'>
                                                    <a style="margin-right:4px" href="" data-toggle="tooltip" data-placement="bottom" title="Edit Data" data-type="read" id="sm-edit" data-id="<?php echo $key['id_jadwal']?>" class="fa fa-edit fa-2x"></a>
                                                    <a style="margin-right:4px" href="" data-id="<?php echo $key['id_jadwal']?>" data-toggle="tooltip" data-placement="bottom" title="Save Data" id="sm-update" class="hidden"><span class="fa fa-save fa-2x"></span></a>
                                                    <a style="margin-right:4px" href="<?php echo site_URL() ?>SiteManagement/RecordData/deleteDataSiteManagement?id=<?php echo $encrypted_string ?>&menu=Sajadah" data-toggle="tooltip" data-placement="bottom" title="Delete Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
                                                <?php else: ?>
                                                <td><?php echo date('d F Y', strtotime($key['tanggal_jadwal']));?></td>
                                                <td align="center"><input type="checkbox" name="sm_status" <?php if($key['status']==='t') {echo "checked";} ?> data-id="<?php echo $key['id_jadwal']?>" id="sm_status" class="sm_status" value="" <?php if($key['status']==='t' || $key['pic']!=null || $key['keterangan']!=null) {echo "disabled";}?>></td>
                                                <td><input type="text" name="sm_pic" value="<?php echo $key['pic'];?>" placeholder="input nama" class="form-control" style="width: 170px" id="sm_pic" data-id="<?php echo $key['id_jadwal']?>" <?php if($key['status']==='t' || $key['pic']!=null || $key['keterangan']!=null) {echo "readonly";} ?>></td>
                                                <td><textarea placeholder="input keterangan" class="form-control" id="sm_keterangan" data-id="<?php echo $key['id_jadwal']?>" data-id="<?php echo $key['id_jadwal']?>" <?php if($key['status']==='t' || $key['pic']!=null || $key['keterangan']!=null) {echo "readonly";} ?> ><?php echo $key['keterangan']; ?></textarea></td>
                                                <td align="center">
                                                    <a style="margin-right:4px" href="" data-id="<?php echo $key['id_jadwal']?>" data-toggle="tooltip" data-placement="bottom" title="Simpan Data" class="fa fa-save fa-2x" id="SaveDataSM"></a>
                                                <?php endif; ?>
                                                </td>
                                            </tr>
                                           <?php endforeach; ?>
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
