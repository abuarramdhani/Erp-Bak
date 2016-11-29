<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Set Iuran Koperasi</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/RiwayatParamKoperasi/');?>">
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
                               Set Iuran Koperasi
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
                                            <label for="txtIdRiwayatNew" class="control-label col-lg-4">ID</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Ikop" name="txtIdRiwayatNew" id="txtIdRiwayatNew" class="form-control" value="<?php echo $id_riwayat; ?>" onkeypress="return isNumberKey(event)" maxlength="8" />
                                            </div>
                                    </div>
									<div class="form-group">
	                                            <label for="txtTglBerlaku" class="control-label col-lg-4">Tanggal Berlaku</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglBerlaku" value="<?php echo $tgl_berlaku ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtTglBerlaku" />
	                                            </div>
	                                        </div>
									<div class="form-group">
	                                            <label for="txtTglTberlaku" class="control-label col-lg-4">Tanggal Tberlaku</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglTberlaku" value="<?php echo $tgl_tberlaku ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtTglTberlaku" />
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtIkop" class="control-label col-lg-4">Ikop</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Ikop" name="txtIkop" id="txtIkop" class="form-control" value="<?php echo $ikop; ?>" onkeypress="return isNumberKey(event)" maxlength="7" />
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtKodePetugas" class="control-label col-lg-4">Kode Petugas</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Kode Petugas" name="txtKodePetugas" id="txtKodePetugas" class="form-control" value="<?php echo $kode_petugas; ?>" onkeypress="return isNumberKey(event)" maxlength="7" />
                                            </div>
                                    </div>
									<div class="form-group">
	                                            <label for="txtTglRecord" class="control-label col-lg-4">Tanggal Record</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglRecord" value="<?php echo $tgl_record ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtTglRecord" />
	                                            </div>
	                                        </div>

									<input type="hidden" name="txtIdRiwayat" value="<?php echo $id_riwayat; ?>" />
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