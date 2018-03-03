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
                                <form class="form-horizontal" action="<?php echo base_url('ProductCost/BppbgAccount/create') ?>" method="post">
                                    <div class="row">
                                        <div class="col-md-8 col-md-offset-2">
                                            <div class="form-group">
                                                <label>Using Category Code</label>
                                                <div class="input-group">
                                                    <input type="text" name="using_category_code" class="form-control toupper" placeholder="Using Category Code" required="">
                                                    <span class="input-group-addon" data-toggle="tooltip" data-placement="top" title="Checking data in database"><i class="fa fa-circle-o-notch fa-spin"></i></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Using Category</label>
                                                <input class="form-control toupper" type="text" name="using_category" placeholder="Using Category" required="">
                                            </div>
                                            <div class="form-group">
                                                <label>Cost Center</label>
                                                <div class="input-group">
                                                    <input class="form-control toupper" type="text" name="cost_center" placeholder="Cost Center" required="">
                                                    <span class="input-group-addon" data-toggle="tooltip" data-placement="top" title="Checking data in database"><i class="fa fa-circle-o-notch fa-spin"></i></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Cost Center Description</label>
                                                <input class="form-control toupper" type="text" name="cost_center_description" placeholder="Cost Center Description" required="">
                                            </div>
                                            <div class="form-group">
                                                <label>Account Number</label>
                                                <div class="input-group">
                                                    <input class="form-control toupper" type="text" name="account_number" placeholder="Account Number" required="">
                                                    <span class="input-group-addon" data-toggle="tooltip" data-placement="top" title="Checking data in database"><i class="fa fa-circle-o-notch fa-spin"></i></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Account Attribute</label>
                                                <input class="form-control toupper" type="text" name="account_attribute" placeholder="Account Attribute">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary pull-right">SUBMIT</button>
                                            <a class="btn btn-default pull-right" href="<?php echo base_url('ProductCost/BppbgAccount') ?>">BACK</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>