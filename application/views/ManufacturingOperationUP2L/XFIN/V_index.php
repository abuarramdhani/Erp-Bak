<section class="content">
    <div class="inner">
        <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                    <h1>
                                        <b>
                                            <?= $Title ?> 
                                        </b>
                                    </h1>
                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg"
                                        href="<?php echo site_url('ManufacturingOperationUP2L/XFIN/');?>">
                                        <i class="icon-wrench icon-2x">
                                        </i>
                                        <span>
                                            <br />
                                        </span>
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
                                    Generate XFIN
                                </div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <form action="<?php echo base_url('ManufacturingOperationUP2L/XFIN/export');?>" class="form-horizontal" autocomplete="off" method="post">
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Start Date</label>
                                                <div class="col-md-4">
                                                    <input type="text" id="txtStartDate" name="txtStartDate" required="true" class="form-control time-form1" autocomplete="off" placeholder="Start Date">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">End Date</label>
                                                <div class="col-md-4">
                                                    <input type="text" id="txtEndDate" name="txtEndDate" required="true" class="form-control time-form1" autocomplete="off" placeholder="End Date">
                                                </div>
                                            </div> <br />
                                            <center><input type="submit" class="btn btn-success"></center>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</section>