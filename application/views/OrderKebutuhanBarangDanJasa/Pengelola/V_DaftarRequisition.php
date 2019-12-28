<style>
    .tblOKBNewOrderList thead tr th {
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
                
                <form action="<?= base_url('OrderKebutuhanBarangDanJasa/Requisition/createOrder') ?>" method="post" enctype="multipart/form-data">

                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">List Requisition</h3>
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
                            </div> <br><br>

                            <div class="box-body table-responsive no-padding">
                                <div class="panel panel-success">
									<div class="panel-heading">
                                        <p class="bold">Requisition List</p>
  								    </div>
                                    <div class="panel-body">
                                        <table class="table table-bordered table-hover table-striped tblOKBOrderListPengorder">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <!-- <th style="text-align:center;"><input type="checkbox" class="minimal checkAllApproveOKB"></th> -->
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $no=0; foreach ($monitoringRequisition as $key => $list) { $no++; ?>
                                                <tr>
                                                    <!-- <td style="text-align:center;"><input type="checkbox" class="minimal checkApproveOKB" value="<?php echo $list['PRE_REQ_ID']; ?>"></td> -->
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
                                                    }else if($list['PRE_REQ_STATUS_ID'] == '5'){
                                                        $status = "PRE REQUISITION APPROVED";
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
                                                                        <label class="control-label"> <h4><img src="<? echo base_url('assets/img/gif/loading5.gif') ?>" style="width:30px"> <b>Sedang Mengambil Data ...</b></h4> </label>
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

                    </div>

                </form>

            </div>
            
        </div>
    </section>