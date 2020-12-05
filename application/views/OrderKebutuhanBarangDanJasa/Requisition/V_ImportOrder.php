<style>
    .slcOKBNewOrderList+.select2-container>.selection>.select2-selection, .slcOKBNewUomList+.select2-container>.selection>.select2-selection{
        background: #fbfb5966;
        text-align: left;
    }
    .tblOKBNewOrderList thead tr th {
        text-align: center;
    }
    .txaOKBNewOrderListReason, .txaOKBNewOrderListNote {
        height: 34px;
        resize: vertical;
    }
    .divOKBScrollable {
		overflow-x: scroll;
	}
    .ml-15px {
        margin-left: 15px;
    }
    .bold {
        font-weight: bold;
    }
    .organizationOKB+.select2-container>.selection>.select2-selection, .locationOKB+.select2-container>.selection>.select2-selection,.subinventoryOKB+.select2-container>.selection>.select2-selection{
        text-align: center;
    }
    .bright-success {
        background-color: #62d19f !important;
    }
    .bright-warning {
        background-color: #f6d365 !important;
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
                        <h3 class="box-title">Buat Baru</h3>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label for="txtOKBOrderCreatorName" class="col-sm-2 control-label" style="font-weight:normal">Nama Pemberi Order</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-user"></i></span>
                                    <input class="form-control" id="txtOKBOrderCreatorName" name="txtOKBOrderCreatorName" value="<?php echo $this->session->employee; ?>" readonly>
                                </div>
                            </div>
                            <label for="txtOKBOrderDate" style="font-weight:normal" class="col-sm-3 control-label text-right">Tanggal Order</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-calendar"></i></span>
                                    <input class="form-control" id="txtOKBOrderDate" name="txtOKBOrderDate" value="<?php echo date("d F Y")?>" readonly>
                                </div>
                            </div>
                        </div> <br>

                        <div class="form-group">
                            <label for="txtOKBOrderCreatorIDNumber" class="col-sm-2 control-label" style="font-weight:normal">No. Induk</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-list-ol"></i></span>
                                    <input class="form-control" id="txtOKBOrderCreatorId" name="" value="<?php echo $this->session->user; ?>" readonly>
                                    <input type="hidden" class="form-control" id="txtOKBOrderCreatorId" name="txtOKBOrderCreatorId" value="<?php echo $pengorder[0]['PERSON_ID'] ?>" readonly>
                                </div>
                            </div>
                                
                        </div> <br>
                            
                        <div class="form-group">
                            <label for="txtOKBSectionOrderCreator" class="col-sm-2 control-label" style="font-weight:normal">Seksi Pemberi Order</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-users"></i></span>
                                    <input class="form-control" id="txtOKBSectionOrderCreator" name="txtOKBSectionOrderCreator" value="<?php echo $pengorder[0]['ATTRIBUTE3']?>" readonly>
                                </div>
                            </div>
                            <!-- untuk admin -->
                            <?php if ($this->session->responsibility_id == 2683) { ?>
                                <label for="txtOKBOrderRequesterName" style="font-weight:normal" class="col-sm-3 control-label text-right">Requester</label>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i style="width:15px;" class="fa fa-user"></i></span>
                                        <input class="form-control" id="txtOKBOrderReqesterName" name="txtOKBOrderRequesterName" value="<?php echo $requester[0]['FULL_NAME']; ?>" readonly>
                                        <input type="hidden" class="form-control" id="txtOKBOrderReqesterId" name="txtOKBOrderRequesterId" value="<?php echo $requester[0]['APPROVER']; ?>" readonly>
                                    </div>
                                </div>
                            <?php }else{ ?>
                                <input type="hidden" class="form-control" id="txtOKBOrderReqesterId" name="txtOKBOrderRequesterId" value="<?php echo $pengorder[0]['PERSON_ID']; ?>" readonly>
                            <?php } ?>  
                        </div> <br> <br>

                        <div class="form-group">
                            <label for="txtOKBStatusOrder" class="col-sm-2 control-label" style="font-weight:normal">Status Order</label>
                            <div class="col-sm-3">
                                <a href="#">
                                <div class="input-group">
                                    <span class="input-group-addon bright-success btnOKBChangeStatusOrder" style=""><i style="width: 15px; color: #f7f7f7 !important;" class="fa fa-fw fa-check"></i></span>
                                    <input class="form-control btnOKBChangeStatusOrder" id="txtOKBStatusOrder" name="txtOKBStatusOrder" value="REGULER" readonly="">
                                    <input type="hidden" id="txtOKBHdnStatusOrder" name="txtOKBHdnStatusOrder" value="N" readonly="" class="form-control">
                                </div>
                                </a>
                            </div>
                        </div> <br> <br>

                        <div class="box-body table-responsive no-padding">
                            <div class="panel panel-default">
								<div class="panel-heading">
                                    <p class="bold">Import Order Via Excel</p>
  								</div>

                                <div class="panel-body">
                                    <a href="<?= base_url('assets/upload/Okebaja/import/import_okebaja.xls');?>" type="button" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Download Template Excel</a><br><br>
                                    <table class="table">
                                        <tr>
                                            <th>Pilih File</th>
                                            <th>:</th>
                                            <th><input type="file" name="userfile" id="uploadOKB"></th>
                                            <th><button type="button" class="btn btn-primary btnUploadOKB">Upload</button></th>
                                        </tr>
                                    </table>
                                    <div class="text-center loadingImportOKB" style="display:none;">
                                        <img src="<?= base_url('assets/img/gif/loading14.gif');?>">
                                    </div>
                                </div>
                            </div>
                            <div class="listOKB">
                            </div>

                            <div class="form-group">
                                <!-- <div class="row"> -->
                                    <div class="col-sm">
                                        <label class="control-label ml-15px" for="txaOKBNewOrderListConfirm">
                                            Pernyataan Konfirmasi
                                        </label>
                                    </div>
                                    <div class="col-sm">
                                        <label class="control-label ml-15px">
                                            <input type="checkbox" id="txaOKBNewOrderListConfirm" class="minimal checkBoxConfirmOrderOkebaja">
                                            <span style="font-weight:normal">Order yang dibuat adalah sepenuhnya tanggung jawab pembuat order dan akan di teruskan ke atasan terkait serta pengelola.
                                            </span>
                                        </label>
                                    </div>
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="pull-right">
                            <!-- <button type="button" class="btn btn-default"><i class="fa fa-times"></i> Batal </button> -->
                            <button type="submit" class="btn btn-primary btnBuatOrderOkebaja" disabled name="btnOKBSubmit" value="1"><i class="fa fa-shopping-cart"></i> Buat Order </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

