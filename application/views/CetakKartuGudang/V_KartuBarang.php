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
                                <a class="btn btn-default btn-lg"
                                    href="<?php echo site_url('CetakKartuGudang/KartuBarang');?>">
                                    <i class="fa fa-2x fa-file-text-o">
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
                        <div class="box box-primary box-solid">
                            <div class="box-body">
                            <form method="post" target="_blank" class="import_excel" id="import_excel" enctype="multipart/form-data" action="<?php echo base_url('CetakKartuGudang/KartuBarang/Cetak')?>">
                                <div class="panel-body">
                                    <div class="col-md-3">
                                    <label>Ukuran Cetakan : </label>
                                        <select name="size_cetak" class="form-control select2" data-placeholder="pilih ukuran" autocomplete="off">
                                        <option></option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-2">
                                    <label>Masukan File : </label>
                                        <input type="file" name="excel_file" id="excel_file" accept=".csv, .xls,.xlsx" />
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-md btn-success"> Cetak</button>
                                    </div>
                                </div>
                            </form> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


