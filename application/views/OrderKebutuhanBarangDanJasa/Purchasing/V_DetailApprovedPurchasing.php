<section class="content-header">
        <h1> Order Kebutuhan Barang dan Jasa </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">List Detail Approved Order</h3>
                </div>
                <div class="box-body">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <p class="bold">Order list</p>
                        </div>
                        <div class="panel-body">
                            <div>
                                <span class="col-sm-1" style="background-color :#f39c12;">&nbsp;</span>
                                <span>&nbsp;*Terdapat Attachment/Lampiran</span>
                            </div><br><br>
                            <table class="table table-hover table-bordered table-striped tblDetailApprovedPurchasingOKB">
                                <thead>
                                    <tr class="bg-primary">
                                        <th>Pre_req_id</th>
                                        <th>Order id</th>
                                        <th>Order Date</th>
                                        <th>PR Number</th>
                                        <th>Line Number</th>
                                        <th>Buyer</th>
                                        <th>Approved Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($list_detail as $key => $list) { 
                                    if ($list['ATTACHMENT'] > 0) {
                                        $bg = "style='background-color :#f39c12;'";
                                     }else{
                                         $bg = '';
                                     }
                                ?>
                                    <tr <?= $bg;?> >
                                        <td><?= $list['PRE_REQ_ID'];?></td>
                                        <td><button type="button" class="btn btn-sm btn-info btnOKBDetailApprovedOrderPurchasing"><?= $list['ORDER_ID'];?></button></td>
                                        <td><?= $list['ORDER_DATE'];?></td>
                                        <td><?= $list['NO_PR'];?></td>
                                        <td><?= $list['PR_LINE_NUM'];?></td>
                                        <td><?= $list['BUYER'];?></td>
                                        <td><?= $list['APPROVED_DATE'];?></td>
                                    </tr>
                                    <div class="modal fade" id="mdlOKBDetailApprovedPurchasing-<?= $list['ORDER_ID'];?>" role="dialog">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title"><i class="fa fa-search"></i>Detail Order - <?= $list['ORDER_ID'];?></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-center newtableDetailApprovedOKB-<?php echo $list['ORDER_ID']; ?>">
                                                        <img src="<?= base_url('assets/img/gif/loading5.gif') ?>" class="imgOKBLoading" style="width:35px; height:35px;">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
    </div>
</section>