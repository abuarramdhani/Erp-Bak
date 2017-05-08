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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Potongan');?>">
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
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Potongan/Import') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" class="btn btn-default btn-sm" alt="Import Data" title="Import Data" data-toggle="tooltip" data-placement="left" >
                                    <i class="fa fa-upload fa-2x"></i>
                                </a>
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Potongan/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblPotongan" style="font-size:12px;min-width: 100%">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
                                                <th class="text-center" width="100px">Noind</th>
												<th class="text-center" width="100px">Nama</th>
												<th class="text-center" width="100px">Bulan Gaji</th>
												<th class="text-center" width="100px">Tahun Gaji</th>
												<th class="text-center" width="100px">Pot Lebih Bayar</th>
												<th class="text-center" width="100px">Pot Gp</th>
												<th class="text-center" width="100px">Pot Dl</th>
												<th class="text-center" width="100px">Pot Duka</th>
												<th class="text-center" width="100px">Pot Koperasi</th>
												<th class="text-center" width="100px">Pot Hutang Lain</th>
												<th class="text-center" width="100px">Pot Thp</th>
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