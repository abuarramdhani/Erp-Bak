<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('GeneralAffair/FleetKendaraan/create');?>" class="form-horizontal form-kendaraaan-ga" enctype="multipart/form-data">
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
                                <div class="box-header with-border">Create Kendaraan</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="txtNomorPolisiHeader" class="control-label col-lg-4">Nomor Polisi</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Nomor Polisi (contoh : AB1234CD)" name="txtNomorPolisiHeader" id="txtNomorPolisiHeader" class="form-control" maxlength="11" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="cmbJenisKendaraanIdHeader" class="control-label col-lg-4">Jenis Kendaraan</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbJenisKendaraanIdHeader" name="cmbJenisKendaraanIdHeader" class="select2" data-placeholder="Pilih" style="width: 75%" required="">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($FleetJenisKendaraan as $JenisKendaraan) {
                                                                echo '  <option value="'.$JenisKendaraan['kode_jenis_kendaraan'].'" >'
                                                                            .$JenisKendaraan['jenis_kendaraan'].'
                                                                        </option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="cmbMerkKendaraanIdHeader" class="control-label col-lg-4">Merk Kendaraan</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbMerkKendaraanIdHeader" name="cmbMerkKendaraanIdHeader" class="select2" data-placeholder="Pilih" style="width: 75%" required="">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($FleetMerkKendaraan as $MerkKendaraan) {
                                                                echo '  <option value="'.$MerkKendaraan["kode_merk_kendaraan"].'" >'
                                                                            .$MerkKendaraan["merk_kendaraan"].'
                                                                        </option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="cmbWarnaKendaraanIdHeader" class="control-label col-lg-4">Warna Kendaraan</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbWarnaKendaraanIdHeader" name="cmbWarnaKendaraanIdHeader" class="select2" data-placeholder="Pilih" style="width: 75%" required="">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($FleetWarnaKendaraan as $WarnaKendaraan) {
                                                                echo '  <option value="'.$WarnaKendaraan["kode_warna_kendaraan"].'" >'
                                                                            .$WarnaKendaraan["warna_kendaraan"].'
                                                                        </option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTahunPembuatanHeader" class="control-label col-lg-4">Tahun Pembuatan</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbTahunPembuatan" name="cmbTahunPembuatan" class="select2" data-placeholder="Pilih" style="width: 50%" required="">
                                                        <option value=""></option>
                                                        <?php
                                                        for ($tahun=date('Y'); $tahun > 1900; $tahun--) 
                                                        { 
                                                        echo '  <option value="'.$tahun.'">
                                                                        '.$tahun.'
                                                                </option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php 
                                            if ($user_login == "B0647") {
                                                ?>
                                                <div class="form-group">
                                                    <label for="txtLokasiKerjaHeader" class="control-label col-lg-4">Lokasi Kerja</label>
                                                    <div class="col-lg-6">
                                                        <select id="txtLokasiKerjaHeader" name="lokasi_kerja_k" class="select2" data-placeholder="Pilih" style="width: 50%" required="">
                                                            <option value=""></option>
                                                            <?php
                                                            foreach ($FleetLokasiKerja as $loker) {
                                                                echo '  <option value="'.$loker["location_code"].'" >'
                                                                            .$loker["location_name"].'
                                                                        </option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            
                                            ?>
                                            <div class="form-group">
                                                <label for="txtPICHeader" class="control-label col-lg-4">PIC</label>
                                                <div class="col-lg-4">
                                                  <select id="slc_pic_kendaraan" name="pic_kendaraan" class="form-control">
                                                  </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtSeksiPemakaiHeader" class="control-label col-lg-4">Seksi Pemakai</label>
                                                <div class="col-lg-4">
                                                    <select id="slc_seksi_pemakai" name="txtSeksiPemakaiHeader" class="form-control">
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="txtNomorPolisiHeader" class="control-label col-lg-4">Nomor Rangka</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Nomor Rangka (contoh : NHKP3CA1JFK089113)" name="txtNomorRangkaHeader" id="txtNomorRangkaHeader" class="form-control" maxlength="30" />
                                                </div>
                                            </div>

                                             <div class="form-group">
                                                <label for="txtTagNumber" class="control-label col-lg-4">Tag Number</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Tag Number" name="TagNumber" id="TagNumber" class="form-control" >
                                                </div>
                                            </div>


											<div class="form-group">
                                                <label for="txtFotoStnkHeader" class="control-label col-lg-4">Foto STNK</label>
                                                <div class="col-lg-4">
                                                    <input type="file" placeholder="Foto STNK" name="FotoSTNK" data-max-size='500' id="FotoSTNK" class="form-control" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtFotoBpkbHeader" class="control-label col-lg-4">Foto BPKB</label>
                                                <div class="col-lg-4">
                                                    <input type="file" placeholder="Foto BPKB" name="FotoBPKB" data-max-size='500' id="FotoBPKB" class="form-control" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtFotoKendaraanHeader" class="control-label col-lg-4">Foto Kendaraan</label>
                                                <div class="col-lg-4">
                                                    <input type="file" placeholder="Foto Kendaraan" data-max-size='500' name="FotoKendaraan" id="FotoKendaraan" class="form-control" />
                                                </div>
                                            </div>

                                            <!-- <div class="form-group">
                                                <label class="control-label col-lg-4">Usable</label>
                                                <div class="col-lg-4" style="padding-top: 6px;">
                                                    <label><input type="radio" name="usable" id="usable" class="form-control" value="1" /> Ya</label>
                                                    <label style="margin-left: 30px;"><input type="radio" name="usable" id="usable" class="form-control" value="0" /> Tidak</label>
                                                </div>
                                            </div> -->

                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Kepemilikan Kendaraan</label>
                                                <div class="col-lg-4" style="padding-top: 6px;">
                                                    <label ><input type="radio" name="kepemilikan_kendaraan" id="kepemilikan_kendaraan" class="form-control" value="1" /> Perusahaan</label>
                                                    <label style="margin-left: 30px;"><input type="radio" name="kepemilikan_kendaraan" id="kepemilikan_kendaraan" class="form-control" value="0" /> Rental</label>
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