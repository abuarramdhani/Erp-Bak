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
                                        Update master Induk
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
                                Update Master Induk
                            </div>

                            <div class="panel-body">
                            <div class="col-md-12 tab-content" style="padding-top:2em">
                                <div id="1" class="tab-pane fade in active">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url('ManufacturingOperation/ProductionObstacles/master/saveUpdateInduk'); ?>">
                                        <div class="col-md-6">
                                        <?php foreach ($dataInd as $ind) {?>
                                            <div class="form-group">
                                                <label>Hambatan:</label>
                                                <select id="hambatan" class="form-control select2" name="slc_hambatan" data-placeholder="Pilih Cetakan">
                                                    <option></option>
                                                    <?php if ($ind['hambatan']=='mesin') {
                                                        $mesin='selected';
                                                        $non='';
                                                    }else{
                                                        $non='selected';
                                                        $mesin='';
                                                        } ?>
                                                    <option value="mesin" <?php echo $mesin?> >Mesin</option>
                                                    <option value="non-mesin" <?php echo $non?> >Non Mesin</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Cetakan:</label>
                                                <select class="form-control select2" name="slc_cetakan" data-placeholder="Pilih Cetakan">
                                                    <option></option>
                                                    <?php if ($ind['cetak']=='logam') {
                                                        $logam='selected';
                                                        $inti='';
                                                    }else{
                                                        $logam='';
                                                        $inti='selected';
                                                        } ?>
                                                    <option value="logam" <?php echo $logam; ?>>Logam</option>
                                                    <option value="inti"<?php echo $inti; ?>>Inti</option>
                                                </select>
                                            </div>
                                            <div id="slc_kategori" class="form-group">
                                                <label>Kategori:</label>
                                                <select class="form-control select2" name="slc_kategori" data-placeholder="Pilih Kategori">
                                                    <option></option>
                                                    <?php if ($ind['kategori']=='umum') {
                                                        $umum='selected';
                                                        $per='';
                                                    }elseif($ind['kategori']=='permesin'){
                                                        $umum='';
                                                        $per='selected';
                                                    }else{
                                                        $umum='';
                                                        $per='';
                                                            } ?>
                                                    <option value="umum" <?php echo $umum; ?> >Umum</option>
                                                    <option value="permesin" <?php echo $per; ?>>Per Mesin</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Induk:</label>
                                                <input type="text" name="txt_induk" class="form-control" placeholder="Input Induk" value="<?php echo $ind['induk'] ?>" required>
                                                <input type="hidden" name="txt_idInduk" value="<?php echo $ind['id'] ?>">
                                            </div>
                                                    
                                        <?php } ?>
                                            
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