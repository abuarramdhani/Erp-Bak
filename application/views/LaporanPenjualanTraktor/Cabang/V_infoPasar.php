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
                                <b>Input Info Pasar</b>&nbsp;Penjualan TR2 per Bulan ( <b><?= $cabang ?></b> )
                            </div>
                            <hr style="width:100%;height:1px;">
                            <?php if ($info_target == '') { ?>
                            <label style="font-weight:normal;"><b>Maaf</b> kamu belum bisa menginputkan data
                                info pasar sekarang</label>
                            <?php } else { ?>
                            <?php if ($info_today == '') { ?>
                            <form id="form-input-info-pasar-lpt">
                                <table style=" width:70%;">
                                    <input type="text" style="display:none" id="cabang-input-lpt"
                                        value="<?= $cabang ?>"></input>
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
                                                    name="value-info-pasar-lpt" style="height:100px;"
                                                    required></textarea>
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
                                                    <div
                                                        style="width:70%;display:flex;justify-content:center;margin-top:15px;">
                                                        <button class="btn btn-success button-input-info-pasar-lpt"
                                                            type="button"><i class="fa fa-upload"
                                                                style="padding-right:6px;"></i>Input
                                                            Info Pasar</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>

                            <hr style="width:100%;height:1px;">
                            <table class="table" style="margin-bottom:10px;">
                                <tbody>
                                    <tr>
                                        <td style="border:unset;" colspan="2">
                                            <i class="fa fa-history" style="padding-right:8px;"></i>
                                            <b>History Analisa</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:2.8%;border:unset;"></td>
                                        <td style="border:unset;">
                                            <table class="table table-striped table-bordered" id="table-list-analys-lpt"
                                                style="width:100%;">
                                                <thead style="background-color: #4C575E;color:white;">
                                                    <th style="width:15%" class="text-center">Tanggal Input</th>
                                                    <th class="text-center">Description</th>
                                                    <th style="width:10%" class="text-center">Action</th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                            $i = 0;
                                                            foreach ($info_month as $value) {
                                                                if ($value['DESCRIPTION'] != '-') { ?>
                                                    <tr>
                                                        <td class="text-center" style="vertical-align:middle;">
                                                            <?php if ($value['DAYS'] == date('d-m-Y')) {
                                                                                echo 'Hari Ini';
                                                                            } else {
                                                                                echo $value['DAYS'];
                                                                            } ?>
                                                        </td>
                                                        <td class="text-center text-list-analys-month-lpt-<?= $i ?>"
                                                            style="vertical-align:middle;"><?= $value['DESCRIPTION'] ?>
                                                        </td>
                                                        <td class="text-center"><a class="btn btn-success"
                                                                href="<?= base_url('laporanPenjualanTR2/Cabang/' . $cabang . '/viewInfoPasar/' . $value['MARKET_ID']) ?>"><i
                                                                    class="fa fa-eye"></i></a></td>
                                                    </tr>
                                                    <?php $i++;
                                                                }
                                                            } ?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php } else { ?>
                            <label style="font-weight:normal;"><b>Maaf</b>, hari ini kamu telah menginputkan data Info
                                Pasar (
                                kamu bisa mengeditnya dibawah )</label>
                            <hr style="width:100%;height:1px;">
                            <table class="table" style="margin-bottom:10px;">
                                <tbody>
                                    <tr>
                                        <td style="border:unset;" colspan="2">
                                            <i class="fa fa-history" style="padding-right:8px;"></i>
                                            <b>History Analisa</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:2.8%;border:unset;"></td>
                                        <td style="border:unset;">
                                            <table class="table table-striped table-bordered" id="table-list-analys-lpt"
                                                style="width:100%;">
                                                <thead style="background-color: #4C575E;color:white;">
                                                    <th style="width:15%" class="text-center">Tanggal Input</th>
                                                    <th class="text-center">Description</th>
                                                    <th style="width:10%" class="text-center">Action</th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                            $i = 0;
                                                            foreach ($info_month as $value) {
                                                                if ($value['DESCRIPTION'] != '-') { ?>
                                                    <tr>
                                                        <td class="text-center" style="vertical-align:middle;">
                                                            <?php if ($value['DAYS'] == date('d-m-Y')) {
                                                                                echo 'Hari Ini';
                                                                            } else {
                                                                                echo $value['DAYS'];
                                                                            } ?></td>
                                                        <td class="text-center text-list-analys-month-lpt-<?= $i ?>"
                                                            style="vertical-align:middle;"><?= $value['DESCRIPTION'] ?>
                                                        </td>
                                                        <td class="text-center"><a class="btn btn-success"
                                                                href="<?= base_url('laporanPenjualanTR2/Cabang/' . $cabang . '/viewInfoPasar/' . $value['MARKET_ID']) ?>"><i
                                                                    class="fa fa-eye"></i></a></td>
                                                    </tr>
                                                    <?php $i++;
                                                                }
                                                            } ?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
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