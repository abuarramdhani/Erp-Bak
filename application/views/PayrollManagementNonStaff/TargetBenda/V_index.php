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
                                <a href="<?php echo site_url('PayrollManagementNonStaff/MasterData/TargetBenda/doClearData/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Empty Data" title="Empty Data" onclick="return confirm('Apakah anda yakin ingin mengkosongkan data ini ?')">
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash fa-2x"></i></button>
                                </a>
                                <a href="<?php echo site_url('PayrollManagementNonStaff/MasterData/TargetBenda/create/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New Data" title="Add New Data" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                                <a href="<?php echo site_url('PayrollManagementNonStaff/MasterData/TargetBenda/import_data/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Import Data" title="Import Data" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-upload fa-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblTargetBenda" style="font-size:12px;min-width: 100%">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
                                                <th class="text-center" width="100px">Kodesie</th>
												<th class="text-center" width="100px">Nama Unit</th>
												<th class="text-center" width="100px">Kode Barang</th>
												<th class="text-center" width="100px">Nama Barang</th>
												<th class="text-center" width="100px">Kode Proses</th>
												<th class="text-center" width="100px">Nama Proses</th>
												<th class="text-center" width="100px">Jumlah Operator</th>
                                                <th class="text-center" width="150px">Target Utama Senin Kamis</th>
                                                <th class="text-center" width="150px">Target Utama Senin Kamis 4</th>
                                                <th class="text-center" width="200px">Target Sementara Senin Kamis</th>
                                                <th class="text-center" width="150px">Target Utama Jumat Sabtu</th>
                                                <th class="text-center" width="160px">Target Utama Jumat Sabtu 4</th>
                                                <th class="text-center" width="200px">Target Sementara Jumat Sabtu</th>
												<th class="text-center" width="100px">Waktu Setting</th>
												<th class="text-center" width="100px">Tgl Berlaku</th>
												<th class="text-center" width="100px">Tgl Input</th>
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