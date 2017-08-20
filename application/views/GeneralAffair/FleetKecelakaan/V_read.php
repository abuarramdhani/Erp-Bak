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
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/FleetKecelakaan/');?>">
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
                                <div class="box-header with-border">Read Fleet Kecelakaan</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table" style="border: 0px !Important;">
                                                    <?php foreach ($FleetKecelakaan as $headerRow): ?>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Kendaraan Id</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['kendaraan_id']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Tanggal Kecelakaan</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['tanggal_kecelakaan']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Sebab</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['sebab']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Biaya Perusahaan</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['biaya_perusahaan']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Biaya Pekerja</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['biaya_pekerja']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Pekerja</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['pekerja']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Start Date</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['start_date']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>End Date</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['end_date']; ?></td>
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
														<li class="active"><a href="#lines_view_ga_fleet_kecelakaan_detail" data-toggle="tab">Fleet Kecelakaan Detail</a></li>
													</ul>
                                                    <div class="tab-content">
														<div class="tab-pane active" id="lines_view_ga_fleet_kecelakaan_detail">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">Lines of Fleet Kecelakaan Detail</div>
                                                                    <div class="panel-body">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-striped table-bordered table-hover" style="font-size:12px;">
                                                                                <thead>
                                                                                    <tr class="bg-primary">
                                                                                        <th style="text-align:center; width:30px">No</th>
																						<th style="text-align:center;">Kerusakan</th>
																						<th style="text-align:center;">Start Date</th>
																						<th style="text-align:center;">End Date</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php $no = 1; foreach($FleetKecelakaanDetail as $lines1_row): ?>
                                                                                    <tr>
                                                                                        <td style="text-align:center; width:30px"><?php echo $no++;?></td>
																						<td><?php echo $lines1_row['kerusakan']; ?></td>
																						<td><?php echo $lines1_row['start_date']; ?></td>
																						<td><?php echo $lines1_row['end_date']; ?></td>
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