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
                                        Input Daily Plans
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ProductionPlanning/DataPlanDaily');?>">
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
                            <div class="box-body">
                                <?php echo $message; ?>
                                <form enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo base_url('ProductionPlanning/DataPlanDaily/CreateSubmit'); ?>">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <h2><b>UPLOAD FILE EXCEL</b></h2>
                                            <p>-- Klik button download to download sample format data plans --</p>
                                        </div>
                                    </div>
                                    <div class="row"> 
                                        <div class="form-group">
                                            <label class="control-label col-md-3" for="dp2">Section</label>
                                            <div class="col-md-7">
                                                <select class="form-control select4" name="section" required="">
                                                    <option></option>
                                                    <?php foreach ($section as $s) { ?>
                                                        <option value="<?php echo $s['section_id']; ?>"> <?php echo $s['section_name']; ?> </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3" for="dp2">Data Plan</label>
                                            <div class="col-lg-7">
                                                <input type="file" name="dataPlan" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <div class="row text-right">
                                        <div class="col-md-12">
                                            <a class="btn btn-default" href="<?php echo base_url('ProductionPlanning/DataPlanDaily');?>">
                                                CANCEL
                                            </a>
                                            <a class="btn btn-warning" href="<?php echo base_url('ProductionPlanning/DataPlanDaily/DownloadSample');?>">
                                                <i aria-hidden="true" class="fa fa-download"></i> DOWNLOAD SAMPLE
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i aria-hidden="true" class="fa fa-upload"></i> UPLOAD PLANS
                                            </button>
                                        </div>
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