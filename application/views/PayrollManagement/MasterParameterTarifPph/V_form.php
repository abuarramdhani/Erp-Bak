<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Master Parameter Tarif Pph</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/MasterParameterTarifPph/');?>">
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
                                Master Parameter Tarif Pph
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
                                        <label for="txtKdPphNew" class="control-label col-lg-4">Tingkatan</label>
                                        <div class="col-lg-4">
											<input type="text" placeholder="Tingkatan PPH" name="txtKdPphNew" id="txtKdPphNew" class="form-control" onkeypress="return isNumberKey(event)" value="<?php echo $kd_pph; ?>" maxlength="1"/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtBatasBawah" class="control-label col-lg-4">Batas Bawah</label>
                                        <div class="col-lg-4">
											<input type="text" placeholder="Batas Bawah" name="txtBatasBawah" id="txtBatasBawah" class="form-control money" value="<?php echo $batas_bawah; ?>" onkeypress="return isNumberKey(event)" maxlength="15"/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtBatasAtas" class="control-label col-lg-4">Batas Atas</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="Batas Atas" name="txtBatasAtas" id="txtBatasAtas" class="form-control money" value="<?php echo $batas_atas; ?>" onkeypress="return isNumberKey(event)" maxlength="15"/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtPersen" class="control-label col-lg-4">Persentase Pph</label>
                                        <div class="col-lg-2">
                                            <input type="text" placeholder="Persentase Pph" name="txtPersen" id="txtPersen" class="form-control" onkeypress="return isNumberKey(event)" value="<?php echo $persen; ?>" maxlength="3"/>
                                        </div>
										<label for="txtPersen" class="control-label">%</label>
										<label for="txtPersen" class="control-label">(Percent)</label>
                                    </div>
									<input type="hidden" name="txtKdPph" value="<?php echo $kd_pph; ?>" />
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
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</section>