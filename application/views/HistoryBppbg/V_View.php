<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border" style="font-size:20px"><b><i class="fa fa-history"></i> <?= $Title?></b></div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label">
                                        <?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?>
                                    </label>
                                </div>
                                <br>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="col-md-4 text-center">
                                            <label>Input Bppbg</label>
                                            <div class="input-group">
                                                <input id="bppbg" name="bppbg" class="form-control" >
                                                <span class="input-group-btn">
                                                    <button type="button" onclick="cekBppbgHB(this)" class="btn btn-primary"> <i class="fa fa-search"></i></button>    
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body" id="tb_view"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>