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
                                        href="<?php echo site_url('ManufacturingOperationUP2L/XFIN/');?>">
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
                        <div class="col-lg-6">
                            <form autocomplete="off" action="<?php echo base_url('ManufacturingOperationUP2L/GenerateLaporan/createLaporan1'); ?>" method="POST">
                                <div class="box box-primary box-solid">
                                    <div class="box-header with-border">Monitoring Produksi</div>
                                    <div class="box-body">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="txtComponentCodeHeader" class="control-label col-lg-4">Tanggal Awal</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control selcDateUp2L" type="text" placeholder="Pilih tanggal Awal" name="tanggal_awal" required="">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="txtComponentDescriptionHeader" class="control-label col-lg-4">Tanggal Akhir</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control selcDateUp2L" type="text" placeholder="Pilih tanggal Akhir" name="tanggal_akhir" required="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <br />
                                                <br />
                                                <div class="row">
                                                    <div class="nav-tabs-custom">
                                                        <ul class="nav nav-tabs">
                                                        </ul>
                                                        <div class="tab-content">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="row text-right">
                                                <button type="submit" class="btn btn-primary btn-lg btn-rect">Generate</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        </form>
                        <form autocomplete="off" action="<?php echo base_url('ManufacturingOperationUP2L/GenerateLaporan/createLaporan2'); ?>" method="POST">
                            <div class="col-lg-6">
                                <div class="box box-primary box-solid">
                                    <div class="box-header with-border">Evaluasi Produksi</div>
                                    <div class="box-body">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="txtComponentCodeHeader" class="control-label col-lg-4">Tanggal Awal</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control selcDateUp2L" type="text" placeholder="Pilih tanggal Awal" name="tanggal_awal" required="">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="txtComponentDescriptionHeader" class="control-label col-lg-4">Tanggal Akhir</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control selcDateUp2L" type="text" placeholder="Pilih tanggal Akhir" name="tanggal_akhir" required="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <br />
                                                <br />
                                                <div class="row">
                                                    <div class="nav-tabs-custom">
                                                        <ul class="nav nav-tabs">
                                                        </ul>
                                                        <div class="tab-content">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="row text-right">
                                                <button type="submit" class="btn btn-primary btn-lg btn-rect">Generate</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form autocomplete="off" action="<?php echo base_url('ManufacturingOperationUP2L/GenerateLaporan/createLaporan3'); ?>" method="POST">
                            <div class="col-lg-6">
                                <div class="box box-primary box-solid">
                                    <div class="box-header with-border">Laporan DET_TRAN</div>
                                    <div class="box-body">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="txtComponentCodeHeader" class="control-label col-lg-4">Tanggal Awal</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control selcDateUp2L" type="text" placeholder="Pilih tanggal Awal" name="tanggal_awal" required="">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="txtComponentDescriptionHeader" class="control-label col-lg-4">Tanggal Akhir</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control selcDateUp2L" type="text" placeholder="Pilih tanggal Akhir" name="tanggal_akhir" required="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <br />
                                                <br />
                                                <div class="row">
                                                    <div class="nav-tabs-custom">
                                                        <ul class="nav nav-tabs">
                                                        </ul>
                                                        <div class="tab-content">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="row text-right">
                                                <button type="submit" class="btn btn-primary btn-lg btn-rect">Generate</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form autocomplete="off" action="<?php echo base_url('ManufacturingOperationUP2L/GenerateLaporan/createLaporan4'); ?>" method="POST">
                            <div class="col-lg-6">
                                <div class="box box-primary box-solid">
                                    <div class="box-header with-border">Laporan BPKEKAT</div>
                                    <div class="box-body">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="txtComponentCodeHeader" class="control-label col-lg-4">Tanggal Awal</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control selcDateUp2L" type="text" placeholder="Pilih tanggal Awal" name="tanggal_awal" required="">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="txtComponentDescriptionHeader" class="control-label col-lg-4">Tanggal Akhir</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control selcDateUp2L" type="text" placeholder="Pilih tanggal Akhir" name="tanggal_akhir" required="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <br />
                                                <br />
                                                <div class="row">
                                                    <div class="nav-tabs-custom">
                                                        <ul class="nav nav-tabs">
                                                        </ul>
                                                        <div class="tab-content">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="row text-right">
                                                <button type="submit" class="btn btn-primary btn-lg btn-rect">Generate</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form autocomplete="off" action="<?php echo base_url('ManufacturingOperationUP2L/GenerateLaporan/createLaporan5'); ?>" method="POST">
                            <div class="col-lg-6">
                                <div class="box box-primary box-solid">
                                    <div class="box-header with-border">Laporan IND_TRAN</div>
                                    <div class="box-body">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="txtComponentCodeHeader" class="control-label col-lg-4">Tanggal Awal</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control selcDateUp2L" type="text" name="tanggal_awal" required="" placeholder="Pilih tanggal Awal">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="txtComponentDescriptionHeader" class="control-label col-lg-4">Tanggal Akhir</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control selcDateUp2L" type="text" name="tanggal_akhir" required="" placeholder="Pilih tanggal Akhir">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <br />
                                                <br />
                                                <div class="row">
                                                    <div class="nav-tabs-custom">
                                                        <ul class="nav nav-tabs">
                                                        </ul>
                                                        <div class="tab-content">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="row text-right">
                                                <button type="submit" class="btn btn-primary btn-lg btn-rect">Generate</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form autocomplete="off" action="<?php echo base_url('ManufacturingOperationUP2L/GenerateLaporan/createLaporan6'); ?>" method="POST">
                            <div class="col-lg-6">
                                <div class="box box-primary box-solid">
                                    <div class="box-header with-border">Laporan XFIN</div>
                                    <div class="box-body">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="txtComponentCodeHeader" class="control-label col-lg-4">Tanggal Awal</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control selcDateUp2L" type="text" name="tanggal_awal" required="" placeholder="Pilih tanggal Awal">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="txtComponentDescriptionHeader" class="control-label col-lg-4">Tanggal Akhir</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control selcDateUp2L" type="text" name="tanggal_akhir" required="" placeholder="Pilih tanggal Akhir">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <br />
                                                <br />
                                                <div class="row">
                                                    <div class="nav-tabs-custom">
                                                        <ul class="nav nav-tabs">
                                                        </ul>
                                                        <div class="tab-content">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="row text-right">
                                                <button type="submit" class="btn btn-primary btn-lg btn-rect">Generate</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
</section>