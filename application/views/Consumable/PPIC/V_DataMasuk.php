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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ConsumablePPIC/Datamasuk'); ?>">
                                    <i class="fa fa-list fa-2x">
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
                            <div class="box-body">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead class="bg-teal">
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Seksi</th>
                                                <th class="text-center">Tanggal Input</th>
                                                <th class="text-center">Tanggal Approve Atasan</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1;
                                            foreach ($kebutuhan_seksi as $need) { ?>
                                                <tr>
                                                    <td class="text-center"><?= $no ?></td>
                                                    <td class="text-center"><?= $need['nama_seksi'] ?></td>
                                                    <td class="text-center"><?= $need['tgl_input'] ?></td>
                                                    <td class="text-center"><?= $need['tgl_approve_atasan'] ?></td>
                                                    <td class="text-center"><button onclick="lihatkebutuhanseksi(this, <?= $no ?>)" class="btn btn-default btn-sm">Lihat</button></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td colspan="4">
                                                        <div id="lihatkebutuhanseksi<?= $no ?>" style="display: none;">
                                                            <h5 style="font-weight: bold;">Permintaan Update Standar Kebutuhan</h5>
                                                            <table class="table table-bordered" id="tablekebutuhanseksi<?= $no ?>">
                                                                <thead class="bg-info">
                                                                    <tr>
                                                                        <th class="text-center"><input type="checkbox" class="checksemwa<?= $no ?>" /></th>
                                                                        <th class="text-center">Item Code</th>
                                                                        <th class="text-center">Description</th>
                                                                        <th class="text-center">Qty</th>
                                                                        <th class="text-center">UoM</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $nom = 1;
                                                                    foreach ($need['lihat'] as $value) { ?>
                                                                        <tr>
                                                                            <input type="hidden" class="IdApprove" data-row="<?= $no ?><?= $nom ?>" value="<?= $value['id'] ?>" />
                                                                            <td class="text-center"><input type="checkbox" class="daftarcheck<?= $no ?>" data-row="<?= $no ?><?= $nom ?>" value="<?= $value['item_code'] ?>" /></td>
                                                                            <td class="text-center"><input type="hidden" class="ItemApprove" data-row="<?= $no ?><?= $nom ?>" value="<?= $value['item_code'] ?>" /><?= $value['item_code'] ?></td>
                                                                            <td class="text-center"><input type="hidden" value="<?= $value['item_desc'] ?>" /><?= $value['item_desc'] ?></td>
                                                                            <td class="text-center"><input type="hidden" value="<?= $value['quantity'] ?>" /><?= $value['quantity'] ?></td>
                                                                            <td class="text-center"><input type="hidden" value="<?= $value['uom'] ?>" /><?= $value['uom'] ?></td>

                                                                        </tr>
                                                                    <?php $nom++;
                                                                    } ?>
                                                                </tbody>
                                                            </table>
                                                            <div class="col-md-12" style="text-align: right;"><button class="btn btn-success btn-Update-Approve-PPIC<?= $no ?>">Approve</button> <button class="btn btn-danger btn-Update-Reject-PPIC<?= $no ?>">Reject</button></div>
                                                            <br>
                                                            <br>
                                                            <h5 style="font-weight: bold;">Standar Kebutuhan Terakhir</h5>
                                                            <table class="table table-bordered" id="tablerekapkebutuhanseksi<?= $no ?>">
                                                                <thead class="bg-success">
                                                                    <tr>
                                                                        <th class="text-center">No</th>
                                                                        <th class="text-center">Item Code</th>
                                                                        <th class="text-center">Description</th>
                                                                        <th class="text-center">Qty</th>
                                                                        <th class="text-center">UoM</th>
                                                                        <th class="text-center">Tgl Approve PPIC</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $nomo = 1;
                                                                    foreach ($need['rekap'] as $value) { ?>
                                                                        <tr>
                                                                            <td class="text-center"><?= $nomo ?></td>
                                                                            <td class="text-center"><input type="hidden" value="<?= $value['item_code'] ?>" /><?= $value['item_code'] ?></td>
                                                                            <td class="text-center"><input type="hidden" value="<?= $value['item_desc'] ?>" /><?= $value['item_desc'] ?></td>
                                                                            <td class="text-center"><input type="hidden" value="<?= $value['quantity'] ?>" /><?= $value['quantity'] ?></td>
                                                                            <td class="text-center"><input type="hidden" value="<?= $value['uom'] ?>" /><?= $value['uom'] ?></td>
                                                                            <td class="text-center"><input type="hidden" value="<?= $value['ppic_approve_date'] ?>" /><?= $value['ppic_approve_date'] ?></td>
                                                                        </tr>
                                                                    <?php $nomo++;
                                                                    } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php $no++;
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>