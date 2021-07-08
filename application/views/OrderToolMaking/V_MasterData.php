<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header">
                                <div class="col-md-6 text-left"><h4 style="font-size:20px;font-weight:bold"><?= $Title?></h4></div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-success" onclick="tambah_proses_otm(this)"><i class="fa fa-2x fa-plus"></i></button>
                                </div>
                            </div>                            
                            <div class="box-body">
                                <div class="panel-body" id="tb_proses_otm"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header">
                                <div class="col-md-6 text-left"><h4 style="font-size:20px;font-weight:bold">Master Data Mesin</h4></div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-success" onclick="tambah_mesin_otm(this)"><i class="fa fa-2x fa-plus"></i></button>
                                </div>
                            </div>                            
                            <div class="box-body">
                                <div class="panel-body" id="tb_mesin_otm"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>