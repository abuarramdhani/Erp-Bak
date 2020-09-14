<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-danger">
                        <div class="box-header">
                            <h2 style="font-weight:bold"><i class="fa fa-pencil"></i> <?= $Title?></h2>
                        </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-1">
                                        <label>Kategori:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="kategori" class="form-control" style="text-transform:uppercase" placeholder="Masukkan Kategori">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn bg-orange" style="margin-left:15px" onclick="saveCategory(this)"><i class="fa fa-plus"></i> Tambah</button>
                                    </div>
                                </div>
                                <div class="panel-body" id="tbl_master_category">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>