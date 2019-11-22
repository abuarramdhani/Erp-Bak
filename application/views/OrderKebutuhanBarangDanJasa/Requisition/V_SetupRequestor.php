<style>
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
                            <h3 class="box-title">Setup Approver</h3>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="txtOKBOrderRequesterName" class="col-sm-2 control-label" style="font-weight:normal">Nama Pengorder</label>
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
                                        <input type="hidden" class="form-control hdnPersonIdOKB" id="txtOKBOrderRequestorId" name="txtOKBOrderRequestorId" value="<?php echo $pengorder[0]['PERSON_ID'] ?>" readonly>
                                    </div>
                                </div>
                            </div> <br>
                            
                            <div class="form-group">
                                <label for="txtOKBSectionOrderRequester" class="col-sm-2 control-label" style="font-weight:normal">Seksi Pemberi Order</label>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i style="width:15px;" class="fa fa-users"></i></span>
                                        <input class="form-control" id="txtOKBSectionOrderRequestor" name="txtOKBSectionOrderRequestor" value="<?php echo $pengorder[0]['ATTRIBUTE3']?>" readonly>
                                    </div>
                                </div>  

                            </div> <br> <br>

                            <div class="box-body table-responsive no-padding">
                                <div class="panel panel-warning">
									<div class="panel-heading">
                                        <div style="float: right">
                                        </div>
                                        <p class="bold">Setting</p>
  								    </div>
                                    <div class="panel-body">
                                        <div class="col-md-6">
                                            <table class="table">
                                                <tr>
                                                    <td><span>Atasan Level Kasie / Requestor</span></td>
                                                    <td>:</td>
                                                    <td>
                                                        <select class="select2 slcAtasanOKB slcRequestorOKB" style="width:285px" name="slcAtasanKasieOKB" required>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>
                                            <div class="pull-right">
                                                <button type="button" class="btn btn-primary btnSetRequestorOKB">Apply</button>
                                                <img src="<?= base_url('assets/img/gif/loading5.gif') ?>" class="imgOKBLoading" style="width:35px; height:35px; display:none;">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                        <table class="table">
                                                <tr>
                                                    <td><span>Requestor Aktif Saat ini</span></td>
                                                    <td>:</td>
                                                    <td>
                                                    <?php if (count($activeRequestor) != 0) { ?>
                                                        <input type="text" class="form-control txtRequestoractOKB" value="<?= $activeRequestor[0]['FULL_NAME']; ?>" readonly>
                                                    <?php }else{ ?>
                                                        <input type="text" class="form-control txtRequestoractOKB" value="" readonly>

                                                    <?php } ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="box-footer">
                            <div class="pull-right">
                                <button type="button" class="btn btn-default"><i class="fa fa-times"></i> Batal </button>
                                <button type="submit" class="btn btn-primary btnBuatOrderOkebaja" disabled><i class="fa fa-shopping-cart"></i> Buat Order </button>
                            </div>
                        </div> -->

                    </div>
            </div>
            
        </div>
    </section>