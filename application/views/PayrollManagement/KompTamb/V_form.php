<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Komp Tamb</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/KompTamb/');?>">
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
                                Komp Tamb
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
                                            <label for="txtPeriode" class="control-label col-lg-4">Periode</label>
                                            <div class="col-lg-2">
                                                <input type="text" placeholder="Periode" name="txtPeriode" id="txtPeriodeHitung" class="form-control" value="<?php echo $periode; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
	                                            <label for="cmbNoind" class="control-label col-lg-4">Noind</label>
	                                            <div class="col-lg-4">
													 <select style="width:100%" id="cmbNoind" name="txtNoind" class="select2-getNoind" data-placeholder="Choose an option" onchange="getMaxHutang($(this).val())">
														<option value="<?php echo $noind ?>"><?php echo $noind ?></option>
													</select>
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtTambahan" class="control-label col-lg-4">Tambahan</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Tambahan" name="txtTambahan" id="txtTambahan" class="form-control number" value="<?php echo $tambahan; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
	                                            <label for="cmbStat" class="control-label col-lg-4">Status Kena Pajak</label>
	                                            <div class="col-lg-2">
	                                                <select id="cmbStat" name="cmbStat" class="form-control select2" data-placeholder="Choose an option"><option value="" style="width:100%;"></option>
                                                            <?php
																if($stat == "KP"){
																	$kena = "selected";
																	$tidak_kena = "";
																}else{
																	$kena = "";
																	$tidak_kena = "selected";
																}
															?>
															<option value="KP" <?php echo $kena; ?>>Kena Pajak</option>
                                                            <option value="TKP"  <?php echo $tidak_kena; ?>>Tidak Kena Pajak</option></select>
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtDesc" class="control-label col-lg-4">Desc </label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Desc " name="txtDesc" id="txtDesc" class="form-control" value="<?php echo $desc_; ?>"/>
                                            </div>
                                    </div>

	    <input type="hidden" name="txtId" value="<?php echo $id; ?>" /> </div>
                                
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