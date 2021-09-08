<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Order Kebutuhan Barang dan Jasa </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">

        <div class="col-md-12">

            <div class="box box-primary">

                <div class="box-header with-border">
                    <h3 class="box-title"><?= $Title ?></h3>
                </div>

                <div class="box-body">
                    <table class="table table-bordered table_outstanding_ord_okbj">
                        <thead class="bg-danger">
                            <tr>
                                <!-- <th>No</th> -->
                                <th>Order Id</th>
                                <th>Item Code</th>
                                <th>Item Description</th>
                                <th>Requester</th>
                                <!-- <th>Quantity</th> -->
                                <!-- <th>UoM</th> -->
                                <th>Order Date</th>
                                <!-- <th>order Purpose</th> -->
                                <!-- <th>Urgent Reason</th> -->
                                <th>Menunggu Approve dari</th>
                                <th>Cut Off Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($outstanding as $key => $out) { ?>
                                <tr>
                                    <td><?= $out['ORDER_ID'] ?></td>
                                    <td><?= $out['ITEM_CODE'] ?></td>
                                    <td><?= $out['ITEM_DESCRIPTION'] ?></td>
                                    <td><?= $out['REQUESTER'] ?></td>
                                    <!-- <td><?= $out['QUANTITY'] ?></td> -->
                                    <!-- <td><?= $out['UOM'] ?></td> -->
                                    <td><?= $out['ORDER_DATE'] ?></td>
                                    <!-- <td><?= $out['ORDER_PURPOSE'] ?></td> -->
                                    <!-- <td><?= $out['URGENT_REASON'] ?></td> -->
                                    <td><?= $out['MENUNGGU_APPROVE_DARI'] ?></td>
                                    <td><?= $out['CUT_OFF_DATE'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">

                </div>
            </div>
        </div>
    </div>
</section>