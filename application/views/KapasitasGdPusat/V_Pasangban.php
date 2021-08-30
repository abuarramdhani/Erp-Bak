<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border" style="font-size:25px"><b><i class="fa fa-support"></i> <?= $Title?></b></div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label"><?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?></label>
                                </div>
                                <br>
                                <div class="panel-body">
                                    <div class="col-md-12 text-center">
                                        <div class="col-md-6">
                                            <h3><label class="control-label">Jenis Ban</label></h3>
                                            <select class="form-control select2 jenis_ban" data-placeholder="Pilih Jenis Ban" id="jenis_ban" name="jenis_ban">
                                                <option value=""> </option>
                                                <option value="RUBBER TIRE RING 12 SUB GROUP (VULKANISIR / GRAN PRINX / GP)">RUBBER TIRE RING 12 SUB GROUP (VULKANISIR / GRAN PRINX / GP)</option>
                                                <option value="RUBBER TIRE RING 12 SUB GROUP (NON VULKANISIR / NV / PRIMEX)">RUBBER TIRE RING 12 SUB GROUP (NON VULKANISIR / NV / PRIMEX)</option>
                                                <option value="RUBBER TIRE RING 13 SUB GROUP (VULKANISIR / GRAN PRINX / GP)">RUBBER TIRE RING 13 SUB GROUP (VULKANISIR / GRAN PRINX / GP)</option>
                                                <option value="RUBBER TIRE RING 13 SUB GROUP (NON VULKANISIR / NV / PRIMEX)">RUBBER TIRE RING 13 SUB GROUP (NON VULKANISIR / NV / PRIMEX)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <h3>TARGET</h3>
                                            <h3 style="font-weight:bold">80 SET/LINE</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body  box box-info box-solid">
                                    <div class="col-md-12 text-center">
                                        <h3>PERSIAPAN</h3>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-9" id="persiapan_line1"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-9" id="persiapan_line2"></div>
                                    </div>
                                </div>
                                <div class="panel-body  box box-success box-solid">
                                    <div class="col-md-12 text-center">
                                        <h3>PASANG BAN</h3>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-9" id="pasang_line1"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-9" id="pasang_line2"></div>
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