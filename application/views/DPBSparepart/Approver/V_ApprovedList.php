<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Approved List DPB</h3>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-hover table-bordered" id="tblWaitingListApproverDSP">
                        <thead>
                            <tr class="bg-primary"> 
                                <th>Request Number</th>
                                <th>Dikirim Dari</th>
                                <th>Kepada</th>
                                <th>Alamat Tujuan</th>
                                <th>Tipe</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($approved_list as $key => $list) { ?>
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-primary btnReqNumberDSP"><?= $list['REQUEST_NUMBER'];?></button>
                                        <div class="modal fade" id="mdlDSP-<?= $list['REQUEST_NUMBER'];?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title">Detail <b><?= $list['REQUEST_NUMBER'];?></b></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="loadingDetailDSP-<?= $list['REQUEST_NUMBER'];?>" align="center" style="display:none">
                                                            <img src="<?= base_url('assets/img/gif/loading3.gif');?>" class="img-responsive" alt="Image">
                                                        </div>
                                                        <div class="dataDSP-<?= $list['REQUEST_NUMBER'];?>"></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">OK</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= $list['DIKIRIM_DARI'];?></td>
                                    <td><?= $list['KEPADA'];?></td>
                                    <td><?= $list['ALAMAT_TUJUAN'];?></td>
                                    <td><?= $list['TIPE'];?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>