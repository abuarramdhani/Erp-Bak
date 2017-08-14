<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-md-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-md" href="<?php echo site_url('GeneralAffair/Limbah/');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <br />
                                    </a>                             
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Read Limbah Pengirim
                                </div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table" style="border: 0px !Important;">
                                                    <?php foreach ($Limbah as $headerRow): ?>
														<tr>
                                                            <td class="col-md-2" style="border: 0"><strong>Tanggal Kirim</strong></td>
                                                            <td style="border: 0">: <?php echo date('d M Y', strtotime($headerRow['tanggal_kirim'])) ;?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-md-2" style="border: 0"><strong>Seksi Pengirim</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['seksi']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-md-2" style="border: 0"><strong>Nama Pengirim</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['nama_kirim']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-md-2" style="border: 0"><strong>Nama Limbah</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['nama_limbah']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-md-2" style="border: 0"><strong>Nomor Limbah</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['nomor_limbah']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-md-2" style="border: 0"><strong>Jenis Limbah</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['limbahjenis']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-md-2" style="border: 0"><strong>Karakteristik Limbah</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['karakteristik_limbah']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-md-2" style="border: 0"><strong>Kondisi Limbah</strong></td>
                                                            <td style="border: 0">: <a target="_blank" href="<?php echo base_url('/assets/limbah/kondisi-limbah/'.$headerRow['kondisi_limbah']);?>"><?php echo $headerRow['kondisi_limbah'];?></a></td>
                                                        </tr>
														<tr>
                                                            <td class="col-md-2" style="border: 0"><strong>Temuan Kemasan</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['temuan_kemasan']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-md-2" style="border: 0"><strong>Temuan Kemasan Status</strong></td>
                                                            <td style="border: 0">: <?php if($headerRow['temuan_kemasan_status']==1)
                                                                {echo "Ok";
                                                            }elseif ($headerRow['temuan_kemasan_status']==0) {echo "Not Ok";} ;?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-md-2" style="border: 0"><strong>Temuan Kebocoran</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['temuan_kebocoran']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-md-2" style="border: 0"><strong>Temuan Kebocoran Status</strong></td>
                                                            <td style="border: 0">: <?php if($headerRow['temuan_kebocoran_status']==1) 
                                                                {echo "Ok";
                                                                }elseif ($headerRow['temuan_kebocoran_status']==0) {
                                                                   echo "Not Ok";} ;?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-md-2" style="border: 0"><strong>Temuan Level Limbah</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['temuan_level_limbah']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-md-2" style="border: 0"><strong>Temuan Level Limbah Status</strong></td>
                                                            <td style="border: 0">: <?php if($headerRow['temuan_level_limbah_status']==1) 
                                                                {echo "Ok";
                                                                }elseif ($headerRow['temuan_level_limbah_status']==0) {
                                                                    echo "Not Ok";} ;?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-md-2" style="border: 0"><strong>Temuan Lain Lain</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['temuan_lain_lain']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-md-2" style="border: 0"><strong>Temuan Lain Lain Status</strong></td>
                                                            <td style="border: 0">: <?php if($headerRow['temuan_lain_lain_status']==1) 
                                                                {echo "Ok";
                                                                }elseif ($headerRow['temuan_lain_lain_status']==0) {
                                                                echo "Not Ok";} ;?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-md-2" style="border: 0"><strong>Standar Foto</strong></td>
                                                            <td style="border: 0">: <a target="_blank" href="<?php echo base_url('/assets/limbah/standar-foto/'.$headerRow['standar_foto']);?>"><?php echo $headerRow['standar_foto'];?></a></td>
                                                        </tr>
														<tr>
                                                            <td class="col-md-2" style="border: 0"><strong>Standar Refrensi</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['standar_refrensi']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-md-2" style="border: 0"><strong>Standar Kemasan</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['standar_kemasan']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-md-2" style="border: 0"><strong>Standar Kebocoran</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['standar_kebocoran']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-md-2" style="border: 0"><strong>Standar Lain Lain</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['standar_lain_lain']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-md-2" style="border: 0"><strong>Catatan Saran</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['catatan_saran']; ?></td>
                                                        </tr>
													<?php endforeach; ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
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
                                            <a href="javascript:history.back(1)" class="btn btn-primary btn-md btn-rect">Back</a>
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