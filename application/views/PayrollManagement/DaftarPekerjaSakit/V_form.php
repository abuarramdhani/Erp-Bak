<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Transaksi Pekerja Sakit Berkepanjangan</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/DaftarPekerjaSakit/');?>">
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
                                Transaksi Pekerja Sakit Berkepanjangan
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
	                                    <label for="txtTanggal" class="control-label col-lg-4">Tanggal</label>
	                                    <div class="col-lg-4">
	                                        <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTanggal" value="<?php echo $tanggal ?>" class="form-control" id="txtTanggal" />
	                                    </div>
	                                </div>
									<div class="form-group">
                                        <label for="txtNoind" class="control-label col-lg-4">No induk</label>
                                        <div class="col-lg-4">
                                             <select style="width:100%" id="cmbNoind" name="txtNoind" class="select2-getNoind" data-placeholder="Choose an option" onchange="getMaxHutang($(this).val())">
													<option value=""></option>
												</select>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtBulanSakit" class="control-label col-lg-4">Bulan Sakit</label>
                                        <div class="col-lg-2">
                                            <input type="text" placeholder="Bulan Sakit" name="txtBulanSakit" id="txtBulanSakit" class="form-control" value="<?php echo $bulan_sakit; ?>" onkeypress="return isNumberKey(event)" maxlength="2"/>
                                        </div>
                                    </div>
									<input type="hidden" name="txtIdSetting" value="<?php echo $id_setting; ?>" />
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