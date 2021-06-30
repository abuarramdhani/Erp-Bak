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
                    <th class="text-center">INVOICE AMMOUNT</th>
                    <th class="text-center">RDO AMMOUNT</th>
                </tr>
            </thead>
            <tbody>
                <?php $angka = 1;
                foreach ($DoFinish as $key => $red) {
                    $inv_amm = number_format($red['AMMOUNT_INVOICE'], 0);
                    $rdo_amm = number_format($red['AMMOUNT_RDO'], 0);
                    if ($inv_amm != $rdo_amm) {
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
                            <td class="text-center"><?= $inv_amm ?></td>
                            <td class="text-center"><?= $rdo_amm ?></td>

                        </tr>
                <?php $angka++;
                    }
                } ?>
            </tbody>
        </table>
    </div>
</div>