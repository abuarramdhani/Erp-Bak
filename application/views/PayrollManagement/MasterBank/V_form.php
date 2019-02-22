<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Master Bank</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/MasterBank/');?>">
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
                                Master Bank
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
	                                    <label for="cmbKdBankInduk" class="control-label col-lg-4">Kode Bank Induk</label>
	                                    <div class="col-lg-4">
	                                        <select style="width:100%" id="cmbKdBankInduk" name="cmbKdBankInduk" class="select2 text-uppercase" data-placeholder="Choose an option" width="300px"><option value=""></option>
                                                <?php
													foreach ($pr_master_bank_induk_data as $row){ 
													$slc='';if($row->kd_bank_induk==$kd_bank_induk){$slc='selected';}
                                                    echo '<option '.$slc.' value="'.$row->kd_bank_induk.'">'.$row->kd_bank_induk.'</option>';
                                                    }
                                                ?>
											</select>
	                                    </div>
	                                </div>
                                    <input type="hidden" placeholder="Bank" name="txtKdBankNew" id="txtKdBankNew" class="form-control text-uppercase" value="<?php echo $kd_bank; ?>" maxlength="5" readonly />
									<div class="form-group">
                                        <label for="txtBank" class="control-label col-lg-4">Cabang</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="Cabang" name="txtBank" id="txtBank" class="form-control text-uppercase" value="<?php echo $bank; ?>" maxlength="30" />
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtPotTransfer" class="control-label col-lg-4">Pot Transfer</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="Pot Transfer" name="txtPotTransfer" id="txtPotTransfer" class="form-control number text-uppercase" onkeypress="return isNumberKey(event)" value="<?php echo $pot_transfer; ?>" maxlength="10" />
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtPotTransferTgPrshn" class="control-label col-lg-4">Pot Transfer Tg Perusahaan</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="Pot Transfer Tg Prshn" name="txtPotTransferTgPrshn" id="txtPotTransferTgPrshn" class="form-control number text-uppercase" onkeypress="return isNumberKey(event)" value="<?php echo $pot_transfer_tg_prshn; ?>" maxlength="10" />
                                        </div>
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