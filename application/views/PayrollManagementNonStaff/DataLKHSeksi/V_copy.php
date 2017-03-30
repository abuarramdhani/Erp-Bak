<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataLKHSeksi');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
          
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title"><?= $Title ?></h3>
                            </div>
                            <div class="box-body">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">
                                            Server
                                        </label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <input type="text" id="txtServer" name="txtServer" value="192.168.6.20" class="form-control" placeholder="192.168.6.20" readonly>
                                                <span class="input-group-btn">
                                                    <button id="btnCheckServer" class="btn btn-primary" type="button">Check Server</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-1" id="server-status">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">
                                            Pilih Periode
                                        </label>
                                        <div class="col-lg-2">
                                            <input type="text" name="txtBulan" class="form-control" placeholder="Bulan">
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="text" name="txtTahun" class="form-control" placeholder="Tahun">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-6 col-sm-2">
                                            <button type="submit" class="btn btn-primary btn-block" style="float: right;">Download</button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-8">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;">
                                                    0%
                                                </div>
                                            </div>

                                        </div>
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