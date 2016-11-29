<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
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
                                <div class="row">
									<div class="form-group">
                                        <label for="txtIdKompJab" class="control-label col-lg-4">Id Komponen Jabatan</label>
                                        <div class="col-lg-4">
											<input type="text" name="txtIdKompJabNew" id="txtIdKompJabNew" class="form-control" value="<?php echo $id_komp_jab; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtKdStatusKerja" class="control-label col-lg-4">Kode Status Kerja</label>
                                        <div class="col-lg-4">
											<input type="text" name="txtKdStatusKerja" id="txtKdStatusKerja" class="form-control" value="<?php echo $kd_status_kerja; ?>" readonly/>
                                        </div>
                                    </div>
<div class="form-group">
                                            <label for="txtKdJabatan" class="control-label col-lg-4">Kode Jabatan</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtKdJabatan" id="txtKdJabatan" class="form-control" value="<?php echo $kd_jabatan; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtIp" class="control-label col-lg-4">Ip</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtIp" id="txtIp" class="form-control" value="<?php echo $ip; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtIk" class="control-label col-lg-4">Ik</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtIk" id="txtIk" class="form-control" value="<?php echo $ik; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtIms" class="control-label col-lg-4">Ims</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtIms" id="txtIms" class="form-control" value="<?php echo $ims; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtImm" class="control-label col-lg-4">Imm</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtImm" id="txtImm" class="form-control" value="<?php echo $imm; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtPotDuka" class="control-label col-lg-4">Pot Duka</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtPotDuka" id="txtPotDuka" class="form-control" value="<?php echo $pot_duka; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtSpsi" class="control-label col-lg-4">Spsi</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtSpsi" id="txtSpsi" class="form-control" value="<?php echo $spsi; ?>" readonly/>
                                            </div>
                                        </div>
</div>
                                
                            </div>
                            <div class="panel-footer">
                                <div class="row text-right">
                                    <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
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