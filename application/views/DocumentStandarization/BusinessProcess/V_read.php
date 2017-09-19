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
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('DocumentStandarization/BP/');?>">
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
                                <div class="box-header with-border">Read Business Process</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table" style="border: 0px !Important;">
                                                    <?php foreach ($BusinessProcess as $headerRow): ?>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Bp Name</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['bp_name']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Bp File</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['bp_file']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>No Kontrol</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['no_kontrol']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>No Revisi</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['no_revisi']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Tanggal</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['tanggal']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Dibuat</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['dibuat']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Diperiksa 1</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['diperiksa_1']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Diperiksa 2</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['diperiksa_2']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Diputuskan</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['diputuskan']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Jml Halaman</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['jml_halaman']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Bp Info</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['bp_info']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Tgl Upload</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['tgl_upload']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Tgl Insert</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['tgl_insert']; ?></td>
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