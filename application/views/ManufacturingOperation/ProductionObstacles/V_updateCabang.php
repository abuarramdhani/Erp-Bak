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
                                        Edit master Cabang
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
                                Edit Master Cabang
                            </div>

                            <div class="panel-body">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#1">Cetak Logam</a></li>
                            </ul>
                            <div class="col-md-12 tab-content" style="padding-top:2em">
                                <div id="1" class="tab-pane fade in active">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url('ManufacturingOperation/ProductionObstacles/master/saveUpdateCabang'); ?>">
                                        <div class="col-md-6">
                                            <?php foreach ($dataCbg as $cbg) { ?>
                                            <div class="form-group">
                                                <label>Induk:</label>
                                                <select id="slcIndukCabang" class="form-control select2" name="slcInduk" data-placeholder="Pilih induk">
                                                    <option value="<?php echo $cbg['induk_id'] ?>" selected><?php echo $cbg['induk'];?></option>
                                                </select>
                                            </div>
                                            <div class="form-group" style="padding-bottom: 10px">
                                                <label>Cabang:</label>
                                                <input type="text" name="txt_cabang" class="form-control" placeholder="Input Cabang" value="<?php echo $cbg['cabang']?>" required>
                                                <input type="hidden" name="txt_idCabang" value="<?php echo $cbg['id']?>">
                                            </div>

                                            <?php } ?>
                                            <input type="hidden" name="txt_typeCabang" value="logam">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                            <a class="btn btn-warning" href="<?php echo base_url('ManufacturingOperation/ProductionObstacles/master/cabang')?>">Back</a>
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