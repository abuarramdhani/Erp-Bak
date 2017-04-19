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
                                <h3 class="box-title"><?= $Title ?></h3>
                            </div>
                            <div class="box-body">
                                <form id="ProsesGajiForm" class="row form-horizontal" action="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/HitungGaji/doHitungGaji'); ?>" method="post">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Seksi</label>
                                        <div class="col-lg-4">
                                            <select name="cmbKodesie" class="select cmbKodesie" data-placeholder="Select Section Code" style="width: 100%" required>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">
                                            Pilih Periode
                                        </label>
                                        <div class="col-lg-2">
                                            <select name="cmbBulan" class="form-control select2" data-placeholder="Select Month" style="width: 100%">
                                                <option value=""></option>
                                                <?php
                                                    for($i = 1; $i <= 12; $i++){
                                                        echo '<option value="'.$i.'">'.date("F", mktime(0, 0, 0, $i, 1)).'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="text" name="txtTahun" class="form-control" placeholder="Tahun" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Tanggal Pembayaran</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtTglPembayaran" class="form-control date-picker-pr-non-staf">
                                        </div>
                                    </div>
                                </form>
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <div id="errorProsesGaji" class="col-lg-2 col-lg-offset-4">
                                        </div>
                                        <div class="col-lg-2">
                                            <button type="button" id="btnProsesGaji" class="btn btn-primary btn-block">Proses Gaji</button>
                                        </div>
                                        <div class="col-lg-2">
                                            <form method="post" target="_blank" action="<?php echo base_url('PayrollManagementNonStaff/ProsesGaji/HitungGaji/cetakStruk'); ?>">
                                                <input type="hidden" name="noind" value="NULL">
                                                <button id="btnPrintStrukAll" type="submit" class="btn btn-primary btn-block" disabled><i class="fa fa-print"></i> Struk Semua</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="tblHitungGaji" style="min-width: 100%;">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th class="text-center" width="50px">No</th>
                                                        <th class="text-center" width="100px">Action</th>
                                                        <th class="text-center" width="100px">No Induk</th>
                                                        <th class="text-center" width="250px">Nama</th>
                                                        <th class="text-center" width="150px">Gaji Pokok</th>
                                                        <th class="text-center" width="150px">Insentif Prestasi</th>
                                                        <th class="text-center" width="150px">Insentif Kelebihan</th>
                                                        <th class="text-center" width="150px">Insentif Kondite</th>
                                                        <th class="text-center" width="150px">Insentif Masuk Sore</th>
                                                        <th class="text-center" width="150px">Insentif Masuk Malam</th>
                                                        <th class="text-center" width="150px">UBT</th>
                                                        <th class="text-center" width="150px">UPAMK</th>
                                                        <th class="text-center" width="150px">Uang Lembur</th>
                                                        <th class="text-center" width="150px">Tambah Kurang Bayar</th>
                                                        <th class="text-center" width="150px">Tambah Lain</th>
                                                        <th class="text-center" width="150px">DL</th>
                                                        <th class="text-center" width="150px">Potongan HTM</th>
                                                        <th class="text-center" width="150px">Potongan Lebih Bayar</th>
                                                        <th class="text-center" width="150px">Potongan GP</th>
                                                        <th class="text-center" width="150px">Potongan DL</th>
                                                        <th class="text-center" width="150px">JTH</th>
                                                        <th class="text-center" width="150px">JKN</th>
                                                        <th class="text-center" width="150px">JP</th>
                                                        <th class="text-center" width="150px">Potongan Koperasi</th>
                                                        <th class="text-center" width="150px">Potongan Hutang Lain</th>
                                                        <th class="text-center" width="150px">Potongan DPLK</th>
                                                        <th class="text-center" width="150px">Potongan SPSI</th>
                                                        <th class="text-center" width="150px">Potongan Duka</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="prosesGaji">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>    
        </div>
    </div>
</section>