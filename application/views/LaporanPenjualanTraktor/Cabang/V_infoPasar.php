<style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
input[type=number] {
    -moz-appearance: textfield;
}

.btn-file {
    position: relative;
    overflow: hidden;
    background-color: #4C575E;
    color: white;
}

.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 999px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    background: red;
    cursor: inherit;
    display: block;
    width: 100%;
    height: 100%;
}

input[readonly] {
    background-color: white !important;
    cursor: text !important;
}
</style>
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="col-lg-12"
                            style="padding:40px 40px;display:flex;justify-content:center;flex-direction:column;">
                            <?php if ($data == '') { ?>
                            <div style="display:flex;align-items:center;font-size:24px;">
                                <i class="fa fa-edit" style="margin-right:10px;"></i>
                                <b>Input Info Pasar</b>&nbsp;Penjualan TR2 per Bulan ( <b><?= $cabang ?></b> )
                            </div>
                            <hr style="width:100%;height:1px;">
                            <label style="font-weight:normal;"><b>Maaf</b> kamu belum bisa menginputkan data
                                info pasar sekarang</label>
                            <?php } else { ?>
                            <?php if ($data['MARKET_DESC'] == '' && $data['ATTACHMENT'] == '') { ?>
                            <div style="display:flex;align-items:center;font-size:24px;">
                                <i class="fa fa-edit" style="margin-right:10px;"></i>
                                <b>Input Info Pasar</b>&nbsp;Penjualan TR2 per Bulan ( <b><?= $cabang ?></b> )
                            </div>
                            <hr style="width:100%;height:1px;">
                            <?= form_open_multipart(base_url('laporanPenjualanTR2/inputInfoPasar')) ?>
                            <table style="width:70%;">
                                <input type="text" style="display:none" name="cabang-input-lpt"
                                    value="<?= $cabang ?>"></input>
                                <input type="text" style="display:none" name="reportid-input-lpt"
                                    value="<?= $data['REPORT_ID'] ?>"></input>
                                <tbody>
                                    <tr>
                                        <td style="width:10%;text-align:right;"><i class="fa fa-file-text-o"
                                                style="font-size:18px;margin-right:20%;"></i>
                                        </td>
                                        <td style="font-size:17px;">Informasi Pasar (Tren Penjualan, Data
                                            Kompetitor,
                                            Kondisi Ekonomi, Musim)</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="padding-top:10px;">
                                            <textarea class="form-control" name="value-info-pasar-lpt"
                                                style="height:100px;" required></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="width:70%;margin-top:30px;">
                                <tbody>
                                    <tr>
                                        <td style="width:10%;text-align:right;"><i class="fa fa-paperclip"
                                                style="font-size:18px;margin-right:20%;"></i>
                                        </td>
                                        <td style="font-size:17px;">Lampiran</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="padding-top:10px;">
                                            <div class="form-group">
                                                <div class="input-group input-attachment-lpt ial-1"
                                                    style="margin-bottom:10px;" data-id="1">
                                                    <span class="input-group-btn">
                                                        <span class="btn btn-default btn-file">
                                                            Browse...
                                                            <input type="file" name="input-attachment-market-info-lpt[]"
                                                                class="input-attachment-market-info-lpt" data-input="1"
                                                                accept="image/jpeg, image/png, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel "
                                                                required>
                                                        </span>
                                                    </span>
                                                    <input readonly="readonly" placeholder="File Lampiran"
                                                        class="form-control output-attachment-market-info-lpt"
                                                        type="text">
                                                </div>
                                                <!--  -->
                                                <div class="input-group input-attachment-lpt ial-2"
                                                    style="margin:10px 0;display:none;" data-id="2">
                                                    <span class="input-group-btn">
                                                        <span class="btn btn-default btn-file">
                                                            Browse...
                                                            <input type="file" name="input-attachment-market-info-lpt[]"
                                                                class="input-attachment-market-info-lpt" data-input="2"
                                                                accept="image/jpeg, image/png, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel ">
                                                        </span>
                                                    </span>
                                                    <input readonly="readonly" placeholder="File Lampiran"
                                                        class="form-control output-attachment-market-info-lpt"
                                                        type="text">
                                                </div>
                                                <!--  -->
                                                <div class="input-group input-attachment-lpt ial-3"
                                                    style="margin:10px 0;display:none;" data-id="3">
                                                    <span class="input-group-btn">
                                                        <span class="btn btn-default btn-file">
                                                            Browse...
                                                            <input type="file" name="input-attachment-market-info-lpt[]"
                                                                class="input-attachment-market-info-lpt" data-input="3"
                                                                accept="image/jpeg, image/png, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel ">
                                                        </span>
                                                    </span>
                                                    <input readonly="readonly" placeholder="File Lampiran"
                                                        class="form-control output-attachment-market-info-lpt"
                                                        type="text">
                                                </div>
                                                <!--  -->
                                                <div class="input-group input-attachment-lpt ial-4"
                                                    style="margin:10px 0;display:none;" data-id="4">
                                                    <span class="input-group-btn">
                                                        <span class="btn btn-default btn-file">
                                                            Browse...
                                                            <input type="file" name="input-attachment-market-info-lpt[]"
                                                                class="input-attachment-market-info-lpt" data-input="4"
                                                                accept="image/jpeg, image/png, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel ">
                                                        </span>
                                                    </span>
                                                    <input readonly="readonly" placeholder="File Lampiran"
                                                        class="form-control output-attachment-market-info-lpt"
                                                        type="text">
                                                </div>
                                                <div
                                                    style="width:70%;display:flex;justify-content:center;margin-top:15px;">
                                                    <button class="btn btn-success" type="submit"><i
                                                            class="fa fa-upload" style="padding-right:6px;"></i>Input
                                                        Info Pasar</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </form>
                            <?php } else { ?>
                            <div style="display:flex;align-items:center;font-size:24px;">
                                <i class="fa fa-edit" style="margin-right:10px;"></i>
                                <b>Edit Info Pasar</b>&nbsp;Penjualan TR2 per Bulan ( <b><?= $cabang ?></b> )
                            </div>
                            <hr style="width:100%;height:1px;">
                            <?= form_open_multipart(base_url('laporanPenjualanTR2/editInfoPasar')) ?>
                            <table style="width:70%;">
                                <input type="text" style="display:none" name="cabang-input-lpt"
                                    value="<?= $cabang ?>"></input>
                                <input type="text" style="display:none" name="reportid-input-lpt"
                                    value="<?= $data['REPORT_ID'] ?>"></input>
                                <tbody>
                                    <tr>
                                        <td style="width:10%;text-align:right;"><i class="fa fa-file-text-o"
                                                style="font-size:18px;margin-right:20%;"></i>
                                        </td>
                                        <td style="font-size:17px;">Informasi Pasar (Tren Penjualan, Data
                                            Kompetitor,
                                            Kondisi Ekonomi, Musim)</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="padding-top:10px;">
                                            <textarea class="form-control value-info-pasar-lpt"
                                                name="value-info-pasar-lpt" style="height:100px;" required
                                                disabled><?= $data['MARKET_DESC'] ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="padding-top:10px;">
                                            <button class="btn button-edit-info-pasar-lpt" type="button"
                                                style="background-color: #4C575E;color:white;">
                                                <i class="fa fa-pencil" style="padding-right:8px;"></i>Edit
                                            </button>
                                            <button class="btn btn-success button-save-edit-info-pasar-lpt"
                                                style="display:none;">
                                                <i class="fa fa-save" style="padding-right:8px;"></i>Save
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </form>
                            <table style="width:70%;margin-top:30px;">
                                <?= form_open_multipart(base_url('laporanPenjualanTR2/editFileInfoPasar')) ?>
                                <input type="text" style="display:none" name="cabang-input-lpt"
                                    value="<?= $cabang ?>"></input>
                                <input type="text" style="display:none" name="reportid-input-lpt"
                                    value="<?= $data['REPORT_ID'] ?>"></input>
                                <tbody>
                                    <tr>
                                        <td style="width:10%;text-align:right;"><i class="fa fa-paperclip"
                                                style="font-size:18px;margin-right:20%;"></i>
                                        </td>
                                        <td style="font-size:17px;">Lampiran</td>
                                    </tr>
                                    <?php foreach ($filename as $value) {
                                                $explodefile = explode(".", $value); ?>
                                    <tr class="file-attachment-info-pasar-lpt">
                                        <td></td>
                                        <td style="padding-top:10px;">
                                            <div style="display:flex;">
                                                <?php if (end($explodefile) == 'png' || end($explodefile) == 'PNG' || end($explodefile) == 'jpg' || end($explodefile) == 'JPG' || end($explodefile) == 'jpeg' || end($explodefile) == 'JPEG') { ?>
                                                <div
                                                    style="height:34px;width:40px;background-color:#BA372A;color:white;display:flex;justify-content:center;align-items:center">
                                                    <i class="fa fa-image"></i>
                                                </div>
                                                <?php } ?>
                                                <?php if (end($explodefile) == 'xls' || end($explodefile) == 'xlsx' || end($explodefile) == 'XLS' || end($explodefile) == 'XLSX') { ?>
                                                <div
                                                    style="height:34px;width:40px;background-color:green;color:white;display:flex;justify-content:center;align-items:center">
                                                    <i class="fa fa-file-excel-o"></i>
                                                </div>
                                                <?php } ?>
                                                <div class="form-control"><?= $value ?></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <tr id="input-edit-file-attachment-info-pasar-lpt" style="display:none;">
                                        <td></td>
                                        <td style="padding-top:10px;">
                                            <div class="form-group">
                                                <div class="input-group input-attachment-lpt ial-1"
                                                    style="margin-bottom:10px;" data-id="1">
                                                    <span class="input-group-btn">
                                                        <span class="btn btn-default btn-file">
                                                            Browse...
                                                            <input type="file" name="input-attachment-market-info-lpt[]"
                                                                class="input-attachment-market-info-lpt" data-input="1"
                                                                accept="image/jpeg, image/png, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel "
                                                                required>
                                                        </span>
                                                    </span>
                                                    <input readonly="readonly" placeholder="File Lampiran"
                                                        class="form-control output-attachment-market-info-lpt"
                                                        type="text">
                                                </div>
                                                <!--  -->
                                                <div class="input-group input-attachment-lpt ial-2"
                                                    style="margin:10px 0;display:none;" data-id="2">
                                                    <span class="input-group-btn">
                                                        <span class="btn btn-default btn-file">
                                                            Browse...
                                                            <input type="file" name="input-attachment-market-info-lpt[]"
                                                                class="input-attachment-market-info-lpt" data-input="2"
                                                                accept="image/jpeg, image/png, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel ">
                                                        </span>
                                                    </span>
                                                    <input readonly="readonly" placeholder="File Lampiran"
                                                        class="form-control output-attachment-market-info-lpt"
                                                        type="text">
                                                </div>
                                                <!--  -->
                                                <div class="input-group input-attachment-lpt ial-3"
                                                    style="margin:10px 0;display:none;" data-id="3">
                                                    <span class="input-group-btn">
                                                        <span class="btn btn-default btn-file">
                                                            Browse...
                                                            <input type="file" name="input-attachment-market-info-lpt[]"
                                                                class="input-attachment-market-info-lpt" data-input="3"
                                                                accept="image/jpeg, image/png, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel ">
                                                        </span>
                                                    </span>
                                                    <input readonly="readonly" placeholder="File Lampiran"
                                                        class="form-control output-attachment-market-info-lpt"
                                                        type="text">
                                                </div>
                                                <!--  -->
                                                <div class="input-group input-attachment-lpt ial-4"
                                                    style="margin:10px 0;display:none;" data-id="4">
                                                    <span class="input-group-btn">
                                                        <span class="btn btn-default btn-file">
                                                            Browse...
                                                            <input type="file" name="input-attachment-market-info-lpt[]"
                                                                class="input-attachment-market-info-lpt" data-input="4"
                                                                accept="image/jpeg, image/png, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel ">
                                                        </span>
                                                    </span>
                                                    <input readonly="readonly" placeholder="File Lampiran"
                                                        class="form-control output-attachment-market-info-lpt"
                                                        type="text">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="padding-top:20px;">
                                            <button class="btn button-edit-attachment-info-pasar-lpt" type="button"
                                                style="background-color: #4C575E;color:white;">
                                                <i class="fa fa-pencil" style="padding-right:8px;"></i>Edit File
                                            </button>
                                            <button class="btn btn-success button-save-edit-attachment-info-pasar-lpt"
                                                style="display:none;">
                                                <i class="fa fa-save" style="padding-right:8px;"></i>Save File
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                </form>
                            </table>
                            <?php }
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>