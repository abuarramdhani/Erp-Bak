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
                                <form class="FormSubmitDataRekapEkspedisi" method="post">

                                    <div class="panel-body">
                                        <div class="col-md-2" style="text-align: right;"><label> Ekspedisi </label></div>
                                        <div class="col-md-3">
                                            <input type="hidden" name="name_ekspedisi_express" id="name_ekspedisi_express" />
                                            <select class="form-control select2" data-placeholder="Select" name="ekspedisi_express" id="ekspedisi_express" onchange="ChgEkspedisi()">
                                                <option value=""></option>
                                                <option value="SADANA">SADANA</option>
                                                <option value="TAM">TAM</option>
                                                <option value="JPM">JPM</option>

                                            </select>
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
                                            <input type="text" autocomplete="off" class="form-control" name="" id="tanggal_express">
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
                                            <input type="text" autocomplete="off" class="form-control" name="" id="resi_express">
                                        </div>
                                        <div class="col-md-2" style="text-align: right;"><label>Colly</label></div>
                                        <div class="col-md-3">
                                            <input type="text" autocomplete="off" class="form-control" name="" id="collynya_express">
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-2" style="text-align: right;"><label>Berat</label></div>
                                        <div class="col-md-3">
                                            <input type="text" autocomplete="off" class="form-control" name="" id="beratnya_express">
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
                                                    <td class="text-center" style="display:none">Tanggal</th>
                                                    <td class="text-center" style="display:none">No</th>
                                                    <td class="text-center" style="display:none">Cost Center</th>
                                                    <td class="text-center" style="display:none">Relasi / Cabang</th>
                                                    <td class="text-center" style="display:none">Tujuan</th>
                                                    <td class="text-center" style="display:none">No SPB / DOSP</th>
                                                    <td class="text-center" style="display:none">Colly</th>
                                                    <td class="text-center" style="display:none">Berat (Kg)</th>
                                                    <td class="text-center" style="display:none">Biaya (Rp)</th>
                                                    <td class="text-center" style="display:none">Action</th>

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