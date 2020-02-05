<section class="content">
    <div class="inner" >
        <div class="row">
            <form id="MasterPekerja-SuratUsiaLanjut-FormCreate" method="post" action="<?php echo site_url('MasterPekerja/Surat/SuratUsiaLanjut/add');?>" class="form-horizontal" >
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja/Surat/SuratUsiaLanjut/');?>">
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
                                <div class="box-header with-border">Create Surat Pemberitahuan Usia Lanjut</div>
                                    <div class="box-body">
                                        <div class="panel-body">
                                        <?php 

                                                $bithdayDate = substr($PekerjaUsiaLanjut[0]['tgllahir'], 0, 10);
                                                $date = new DateTime($bithdayDate);
                                                $yearEnd = date('Y-m-d', strtotime('12/31'));
                                                $now = new DateTime($yearEnd);
                                                $interval = $now->diff($date);
                                                $age = $interval->y;    
                                                $usia = $age;
                                                        
                                                $date1 = $PekerjaUsiaLanjut[0]['tglkeluar'];
                                                $date2 =  date('Y-m-d');

                                                $diff = abs(strtotime($date2) - strtotime($date1));

                                                $years = floor($diff / (365*60*60*24));
                                                $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                                $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                                $sisawaktu =  $years.' Tahun '.$months.' Bulan ';

                                                if ($years == '0') {
                                                    $sisawaktu =  $months.' Bulan ';
                                                }elseif ($months == '0') {
                                                    $sisawaktu =  $years.' Tahun ';
                                                    if ($years == '0') {
                                                        $sisawaktu = '1'.' Bulan ';
                                                    }
                                                }
                                                // echo "<pre>"; print_r($sisawaktu); exit();
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="col-lg-4 control-label">Nama</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtnama" class="form-control" value="<?php echo $PekerjaUsiaLanjut[0]['noind'].' - '.$PekerjaUsiaLanjut[0]['nama']; ?>" readonly="">
                                                        </div>
                                                    </div>  
                                                    <div class="form-group">
                                                        <label class="col-lg-4 control-label">Kodesie</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" value="<?php echo $PekerjaUsiaLanjut[0]['kodesie']; ?>"  name="txtKodesie" class="form-control" readonly="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-4 control-label">Seksi</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" value="<?php echo $PekerjaUsiaLanjut[0]['seksi']; ?>"  name="txtSeksi" class="form-control" readonly="">
                                                        </div>
                                                    </div>  
                                                     <div class="form-group">
                                                        <label class="col-lg-4 control-label">Usia</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" value="<?php echo "$usia"." "."Tahun";?>" name="txtUsia" class="form-control" readonly="">
                                                        </div>
                                                    </div> 
                                                </div>
                                                <div class="col-lg-6">
                                                <div class="form-group">
                                                        <label class="col-lg-4 control-label">Tanggal Usia 55</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" value="<?php echo substr( $PekerjaUsiaLanjut[0]['tglkeluar'], 0, 10); ?>" name="txtTanggalUsia" class="form-control" readonly="">
                                                        </div>
                                                    </div> 
                                                     <div class="form-group">
                                                        <label class="col-lg-4 control-label">Sisa Waktu
                                                        <img src="<?php echo base_url('assets/img/kuranglebih.png') ?>" style="width: 13px; height: 13px;"/>
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="text" value="<?php echo $sisawaktu;?>" name="txtSisaKerja" class="form-control" readonly="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="cmbNoind" class="col-lg-4 control-label">Approval 1</label>
                                                        <div class="col-lg-8">
                                                            <select class="select2 MasterPekerja-Surat-DaftarPekerja" name="txtAproval1" style="width: 100%">
                                                                <option></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="cmbNoind" class="col-lg-4 control-label">Approval 2</label>
                                                        <div class="col-lg-8">
                                                            <select class="select2 MasterPekerja-Surat-DaftarPekerja" name="txtAproval2" style="width: 100%">
                                                                <option></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                </div>
                                                
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="txtNomorSurat" class="control-label col-lg-4">Nomor Surat</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control MasterPekerja-SuratUsiaLanjut-txtNomorSurat" name="txtNomorSurat" id="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="txtNomorSurat" class="control-label col-lg-4">Hal Surat</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control MasterPekerja-SuratUsiaLanjut-txtHalSurat" name="txtHalSurat" value="Pemberitahuan Usia Lanjut" id="" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="txtKodeSurat" class="control-label col-lg-4">Kode Surat</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" value="PS/KI-L" class="form-control" name="txtKodeSurat" id="MasterPekerja-Surat-txtKodeSurat">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="txtTanggalCetak" class="col-lg-4 control-label">Tanggal Cetak</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" readonly="" name="txtTanggalCetak" class="form-control MasterPekerja-daterangepickersingledate">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                                    
                                            <div class="form-group">
                                                        <div class="col-lg-2 text-right">
                                                            <a title="Preview" class="btn btn-info MasterPekerja-SuratUsiaLanjut-btnPreview">Preview</a>
                                                        </div>
                                                        <div class="col-lg-10">
                                                            <textarea class="ckeditor MasterPekerja-SuratUsiaLanjut-txaPreview" name="txaPreview"></textarea>
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