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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/FleetKecelakaan');?>">
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
                                <a href="<?php echo site_url('GeneralAffair/FleetKecelakaan/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <?php
                                if(substr($kodesie, 0, 5)=='10103')
                                    {
                                ?>                            
                                <ul class="nav nav-pills nav-justified">
                                    <li class="active"><a data-toggle="pill" href="#active">Active</a></li>
                                    <li><a data-toggle="pill" href="#removed">Removed</a></li>
                                </ul>
                                <?php
                                    }
                                ?>                                
                                <div class="tab-content">
                                    <div id="active" class="tab-pane fade in active">
                                        <div class="table-responsive">
                                            <br/>
                                            <table class="datatable table table-striped table-bordered table-hover text-left" id="dataTables-fleetKecelakaan" style="font-size:12px;">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th style="text-align:center; width:30px">No</th>
                                                        <th style="text-align:center; min-width:80px">Action</th>
                                                        <th>Kendaraan</th>
                                                        <th>Lokasi Kerja</th>
                                                        <th>Tanggal Kecelakaan</th>
                                                        <th>Sebab</th>
                                                        <th>Biaya Perusahaan</th>
                                                        <th>Biaya Pekerja</th>
                                                        <th>Pekerja</th>
                                                        <th>Asuransi</th>
                                                        <th>Cek Asuransi</th>
                                                        <th>Masuk Bengkel</th>
                                                        <th>Keluar Bengkel</th>
                                                        <th>Waktu Dibuat</th>
                                                     </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                       $no = 1; 
                                                       foreach($FleetKecelakaan as $row):
                                                       $encrypted_string = $this->encrypt->encode($row['kode_kecelakaan']);
                                                        $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                                     ?>
                                                    <tr>
                                                        <td align='center'><?php echo $no++;?></td>
                                                        <td align='center'>
                                                           <a style="margin-right:4px" href="<?php echo base_url('GeneralAffair/FleetKecelakaan/read/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
                                                           <a style="margin-right:4px" href="<?php echo base_url('GeneralAffair/FleetKecelakaan/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                           <a href="<?php echo base_url('GeneralAffair/FleetKecelakaan/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Apakah Anda ingin menghapus data ini?');"><span class="fa fa-trash fa-2x"></span></a>
                                                        </td>
                                                        <td><?php echo $row['nomor_polisi'] ?></td>
                                                        <td><?php echo $row['lokasi'] ?></td>
                                                        <td><?php echo $row['tanggal_kecelakaan'] ?></td>
                                                        <td>    <?php 
                                                                    if(strlen($row['sebab'])>30)
                                                                    {
                                                                        echo substr($row['sebab'], 0, 29);
                                                                        echo '<br/>'.'<a target="_blank" href="'.base_url('GeneralAffair/FleetKecelakaan/read/'.$encrypted_string.'').'">Lihat lebih detail</a>';
                                                                    }
                                                                    else
                                                                    {
                                                                        echo $row['sebab'];
                                                                    } 
                                                                ?>
                                                        </td>
                                                        <td>Rp<?php echo number_format($row['biaya_perusahaan'],0,",",".") ?></td>
                                                        <td>Rp<?php echo number_format($row['biaya_pekerja'],0,",",".") ?></td>
                                                        <td><?php echo $row['pekerja'] ?></td>
                                                        <td>
                                                            <?php
                                                                $status_button = '';
                                                                if($row['status_asuransi']==1)
                                                                {
                                                                    echo 'Ya';
                                                                }
                                                                elseif($row['status_asuransi']==0)
                                                                {
                                                                    echo 'Tidak';
                                                                    $status_button = 'disabled';
                                                                }
                                                            ?>
                                                        </td>
                                                        <td><?php echo $row['tanggal_cek_asuransi'];?></td>
                                                        <td>
                                                            <?php echo $row['tanggal_masuk_bengkel'];?>
                                                            <br/>
                                                            <a href="<?php echo base_url('assets/upload/GA/Kendaraan/'.$row['foto_masuk_bengkel']);?>" target="_blank" class="btn btn-info <?php echo $status_button;?>">Lihat Foto</a>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['tanggal_keluar_bengkel'];?>
                                                            <br/>
                                                            <a href="<?php echo base_url('assets/upload/GA/Kendaraan/'.$row['foto_keluar_bengkel']);?>" target="_blank" class="btn btn-info <?php echo $status_button;?>">Lihat Foto</a>                                                            
                                                        </td>
                                                        <td><?php echo $row['waktu_dibuat'];?></td>             
                                                     </tr>
                                                    <?php endforeach; ?>
                                                </tbody>                                      
                                            </table>
                                        </div>
                                    </div>
                                    <div id="removed" class="tab-pane fade">
                                        <div class="table-responsive">
                                            <br/>
                                            <table class="datatable table table-striped table-bordered table-hover text-left" id="dataTables-fleetKecelakaanDeleted" style="font-size:12px;">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th style="text-align:center; width:30px">No</th>
                                                        <th style="text-align:center; min-width:80px">Action</th>
												        <th>Kendaraan</th>
												        <th>Tanggal Kecelakaan</th>
												        <th>Sebab</th>
												        <th>Biaya Perusahaan</th>
												        <th>Biaya Pekerja</th>
												        <th>Pekerja</th>
                                                        <th>Asuransi</th>
                                                        <th>Cek Asuransi</th>
                                                        <th>Masuk Bengkel</th>
                                                        <th>Keluar Bengkel</th>
                                                        <th>Waktu Dibuat</th>
                                                        <th>Waktu Dihapus</th>
											         </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                            	       $no = 1; 
                                            	       foreach($FleetKecelakaanDeleted as $row):
                                            	       $encrypted_string = $this->encrypt->encode($row['kode_kecelakaan']);
												        $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											         ?>
                                                    <tr>
                                                        <td align='center'><?php echo $no++;?></td>
                                                        <td align='center'>
                                                	       <a style="margin-right:4px" href="<?php echo base_url('GeneralAffair/FleetKecelakaan/read/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
                                                	       <a style="margin-right:4px" href="<?php echo base_url('GeneralAffair/FleetKecelakaan/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                        </td>
												        <td><?php echo $row['nomor_polisi'] ?></td>
												        <td><?php echo $row['tanggal_kecelakaan'] ?></td>
                                                        <td>    <?php 
                                                                    if(strlen($row['sebab'])>30)
                                                                    {
                                                                        echo substr($row['sebab'], 0, 29);
                                                                        echo '<br/>'.'<a target="_blank" href="'.base_url('GeneralAffair/FleetKecelakaan/read/'.$encrypted_string.'').'">Lihat lebih detail</a>';
                                                                    }
                                                                    else
                                                                    {
                                                                        echo $row['sebab'];
                                                                    } 
                                                                ?>
                                                        </td>
												        <td>Rp<?php echo number_format($row['biaya_perusahaan'],0,",",".") ?></td>
                                                        <td>Rp<?php echo number_format($row['biaya_pekerja'],0,",",".") ?></td>
												        <td><?php echo $row['pekerja'] ?></td>
                                                        <td>
                                                            <?php
                                                                $status_button = '';
                                                                if($row['status_asuransi']==1)
                                                                {
                                                                    echo 'Ya';
                                                                }
                                                                elseif($row['status_asuransi']==0)
                                                                {
                                                                    echo 'Tidak';
                                                                    $status_button = 'disabled';
                                                                }
                                                            ?>
                                                        </td>
                                                        <td><?php echo $row['tanggal_cek_asuransi'];?></td>
                                                        <td>
                                                            <?php echo $row['tanggal_masuk_bengkel'];?>
                                                            <br/>
                                                            <a href="<?php echo base_url('assets/upload/GA/Kendaraan/'.$row['foto_masuk_bengkel']);?>" target="_blank" class="btn btn-info <?php echo $status_button;?>">Lihat Foto</a>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['tanggal_keluar_bengkel'];?>
                                                            <br/>
                                                            <a href="<?php echo base_url('assets/upload/GA/Kendaraan/'.$row['foto_keluar_bengkel']);?>" target="_blank" class="btn btn-info <?php echo $status_button;?>">Lihat Foto</a>                                                            
                                                        </td>
                                                        <td><?php echo $row['waktu_dibuat'];?></td>
                                                        <td><?php echo $row['waktu_dihapus'];?></td>                                                      
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
        </div>
    </div>
</section>