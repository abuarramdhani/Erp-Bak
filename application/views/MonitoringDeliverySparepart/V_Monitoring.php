<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
    <script>
         $(document).ready(function () {
            $('.datepickbln').datepicker({
                format: 'M yyyy',
                todayHighlight: true,
                viewMode: "months",
                minViewMode: "months",
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
                                    href="<?php echo site_url('MonitoringDeliverySparepart/Monitoring/');?>">
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
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="col-md-5 text-right">
                                            <label class="control-label">Periode</label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                            <input id="period" name="period" class="form-control datepickbln" placeholder="mm/yyyy" autocomplete="off">
                                            <input type="hidden" id="dept" value="<?= $hak[0]['deptclass']?>">
                                            <span class="input-group-btn">
                                                <button type="button" onclick="schMonitoring(this)" class="btn btn-flat" style="background:inherit; text-align:left;padding:0px;padding-left:10px;"><i class="fa fa-2x fa-arrow-circle-right" ></i></button>    
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body" id="tb_monitoring">
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


