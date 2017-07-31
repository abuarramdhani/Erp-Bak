<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('PayrollManagementNonStaff/MasterData/DataGaji/doUpdate/'.$id);?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/MasterData/DataGaji/');?>">
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
                                <div class="box-header with-border">Update Master Gaji</div>
                                <?php
                                    foreach ($MasterGaji as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="cmbNoindHeader" class="control-label col-lg-4">Noind</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbNoindHeader" name="cmbNoindHeader" class="select cmbNoindHeader" data-placeholder="No Induk" style="width: 100%" required>
                                                        <option value="<?php echo $headerRow['noind']; ?>" selected><?php echo $headerRow['noind'].' - '.$headerRow['employee_name']; ?></option>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="cmbKodesieHeader" class="control-label col-lg-4">Kodesie</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbKodesieHeader" name="cmbKodesieHeader" class="select cmbKodesie" data-placeholder="Kodesie" style="width: 100%" required>
                                                        <option value="<?php echo $headerRow['kodesie']; ?>" selected><?php echo $headerRow['kodesie'].' - '.$headerRow['unit_name']; ?></option>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtKelasHeader" class="control-label col-lg-4">Kelas</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Kelas" name="txtKelasHeader" id="txtKelasHeader" class="form-control" value="<?php echo $headerRow['kelas']; ?>" required/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtGajiPokokHeader" class="control-label col-lg-4">Gaji Pokok</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Gaji Pokok" name="txtGajiPokokHeader" id="txtGajiPokokHeader" class="form-control" value="<?php echo $headerRow['gaji_pokok']; ?>" required/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtInsentifPrestasiHeader" class="control-label col-lg-4">Insentif Prestasi</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Insentif Prestasi" name="txtInsentifPrestasiHeader" id="txtInsentifPrestasiHeader" class="form-control" value="<?php echo $headerRow['insentif_prestasi']; ?>" required/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtInsentifMasukSoreHeader" class="control-label col-lg-4">Insentif Masuk Sore</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Insentif Masuk Sore" name="txtInsentifMasukSoreHeader" id="txtInsentifMasukSoreHeader" class="form-control" value="<?php echo $headerRow['insentif_masuk_sore']; ?>" required/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtInsentifMasukMalamHeader" class="control-label col-lg-4">Insentif Masuk Malam</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Insentif Masuk Malam" name="txtInsentifMasukMalamHeader" id="txtInsentifMasukMalamHeader" class="form-control" value="<?php echo $headerRow['insentif_masuk_malam']; ?>" required/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtUbtHeader" class="control-label col-lg-4">Ubt</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Ubt" name="txtUbtHeader" id="txtUbtHeader" class="form-control" value="<?php echo $headerRow['ubt']; ?>" required/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtUpamkHeader" class="control-label col-lg-4">Upamk</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Upamk" name="txtUpamkHeader" id="txtUpamkHeader" class="form-control" value="<?php echo $headerRow['upamk']; ?>" required/>
                                                </div>
                                            </div>

                                            
                                            <div class="form-group">
                                                <label for="txtBankCodeHeader" class="control-label col-lg-4">Bank Code</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Bank Code" name="txtBankCodeHeader" id="txtBankCodeHeader" class="form-control" value="<?php echo $headerRow['bank_code']; ?>"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtStatusPajakHeader" class="control-label col-lg-4">Status Pajak</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Status Pajak" name="txtStatusPajakHeader" id="txtStatusPajakHeader" class="form-control" value="<?php echo $headerRow['status_pajak']; ?>"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtTanggunganPajakHeader" class="control-label col-lg-4">Tanggungan Pajak</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Tanggungan Pajak" name="txtTanggunganPajakHeader" id="txtTanggunganPajakHeader" class="form-control" value="<?php echo $headerRow['tanggungan_pajak']; ?>"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtPtkpHeader" class="control-label col-lg-4">Ptkp</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Ptkp" name="txtPtkpHeader" id="txtPtkpHeader" class="form-control" value="<?php echo $headerRow['ptkp']; ?>"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtBulanKerjaHeader" class="control-label col-lg-4">Bulan Kerja</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Bulan Kerja" name="txtBulanKerjaHeader" id="txtBulanKerjaHeader" class="form-control" value="<?php echo $headerRow['bulan_kerja']; ?>"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtKpphHeader" class="control-label col-lg-4">Kpph</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Kpph" name="txtKpphHeader" id="txtKpphHeader" class="form-control" value="<?php echo $headerRow['kpph']; ?>"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtPotonganDplkHeader" class="control-label col-lg-4">Potongan Dplk</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Potongan Dplk" name="txtPotonganDplkHeader" id="txtPotonganDplkHeader" class="form-control" value="<?php echo $headerRow['potongan_dplk']; ?>"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtPotonganSpsiHeader" class="control-label col-lg-4">Potongan Spsi</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Potongan Spsi" name="txtPotonganSpsiHeader" id="txtPotonganSpsiHeader" class="form-control" value="<?php echo $headerRow['potongan_spsi']; ?>"/>
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