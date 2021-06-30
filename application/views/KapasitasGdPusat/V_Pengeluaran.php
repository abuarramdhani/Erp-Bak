<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border" style="font-size:20px"><b><i class="fa fa-share-square-o"></i> <?= $Title?></b></div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label">
                                        <?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?>
                                    </label>
                                </div>
                                <br>
                                <form method="POST" action="<?php echo base_url("KapasitasGdPusat/Pengeluaran/input_data")?>">
                                    <div class="panel-body  box box-info box-solid">
                                        <div class="col-md-12">
                                            <div class="col-md-4 text-center">
                                                <label class="control-label">Subinventory</label>
                                                <!-- <input id="subinv" name="subinv" class="form-control pull-right" placeholder="Subinventory" readonly> -->
                                                <select class="form-control select2" data-placeholder="Pilih Subinventory Terlebih Dahulu" id="subinv" name="subinv">
                                                    <option> </option>
                                                    <option>KOM1-DM</option>
                                                    <option>PNL-DM</option>
                                                    <option>FG-DM</option>
                                                    <option>MAT-PM</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <label>Input Picklist / Bon</label>
                                                <div class="input-group">
                                                    <input id="no_dokumen" name="no_dokumen" class="form-control">
                                                    <span class="input-group-btn">
                                                        <button type="button" onclick="cekPengeluaranKGP(this)" class="btn btn-primary"> <i class="fa fa-search"></i></button>    
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="panel-body" id="tb_pengeluaran"></div>
                                    </div>
                                </form>

                                <div class="panel-body" id="tb_data_pengeluaran"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>