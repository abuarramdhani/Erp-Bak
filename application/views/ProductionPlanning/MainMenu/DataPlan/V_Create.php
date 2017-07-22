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
                                        Input Data Plans
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ProductionPlanning/DataPlan');?>">
                                    <i aria-hidden="true" class="fa fa-line-chart fa-2x">
                                    </i>
                                    <span>
                                        <br/>
                                    </span>
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
                                Create New Plans
                            </div>
                            <div class="panel-body">
                                <form method="post" action="<?php echo base_url('ProductionPlanning/DataPlan/Create'); ?>">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <h2><b>UPLOAD FILE EXCEL</b></h2>
                                            <p>-- Klik button download to download sample format data plans --</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <a class="btn btn-default" href="<?php echo base_url('ProductionPlanning/DataPlan/DownloadSample');?>">
                                                <i aria-hidden="true" class="fa fa-download"></i> DOWNLOAD SAMPLE
                                            </a>
                                            <br><br>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-bottom: 50px;"> 
                                        <div class="col-md-12">
                                            <select class="form-control select2" name="section">
                                                <?php foreach ($section as $s) { ?>
                                                    <option value="<?php echo $s['section_id']; ?>"> <?php echo $s['section_name']; ?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-7 col-md-offset-2">
                                            <input type="file" name="dataPlan" class="form-control" required>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i aria-hidden="true" class="fa fa-upload"></i> UPLOAD
                                            </button>
                                        </div>
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