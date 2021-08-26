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
                                        <?= $Title ?>
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg">
                                    <i class="fa fa-pencil fa-2x">
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
                        <div class="box box-warning">
                            <div class="box-header with-border"></div>
                            <div class="box-body" id="View_Create_Rekap_Data_Ekspedisi_Express">
                                <form class="FormEditDataRekapEkspedisi" method="post">

                                    <div class="panel-body">
                                        <div class="col-md-2" style="text-align: right;"><label> Ekspedisi </label></div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="name_ekspedisi_express" readonly id="name_ekspedisi_express" value="<?= $rekap[0]['EXP_TYPE'] ?>" />
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <!-- <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label> Jenis </label></div>
                                        <div class="col-md-3">
                                            <select class="form-control select2" onchange="SPBorDOSP()" data-placeholder="Select" name="jenis_nomor_ekspedisi_express" id="jenis_nomor_ekspedisi_express">
                                                <option value=""></option>
                                                <option value="SPB">SPB</option>
                                                <option value="DOSP">DOSP</option>

                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="panel-body">
                                        <div class="col-md-2" style="text-align: right;"><label>Tanggal</label></div>
                                        <div class="col-md-3">
                                            <input type="text" autocomplete="off" class="form-control" name="tanggal_express[]" id="tanggal_express">
                                        </div>
                                        <div class="col-md-2" style="text-align: right;"><label> Nomor SPB / DOSP</label></div>
                                        <div class="col-md-3">
                                            <select class="form-control select2" multiple="multiple" name="nomor_ekspedisi_express[]" id="nomor_ekspedisi_express">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-2" style="text-align: right;"><label>No Resi</label></div>
                                        <div class="col-md-3">
                                            <input type="text" autocomplete="off" class="form-control" name="resi_express" id="resi_express">
                                        </div>
                                        <div class="col-md-2" style="text-align: right;"><label>Colly</label></div>
                                        <div class="col-md-3">
                                            <input type="text" autocomplete="off" class="form-control" name="collynya_express" id="collynya_express">
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-2" style="text-align: right;"><label>Berat</label></div>
                                        <div class="col-md-3">
                                            <input type="text" autocomplete="off" class="form-control" name="beratnya_express" id="beratnya_express">
                                        </div>
                                    </div>
                                    <input type="hidden" id="LastKlikedButon">
                                    <div class="panel-body">
                                        <div class="col-md-12" style="text-align: center;">
                                            <button type="submit" class="btn btn-primary" onclick="LastKlikedButonnn('1')">Add</button>
                                        </div>
                                    </div>
                                    <!-- </form>
                                <form action="<?= base_url('ReportEkspedisi/CreateReport/ExpInsert') ?>" target="_blank" method="post"> -->
                                    <div class="panel-body">
                                        <div class="col-md-12">
                                            <table class="table table-bordered" id="TblViewRekapEkspedisi">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th class="text-center">Tanggal</th>
                                                        <th class="text-center">No</th>
                                                        <th class="text-center">Cost Center</th>
                                                        <th class="text-center">Relasi / Cabang</th>
                                                        <th class="text-center">Tujuan</th>
                                                        <th class="text-center">No SPB / DOSP</th>
                                                        <th class="text-center">Colly</th>
                                                        <th class="text-center">Berat (Kg)</th>
                                                        <th class="text-center">Biaya (Rp)</th>
                                                        <th class="text-center">Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody id="AppendRowRekapEkspedisi">
                                                    <?php foreach ($rekap as $key => $rek) { ?>
                                                        <tr id="RowAPus<?= $rek['DATA_ID'] ?>">
                                                            <td class="text-center"><?= $rek['TANGGAL_RESI'] ?><input type="hidden" name="DataIDExpress[]" value="<?= $rek['DATA_ID'] ?>"></td>
                                                            <td class="text-center"><?= $rek['NO_RESI'] ?></td>
                                                            <td class="text-center"><?= $rek['COST_CENTER'] ?></td>
                                                            <td class="text-center"><?= $rek['RELASI'] ?></td>
                                                            <td class="text-center"><?= $rek['CITY'] ?></td>
                                                            <td class="text-center"><?= $rek['INDEX_TYPE'] ?> <?= $rek['NOMOR'] ?></td>
                                                            <td class="text-center"><?= $rek['COLLY'] ?></td>
                                                            <td class="text-center"><?= $rek['QTY'] ?></td>
                                                            <td class="text-center"><?= $rek['BIAYA'] ?></td>
                                                            <td class="text-center"><a class="btn btn-danger" onclick="DeleteDataExpress(<?= $rek['DATA_ID'] ?>)">Delete</a></td>

                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12" style="text-align:right"><button type="submit" onclick="LastKlikedButonnn('2')" class="btn btn-success">Export</button></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>