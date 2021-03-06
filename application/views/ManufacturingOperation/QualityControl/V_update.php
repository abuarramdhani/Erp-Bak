<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('ManufacturingOperation/QualityControl/update/'.$id);?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperation/QualityControl/');?>">
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
                                <div class="box-header with-border">Update Quality Control</div>
                                <?php
                                    foreach ($QualityControl as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="txtCheckingDateHeader" class="control-label col-lg-4">Checking Date</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtCheckingDateHeader" value="<?php echo $headerRow['checking_date'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtCheckingDateHeader" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtPrintCodeHeader" class="control-label col-lg-4">Print Code</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Print Code" name="txtPrintCodeHeader" id="txtPrintCodeHeader" class="form-control" value="<?php echo $headerRow['print_code']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtCheckingQuantityHeader" class="control-label col-lg-4">Checking Quantity</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Checking Quantity" name="txtCheckingQuantityHeader" id="txtCheckingQuantityHeader" class="form-control" value="<?php echo $headerRow['checking_quantity']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtScrapQuantityHeader" class="control-label col-lg-4">Scrap Quantity</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Scrap Quantity" name="txtScrapQuantityHeader" id="txtScrapQuantityHeader" class="form-control" value="<?php echo $headerRow['scrap_quantity']; ?>"/>
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
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>