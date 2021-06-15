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
                            <div class="box-body" id="view_simulasihh">
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <a href="<?= base_url('MuatanTruk/Simulasi') ?>" class="btn btn-danger">Reset</a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-1"><b>Kendaraan</b></div>
                                    <div class="col-md-3">
                                        <select class="form-control select2" name="" data-placeholder="Select" id="SelctKendaraAn">
                                            <option value=""></option>
                                            <option value="Engkel">Engkel</option>
                                            <option value="Rhino">Rhino</option>
                                            <option value="Fuso6-7M">Fuso6-7M</option>
                                            <option value="Tronton10M">Tronton10M</option>
                                            <option value="Fuso8M/Tronton9M">Fuso8M/Tronton9M</option>
                                            <option value="Container20">Container20</option>
                                            <option value="Container40">Container40</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2"><button class="btn btn-danger" onclick="CrtSims()">Buat Simulasi</button></div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12" id="TableSimUlasi">
                                        <!-- <table class="table table-bordered" id="tbl_simulasi" style="font-size: 9pt;">
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
                                        </table> -->
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>