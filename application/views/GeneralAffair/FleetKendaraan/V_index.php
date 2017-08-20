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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/FleetKendaraan');?>">
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
                                <a href="<?php echo site_url('GeneralAffair/FleetKendaraan/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblFleetKendaraan" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
<<<<<<< HEAD
                                                <th style="text-align:center; min-width:80px">Action</th>
=======
                                                <th style="text-align:center; min-width:80px">Action</th>
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc
												<th>Nomor Polisi</th>
												<th>Jenis Kendaraan Id</th>
												<th>Merk Kendaraan Id</th>
												<th>Warna Kendaraan Id</th>
												<th>Tahun Pembuatan</th>
												<th>Foto Stnk</th>
												<th>Foto Bpkb</th>
												<th>Foto Kendaraan</th>
												<th>Start Date</th>
												<th>End Date</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            	$no = 1; 
                                            	foreach($FleetKendaraan as $row):
                                            	$encrypted_string = $this->encrypt->encode($row['kendaraan_id']);
												$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center'>
                                                	<a style="margin-right:4px" href="<?php echo base_url('GeneralAffair/FleetKendaraan/read/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
                                                	<a style="margin-right:4px" href="<?php echo base_url('GeneralAffair/FleetKendaraan/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                	<a href="<?php echo base_url('GeneralAffair/FleetKendaraan/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
<<<<<<< HEAD
                                                </td>
												<td><?php echo $row['nomor_polisi'] ?></td>
												<td><?php echo $row['jenis_kendaraan_id'] ?></td>
												<td><?php echo $row['merk_kendaraan_id'] ?></td>
												<td><?php echo $row['warna_kendaraan_id'] ?></td>
												<td><?php echo $row['tahun_pembuatan'] ?></td>
												<td><?php echo $row['foto_stnk'] ?></td>
												<td><?php echo $row['foto_bpkb'] ?></td>
												<td><?php echo $row['foto_kendaraan'] ?></td>
												<td><?php echo $row['start_date'] ?></td>
												<td><?php echo $row['end_date'] ?></td>
=======
                                                </td>
												<td><?php echo $row['nomor_polisi'] ?></td>
												<td><?php echo $row['jenis_kendaraan_id'] ?></td>
												<td><?php echo $row['merk_kendaraan_id'] ?></td>
												<td><?php echo $row['warna_kendaraan_id'] ?></td>
												<td><?php echo $row['tahun_pembuatan'] ?></td>
												<td><?php echo $row['foto_stnk'] ?></td>
												<td><?php echo $row['foto_bpkb'] ?></td>
												<td><?php echo $row['foto_kendaraan'] ?></td>
												<td><?php echo $row['start_date'] ?></td>
												<td><?php echo $row['end_date'] ?></td>
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc
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