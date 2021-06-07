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
                                        </div>
                                        <div class="col-md-5">
                                            <p>
                                                <select class="form-control select2 subkon" name="slcSubkon" id="slcSubkon" style="width: 450px;" required>
                                                  <option></option>
                                                </select>
                                            </p>
                                            <a id="linkCetak" target="_blank" class="btn btn-primary" style="float: right;" onclick="cetak()">
                                                <i class="fa fa-file-pdf-o"> Cetak</i>
                                            </a>
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