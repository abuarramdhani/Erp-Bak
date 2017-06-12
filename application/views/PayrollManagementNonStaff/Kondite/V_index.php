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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Kondite');?>">
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
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Kondite/clear_data/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Kosongkan Data" title="Kosongkan Data" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash fa-2x"></i></button>
                                </a>
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Kondite/Import') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" class="btn btn-default btn-sm" alt="Import Data" title="Import Data" data-toggle="tooltip" data-placement="left" >
                                    <i class="fa fa-upload fa-2x"></i>
                                </a>
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Kondite/create/seksi') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" class="btn btn-default btn-sm" alt="Input Per Seksi" title="Input Per Seksi" data-toggle="tooltip" data-placement="left" >
                                    <i class="fa fa-users fa-2x"></i>
                                </a>
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Kondite/create/pekerja') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" class="btn btn-default btn-sm" alt="Input Per Pekerja" title="Input Per Pekerja" data-toggle="tooltip" data-placement="left" >
                                    <i class="fa fa-user-plus fa-2x"></i>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblKondite" style="font-size:12px;min-width: 100%">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
                                                <th class="text-center" width="100px">Noind</th>
                                                <th class="text-center" width="100px">Nama</th>
                                                <th class="text-center" width="100px">Kodesie</th>
												<th class="text-center" width="100px">Nama Unit</th>
												<th class="text-center" width="100px">Tanggal</th>
												<th class="text-center" width="100px">MK</th>
												<th class="text-center" width="100px">BKI</th>
												<th class="text-center" width="100px">BKP</th>
												<th class="text-center" width="100px">TKP</th>
												<th class="text-center" width="100px">KB</th>
												<th class="text-center" width="100px">KK</th>
												<th class="text-center" width="100px">KS</th>
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