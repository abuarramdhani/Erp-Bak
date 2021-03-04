<style>
.tblOKBOrderList thead tr th {
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

            <div class="box box-primary">

                <div class="box-header with-border">
                    <h3 class="box-title">List Order <?= $statOrder;?></h3>
                </div>

                <div class="box-body">
                    <div class="form-group">
                        <label for="txtOKBOrderRequesterName" class="col-sm-2 control-label" style="font-weight:normal">Nama Approver</label>
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
                                <input class="form-control" id="txtOKBOrderRequestorId" name="" value="<?php echo $this->session->user; ?>" readonly>
                                <input type="hidden" class="form-control txtOKBPerson_id" id="txtOKBOrderRequestorId" name="txtOKBOrderRequestorId" value="<?php echo $approver[0]['PERSON_ID']; ?>" readonly>
                            </div>
                        </div>
                    </div> <br><br>

                    <div class="box-body table-responsive no-padding">
                        <div class="panel <?= $panelStatOrder; ?>">
                            <div class="panel-heading">
                                <p class="bold">Order List</p>
                            </div>
                            <div class="panel-body">
                                <table class="table table-bordered table-hover table-striped tblOKBOrderList text-center">
                                    <thead class="bg-primary">
                                        <tr>
                                            <!-- <input type="checkbox" class="minimal checkAllApproveOKB"> -->
                                            <th></th>
                                            <!-- <th>No</th> -->
                                            <th style="width:100px;">Order id</th>
                                            <!-- <th style="width:100px;">Tanggal Order</th> -->
                                            <th style="width:100px;">Nama Pembuat Order</th>
                                            <!-- <th style="width:100px;">Seksi Pembuat Order</th> -->
                                            <th style="width:100px;">Kode Barang</th>
                                            <th style="width:100px;">Deskripsi Item</th>
                                            <!-- <th style="width:100px;">NAMA Barang</th> -->
                                            <th style="width:100px;">Qty + UOM</th>
                                            <!-- <th style="width:100px;">UOM</th> -->
                                            <th style="width:100px;">Need By Date</th>
                                            <th style="width:100px;">Alasan Order</th>
                                            <th style="width:120px;">Note To Pengelola</th>
                                            <th style="width:120px;">Note To Buyer</th>
                                            <th style="width:100px;">Status</th>
                                            <!-- <th>Action</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=0; foreach ($listOrder as $key => $list) { $no++; ?>
                                        <tr>
                                            <td style="text-align:center;"><input type="checkbox" class="minimal checkApproveOKB" value="<?php echo $list['ORDER_ID']; ?>"></td>
                                            <!-- <td><?php echo $no; ?></td> -->
                                            <td><span class="tdOKBListOrderId"><?php echo $list['ORDER_ID']; ?></span><br><?= date("d-M-Y",strtotime($list['ORDER_DATE']));?></td>
                                            <!-- <td><?php echo date("d-M-Y",strtotime($list['ORDER_DATE'])); ?></td> -->
                                            <td><?php echo $list['NATIONAL_IDENTIFIER'].'-'.$list['FULL_NAME'].'<br>'.$list['ATTRIBUTE3'];?></td>
                                            <!-- <td><?php echo $list['ATTRIBUTE3'];?></td> -->
                                            <td><button type="button" class="btn btn-xs btn-default checkStokOKB"><?php echo $list['SEGMENT1'].'-'.$list['DESCRIPTION']; ?></button></td>
                                            <td><?php echo $list['ITEM_DESCRIPTION']; ?><br><?php if ($list['ATTACHMENT'] != 0) { ?>
                                                <button type="button" class="btn btn-info btn-xs btnAttachmentOKB">view attachment</button>
                                                <?php }?>
                                            </td>
                                            <!-- <td><?php echo $list['DESCRIPTION']; ?></td> -->
                                            <td><?php echo $list['QUANTITY'].' '.$list['UOM']; ?></td>
                                            <!-- <td><?php echo $list['UOM']; ?></td> -->
                                            <td><?php echo date("d-M-Y", strtotime($list['NEED_BY_DATE'])); ?></td>
                                            <td><?php echo $list['ORDER_PURPOSE']; ?></td>
                                            <td><?php echo $list['NOTE_TO_PENGELOLA']; ?></td>
                                            <td><?php echo $list['NOTE_TO_BUYER']; ?></td>
                                            <?php if ($list['ORDER_STATUS_ID'] == '3') { 
                                                        $status = "ORDER APPROVED";
                                                    } ?>
                                            <td><button type="button" class="btn btn-info btnOKBListOrderHistory"><?php echo $status; ?></button></td>
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
                                        <div class="modal fade mdlOKBListOrderStock-<?php echo $list['ORDER_ID']; ?>" role="dialog" aria-labelledby="modalDelete" aria-hidden="true">
                                            <div class="modal-dialog" style="width:750px;">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4><i style="vertical-align: middle;" class="fa fa-check-circle-o"> </i> Stock <b>Item</b></h4>
                                                    </div>
                                                    <div class="modal-body" style="height: 300px;">
                                                        <center>
                                                            <div class="row text-primary divOKBListOrderStockLoading-<?php echo $list['ORDER_ID']; ?>" style="width: 400px; margin-top: 25px; display: none;">
                                                                <label class="control-label">
                                                                    <h4><img src="<?php echo base_url('assets/img/gif/loading5.gif') ?>" style="width:30px"> <b>Sedang Mengambil Data ...</b></h4>
                                                                </label>
                                                            </div>
                                                        </center>
                                                        <div class="row divStockOKB-<?php echo $list['ORDER_ID'];?>"></div>
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
                                                        <div class="row divAttachmentOKB-<?php echo $list['ORDER_ID'];?>"></div>
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
                <div class="box-footer">
                    <div class="col-lg-6">
                        <button type="button" class="btn btn-success btnOKBReleaseOrderPulling"> Release</button>
                        <img src="<?= base_url('assets/img/gif/loading5.gif') ?>" class="imgOKBLoading" style="width:35px; height:35px; display:none;">
                    </div>
                </div>
            </div>


        </div>

    </div>
</section>
<div class="modal fade" tabindex="-1" role="dialog" id="modalReasonRejectOrderOKB">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Keterangan / Alasan Reject</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <textarea class="txaReasonRejectOKB" name="reason" id="txtReason" placeholder="Masukkan keterangan" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" value="" name="" class="btn btn-danger btnRejectorderOKB">Save & Reject</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>