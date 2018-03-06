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
                                        <?php echo $Title; ?>
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ProductCost/BppbgAccount/create');?>">
                                    <i aria-hidden="true" class="fa fa-user fa-2x">
                                    </i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                Create New Bppbg Account
                            </div>
                            <div class="box-body">
                                <?php foreach ($account as $value) { ?>
                                    <form class="form-horizontal" action="<?php echo base_url('ProductCost/BppbgAccount/edit/'.$id) ?>" method="post">
                                        <div class="row">
                                            <div class="col-md-8 col-md-offset-2">
                                                <div class="form-group">
                                                    <label>Using Category Code</label>
                                                    <div class="input-group">
                                                        <input type="hidden" name="using_category_code_checkout" value="0">
                                                        <input type="text" name="using_category_code" class="form-control toupper checking-database-account" placeholder="Using Category Code" required="" value="<?php echo $value['USING_CATEGORY_CODE'] ?>">
                                                        <span id="using_category_code" class="input-group-addon" data-toggle="tooltip" data-placement="top" title="Checking data in database"><i class="fa fa-info"></i></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Using Category</label>
                                                    <input class="form-control toupper" type="text" name="using_category" placeholder="Using Category" required="" value="<?php echo $value['USING_CATEGORY'] ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Cost Center</label>
                                                    <div class="input-group">
                                                        <input type="hidden" name="cost_center_checkout" value="0">
                                                        <input type="text" name="cost_center" class="form-control toupper checking-database-account" placeholder="Cost Center" required="" value="<?php echo $value['COST_CENTER'] ?>">
                                                        <span id="cost_center" class="input-group-addon" data-toggle="tooltip" data-placement="top" title="Checking data in database"><i class="fa fa-info"></i></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Cost Center Description</label>
                                                    <input class="form-control toupper" type="text" name="cost_center_description" placeholder="Cost Center Description" required="" value="<?php echo $value['COST_CENTER_DESCRIPTION'] ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Account Number</label>
                                                    <div class="input-group">
                                                        <input type="hidden" name="account_number_checkout" value="0">
                                                        <input type="text" name="account_number" class="form-control toupper checking-database-account" placeholder="Account Number" required="" value="<?php echo $value['ACCOUNT_NUMBER'] ?>">
                                                        <span id="account_number" class="input-group-addon" data-toggle="tooltip" data-placement="top" title="Checking data in database"><i class="fa fa-info"></i></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Account Attribute</label>
                                                    <input class="form-control toupper" type="text" name="account_attribute" placeholder="Account Attribute" value="<?php echo $value['ACCOUNT_ATTRIBUTE'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button id="bAccountSubmitBtn" type="submit" class="btn btn-primary pull-right">SUBMIT</button>
                                                <a class="btn btn-default pull-right" href="<?php echo base_url('ProductCost/BppbgAccount') ?>">BACK</a>
                                            </div>
                                        </div>
                                    </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>