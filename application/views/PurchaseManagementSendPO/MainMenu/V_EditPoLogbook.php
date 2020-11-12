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
                <p class="text-bold">*No PO : <?= $po_number; ?></p>
                <br />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"></div>
                            <div class="box-body box-primary">
                                <div class="row" style="margin-top: 50px;">
                                    <div class="col-lg-12">
                                        <form id="editPoLogbook">
                                            <input type="hidden" value="<?= $po_number; ?>" name="po_number" required>
                                            <div class="row">
                                                <div class="col-lg-5 text-right">
                                                    <label>Distribution Method</label>
                                                </div>
                                                <label class="col-lg-1" style="width: 10px;">: </label>
                                                <div class="col-lg-4 text-left">
                                                    <select type="select select2" class="form-control" id="select_distribution_method" name="distribution_method" required>
                                                        <option <?= $edit_PoLogbook['DISTRIBUTION_METHOD'] == NULL ? 'selected' : '' ?> disabled>--Select Confirm Method--</option>
                                                        <option <?= $edit_PoLogbook['DISTRIBUTION_METHOD'] == "email" ? 'selected' : '' ?> value="email">Email</option>
                                                        <option <?= $edit_PoLogbook['DISTRIBUTION_METHOD'] == "fax" ? 'selected' : '' ?> value="fax">Fax</option>
                                                        <option <?= $edit_PoLogbook['DISTRIBUTION_METHOD'] == "sms" ? 'selected' : '' ?> value="sms">SMS</option>
                                                        <option <?= $edit_PoLogbook['DISTRIBUTION_METHOD'] == "wabuyer" ? 'selected' : '' ?> value="wabuyer">WA Buyer</option>
                                                        <option <?= $edit_PoLogbook['DISTRIBUTION_METHOD'] == "wasystem" ? 'selected' : '' ?> value="wasystem">WA System</option>
                                                        <option <?= $edit_PoLogbook['DISTRIBUTION_METHOD'] == "others" ? 'selected' : '' ?> value="others">Others</option>
                                                        <option <?= $edit_PoLogbook['DISTRIBUTION_METHOD'] == "none" ? 'selected' : '' ?> value="none">None</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row send_date_row">
                                                <br>
                                                <div class="col-lg-12">
                                                    <div class="col-lg-5 text-right">
                                                        <label>Send Date 1</label>
                                                    </div>
                                                    <label class="col-lg-1" style="width:10px">:</label>
                                                    <div class="col-lg-4 text-left">
                                                        <?php $date = date_create($edit_PoLogbook['SEND_DATE_1']); ?>
                                                        <input type="text" class="form-control input_send_date" id="send_date_1" name="send_date_1" autocomplete="off" value="<?= ($edit_PoLogbook['SEND_DATE_1'] !== NULL) ? date_format($date, 'd/m/Y') : '';?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row send_date_row">
                                                <br>
                                                <div class="col-lg-12">
                                                    <div class="col-lg-5 text-right">
                                                        <label>Send Date 2</label>
                                                    </div>
                                                    <label class="col-lg-1" style="width:10px">:</label>
                                                    <div class="col-lg-4 text-left">
                                                        <?php $date = date_create($edit_PoLogbook['SEND_DATE_2']) ?>
                                                        <input type="text" class="form-control input_send_date" id="send_date_2" name="send_date_2" autocomplete="off" value="<?= ($edit_PoLogbook['SEND_DATE_2'] !== NULL) ? date_format($date, 'd/m/Y') : '';?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row vendor_confirm_row">
                                                <br>
                                                <div class="col-lg-12">
                                                    <div class="col-lg-5 text-right">
                                                        <label>Vendor Confirm Date</label>
                                                    </div>
                                                    <label class="col-lg-1" style="width:10px">:</label>
                                                    <div class="col-lg-4 text-left">
                                                        <?php $date = date_create($edit_PoLogbook['VENDOR_CONFIRM_DATE']) ?>
                                                        <input type="text" class="form-control input_vendor_confirm" id="vendor_confirm_date" name="vendor_confirm_date" <?= ($edit_PoLogbook['SELISIH_WAKTU_1'] > 48 && $edit_PoLogbook['SEND_DATE_2'] == NULL && $edit_PoLogbook['VENDOR_CONFIRM_DATE'] == NULL OR $edit_PoLogbook['SELISIH_WAKTU_2'] > 24 && $edit_PoLogbook['VENDOR_CONFIRM_DATE'] == NULL) ? 'required' : 'disabled'; ?> autocomplete="off"
                                                            value="<?= ($edit_PoLogbook['VENDOR_CONFIRM_DATE'] !== NULL) ? date_format($date, 'd/m/Y') : '' ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row vendor_confirm_row">
                                                <br>
                                                <div class="col-lg-5 text-right">
                                                    <label>Vendor Confirm Method</label>
                                                </div>
                                                <label class="col-lg-1" style="width: 10px;">: </label>
                                                <div class="col-lg-4 text-left">
                                                    <select type="select select2" class="form-control input_vendor_confirm" id="select_vendor_confirm_method" name="vendor_confirm_method" <?= ($edit_PoLogbook['SELISIH_WAKTU_1'] > 48 && $edit_PoLogbook['SEND_DATE_2'] == NULL && $edit_PoLogbook['VENDOR_CONFIRM_DATE'] == NULL OR $edit_PoLogbook['SELISIH_WAKTU_2'] > 24 && $edit_PoLogbook['VENDOR_CONFIRM_DATE'] == NULL) ? 'required' : 'disabled'; ?>>
                                                        <option <?= $edit_PoLogbook['VENDOR_CONFIRM_METHOD'] == NULL ? 'selected' : '' ?> disabled>--Select Confirm Method--</option>
                                                        <option <?= $edit_PoLogbook['VENDOR_CONFIRM_METHOD'] == "email" ? 'selected' : '' ?> value="email">Email</option>
                                                        <option <?= $edit_PoLogbook['VENDOR_CONFIRM_METHOD'] == "fax" ? 'selected' : '' ?> value="fax">Fax</option>
                                                        <option <?= $edit_PoLogbook['VENDOR_CONFIRM_METHOD'] == "sms" ? 'selected' : '' ?> value="sms">SMS</option>
                                                        <option <?= $edit_PoLogbook['VENDOR_CONFIRM_METHOD'] == "wabuyer" ? 'selected' : '' ?> value="wabuyer">WA Buyer</option>
                                                        <option <?= $edit_PoLogbook['VENDOR_CONFIRM_METHOD'] == "wasystem" ? 'selected' : '' ?> value="wasystem">WA System</option>
                                                        <option <?= $edit_PoLogbook['VENDOR_CONFIRM_METHOD'] == "others" ? 'selected' : '' ?> value="others">Others</option>
                                                        <option <?= $edit_PoLogbook['VENDOR_CONFIRM_METHOD'] == "none" ? 'selected' : '' ?> value="none">None</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row vendor_confirm_row">
                                                <br>
                                                <div class="col-lg-12">
                                                    <div class="col-lg-5 text-right">
                                                        <label>Vendor Confirm PIC</label>
                                                    </div>
                                                    <label class="col-lg-1" style="width: 10px;">:</label>
                                                    <div class="col-lg-4 text-left">
                                                        <input type="text" class="form-control input_vendor_confirm" id="vendor_confirm_pic" name="vendor_confirm_pic" <?= ($edit_PoLogbook['SELISIH_WAKTU_1'] > 48 && $edit_PoLogbook['SEND_DATE_2'] == NULL && $edit_PoLogbook['VENDOR_CONFIRM_DATE'] == NULL OR $edit_PoLogbook['SELISIH_WAKTU_2'] > 24 && $edit_PoLogbook['VENDOR_CONFIRM_DATE'] == NULL) ? 'required' : 'disabled'; ?> value="<?= $edit_PoLogbook['VENDOR_CONFIRM_PIC'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row vendor_confirm_row">
                                                <br>
                                                <div class="col-lg-12">
                                                    <div class="col-lg-5 text-right">
                                                        <label>Vendor Confirm Note</label>
                                                    </div>
                                                    <label class="col-lg-1" style="width: 10px;">:</label>
                                                    <div class="col-lg-4 text-left">
                                                        <input type="text" class="form-control input_vendor_confirm" id="vendor_confirm_note" name="vendor_confirm_note" <?= ($edit_PoLogbook['SELISIH_WAKTU_1'] > 48 && $edit_PoLogbook['SEND_DATE_2'] == NULL && $edit_PoLogbook['VENDOR_CONFIRM_DATE'] == NULL OR $edit_PoLogbook['SELISIH_WAKTU_2'] > 24 && $edit_PoLogbook['VENDOR_CONFIRM_DATE'] == NULL) ? 'required' : 'disabled'; ?> value="<?= $edit_PoLogbook['VENDOR_CONFIRM_NOTE'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row attachment_flag_row">
                                                <br>
                                                <div class="col-lg-5 text-right">
                                                    <label>Attachment Flag</label>
                                                </div>
                                                <label class="col-lg-1" style="width: 10px;">: </label>
                                                <div class="col-lg-4 text-left">
                                                    <select type="select select2" class="form-control input_attachment_flag" id="select_attachment_flag" name="attachment_flag" required>
                                                        <option <?= $edit_PoLogbook['ATTACHMENT_FLAG'] == NULL ? 'selected' : '' ?> disabled>--Select Attachment Flag--</option>
                                                        <option <?= $edit_PoLogbook['ATTACHMENT_FLAG'] == 'Y' ? 'selected' : '' ?> value="Y">Yes</option>
                                                        <option <?= $edit_PoLogbook['ATTACHMENT_FLAG'] == 'N' ? 'selected' : '' ?> value="N">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row attachment_row">
                                                <br>
                                                <div class="col-lg-12">
                                                    <div class="col-lg-5 text-right">
                                                        <label>Attachment</label>
                                                    </div>
                                                    <label class="col-lg-1" style="width:10px">:</label>
                                                    <div class="col-lg-4 text-left">
                                                        <input type="file" class="input_attachment" id="lampiranPO" name="lampiranPO" <?= ($edit_PoLogbook['SELISIH_WAKTU_1'] > 48 && $edit_PoLogbook['SEND_DATE_2'] == NULL && $edit_PoLogbook['VENDOR_CONFIRM_DATE'] == NULL OR $edit_PoLogbook['SELISIH_WAKTU_2'] > 24 && $edit_PoLogbook['VENDOR_CONFIRM_DATE'] == NULL) ? 'required' : 'disabled'; ?> autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-lg-12 text-center">
                                                    <button type="button" class="btn btn-primary btnEditPoLogbook" style="margin-right: 8px;">Simpan</button>
                                                    <a href="<?= base_url('PurchaseManagementSendPO/POLogbook/edit'); ?>" class="btn btn-primary">Kembali</a>
                                                </div>
                                            </div>
                                        </form>
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