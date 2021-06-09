<style>
    .btnPOLogbookSelectMonth {
        display: block;
    }
</style>
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
                
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Waktu data yang akan ditampilkan</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <p class="text-center">Cari data berdasarkan waktu tahun & bulan yang dipilih</p>
                            <?php foreach (range(2020, date('Y')) as $key => $year) : ?>
                                <div class="col-md-6">
                                    <div class="panel box box-primary">
                                        <div class="box-header with-border">
                                            <h4 class="box-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $year ?>" aria-expanded="false" class="collapsed">Data Tahun <?= $year ?></a>
                                            </h4>
                                        </div>
                                        <div id="collapse<?= $year ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <a href="<?= base_url('PurchaseManagementSendPO/PoLog?date=01-' . $year) ?>"
                                                            class="btnPOLogbookSelectMonth btn alert-info alert text-center">Januari</a>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <a href="<?= base_url('PurchaseManagementSendPO/PoLog?date=02-' . $year) ?>"
                                                            class="btnPOLogbookSelectMonth btn alert-info alert text-center">Februari</a>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <a href="<?= base_url('PurchaseManagementSendPO/PoLog?date=03-' . $year) ?>"
                                                            class="btnPOLogbookSelectMonth btn alert-info alert text-center">Maret</a>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <a href="<?= base_url('PurchaseManagementSendPO/PoLog?date=04-' . $year) ?>"
                                                            class="btnPOLogbookSelectMonth btn alert-info alert text-center">April</a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <a href="<?= base_url('PurchaseManagementSendPO/PoLog?date=05-' . $year) ?>"
                                                            class="btnPOLogbookSelectMonth btn alert-info alert text-center">Mei</a>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <a href="<?= base_url('PurchaseManagementSendPO/PoLog?date=06-' . $year) ?>"
                                                            class="btnPOLogbookSelectMonth btn alert-info alert text-center">Juni</a>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <a href="<?= base_url('PurchaseManagementSendPO/PoLog?date=07-' . $year) ?>"
                                                            class="btnPOLogbookSelectMonth btn alert-info alert text-center">Juli</a>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <a href="<?= base_url('PurchaseManagementSendPO/PoLog?date=08-' . $year) ?>"
                                                            class="btnPOLogbookSelectMonth btn alert-info alert text-center">Agustus</a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <a href="<?= base_url('PurchaseManagementSendPO/PoLog?date=09-' . $year) ?>"
                                                            class="btnPOLogbookSelectMonth btn alert-info alert text-center">September</a>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <a href="<?= base_url('PurchaseManagementSendPO/PoLog?date=10-' . $year) ?>"
                                                            class="btnPOLogbookSelectMonth btn alert-info alert text-center">Oktober</a>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <a href="<?= base_url('PurchaseManagementSendPO/PoLog?date=11-' . $year) ?>"
                                                            class="btnPOLogbookSelectMonth btn alert-info alert text-center">November</a>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <a href="<?= base_url('PurchaseManagementSendPO/PoLog?date=12-' . $year) ?>"
                                                            class="btnPOLogbookSelectMonth btn alert-info alert text-center">Desember</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            <?php endforeach ?>
                        </div>
                        <br>
                        <div class="row">
                            <p class="text-center">Atau cari data di seluruh waktu dengan mengisikan kata kunci pada input berikut</p>
                            <div class="text-center">
                                <form action="<?= base_url('PurchaseManagementSendPO/PoLog') ?>" method="get">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-3">
                                        <input type="text" name="keyword" class="form-control" placeholder="Kata kunci (tidak wajib diisi)">
                                    </div>
                                    <div class="col-sm-1">
                                        <button class="btn btn-primary" title="Cari Sekarang">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                    <div class="col-sm-4"></div>
                                </form>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>

                <?php if (count($PoLog) > 0 || count($this->input->get()) > 0) : ?>
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
                                                <td class="view-attachment-polog" data-po="<?= $value['PO_NUMBER'] . '-' . $value['PO_REVISION'] ?>" file-name="<?= $value['ATTACHMENT']; ?>">
                                                    <center>
                                                        <p class="name-attachment"><?= $value['ATTACHMENT']; ?></p>
                                                    </center>
                                                </td>
                                                <?php $this->session->user == 'B0846' ? $url_edit = base_url('PurchaseManagementSendPO/PoLog/editSpecial') : $url_edit = base_url("PurchaseManagementSendPO/PoLog/edit"); ?>
                                                <td style="min-width: 120px; max-width: 120px; text-align: center;">
                                                    <a class="btn btn-success <?= ($value['SEND_DATE_1'] === NULL)? 'hidden' : ''; ?>" href="<?= base_url("PurchaseManagementSendPO/SendPO") . '?po_number=' . $value['PO_NUMBER'] . '-' . $value['PO_REVISION']; ?>" title="Resend"><i class="fa fa-send"></i></a>
                                                    <a class="btn btn-success btn-edit" href="<?= $url_edit . '?po_numb=' . $value['PO_NUMBER'] . '-' . $value['PO_REVISION']; ?>" title="Edit"><i class="fa fa-edit"></i></a>
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
                <?php endif ?>
            </div>
        </div>
    </div>
</section>