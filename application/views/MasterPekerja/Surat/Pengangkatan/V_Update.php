<section class="content">
    <div class="inner" >
        <div class="row">
            <form id="MasterPekerja-SuratPengangkatan-FormCreate" method="post" action="<?php echo site_url('MasterPekerja/Surat/SuratPengangkatan/edit/'.$id);?>" class="form-horizontal" >
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja/Surat/SuratPengangkatan/');?>">
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
                                <div class="box-header with-border">Update Surat Pengangkatan</div>
                                    <div class="box-body">
                                        <div class="panel-body">
                                            <div class="row">
                                            </div>
                                            <?php
                                                foreach ($editSuratMutasi as $edit) 
                                                {
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="cmbNoind" class="col-lg-4 control-label">Nomor Induk</label>
                                                        <div class="col-lg-8">
                                                            <select class="select2" name="txtNoind" id="MasterPekerja-SuratMutasi-DaftarPekerja" style="width: 100%" readonly>
                                                                <option value="<?php echo $edit['noind']?>" selected="true" >
                                                                    <?php echo $edit['noind'].' - '.$edit['nama'] ;?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                   <!--  <div class="form-group">
                                                        <label for="cmbNoind" class="col-lg-4 control-label">Nomor Induk</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control" name="txtNoind" readonly="" id="MasterPekerja-SuratMutasi-DaftarPekerja" value="<?php echo $edit['noind'];?>">    
                                                        </div>
                                                    </div> -->
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="txtStatusStaf" class="col-lg-4 control-label">Staf/Nonstaf</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtStatusStaf" class="form-control" id="MasterPekerja-txtStatusStaf" readonly="" value="<?php echo $edit['status_staf'];?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="txtKodesieLama" class="col-lg-4 control-label">Seksi Asal</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtKodesieLama" class="form-control" id="MasterPekerja-txtKodesieLama" readonly="" value="<?php echo $edit['seksi_lama'];?>">
                                                        </div>
                                                    </div>  
                                                    <div class="form-group">
                                                        <label for="txtGolonganPekerjaanLama" class="col-lg-4 control-label">Gol. Kerja</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtGolonganPekerjaanLama" class="form-control" id="MasterPekerja-txtGolonganKerjaLama" readonly="" value="<?php echo $edit['golkerja_lama'];?>">
                                                        </div>
                                                    </div>   
                                                    <div class="form-group">
                                                        <label for="txtPekerjaanLama" class="col-lg-4 control-label">Pekerjaan</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtPekerjaanLama" class="form-control" id="MasterPekerja-txtPekerjaanLama" readonly="" value="<?php echo $edit['pekerjaan_lama'];?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="txtKdJabatanLama" class="col-lg-4 control-label">Kd Jabatan</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtKdJabatanLama" class="form-control" id="MasterPekerja-txtKdJabatanLama" readonly=""value="<?php echo $edit['kd_jabatan_lama'];?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="txtJabatanLama" class="col-lg-4 control-label">Jabatan</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtJabatanLama" class="form-control" id="MasterPekerja-txtJabatanLama" readonly="" value="<?php echo $edit['jabatan_lama'];?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="txtLokasiKerjaLama" class="col-lg-4 control-label">Lokasi Kerja</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtLokasiKerja" class="form-control" id="MasterPekerja-txtLokasiKerjaLama" readonly="" value="<?php echo $edit['lokasi_lama'];?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="txtTempatMakan1" class="col-lg-4 control-label">Tempat Makan 1</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtTempatMakan1" class="form-control" id="MasterPekerja-txtTempatMakan1" readonly="" value="<?php echo $edit['tempat_makan_1_lama'];?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="txtTempatMakan2" class="col-lg-4 control-label">Tempat Makan 2</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtTempatMakan2" class="form-control" id="MasterPekerja-txtTempatMakan2" readonly="" value="<?php echo $edit['tempat_makan_2_lama'];?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="txtKodesieBaru" class="col-lg-4 control-label">Mutasi Ke</label>
                                                        <div class="col-lg-8">
                                                            <select name="txtKodesieBaru" class="select2" id="MasterPekerja-SuratMutasi-DaftarSeksi" style="width: 100%">
                                                                <option value="<?php echo $edit['kodesie_baru']?>" selected="true">
                                                                    <?php echo $edit['seksi_baru']?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="txtGolonganPekerjaanBaru" class="col-lg-4 control-label">Gol.Kerja</label>
                                                        <div class="col-lg-8">
                                                            <select name="txtGolonganPekerjaanBaru" class="form-control select2" id="MasterPekerja-SuratMutasi-DaftarGolongan">
                                                                <option value="<?php echo $edit['golkerja_baru']?>" selected="">
                                                                    <?php echo $edit['golkerja_baru']?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="txtPekerjaanBaru" class="col-lg-4 control-label">Pekerjaan</label>
                                                        <div class="col-lg-8">
                                                            <select name="txtPekerjaanBaru" class="form-control select2" id="MasterPekerja-SuratMutasi-DaftarPekerjaan">
                                                                <option value="<?php echo $edit['kd_pkj_baru']?>" selected>
                                                                    <?php echo $edit['kd_pkj_baru'].' - '.$edit['pekerjaan_baru']?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                     <div class="form-group">
                                                        <label for="txtKdJabatanBaru" class="col-lg-4 control-label">Kd Jabatan Baru</label>
                                                        <div class="col-lg-8">
                                                            <select name="txtKdJabatanBaru" class="form-control select2">
                                                                 <option value="<?php echo $edit['kd_jabatan_baru'];?>" selected>
                                                                     <?php echo $edit['kd_jabatan_baru'].' - '.$edit['jabatann']?>
                                                                 </option>
                                                                <?php
                                                                    foreach ($DaftarKdJabatan as $kdjabatan) 
                                                                    {
                                                                        if ($kdjabatan['kd_jabatan']!=$edit['kd_jabatan_baru']) {
                                                                ?>
                                                                     <option value="<?php echo $kdjabatan['kd_jabatan'];?>">
                                                                         <?php echo $kdjabatan['kd_jabatan'].' - '.$kdjabatan['jabatan'];?>
                                                                     </option>
                                                               <?php
                                                                        }
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="txtJabatanBaru" class="col-lg-4 control-label">Jabatan Baru</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control toupper" type="text" name="txtJabatanBaru" value="<?php echo $edit['jabatan_baru'];?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="txtLokasiKerjaBaru" class="col-lg-4 control-label">Lokasi Kerja</label>
                                                        <div class="col-lg-8">
                                                            <select name="txtLokasiKerjaBaru" class="form-control select2" >
                                                                <option value="<?php echo $edit['lokasi_baru'];?>" selected>
                                                                <?php echo $edit['lokasi_baru'];?>
                                                                </option>
                                                                <?php
                                                                    foreach ($DaftarLokasiKerja as $lokasikerja) 
                                                                    {   
                                                                        $lkb='';
                                                                        if ($lokasikerja['kode_lokasi']!=$edit['lokasi_kerja_baru']) {
                                                                        
                                                               ?>
                                                            <option value="<?php echo $lokasikerja['lokasi']?>">
                                                             <?php echo $lokasikerja['lokasi'];?>
                                                            </option>
                                                               <?php
                                                                        }
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="txtTempatMakan1Baru" class="col-lg-4 control-label">Tempat Makan 1</label>
                                                        <div class="col-lg-8">
                                                            <select name="txtTempatMakan1Baru" class="form-control select2" >
                                                                 <option value=""></option>
                                                                <?php
                                                                    foreach ($DaftarTempatMakan1 as $tempatmakan1) 
                                                                    {
                                                                         $tmsb = '';
                                                                         if($tempatmakan1['tempat_makan1']==$edit['tempat_makan_1_baru']) {
                                                                            $tmsb='selected';
                                                                         }
                                                               ?>
                                                             <option <?php echo $tmsb ?> value="<?php echo $tempatmakan1['tempat_makan1'];?>" ><?php echo $tempatmakan1['tempat_makan1']?>
                                                             </option>
                                                               <?php
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="txtTempatMakan2Baru" class="col-lg-4 control-label">Tempat Makan 2</label>
                                                        <div class="col-lg-8">
                                                            <select name="txtTempatMakan2Baru" class="form-control select2" >
                                                                 <option value=""></option>
                                                                <?php
                                                                    foreach ($DaftarTempatMakan2 as $tempatmakan2) 
                                                                    {
                                                                        $tmdb='';
                                                                        if($tempatmakan2['tempat_makan2']==$edit['tempat_makan_2_baru']) {
                                                                            $tmdb='selected';
                                                                        }
                                                               ?>
                                                             <option <?php echo $tmdb ?> value="<?php echo $tempatmakan2['tempat_makan2'];?>" ><?php echo $tempatmakan2['tempat_makan2'];?></option>
                                                               <?php
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="txtTanggalCetak" class="col-lg-4 control-label">Tanggal Cetak</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtTanggalCetak" class="form-control MasterPekerja-daterangepickersingledate" value="<?php echo $edit['tanggal_cetak'];?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="txtTanggalBerlaku" class="col-lg-4 control-label">Tanggal Berlaku</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtTanggalBerlaku" class="form-control MasterPekerja-daterangepickersingledate" value="<?php echo $edit['tanggal_berlaku'];?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <div class="col-lg-2 text-right">
                                                            <a id="MasterPekerja-SuratMutasi-btnPreview" title="Preview" class="btn btn-info">Preview</a>
                                                        </div>
                                                        <div class="col-lg-10">
                                                            <textarea class="ckeditor" name="txaPreview" id="MasterPekerja-SuratMutasi-txaPreview">
                                                                <?php echo $edit['isi_surat'];?>
                                                            </textarea>
                                                        </div>
                                                    </div>  
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="txtNomorSurat" class="control-label col-lg-4">Nomor Surat</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control" readonly="" name="txtNomorSurat" id="MasterPekerja-SuratMutasi-txtNomorSurat" value="<?php echo $edit['no_surat'];?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="txtKodeSurat" class="control-label col-lg-4">Kode Surat</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control" readonly="" name="txtKodeSurat" id="MasterPekerja-SuratMutasi-txtKodeSurat" value="<?php echo $edit['kode'];?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="txtNomorSurat" class="control-label col-lg-4">Hal Surat</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control" style="text-transform: uppercase;" name="txtHalSurat" id="MasterPekerja-SuratMutasi-txtHalSurat" value="<?php echo $edit['hal_surat'];?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="row text-right">
                                                <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
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