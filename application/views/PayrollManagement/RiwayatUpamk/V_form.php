<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Riwayat Upamk</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/RiwayatUpamk/');?>">
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
                                Riwayat Upamk
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
	                                            <label for="txtTglBerlaku" class="control-label col-lg-4">Tgl Berlaku</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglBerlaku" value="<?php echo rtrim($tgl_berlaku) ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtTglBerlaku" />
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtPeriode" class="control-label col-lg-4">Periode</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Periode" name="txtPeriode" id="txtPeriodeHitung" class="form-control" value="<?php echo rtrim($periode); ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtNoind" class="control-label col-lg-4">Noind</label>
                                            <div class="col-lg-4">
                                                <select class="form-control select2-getNoind" id="txtNoind" name="txtNoind" style="width:100%;" required>
														<option value=""></option>
												</select>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtUpamk" class="control-label col-lg-4">Upamk</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Upamk" name="txtUpamk" id="txtUpamk" class="form-control money" value="<?php echo rtrim($upamk); ?>"/>
                                            </div>
                                    </div>
									<div class="form-

	    <input type="hidden" name="txtIdUpamk" value="<?php echo $id_upamk; ?>" /> </div>
                                
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