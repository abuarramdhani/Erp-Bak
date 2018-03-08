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
                                        Bppbg Account
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ProductCost/BppbgAccount');?>">
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
                                <a alt="Add New" class="pull-right" href="<?php echo site_url('ProductCost/BppbgAccount/create') ?>" title="Add New">
                                    <button class="btn btn-default btn-sm" type="button">
                                        <i class="fa fa-plus">
                                        </i>
                                    </button>
                                </a>
                                Bppbg Account List
                            </div>
                            <div class="panel-body">
                                <form id="searchBppbgAccountArea" method="post">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input class="form-control toupper" data-placement="top" data-toggle="tooltip" name="using_category_code" placeholder="Using Category Code" title="Search by Category Code" type="text">
                                            </input>
                                        </div>
                                        <div class="col-md-3">
                                            <input class="form-control toupper" data-placement="top" data-toggle="tooltip" name="account_number" placeholder="Account Number" title="Search by Account Number" type="text">
                                            </input>
                                        </div>
                                        <div class="col-md-3">
                                            <input class="form-control toupper" data-placement="top" data-toggle="tooltip" name="cost_center" placeholder="Cost Center" title="Search by Cost Center" type="text">
                                            </input>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control toupper" data-placement="top" data-toggle="tooltip" name="limit" placeholder="Limit Data" title="Set Limit data to show" type="number">
                                            </input>
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-primary btn-block" type="submit">
                                                <i class="fa fa-search">
                                                </i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div id="loadingArea">
                                    </div>
                                    <div class="col-md-12 table-responsive" id="tblBppbgAccountArea">
                                        <table class="table table-bordered table-striped table-hover" id="tblBppbgAccount">
                                            <thead class="bg-primary">
                                                <td>
                                                    No
                                                </td>
                                                <td style="width: 90px;">
                                                    Action
                                                </td>
                                                <td>
                                                    Using Category Code
                                                </td>
                                                <td>
                                                    Using Category
                                                </td>
                                                <td>
                                                    Cost Center
                                                </td>
                                                <td>
                                                    Cost Center Description
                                                </td>
                                                <td>
                                                    Account Number
                                                </td>
                                                <td>
                                                    Attribute
                                                </td>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach ($account as $value) {
                                                        // $encrypted_string = $this->encrypt->encode($value['ACCOUNT_ID']);
                                                        // $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                                ?>
                                                <tr>
                                                    <td class="col-numb" data-number="<?php echo $no; ?>">
                                                        <?php echo $no++; ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group-justified">
                                                            <a class="btn btn-default" href="<?php echo base_url('ProductCost/BppbgAccount/edit/'.$value['ACCOUNT_ID']) ?>">
                                                                <i class="fa fa-edit">
                                                                </i>
                                                            </a>
                                                            <a class="btn btn-danger" data-id="<?php echo $value['ACCOUNT_ID']; ?>" href="javascript:void(0)" onclick="deleteBppbgAccount(this,'<?php echo $value['ACCOUNT_ID'] ?>')">
                                                                <i class="fa fa-trash">
                                                                </i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td class="col-ucc" data-ucc="<?php echo $value['USING_CATEGORY_CODE']; ?>">
                                                        <?php echo $value['USING_CATEGORY_CODE']; ?>
                                                    </td>
                                                    <td class="col-uc" data-uc="<?php echo $value['USING_CATEGORY']; ?>">
                                                        <?php echo $value['USING_CATEGORY']; ?>
                                                    </td>
                                                    <td class="col-cc" data-cc="<?php echo $value['COST_CENTER']; ?>">
                                                        <?php echo $value['COST_CENTER']; ?>
                                                    </td>
                                                    <td class="col-ccd" data-ccd="<?php echo $value['COST_CENTER_DESCRIPTION']; ?>">
                                                        <?php echo $value['COST_CENTER_DESCRIPTION']; ?>
                                                    </td>
                                                    <td class="col-an" data-an="<?php echo $value['ACCOUNT_NUMBER']; ?>">
                                                        <?php echo $value['ACCOUNT_NUMBER']; ?>
                                                    </td>
                                                    <td class="col-aa" data-aa="<?php echo $value['ACCOUNT_ATTRIBUTE']; ?>">
                                                        <?php echo $value['ACCOUNT_ATTRIBUTE']; ?>
                                                    </td>
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
    </div>
</section>
<div class="row">
    <div class="col-md-12">
        <div class="modal fade" id="deleteBppbgAccountModal" role="dialog" tabindex="-1">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">
                                ×
                            </span>
                        </button>
                        <h4 class="modal-title">
                            DELETE CONFIRMATION!
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <h5>Are you sure want to delete this data?</h5>
                        </div>
                        <div class="col-md-12">
                            <table class="table">
                                <tr class="bg-primary">
                                    <td>No</td>
                                    <td>Using Category Code</td>
                                    <td>Using Category</td>
                                    <td>Cost Center</td>
                                    <td>Cost Center Description</td>
                                    <td>Account Number</td>
                                    <td>Attribute</td>
                                </tr>
                                <tr>
                                    <td id="ba_number"></td>
                                    <td id="ba_ucc"></td>
                                    <td id="ba_uc"></td>
                                    <td id="ba_cc"></td>
                                    <td id="ba_ccd"></td>
                                    <td id="ba_an"></td>
                                    <td id="ba_a"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <small class="pull-left">*Data that deleted cant be restored.</small>
                        <button class="btn btn-default" data-dismiss="modal" type="button">
                            CANCEL
                        </button>
                        <a class="btn btn-danger" id="btnDelAction">
                            DELETE
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>