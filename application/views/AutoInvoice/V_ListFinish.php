<div class="panel-body">
    <div class="col-md-12">
        <table class="table table-bordered" id="tbl_do_finish">
            <thead class="bg-green">
                <tr>
                    <th class="text-center">NO</th>
                    <th class="text-center">NO DO</th>
                    <th class="text-center">SO NUMBER</th>
                    <th class="text-center">OU</th>
                    <th class="text-center">INVOICE NUM</th>
                    <th class="text-center">ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php $angka = 1;
                foreach ($DoFinish as $key => $red) { ?>
                    <tr>
                        <td class="text-center"><?= $angka ?></td>
                        <td class="text-center"><?= $red['WDD_BATCH_ID'] ?></td>
                        <td class="text-center"><?= $red['OOH_ORDER_NUMBER'] ?></td>
                        <td class="text-center"><?= $red['NAME'] ?></td>
                        <td class="text-center"><?= $red['TRX_NUMBER'] ?></td>
                        <td class="text-center">
                            <?php if ($red['CETAK_INVOICE_REQ_ID'] != null) { ?>
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