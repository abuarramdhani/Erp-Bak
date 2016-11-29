<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
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
                                Read Master Bank
                            </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <div class="row">
									<div class="form-group">
                                        <label for="txtKdBank" class="control-label col-lg-4">Kode Bank</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtKdBank" id="txtKdBank" class="form-control" value="<?php echo $kd_bank; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtBank" class="control-label col-lg-4">Bank</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtBank" id="txtBank" class="form-control" value="<?php echo $bank; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtPotTransfer" class="control-label col-lg-4">Pot Transfer</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtPotTransfer" id="txtPotTransfer" class="form-control" value="<?php echo $pot_transfer; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtPotTransferTgPrshn" class="control-label col-lg-4">Pot Transfer Tg Perusahaan</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtPotTransferTgPrshn" id="txtPotTransferTgPrshn" class="form-control" value="<?php echo $pot_transfer_tg_prshn; ?>" readonly/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtKdBankInduk" class="control-label col-lg-4">Kode Bank Induk</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtKdBankInduk" id="txtKdBankInduk" class="form-control" value="<?php echo $kd_bank_induk; ?>" readonly/>
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