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
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/MasterData/DataGaji/');?>">
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
                                <div class="box-header with-border">Read Master Gaji</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table" style="border: 0px !Important;">
                                                    <?php foreach ($MasterGaji as $headerRow): ?>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Noind</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['noind'].' - '.$headerRow['employee_name']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Kodesie</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['kodesie'].' - '.$headerRow['unit_name']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Kelas</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['kelas']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Gaji Pokok</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['gaji_pokok']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Insentif Prestasi</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['insentif_prestasi']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Insentif Masuk Sore</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['insentif_masuk_sore']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Insentif Masuk Malam</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['insentif_masuk_malam']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Ubt</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['ubt']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Upamk</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['upamk']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Bank Code</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['bank_code']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Status Pajak</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['status_pajak']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Tanggungan Pajak</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['tanggungan_pajak']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Ptkp</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['ptkp']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Bulan Kerja</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['bulan_kerja']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Kpph</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['kpph']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Potongan Dplk</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['potongan_dplk']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Potongan Spsi</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['potongan_spsi']; ?></td>
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