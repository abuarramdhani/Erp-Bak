<section class="content-header">
    <h1> Order Kebutuhan Barang dan Jasa </h1>
</section>
<section class="content">
    <div class="row">
        <form class="ExportApprovalOkbj" action="<?= base_url('OrderKebutuhanBarangDanJasa/ExportApproval/ExportFileApproval') ?>" method="POST" enctype="multipart/form-data">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header"></div>
                    <div class="box-body">
                        <div class="panel-body">
                            <div class="col-md-4" style="text-align: right;"><b>Level</b></div>
                            <div class="col-md-4">
                                <select class="form-control select2" data-placeholder="Pilih Level" name="okbj_lvl_approval" onchange="ChangeLevelApproval()" id="okbj_lvl_approval">
                                    <option value=""></option>
                                    <option value="3">Kasie</option>
                                    <option value="5">Unit</option>
                                    <option value="6">Puller</option>
                                    <option value="7">Pengelola</option>
                                    <option value="8">Departement</option>

                                </select>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-4" style="text-align: right;"><b>Nama Approver / Puller</b></div>
                            <div class="col-md-4">
                                <select class="form-control select2" name="okbj_name_approver" data-placeholder="Pilih Approver" id="okbj_name_approver">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12" style="text-align: center;">
                                <button class="btn btn-success">Export</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>