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
                            <h3 class="box-title">List Order <?= $stat;?></h3>
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
                                <div class="panel <?= $panel;?>">
									<div class="panel-heading">
                                        <p class="bold">Order List</p>
  								    </div>
                                    <div class="panel-body">
                                        <table class="table table-bordered table-hover table-striped tblOKBReleasedOrderList text-center" width="100%">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th style="width:10px;">No</th>
                                                    <th>Pre_req_id</th>
                                                    <th>Creation Date</th>
                                                    <th>Created By</th>
                                                    <th>Flag</th>
                                                    <th>Approved By</th>
                                                    <th>Approved Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $no=0; foreach ($listOrder as $key => $list) { $no++; ?>
                                                <tr>
                                                    <td><?php echo $no; ?></td>
                                                    <td class="tdOKBListOrderId"><?php echo $list['PRE_REQ_ID']; ?></td>
                                                    <td><?php echo date("d-M-Y",strtotime($list['CREATION_DATE'])); ?></td>
                                                    <td><?php echo $list['NOIND'].'-'.$list['CREATOR'];?></td>
                                                    <td>
                                                        <?php if ($list['APPROVED_FLAG'] == null) { ?>
                                                            <label class="label label-default"><i>no action recorded</i></label>
                                                        <?php } elseif ($list['APPROVED_FLAG'] == 'Y') { ?>
                                                            <label class="label label-success"><i>Approved</i></label>
                                                        <?php }elseif ($list['APPROVED_FLAG'] == 'N') { ?>
                                                            <label class="label label-danger"><i>Rejected</i></label>
                                                        <?php }?>
                                                    </td>
                                                    <td>
                                                        <?php if ($list['APPROVED_BY'] == null) { ?>
                                                            <label class="label label-default"><i>no action recorded</i></label>
                                                        <?php }else{
                                                            echo $list['APPROVER'];
                                                        } ?>
                                                    </td>
                                                    <td>
                                                    <?php if ($list['APPROVED_DATE'] == null) { ?>
                                                            <label class="label label-default"><i>no action recorded</i></label>
                                                        <?php }else{
                                                            echo $list['APPROVED_DATE'];
                                                        } ?>
                                                    </td>
                                                    <td><button type="button" class="btn btn-info btn-xs btnOKBDetailReleasedOrder">Detail</button></td>
                                                </tr>
                                                <div class="modal fade modalDetailReleasedOrderOKB-<?php echo $list['PRE_REQ_ID']; ?>" tabindex="-1" role="dialog" id="">
                                                    <div class="modal-dialog modal-lg" role="document" style="width:1200px;">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">Detail Order</h4>
                                                            </div>
                                                            <div class="modal-body" style="min-height: 500px;">
                                                                <div class="text-center newtableDetailOKB-<?php echo $list['PRE_REQ_ID']; ?>">
                                                                    <img src="<?= base_url('assets/img/gif/loading5.gif') ?>" class="imgOKBLoading" style="width:35px; height:35px;">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                            <?php 
                                                                $encrypted_string = $this->encrypt->encode($list['PRE_REQ_ID']);
                                                                $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                                            ?>
                                                                <a href="<?= base_url('OrderKebutuhanBarangDanJasa/Purchasing/cetakOrder/'.$encrypted_string);?>" target="_blank" type="button" class="btn btn-default"><i class="fa fa-print"></i> cetak</a>
                                                                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
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
                            
                        </div>
                    </div>
            </div>
        </div>
    </section>