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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/QualityControl');?>">
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
                                <a href="<?php echo site_url('ManufacturingOperationUP2L/QualityControl/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                          
                            <form action="<?php echo base_url('ManufacturingOperationUP2L/QualityControl/DownloadSample')?>"  method="post">
                                <button>Adexe</button>
                            </form>
                            <form action="<?php echo base_url('ManufacturingOperationUP2L/QualityControl/CreateLaporan')?>"  method="post">
                                <button>Alifian</button>
                            </form>
                        </div>
                    </div>
                </div>    
            </div>    
        </div>
    </div>
</section>