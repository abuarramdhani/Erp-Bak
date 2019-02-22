<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/FleetPajak/');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <br />
                                    </a>                             
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Read Pajak</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table" style="border: 0px !Important;">
                                                    <?php foreach ($FleetPajak as $headerRow): ?>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Kendaraan</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['nomor_polisi']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Tanggal Pajak</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['tanggal_pajak']; ?></td>                                                   
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Periode Pajak</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['periode_pajak']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Biaya</strong></td>
                                                            <td style="border: 0">: Rp<?php echo number_format($headerRow['biaya'],0,",","."); ?></td>
                                                        </tr>
                                                        <?php
                                                          if($headerRow['waktu_dihapus']=='12-12-9999 00:00:00')
                                                          {
                                                            echo '  <tr>
                                                                        <td class="col-lg-2" style="border: 0"><strong>Waktu Dibuat</strong></td>
                                                                        <td style="border: 0">: '.$headerRow['waktu_dibuat'].'</td>
                                                                    </tr>';
                                                          }
                                                          else
                                                          {
                                                            echo '  <tr>
                                                                        <td class="col-lg-2" style="border: 0"><strong>Waktu Dibuat</strong></td>
                                                                        <td style="border: 0">: '.$headerRow['waktu_dibuat'].'</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="col-lg-2" style="border: 0"><strong>Waktu Dihapus</strong></td>
                                                                        <td style="border: 0">: '.$headerRow['waktu_dihapus'].'</td>
                                                                    </tr>';
                                                          }
                                                        ?>                                                        
													<?php endforeach; ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <br />
                                            <br />
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
													</ul>
                                                    <div class="tab-content">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div align="right">
                                            <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>