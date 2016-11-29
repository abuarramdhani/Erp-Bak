<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Riwayat Rekening Pekerja</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/RiwayatRekeningPekerja/');?>">
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
                                Read Riwayat Rekening Pekerja
                            </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <div class="row">
<div class="form-group">
                                            <label for="txtTglBerlaku" class="control-label col-lg-4">Tgl Berlaku</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtTglBerlaku" id="txtTglBerlaku" class="form-control" value="<?php echo $tgl_berlaku; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtTglTberlaku" class="control-label col-lg-4">Tgl Tberlaku</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtTglTberlaku" id="txtTglTberlaku" class="form-control" value="<?php echo $tgl_tberlaku; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtNoind" class="control-label col-lg-4">Noind</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtNoind" id="txtNoind" class="form-control" value="<?php echo $noind; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtKdBank" class="control-label col-lg-4">Kd Bank</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtKdBank" id="txtKdBank" class="form-control" value="<?php echo $kd_bank; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtNoRekening" class="control-label col-lg-4">No Rekening</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtNoRekening" id="txtNoRekening" class="form-control" value="<?php echo $no_rekening; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtNamaPemilikRekening" class="control-label col-lg-4">Nama Pemilik Rekening</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtNamaPemilikRekening" id="txtNamaPemilikRekening" class="form-control" value="<?php echo $nama_pemilik_rekening; ?>" readonly/>
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