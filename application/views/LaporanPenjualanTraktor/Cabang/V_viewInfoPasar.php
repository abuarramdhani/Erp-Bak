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
                            <div style="display:flex;align-items:center;font-size:24px;">
                                <i class="fa fa-edit" style="margin-right:10px;"></i>
                                <b>Edit Info Pasar</b>&nbsp;Penjualan TR2 per Bulan ( <b><?= $cabang ?></b> )
                            </div>
                            <hr style="width:100%;height:1px;">
                            <table style=" width:70%;">
                                <input type="text" style="display:none" id="cabang-input-lpt"
                                    value="<?= $infoPasar['MARKET_ID'] ?>"></input>
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
                                                disabled><?= $infoPasar['DESCRIPTION'] ?></textarea>
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
                                            <?php if ($infoPasar['ATTACHMENT'] != '') { ?>
                                                <div style="display:flex" class="file-attachment-info-pasar-lpt">
                                                    <?php $explode1 = explode("/", $infoPasar['ATTACHMENT']);
                                                    $explode2 = explode(".", end($explode1));
                                                    $ekstensi = strtolower(end($explode2));
                                                    if ($ekstensi == 'png' || $ekstensi == 'jpg' || $ekstensi == 'jpeg') { ?>
                                                    <button type="button" class="btn" data-toggle="modal"
                                                        data-target="#modal-image-lpt-info-pasar"
                                                        style="width:38px;height:34px;background-color:#BA372A;color:white;display:flex">
                                                        <i class="fa fa-image" style="margin:auto"></i>
                                                    </button>
                                                    <div class="modal fade" id="modal-image-lpt-info-pasar"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content" style="border-radius:10px;">
                                                                <div class="modal-header"
                                                                    style="display:flex;background-color:#4C575E;border-radius:8px 8px 0 0;">
                                                                    <div>
                                                                        <h4 class="modal-title" style="color:white"
                                                                            id="exampleModalLongTitle">
                                                                            Gambar</h4>
                                                                    </div>
                                                                    <div style="margin-left:auto">
                                                                        <button type="button" class="close"
                                                                            style="color:white" data-dismiss="modal"
                                                                            aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-body"
                                                                    style="padding:30px;display:flex;justify-content:center;">
                                                                    <img style="min-width:50%;max-width:100%"
                                                                        src="<?= $infoPasar['ATTACHMENT'] ?>">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <?= end($explode1) ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php }
                                                    if ($ekstensi == 'xls' || $ekstensi == 'xlsx') { ?>
                                                    <a class="btn" href="<?= $infoPasar['ATTACHMENT'] ?>"
                                                        style="width:38px;height:34px;background-color:green;color:white;display:flex">
                                                        <i class="fa fa-file-excel-o" style="margin:auto"></i>
                                                    </a>
                                                    <?php } ?>
                                                    <div style="width:100%;">
                                                        <input class="form-control" value="<?= end($explode1) ?>"
                                                            disabled>
                                                    </div>
                                                    <div>
                                                        <button class="btn btn-danger button-remove-file-attachment" style="display:none"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                </div>
                                                    <div class="input-group input-attachment-lpt-in ial-1"
                                                        style="display:none" data-id="1">
                                                        <span class="input-group-btn">
                                                            <span class="btn btn-default btn-file">
                                                                Browse...
                                                                <input type="file"
                                                                    name="input-attachment-market-info-lpt[]"
                                                                    class="input-attachment-market-info-lpt"
                                                                    data-input="1"
                                                                    accept="image/jpeg, image/png, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                                            </span>
                                                        </span>
                                                        <input readonly="readonly" placeholder="File Lampiran"
                                                            class="form-control output-attachment-market-info-lpt"
                                                            type="text">
                                                    </div>
                                                <?php } else {?>
                                                    <div style="width:100%;">
                                                        <input class="form-control input-replace-attachment-info-pasar-lpt" value="Tidak Ada Lampiran"
                                                            disabled>
                                                    </div>
                                                    <div class="input-group input-attachment-lpt ial-1"
                                                        style="display:none" data-id="1">
                                                        <span class="input-group-btn">
                                                            <span class="btn btn-default btn-file">
                                                                Browse...
                                                                <input type="file"
                                                                    name="input-attachment-market-info-lpt[]"
                                                                    class="input-attachment-market-info-lpt"
                                                                    data-input="1"
                                                                    accept="image/jpeg, image/png, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                                            </span>
                                                        </span>
                                                        <input readonly="readonly" placeholder="File Lampiran"
                                                            class="form-control output-attachment-market-info-lpt"
                                                            type="text">
                                                    </div>
                                                <?php } ?>
                                                <div style="width:70%;display:flex;;margin-top:15px;">
                                                    <button class="btn button-edit-input-info-pasar-lpt" type="button"
                                                        style="background-color: #4C575E;color:white;"><i
                                                            class="fa fa-edit" style="padding-right:6px;"></i>Edit
                                                        Info Pasar</button>
                                                    <button class="btn btn-success button-save-edit-input-info-pasar-lpt" style="display:none" data-statusfile="0">
                                                        <i class="fa fa-save" style="padding-right:8px"></i>Save
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div>
                                <a href="<?= base_url("laporanPenjualanTR2/Cabang/" . $cabang . "/inputInfoPasar") ?>"
                                    style="float:right" class="btn btn-primary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>