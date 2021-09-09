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
                                <a class="btn btn-default btn-lg">
                                    <i class="fa fa-list fa-2x">
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
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header with-border"></div>
                            <form name="Orderform" enctype="multipart/form-data" onsubmit="return validasi();window.location.reload();" method="post">
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="col-md-12">
                                            <table class="table table-bordered" id="hsl_imprt">
                                                <thead class="bg-yellow">
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th class="text-center">Supplier Name</th>
                                                        <th class="text-center">PO Number</th>
                                                        <th class="text-center">Line</th>
                                                        <th class="text-center">Item Code</th>
                                                        <th class="text-center">Item Description</th>
                                                        <th class="text-center">UOM</th>
                                                        <th class="text-center">Qty PO</th>
                                                        <th class="text-center">Receive Date PO</th>
                                                        <th class="text-center">Shipment Date</th>
                                                        <th class="text-center">LPPB Number</th>
                                                        <th class="text-center">Actual Receipt Date</th>
                                                        <th class="text-center">Qty Receipt</th>
                                                        <th class="text-center">Notes</th>
                                                        <th class="text-center">Detail Rootcause</th>
                                                        <th class="text-center">Rootcause Category</th>
                                                        <th class="text-center">CAR Type</th>
                                                        <th class="text-center">NC Scope</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1;
                                                    foreach ($array_import as $v) { ?>
                                                        <tr>
                                                            <td class="text-center"><?= $i ?></td>
                                                            <td class="text-center"><input type="hidden" name="car_supplier[]" value="<?= $v['supplier'] ?>" /><?= $v['supplier'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="car_po[]" value="<?= $v['po'] ?>" /><?= $v['po'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="car_line[]" value="<?= $v['line'] ?>" /><?= $v['line'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="car_item_code[]" value="<?= $v['item_code'] ?>" /><?= $v['item_code'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="car_item_desc[]" value="<?= $v['item_desc'] ?>" /><?= $v['item_desc'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="car_uom[]" value="<?= $v['uom'] ?>" /><?= $v['uom'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="car_qty_po[]" value="<?= $v['qty_po'] ?>" /><?= $v['qty_po'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="car_received_date_po[]" value="<?= $v['received_date_po'] ?>" /><?= $v['received_date_po'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="car_shipment_date[]" value="<?= $v['shipment_date'] ?>" /><?= $v['shipment_date'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="car_lppb[]" value="<?= $v['lppb'] ?>" /><?= $v['lppb'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="car_act_receipt_date[]" value="<?= $v['act_receipt_date'] ?>" /><?= $v['act_receipt_date'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="car_qty_receipt[]" value="<?= $v['qty_receipt'] ?>" /><?= $v['qty_receipt'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="car_notes[]" value="<?= $v['notes'] ?>" /><?= $v['notes'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="car_detail_rootcause[]" value="<?= $v['detail_rootcause'] ?>" /><?= $v['detail_rootcause'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="car_rootcause_category[]" value="<?= $v['rootcause_category'] ?>" /><?= $v['rootcause_category'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="car_car_type[]" value="<?= $v['car_type'] ?>" /><?= $v['car_type'] ?></td>
                                                            <td class="text-center"><input type="hidden" name="car_nc_scope[]" value="<?= $v['nc_scope'] ?>" /><?= $v['nc_scope'] ?></td>
                                                            <input type="hidden" name="date_source[]" value="<?= $v['date_source'] ?>" />
                                                        </tr>
                                                    <?php $i++;
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12" style="text-align: right;"><button formaction="<?php echo base_url('CARVP/Input/InsertImport'); ?>" class="btn btn-danger">Save</button></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>