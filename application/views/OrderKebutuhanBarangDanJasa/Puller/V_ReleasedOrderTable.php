<table class="table table-bordered table-stripped text-center">
    <thead class="bg-primary">
        <tr>
            <th>No</th>
            <th>Order ID</th>
            <th>Item Kode</th>
            <th>Nama Barang</th>
            <th>Quantity</th>
            <th>UOM</th>
            <th>NBD</th>
            <th>Flag</th>
        </tr>
    </thead>
    <tbody>
    <?php $no=0; foreach ($listOrder as $key => $list) { $no++;?>
        <tr>
            <td><?php echo $no;?></td>
            <td><?php echo $list['ORDER_ID']; ?></td>
            <td><?php echo $list['SEGMENT1']; ?></td>
            <td><?php echo $list['DESCRIPTION']; ?></td>
            <td><?php echo $list['QUANTITY']; ?></td>
            <td><?php echo $list['UOM']; ?></td>
            <td><?php echo $list['NEED_BY_DATE']; ?></td>
            <td>
                <?php if ($list['URGENT_FLAG'] == 'Y') { ?>
                   <label class="label label-danger"><i>urgent</i></label>
                <?php }else{ ?>
                   <label class="label label-success"><i>normal</i></label>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>