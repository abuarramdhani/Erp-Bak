<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Transaksi Hitung Thr</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/TransaksiHitungThr/');?>">
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
                                Read Transaksi Hitung Thr
                            </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <div class="row">
<div class="form-group">
                                            <label for="txtTanggal" class="control-label col-lg-4">Tanggal</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtTanggal" id="txtTanggal" class="form-control" value="<?php echo $tanggal; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtPeriode" class="control-label col-lg-4">Periode</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtPeriode" id="txtPeriode" class="form-control" value="<?php echo $periode; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtNoind" class="control-label col-lg-4">Noind</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtNoind" id="txtNoind" class="form-control" value="<?php echo $noind; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtKdStatusKerja" class="control-label col-lg-4">Kd Status Kerja</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtKdStatusKerja" id="txtKdStatusKerja" class="form-control" value="<?php echo $kd_status_kerja; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtDiangkat" class="control-label col-lg-4">Diangkat</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtDiangkat" id="txtDiangkat" class="form-control" value="<?php echo $diangkat; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtLamaThn" class="control-label col-lg-4">Lama Thn</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtLamaThn" id="txtLamaThn" class="form-control" value="<?php echo $lama_thn; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtLamaBln" class="control-label col-lg-4">Lama Bln</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtLamaBln" id="txtLamaBln" class="form-control" value="<?php echo $lama_bln; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtGajiPokok" class="control-label col-lg-4">Gaji Pokok</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtGajiPokok" id="txtGajiPokok" class="form-control" value="<?php echo $gaji_pokok; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtThr" class="control-label col-lg-4">Thr</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtThr" id="txtThr" class="form-control" value="<?php echo $thr; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtPersentaseUbthr" class="control-label col-lg-4">Persentase Ubthr</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtPersentaseUbthr" id="txtPersentaseUbthr" class="form-control" value="<?php echo $persentase_ubthr; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtUbthr" class="control-label col-lg-4">Ubthr</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtUbthr" id="txtUbthr" class="form-control" value="<?php echo $ubthr; ?>" readonly/>
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