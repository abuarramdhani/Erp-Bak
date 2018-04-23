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
                                        Add master Induk
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperation/MasterItem');?>">
                                    <i aria-hidden="true" class="fa fa-line-chart fa-2x">
                                    </i>
                                    <span>
                                        <br/>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                Add Master Induk
                            </div>

                            <div class="panel-body">
                            <ul class="nav nav-tabs">
                            </ul>
                            <div class="col-md-12 tab-content" style="padding-top:2em">
                                <div id="1" class="tab-pane fade in active">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url('ManufacturingOperation/ProductionObstacles/master/submitInduk'); ?>">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Hambatan:</label>
                                                <select id="hambatan" class="form-control select2" name="slc_hambatan" data-placeholder="Pilih Cetakan">
                                                    <option></option>
                                                    <option value="mesin">Mesin</option>
                                                    <option value="non-mesin">Non Mesin</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Cetakan:</label>
                                                <select class="form-control select2" name="slc_cetakan" data-placeholder="Pilih Cetakan">
                                                    <option></option>
                                                    <option value="logam">Logam</option>
                                                    <option value="inti">Inti</option>
                                                </select>
                                            </div>
                                            <div id="slc_kategori" class="form-group">
                                                <label>Kategori:</label>
                                                <select class="form-control select2" name="slc_kategori" data-placeholder="Pilih Kategori">
                                                    <option></option>
                                                    <option value="umum">Umum</option>
                                                    <option value="permesin">Per Mesin</option>
                                                </select>
                                            </div>
                                            <div id="input-containerLogam" style="padding-bottom: 10px">
                                                <label>Kode Induk</label>
                                                <div id="containerLogam" class="input-group">
                                                    <input type="text" name="txt_induk[]" class="form-control" placeholder="Input Induk" required>
                                                    <div class="input-group-btn">
                                                        <a class="btn btn-default" id="addNewInduk">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                        <a class="btn btn-default" id="removeNewInduk" style="display: none">
                                                            <i class="fa fa-minus"></i>
                                                        </a>
                                                    </div>  
                                                </div>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-success">Submit</button>
                                            <a class="btn btn-warning" href="<?php echo base_url('ManufacturingOperation/ProductionObstacles/master/induk')?>">Back</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>