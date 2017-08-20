<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('GeneralAffair/FleetKendaraan/update/'.$id);?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/FleetKendaraan/');?>">
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
                                <div class="box-header with-border">Update Fleet Kendaraan</div>
                                <?php
                                    foreach ($FleetKendaraan as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
<<<<<<< HEAD
                                        <div class="row">
=======
                                        <div class="row">
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc
											<div class="form-group">
                                                <label for="txtNomorPolisiHeader" class="control-label col-lg-4">Nomor Polisi</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Nomor Polisi" name="txtNomorPolisiHeader" id="txtNomorPolisiHeader" class="form-control" value="<?php echo $headerRow['nomor_polisi']; ?>"/>
                                                </div>
<<<<<<< HEAD
                                            </div>
=======
                                            </div>
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc

											<div class="form-group">
                                                <label for="cmbJenisKendaraanIdHeader" class="control-label col-lg-4">Jenis Kendaraan Id</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbJenisKendaraanIdHeader" name="cmbJenisKendaraanIdHeader" class="select select2" data-placeholder="Choose an option">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($FleetJenisKendaraan as $row) {
                                                                if ($headerRow['jenis_kendaraan_id'] == $row['jenis_kendaraan_id']) {
                                                                    $selected_data = "selected";
                                                                } else {
                                                                    $selected_data = "";   
                                                                }
                                                                echo '<option value="'.$row['jenis_kendaraan'].'" '.$selected_data.'>'.$row['jenis_kendaraan_id'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
<<<<<<< HEAD
                                            </div>
=======
                                            </div>
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc

											<div class="form-group">
                                                <label for="cmbMerkKendaraanIdHeader" class="control-label col-lg-4">Merk Kendaraan Id</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbMerkKendaraanIdHeader" name="cmbMerkKendaraanIdHeader" class="select select2" data-placeholder="Choose an option">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($FleetMerkKendaraan as $row) {
                                                                if ($headerRow['merk_kendaraan_id'] == $row['merk_kendaraan_id']) {
                                                                    $selected_data = "selected";
                                                                } else {
                                                                    $selected_data = "";   
                                                                }
                                                                echo '<option value="'.$row['merk_kendaraan'].'" '.$selected_data.'>'.$row['merk_kendaraan_id'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
<<<<<<< HEAD
                                            </div>
=======
                                            </div>
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc

											<div class="form-group">
                                                <label for="cmbWarnaKendaraanIdHeader" class="control-label col-lg-4">Warna Kendaraan Id</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbWarnaKendaraanIdHeader" name="cmbWarnaKendaraanIdHeader" class="select select2" data-placeholder="Choose an option">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($FleetWarnaKendaraan as $row) {
                                                                if ($headerRow['warna_kendaraan_id'] == $row['warna_kendaraan_id']) {
                                                                    $selected_data = "selected";
                                                                } else {
                                                                    $selected_data = "";   
                                                                }
                                                                echo '<option value="'.$row['warna_kendaraan'].'" '.$selected_data.'>'.$row['warna_kendaraan_id'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
<<<<<<< HEAD
                                            </div>
=======
                                            </div>
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc

											<div class="form-group">
                                                <label for="txtTahunPembuatanHeader" class="control-label col-lg-4">Tahun Pembuatan</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Tahun Pembuatan" name="txtTahunPembuatanHeader" id="txtTahunPembuatanHeader" class="form-control" value="<?php echo $headerRow['tahun_pembuatan']; ?>"/>
                                                </div>
<<<<<<< HEAD
                                            </div>
=======
                                            </div>
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc

											<div class="form-group">
                                                <label for="txtFotoStnkHeader" class="control-label col-lg-4">Foto Stnk</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Foto Stnk" name="txtFotoStnkHeader" id="txtFotoStnkHeader" class="form-control" value="<?php echo $headerRow['foto_stnk']; ?>"/>
                                                </div>
<<<<<<< HEAD
                                            </div>
=======
                                            </div>
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc

											<div class="form-group">
                                                <label for="txtFotoBpkbHeader" class="control-label col-lg-4">Foto Bpkb</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Foto Bpkb" name="txtFotoBpkbHeader" id="txtFotoBpkbHeader" class="form-control" value="<?php echo $headerRow['foto_bpkb']; ?>"/>
                                                </div>
<<<<<<< HEAD
                                            </div>
=======
                                            </div>
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc

											<div class="form-group">
                                                <label for="txtFotoKendaraanHeader" class="control-label col-lg-4">Foto Kendaraan</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Foto Kendaraan" name="txtFotoKendaraanHeader" id="txtFotoKendaraanHeader" class="form-control" value="<?php echo $headerRow['foto_kendaraan']; ?>"/>
                                                </div>
<<<<<<< HEAD
                                            </div>
=======
                                            </div>
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc

											<div class="form-group">
                                                <label for="txtStartDateHeader" class="control-label col-lg-4">Start Date</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtStartDateHeader" value="<?php echo $headerRow['start_date'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtStartDateHeader" />
                                                </div>
<<<<<<< HEAD
                                            </div>
=======
                                            </div>
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc

											<div class="form-group">
                                                <label for="txtEndDateHeader" class="control-label col-lg-4">End Date</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtEndDateHeader" value="<?php echo $headerRow['end_date'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtEndDateHeader" />
                                                </div>
<<<<<<< HEAD
                                            </div>
=======
                                            </div>
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc


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