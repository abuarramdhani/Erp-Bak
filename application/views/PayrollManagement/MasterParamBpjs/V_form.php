<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Master Param Bpjs</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/MasterParamBpjs/');?>">
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
                                Master Param Bpjs
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
	                                            <label for="txtBatasMaxJkn" class="control-label col-lg-4">Batas Max JKN</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" placeholder="Batas Max JKN" name="txtBatasMaxJkn" id="txtBatasMaxJkn" class="form-control" value="<?php echo $batas_max_jkn ?>" maxlength="10" />
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtJknTgKary" class="control-label col-lg-4">JKN Tg Karyawan</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Jkn Tg Kary" name="txtJknTgKary" id="txtJknTgKary" class="form-control" value="<?php echo $jkn_tg_kary; ?>" maxlength="5"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtJknTgPrshn" class="control-label col-lg-4">JKN Tg Perusahaan</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Jkn Tg Prshn" name="txtJknTgPrshn" id="txtJknTgPrshn" class="form-control" value="<?php echo $jkn_tg_prshn; ?>"  maxlength="5"/>
                                            </div>
                                    </div>
									<div class="form-group">
	                                            <label for="txtBatasMaxJpn" class="control-label col-lg-4">Batas Max JPN</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" placeholder="Batas Max JPN" name="txtBatasMaxJpn" id="txtBatasMaxJpn" class="form-control" value="<?php echo $batas_max_jpn ?>" maxlength="10"/>
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtJpnTgKary" class="control-label col-lg-4">JPN Tg Karyawan</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Jpn Tg Kary" name="txtJpnTgKary" id="txtJpnTgKary" class="form-control" value="<?php echo $jpn_tg_kary; ?>"  maxlength="5"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtJpnTgPrshn" class="control-label col-lg-4">JPN Tg Perusahaan</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Jpn Tg Prshn" name="txtJpnTgPrshn" id="txtJpnTgPrshn" class="form-control" value="<?php echo $jpn_tg_prshn; ?>"  maxlength="5"/>
                                            </div>
                                    </div>

	    <input type="hidden" name="txtIdSetting" value="<?php echo $id_setting; ?>" /> </div>
                                
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