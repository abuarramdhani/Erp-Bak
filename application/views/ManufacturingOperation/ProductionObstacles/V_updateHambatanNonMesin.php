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
                                        Update Data Hambatan
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
                                Edit Hambatan Non Mesin
                            </div>
                            <div class="panel-body">
                                <form method="post" action="<?php echo base_url('ManufacturingOperation/ProductionObstacles/Hambatan/non-mesin/submitUpdate') ?>">
                                <?php foreach ($edtHam as $h) { ?>
                                    <div class="form-group">
                                        <label>Cetak :</label>
                                        <select id="typeCetakan" class="form-control select2" name="typeHambatan" data-placeholder="Pilih Cetakan" required>
                                        <?php 
                                            if ($h['cetak']=='logam') {
                                                $logam = 'selected';
                                                $inti = '';
                                            }elseif ($h['cetak']=='inti') {
                                                $logam = '';
                                                $inti = 'selected';
                                            }
                                        ?>
                                            <option></option>
                                            <option value="logam" <?php echo $logam ?>>Logam</option>
                                            <option value="inti" <?php echo $inti ?>>Inti</option>
                                        </select>
                                        <input type="hidden" name="kategori" id="kategori" value="non-mesin">

                                    </div>
                                    <div class="form-group">
                                        <label>Induk :</label>
                                        <select id="slc_updtInduk" class="form-control select2" name="slc_induk" data-placeholder="Pilih Induk" required>
                                            <option value="<?php echo $h['induk_id'] ?>" selected><?php echo $h['induk'];?></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Cabang :</label>
                                        <select id="slc_updtCabang" class="form-control select2" name="slc_cabang" data-placeholder="Pilih Cabang" >
                                            <option value="<?php echo $h['cabang'] ?>" selected><?php echo $h['cabang'];?></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6" style="padding-left:0px;padding-right: 5px">
                                        <label>Mulai :</label>
                                        <input class="form-control date-picker" type="text" name="tgl_mulai" value="<?php echo $h['mulai'] ?>" required>
                                    </div>
                                    <div class="form-group col-md-6" style="padding-right:0px">
                                        <label>Selesai :</label>
                                        <input class="form-control date-picker" type="text" name="tgl_selesai" value="<?php echo $h['selesai'] ?>" required>
                                        <input type="hidden" name="idHambatan" value="<?php echo $h['id'] ?>">
                                    </div>
                                    <button class="btn btn-success">Submit</button>
                                    <a class="btn btn-warning" href="<?php echo base_url('ManufacturingOperation/ProductionObstacles/Hambatan/non-mesin/') ?>">Cancel</a>
                                    <?php }?>
                                </form>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>