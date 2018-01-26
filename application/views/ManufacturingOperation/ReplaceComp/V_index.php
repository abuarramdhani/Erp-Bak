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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperation/Job/ReplaceComp');?>">
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
                                Job Data
                            </div>
                            <div class="box-body">
                                <form method="post" class="form-horizontal" onsubmit="getJobData(this)">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" name="jobCode" class="form-control toupper" placeholder="Job Code">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="startDate" class="form-control time-form" placeholder="Start Date">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="endDate" class="form-control time-form" placeholder="End Date">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="submit" class="btn btn-block">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <br>
                                <div class="row">
                                    <div class="col-md-12 text-center" id="jobTableArea"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>    
        </div>
    </div>
</section>