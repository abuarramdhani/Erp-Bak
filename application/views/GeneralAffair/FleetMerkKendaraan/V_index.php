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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/FleetMerkKendaraan');?>">
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
                                <a href="<?php echo site_url('GeneralAffair/FleetMerkKendaraan/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
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
                                        <br/>
                                        <div class="table-responsive">
                                            <table class="datatable table table-striped table-bordered table-hover text-left" id="dataTables-fleetMerkKendaraan" style="font-size:12px;">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th style="text-align:center; width:30px">No</th>
                                                        <th style="text-align:center; min-width:80px">Action</th>
                                                        <th>Model Kendaraan</th>
                                                        <th>Jenis Bahan Bakar</th>
                                                        <th>Rasio Penggunaan BBM</th>
                                                        <th>Kapasitas Bahan Bakar</th>
                                                        <th>Waktu Dibuat</th>
                                                     </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                       $no = 1; 
                                                       foreach($FleetMerkKendaraan as $row):
                                                       $encrypted_string = $this->encrypt->encode($row['kode_merk_kendaraan']);
                                                        $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                                     ?>   
                                                    <tr>
                                                        <td align='center'><?php echo $no++;?></td>
                                                        <td align='center'>
                                                           <a style="margin-right:4px" href="<?php echo base_url('GeneralAffair/FleetMerkKendaraan/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                           <a href="<?php echo base_url('GeneralAffair/FleetMerkKendaraan/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                        </td>
                                                        <td><?php echo $row['merk_kendaraan'] ?></td>
                                                        <td><?php echo $row['jenis_bahanbakar'] ?></td>
                                                        <td><?php if ($row['rasio_bahanbakar'] == ""){
                                                                        echo "";
                                                                }else{
                                                                    $liter = substr($row['rasio_bahanbakar'], 0,1);
                                                                    echo $liter." : "; 
                                                                    $jarak = substr($row['rasio_bahanbakar'], 1);
                                                                    echo $jarak." Km";
                                                                }  ?></td>
                                                        <td><?php echo $row['kapasitas_bahanbakar']." liter"; ?></td>
                                                        <td><?php echo $row['waktu_dibuat'] ?></td>
                                                 </tr>
                                                    <?php endforeach; ?>
                                                </tbody>                                      
                                            </table>
                                        </div>
                                    </div>
                                    <div id="removed" class="tab-pane fade">
                                        <br/>
                                        <div class="table-responsive">
                                            <table class="datatable table table-striped table-bordered table-hover text-left" id="dataTables-fleetMerkKendaraanDeleted" style="font-size:12px;">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th style="text-align:center; width:30px">No</th>
                                                        <th style="text-align:center; min-width:80px">Action</th>
												        <th>Model Kendaraan</th>
                                                        <th>Jenis Bahan Bakar</th>
                                                        <th>Rasio Penggunaan BBM</th>
                                                        <th>Kapasitas Bahan Bakar</th>
												        <th>Waktu Dibuat</th>
                                                        <th>Waktu Dihapus</th>
											         </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                            	       $no = 1; 
                                            	       foreach($FleetMerkKendaraanDeleted as $row):
                                            	       $encrypted_string = $this->encrypt->encode($row['kode_merk_kendaraan']);
												        $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											         ?>   
                                                    <tr>
                                                        <td align='center'><?php echo $no++;?></td>
                                                        <td align='center'>
                                                	       <a style="margin-right:4px" href="<?php echo base_url('GeneralAffair/FleetMerkKendaraan/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                        </td>
												        <td><?php echo $row['merk_kendaraan'] ?></td>
                                                        <td><?php echo $row['jenis_bahanbakar'] ?></td>
                                                        <td><?php if ($row['rasio_bahanbakar'] == ""){
                                                                        echo "";
                                                                }else{
                                                                    $liter = substr($row['rasio_bahanbakar'], 0,1);
                                                                    echo $liter." : "; 
                                                                    $jarak = substr($row['rasio_bahanbakar'], 1);
                                                                    echo $jarak." Km";
                                                                }  ?></td>
                                                        <td><?php echo $row['kapasitas_bahanbakar']." liter"; ?></td>
												        <td><?php echo $row['waktu_dibuat'] ?></td>
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