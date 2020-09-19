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
                <!-- <form name="Orderform" action="<?php echo base_url('ConsumableSEKSI/Inputkebutuhan/'); ?>" class="form-horizontal" target="_blank" onsubmit="return validasi();window.location.reload();" method="post"> -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-danger">
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="col-md-1"><label>Periode</label></div>
                                        <div class="col-md-3"><input id="periodebon" type="text" class="form-control periodebon" autocomplete="off" placeholder="Periode Bon" required /></div>
                                        <div class="col-md-2"><button class="btn btn-danger" onclick="caridatabon()">Lihat</button></div>
                                    </div>

                                </div>
                                <div class="col-md-12" id="tbl_bon">
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <label> Seksi</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-8">
                                            <select required class="form-control select2" disabled="disabled" id="seksi_pengebonn" data-placeholder="Select Seksi">
                                                <option></option>
                                            </select>
                                            <input type="hidden" id="seksi_pemakai">
                                            <input type="hidden" id="seksi_pengebon" value="<?= $carinamaseksi[0]['seksi'] ?>">
                                        </div>
                                    </div>
                                    <!-- Pembatassss -->
                                    <div class="col-md-12">
                                        <div class="col-md-8">
                                            <div class="col-md-6" style="padding: 0px;padding-right:3px"><label> Cost Center</label></div>
                                            <div class="col-md-6" style="padding: 0px;padding-left:3px"><label> Branch</label></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-8">
                                            <div class="col-md-6" style="padding: 0px;padding-right:3px">
                                                <input placeholder="Cost Center" id="cocenter" type="text" class="form-control" readonly />
                                            </div>
                                            <div class="col-md-6" style="padding: 0px;padding-left:3px">
                                                <input placeholder="Kode Cabang" id="KoCab" type="text" class="form-control" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Pembatassss -->
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <label>Tujuan Penggunaan</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-8">
                                            <!-- <input type="text" class="form-control" id="locator_bon" value="UMUM" readonly /> -->
                                            <select class="form-control select2" id="tujuan_guna" disabled="disabled" data-placeholder="Select">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Pembatassss -->
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <label>Lokasi</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="lokasi_bon" value="<?= $lokk ?>" readonly />
                                            <input type="hidden" id="lokasi_bon_id" value="<?= $lokk_id ?>" />

                                        </div>
                                    </div>
                                    <!-- Pembatassss -->
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <label>Subinventory</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="subinvbon" value="<?= $sub ?>" readonly />
                                            <input type="hidden" id="subinvbon2" value="<?= $sub_id ?>" />
                                        </div>
                                    </div>

                                    <div style="color:white">haha</div> <!-- pembatas-->
                                    <!-- table barang -->
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <label>Barang</label>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12" id="loadingkartubon">
                                            <table class="table table-bordered">
                                                <thead class="bg-default">
                                                    <tr>
                                                        <th class="text-center"><input type="checkbox" class="bonsemwa" /></th>
                                                        <th class="text-center">Item</th>
                                                        <th class="text-center">Desc</th>
                                                        <th class="text-center">Jumlah Kebutuhan</th>
                                                        <th class="text-center">Total Bon terakhir</th>
                                                        <th class="text-center">Jumlah Bon</th>
                                                        <th class="text-center">Saldo</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbodybon">
                                                </tbody>
                                            </table>
                                            <div class="col-md-12" id="loadingbon"></div>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12" style="text-align: right;"><button class="btn btn-warning btn-Bon">Input</button></div>
                                    </div>
                                </div>
                                <div class="row">

                                </div>
                            </div>
                        </div>
                        <!-- </form> -->
                    </div>
</section>