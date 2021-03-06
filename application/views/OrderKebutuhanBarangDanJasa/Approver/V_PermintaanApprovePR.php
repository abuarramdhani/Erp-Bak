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
                
                <!-- <form action="<?= base_url('OrderKebutuhanBarangDanJasa/Requisition/createOrder') ?>" method="post" enctype="multipart/form-data"> -->

                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">List Order</h3>
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
                                <div class="panel panel-success">
									<div class="panel-heading">
                                        <p class="bold">Order List</p>
  								    </div>
                                    <div class="panel-body">
                                        <table class="table table-bordered table-hover table-striped tblOKBOrderList">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th><input type="checkbox" class="minimal checkAllApproveOKB"></th>
                                                    <th style="width:10px;">No</th>
                                                    <th style="width:100px;">Pre_Requisition_id</th>
                                                    <th style="width:100px;">Tanggal Order</th>
                                                    <th style="width:100px;">Nama Pembuat Order</th>
                                                    <th style="width:100px;">Seksi Pembuat Order</th>
                                                    <th style="width:100px;">Kode Barang</th>
                                                    <th style="width:100px;">NAMA Barang</th>
                                                    <th style="width:100px;">Quantity</th>
                                                    <th style="width:100px;">UOM</th>
                                                    <th style="width:100px;">Need By Date</th>
                                                    <th style="width:100px;">Keterangan</th>
                                                    <th style="width:100px;">Note To Buyer</th>
                                                    <th style="width:100px;">Status</th>
                                                    <!-- <th>Action</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $no=0; foreach ($listOrder as $key => $list) { $no++; ?>
                                                <tr>
                                                    <td style="text-align:center;"><input type="checkbox" class="minimal checkApproveOKB" value="<?php echo $list['PRE_REQ_ID']; ?>"></td>
                                                    <td><?php echo $no; ?></td>
                                                    <td class="tdOKBListOrderId"><?php echo $list['PRE_REQ_ID']; ?></td>
                                                    <td><?php echo date("d-M-Y",strtotime($list['PRE_REQ_DATE'])); ?></td>
                                                    <td><?php echo $list['NATIONAL_IDENTIFIER'].'-'.$list['FULL_NAME'];?></td>
                                                    <td><?php echo $list['ATTRIBUTE3'];?></td>
                                                    <td><?php echo $list['SEGMENT1']; ?></td>
                                                    <td><?php echo $list['DESCRIPTION']; ?></td>
                                                    <td><?php echo $list['QUANTITY']; ?></td>
                                                    <td><?php echo $list['UOM']; ?></td>
                                                    <td><?php echo date("d-M-Y", strtotime($list['NEED_BY_DATE'])); ?></td>
                                                    <td>
                                                        <?php
                                                            $pre_req = $list['PRE_REQ_ID'];
                                                            $cariKeterangan = $this->M_approver->getKeterangan($pre_req);
                                                            $nom = 0;
                                                            foreach ($cariKeterangan as $key => $keterangan) {$nom++;
                                                               echo $nom.'. '.$keterangan['ATTRIBUTE3'].' <span style="color:red;">- '.$keterangan['ORDER_PURPOSE'].'</span><br>';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $list['NOTE_TO_AGENT']; ?></td>
                                                    <?php if ($list['PRE_REQ_STATUS_ID'] == '4') { 
                                                        $status = "WIP APPROVE PRE REQUISITION";
                                                    } ?>
                                                    <td><button type="button" class="btn btn-info btnOKBListRequisitionHistory"><?php echo $status; ?></button></td>
                                                </tr>
                                                <div class="modal fade mdlOKBListRequisitionHistory-<?php echo $list['PRE_REQ_ID']; ?>" role="dialog" aria-labelledby="modalDelete" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4><i style="vertical-align: middle;" class="fa fa-check-circle-o"> </i> Status <b>Order</b></h4>
                                                            </div>
                                                            <div class="modal-body" style="height: 400px;">
                                                                <center>
                                                                    <div class="row text-primary divOKBListRequisitionHistoryLoading-<?php echo $list['PRE_REQ_ID']; ?>" style="width: 400px; margin-top: 25px; display: none;">
                                                                        <label class="control-label"> <h4><img src="<?php echo base_url('assets/img/gif/loading5.gif') ?>" style="width:30px"> <b>Sedang Mengambil Data ...</b></h4> </label>
                                                                    </div>
                                                                </center>
                                                                <div class="col-lg-12 divOKBListRequisitionHistory-<?php echo $list['PRE_REQ_ID']; ?>" style="overflow: auto; height: 400px; display: none;">
                                                                    <span></span>
                                                                </div>
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
                                <select class="select2 form-control slcOKBTindakanApproverPR slcTindakanOKB" style="width:300px;">
                                    <option></option>
                                    <option value="A">Approve Order</option>
                                    <option value="R">Reject Order</option>
                                </select>
                                <button type="button" class="btn btn-success btnOKBApproverPRAct"> Terapkan</button>
                                <img src="<?= base_url('assets/img/gif/loading5.gif') ?>" class="imgOKBLoading" style="width:35px; height:35px; display:none;">
                            </div>
                        </div>
                    </div>

                <!-- </form> -->

            </div>
            
        </div>
    </section>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalReasonRejectOrderPROKB">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Keterangan / Alasan Reject</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <textarea class="txaReasonRejectPROKB" name="reason" id="txtReason" placeholder="Masukkan keterangan" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" value="" name="" class="btn btn-danger btnRejectorderPROKB">Save & Reject</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
        