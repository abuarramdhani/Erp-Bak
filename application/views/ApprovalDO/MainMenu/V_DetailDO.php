<style>    
    label {
        font-weight: normal !important;
    }
    .label {
        font-size: 90% !important;
        display: inline-block;
        width: 100px;
        padding: 5px;
    }
    .mailbox-attachments li {
        width: 225px !important;
    }    
    .mr-20px {
        margin-right: 20px;
    }
    .swal-font-small {
        font-size: 1.5rem !important;
    }
</style>

<section class="content-header">
    <h1><?= $UserMenu[0]['user_group_menu_name'] ?> </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <?php if ($DetailType === 'ListBackorder') : ?>
                        <h3 class="box-title"><b>Detail Sales Order</b></h3><br>
                        <h3 class="box-title">
                            <span class='spnADOSONumber'><?= $DOSONumber['NO_SO'] ?></span>
                        </h3>
                    <?php elseif ($DetailType === 'LaunchPickRelease') : ?>
                        <h3 class="box-title"><b>Detail Launch Pick Release</b></h3><br>
                        <h3 class="box-title">
                            <span class='spnADOSONumber'><?= $DOSONumber['NO_SO'] ?></span>
                            <input type="hidden" class="hdnADODeliveryId" value="<?= $DetailDO[0]['DELIVERY_ID'] ?>">
                        </h3>
                    <?php else : ?>
                        <h3 class="box-title"><b>Detail Delivery Order</b></h3><br>
                        <h3 class="box-title">
                            <span class='spnADOSONumber'><?= $DOSONumber['NO_SO'] ?></span>/
                            <span class='spnADODONumber'><?= $DOSONumber['NO_DO'] ?></span>
                        </h3>
                    <?php endif ?>
                </div>
                <div class="box-body">
                    <div class="box-body table-responsive no-padding">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Relasi</label>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-users"></i></span>
                                    <input class="form-control" value="<?php if (isset($DetailDO[0]['NAMA_CUST'])) echo $DetailDO[0]['NAMA_CUST'] ?>" readonly="">
                                </div>
                            </div>
                        </div><br>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Alamat</label>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-map-marker"></i></span>
                                    <input class="form-control" value="<?php if (isset($DetailDO[0]['ALAMAT'])) echo $DetailDO[0]['ALAMAT'] ?>" readonly="">
                                </div>
                            </div>
                        </div><br><br>
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <p class="bold">Detail Information List</p>
                            </div>
                            <div class="panel-body">
                                <div class="col-sm-12 text-center divADOLoadingTable">
                                    <label class="control-label">
                                        <p><img src="<?= base_url('assets/img/gif/loading5.gif') ?>" style="width:30px"> Sedang Memproses ...</p> 
                                    </label>
                                </div>
                                <table class="table table-bordered table-hover table-striped tblADOList" style="display: none">
                                    <thead>
                                        <tr class="bg-primary" height="50px">
                                            <th width="5%" class="text-center">No</th>
                                            <th width="20%" class="text-center">Kode Barang</th>
                                            <th width="20%" class="text-center">Nama Barang</th>
                                            <?php if ($DetailType === 'ListBackorder') : ?>
                                                <th width="15%" class="text-center">QTY</th>
                                            <?php elseif ($DetailType === 'LaunchPickRelease') : ?>
                                                <th width="15%" class="text-center">QTY REQ</th>
                                            <?php else : ?>
                                                <th width="7.5%" class="text-center">QTY REQ</th>
                                                <th width="7.5%" class="text-center">QTY ATR</th>
                                            <?php endif ?>
                                                <th width="10%" class="text-center">UOM</th>
                                                <th width="15%" class="text-center">Lokasi Gudang</th>
                                            <?php if ($DetailType === 'LaunchPickRelease') : ?>
                                                <th width="15%" class="text-center">Delivery ID</th>
                                                <th class="text-center">Action</th>
                                            <?php endif ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($DetailDO as $key => $val) : ?>
                                            <tr>
                                                <td width="5%" class="text-right"><?= $key+1 ?></td>
                                                <td width="20%"><?= $val['KODE_BARANG'] ?></td>
                                                <td width="20%"><?= $val['NAMA_BARANG'] ?></td>
                                                <?php if ($DetailType === 'ListBackorder' || $DetailType === 'LaunchPickRelease') : ?>
                                                    <td width="15%" class="text-right"><?= $val['REQ_QTY'] ?></td>
                                                <?php else : ?>
                                                    <td width="10%" class="text-right"><?= $val['REQ_QTY'] ?></td>
                                                    <td width="10%" class="text-right"><?= $val['QTY_ATR'] ?></td>
                                                <?php endif ?>
                                                    <td width="10%"><?= $val['UOM'] ?></td>
                                                    <td width="15%"><?= $val['LOKASI_GUDANG']->load() ?></td>                                            
                                                <?php if ($DetailType === 'LaunchPickRelease') : ?>
                                                    <td width="15%"><span class="spnADODeliveryID"><?= $val['DELIVERY_ID'] ?></span></td>
                                                    <td class="text-center"><input type="checkbox" class="chkADOPickedRelease"></td>
                                                <?php endif ?>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <?= $ButtonType ?>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="mdlADOAssignApprover" class="modal fade">
    <div class="modal-dialog modal-slg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-user-plus"></i> Select Approver</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Pilih Approver</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i style="width:15px;" class="fa fa-user"></i></span>
                            <select class="slcADOAssignerList form-control" name="slcADOAssignerList" style="width: 100%;">
                                <?php foreach ($ApproverList as $key => $val) : ?>
                                    <option value="<?= $val['id'] ?>"><?= $val['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div><br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btnADORequestApprove"><i class="fa fa-check"></i>&nbsp; Req. Approve</button>
            </div>
        </div>
    </div>
</div>