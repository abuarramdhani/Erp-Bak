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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/FleetMonitoring');?>">
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
                                <form method="POST" action="<?php echo site_url('GeneralAffair/FleetMonitoring/cetakExcelMonitoringKendaraanDetail');?>">
                                    <input type="hidden" name="PeriodeMonitoringDetail" id="PeriodeMonitoringDetail" value="<?php echo $tgl;?>">
                                    <button type="submit" class="btn btn-default btn-sm" style="float:right;margin-right:1%;margin-top:0%;"><i class="icon-print icon-2x"></i></button>
                                </form>  
                            </div>
                            <div class="box-body">
                                periode : <?php echo $tgl;?>
                                <div>
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="table-DetailMonitoringMK" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
												<th>Nomor Polisi</th>
												<th>Jenis Maintenance</th>
												<th>Tanggal Maintenance</th>
												<th>Biaya</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            	$no = 1; 
                                            	foreach($detailMonitoring as $row):
											?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
												<td><?php echo $row['nomor_polisi'];?></td>
												<td><?php echo $row['tanggal'];?></td>
												<td><?php echo $row['jenis_maintenance'];?></td>
												<td><?php echo $row['biaya'];?></td>
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