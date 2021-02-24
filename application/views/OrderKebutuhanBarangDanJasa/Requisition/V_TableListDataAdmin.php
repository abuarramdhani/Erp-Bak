<?php $no=0; foreach ($listOrder as $key => $list) { $no++; ?>
<?php if ($list['URGENT_FLAG']=='Y' && $list['IS_SUSULAN'] != 'Y') {
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
    <td><span class="tdOKBListOrderId" style="display: none;"><?php echo $list['ORDER_ID']; ?></span><button type="button" class="btn btn-sm btn-default btnOKBInfoPR"><?php echo $list['ORDER_ID']; ?></button></td>
    <td><?= $list['NATIONAL_IDENTIFIER'].', '.$list['FULL_NAME']; ?></td>
    <td><?php echo date("d-M-Y",strtotime($list['ORDER_DATE'])); ?><br><label class="label <?= $flag; ?>"><?= $tag; ?></label></td>
    <td><?php echo $list['SEGMENT1'].'-'.$list['DESCRIPTION']; ?><br><br>
        <?php if ($list['ATTACHMENT'] != 0) { ?>
        <button type="button" class="btn btn-info btn-xs btnAttachmentOKB">view attachment</button>
        <?php }?>
    </td>
    <td><?php echo $list['ITEM_DESCRIPTION']; ?></td>
    <td><?php echo $list['QUANTITY'].' '.$list['UOM']; ?></td>
    <td><?php echo date("d-M-Y", strtotime($list['NEED_BY_DATE'])); ?></td>
    <td>Alasan Order :<?php echo $list['ORDER_PURPOSE']; ?><br>Alasan Urgensi : <?php echo $list['URGENT_REASON']; ?></td>
    <td><?php echo $list['NOTE_TO_PENGELOLA']; ?></td>
    <?php if ($list['ORDER_STATUS_ID'] == '2') { 
                $status = "WIP APPROVE ORDER";
            }else if ($list['ORDER_STATUS_ID'] == '3') {
                $status = "ORDER APPROVED";
            }else if ($list['ORDER_STATUS_ID'] == '4') {
                $status = "REJECTED ORDER";
            }else if ($list['ORDER_STATUS_ID'] == '6') {
                $status = "WIP APPROVE PEMBELIAN";
            }else if ($list['ORDER_STATUS_ID'] == '7') {
                $status = "APPROVED PEMBELIAN";
            }else if ($list['ORDER_STATUS_ID'] == '8') {
                $status = "REJECTED PEMBELIAN";
            } ?>
    <td><button type="button" class="btn btn-info btnOKBListOrderHistory"><?php echo $status; ?></button></td>
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
                <div class="row divAttachmentOKB-<?php echo $list['ORDER_ID'];?>"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>