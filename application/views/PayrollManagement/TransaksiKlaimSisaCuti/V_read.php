<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Transaksi Klaim Sisa Cuti</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/TransaksiKlaimSisaCuti/');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <span ><br /></span>
                                    </a>                             
                                </div>
                            </div>
                        </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                Read Transaksi Klaim Sisa Cuti
                            </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <div class="row">
<div class="form-group">
                                            <label for="txtNoind" class="control-label col-lg-4">Noind</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtNoind" id="txtNoind" class="form-control" value="<?php echo $noind; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtPeriode" class="control-label col-lg-4">Periode</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtPeriode" id="txtPeriode" class="form-control" value="<?php echo $periode; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtSisaCuti" class="control-label col-lg-4">Sisa Cuti</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtSisaCuti" id="txtSisaCuti" class="form-control" value="<?php echo $sisa_cuti; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtJumlahKlaim" class="control-label col-lg-4">Jumlah Klaim</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtJumlahKlaim" id="txtJumlahKlaim" class="form-control" value="<?php echo $jumlah_klaim; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtKodePetugas" class="control-label col-lg-4">Kode Petugas</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtKodePetugas" id="txtKodePetugas" class="form-control" value="<?php echo $kode_petugas; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtTglJamRecord" class="control-label col-lg-4">Tgl Jam Record</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtTglJamRecord" id="txtTglJamRecord" class="form-control" value="<?php echo $tgl_jam_record; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtKdJnsTransaksi" class="control-label col-lg-4">Kd Jns Transaksi</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtKdJnsTransaksi" id="txtKdJnsTransaksi" class="form-control" value="<?php echo $kd_jns_transaksi; ?>" readonly/>
                                            </div>
                                        </div>
</div>
                                
                            </div>
                            <div class="panel-footer">
                                <div class="row text-right">
                                    <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</section>