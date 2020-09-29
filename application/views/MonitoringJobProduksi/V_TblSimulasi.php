<?php if (!empty($data)) {?>
<table class="table table-bordered table-hover table-striped text-center" id="tb_monsimulasi" style="width: 100%;font-size:12px">
    <thead style="background-color:#5EC7EB">
        <tr>
            <th style="width:7%;vertical-align:middle">No</th>
            <th style="vertical-align:middle">Kode Item</th>
            <th style="vertical-align:middle">Deskripsi Item</th>
            <th style="vertical-align:middle">Gudang Asal</th>
            <th style="vertical-align:middle">Locator</th>
            <?php if ($level != 1) { ?>
            <th style="vertical-align:middle">Gudang</th>
            <?php }?>
            <th style="vertical-align:middle">Unit</th>
            <th style="vertical-align:middle">Jumlah Yang Dibutuhkan</th>
            <th style="vertical-align:middle">ATT</th>
            <th style="vertical-align:middle">Balance <br>(+ / -)</th>
            <th style="vertical-align:middle">WIP</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($data as $val) { 
            $tanda = ($val['REQUIRED_QUANTITY'] > $val['ATT']) ? "bg-danger" : "";
            $col = $level != 1 ? 10 : 9;
            $tambah = $tanda == 'bg-danger' ? '<tr><td></td><td colspan="'.$col.'" id="tr_simulasi'.$level.''.$no.''.$nomor.'" style="display:none"></td></tr>' : '';
            $jml_gd = $val['DFG'] + $val['DMC'] + $val['FG_TKS'] + $val['INT_PAINT'] + $val['INT_WELD'] + $val['INT_SUB'] + $val['PNL_TKS'] + $val['SM_TKS'] + $val['INT_ASSYGT'] + $val['INT_ASSY'] + $val['INT_MACHA'] + $val['INT_MACHB'] + $val['INT_MACHC'] + $val['INT_MACHD'];
        ?>
            <tr>
                <td class="<?= $tanda?>"><?= $no?>
                    <input type="hidden" id="penanda<?= $level?><?= $no?><?= $nomor?>" value="off">
                    <input type="hidden" id="dfg<?= $level?><?= $no?><?= $nomor?>" value="<?= $val['DFG']?>">
                    <input type="hidden" id="dmc<?= $level?><?= $no?><?= $nomor?>" value="<?= $val['DMC']?>">
                    <input type="hidden" id="fg_tks<?= $level?><?= $no?><?= $nomor?>" value="<?= $val['FG_TKS']?>">
                    <input type="hidden" id="int_paint<?= $level?><?= $no?><?= $nomor?>" value="<?= $val['INT_PAINT']?>">
                    <input type="hidden" id="int_weld<?= $level?><?= $no?><?= $nomor?>" value="<?= $val['INT_WELD']?>">
                    <input type="hidden" id="int_sub<?= $level?><?= $no?><?= $nomor?>" value="<?= $val['INT_SUB']?>">
                    <input type="hidden" id="pnl_tks<?= $level?><?= $no?><?= $nomor?>" value="<?= $val['PNL_TKS']?>">
                    <input type="hidden" id="sm_tks<?= $level?><?= $no?><?= $nomor?>" value="<?= $val['SM_TKS']?>">
                    <input type="hidden" id="int_assygt<?= $level?><?= $no?><?= $nomor?>" value="<?= $val['INT_ASSYGT']?>">
                    <input type="hidden" id="int_assy<?= $level?><?= $no?><?= $nomor?>" value="<?= $val['INT_ASSY']?>">
                    <input type="hidden" id="int_macha<?= $level?><?= $no?><?= $nomor?>" value="<?= $val['INT_MACHA']?>">
                    <input type="hidden" id="int_machb<?= $level?><?= $no?><?= $nomor?>" value="<?= $val['INT_MACHB']?>">
                    <input type="hidden" id="int_machc<?= $level?><?= $no?><?= $nomor?>" value="<?= $val['INT_MACHC']?>">
                    <input type="hidden" id="int_machd<?= $level?><?= $no?><?= $nomor?>" value="<?= $val['INT_MACHD']?>">
                </td>
                <td class="<?= $tanda?>"><input type="hidden" id="komp<?= $level?><?= $no?><?= $nomor?>" value="<?= $val['KOMPONEN']?>"><?= $val['KOMPONEN']?></td>
                <td class="<?= $tanda?>"><input type="hidden" id="desc<?= $level?><?= $no?><?= $nomor?>" value="<?= $val['KOMP_DESC'] ?>"><?= $val['KOMP_DESC']?></td>
                <td class="<?= $tanda?>"><?= $val['GUDANG_ASAL']?></td>
                <td class="<?= $tanda?>"><?= $val['LOCATOR_ASAL']?></td>
                <?php if ($level != 1) { ?>
                    <td class="<?= $tanda?>"><button type="button" class="btn btn-xs bg-teal" style="font-size:12px" onclick="mdlGudangSimulasi(<?= $level?><?= $no?><?= $nomor?>)"><?= $jml_gd?></button>
                        <input type="hidden" id="jml_gudang<?= $level?><?= $no?><?= $nomor?>" value="<?= $jml_gd?>">
                    </td>
                <?php }?>
                <td class="<?= $tanda?>"><?= $val['UOM_ASSY']?></td>
                <td class="<?= $tanda?>"><input type="hidden" id="qty<?= $level?><?= $no?><?= $nomor?>" value="<?= $val['REQUIRED_QUANTITY'] ?>"><?= round($val['REQUIRED_QUANTITY'], 3)?></td>
                <td class="<?= $tanda?>"><?= $val['ATT']?></td>
                <td class="<?= $tanda?>">
                    <?php $btn = $tanda == 'bg-danger' ? 'btn-danger' : 'btn-success'?>
                    <button type="button" class="btn btn-xs <?= $btn?>" style="font-size:12px" onclick="tambahsimulasi(<?= $level?>, <?= $no?>, <?= $nomor?>)"><?= ($val['KEKURANGAN'])?></button>
                </td>
                <td class="<?= $tanda?>">
                    <?php if ($val['WIP'] != '') { ?>
                        <button type="button" class="btn btn-xs bg-orange" style="font-size:12px" onclick="mdlWIPSimulasi(<?= $level?><?= $no?><?= $nomor?>)"><?= $val['WIP']?></button>
                        <input type="hidden" id="wip<?= $level?><?= $no?><?= $nomor?>" value="<?= $val['WIP']?>">
                    <?php }?>
                </td>
            </tr>
            <tr><td></td><td colspan="<?= $col?>" id="tr_simulasi<?= $level?><?= $no?><?= $nomor?>" style="display:none"></td></tr>
        <?php $no++;}?>
    </tbody>
</table>
<?php 
}else {
    echo '<center><b>Data Kosong</b></center>';
}?>