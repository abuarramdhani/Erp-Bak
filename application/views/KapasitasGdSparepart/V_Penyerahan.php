<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     <script>
         $(document).ready(function () {
            $('.tbltrack').dataTable({
                "scrollX": true,
            });
            $('.datepicktgl').datepicker({
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                autoClose: true
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
                                    href="<?php echo site_url('MonitoringPelayananSPB/Penyerahan/');?>">
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
                        <div class="box box-primary">
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label"><?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?></label>
                                </div>
                                <br>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="col-md-1">
                                            <label>Tanggal :</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="tglAwal" name="tglAwal[]" class="form-control pull-right datepicktgl" placeholder="masukkan tanggal" autocomplete="off">
                                        </div>
                                        <button type="button" class="btn btn-primary" onclick="getDataPenyerahan(this)"><i class="fa fa-search"></i> Find</button>    
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div id="tb_penyerahan"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
