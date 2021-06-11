<table width="100%" class="table table-bordered table-striped" id="tbl-input-line-GMI" style="margin-top: 20px;">
    <thead>
        <tr class="bg-info">
            <th width="5%" class="text-center">No</th>
            <th width="25%" class="text-center">Kode Barang</th>
            <th width="35%" class="text-center">Deskripsi</th>
            <th width="20%" class="text-center">Item Type</th>
            <th width="15%" class="text-center">Action</th>
        </tr>
    </thead>
    <tbody id="tbody-add-item-GMI" data-source="excel">
        <?php
            $row = 0;
            foreach ($excel as $key => $data) {
                $row++;
        ?>
            <tr class="tr-add-item-GMI" data-row="<?=$row?>" data-id="<?= $data['item_id'] ?>" data-source="excel">
                <td style="text-align: center;"><?=$row?></td>
                <td style="text-align: center;" class="inp-excel-item-GMI"><?= $data['item_code'] ?></td>
                <td style="text-align: center;"><?= $data['desc'] ?></td>
                <td style="text-align: center;"><?= $data['type'] ?></td>
                <td style="text-align: center;">
                <button type="button" class="btn btn-danger btn-sm btn-delete-item-GMI" value="line-input" data-id="-1">
                <i class="fa fa-times"></i>
                </button>
                </td>
                </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" align="right">
                <button type="button" class="btn btn-xl btn-primary" id="btn-save-iteml-GMI" value="-1" data-action="SAVE">SAVE</button>
                <button type="button" class="btn btn-xl btn-danger btn-delete-item-GMI" style="margin-left: 3px;" value="all">DELETE</button>
            </td>
        </tr>
    </tfoot>
</table>