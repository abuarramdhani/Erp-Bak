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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/MasterData/TargetBenda');?>">
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
                                <a href="<?php echo site_url('PayrollManagementNonStaff/MasterData/TargetBenda/create/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New Data" title="Add New Data" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                                <a href="<?php echo site_url('PayrollManagementNonStaff/MasterData/TargetBenda/import_data/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Import Data" title="Import Data" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-upload fa-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblTargetBenda" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
												<th>Kodesie</th>
												<th>Kode Barang</th>
												<th>Nama Barang</th>
												<th>Kode Proses</th>
												<th>Nama Proses</th>
												<th>Jumlah Operator</th>
												<th>Target Utama</th>
												<th>Target Sementara</th>
												<th>Waktu Setting</th>
												<th>Tgl Berlaku</th>
												<th>Tgl Input</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            	$no = 1; 
                                            	foreach($TargetBenda as $row):
                                            	$encrypted_string = $this->encrypt->encode($row['target_benda_id']);
												$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center'>
                                                	<a style="margin-right:4px" href="<?php echo base_url('PayrollManagementNonStaff/MasterData/TargetBenda/read/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
                                                	<a style="margin-right:4px" href="<?php echo base_url('PayrollManagementNonStaff/MasterData/TargetBenda/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                	<a href="<?php echo base_url('PayrollManagementNonStaff/MasterData/TargetBenda/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
												<td><?php echo $row['kodesie'] ?></td>
												<td><?php echo $row['kode_barang'] ?></td>
												<td><?php echo $row['nama_barang'] ?></td>
												<td><?php echo $row['kode_proses'] ?></td>
												<td><?php echo $row['nama_proses'] ?></td>
												<td><?php echo $row['jumlah_operator'] ?></td>
												<td><?php echo $row['target_utama'] ?></td>
												<td><?php echo $row['target_sementara'] ?></td>
												<td><?php echo $row['waktu_setting'] ?></td>
												<td><?php echo $row['tgl_berlaku'] ?></td>
												<td><?php echo $row['tgl_input'] ?></td>
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