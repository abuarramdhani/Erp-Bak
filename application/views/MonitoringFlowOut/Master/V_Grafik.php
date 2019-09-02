<style>
    .none{
        display: none;
    }
</style>
<input type="hidden" class="hdnPagesMFO" value="1">
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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('MonitoringFlowOut'); ?>">
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
                <div class="col-lg-12">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                            <b style="vertical-align:middle;"><b> Chart Data Flowout </b></b>
                        </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <div class="col-lg-5">
                                    <div class="input-group grpMnth">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="text" class="form-control selectM" id="blnGr" placeholder="Pilih bulan...">
                                    </div> <p id="blnGr2"></p>
                                </div>
                                    <div class="col-lg-1">
                                        <button onclick="getGrafMFO()" id="btnMfo" class="btn btn-success"> <i class="fa fa-paper-plane"></i> Submit </button>
                                        <a href="<?= base_url('MonitoringFlowOut/InternalView/Grafik'); ?>" id="freshGraf" class="btn btn-primary" style="display:none"> <i class="fa fa-refresh"></i> Refresh </a>
                                    </div><br /> <br />
                                <div id="resultGrafMFO" class="none">
                                    <br /> <br />
                                    <b id="txtInternal">Internal</b>
                                    <canvas id="GrafikFlowOutInt" width="700" height="100"></canvas> <p id="chInt"></p> <br />
                                    <b id="txtExternal">External</b>
                                    <canvas id="GrafikFlowOutExt" width="700" height="100"></canvas> <p id="chExt"></p> <br />
                                    <p id="textBlnMFO"></p>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>