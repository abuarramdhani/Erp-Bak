<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Master Param Tarif Jamsostek</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/MasterParamTarifJamsostek/');?>">
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
                            <div class="box-header with-border">
                                Master Param Tarif Jamsostek
                            </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <?php if (validation_errors() <> '') {
                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4><i class="fa fa-times"></i> &nbsp; Error! Please check the following errors:</h4>';
                                echo validation_errors(); 
                                echo "</div>";
                            }
                                ?>
                                <div class="row">
									<div class="form-group">
                                            <label for="txtPeriodeJst_new" class="control-label col-lg-4">Periode Jamsostek</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Periode Jamsostek" name="txtPeriodeJst_new" id="txtPeriodeJst_new" class="form-control" value="<?php echo $periode_jst; ?>"/>
                                            </div>
                                    </div>
                                    <div class="form-group">
                                            <label for="txtJkk" class="control-label col-lg-4">Jkk</label>
                                            <div class="col-lg-2">
                                                <input type="text" placeholder="Jkk" name="txtJkk" id="txtJkk" class="form-control"onkeypress="return isNumberKeyAndDot(event)" value="<?php echo rtrim($jkk); ?>" maxlength='4'/>
                                            </div>
											<label for="txtPersen" class="control-label">%</label>
											<label for="txtPersen" class="control-label">(Percent)</label>
                                    </div>
									<div class="form-group">
                                            <label for="txtJhtKaryawan" class="control-label col-lg-4">Jht Karyawan</label>
                                            <div class="col-lg-2">
                                                <input type="text" placeholder="Jht Karyawan" name="txtJhtKaryawan" id="txtJhtKaryawan" class="form-control" onkeypress="return isNumberKeyAndDot(event)" value="<?php echo rtrim($jht_karyawan); ?>" maxlength='4'/>
                                            </div>
											<label for="txtPersen" class="control-label">%</label>
											<label for="txtPersen" class="control-label">(Percent)</label>
                                    </div>
									<div class="form-group">
                                            <label for="txtJhtPerusahaan" class="control-label col-lg-4">Jht Perusahaan</label>
                                            <div class="col-lg-2">
                                                <input type="text" placeholder="Jht Perusahaan" name="txtJhtPerusahaan" id="txtJhtPerusahaan" class="form-control" onkeypress="return isNumberKeyAndDot(event)" value="<?php echo rtrim($jht_perusahaan); ?>" maxlength='4'/>
                                            </div>
											<label for="txtPersen" class="control-label">%</label>
											<label for="txtPersen" class="control-label">(Percent)</label>
                                    </div>
									<div class="form-group">
                                            <label for="txtJkm" class="control-label col-lg-4">Jkm</label>
                                            <div class="col-lg-2">
                                                <input type="text" placeholder="Jkm" name="txtJkm" id="txtJkm" class="form-control" onkeypress="return isNumberKeyAndDot(event)" value="<?php echo rtrim($jkm); ?>" maxlength='4'/>
                                            </div>
											<label for="txtPersen" class="control-label">%</label>
											<label for="txtPersen" class="control-label">(Percent)</label>
                                    </div>
									<div class="form-group">
                                            <label for="txtJpkLajang" class="control-label col-lg-4">Jpk Karyawan</label>
                                            <div class="col-lg-2">
                                                <input type="text" placeholder="Jpk Karyawan" name="txtJpkLajang" id="txtJpkLajang" onkeypress="return isNumberKeyAndDot(event)" class="form-control" value="<?php echo rtrim($jpk_karyawan); ?>" maxlength='4'/>
                                            </div>
											<label for="txtPersen" class="control-label">%</label>
											<label for="txtPersen" class="control-label">(Percent)</label>
                                    </div>
									<div class="form-group">
                                            <label for="txtJpkNikah" class="control-label col-lg-4">Jpk Perusahaan</label>
                                            <div class="col-lg-2">
                                                <input type="text" placeholder="Jpk Perusahaan" name="txtJpkNikah" id="txtJpkNikah" onkeypress="return isNumberKeyAndDot(event)" class="form-control" value="<?php echo rtrim($jpk_perusahaan); ?>"  maxlength='4'/>
                                            </div>
											<label for="txtPersen" class="control-label">%</label>
											<label for="txtPersen" class="control-label">(Percent)</label>
                                    </div>
									<div class="form-group">
                                            <label for="txtBatasJpk" class="control-label col-lg-4">Batas Umur Jpk</label>
                                            <div class="col-lg-2">
                                                <input type="text" placeholder="Batas Jpk" name="txtBatasUmurJpk" id="txtBatasUmurJpk" onkeypress="return isNumberKey(event)" class="form-control" value="<?php echo rtrim($batas_umur_jpk); ?>" maxlength='12' />
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtBatasJpk" class="control-label col-lg-4">Batas Nominal Jpk</label>
                                            <div class="col-lg-2">
                                                <input type="text" placeholder="Batas Jpk" name="txtBatasJpk" id="txtBatasJpk" onkeypress="return isNumberKeyAndDot(event)" class="form-control money" value="<?php echo rtrim($batas_jpk); ?>" maxlength='12' />
                                            </div>
                                    </div>

	    <input type="hidden" name="txtPeriodeJst" value="<?php echo $periode_jst; ?>" /> </div>
                                
                            </div>
                            <div class="panel-footer">
                                <div class="row text-right">
                                    <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                    &nbsp;&nbsp;
                                    <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
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