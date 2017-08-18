<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('WasteManagement/Limbah/update/'.$id);?>" class="form-horizontal" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('WasteManagement/Limbah/');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <span ><br /></span>
                                    </a>                             
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Update Limbah</div>
                                <?php
                                    foreach ($Limbah as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
											<div class="form-group">
                                                <label for="txtTanggalKirimHeader" class="control-label col-lg-4">Tanggal Kirim</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTanggalKirimHeader" value="<?php echo date('d M Y', strtotime($headerRow['tanggal_kirim']));?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtTanggalKirimHeader" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtSeksiKirimHeader" class="control-label col-lg-4">Seksi Pengirim</label>
                                                <div class="col-lg-4">
                                                 <select id="cmbSeksiKirimHeader" name="cmbSeksiKirimHeader" style="width: 100%" class="select select2" data-placeholder="Choose an option">
                                                        <option value=""></option>
                                                        <?php foreach ($getSeksi as $seksi) { ?>
                                                        <option value="<?php echo $seksi['seksi_id']; ?>" <?php if($seksi['seksi_id']==$headerRow['seksi_kirim']) echo "selected"; ?>><?php echo $seksi['nama_seksi']; ?></option>
                                                        <?php }?> 
                                                 </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtNamaKirimHeader" class="control-label col-lg-4">Nama Pengirim</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Nama Pengirim" name="txtNamaKirimHeader" id="txtNamaKirimHeader" class="form-control" value="<?php echo $headerRow['nama_kirim']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtNamaLimbahHeader" class="control-label col-lg-4">Nama Limbah</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Nama Limbah" name="txtNamaLimbahHeader" id="txtNamaLimbahHeader" class="form-control" value="<?php echo $headerRow['nama_limbah']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtNomorLimbahHeader" class="control-label col-lg-4">Nomor Limbah</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Nomor Limbah" name="txtNomorLimbahHeader" id="txtNomorLimbahHeader" class="form-control" value="<?php echo $headerRow['nomor_limbah']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="cmbJenisLimbahHeader" class="control-label col-lg-4">Jenis Limbah</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbJenisLimbahHeader" name="cmbJenisLimbahHeader" style="width: 100%" class="select select2" data-placeholder="Choose an option">
                                                        <option value=""></option>
                                                        <?php foreach ($jenis_limbah as $JenisLimbah) { ?>
                                                        <option value="<?php echo $JenisLimbah['id_jenis_limbah']; ?>" <?php if($JenisLimbah['id_jenis_limbah']==$headerRow['jenis_limbah']) echo "selected"; ?>><?php echo $JenisLimbah['jenis_limbah']; ?></option>
                                                        <?php }?> 
                                                 </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtKarakteristikLimbahHeader" class="control-label col-lg-4">Karakteristik Limbah</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Karakteristik Limbah" name="txtKarakteristikLimbahHeader" id="txtKarakteristikLimbahHeader" class="form-control" value="<?php echo $headerRow['karakteristik_limbah']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="fileLimbah" class="control-label col-lg-4">Kondisi Limbah</label>
                                                <div class="col-lg-4">
                                                    <input type="file" name="fileLimbah" id="fileLimbah" />
                                                    <a target="_blank" href="<?php echo base_url('/assets/limbah/kondisi-limbah/').$headerRow['kondisi_limbah'];?>"><?php echo $headerRow['kondisi_limbah'];?></a>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTemuanKemasanHeader" class="control-label col-lg-4">Temuan Kemasan</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Temuan Kemasan" name="txtTemuanKemasanHeader" id="txtTemuanKemasanHeader" class="form-control" value="<?php echo $headerRow['temuan_kemasan']; ?>"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cmbTemuanKemasanStatusHeader" class="control-label col-lg-4">Temuan Kemasan Status</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbTemuanKemasanStatusHeader" name="cmbTemuanKemasanStatusHeader" style="width: 100%" class="select select2" data-placeholder="Choose an option">
                                                        <option value=""></option>
                                                        <option value="1" <?php if ($headerRow['temuan_kemasan_status'] == "1") { echo "selected"; }?>>Ok</option>
                                                        <option value="0" <?php if ($headerRow['temuan_kemasan_status'] == "0") { echo "selected"; }?>>Not Ok</option>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTemuanKebocoranHeader" class="control-label col-lg-4">Temuan Kebocoran</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Temuan Kebocoran" name="txtTemuanKebocoranHeader" id="txtTemuanKebocoranHeader" class="form-control" value="<?php echo $headerRow['temuan_kebocoran']; ?>"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cmbTemuanKebocoranStatusHeader" class="control-label col-lg-4">Temuan Kebocoran Status</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbTemuanKebocoranStatusHeader" name="cmbTemuanKebocoranStatusHeader" style="width: 100%" class="select select2" data-placeholder="Choose an option">
                                                        <option value=""></option>
                                                        <option value="1" <?php if ($headerRow['temuan_kebocoran_status'] == "1") { echo "selected"; }?>>Ok</option>
                                                        <option value="0" <?php if ($headerRow['temuan_kebocoran_status'] == "0") { echo "selected"; }?>>Not Ok</option>
                                                    </select>
                                                </div>
                                            </div>

                                            </div>
                                            <div class="col-md-6">

											<div class="form-group">
                                                <label for="txtTemuanLevelLimbahHeader" class="control-label col-lg-4">Temuan Level Limbah</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Temuan Level Limbah" name="txtTemuanLevelLimbahHeader" id="txtTemuanLevelLimbahHeader" class="form-control" value="<?php echo $headerRow['temuan_level_limbah']; ?>"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cmbTemuanLevelLimbahStatusHeader" class="control-label col-lg-4">Temuan Level Limbah Status</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbTemuanLevelLimbahStatusHeader" name="cmbTemuanLevelLimbahStatusHeader" style="width: 100%" class="select select2" data-placeholder="Choose an option">
                                                        <option value=""></option>
                                                        <option value="1" <?php if ($headerRow['temuan_level_limbah_status'] == "1") { echo "selected"; }?>>Ok</option>
                                                        <option value="0" <?php if ($headerRow['temuan_level_limbah_status'] == "0") { echo "selected"; }?>>Not Ok</option>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTemuanLainLainHeader" class="control-label col-lg-4">Temuan Lain Lain</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Temuan Lain Lain" name="txtTemuanLainLainHeader" id="txtTemuanLainLainHeader" class="form-control" value="<?php echo $headerRow['temuan_lain_lain']; ?>"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cmbTemuanLainLainStatusHeader" class="control-label col-lg-4">Temuan Lain Lain Status</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbTemuanLainLainStatusHeader" name="cmbTemuanLainLainStatusHeader" style="width: 100%" class="select select2" data-placeholder="Choose an option">
                                                        <option value=""></option>
                                                        <option value="1" <?php if ($headerRow['temuan_lain_lain_status'] == "1") { echo "selected"; }?>>Ok</option>
                                                        <option value="0" <?php if ($headerRow['temuan_lain_lain_status'] == "0") { echo "selected"; }?>>Not Ok</option>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="fileFoto" class="control-label col-lg-4">Standar Foto</label>
                                                <div class="col-lg-4">
                                                    <input type="file" name="fileFoto" id="fileFoto" />
                                                    <a target="_blank" href="<?php echo base_url('/assets/limbah/standar-foto/').$headerRow['standar_foto'];?>"><?php echo $headerRow['standar_foto'];?></a>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txaStandarRefrensiHeader" class="control-label col-lg-4">Standar Refrensi</label>
                                                <div class="col-lg-4">
                                                    <textarea name="txaStandarRefrensiHeader" id="txaStandarRefrensiHeader" class="form-control" placeholder="Standar Refrensi"><?php echo $headerRow['standar_refrensi']; ?></textarea>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtStandarKemasanHeader" class="control-label col-lg-4">Standar Kemasan</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Standar Kemasan" name="txtStandarKemasanHeader" id="txtStandarKemasanHeader" class="form-control" value="<?php echo $headerRow['standar_kemasan']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtStandarKebocoranHeader" class="control-label col-lg-4">Standar Kebocoran</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Standar Kebocoran" name="txtStandarKebocoranHeader" id="txtStandarKebocoranHeader" class="form-control" value="<?php echo $headerRow['standar_kebocoran']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtStandarLainLainHeader" class="control-label col-lg-4">Standar Lain Lain</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Standar Lain Lain" name="txtStandarLainLainHeader" id="txtStandarLainLainHeader" class="form-control" value="<?php echo $headerRow['standar_lain_lain']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txaCatatanSaranHeader" class="control-label col-lg-4">Catatan Saran</label>
                                                <div class="col-lg-4">
                                                    <textarea name="txaCatatanSaranHeader" id="txaCatatanSaranHeader" class="form-control" placeholder="Catatan Saran"><?php echo $headerRow['catatan_saran']; ?></textarea>
                                                </div>
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
                                    <div class="panel-footer">
                                        <div class="row text-right">
                                            <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>