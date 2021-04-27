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
                        <div class="box box-primary">
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead class="bg-aqua">
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Nomor Tagihan</th>
                                                    <th class="text-center">Nama Vendor</th>
                                                    <th class="text-center">Jumlah Item</th>
                                                    <th class="text-center">Total</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1;
                                                for ($i = 0; $i < sizeof($list_tagihan); $i++) {  ?>
                                                    <tr>
                                                        <td class="text-center"><?= $no ?></td>
                                                        <td class="text-center"><?= $list_tagihan[$i]['nomor_tagihan'] ?></td>
                                                        <input type="hidden" id="nom_tgh<?= $i ?>" value="<?= $list_tagihan[$i]['nomor_tagihan'] ?>">
                                                        <td class="text-center"><?= $list_tagihan[$i]['vendor_name'] ?></td>
                                                        <td class="text-center"><?= $list_tagihan[$i]['jml_item'] ?></td>
                                                        <td class="text-center">Rp <?= number_format($list_tagihan[$i]['total'], 0) ?></td>
                                                        <td class="text-center"><button class="btn btn-default btn-sm" onclick="DetailTagihan(<?= $i ?>)">Detail</button></td>
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
        </div>
</section>
<div class="modal fade" id="mdl_tagihan_d" role="dialog">
    <div class="modal-dialog" style="width:80%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Detail Tagihan</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="tagihan_d"></div>
            </div>
        </div>
    </div>
</div>