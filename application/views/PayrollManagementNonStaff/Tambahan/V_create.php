<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Tambahan/doCreate');?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Tambahan/');?>">
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
                                <div class="box-header with-border">Create Tambahan</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="cmbNoindHeader" class="control-label col-lg-4">Noind</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbNoindHeader" name="cmbNoindHeader" class="select cmbNoindHeader" data-placeholder="No Induk" style="width: 100%">
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtBulanGajiHeader" class="control-label col-lg-4">Bulan Gaji</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Bulan Gaji" name="txtBulanGajiHeader" id="txtBulanGajiHeader" class="form-control" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTahunGajiHeader" class="control-label col-lg-4">Tahun Gaji</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Tahun Gaji" name="txtTahunGajiHeader" id="txtTahunGajiHeader" class="form-control" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtKurangBayarHeader" class="control-label col-lg-4">Kurang Bayar</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Kurang Bayar" name="txtKurangBayarHeader" id="txtKurangBayarHeader" class="form-control" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtLainLainHeader" class="control-label col-lg-4">Lain Lain</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Lain Lain" name="txtLainLainHeader" id="txtLainLainHeader" class="form-control" />
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
                                            <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
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