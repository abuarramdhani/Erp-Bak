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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Potongan');?>">
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
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Potongan/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblPotongan" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
												<th>Noind</th>
												<th>Bulan Gaji</th>
												<th>Tahun Gaji</th>
												<th>Pot Lebih Bayar</th>
												<th>Pot Gp</th>
												<th>Pot Dl</th>
												<th>Pot Spsi</th>
												<th>Pot Duka</th>
												<th>Pot Koperasi</th>
												<th>Pot Hutang Lain</th>
												<th>Pot Dplk</th>
												<th>Pot Thp</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            	$no = 1; 
                                            	foreach($Potongan as $row):
                                            	$encrypted_string = $this->encrypt->encode($row['potongan_id']);
												$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center'>
                                                	<a style="margin-right:4px" href="<?php echo base_url('PayrollManagementNonStaff/ProsesGaji/Potongan/read/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
                                                	<a style="margin-right:4px" href="<?php echo base_url('PayrollManagementNonStaff/ProsesGaji/Potongan/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                	<a href="<?php echo base_url('PayrollManagementNonStaff/ProsesGaji/Potongan/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
												<td><?php echo $row['noind'] ?></td>
												<td><?php echo $row['bulan_gaji'] ?></td>
												<td><?php echo $row['tahun_gaji'] ?></td>
												<td><?php echo $row['pot_lebih_bayar'] ?></td>
												<td><?php echo $row['pot_gp'] ?></td>
												<td><?php echo $row['pot_dl'] ?></td>
												<td><?php echo $row['pot_spsi'] ?></td>
												<td><?php echo $row['pot_duka'] ?></td>
												<td><?php echo $row['pot_koperasi'] ?></td>
												<td><?php echo $row['pot_hutang_lain'] ?></td>
												<td><?php echo $row['pot_dplk'] ?></td>
												<td><?php echo $row['pot_thp'] ?></td>
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