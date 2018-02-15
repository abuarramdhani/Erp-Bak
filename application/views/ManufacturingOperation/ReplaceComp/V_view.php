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
                                        <strong>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    JOB NUMBER
                                                </div>
                                                <div class="col-md-9">
                                                    :
                                                    <?php echo $value['WIP_ENTITY_NAME']; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    ASSY CODE
                                                </div>
                                                <div class="col-md-9">
                                                    :
                                                    <?php echo $value['SEGMENT1']; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    DESCRIPTION
                                                </div>
                                                <div class="col-md-9">
                                                    :
                                                    <?php echo $value['DESCRIPTION']; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    SECTION
                                                </div>
                                                <div class="col-md-9">
                                                    :
                                                    <?php echo $section; ?>
                                                </div>
                                            </div>
                                        </strong>
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
                                                        SUBINVENTORY
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
                                                        <input name="qty" type="hidden" value="<?php echo $val['COMPONENT_QUANTITY']; ?>">
                                                        <input name="uom" type="hidden" value="<?php echo $val['PRIMARY_UOM_CODE']; ?>">
                                                        <input name="subinv" type="hidden" value="<?php echo $val['SUBINVENTORY_CODE']; ?>">
                                                        <input name="asal" type="hidden" value="<?php echo $val['ASAL']; ?>">
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
                                                            <?php echo $val['SUBINVENTORY_CODE']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $val['COMPONENT_QUANTITY']; ?>
                                                        </td>
                                                        <td class="rejectArea" data-reject="<?php echo $val['REJECT_QTY']; ?>">
                                                            <?php echo $val['REJECT_QTY']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $val['PRIMARY_UOM_CODE']; ?>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-block" onclick="modalReject(this,'<?php echo $no++ ?>')" type="button" data-toggle="tooltip" data-placement="left" title="Add Reject Component" <?php if ($val['COMPONENT_QUANTITY'] == $val['REJECT_QTY']) {echo "disabled";} ?>>
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
                                                        SUBINVENTORY
                                                    </td>
                                                    <td>
                                                        ACTION
                                                    </td>
                                                </thead>
                                                <tbody>
                                                    <?php $numb=1; foreach ($jobLineReject as $rj) { ?>
                                                        <tr row-id="<?php echo $numb; ?>" data-subinv="<?php echo $rj['subinventory_code'] ?>">
                                                            <td><?php echo $numb++; ?></td>
                                                            <td><?php echo $rj['component_code'] ?></td>
                                                            <td><?php echo $rj['component_description'] ?></td>
                                                            <td><?php echo $rj['return_quantity'] ?></td>
                                                            <td><?php echo $rj['uom'] ?></td>
                                                            <td><?php echo $rj['return_information'] ?></td>
                                                            <td><?php echo $rj['subinventory_code'] ?></td>
                                                            <td>
                                                                <a href="<?php echo base_url('ManufacturingOperation/Job/ReplaceComp/deleteRejectComp/'.$value['WIP_ENTITY_NAME'].'/'.$rj['replacement_component_id']) ?>" onclick="return confirm('Are you sure to remove this data?');" class="btn btn-danger btn-block" data-toggle="tooltip" data-placement="left" title="Remove Reject Component">
                                                                    <i class="fa fa-minus"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer" id="generateBtnArea">
                                    <div class="row text-right">
                                        <a id="btnClearRjc" class="btn btn-default btnReject" href="<?php echo base_url('ManufacturingOperation/Job/ReplaceComp/clearJob/'.$value['WIP_ENTITY_NAME']); ?>" <?php if (empty($jobLineReject)) { echo "disabled"; } ?>>CLEAR</a>
                                        <button id="btnFormRjc" class="btn btn-primary btnReject" onclick="submitFormRjc('<?php echo $value['WIP_ENTITY_NAME']; ?>')" <?php if (empty($jobLineReject)) { echo "disabled"; } ?>>FORM REJECT</button>
                                        <button id="btnKIBRjc" class="btn btn-primary btnReject" onclick="submitJobKIB(this, '<?php echo $value['WIP_ENTITY_NAME'] ?>')" <?php if (empty($jobLineReject)) { echo "disabled"; } ?>>KIB</button>
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <label>Job Number</label>
                                <input name="jobNumber" type="text" class="form-control" readonly="">
                            </div>
                            <div class="col-md-12">
                                <label>Assy Code</label>
                                <input name="assyCode" type="text" class="form-control" readonly="">
                            </div>
                            <div class="col-md-12">
                                <label>Assy Description</label>
                                <input name="assyDesc" type="text" class="form-control" readonly="">
                            </div>
                            <div class="col-md-12">
                                <label>Section</label>
                                <input name="section" type="text" class="form-control" readonly="">
                            </div>
                            <div class="col-md-12">
                                <label>SubInventory</label>
                                <input name="subinv" type="text" class="form-control" readonly="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <label>Component Code</label>
                                <input name="compCode" type="text" class="form-control" readonly="">
                            </div>
                            <div class="col-md-12">
                                <label>Component Description</label>
                                <input name="compDesc" type="text" class="form-control" readonly="">
                            </div>
                            <div class="col-md-12">
                                <label>Picklist Quantity</label>
                                <input name="qty" type="text" class="form-control" readonly="">
                            </div>
                            <div class="col-md-12">
                                <label>UOM</label>
                                <input name="uom" type="text" class="form-control" readonly="">
                            </div>
                            <div class="col-md-12">
                                <label>Section Source</label>
                                <input name="asal" type="text" class="form-control" readonly="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <label>Return Quantity</label> 
                                <input type="number" name="returnQty" class="form-control" placeholder="Return Quantity" min="1" required="">
                            </div>
                            <div class="col-md-12">
                                <label>Return Information</label>
                                <textarea class="form-control toupper" name="returnInfo" rows="3" placeholder="Return Information" required="" maxlength="250"></textarea>
                            </div>
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
<div class="modal fade" id="modalFormReject" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
                <h4 class="modal-title">
                    Set Report
                </h4>
            </div>
            <form method="post" target="_blank" action="<?php echo base_url('ManufacturingOperation/Job/ReplaceComp/submitJobForm/'.$id) ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Select Subinventory</label>
                            <div id="subinvArea"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="button">
                        CANCEL
                    </button>
                    <button class="btn btn-primary" type="submit" id="btnSubmit" disabled="true">
                        PROCEED
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>