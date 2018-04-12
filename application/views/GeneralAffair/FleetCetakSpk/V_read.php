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
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/FleetCetakSpk/');?>">
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
                                <div class="box-header with-border">Read Fleet Cetak Spk</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table" style="border: 0px !Important;">
                                                    <?php foreach ($FleetCetakSpk as $headerRow): ?>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>No Kendaraan</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['no_pol']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Tanggal Maintenance</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['tanggal_maintenance']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Maintenance Kategori Id</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['maintenance_kategori']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Nama Bengkel</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['nama_bengkel']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>No Surat</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['no_surat']; ?></td>
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
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="lines_view_ga_fleet_maintenance_kendaraan_detail">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">Lines of Fleet Cetak SPK</div>
                                                                    <div class="panel-body">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-striped table-bordered table-hover" style="font-size:14px;">
                                                                                <thead>
                                                                                    <tr class="bg-primary">
                                                                                        <th style="text-align:center; width:30px">No</th>
                                                                                        <th style="text-align:center;">Jenis Maintenance</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php $no = 1; foreach($FleetCetakSpkDetail as $lines1_row): ?>
                                                                                    <tr>
                                                                                        <td style="text-align:center; width:30px"><?php echo $no++;?></td>
                                                                                        <td><?php echo $lines1_row['jenis_maintenance']; ?></td>
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