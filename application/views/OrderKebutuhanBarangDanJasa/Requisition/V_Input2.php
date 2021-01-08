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
    .OKB-table {
        border: none;
        border-right: solid 1px #DDEFEF;
        border-collapse: separate;
        border-spacing: 0;
        /* font: normal 13px Arial, sans-serif; */
    }
    .OKB-table thead th {
        background-color: #DDEFEF;
        border: none;
        color: #336B6B;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
        white-space: nowrap;
    }
    .OKB-table tbody td {
        border-bottom: solid 1px #DDEFEF;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
        white-space: nowrap;
    }
    .OKB-wrapper {
        position: relative;
    }
    .OKB-scroller {
        margin-left: 689px;
        overflow-x: scroll;
        overflow-y: visible;
        padding-bottom: 5px;
        width: auto;
    }
    .OKB-table .OKB-sticky-col {
        border-left: solid 1px #DDEFEF;
        border-right: solid 1px #DDEFEF;
        left: 0;
        position: absolute;
        top: auto;
        width: 36px;
    }
    .OKB-table .OKB-sticky-col2 {
        border-left: solid 1px #DDEFEF;
        border-right: solid 1px #DDEFEF;
        left: 35px;
        position: absolute;
        top: auto;
        width: 220px;
    }
    .OKB-table .OKB-sticky-col3 {
        border-left: solid 1px #DDEFEF;
        border-right: solid 1px #DDEFEF;
        left: 254px;
        position: absolute;
        top: auto;
        width: 218px;
    }
    .OKB-table .OKB-sticky-col4 {
        border-left: solid 1px #DDEFEF;
        border-right: solid 1px #DDEFEF;
        left: 471px;
        position: absolute;
        top: auto;
        width: 218px;
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
                                    <div style="float: right">
                                        <button type="button" class="btn btn-md btn-primary btnOKBNewOrderList" title="Tambah Data"><i class="fa fa-plus"></i></button>
                                    </div>
                                    <p class="bold">New Order List</p>
                                    <!-- <span>Status order :&nbsp;</span><button type="button" class="btn btn-success">Normal</button> -->
  								</div>

                                <div class="panel-body">
                                    <div class="OKB-wrapper">
                                        <div class="OKB-scroller">
                                            <table class="OKB-table" width="200%">
                                                <thead>
                                                    <tr>
                                                        <th class="OKB-sticky-col">No</th>
                                                        <th class="OKB-sticky-col2">Kode Barang</th>
                                                        <th class="OKB-sticky-col3">Nama Barang</th>
                                                        <th class="OKB-sticky-col4">Deskripsi</th>
                                                        <th>QTY</th>
                                                        <th>UOM</th>
                                                        <th>Kategori Item</th>
                                                        <th>Leadtime</th>
                                                        <th>NBD</th>
                                                        <th>Destination Line</th>
                                                        <th>Alasan Order</th>
                                                        <th>Alasan Urgensi</th>
                                                        <th>Note to Pengelola</th>
                                                        <th>Attachment</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="trOKBNewOrderListDataRow" data-row="1">
                                                        <td class="OKB-sticky-col" style="height:55px;"> 1 </td>
                                                        <td class="text-center OKB-sticky-col2"><select class="select2 slcOKBNewOrderList" name="slcOKBinputCode[]" required style="width:200px"></select> </td>
                                                        <td class="OKB-sticky-col3"><input class="form-control txtOKBNewOrderListItemName" readonly name="txtOKBitemName[]"> </td>
                                                        <td class="OKB-sticky-col4"><textarea style="height: 34px;" class="form-control txaOKBNewOrderDescription" name="txtOKBinputDescription[]" readonly></textarea> </td>
                                                        <td><input type="text" class="form-control txtOKBNewOrderListQty" name="txtOKBinputQty[]" required style="background-color: #fbfb5966; min-width:70px;"></td>
                                                        <td class="text-center"> <select class="form-control select2 slcOKBNewUomList" name="slcOKBuom[]" required style="width:120px"></select> </td>
                                                        <td><input type="text" class="form-control kategoriItemOKB" name="" id="" readonly style="width:200px;"> </td>
                                                        <td><input type="text" class="form-control leadtimeOKB" name="txtOKBLeadtime[]" id="" readonly> </td>
                                                        <td><input type="text" class="form-control nbdOKB" name="txtOKBnbd[]" id="" required style="background-color: #fbfb5966; min-width:120px;"> </td>
                                                        <td><input type="text" class="form-control txtDestLineOKB" placeholder="Click Here!" data-row="1" required style="background-color: #fbfb5966; min-width:130px;"></td>
                                                        <td><textarea style="height: 34px; min-width:150px; background-color: #fbfb5966;" class="form-control txaOKBNewOrderListReason" name="txtOKBinputReason[]" required></textarea> </td>
                                                        <td><textarea style="height: 34px; min-width:150px;" class="form-control txaOKBNewOrderListUrgentReason" name="txtOKBinputUrgentReason[]" required></textarea> </td>
                                                        <td><textarea style="height: 34px; min-width:150px; " class="form-control txaOKBNewOrderListNote" name="txtOKBinputNote[]"></textarea> </td>
                                                        <td><input type="file" name="fileOKBAttachment1[]" multiple></td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-success btnOKBNewOrderListCancel" data-row="1" title="Batal">
                                                                <i class="fa fa-refresh"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-danger btnOKBNewOrderListDelete" title="Hapus" disabled>
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </td>
                                                        <td style="display:none;"><input type="hidden" class="hdnDestOKB" name="hdnDestinationOKB[]"></td>
                                                        <td style="display:none;"><input type="hidden" class="hdnOrgOKB" name="hdnOrganizationOKB[]"></td>
                                                        <td style="display:none;"><input type="hidden" class="hdnLocOKB" name="hdnLocationOKB[]"></td>
                                                        <td style="display:none;"><input type="hidden" class="hdnSubinvOKB" name="hdnSubinventoyOKB[]"></td>
                                                        <td style="display:none;"><input type="hidden" class="hdUrgentFlagOKB" name="hdnUrgentFlagOKB[]"></td>
                                                        <td style="display:none;"><input type="hidden" class="hdnItemCodeOKB" name="hdnItemCodeOKB[]"></td>
                                                        <td style="display:none;"><input type="hidden" class="hdnEstArrivalOKB" name="hdnEstArrivalOKB[]"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>                                    
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
                            <button type="submit" class="btn btn-primary btnBuatOrderOkebaja" disabled><i class="fa fa-shopping-cart"></i> Buat Order </button>
                        </div>
                    </div>

                </div>

            </form>

        </div>
            
    </div>
</section>
<div class='mdlTambahDestOKB'>
    <div class="modal fade" id="modal-destination-okb" data-row="1">
        <div class="modal-dialog" style="width: 470px;">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #337AB7; color:#FFF;">
                    <h4 class="modal-title text-center">Destination Line</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Destination Type :</label>
                                <div class="loadingDestinationOKB" style="display: none;width:100%;margin-top: 0px;margin-bottom: 20px" data-row="1">
                                    <img style="width:50px"src="<?php echo base_url().'assets/img/gif/loading5.gif' ?>" />
                                </div>
                                <div class="col-sm-8 dest_typeOKB" data-row="1" style="display: block;">
                                    <input type="text" class="form-control text-center destinationOKB" id="txtModalDestination" style="width: 250px;" title="Destination Type" data-row="1" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Organization :</label>
                                <div class="loadingOrganizationOKB" data-row="1" style="display: none; width:100%;margin-top: 0px;margin-bottom: 20px">
                                        <img style="width:50px" src="<?php echo base_url().'assets/img/gif/loading5.gif' ?>" />
                                </div>
                                <div class="col-sm-8 viewOrganizationOKB" data-row="1" style="display: block;">
                                    <select class="select2 organizationOKB" id="slcModalOrganization" style="width: 250px; text-align:center" name="slcOrganization" title="Organization" data-row="1">
                                        <option></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Location :</label>
                                <div class="loadingLocationOKB" data-row="1" style="display: none; width:100%;margin-top: 0px;margin-bottom: 20px">
                                    <img style="width:50px" src="<?php echo base_url().'assets/img/gif/loading5.gif' ?>" />
                                </div>
                                <div class="col-sm-8 viewLocationOKB" data-row="1">
                                    <select class="select2 locationOKB" id="slcLocation" style="width: 250px; text-align:center" name="slcLocation" title="Location" data-row="1">
                                        <option></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Subinventory :</label>
                                <div class="loadingSubinventoryOKB" data-row="1" style="display: none; width:100%;margin-top: 0px;margin-bottom: 20px">
                                    <img style="width:50px" src="<?php echo base_url().'assets/img/gif/loading5.gif' ?>" />
                                </div>
                                <div class="col-sm-8 viewSubinventoryOKB" data-row="1">
                                    <select class="select2 subinventoryOKB" id="slcSubinventory" data-row="1" style="width: 250px; text-align:center" name="slcSubinventory">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" data-row="1" class="btn btn-primary btnCloseModalDestOKB" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade mdlOKBStatusOrder" role="dialog" aria-labelledby="modalDelete" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4><i style="vertical-align: middle;" class="fa fa-question-circle"></i> Status <b>Order</b></h4>
            </div>
            <div class="modal-body">
                <center>
                    Silahkan memilih status order anda
                </center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success pull-left btnOKBStatusOrderNormal" data-dismiss="modal"><i class="fa fa-fw fa-check"></i> Reguler</button>
                <button type="button" class="btn btn-warning btnOKBStatusOrderFollowUp" data-dismiss="modal"><i class="fa fa-warning"></i> Emergency (Susulan)</button>
            </div>
        </div>
    </div>
</div>