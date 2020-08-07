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
                                <div class="box-header with-border">Read Kendaraan</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table" style="border: 0px !Important;">
                                                    <?php foreach ($FleetKendaraan as $kendaraanDetail): ?>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Nomor Polisi</strong></td>
                                                            <td style="border: 0">: <?php echo $kendaraanDetail['nomor_polisi']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Jenis Kendaraan</strong></td>
                                                            <td style="border: 0">: <?php echo $kendaraanDetail['jenis_kendaraan']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Merk Kendaraan</strong></td>
                                                            <td style="border: 0">: <?php echo $kendaraanDetail['merk_kendaraan']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Warna Kendaraan</strong></td>
                                                            <td style="border: 0">: <?php echo $kendaraanDetail['warna_kendaraan']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Tahun Pembuatan</strong></td>
                                                            <td style="border: 0">: <?php echo $kendaraanDetail['tahun_pembuatan']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Nomor Rangka</strong></td>
                                                            <td style="border: 0">: <?php echo $kendaraanDetail['nomor_rangka']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Tag Number</strong></td>
                                                            <td style="border: 0">: <?php echo $kendaraanDetail['tag_number']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Foto STNK</strong></td>
                                                            <td style="border: 0">: <a href="<?php echo base_url('assets/upload/GA/Kendaraan/'.$kendaraanDetail['foto_stnk']);?>" target="_blank"><?php echo $kendaraanDetail['foto_stnk']; ?></a></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Foto BPKB</strong></td>
                                                            <td style="border: 0">: <a href="<?php echo base_url('assets/upload/GA/Kendaraan/'.$kendaraanDetail['foto_bpkb']);?>" target="_blank"><?php echo $kendaraanDetail['foto_bpkb']; ?></a></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Foto Kendaraan</strong></td>
                                                            <td style="border: 0">: <a href="<?php echo base_url('assets/upload/GA/Kendaraan/'.$kendaraanDetail['foto_kendaraan']);?>" target="_blank"><?php echo $kendaraanDetail['foto_kendaraan']; ?></a></td>
                                                        </tr>
                                                        <?php
                                                            if($kendaraanDetail['waktu_dihapus']=='12-12-9999 00:00:00')
                                                            {
                                                                echo '  <tr>
                                                                            <td class="col-lg-2" style="border: 0">
                                                                                <strong>Waktu Dibuat</strong>
                                                                            </td>
                                                                            <td style="border: 0">
                                                                                : '.$kendaraanDetail['waktu_dibuat'].' 
                                                                            </td>
                                                                        </tr>';
                                                            }
                                                            else
                                                            {
                                                                echo '  <tr>
                                                                            <td class="col-lg-2" style="border: 0;">
                                                                                <strong>Waktu Dibuat</strong>
                                                                            </td>
                                                                            <td style="border: 0">
                                                                                : '.$kendaraanDetail['waktu_dibuat'].' 
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="col-lg-2" style="border: 0;">
                                                                                <strong>Waktu Dihapus</strong>
                                                                            </td>
                                                                            <td style="border: 0;">
                                                                                : '.$kendaraanDetail['waktu_dihapus'].'
                                                                            </td>
                                                                        </tr>';
                                                            }
                                                        ?>
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