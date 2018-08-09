<body class="hold-transition login-page">
  <section class="content">
    <div class="panel-group">
      <div class="panel panel-primary">
          <div class="panel-heading text-center"><b>LAPORAN KASUS KECELAKAAN KERJA</b></div>
        <div class="panel-body">
          <form name="frm_inputKecelakaan" method="post" action="<?php echo base_url('MasterPekerja/KecelakaanKerja/updateTahap1'.'/'.$data1[0]['id_lkk_1']); ?>">
            <h3 class="text-primary text-center">TAHAP I</h3>
               
                
            <div class="panel-group">
              <div class="panel panel-primary"> 
                <div class="panel-heading">
                  
                </div>
                <div class="panel-body">
                  <div class="row">
                      <div class="col-lg-3">
                        <div class="form-group has-feedback">
                          <label class="control-label" >Pilih Pekerja</label>
                          <input type="text" name="kk-it_pekerja" value="<?php echo $data1[0]['noind'] ?>" class="form-control" readonly="">
                       </div> 
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group has-feedback">
                          <label class="control-label" for="cmbCabangPerusahaan">Pilih Cabang</label>
                          <input type="text" name="itCabangPerusahaan" id="KecelakaanKerja-itCabangPerusahaan" class="form-control" value="<?php echo $data1[0]['kode_mitra'] ?>" readonly="">
                       </div> 
                      </div>
                    </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="control-label">Upah tenaga kerja yang diterima :</label>
                        <select class="form-control" name="slc_upahDiterima">
                          <?php
                          if ($data1[0]['upah_status'] == 1) {
                            ?>
                              <option value="1" selected="selected">Perhari</option>
                              <option value="2">Perbulan</option>
                              <option value="3">Pertahun</option>                            
                            <?php
                           } 
                           if ($data1[0]['upah_status'] == 2) {
                            ?>
                              <option value="1">Perhari</option>
                              <option value="2" selected="selected">Perbulan</option>
                              <option value="3">Pertahun</option>                            
                            <?php
                           } 
                           if ($data1[0]['upah_status'] == 3) {
                            ?>
                              <option value="1">Perhari</option>
                              <option value="2">Perbulan</option>
                              <option value="3" selected="selected">Pertahun</option>                            
                            <?php
                           } 
                          ?>
                        </select>
                      </div>                                
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="control-label">Jumlah upah yang diterima :</label>
                        <input class="form-control" type="text" name="it_jumlahUpah" value="<?php echo $data1[0]['upah_nominal'] ?>">
                      </div>                            
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group"> 
                        <label class="control-label">Tempat kejadian kecelakaan :</label>
                        <select class="form-control" name="it_tempatKecelakaan" id="kk_it_tempatKecelakaan2" onchange="getalamatview(this)">
                          <?php
                          if ($data1[0]['lokasi_kk'] == 1) {
                            ?>
                            <option value="1" selected="selected">Di dalam lokasi kerja</option>
                            <option value="2">Di luar lokasi kerja</option>
                            <option value="3">Lalu lintas</option>
                            <?php
                          }
                          ?>
                          <?php
                          if ($data1[0]['lokasi_kk'] == 2) {
                            ?>
                            <option value="1">Di dalam lokasi kerja</option>
                            <option value="2" selected="selected">Di luar lokasi kerja</option>
                            <option value="3">Lalu lintas</option>
                            <?php
                          }
                          if ($data1[0]['lokasi_kk'] == 3) {
                            ?>
                            <option value="1">Di dalam lokasi kerja</option>
                            <option value="2">Di luar lokasi kerja</option>
                            <option value="3" selected="selected">Lalu lintas</option>
                            <?php
                          }
                          ?>
                        </select>
                      </div>                
                    </div>
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label class="control-label">Tanggal Kecelakaan :</label>
                          <input type="text" name="KecelakaanKerja-daterangepickersingledatewithtime" class=" form-control KecelakaanKerja-daterangepickersingledatewithtime" value="<?php echo $data1[0]['tgl_kk'] ?>">
                        </div>
                      </div>
                  </div>
                  <div class="row">                    
                    <div class="col-lg-6">
                      <div class="form-group"> 
                        <label class="control-label">Alamat lokasi kejadian kecelakaan :</label>
                        <input class="form-control" type="text" name="it_alamatKecelakaan" id="kk_it_alamatKecelakaan" value="<?php echo $data1[0]['alamat_kk'] ?>">
                      </div>                
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                          <label class="control-label" for="it_alamatDesaKecelakaan">Desa :</label>
                          <input class="form-control" type="text" name="it_alamatDesaKecelakaan" id="it_alamatDesaKecelakaan" value="<?php echo $data1[0]['desa'] ?>">
                        </div>               
                      </div> 
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label class="control-label" for="it_alamatKecamatanKecelakaan">Kecamatan :</label>
                          <input class="form-control" type="text" name="it_alamatKecamatanKecelakaan" id="it_alamatKecamatanKecelakaan" value="<?php echo $data1[0]['kecamatan'] ?>">
                        </div>               
                      </div>
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label class="control-label" for="it_alamatKotaKecelakaan">Kota :</label>
                          <input class="form-control" type="text" name="it_alamatKotaKecelakaan" id="it_alamatKotaKecelakaan" value="<?php echo $data1[0]['kokab'] ?>">
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
                              foreach ($kec as $key => $val) {
                                $kece[] = $val['id_kecelakaan_detail'];
                              }
                            ?>
                              <div class="checkbox">
                                  <label class="control-label">
                                    <input <?= (in_array($value['id_kecelakaan_detail'],$kece)) ? 'checked' : '' ?> type="checkbox" value="<?php echo $value['id_kecelakaan_detail'] ?>" 
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
                            <textarea style="size: fixed; width: 1026px; height: 144px;" class="form-control" id="bagaimanaTerjadiKecelakaan" rows="5" name="bagaimanaTerjadiKecelakaan"><?php echo $data1[0]['kejadian']; ?></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label for="sebutkanBagianMesin" class="control-label">- Sebutkan bagian mesin, instalasi bahan atau lingkungan yang menyebabkan cidera <h6><small>*)tidak perlu diisi bagi peserta bukan penerima upah</small></h6></label>
                            <textarea style="size: fixed; width: 1026px; height: 144px;" class="form-control" id="sebutkanBagianMesin" rows="5" name="sebutkanBagianMesin"><?php echo $data1[0]['penyebab']; ?></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-10">
                          <div class="form-group">
                            <label class="control-label">Akibat yang diderita korban :</label><br>
                            <?php
                            if ($data1[0]['akibat_diderita'] == "Meninggal") {
                              ?>
                                <label class="radio-inline"><input type="radio" name="rd_akibat" value="Meninggal" checked="checked">Meninggal</label>
                                <label class="radio-inline"><input type="radio" name="rd_akibat" value="Cedera/Luka">Cedera/Luka</label>
                              <?php
                            }
                            if ($data1[0]['akibat_diderita'] == "Cedera/Luka") {
                              ?>
                                <label class="radio-inline"><input type="radio" name="rd_akibat" value="Meninggal">Meninggal</label>
                                <label class="radio-inline"><input type="radio" name="rd_akibat" value="Cedera/Luka" checked="checked">Cedera/Luka</label>
                              <?php
                            }
                            ?>
                              <br>
                            <label for="it_bagianTubuhLuka" class="control-label">- Sebutkan bagian tubuh yang luka :</label>
                            <input class="form-control" type="text" name="it_bagianTubuhLuka" id="it_bagianTubuhLuka" value="<?php echo $data1[0]['akibat_detail'] ?>">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-10">
                          <div class="form-group">
                            <label class="control-label">Fasilitas Kesehatan(faskes) yang memberikan pertolongan pertama :</label><br>
                            <label for="it_namafaskes" class="control-label">- Nama Faskes :</label>
                            <input class="form-control" type="text" name="it_namafaskes" id="it_namafaskes" value="<?php echo $faskes[0]['nama'] ?>">
                            <label class="control-label">- Jenis Faskes :</label><br>
                            <?php
                            if ($faskes[0]['jenis_faskes'] == "Rumah Sakit Trauma Center") {
                              ?>
                                <label class="radio-inline"><input type="radio" name="rd_jenisFaskes" value="Rumah Sakit Trauma Center" checked="checked">Rumah Sakit Trauma Center</label>
                                <label class="radio-inline"><input type="radio" name="rd_jenisFaskes" value="Klinik Trauma Center">Klinik Trauma Center</label>
                                <label class="radio-inline"><input type="radio" name="rd_jenisFaskes" value="Bukan Jejaring TC">Bukan Jejaring TC</label>                              
                              <?php
                            }
                            if ($faskes[0]['jenis_faskes'] == "Klinik Trauma Center") {
                              ?>
                                <label class="radio-inline"><input type="radio" name="rd_jenisFaskes" value="Rumah Sakit Trauma Center">Rumah Sakit Trauma Center</label>
                                <label class="radio-inline"><input type="radio" name="rd_jenisFaskes" value="Klinik Trauma Center" checked="checked">Klinik Trauma Center</label>
                                <label class="radio-inline"><input type="radio" name="rd_jenisFaskes" value="Bukan Jejaring TC">Bukan Jejaring TC</label>                              
                              <?php
                            }
                            if ($faskes[0]['jenis_faskes'] == "Bukan Jejaring TC") {
                              ?>
                                <label class="radio-inline"><input type="radio" name="rd_jenisFaskes" value="Rumah Sakit Trauma Center">Rumah Sakit Trauma Center</label>
                                <label class="radio-inline"><input type="radio" name="rd_jenisFaskes" value="Klinik Trauma Center">Klinik Trauma Center</label>
                                <label class="radio-inline"><input type="radio" name="rd_jenisFaskes" value="Bukan Jejaring TC"  checked="checked">Bukan Jejaring TC</label>                              
                              <?php
                            }
                            ?>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label for="it_alamatFaskes" class="control-label">- Alamat Faskes :</label>
                            <input class="form-control" type="text" name="it_alamatFaskes" id="it_alamatFaskes" value="<?php echo $faskes[0]['alamat'] ?>">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                              <label class="control-label">Keadaan Penderita Setelah Pemeriksaan Pertama :</label><br>
                              <?php
                              if ($data1[0]['keadaan_penderita'] == "Rawat Jalan") {
                                ?>
                                  <label class="radio-inline"><input type="radio" name="rd_keadaan" value="Rawat Jalan" checked="checked">Rawat Jalan</label>
                                  <label class="radio-inline"><input type="radio" name="rd_keadaan" value="Rawat Inap">Rawat Inap</label>                                
                                <?php
                              }
                              if ($data1[0]['keadaan_penderita'] == "Rawat Inap") {
                                ?>
                                  <label class="radio-inline"><input type="radio" name="rd_keadaan" value="Rawat Jalan">Rawat Jalan</label>
                                  <label class="radio-inline"><input type="radio" name="rd_keadaan" value="Rawat Inap" checked="checked">Rawat Inap</label>                                
                                <?php
                              }
                              ?>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label for="txtarea_keteranganLain" class="control-label">Keterangan Lainnya Jika Perlu :</label>
                            <textarea style="size: fixed; width: 1026px; height: 144px;" class="form-control" name="txtarea_keteranganLain" id="txtarea_keteranganLain" rows="5"><?php echo $data1[0]['keterangan_lain']; ?></textarea>
                          </div>
                        </div>
                      </div>
                    </div>            
                  </div>                         
            </div>
            <div class="btn-group pull-right">
                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </section>
 </body>