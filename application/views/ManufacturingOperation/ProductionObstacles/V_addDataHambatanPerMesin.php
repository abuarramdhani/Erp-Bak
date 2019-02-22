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
                                        Add Data Hambatan
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
                                Hambatan Per Mesin
                            </div>
                            <div class="panel-body">
                                <form method="post" action="<?php echo base_url('ManufacturingOperation/ProductionObstacles/Hambatan/mesin/submitHambatanPerMesin') ?>">
                                    <div class="form-group">
                                        <label>Cetak :</label>
                                        <select id="typeCetakan" class="form-control select2" name="typeHambatan" data-placeholder="Pilih Cetakan" required>
                                            <option></option>
                                            <option value="logam">Logam</option>
                                            <option value="inti">Inti</option>
                                        </select>
                                        <input type="hidden" name="kategori" id="kategori" value="permesin">
                                    </div>
                                    <div class="form-group">
                                        <label>Induk :</label>
                                        <select id="slc_indukUmumLogam" class="form-control select2" name="slc_induk" data-placeholder="Pilih Induk" required>
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Cabang :</label>
                                        <select id="slc_cabangUmumLogam" class="form-control select2" name="slc_cabang" data-placeholder="Pilih Cabang" >
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6" style="padding-left:0px;padding-right: 5px">
                                        <label>Mulai :</label>
                                        <input class="form-control date-picker" type="text" name="tgl_mulai" required>
                                    </div>
                                    <div class="form-group col-md-6" style="padding-right:0px">
                                        <label>Selesai :</label>
                                        <input class="form-control date-picker" type="text" name="tgl_selesai" required>
                                        <!-- <input type="hidden" name="typeHambatan" value="logam"> -->
                                    </div>
                                    <button class="btn btn-success">Submit</button>
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