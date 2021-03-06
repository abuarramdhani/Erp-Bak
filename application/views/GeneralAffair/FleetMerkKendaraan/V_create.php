<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('GeneralAffair/FleetMerkKendaraan/create');?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/FleetMerkKendaraan/');?>">
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
                                <div class="box-header with-border">Create Model Kendaraan</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="cmbProdusenKendaraan" class="control-label col-lg-4">Produsen Kendaraan</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbProdusenKendaraan" name="cmbProdusenKendaraan" class="select2" data-placeholder="Pilih" style="width: 75%;" required="">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($ProdusenKendaraan as $Produsen) 
                                                            {
                                                                echo '  <option value="'.$Produsen['produsen_kendaraan'].'">
                                                                        '.$Produsen['produsen_kendaraan'].'
                                                                        </option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="cmbBahanBakar" class="control-label col-lg-4">Jenis Bahan Bakar</label>
                                                <div class="col-lg-4">
                                                    <select class="select select2" data-placeholder="Jenis Bahan Bakar" name="cmbBahanBakar" id="cmbBahanBakar" class="form-control" required style="width: 75%">
                                                        <option></option>
                                                        <option value="Solar">Solar</option>
                                                        <option value="Non Solar">Non Solar</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="cmbBahanBakar" class="control-label col-lg-4">Rasio Penggunaan BBM</label>
                                                <div class="col-lg-1">
                                                    <input class="form-control" name="rasio_liter" value="1" readonly></input>
                                                  
                                                </div>
                                                <div class="col-lg-1" style="margin-left: -20px;padding-top: 6px;">
                                                      <label> : </label>
                                                </div>
                                                <div class="col-lg-1" style="margin-left: -80px;">
                                                    <input class="form-control" name="rasio_jarak"></input>
                                                </div>
                                                <div class="col-lg-1" style="padding-top: 6px;margin-left: -20px;">
                                                    Km
                                                </div>

                                            </div>
											<div class="form-group">
                                                <label for="txtMerkKendaraanHeader" class="control-label col-lg-4">Merk Kendaraan</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Merk Kendaraan" name="txtMerkKendaraanHeader" id="txtMerkKendaraanHeader" class="form-control" required="" />
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