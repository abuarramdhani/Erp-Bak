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
                                <h3 class="box-title"><?= $Title ?></h3>
                            </div>
                            <div class="box-body">
                                <form id="CekDataLKH" class="form-horizontal" method="post" action="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataLKHSeksi/doCek_LKH');?>" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">
                                            Pilih Opsi
                                        </label>
                                        <div class="col-lg-4">
                                            <select name="slcJenis" class="form-control select2" data-placeholder="Select Option" style="width: 100%">
                                                <option value=""></option>
                                                <option value="10">Cek pekerja masuk LKH tidak ada</option>
                                                <option value="01">Cek pekerja tidak masuk LKH ada</option>
                                                <option value="-1">Cek pekerja ijim keluar LKH ada</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-1" id="server-status">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">
                                            Pilih Periode
                                        </label>
                                        <div class="col-lg-2">
                                            <select name="slcBulan" class="form-control select2" data-placeholder="Select Month" style="width: 100%">
                                                <option value=""></option>
                                                <?php
                                                    for($i = 1; $i <= 12; $i++){
                                                        echo '<option value="'.$i.'">'.date("F", mktime(0, 0, 0, $i, 1)).'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="text" name="txtTahun" class="form-control" placeholder="Tahun">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-4 col-lg-2" id="errorCek_LKH">
                                            
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" id="btnCekDataLKH" class="btn btn-primary btn-block" style="float: right;">Proses</button>
                                        </div>
                                    </div>
                                </form><hr>

                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblCek_LKH" style="font-size:12px;min-width: 100%">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th class="text-center" width="30px">No</th>
                                                <th class="text-center" width="100px">No Induk</th>
                                                <th class="text-center" width="200px">Nama</th>
                                                <th class="text-center" width="200px">Seksi</th>
                                                <th class="text-center" width="100px">Tanggal</th>
                                                <th class="text-center" width="100px">Shift</th>
                                                <th class="text-center" width="100px">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="prosesCek">
                                            
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
</section>

