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
                                <h4>Data Monitoring Site Management</h4>
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
                                                <th>Kategori</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            	$no = 1; 
                                            	foreach($rekapData as $row):
											?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td><?php echo date('d F Y', strtotime($row['tanggal_jadwal']));?></td>
                                                <td align="center"><input type="checkbox" name="sm_status" <?php if($row['status']==='t') {echo "checked";} ?> data-id="<?php echo $row['id_jadwal']?>" id="sm_status" class="sm_status" value=""></td>
                                                <td><input type="text" name="sm_pic" value="<?php echo $row['pic'];?>" placeholder="input nama" class="form-control" style="width: 170px" id="sm_pic" data-id="<?php echo $row['id_jadwal']?>"></td>
                                                <td><textarea placeholder="input keterangan" class="form-control" id="sm_keterangan" data-id="<?php echo $row['id_jadwal']?>" data-id="<?php echo $row['id_jadwal']?>"><?php echo $row['keterangan']; ?></textarea></td>
                                                <td><?php echo $row['kategori'];?></td>
                                                <td align='center'>
                                                	<a style="margin-right:4px" href="" data-id="<?php echo $row['id_jadwal']?>" data-toggle="tooltip" data-placement="bottom" title="Simpan Data" id="SaveDataSM"><span class="fa fa-save fa-2x"></span></a>
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
