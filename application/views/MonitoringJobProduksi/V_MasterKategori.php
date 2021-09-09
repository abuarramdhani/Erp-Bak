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
                                    <div class="col-md-4 text-right">
                                        <label>Kategori:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="kategori" class="form-control" style="text-transform:uppercase" placeholder="Masukkan Kategori">
                                    </div>
                                </div>
                                <div class="panel-body" id="tambah_subkategori">
                                    <div class="col-md-4 text-right">
                                        <label>SubKategori:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="sub_kategori" name="sub_kategori[]" class="form-control" style="text-transform:uppercase" placeholder="Masukkan SubKategori">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn bg-default" style="margin-left:15px" onclick="tmb_subkategori()"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12 text-center">
                                        <button type="button" class="btn bg-orange" style="margin-left:15px" onclick="saveCategory(this)"><i class="fa fa-plus"></i> Tambah</button>
                                    </div>
                                </div>
                                <div class="panel-body" id="tbl_master_category">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="row">
                    <div class="col-md-12">
                        <div class="box box-warning">
                        <div class="box-header">
                            <h2 style="font-weight:bold"><i class="fa fa-pencil"></i> Data Master Quantity Item</h2>
                        </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-4 text-right">
                                        <label>Kode Item:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <select id="kode_item" class="form-control select2 getitemqty" data-placeholder="Pilih Kode Item"></select>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-4 text-right">
                                        <label>Quantity:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" id="qty_item" class="form-control" placeholder="Masukkan Quantity">
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12 text-center">
                                        <button type="button" class="btn bg-orange" style="margin-left:15px" onclick="saveQuantityItem(this)"><i class="fa fa-plus"></i> Tambah</button>
                                    </div>
                                </div>
                                <div class="panel-body" id="tbl_master_quantity">
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</section>


<form method="post">
<div class="modal fade" id="mdl_masterctgr" role="dialog">
    <div class="modal-dialog" style="padding-left:5px;width:60%">
      <!-- Modal content-->
      <div class="modal-content" style="border-radius:10px">
        <div id="data_masterctgr"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
</form>