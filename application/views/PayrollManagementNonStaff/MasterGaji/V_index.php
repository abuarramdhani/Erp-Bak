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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/MasterData/DataGaji');?>">
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
                                <a href="<?php echo site_url('PayrollManagementNonStaff/MasterData/DataGaji/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add Data" title="Add Data" data-toggle="tooltip" data-placement="left" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                                <a href="<?php echo site_url('PayrollManagementNonStaff/MasterData/DataGaji/import_data/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Import Data" title="Import Data" data-toggle="tooltip" data-placement="left">
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-upload fa-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblMasterGaji" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
												<th>Noind</th>
												<th>Kodesie</th>
												<th>Kelas</th>
												<th>Gaji Pokok</th>
												<th>Insentif Prestasi</th>
												<th>Insentif Masuk Sore</th>
												<th>Insentif Masuk Malam</th>
												<th>Ubt</th>
												<th>Upamk</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            	$no = 1; 
                                            	foreach($MasterGaji as $row):
                                            	$encrypted_string = $this->encrypt->encode($row['master_gaji_id']);
												$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center'>
                                                	<a style="margin-right:4px" href="<?php echo base_url('PayrollManagementNonStaff/MasterData/DataGaji/read/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
                                                	<a style="margin-right:4px" href="<?php echo base_url('PayrollManagementNonStaff/MasterData/DataGaji/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                	<a href="<?php echo base_url('PayrollManagementNonStaff/MasterData/DataGaji/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
												<td><?php echo $row['noind'] ?></td>
												<td><?php echo $row['kodesie'] ?></td>
												<td><?php echo $row['kelas'] ?></td>
												<td><?php echo $row['gaji_pokok'] ?></td>
												<td><?php echo $row['insentif_prestasi'] ?></td>
												<td><?php echo $row['insentif_masuk_sore'] ?></td>
												<td><?php echo $row['insentif_masuk_malam'] ?></td>
												<td><?php echo $row['ubt'] ?></td>
												<td><?php echo $row['upamk'] ?></td>
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