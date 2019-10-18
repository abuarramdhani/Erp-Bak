<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1>
                                    <b>
                                        <?= $Title ?> 
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg"
                                    href="<?php echo site_url('ManufacturingOperationUP2L/DeleteDataUP2L/');?>">
                                    <i class="icon-wrench icon-2x">
                                    </i>
                                    <span>
                                        <br />
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        <form autocomplete="off" action="<?php echo base_url('ManufacturingOperationUP2L/DeleteDataUP2L/delete_massal'); ?>" method="POST">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Hapus Data</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="month" class="control-label col-lg-4">Bulan</label>
                                            <div class="col-lg-6">
                                                <input class="form-control selectM" type="text" placeholder="Pilih Bulan" name="month" required="">
                                            </div>
                                        </div>
                                        <br><br><br><br><p style="color:red;">Peringatan : Semua data yang ada di <b>Moulding, Mixing, Core, OTT, Absen, Selep dan Quality Control</b> akan hilang sesuai dengan bulan yang dipilih</p>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row text-right">
                                            <button style="right:1;" type="submit" onclick="return confirm('Apakah anda yakin untuk menghapus ?');" class="btn btn-danger btn-lg"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-2"></div>
                </div>
            </div>
        </div>
    </div>
</section>