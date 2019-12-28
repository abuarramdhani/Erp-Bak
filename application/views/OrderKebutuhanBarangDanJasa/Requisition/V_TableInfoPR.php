<?php if (count($info) == 0) { ?>
    <center>
        <span><i class="fa fa-warning"> Order Belum Jadi PR</i></span>
    </center>
<?php }else { ?>
    <table class="table table-bordered table-stripped table-hover text-center">
        <thead class="bg-primary">
            <tr>
                <th>PR Number</th>
                <th>PR Creation Date</th>
                <th>PR Line Number</th>
                <th>PO Number</th>
                <th>PO Creation Date</th>
                <th>PO Line Number</th>
                <th>PO Promised Date</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=0; foreach ($info as $key => $list) { $no++;?>
            <tr>
                <td><?php echo $list['PR_NUM']; ?></td>
                <td><?php echo $list['PR_CREATION_DATE']; ?></td>
                <td><?php echo $list['PR_LINE_NUM']; ?></td>
                <td><?php echo $list['PO_NUM']; ?></td>
                <td><?php echo $list['PO_CREATION_DATE']; ?></td>
                <td><?php echo $list['PO_LINE_NUM']; ?></td>
                <td><?php echo $list['PO_PROMISED_DATE']; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } ?>