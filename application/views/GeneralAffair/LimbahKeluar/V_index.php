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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/LimbahKeluar');?>">
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
                                <a href="<?php echo site_url('GeneralAffair/LimbahKeluar/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
        
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblLimbahKeluar" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
                                                <th>Jenis Limbah</th>
												<th>Tanggal Keluar</th>
												<th>Jumlah Keluar</th>
												<th>Tujuan Limbah</th>
												<th>Nomor Dok</th>
												<th>Sisa Limbah</th>
                                                <th style="text-align:center">Status</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            	$no = 1;  
                                            	foreach($data as $row):
                                            	$encrypted_string = $this->encrypt->encode($row['id_limbah_keluar']);
												$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center'>
                                                	<a style="margin-right:4px" href="<?php echo base_url('GeneralAffair/LimbahKeluar/read/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
                                                	<a style="margin-right:4px" href="<?php echo base_url('GeneralAffair/LimbahKeluar/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                	<a href="<?php echo base_url('GeneralAffair/LimbahKeluar/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
                                                <td><?php echo $row['jenis'] ?></td>
												<td><?php echo date('d M Y',strtotime($row['tanggal_keluar'])); ?></td>
												<td><?php echo $row['jumlah_keluar'] ?></td>
												<td><?php echo $row['tujuan_limbah'] ?></td>
												<td><?php echo $row['nomor_dok'] ?></td>
												<td><?php echo $row['sisa_limbah'] ?></td>
                                                <td align="center"><?php if($row['konfirmasi_status']==0) {
                                                                echo "<h4><span class='label label-warning'>Waiting</span></h4>";
                                                            }elseif ($row['konfirmasi_status']==1) {
                                                                echo "<h4><span class='label label-success'>Confirmed</span></h4>";
                                                            }elseif ($row['konfirmasi_status']==2) {
                                                                echo "<h4><span class='label label-danger'>Not Confirmed</span></h4>";
                                                            } ;?>
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