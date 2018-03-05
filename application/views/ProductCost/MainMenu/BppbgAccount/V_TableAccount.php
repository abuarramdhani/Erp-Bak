<table class="table table-bordered table-striped table-hover" id="tblBppbgAccount">
    <thead class="bg-primary">
        <td>
            No
        </td>
        <td style="width: 90px;">
            Action
        </td>
        <td>
            Using Category Code
        </td>
        <td>
            Using Category
        </td>
        <td>
            Cost Center
        </td>
        <td>
            Cost Center Description
        </td>
        <td>
            Account Number
        </td>
        <td>
            Attribute
        </td>
    </thead>
    <tbody>
        <?php
    	foreach ($account as $value) {
    		// $encrypted_string = $this->encrypt->encode($value['ACCOUNT_ID']);
    		// $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
        ?>
        <tr>
            <td>
                <?php echo $no++; ?>
            </td>
            <td>
                <div class="btn-group-justified">
                    <a class="btn btn-default" href="<?php echo base_url('ProductCost/BppbgAccount/edit/'.$value['ACCOUNT_ID']) ?>">
                        <i class="fa fa-edit">
                        </i>
                    </a>
                    <a class="btn btn-danger" data-id="<?php echo $value['ACCOUNT_ID']; ?>" href="javascript:void(0)">
                        <i class="fa fa-trash">
                        </i>
                    </a>
                </div>
            </td>
            <td>
                <?php echo $value['USING_CATEGORY_CODE']; ?>
            </td>
            <td>
                <?php echo $value['USING_CATEGORY']; ?>
            </td>
            <td>
                <?php echo $value['COST_CENTER']; ?>
            </td>
            <td>
                <?php echo $value['COST_CENTER_DESCRIPTION']; ?>
            </td>
            <td>
                <?php echo $value['ACCOUNT_NUMBER']; ?>
            </td>
            <td>
                <?php echo $value['ACCOUNT_ATTRIBUTE']; ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>