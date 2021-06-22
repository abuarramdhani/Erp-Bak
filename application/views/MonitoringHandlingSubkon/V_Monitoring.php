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
                                            <p style="margin: 5px 0 20px 0;"><label>Nama Subkon</label></p>
                                            <p style="margin: 5px 0 20px 0;"><label>Jenis Handling</label></p>
                                            <p style="margin: 5px 0 20px 0;"><label>Tanggal</label></p>
                                            <p style="margin: 5px 0 5px 0;"><label>Status</label></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p>
                                                <select class="form-control select2 jenisSub" name="slcJenisSub" id="slcJenisSub" style="width: 450px;" required>
                                                  <option></option>
                                                </select>
                                            </p>
                                            <p>
                                                <select class="form-control select2 jenisHS" name="slcHandling" id="slcHandling" style="width: 450px;" required>
                                                  <option></option>
                                                </select>
                                            </p>
                                            <p>
                                                <input type="text" class="date form-control" name="slcDateRange" id="slcDateRange" autocomplete="off">
                                            </p>
                                            <p>
                                                <select class="form-control select2" name="slcType" id="slcType" style="width: 150px;" required>
                                                    <option value="ALL">ALL</option>
                                                    <option value="IN">IN KHS</option>
                                                    <option value="OUT">OUT KHS</option>
                                                </select>
                                            </p>
                                            <button type="button" class="btn btn-primary" style="float: right;" onclick="cariHS()">
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