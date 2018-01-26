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
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperation/Job/ReplaceComp');?>">
                                    <i class="icon-wrench icon-2x">
                                    </i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12">
                        <?php foreach ($jobHeader as $value) {
                            if (!empty($jobLine)) {
                                $section = $jobLine[0]['SEKSI'];
                            }else{
                                $section = '-';
                            }
                        ?>
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title">Picklist Component</h3>
                                <div class="pull-right box-tools">
                                    <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Show/Hide Panel">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body" id="parentData">
                                    <input name="jobNumber" type="hidden" value="<?php echo $value['WIP_ENTITY_NAME']; ?>">
                                    <input name="assyCode" type="hidden" value="<?php echo $value['SEGMENT1']; ?>">
                                    <input name="assyDesc" type="hidden" value="<?php echo $value['DESCRIPTION']; ?>">
                                    <input name="section" type="hidden" value="<?php echo $section; ?>">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                JOB NUMBER
                                            </div>
                                            <div class="col-md-8">
                                                :
                                                <?php echo $value['WIP_ENTITY_NAME']; ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                ASSY CODE
                                            </div>
                                            <div class="col-md-8">
                                                :
                                                <?php echo $value['SEGMENT1']; ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                DESCRIPTION
                                            </div>
                                            <div class="col-md-8">
                                                :
                                                <?php echo $value['DESCRIPTION']; ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                SECTION
                                            </div>
                                            <div class="col-md-8">
                                                :
                                                <?php echo $section; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover" id="jobTable">
                                                <thead class="bg-primary">
                                                    <td>
                                                        NO
                                                    </td>
                                                    <td>
                                                        COMPONENT CODE
                                                    </td>
                                                    <td>
                                                        DESCRIPTION
                                                    </td>
                                                    <td>
                                                        PICKLIST QUANTITY
                                                    </td>
                                                    <td>
                                                        REJECT
                                                    </td>
                                                    <td>
                                                        UOM
                                                    </td>
                                                    <td>
                                                        ACTION
                                                    </td>
                                                </thead>
                                                <tbody>
                                                    <?php $no=1; foreach ($jobLine as $val) { ?>
                                                    <tr row-id="<?php echo $no; ?>">
                                                        <input name="compCode" type="hidden" value="<?php echo $val['SEGMENT1']; ?>">
                                                        <input name="compDesc" type="hidden" value="<?php echo $val['DESCRIPTION']; ?>">
                                                        <input name="qty" type="hidden" value="<?php echo $val['ITEM_NUM']; ?>">
                                                        <input name="uom" type="hidden" value="<?php echo $val['PRIMARY_UOM_CODE']; ?>">
                                                        <td>
                                                            <?php echo $no; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $val['SEGMENT1']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $val['DESCRIPTION']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $val['ITEM_NUM']; ?>
                                                        </td>
                                                        <td class="rejectArea" data-reject="0">
                                                            -
                                                        </td>
                                                        <td>
                                                            <?php echo $val['PRIMARY_UOM_CODE']; ?>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-block" onclick="modalReject(this,'<?php echo $no++ ?>')" type="button" data-toggle="tooltip" data-placement="left" title="Add Reject Component">
                                                                <i class="fa fa-plus">
                                                                </i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title">Replacement Component</h3>
                                <div class="pull-right box-tools">
                                    <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Show/Hide Panel">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped" id="rejectTable">
                                                <thead class="bg-primary">
                                                    <td>
                                                        NO
                                                    </td>
                                                    <td>
                                                        COMPONENT CODE
                                                    </td>
                                                    <td>
                                                        DESCRIPTION
                                                    </td>
                                                    <td>
                                                        RETURN
                                                    </td>
                                                    <td>
                                                        UOM
                                                    </td>
                                                    <td>
                                                        INFORMATION
                                                    </td>
                                                    <td>
                                                        ACTION
                                                    </td>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <div class="row text-right">
                                        <a class="btn btn-default" href="<?php echo base_url('ManufacturingOperation/Job/ReplaceComp/clearJob/'.$value['WIP_ENTITY_NAME']); ?>">CLEAR</a>
                                        <a target="_blank" class="btn btn-primary" href="<?php echo base_url('ManufacturingOperation/Job/ReplaceComp/submitJob/'.$value['WIP_ENTITY_NAME']); ?>">SUBMIT</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="modalReject" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
                <h4 class="modal-title">
                    Input Reject Information
                </h4>
            </div>
            <form method="post" class="form-horizontal" onsubmit="proceedRejectComp()" id="rejectForm">
                <input type="hidden" name="rowID">
                <div class="modal-body">
                    <div class="col-md-6">
                        <div class="form-group col-md-12">
                            <label>Job Number</label>
                            <input name="jobNumber" type="text" class="form-control" readonly="">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Assy Code</label>
                            <input name="assyCode" type="text" class="form-control" readonly="">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Assy Description</label>
                            <input name="assyDesc" type="text" class="form-control" readonly="">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Section</label>
                            <input name="section" type="text" class="form-control" readonly="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group col-md-12">
                            <label>Component Code</label>
                            <input name="compCode" type="text" class="form-control" readonly="">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Component Description</label>
                            <input name="compDesc" type="text" class="form-control" readonly="">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Picklist Quantity</label>
                            <input name="qty" type="text" class="form-control" readonly="">
                        </div>
                        <div class="form-group col-md-12">
                            <label>UOM</label>
                            <input name="uom" type="text" class="form-control" readonly="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Return Quantity</label> 
                            <input type="number" name="returnQty" class="form-control" placeholder="Return Quantity" min="1" required="">
                        </div>
                        <div class="form-group">
                            <label>Return Information</label>
                            <textarea class="form-control toupper" name="returnInfo" rows="3" placeholder="Return Information" required=""></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="button">
                        CANCEL
                    </button>
                    <button class="btn btn-primary" type="submit" id="btnSubmit">
                        PROCEED
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>