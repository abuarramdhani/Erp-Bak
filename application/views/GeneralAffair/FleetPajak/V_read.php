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
                                <div class="box-header with-border">Read Fleet Pajak</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table" style="border: 0px !Important;">
<<<<<<< HEAD
                                                    <?php foreach ($FleetPajak as $headerRow): ?>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Kendaraan Id</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['kendaraan_id']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Periode Awal Pajak</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['periode_awal_pajak']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Periode Akhir Pajak</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['periode_akhir_pajak']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Biaya</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['biaya']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Start Date</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['start_date']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>End Date</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['end_date']; ?></td>
                                                        </tr>
=======
                                                    <?php foreach ($FleetPajak as $headerRow): ?>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Kendaraan Id</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['kendaraan_id']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Periode Awal Pajak</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['periode_awal_pajak']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Periode Akhir Pajak</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['periode_akhir_pajak']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Biaya</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['biaya']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Start Date</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['start_date']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>End Date</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['end_date']; ?></td>
                                                        </tr>
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc
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