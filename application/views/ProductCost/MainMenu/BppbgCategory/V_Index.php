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
                                        Bppbg Category
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ProductCost/BppbgCategory');?>">
                                    <i aria-hidden="true" class="fa fa-user fa-2x">
                                    </i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title">Bppbg Category List</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box box-default box-solid collapsed-box">
                                            <div class="box-header">
                                                <h3 class="box-title">Insert New Category</h3>
                                                <div class="pull-right box-tools">
                                                    <button type="button" class="btn btn-default btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Show/Hide Panel">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <form method="post" action="<?php echo base_url('ProductCost/BppbgCategory/create') ?>">
                                                            <div class="form-group">
                                                                <label>Category Code</label>
                                                                <input type="text" name="category_code" class="form-control toupper" placeholder="Category Code" required="">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Category Description</label>
                                                                <input type="text" name="category_description" class="form-control toupper" placeholder="Category Description" required="">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>General Description</label>
                                                                <input type="text" name="general_description" class="form-control toupper" placeholder="General Description">
                                                            </div>
                                                            <div class="form-group pull-right">
                                                                <input type="submit" class="btn btn-primary" value="INSERT">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 table-responsive" id="tblBppbgAccountArea">
                                        <table class="table table-bordered table-striped table-hover" id="tblBppbgCategory">
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
                                                    General Description
                                                </td>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($category as $value) { ?>
                                                    <tr>
                                                        <td class="c_number" data-number="<?php echo $no; ?>"><?php echo $no++; ?></td>
                                                        <td>
                                                            <div class="btn-group-justified">
                                                                <a class="btn btn-default" href="javascript:void(0)" onclick="editBppbgCategory(this, '<?php echo $value['ID'] ?>')">
                                                                <!-- <a class="btn btn-default" href="<?php echo base_url(''.$value['ID']) ?>"> -->
                                                                    <i class="fa fa-edit">
                                                                    </i>
                                                                </a>
                                                                <a class="btn btn-danger" data-id="<?php echo $value['ID']; ?>" href="javascript:void(0)" onclick="deleteBppbgCategory(this,'<?php echo $value['ID'] ?>')">
                                                                    <i class="fa fa-trash">
                                                                    </i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td class="c_ucc" data-ucc="<?php echo $value['USING_CATEGORY_CODE']; ?>"><?php echo $value['USING_CATEGORY_CODE']; ?></td>
                                                        <td class="c_ucd" data-ucd="<?php echo $value['USING_CATEGORY_DESCRIPTION']; ?>"><?php echo $value['USING_CATEGORY_DESCRIPTION']; ?></td>
                                                        <td class="c_gd" data-gd="<?php echo $value['GENERAL_DESCRIPTION']; ?>"><?php echo $value['GENERAL_DESCRIPTION']; ?></td>
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
        <div class="modal fade" id="editBppbgCategoryModal" role="dialog" tabindex="-1">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">
                                ×
                            </span>
                        </button>
                        <h4 class="modal-title">
                            EDIT BPPBG CATEGORY
                        </h4>
                    </div>
                    <form id="editBppbgCategoryForm" method="post">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Category Code</label>
                                            <input type="text" name="category_code" class="form-control toupper" placeholder="Category Code" required="">
                                        </div>
                                        <div class="form-group">
                                            <label>Category Description</label>
                                            <input type="text" name="category_description" class="form-control toupper" placeholder="Category Description" required="">
                                        </div>
                                        <div class="form-group">
                                            <label>General Description</label>
                                            <textarea name="general_description" class="form-control toupper" placeholder="General Description" rowspan></textarea>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal" type="button">
                                CANCEL
                            </button>
                            <button type="submit" class="btn btn-primary">SAVE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="modal fade" id="deleteBppbgCategoryModal" role="dialog" tabindex="-1">
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
                                    <td>General Description</td>
                                </tr>
                                <tr>
                                    <td id="bc_number"></td>
                                    <td id="bc_ucc"></td>
                                    <td id="bc_uc"></td>
                                    <td id="bc_gd"></td>
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