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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/MasterData/DataGaji');?>">
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
                                <a href="<?php echo site_url('PayrollManagementNonStaff/MasterData/DataGaji/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add Data" title="Add Data" data-toggle="tooltip" data-placement="left" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                                <a href="<?php echo site_url('PayrollManagementNonStaff/MasterData/DataGaji/import_data/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Import Data" title="Import Data" data-toggle="tooltip" data-placement="left">
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-upload fa-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblMasterGaji" style="font-size:12px;min-width: 100%">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
                                                <th class="text-center" width="100px">Noind</th>
												<th class="text-center" width="100px">Nama</th>
                                                <th class="text-center" width="100px">Kodesie</th>
												<th class="text-center" width="100px">Unit Name</th>
												<th class="text-center" width="100px">Kelas</th>
												<th class="text-center" width="100px">Gaji Pokok</th>
												<th class="text-center" width="100px">Insentif Prestasi</th>
												<th class="text-center" width="100px">Insentif Masuk Sore</th>
												<th class="text-center" width="100px">Insentif Masuk Malam</th>
												<th class="text-center" width="100px">Ubt</th>
												<th class="text-center" width="100px">Upamk</th>
                                                <th class="text-center" width="100px">Bank Code</th>
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