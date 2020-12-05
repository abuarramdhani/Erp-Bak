<style>
    .slcOKBNewOrderList+.select2-container>.selection>.select2-selection, .slcOKBNewUomList+.select2-container>.selection>.select2-selection{
        background: #fbfb5966;
        text-align: left;
    }
    .bright-success {
        background-color: #62d19f !important;
    }
    .bright-warning {
        background-color: #f6d365 !important;
    }
    .organizationOKB+.select2-container>.selection>.select2-selection, .locationOKB+.select2-container>.selection>.select2-selection,.subinventoryOKB+.select2-container>.selection>.select2-selection{
        text-align: center;
    }
</style>
<section class="content-header">
    <h1> Order Kebutuhan Barang dan Jasa </h1>
</section>
<section class="content">
    <div class="row">
        <form action="<?= base_url('OrderKebutuhanBarangDanJasa/Requisition/createOrder') ?>" method="post" enctype="multipart/form-data">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <div class="box-title with-border">
                            Penginput Order
                        </div>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="txtOKBOrderCreatorName" class="col-sm-2 control-label" style="font-weight:normal">Nama Penginput Order</label>
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
                            <label for="txtOKBSectionOrderCreator" class="col-sm-2 control-label" style="font-weight:normal">Seksi Penginput Order</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-users"></i></span>
                                    <input class="form-control" id="txtOKBSectionOrderCreator" name="txtOKBSectionOrderCreator" value="<?php echo $pengorder[0]['ATTRIBUTE3']?>" readonly>
                                </div>
                            </div>
                            <!-- untuk admin -->
                            <?php if ($this->session->responsibility_id == 2678) { ?>
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
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Orders</h3>
                        <div class="pull-right">
                            <button type="button" class="btn btn-primary btnOKBNewOrderList"><i class="fa fa-plus"></i> Add</button>
                        </div>
                    </div>
                    <div class="box-body bodyformOKB" style="overflow: scroll;height: 500px;">
                        <div class="col-md-12 formOKB" id-form="1">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <div class="box-title with-border">
                                        Order No : 1
                                        <button type="button" class="btn btn-success btnOKBNewOrderListCancel" title="clear line" data-row="1"><i class="fa fa-refresh"></i></button>
                                        <button type="button" class="btn btn-danger btnOKBNewOrderListDelete" disabled><i class="fa fa-trash"></i></button>
                                        <span class="OKBOrderNameMinimize"></span>
                                    </div>
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-box-tool OKBMinimize" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body" id="parentsItemOKB">
                                    <table class="table tblOKBOrderNew">
                                        <tr>
                                            <th>Kode Barang</th>
                                            <th>:</th>
                                            <td><select class="select2 slcOKBNewOrderList slcOKBOrder" name="slcOKBinputCode[]" required style="width:360px"></select> <button type="button" class="btn btn-default btnOKBStokNew" style="display:none">INFO</button></td>
                                        </tr>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>:</th>
                                            <td><select class="select2 slcOKBNewOrderListNamaBarang slcOKBOrder" name="" required style="width:360px"></select></td>
                                            <!-- <td><input class="form-control txtOKBNewOrderListItemName" readonly name="txtOKBitemName[]" style="width:360px"></td> -->
                                        </tr>
                                        <tr>
                                            <th>Deskripsi</th>
                                            <th>:</th>
                                            <td><textarea style="height: 34px; width:360px;" class="form-control txaOKBNewOrderDescription" name="txtOKBinputDescription[]" readonly></textarea></td>
                                        </tr>
                                        <tr>
                                            <th>Quantity</th>
                                            <th>:</th>
                                            <td><input type="text" class="form-control txtOKBNewOrderListQty" name="txtOKBinputQty[]" required style="background-color: #fbfb5966; width: 250px;"></td>
                                        </tr>
                                        <tr>
                                            <th>UOM</th>
                                            <th>:</th>
                                            <td><select class="form-control select2 slcOKBNewUomList slcOKBOrder" name="slcOKBuom[]" required style="width:250px;"></select></td>
                                        </tr>
                                        <tr>
                                            <th>Kategori Item</th>
                                            <th>:</th>
                                            <td><input type="text" class="form-control kategoriItemOKB" name="" id="" style="width:360px" readonly></td>
                                        </tr>
                                        <!-- <tr>
                                            <th>Leadtime</th>
                                            <th>:</th>
                                            <td><input type="text" class="form-control leadtimeOKB" name="txtOKBLeadtime[]" id="" style="width:50px;" readonly></td>
                                        </tr> -->
                                        <tr>
                                            <th>Estimasi Kedatangan Barang</th>
                                            <th>:</th>
                                            <td class="hdnEstArrivalOKB"></td>
                                        </tr>
                                        <tr>
                                            <th>Cut Off Terdekat</th>
                                            <th>:</th>
                                            <td class="hdnECutOffOKB"></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Kebutuhan (Need By Date/NBD)</th>
                                            <th>:</th>
                                            <td><input type="text" class="form-control nbdOKB" name="txtOKBnbd[]" id="" required style="background-color: #fbfb5966; width: 250px;" autocomplete="off"></td>
                                        </tr>
                                        <tr>
                                            <th>Destination Type</th>
                                            <th>:</th>
                                            <td>
                                                <div class="loadingDestinationOKB" style="display:none; width:100%;margin-top: 0px;margin-bottom: 20px" data-row="1">
                                                    <img style="width:50px" src="<?php echo base_url().'assets/img/gif/loading5.gif' ?>" />
                                                 </div>
                                                <div class="dest_typeOKB" style="display: block;">
                                                    <input type="text" class="form-control text-center destinationOKB" id="txtModalDestination" name="hdnDestinationOKB[]" style="width: 250px;" title="Destination Type" readonly>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Organization</th>
                                            <th>:</th>
                                            <td>
                                                <div class="loadingOrganizationOKB" style="display: none; width:100%;margin-top: 0px;margin-bottom: 20px">
                                                    <img style="width:50px" src="<?php echo base_url().'assets/img/gif/loading5.gif' ?>" />
                                                </div>
                                                <div class="viewOrganizationOKB" style="display: block;">
                                                    <select class="select2 organizationOKB" id="slcModalOrganization" style="width: 250px; text-align:center" name="organizationOKB[]" title="Organization">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Location</th>
                                            <th>:</th>
                                            <td>
                                                <div class="loadingLocationOKB" style="display: none; width:100%;margin-top: 0px;margin-bottom: 20px">
                                                    <img style="width:50px" src="<?php echo base_url().'assets/img/gif/loading5.gif' ?>" />
                                                </div>
                                                <div class="viewLocationOKB">
                                                    <select class="select2 locationOKB" id="slcLocation" style="width: 250px; text-align:center" name="locationOKB[]" title="Location">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Subinventory</th>
                                            <th>:</th>
                                            <td>
                                                <div class="loadingSubinventoryOKB" style="display: none; width:100%;margin-top: 0px;margin-bottom: 20px">
                                                    <img style="width:50px" src="<?php echo base_url().'assets/img/gif/loading5.gif' ?>" />
                                                </div>
                                                <div class="viewSubinventoryOKB">
                                                    <select class="select2 subinventoryOKB" id="slcSubinventory" style="width: 250px; text-align:center" name="">
                                                        <option></option>
                                                    </select>
                                                    <input type="hidden" class="hdnSubinvOKB" name="subinventoyOKB[]">
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- <tr>
                                            <th>Destination Line</th>
                                            <th>:</th>
                                            <td><input type="text" class="form-control txtDestLineOKB" placeholder="Click Here!" data-row="1" required style="background-color: #fbfb5966; width:360px;"></td>
                                        </tr> -->
                                        <tr>
                                            <th>Alasan Order</th>
                                            <th>:</th>
                                            <td><textarea style="height: 34px; width:360px; background-color: #fbfb5966;" class="form-control txaOKBNewOrderListReason" name="txtOKBinputReason[]" required></textarea></td>
                                        </tr>
                                        <tr>
                                            <th>Alasan Urgensi</th>
                                            <th>:</th>
                                            <td>
                                                <select class="select2 slcAlasanUrgensiOKB" style="width: 250px;" disabled>
                                                    <option></option>
                                                    <option value="Perubahan Rencana Penjualan">Perubahan Rencana Penjualan</option>
                                                    <option value="Kesalahan Perencanaan Seksi">Kesalahan Perencanaan Seksi</option>
                                                    <option value="Manajemen Stok Gudang">Manajemen Stok Gudang</option>
                                                    <option value="Kebutuhan Proses Beli">Kebutuhan Proses Beli</option>
                                                    <option value="Barang Reject / Proses Produksi Reject">Barang Reject / Proses Produksi Reject</option>
                                                    <option value="0">Lain-Lain</option>
                                                </select><br><br>
                                                <textarea style="height: 34px; width:360px; display:none;" class="form-control txaOKBNewOrderListUrgentReason" name="txtOKBinputUrgentReason[]"></textarea>
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <th>Note to Pengelola</th>
                                            <th>:</th>
                                            <td><textarea style="height: 34px; width:360px; " class="form-control txaOKBNewOrderListNote" name="txtOKBinputNote[]"></textarea></td>
                                        </tr>
                                        <tr>
                                            <th>Attachment</th>
                                            <th>:</th>
                                            <td><input type="file" name="fileOKBAttachment1[]" multiple></td>
                                        </tr>
                                        <tr style="display:none">
                                            <th><input type="hidden" class="hdUrgentFlagOKB" name="hdnUrgentFlagOKB[]"></th>
                                            <th><input type="hidden" class="hdnItemCodeOKB" name="hdnItemCodeOKB[]"></th>
                                        </tr>
                                        <div class="modal fade mdlOKBListOrderStock" role="dialog" aria-labelledby="modalDelete" aria-hidden="true">
                                            <div class="modal-dialog" style="width:750px;">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4><i style="vertical-align: middle;" class="fa fa-check-circle-o"> </i> Stock <b>Item</b></h4>
                                                    </div>
                                                    <div class="modal-body" style="height: 300px;">
                                                        <center>
                                                            <div class="row text-primary divOKBListOrderStockLoading" style="width: 400px; margin-top: 25px; display: none;">
                                                                <label class="control-label"> <h4><img src="<? echo base_url('assets/img/gif/loading5.gif') ?>" style="width:30px"> <b>Sedang Mengambil Data ...</b></h4> </label>
                                                            </div>
                                                        </center>
                                                        <div class="row divStockOKB"></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="col-sm">
                            <label class="control-label ml-15px" for="txaOKBNewOrderListConfirm">
                                Pernyataan Konfirmasi
                            </label>
                        </div>
                        <div class="col-sm">                    
                            <label class="control-label ml-15px">
                                <input type="checkbox" id="txaOKBNewOrderListConfirm" class="minimal checkBoxConfirmOrderOkebaja">
                                <span style="font-weight:normal">Order yang dibuat adalah sepenuhnya tanggung jawab pembuat order dan akan di teruskan ke atasan terkait serta pengelola.</span>
                            </label>
                        </div>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary btnBuatOrderOkebaja" disabled name="btnOKBSubmit" value="0"><i class="fa fa-shopping-cart"></i> Buat Order </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
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
                <button type="button" class="btn btn-warning btnOKBStatusOrderFollowUp" data-dismiss="modal"><i class="fa fa-warning"></i> Emergency</button>
            </div>
        </div>
    </div>
</div>