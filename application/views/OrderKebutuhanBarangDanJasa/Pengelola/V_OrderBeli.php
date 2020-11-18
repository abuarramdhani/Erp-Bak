<style>
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
                                        <input type="hidden" class="form-control txtOKBPerson_id" id="txtOKBOrderRequestorId" name="txtOKBOrderRequestorId" value="" readonly>
                                    </div>
                                </div>
                            </div> <br><br>

                            <div class="box-body table-responsive no-padding">
                                <div class="panel panel-success">
									<div class="panel-heading">
                                        <p class="bold">Order List</p>
  								    </div>
                                    <div class="panel-body">
                                        <table class="table table-bordered table-hover table-striped tblOKBOrderListPengorder">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <!-- <th style="text-align:center;"><input type="checkbox" class="minimal checkAllApproveOKB"></th> -->
                                                    <th class="bg-primary">No</th>
                                                    <th class="bg-primary" style="width:60px;">Order id</th>
                                                    <th class="bg-primary" style="width:100px;">Tanggal Order</th>
                                                    <th class="bg-primary" style="width:100px;">Nama Pembuat Order</th>
                                                    <!-- <th class="bg-primary">Saksi Pembuat Order</th> -->
                                                    <th class="bg-primary" style="width:100px;">Kode Barang</th>
                                                    <th style="width:100px;">Deskripsi Item</th>
                                                    <!-- <th style="width:100px;">Nama Barang</th> -->
                                                    <th class="bg-primary">Qty + UOM</th>
                                                    <!-- <th style="width:100px;">UOM</th> -->
                                                    <th style="width:100px;">Need By Date</th>
                                                    <th style="width:100px;">Alasan Order</th>
                                                    <th style="width:100px;">Alasan Urgensi</th>
                                                    <th style="width:100px;">Note To Buyer</th>
                                                    <th style="width:100px;">Status</th>
                                                    <th style="display:none;"></th>
                                                    <th style="display:none;"></th>
                                                    <th style="display:none;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=0; foreach ($listOrder as $key => $list) { $no++;
                                                    if ($list['URGENT_FLAG']=='Y' && $list['IS_SUSULAN'] != 'Y') {
                                                        $flag = 'label-danger';
                                                        $tag = 'urgent';
                                                    }else if ($list['URGENT_FLAG']=='N' && $list['IS_SUSULAN'] != 'Y'){
                                                        $flag = 'label-success';
                                                        $tag = 'reguler';
                                                    }else if ($list['IS_SUSULAN'] == 'Y') {
                                                        $flag = 'label-warning';
                                                        $tag = 'emergency';
                                                    }
                                                    
                                                ?>
                                                    <tr>
                                                        <td><?php echo $no; ?></td>
                                                        <td><span class="tdOKBListOrderId"><?php echo $list['ORDER_ID']; ?></span><br>
                                                        </td>
                                                        <td><?php echo date("d-M-Y",strtotime($list['ORDER_DATE'])); ?><br><label class="label <?= $flag; ?>"><?= $tag; ?></label></td>
                                                        <td><?php echo $list['NATIONAL_IDENTIFIER'].'-'.$list['FULL_NAME'].'<br>'.$list['ATTRIBUTE3'];?></td>
                                                        <!-- <td><?php echo $list['ATTRIBUTE3'];?></td> -->
                                                        <td><button type="button" class="btn btn-xs btn-default checkStokOKB"><?php echo $list['SEGMENT1'].'-'.$list['DESCRIPTION']; ?></button></td>
                                                        <!-- <td><?php echo $list['DESCRIPTION']; ?></td> -->
                                                        <td><?php echo $list['ITEM_DESCRIPTION']; ?><br><?php if ($list['ATTACHMENT'] != 0) { ?>
                                                        <button type="button" class="btn btn-info btn-xs btnAttachmentOKB">view attachment</button>
                                                        <?php }?></td>
                                                        <td><?php echo $list['QUANTITY'].' '.$list['UOM']; ?></td>
                                                        <!-- <td><?php echo $list['UOM']; ?></td> -->
                                                        <td><?php echo date("d-M-Y", strtotime($list['NEED_BY_DATE'])); ?></td>
                                                        <td><?php echo $list['ORDER_PURPOSE']; ?></td>
                                                        <td><?php echo $list['URGENT_REASON']; ?></td>
                                                        <td><?php echo $list['NOTE_TO_PENGELOLA']; ?></td>
                                                        <?php if ($list['ORDER_STATUS_ID'] == '2') { 
                                                            $status = "WIP APPROVE ORDER";
                                                        }else if ($list['ORDER_STATUS_ID'] == '3') {
                                                            $status = "ORDER APPROVED";
                                                        }else if ($list['ORDER_STATUS_ID'] == '4') {
                                                            $status = "ORDER REJECTED";
                                                        } ?>
                                                        <td><button type="button" class="btn btn-info btn-sm btnOKBListOrderHistory"><?php echo $status; ?></button></td>
                                                        <td style="display: none;"></td>
                                                        <td style="display: none;"></td>
                                                        <td style="display: none;"></td>
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
                                                                            <label class="control-label"> <h4><img src="<?php echo base_url('assets/img/gif/loading5.gif') ?>" style="width:30px"> <b>Sedang Mengambil Data ...</b></h4> </label>
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
                                                                            <label class="control-label"> <h4><img src="<?php echo base_url('assets/img/gif/loading5.gif') ?>" style="width:30px"> <b>Sedang Mengambil Data ...</b></h4> </label>
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
                                                                <div class="modal-body" style="height: 400px;">
                                                                    <center>
                                                                        <div class="row text-primary divOKBListOrderAttachmentLoading-<?php echo $list['ORDER_ID']; ?>" style="width: 400px; margin-top: 25px; display: none;">
                                                                            <label class="control-label"> <h4><img src="<?php echo base_url('assets/img/gif/loading5.gif') ?>" style="width:30px"> <b>Sedang Mengambil Data ...</b></h4> </label>
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
                            <!-- <div class="col-lg-6">
                                <select class="select2 form-control slcOKBTindakanPengelolaBeli slcTindakanOKB" style="width:300px;">
                                    <option></option>
                                    <option value="1">Create PR</option>
                                    <option value="R">Reject Order</option>
                                </select>
                                <button type="button" class="btn btn-success btnOKBPengelolaBeliAct"> Terapkan</button>
                                <img src="<?= base_url('assets/img/gif/loading5.gif') ?>" class="imgOKBLoading" style="width:35px; height:35px; display:none;">
                            </div> -->
                        </div>
                    </div>

            </div>
            
        </div>
    </section>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalNoteToAgentOKB">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Note To Agent</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <textarea class="txaNoteToAgentOKB" name="reason" id="txtReason" placeholder="Note To Agent" style="width: 100%; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea><br><br>
                        <textarea class="txaItemDescPengelolaOKB" name="reason" id="txtReason" placeholder="Item Description" style="width: 100%; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                    </div>
                    <div>
                        <input type="text" class="form-control nbdOKB" placeholder="please insert need by date!">
                    </div>
                <div class="modal-footer">
                    <button type="button" value="" name="" class="btn btn-success btnCreatePRPengelolaOKB">Process</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
        