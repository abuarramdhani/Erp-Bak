<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                        <div class="box-header">
                            <h2 style="font-weight:bold"><i class="fa fa-pencil"></i> <?= $Title?></h2>
                        </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-1">
                                        <label>Kategori:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <select id="kategori" class="form-control select2" style="width:100%" data-placeholder="Kategori">
                                            <option></option>
                                            <?php foreach ($kategori as $key => $val) { ?>
                                            <option value="<?= $val['CATEGORY_NAME']?>"><?= $val['CATEGORY_NAME']?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-info" style="margin-left:15px" onclick="schItemList(this)"><i class="fa fa-search"></i> View</button>
                                    </div>
                                </div>
                                <div class="panel-body" id="tbl_item_produksi">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>