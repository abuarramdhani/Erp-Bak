<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Transaksi Klaim Dl</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/TransaksiKlaimDl/');?>">
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
                                Transaksi Klaim Dl
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
	                                            <label for="txtTglTransaksi" class="control-label col-lg-4">Tanggal</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('d/m/Y')?>" name="txtTglTransaksi" value="<?php echo $tanggal ?>" class="form-control datepicker-erp-pr" data-date-format="dd/mm/yyyy" id="txtTglTransaksi" />
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtNoind" class="control-label col-lg-4">Noind</label>
                                            <div class="col-lg-4">
                                                <select style="width:100%" id="cmbNoind" name="txtNoind" class="select2-getNoind" data-placeholder="Choose an option">
													<option value="<?php echo $noind; ?>"><?php echo $noind; ?></option>
												</select>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtKlaimDl" class="control-label col-lg-4">Klaim Dl</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Klaim Dl" name="txtKlaimDl" id="txtKlaimDl" class="form-control number" value="<?php echo rtrim($klaim_dl); ?>"/>
                                            </div>
                                    </div>

	    <input type="hidden" name="txtIdKlaimDl" value="<?php echo $id_klaim_dl; ?>" /> </div>
                                
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