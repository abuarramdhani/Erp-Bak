<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Waiting List Approve DPB</h3>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-hover table-bordered" id="tblWaitingListApproverDSP">
                        <thead>
                            <tr class="bg-primary">
                                <th>Request Number</th>
                                <th>Dikirim Dari</th>
                                <th max-width="150px">Kepada</th>
                                <th max-width="150px">Alamat Tujuan</th>
                                <th>Tipe</th>
                                <th>Ekspedisi</th>
                                <th>Estimasi Berat</th>
                                <th>Shipping Instruction</th>
                                <th>Keterangan Tambahan</th>

                                <th width="180px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($waiting_list as $key => $list) { ?>
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-primary btnReqNumberDSP"><?= $list['REQUEST_NUMBER']; ?></button>
                                        <div class="modal fade" id="mdlDSP-<?= $list['REQUEST_NUMBER']; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title">Detail <b><?= $list['REQUEST_NUMBER']; ?></b></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="loadingDetailDSP-<?= $list['REQUEST_NUMBER']; ?>" align="center" style="display:none">
                                                            <img src="<?= base_url('assets/img/gif/loading3.gif'); ?>" class="img-responsive" alt="Image">
                                                        </div>
                                                        <div class="dataDSP-<?= $list['REQUEST_NUMBER']; ?>"></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">OK</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= $list['DIKIRIM_DARI']; ?></td>
                                    <td><?= $list['KEPADA']; ?></td>
                                    <td><?= $list['ALAMAT_TUJUAN']; ?></td>
                                    <td><?= $list['TIPE']; ?></td>
                                    <td><?= $list['EKSPEDISI'] ?></td>
                                    <td><?= $list['ESTIMASI_BERAT'] ?></td>
                                    <td><?= $list['SHIPPING_INSTRUCTIONS'] ?></td>
                                    <td><?= $list['KETERANGAN'] ?></td>

                                    <input type="hidden" id="EksToEdit<?= $list['REQUEST_NUMBER'] ?>" value="<?= $list['EKSPEDISI'] ?>" />
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm btnRejectDSP" title="reject" value="<?= $list['REQUEST_NUMBER']; ?>"><i class="fa fa-remove"></i> Reject</button>
                                        <button type="button" class="btn btn-success btn-sm btnApproveDSP" title="reject" value="<?= $list['REQUEST_NUMBER']; ?>"><i class="fa fa-check"></i> Approve</button>
                                        <button type="button" class="btn btn-warning btn-sm btnEditDSP" title="reject" value="<?= $list['REQUEST_NUMBER']; ?>"><i class="fa fa-pencil"></i> Edit Ekspedisi</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="Mdl_Ed_Eks" role="dialog">
    <div class="modal-dialog" style="width:60%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Edit Ekspedisi</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="Ed_Eks"></div>
            </div>
        </div>
    </div>
</div>