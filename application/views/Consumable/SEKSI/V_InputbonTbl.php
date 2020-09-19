<?php $angka = 1;
foreach ($datatobon as $bon) {
    if ($bon['sisa_saldo'] < 1) {
        $warna = 'bg-danger';
        $disabled = 'disabled';
    } else {
        $warna = '';
        $disabled = '';
    } ?>
    <tr class="<?= $warna ?>">
        <td class="text-center"><input type="checkbox" class="daftarbon icheckbox_flat-blue" id="daftarbon<?= $angka ?>" data-row="<?= $angka ?>" /></td>

        <td class="text-center"><input type="hidden" class="itembon" data-row="<?= $angka ?>" id="itembon<?= $angka ?>" value="<?= $bon['item_code'] ?>" name="" /><?= $bon['item_code'] ?></td>

        <td class="text-center"><?= $bon['item_desc'] ?></td>

        <td class="text-center"><input type="hidden" class="kebutuhan" data-row="<?= $angka ?>" value="<?= $bon['qty_kebutuhan'] ?>" name="" /><?= $bon['qty_kebutuhan'] ?></td>

        <td class="text-center"><input type="hidden" value="<?= $bon['qty_dibon'] ?>" name="" /><?= $bon['qty_dibon'] ?></td>

        <td class="text-center" style="width: 10%;"><input <?= $disabled ?> type="number" id="qtytobon<?= $angka ?>" onkeyup="hitungsaldo(<?= $angka ?>)" onchange="hitungsaldo(<?= $angka ?>)" class="form-control" name="" /></td>
        <input type="hidden" class="qtytobon" data-row="<?= $angka ?>" id="qtytobon2<?= $angka ?>" name="" />

        <input type="hidden" value="<?= $bon['sisa_saldo'] ?>" id="kebutuhan<?= $angka ?>" />

        <td class="text-center" id="saldotobontd<?= $angka ?>"><?= $bon['sisa_saldo'] ?></td>
        <input class="saldotobon" data-row="<?= $angka ?>" type="hidden" id="saldotobon<?= $angka ?>" value="<?= $bon['sisa_saldo'] ?>" />

    </tr>
<?php $angka++;
} ?>