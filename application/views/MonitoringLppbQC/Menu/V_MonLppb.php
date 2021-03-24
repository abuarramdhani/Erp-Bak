<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border text-center"><b>Monitoring Lppb</b></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12 text-right">
                                        <label class="control-label"><?php echo date("l/d F Y H:i:s"); ?></label>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label class="control-label">Pilih Status Lppb</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-control select2" data-placeholder="Status Lppb" id="trx_type" name="trx_type">
                                                <?php 
                                                    if ($trx_type == 'BELUM QC'){
                                                        echo '<option value="RECEIVE">BELUM QC</option>';
                                                    }elseif($trx_type == 'ACCEPT') {
                                                        echo '<option value="ACCEPT">ACCEPT</option>';
                                                    }elseif($trx_type == 'REJECT') {
                                                        echo '<option value="REJECT">REJECT</option>';
                                                    }else {
                                                        echo '<option value=""></option>';
                                                    }
                                                ?>
                                                    <option value="RECEIVE">BELUM QC</option>
                                                    <option value="ACCEPT">ACCEPT</option>
                                                    <option value="REJECT">REJECT</option>
                                                </select><br><br>
                                            </div>
                                        </div>
                                        <div class="col-md-6"></div>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <div class="area-mon"></div>
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