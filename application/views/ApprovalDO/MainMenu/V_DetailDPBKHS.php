<style>    
    .bg-danger-important {
        background-color: #f2dede !important;
    }
    label {
        font-weight: normal !important;
    }
    .label {
        font-size: 90% !important;
        display: inline-block;
        width: 100px;
        padding: 5px;
    }
    .form-control-auto {
        width: 100% !important;
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
                    <h3 class="box-title"><b>Detail PR</b> <span class="spnADOPRNumber"><?= $NO_PR ?></span></h3><br>
                </div>
                <div class="box-body">
                    <div class="box-body table-responsive no-padding">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Jenis Kendaraan</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-car"></i></span>
                                    <input class="form-control txtADOVehicleCategory" <?= $UserAccess['edit_field'] ?> value="<?php if (isset($DPBKHSDetail[0]['JENIS_KENDARAAN'])) echo $DPBKHSDetail[0]['JENIS_KENDARAAN'] ?>">
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">No. Kendaraan</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-list-ol"></i></span>
                                    <input class="form-control txtADOVehicleIdentity" <?= $UserAccess['edit_field'] ?> value="<?php if (isset($DPBKHSDetail[0]['NO_KENDARAAN'])) echo $DPBKHSDetail[0]['NO_KENDARAAN'] ?>">
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Supir</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-user"></i></span>
                                    <input class="form-control txtADODriverName" <?= $UserAccess['edit_field'] ?> value="<?php if (isset($DPBKHSDetail[0]['NAMA_SUPIR'])) echo $DPBKHSDetail[0]['NAMA_SUPIR'] ?>">
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Vendor Ekspedisi</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-truck"></i></span>
                                    <input class="form-control txtADOExpeditionVendor" <?= $UserAccess['edit_field'] ?> value="<?php if (isset($DPBKHSDetail[0]['VENDOR_EKSPEDISI'])) echo $DPBKHSDetail[0]['VENDOR_EKSPEDISI'] ?>">
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Lain-Lain</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-plus"></i></span>
                                    <input class="form-control txtADOAdditionalInformation" <?= $UserAccess['edit_field'] ?> value="<?php if (isset($DPBKHSDetail[0]['LAIN'])) echo $DPBKHSDetail[0]['LAIN'] ?>">
                                </div>
                            </div>
                        </div>
                        <br />
                        <br />
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <p class="bold pull-left">Detail Information List</p>
                                <button class="btn btn-success pull-right btnADOAddNewRow" title="Tambahkan Data Baru" <?= $UserAccess['add_row'] ?>>
                                    <i class="fa fa-plus"></i>&nbsp; Tambah Baris
                                </button>
                                <br>
                                <br>
                            </div>
                            <div class="panel-body">
                                <div class="col-sm-12 text-center divADOLoadingTable">
                                    <label class="control-label">
                                        <p><img src="<?= base_url('assets/img/gif/loading5.gif') ?>" style="width:30px"> Sedang Memproses ...</p> 
                                    </label>
                                </div>
                                <table class="table table-bordered table-hover table-striped tblADODetailList" style="display: none">
                                    <thead>
                                        <tr class="bg-primary" height="50px">
                                            <th class="text-center text-nowrap" style="width: 5%">No</th>
                                            <th class="text-center text-nowrap">Kode DO</th>
                                            <th class="text-center text-nowrap">Nama Barang</th>
                                            <th class="text-center text-nowrap">Qty</th>
                                            <th class="text-center text-nowrap">UOM</th>
                                            <th class="text-center text-nowrap">Nama Toko</th>
                                            <th class="text-center text-nowrap">Kota</th>
                                            <th class="text-center text-nowrap" style="width: 5%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($DPBKHSDetail as $key => $val) : ?>
                                        <tr data-type="update" data-line="<?= $val['LINE_NUM'] ?>">
                                            <td class="text-right" style="width: 5%"><?= $key+1 ?></td>
                                            <td class="text-right"><input type="text" class="form-control-auto form-control txtADODONumber" value="<?= $val['DO_NUM'] ?>" <?= $UserAccess['edit_field'] ?>></td>
                                            <td class="text-left"><input type="text" class="form-control-auto form-control txtADOItemName" value="<?= $val['ITEM_NAME'] ?>" <?= $UserAccess['edit_field'] ?>></td>
                                            <td class="text-right"><input type="number" class="form-control-auto form-control txtADOQty" value="<?= $val['QTY'] ?>" <?= $UserAccess['edit_field'] ?>></td>
                                            <td class="text-left"><input type="text" class="form-control-auto form-control txtADOUOM" value="<?= $val['UOM'] ?>" <?= $UserAccess['edit_field'] ?>></td>
                                            <td class="text-left"><input type="text" class="form-control-auto form-control txtADOShopName" value="<?= $val['NAMA_TOKO'] ?>" <?= $UserAccess['edit_field'] ?>></td>
                                            <td class="text-left"><input type="text" class="form-control-auto form-control txtADOCity" value="<?= $val['KOTA'] ?>" <?= $UserAccess['edit_field'] ?>></td>
                                            <td class="text-center" style="width: 5%">
                                                <button title="Hapus Baris" class="btn btn-danger btnADODeleteRow" <?= $UserAccess['delete_row'] ?>><i class="fa fa-trash"></i></button> 
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="button" title="Approve" class="btn btn-primary pull-right btnADOSaveUpdate" style="margin-right: 10px" <?= $UserAccess['save'] ?>>
                        <i class="fa fa-save"></i>&nbsp; Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>