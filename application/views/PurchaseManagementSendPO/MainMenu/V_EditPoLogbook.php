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
                                                <div class="col-lg-12">
                                                    <div class="col-lg-5 text-right">
                                                        <label>Vendor Confirm Date</label>
                                                    </div>
                                                    <label class="col-lg-1" style="width:10px">:</label>
                                                    <div class="col-lg-4 text-left">
                                                        <input type="text" class="form-control" id="vendor_confirm_date"
                                                            name="vendor_confirm_date"
                                                            <?= ($edit_Po['SELISIH_WAKTU_1'] > 48 && $edit_Po['SEND_DATE_2'] == NULL && $edit_Po['VENDOR_CONFIRM_DATE'] == NULL OR $edit_Po['SELISIH_WAKTU_2'] > 24 && $edit_Po['VENDOR_CONFIRM_DATE'] == NULL) ? 'required' : 'disabled'; ?>
                                                            autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-5 text-right">
                                                    <label>Distribution Method</label>
                                                </div>
                                                <label class="col-lg-1" style="width: 10px;">: </label>
                                                <div class="col-lg-4 text-left">
                                                    <select type="select select2" class="form-control"
                                                        id="select_distribution_method" name="distribution_method"
                                                        required>
                                                        <option selected disabled>--Select Distribution Method--
                                                        </option>
                                                        <option value="email">Email</option>
                                                        <option value="fax">Fax</option>
                                                        <option value="sms">SMS</option>
                                                        <option value="wabuyer">WA Buyer</option>
                                                        <option value="wasystem">WA System</option>
                                                        <option value="others">Others</option>
                                                        <option value="none">None</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-5 text-right">
                                                    <label>Vendor Confirm Method</label>
                                                </div>
                                                <label class="col-lg-1" style="width: 10px;">: </label>
                                                <div class="col-lg-4 text-left">
                                                    <select type="select select2" class="form-control"
                                                        id="select_vendor_confirm_method" name="vendor_confirm_method"
                                                        <?= ($edit_Po['SELISIH_WAKTU_1'] > 48 && $edit_Po['SEND_DATE_2'] == NULL && $edit_Po['VENDOR_CONFIRM_DATE'] == NULL OR $edit_Po['SELISIH_WAKTU_2'] > 24 && $edit_Po['VENDOR_CONFIRM_DATE'] == NULL) ? 'required' : 'disabled'; ?>>
                                                        <option selected disabled>--Select Confirm Method--</option>
                                                        <option value="email">Email</option>
                                                        <option value="fax">Fax</option>
                                                        <option value="sms">SMS</option>
                                                        <option value="wabuyer">WA Buyer</option>
                                                        <option value="wasystem">WA System</option>
                                                        <option value="others">Others</option>
                                                        <option value="none">None</option>
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
                                                        <input type="text" class="form-control" id="vendor_confirm_pic"
                                                            name="vendor_confirm_pic"
                                                            <?= ($edit_Po['SELISIH_WAKTU_1'] > 48 && $edit_Po['SEND_DATE_2'] == NULL && $edit_Po['VENDOR_CONFIRM_DATE'] == NULL OR $edit_Po['SELISIH_WAKTU_2'] > 24 && $edit_Po['VENDOR_CONFIRM_DATE'] == NULL) ? 'required' : 'disabled'; ?>>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-5 text-right">
                                                    <label>Attachment Flag</label>
                                                </div>
                                                <label class="col-lg-1" style="width: 10px;">: </label>
                                                <div class="col-lg-4 text-left">
                                                    <select type="select select2" class="form-control"
                                                        id="select_attachment_flag" name="attachment_flag" required>
                                                        <option selected disabled>--Select Attachment Flag--</option>
                                                        <option value="Y">Yes</option>
                                                        <option value="N">No</option>
                                                    </select>
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
                                                        <input type="file" id="lampiranPO" name="lampiranPO"
                                                            <?= ($edit_Po['SELISIH_WAKTU_1'] > 48 && $edit_Po['SEND_DATE_2'] == NULL && $edit_Po['VENDOR_CONFIRM_DATE'] == NULL OR $edit_Po['SELISIH_WAKTU_2'] > 24 && $edit_Po['VENDOR_CONFIRM_DATE'] == NULL) ? 'required' : 'disabled'; ?>
                                                            autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-lg-12 text-center">
                                                    <button type="button" class="btn btn-primary btnEditPoLogbook"
                                                        style="margin-right: 8px;">Simpan</button>
                                                    <a href="<?= base_url('PurchaseManagementSendPO/POLogbook/edit'); ?>"
                                                        class="btn btn-primary">Kembali</a>
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