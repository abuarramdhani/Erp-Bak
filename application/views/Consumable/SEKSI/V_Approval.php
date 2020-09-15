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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ConsumableSEKSI/Approval'); ?>">
                                    <i class="fa fa-check fa-2x">
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
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <div class="col-md-12">
                                    <div class="panel-body">
                                        <div class="col-md-2" style="text-align: center;"> <label>Departement</label></div>
                                        <div class="col-md-3" style="text-align: left;"><input type="text" class="form-control" readonly value="<?= $carinamaseksi[0]['dept'] ?>" /> </div>

                                        <div class="col-md-2" style="text-align: center;"> <label>Unit</label></div>
                                        <div class="col-md-4" style="text-align: left;"><input type="text" class="form-control" readonly value="<?= $carinamaseksi[0]['unit'] ?>" /> </div>

                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-2" style="text-align: center;"> <label>Bidang</label></div>
                                        <div class="col-md-3" style="text-align: left;"><input type="text" class="form-control" readonly value="<?= $carinamaseksi[0]['bidang'] ?>" /> </div>

                                        <div class="col-md-2" style="text-align: center;"> <label>Seksi</label></div>
                                        <div class="col-md-4" style="text-align: left;"><input type="text" class="form-control" readonly value="<?= $carinamaseksi[0]['seksi'] ?>" /> </div>
                                    </div>
                                    <!-- <div class="panel-body">
                                        <div class="col-md-5" style="text-align: right;"> <label>Kode Sie</label></div>
                                        <div class="col-md-2" style="text-align: left;"><input type="text" class="form-control" readonly value="<?= $carinamaseksi[0]['kodesie'] ?>" /> </div>
                                    </div> -->
                                </div>
                            </div>
                            <div class="box-body" id="tbl_approval">
                                <div class="col-md-12">
                                    <table class="table table-bordered" id="tbl_approval_kebutuhan" style="width: 100%;">
                                        <thead class="bg-success">
                                            <tr>
                                                <th class="text-center"><input class="checkAll" type="checkbox" id="check-semuanya" /></th>
                                                <th class="text-center">Item Code</th>
                                                <th class="text-center">Description</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">UoM</th>
                                                <th class="text-center">Creation Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $u = 1;
                                            for ($i = 0; $i < sizeof($kebutuhan); $i++) { ?>
                                                <tr>
                                                    <input type="hidden" class="idUpdate" data-row="<?= $u ?>" name="id_item[]" value="<?= $kebutuhan[$i]['id'] ?>">
                                                    <td class="text-center"><input type="checkbox" class="checkUpdate" data-row="<?= $u ?>" name="check[]" value="<?= $kebutuhan[$i]['item_code'] ?>"></td>
                                                    <td class="text-center"><input type="hidden" class="itemUpdate" data-row="<?= $u ?>" name="item_code[]" value="<?= $kebutuhan[$i]['item_code'] ?>"><?= $kebutuhan[$i]['item_code'] ?></td>
                                                    <td class="text-center"><input type="hidden" class="descUpdate" data-row="<?= $u ?>" name="item_desc[]" value="<?= $kebutuhan[$i]['item_desc'] ?>"><?= $kebutuhan[$i]['item_desc'] ?></td>
                                                    <td class="text-center"><input type="hidden" class="qtyUpdate" data-row="<?= $u ?>" name="quantity[]" value="<?= $kebutuhan[$i]['quantity'] ?>"><?= $kebutuhan[$i]['quantity'] ?></td>
                                                    <td class="text-center"><input type="hidden" class="uomUpdate" data-row="<?= $u ?>" name="satuan[]" value="<?= $kebutuhan[$i]['satuan'] ?>"><?= $kebutuhan[$i]['satuan'] ?></td>
                                                    <td class="text-center"><input type="hidden" class="CreatedDt" data-row="<?= $u ?>" name="creatdt[]" value="<?= $kebutuhan[$i]['creation_date'] ?>"><?= $kebutuhan[$i]['creation_date'] ?></td>

                                                </tr>
                                            <?php $u++;
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12" style="text-align: right;"><button class="btn btn-warning btn-Update-Approve">Approve</button> <button class="btn btn-danger btn-Update-reject">Reject</button></div>
                            </div>
                        </div>
                        <div class="row">

                        </div>
                    </div>
                </div>
            </div>
</section>