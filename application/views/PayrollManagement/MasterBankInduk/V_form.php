<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Master Bank Induk</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/MasterBankInduk/');?>">
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
                                Master Bank Induk
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
                                            <label for="txtKdBankIndukNew" class="control-label col-lg-4">Kode Bank Induk</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Kode Bank Induk" name="txtKdBankIndukNew" id="txtKdBankIndukNew" class="form-control  text-uppercase" value="<?php echo $kd_bank_induk; ?>" maxlength="3"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtBankInduk" class="control-label col-lg-4">Bank Induk</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Bank Induk" name="txtBankInduk" id="txtBankInduk" class="form-control text-uppercase" value="<?php echo $bank_induk; ?>" maxlength="30"/>
                                            </div>
                                    </div>
									<input type="hidden" placeholder="Kode Bank Induk" name="txtKdBankInduk" id="txtKdBankInduk" class="form-control " value="<?php echo $kd_bank_induk; ?>" maxlength="3"/>
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