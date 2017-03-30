<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Potongan/doCreate');?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Potongan/');?>">
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
                                <div class="box-header with-border">Create Potongan</div>
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
                                                <label for="txtPotLebihBayarHeader" class="control-label col-lg-4">Pot Lebih Bayar</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Pot Lebih Bayar" name="txtPotLebihBayarHeader" id="txtPotLebihBayarHeader" class="form-control" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtPotGpHeader" class="control-label col-lg-4">Pot Gp</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Pot Gp" name="txtPotGpHeader" id="txtPotGpHeader" class="form-control" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtPotDlHeader" class="control-label col-lg-4">Pot Dl</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Pot Dl" name="txtPotDlHeader" id="txtPotDlHeader" class="form-control" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtPotSpsiHeader" class="control-label col-lg-4">Pot Spsi</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Pot Spsi" name="txtPotSpsiHeader" id="txtPotSpsiHeader" class="form-control" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtPotDukaHeader" class="control-label col-lg-4">Pot Duka</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Pot Duka" name="txtPotDukaHeader" id="txtPotDukaHeader" class="form-control" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtPotKoperasiHeader" class="control-label col-lg-4">Pot Koperasi</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Pot Koperasi" name="txtPotKoperasiHeader" id="txtPotKoperasiHeader" class="form-control" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtPotHutangLainHeader" class="control-label col-lg-4">Pot Hutang Lain</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Pot Hutang Lain" name="txtPotHutangLainHeader" id="txtPotHutangLainHeader" class="form-control" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtPotDplkHeader" class="control-label col-lg-4">Pot Dplk</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Pot Dplk" name="txtPotDplkHeader" id="txtPotDplkHeader" class="form-control" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtPotThpHeader" class="control-label col-lg-4">Pot Thp</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Pot Thp" name="txtPotThpHeader" id="txtPotThpHeader" class="form-control" />
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