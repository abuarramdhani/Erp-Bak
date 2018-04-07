<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('GeneralAffair/FleetPicKendaraan/update/'.$id);?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/FleetPicKendaraan/');?>">
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
                                <div class="box-header with-border">Update PIC Kendaraan</div>
                                <?php
                                    foreach ($FleetPicKendaraan as $headerRow):
                                        $status_dropdown_seksi      = 'disabled';
                                        $status_dropdown_pekerja    = 'disabled' ;
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="cmbKendaraanIdHeader" class="control-label col-lg-4">Kendaraan</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbKendaraanIdHeader" name="cmbKendaraanIdHeader" class="select2" data-placeholder="Choose an option" style="width: 75%">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($FleetKendaraan as $row) 
                                                            {
                                                                 if ($headerRow['kode_kendaraan'] == $row['kode_kendaraan']) {
                                                                    $selected_data = "selected";
                                                                } else {
                                                                    $selected_data = "";   
                                                                }
                                                                echo '<option value="'.$row['kode_kendaraan'].'" '.$selected_data.'>'.$row['nomor_polisi'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cmbPekerjaHeader" class="control-label col-lg-4">PIC</label>
                                                    <div class="col-lg-2">
                                                        <input type="radio" name="OpsiPIC" value="Seksi" required="" <?php if($headerRow['pilihan']=='seksi'){echo 'checked';$status_dropdown_seksi = '';};?>/>
                                                        <label for="OpsiSeksi" class="control-label">Seksi</label>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <select id="cmbSeksi" name="cmbSeksi" class="select2" data-placeholder="Pilih Seksi" style="width: 75%" required="" <?php echo $status_dropdown_seksi;?> >
                                                            <option value="" selected></option>
                                                            <?php
                                                             foreach ($DaftarSeksi as $row) 
                                                             {
                                                                $status_data_seksi = '';
                                                                if($row['kode_seksi']==$headerRow['kode'])
                                                                {
                                                                    $status_data_seksi     = 'selected';
                                                                }

                                                                    echo '<option value="'.$row['kode_seksi'].'" '.$status_data_seksi.'>'.$row['nama_seksi'].'</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="cmbPekerjaHeader" class="control-label col-lg-4"><span class="hidden">PIC</span></label>
                                                    <div class="col-lg-2">
                                                        <input type="radio" name="OpsiPIC" value="Pekerja" required="" <?php if($headerRow['pilihan']=='pekerja'){echo 'checked';$status_dropdown_pekerja='';};?>/>
                                                        <label for="OpsiSeksi" class="control-label" >Pekerja</label>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <select id="cmbPekerja" name="cmbPekerja" class="select2" data-placeholder="Pilih Pekerja" style="width: 75%" required="" <?php echo $status_dropdown_pekerja;?> >
                                                            <option value=""></option>
                                                            <?php
                                                             foreach ($DaftarNama as $row) {
                                                                $status_data_pekerja = '';
                                                                if($row['id_pekerja']==$headerRow['kode'])
                                                                {
                                                                    $status_data_pekerja     = 'selected';
                                                                }                                                                
                                                                    echo '<option value="'.$row['id_pekerja'].'" '.$status_data_pekerja.'>'.$row['daftar'].'</option>';
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                            </div>


                                            <div class="form-group hidden">
                                                <label for="txtMasaAktifPICHeader" class="control-label col-lg-4">Masa Penggunaan</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="masaAktifPIC" class="date form-control" id="ManajemenKendaraan-daterangepicker" value="<?php echo $headerRow['periode'];?>" required="" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtStartDateHeader" class="control-label col-lg-4">Waktu Dibuat</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo $headerRow['waktu_dibuat'];?>" name="txtStartDateHeader" value="<?php echo $headerRow['waktu_dibuat'] ?>" class="date form-control" data-date-format="dd-mm-yyyy H:i:s" id="txtStartDateHeader" disabled=""/>
                                                    <input type="text" name="WaktuDihapus" id="WaktuDihapus" hidden="" value="<?php echo $headerRow['waktu_dihapus'];?>">
                                                </div>
                                            </div>
                                            <?php if(substr($kodesie, 0, 5)=='10103'): ?>
                                            <div class="form-group">
                                                <label for="txtTanggalNonaktif" class="control-label col-lg-4">Aktif</label>
                                                <div class="col-lg-4">
                                                    <input type="checkbox" name="CheckAktif" id="CheckAktif" <?php if($headerRow['waktu_dihapus']=='12-12-9999 00:00:00'){echo 'checked';};?>>
                                                    
                                                </div>

                                            </div>
                                            <?php else: ?>                                            
                                                <input type="checkbox" name="CheckAktifUser" id="CheckAktif" <?php if($headerRow['waktu_dihapus']=='12-12-9999 00:00:00'){echo 'checked';};?> hidden="">
                                            <?php endif; ?>
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