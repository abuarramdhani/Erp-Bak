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
                        <div class="box box-info">
                            <div class="box-header with-border"></div>
                            <!-- <form name="Orderform" enctype="multipart/form-data" onsubmit="return validasi();window.location.reload();" method="post"> -->
                            <div class="box-body">
                                <!-- <div class="panel-body">
                                        <div class="col-md-12" style="text-align: right;"><a onclick="deleteAlldata()" class="btn btn-danger">Delete All Data</a></div>
                                    </div> -->
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <table class="table table-bordered" id="list_SPB" style="width: 100%;">
                                            <thead class="bg-teal">
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Nomor SPB</th>
                                                    <th class="text-center">Creation Date</th>
                                                    <th class="text-center">Nomor SO</th>
                                                    <th class="text-center">Transact Status</th>
                                                    <th class="text-center">Interorg Status</th>
                                                    <th class="text-center">IO Tujuan</th>
                                                    <th class="text-center">Receipt Date</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1;
                                                foreach ($header as $v) { ?>
                                                    <tr>
                                                        <td class="text-center"><?= $i ?></td>
                                                        <td class="text-center"><?= $v['NO_SPB'] ?></td>
                                                        <input type="hidden" id="no_spb<?= $i ?>" value="<?= $v['NO_SPB'] ?>">
                                                        <td class="text-center"><?= $v['CREATION_DATE'] ?></td>
                                                        <td class="text-center"><?= $v['NO_SO'] ?></td>
                                                        <td class="text-center"><?= $v['TRANSACT_STATUS'] ?></td>
                                                        <td class="text-center"><?= $v['INTERORG_STATUS'] ?></td>
                                                        <td class="text-center"><?= $v['IO_TUJUAN'] ?></td>
                                                        <td class="text-center"><?= $v['TANGGAL_RECEIPT'] ?></td>
                                                        <td class="text-center"><button class="btn btn-sm btn-default" onclick="DetailSPB(<?= $i ?>)">Detail</button></td>
                                                    </tr>
                                                <?php $i++;
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- </form> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<div class="modal fade" id="mdl_detail_spb" role="dialog">
    <div class="modal-dialog" style="width:60%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Detail SPB</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="tbl_spb"></div>
            </div>
        </div>

    </div>
</div>