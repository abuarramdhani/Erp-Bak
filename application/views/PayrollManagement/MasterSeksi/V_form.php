<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Master Seksi</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/MasterSeksi/');?>">
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
                                Master Seksi
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
                                        <label for="txtKodesieNew" class="control-label col-lg-4">Kodesie</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="Bidang" name="txtKodesieNew" id="txtKodesieNew" class="form-control" value="<?php echo $kodesie; ?>" maxlength="9"/>
                                        </div>
                                    </div>
									<div class="form-group">
	                                    <label for="cmbDept" class="control-label col-lg-4">Dept</label>
	                                    <div class="col-lg-4">
	                                        <select style="width:100%" id="cmbDept" name="cmbDept" class="select2" data-placeholder="Choose an option"><option value=""></option>
                                                <?php
													$keuangan=''; if($dept=='KEUANGAN'){$keuangan='selected';}
													$pemasaran=''; if($dept=='PEMASARAN'){$pemasaran='selected';}
													$personalia=''; if($dept=='PERSONALIA'){$personalia='selected';}
													$produksi=''; if($dept=='PRODUKSI'){$produksi='selected';}
												?>
												<option <?php echo $keuangan ?> value="KEUANGAN">KEUANGAN</option>
                                                <option <?php echo $pemasaran ?> value="PEMASARAN">PEMASARAN</option>
                                                <option <?php echo $personalia ?> value="PERSONALIA">PERSONALIA</option>
                                                <option <?php echo $produksi ?> value="PRODUKSI">PRODUKSI</option>
											</select>
	                                    </div>
	                                </div>
									<div class="form-group">
                                        <label for="txtBidang" class="control-label col-lg-4">Bidang</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="Bidang" name="txtBidang" id="txtBidang" class="form-control" value="<?php echo $bidang; ?>" maxlength="50"/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtUnit" class="control-label col-lg-4">Unit</label>
										<div class="col-lg-4">
                                            <input type="text" placeholder="Unit" name="txtUnit" id="txtUnit" class="form-control" value="<?php echo $unit; ?>" maxlength="50"/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtSeksi" class="control-label col-lg-4">Seksi</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="Seksi" name="txtSeksi" id="txtSeksi" class="form-control" value="<?php echo $seksi; ?>" maxlength="50"/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtPekerjaan" class="control-label col-lg-4">Pekerjaan</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="Pekerjaan" name="txtPekerjaan" id="txtPekerjaan" class="form-control" value="<?php echo $pekerjaan; ?>" maxlength="50"/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtGolkerja" class="control-label col-lg-4">Golkerja</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="Golkerja" name="txtGolkerja" id="txtGolkerja" class="form-control" value="<?php echo $golkerja; ?>" maxlength="5"/>
                                        </div>
                                    </div>
									<input type="hidden" name="txtKodesie" value="<?php echo $kodesie; ?>" />
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