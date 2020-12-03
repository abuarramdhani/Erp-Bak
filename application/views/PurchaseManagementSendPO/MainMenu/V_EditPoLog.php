<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1><b><?= $Menu ?></b></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-bold">*No PO : <?= $po_number . '-' . $po_revision; ?></p>
                <br />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"></div>
                            <div class="box-body box-primary">
                                <div class="row" style="margin-top: 50px;">
                                    <div class="col-lg-12">
                                        <form id="editPoLog">
                                            <input type="hidden" value="<?= $po_number . '-' . $po_revision; ?>" name="po_number" required>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="col-lg-5 text-right">
                                                        <label>Vendor Confirm Date</label>
                                                    </div>
                                                    <label class="col-lg-1" style="width:10px">:</label>
                                                    <div class="col-lg-4 text-left">
                                                        <?php $date = date_create($edit_PoLog['VENDOR_CONFIRM_DATE']) ?>
                                                        <input type="text" class="form-control" id="vendor_confirm_date" name="vendor_confirm_date" required autocomplete="off" value="<?= ($edit_PoLog['VENDOR_CONFIRM_DATE'] !== NULL) ? date_format($date, 'd/m/Y') : '' ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-5 text-right">
                                                    <label>Vendor Confirm Method</label>
                                                </div>
                                                <label class="col-lg-1" style="width: 10px;">: </label>
                                                <div class="col-lg-4 text-left">
                                                    <select type="select select2" class="form-control" id="select_vendor_confirm_method" name="vendor_confirm_method" required>
                                                        <option <?= $edit_PoLog['VENDOR_CONFIRM_METHOD'] == NULL ? 'selected' : '' ?> disabled>--Select Confirm Method--</option>
                                                        <option <?= $edit_PoLog['VENDOR_CONFIRM_METHOD'] == "email" ? 'selected' : '' ?> value="email">Email</option>
                                                        <option <?= $edit_PoLog['VENDOR_CONFIRM_METHOD'] == "fax" ? 'selected' : '' ?> value="fax">Fax</option>
                                                        <option <?= $edit_PoLog['VENDOR_CONFIRM_METHOD'] == "sms" ? 'selected' : '' ?> value="sms">SMS</option>
                                                        <option <?= $edit_PoLog['VENDOR_CONFIRM_METHOD'] == "wabuyer" ? 'selected' : '' ?> value="wabuyer">WA Buyer</option>
                                                        <option <?= $edit_PoLog['VENDOR_CONFIRM_METHOD'] == "wasystem" ? 'selected' : '' ?> value="wasystem">WA System</option>
                                                        <option <?= $edit_PoLog['VENDOR_CONFIRM_METHOD'] == "others" ? 'selected' : '' ?> value="others">Others</option>
                                                        <option <?= $edit_PoLog['VENDOR_CONFIRM_METHOD'] == "none" ? 'selected' : '' ?> value="none">None</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="col-lg-5 text-right">
                                                        <label>Vendor Confirm PIC</label>
                                                    </div>
                                                    <label class="col-lg-1" style="width: 10px;">:</label>
                                                    <div class="col-lg-4 text-left">
                                                        <input type="text" class="form-control" id="vendor_confirm_pic" name="vendor_confirm_pic" required value="<?= $edit_PoLog['VENDOR_CONFIRM_PIC'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="col-lg-5 text-right">
                                                        <label>Vendor Confirm Note</label>
                                                    </div>
                                                    <label class="col-lg-1" style="width: 10px;">:</label>
                                                    <div class="col-lg-4 text-left">
                                                        <input type="text" class="form-control" id="vendor_confirm_note" name="vendor_confirm_note" required value="<?= $edit_PoLog['VENDOR_CONFIRM_NOTE'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="col-lg-5 text-right">
                                                        <label>Attachment</label>
                                                    </div>
                                                    <label class="col-lg-1" style="width:10px">:</label>
                                                    <div class="col-lg-4 text-left">
                                                        <input type="file" id="lampiranPO" name="lampiranPO" required autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-lg-12 text-center">
                                                    <button type="button" class="btn btn-primary btnVendorConfirm" style="margin-right: 8px;">Simpan</button>
                                                    <a href="<?= base_url('PurchaseManagementSendPO/PoLog/edit'); ?>" class="btn btn-primary">Kembali</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>