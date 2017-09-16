<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('GeneralAffair/FleetPicKendaraan/create');?>" class="form-horizontal">
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
                                <div class="box-header with-border">Create PIC Kendaraan</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="cmbKendaraanIdHeader" class="control-label col-lg-4">Kendaraan</label>
                                                <div class="col-lg-8">
                                                    <select id="cmbKendaraanIdHeader" name="cmbKendaraanIdHeader" class="select2" data-placeholder="Pilih" style="width: 75%" required="">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($FleetKendaraan as $row) {
                                                                echo '<option value="'.$row['kode_kendaraan'].'" >'.$row['nomor_polisi'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cmbPekerjaHeader" class="control-label col-lg-4">PIC</label>
                                                    <div class="col-lg-2">
                                                            <input type="radio" name="OpsiPIC" value="Seksi" required="" />
                                                            <label for="OpsiSeksi" class="control-label" >Seksi</label>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <select id="cmbSeksi" name="cmbSeksi" class="select2" data-placeholder="Pilih Seksi" style="width: 75%" required="" disabled="true">
                                                            <option value=""></option>
                                                            <?php
                                                             foreach ($DaftarSeksi as $row) {
                                                                    echo '<option value="'.$row['kode_seksi'].'" >'.$row['nama_seksi'].'</option>';
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                            </div>
											<div class="form-group">
                                                <label for="cmbPekerjaHeader" class="control-label col-lg-4"><span class="hidden">PIC</span></label>
                                                    <div class="col-lg-2">
                                                        <input type="radio" name="OpsiPIC" value="Pekerja" required="" />
                                                        <label for="OpsiSeksi" class="control-label">Pekerja</label>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <select id="cmbPekerja" name="cmbPekerja" class="select2" data-placeholder="Pilih Pekerja" style="width: 75%" required="" disabled="true">
                                                            <option value=""></option>
                                                            <?php
                                                             foreach ($DaftarNama as $row) {
                                                                    echo '<option value="'.$row['id_pekerja'].'" >'.$row['daftar'].'</option>';
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                            </div>



											<div class="form-group hidden">
                                                <label for="txtMasaAktifPICHeader" class="control-label col-lg-4">Masa Penggunaan</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="masaAktifPIC" class="date form-control" id="daterangepicker" />
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