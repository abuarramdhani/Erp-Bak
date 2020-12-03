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
                <p class="text-bold">*Background Kuning : PO belum konfirmasi setelah 1 x 24 jam dari Send Date 1</p>
                <p class="text-bold">*Background Merah : PO belum konfirmasi setelah 1 x 24 jam dari Send Date 2</p>
                <br />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-body">
                                <a href="<?= base_url('PurchaseManagementSendPO/PoLog/exportExcel') ?>" class="btn btn-success" style="margin-bottom: 10px">Export Excel</a>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-left" id="tbl-PoLog" style="font-size:12px; width: 150%;">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="bg-primary" style="vertical-align: middle;">
                                                    <center>No</center>
                                                </th>
                                                <th rowspan="2" class="bg-primary" style="vertical-align: middle;">
                                                    <center>Input Date</center>
                                                </th>
                                                <th rowspan="2" class="bg-primary" style="vertical-align: middle;">
                                                    <center>Employee</center>
                                                </th>
                                                <th rowspan="2" class="bg-primary" style="vertical-align: middle;">
                                                    <center>PO Number</center>
                                                </th>
                                                <th rowspan="2" class="bg-primary" style="vertical-align: middle;">
                                                    <center>Vendor Name</center>
                                                </th>
                                                <th rowspan="2" class="bg-primary" style="vertical-align: middle;">
                                                    <center>Buyer</center>
                                                </th>
                                                <th rowspan="2" class="bg-primary" style="vertical-align: middle;">
                                                    <center>PO Rev</center>
                                                </th>
                                                <th rowspan="2" class="bg-primary" style="vertical-align: middle;">
                                                    <center>Attach Flag</center>
                                                </th>
                                                <th rowspan="2" class="bg-primary" style="vertical-align: middle;">
                                                    <center>PO Print Date</center>
                                                </th>
                                                <th rowspan="2" class="bg-primary" style="vertical-align: middle;">
                                                    <center>Distribution Method</center>
                                                </th>
                                                <th colspan="2" class="bg-primary" style="vertical-align: middle;">
                                                    <center>Approve Date</center>
                                                </th>
                                                <th rowspan="2" class="bg-primary" style="border-left: 1px solid #fff; vertical-align: middle;">
                                                    <center>Send Date 1</center>
                                                </th>
                                                <th rowspan="2" class="bg-primary" style="vertical-align: middle;">
                                                    <center>Delivery Status 1</center>
                                                </th>
                                                <th rowspan="2" class="bg-primary" style="vertical-align: middle;">
                                                    <center>Send Date 2</center>
                                                </th>
                                                <th rowspan="2" class="bg-primary" style="vertical-align: middle;">
                                                    <center>Delivery Status 2</center>
                                                </th>
                                                <th rowspan="2" class="bg-primary" style="vertical-align: middle;">
                                                    <center>Vendor Confirm Date</center>
                                                </th>
                                                <th rowspan="2" class="bg-primary" style="vertical-align: middle;">
                                                    <center>Vendor Confirm Method</center>
                                                </th>
                                                <th rowspan="2" class="bg-primary" style="vertical-align: middle;">
                                                    <center>Vendor Confirm PIC</center>
                                                </th>
                                                <th rowspan="2" class="bg-primary" style="vertical-align: middle;">
                                                    <center>Vendor Confirm Note</center>
                                                </th>
                                                <th rowspan="2" class="bg-primary" style="vertical-align: middle;">
                                                    <center>Attachment</center>
                                                </th>
                                                <th rowspan="2" class="bg-primary" style="vertical-align: middle;">
                                                    <center>Action</center>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="bg-primary">
                                                    <center>Purchasing Approve Date</center>
                                                </th>
                                                <th class="bg-primary">
                                                    <center>Management Approve Date</center>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($PoLog as $key => $value) : ?>
                                            <tr class="
                                            <?php if($value['DISTRIBUTION_METHOD'] !== "none" && $value['SELISIH_WAKTU_1'] > 24 && $value['VENDOR_CONFIRM_DATE'] === NULL && $value['SEND_DATE_2'] === NULL){
                                                echo 'warning';
                                            } elseif ($value['DISTRIBUTION_METHOD'] !== "none" && $value['SELISIH_WAKTU_2'] > 24 && $value['VENDOR_CONFIRM_DATE'] === NULL) {
                                                echo 'danger';
                                            } else {
                                                echo '';
                                            }; ?>">
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
                                                    <center><?= $value['BUYER_NAME']; ?> - <?= $value['BUYER_NIK']; ?></center>
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
                                                    <center><?= $value['VENDOR_CONFIRM_NOTE']; ?></center>
                                                </td>
                                                <td>
                                                    <center><a href="<?= base_url('PurchaseManagementSendPO/PoLog/download') . '/' . $value['PO_NUMBER'] . '-' . $value['PO_REVISION'] . '/' . $value['ATTACHMENT']; ?>" style="text-decoration: none;"><?= $value['ATTACHMENT']; ?></a></center>
                                                </td>
                                                <td style="min-width: 120px; max-width: 120px; text-align: center;">
                                                    <a class="btn btn-success <?= ($value['SEND_DATE_1'] === NULL)? 'hidden' : ''; ?>" href="<?= base_url("PurchaseManagementSendPO/SendPO") . '?po_number=' . $value['PO_NUMBER'] . '-' . $value['PO_REVISION']; ?>" title="Resend"><i class="fa fa-send"></i></a>
                                                    <a class="btn btn-success btn-edit" href="<?= base_url("PurchaseManagementSendPO/PoLog/edit") . '?po_numb=' . $value['PO_NUMBER']; ?>" title="Edit"><i class="fa fa-edit"></i></a>
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