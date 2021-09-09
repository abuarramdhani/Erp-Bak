<input type="hidden" id="punyaManifest" value="1">
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
                                <div class="panel-body">
                                        <!-- <div class="row">
                                            <div class="col-md-2">
                                                <label style="padding-top: 5px;">Scan SPB/DOSP :</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" id="inputSPBMan" class="form-control" style="width: 80%;" onkeyup="inputManifest(event,this)" autofocus>
                                            </div>
                                        </div> -->
                                        <!-- <div class="row">
                                            <div class="col-md-5">

                                            </div>
                                        </div> -->
                                    <div class="nav-tabs-custom">
                                      <ul class="nav nav-tabs pull-right" style="border:none">
                                        <li style="vertical-align:middle"><label class="control-label"><?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?></label></li>
                                        <li class="pull-left"><label style="padding-top: 5px;">Ekspedisi :</label></li>
                                        <li class="pull-left ml-3"> <select id="jenisEksped" name="eksped" class="eksped " style="float:left;width:200px"  required><option></option></select> </li>
                                        <li class="pull-left ml-2"><button type="button" class="btn btn-primary" style="float: left;" onclick="manifest()"><i class="fa fa-search"></i> Find</button></li>
                                      </ul>
                                      <br>
                                    </div>
                                    <h3 class="text-bold"> <i class="fa fa-cube"></i>  Penyerahan</h3>
                                    <div id="loadingAreaPenyerahan" style="display:none;">
                                        <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                                    </div>
                                    <div class="table_penyerahan">

                                    </div>
                                    <br><br>
                                    <hr>
                                    <h3 class="text-bold"> <i class="fa fa-dropbox"></i>Sudah Penyerahan</h3>

                                    <div id="loadingAreaSdhPenyerahan" style="display:none;">
                                        <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                                    </div>
                                    <div class="table_sudah_penyerahan">

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
