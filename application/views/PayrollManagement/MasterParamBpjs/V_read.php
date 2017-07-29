<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
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
                                Read Master Param Bpjs
                            </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <div class="row">
									<div class="form-group">
                                        <label for="txtBatasMaxJkn" class="control-label col-lg-4">Batas Max JKN</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtBatasMaxJkn" id="txtBatasMaxJkn" class="form-control" value="<?php echo $batas_max_jkn; ?>" readonly/>
                                        </div>
									</div>
									<div class="form-group">
                                        <label for="txtJknTgKary" class="control-label col-lg-4">JKN Tg Karyawan</label>
                                        <div class="col-lg-4">
											<input type="text" name="txtJknTgKary" id="txtJknTgKary" class="form-control" value="<?php echo $jkn_tg_kary; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtJknTgPrshn" class="control-label col-lg-4">JKN Tg Perusahaan</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtJknTgPrshn" id="txtJknTgPrshn" class="form-control" value="<?php echo $jkn_tg_prshn; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtBatasMaxJpn" class="control-label col-lg-4">Batas Max JPN</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtBatasMaxJpn" id="txtBatasMaxJpn" class="form-control" value="<?php echo $batas_max_jpn; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtJpnTgKary" class="control-label col-lg-4">JPN Tg Karyawan</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtJpnTgKary" id="txtJpnTgKary" class="form-control" value="<?php echo $jpn_tg_kary; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtJpnTgPrshn" class="control-label col-lg-4">JPN Tg Perusahaan</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtJpnTgPrshn" id="txtJpnTgPrshn" class="form-control" value="<?php echo $jpn_tg_prshn; ?>" readonly/>
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