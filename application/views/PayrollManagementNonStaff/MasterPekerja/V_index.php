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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/MasterData/TargetBenda');?>">
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
                                <a href="<?php echo site_url('PayrollManagementNonStaff/MasterData/MasterPekerja/import_data/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Import Data" title="Import Data" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-upload fa-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblMasterPekerja" style="font-size:12px;min-width: 100%">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th class="text-center" width="100px">Employee Code</th>
                                                <th class="text-center" width="100px">Employee Name</th>
                                                <th class="text-center" width="50px">Sex</th>
                                                <th class="text-center" width="100px">Address</th>
                                                <th class="text-center" width="100px">Telephone</th>
                                                <th class="text-center" width="100px">Handphone</th>
                                                <th class="text-center" width="100px">Recruited Date</th>
                                                <th class="text-center" width="100px">Start Working</th>
                                                <th class="text-center" width="100px">Section Code</th>
                                                <th class="text-center" width="100px">Section Name</th>
                                                <th class="text-center" width="100px">Resign?</th>
                                                <th class="text-center" width="100px">Resign Date</th>
                                                <th class="text-center" width="150px">New Employee Code</th>
                                                <th class="text-center" width="100px">Worker Status</th>
                                                <th class="text-center" width="100px">Location Code</th>
                                                <th class="text-center" width="100px">Worker Code</th>
											</tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>    
        </div>
    </div>
</section>