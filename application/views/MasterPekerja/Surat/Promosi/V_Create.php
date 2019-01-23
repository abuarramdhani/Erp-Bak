<section class="content">
    <div class="inner" >
        <div class="row">
            <form id="MasterPekerja-SuratPromosi-FormCreate" method="post" action="<?php echo site_url('MasterPekerja/Surat/SuratPromosi/add');?>" class="form-horizontal" >
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja/Surat/SuratPromosi/');?>">
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
                                <div class="box-header with-border">Create Surat Promosi</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="cmbNoind" class="col-lg-4 control-label">Nomor Induk</label>
                                                    <div class="col-lg-8">
                                                        <select class="select2 MasterPekerja-Surat-DaftarPekerja ganti" name="txtNoind" id="" style="width: 100%">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="txtStatusStaf" class="col-lg-4 control-label">Staf/Nonstaf</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="txtStatusStaf" class="form-control MasterPekerja-txtStatusStaf statuz" id="" readonly="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="txtKodesieLama" class="col-lg-4 control-label">Seksi Asal</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="txtKodesieLama" class="form-control MasterPekerja-txtKodesieLama" id="" readonly="">
                                                    </div>
                                                </div>  
                                                <div class="form-group">
                                                    <label for="txtGolonganPekerjaanLama" class="col-lg-4 control-label">Gol. Kerja</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="txtGolonganPekerjaanLama" class="form-control MasterPekerja-txtGolonganKerjaLama" id="" readonly="">
                                                    </div>
                                                </div>   
                                                <div class="form-group">
                                                    <label for="txtPekerjaanLama" class="col-lg-4 control-label">Pekerjaan</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="txtPekerjaanLama" class="form-control MasterPekerja-txtPekerjaanLama" id="" readonly="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="txtKdJabatanLama" class="col-lg-4 control-label">Kd Jabatan</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="txtKdJabatanLama" class="form-control MasterPekerja-txtKdJabatanLama" id="" readonly="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="txtJabatanLama" class="col-lg-4 control-label">Jabatan</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="txtJabatanLama" class="form-control MasterPekerja-txtJabatanLama" id="" readonly="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="txtLokasiKerjaLama" class="col-lg-4 control-label">Lokasi Kerja</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="txtLokasiKerja" class="form-control MasterPekerja-txtLokasiKerjaLama" id="" readonly="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="txtTempatMakan1" class="col-lg-4 control-label">Tempat Makan 1</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="txtTempatMakan1" class="form-control MasterPekerja-txtTempatMakan1" id="" readonly="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="txtTempatMakan2" class="col-lg-4 control-label">Tempat Makan 2</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="txtTempatMakan2" class="form-control MasterPekerja-txtTempatMakan2" id="" readonly="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="txtKodesieBaru" class="col-lg-4 control-label">Promosi Ke</label>
                                                    <div class="col-lg-8">
                                                        <select name="txtKodesieBaru" class="mpk-kdbaru select2 MasterPekerja-SuratMutasi-DaftarSeksi" id="" style="width: 100%">
                                                            <option value=""></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="txtGolonganPekerjaanBaru" class="col-lg-4 control-label">Gol.Kerja</label>
                                                    <div class="col-lg-8">
                                                        <select name="txtGolonganPekerjaanBaru" class="form-control select2 MasterPekerja-SuratMutasi-DaftarGolongan" id="">
                                                            <option value=""></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="txtPekerjaanBaru" class="col-lg-4 control-label">Pekerjaan</label>
                                                    <div class="col-lg-8">
                                                        <select name="txtPekerjaanBaru" class="form-control select2 MasterPekerja-SuratMutasi-DaftarPekerjaan" id="">
                                                            <option value=""></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="txtKdJabatanBaru" class="col-lg-4 control-label">Kd Jabatan Baru</label>
                                                    <div class="col-lg-8">
                                                        <select name="txtKdJabatanBaru" class="form-control jabatan select2">
                                                            <option value=""></option>
                                                            <?php
                                                            foreach ($DaftarKdJabatan as $kdjabatan) 
                                                            {
                                                               ?>
                                                               <!--  <option value="<?php echo $kdjabatan['kd_jabatan'];?>"><?php echo $kdjabatan['jabatan'];?></option> -->
                                                               <option value="<?php echo $kdjabatan['kd_jabatan'];?>">
                                                                 <?php echo $kdjabatan['kd_jabatan'].' - '.$kdjabatan['jabatan'];?>
                                                             </option>
                                                             <?php
                                                         }
                                                         ?>
                                                     </select>
                                                 </div>
                                             </div>
                                             <div class="form-group">
                                                <label for="txtJabatanBaru" class="col-lg-4 control-label">Jabatan Baru</label>
                                                <div class="col-lg-8">
                                                    <input readonly class="form-control toupper setjabatan" type="text" name="txtJabatanBaru">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtLokasiKerjaBaru" class="col-lg-4 control-label">Lokasi Kerja</label>
                                                <div class="col-lg-8">
                                                    <select name="txtLokasiKerjaBaru" class="form-control select2" >
                                                        <option value=""></option>
                                                        <?php
                                                        foreach ($DaftarLokasiKerja as $lokasikerja) 
                                                        {
                                                           ?>
                                                           <option value="<?php echo $lokasikerja['lokasi'];?>"><?php echo $lokasikerja['lokasi'];?></option>
                                                           <?php
                                                       }
                                                       ?>
                                                   </select>
                                               </div>
                                           </div>
                                           <div class="form-group">
                                            <label for="txtTempatMakan1Baru" class="col-lg-4 control-label">Tempat Makan 1</label>
                                            <div class="col-lg-8">
                                                <select name="txtTempatMakan1Baru" class="form-control select2 MasterPekerja-DaftarTempatMakan" >
                                                    <option value=""></option>
                                                    <?php
                                                    foreach ($DaftarTempatMakan1 as $tempatmakan1) 
                                                    {
                                                       ?>
                                                       <option value="<?php echo $tempatmakan1['tempat_makan1'];?>"><?php echo $tempatmakan1['tempat_makan1'];?></option>
                                                       <?php
                                                   }
                                                   ?>
                                               </select>
                                           </div>
                                       </div>
                                       <div class="form-group">
                                        <label for="txtTempatMakan2Baru" class="col-lg-4 control-label">Tempat Makan 2</label>
                                        <div class="col-lg-8">
                                            <select name="txtTempatMakan2Baru" class="form-control select2 MasterPekerja-DaftarTempatMakan" >
                                                <option value=""></option>
                                                <?php
                                                foreach ($DaftarTempatMakan2 as $tempatmakan2) 
                                                {
                                                   ?>
                                                   <option value="<?php echo $tempatmakan2['tempat_makan2'];?>"><?php echo $tempatmakan2['tempat_makan2'];?></option>
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
                                        <input type="text" name="txtTanggalCetak" class="form-control MasterPekerja-daterangepickersingledate">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="txtTanggalBerlaku" class="col-lg-4 control-label">Tanggal Berlaku</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="txtTanggalBerlaku" class="form-control MasterPekerja-daterangepickersingledate">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 pull-right cobaHide">
                                <div class="form-group">
                                <label for="txtTanggalBerlaku" class="col-lg-4 control-label">Tanggal Periode</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="txtTanggalPeriode" class="form-control MasterPekerja-daterangepicker periode" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="col-lg-2 text-right">
                                        <a id="MasterPekerja-SuratPromosi-btnPreview" title="Preview" class="btn btn-info">Preview</a>
                                    </div>
                                    <div class="col-lg-10">
                                        <textarea class="ckeditor MasterPekerja-SuratPromosi-txaPreview" name="txaPreview" id=""></textarea>
                                    </div>
                                </div>  
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="txtNomorSurat" class="control-label col-lg-4">Nomor Surat</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" readonly="" name="txtNomorSurat" id="MasterPekerja-SuratPromosi-txtNomorSurat">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="txtKodeSurat" class="control-label col-lg-4">Kode Surat</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" readonly="" name="txtKodeSurat" id="MasterPekerja-SuratPromosi-txtKodeSurat">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="txtNomorSurat" class="control-label col-lg-4">Hal Surat</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" style="text-transform: uppercase;" name="txtHalSurat" value="" id="MasterPekerja-SuratPromosi-txtHalSurat">
                                    </div>
                                </div>
                            </div>
                        </div>
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
<script type="text/javascript">
    $(document).ajaxStop(function () {
        $('.periode').attr('disabled', true);
        var tex = $('.statuz').val().length;
        if (tex == 4) {
            $('.periode').attr('disabled', false);
            $('.cobaHide').attr('hidden', false);
        }else{
            $('.periode').attr('disabled', true);
            $('.cobaHide').attr('hidden', true);
        }
    });
</script>