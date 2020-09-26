<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1><b><?= $Menu ?></b></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-bold">*Background Merah : PO belum konfirmasi setelah 1 x 24 jam</p>
                <br />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-left" id="tbl-SpoLog"
                                        style="font-size:12px; width: 200%;">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th rowspan="2" style="vertical-align: middle;">
                                                    <center>No</center>
                                                </th>
                                                <th rowspan="2" style="vertical-align: middle;">
                                                    <center>Input Date</center>
                                                </th>
                                                <th rowspan="2" style="vertical-align: middle;">
                                                    <center>Employee</center>
                                                </th>
                                                <th rowspan="2" style="vertical-align: middle;">
                                                    <center>PO Number</center>
                                                </th>
                                                <th rowspan="2" style="vertical-align: middle;">
                                                    <center>Vendor Name</center>
                                                </th>
                                                <th rowspan="2" style="vertical-align: middle;">
                                                    <center>Buyer Name</center>
                                                </th>
                                                <th rowspan="2" style="vertical-align: middle;">
                                                    <center>Buyer NIK</center>
                                                </th>
                                                <th rowspan="2" style="vertical-align: middle;">
                                                    <center>PO Revision</center>
                                                </th>
                                                <th rowspan="2" style="vertical-align: middle;">
                                                    <center>Attachment Flag</center>
                                                </th>
                                                <th rowspan="2" style="vertical-align: middle;">
                                                    <center>PO Print Date</center>
                                                </th>
                                                <th rowspan="2" style="vertical-align: middle;">
                                                    <center>Distribution Method</center>
                                                </th>
                                                <th colspan="2" style="vertical-align: middle;">
                                                    <center>Approve Date</center>
                                                </th>
                                                <th rowspan="2"
                                                    style="border-left: 1px solid #fff; vertical-align: middle;">
                                                    <center>Send Date 1</center>
                                                </th>
                                                <th rowspan="2" style="vertical-align: middle;">
                                                    <center>Delivery Status 1</center>
                                                </th>
                                                <th rowspan="2" style="vertical-align: middle;">
                                                    <center>Send Date 2</center>
                                                </th>
                                                <th rowspan="2" style="vertical-align: middle;">
                                                    <center>Delivery Status 2</center>
                                                </th>
                                                <th rowspan="2" style="vertical-align: middle;">
                                                    <center>Vendor Confirm Date</center>
                                                </th>
                                                <th rowspan="2" style="vertical-align: middle;">
                                                    <center>Vendor Confirm Method</center>
                                                </th>
                                                <th rowspan="2" style="vertical-align: middle;">
                                                    <center>Vendor Confirm PIC</center>
                                                </th>
                                                <th rowspan="2" style="vertical-align: middle;">
                                                    <center>Attachment</center>
                                                </th>
                                                <th rowspan="2" style="vertical-align: middle;">
                                                    <center>Action</center>
                                                </th>
                                            </tr>
                                            <tr class="bg-primary">
                                                <th>
                                                    <center>Purchasing Approve Date</center>
                                                </th>
                                                <th>
                                                    <center>Management Approve Date</center>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($PoLogbook as $key => $value) : ?>
                                            <tr
                                                <?= ($value['SELISIH_WAKTU'] > 24 && $value['VENDOR_CONFIRM_DATE'] === NULL) ? 'style="background-color: #f2dede;"' : ''; ?>>
                                                <td>
                                                    <center><?= $key + 1; ?></center>
                                                </td>
                                                <td>
                                                    <center><?= $value['INPUT_DATE']; ?></center>
                                                </td>
                                                <td>
                                                    <center><?= $value['EMPLOYEE']; ?></center>
                                                </td>
                                                <td>
                                                    <center><?= $value['PO_NUMBER']; ?></center>
                                                </td>
                                                <td>
                                                    <center><?= $value['VENDOR_NAME']; ?></center>
                                                </td>
                                                <td>
                                                    <center><?= $value['BUYER_NAME']; ?></center>
                                                </td>
                                                <td>
                                                    <center><?= $value['BUYER_NIK']; ?></center>
                                                </td>
                                                <td>
                                                    <center><?= $value['PO_REVISION']; ?></center>
                                                </td>
                                                <td>
                                                    <center><?= $value['ATTACHMENT_FLAG']; ?></center>
                                                </td>
                                                <td>
                                                    <center><?= $value['PO_PRINT_DATE']; ?></center>
                                                </td>
                                                <td>
                                                    <center><?= $value['DISTRIBUTION_METHOD']; ?></center>
                                                </td>
                                                <td>
                                                    <center><?= $value['PURCHASING_APPROVE_DATE']; ?></center>
                                                </td>
                                                <td>
                                                    <center><?= $value['MANAGEMENT_APPROVE_DATE']; ?></center>
                                                </td>
                                                <td>
                                                    <center><?= $value['SEND_DATE_1']; ?></center>
                                                </td>
                                                <td>
                                                    <center><?= $value['DELIVERY_STATUS_1']; ?></center>
                                                </td>
                                                <td>
                                                    <center><?= $value['SEND_DATE_2']; ?></center>
                                                </td>
                                                <td>
                                                    <center><?= $value['DELIVERY_STATUS_2']; ?></center>
                                                </td>
                                                <td>
                                                    <center><?= $value['VENDOR_CONFIRM_DATE']; ?></center>
                                                </td>
                                                <td>
                                                    <center><?= ucfirst($value['VENDOR_CONFIRM_METHOD']); ?></center>
                                                </td>
                                                <td>
                                                    <center><?= $value['VENDOR_CONFIRM_PIC']; ?></center>
                                                </td>
                                                <td>
                                                    <center><?= $value['ATTACHMENT']; ?></center>
                                                </td>
                                                <td style="min-width: 60px; max-width: 60px; text-align: center;">
                                                    <a class="btn btn-success btn-edit"
                                                        href="<?= base_url("PurchaseManagementSendPO/PoLog/edit") . '?po_number=' . $value['PO_NUMBER']; ?>"
                                                        title="Edit"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>