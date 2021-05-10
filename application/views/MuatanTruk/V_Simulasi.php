<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1>
                                    <b>
                                        SIMULASI MUATAN TRUK
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg">
                                    <i class="fa fa-truck fa-2x">
                                    </i>
                                    <span>
                                        <br />
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <!-- <div class="col-md-12">
                                        <h3>Traktor</h3>
                                    </div> -->
                                    <div class="col-md-12">
                                        <table class="table table-bordered" id="tbl_simulasi" style="font-size: 9pt;">
                                            <thead style="color:white">
                                                <tr>
                                                    <th class="text-center" style="background-color: #00c0ef;" rowspan="2">Kapasitas <br>Muat</th>
                                                    <th class="text-center" style="background-color: #00c0ef;" rowspan="2">Jenis</th>

                                                    <?php $ken = 1;
                                                    for ($i = 0; $i < sizeof($kendaraan); $i++) { ?>
                                                        <th class="text-center" style="background-color:  <?= $kendaraan[$i]['WARNA'] ?>;" colspan="3">
                                                            <?= $kendaraan[$i]['KENDARAAN'] ?>
                                                            <p>Presentase : </p>
                                                            <p class="presentase<?= $ken ?>" style="font-size: 12pt;">0%</p>
                                                            <input type="hidden" class="presentasehidden<?= $ken ?>" value="0">
                                                            <input type="hidden" class="lastchange<?= $ken ?>">
                                                            <input type="hidden" class="cekpresentasekeberapa<?= $ken ?>" value="0">

                                                        </th>
                                                    <?php $ken++;
                                                    } ?>
                                                </tr>
                                                <tr>
                                                    <?php for ($i = 0; $i < sizeof($kendaraan); $i++) { ?>
                                                        <th style="background-color:  <?= $kendaraan[$i]['WARNA'] ?>;" class="text-center">Body</th>
                                                        <th style="background-color:  <?= $kendaraan[$i]['WARNA'] ?>;" class="text-center">Kopel</th>
                                                        <th style="background-color:  <?= $kendaraan[$i]['WARNA'] ?>;" class="text-center">Peti</th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1;
                                                foreach ($DataSimulasi as $key => $simulasi) { ?>
                                                    <tr>
                                                        <td><b><?= $simulasi['item'] ?></b></td>
                                                        <td><b><?= $simulasi['jenis'] ?></b></td>

                                                        <?php $nos = 1;
                                                        foreach ($simulasi['kendaraan'] as $key => $sim) {
                                                            foreach ($sim as $keys => $value) {
                                                                if ($value['JENIS_MUATAN'] == 'disable') {
                                                                    $read = 'readonly';
                                                                } else {
                                                                    $read = "";
                                                                } ?>
                                                                <td style="background-color:  <?= $kendaraan[$key]['WARNA'] ?>;"><input <?= $read ?> type="number" id="precentinput<?= $keys . $no . $nos ?>" onkeyup="ChangePrecent(<?= $keys ?>,<?= $no ?>,<?= $nos ?>)" class="form-control" style="width: 100%;"></td>
                                                                <input type="hidden" id="precent<?= $keys . $no . $nos ?>" value="<?= $value['PROSENTASE'] ?>" />
                                                                <input type="hidden" class="lastvalue<?= $keys . $no . $nos ?>">
                                                        <?php
                                                            }
                                                            $nos++;
                                                        } ?>
                                                    </tr>
                                                <?php $no++;
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Table Diesel
                                <div class=" panel-body">
                                    <div class="col-md-12">
                                        <h3>Diesel</h3>
                                    </div>

                                    <div class="col-md-12">
                                        <table class="table table-bordered" style="font-size: 9pt;">
                                            <tbody>
                                                <?php $no = 1;
                                                foreach ($DataSimulasi2 as $key => $simulasi) { ?>
                                                    <tr>
                                                        <td><b><?= $simulasi['item'] ?></b></td>

                                                        <?php $nos = 1;
                                                        foreach ($simulasi['kendaraan'] as $key => $sim) {
                                                            foreach ($sim as $keys => $value) { ?>
                                                                <td colspan="3"><input type="number" id="precentinputt<?= $no . $nos ?>" onkeyup="Changepresentase2(<?= $no ?>,<?= $nos ?>)" class="form-control" style="width: 100%;"></td>
                                                                <input type="hidden" id="precentt<?= $no . $nos ?>" value="<?= $value['PROSENTASE']  ?>" />
                                                                <input type="hidden" class="lasttvalue<?= $no . $nos ?>">
                                                        <?php
                                                            }
                                                            $nos++;
                                                        } ?>
                                                    </tr>
                                                <?php $no++;
                                                } ?>
                                            </tbody>
                                            <tfoot class="bg-aqua">
                                                <tr>
                                                    <th class="text-center" rowspan="2">Kapasitas <br>Muat</th>
                                                    <?php for ($i = 0; $i < sizeof($kendaraan); $i++) { ?>
                                                        <th class="text-center">Body</th>
                                                        <th class="text-center">Kopel</th>
                                                        <th class="text-center">Peti</th>
                                                    <?php } ?>
                                                </tr>
                                                <tr>
                                                    <?php $ken = 1;
                                                    for ($i = 0; $i < sizeof($kendaraan); $i++) { ?>
                                                        <th class="text-center" colspan="3">
                                                            <?= $kendaraan[$i]['KENDARAAN'] ?>
                                                            <p class="presentase<?= $ken ?>">Presentase : 0%</p>
                                                            <input type="hidden" class="presentasehidden<?= $ken ?>" value="0">
                                                        </th>
                                                    <?php $ken++;
                                                    } ?>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>