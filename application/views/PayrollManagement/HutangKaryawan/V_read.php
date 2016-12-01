<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Hutang Karyawan</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/HutangKaryawan/');?>">
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
                                Read Hutang Karyawan
                            </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <div class="row">

<div class="form-group">
                                            <label for="txtNoind" class="control-label col-lg-4">Nomor Hutang</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtNoind" id="txtNoind" class="form-control" value="<?php echo $no_hutang; ?>" readonly/>
                                            </div>
                                        </div>							
<div class="form-group">
                                            <label for="txtNoind" class="control-label col-lg-4">Nomor Induk</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtNoind" id="txtNoind" class="form-control" value="<?php echo $noind; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtTglPengajuan" class="control-label col-lg-4">Tgl Pengajuan</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtTglPengajuan" id="txtTglPengajuan" class="form-control" value="<?php echo $tgl_pengajuan; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtTotalHutang" class="control-label col-lg-4">Total Hutang</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtTotalHutang" id="txtTotalHutang" class="form-control" value="<?php echo $total_hutang; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtJmlCicilan" class="control-label col-lg-4">Jml Cicilan</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtJmlCicilan" id="txtJmlCicilan" class="form-control" value="<?php echo $jml_cicilan; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtStatusLunas" class="control-label col-lg-4">Status Lunas</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtStatusLunas" id="txtStatusLunas" class="form-control" value="<?php echo $status_lunas; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtKodePetugas" class="control-label col-lg-4">Kode Petugas</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtKodePetugas" id="txtKodePetugas" class="form-control" value="<?php echo $kode_petugas; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtTglRecord" class="control-label col-lg-4">Tgl Record</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtTglRecord" id="txtTglRecord" class="form-control" value="<?php echo $tgl_record; ?>" readonly/>
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