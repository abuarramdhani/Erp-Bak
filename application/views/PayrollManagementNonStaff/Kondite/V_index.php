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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Kondite');?>">
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
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Kondite/create/seksi') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" class="btn btn-default btn-sm" alt="Input Per Seksi" title="Input Per Seksi" data-toggle="tooltip" data-placement="left" >
                                    <i class="fa fa-users fa-2x"></i>
                                </a>
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Kondite/create/pekerja') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" class="btn btn-default btn-sm" alt="Input Per Pekerja" title="Input Per Pekerja" data-toggle="tooltip" data-placement="left" >
                                    <i class="fa fa-user-plus fa-2x"></i>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblKondite" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
												<th>Noind</th>
												<th>Kodesie</th>
												<th>Tanggal</th>
												<th>MK</th>
												<th>BKI</th>
												<th>BKP</th>
												<th>TKP</th>
												<th>KB</th>
												<th>KK</th>
												<th>KS</th>
												<th>Approval</th>
												<th>Approve Date</th>
												<th>Approved By</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            	$no = 1; 
                                            	foreach($Kondite as $row):
                                            	$encrypted_string = $this->encrypt->encode($row['kondite_id']);
												$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center'>
                                                	<a style="margin-right:4px" href="<?php echo base_url('PayrollManagementNonStaff/ProsesGaji/Kondite/read/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
                                                	<a style="margin-right:4px" href="<?php echo base_url('PayrollManagementNonStaff/ProsesGaji/Kondite/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                	<a href="<?php echo base_url('PayrollManagementNonStaff/ProsesGaji/Kondite/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
												<td><?php echo $row['noind'] ?></td>
												<td><?php echo $row['kodesie'] ?></td>
												<td><?php echo $row['tanggal'] ?></td>
												<td><?php echo $row['MK'] ?></td>
												<td><?php echo $row['BKI'] ?></td>
												<td><?php echo $row['BKP'] ?></td>
												<td><?php echo $row['TKP'] ?></td>
												<td><?php echo $row['KB'] ?></td>
												<td><?php echo $row['KK'] ?></td>
												<td><?php echo $row['KS'] ?></td>
												<td><?php echo $row['approval'] ?></td>
												<td><?php echo $row['approve_date'] ?></td>
												<td><?php echo $row['approved_by'] ?></td>
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