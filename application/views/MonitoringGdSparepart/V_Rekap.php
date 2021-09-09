<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
<script>
    $(document).ready(function () {            
        $('.datepicktgl').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            autoclose: true
        });
    });
</script>

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
                                        <?= $Title ?> 
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg"
                                    href="<?php echo site_url('MonitoringGdSparepart/Monitoring/');?>">
                                    <i class="icon-wrench icon-2x">
                                    </i>
                                    <span>
                                        <br />
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"><b>Rekap</b></div>

                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12 text-right">
                                      <label class="control-label"><?php echo date("l, d F Y") ?></label>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <label class="control-label">Subinventory</label>
                                            <select class="form-control select2" data-placeholder="Pilih Subinventory Terlebih Dahulu" id="subinventory" name="subinventory" onchange="getRekap(this)">
                                                <option> </option>
                                                <option>SP-YSP</option>
                                                <option>KOM1-DM</option>
                                                <option>PNL-DM</option>
                                                <option>FG-DM</option>
                                                <option>MAT-PM</option>
                                            </select>
                                            <!-- <input id="subinventory" name="subinventory" class="form-control pull-right" placeholder="Subinventory" readonly> -->
                                        </div>
                                        <div class="col-md-3">
                                            <label class="text-right">Tanggal Awal</label>
                                            <input id="tglAwal" name="tglAwal" class="form-control pull-right datepicktgl" placeholder="yyyy-mm-dd" autocomplete="off">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="text-right">Tanggal Akhir</label>
                                            <div class="input-group">
                                            <input id="tglAkhir" name="tglAkhir" class="form-control pull-right datepicktgl" placeholder="yyyy-mm-dd" autocomplete="off">
                                            <span class="input-group-btn">
                                                <button type="button" onclick="schRekapMGS(this)" class="btn btn-flat" style="background:inherit; text-align:left;padding:0px;padding-left:10px;"><i class="fa fa-2x fa-arrow-circle-right" ></i></button>    
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form method="post" action="<?= base_url('MonitoringGdSparepart/Rekap/exportRekap'); ?>">
                                    <div class="panel-body" id="tb_RkpMGS">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
