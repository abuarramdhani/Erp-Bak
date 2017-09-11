<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('GeneralAffair/FleetMerkKendaraan/update/'.$id);?>" class="form-horizontal">
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
                                <div class="box-header with-border">Update Model Kendaraan</div>
                                <?php
                                    foreach ($FleetMerkKendaraan as $headerRow):
                                        $merkKendaraan      =   $headerRow['merk_kendaraan'];
                                        $merkKendaraan      =   explode(' - ', $merkKendaraan);
                                        $produsenKendaraan  =   $merkKendaraan[0];
                                        if (isset($merkKendaraan[1])) 
                                        {
                                            $modelKendaraan     =   $merkKendaraan[1];
                                        }

                                ?>
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
                                                                $status = '';
                                                                if (strtolower($Produsen['produsen_kendaraan'])==strtolower($produsenKendaraan))
                                                                {
                                                                    echo $status = 'selected';
                                                                }
                                                                echo '  <option value="'.$Produsen['produsen_kendaraan'].'" '.$status.'>
                                                                        '.$Produsen['produsen_kendaraan'].'
                                                                        </option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>                                        
											<div class="form-group">
                                                <label for="txtMerkKendaraanHeader" class="control-label col-lg-4">Merk Kendaraan</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Merk Kendaraan" name="txtMerkKendaraanHeader" id="txtMerkKendaraanHeader" class="form-control" value="<?php if(isset($modelKendaraan)){echo $modelKendaraan;} ?>"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtStartDateHeader" class="control-label col-lg-4">Waktu Dibuat</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo $headerRow['waktu_dibuat'];?>" name="txtStartDateHeader" value="<?php echo $headerRow['waktu_dibuat'] ?>" class="date form-control" data-date-format="dd-mm-yyyy H:i:s" id="txtStartDateHeader" disabled=""/>
                                                </div>
                                            </div>
                                            <?php
                                                if(substr($kodesie, 0, 5)=='10103')
                                                    {
                                            ?>
                                            <div class="form-group">
                                                <label for="txtTanggalNonaktif" class="control-label col-lg-4">Aktif</label>
                                                <div class="col-lg-4">
                                                    <input type="checkbox" name="CheckAktif" id="CheckAktif" <?php if($headerRow['waktu_dihapus']=='12-12-9999 00:00:00'){echo 'checked';};?>>
                                                    <input type="text" name="WaktuDihapus" id="WaktuDihapus" hidden="" value="<?php echo $headerRow['waktu_dihapus'];?>">
                                                </div>

                                            </div>
                                            <?php
                                                }
                                            ?>


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
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>