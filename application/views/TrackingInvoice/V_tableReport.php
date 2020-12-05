<div class="box-body">
    <div style="overflow:auto;">
        <table id="tabel_search_r_tracking_invoice" style="min-width: 110%" class="table table-striped table-bordered table-hover text-center dataTable">
            <thead style="vertical-align: middle;">
                <tr class="bg-primary">
                    <th>No</th>
                    <th>Vendor name</th>
                    <th>Invoice Number</th>
                    <th>Invoice Date</th>
                    <th>Action Date</th>
                    <th>Action Status</th>
                    <th>Invoice Amount</th>
                    <th>PO Detail</th>
                    <th>PIC</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                if ($invoice) {
                    foreach ($invoice as $i) { ?>
                        <tr>
                            <td><?php echo $no ?></td>
                            <td><?php echo $i['VENDOR_NAME'] ?></td>
                            <td><?php echo $i['INVOICE_NUMBER'] ?></td>
                            <td><?php echo $i['INVOICE_DATE'] ?></td>
                            <td><?php echo $i['ACTION_DATE'] ?></td>
                            <td><?php echo $i['STATUS'] ?></td>
                            <td><?php echo 'Rp. ' . number_format(round($i['INVOICE_AMOUNT']), 0, '.', '.') . ',00-';
                                ?></td>
                            <td>
                                <?php
                                foreach ($status as $k) { ?>
                                    <?php echo  $k . "<br>" ?>
                                <?php }
                                ?>

                            </td>
                            <td><?php echo $i['SOURCE'] ?></td>
                        </tr>
                <?php $no++;
                    }
                } ?>
            </tbody>
        </table>
    </div>
</div>