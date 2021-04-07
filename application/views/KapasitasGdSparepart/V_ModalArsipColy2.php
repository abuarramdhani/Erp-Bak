<?php 
$edit = $user_arsip == 'user_arsip' ? 'disabled' : '';
?>
<div class="table-responsive">
    <table class="table table-stripped table-hovered text-center" style="width:100%">
        <thead>
            <tr>
                <td>No</td>
                <td>No Colly</td>
                <td>Berat (KG)</td>
            </tr>
        </thead>
        <tbody id="tambahbrt2">
            <?php $no = 1; foreach ($data as $key => $val) { ?>
                <tr>
                    <td><?= $no?></td>
                    <td><?= $val['COLLY_NUMBER']?>
                        <input type="hidden" id="no_spb<?= $no?>" value="<?= $val['REQUEST_NUMBER']?>">
                        <input type="hidden" id="no_colly<?= $no?>" value="<?= $val['COLLY_NUMBER']?>">
                    </td>
                    <td><input class="form-control" id="berat<?= $no?>" name="berat" value="<?= $val['BERAT']?>" onchange="saveColly2(<?= $no?>)" <?= $edit?>></td>
                </tr>
            <?php $no++; }?>
        </tbody>
    </table>
</div>