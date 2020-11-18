<style>
    .tblOKBOrderList thead tr th {
        text-align: center;
    }
    .txaOKBNewOrderListReason, .txaOKBNewOrderListNote {
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
                            <h3 class="box-title">List</h3>
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

                            <div class="col-lg-8">
                                <div class="box-body table-responsive no-padding">
                                    <div class="panel <?= $panelStatOrder; ?>">
                                        <div class="panel-heading">
                                            <p class="bold">Ready To Release</p>
                                        </div>
                                        <div class="panel-body">
                                            <table class="table table-bordered table-hover table-striped tblOKBOrderList text-center">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <!-- <input type="checkbox" class="minimal checkAllApproveOKB"> -->
                                                        <th></th>
                                                        <!-- <th>No</th> -->
                                                        <th style="width:100px;">SUM(Quantity)</th>
                                                        <th style="width:100px;">Kode Barang</th>
                                                        <th style="width:100px;">Deskripsi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php $no=0; foreach ($listOrder as $key => $list) { $no++; ?>
                                                    <tr>
                                                        <td style="text-align:center;"><input type="checkbox" class="minimal checkApproveOKB" value="<?php echo $list['INVENTORY_ITEM_ID']; ?>"></td>
                                                        <td><?= $list['SUM(OOH.QUANTITY)'];?></td>
                                                        <td><?= $list['SEGMENT1'];?></td>
                                                        <td><?= $list['DESCRIPTION'];?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="col-lg-6">
                                <button type="button" class="btn btn-success btnOKBReleaseOrderPullingBatch"> Release</button>
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
        