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
                                <i class="fa fa-eye" style="margin-right:10px;"></i>
                                <b>Lihat Target Cabang</b>&nbsp;Penjualan TR2 per Bulan
                            </div>
                            <hr style="width:100%;height:1px;">
                            <table class="table table-bordered" style="width:50%;">
                                <thead style="background-color:#EFEFEF;">
                                    <th class="text-center" style="width:40%"><i class="fa fa-map-marker"
                                            style="padding-right:4px;"></i>Cabang
                                    </th>
                                    <th class="text-center" style="width:30%"><i class="fa fa-bullseye"
                                            style="padding-right:4px;color:red;"></i>Target</th>
                                    <th class="text-center">Action</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $value) { ?>
                                    <tr>
                                        <td class="text-center" style="vertical-align:middle;"><?= $value['BRANCH'] ?>
                                        </td>
                                        <td class="text-center"><input style="font-weight:bold;text-align:center;"
                                                class="form-control edit-input-target-lpt-pusat edit-input-target-lpt-pusat-<?= $value['REPORT_ID'] ?>"
                                                type="number" value="<?= $value['TARGET'] ?>"
                                                data-id="<?= $value['REPORT_ID'] ?>" disabled></td>
                                        <td class="text-center" style="vertical-align:middle;">
                                            <button class="btn btn-primary button-edit-target-lpt-pusat"
                                                data-id="<?= $value['REPORT_ID'] ?>"><i class="fa fa-edit"></i></button>
                                            <button
                                                class="btn btn-success button-save-target-lpt-pusat button-save-target-lpt-pusat-<?= $value['REPORT_ID'] ?>"
                                                style="display:none" data-id="<?= $value['REPORT_ID'] ?>"><i
                                                    class="fa fa-save"></i></button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <div>
                                <a href=" <?= base_url("laporanPenjualanTR2/Pusat/inputTarget") ?>"
                                    class="btn btn-primary" style="float: right;">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>