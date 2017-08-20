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
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/FleetKendaraan/');?>">
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
                                <div class="box-header with-border">Read Fleet Kendaraan</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table" style="border: 0px !Important;">
<<<<<<< HEAD
                                                    <?php foreach ($FleetKendaraan as $headerRow): ?>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Nomor Polisi</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['nomor_polisi']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Jenis Kendaraan Id</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['jenis_kendaraan_id']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Merk Kendaraan Id</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['merk_kendaraan_id']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Warna Kendaraan Id</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['warna_kendaraan_id']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Tahun Pembuatan</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['tahun_pembuatan']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Foto Stnk</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['foto_stnk']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Foto Bpkb</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['foto_bpkb']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Foto Kendaraan</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['foto_kendaraan']; ?></td>
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
                                                    <?php foreach ($FleetKendaraan as $headerRow): ?>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Nomor Polisi</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['nomor_polisi']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Jenis Kendaraan Id</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['jenis_kendaraan_id']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Merk Kendaraan Id</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['merk_kendaraan_id']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Warna Kendaraan Id</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['warna_kendaraan_id']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Tahun Pembuatan</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['tahun_pembuatan']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Foto Stnk</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['foto_stnk']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Foto Bpkb</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['foto_bpkb']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Foto Kendaraan</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['foto_kendaraan']; ?></td>
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