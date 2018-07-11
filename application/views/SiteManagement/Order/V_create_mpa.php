<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('SiteManagement/Order/createMPA');?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('SiteManagement');?>">
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
                                <div class="box-header with-border">Create Order Keluar</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="txtNoOrderHeader" class="control-label col-lg-4">No Order</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="No Order" name="txtNoOrderHeader" id="txtNoOrderHeader" class="form-control" maxlength="9" required/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtTglOrderHeader" class="control-label col-lg-4">Tgl Order</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglOrderHeader" class="date form-control sm_datepicker" data-date-format="yyyy-mm-dd" id="txtTglOrderHeader" required/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtKetOrderHeader" class="control-label col-lg-4">Ket Order</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Ket Order" name="txtKetOrderHeader" id="txtKetOrderHeader" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtKetOrderDetail" class="control-label col-lg-4">Detail Order</label>
                                                <div class="col-lg-4">
                                                    <textarea placeholder="Detail Order" name="txtKetOrderDetail" class="form-control"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtDueDateHeader" class="control-label col-lg-4">Due Date</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtDueDateHeader" class="date form-control sm_datepicker" data-date-format="yyyy-mm-dd" id="txtDueDateHeader" required/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="chkRemarksHeader" class="control-label col-lg-4">Remarks</label>
                                                <div class="col-lg-4">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="chkRemarksHeader" id="chkRemarksHeader" /> 
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtRemarksDate" class="control-label col-lg-4">Remarks Date</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtRemarksDate" class="date form-control sm_datepicker" data-date-format="yyyy-mm-dd" id="txtRemarksDate" />
                                                </div>
                                            </div>


                                        </div>

                                        <div class="col-lg-12">
                                            <br />
                                            <br />
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
                                                    </ul>
                                                    <div class="tab-content">
                                                    </div>
                                                </div>
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