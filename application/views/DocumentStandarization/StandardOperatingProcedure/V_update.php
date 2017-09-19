<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('DocumentStandarization/SOP/update/'.$id);?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('DocumentStandarization/SOP/');?>">
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
                                <div class="box-header with-border">Update Standard Operating Procedure</div>
                                <?php
                                    foreach ($StandardOperatingProcedure as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="txtSopNameHeader" class="control-label col-lg-4">Sop Name</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Sop Name" name="txtSopNameHeader" id="txtSopNameHeader" class="form-control" value="<?php echo $headerRow['sop_name']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtSopFileHeader" class="control-label col-lg-4">Sop File</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Sop File" name="txtSopFileHeader" id="txtSopFileHeader" class="form-control" value="<?php echo $headerRow['sop_file']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtNoKontrolHeader" class="control-label col-lg-4">No Kontrol</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="No Kontrol" name="txtNoKontrolHeader" id="txtNoKontrolHeader" class="form-control" value="<?php echo $headerRow['no_kontrol']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtNoRevisiHeader" class="control-label col-lg-4">No Revisi</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="No Revisi" name="txtNoRevisiHeader" id="txtNoRevisiHeader" class="form-control" value="<?php echo $headerRow['no_revisi']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTanggalHeader" class="control-label col-lg-4">Tanggal</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTanggalHeader" value="<?php echo $headerRow['tanggal'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtTanggalHeader" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtDibuatHeader" class="control-label col-lg-4">Dibuat</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Dibuat" name="txtDibuatHeader" id="txtDibuatHeader" class="form-control" value="<?php echo $headerRow['dibuat']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtDiperiksa1Header" class="control-label col-lg-4">Diperiksa 1</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Diperiksa 1" name="txtDiperiksa1Header" id="txtDiperiksa1Header" class="form-control" value="<?php echo $headerRow['diperiksa_1']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtDiperiksa2Header" class="control-label col-lg-4">Diperiksa 2</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Diperiksa 2" name="txtDiperiksa2Header" id="txtDiperiksa2Header" class="form-control" value="<?php echo $headerRow['diperiksa_2']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtDiputuskanHeader" class="control-label col-lg-4">Diputuskan</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Diputuskan" name="txtDiputuskanHeader" id="txtDiputuskanHeader" class="form-control" value="<?php echo $headerRow['diputuskan']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtJmlHalamanHeader" class="control-label col-lg-4">Jml Halaman</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Jml Halaman" name="txtJmlHalamanHeader" id="txtJmlHalamanHeader" class="form-control" value="<?php echo $headerRow['jml_halaman']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txaSopInfoHeader" class="control-label col-lg-4">Sop Info</label>
                                                <div class="col-lg-4">
                                                    <textarea name="txaSopInfoHeader" id="txaSopInfoHeader" class="form-control" placeholder="Sop Info"><?php echo $headerRow['sop_info']; ?></textarea>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTglUploadHeader" class="control-label col-lg-4">Tgl Upload</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Tgl Upload" name="txtTglUploadHeader" id="txtTglUploadHeader" class="form-control" value="<?php echo $headerRow['tgl_upload']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTglInsertHeader" class="control-label col-lg-4">Tgl Insert</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Tgl Insert" name="txtTglInsertHeader" id="txtTglInsertHeader" class="form-control" value="<?php echo $headerRow['tgl_insert']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtBpIdHeader" class="control-label col-lg-4">Bp Id</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Bp Id" name="txtBpIdHeader" id="txtBpIdHeader" class="form-control" value="<?php echo $headerRow['bp_id']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtCdIdHeader" class="control-label col-lg-4">Cd Id</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Cd Id" name="txtCdIdHeader" id="txtCdIdHeader" class="form-control" value="<?php echo $headerRow['cd_id']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txaSopTujuanHeader" class="control-label col-lg-4">Sop Tujuan</label>
                                                <div class="col-lg-4">
                                                    <textarea name="txaSopTujuanHeader" id="txaSopTujuanHeader" class="form-control" placeholder="Sop Tujuan"><?php echo $headerRow['sop_tujuan']; ?></textarea>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txaSopRuangLingkupHeader" class="control-label col-lg-4">Sop Ruang Lingkup</label>
                                                <div class="col-lg-4">
                                                    <textarea name="txaSopRuangLingkupHeader" id="txaSopRuangLingkupHeader" class="form-control" placeholder="Sop Ruang Lingkup"><?php echo $headerRow['sop_ruang_lingkup']; ?></textarea>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txaSopReferensiHeader" class="control-label col-lg-4">Sop Referensi</label>
                                                <div class="col-lg-4">
                                                    <textarea name="txaSopReferensiHeader" id="txaSopReferensiHeader" class="form-control" placeholder="Sop Referensi"><?php echo $headerRow['sop_referensi']; ?></textarea>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txaSopDefinisiHeader" class="control-label col-lg-4">Sop Definisi</label>
                                                <div class="col-lg-4">
                                                    <textarea name="txaSopDefinisiHeader" id="txaSopDefinisiHeader" class="form-control" placeholder="Sop Definisi"><?php echo $headerRow['sop_definisi']; ?></textarea>
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