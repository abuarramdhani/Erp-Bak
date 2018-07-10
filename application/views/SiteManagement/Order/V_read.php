<section class="content">
    <div class="inner" >
        <div class="row">
            <?php foreach ($header as $headerRow): ?>
            <form class="form-horizontal" method="post" action="<?php echo site_url('SiteManagement/Order/SimpanKeteranganOM/'.$headerRow['id_order']);?>">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('SiteManagement');?>">
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
                                <div class="box-header with-border">Read Order Detail</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table" style="border: 0px !Important;">
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>No Order</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['no_order']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Tgl Order</strong></td>
                                                            <td style="border: 0">: <?php echo date('Y-m-d', strtotime($headerRow['tgl_order'])); ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Jenis Order</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['jenis_order']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Seksi Order</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['nama_seksi']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Due Date</strong></td>
                                                            <td style="border: 0">: <?php echo date('Y-m-d', strtotime($headerRow['due_date']));?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Tgl Terima</strong></td>
                                                            <td style="border: 0">: <?php if($headerRow['tgl_terima']==null || $headerRow['tgl_terima']==''){echo "";}else{ echo date('Y-m-d', strtotime($headerRow['tgl_terima']));}?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Status</strong></td>
                                                            <td style="border: 0">: 
                                                                <?php 
                                                                    if($headerRow['status']==0){echo "<b style='color:orange;'>New</b>";}
                                                                    elseif ($headerRow['status']==1) {echo "<b style='color:blue;'>Approve</b>";}
                                                                    elseif ($headerRow['status']==2) {echo "<b style='color:red;'>Reject by admin</b>";}
                                                                    elseif ($headerRow['status']==3) {echo "<b style='color:green;'>Done</b>";}
                                                                    elseif ($headerRow['status']==4) {echo "<b style='color:navy;'>Reject by system</b>";}
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border:0"><strong>Status Date</strong></td>
                                                            <td style="border:0">: <?php if($headerRow['status_date']==null || $headerRow['status_date']==''){echo "";}else{ echo date('Y-m-d', strtotime($headerRow['status_date']));}?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Keterangan</strong></td>
                                                            <td style="border:0"> <textarea class="form-control" style="width: 50%" name="OM_keterangan"><?php echo $headerRow['keterangan']?></textarea>
                                                            </td>
                                                        </tr>
													<?php endforeach; ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">Lines Of Order Detail</div>
                                                                <div class="panel-body">
                                                                    <table class="table table-striped table-bordered table-hover" style="font-size:12px;">
                                                                        <thead>
                                                                            <tr class="bg-primary">
                                                                                <th style="text-align:center; width:5%">No</th>
                                                                                <th style="text-align:center; width:10%">Jumlah</th>
                                                                                <th style="text-align:center; width:10%">Satuan</th>
                                                                                <th style="text-align:center; width:35%">Keterangan</th>
                                                                                <th style="text-align:center; width:35%">Lampiran</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php $no=1;foreach ($lines as $key):?>
                                                                            <tr>
                                                                                <td style="text-align:center;"><?php echo $no++;?></td>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <div class="col-lg-12">
                                                                                        <input type="text" value="<?php echo($key['jumlah']) ?>" class="form-control" readonly/>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <div class="col-lg-12">
                                                                                        <input type="text" value="<?php echo($key['satuan']) ?>" class="form-control" readonly/>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <div class="col-lg-12">
                                                                                        <input type="text" value="<?php echo($key['keterangan']) ?>" class="form-control" readonly/>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <div class="col-lg-12">
                                                                                        <input type="text" value="<?php echo($key['lampiran']) ?>" class="form-control" readonly/>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
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
                                    <div class="panel-footer">
                                        <div align="right">
                                            <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-success btn-lg btn-rect">Update</button>
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