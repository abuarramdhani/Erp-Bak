<body class="hold-transition login-page">
  <section class="content">
    <div class="panel-group">
      <div class="panel panel-primary">
          <div class="panel-heading text-center"><b>LAPORAN KASUS KECELAKAAN KERJA</b></div>
        <div class="panel-body">
          <form name="frm_inputKecelakaan" method="post" action="<?php echo base_url('MasterPekerja/KecelakaanKerja/inputDataTahap2'); ?>">
            <h3 class="text-primary text-center">TAHAP II</h3>
               
                
            <div class="panel-group"> 
              <div class="panel panel-primary"> 
                <div class="panel-heading">
                  
                </div>
                <div class="panel-body">
                  <div class="row">
                      <div class="col-lg-3">
                        <div class="form-group has-feedback">
                          <label>No Induk Pekerja :</label> 
                            <input class="form-control" type="text" name="txt_noindPekerja" value="<?php echo $data[0]['noind'] ?>" readonly="">
                        </div> 
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group has-feedback">
                          <label>Kode Mitra Perusahaan :</label>
                            <input class="form-control" type="text" name="txt_kodemitraPerusahaan" value="<?php echo $data[0]['kode_mitra'] ?>"  readonly="">
                        </div> 
                      </div>
                      <div class="col-lg-3"> 
                        <div class="form-group">
                          <label class="control-label" for="KecelakaanKerja-txt_tgl_kecelakaan">Tanggal Kecelakaan :</label>
                            <input type="text" name="txt_tgl_kecelakaan" class="form-control" id="KecelakaanKerja-txt_tgl_kecelakaan" value="<?php echo $data[0]['tgl_kk']; ?>" readonly="">
                        </div>
                      </div>
                      <div class="col-lg-3"> 
                        <div class="form-group">
                            <input type="text" name="txt_id_lkk1" value="<?php echo $id['lkk_1']; ?>" hidden="hidden">
                        </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                        <label class="control-label">Laporan kasus kecelakaan kerja Tahap I telah disampaikan kepada BPJS Ketenagakerjaan dan Kantor Dinas Tenaga Kerja :</label>
                        <div>
                          <div class="form-group">
                            <label class="radio-inline"><input type="radio" name="rd_disampaikan" value="Belum disampaikan">Belum disampaikan</label>
                            <label class="radio-inline"><input type="radio" name="rd_disampaikan" value="Sudah disampaikan">Sudah disampaikan pada </label>
                            <input type="text" name="txt_tgl_kirim_tahap1" class="KecelakaanKerja-daterangepickersingledatewithtime" id="txt_tgl_kirim_tahap1"> 
                          </div>
                        </div>  
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <label class="control-label">Pengajuan Pembiayaan oleh :</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                          <label class="radio-inline"><input type="radio" name="rd_pengajuan" value="Perusahaan">Perusahaan</label>
                          <label class="radio-inline"><input type="radio" name="rd_pengajuan" value="Peserta">Peserta</label>
                          <label class="radio-inline"><input type="radio" name="rd_pengajuan" value="Faskes Trauma Center">Faskes Trauma Center</label>
                           <label class="radio-inline"><input type="radio" name="rd_pengajuan" value="Ahli Waris">Ahli Waris</label>
                      </div>
                    </div>
                  </div>
                  <?php
                  $b = 0;
                  foreach ($biaya as $key) {
                  
                  ?>
                  <div class="row">
                    <div class="col-lg-3">
                      <label class="radio-inline"><?php echo $biaya[$b]['keterangan']; ?></label>
                    </div>
                    <div class="col-lg-3">
                      <input type="text" name="txt_biaya<?= $b ?>" placeholder="Rp ..." class="form-control">
                    </div>
                  </div>
                  <?php
                  $b++;
                   } 
                  ?>

                  <!-- <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="radio-inline">a) biaya pengangkutan</label>
                      </div>
                    </div>
                    <div class="col-lg-1">
                      <label class="radio-inline">: Rp</label>
                    </div>
                    <div class="col-lg-3">
                      <input type="text" name="txt_pengangkutan" class="form-control">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="radio-inline">b) biaya pengobatan dan perawatan</label>
                      </div>
                    </div>
                    <div class="col-lg-1">
                      <label class="radio-inline">: Rp</label>
                    </div>
                    <div class="col-lg-3">
                      <input type="text" name="txt_pengobatan" class="form-control">
                    </div>
                  </div> 
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="radio-inline">c) biaya Rehabilitasi</label>
                      </div>
                    </div>
                    <div class="col-lg-1">
                      <label class="radio-inline">: Rp</label>
                    </div>
                    <div class="col-lg-3">
                      <input type="text" name="txt_rehabilitasi" class="form-control">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="radio-inline">d) biaya prothesa/orthesa</label>
                      </div>
                    </div>
                    <div class="col-lg-1">
                      <label class="radio-inline">: Rp</label>
                    </div>
                    <div class="col-lg-3">
                      <input type="text" name="txt_proor" class="form-control">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="radio-inline">e) biaya Pemakaman</label>
                      </div>
                    </div>
                    <div class="col-lg-1">
                      <label class="radio-inline">: Rp</label>
                    </div>
                    <div class="col-lg-3">
                      <input type="text" name="txt_pemakaman" class="form-control">
                    </div>
                  </div> -->
                  <div class="row">
                    <div class="col-lg-12">
                      <label>Penerima manfaat pembiayaan :</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="radio-inline"><input type="radio" name="rd_penerima" value="Perusahaan"> Perusahaan</label>
                        <label class="radio-inline"><input type="radio" name="rd_penerima" value="Peserta"> Peserta</label>
                        <label class="radio-inline"><input type="radio" name="rd_penerima" value="Faskes Trauma Center"> Faskes Trauma Center</label>
                        <label class="radio-inline"><input type="radio" name="rd_penerima" value="Ahli Waris"> Ahli Waris</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <label>Pengajuan Santunan Sementara Tidak Mampu Bekerja(STMB) :</label>
                    </div>
                  </div>
                  <?php
                  for ($c=1; $c < 3; $c++) { 
                    
                  ?>
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label>Periode Awal</label>
                        <input type="text" name="txt_periode_awal<?= $c ?>" class="KecelakaanKerja-daterangepickersingledate form-control">
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label>Periode Berakhir</label>
                        <input type="text" name="txt_periode_akhir<?= $c ?>" class="KecelakaanKerja-daterangepickersingledate form-control">
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label>Jumlah besarnya STMB</label>
                        <input type="text" name="txt_jml_stmb<?= $c ?>" class="form-control" placeholder="Rp ...">
                      </div>
                    </div>
                  </div>
                  <?php
                   } 


                  ?>
                  <!-- <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label for="KK_txt_periode_a">a) Periode</label>
                        <input type="text" name="txt_periode_a" id="KK_txt_periode_a" class="KecelakaanKerja-daterangepicker form-control">
                      </div>                      
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label for="KK_txt_jml_stmb_a">Jumlah besarnya STMB </label>
                        <input type="text" name="txt_jml_stmb_a" id="KK_txt_jml_stmb_a" class="form-control" placeholder="Rp ....">
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label for="KK_txt_periode_b">b) Periode</label>
                        <input type="text" name="txt_periode_b" id="KK_txt_periode_b" class="KecelakaanKerja-daterangepicker form-control">
                      </div>                      
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label for="KK_txt_jml_stmb_b">Jumlah besarnya STMB </label>
                        <input type="text" name="txt_jml_stmb_b" id="KK_txt_jml_stmb_b" class="form-control" placeholder="Rp ....">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label for="KK_txt_periode_c">c) Periode</label>
                        <input type="text" name="txt_periode_c" id="KK_txt_periode_c" class="KecelakaanKerja-daterangepicker form-control">
                      </div>                      
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label for="KK_txt_jml_stmb_c">Jumlah besarnya STMB </label>
                        <input type="text" name="txt_jml_stmb_c" id="KK_txt_jml_stmb_c" class="form-control" placeholder="Rp ....">
                      </div>
                    </div> -->
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label>Uraian keterangan dokter tentang kondisi fisik/mental peserta pasca kecelakaan kerja</label>
                        <label class="radio-inline"><input type="radio" name="rd_terlampir" value="Terlampir">Terlampir</label>
                        <label class="radio-inline"><input type="radio" name="rd_terlampir" value="Tidak Terlampir">Tidak Terlampir</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                          <label>Berdasarkan Surat Keterangan dokter bentuk KK4 atau KK5 ditetapkan terlampir :</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="col-lg-5">
                        <label class="radio-inline">Pada tanggal </label>
                      </div>
                      <div class="col-lg-7">
                        <input type="text" name="txt_tgl_kk4" class="form-control KecelakaanKerja-daterangepickersingledate">
                      </div>
                    </div>                    
                    <div class="col-lg-2">
                      <label class="radio-inline">peserta ditetapkan </label>
                    </div>
                  </div>
                  <div class="row">
                    <?php
                    $i = 1;
                    $indeks = 1;
                    foreach ($kk4 as $row) {
                    
                    if ( $indeks % 4 == 1 ) {
                    ?>
                    <div class="col-lg-6">
                    <?php
                    }
                    ?>
                      <div class="checkbox">
                        <label class="control-label">
                        <input type="checkbox" value="<?php echo $row['id_ket_kk4'] ?>" name="ket[]; ?>"> <?php echo $row['keterangan'] ?></input>
                        </label>
                      </div>
                    <?php
                    if ($indeks % 4 == 0) {
                     
                    ?>
                    </div>
                    <?php
                    } 
                    ?>
                    <?php
                    $indeks++;
                    $i++;
                     } 
                    ?>
                  </div>
                </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label>Besarnya pembiayaan dan santunan yang telah diberikan kepada peserta atau ahli waris pasca kecelakaan kerja :</label>
                        <div class="col-lg-6">
                          <input type="text" name="txt_santunan" class="form-control" placeholder="Rp ....." required="">
                        </div>                      
                      </div>                      
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-lg-6">
                      <label>Penerima manfaat santunan (ahli waris) :</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <label class="radio-inline">Nama Peserta</label>
                    </div>
                    <div class="col-lg-1">
                      <label class="radio-inline">:</label>
                    </div>
                    <div class="col-lg-6">
                      <input type="text" name="txt_pnama" class="form-control">
                    </div>
                  </div> 
                  <div class="row">
                    <div class="col-lg-3">
                      <label class="radio-inline">Nomor Identitas Kependudukan</label>
                    </div>
                    <div class="col-lg-1">
                      <label class="radio-inline">:</label>
                    </div>
                    <div class="col-lg-4">
                      <input type="text" name="txt_pnik" class="form-control">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <label class="radio-inline">Hubungan ahli waris dengan peserta</label>
                    </div>
                    <div class="col-lg-1">
                      <label class="radio-inline">:</label>
                    </div>
                    <div class="col-lg-8">
                      <div class="row">
                        <div class="col-lg-12">
                          <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Janda/Duda"> Janda/duda</label>
                          <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Anak"> Anak</label>
                          <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Ayah/Ibu"> Ayah/Ibu</label>
                          <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Kakek/Nenek"> Kakek/Nenek</label>
                        </div>                      
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Saudara Kandung"> Saudara Kandung</label>
                          <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Cucu"> Cucu</label>
                          <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Mertua"> Mertua</label>
                          <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Pihak yang ditunjuk dalam wasiat"> Pihak yang ditunjuk dalam wasiat</label>
                        </div>
                      </div>                      
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <label class="radio-inline">Alamat/ no telp</label>
                    </div>
                    <div class="col-lg-1">
                      <label class="radio-inline">:</label>
                    </div>
                    <div class="col-lg-8">
                      <input type="text" name="txt_palamat" class="form-control">
                      <div class="row">
                        <div class="col-lg-4">
                          <input type="text" name="txt_pdesa" placeholder="Desa/Kel" class="form-control">
                        </div>
                        <div class="col-lg-4">
                          <input type="text" name="txt_pkec" placeholder="Kecamatan" class="form-control">
                        </div>
                        <div class="col-lg-4">
                          <input type="text" name="txt_pkab" placeholder="Kabupaten/Kota" class="form-control">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-4">
                          <input type="text" name="txt_pkodepos" placeholder="Kode Pos" class="form-control">
                        </div>
                        <div class="col-lg-5">
                          <input type="text" name="txt_pnotelp" placeholder="No Telp/hp" class="form-control">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <label class="radio-inline">Nomor Rekening</label>
                    </div>
                    <div class="col-lg-1">
                      <label class="radio-inline">:</label>
                    </div>
                    <div class="col-lg-6">
                      <input type="text" name="txt_prekening" class="form-control">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <label class="radio-inline">Nama Bank</label>
                    </div>
                    <div class="col-lg-1">
                      <label class="radio-inline">:</label>
                    </div>
                    <div class="col-lg-8">
                      <input type="text" name="txt_pnamabank" class="form-control">
                    </div>
                  </div>
                  <br>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label class="control-label">Keterangan Lainnya jika perlu :</label>
                      <textarea name="txtarea_keteranganlain" class="form-control" style="width: 1026px; height: 100px;"></textarea>
                    </div>                     
                  </div>
                </div>                          
              </div>                                        
            </div>
            <br>
            <div class="btn-group pull-right">
                <button type="submit" class="btn btn-primary">Submit Di sini</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </section>
 </body>