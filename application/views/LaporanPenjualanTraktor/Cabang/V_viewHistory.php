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
                                <div>
                                    <i class="fa fa-history" style="margin-right:10px;"></i>
                                    <b>History
                                        <?php
                                        if ($namaMenu == 'analysis') {
                                            $menu = 'inputAnalisa';
                                            $link = 'lastWeekHistoryOfAnalysis';
                                            echo 'Analisa';
                                        }
                                        if ($namaMenu == 'infoPasar') {
                                            $menu = 'inputInfoPasar';
                                            $link = 'lastWeekHistoryOfMarketInfo';
                                            echo 'Info Pasar';
                                        }
                                        ?>
                                    </b>&nbsp;Minggu Kemarin ( <b><?= $cabang ?></b> )
                                </div>
                                <div style="margin-left:auto">
                                    <a href="<?= base_url('laporanPenjualanTR2/exportPdfLastWeek/' . $cabang) ?>"
                                        class="btn btn-danger" style="box-shadow: 3px 3px 4px 0px #c3c3c3d1">
                                        <i class="fa fa-file-pdf-o"></i>
                                        &emsp;<b>Export PDF</b>
                                    </a>
                                </div>
                            </div>
                            <hr style="width:100%;height:1px;">
                            <div style="padding:20px">
                                <table class="table table-striped table-bordered" id="table-list-history-lpt">
                                    <thead style="background-color: #4C575E;color:white;">
                                        <th class="text-center" style="width:18%">Tanggal</th>
                                        <th class="text-center">
                                            <?php
                                            if ($namaMenu == 'analysis') {
                                                echo 'Problem';
                                            }
                                            if ($namaMenu == 'infoPasar') {
                                                echo 'Description';
                                            }
                                            ?>
                                        </th>
                                        <th class="text-center" style="width:10%">Action</th>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0;
                                        foreach ($history as $value) {
                                            if ($namaMenu == 'analysis') {
                                                $index = $value['PROBLEM'];
                                            }
                                            if ($namaMenu == 'infoPasar') {
                                                $index = $value['DESCRIPTION'];
                                            }
                                            if ($index != '-') { ?>
                                        <tr>
                                            <td class="text-center" style="vertical-align:middle">
                                                <?= $value['DAYS'] ?>
                                            </td>
                                            <td class="text-center text-list-history-lpt-<?= $i ?>"
                                                style="vertical-align:middle">
                                                <?php if ($namaMenu == 'analysis') {
                                                            echo $value['PROBLEM'];
                                                        }
                                                        if ($namaMenu == 'infoPasar') {
                                                            echo $value['DESCRIPTION'];
                                                        } ?>
                                            </td>
                                            <td class="text-center" style="vertical-align:middle">
                                                <?php if ($value['ID'] != '-') { ?>
                                                <a href="<?= base_url('laporanPenjualanTR2/Cabang/' . $cabang . '/' . $link . '/detail/' . $value['ID']) ?>"
                                                    class="btn btn-success">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <?php } else {
                                                            echo '-';
                                                        } ?>
                                            </td>
                                        </tr>
                                        <?php
                                                $i++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <a href="<?= base_url('laporanPenjualanTR2/Cabang/' . $cabang . '/' . $menu) ?>"
                                    class="btn" style="background-color: #4C575E;color:white;">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>