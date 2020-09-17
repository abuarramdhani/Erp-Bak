<?php if (!empty($data)) {?>
<table class="table table-bordered table-hover table-striped text-center" id="tb_monsimulasi" style="width: 100%;font-size:13px">
    <thead style="background-color:#5EC7EB">
        <tr>
            <th style="width:7%;vertical-align:middle">No</th>
            <th style="vertical-align:middle">Kode Item</th>
            <th style="vertical-align:middle">Deskripsi Item</th>
            <th style="vertical-align:middle">Gudang Asal</th>
            <th style="vertical-align:middle">Locator</th>
            <th style="vertical-align:middle">Unit</th>
            <th style="vertical-align:middle">Jumlah Yang Dibutuhkan</th>
            <th style="vertical-align:middle">ATT</th>
            <th style="vertical-align:middle">MO</th>
            <th style="vertical-align:middle">Stok</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($data as $val) { 
            $tanda = ($val['REQUIRED_QUANTITY'] > $val['ATT'] || $val['REQUIRED_QUANTITY'] > $val['KURANG']) ? "bg-danger" : "";
            $tambah = $tanda == 'bg-danger' ? '<tr><td></td><td colspan="9" id="tr_simulasi'.$level.''.$no.''.$nomor.'" style="display:none"></td></tr>' : '';
        ?>
            <tr>
                <td class="<?= $tanda?>"><input type="hidden" id="penanda<?= $level?><?= $no?><?= $nomor?>" value="off"><?= $no?></td>
                <td class="<?= $tanda?>"><input type="hidden" id="komp<?= $level?><?= $no?><?= $nomor?>" value="<?= $val['KOMPONEN']?>"><?= $val['KOMPONEN']?></td>
                <td class="<?= $tanda?>"><input type="hidden" id="desc<?= $level?><?= $no?>" value="<?= $val['KOMP_DESC'] ?>"><?= $val['KOMP_DESC']?></td>
                <td class="<?= $tanda?>"><?= $val['GUDANG_ASAL']?></td>
                <td class="<?= $tanda?>"><?= $val['LOCATOR_ASAL']?></td>
                <td class="<?= $tanda?>"><?= $val['UOM_ASSY']?></td>
                <td class="<?= $tanda?>"><input type="hidden" id="qty<?= $level?><?= $no?><?= $nomor?>" value="<?= $val['REQUIRED_QUANTITY'] ?>"><?= $val['REQUIRED_QUANTITY']?></td>
                <td class="<?= $tanda?>"><?= $val['ATT']?></td>
                <td class="<?= $tanda?>"><?= $val['MO']?></td>
                <td class="<?= $tanda?>">
                    <?= $tanda == 'bg-danger' ? '<button type="button" class="btn btn-xs btn-danger" style="font-size:13px" onclick="tambahsimulasi('.$level.', '.$no.', '.$nomor.')">'.$val['KURANG'].'</button>' : ''.$val['KURANG'].''?>
                </td>
            </tr>
            <?= $tambah?>
        <?php $no++;}?>
    </tbody>
</table>
<?php 
}else {
    echo '<center><b>Data Kosong</b></center>';
}?>