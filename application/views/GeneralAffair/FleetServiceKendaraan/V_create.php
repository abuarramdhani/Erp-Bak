<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('GeneralAffair/FleetServiceKendaraan/before_create');?>" class="form-horizontal" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/FleetServiceKendaraan/');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <span ><br /></span>
                                    </a>                             
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Create Service Kendaraan</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="txtMerkKendaraan" class="control-label col-lg-4">Kendaraan</label>
                                                <div class="col-lg-4">
                                                    <select name="txtMerkKendaraan" id="txtMerkKendaraan" class="form-control"></select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="jenis_service" class="control-label col-lg-4">Jenis Service</label>
                                                <div class="col-lg-4">
                                                    <select id="jenis_service" name="jenis_service" class="form-control" required="">
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <div class="col-lg-3">
                                                    
                                                </div>
                                                <div class="col-lg-6" style="border: 1px solid black;padding: 10px;">
                                                    <div class="row">
                                                        <div class="col-sm-2" style="padding-top: 6px;">
                                                            <label>Start</label>
                                                        </div>
                                                        <div class="col-sm-2" style="margin-left: -20px;">
                                                            <input class="form-control" name="jarak_awal" id="jarak_awal"></input>
                                                        </div>
                                                        <div class="col-sm-2" style="padding-top: 6px;margin-left: -20px;">
                                                            <label>Kilometer;</label>
                                                        </div> 
                                                        <div class="col-sm-2" style="padding-top: 6px;margin-left: 25px;">
                                                            <label>Kelipatan</label>
                                                        </div>
                                                        <div class="col-sm-2" style="margin-left: 12px;">
                                                            <input class="form-control" name="kelipatan_jarak" id="kelipatan_jarak"></input>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-sm-2" style="padding-top: 6px;">
                                                            <label>Start</label>
                                                        </div>
                                                        <div class="col-sm-2" style="margin-left: -20px;">
                                                            <input class="form-control" name="lama_awal" id="lama_awal"></input>
                                                        </div>
                                                        <div class="col-sm-2" style="padding-top: 6px;margin-left: -20px;">
                                                            <label>bulan;</label>
                                                        </div> 
                                                        <div class="col-sm-2" style="padding-top: 6px;margin-left: 25px;">
                                                            <label>Kelipatan</label>
                                                        </div>
                                                        <div class="col-sm-2" style="margin-left: 12px;">
                                                            <input class="form-control" name="kelipatan_waktu" id="kelipatan_waktu"></input>
                                                        </div>
                                                        
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-sm-1"></div>
                                                        <div class="col-sm-3" style="padding-top: 6px;margin-left: -30px;">
                                                            <label>jumlah Input</label>
                                                        </div>
                                                        <div class="col-sm-2" style="margin-left: -10px;">
                                                            <input class="form-control" name="batas_lama" id="batas_lama"></input>
                                                        </div>
                                                        <div class="col-sm-6 text-right" style="padding-right: 30px;">
                                                             <button type="submit" id="create_form" class="btn btn-default btn-sm">Create Form</button>
                                                        </div>
                                                       
                                                    </div>
                                                </div>
                                            </div>

											

                                        </div>

                                        <div class="col-lg-12">
                                            <br />
                                            <br />
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
                                                    </ul>
                                                    <div class="tab-content">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="panel-footer">
                                        <div class="row text-right">
                                            <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>