<body class="hold-transition login-page">
  <section class="content">
    <div class="panel-group">
      <div class="panel panel-primary">
          <div class="panel-heading text-center"><b>LAPORAN KASUS KECELAKAAN KERJA</b></div>
        <div class="panel-body">
          <form name="frm_inputKecelakaan" method="post" action="<?php echo base_url('MasterPekerja/KecelakaanKerja/inputTahap1'); ?>">
            <h3 class="text-primary text-center">TAHAP I</h3>
               
                
            <div class="panel-group">
              <div class="panel panel-primary"> 
                <div class="panel-heading">
                  
                </div>
                <div class="panel-body">
                  <div class="row">
                      <div class="col-lg-3">
                        <div class="form-group has-feedback">
                          <label class="control-label" for="cmbNoindukPekerja">Pilih Pekerja</label>
                          <select class="form-control " name="cmbNoindukPekerja" id="KecelakaanKerja-cmbNoindukPekerja" required="">
                          </select>
                       </div> 
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group has-feedback">
                          <label class="control-label" for="cmbCabangPerusahaan">Pilih Cabang</label>
                          <select class="form-control " name="cmbCabangPerusahaan" id="KecelakaanKerja-cmbCabangPerusahaan" required="">
                          </select>
                       </div> 
                      </div>
                    </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="control-label">Upah tenaga kerja yang diterima :</label>
                        <select class="form-control" name="slc_upahDiterima" required="">
                          <option value="1">Perhari</option>
                          <option value="2">Perbulan</option>
                          <option value="3">Pertahun</option>
                        </select>
                      </div>                                
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="control-label">Jumlah upah yang diterima :</label>
                        <input class="form-control" type="number" name="it_jumlahUpah" required="" placeholder="Masukkan nominal dalam angka">
                      </div>                            
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group"> 
                        <label class="control-label">Tempat kejadian kecelakaan :</label>
                        <select class="form-control" name="it_tempatKecelakaan" id="kk_it_tempatKecelakaan" onchange="getalamat(this)" required="">
                          <option selected="selected" disabled="disabled"></option>
                          <option value="1">Di dalam lokasi kerja</option>
                          <option value="2">Di luar lokasi kerja</option>
                          <option value="3">Lalu lintas</option>
                        </select>
                      </div>                
                    </div>
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label class="control-label">Tanggal Kecelakaan :</label>
                          <input type="text" name="KecelakaanKerja-daterangepickersingledatewithtime" class=" form-control KecelakaanKerja-daterangepickersingledatewithtime" required="">
                        </div>
                      </div>
                  </div>
                  <div class="row">                    
                    <div class="col-lg-6">
                      <div class="form-group"> 
                        <label class="control-label">Alamat lokasi kejadian kecelakaan :</label>
                        <input class="form-control" type="text" name="it_alamatKecelakaan" id="kk_it_alamatKecelakaan" required="">
                      </div>                
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                          <label class="control-label" for="it_alamatDesaKecelakaan">Desa :</label>
                          <input class="form-control" type="text" name="it_alamatDesaKecelakaan" id="it_alamatDesaKecelakaan" required="">
                        </div>               
                      </div> 
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label class="control-label" for="it_alamatKecamatanKecelakaan">Kecamatan :</label>
                          <input class="form-control" type="text" name="it_alamatKecamatanKecelakaan" id="it_alamatKecamatanKecelakaan" required="">
                        </div>               
                      </div>
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label class="control-label" for="it_alamatKotaKecelakaan">Kota :</label>
                          <input class="form-control" type="text" name="it_alamatKotaKecelakaan" id="it_alamatKotaKecelakaan" required="">
                        </div>               
                      </div>                    
                  </div>

                   <?php 
                      $arrayname = array(
                                    '1' => 'Tindakan Bahaya Penyebab Kecelakaan',
                                    '2' => 'Kondisi yang menimbulkan bahaya da menjadi pencetus terjadinya bahaya',
                                    '3' => 'Corak Kecelakaan yang terjadi',
                                    '4' => 'Sumber penyebab cedera',
                                    ); ?>
                      <?php
                        $i =1; 
                        foreach($kk_kecelakaan_detail as $row)
                        { 
                      ?>
                          <div class="row" style="margin-left: 2%">
                            <b><?php echo $arrayname[$i]; ?></b>                              
                          </div>
                          <div class="row">
                          <?php
                            $indeks   = 1;
                            $jumlah_kecelakaan_detail   = count($row);
                            foreach ($row as $key => $value)
                            { 
                          ?>
                          <?php
                              if ( $indeks % 4 == 1 )
                              {
                          ?>
                            <div class="col-lg-4">
                            <?php
                              }
                            ?>
                              <div class="checkbox">
                                  <label class="control-label">
                                    <input type="checkbox" value="<?php echo $value['id_kecelakaan_detail'] ?>" 
                                    name="desc<?= $i; ?>[]"> <?php echo $value['desc'] ?></input>
                                  </label>
                              </div>    
                            <?php
                                if ( $indeks % 4 == 0 OR $indeks == $jumlah_kecelakaan_detail )
                                {
                            ?>
                            </div>
                            <?php
                                }
                            ?>
                            <?php
                                $indeks++;
                              } 
                            ?>
                          </div>
                      <?php
                          $i++;
                        }
                      ?> 
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label class="control-label">Uraian Kejadian Kecelakaan :</label>
                            <br>
                            <label for="bagaimanaTerjadiKecelakaan" class="control-label">- Bagaimana terjadinya kecelakaan</label>
                            <textarea style="size: fixed; width: 1026px; height: 144px;" class="form-control" id="bagaimanaTerjadiKecelakaan" rows="5" name="bagaimanaTerjadiKecelakaan" required=""></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label for="sebutkanBagianMesin" class="control-label">- Sebutkan bagian mesin, instalasi bahan atau lingkungan yang menyebabkan cidera <h6><small>*)tidak perlu diisi bagi peserta bukan penerima upah</small></h6></label>
                            <textarea style="size: fixed; width: 1026px; height: 144px;" class="form-control" id="sebutkanBagianMesin" rows="5" name="sebutkanBagianMesin" required=""></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-10">
                          <div class="form-group">
                            <label class="control-label">Akibat yang diderita korban :</label><br>
                              <label class="radio-inline"><input type="radio" name="rd_akibat" value="Meninggal">Meninggal</label>
                              <label class="radio-inline"><input type="radio" name="rd_akibat" value="Cedera/Luka">Cedera/Luka</label><br>
                            <label for="it_bagianTubuhLuka" class="control-label">- Sebutkan bagian tubuh yang luka :</label>
                            <input class="form-control" type="text" name="it_bagianTubuhLuka" id="it_bagianTubuhLuka" required="">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-10">
                          <div class="form-group">
                            <label class="control-label">Fasilitas Kesehatan(faskes) yang memberikan pertolongan pertama :</label><br>
                            <label for="it_namafaskes" class="control-label">- Nama Faskes :</label>
                            <input class="form-control" type="text" name="it_namafaskes" id="it_namafaskes" required="">
                            <label class="control-label">- Jenis Faskes :</label><br>
                            <label class="radio-inline"><input type="radio" name="rd_jenisFaskes" value="Rumah Sakit Trauma Center">Rumah Sakit Trauma Center</label>
                            <label class="radio-inline"><input type="radio" name="rd_jenisFaskes" value="Klinik Trauma Center">Klinik Trauma Center</label>
                            <label class="radio-inline"><input type="radio" name="rd_jenisFaskes" value="Bukan Jejaring TC">Bukan Jejaring TC</label>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label for="it_alamatFaskes" class="control-label">- Alamat Faskes :</label>
                            <input class="form-control" type="text" name="it_alamatFaskes" id="it_alamatFaskes" required="">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                              <label class="control-label">Keadaan Penderita Setelah Pemeriksaan Pertama :</label><br>
                              <label class="radio-inline"><input type="radio" name="rd_keadaan" value="Rawat Jalan">Rawat Jalan</label>
                              <label class="radio-inline"><input type="radio" name="rd_keadaan" value="Rawat Inap">Rawat Inap</label>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label for="txtarea_keteranganLain" class="control-label">Keterangan Lainnya Jika Perlu :</label>
                            <textarea style="size: fixed; width: 1026px; height: 144px;" class="form-control" name="txtarea_keteranganLain" id="txtarea_keteranganLain" rows="5"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>            
                  </div>                         
            </div>
            <div class="btn-group pull-right">
                <button type="submit" class="btn btn-primary">Submit Di sini</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </section>
 </body>