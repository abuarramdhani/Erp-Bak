<style>
    input.car_date {
        text-transform: uppercase;
    }
</style>
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
                                    <i class="fa fa-pencil fa-2x">
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
                        <div class="box box-info">
                            <div class="box-header with-border"></div>
                            <form name="Orderform" enctype="multipart/form-data" onsubmit="return validasi();window.location.reload();" method="post">
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="col-md-1"><label>No CAR</label></div>
                                        <div class="col-md-4"><input name="car_num" type="text" class="form-control" readonly value="<?= $dataToEdit[0]['CAR_NUM'] ?>" /></div>
                                        <div class="col-md-2" style="text-align: right;"><label>Type CAR</label></div>
                                        <div class="col-md-4"><input name="car_type" type="text" class="form-control" readonly value="<?= $dataToEdit[0]['CAR_TYPE'] ?>" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-1"><label>Supplier</label></div>
                                        <div class="col-md-4"><input name="car_supplier" type="text" class="form-control" readonly value="<?= $dataToEdit[0]['SUPPLIER_NAME'] ?>" /></div>
                                        <div class="col-md-2" style="text-align: right;"><label>NC Scope</label></div>
                                        <div class="col-md-4"><input name="car_nc_scope" type="text" class="form-control" readonly value="<?= $dataToEdit[0]['NC_SCOPE'] ?>" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12">
                                            <table class="table table-bordered" id="edit_CAR" style="width: 100%;">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th class="text-center">PO Number</th>
                                                        <th class="text-center">Line</th>
                                                        <th class="text-center">Item Code</th>
                                                        <th class="text-center">Item Description</th>
                                                        <th class="text-center">UoM</th>
                                                        <th class="text-center">Qty PO</th>
                                                        <th class="text-center">Received Date PO</th>
                                                        <th class="text-center">Shipment Date</th>
                                                        <th class="text-center">LPPB Number</th>
                                                        <th class="text-center">Actual Receive Date</th>
                                                        <th class="text-center">Qty Receipt</th>
                                                        <th class="text-center">Notes</th>
                                                        <th class="text-center">Detail Rootcause</th>
                                                        <th class="text-center">Rootcause Category</th>
                                                        <th class="text-center">Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1;
                                                    foreach ($dataToEdit as $v) { ?>
                                                        <tr>
                                                            <input type="hidden" name="car_id[]" value="<?= $v['CAR_ID'] ?>" />
                                                            <td class="text-center"><input name="car_po_num[]" style="width: 100px;" type="text" class="form-control" value="<?= $v['PO_NUMBER'] ?>" /></td>
                                                            <td class="text-center"><input name="car_line[]" style="width: 100px;" type="text" class="form-control" value="<?= $v['LINE'] ?>" /></td>
                                                            <td class="text-center">
                                                                <select name="car_item_code[]" id="car_item_code<?= $i ?>" style="width: 300px;" type="text" onchange="getDescription(<?= $i ?>)" class="form-control select2 itemm_code">
                                                                    <option value="<?= $v['ITEM_CODE'] ?>"><?= $v['ITEM_CODE'] ?> - <?= $v['ITEM_DESCRIPTION'] ?></option>
                                                                </select>
                                                            </td>
                                                            <td class="text-center"><input name="car_item_desc[]" id="desc_item<?= $i ?>" type="text" readonly class="form-control" value="<?= $v['ITEM_DESCRIPTION'] ?>" /></td>
                                                            <td class="text-center"><input name="car_uom[]" id="uom_item<?= $i ?>" style="width: 50px;" readonly type="text" class="form-control" value="<?= $v['UOM'] ?>" /></td>
                                                            <td class="text-center"><input name="car_qty_po[]" style="width: 100px;" type="text" class="form-control" value="<?= $v['QTY_PO'] ?>" /></td>
                                                            <td class="text-center"><input name="car_receive_date[]" style="width: 150px;" type="text" class="form-control car_date" value="<?= $v['RECEIVED_DATE_PO'] ?>" /></td>
                                                            <td class="text-center"><input name="car_ship_date[]" style="width: 150px;" type="text" class="form-control car_date" value="<?= $v['SHIPMENT_DATE'] ?>" /></td>
                                                            <td class="text-center"><input name="car_lppb[]" style="width: 150px;" type="text" class="form-control" value="<?= $v['LPPB_NUMBER'] ?>" /></td>
                                                            <td class="text-center"><input name="car_act_receive_date[]" style="width: 150px;" type="text" class="form-control car_date" value="<?= $v['ACTUAL_RECEIPT_DATE'] ?>" /></td>
                                                            <td class="text-center"><input name="car_qty_receipt[]" style="width: 100px;" type="text" class="form-control" value="<?= $v['QTY_RECEIPT'] ?>" /></td>
                                                            <td class="text-center"><input name="car_notes[]" type="text" class="form-control" value="<?= $v['NOTES'] ?>" /></td>
                                                            <td class="text-center"><input name="car_detail_rootcause[]" type="text" class="form-control" value="<?= $v['DETAIL_ROOTCAUSE'] ?>" /></td>
                                                            <td class="text-center"><input name="car_rootcause_category[]" type="text" class="form-control" value="<?= $v['ROOTCAUSE_CATEGORI'] ?>" /></td>
                                                            <td class="text-center"><a onclick="deleteItem(<?= $v['CAR_ID'] ?>)" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i></a></td>
                                                        </tr>
                                                    <?php $i++;
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12" style="text-align: right;"><button formaction="<?php echo base_url('CARVP/ListData'); ?>" class="btn btn-default">Back</button> <button formaction="<?php echo base_url('CARVP/ListData/SaveChangesCAR'); ?>" class="btn btn-success">Save Changes</button></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>