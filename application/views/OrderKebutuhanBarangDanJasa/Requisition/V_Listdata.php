<style>
    .tblOKBNewOrderList thead tr th {
        text-align: center;
    }

    .txaOKBNewOrderListReason,
    .txaOKBNewOrderListNote {
        height: 34px;
        resize: vertical;
    }

    .ml-15px {
        margin-left: 15px;
    }

    .bold {
        font-weight: bold;
    }

    .approved {
        color: #00a65a;
        padding: 2px 4px;
        background-color: #ebfff6;
        border-radius: 4px;
    }

    .rejected {
        color: #c7254e;
        padding: 2px 4px;
        background-color: #f9f2f4;
        border-radius: 4px;
    }

    .waiting {
        color: #f39c12;
        padding: 2px 4px;
        background-color: #fffbf5;
        border-radius: 4px;
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Order Kebutuhan Barang dan Jasa </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">

        <div class="col-md-12">

            <form action="<?= base_url('OrderKebutuhanBarangDanJasa/Requisition/createOrder') ?>" method="post" enctype="multipart/form-data">

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title">List Order</h3>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label for="txtOKBOrderRequesterName" class="col-sm-2 control-label" style="font-weight:normal">Nama Pemberi Order</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-user"></i></span>
                                    <input class="form-control" id="txtOKBOrderRequestorName" name="txtOKBOrderRequestorName" value="<?php echo $this->session->employee; ?>" readonly>
                                </div>
                            </div>
                        </div> <br>

                        <div class="form-group">
                            <label for="txtOKBOrderRequesterIDNumber" class="col-sm-2 control-label" style="font-weight:normal">No. Induk</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-list-ol"></i></span>
                                    <input class="form-control" id="txtOKBOrderRequestorId" name="txtOKBOrderRequestorId" value="<?php echo $this->session->user; ?>" readonly>
                                </div>
                            </div>
                        </div> <br>

                        <div class="form-group">
                            <label for="txtOKBSectionOrderRequester" class="col-sm-2 control-label" style="font-weight:normal">Seksi Pemberi Order</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-users"></i></span>
                                    <input class="form-control" id="txtOKBSectionOrderRequestor" name="txtOKBSectionOrderRequestor" value="<?php echo $pengorder[0]['section_name'] ?>" readonly>
                                </div>
                            </div>
                        </div> <br>

                        <div class="form-group">
                            <label for="selectOKBLOVListData" class="col-sm-2 control-label" style="font-weight:normal">Filter List Data</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-filter"></i></span>
                                    <select class="form-control select2 selectOKBLOVListData" id="selectOKBLOVListData" name="selectOKBLOVListData">
                                        <option value=""></option>
                                        <option value="wipapproveatasan">WIP Approve Atasan</option>
                                        <option value="wipreleasepuller">WIP Release Puller</option>
                                        <option value="wipapprovepembelian">WIP Approve Pembelian</option>
                                        <option value="fullapprove">Full Approve</option>
                                        <option value="rejectbypembelian">Reject by Pembelian</option>
                                        <option value="rejectbyatasan">Reject by Atasan/Pengelola</option>
                                        <option value="showall">Show All</option>
                                    </select>
                                </div>
                            </div>
                        </div> <br> <br>

                        <div class="box-body table-responsive no-padding">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <p class="bold">Order List</p>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-bordered table-hover table-striped tblOKBOrderListPengorder" width="125%">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th class="bg-primary">No</th>
                                                <th class="bg-primary">ORDER ID</th>
                                                <th class="bg-primary">Pembuat Order</th>
                                                <th class="bg-primary">Tanggal Order</th>
                                                <th class="bg-primary">Kode Barang</th>
                                                <th class="bg-primary">Deskripsi Barang</th>
                                                <!-- <th>Nama Barang</th> -->
                                                <th class="bg-primary">Qty + UOM</th>
                                                <th>Need By Date</th>
                                                <th>Keterangan</th>
                                                <th>Note To Pengelola</th>
                                                <th>Status</th>
                                                <th>Distribution</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0;
                                            foreach ($listOrder as $key => $list) {
                                                $no++; ?>
                                                <?php if ($list['URGENT_FLAG'] == 'Y' && $list['IS_SUSULAN'] != 'Y') {
                                                    $flag = 'label-danger';
                                                    $tag = 'urgent';
                                                } else if ($list['URGENT_FLAG'] == 'N' && $list['IS_SUSULAN'] != 'Y') {
                                                    $flag = 'label-success';
                                                    $tag = 'reguler';
                                                } else if ($list['IS_SUSULAN'] == 'Y') {
                                                    $flag = 'label-warning';
                                                    $tag = 'emergency';
                                                }

                                                if ($list['CHANGES'] == 'berubah') {
                                                    $bgcolor = 'rgba(213, 184, 255, 1)';
                                                } else {
                                                    $bgcolor = '';
                                                }
                                                ?>
                                                <tr style="background-color: <?= $bgcolor ?>;">
                                                    <td><?php echo $no; ?></td>
                                                    <td><span class="tdOKBListOrderId" style="display: none;"><?php echo $list['ORDER_ID']; ?></span><button type="button" class="btn btn-sm btn-default btnOKBInfoPR"><?php echo $list['ORDER_ID']; ?></button></td>
                                                    <td><?= $list['NATIONAL_IDENTIFIER'] . ', ' . $list['FULL_NAME']; ?></td>
                                                    <td><?php echo date("d-M-Y", strtotime($list['ORDER_DATE'])); ?><br><label class="label <?= $flag; ?>"><?= $tag; ?></label></td>
                                                    <td><?php echo $list['SEGMENT1'] . '-' . $list['DESCRIPTION']; ?><br><br><?php if ($list['ATTACHMENT'] != 0) { ?>
                                                            <button type="button" class="btn btn-info btn-xs btnAttachmentOKB">view attachment</button>
                                                        <?php } ?>
                                                    </td>
                                                    <td><?php echo $list['ITEM_DESCRIPTION']; ?></td>
                                                    <td><?php echo $list['QUANTITY'] . ' ' . $list['UOM']; ?></td>
                                                    <td><?php echo date("d-M-Y", strtotime($list['NEED_BY_DATE'])); ?></td>
                                                    <td>Alasan Order :<?php echo $list['ORDER_PURPOSE']; ?><br>Alasan Urgensi : <?php echo $list['URGENT_REASON']; ?></td>
                                                    <td><?php echo $list['NOTE_TO_PENGELOLA']; ?></td>
                                                    <?php if ($list['ORDER_STATUS_ID'] == '2') {
                                                        $status = "WIP APPROVE ORDER";
                                                        $text = 'Menunggu Approval ' . $list['APPROVAL'];
                                                    } else if ($list['ORDER_STATUS_ID'] == '3') {
                                                        $status = "ORDER APPROVED";
                                                        $text = '';
                                                    } else if ($list['ORDER_STATUS_ID'] == '4') {
                                                        $status = "REJECTED ORDER";
                                                        $text = '';
                                                    } else if ($list['ORDER_STATUS_ID'] == '6') {
                                                        $status = "WIP APPROVE PEMBELIAN";
                                                        $text = 'Menunggu Approval ' . $list['APPROVAL'];
                                                    } else if ($list['ORDER_STATUS_ID'] == '7') {
                                                        $status = "APPROVED PEMBELIAN";
                                                        $text = '';
                                                    } else if ($list['ORDER_STATUS_ID'] == '8') {
                                                        $status = "REJECTED PEMBELIAN";
                                                        $text = '';
                                                    } ?>
                                                    <td><button type="button" class="btn btn-info btnOKBListOrderHistory"><?php echo $status; ?></button> <br><b><?= $text ?></b></td>
                                                    <td><?= $list['DISTRIBUTION'] ?></td>
                                                    <td></td>
                                                    <!-- <td><button type="button" class="btn btn-danger btnCancelOKB"><i class="fa fa-close"></i> Cancel</button></td> -->
                                                </tr>
                                                <div class="modal fade mdlOKBListOrderHistory-<?php echo $list['ORDER_ID']; ?>" role="dialog" aria-labelledby="modalDelete" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4><i style="vertical-align: middle;" class="fa fa-check-circle-o"> </i> Status <b>Order</b></h4>
                                                            </div>
                                                            <div class="modal-body" style="height: 400px;">
                                                                <center>
                                                                    <div class="row text-primary divOKBListOrderHistoryLoading-<?php echo $list['ORDER_ID']; ?>" style="width: 400px; margin-top: 25px; display: none;">
                                                                        <label class="control-label">
                                                                            <h4><img src="<?php echo base_url('assets/img/gif/loading5.gif') ?>" style="width:30px"> <b>Sedang Mengambil Data ...</b></h4>
                                                                        </label>
                                                                    </div>
                                                                </center>
                                                                <div class="col-lg-12 divOKBListOrderHistory-<?php echo $list['ORDER_ID']; ?>" style="overflow: auto; height: 400px; display: none;">
                                                                    <span></span>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade mdlOKBOrderPR-<?php echo $list['ORDER_ID']; ?>" role="dialog" aria-labelledby="modalDelete" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4><i style="vertical-align: middle;" class="fa fa-check-circle-o"> </i> Info <b>Order</b></h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <center>
                                                                    <div class="row text-primary divOKBOrderPRLoading-<?php echo $list['ORDER_ID']; ?>" style="margin-top: 25px; display: none;">
                                                                        <label class="control-label">
                                                                            <h4><img src="<?php echo base_url('assets/img/gif/loading5.gif') ?>" style="width:30px"> <b>Sedang Mengambil Data ...</b></h4>
                                                                        </label>
                                                                    </div>
                                                                </center>
                                                                <div class="col-lg-12 divOKBOrderPR-<?php echo $list['ORDER_ID']; ?>" style="overflow: auto; display: none;"></div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade mdlOKBListOrderAttachment-<?php echo $list['ORDER_ID']; ?>" role="dialog" aria-labelledby="modalDelete" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4><i style="vertical-align: middle;" class="fa fa-check-circle-o"></i><b> Attachment</b></h4>
                                                            </div>
                                                            <div class="modal-body" style="min-height: 400px;">
                                                                <center>
                                                                    <div class="row text-primary divOKBListOrderAttachmentLoading-<?php echo $list['ORDER_ID']; ?>" style="width: 400px; margin-top: 25px; display: none;">
                                                                        <label class="control-label">
                                                                            <h4><img src="<?php echo base_url('assets/img/gif/loading5.gif') ?>" style="width:30px"> <b>Sedang Mengambil Data ...</b></h4>
                                                                        </label>
                                                                    </div>
                                                                </center>
                                                                <div class="row divAttachmentOKB-<?php echo $list['ORDER_ID']; ?>"></div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </form>

        </div>

    </div>
</section>