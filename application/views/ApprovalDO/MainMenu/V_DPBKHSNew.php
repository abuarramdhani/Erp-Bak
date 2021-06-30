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
                    <h3 class="box-title"><b>Tambahkan Data Baru</b></span></h3><br>
                </div>
                <div class="box-body">
                    <div class="box-body table-responsive no-padding">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Jenis Kendaraan</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-car"></i></span>
                                    <input class="form-control txtADOVehicleCategory">
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">No. Kendaraan</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-list-ol"></i></span>
                                    <input class="form-control txtADOVehicleIdentity">
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Supir</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-user"></i></span>
                                    <input class="form-control txtADODriverName">
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Vendor Ekspedisi</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-truck"></i></span>
                                    <input class="form-control txtADOExpeditionVendor">
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Gudang Pengirim</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-home"></i></span>
                                    <select class="form-control slcADOGudangPengirim" id="">
                                        <option></option>
                                        <option value="TUKSONO">TUKSONO</option>
                                        <option value="MLATI">MLATI</option>
                                        <option value="PUSAT">PUSAT</option>
                                        <option value="JAKARTA">JAKARTA</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tanggal Kirim</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-clock-o"></i></span>
                                    <input class="form-control txttglKirimDPB">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Estimasi Kedatangan</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-clock-o"></i></span>
                                    <input class="form-control txtDPBEstDatang">
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Pakai Alamat Bongkar ?</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-question"></i></span>
                                    <select class="form-control slcADOPakaiBongkar" id="" <?= $UserAccess['gudang_pengirim'] ?>>
                                        <option value="0">Tidak</option>
                                        <option value="1">Ya</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Alamat Bongkar</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-home"></i></span>
                                    <input class="form-control txtADOAlamatBongkar" readonly>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Catatan</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-sticky-note"></i></span>
                                    <input class="form-control txtADOCatatan">
                                </div>
                            </div>
                        </div>
                        <br />
                        <br />
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <p class="bold pull-left">Detail Information List</p>
                                <button class="btn btn-success pull-right btnADOAddNewRow" title="Tambahkan Data Baru">
                                    <i class="fa fa-plus"></i>&nbsp; Tambah Baris
                                </button>
                                <br>
                                <br>
                            </div>
                            <div class="panel-body">
                                <input type="hidden" id="org_id_nya" />
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="button" title="Approve" class="btn btn-primary pull-right btnADODPBSaveNew">
                        <i class="fa fa-save"></i>&nbsp; Save
                    </button>
                    <button type="button" title="stok" class="btn btn-primary pull-right btnADOCekStok" style="margin-right: 10px">Cek Stok</button>
                </div>
            </div>
        </div>
    </div>
</section>