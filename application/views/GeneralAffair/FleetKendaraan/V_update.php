<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('GeneralAffair/FleetKendaraan/update/'.$id);?>" class="form-horizontal" enctype="multipart/form-data">
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
                                <div class="box-header with-border">Update Kendaraan</div>
                                <?php
                                    foreach ($FleetKendaraan as $kendaraanEdit):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="txtNomorPolisiHeader" class="control-label col-lg-4">Nomor Polisi</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Nomor Polisi (contoh: AB1234CD)" name="txtNomorPolisiHeader" id="txtNomorPolisiHeader" class="form-control" value="<?php echo $kendaraanEdit['nomor_polisi']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="cmbJenisKendaraanIdHeader" class="control-label col-lg-4">Jenis Kendaraan</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbJenisKendaraanIdHeader" name="cmbJenisKendaraanIdHeader" class="select2" data-placeholder="Pilih" style="width: 75%">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($FleetJenisKendaraan as $row) {
                                                                if ($kendaraanEdit['kode_jenis_kendaraan'] == $row['kode_jenis_kendaraan']) {
                                                                    $selected_data = "selected";
                                                                } else {
                                                                    $selected_data = "";   
                                                                }
                                                                echo '<option value="'.$row['kode_jenis_kendaraan'].'" '.$selected_data.'>'.$row['jenis_kendaraan'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="cmbMerkKendaraanIdHeader" class="control-label col-lg-4">Merk Kendaraan</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbMerkKendaraanIdHeader" name="cmbMerkKendaraanIdHeader" class="select2" data-placeholder="Pilih" style="width: 75%">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($FleetMerkKendaraan as $row) {
                                                                if ($kendaraanEdit['kode_merk_kendaraan'] == $row['kode_merk_kendaraan']) {
                                                                    $selected_data = "selected";
                                                                } else {
                                                                    $selected_data = "";   
                                                                }
                                                                echo '<option value="'.$row['kode_merk_kendaraan'].'" '.$selected_data.'>'.$row['merk_kendaraan'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="cmbWarnaKendaraanIdHeader" class="control-label col-lg-4">Warna Kendaraan</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbWarnaKendaraanIdHeader" name="cmbWarnaKendaraanIdHeader" class="select2" data-placeholder="Pilih" style="width: 75%">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($FleetWarnaKendaraan as $row) {
                                                                if ($kendaraanEdit['kode_warna_kendaraan'] == $row['kode_warna_kendaraan']) {
                                                                    $selected_data = "selected";
                                                                } else {
                                                                    $selected_data = "";   
                                                                }
                                                                echo '<option value="'.$row['kode_warna_kendaraan'].'" '.$selected_data.'>'.$row['warna_kendaraan'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTahunPembuatanHeader" class="control-label col-lg-4">Tahun Pembuatan</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbTahunPembuatan" name="cmbTahunPembuatan" class="select2" data-placeholder="Pilih" style="width: 50%">
                                                        <option value=""></option>
                                                        <?php
                                                        for ($tahun=date('Y'); $tahun > 1900; $tahun--) 
                                                        {
                                                        $terpilih;
                                                            if($tahun==$kendaraanEdit['tahun_pembuatan'])
                                                            {
                                                                $terpilih = "selected";
                                                            }
                                                            else
                                                            {
                                                                $terpilih = "";
                                                            }
                                                        echo '  <option value="'.$tahun.'" '.$terpilih.'>
                                                                        '.$tahun.'
                                                                </option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtFotoStnkHeader" class="control-label col-lg-4">Foto STNK</label>
                                                <div class="col-lg-4">
                                                    <input type="file" name="FotoSTNK" id="FotoSTNK" class="form-control" placeholder="Edit File" />
                                                    <a target="_blank" href="<?php echo base_url('assets/upload/GA/Kendaraan/'.$kendaraanEdit['foto_stnk']);?>"><?php echo $kendaraanEdit['foto_stnk'];?></a>
                                                    <input type="text" name="FotoSTNKawal" id="FotoSTNKawal" hidden="" value="<?php echo $kendaraanEdit['foto_stnk'];?>">

                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtFotoBpkbHeader" class="control-label col-lg-4">Foto BPKB</label>
                                                <div class="col-lg-4">
                                                    <input type="file" name="FotoBPKB" id="FotoBPKB" class="form-control" placeholder="Edit File" />
                                                    <a target="_blank" href="<?php echo base_url('assets/upload/GA/Kendaraan/'.$kendaraanEdit['foto_bpkb']);?>"><?php echo $kendaraanEdit['foto_bpkb'];?></a>
                                                    <input type="text" name="FotoBPKBawal" id="FotoBPKBawal" hidden="" value="<?php echo $kendaraanEdit['foto_bpkb'];?>">
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtFotoKendaraanHeader" class="control-label col-lg-4">Foto Kendaraan</label>
                                                <div class="col-lg-4">
                                                    <input type="file" name="FotoKendaraan" id="FotoKendaraan" class="form-control" placeholder="Edit File" />
                                                    <a target="_blank" href="<?php echo base_url('assets/upload/GA/Kendaraan/'.$kendaraanEdit['foto_kendaraan']);?>"><?php echo $kendaraanEdit['foto_kendaraan'];?></a>
                                                    <input type="text" name="FotoKendaraanawal" id="FotoKendaraanawal" hidden="" value="<?php echo $kendaraanEdit['foto_kendaraan'];?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtTanggalDibuat" class="control-label col-lg-4">Tanggal Dibuat</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Tanggal Dibuat" name="TanggalDibuat" id="TanggalDibuat" class="form-control" value="<?php echo $kendaraanEdit['waktu_dibuat'];?>" disabled>
                                                    <input type="text" name="WaktuDihapus" id="WaktuDihapus" hidden="" value="<?php echo $kendaraanEdit['waktu_dihapus'];?>">
                                                </div>
                                            </div>
                                            <?php
                                                if(substr($kodesie, 0, 5)=='10103')
                                                    {
                                            ?>
                                            <div class="form-group">
                                                <label for="txtTanggalNonaktif" class="control-label col-lg-4">Aktif</label>
                                                <div class="col-lg-4">
                                                    <input type="checkbox" name="CheckAktif" id="CheckAktif" <?php if($kendaraanEdit['waktu_dihapus']=='12-12-9999 00:00:00'){echo 'checked';};?>>
                                                    
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