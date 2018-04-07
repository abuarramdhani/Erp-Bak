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
                                <?php
                                if(substr($kodesie, 0, 5)=='10103')
                                    {
                                ?>                            
                                <ul class="nav nav-pills nav-justified">
                                    <li class="active"><a data-toggle="pill" href="#active">Active</a></li>
                                    <li><a data-toggle="pill" href="#disabled">Removed</a></li>
                                </ul>
                                <?php
                                    }
                                ?>


                                <div class="tab-content">
                                    <div id="active" class="tab-pane fade in active">
                                        <br/>
                                            <table class="datatable table table-striped table-bordered table-hover text-left" id="dataTables-fleetKendaraan" style="font-size:12px;">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th style="text-align:center; width:30px">No</th>
                                                        <th style="text-align:center; min-width:80px">Action</th>
                                                        <th>Nomor Polisi</th>
                                                        <th>Jenis Kendaraan</th>
                                                        <th>Merk Kendaraan</th>
                                                        <th>Warna Kendaraan</th>
                                                        <th>Tahun Pembuatan</th>
                                                        <th>Foto STNK</th>
                                                        <th>Foto BPKB</th>
                                                        <th>Foto Kendaraan</th>
                                                        <th>Waktu Dibuat</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $no = 1; 
                                                        foreach($FleetKendaraan as $Kendaraan):
                                                        $encrypted_string = $this->encrypt->encode($Kendaraan['kode_kendaraan']);
                                                        $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                                    ?>
                                                    <tr>
                                                        <td align='center'><?php echo $no++;?></td>
                                                        <td align='center'>
                                                            <a style="margin-right:4px" href="<?php echo base_url('GeneralAffair/FleetKendaraan/read/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
                                                            <a style="margin-right:4px" href="<?php echo base_url('GeneralAffair/FleetKendaraan/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                            <a href="<?php echo base_url('GeneralAffair/FleetKendaraan/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Apakah Anda ingin menghapus kendaraan ini?');"><span class="fa fa-trash fa-2x"></span></a>
                                                        </td>
                                                        <td><?php echo $Kendaraan['nomor_polisi'] ?></td>
                                                        <td><?php echo $Kendaraan['jenis_kendaraan'] ?></td>
                                                        <td><?php echo $Kendaraan['merk_kendaraan'] ?></td>
                                                        <td><?php echo $Kendaraan['warna_kendaraan'] ?></td>
                                                        <td><?php echo $Kendaraan['tahun_pembuatan'] ?></td>
                                                        <td><a href="<?php echo base_url('assets/upload/GA/Kendaraan/'.$Kendaraan['foto_stnk']);?>" target="_blank" class="btn btn-info">Lihat Foto</a></td>
                                                        <td><a href="<?php echo base_url('assets/upload/GA/Kendaraan/'.$Kendaraan['foto_bpkb']);?>" target="_blank" class="btn btn-info">Lihat Foto</a></td>
                                                        <td><a href="<?php echo base_url('assets/upload/GA/Kendaraan/'.$Kendaraan['foto_kendaraan']);?>" target="_blank" class="btn btn-info">Lihat Foto</a></td>
                                                        <td><?php echo $Kendaraan['waktu_dibuat'];?></td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>                                      
                                            </table>
                                        
                                </div>
                                    <div id="disabled" class="tab-pane fade">
                                        <br/>
                                        <div class="table-responsive">
                                            <table class="datatable table table-striped table-bordered table-hover text-left" id="dataTables-fleetKendaraanDeleted" style="font-size:12px;">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th style="text-align:center; width:30px">No</th>
                                                        <th style="text-align:center; min-width:80px">Action</th>
												        <th>Nomor Polisi</th>
												        <th>Jenis Kendaraan</th>
												        <th>Merk Kendaraan</th>
												        <th>Warna Kendaraan</th>
												        <th>Tahun Pembuatan</th>
												        <th>Foto STNK</th>
												        <th>Foto BPKB</th>
												        <th>Foto Kendaraan</th>
												        <th>Waktu Dibuat</th>
                                                        <th>Waktu Dihapus</th>
											         </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                            	       $no = 1; 
                                            	       foreach($FleetKendaraanDeleted as $KendaraanDeleted):
                                            	       $encrypted_string = $this->encrypt->encode($KendaraanDeleted['kode_kendaraan']);
												        $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											         ?>
                                                    <tr>
                                                        <td align='center'><?php echo $no++;?></td>
                                                        <td align='center'>
                                                	       <a style="margin-right:4px" href="<?php echo base_url('GeneralAffair/FleetKendaraan/read/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
                                                	       <a style="margin-right:4px" href="<?php echo base_url('GeneralAffair/FleetKendaraan/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                	       <!-- <a href="<?php echo base_url('GeneralAffair/FleetKendaraan/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Apakah Anda ingin menghapus data ini?');"><span class="fa fa-trash fa-2x"></span></a> -->
                                                        </td>
												        <td><?php echo $KendaraanDeleted['nomor_polisi'] ?></td>
												        <td><?php echo $KendaraanDeleted['jenis_kendaraan'] ?></td>
												        <td><?php echo $KendaraanDeleted['merk_kendaraan'] ?></td>
												        <td><?php echo $KendaraanDeleted['warna_kendaraan'] ?></td>
												        <td><?php echo $KendaraanDeleted['tahun_pembuatan'] ?></td>
												        <td><a href="<?php echo base_url('assets/upload/GA/Kendaraan/'.$KendaraanDeleted['foto_stnk']);?>" target="_blank" class="btn btn-info">Lihat Foto</a></td>
												        <td><a href="<?php echo base_url('assets/upload/GA/Kendaraan/'.$KendaraanDeleted['foto_bpkb']);?>" target="_blank" class="btn btn-info">Lihat Foto</a></td>
												        <td><a href="<?php echo base_url('assets/upload/GA/Kendaraan/'.$KendaraanDeleted['foto_kendaraan']);?>" target="_blank" class="btn btn-info">Lihat Foto</a></td>
                                                        <td><?php echo $KendaraanDeleted['waktu_dibuat'];?></td>
                                                        <td><?php echo $KendaraanDeleted['waktu_dihapus'];?></td>
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