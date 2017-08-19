<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('GeneralAffair/FleetKecelakaan/update/'.$id);?>" class="form-horizontal">
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
                                <div class="box-header with-border">Update Fleet Kecelakaan</div>
                                <?php
                                    foreach ($FleetKecelakaan as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="txtKendaraanIdHeader" class="control-label col-lg-4">Kendaraan Id</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Kendaraan Id" name="txtKendaraanIdHeader" id="txtKendaraanIdHeader" class="form-control" value="<?php echo $headerRow['kendaraan_id']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTanggalKecelakaanHeader" class="control-label col-lg-4">Tanggal Kecelakaan</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTanggalKecelakaanHeader" value="<?php echo $headerRow['tanggal_kecelakaan'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtTanggalKecelakaanHeader" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txaSebabHeader" class="control-label col-lg-4">Sebab</label>
                                                <div class="col-lg-4">
                                                    <textarea name="txaSebabHeader" id="txaSebabHeader" class="form-control" placeholder="Sebab"><?php echo $headerRow['sebab']; ?></textarea>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtBiayaPerusahaanHeader" class="control-label col-lg-4">Biaya Perusahaan</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Biaya Perusahaan" name="txtBiayaPerusahaanHeader" id="txtBiayaPerusahaanHeader" class="form-control" value="<?php echo $headerRow['biaya_perusahaan']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtBiayaPekerjaHeader" class="control-label col-lg-4">Biaya Pekerja</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Biaya Pekerja" name="txtBiayaPekerjaHeader" id="txtBiayaPekerjaHeader" class="form-control" value="<?php echo $headerRow['biaya_pekerja']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtPekerjaHeader" class="control-label col-lg-4">Pekerja</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Pekerja" name="txtPekerjaHeader" id="txtPekerjaHeader" class="form-control" value="<?php echo $headerRow['pekerja']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtStartDateHeader" class="control-label col-lg-4">Start Date</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtStartDateHeader" value="<?php echo $headerRow['start_date'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtStartDateHeader" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtEndDateHeader" class="control-label col-lg-4">End Date</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtEndDateHeader" value="<?php echo $headerRow['end_date'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtEndDateHeader" />
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