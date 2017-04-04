<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Kondite/doUpdate/'.$id);?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Kondite/');?>">
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
                                <div class="box-header with-border">Update Kondite</div>
                                <?php
                                    foreach ($Kondite as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="cmbNoindHeader" class="control-label col-lg-4">Noind</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbNoindHeader" name="cmbNoindHeader" class="select cmbNoindHeader" data-placeholder="Choose an option" style="width: 100%">
                                                        <option value="<?php echo $headerRow['noind'].' - '.$headerRow['section_code']; ?>"><?php echo $headerRow['noind']." - ".$headerRow['employee_name']; ?></option>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="cmbKodesieHeader" class="control-label col-lg-4">Kodesie</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbKodesieHeader" name="cmbKodesieHeader" class="select cmbKodesie" data-placeholder="Choose an option" style="width: 100%">
                                                        <option value="<?php echo $headerRow['kodesie']; ?>"><?php echo $headerRow['kodesie']." - ".$headerRow['unit_name']; ?></option>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTanggalHeader" class="control-label col-lg-4">Tanggal</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTanggalHeader" value="<?php echo $headerRow['tanggal'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtTanggalHeader" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtMKHeader" class="control-label col-lg-4">MK</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="MK" name="txtMKHeader" id="txtMKHeader" class="form-control" value="<?php echo $headerRow['MK']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtBKIHeader" class="control-label col-lg-4">BKI</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="BKI" name="txtBKIHeader" id="txtBKIHeader" class="form-control" value="<?php echo $headerRow['BKI']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtBKPHeader" class="control-label col-lg-4">BKP</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="BKP" name="txtBKPHeader" id="txtBKPHeader" class="form-control" value="<?php echo $headerRow['BKP']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTKPHeader" class="control-label col-lg-4">TKP</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="TKP" name="txtTKPHeader" id="txtTKPHeader" class="form-control" value="<?php echo $headerRow['TKP']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtKBHeader" class="control-label col-lg-4">KB</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="KB" name="txtKBHeader" id="txtKBHeader" class="form-control" value="<?php echo $headerRow['KB']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtKKHeader" class="control-label col-lg-4">KK</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="KK" name="txtKKHeader" id="txtKKHeader" class="form-control" value="<?php echo $headerRow['KK']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtKSHeader" class="control-label col-lg-4">KS</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="KS" name="txtKSHeader" id="txtKSHeader" class="form-control" value="<?php echo $headerRow['KS']; ?>"/>
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