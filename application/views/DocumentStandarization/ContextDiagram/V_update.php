<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('DocumentStandarization/CD/update/'.$id);?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('DocumentStandarization/CD/');?>">
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
                                <div class="box-header with-border">Update Context Diagram</div>
                                <?php
                                    foreach ($ContextDiagram as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="txtCdNameHeader" class="control-label col-lg-4">Cd Name</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Cd Name" name="txtCdNameHeader" id="txtCdNameHeader" class="form-control" value="<?php echo $headerRow['cd_name']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtCdFileHeader" class="control-label col-lg-4">Cd File</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Cd File" name="txtCdFileHeader" id="txtCdFileHeader" class="form-control" value="<?php echo $headerRow['cd_file']; ?>"/>
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
                                                <label for="txaCdInfoHeader" class="control-label col-lg-4">Cd Info</label>
                                                <div class="col-lg-4">
                                                    <textarea name="txaCdInfoHeader" id="txaCdInfoHeader" class="form-control" placeholder="Cd Info"><?php echo $headerRow['cd_info']; ?></textarea>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTglUploadHeader" class="control-label col-lg-4">Tgl Upload</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglUploadHeader" value="<?php echo $headerRow['tgl_upload'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtTglUploadHeader" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTglInsertHeader" class="control-label col-lg-4">Tgl Insert</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglInsertHeader" value="<?php echo $headerRow['tgl_insert'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtTglInsertHeader" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtBpIdHeader" class="control-label col-lg-4">Bp Id</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Bp Id" name="txtBpIdHeader" id="txtBpIdHeader" class="form-control" value="<?php echo $headerRow['bp_id']; ?>"/>
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