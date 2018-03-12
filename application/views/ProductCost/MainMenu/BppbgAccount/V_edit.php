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
                                Edit Bppbg Account
                            </div>
                            <div class="box-body">
                                <?php foreach ($account as $value) { ?>
                                    <form class="form-horizontal" action="<?php echo base_url('ProductCost/BppbgAccount/edit/'.$id) ?>" method="post">
                                        <div class="row">
                                            <div class="col-md-8 col-md-offset-2">
                                                <div class="form-group">
                                                    <label>Category Code</label>
                                                    <div class="input-group">
                                                        <input type="hidden" name="using_category_code_checkout" value="0">
                                                        <input type="text" name="using_category_code" class="form-control toupper checking-database-account" placeholder="Using Category Code" required="" value="<?php echo $value['USING_CATEGORY_CODE'] ?>" onfocus="slcBppbgCategory()">
                                                        <span id="using_category_code" class="input-group-addon" data-toggle="tooltip" data-placement="top" title="Checking data in database"><i class="fa fa-info"></i></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Category Description</label>
                                                    <input class="form-control" type="text" name="using_category" placeholder="Category Description"  value="<?php echo $value['USING_CATEGORY'] ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Cost Center</label>
                                                    <div class="input-group">
                                                        <input type="hidden" name="cost_center_checkout" value="0">
                                                        <input type="text" name="cost_center" class="form-control checking-database-account" placeholder="Cost Center" required="" value="<?php echo $value['COST_CENTER'] ?>" onfocus="slcCostCenter()">
                                                        <span id="cost_center" class="input-group-addon" data-toggle="tooltip" data-placement="top" title="Checking data in database"><i class="fa fa-info"></i></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Cost Center Description</label>
                                                    <input class="form-control" type="text" name="cost_center_description" placeholder="Cost Center Description" value="<?php echo $value['COST_CENTER_DESCRIPTION'] ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Account Number</label>
                                                    <div class="input-group">
                                                        <input type="hidden" name="account_number_checkout" value="0">
                                                        <select name="account_number" class="form-control select2 checking-database-account" data-placeholder="Account Number">
                                                            <option></option>
                                                            <?php foreach ($accountnumber as $an) {
                                                                if ($value['ACCOUNT_NUMBER']==$an['ACCOUNT_NUMBER']) {
                                                            ?>
                                                                <option value="<?php echo $an['ACCOUNT_NUMBER'] ?>" selected>
                                                                    <?php echo $an['ACCOUNT_NUMBER'].' | '.$an['ACCOUNT_NUMBER_DESCRIPTION']; ?>
                                                                </option>
                                                            <?php
                                                                }else{
                                                            ?>
                                                                <option value="<?php echo $an['ACCOUNT_NUMBER'] ?>">
                                                                    <?php echo $an['ACCOUNT_NUMBER'].' | '.$an['ACCOUNT_NUMBER_DESCRIPTION']; ?>
                                                                </option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
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

<div class="row">
    <div class="col-md-12">
        <div class="modal fade" id="slcBppbgCategoryModal" role="dialog" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-lg">
                    <div class="modal-header">
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">
                                ×
                            </span>
                        </button>
                        <h4 class="modal-title">
                            Select Bppbg Category!
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-hover datatable-default" width="100%">
                                    <thead class="bg-primary">
                                        <td>No</td>
                                        <td>Category Code</td>
                                        <td>Category Description</td>
                                        <td>General Description</td>
                                    </thead>
                                    <tbody>
                                    <?php $x=1; foreach ($category as $c) { ?>
                                        <tr style="cursor: pointer;" onclick="slcBppbgCategoryProceed('<?php echo $c['USING_CATEGORY_CODE']; ?>','<?php echo $c['USING_CATEGORY_DESCRIPTION']; ?>')">
                                            <td><?php echo $x++; ?></td>
                                            <td><?php echo $c['USING_CATEGORY_CODE']; ?></td>
                                            <td><?php echo $c['USING_CATEGORY_DESCRIPTION']; ?></td>
                                            <td><?php echo $c['GENERAL_DESCRIPTION']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="modal fade" id="slcCostCenterModal" role="dialog" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-lg">
                    <div class="modal-header">
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">
                                ×
                            </span>
                        </button>
                        <h4 class="modal-title">
                            Select Cost Center!
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-hover datatable-default" width="100%">
                                    <thead class="bg-primary">
                                        <td>No</td>
                                        <td>Cost Center</td>
                                        <td>Cost Center Description</td>
                                    </thead>
                                    <tbody>
                                    <?php $no=1; foreach ($costcenter as $cc) { ?>
                                        <tr style="cursor: pointer;" onclick="slcCostCenterProceed('<?php echo $cc['COST_CENTER']; ?>','<?php echo $cc['COST_CENTER_DESCRIPTION']; ?>')">
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $cc['COST_CENTER']; ?></td>
                                            <td><?php echo $cc['COST_CENTER_DESCRIPTION']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>