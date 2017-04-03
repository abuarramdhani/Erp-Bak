<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Transaksi Hutang</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/TransaksiHutang/');?>">
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
                                Read Transaksi Hutang
                            </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <div class="row">
<div class="form-group">
                                            <label for="txtIdTransaksiHutang" class="control-label col-lg-4">Id Transaksi Hutang</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtIdTransaksiHutang" id="txtIdTransaksiHutang" class="form-control" value="<?php echo $id_transaksi_hutang; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtNoHutang" class="control-label col-lg-4">No Hutang</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtNoHutang" id="txtNoHutang" class="form-control" value="<?php echo $no_hutang; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtTglTransaksi" class="control-label col-lg-4">Tgl Transaksi</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtTglTransaksi" id="txtTglTransaksi" class="form-control" value="<?php echo $tgl_transaksi; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtJenisTransaksi" class="control-label col-lg-4">Jenis Transaksi</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtJenisTransaksi" id="txtJenisTransaksi" class="form-control" value="<?php echo $jenis_transaksi; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtJumlahTransaksi" class="control-label col-lg-4">Jumlah Transaksi</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtJumlahTransaksi" id="txtJumlahTransaksi" class="form-control" value="<?php echo $jumlah_transaksi; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtLunas" class="control-label col-lg-4">Lunas</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtLunas" id="txtLunas" class="form-control" value="<?php echo $lunas; ?>" readonly/>
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