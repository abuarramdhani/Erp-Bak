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
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Potongan/');?>">
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
                                <div class="box-header with-border">Read Potongan</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table" style="border: 0px !Important;">
                                                    <?php foreach ($Potongan as $headerRow): ?>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Noind</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['noind'].' - '.$headerRow['employee_name']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Bulan Gaji</strong></td>
                                                            <td style="border: 0">: <?php echo date("F", mktime(0, 0, 0, $headerRow['bulan_gaji'], 1)); ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Tahun Gaji</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['tahun_gaji']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Pot Lebih Bayar</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['pot_lebih_bayar']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Pot Gp</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['pot_gp']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Pot Dl</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['pot_dl']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Pot Duka</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['pot_duka']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Pot Koperasi</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['pot_koperasi']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Pot Hutang Lain</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['pot_hutang_lain']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Pot Thp</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['pot_tkp']; ?></td>
                                                        </tr>
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