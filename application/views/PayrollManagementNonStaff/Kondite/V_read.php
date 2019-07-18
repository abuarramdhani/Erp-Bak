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
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Kondite/');?>">
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
                                <div class="box-header with-border">Read Kondite</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table" style="border: 0px !Important;">
                                                    <?php foreach ($Kondite as $headerRow): ?>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Noind</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['noind']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Kodesie</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['kodesie']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Tanggal</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['tanggal']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>MK</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['mk']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>BKI</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['bki']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>BKP</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['bkp']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>TKP</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['tkp']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>KB</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['kb']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>KK</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['kk']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>KS</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['ks']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Approval</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['approval']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Approve Date</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['approve_date']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Approved By</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['approved_by']; ?></td>
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