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
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataLKHSeksi/clear_data/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Kosongkan Data" title="Kosongkan Data" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash fa-2x"></i></button>
                                </a>
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataLKHSeksi/import_data/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Import Data" title="Import Data" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-upload fa-2x"></i></button>
                                </a>
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataLKHSeksi/import_data/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Tambah Data" title="Tambah Data" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataLKHSeksi/download_data/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Download Data From Database" title="Download Data From Database" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-database fa-2x"></i></button>
                                </a>
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataLKHSeksi/chart_ott/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Download Data as Graph" title="Download Grafik Ott" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-file-pdf-o fa-2x"></i></button>
                                </a>
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataLKHSeksi/cek_data_lkh/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Cek Data LKH" title="Cek Data LKH" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-adjust fa-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblDataLKHSeksi" style="font-size:12px;min-width: 100%">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th class="text-center" width="100px">Tanggal</th>
                                                <th class="text-center" width="100px">No Induk</th>
                                                <th class="text-center" width="200px">Nama</th>
                                                <th class="text-center" width="200px">Kode Barang</th>
                                                <th class="text-center" width="100px">Kode Proses</th>
                                                <th class="text-center" width="100px">Jml Barang</th>
                                                <th class="text-center" width="100px">Afmat</th>
                                                <th class="text-center" width="100px">Afmch</th>
                                                <th class="text-center" width="100px">Repair</th>
                                                <th class="text-center" width="100px">Reject</th>
                                                <th class="text-center" width="100px">Setting Time</th>
                                                <th class="text-center" width="100px">Shift</th>
                                                <th class="text-center" width="100px">Status</th>
                                                <th class="text-center" width="200px">Kode Barang Target Sementara</th>
                                                <th class="text-center" width="200px">Kode Proses Target Sementara</th>
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