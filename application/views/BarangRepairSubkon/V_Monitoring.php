<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border" style="font-size:20px"><b>
                                <i class="fa fa-wrench"></i> <?= $Title?></b>
                            </div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label">
                                        <?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?>
                                    </label>
                                </div>
                                <br>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="periode">Periode</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control pull-right periodeBRS" id="periode" name="periode" placeholder="Periode">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="subkon">Nama Subkon</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <select class="form-control getSubkon" id="subkon" name="subkon"></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="panel-body">
                                            <center>
                                                <button type="button" class="btn btn-primary" style="margin-left:25px" onclick="getMonBrgRepair(this)">
                                                    <i class="fa fa-search"></i> Search
                                                </button>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body" id="tbl_monbrgrepair"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>