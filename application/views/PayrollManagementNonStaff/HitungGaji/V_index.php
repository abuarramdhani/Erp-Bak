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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/HitungGaji');?>">
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
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/HitungGaji/clear_data/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Kosongkan Data" title="Kosongkan Data" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash fa-2x"></i></button>
                                </a>
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/HitungGaji/hitung/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Hitung Gaji" title="Hitung Gaji" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-calculator fa-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblHasilGaji" style="font-size:12px;min-width: 100%">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th class="text-center" width="100px">Action</th>
                                                <th class="text-center" width="100px">Error ?</th>
                                                <th class="text-center" width="150px">Tanggal Pembayaran</th>
                                                <th class="text-center" width="100px">No Induk</th>
                                                <th class="text-center" width="200px">Nama</th>
                                                <th class="text-center" width="100px">Kodesie</th>
                                                <th class="text-center" width="200px">Nama Seksi</th>
                                                <th class="text-center" width="100px">Bulan Gaji</th>
                                                <th class="text-center" width="100px">Tahun Gaji</th>
                                                <th class="text-center" width="100px">Gaji Pokok</th>
                                                <th class="text-center" width="100px">Insentif Prestasi</th>
                                                <th class="text-center" width="100px">Insentif Kelebihan</th>
                                                <th class="text-center" width="100px">Insentif Kondite</th>
                                                <th class="text-center" width="120px">Insentif Masuk Sore</th>
                                                <th class="text-center" width="120px">Insentif Masuk Malam</th>
                                                <th class="text-center" width="100px">UBT</th>
                                                <th class="text-center" width="100px">UPAMK</th>
                                                <th class="text-center" width="100px">Uang Lembur</th>
                                                <th class="text-center" width="120px">Tambah Kurang Bayar</th>
                                                <th class="text-center" width="100px">Tambah Lain</th>
                                                <th class="text-center" width="100px">Uang DL</th>
                                                <th class="text-center" width="100px">Tambah Pajak</th>
                                                <th class="text-center" width="130px">Denda Insentif Kondite</th>
                                                <th class="text-center" width="100px">Potongan HTM</th>
                                                <th class="text-center" width="120px">Potongan Lebih Bayar</th>
                                                <th class="text-center" width="120px">Potongan Gaji Pokok</th>
                                                <th class="text-center" width="100px">Potongan Uang DL</th>
                                                <th class="text-center" width="100px">JHT</th>
                                                <th class="text-center" width="100px">JKN</th>
                                                <th class="text-center" width="100px">JP</th>
                                                <th class="text-center" width="100px">SPSI</th>
                                                <th class="text-center" width="100px">Duka</th>
                                                <th class="text-center" width="100px">Potongan Koperasi</th>
                                                <th class="text-center" width="120px">Potongan Hutang Lain</th>
                                                <th class="text-center" width="100px">Potongan DPLK</th>
                                                <th class="text-center" width="100px">TKP</th>
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