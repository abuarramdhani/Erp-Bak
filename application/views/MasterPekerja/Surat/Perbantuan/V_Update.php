<section class="content">
    <div class="inner" >
        <div class="row">
            <form id="MasterPekerja-SuratPerbantuan-FormCreate" method="post" action="<?php echo site_url('MasterPekerja/Surat/SuratPerbantuan/edit/'.$id);?>" class="form-horizontal" >
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja/Surat/SuratPerbantuan/');?>">
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
                                <div class="box-header with-border">Update Surat Perbantuan</div>
                                    <div class="box-body">
                                        <div class="panel-body">
                                            <div class="row">
                                            </div>
                                            <?php
                                                foreach ($editSuratPerbantuan as $edit) 
                                                {
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="cmbNoind" class="col-lg-4 control-label">Nomor Induk</label>
                                                        <div class="col-lg-8">
                                                             <select  class="select2 golker" name="txtNoind" id="MasterPekerja-Surat-UpdatePekerja" style="width: 100%" readonly>
                                                                <option value="<?php echo $edit['noind']?>" selected="true" >
                                                                    <?php echo $edit['noind'].' - '.$edit['nama'] ;?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                   <!--  <div class="form-group">
                                                        <label for="cmbNoind" class="col-lg-4 control-label">Nomor Induk</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control" name="txtNoind" readonly="" id="MasterPekerja-SuratPerbantuan-DaftarPekerja" value="<?php echo $edit['noind'];?>">    
                                                        </div>
                                                    </div>  -->
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="txtStatusStaf" class="col-lg-4 control-label">Staf/Nonstaf</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtStatusStaf" class="form-control MasterPekerja-txtStatusStaf" readonly="" value="<?php echo $edit['status_staf'];?>">
                                                            <input hidden type="text" name="txtStatusEdit" value="1">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="txtKodesieLama" class="col-lg-4 control-label">Seksi Asal</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtKodesieLama" class="form-control MasterPekerja-txtKodesieLama" readonly="" value="<?php echo $edit['seksi_lama'];?>">
                                                        </div>
                                                    </div>  
                                                    <div class="form-group">
                                                        <label for="txtGolonganPekerjaanLama" class="col-lg-4 control-label">Gol. Kerja</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtGolonganPekerjaanLama" class="form-control MasterPekerja-txtGolonganKerjaLama" readonly="" value="<?php echo $edit['golkerja_lama'];?>">
                                                        </div>
                                                    </div>   
                                                    <div class="form-group">
                                                        <label for="txtPekerjaanLama" class="col-lg-4 control-label">Pekerjaan</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtPekerjaanLama" class="form-control MasterPekerja-txtPekerjaanLama" readonly="" value="<?php echo $edit['kd_pkj_lama'].' - '.$edit['pekerjaan_lama'];?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="txtKdJabatanLama" class="col-lg-4 control-label">Kd Jabatan</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtKdJabatanLama" class="form-control MasterPekerja-txtKdJabatanLama" readonly=""value="<?php echo $edit['kd_jabatan_lama'];?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="txtJabatanLama" class="col-lg-4 control-label">Jabatan</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtJabatanLama" class="form-control MasterPekerja-txtJabatanLama" readonly="" value="<?php echo $edit['jabatan_lama'];?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="txtLokasiKerjaLama" class="col-lg-4 control-label">Lokasi Kerja</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtLokasiKerja" class="form-control MasterPekerja-txtLokasiKerjaLama" readonly="" value="<?php echo $edit['lokasi_lama'];?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="txtTempatMakan1" class="col-lg-4 control-label">Tempat Makan 1</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtTempatMakan1" class="form-control MasterPekerja-txtTempatMakan1" readonly="" value="<?php echo $edit['tempat_makan_1_lama'];?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="txtTempatMakan2" class="col-lg-4 control-label">Tempat Makan 2</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtTempatMakan2" class="form-control MasterPekerja-txtTempatMakan2" readonly="" value="<?php echo $edit['tempat_makan_2_lama'];?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                         <label for="txtStatusJabatanlama" class="col-lg-4 control-label">Status Jabatan Lama</label>
                                                         <div class="col-lg-8">
                                                             <input type="text" name="txtStatusJabatanlama" class="form-control" id="MasterPekerja-txtStatusJabatanlama" readonly="" value="<?php echo $edit['nama_status_lama'];?>">
                                                         </div>
                                                     </div>
                                                     <div class="form-group">
                                                         <label for="txtNamaJabatanUpahlama" class="col-lg-4 control-label">Nama Jabatan Upah Lama</label>
                                                         <div class="col-lg-8">
                                                             <input type="text" name="txtNamaJabatanUpahlama" class="form-control" id="MasterPekerja-txtNamaJabatanUpahlama" readonly="" value="<?php echo $edit['nama_jabatan_upah_lama'];?>">
                                                         </div>
                                                     </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="txtKodesieBaru" class="col-lg-4 control-label">Perbantuan Ke</label>
                                                        <div class="col-lg-8">
                                                            <select name="txtKodesieBaru" class="mpk-kdbaru select2 MasterPekerja-SuratMutasi-DaftarSeksi" style="width: 100%">
                                                                <option value="<?php echo $edit['kodesie_baru']?>" selected="true">
                                                                    <?php echo $edit['seksi_baru']?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="txtGolonganPekerjaanBaru" class="col-lg-4 control-label">Gol.Kerja</label>
                                                        <div class="col-lg-8">
                                                            <select name="txtGolonganPekerjaanBaru" class="form-control select2 MasterPekerja-SuratMutasi-DaftarGolongan" id="">
                                                                <option value="<?php echo $edit['golkerja_baru']?>" selected="">
                                                                    <?php echo $edit['golkerja_baru']?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="txtPekerjaanBaru" class="col-lg-4 control-label">Pekerjaan</label>
                                                        <div class="col-lg-8">
                                                            <select name="txtPekerjaanBaru" class="form-control select2 MasterPekerja-SuratMutasi-DaftarPekerjaan" id="">
                                                                <option value="<?php echo $edit['kd_pkj_baru']?>" selected>
                                                                    <?php echo $edit['kd_pkj_baru'].' - '.$edit['pekerjaan_baru']?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                     <div class="form-group">
                                                        <label for="txtKdJabatanBaru" class="col-lg-4 control-label">Kd Jabatan Baru</label>
                                                        <div class="col-lg-8">
                                                            <select name="txtKdJabatanBaru" class="form-control jabatan select2">
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
                                                            <input readonly class="form-control toupper setjabatan" type="text" name="txtJabatanBaru" value="<?php echo $edit['jabatan_baru'];?>">
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
                                                   <!--  <div class="form-group">
                                                         <label for="txtStatusjabatanBaru" class="col-lg-4 control-label">Status Jabatan Baru</label>
                                                         <div class="col-lg-8">
                                                             <select name="txtStatusjabatanBaru" class="form-control select2" id="MasterPekerja-txtStatusjabatanBaru">
                                                                 <option value="<?php echo $edit['nama_status_baru'];?>" selected><?php echo $edit['nama_status_baru'];?></option>
                                                             </select>
                                                         </div>
                                                     </div> -->
                                                     <!-- <div class="form-group">
                                                         <label for="txtNamaJabatanUpahBaru" class="col-lg-4 control-label">Nama Jabatan Upah Baru</label>
                                                         <div class="col-lg-8">
                                                             <select name="txtNamaJabatanUpahBaru" class="form-control select2" id="MasterPekerja-txtNamaJabatanUpahBaru">
                                                                 <option value="<?php echo $edit['nama_jabatan_upah_baru'];?>">
                                                                 <?php echo $edit['nama_jabatan_upah_baru'];?>
                                                                 </option>
                                                             </select>
                                                         </div>
                                                     </div> -->
                                                    <!-- <div class="form-group">
                                                        <label for="txtTempatMakan1Baru" class="col-lg-4 control-label">Tempat Makan 1</label>
                                                        <div class="col-lg-8">
                                                            <select name="txtTempatMakan1Baru" class="form-control select2 MasterPekerja-DaftarTempatMakan" >
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
                                                    </div> -->
                                                    <!-- <div class="form-group">
                                                        <label for="txtTempatMakan2Baru" class="col-lg-4 control-label">Tempat Makan 2</label>
                                                        <div class="col-lg-8">
                                                            <select name="txtTempatMakan2Baru" class="form-control select2 MasterPekerja-DaftarTempatMakan" >
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
                                                    </div> -->
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="txtTanggalCetak" class="col-lg-4 control-label">Tanggal Cetak</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtTanggalCetak" class="form-control MasterPekerja-daterangepickersingledate" value="<?php echo $edit['tanggal_cetak'];?>">
                                                            <input hidden type="text" name="txtTanggalCetakAsli" class="" value="<?php echo $edit['tanggal_cetak'];?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="txtTanggalBerlaku" class="col-lg-4 control-label">Tanggal Berlaku</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtTanggalBerlaku" class="form-control MasterPekerja-daterangepicker" value="<?php echo $edit['tanggal_mulai_perbantuan'].' - '.$edit['tanggal_selesai_perbantuan'];?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <input style="display: none" type="text" name="txtFingerParameter" class="form-control" value="<?php echo $editFinger[0]['finger_pindah'];?>">
                                                 <?php if ($editFinger[0]['finger_pindah'] == 'tidakada') { ?>
                                                 <div  class="col-lg-12">
                                                    <div class="col-md-6 control-label">
                                                        <div class="form-group">
                                                            <label style="margin-top: 0px;" class="col-lg-4 col-form-label" for="name">Pindah Finger</label>
                                                            <div class="col-md-2 text-left">
                                                                <input style="width: 1.2em;" type="radio" class="form-control finger" name="finger_pindah" id="fingerYa" value="t"> Ya
                                                            </div>
                                                             <div class="col-md-3 text-left">
                                                                <input style="width: 1.2em;" type="radio" class="form-control finger" name="finger_pindah" id="fingerTidak" value="f" checked=""> Tidak
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12" id="fingerpindah" hidden>
                                                    <div class="form-group">
                                                        <p for="txtFingerdari" class="col-lg-2 control-label">Dari</p>
                                                        <div class="col-lg-4">
                                                            <input type="text" class="form-control" name="txtFingerAwal" id="MasterPekerja-Surat-FingerAwal" readonly="">
                                                        </div>
                                                         <p for="txtFingerKe" class="col-lg-2 control-label">Ke</p>
                                                        <div class="col-lg-4">
                                                           <select class="select2" name="txtFingerGanti" id="MasterPekerja-Surat-FingerGanti" style="width: 100%">
                                                                <option></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php }elseif ($editFinger[0]['finger_pindah'] == 't') { ?>
                                                 <div  class="col-lg-12">
                                                    <div class="col-md-6 control-label">
                                                        <div class="form-group">
                                                            <label style="margin-top: 0px;" class="col-lg-4 col-form-label" for="name">Pindah Finger</label>
                                                            <div class="col-md-2 text-left">
                                                                <input style="width: 1.2em;" type="radio" class="form-control finger" name="finger_pindah" id="fingerYa" value="t" checked=""> Ya
                                                            </div>
                                                             <div class="col-md-3 text-left">
                                                                <input style="width: 1.2em;" type="radio" class="form-control finger" name="finger_pindah" id="fingerTidak" value="f"> Tidak
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12" id="fingerpindah">
                                                    <div class="form-group">
                                                        <p for="txtFingerdari" class="col-lg-2 control-label">Dari</p>
                                                        <div class="col-lg-4">
                                                        <input type="text" class="form-control" name="txtFingerAwal" value="<?php echo $editFinger[0]['finger_awal'].' - '.$editFinger[0]['lokasifinger_awal']; ?>" readonly="">
                                                        </div>
                                                         <p for="txtFingerKe" class="col-lg-2 control-label">Ke</p>
                                                        <div class="col-lg-4">
                                                           <select class="select2" name="txtFingerGanti" id="MasterPekerja-Surat-FingerGanti" style="width: 100%">
                                                                <option selected value="<?php echo $editFinger[0]['finger_akhir'].' - '.$editFinger[0]['lokasifinger_akhir']; ?>"><?php echo $editFinger[0]['finger_akhir'].' - '.$editFinger[0]['lokasifinger_akhir']; ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php }elseif ($editFinger[0]['finger_pindah'] == 'f') { ?>
                                                <div  class="col-lg-12">
                                                    <div class="col-md-6 control-label">
                                                        <div class="form-group">
                                                            <label style="margin-top: 0px;" class="col-lg-4 col-form-label" for="name">Pindah Finger</label>
                                                            <div class="col-md-2 text-left">
                                                                <input style="width: 1.2em;" type="radio" class="form-control finger" name="finger_pindah" id="fingerYa" value="t"> Ya
                                                            </div>
                                                             <div class="col-md-3 text-left">
                                                                <input style="width: 1.2em;" type="radio" class="form-control finger" name="finger_pindah" id="fingerTidak" value="f" checked=""> Tidak
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12" id="fingerpindah" hidden>
                                                    <div class="form-group">
                                                        <p for="txtFingerdari" class="col-lg-2 control-label">Dari</p>
                                                        <div class="col-lg-4">
                                                        <input type="text" class="form-control" name="txtFingerAwal" value="<?php echo $editFinger[0]['finger_awal'].' - '.$editFinger[0]['lokasifinger_awal']; ?>" readonly="">
                                                        </div>
                                                         <p for="txtFingerKe" class="col-lg-2 control-label">Ke</p>
                                                        <div class="col-lg-4">
                                                           <select class="select2" name="txtFingerGanti" id="MasterPekerja-Surat-FingerGanti" style="width: 100%">
                                                                <option></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <div class="col-lg-2 text-right">
                                                            <a title="Preview" class="btn btn-info MasterPekerja-SuratPerbantuan-btnPreview">Preview</a>
                                                        </div>
                                                        <div class="col-lg-10">
                                                            <textarea class="ckeditor" name="txaPreview" id="MasterPekerja-SuratPerbantuan-txaPreview">
                                                                <?php echo $edit['isi_surat'];?>
                                                            </textarea>
                                                        </div>
                                                    </div>  
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="txtNomorSurat" class="control-label col-lg-4">Nomor Surat</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control" readonly="" name="txtNomorSurat" id="MasterPekerja-SuratPerbantuan-txtNomorSurat" value="<?php echo $edit['no_surat'];?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="txtKodeSurat" class="control-label col-lg-4">Kode Surat</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control" readonly="" name="txtKodeSurat" id="MasterPekerja-SuratPerbantuan-txtKodeSurat" value="<?php echo $edit['kode'];?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="txtNomorSurat" class="control-label col-lg-4">Hal Surat</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control" style="text-transform: uppercase;" name="txtHalSurat" id="MasterPekerja-SuratPerbantuan-txtHalSurat" value="<?php echo $edit['hal_surat'];?>">
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
<div id="surat-loading" hidden style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="<?php echo site_url('assets/img/gif/loadingtwo.gif');?>" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<script>
    $(document).ready(function(){
        var noind = $('#MasterPekerja-Surat-UpdatePekerja').val();
        // alert(a);
        $.ajax({
            type: 'POST',
            data: { noind: noind },
            url: baseurl + "MasterPekerja/Surat/detail_pekerja",
            success: function(result) {
                var result = JSON.parse(result);
                $('#MasterPekerja-Surat-FingerAwal').val(result['id_lokasifinger'] + ' - ' + result['lokasi_finger']);
            }
        });
    });
</script>