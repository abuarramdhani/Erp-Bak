<table class="table table-responsive table-striped table-hover table-bordered" id="table_SA" style="min-width:1600px;">
    <thead class="bg-primary">
        <tr>
            <th style="vertical-align: middle; text-align:center; width: 3%">
                No
            </th>
            <th style="vertical-align: middle; text-align:center">
                Action
            </th>
            <th style="vertical-align: middle; text-align:center">
                Assembly Code
            </th>
            <th style="vertical-align: middle; text-align:center">
                Assembly Name
            </th>
            <th style="vertical-align: middle; text-align:center">
                Assembly Type
            </th>
            <th style="vertical-align: middle; text-align:center">
                Component Code
            </th>
            <th style="vertical-align: middle; text-align:center">
                Description
            </th>
            <th style="vertical-align: middle; text-align:center">
                Subinventory
            </th>
            <th style="vertical-align: middle; text-align:center">
                Storage Location
            </th>
            <th style="vertical-align: middle; text-align:center; width: 5%;">
                LPPB / MO / KIB
            </th>
            <th style="vertical-align: middle; text-align:center; width: 5%;">
                Picklist
            </th>
        </tr>
    </thead>
    <tbody>
        <?php 
			$num = 1;
			foreach($Assy as $SA){
                if ($SA['KODE_ASSEMBLY'] == '' || $SA['KODE_ASSEMBLY'] == null) {
                	$assCode = '-';
                	$assName = '-';
                	$assType = '-';
                }else{
                	$assCode = $SA['KODE_ASSEMBLY'];
                	$assName = $SA['NAMA_ASSEMBLY'];
                	$assType = $SA['TYPE_ASSEMBLY'];
                }
		?>
        <tr>
            <td>
                <?php echo $num; ?>
            </td>
            <td>
                <button type="button" class="btn btn-danger" data-assCode="<?php echo $assCode; ?>" onclick="DeleteConfir(this,<?php echo $num; ?>)">
                    <i aria-hidden="true" class="fa fa-trash">
                    </i>
                </button>
            </td>
            <td>
            	<?php echo $assCode; ?>
            </td>
            <td>
                <?php echo $assName; ?>
            </td>
            <td>
                <?php echo $assType; ?>
            </td>
            <td>
                <select class="form-control jsComponent item" data-placement="top" data-toggle="tooltip" name="compCode" onchange="updateCompCode(this)" style="width: 150px;" title="Automatically save when you change the value!">
                    <option selected="" value="<?php echo $SA['ITEM']; ?>">
                        <?php echo $SA['ITEM']; ?>
                    </option>
                </select>
                <input class="ID" type="hidden" value="<?php echo $SA['ID']; ?>">
                    <input class="org_id" type="hidden" value="<?php echo $SA['ORGANIZATION_ID']; ?>">
            </td>
            <td>
                <?php echo $SA['DESCRIPTION']; ?>
            </td>
            <td>
                <select class="form-control select-2 sub_inv" data-placement="top" data-toggle="tooltip" name="subInv" onchange="updateSubInv(this)" style="max-width: 100px;" title="Automatically save when you change the value!">
                    <?php foreach ($SubInv as $si) { 
						if ($si['SECONDARY_INVENTORY_NAME'] == $SA['SUB_INV']) {
					?>
                    <option selected="" value="<?php echo $si['SECONDARY_INVENTORY_NAME']; ?>">
                        <?php echo $si['SECONDARY_INVENTORY_NAME']; ?>
                    </option>
                    <?php }elseif ($si['ORGANIZATION_ID'] == $SA['ORGANIZATION_ID']) { ?>
                    <option value="<?php echo $si['SECONDARY_INVENTORY_NAME']; ?>">
                        <?php echo $si['SECONDARY_INVENTORY_NAME']; ?>
                    </option>
                    <?php }
					} ?>
                </select>
            </td>
            <td align="center">
                <input class="alamat form-control" data-placement="top" data-toggle="tooltip" onkeypress="updateStorage(event, this)" title="Press Enter to save!" type="text" value="<?php echo $SA['ALAMAT'];?>">
            </td>
            <td>
                <select class="lmk form-control select-2" name="txtLmk[]" onchange="updateLMK(this)" style="width: auto;">
                    <option>
                    </option>
                    <option value="1" <?php if ($SA['LMK']=="1") { echo "selected"; } ?>>
                        YES
                    </option>
                    <option value="0" <?php if ($SA['LMK']=="0") { echo "selected"; } ?>>
                        NO
                    </option>
                </select>
            </td>
            <td>
                <select class="form-control select-2 picklist" name="txtPicklist[]" onchange="updatePicklist(this)" style="width: auto;">
                    <option>
                    </option>
                    <option value="1" <?php if ($SA['PICKLIST']=="1") { echo "selected"; } ?>>
                        YES
                    </option>
                    <option value="0" <?php if ($SA['PICKLIST']=="0") { echo "selected"; } ?>>
                        NO
                    </option>
                </select>
            </td>
        </tr>
        <?php
			$num++;
			}
		?>
    </tbody>
</table>
<div aria-labelledby="myLargeModalLabel" class="modal fade" id="mdlStrgLoc" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Are you sure to delete this data?
                </h4>
            </div>
            <form action="<?php echo base_url('StorageLocation/Correction/Delete'); ?>" method="post">
            	<input type="hidden" name="ID" id="deleteIdData">
            <div class="modal-body">
                    <table class="table table-striped table-hover">
                        <thead class="bg-primary">
                            <tr>
                                <th style="vertical-align: middle; text-align:center; width: 3%">
                                    No
                                </th>
                                <th style="vertical-align: middle; text-align:center">
                                    Assembly Code
                                </th>
                                <th style="vertical-align: middle; text-align:center">
                                    Component Code
                                </th>
                                <th style="vertical-align: middle; text-align:center">
                                    Subinventory
                                </th>
                                <th style="vertical-align: middle; text-align:center">
                                    Storage Location
                                </th>
                                <th style="vertical-align: middle; text-align:center; width: 5%;">
                                    LPPB / MO / KIB
                                </th>
                                <th style="vertical-align: middle; text-align:center; width: 5%;">
                                    Picklist
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        	<tr>
                        		<td id="tdno"></td>
                        		<td id="tdassCode"></td>
                        		<td id="tdcompCode"></td>
                        		<td id="tdsubInv"></td>
                        		<td id="tdstrgLoc"></td>
                        		<td id="tdLMK"></td>
                        		<td id="tdpick"></td>
                        	</tr>
                        </tbody>
                    </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" type="button">
                    Cancel
                </button>
                <button class="btn btn-danger" type="submit">
                    Delete!
                </button>
            </div>
            </form>
        </div>
    </div>
</div>