<?php if ($path[1] == 'AutoInvoice') { ?>
    <div class="panel-body">
        <div class="col-md-12">
            <table class="table table-bordered" id="tbl_do_finish">
                <thead class="bg-green">
                    <tr>
                        <!-- <th class="text-center"><input type="checkbox" class="cekAllFinish"></th> -->
                        <th class="text-center">NO</th>
                        <th class="text-center">NO DO</th>
                        <th class="text-center">SO NUMBER</th>
                        <th class="text-center">OU</th>
                        <th class="text-center">INVOICE NUM</th>
                        <th class="text-center">INVOICE AMMOUNT</th>
                        <th class="text-center">RDO AMMOUNT</th>
                        <th class="text-center" style="width: 200px;">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $angka = 1;
                    foreach ($DoFinish as $key => $red) {
                        if ($red['AMMOUNT_INVOICE'] != $red['AMMOUNT_RDO']) {
                            $bg = 'bg-warning';
                        } else {
                            $bg = '';
                        }
                        if ($red['APPROVAL_FLAG'] == 'Y') {
                    ?>
                            <tr class="<?= $bg ?>">
                                <!-- <td class="text-center"><input type="checkbox" class="cekListFinish" data-row="<?= $angka ?>"></td> -->
                                <td class="text-center"><?= $angka ?></td>
                                <td class="text-center"><?= $red['WDD_BATCH_ID'] ?></td>
                                <td class="text-center"><?= $red['OOH_ORDER_NUMBER'] ?></td>
                                <td class="text-center"><?= $red['NAME'] ?></td>
                                <td class="text-center"><?= $red['TRX_NUMBER'] ?></td>
                                <td class="text-center"><?= number_format($red['AMMOUNT_INVOICE'], 0) ?></td>
                                <td class="text-center"><?= number_format($red['AMMOUNT_RDO'], 0) ?></td>
                                <td class="text-center">
                                    <?php if ($red['APPROVAL_FLAG'] == 'Y') { ?>
                                        <a class="btn btn-danger btn-sm" target="_blank" href="<?= base_url('AutoInvoice/FinishInvoice/CetakInvoice/' . $red['CETAK_INVOICE_REQ_ID']) ?>">Cetak Invoice</a>
                                        <a class="btn btn-danger btn-sm" target="_blank" href="<?= base_url('AutoInvoice/FinishInvoice/CetakRDO/' . $red['CETAK_RDO_REQ_ID']) ?>">Cetak RDO</a>
                                    <?php } ?>
                                </td>
                            </tr>
                    <?php $angka++;
                        }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } else { ?>
    <div class="panel-body">
        <div class="col-md-12">
            <table class="table table-bordered" id="tbl_do_finish">
                <thead class="bg-green">
                    <tr>
                        <th class="text-center"><input type="checkbox" class="cekAllFinish"></th>
                        <th class="text-center">NO</th>
                        <th class="text-center">NO DO</th>
                        <th class="text-center">SO NUMBER</th>
                        <th class="text-center">OU</th>
                        <th class="text-center">INVOICE NUM</th>
                        <th class="text-center">INVOICE AMMOUNT</th>
                        <th class="text-center">RDO AMMOUNT</th>
                        <th class="text-center" style="width: 200px;">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $angka = 1;
                    foreach ($DoFinish as $key => $red) {
                        if ($red['AMMOUNT_INVOICE'] != $red['AMMOUNT_RDO']) {
                            $bg = 'bg-warning';
                        } else {
                            $bg = '';
                        } ?>
                        <tr class="<?= $bg ?>">
                            <td class="text-center"><input type="checkbox" class="cekListFinish" data-row="<?= $angka ?>"></td>
                            <td class="text-center"><?= $angka ?></td>
                            <td class="text-center"><?= $red['WDD_BATCH_ID'] ?> <input type="hidden" class="wdd_batch_id" data-row="<?= $angka ?>" value="<?= $red['WDD_BATCH_ID'] ?>"></td>
                            <td class="text-center"><?= $red['OOH_ORDER_NUMBER'] ?></td>
                            <td class="text-center"><?= $red['NAME'] ?></td>
                            <td class="text-center"><?= $red['TRX_NUMBER'] ?></td>
                            <td class="text-center"><?= number_format($red['AMMOUNT_INVOICE'], 0) ?></td>
                            <td class="text-center"><?= number_format($red['AMMOUNT_RDO'], 0) ?></td>
                            <td class="text-center">
                                <?php if ($red['APPROVAL_FLAG'] == 'Y') { ?>
                                    <a class="btn btn-danger btn-sm" target="_blank" href="<?= base_url('AutoInvoice/FinishInvoice/CetakInvoice/' . $red['CETAK_INVOICE_REQ_ID']) ?>">Cetak Invoice</a>
                                    <a class="btn btn-danger btn-sm" target="_blank" href="<?= base_url('AutoInvoice/FinishInvoice/CetakRDO/' . $red['CETAK_RDO_REQ_ID']) ?>">Cetak RDO</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php $angka++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-md-1">
            <label>Action</label>
        </div>
        <div class="col-md-3">
            <select class="form-control select2 slcApproveFinish" data-placeholder="Select" style="width:100%">
                <option></option>
                <option value="Y">Approve</option>
                <option value="N">Reject</option>
            </select>
        </div>
        <div class="col-md-1" style="text-align: left;">
            <button class="btn btn-success ApproveFinish" onclick="ApproveFinish()">OK</button>
        </div>
        <div class="col-md-2 loading_process" style="text-align: left;"></div>
    </div>
<?php } ?>