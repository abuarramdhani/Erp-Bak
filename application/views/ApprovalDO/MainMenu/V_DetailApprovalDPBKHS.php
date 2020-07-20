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
                                    <input class="form-control txtADOVehicleCategory" <?= $UserAccess['jenis_kendaraan'] ?> value="<?php if (isset($DPBKHSDetail[0]['JENIS_KENDARAAN'])) echo $DPBKHSDetail[0]['JENIS_KENDARAAN'] ?>">
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">No. Kendaraan</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-list-ol"></i></span>
                                    <input class="form-control txtADOVehicleIdentity" <?= $UserAccess['no_kendaraan'] ?> value="<?php if (isset($DPBKHSDetail[0]['NO_KENDARAAN'])) echo $DPBKHSDetail[0]['NO_KENDARAAN'] ?>">
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Supir</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-user"></i></span>
                                    <input class="form-control txtADODriverName" <?= $UserAccess['nama_supir'] ?> value="<?php if (isset($DPBKHSDetail[0]['NAMA_SUPIR'])) echo $DPBKHSDetail[0]['NAMA_SUPIR'] ?>">
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Kontak Supir</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-phone"></i></span>
                                    <input class="form-control txtADODriverContact" <?= $UserAccess['kontak_supir'] ?> value="<?php if (isset($DPBKHSDetail[0]['KONTAK_SUPIR'])) echo $DPBKHSDetail[0]['KONTAK_SUPIR'] ?>">
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Vendor Ekspedisi</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-truck"></i></span>
                                    <input class="form-control txtADOExpeditionVendor" <?= $UserAccess['vendor_ekspedisi'] ?> value="<?php if (isset($DPBKHSDetail[0]['VENDOR_EKSPEDISI'])) echo $DPBKHSDetail[0]['VENDOR_EKSPEDISI'] ?>">
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Estimasi Kedatangan</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-clock-o"></i></span>
                                    <input class="form-control <?= $UserAccess['estdate'] ?> txtADOEstDatang" <?= $UserAccess['estimasi_datang'] ?> value="<?php if (isset($DPBKHSDetail[0]['ESTIMASI_DATANG'])) echo date("Y/m/d H:i",strtotime($DPBKHSDetail[0]['ESTIMASI_DATANG']));?>">
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Gudang Pengirim</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-home"></i></span>
                                    <input class="form-control" <?= $UserAccess['gudang_pengirim'] ?> value="<?php if (isset($DPBVendorDetail[0]['GUDANG_PENGIRIM'])) echo $DPBVendorDetail[0]['GUDANG_PENGIRIM'] ?>">
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Alamat Bongkar</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-home"></i></span>
                                    <input class="form-control txtADOAlamatBongkar" <?= $UserAccess['alamat_bongkar'] ?> value="<?php if (isset($DPBKHSDetail[0]['ALAMAT_BONGKAR'])) echo $DPBKHSDetail[0]['ALAMAT_BONGKAR'] ?>">
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Catatan</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-sticky-note"></i></span>
                                    <input class="form-control txtADOCatatan" <?= $UserAccess['catatan'] ?> value="<?php if (isset($DPBKHSDetail[0]['CATATAN'])) echo $DPBKHSDetail[0]['CATATAN'] ?>">
                                </div>
                            </div>
                        </div>
                        <br />
                        <br />
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
                                <table class="table table-bordered table-hover table-striped tblADODetailList" style="display: none">
                                    <thead>
                                        <tr class="bg-primary" height="50px">
                                            <th class="text-center text-nowrap">No</th>
                                            <th class="text-center text-nowrap">Kode DO</th>
                                            <th class="text-center text-nowrap">Nama Barang</th>
                                            <th class="text-center text-nowrap">Qty</th>
                                            <th class="text-center text-nowrap">UOM</th>
                                            <th class="text-center text-nowrap">Nama Toko</th>
                                            <th class="text-center text-nowrap">Kota</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($DPBKHSDetail as $key => $val) : ?>
                                        <tr>
                                            <td class="text-right"><?= $key+1 ?></td>
                                            <td class="text-right"><?= $val['DO_NUM'] ?></td>
                                            <td class="text-left"><?= $val['ITEM_NAME'] ?></td>
                                            <td class="text-right"><?= $val['QTY'] ?></td>
                                            <td class="text-left"><?= $val['UOM'] ?></td>
                                            <td class="text-left"><?= $val['NAMA_TOKO'] ?></td>
                                            <td class="text-left"><?= $val['KOTA'] ?></td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="button" title="Reject" class="btn btn-danger pull-right btnApproveDPBDO" style="margin-right: 10px" value="0">
                        <i class="fa fa-close"></i>&nbsp; Reject
                    </button>
                    <button type="button" title="Approve" class="btn btn-primary pull-right btnApproveDPBDO" style="margin-right: 10px" value="1">
                        <i class="fa fa-check"></i>&nbsp; Approve
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>