<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('GeneralAffair/FleetKir/update/'.$id);?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/FleetKir/');?>">
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
                                <div class="box-header with-border">Update Fleet Kir</div>
                                <?php
                                    foreach ($FleetKir as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="cmbKendaraanIdHeader" class="control-label col-lg-4">Kendaraan Id</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbKendaraanIdHeader" name="cmbKendaraanIdHeader" class="select select2" data-placeholder="Choose an option">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($FleetKendaraan as $row) {
                                                                if ($headerRow['kendaraan_id'] == $row['kendaraan_id']) {
                                                                    $selected_data = "selected";
                                                                } else {
                                                                    $selected_data = "";   
                                                                }
                                                                echo '<option value="'.$row['nomor_polisi'].'" '.$selected_data.'>'.$row['kendaraan_id'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTanggalKirHeader" class="control-label col-lg-4">Tanggal Kir</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTanggalKirHeader" value="<?php echo $headerRow['tanggal_kir'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtTanggalKirHeader" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtPeriodeAwalKirHeader" class="control-label col-lg-4">Periode Awal Kir</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtPeriodeAwalKirHeader" value="<?php echo $headerRow['periode_awal_kir'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtPeriodeAwalKirHeader" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtPeriodeAkhirKirHeader" class="control-label col-lg-4">Periode Akhir Kir</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtPeriodeAkhirKirHeader" value="<?php echo $headerRow['periode_akhir_kir'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtPeriodeAkhirKirHeader" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtBiayaHeader" class="control-label col-lg-4">Biaya</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Biaya" name="txtBiayaHeader" id="txtBiayaHeader" class="form-control" value="<?php echo $headerRow['biaya']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtStartDateHeader" class="control-label col-lg-4">Start Date</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtStartDateHeader" value="<?php echo $headerRow['start_date'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtStartDateHeader" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtEndDateHeader" class="control-label col-lg-4">End Date</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtEndDateHeader" value="<?php echo $headerRow['end_date'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtEndDateHeader" />
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
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>