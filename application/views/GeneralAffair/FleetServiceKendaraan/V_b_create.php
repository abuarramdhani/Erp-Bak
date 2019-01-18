<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('GeneralAffair/FleetServiceKendaraan/saveDataService');?>" class="form-horizontal" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/FleetServiceKendaraan/');?>">
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
                                <div class="box-header with-border">Create Service Kendaraan</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="txtMerkKendaraan" class="control-label col-lg-4">Kendaraan</label>
                                                <div class="col-lg-3">
                                                    <input class="form-control" name="txtMerkKendaraan" value="<?php echo $item['merk']; ?>" readonly></input>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="jenis_service" class="control-label col-lg-4">Jenis Service</label>
                                                <div class="col-lg-3">
                                                    <input class="form-control" name="jenis_service" value="<?php echo $item['jenis_service']; ?>" readonly></input>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <div class="col-lg-3">
                                                    
                                                </div>
                                                <div class="col-lg-4" style="padding: 10px;">
                                                    <?php
                                                        $jarak = $item['jarak_awal'];
                                                        $k_jarak = $item['kelipatan_jarak'];
                                                        $waktu = $item['lama_awal'];
                                                        $k_waktu = $item['kelipatan_waktu'];

                                                        for ($i=0; $i < $item['batas']; $i++) { 
                                                            ?>
                                                                <div class="row">
                                                                    <div class="col-lg-4">
                                                                        <input style="border: none" readonly name="jarak[]" value="<?php echo $jarak ?>"></input> <br>
                                                                        <input style="border: none" readonly name="waktu[]" value="<?php echo $waktu ?>"></input>
                                                                    </div>
                                                                    <div class="col-sm-1" style="margin-top: -7px;margin-left: -70px;">
                                                                        <label style="margin-left: -10px;" class="radio-inline">Km/</label><br>
                                                                        <label style="margin-top: -4px;margin-left: -10px;" class="radio-inline">bulan</label>
                                                                    </div>
                                                                    <div class="col-lg-7">
                                                                        <select class="form-control" name="status_service[]">
                                                                            <option value="-">-</option>    
                                                                            <option value="G">G</option>    
                                                                            <option value="P">P</option>    
                                                                            <option value="R">R</option>    
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                            <?php
                                                            $j_waktu = (int)$waktu;
                                                            $j_jarak = (int)$jarak;
                                                            $j_k_waktu = (int)$k_waktu;
                                                            $j_k_jarak = (int)$k_jarak;
                                                            $waktu = $j_waktu+$j_k_waktu;
                                                            $jarak = $j_jarak+$j_k_jarak;
                                                        }
                                                    ?>
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