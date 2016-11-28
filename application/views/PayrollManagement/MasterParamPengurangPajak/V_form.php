<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Set Pengurang Pajak</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/MasterParamPengurangPajak/');?>">
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
                                Set Pengurang Pajak
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
                                            <label for="txtPeriodePengurangPajak" class="control-label col-lg-4">Periode Pengurang Pajak</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Periode Pengurang Pajak" name="txtPeriodePengurangPajak" id="txtPeriodePengurangPajak" class="form-control" value="<?php echo $periode_pengurang_pajak; ?>" maxlength="6"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtMaxJab" class="control-label col-lg-4">Max Jab</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Max Jab" name="txtMaxJab" id="txtMaxJab" class="form-control" value="<?php echo $max_jab; ?>" maxlength="10"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtPersentaseJab" class="control-label col-lg-4">Persentase Jab</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Persentase Jab" name="txtPersentaseJab" id="txtPersentaseJab" class="form-control" value="<?php echo $persentase_jab; ?>" onkeypress="return isNumberKey(event)" maxlength="3"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtMaxPensiun" class="control-label col-lg-4">Max Pensiun</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Max Pensiun" name="txtMaxPensiun" id="txtMaxPensiun" class="form-control" value="<?php echo $max_pensiun; ?>" maxlength="10"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtPersentasePensiun" class="control-label col-lg-4">Persentase Pensiun</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Persentase Pensiun" name="txtPersentasePensiun" id="txtPersentasePensiun" class="form-control" value="<?php echo $persentase_pensiun; ?>" onkeypress="return isNumberKey(event)" maxlength="3"/>
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