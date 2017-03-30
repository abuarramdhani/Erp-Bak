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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataAbsensi');?>">
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
                                        <div id="errorProsesGaji" class="col-lg-2 col-lg-offset-4">
                                        </div>
                                        <div class="col-lg-2">
                                            <button type="button" id="btnProsesGaji" class="btn btn-primary btn-block">Proses Gaji</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped ">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th class="text-center">No Induk</th>
                                                        <th class="text-center">Nama</th>
                                                        <th class="text-center">Gaji Pokok</th>
                                                        <th class="text-center">Insentif Prestasi</th>
                                                        <th class="text-center">Insentif kelebihan</th>
                                                        <th class="text-center">Insentif Masuk Sore</th>
                                                        <th class="text-center">Insentif Masuk Malam</th>
                                                        <th class="text-center">UBT</th>
                                                        <th class="text-center">UPAMK</th>
                                                        <th class="text-center">Uang Lembur</th>
                                                        <th class="text-center">Tambah Kurang Bayar</th>
                                                        <th class="text-center">Tambah Lain</th>
                                                        <th class="text-center">DL</th>
                                                        <th class="text-center">Potongan HTM</th>
                                                        <th class="text-center">Potongan Lebih Bayar</th>
                                                        <th class="text-center">Potongan GP</th>
                                                        <th class="text-center">Potongan DL</th>
                                                        <th class="text-center">JTH</th>
                                                        <th class="text-center">JKN</th>
                                                        <th class="text-center">JP</th>
                                                        <th class="text-center">Potongan Koperasi</th>
                                                        <th class="text-center">Potongan Hutang Lain</th>
                                                        <th class="text-center">Potongan DPLK</th>
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