<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border" style="font-size:20px"><b><i class="fa fa-television"></i> <?= $Title?></b></div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label">
                                        <?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?>
                                    </label>
                                </div>
                                <br>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <p style="margin: 5px 0 20px 0;"><label>Subinventory</label></p>
                                            <p style="margin: 5px 0 20px 0;"><label>Item</label></p>
                                            <p style="margin: 5px 0 5px 0;"><label>Status</label></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p>
                                                <select class="form-control select2 subinv" name="slcSubinv" id="slcSubinv" style="width: 200px;" required>
                                                  <option></option>
                                                </select>
                                            </p>
                                            <p>
                                                <select class="form-control select2 item" name="slcItem" id="slcItem" style="width: 700px;" required>
                                                  <option></option>
                                                </select>
                                            </p>
                                            <p>
                                                <select class="form-control select2" name="slcStatus" id="slcStatus" style="width: 200px;" required>
                                                    <option value="SEMUA">SEMUA</option>
                                                    <option value="Y">SUDAH TRANSACT</option>
                                                    <option value="N">BELUM TRANSACT</option>
                                                </select>
                                            </p>
                                            <button type="button" class="btn btn-primary" style="float: right;" onclick="cari()">
                                                <i class="fa fa-search"></i> Cari
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="loadingArea" style="display: none;">
                                  <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                                </div>
                                <div id="tb_monitoring">
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>