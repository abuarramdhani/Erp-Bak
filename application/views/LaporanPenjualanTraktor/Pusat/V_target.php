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
                                <b>Input Target</b>&nbsp;Penjualan TR2 per Bulan
                            </div>
                            <hr style="width:100%;height:1px;">
                            <div class="box-info-input-target-lpt" style="border-top:unset;margin-bottom:30px;">
                                <div
                                    style="padding:14px 20px 14px 30px;background-color:#4C575E;color:white;border-radius:5px;">
                                    <i>Bila sudah
                                        menginputkan target pada
                                        bulan ini ( <b style="color:#F76F72"><?= date("F") ?></b> ), maka tidak bisa
                                        input target pada bulan ini kembali ( tapi kamu bisa mengeditnya )</i><i
                                        class="fa fa-close close-info-input-target" style="float:right"
                                        onmouseover=""></i>
                                </div>
                            </div>
                            <table class="table table-bordered">
                                <thead style="background-color:#EFEFEF;">
                                    <tr>
                                        <th class="text-center"><i class="fa fa-map-marker"
                                                style="padding-right:4px;"></i>Cabang</th>
                                        <td class="text-center" style="width:8%;vertical-align:middle;">MKS</td>
                                        <td class="text-center" style="width:8%;vertical-align:middle;">GJK</td>
                                        <td class="text-center" style="width:8%;vertical-align:middle;">YGY</td>
                                        <td class="text-center" style="width:8%;vertical-align:middle;">JKT</td>
                                        <td class="text-center" style="width:8%;vertical-align:middle;">TJK</td>
                                        <td class="text-center" style="width:8%;vertical-align:middle;">MDN</td>
                                        <td class="text-center" style="width:8%;vertical-align:middle;">PLU</td>
                                        <td class="text-center" style="width:8%;vertical-align:middle;">PKU</td>
                                        <td class="text-center" style="width:8%;vertical-align:middle;">PNK</td>
                                        <td class="text-center" style="width:8%;vertical-align:middle;">BJM</td>
                                        <td class="text-center" style="width:8%;vertical-align:middle;">Ekspor
                                        </td>
                                    </tr>
                                </thead>
                                <tbody class="form-input-target-cabang-lpt">
                                    <tr>
                                        <th class="text-center" style="vertical-align:middle;"><i class="fa fa-bullseye"
                                                style="padding-right:4px;color:red;"></i>Target
                                        </th>
                                        <td class="text-center"><input type="number"
                                                class="form-control text-center input-target-lpt-mks"
                                                style="font-weight:bold">
                                        </td>
                                        <td class="text-center"><input type="number"
                                                class="form-control text-center input-target-lpt-gjk"
                                                style="font-weight:bold">
                                        </td>
                                        <td class="text-center"><input type="number"
                                                class="form-control text-center input-target-lpt-ygy"
                                                style="font-weight:bold">
                                        </td>
                                        <td class="text-center"><input type="number"
                                                class="form-control text-center input-target-lpt-jkt"
                                                style="font-weight:bold">
                                        </td>
                                        <td class="text-center"><input type="number"
                                                class="form-control text-center input-target-lpt-tjk"
                                                style="font-weight:bold">
                                        </td>
                                        <td class="text-center"><input type="number"
                                                class="form-control text-center input-target-lpt-mdn"
                                                style="font-weight:bold">
                                        </td>
                                        <td class="text-center"><input type="number"
                                                class="form-control text-center input-target-lpt-plu"
                                                style="font-weight:bold">
                                        </td>
                                        <td class="text-center"><input type="number"
                                                class="form-control text-center input-target-lpt-pku"
                                                style="font-weight:bold">
                                        </td>
                                        <td class="text-center"><input type="number"
                                                class="form-control text-center input-target-lpt-pnk"
                                                style="font-weight:bold">
                                        </td>
                                        <td class="text-center"><input type="number"
                                                class="form-control text-center input-target-lpt-bjm"
                                                style="font-weight:bold">
                                        </td>
                                        <td class="text-center"><input type="number"
                                                class="form-control text-center input-target-lpt-ekspor"
                                                style="font-weight:bold">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div style="display:flex;justify-content:center;">
                                <button class="btn btn-success button-input-lpt" <?php if (empty($infoTarget)) {
                                                                                        echo '';
                                                                                    } else {
                                                                                        echo 'disabled';
                                                                                    } ?>>
                                    <i class="fa fa-upload" style="padding-right:6px;"></i>Inputkan Target
                                </button>
                            </div>
                            <br>
                            <br>
                            <div class="col-lg-4">
                                <div class="box box solid" style="border-top:unset;">
                                    <div class="box-header"
                                        style="background-color:#EFEFEF;font-weight:bold;padding:6px 15px;">
                                        <i class="fa fa-info-circle" style="font-size:14px;color:#E04A3A;"></i>Catatan
                                    </div>
                                    <div class="box-body" style="padding:10px 20px;">
                                        <?php
                                        if (empty($infoTarget)) {
                                            echo '<i><b>(' . date('M') . ') - </b></i>';
                                            echo '<i style="color:#E04A3A;font-size:14px;">Target bulan ini belum ditambahkan</i>';
                                        } else {
                                            echo '<i><b>(' . date('M') . ') - </b></i>';
                                            echo '<i style="color:green;font-size:14px;">Target bulan ini sudah
                                            ditambahkan</i>';
                                        ?>
                                        <div style="display:flex;justify-content:center;margin-top:10px;"><a
                                                href="<?= base_url("laporanPenjualanTR2/Pusat/inputTarget/viewTarget") ?>"
                                                class="btn btn-danger">Lihat Target</a>
                                        </div>
                                        <?php
                                        }
                                        ?>
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