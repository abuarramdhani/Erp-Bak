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
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/FleetMonitoringServiceKendaraan');?>">
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
                                <div class="box-header with-border">Monitoring Service Kendaraan</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <form method="POST" action="<?php echo base_url('GeneralAffair/FleetMonitoringServiceKendaraan/sudahsave');?>">
                                        <button type="submit" class="btn btn-success pull-right">
                                            Sudah Service
                                        </button>
                                        <table width="100%" class="table table-stripped table-bordered" id="tbl_monitoringservice">
                                            <thead>
                                                <?php
                                                    $jumlah = count($jenisService);
                                                ?>
                                                <tr>
                                                    <th style="text-align: center;vertical-align: middle;" rowspan="2">No</th>
                                                    <th style="text-align: center;vertical-align: middle;" rowspan="2">Nomor Polisi</th>
                                                    <th style="text-align: center;vertical-align: middle;" rowspan="2">Merk Kendaraan</th>
                                                    <th style="text-align: center;vertical-align: middle;" colspan="2">Periode Service</th>
                                                    <th style="text-align: center;vertical-align: middle;" colspan="<?php echo $jumlah;?>">Status Service</th>
                                                    <th style="text-align: center;vertical-align: middle;" rowspan="2">Action</th>
                                                </tr>
                                                <tr>
                                                    
                                                    <th style="text-align: center;vertical-align: middle;">Kilometer</th>
                                                    <th style="text-align: center;vertical-align: middle;">Bulan</th>
                                                    <?php
                                                        foreach ($jenisService as $key) {
                                                            ?>
                                                                <th style="text-align: center;"><?php echo $key['jenis_service']; ?></th>
                                                            <?php
                                                        }
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $no=1;
                                                    foreach ($FleetKendaraan as $row) {
                                                        foreach ($sudahService as $sudah) {
                                                            if ($row['k_id'] == $sudah['kendaraan_id'] && $row['kilometer'] == $sudah['kilometer']) {
                                                                
                                                            }else{
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo $no; ?></td>
                                                                        <td><?php echo $row['nomor_polisi']; ?></td>
                                                                        <td><?php echo $row['merk_kendaraan']; ?></td>
                                                                        <td><input readonly size="2" maxlength="6" style="border: none;" name="kilometer[]" value="<?php echo $row['kilometer']; ?>"></input></td>
                                                                        <td><?php echo $row['bulan']; ?></td>
                                                                           <?php
                                                                               foreach ($jenisService as $key) {
                                                                                   ?>
                                                                                       <td style="text-align: center;">
                                                                                       <?php foreach ($serviceKendaraan as $ken) {
                                                                                          if ($row['id_merk'] == $ken['merk_kendaraan_id'] && $row['kilometer'] == $ken['kilometer'] && $row['bulan'] == $ken['bulan'] && $key['jenis_service_id'] == $ken['jenis_service_id']) {
                                                                                              echo $ken['service'];
                                                                                          }
                                                                                       } ?>
                                                                                       </td>
                                                                                   <?php
                                                                               }
                                                                           ?>
                                                                        <td style="text-align: center;"><input name="id[]" type="checkbox" class="checkbox" value="<?php echo $row['k_id']; ?>"></input></td>
                                                                    </tr>
                                                                <?php
                                                                $no++;
                                                            }
                                                        }
                                                        
                                                    }
                                                ?>
                                               
                                            </tbody>
                                        </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>      
        </div>
    </div>
</section>