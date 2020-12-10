<table class="table table-bordered table-stripped text-center">
    <thead class="bg-primary">
        <tr>
            <th>No</th>
            <th>Order ID</th>
            <th>Nama Pembuat Order</th>
            <th>Item Kode</th>
            <th>Deskripsi Item</th>
            <th>Quantity</th>
            <th>Cut Off</th>
            <th>NBD</th>
            <th>Flag</th>
            <th>Buyer</th>
            <th>Note to Buyer</th>
        </tr>
    </thead>
    <tbody>
    <?php $no=0; foreach ($listOrder as $key => $list) { $no++;?>
        <tr>
            <td><?php echo $no;?></td>
            <td><span class="tdOKBListOrderId"><?php echo $list['ORDER_ID']; ?></span><br><?= date("d-M-Y",strtotime($list['ORDER_DATE'])); ?></td>
            <td><?php echo $list['NATIONAL_IDENTIFIER'].'-'.$list['FULL_NAME'].'<br>'.$list['ATTRIBUTE3'];?></td>
            <td><?php echo $list['SEGMENT1'].'-'.$list['DESCRIPTION']; ?></td>
            <td><?php echo $list['ITEM_DESCRIPTION']; ?><br>
            <?php if ($list['ATTACHMENT'] != 0) {?>
                <a class="btn btn-info" href="<?= base_url('OrderKebutuhanBarangDanJasa/Purchasing/ShowAttachment/'.$list['ORDER_ID']); ?>" target="_blank" rel="noopener noreferrer">View Attachment</a>
            <?php } ?></td>
            <td><?php echo $list['QUANTITY'].' '.$list['UOM']; ?></td>
            <td><?php echo $list['CUT_OFF_DATE'];?></td>
            <td><?php echo $list['NEED_BY_DATE']; ?></td>
            <td>
                <?php if ($list['URGENT_FLAG'] == 'Y' && $list['IS_SUSULAN'] == 'N') { ?>
                   <label class="label label-danger"><i>urgent</i></label>
                <?php }else if ($list['URGENT_FLAG'] == 'N' && $list['IS_SUSULAN'] == 'N'){ ?>
                   <label class="label label-success"><i>reguler</i></label>
                <?php }if ($list['IS_SUSULAN'] == 'Y'){ ?>
                    <label class="label label-warning"><i>emergency</i></label>
                <?php } ?>
            </td>
            <td><?php echo $list['BUYER_NAME']; ?></td>
            <td><?php echo $list['NOTE_TO_BUYER']; ?></td>
        </tr>
        <div class="modal fade mdlOKBListOrderAttachment-<?php echo $list['ORDER_ID']; ?> mdlOKBattach" role="dialog" aria-labelledby="modalDelete" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close clsOKBModalAttachment" aria-hidden="true">&times;</button>
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
                        <button type="button" class="btn btn-default clsOKBModalAttachment">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    </tbody>
</table>