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
                                <b><?php if ($data['PROBLEM'] == '' && $data['ROOT_CAUSE'] == '' && $data['ACTION'] == '' && $data['DUE_DATE'] == '') {
                                        echo 'Input';
                                    } else {
                                        echo 'Edit';
                                    } ?>
                                    Analisa</b>&nbsp;Penjualan TR2 per Bulan ( <b><?= $cabang ?></b> )
                            </div>
                            <hr style="width:100%;height:1px;">
                            <?php if ($data == '') { ?>
                            <label style="font-weight:normal;"><b>Maaf</b> kamu belum bisa menginputkan data
                                anlisa sekarang</label>
                            <?php } else { ?>
                            <table class="table" style="margin-bottom:10px;">
                                <tbody>
                                    <tr>
                                        <td style="width:50%;border:unset;" colspan="2">
                                            <i class="fa fa-tachometer" style="padding-right:8px;"></i>
                                            <b>Laju Penjualan</b>
                                        </td>
                                        <td style="border:unset;" colspan="2">
                                            <i class="fa fa-line-chart" style="padding-right:8px;"></i>
                                            <b>Penjualan per Bulan</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:2.8%;border:unset;"></td>
                                        <td style="padding-top:10px;padding-left:30px;border:unset;">
                                            <table style="width:70%">
                                                <tbody>
                                                    <tr>
                                                        <td style="width:25%;padding:5px 0;">Rata-Rata</td>
                                                        <td style="width:25%;font-size:16px;" class="text-center">
                                                            <b><?= $data['TOTAL_PER_HARI'] ?></b>
                                                        </td>
                                                        <td style="width:50%;padding-left:20px;">/ Hari</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:5px 0;">Target</td>
                                                        <td style="font-size:16px;" class="text-center">
                                                            <b><?= $data['TARGET_PER_HARI'] ?></b>
                                                        </td>
                                                        <td style="padding-left:20px;">/ Hari</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:5px 0;">Ketrangan</td>
                                                        <td colspan="2">
                                                            <b><?php if ($data['TOTAL_PER_HARI'] < $data['TARGET_PER_HARI']) {
                                                                        echo 'Dibawah Target Laju Penjualan';
                                                                    } else {
                                                                        echo 'Diatas Target Laju Penjualan';
                                                                    } ?></b>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td style="width:2.8%;border:unset;"></td>
                                        <td style="padding-top:10px;padding-left:30px;border:unset;">
                                            <table style="width:70%">
                                                <tbody>
                                                    <tr>
                                                        <td style="width:25%;padding:5px 0;">Akumulasi</td>
                                                        <td style="width:25%;font-size:16px;" class="text-center">
                                                            <b><?= $data['TOTAL'] ?></b>
                                                        </td>
                                                        <td style="width:50%;padding-left:20px;">Unit</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:5px 0;">Target</td>
                                                        <td style="font-size:16px;" class="text-center">
                                                            <b><?= $data['TARGET'] ?></b>
                                                        </td>
                                                        <td style="padding-left:20px;">Unit</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:5px 0;">Pencapaian</td>
                                                        <td style="font-size:16px;" class="text-center">
                                                            <b><?= $data['PERBANDINGAN'] ?> %</b>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr style="width:100%;height:1px;">
                            <?php if ($data['PROBLEM'] == '' && $data['ROOT_CAUSE'] == '' && $data['ACTION'] == '' && $data['DUE_DATE'] == '') { ?>
                            <div style="padding:8px;">
                                <div style="margin-bottom:20px;">
                                    <i class="fa fa-pencil" style="font-size:14px;padding-right:8px;"></i><b>Problem</b>
                                    <div style="padding-left:22px;margin-top:10px;">
                                        <textarea class="form-control input-analytics-problem-lpt-cabang"
                                            style="height:80px;" placeholder="Problem ..."
                                            data-id="<?= $data['REPORT_ID'] ?>"></textarea>
                                    </div>
                                </div>
                                <div style="margin-bottom:20px;">
                                    <i class="fa fa-pencil" style="font-size:14px;padding-right:8px;"></i><b>Root
                                        Cause</b>
                                    <div style="padding-left:22px;margin-top:10px;">
                                        <textarea class="form-control input-analytics-rootcause-lpt-cabang"
                                            style="height:80px;" placeholder="Root Cause ..."></textarea>
                                    </div>
                                </div>
                                <div style="margin-bottom:20px;">
                                    <i class="fa fa-pencil" style="font-size:14px;padding-right:8px;"></i><b>Action</b>
                                    <div style="padding-left:22px;margin-top:10px;">
                                        <textarea class="form-control input-analytics-action-lpt-cabang"
                                            style="height:80px;" placeholder="Action ..."></textarea>
                                    </div>
                                </div>
                                <div style="margin-bottom:20px;">
                                    <i class="fa fa-calendar" style="font-size:14px;padding-right:8px;"></i><b>Due
                                        Date</b>
                                    <div style="padding-left:22px;margin-top:10px;">
                                        <input class="form-control input-analytics-duedate-lpt-cabang"
                                            placeholder="Date ... "></input>
                                    </div>
                                </div>
                                <div style="margin-top:20px;padding-left:22px;">
                                    <button class="btn" style="background-color: #4C575E;color:white;"
                                        id="button-input-analytics-lpt-cabang">Input
                                        Analisa</button>
                                </div>
                            </div>
                            <?php } else { ?>
                            <div style="padding:8px;">
                                <div style="margin-bottom:20px;">
                                    <i class="fa fa-pencil" style="font-size:14px;padding-right:8px;"></i><b>Problem</b>
                                    <div style="padding-left:22px;margin-top:10px;">
                                        <textarea class="form-control input-analytics-problem-lpt-cabang"
                                            style="height:80px;margin-bottom:10px" data-id="<?= $data['REPORT_ID'] ?>"
                                            disabled><?= $data['PROBLEM'] ?></textarea>
                                    </div>
                                </div>
                                <div style="margin-bottom:20px;">
                                    <i class="fa fa-pencil" style="font-size:14px;padding-right:8px;"></i><b>Root
                                        Cause</b>
                                    <div style="padding-left:22px;margin-top:10px;">
                                        <textarea class="form-control input-analytics-rootcause-lpt-cabang"
                                            style="height:80px;margin-bottom:10px"
                                            disabled><?= $data['ROOT_CAUSE'] ?></textarea>
                                    </div>
                                </div>
                                <div style="margin-bottom:20px;">
                                    <i class="fa fa-pencil" style="font-size:14px;padding-right:8px;"></i><b>Action</b>
                                    <div style="padding-left:22px;margin-top:10px;">
                                        <textarea class="form-control input-analytics-action-lpt-cabang"
                                            style="height:80px;margin-bottom:10px"
                                            disabled><?= $data['ACTION'] ?></textarea>
                                    </div>
                                </div>
                                <div style="margin-bottom:20px;">
                                    <i class="fa fa-calendar" style="font-size:14px;padding-right:8px;"></i><b>Due
                                        Date</b>
                                    <div style="padding-left:22px;margin-top:10px;">
                                        <input class="form-control input-analytics-duedate-lpt-cabang"
                                            style="margin-bottom:10px;" value="<?= $data['DUE_DATE'] ?>" disabled>
                                    </div>
                                </div>
                                <div style="margin-top:20px;padding-left:22px;">
                                    <button class="btn" style="background-color: #4C575E;color:white;"
                                        id="button-edit-input-analytics-lpt-cabang">Edit
                                        Analisa</button>
                                    <button class="btn btn-success" id="button-save-edit-analytics-lpt-cabang"
                                        style="display:none"><i class="fa fa-save"
                                            style="padding-right:10px"></i>Save</button>
                                </div>
                            </div>
                            <?php }
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>