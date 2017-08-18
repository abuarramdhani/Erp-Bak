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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('WasteManagement/Limbah');?>">
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
                                <a href="<?php echo site_url('WasteManagement/Limbah/create/') ?>" style="float:right;margin-right:1%;margin-top:0px;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblLimbah" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
												<th>Tanggal Kirim</th>
												<th>Seksi Pengirim</th>
												<th>Nama Pengirim</th>
												<th>Nama Limbah</th>
												<th>Nomor Limbah</th>
												<th>Jenis Limbah</th>
												<th>Karakteristik Limbah</th>
												<th>Kondisi Limbah</th>
												<th>Temuan Kemasan</th>
                                                <th>Temuan Kemasan Status</th>
												<th>Temuan Kebocoran</th>
                                                <th>Temuan Kebocoran Status</th>
												<th>Temuan Level Limbah</th>
                                                <th>Temuan Level Limbah Status</th>
												<th>Temuan Lain Lain</th>
                                                <th>Temuan Lain Lain Status</th>
												<th>Standar Foto</th>
												<th>Standar Refrensi</th>
												<th>Standar Kemasan</th>
												<th>Standar Kebocoran</th>
												<th>Standar Lain Lain</th>
												<th>Catatan Saran</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            	$no = 1; 
                                            	foreach($Limbah as $row):
                                            	$encrypted_string = $this->encrypt->encode($row['limbah_id']);
												$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center'>
                                                	<a style="margin-right:4px" href="<?php echo base_url('WasteManagement/Limbah/read/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
                                                	<a style="margin-right:4px" href="<?php echo base_url('WasteManagement/Limbah/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                	<a href="<?php echo base_url('WasteManagement/Limbah/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
												<td><?php echo date('d M Y', strtotime($row['tanggal_kirim'])) ;?></td>
												<td><?php echo $row['seksi'] ?></td>
												<td><?php echo $row['nama_kirim'] ?></td>
												<td><?php echo $row['nama_limbah'] ?></td>
												<td><?php echo $row['nomor_limbah'] ?></td>
												<td><?php echo $row['limbahjenis'] ?></td>
												<td><?php echo $row['karakteristik_limbah'] ?></td>
												<td><a target="_blank" href="<?php echo base_url('/assets/limbah/kondisi-limbah/'.$row['kondisi_limbah']);?>"><?php echo $row['kondisi_limbah'];?></a>
                                                </td>
												<td><?php echo $row['temuan_kemasan'] ?></td>
                                                <td><?php if($row['temuan_kemasan_status']==1) {
                                                            echo "Ok";
                                                         }elseif ($row['temuan_kemasan_status']==0) {
                                                            echo "Not Ok"; } ?>
                                                </td>
												<td><?php echo $row['temuan_kebocoran'] ?></td>
                                                <td><?php if($row['temuan_kebocoran_status']==1) {
                                                            echo "Ok";
                                                         }elseif ($row['temuan_kebocoran_status']==0) {
                                                            echo "Not Ok"; } ?>   
                                                </td>
												<td><?php echo $row['temuan_level_limbah'] ?></td>
                                                <td><?php if($row['temuan_level_limbah_status']==1) {
                                                            echo "Ok";
                                                         }elseif ($row['temuan_level_limbah_status']==0) {
                                                            echo "Not Ok"; } ?>      
                                                </td>
												<td><?php echo $row['temuan_lain_lain'] ?></td>
                                                <td><?php if($row['temuan_lain_lain_status']==1) {
                                                            echo "Ok";
                                                         }elseif ($row['temuan_lain_lain_status']==0) {
                                                            echo "Not Ok"; } ?>    
                                                </td>
												<td><a target="_blank" href="<?php echo base_url('/assets/limbah/standar-foto/'.$row['standar_foto']);?>"><?php echo $row['standar_foto'];?></a>
                                                </td>
												<td><?php if(strlen($row['standar_refrensi'])<50) {
                                                              echo $row['standar_refrensi'];  
                                                    }else{
                                                             echo substr($row['standar_refrensi'], 0, 50).'.......</br>[<a href="'.site_url('WasteManagement/Limbah/read/'.$encrypted_string.'').'">Read More</a> ] </hr>';    
                                                    } ?></td>
                                                <td><?php echo $row['standar_kemasan'] ?></td>
												<td><?php echo $row['standar_kebocoran'] ?></td>
												<td><?php echo $row['standar_lain_lain'] ?></td>
												<td><?php if(strlen($row['catatan_saran'])<50) {
                                                              echo $row['catatan_saran'];  
                                                    }else{
                                                             echo substr($row['catatan_saran'], 0, 50).'.....</br>[<a href="'.site_url('WasteManagement/Limbah/read/'.$encrypted_string.'').'">Read More</a> ] </hr>';    
                                                    } ?></td>
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
