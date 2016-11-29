<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Set Komponen Gaji Jabatan</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/MasterParamKompJab/');?>">
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
                                Set Komponen Gaji Jabatan
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
                                        <label for="txtIdKompJabNew" class="control-label col-lg-4">Id Komponen Jabatan</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="Ip" name="txtIdKompJabNew" id="txtIdKompJabNew" class="form-control" value="<?php echo $id_komp_jab; ?>" maxlength="6"/>
                                        </div>
                                    </div>
									<div class="form-group">
	                                    <label for="cmbKdStatusKerja" class="control-label col-lg-4">Status Kerja</label>
											<div class="col-lg-4">
												<select style="width:100%" id="cmbKdStatusKerja" name="cmbKdStatusKerja" class="select2" data-placeholder="Choose an option"><option value=""></option>
                                                    <?php
                                                        foreach ($pr_master_status_kerja_data as $row) {
														$slc='';if($row->kd_status_kerja==$kd_status_kerja){$slc='selected';}
                                                        echo '<option '.$slc.' value="'.$row->kd_status_kerja.'">'.$row->status_kerja.'</option>';
                                                        }
                                                    ?>
												</select>
	                                        </div>
	                                        </div>
									<div class="form-group">
	                                        <label for="cmbKdJabatan" class="control-label col-lg-4">Jabatan</label>
	                                        <div class="col-lg-4">
	                                        <select style="width:100%" id="cmbKdJabatan" name="cmbKdJabatan" class="select2" data-placeholder="Choose an option"><option value=""></option>
                                                <?php
													foreach ($pr_master_jabatan_data as $row) {
													$slc2='';if($row->kd_jabatan==$kd_jabatan){$slc2='selected';}
                                                    echo '<option '.$slc2.' value="'.$row->kd_jabatan.'">'.$row->jabatan.'</option>';
													}
                                                ?>
											</select>
	                                    </div>
	                                </div>
									<div class="form-group">
                                        <label for="txtIp" class="control-label col-lg-4">Ip</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="Ip" name="txtIp" id="txtIp" class="form-control" onkeypress="return isNumberKey(event)" value="<?php echo $ip; ?>" maxlength="10"/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtIk" class="control-label col-lg-4">Ik</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="Ik" name="txtIk" id="txtIk" class="form-control" onkeypress="return isNumberKey(event)" value="<?php echo $ik; ?>" maxlength="10"/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtIms" class="control-label col-lg-4">Ims</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="Ims" name="txtIms" id="txtIms" class="form-control" onkeypress="return isNumberKey(event)" value="<?php echo $ims; ?>" maxlength="10"/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtImm" class="control-label col-lg-4">Imm</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="Imm" name="txtImm" id="txtImm" class="form-control" onkeypress="return isNumberKey(event)" value="<?php echo $imm; ?>" maxlength="10"/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtPotDuka" class="control-label col-lg-4">Pot Duka</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="Pot Duka" name="txtPotDuka" id="txtPotDuka" class="form-control" onkeypress="return isNumberKey(event)" value="<?php echo $pot_duka; ?>" maxlength="10"/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtSpsi" class="control-label col-lg-4">Spsi</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="Spsi" name="txtSpsi" id="txtSpsi" class="form-control" onkeypress="return isNumberKey(event)" value="<?php echo $spsi; ?>" maxlength="10"/>
                                        </div>
                                    </div>
									<input type="hidden" name="txtIdKompJab" value="<?php echo $id_komp_jab; ?>" />
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