<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Approved List DPB</h3>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-hover table-bordered" id="tblMonitoringDSP" width="100%">
                        <thead>
                            <tr class="bg-primary"> 
                                <th style="vertical-align:middle;" rowspan="2">No Dokumen</th>
                                <th style="vertical-align:middle;" rowspan="2">Jenis Dokumen</th>
                                <th style="vertical-align:middle;" rowspan="2">Tipe</th>
                                <th style="vertical-align:middle;" rowspan="2">Ekspedisi</th>
                                <th style="text-align:center;" colspan="3">Pelayanan</th>
                                <th style="text-align:center;" colspan="3">Packing</th>
                            </tr>
                            <tr class="bg-primary text-center">
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Waktu</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php foreach($monitoring_list as $key => $list) { ?>
                              <tr>
                                <td>
                                    <button type="button" class="btn btn-primary btnReqNumberDSP"><?= $list['NO_DOKUMEN'];?></button>
                                    <div class="modal fade" id="mdlDSP-<?= $list['NO_DOKUMEN'];?>">
                                        <div class="modal-dialog">
                                             <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">Detail <b><?= $list['NO_DOKUMEN'];?></b></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="loadingDetailDSP-<?= $list['NO_DOKUMEN'];?>" align="center" style="display:none">
                                                        <img src="<?= base_url('assets/img/gif/loading3.gif');?>" class="img-responsive" alt="Image">
                                                    </div>
                                                    <div class="dataDSP-<?= $list['NO_DOKUMEN'];?>"></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">OK</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><?= $list['JENIS_DOKUMEN'];?></td>
                                <td><?= $list['TIPE'];?></td>
                                <td><?= $list['EKSPEDISI'];?></td>
                                <td><?= $list['MULAI_PELAYANAN'];?></td>
                                <td><?= $list['SELESAI_PELAYANAN'];?></td>
                                <td><?= $list['WAKTU_PELAYANAN'];?></td>
                                <td><?= $list['MULAI_PACKING'];?></td>
                                <td><?= $list['SELESAI_PACKING'];?></td>
                                <td><?= $list['WAKTU_PACKING'];?></td>
                              </tr>
                           <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>