<style>
.buttons-excel{
    color: white;
}
.dt-buttons{
    margin-left: 500px;
}
</style>

<table class="table table-striped table-bordered table-responsive table-hover" id="tblExportMO" style="font-size:14px;width:100%">
    <thead>
        <tr class="bg-primary text-center">
            <td width=""><b>No</b></td>
            <td width=""><b>No Job </b></td>
            <td width=""><b>Item Code</b></td>
            <td width="20%"><b>Description</b></td>
            <td width=""><b>Start Quantity</b></td>
            <td width=""><b>Quantity Completed</b></td>
            <td width=""><b>Remaining</b></td>
            <td width=""><b>Dept Class</b></td>
            <td width=""><b>Shift</b></td>
            <td width=""><b>Status</b></td>
            <td width=""><b>No Picklist</b></td>
        </tr>
    </thead>
    <tbody class="text-nowrap text-left">
    <?php 
    $i=1;
    if (empty($data)) {
    } else {
    foreach ($data as $key) { 
        if ($key['QUANTITY_COMPLETED'] != 0) {
           $td = "bg-warning";
        }elseif ($key['REMAINING'] == 0) {
            $td = "bg-success";
        }else{
            $td = '';
        }
         ?>
            <tr>
                <td class="<?= $td?>"><?= $i ?></td>
                <td class="<?= $td?>"><?= $key['WIP_ENTITY_NAME'] ?><input type="hidden" name="nojob[]" value="<?= $key['WIP_ENTITY_NAME'] ?>"></td>
                <td class="<?= $td?>"><?= $key['ITEM_CODE'] ?><input type="hidden" name="item[]" value="<?= $key['ITEM_CODE'] ?>"></td>
                <td class="<?= $td?>"><?= $key['ITEM_DESC'] ?><input type="hidden" name="desc[]" value="<?= $key['ITEM_DESC'] ?>"></td>
                <td class="<?= $td?>"><?= $key['START_QUANTITY'] ?><input type="hidden" name="startqty[]" value="<?= $key['START_QUANTITY'] ?>"></td>
                <td class="<?= $td?>"><?= $key['QUANTITY_COMPLETED'] ?><input type="hidden" name="qtycompleted[]" value="<?= $key['QUANTITY_COMPLETED'] ?>"></td>
                <td class="<?= $td?>"><?= $key['REMAINING'] ?><input type="hidden" name="remaining[]" value="<?= $key['REMAINING'] ?>"></td>
                <td class="<?= $td?>"><?= $key['DEPT_CLASS'] ?><input type="hidden" name="dept[]" value="<?= $key['DEPT_CLASS'] ?>"></td>
                <td class="<?= $td?>"><?= $key['DESCRIPTION'] ?><input type="hidden" name="shift[]" value="<?= $key['DESCRIPTION'] ?>"></td>
                <td class="<?= $td?>"><?= $key['STATUS'] ?><input type="hidden" name="status[]" value="<?= $key['STATUS'] ?>"></td>
                <td class="<?= $td?>"><?= $key['PIKLIST'] ?><input type="hidden" name="piklist[]" value="<?= $key['PIKLIST'] ?>"></td>
            </tr>
        <?php $i++; }
            } 
    ?>
    </tbody>
</table>