<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border" style="font-size:20px"><b><i class="fa fa-clipboard"></i> <?= $Title?></b></div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label">
                                        <?php echo gmdate("l, d F Y", time()+60*60*7) ?>
                                    </label>
                                </div>
                                <br>
                                <div class="panel-body box box-info box-solid">
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <p style="margin: 5px 0 20px 0;"><label>Tanggal</label></p>
                                            <p style="margin: 5px 0 20px 0;"><label>Lokasi</label></p>
                                            <p style="margin: 5px 0 20px 0;"><label>IO</label></p>
                                        </div>
                                        <div class="col-md-10">
                                            <p>
                                                <input type="text" class="date form-control" name="slcTglRPL" id="slcTglRPL" style="width: 300px;" autocomplete="off">
                                            </p>
                                            <p>
                                                <select class="form-control select2" name="slcLokasiRPL" id="slcLokasiRPL" style="width: 300px;" required>
                                                    <option value=""></option>
                                                    <option value="TUKSONO">TUKSONO</option>
                                                    <option value="PUSAT">PUSAT</option>
                                                </select>
                                            </p>
                                            <p>
                                                <select class="form-control select2" name="slcIORPL" id="slcIORPL" style="width: 300px;" required>
                                                    <option value="ALL">ALL</option>
                                                    <option value="102">ODM</option>
                                                    <option value="101">OPM</option>
                                                    <option value="124">EXP</option>
                                                </select>
                                            </p>
                                        </div>
                                        <div class="col-md-12 text-center">
                                            <button class="btn btn-success" onclick="SearchRPL()"><i class="fa fa-search"></i> Cari</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="loadingArea" style="display: none;">
                                  <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                                </div>
                                <div id="tb_rpl">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>